<?php
/**
 * Uninstall cleanup for MH User Activity Monitor.
 *
 * @package MHUAM
 * @license GPL-2.0-or-later
 */

if (!defined('WP_UNINSTALL_PLUGIN')) { exit; }

$mhuam_settings = get_option('mhuam_settings', []);
if (is_array($mhuam_settings) && !empty($mhuam_settings['delete_data_on_uninstall'])) {
    global $wpdb;
    // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.DirectDatabaseQuery.SchemaChange -- Intentional uninstall cleanup for the plugin custom table.
    $wpdb->query($wpdb->prepare('DROP TABLE IF EXISTS %i', $wpdb->prefix . 'mhuam_sessions'));
    delete_option('mhuam_settings');
    delete_option('mhuam_db_version');
}
