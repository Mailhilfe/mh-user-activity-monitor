<?php
/**
 * MH User Activity Monitor
 *
 * @package MHUAM
 * @license GPL-2.0-or-later
 */

namespace MHUAM;

if (!defined('ABSPATH')) { exit; }

final class Tracker {
    private const HOST_COOKIE_NAME = '__Host-wpuam_sid';
    private const FALLBACK_COOKIE_NAME = 'wpuam_sid';
    private const COOKIE_SECONDS = 86400;
    private const MIN_WRITE_INTERVAL = 15;
    private const AJAX_IP_RATE_LIMIT = 120;
    private const AJAX_IP_RATE_WINDOW = 60;
    private const NEW_SESSIONS_PER_IP_LIMIT = 30;
    private const NEW_SESSIONS_PER_IP_WINDOW = 600;
    private const MAX_URL_LENGTH = 1000;
    private const MAX_REFERRER_LENGTH = 1000;
    private const MAX_USER_AGENT_LENGTH = 500;

    private Settings $settings;
    private DB $db;
    private BotDetector $botDetector;

    public function __construct(Settings $settings, DB $db, BotDetector $botDetector) {
        $this->settings = $settings; $this->db = $db; $this->botDetector = $botDetector;
    }

    public function init(): void {
        add_action('send_headers', [$this, 'maybe_set_session_cookie'], 1);
        add_action('init', [$this, 'maybe_set_session_cookie'], 1);
        add_action('wp_loaded', [$this, 'track_activity'], 20);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_frontend_ping']);
        add_action('wp_ajax_mhuam_ping', [$this, 'ajax_ping']);
        add_action('wp_ajax_nopriv_mhuam_ping', [$this, 'ajax_ping']);
    }

    public function maybe_set_session_cookie(): void {
        if (is_admin() && !$this->is_frontend_ajax()) { return; }
        $sid = $this->get_sid_from_cookie();
        if ($sid) { return; }
        if (headers_sent()) {
            return;
        }
        $ip = $this->resolve_ip();
        if (!$this->allow_new_session_for_ip($ip)) { return; }
        $sid = bin2hex(random_bytes(16));
        $secure = is_ssl();
        $cookie_name = $this->cookie_name();
        $cookie_set = setcookie($cookie_name, $sid, [
            'expires' => time() + self::COOKIE_SECONDS,
            'path' => '/',
            'secure' => $secure,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        if ($cookie_set) {
            $_COOKIE[$cookie_name] = $sid;
        }
        if ($secure && $this->cookie_value(self::FALLBACK_COOKIE_NAME) !== '' && !headers_sent()) {
            setcookie(self::FALLBACK_COOKIE_NAME, '', time() - 3600, '/', '', false, true);
        }
    }

    public function enqueue_frontend_ping(): void {
        if (is_admin()) { return; }
        $settings = $this->settings->get();
        $is_woocommerce_page = $this->is_woocommerce_context();
        if ($this->privacy_mode() === 'strict') { return; }
        if (empty($settings['frontend_ping_enabled'])) { return; }
        if (!empty($settings['frontend_ping_woocommerce_only']) && !$is_woocommerce_page) { return; }
        wp_enqueue_script('mhuam-frontend', MHUAM_URL . 'assets/frontend.js', [], MHUAM_VERSION, true);
        wp_localize_script('mhuam-frontend', 'MHUAM_FRONTEND', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'action' => 'mhuam_ping',
            'nonce' => wp_create_nonce('mhuam_ping'),
            'interval' => (int)$settings['frontend_ping_seconds'],
            'woocommerceOnly' => !empty($settings['frontend_ping_woocommerce_only']),
            'isWooCommercePage' => $is_woocommerce_page,
        ]);
    }

    public function ajax_ping(): void {
        if (!check_ajax_referer('mhuam_ping', 'nonce', false)) {
            wp_send_json_error(['ok' => false, 'reason' => 'nonce'], 403);
        }
        $ip = $this->resolve_ip();
        if (!$this->allow_ajax_ip($ip)) { wp_send_json_error(['ok' => false, 'reason' => 'rate_limited'], 429); }
        $this->track_activity('ajax');
        wp_send_json_success(['ok' => true], 200);
    }

    public function track_activity($source = 'page'): void {
        if (is_admin() && !$this->is_frontend_ajax()) { return; }
        $s = $this->settings->get();
        $sid = $this->get_sid_from_cookie();
        if (!$sid) { return; }

        $now = time();
        if ($source === 'ajax' && !$this->allow_session_write($sid, $now)) { return; }

        $raw_uri = $this->raw_current_url();
        $raw_ua = $this->server_value('HTTP_USER_AGENT');
        if ($this->is_ignored_url($raw_uri) || $this->is_ignored_user_agent($raw_ua)) { return; }

        $ip = $this->resolve_ip();
        if ($this->is_ignored_ip($ip)) { return; }

        $user = wp_get_current_user();
        if (!empty($s['hide_admins']) && $user && $user->ID && in_array('administrator', (array)$user->roles, true)) { return; }

        $hits_for_session = $this->session_hit_estimate($sid);
        $first_seen_ts = $this->session_first_seen_estimate($sid, $now);

        if (!empty($s['track_bots'])) {
            $bot = $this->botDetector->analyze($raw_ua, $raw_uri, $hits_for_session);
            if (!empty($s['hide_known_search_bots']) && $bot['bot_category'] === 'Suchmaschine') { return; }
        } else {
            $bot = [
                'is_bot' => false,
                'bot_name' => '',
                'bot_category' => '',
                'bot_risk' => 'green',
                'attack_flags' => [],
            ];
        }

        $url = $this->sanitize_url_for_storage($raw_uri, 'url');
        $ref = $this->effective_track_referrer() ? $this->sanitize_referrer_for_storage($this->frontend_value('referrer', $this->server_value('HTTP_REFERER'))) : '';
        $page_type = $this->detect_page_type($raw_uri);
        $history = $source === 'ajax' ? $this->frontend_history($url, $page_type, $now) : $this->build_history('[]', $url, $page_type, $now);
        $cart = $this->effective_track_cart() ? $this->cart_snapshot() : ['empty' => true];
        $visitor_type = $this->visitor_type($user, (bool)$bot['is_bot']);
        $ip_display = $this->format_ip($ip);

        $this->db->upsert([
            'session_id' => $sid,
            'user_id' => (int)($user && $user->ID ? $user->ID : 0),
            'display_name' => $this->clamp($user && $user->ID ? $user->display_name : ($bot['is_bot'] ? $bot['bot_name'] : __('Besucher', 'mh-user-activity-monitor')), 191),
            'user_login' => $this->clamp($user && $user->ID ? $user->user_login : '', 80),
            'roles' => wp_json_encode($user && $user->ID ? (array)$user->roles : []),
            'visitor_type' => $visitor_type,
            'ip_address' => ($this->effective_ip_mode() === 'full') ? $ip : '',
            'ip_display' => $ip_display,
            'ip_hash' => hash('sha256', strtolower($ip) . '|' . wp_salt('auth')),
            'current_url' => $url,
            'page_type' => $page_type,
            'attack_flags_json' => wp_json_encode($bot['attack_flags']),
            'page_history_json' => wp_json_encode($history),
            'referrer' => $ref,
            'user_agent' => $this->effective_track_user_agent() ? $this->clamp($raw_ua, self::MAX_USER_AGENT_LENGTH) : '',
            'is_bot' => $bot['is_bot'] ? 1 : 0,
            'bot_name' => $bot['bot_name'],
            'bot_category' => $bot['bot_category'],
            'bot_risk' => $bot['bot_risk'],
            'cart_json' => wp_json_encode($cart),
            'cart_count' => $this->cart_count($cart),
            'first_seen' => gmdate('Y-m-d H:i:s', $first_seen_ts),
            'last_seen' => gmdate('Y-m-d H:i:s', $now),
            'last_seen_ts' => $now,
            'hits' => $hits_for_session,
            'last_ping_source' => $source === 'ajax' ? 'ajax' : 'page',
        ]);
    }

    private function allow_session_write(string $sid, int $now): bool {
        $key = 'mhuam_lastwrite_' . md5($sid);
        $last = (int)get_transient($key);
        if ($last > 0 && ($now - $last) < self::MIN_WRITE_INTERVAL) { return false; }
        set_transient($key, $now, self::MIN_WRITE_INTERVAL);
        return true;
    }

    private function session_hit_estimate(string $sid): int {
        $key = 'mhuam_hits_' . md5($sid);
        $hits = (int)get_transient($key);
        $hits++;
        set_transient($key, $hits, DAY_IN_SECONDS);
        return $hits;
    }

    private function session_first_seen_estimate(string $sid, int $now): int {
        $key = 'mhuam_first_seen_' . md5($sid);
        $first_seen = (int)get_transient($key);
        if ($first_seen <= 0) {
            $first_seen = $now;
            set_transient($key, $first_seen, DAY_IN_SECONDS);
        }
        return $first_seen;
    }

    private function get_sid_from_cookie(): string {
        $sid = $this->cookie_value($this->cookie_name());
        if ($sid === '') { $sid = $this->cookie_value(self::HOST_COOKIE_NAME); }
        if ($sid === '') { $sid = $this->cookie_value(self::FALLBACK_COOKIE_NAME); }
        return preg_match('/^[a-f0-9]{32}$/', $sid) ? $sid : '';
    }

    private function cookie_name(): string {
        return is_ssl() ? self::HOST_COOKIE_NAME : self::FALLBACK_COOKIE_NAME;
    }

    private function resolve_ip(): string {
        $s = $this->settings->get();
        $ip = $this->server_value('REMOTE_ADDR');
        if (!empty($s['trust_proxy_headers']) && $this->is_trusted_proxy($ip)) {
            $headers = ['HTTP_CF_CONNECTING_IP','HTTP_X_REAL_IP','HTTP_X_FORWARDED_FOR'];
            foreach ($headers as $h) {
                $header_value = $this->server_value($h);
                if ($header_value === '') { continue; }
                $candidate = trim(explode(',', $header_value)[0]);
                if (filter_var($candidate, FILTER_VALIDATE_IP)) { $ip = $candidate; break; }
            }
        }
        return filter_var($ip, FILTER_VALIDATE_IP) ? $ip : '0.0.0.0';
    }


    private function is_trusted_proxy(string $remote_ip): bool {
        $settings = $this->settings->get();
        $patterns = Settings::lines($this->scalar_to_string($settings['trusted_proxy_ips'] ?? ''));
        if (empty($patterns)) {
            return false;
        }
        foreach ($patterns as $pattern) {
            if (Settings::ip_rule_match($pattern, $remote_ip)) { return true; }
        }
        return false;
    }

    private function format_ip(string $ip): string {
        $mode = $this->effective_ip_mode();
        if ($mode === 'hash') { return substr(hash('sha256', strtolower($ip) . '|' . wp_salt('auth')), 0, 16); }
        if ($mode === 'anonymized') {
            if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) { return preg_replace('/\.\d+$/', '.xxx', $ip); }
            return preg_replace('/:[0-9a-f]{1,4}$/i', ':xxxx', $ip);
        }
        return $ip;
    }

    private function allow_ajax_ip(string $ip): bool {
        $key = 'mhuam_ajax_' . md5($ip);
        $count = (int)get_transient($key);
        if ($count >= self::AJAX_IP_RATE_LIMIT) { return false; }
        set_transient($key, $count + 1, self::AJAX_IP_RATE_WINDOW);
        return true;
    }

    private function allow_new_session_for_ip(string $ip): bool {
        $key = 'mhuam_new_' . md5($ip);
        $count = (int)get_transient($key);
        if ($count >= self::NEW_SESSIONS_PER_IP_LIMIT) { return false; }
        set_transient($key, $count + 1, self::NEW_SESSIONS_PER_IP_WINDOW);
        return true;
    }

    private function is_ignored_ip(string $ip): bool {
        $settings = $this->settings->get();
        foreach (Settings::lines($this->scalar_to_string($settings['ignored_ips'] ?? '')) as $pattern) {
            if (Settings::ip_rule_match($pattern, $ip)) { return true; }
        }
        return false;
    }

    private function is_ignored_url(string $url): bool {
        $settings = $this->settings->get();
        foreach (Settings::lines($this->scalar_to_string($settings['ignored_urls'] ?? '')) as $pattern) {
            if (Settings::wildcard_match($pattern, $url)) { return true; }
        }
        return false;
    }

    private function is_ignored_user_agent(string $ua): bool {
        $settings = $this->settings->get();
        foreach (Settings::lines($this->scalar_to_string($settings['ignored_user_agents'] ?? '')) as $pattern) {
            if (Settings::wildcard_match($pattern, $ua)) { return true; }
        }
        return false;
    }

    private function raw_current_url(): string {
        if ($this->is_frontend_ajax()) {
            $posted = $this->frontend_value('current_url', '');
            if ($posted !== '') { return $posted; }
        }
        $scheme = is_ssl() ? 'https://' : 'http://';
        $host = $this->server_value('HTTP_HOST');
        if ($host === '') { $host = (string) wp_parse_url(home_url(), PHP_URL_HOST); }
        $uri = $this->server_value('REQUEST_URI');
        if ($uri === '') { $uri = '/'; }
        return $scheme . $host . $uri;
    }

    private function sanitize_url_for_storage(string $url, string $type = 'url'): string {
        if ($url === '') { return ''; }
        $url = esc_url_raw($url);
        $parts = wp_parse_url($url);
        if (!is_array($parts)) { return $this->clamp($url, self::MAX_URL_LENGTH); }

        $scheme = isset($parts['scheme']) ? sanitize_key((string)$parts['scheme']) : (is_ssl() ? 'https' : 'http');
        if (!in_array($scheme, ['http','https'], true)) { $scheme = is_ssl() ? 'https' : 'http'; }
        $host = isset($parts['host']) ? sanitize_text_field((string)$parts['host']) : '';
        $path = isset($parts['path']) ? '/' . ltrim(sanitize_text_field((string)$parts['path']), '/') : '/';

        $rebuilt = $host !== '' ? $scheme . '://' . $host . $path : $path;

        if ($this->privacy_mode() === 'none' && isset($parts['query'])) {
            $query = sanitize_text_field((string)$parts['query']);
            if ($query !== '') {
                $rebuilt .= '?' . $query;
            }
        }

        $max = $type === 'referrer' ? self::MAX_REFERRER_LENGTH : self::MAX_URL_LENGTH;
        return $this->clamp($rebuilt, $max);
    }

    private function sanitize_referrer_for_storage(string $referrer): string {
        if ($referrer === '') { return ''; }
        if ($this->privacy_mode() === 'data_saving') {
            $host = wp_parse_url(esc_url_raw($referrer), PHP_URL_HOST);
            return $host ? $this->clamp((string)$host, 255) : '';
        }
        return $this->sanitize_url_for_storage($referrer, 'referrer');
    }

    private function detect_page_type(string $current_url = ''): string {
        /*
         * admin-ajax.php runs in an admin context, but frontend pings are still
         * visitor activity. Do not classify those requests as "Adminbereich".
         * For AJAX pings we use the public URL sent by the frontend script and a
         * strict whitelist of public page type labels.
         */
        if ($this->is_frontend_ajax()) {
            $posted_type = $this->frontend_value('page_type', '');
            $allowed_types = [
                'WooCommerce Warenkorb',
                'WooCommerce Kasse',
                'WooCommerce Mein Konto',
                'WooCommerce Produkt',
                'WooCommerce Produktkategorie',
                'Startseite',
                'Frontend-Seite',
                'Seite / Beitrag',
            ];
            if (in_array($posted_type, $allowed_types, true)) {
                return $posted_type;
            }
            return $this->detect_page_type_from_url($current_url);
        }

        if (is_admin()) { return 'Adminbereich'; }
        $uri = strtolower($this->server_value('REQUEST_URI'));
        if (strpos($uri, '/wp-json/') !== false) { return 'REST API'; }
        if (strpos($uri, 'xmlrpc.php') !== false) { return 'XML-RPC'; }
        if (strpos($uri, 'wp-login.php') !== false) { return 'Login-Seite'; }
        if (function_exists('is_cart') && is_cart()) { return 'WooCommerce Warenkorb'; }
        if (function_exists('is_checkout') && is_checkout()) { return 'WooCommerce Kasse'; }
        if (function_exists('is_account_page') && is_account_page()) { return 'WooCommerce Mein Konto'; }
        if (function_exists('is_product') && is_product()) { return 'WooCommerce Produkt'; }
        if (function_exists('is_product_category') && is_product_category()) { return 'WooCommerce Produktkategorie'; }
        if (is_404()) { return '404-Seite'; }
        if (is_front_page()) { return 'Startseite'; }
        if (is_search()) { return 'Suche'; }
        if (is_category()) { return 'Kategorie'; }
        if (is_tag()) { return 'Schlagwort'; }
        if (is_page()) { return 'Seite'; }
        if (is_single()) { return 'Beitrag'; }
        return 'Seite / Beitrag';
    }

    private function detect_page_type_from_url(string $url): string {
        $path = (string) wp_parse_url(esc_url_raw($url), PHP_URL_PATH);
        $path = strtolower($path !== '' ? $path : '/');

        if (strpos($path, '/wp-json/') !== false) { return 'REST API'; }
        if (strpos($path, 'xmlrpc.php') !== false) { return 'XML-RPC'; }
        if (strpos($path, 'wp-login.php') !== false) { return 'Login-Seite'; }
        if ($path === '/' || $path === '') { return 'Startseite'; }
        if (strpos($path, '/cart') !== false || strpos($path, '/warenkorb') !== false) { return 'WooCommerce Warenkorb'; }
        if (strpos($path, '/checkout') !== false || strpos($path, '/kasse') !== false) { return 'WooCommerce Kasse'; }
        if (strpos($path, '/my-account') !== false || strpos($path, '/mein-konto') !== false) { return 'WooCommerce Mein Konto'; }
        if (strpos($path, '/product/') !== false || strpos($path, '/produkt/') !== false) { return 'WooCommerce Produkt'; }
        if (strpos($path, '/product-category/') !== false || strpos($path, '/produkt-kategorie/') !== false) { return 'WooCommerce Produktkategorie'; }

        return 'Frontend-Seite';
    }

    private function build_history(string $json, string $url, string $type, int $ts): array {
        if (empty($this->settings->get()['track_page_history'])) { return []; }
        $history = json_decode($json, true);
        $history = is_array($history) ? $history : [];
        $last = end($history);
        if (!is_array($last) || ($last['url'] ?? '') !== $url) {
            $history[] = ['time' => gmdate('H:i:s', $ts), 'url' => $url, 'type' => $type];
        }
        return array_slice($history, -10);
    }

    private function visitor_type($user, bool $is_bot): string {
        if ($is_bot) { return 'Bot/Crawler'; }
        if ($user && $user->ID) {
            $roles = (array)$user->roles;
            if (array_intersect(['customer','shop_manager'], $roles)) { return 'WooCommerce-Kunde'; }
            if (in_array('administrator', $roles, true)) { return 'Administrator'; }
            return 'Benutzer';
        }
        return 'Besucher';
    }

    private function cart_snapshot(): array {
        if (!function_exists('WC') || !did_action('wp_loaded') || !WC()) { return ['empty' => true]; }
        if (!WC()->cart && function_exists('wc_load_cart')) { wc_load_cart(); }
        if (!WC()->cart) { return ['empty' => true]; }

        $mode = $this->effective_cart_mode();

        $count = max(0, (int)WC()->cart->get_cart_contents_count());
        $cart = [
            'empty' => $count <= 0,
            'mode' => $mode,
            'count' => $count,
        ];

        if ($mode === 'count' || $count <= 0) {
            return $cart;
        }

        $cart['total'] = wp_strip_all_tags(WC()->cart->get_cart_subtotal());

        if ($mode !== 'details') {
            return $cart;
        }

        $items = [];
        foreach (WC()->cart->get_cart() as $item) {
            $product = $item['data'] ?? null;
            if (!$product || !is_object($product)) { continue; }

            $product_name = '';
            if (is_callable([$product, 'get_name'])) {
                $product_name = (string) $product->get_name();
            }

            if ($product_name === '' && !empty($item['product_id'])) {
                $product_name = (string) get_the_title((int) $item['product_id']);
            }

            if ($product_name === '') {
                $product_name = __('Unknown product', 'mh-user-activity-monitor');
            }

            $items[] = [
                'name' => $this->clamp($product_name, 160),
                'qty' => (int)($item['quantity'] ?? 0),
                'sku' => $this->clamp((string)$product->get_sku(), 80),
                'line_total' => wc_price((float)($item['line_total'] ?? 0)),
            ];
        }
        $cart['items'] = $items;
        return $cart;
    }


    private function cart_count(array $cart): int {
        if (!empty($cart['empty'])) { return 0; }
        return max(0, min(255, (int)($cart['count'] ?? 0)));
    }


    private function frontend_value(string $key, string $default = ''): string {
        if (!$this->is_frontend_ajax()) {
            return $default;
        }
        return $this->post_text($key, $default);
    }

    private function frontend_history(string $fallback_url, string $fallback_type, int $fallback_ts): array {
        if (empty($this->settings->get()['track_page_history'])) { return []; }
        if (!$this->is_frontend_ajax()) {
            return $this->build_history('[]', $fallback_url, $fallback_type, $fallback_ts);
        }
        $raw = $this->post_textarea('history', '');
        if ($raw === '') {
            return $this->build_history('[]', $fallback_url, $fallback_type, $fallback_ts);
        }
        $items = json_decode($raw, true);
        if (!is_array($items)) {
            return $this->build_history('[]', $fallback_url, $fallback_type, $fallback_ts);
        }
        $history = [];
        foreach (array_slice($items, -10) as $item) {
            if (!is_array($item)) { continue; }
            $url = $this->sanitize_url_for_storage($this->scalar_to_string($item['url'] ?? ''), 'url');
            if ($url === '') { continue; }
            $history[] = [
                'time' => $this->clamp($this->scalar_to_string($item['time'] ?? gmdate('H:i:s', $fallback_ts)), 12),
                'url' => $url,
                'type' => $this->clamp($this->scalar_to_string($item['type'] ?? $fallback_type), 120),
            ];
        }
        if (empty($history)) {
            $history = $this->build_history('[]', $fallback_url, $fallback_type, $fallback_ts);
        }
        return $history;
    }

    private function is_woocommerce_context(): bool {
        return (function_exists('is_cart') && is_cart())
            || (function_exists('is_checkout') && is_checkout())
            || (function_exists('is_account_page') && is_account_page())
            || (function_exists('is_product') && is_product())
            || (function_exists('is_product_category') && is_product_category())
            || (function_exists('is_shop') && is_shop());
    }

    private function privacy_mode(): string {
        $settings = $this->settings->get();
        $mode = $this->scalar_to_string($settings['privacy_mode'] ?? 'standard');
        return in_array($mode, ['standard','data_saving','strict'], true) ? $mode : 'standard';
    }

    private function effective_ip_mode(): string {
        $mode = $this->privacy_mode();
        if ($mode === 'strict') { return 'hash'; }
        if ($mode === 'data_saving') { return 'hash'; }
        $settings = $this->settings->get();
        $ip_mode = $this->scalar_to_string($settings['ip_mode'] ?? 'anonymized');
        return in_array($ip_mode, ['full','anonymized','hash'], true) ? $ip_mode : 'anonymized';
    }

    private function effective_track_referrer(): bool {
        if ($this->privacy_mode() === 'strict') { return false; }
        return !empty($this->settings->get()['track_referrer']);
    }

    private function effective_track_user_agent(): bool {
        if ($this->privacy_mode() !== 'standard') { return false; }
        return !empty($this->settings->get()['track_user_agent']);
    }

    private function effective_track_cart(): bool {
        if ($this->privacy_mode() === 'strict') { return false; }
        return !empty($this->settings->get()['track_cart']);
    }

    private function effective_cart_mode(): string {
        if ($this->privacy_mode() === 'strict') { return 'count'; }
        if ($this->privacy_mode() === 'data_saving') { return 'count'; }

        $settings = $this->settings->get();
        $mode = $this->scalar_to_string($settings['cart_mode'] ?? 'details');
        if (!in_array($mode, ['count','summary','details'], true)) {
            $mode = 'details';
        }

        // In standard privacy mode the cart table column should display the
        // real WooCommerce product names instead of the generic "item" label.
        // Existing installations that still have the legacy summary mode are
        // therefore written with product-name snapshots from now on. Stricter
        // privacy modes above continue to suppress product details.
        if ($this->privacy_mode() === 'standard' && $mode === 'summary') {
            return 'details';
        }

        return $mode;
    }


    private function post_text(string $key, string $default = ''): string {
        // The public AJAX ping nonce is verified in ajax_ping() before track_activity() calls this helper.
        // phpcs:ignore WordPress.Security.NonceVerification.Missing -- Nonce verified in ajax_ping().
        if (!array_key_exists($key, $_POST)) {
            return $default;
        }
        // phpcs:ignore WordPress.Security.NonceVerification.Missing, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Nonce verified in ajax_ping(); value is unslashed here and sanitized immediately below.
        $raw_value = wp_unslash($_POST[$key]);
        $value = sanitize_text_field($this->scalar_to_string($raw_value));
        return $value === '' ? $default : $value;
    }

    private function post_textarea(string $key, string $default = ''): string {
        // The public AJAX ping nonce is verified in ajax_ping() before track_activity() calls this helper.
        // phpcs:ignore WordPress.Security.NonceVerification.Missing -- Nonce verified in ajax_ping().
        if (!array_key_exists($key, $_POST)) {
            return $default;
        }
        // phpcs:ignore WordPress.Security.NonceVerification.Missing, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Nonce verified in ajax_ping(); value is unslashed here and sanitized immediately below.
        $raw_value = wp_unslash($_POST[$key]);
        $value = sanitize_textarea_field($this->scalar_to_string($raw_value));
        return $value === '' ? $default : $value;
    }

    private function server_value(string $key): string {
        if (!array_key_exists($key, $_SERVER)) {
            return '';
        }
        // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Server value is unslashed here and sanitized immediately below.
        $raw_value = wp_unslash($_SERVER[$key]);
        $value = sanitize_text_field($this->scalar_to_string($raw_value));
        return $value === '' ? '' : $value;
    }

    private function cookie_value(string $key): string {
        if (!array_key_exists($key, $_COOKIE)) {
            return '';
        }
        // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Cookie value is unslashed here and sanitized immediately below.
        $raw_value = wp_unslash($_COOKIE[$key]);
        $value = sanitize_text_field($this->scalar_to_string($raw_value));
        return $value === '' ? '' : $value;
    }

    private function request_action(): string {
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Only reads the public AJAX action name to identify the request type.
        if (!array_key_exists('action', $_REQUEST)) {
            return '';
        }
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Only reads the public AJAX action name; value is unslashed here and sanitized immediately below.
        $raw_value = wp_unslash($_REQUEST['action']);
        $value = sanitize_key($this->scalar_to_string($raw_value));
        return $value === '' ? '' : $value;
    }

    /**
     * Convert request/server/cookie values to a safe string before passing them to
     * WordPress sanitizers. Some hosts/plugins can populate superglobals with null
     * or array values, which would otherwise trigger PHP 8.1+ deprecation notices
     * inside WordPress core helper functions.
     *
     * @param mixed $value Raw value.
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

    private function is_frontend_ajax(): bool { return defined('DOING_AJAX') && DOING_AJAX && $this->request_action() === 'mhuam_ping'; }
    private function clamp(string $value, int $length): string { return mb_substr(wp_strip_all_tags($value), 0, $length); }
}
