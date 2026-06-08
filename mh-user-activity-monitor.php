<?php
/**
 * Plugin Name: MH User Activity Monitor
 * Description: MH User Activity Monitor zeigt in Echtzeit, welche Benutzer, Besucher, WooCommerce-Kunden und Bots gerade auf Ihrer WordPress-Website aktiv sind. Das Plugin hilft Administratoren, ungewöhnliche Aktivitäten, Warenkorb-Sitzungen, Bot-Zugriffe und verdächtige Anfragen schneller zu erkennen – mit Datenschutzoptionen wie IP-Anonymisierung, Datensparmodus und automatischer Bereinigung.
 * Version: 1.62
 * Requires at least: 6.2
 * Tested up to: 7.0
 * Requires PHP: 7.4
 * Author: Mailhilfe.de
 * Author URI: https://www.mailhilfe.de
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: mh-user-activity-monitor
 * Domain Path: /languages
 */

if (!defined('ABSPATH')) { exit; }

define('MHUAM_VERSION', '1.62');
define('MHUAM_FILE', __FILE__);
define('MHUAM_PATH', plugin_dir_path(__FILE__));
define('MHUAM_URL', plugin_dir_url(__FILE__));
define('MHUAM_BASENAME', plugin_basename(__FILE__));

require_once MHUAM_PATH . 'includes/Autoloader.php';
MHUAM\Autoloader::register();

register_activation_hook(__FILE__, ['MHUAM\\Plugin', 'activate']);
register_deactivation_hook(__FILE__, ['MHUAM\\Plugin', 'deactivate']);

add_action('plugins_loaded', static function () {
    MHUAM\Plugin::instance()->init();
});
