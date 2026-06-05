<?php
/**
 * MH User Activity Monitor
 *
 * @package MHUAM
 * @license GPL-2.0-or-later
 */

namespace MHUAM;

if (!defined('ABSPATH')) { exit; }

final class Plugin {
    private static ?self $instance = null;
    private Settings $settings;
    private DB $db;
    private BotDetector $botDetector;
    private Tracker $tracker;
    private Admin $admin;

    public static function instance(): self {
        if (!self::$instance) { self::$instance = new self(); }
        return self::$instance;
    }

    private function __construct() {
        $this->settings = new Settings();
        $this->db = new DB($this->settings);
        $this->botDetector = new BotDetector($this->settings);
        $this->tracker = new Tracker($this->settings, $this->db, $this->botDetector);
        $this->admin = new Admin($this->settings, $this->db);
    }

    public function init(): void {
        DB::maybe_upgrade();
        self::cleanup_legacy_cron_hooks();
        $this->settings->init();
        $this->tracker->init();
        $this->admin->init();
        add_filter('cron_schedules', [$this, 'cron_schedules']);
        $this->ensure_cron();
        add_action('mhuam_five_minute_cleanup', [$this, 'cron_cleanup']);
        add_action('mhuam_hourly_cleanup', [$this, 'cron_cleanup']);
    }

    public static function activate(): void {
        DB::create_table();
        add_option(Settings::OPTION, Settings::defaults(), '', false);
        update_option(DB::DB_VERSION_OPTION, DB::DB_VERSION, false);
        self::cleanup_legacy_cron_hooks();
        if (!wp_next_scheduled('mhuam_hourly_cleanup')) {
            wp_schedule_event(time() + HOUR_IN_SECONDS, 'hourly', 'mhuam_hourly_cleanup');
        }
    }

    public static function deactivate(): void {
        wp_clear_scheduled_hook('mhuam_five_minute_cleanup');
        wp_clear_scheduled_hook('mhuam_hourly_cleanup');
        self::cleanup_legacy_cron_hooks();
    }


    private static function cleanup_legacy_cron_hooks(): void {
        foreach ([
            'mhuam_cleanup_sessions',
            'mhuam_cleanup',
            'mhuam_session_cleanup',
            'mhuam_cron_cleanup',
        ] as $hook) {
            wp_clear_scheduled_hook($hook);
        }
    }

    public function cron_schedules(array $schedules): array {
        if (!isset($schedules['mhuam_five_minutes'])) {
            $schedules['mhuam_five_minutes'] = [
                'interval' => 5 * MINUTE_IN_SECONDS,
                'display' => __('Every five minutes', 'mh-user-activity-monitor'),
            ];
        }
        return $schedules;
    }

    private function ensure_cron(): void {
        if (!wp_next_scheduled('mhuam_five_minute_cleanup')) {
            wp_schedule_event(time() + 5 * MINUTE_IN_SECONDS, 'mhuam_five_minutes', 'mhuam_five_minute_cleanup');
        }
        self::cleanup_legacy_cron_hooks();
        if (!wp_next_scheduled('mhuam_hourly_cleanup')) {
            wp_schedule_event(time() + HOUR_IN_SECONDS, 'hourly', 'mhuam_hourly_cleanup');
        }
    }

    public function cron_cleanup(): void {
        $this->db->cleanup();
        $this->db->enforce_max_sessions();
        $this->db->clear_stats_cache();
    }
}
