<?php
/**
 * MH User Activity Monitor
 *
 * @package MHUAM
 * @license GPL-2.0-or-later
 */

namespace MHUAM;

if (!defined('ABSPATH')) { exit; }

final class Settings {
    public const OPTION = 'mhuam_settings';
    private ?array $cachedSettings = null;

    public function init(): void {
        add_action('admin_init', [$this, 'register']);
    }

    public static function defaults(): array {
        return [
            'online_seconds' => 300,
            'privacy_mode' => 'standard',
            'retention_seconds' => 900,
            'ip_mode' => 'anonymized',
            'show_ip_to' => 'manage_options',
            'hide_admins' => 0,
            'hide_own_ip' => 0,
            'ignored_ips' => '',
            'ignored_urls' => "/wp-json/\n/wp-cron.php\n/feed/",
            'ignored_user_agents' => '',
            'track_referrer' => 1,
            'track_user_agent' => 1,
            'track_cart' => 1,
            'cart_mode' => 'details',
            'track_bots' => 1,
            'hide_known_search_bots' => 0,
            'max_sessions' => 250,
            'bot_warning_threshold_orange' => 20,
            'bot_warning_threshold_red' => 50,
            'live_refresh_seconds' => 10,
            'frontend_ping_seconds' => 60,
            'frontend_ping_enabled' => 1,
            'frontend_ping_woocommerce_only' => 0,
            'track_page_history' => 1,
            'privacy_help_enabled' => 1,
            'trust_proxy_headers' => 0,
            'trusted_proxy_ips' => '',
            'delete_data_on_uninstall' => 0,
        ];
    }

    public function get(): array {
        if ($this->cachedSettings !== null) { return $this->cachedSettings; }
        $raw = get_option(self::OPTION, []);
        $this->cachedSettings = wp_parse_args(is_array($raw) ? $raw : [], self::defaults());
        return $this->cachedSettings;
    }

    public function reset_cache(): void { $this->cachedSettings = null; }

    private static function bounded_int($value, int $min, int $max, int $default): int {
        $value = absint($value);
        if ($value <= 0 && $min > 0) {
            $value = $default;
        }
        return max($min, min($max, $value));
    }

    private static function select_value($value, array $allowed, string $default): string {
        $value = sanitize_key((string)$value);
        return in_array($value, $allowed, true) ? $value : $default;
    }

    private static function limited_textarea($value, int $max_length): string {
        if (!is_scalar($value)) {
            $value = '';
        }
        $value = sanitize_textarea_field((string) $value);
        return mb_substr($value, 0, $max_length);
    }

    public function register(): void {
        register_setting('mhuam_settings_group', self::OPTION, [
            'type' => 'array',
            'sanitize_callback' => [$this, 'sanitize'],
            'default' => self::defaults(),
        ]);
    }

    public function sanitize($input): array {
        $input = is_array($input) ? $input : [];
        $previous = $this->get();
        $d = self::defaults();
        $out = [];
        $out['online_seconds'] = self::bounded_int($input['online_seconds'] ?? $d['online_seconds'], 60, 3600, (int)$d['online_seconds']);
        $out['retention_seconds'] = self::bounded_int($input['retention_seconds'] ?? $d['retention_seconds'], $out['online_seconds'], 86400, (int)$d['retention_seconds']);
        $out['privacy_mode'] = self::select_value($input['privacy_mode'] ?? $d['privacy_mode'], ['standard','data_saving','strict'], (string)$d['privacy_mode']);
        $out['ip_mode'] = self::select_value($input['ip_mode'] ?? $d['ip_mode'], ['full','anonymized','hash'], (string)$d['ip_mode']);
        $out['cart_mode'] = self::select_value($input['cart_mode'] ?? $d['cart_mode'], ['count','summary','details'], (string)$d['cart_mode']);
        $show_ip_to = isset($input['show_ip_to']) ? (string) $input['show_ip_to'] : (string) $d['show_ip_to'];
        $out['show_ip_to'] = self::select_value($show_ip_to, ['manage_options','list_users'], 'manage_options');
        foreach (['hide_admins','hide_own_ip','track_referrer','track_user_agent','track_cart','track_bots','hide_known_search_bots','track_page_history','privacy_help_enabled','trust_proxy_headers','frontend_ping_enabled','frontend_ping_woocommerce_only','delete_data_on_uninstall'] as $key) {
            $out[$key] = !empty($input[$key]) ? 1 : 0;
        }
        foreach (['ignored_ips','ignored_urls','ignored_user_agents','trusted_proxy_ips'] as $key) {
            $out[$key] = self::limited_textarea((string)($input[$key] ?? ''), 5000);
        }
        if (!empty($out['trust_proxy_headers'])) {
            if (trim((string)$out['trusted_proxy_ips']) === '') {
                $out['trust_proxy_headers'] = 0;
                add_settings_error(
                    self::OPTION,
                    'mhuam_proxy_headers_without_trusted_ips',
                    __('Proxy-Header wurden nicht aktiviert, weil keine vertrauenswürdigen Proxy-IP-Adressen eingetragen wurden. Tragen Sie zuerst die IP-Adressen Ihres Reverse Proxys oder CDN ein und speichern Sie die Einstellung anschließend erneut.', 'mh-user-activity-monitor'),
                    'error'
                );
            } else {
                $invalid_proxy_rules = self::invalid_ip_rules((string)$out['trusted_proxy_ips']);
                if (!empty($invalid_proxy_rules)) {
                    $out['trust_proxy_headers'] = 0;
                    add_settings_error(
                        self::OPTION,
                        'mhuam_invalid_proxy_ip_rules',
                        sprintf(
                            /* translators: %s: comma-separated list of invalid proxy IP rules. */
                            __('Proxy-Header wurden nicht aktiviert, weil folgende Proxy-IP-Regeln ungültig sind: %s', 'mh-user-activity-monitor'),
                            implode(', ', $invalid_proxy_rules)
                        ),
                        'error'
                    );
                }
            }
        }
        $out['max_sessions'] = self::bounded_int($input['max_sessions'] ?? $d['max_sessions'], 25, 5000, (int)$d['max_sessions']);
        $out['bot_warning_threshold_orange'] = self::bounded_int($input['bot_warning_threshold_orange'] ?? $d['bot_warning_threshold_orange'], 3, 1000, (int)$d['bot_warning_threshold_orange']);
        $out['bot_warning_threshold_red'] = self::bounded_int($input['bot_warning_threshold_red'] ?? $d['bot_warning_threshold_red'], $out['bot_warning_threshold_orange'], 5000, (int)$d['bot_warning_threshold_red']);
        $out['live_refresh_seconds'] = self::bounded_int($input['live_refresh_seconds'] ?? $d['live_refresh_seconds'], 5, 120, (int)$d['live_refresh_seconds']);
        $out['frontend_ping_seconds'] = self::bounded_int($input['frontend_ping_seconds'] ?? $d['frontend_ping_seconds'], 30, 600, (int)$d['frontend_ping_seconds']);
        if (($previous['cart_mode'] ?? $d['cart_mode']) === 'details' && $out['cart_mode'] !== 'details') {
            DB::clear_stored_cart_details();
        }
        if (($previous['privacy_mode'] ?? $d['privacy_mode']) !== $out['privacy_mode'] && in_array($out['privacy_mode'], ['data_saving','strict'], true)) {
            DB::reduce_stored_data_for_privacy_mode($out['privacy_mode']);
        }

        delete_transient('mhuam_stats_cache');
        $this->cachedSettings = null;
        return $out;
    }

    public function can_view(): bool { return current_user_can('manage_options') || current_user_can('list_users'); }
    public function can_manage(): bool { return current_user_can('manage_options'); }
    public function can_view_ip(): bool { $s = $this->get(); $capability = isset($s['show_ip_to']) ? (string) $s['show_ip_to'] : 'manage_options'; return current_user_can($capability); }

    public static function lines(string $value): array {
        $items = preg_split('/\r\n|\r|\n/', $value);
        return array_values(array_filter(array_map('trim', is_array($items) ? $items : []), static fn($v) => $v !== ''));
    }

    public static function wildcard_match(string $pattern, string $value): bool {
        $pattern = trim($pattern);
        if ($pattern === '') { return false; }
        if (strpos($pattern, '*') !== false) {
            return (bool)preg_match('/^' . str_replace('\\*', '.*', preg_quote($pattern, '/')) . '$/i', $value);
        }
        return stripos($value, $pattern) !== false;
    }


    public static function invalid_ip_rules(string $rules): array {
        $invalid = [];
        foreach (self::lines($rules) as $rule) {
            if (!self::is_valid_ip_rule($rule)) {
                $invalid[] = $rule;
            }
        }
        return $invalid;
    }

    public static function is_valid_ip_rule(string $rule): bool {
        $rule = trim($rule);
        if ($rule === '') { return false; }
        if (strpos($rule, '/') !== false) {
            [$subnet, $bits] = array_pad(explode('/', $rule, 2), 2, null);
            $subnet = trim((string)$subnet);
            if (!filter_var($subnet, FILTER_VALIDATE_IP) || !is_numeric($bits)) { return false; }
            $max_bits = filter_var($subnet, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) ? 32 : 128;
            $bits = (int)$bits;
            return $bits >= 0 && $bits <= $max_bits;
        }
        if (filter_var($rule, FILTER_VALIDATE_IP)) { return true; }
        return self::is_valid_ipv4_wildcard($rule);
    }

    private static function is_valid_ipv4_wildcard(string $rule): bool {
        if (strpos($rule, '*') === false) { return false; }
        $parts = explode('.', $rule);
        if (count($parts) !== 4) { return false; }
        foreach ($parts as $part) {
            if ($part === '*') { continue; }
            if ($part === '' || !ctype_digit($part)) { return false; }
            $number = (int)$part;
            if ((string)$number !== $part || $number < 0 || $number > 255) { return false; }
        }
        return true;
    }

    public static function ip_rule_match(string $rule, string $ip): bool {
        $rule = trim($rule);
        $ip = trim($ip);
        if ($rule === '' || !filter_var($ip, FILTER_VALIDATE_IP)) { return false; }
        if (strpos($rule, '/') !== false) { return self::ip_in_cidr($ip, $rule); }
        if (filter_var($rule, FILTER_VALIDATE_IP)) { return hash_equals(strtolower($rule), strtolower($ip)); }
        if (strpos($rule, '*') !== false) {
            return (bool)preg_match('/^' . str_replace('\\*', '.*', preg_quote($rule, '/')) . '$/i', $ip);
        }
        return false;
    }

    private static function ip_in_cidr(string $ip, string $cidr): bool {
        [$subnet, $bits] = array_pad(explode('/', $cidr, 2), 2, null);
        $subnet = trim((string)$subnet);
        $bits = is_numeric($bits) ? (int)$bits : -1;
        $ip_bin = @inet_pton($ip);
        $subnet_bin = @inet_pton($subnet);
        if ($ip_bin === false || $subnet_bin === false || strlen($ip_bin) !== strlen($subnet_bin)) { return false; }
        $max_bits = strlen($ip_bin) * 8;
        if ($bits < 0 || $bits > $max_bits) { return false; }
        $full_bytes = intdiv($bits, 8);
        $remaining_bits = $bits % 8;
        if ($full_bytes > 0 && substr($ip_bin, 0, $full_bytes) !== substr($subnet_bin, 0, $full_bytes)) { return false; }
        if ($remaining_bits === 0) { return true; }
        $mask = (0xff << (8 - $remaining_bits)) & 0xff;
        return (ord($ip_bin[$full_bytes]) & $mask) === (ord($subnet_bin[$full_bytes]) & $mask);
    }
}
