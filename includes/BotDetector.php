<?php
/**
 * MH User Activity Monitor
 *
 * @package MHUAM
 * @license GPL-2.0-or-later
 */

namespace MHUAM;

if (!defined('ABSPATH')) { exit; }

final class BotDetector {
    private Settings $settings;
    public function __construct(Settings $settings) { $this->settings = $settings; }

    public function analyze(string $user_agent, string $raw_uri, int $hits): array {
        $ua = strtolower($user_agent);
        $rules = [
            'Suchmaschine' => ['googlebot','bingbot','duckduckbot','yandexbot','baiduspider','applebot','qwantbot'],
            'SEO-Tool' => ['ahrefsbot','semrushbot','sistrix','seobility','mj12bot','dotbot','siteauditbot'],
            'KI-Crawler' => ['gptbot','chatgpt-user','claudebot','anthropic-ai','perplexitybot','ccbot','bytespider'],
            'Social Preview' => ['facebookexternalhit','twitterbot','linkedinbot','slackbot','discordbot','telegrambot','whatsapp'],
            'Monitoring' => ['uptimerobot','pingdom','statuscake','better uptime','newrelic'],
            'Scanner' => ['censys','shodan','nikto','acunetix','sqlmap','nuclei','nessus','masscan','zgrab','curl','python-requests','go-http-client','wget'],
        ];
        $is_bot = false; $category = ''; $name = '';
        foreach ($rules as $cat => $needles) {
            foreach ($needles as $needle) {
                if ($needle !== '' && strpos($ua, $needle) !== false) {
                    $is_bot = true; $category = $cat; $name = $needle; break 2;
                }
            }
        }
        if (!$is_bot && preg_match('/bot|crawler|spider|scrape|fetch|preview|scan/i', $user_agent)) {
            $is_bot = true; $category = 'Unbekannter Bot'; $name = 'Bot/Crawler';
        }
        $flags = $this->detect_attack_flags($raw_uri, $user_agent);
        $risk = $this->risk($category, $flags, $hits);
        return [
            'is_bot' => $is_bot,
            'bot_name' => $is_bot ? $this->clamp($name ?: 'Bot/Crawler', 120) : '',
            'bot_category' => $is_bot ? $this->clamp($category ?: 'Bot/Crawler', 80) : '',
            'bot_risk' => $risk,
            'attack_flags' => $flags,
        ];
    }

    public function detect_attack_flags(string $raw_uri, string $user_agent): array {
        $decoded = $raw_uri . ' ' . $user_agent;
        for ($i = 0; $i < 3; $i++) {
            $next = rawurldecode($decoded);
            if ($next === $decoded) { break; }
            $decoded = $next;
        }
        $s = strtolower($decoded);
        $checks = [
            'Login-Zugriff' => ['wp-login.php'],
            'XML-RPC-Zugriff' => ['xmlrpc.php'],
            'Konfigurationsscan' => ['.env','wp-config.php','.git/config','config.php'],
            'Datenbank-Tool' => ['phpmyadmin','adminer.php','mysqladmin'],
            'Backup- oder Dump-Datei' => ['.sql','.bak','.zip','.tar.gz','.old'],
            'Plugin-/Theme-Scan' => ['/wp-content/plugins/','/wp-content/themes/'],
            'Script-Injection-Muster' => ['<script','%3cscript','javascript:','onerror=','onload='],
            'SQL-Injection-Muster' => [' union select ',' concat(','information_schema','sleep(','benchmark(',' or 1=1'],
            'Log4Shell-Muster' => ['${jndi:', 'jndi:ldap', 'jndi:rmi', 'jndi:dns'],
            'PHP-Wrapper-Muster' => ['php://', 'data://', 'phar://', 'zip://', 'expect://', 'input://'],
            'Sehr kurzer oder leerer User-Agent' => [],
        ];
        /**
         * Filtert die Angriffsmuster des MH User Activity Monitor.
         *
         * @param array<string,array<int,string>> $checks Musterliste nach Anzeigename.
         */
        $checks = apply_filters('mhuam_attack_checks', $checks);
        $flags = [];
        foreach ($checks as $label => $needles) {
            if ($label === 'Sehr kurzer oder leerer User-Agent') {
                if (strlen(trim($user_agent)) < 8) { $flags[] = $label; }
                continue;
            }
            foreach ($needles as $needle) {
                if (strpos($s, $needle) !== false) { $flags[] = $label; break; }
            }
        }
        return array_values(array_unique($flags));
    }

    private function risk(string $category, array $flags, int $hits): string {
        $s = $this->settings->get();
        if (!empty($flags) || $category === 'Scanner' || $hits >= (int)$s['bot_warning_threshold_red']) { return 'red'; }
        if (in_array($category, ['SEO-Tool','KI-Crawler','Monitoring','Unbekannter Bot'], true) || $hits >= (int)$s['bot_warning_threshold_orange']) { return 'orange'; }
        if ($category !== '') { return 'yellow'; }
        return 'green';
    }

    private function clamp(string $value, int $length): string { return mb_substr(wp_strip_all_tags($value), 0, $length); }
}
