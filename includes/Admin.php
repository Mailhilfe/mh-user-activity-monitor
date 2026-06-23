<?php
/**
 * MH User Activity Monitor
 *
 * @package MHUAM
 * @license GPL-2.0-or-later
 */

namespace MHUAM;

if (!defined('ABSPATH')) { exit; }

final class Admin {
    private const NOTICE_DISMISS_META = 'mhuam_dismissed_notices';
    private const NOTICE_DISMISS_SECONDS = 2419200;

    private Settings $settings;
    private DB $db;

    public function __construct(Settings $settings, DB $db) { $this->settings = $settings; $this->db = $db; }

    private function has_woocommerce(): bool {
        return class_exists('\WooCommerce') || function_exists('WC');
    }

    private function require_can_view(): void {
        if (!$this->settings->can_view()) {
            wp_die(esc_html__('Keine Berechtigung.', 'mh-user-activity-monitor'), '', ['response' => 403]);
        }
    }

    private function require_can_manage(): void {
        if (!$this->settings->can_manage()) {
            wp_die(esc_html__('Keine Berechtigung.', 'mh-user-activity-monitor'), '', ['response' => 403]);
        }
    }

    private function ajax_require_can_view(): void {
        if (!$this->settings->can_view()) {
            wp_send_json_error(['message' => 'forbidden'], 403);
        }
    }

    public function init(): void {
        add_action('admin_menu', [$this, 'menu']);
        add_action('wp_dashboard_setup', [$this, 'dashboard_widget']);
        add_action('admin_bar_menu', [$this, 'admin_bar_counter'], 100);
        add_action('admin_enqueue_scripts', [$this, 'assets']);
        add_action('admin_post_mhuam_clear_sessions', [$this, 'clear_sessions_action']);
        add_action('admin_post_mhuam_export_sessions', [$this, 'export_sessions_action']);
        add_action('admin_post_mhuam_dismiss_notice', [$this, 'dismiss_notice_action']);
        add_action('wp_ajax_mhuam_admin_live', [$this, 'ajax_live']);
        add_action('admin_notices', [$this, 'security_notices']);
        add_filter('plugin_action_links_' . MHUAM_BASENAME, [$this, 'plugin_action_links']);
    }

    public function menu(): void {
        add_menu_page('MH User Activity Monitor', 'MH User Activity Monitor', 'list_users', 'mh-user-activity-monitor', [$this, 'overview_page'], 'dashicons-visibility', 58);
        add_submenu_page('mh-user-activity-monitor', __('Übersicht', 'mh-user-activity-monitor'), __('Übersicht', 'mh-user-activity-monitor'), 'list_users', 'mh-user-activity-monitor', [$this, 'overview_page']);
        add_submenu_page('mh-user-activity-monitor', __('Einstellungen', 'mh-user-activity-monitor'), __('Einstellungen', 'mh-user-activity-monitor'), 'manage_options', 'mh-user-activity-monitor-settings', [$this, 'settings_page']);
        add_submenu_page('mh-user-activity-monitor', __('Anleitung', 'mh-user-activity-monitor'), __('Anleitung', 'mh-user-activity-monitor'), 'list_users', 'mh-user-activity-monitor-help', [$this, 'help_page']);
    }

    public function assets(string $hook): void {
        if (strpos($hook, 'mh-user-activity-monitor') === false) { return; }
        wp_enqueue_style('mhuam-admin', MHUAM_URL . 'assets/admin.css', [], MHUAM_VERSION);
        wp_enqueue_script('mhuam-admin', MHUAM_URL . 'assets/admin.js', ['jquery'], MHUAM_VERSION, true);
        $s = $this->settings->get();
        wp_localize_script('mhuam-admin', 'MHUAM_ADMIN', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('mhuam_admin_live'),
            'refresh' => (int)$s['live_refresh_seconds'],
        ]);
    }

    public function plugin_action_links(array $links): array {
        $url = admin_url('admin.php?page=mh-user-activity-monitor-settings');
        array_unshift($links, '<a href="' . esc_url($url) . '">' . esc_html__('Einstellungen', 'mh-user-activity-monitor') . '</a>');
        return $links;
    }

    public function security_notices(): void {
        if (!$this->settings->can_manage()) { return; }
        $screen = function_exists('get_current_screen') ? get_current_screen() : null;
        $screen_id = $screen && !empty($screen->id) ? (string)$screen->id : '';
        if (strpos($screen_id, 'mh-user-activity-monitor') === false) { return; }

        $s = $this->settings->get();
        if (!empty($s['trust_proxy_headers']) && trim((string)$s['trusted_proxy_ips']) === '') {
            echo '<div class="notice notice-warning"><p>' . esc_html__('MH User Activity Monitor: Proxy-Header sind aktiviert, aber es wurden keine erlaubten Proxy-IP-Adressen eingetragen. In dieser Konfiguration werden Proxy-Header zwar nicht ausgewertet, die Einstellung ist aber unsicher vorbereitet. Tragen Sie die IP-Adressen Ihres Reverse Proxys oder CDN ein oder deaktivieren Sie die Option.', 'mh-user-activity-monitor') . '</p></div>';
        }

        if (!is_ssl()) {
            echo '<div class="notice notice-info"><p>' . esc_html__('MH User Activity Monitor: Die Website läuft aktuell nicht über HTTPS. Das Session-Cookie wird deshalb ohne Secure-Flag gesetzt, weil Browser es sonst auf HTTP-Seiten nicht speichern würden. Für bessere Cookie-Sicherheit wird HTTPS empfohlen.', 'mh-user-activity-monitor') . '</p></div>';
        }

        if (!wp_using_ext_object_cache()) {
            $this->render_dismissible_notice(
                'object_cache',
                __('MH User Activity Monitor: Bei vielen gleichzeitigen Sessions können mehrere Transients geschrieben werden. Für stark besuchte Websites wird ein persistenter Objektcache wie Redis oder Memcached empfohlen.', 'mh-user-activity-monitor'),
                'info'
            );
        }
    }

    public function overview_page(): void {
        $this->require_can_view();
        $detail = $this->query_arg('session', '', 'text');
        echo '<div class="wrap mhuam-wrap"><h1>MH User Activity Monitor</h1>';
        if ($detail) { $this->render_detail($detail); echo '</div>'; return; }
        if (!empty($this->settings->get()['privacy_help_enabled'])) { $this->privacy_notice(); }
        if (!empty($this->settings->get()['trust_proxy_headers'])) {
            echo '<div class="notice notice-warning"><p>' . esc_html__('Proxy-Header sind aktiv. Header werden nur ausgewertet, wenn die aktuelle REMOTE_ADDR in der Liste der erlaubten Proxy-IP-Adressen steht. Hinterlegen Sie dort ausschließlich die IP-Adressen Ihres Reverse Proxys oder CDN.', 'mh-user-activity-monitor') . '</p></div>';
        }
        echo '<div id="mhuam-cards-wrap">';
        $this->render_cards();
        echo '</div>';
        $this->render_filters($this->query_arg('mhuam_filter', 'all', 'key'));
        echo '<div id="mhuam-table-wrap">';
        $this->render_table();
        echo '</div></div>';
    }

    private function render_cards(): void {
        $stats = $this->db->get_stats();
        $cards = [
            __('Online', 'mh-user-activity-monitor') => ['value' => $stats['online'], 'class' => 'is-online'],
            __('Bots online', 'mh-user-activity-monitor') => ['value' => $stats['bots_online'], 'class' => 'is-bot'],
            __('Kunden online', 'mh-user-activity-monitor') => ['value' => $stats['customers_online'], 'class' => 'is-customer'],
        ];
        if ($this->has_woocommerce()) {
            $cards[__('Warenkörbe', 'mh-user-activity-monitor')] = ['value' => $stats['carts'], 'class' => 'is-cart'];
        }
        $cards[__('Orange', 'mh-user-activity-monitor')] = ['value' => $stats['orange'], 'class' => 'is-orange'];
        $cards[__('Rot', 'mh-user-activity-monitor')] = ['value' => $stats['red'], 'class' => 'is-red'];
        $cards[__('Auffällige Muster', 'mh-user-activity-monitor')] = ['value' => $stats['attack_flags'], 'class' => 'is-flagged'];
        $cards[__('Sessions gesamt', 'mh-user-activity-monitor')] = ['value' => $stats['total'], 'class' => 'is-total'];
        echo '<div class="mhuam-cards">';
        foreach ($cards as $label => $card) {
            echo '<div class="mhuam-card ' . esc_attr($card['class']) . '"><strong>' . esc_html((string)$card['value']) . '</strong><span>' . esc_html($label) . '</span></div>';
        }
        echo '</div>';
    }

    private function render_filters(?string $filter = null): void {
        $filter = $filter ?? $this->query_arg('mhuam_filter', 'all', 'key');
        $base = admin_url('admin.php?page=mh-user-activity-monitor');
        $filters = ['all' => __('Alle', 'mh-user-activity-monitor'), 'high_risk' => __('Auffällig', 'mh-user-activity-monitor'), 'bots' => __('Nur Bots', 'mh-user-activity-monitor'), 'customers' => __('Nur Kunden', 'mh-user-activity-monitor')];
        if ($this->has_woocommerce()) {
            $filters['cart'] = __('Nur Warenkorb', 'mh-user-activity-monitor');
        }
        if (!$this->has_woocommerce() && $filter === 'cart') {
            $filter = 'all';
        }
        echo '<div class="mhuam-toolbar">';
        echo '<span class="mhuam-toolbar-label">' . esc_html__('Filter:', 'mh-user-activity-monitor') . '</span>';
        foreach ($filters as $key => $label) {
            $class = $filter === $key ? 'button button-primary' : 'button';
            echo '<a class="' . esc_attr($class) . '" href="' . esc_url(add_query_arg('mhuam_filter', $key, $base)) . '">' . esc_html($label) . '</a> ';
        }
        echo '<a class="button" href="' . esc_url($this->export_url($filter)) . '">' . esc_html__('CSV exportieren', 'mh-user-activity-monitor') . '</a> ';
        if ($this->settings->can_manage()) {
            $clear = wp_nonce_url(admin_url('admin-post.php?action=mhuam_clear_sessions'), 'mhuam_clear_sessions');
            echo '<a class="button button-secondary" href="' . esc_url($clear) . '" onclick="return confirm(\'' . esc_js(__('Gespeicherte Sessions wirklich löschen?', 'mh-user-activity-monitor')) . '\')">' . esc_html__('Sessions löschen', 'mh-user-activity-monitor') . '</a>';
        }
        echo '</div>';
    }

    private function render_table(?string $filter = null, ?string $orderby = null, ?string $order = null, ?int $paged = null): void {
        $filter = $filter ?? $this->query_arg('mhuam_filter', 'all', 'key');
        if (!$this->has_woocommerce() && $filter === 'cart') {
            $filter = 'all';
        }
        $orderby = $orderby ?? $this->query_arg('orderby', 'last_seen_ts', 'key');
        $order = strtoupper($order ?? $this->query_arg('order', 'DESC', 'text')) === 'ASC' ? 'ASC' : 'DESC';
        $paged = $paged ?? max(1, (int)$this->query_arg('paged', '1', 'int'));
        $per_page = 100;
        $total = $this->db->count_sessions($filter);
        $max_pages = max(1, (int)ceil($total / $per_page));
        $paged = min(max(1, $paged), $max_pages);
        $offset = ($paged - 1) * $per_page;
        $rows = $this->db->get_sessions($filter, $orderby, $order, $per_page, $offset);
        $this->render_pagination($filter, $orderby, $order, $paged, $max_pages, $total);
        echo '<div class="mhuam-table-scroll"><table class="widefat striped mhuam-table"><thead><tr>';
        $cols = ['visitor_type' => __('Besucher / Bot', 'mh-user-activity-monitor'), 'ip_display' => __('IP-Adresse', 'mh-user-activity-monitor'), 'page_type' => __('Aktuelle Seite', 'mh-user-activity-monitor'), 'hits' => __('Aufrufe', 'mh-user-activity-monitor'), 'last_seen_ts' => __('Letzte Aktivität', 'mh-user-activity-monitor'), 'bot_risk' => __('Ampel', 'mh-user-activity-monitor')];
        if ($this->has_woocommerce()) {
            $cols['cart_count'] = __('Warenkorb', 'mh-user-activity-monitor');
        }
        echo '<th>' . esc_html__('Details', 'mh-user-activity-monitor') . '</th><th>' . esc_html__('Status', 'mh-user-activity-monitor') . '</th>';
        foreach ($cols as $key => $label) {
            $next = ($orderby === $key && $order === 'ASC') ? 'DESC' : 'ASC';
            $url = add_query_arg(['orderby' => $key, 'order' => $next, 'paged' => 1]);
            echo '<th><a href="' . esc_url($url) . '">' . esc_html($label) . '</a></th>';
        }
        echo '<th>' . esc_html__('User-Agent', 'mh-user-activity-monitor') . '</th></tr></thead><tbody>';
        if (empty($rows)) {
            echo '<tr><td colspan="' . esc_attr((string)(count($cols) + 3)) . '">' . esc_html__('Keine aktiven Sessions gefunden.', 'mh-user-activity-monitor') . '</td></tr>';
        }
        foreach ($rows as $row) { $this->render_row($row); }
        echo '</tbody></table></div>';
        $this->render_pagination($filter, $orderby, $order, $paged, $max_pages, $total);
    }

    private function render_pagination(string $filter, string $orderby, string $order, int $paged, int $max_pages, int $total): void {
        if ($max_pages <= 1) {
            // translators: %d is the number of sessions currently displayed.
            echo '<p class="description">' . esc_html(sprintf(__('Angezeigte Sessions: %d', 'mh-user-activity-monitor'), $total)) . '</p>';
            return;
        }
        $base = admin_url('admin.php?page=mh-user-activity-monitor');
        $args = ['mhuam_filter' => $filter, 'orderby' => $orderby, 'order' => $order];
        echo '<div class="tablenav"><div class="tablenav-pages">';
        // translators: %d is the total number of sessions.
        echo '<span class="displaying-num">' . esc_html(sprintf(_n('%d Session', '%d Sessions', $total, 'mh-user-activity-monitor'), $total)) . '</span> ';
        if ($paged > 1) {
            echo '<a class="button" href="' . esc_url(add_query_arg(array_merge($args, ['paged' => $paged - 1]), $base)) . '">&lsaquo;</a> ';
        }
        // translators: 1: current page number, 2: total number of pages.
        echo '<span class="paging-input">' . esc_html(sprintf(__('Seite %1$d von %2$d', 'mh-user-activity-monitor'), $paged, $max_pages)) . '</span> ';
        if ($paged < $max_pages) {
            echo '<a class="button" href="' . esc_url(add_query_arg(array_merge($args, ['paged' => $paged + 1]), $base)) . '">&rsaquo;</a>';
        }
        echo '</div></div>';
    }

    private function render_row(array $row): void {
        $s = $this->settings->get();
        $online = (int)$row['last_seen_ts'] >= time() - (int)$s['online_seconds'];
        $detail_url = add_query_arg(['page' => 'mh-user-activity-monitor', 'session' => rawurlencode($row['session_id'])], admin_url('admin.php'));
        $risk = in_array($row['bot_risk'], ['green','yellow','orange','red'], true) ? $row['bot_risk'] : 'green';
        $flags = json_decode((string)$row['attack_flags_json'], true); $flags = is_array($flags) ? $flags : [];
        echo '<tr class="mhuam-risk-' . esc_attr($risk) . '">';
        echo '<td><a class="button button-small" href="' . esc_url($detail_url) . '">' . esc_html__('Details', 'mh-user-activity-monitor') . '</a></td>';
        echo '<td><span class="mhuam-pill ' . ($online ? 'is-online' : 'is-offline') . '">' . esc_html($online ? __('Online', 'mh-user-activity-monitor') : __('Offline', 'mh-user-activity-monitor')) . '</span></td>';
        echo '<td><strong>' . esc_html($row['display_name'] ?: $row['visitor_type']) . '</strong><br><span>' . esc_html($row['visitor_type']) . '</span>';
        if (!empty($row['is_bot'])) { echo '<br><span class="mhuam-bot-label">BOT</span> ' . esc_html($this->format_bot_label($row)); }
        echo '</td>';
        echo '<td>' . wp_kses_post($this->display_ip_value($row['ip_display'])) . '</td>';
        echo '<td><strong>' . esc_html($row['page_type']) . '</strong><br>' . wp_kses_post($this->url_link($row['current_url'])) . '</td>';
        echo '<td>' . esc_html((string)$row['hits']) . '</td>';
        echo '<td>' . wp_kses_post($this->format_time_short((string)$row['last_seen'], (int)$row['last_seen_ts'])) . '</td>';
        echo '<td><span class="mhuam-pill mhuam-risk-pill mhuam-risk-pill-' . esc_attr($risk) . '">' . esc_html($this->format_risk_label($risk)) . '</span>' . (!empty($flags) ? '<br><small>' . esc_html(implode(', ', array_slice($flags, 0, 2))) . '</small>' : '') . '</td>';
        if ($this->has_woocommerce()) {
            echo '<td>' . wp_kses_post($this->cart_summary_cell($row['cart_json'] ?? '', (int)($row['cart_count'] ?? 0))) . '</td>';
        }
        echo '<td class="mhuam-ua">' . esc_html((string)$row['user_agent']) . '</td>';
        echo '</tr>';
    }

    private function format_bot_label(array $row): string {
        $category = $this->translate_bot_category((string)($row['bot_category'] ?? ''));
        $name = trim((string)($row['bot_name'] ?? ''));

        if ($category === '' && $name === '') {
            return '';
        }

        if ($category === '') {
            return $name;
        }

        return $name !== '' ? $category . ': ' . $name : $category;
    }

    private function translate_bot_category(string $category): string {
        switch ($category) {
            case 'KI-Assistent / Live-Abruf':
                return __('KI-Assistent / Live-Abruf', 'mh-user-activity-monitor');
            case 'KI-Suchmaschine':
                return __('KI-Suchmaschine', 'mh-user-activity-monitor');
            case 'KI-Training / Datensammlung':
                return __('KI-Training / Datensammlung', 'mh-user-activity-monitor');
            case 'KI-Crawler':
                return __('KI-Crawler', 'mh-user-activity-monitor');
            case 'Suchmaschine':
                return __('Suchmaschine', 'mh-user-activity-monitor');
            case 'SEO-Tool':
                return __('SEO-Tool', 'mh-user-activity-monitor');
            case 'Social Preview':
                return __('Social Preview', 'mh-user-activity-monitor');
            case 'Monitoring':
                return __('Monitoring', 'mh-user-activity-monitor');
            case 'Scanner':
                return __('Scanner', 'mh-user-activity-monitor');
            case 'Unbekannter Bot':
                return __('Unbekannter Bot', 'mh-user-activity-monitor');
            case 'Bot/Crawler':
                return __('Bot/Crawler', 'mh-user-activity-monitor');
            default:
                return $category;
        }
    }

    private function format_risk_label(string $risk): string {
        switch ($risk) {
            case 'red':
                return __('Rot', 'mh-user-activity-monitor');
            case 'orange':
                return __('Orange', 'mh-user-activity-monitor');
            case 'yellow':
                return __('Gelb', 'mh-user-activity-monitor');
            default:
                return __('Grün', 'mh-user-activity-monitor');
        }
    }

    private function render_detail(string $session_id): void {
        $row = $this->db->get_session($session_id);
        echo '<p><a class="button" href="' . esc_url(admin_url('admin.php?page=mh-user-activity-monitor')) . '">' . esc_html__('Zurück zur Übersicht', 'mh-user-activity-monitor') . '</a></p>';
        if (!$row) { echo '<div class="notice notice-error"><p>' . esc_html__('Session nicht gefunden.', 'mh-user-activity-monitor') . '</p></div>'; return; }
        echo '<h2>' . esc_html__('Detailansicht', 'mh-user-activity-monitor') . '</h2><div class="mhuam-detail-grid">';
        $ip_label = __('IP-Adresse', 'mh-user-activity-monitor');
        $items = [
            __('Typ', 'mh-user-activity-monitor') => $row['visitor_type'],
            __('Name / Agent', 'mh-user-activity-monitor') => $row['display_name'],
            $ip_label => $row['ip_display'],
            __('Seitentyp', 'mh-user-activity-monitor') => $row['page_type'],
            __('Aktuelle Seite', 'mh-user-activity-monitor') => $row['current_url'],
            __('Herkunft', 'mh-user-activity-monitor') => $row['referrer'],
            __('Erste Aktivität', 'mh-user-activity-monitor') => get_date_from_gmt($row['first_seen'], 'd.m.Y H:i:s'),
            __('Letzte Aktivität', 'mh-user-activity-monitor') => get_date_from_gmt($row['last_seen'], 'd.m.Y H:i:s'),
            __('Aufrufe', 'mh-user-activity-monitor') => $row['hits'],
            __('Bot', 'mh-user-activity-monitor') => !empty($row['is_bot']) ? $this->format_bot_label($row) : '—',
            __('User-Agent', 'mh-user-activity-monitor') => $row['user_agent'],
        ];
        foreach ($items as $label => $value) {
            echo '<div><strong>' . esc_html($label) . '</strong><p>';
            if ($label === $ip_label) {
                echo wp_kses_post($this->display_ip_value($value));
            } else {
                echo esc_html((string)$value);
            }
            echo '</p></div>';
        }
        echo '</div><h3>' . esc_html__('Sicherheitsmuster', 'mh-user-activity-monitor') . '</h3>';
        $flags = json_decode((string)$row['attack_flags_json'], true); $flags = is_array($flags) ? $flags : [];
        echo empty($flags) ? '<p>' . esc_html($this->dash()) . '</p>' : '<ul><li>' . implode('</li><li>', array_map('esc_html', $flags)) . '</li></ul>';
        echo '<h3>' . esc_html__('Seitenverlauf', 'mh-user-activity-monitor') . '</h3>' . wp_kses_post($this->history_list($row['page_history_json']));
        if ($this->has_woocommerce()) {
            echo '<h3>' . esc_html__('Warenkorb', 'mh-user-activity-monitor') . '</h3>' . wp_kses_post($this->cart_detail($row['cart_json']));
        }
    }

    public function settings_page(): void {
        $this->require_can_manage();
        $s = $this->settings->get();
        echo '<div class="wrap mhuam-wrap"><h1>MH User Activity Monitor - ' . esc_html__('Einstellungen', 'mh-user-activity-monitor') . '</h1>';
        $this->privacy_notice();
        echo '<form method="post" action="options.php">';
        settings_fields('mhuam_settings_group');
        echo '<table class="form-table" role="presentation">';
        echo '<tr><th>' . esc_html__('Datenschutzmodus', 'mh-user-activity-monitor') . '</th><td><select name="' . esc_attr(Settings::OPTION) . '[privacy_mode]">';
        foreach (['none' => __('Keinen', 'mh-user-activity-monitor'), 'standard' => __('Standard', 'mh-user-activity-monitor'), 'data_saving' => __('Datensparsam', 'mh-user-activity-monitor'), 'strict' => __('Streng', 'mh-user-activity-monitor')] as $k => $label) { echo '<option value="' . esc_attr($k) . '" ' . selected($s['privacy_mode'] ?? 'standard', $k, false) . '>' . esc_html($label) . '</option>'; }
        echo '</select><p class="description">' . esc_html__('Keinen wendet keinen zusätzlichen Datenschutzmodus an und nutzt nur die einzelnen aktivierten Einstellungen. Standard speichert die aktivierten Details datensparsam ohne URL-Parameter. Datensparsam speichert Referrer nur als Domain, IPs nur als Hash, keine User-Agents und Warenkörbe nur als Anzahl. Streng speichert keine Referrer, keine User-Agents, keine Warenkorbdaten und deaktiviert den Frontend-Ping effektiv.', 'mh-user-activity-monitor') . '</p></td></tr>';
        $this->input_number('online_seconds', __('Online-Zeitfenster in Sekunden', 'mh-user-activity-monitor'), $s['online_seconds']);
        $this->input_number('retention_seconds', __('Speicherzeit in Sekunden', 'mh-user-activity-monitor'), $s['retention_seconds']);
        echo '<tr><th>' . esc_html__('IP-Modus', 'mh-user-activity-monitor') . '</th><td><select name="' . esc_attr(Settings::OPTION) . '[ip_mode]">';
        foreach (['full' => __('Vollständig', 'mh-user-activity-monitor'), 'anonymized' => __('Anonymisiert', 'mh-user-activity-monitor'), 'hash' => __('Nur Hash', 'mh-user-activity-monitor')] as $k => $label) { echo '<option value="' . esc_attr($k) . '" ' . selected($s['ip_mode'], $k, false) . '>' . esc_html($label) . '</option>'; }
        echo '</select></td></tr>';
        echo '<tr><th>' . esc_html__('IP-Adressen sichtbar für', 'mh-user-activity-monitor') . '</th><td><select name="' . esc_attr(Settings::OPTION) . '[show_ip_to]">';
        foreach (['manage_options' => __('Nur Administratoren', 'mh-user-activity-monitor'), 'list_users' => __('Administratoren und Benutzerverwaltung', 'mh-user-activity-monitor')] as $k => $label) { echo '<option value="' . esc_attr($k) . '" ' . selected($s['show_ip_to'] ?? 'manage_options', $k, false) . '>' . esc_html($label) . '</option>'; }
        echo '</select><p class="description">' . esc_html__('Legt fest, ob Rollen mit Benutzerlisten-Recht IP-Werte in Übersicht, Details und CSV-Export sehen dürfen.', 'mh-user-activity-monitor') . '</p></td></tr>';
        if ($this->has_woocommerce()) {
            echo '<tr><th>' . esc_html__('WooCommerce-Warenkorb-Modus', 'mh-user-activity-monitor') . '</th><td><select name="' . esc_attr(Settings::OPTION) . '[cart_mode]">';
            foreach (['count' => __('Nur Artikelanzahl', 'mh-user-activity-monitor'), 'summary' => __('Artikelanzahl und Summe', 'mh-user-activity-monitor'), 'details' => __('Produktdetails speichern', 'mh-user-activity-monitor')] as $k => $label) { echo '<option value="' . esc_attr($k) . '" ' . selected($s['cart_mode'] ?? 'summary', $k, false) . '>' . esc_html($label) . '</option>'; }
            echo '</select><p class="description">' . esc_html__('Datensparsamer Standard: Artikelanzahl und Warenkorbsumme. Produktnamen und SKU werden nur im Detailmodus gespeichert.', 'mh-user-activity-monitor') . '</p></td></tr>';
        }
        $checkboxes = ['hide_admins' => __('Administratoren ausblenden', 'mh-user-activity-monitor'), 'hide_own_ip' => __('Eigene IP ausblenden', 'mh-user-activity-monitor'), 'track_referrer' => __('Referrer speichern', 'mh-user-activity-monitor'), 'track_user_agent' => __('User-Agent speichern', 'mh-user-activity-monitor')];
        if ($this->has_woocommerce()) {
            $checkboxes['track_cart'] = __('WooCommerce-Warenkorb speichern', 'mh-user-activity-monitor');
        }
        $checkboxes += ['track_bots' => __('Bot-Erkennung aktivieren', 'mh-user-activity-monitor'), 'track_page_history' => __('Kurzen Seitenverlauf speichern', 'mh-user-activity-monitor'), 'privacy_help_enabled' => __('Datenschutz-Hilfetext anzeigen', 'mh-user-activity-monitor'), 'frontend_ping_enabled' => __('Frontend-Ping aktivieren', 'mh-user-activity-monitor')];
        if ($this->has_woocommerce()) {
            $checkboxes['frontend_ping_woocommerce_only'] = __('Frontend-Ping nur auf WooCommerce-Seiten aktivieren', 'mh-user-activity-monitor');
        }
        $checkboxes['delete_data_on_uninstall'] = __('Plugin-Daten bei Deinstallation löschen', 'mh-user-activity-monitor');
        foreach ($checkboxes as $k => $label) {
            $this->checkbox($k, $label, !empty($s[$k]));
        }
        $this->proxy_checkbox(!empty($s['trust_proxy_headers']));
        $this->textarea('trusted_proxy_ips', __('Erlaubte Reverse-Proxy-IP-Adressen', 'mh-user-activity-monitor'), $s['trusted_proxy_ips'], '203.0.113.10\n198.51.100.0/24\n2001:db8::/32');
        echo '<p class="description">' . esc_html__('Proxy-Header werden nur akzeptiert, wenn REMOTE_ADDR zu dieser Liste passt. Lassen Sie die Liste leer, wenn kein Reverse Proxy oder CDN verwendet wird.', 'mh-user-activity-monitor') . '</p>';
        $this->textarea('ignored_ips', __('Ignorierte IP-Adressen', 'mh-user-activity-monitor'), $s['ignored_ips'], '192.168.178.*\n10.0.0.0/8\n2001:db8::/32');
        echo '<p class="description">' . esc_html__('Ignorierte IP-Adressen unterstützen einzelne IPs, IPv4-Wildcards sowie IPv4- und IPv6-CIDR-Bereiche.', 'mh-user-activity-monitor') . '</p>';
        $this->textarea('ignored_urls', __('Ignorierte URLs', 'mh-user-activity-monitor'), $s['ignored_urls'], '/wp-json/');
        $this->textarea('ignored_user_agents', __('Ignorierte User-Agents', 'mh-user-activity-monitor'), $s['ignored_user_agents'], 'UptimeRobot');
        $this->input_number('max_sessions', __('Maximale Sessions', 'mh-user-activity-monitor'), $s['max_sessions']);
        $this->input_number('bot_warning_threshold_orange', __('Aufrufschwelle Orange', 'mh-user-activity-monitor'), $s['bot_warning_threshold_orange']);
        $this->input_number('bot_warning_threshold_red', __('Aufrufschwelle Rot', 'mh-user-activity-monitor'), $s['bot_warning_threshold_red']);
        $this->input_number('live_refresh_seconds', __('Live-Aktualisierung in Sekunden', 'mh-user-activity-monitor'), $s['live_refresh_seconds']);
        $this->input_number('frontend_ping_seconds', __('Frontend-Ping-Intervall in Sekunden', 'mh-user-activity-monitor'), $s['frontend_ping_seconds']);
        echo '<p class="description">' . esc_html__('Wenn der Frontend-Ping deaktiviert ist, werden nur normale Seitenaufrufe erfasst. Regelmäßige AJAX-Pings im Frontend werden dann nicht geladen.', 'mh-user-activity-monitor') . '</p>';
        echo '</table>';
        submit_button();
        echo '</form></div>';
    }

    public function help_page(): void {
        $this->require_can_view();
        echo '<div class="wrap mhuam-wrap mhuam-help"><h1>' . esc_html__('Ausführliche Anleitung', 'mh-user-activity-monitor') . '</h1>';
        // translators: %s: installed plugin version.
        echo '<p><strong>' . esc_html(sprintf(__('Installed plugin version: %s', 'mh-user-activity-monitor'), MHUAM_VERSION)) . '</strong></p>';
        echo '<p>' . esc_html__('Diese Anleitung erklärt die Einrichtung, die tägliche Nutzung, die Datenschutzoptionen und die wichtigsten Sicherheitsfunktionen des MH User Activity Monitor.', 'mh-user-activity-monitor') . '</p>';
        foreach (HelpDocs::sections(function_exists('determine_locale') ? determine_locale() : get_locale()) as $section) {
            echo '<div class="mhuam-help-section">';
            echo '<h2>' . esc_html($section['title']) . '</h2>';
            if (!empty($section['intro'])) {
                echo '<p>' . esc_html($section['intro']) . '</p>';
            }
            if (!empty($section['items'])) {
                echo '<ul class="mhuam-help-list">';
                foreach ($section['items'] as $item) {
                    echo '<li>' . esc_html($item) . '</li>';
                }
                echo '</ul>';
            }
            echo '</div>';
        }
        echo '<p class="description">' . esc_html__('Hinweis: Die Anleitung ist Bestandteil der Plugin-Sprachdateien. Wenn neue Funktionen ergänzt werden, sollten die POT-Datei sowie alle PO- und MO-Dateien zusammen aktualisiert werden.', 'mh-user-activity-monitor') . '</p>';
        echo '</div>';
    }

    public function dashboard_widget(): void {
        if (!$this->settings->can_view()) { return; }
        wp_add_dashboard_widget('mhuam_dashboard', 'MH User Activity Monitor', function () {
            $s = $this->db->get_stats();
            if ($this->has_woocommerce()) {
                // translators: 1: number of online sessions, 2: number of online bots, 3: number of sessions with carts.
                echo '<p>' . esc_html(sprintf(__('Online: %1$d | Bots: %2$d | Carts: %3$d', 'mh-user-activity-monitor'), $s['online'], $s['bots_online'], $s['carts'])) . '</p>';
            } else {
                // translators: 1: number of online sessions, 2: number of online bots.
                echo '<p>' . esc_html(sprintf(__('Online: %1$d | Bots: %2$d', 'mh-user-activity-monitor'), $s['online'], $s['bots_online'])) . '</p>';
            }
            echo '<p><a class="button" href="' . esc_url(admin_url('admin.php?page=mh-user-activity-monitor')) . '">' . esc_html__('Übersicht öffnen', 'mh-user-activity-monitor') . '</a></p>';
        });
    }

    public function admin_bar_counter($bar): void {
        if (!$this->settings->can_view()) { return; }
        $s = $this->db->get_stats();
        $bar->add_node(['id' => 'mhuam-counter', 'title' => esc_html('Online: ' . (int)$s['online'] . ' | Bots: ' . (int)$s['bots_online']), 'href' => esc_url(admin_url('admin.php?page=mh-user-activity-monitor'))]);
    }

    public function clear_sessions_action(): void {
        $this->require_can_manage();
        check_admin_referer('mhuam_clear_sessions');
        $this->db->clear();
        wp_safe_redirect(admin_url('admin.php?page=mh-user-activity-monitor&cleared=1'));
        exit;
    }

    public function export_sessions_action(): void {
        $this->require_can_view();
        check_admin_referer('mhuam_export_sessions');

        $filter = $this->query_arg('mhuam_filter', 'all', 'key');
        if (!$this->has_woocommerce() && $filter === 'cart') {
            $filter = 'all';
        }
        $orderby = $this->query_arg('orderby', 'last_seen_ts', 'key');
        $order = strtoupper($this->query_arg('order', 'DESC', 'text')) === 'ASC' ? 'ASC' : 'DESC';
        $limit = max(25, min(5000, (int)($this->settings->get()['max_sessions'] ?? 1000)));
        $rows = $this->db->get_sessions($filter, $orderby, $order, $limit, 0);

        nocache_headers();
        status_header(200);
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="mh-user-activity-monitor-sessions-' . gmdate('Ymd-His') . '.csv"');

        $handle = fopen('php://output', 'w');
        if ($handle !== false) {
            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, $this->export_headers());
            foreach ($rows as $row) {
                fputcsv($handle, $this->export_row($row));
            }
            fclose($handle);
        }
        exit;
    }

    public function dismiss_notice_action(): void {
        $this->require_can_manage();

        $notice = $this->query_arg('notice', '', 'key');
        if (!$this->is_dismissible_notice($notice)) {
            wp_safe_redirect(admin_url('admin.php?page=mh-user-activity-monitor'));
            exit;
        }

        check_admin_referer('mhuam_dismiss_notice_' . $notice);

        $dismissed = get_user_meta(get_current_user_id(), self::NOTICE_DISMISS_META, true);
        if (!is_array($dismissed)) {
            $dismissed = [];
        }

        $dismissed[$notice] = time() + self::NOTICE_DISMISS_SECONDS;
        update_user_meta(get_current_user_id(), self::NOTICE_DISMISS_META, $dismissed);

        $redirect = wp_get_referer();
        if (!$redirect) {
            $redirect = admin_url('admin.php?page=mh-user-activity-monitor');
        }

        wp_safe_redirect($redirect);
        exit;
    }

    private function is_dismissible_notice(string $notice): bool {
        return in_array($notice, ['object_cache', 'privacy'], true);
    }

    private function is_notice_dismissed(string $notice): bool {
        if (!$this->is_dismissible_notice($notice)) {
            return false;
        }

        $dismissed = get_user_meta(get_current_user_id(), self::NOTICE_DISMISS_META, true);
        if (!is_array($dismissed) || empty($dismissed[$notice])) {
            return false;
        }

        $until = absint($dismissed[$notice]);
        if ($until > time()) {
            return true;
        }

        unset($dismissed[$notice]);
        update_user_meta(get_current_user_id(), self::NOTICE_DISMISS_META, $dismissed);
        return false;
    }

    private function dismiss_notice_url(string $notice): string {
        $url = add_query_arg(
            [
                'action' => 'mhuam_dismiss_notice',
                'notice' => $notice,
            ],
            admin_url('admin-post.php')
        );

        return wp_nonce_url($url, 'mhuam_dismiss_notice_' . $notice);
    }

    private function render_dismissible_notice(string $notice, string $message, string $type = 'info'): void {
        if ($this->is_notice_dismissed($notice)) {
            return;
        }

        $allowed_types = ['info', 'warning', 'error', 'success'];
        $type = in_array($type, $allowed_types, true) ? $type : 'info';

        echo '<div class="notice notice-' . esc_attr($type) . ' mhuam-dismissible-notice">';
        echo '<p>' . esc_html($message) . '</p>';
        echo '<p><a class="button button-small" href="' . esc_url($this->dismiss_notice_url($notice)) . '">' . esc_html__('Für 4 Wochen ausblenden', 'mh-user-activity-monitor') . '</a></p>';
        echo '</div>';
    }

    public function ajax_live(): void {
        $this->ajax_require_can_view();
        if (!check_ajax_referer('mhuam_admin_live', 'nonce', false)) {
            wp_send_json_error(['message' => 'invalid_nonce'], 403);
        }
        $filter = $this->post_arg('mhuam_filter', 'all', 'key');
        $orderby = $this->post_arg('orderby', 'last_seen_ts', 'key');
        $order = $this->post_arg('order', 'DESC', 'text');
        $paged = max(1, (int)$this->post_arg('paged', '1', 'int'));

        ob_start();
        $this->render_cards();
        $cards = ob_get_clean();

        ob_start();
        $this->render_table($filter, $orderby, $order, $paged);
        $table = ob_get_clean();

        wp_send_json_success([
            'cards' => $cards,
            'table' => $table,
        ]);
    }


    /**
     * Read-only query arguments are sanitized here. These values only control sorting/filtering/detail display.
     */
    private function query_arg(string $key, string $default = '', string $type = 'text'): string {
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Read-only admin table state, no mutation.
        if (!array_key_exists($key, $_GET)) {
            return $default;
        }
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Read-only admin table state; value is unslashed here and sanitized immediately below based on requested type.
        $raw_value = wp_unslash($_GET[$key]);

        if ($type === 'key') {
            $value = sanitize_key($this->scalar_to_string($raw_value));
            return $value === '' ? $default : $value;
        }
        if ($type === 'int') {
            return (string) absint($this->scalar_to_string($raw_value));
        }
        $value = sanitize_text_field($this->scalar_to_string($raw_value));
        return $value === '' ? $default : $value;
    }


    /**
     * AJAX POST arguments are sanitized here after ajax_live() has verified
     * both the capability and the request nonce.
     */
    private function post_arg(string $key, string $default = '', string $type = 'text'): string {
        // phpcs:ignore WordPress.Security.NonceVerification.Missing -- Nonce is verified in ajax_live() before this helper is called.
        if (!array_key_exists($key, $_POST)) {
            return $default;
        }
        // phpcs:ignore WordPress.Security.NonceVerification.Missing, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Nonce is verified in ajax_live(); value is unslashed here and sanitized immediately below based on requested type.
        $raw_value = wp_unslash($_POST[$key]);

        if ($type === 'key') {
            $value = sanitize_key($this->scalar_to_string($raw_value));
            return $value === '' ? $default : $value;
        }
        if ($type === 'int') {
            return (string) absint($this->scalar_to_string($raw_value));
        }
        $value = sanitize_text_field($this->scalar_to_string($raw_value));
        return $value === '' ? $default : $value;
    }


    /**
     * Convert request values to strings before using WordPress sanitizers. This
     * avoids PHP 8.1+ deprecation notices when unexpected null or array values are
     * present in GET/POST data.
     *
     * @param mixed $value Raw request value.
     */
    private function scalar_to_string($value): string {
        if (is_string($value)) {
            return $value;
        }
        if (is_int($value) || is_float($value) || is_bool($value)) {
            return (string) $value;
        }
        return '';
    }

    private function proxy_checkbox(bool $checked): void {
        echo '<tr><th>' . esc_html__('Proxy-Header für echte Besucher-IP vertrauen', 'mh-user-activity-monitor') . '</th><td><label><input type="checkbox" id="mhuam-trust-proxy" name="' . esc_attr(Settings::OPTION) . '[trust_proxy_headers]" value="1" ' . checked($checked, true, false) . ' data-confirm="' . esc_attr__('Aktivieren Sie diese Option nur, wenn die Website hinter einem vertrauenswürdigen Reverse Proxy oder CDN läuft und die erlaubten Proxy-IP-Adressen gepflegt sind. Sonst können Besucher IP-Adressen fälschen.', 'mh-user-activity-monitor') . '"> ' . esc_html__('Aktivieren', 'mh-user-activity-monitor') . '</label></td></tr>';
    }

    private function export_url(string $filter): string {
        $orderby = $this->query_arg('orderby', 'last_seen_ts', 'key');
        $order = strtoupper($this->query_arg('order', 'DESC', 'text')) === 'ASC' ? 'ASC' : 'DESC';
        $url = add_query_arg(
            [
                'action' => 'mhuam_export_sessions',
                'mhuam_filter' => $filter,
                'orderby' => $orderby,
                'order' => $order,
            ],
            admin_url('admin-post.php')
        );

        return wp_nonce_url($url, 'mhuam_export_sessions');
    }

    private function export_headers(): array {
        $headers = [
            __('Session-ID', 'mh-user-activity-monitor'),
            __('Status', 'mh-user-activity-monitor'),
            __('Besucher / Bot', 'mh-user-activity-monitor'),
            __('Name / Agent', 'mh-user-activity-monitor'),
            __('Benutzername', 'mh-user-activity-monitor'),
            __('Rollen', 'mh-user-activity-monitor'),
            __('IP-Adresse', 'mh-user-activity-monitor'),
            __('Seitentyp', 'mh-user-activity-monitor'),
            __('Aktuelle Seite', 'mh-user-activity-monitor'),
            __('Herkunft', 'mh-user-activity-monitor'),
            __('Aufrufe', 'mh-user-activity-monitor'),
            __('Erste Aktivität', 'mh-user-activity-monitor'),
            __('Letzte Aktivität', 'mh-user-activity-monitor'),
            __('Ampel', 'mh-user-activity-monitor'),
            __('Bot', 'mh-user-activity-monitor'),
            __('Bot-Kategorie', 'mh-user-activity-monitor'),
            __('Bot-Name', 'mh-user-activity-monitor'),
            __('Sicherheitsmuster', 'mh-user-activity-monitor'),
        ];
        if ($this->has_woocommerce()) {
            $headers[] = __('Warenkorb', 'mh-user-activity-monitor');
        }
        $headers[] = __('User-Agent', 'mh-user-activity-monitor');
        return $headers;
    }

    private function export_row(array $row): array {
        $s = $this->settings->get();
        $online = (int)($row['last_seen_ts'] ?? 0) >= time() - (int)$s['online_seconds'];
        $flags = json_decode((string)($row['attack_flags_json'] ?? ''), true);
        $flags = is_array($flags) ? implode(', ', array_map([$this, 'scalar_to_string'], $flags)) : '';
        $roles = json_decode((string)($row['roles'] ?? ''), true);
        $roles = is_array($roles) ? implode(', ', array_map([$this, 'scalar_to_string'], $roles)) : '';

        $out = [
            $this->csv_cell($row['session_id'] ?? ''),
            $this->csv_cell($online ? __('Online', 'mh-user-activity-monitor') : __('Offline', 'mh-user-activity-monitor')),
            $this->csv_cell($row['visitor_type'] ?? ''),
            $this->csv_cell($row['display_name'] ?? ''),
            $this->csv_cell($row['user_login'] ?? ''),
            $this->csv_cell($roles),
            $this->csv_cell($this->settings->can_view_ip() ? ($row['ip_display'] ?? '') : $this->hidden_value()),
            $this->csv_cell($row['page_type'] ?? ''),
            $this->csv_cell($row['current_url'] ?? ''),
            $this->csv_cell($row['referrer'] ?? ''),
            $this->csv_cell($row['hits'] ?? ''),
            $this->csv_cell($row['first_seen'] ?? ''),
            $this->csv_cell($row['last_seen'] ?? ''),
            $this->csv_cell($this->format_risk_label((string)($row['bot_risk'] ?? 'green'))),
            $this->csv_cell(!empty($row['is_bot']) ? __('Ja', 'mh-user-activity-monitor') : __('Nein', 'mh-user-activity-monitor')),
            $this->csv_cell($this->translate_bot_category((string)($row['bot_category'] ?? ''))),
            $this->csv_cell($row['bot_name'] ?? ''),
            $this->csv_cell($flags),
        ];
        if ($this->has_woocommerce()) {
            $out[] = $this->csv_cell($this->plain_text($this->cart_visible_product_summary($row['cart_json'] ?? '', (int)($row['cart_count'] ?? 0))));
        }
        $out[] = $this->csv_cell($row['user_agent'] ?? '');
        return $out;
    }

    private function csv_cell($value): string {
        $value = $this->plain_text($this->scalar_to_string($value));
        if ($value !== '' && preg_match('/^[=+\-@\t\r]/', $value)) {
            $value = "'" . $value;
        }
        return $value;
    }

    private function display_ip_value($ip_display): string {
        if (!$this->settings->can_view_ip()) {
            return esc_html($this->hidden_value());
        }
        return $this->ipinfo_link($ip_display);
    }

    private function hidden_value(): string {
        return __('Ausgeblendet', 'mh-user-activity-monitor');
    }

    private function plain_text($value): string {
        $charset = function_exists('get_bloginfo') ? get_bloginfo('charset') : 'UTF-8';
        return html_entity_decode(wp_strip_all_tags((string)$value), ENT_QUOTES, $charset ?: 'UTF-8');
    }

    private function input_number(string $key, string $label, $value): void { echo '<tr><th><label>' . esc_html($label) . '</label></th><td><input type="number" name="' . esc_attr(Settings::OPTION) . '[' . esc_attr($key) . ']" value="' . esc_attr((string)$value) . '" class="small-text"></td></tr>'; }
    private function checkbox(string $key, string $label, bool $checked): void { echo '<tr><th>' . esc_html($label) . '</th><td><label><input type="checkbox" name="' . esc_attr(Settings::OPTION) . '[' . esc_attr($key) . ']" value="1" ' . checked($checked, true, false) . '> ' . esc_html__('Aktivieren', 'mh-user-activity-monitor') . '</label></td></tr>'; }
    private function textarea(string $key, string $label, string $value, string $placeholder): void { echo '<tr><th><label>' . esc_html($label) . '</label></th><td><textarea name="' . esc_attr(Settings::OPTION) . '[' . esc_attr($key) . ']" rows="4" class="large-text code" placeholder="' . esc_attr($placeholder) . '">' . esc_textarea($value) . '</textarea></td></tr>'; }
    private function privacy_notice(): void {
        $this->render_dismissible_notice(
            'privacy',
            __('Datenschutz-Hinweis: Dieses Plugin verarbeitet technische Besucherdaten kurzzeitig zur Website- und Shop-Überwachung. Prüfen Sie IP-Anonymisierung, Speicherzeit und Zugriffsbeschränkung.', 'mh-user-activity-monitor'),
            'info'
        );
    }

    private function help_features(): array {
        return [
            __('Live-Übersicht mit Dashboard-Kacheln und Filtern', 'mh-user-activity-monitor'),
            __('Detailansicht pro Besucher inklusive Seitenverlauf', 'mh-user-activity-monitor'),
            __('WooCommerce-Warenkorb-Anzeige mit datenschutzfreundlichen Einstellungen', 'mh-user-activity-monitor'),
            __('Bot-Erkennung mit Kategorien, Ampelanzeige und Angriffsmuster-Erkennung', 'mh-user-activity-monitor'),
            __('Eigene Datenbanktabelle mit optimierten Indizes', 'mh-user-activity-monitor'),
            __('Ignorierlisten für IP-Adressen, URLs und User-Agents', 'mh-user-activity-monitor'),
            __('Kurzzeitige Speicherung mit automatischer Bereinigung über WordPress-Cron', 'mh-user-activity-monitor'),
        ];
    }

    private function dash(): string { return '—'; }

    private function format_time_short(string $mysql_gmt, int $timestamp): string {
        $absolute = esc_html(get_date_from_gmt($mysql_gmt, 'd.m.Y H:i:s'));
        $relative = esc_html(human_time_diff($timestamp, time()));
        return $absolute . '<br><span>' . $relative . '</span>';
    }

    private function ipinfo_link($ip_display): string {
        $ip = trim((string)$ip_display);
        if ($ip === '' || $ip === '—') {
            return esc_html($ip);
        }

        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            return esc_html($ip);
        }

        $url = 'https://ipinfo.io/' . rawurlencode($ip);
        return '<a href="' . esc_url($url) . '" target="_blank" rel="noopener noreferrer">' . esc_html($ip) . '</a>';
    }

    private function url_link($url): string { $url = (string)$url; if ($url === '') { return esc_html($this->dash()); } return '<a href="' . esc_url($url) . '" target="_blank" rel="noopener noreferrer nofollow">' . esc_html($this->short_url($url)) . '</a>'; }
    private function short_url(string $url): string { $path = wp_parse_url($url, PHP_URL_PATH); return mb_substr($path ?: $url, 0, 90); }
    private function history_summary($json): string { $h = json_decode((string)$json, true); if (!is_array($h) || empty($h)) { return ''; } return '<details><summary>' . esc_html__('Seitenverlauf', 'mh-user-activity-monitor') . '</summary>' . $this->history_list($json) . '</details>'; }
    private function history_list($json): string {
        $history = json_decode((string) $json, true);
        if (!is_array($history) || empty($history)) {
            return '<p>' . esc_html($this->dash()) . '</p>';
        }

        $out = '<ol class="mhuam-history">';
        foreach (array_slice($history, -10) as $item) {
            if (!is_array($item)) {
                continue;
            }
            $time = $this->scalar_to_string($item['time'] ?? '');
            $url  = $this->scalar_to_string($item['url'] ?? '');
            $type = $this->scalar_to_string($item['type'] ?? '');
            $out .= '<li><strong>' . esc_html($time) . '</strong> ' . $this->url_link($url) . ' <em>' . esc_html($type) . '</em></li>';
        }
        return $out . '</ol>';
    }
    private function cart_summary_from_count(int $count): string {
        if ($count <= 0) { return esc_html__('Leer / nicht verfügbar', 'mh-user-activity-monitor'); }
        // translators: %d: number of cart items.
        return esc_html(sprintf(_n('%d item', '%d items', $count, 'mh-user-activity-monitor'), $count));
    }

    private function cart_summary_cell($json, int $fallback_count): string {
        $summary = $this->cart_visible_product_summary($json, $fallback_count);
        if ($fallback_count <= 0) {
            return $summary;
        }

        $tooltip = $this->cart_tooltip_text($json);
        if ($tooltip === '') {
            return $summary;
        }

        return '<span class="mhuam-cart-summary" title="' . esc_attr($tooltip) . '" aria-label="' . esc_attr($tooltip) . '">' . $summary . '</span>';
    }

    private function cart_visible_product_summary($json, int $fallback_count): string {
        if ($fallback_count <= 0) {
            return esc_html__('Leer / nicht verfügbar', 'mh-user-activity-monitor');
        }

        $cart = json_decode((string)$json, true);
        $items = is_array($cart) && isset($cart['items']) && is_array($cart['items']) ? $cart['items'] : [];
        $names = [];

        foreach ($items as $item) {
            if (!is_array($item)) {
                continue;
            }

            $name = trim(wp_strip_all_tags($this->scalar_to_string($item['name'] ?? '')));
            if ($name === '') {
                continue;
            }

            $qty = max(0, (int) $this->scalar_to_string($item['qty'] ?? 0));
            $names[] = ($qty > 1 ? $qty . ' × ' : '') . $name;
        }

        if (empty($names)) {
            return esc_html__('Produktname nicht gespeichert', 'mh-user-activity-monitor');
        }

        $visible_names = array_slice($names, 0, 2);
        $summary = implode(', ', $visible_names);
        $remaining = count($names) - count($visible_names);

        if ($remaining > 0) {
            $summary .= sprintf(
                /* translators: %d: number of additional products in the cart. */
                __(' + %d more', 'mh-user-activity-monitor'),
                $remaining
            );
        }

        return esc_html(mb_substr($summary, 0, 160));
    }

    private function cart_tooltip_text($json): string {
        $cart = json_decode((string)$json, true);
        if (!is_array($cart) || !empty($cart['empty'])) {
            return '';
        }

        $lines = [];
        $items = isset($cart['items']) && is_array($cart['items']) ? $cart['items'] : [];
        foreach (array_slice($items, 0, 10) as $item) {
            if (!is_array($item)) {
                continue;
            }
            $qty = max(0, (int) $this->scalar_to_string($item['qty'] ?? 0));
            $name = trim(wp_strip_all_tags($this->scalar_to_string($item['name'] ?? '')));
            if ($name === '') {
                continue;
            }
            $line = ($qty > 0 ? $qty . ' × ' : '') . $name;
            $sku = trim(wp_strip_all_tags($this->scalar_to_string($item['sku'] ?? '')));
            if ($sku !== '') {
                $line .= ' | SKU: ' . $sku;
            }
            $line_total = trim(wp_strip_all_tags($this->scalar_to_string($item['line_total'] ?? '')));
            if ($line_total !== '') {
                $line .= ' | ' . $line_total;
            }
            $lines[] = $line;
        }

        if (count($items) > 10) {
            $lines[] = '…';
        }

        $total = $this->scalar_to_string($cart['total'] ?? '');
        if ($total !== '') {
            $lines[] = __('Total', 'mh-user-activity-monitor') . ': ' . wp_strip_all_tags($total);
        }

        return mb_substr(implode("\n", $lines), 0, 1000);
    }

    private function cart_summary($json): string {
        $cart = json_decode((string) $json, true);
        if (!is_array($cart) || !empty($cart['empty'])) {
            return esc_html__('Leer / nicht verfügbar', 'mh-user-activity-monitor');
        }
        $count = max(0, (int) ($cart['count'] ?? 0));
        $summary = $count . ' Artikel';
        $total = $this->scalar_to_string($cart['total'] ?? '');
        if ($total !== '') {
            $summary .= ' | ' . $total;
        }
        return esc_html($summary);
    }

    private function cart_detail($json): string {
        $cart = json_decode((string) $json, true);
        if (!is_array($cart) || !empty($cart['empty'])) {
            return '<p>' . esc_html__('Leer / nicht verfügbar', 'mh-user-activity-monitor') . '</p>';
        }

        $count = max(0, (int) ($cart['count'] ?? 0));
        $summary = $count . ' Artikel';
        $total = $this->scalar_to_string($cart['total'] ?? '');
        if ($total !== '') {
            $summary .= ' | ' . $total;
        }
        $out = '<p><strong>' . esc_html($summary) . '</strong></p>';

        $items = isset($cart['items']) && is_array($cart['items']) ? $cart['items'] : [];
        if (empty($items)) {
            return $out . '<p class="description">' . esc_html__('Produktdetails werden im aktuellen Warenkorb-Modus nicht gespeichert.', 'mh-user-activity-monitor') . '</p>';
        }

        $out .= '<ul>';
        foreach ($items as $item) {
            if (!is_array($item)) {
                continue;
            }
            $qty = max(0, (int) ($item['qty'] ?? 0));
            $name = $this->scalar_to_string($item['name'] ?? '');
            $sku = $this->scalar_to_string($item['sku'] ?? '');
            $line_total = $this->scalar_to_string($item['line_total'] ?? '');
            $line = $qty . ' × ' . $name;
            if ($sku !== '') {
                $line .= ' | SKU: ' . $sku;
            }
            if ($line_total !== '') {
                $line .= ' | ' . $line_total;
            }
            $out .= '<li>' . esc_html($line) . '</li>';
        }
        return $out . '</ul>';
    }
}
