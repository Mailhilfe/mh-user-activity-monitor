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
            'KI-Assistent / Live-Abruf' => [
                'chatgpt-user',
                'claude-user',
                'claude-searchbot',
                'perplexity-user',
                'mistralai-user',
                'copilotbot',
            ],
            'KI-Suchmaschine' => [
                'oai-searchbot',
                'searchgpt',
                'chatgpt-search',
                'perplexitybot',
                'perplexity-ai',
                'youbot',
                'youbot/',
                'applebot-extended',
                'google-extended',
            ],
            'KI-Training / Datensammlung' => [
                'gptbot',
                'oai-adsbot',
                'claudebot',
                'anthropic-ai',
                'meta-externalagent',
                'meta-externalfetcher',
                'amazonbot',
                'ccbot',
                'bytespider',
                'cohere-ai',
                'diffbot',
                'img2dataset',
                'omgilibot',
                'omgili',
            ],
            'KI-Crawler' => [
                'openai',
                'anthropic',
                'claude',
                'perplexity',
                'cohere',
                'mistral',
                'ai2bot',
                'ai2bot-dolma',
            ],
            'Suchmaschine' => ['googlebot','googleother','google-inspectiontool','bingbot','bingpreview','duckduckbot','yandexbot','baiduspider','applebot','qwantbot','petalbot','seznambot','sogou','exabot','ia_archiver'],
            'SEO-Tool' => ['ahrefsbot','semrushbot','sistrix','seobility','mj12bot','dotbot','siteauditbot','rogerbot','blexbot','serpstatbot','megaindex'],
            'Social Preview' => ['facebookexternalhit','facebookcatalog','twitterbot','linkedinbot','pinterestbot','slackbot','discordbot','telegrambot','whatsapp','skypeuripreview','vkshare'],
            'Monitoring' => ['uptimerobot','pingdom','statuscake','better uptime','betterstack','newrelic','datadog','site24x7','freshping','healthchecks'],
            'Scanner' => ['censys','shodan','nikto','acunetix','sqlmap','nuclei','nessus','masscan','zgrab','curl','python-requests','go-http-client','wget','libwww-perl','java/','headlesschrome'],
        ];
        /**
         * Filters the bot detection rules.
         *
         * @param array<string,array<int,string>> $rules Rules grouped by category label.
         */
        $rules = apply_filters('mhuam_bot_detection_rules', $rules);
        $rules = is_array($rules) ? $rules : [];
        $is_bot = false; $category = ''; $name = '';
        foreach ($rules as $cat => $needles) {
            if (!is_array($needles)) {
                continue;
            }
            foreach ($needles as $needle) {
                $needle = is_scalar($needle) ? (string)$needle : '';
                if ($needle !== '' && strpos($ua, $needle) !== false) {
                    $is_bot = true; $category = is_scalar($cat) ? (string)$cat : 'Bot/Crawler'; $name = $needle; break 2;
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
            'REST-API-Benutzerabfrage' => ['/wp-json/wp/v2/users', 'rest_route=/wp/v2/users'],
            'Pfad-Traversal-Muster' => ['../', '..\\', '%2e%2e%2f', '%252e%252e%252f'],
            'Remote-File-Inclusion-Muster' => ['=http://', '=https://', '://pastebin.com/', '://raw.githubusercontent.com/'],
            'Script-Injection-Muster' => ['<script','%3cscript','javascript:','onerror=','onload='],
            'SQL-Injection-Muster' => [' union select ',' concat(','information_schema','sleep(','benchmark(',' or 1=1', "' or '1'='1", '" or "1"="1'],
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
        $checks = is_array($checks) ? $checks : [];
        $flags = [];
        foreach ($checks as $label => $needles) {
            if ($label === 'Sehr kurzer oder leerer User-Agent') {
                if (strlen(trim($user_agent)) < 8) { $flags[] = $label; }
                continue;
            }
            if (!is_array($needles)) {
                continue;
            }
            foreach ($needles as $needle) {
                $needle = is_scalar($needle) ? (string)$needle : '';
                if ($needle !== '' && strpos($s, $needle) !== false) { $flags[] = $label; break; }
            }
        }
        return array_values(array_unique($flags));
    }

    private function risk(string $category, array $flags, int $hits): string {
        $s = $this->settings->get();
        if (!empty($flags) || $category === 'Scanner' || $hits >= (int)$s['bot_warning_threshold_red']) { return 'red'; }
        if (strpos($category, 'KI-') === 0 || in_array($category, ['SEO-Tool','Monitoring','Unbekannter Bot'], true) || $hits >= (int)$s['bot_warning_threshold_orange']) { return 'orange'; }
        if ($category !== '') { return 'yellow'; }
        return 'green';
    }

    private function clamp(string $value, int $length): string { return mb_substr(wp_strip_all_tags($value), 0, $length); }
}
