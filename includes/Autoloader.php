<?php
/**
 * MH User Activity Monitor
 *
 * @package MHUAM
 * @license GPL-2.0-or-later
 */

namespace MHUAM;

if (!defined('ABSPATH')) { exit; }

final class Autoloader {
    public static function register(): void {
        spl_autoload_register([__CLASS__, 'autoload']);
    }

    public static function autoload(string $class): void {
        $prefix = __NAMESPACE__ . '\\';
        if (strpos($class, $prefix) !== 0) { return; }
        $relative = substr($class, strlen($prefix));
        $file = MHUAM_PATH . 'includes/' . str_replace('\\', '/', $relative) . '.php';
        if (is_readable($file)) { require_once $file; }
    }
}
