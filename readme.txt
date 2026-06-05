=== MH User Activity Monitor ===
Contributors: schaum, mailhilfe
Tags: users, activity, woocommerce, bots, monitoring
Requires at least: 6.2
Tested up to: 7.0
Requires PHP: 7.4
Stable tag: 1.53
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

MH User Activity Monitor shows active visitors, bots and WooCommerce cart activity in the WordPress admin area.

== Description ==

MH User Activity Monitor helps site owners monitor current user activity in the WordPress admin area. It displays logged-in users, WooCommerce customers, anonymous visitors and detected bots in a live overview.

The plugin uses its own database table, a structured class-based architecture, external CSS and JavaScript files, scheduled cleanup tasks, configurable privacy options, improved bot detection and basic attack-pattern detection.

Main features include:

* Live overview with dashboard cards and filters.
* Active visitor table with status, visitor type, current page, referrer, IP display mode and user agent.
* WooCommerce cart summary for active sessions when WooCommerce data is available, with configurable storage modes for item count, item count plus total, or product details.
* Bot detection with categories and visual risk indicators.
* Detection of common suspicious request patterns, such as XML-RPC, login probes, environment file probes and PHP wrapper probes.
* Short page history per visitor.
* Configurable IP anonymization, with anonymized IPs as the default for new installations.
* Privacy modes: Standard, Data-saving and Strict.
* Stored URLs and referrers are saved without query parameters. User-Agent, URL and referrer values are length-limited before storage.
* Ignore lists for IP addresses, URLs and user agents, including support for exact IPs, IPv4 wildcards and IPv4/IPv6 CIDR ranges.
* Configurable frontend ping interval.
* Frontend ping can be disabled completely or restricted to WooCommerce pages.
* Trusted proxy header support with server-side validation of allowed proxy IP rules.
* Automatic cleanup through WordPress Cron.
* Multilingual help page inside the plugin.

The plugin is intended for short-term operational monitoring. Site owners should review local privacy requirements before enabling features that display IP addresses, user agents, referrers, page history or WooCommerce cart information.

== Requirements ==

* WordPress 6.2 or newer.
* PHP 7.4 or newer.
* Tested up to WordPress 7.0.
* WooCommerce is optional and only required for WooCommerce cart monitoring.

== Installation ==

1. Upload the plugin folder to the `/wp-content/plugins/` directory or install the ZIP file through the WordPress admin area.
2. Activate the plugin through the Plugins screen in WordPress.
3. Open `MH User Activity Monitor` in the WordPress admin menu.
4. Review the settings before using the plugin on a production site.
5. Configure IP anonymization, retention, ignore lists and WooCommerce-related options according to your privacy requirements.

== Frequently Asked Questions ==

= Does the plugin store visitor data permanently? =

No. The plugin is designed for short-term activity monitoring. Cleanup is handled by WordPress Cron and retention-related settings.

= Does the plugin support WooCommerce? =

Yes. If WooCommerce is active, the plugin can show cart information for active sessions when the WooCommerce session data is available.

= Can IP addresses be anonymized? =

Yes. The settings page includes IP display and anonymization options. New installations use anonymized IPs by default. The Data-saving and Strict privacy modes force raw IP storage off.

= What does the privacy mode do? =

Standard uses the explicitly enabled tracking options but still removes query parameters from stored URLs and referrers. Data-saving stores IPs as hashes, removes stored user agents, stores referrers only as domains and reduces cart storage to item counts. Strict disables frontend ping effectively and does not store referrers, user agents, raw IPs or WooCommerce cart details.

= Can bots be detected? =

Yes. The plugin includes user-agent based bot detection and basic attack-pattern detection. It is not a firewall and should not replace a dedicated security plugin.


= Can frontend AJAX pings be disabled? =

Yes. The settings page includes an option to disable frontend ping completely. In that mode, only normal page views are recorded and the regular frontend AJAX ping script is not loaded.

= Which IP rule formats are supported? =

Ignored IP addresses and trusted proxy IP addresses support exact IP addresses, IPv4 wildcard rules such as `192.168.178.*`, and IPv4/IPv6 CIDR ranges such as `10.0.0.0/8` or `2001:db8::/32`.

= Can WooCommerce cart data be reduced? =

Yes. The cart mode can store only the item count, item count plus total, or detailed product information. The data-minimizing default is item count plus total.

= Is the plugin GDPR compliant? =

The plugin provides privacy-related settings, but compliance depends on the site configuration, legal basis, local privacy notices and operational use. Site owners should review their privacy policy and consult qualified advice when needed.

== Changelog ==

= 1.53 =
* Updated the WordPress tested-up-to metadata to 7.0 in the plugin header and readme.

= 1.52 =
* Updated POT, PO and MO language files for the current plugin strings.
* Added translations for dismissible notice text and privacy mode related labels.

= 1.50 =
* Added dismiss links for the object-cache recommendation and privacy notice. Each dismissed notice is hidden per administrator for four weeks.

= 1.49 =
* Improved admin display: WooCommerce cart cards, filters, columns, detail blocks and cart settings are hidden when WooCommerce is not installed or active.


= 1.48 =
* Fix: Hardened request, cookie and server value handling to avoid PHP 8.1+ deprecation notices when unexpected null values are present.

= 1.42 =
* Fix: Frontend AJAX pings are no longer classified as Adminbereich.
* Fix: Frontend script now sends the public page type so the current page column shows the actual visitor context.


= 1.41 =
* Reworked remaining database calls to use wpdb::prepare() identifier placeholders (%i) instead of concatenated plugin table identifiers.
* Updated minimum WordPress requirement to 6.2 because identifier placeholders are used for WordPress.org SQL review compliance.

= 1.40 =
* Refactored legacy database migration to avoid a raw INSERT ... SELECT query and use prepared SELECT plus wpdb insert helpers.
* Replaced remaining unprepared plugin-table cleanup/count queries in DB.php with prepared placeholder queries where applicable.
* Kept SQL identifier handling restricted to plugin-generated table names and hard-coded column whitelists.

= 1.38 =
* Privacy: Added a privacy mode setting with Standard, Data-saving and Strict modes.
* Privacy: Stored URLs and referrers now have query parameters removed before saving.
* Privacy: User-Agent, URL and referrer values are strictly length-limited before storage.
* Security: Settings validation was hardened with explicit allowlists and min/max ranges.
* Privacy: The uninstall cleanup is now controlled by an explicit delete-data-on-uninstall setting.
* Privacy: Switching to Data-saving or Strict now reduces already stored raw IP, user-agent and cart-detail data where applicable.

= 1.37 =
* Security: Centralized capability checks for admin pages, admin-post actions and AJAX handlers.
* Security: Frontend ping rate limits now return a JSON error with HTTP 429 instead of a successful response.
* Security: Added request helper methods for admin AJAX POST arguments and reduced direct superglobal handling.
* Privacy: Stored WooCommerce cart details are cleared when switching from product-detail mode to a more data-saving cart mode.
* Hardening: Reviewed and tightened escaping for visitor-controlled admin output such as URLs, user agents, referrers and cart data.
* Fix: Synchronized plugin version constant with the plugin header.

= 1.36 =
* Code quality: Removed global PHPCS disable comments from database files.
* Code quality: Added targeted SQL-identifier PHPCS ignores only where unavoidable.
* Code quality: Expanded documentation for the internal SQL identifier quoting helper.
* Code quality: Limited uninstall database PHPCS exception to the intentional custom table drop.

= 1.35 =
* Review fixes: Added the WordPress.org owner username to the contributors list.
* Security: Failed frontend ping nonce checks now return wp_send_json_error() with HTTP 403 instead of a success response.
* Security: Refactored session upsert code to use wpdb insert/update helpers and prepared values instead of a dynamically assembled ON DUPLICATE KEY UPDATE statement.

= 1.34 =
* Added WordPress and PHP requirements to the main plugin header.
* Added a requirements section to the readme.

= 1.33 =
* I18n: Updated the POT template and all included PO/MO language files for the functions added up to version 1.32.
* Help: Updated the integrated multilingual help documentation with notes about anonymized IP defaults, CIDR rules, proxy validation, frontend ping control, admin refresh behavior and WooCommerce cart storage modes.
* Docs: Expanded the readme with current privacy, proxy, frontend ping and WooCommerce cart mode information.

= 1.32 =
* Maintenance: Updated the internal database schema version to 1.32.
* Reliability: Legacy cleanup cron hooks are cleared during activation and upgrade handling.
* Security: Ignored IP rules now support exact IP addresses, IPv4 wildcards and IPv4/IPv6 CIDR ranges.
* Security: Trusted proxy IP rules are validated server-side before proxy headers can be enabled.
* Privacy: Added an option to completely disable frontend AJAX pings.
* Performance: Admin live refresh now pauses while the browser tab is inactive.

= 1.31 =
* Security: Trusted proxy IPs now support exact IP addresses, wildcard IPv4 patterns and CIDR ranges for IPv4 and IPv6.
* Privacy: The default IP mode for new installations is now anonymized.
* Performance: Added pagination to the admin session table with 100 sessions per page.
* Privacy: Added a WooCommerce cart storage mode for count-only, count-and-total, or detailed product storage.

= 1.30 =
* Fix: Verified and cleaned up the get_stats() SQL placeholder structure for reliable statistics queries.
* Fix: The track_bots setting is now fully respected. When bot tracking is disabled, bot analysis and bot hit transients are skipped.
* Privacy: Raw IP storage is now controlled only by the IP mode setting and no longer depends on the current admin user's display capability.
* Reliability: Deactivation now uses wp_clear_scheduled_hook() to remove all scheduled cleanup events reliably.

= 1.29 =
* Performance: Removed synchronous random cleanup from session upserts. Cleanup and max-session enforcement now run through WP-Cron only.
* Security: Proxy header support can no longer be enabled without trusted proxy IP addresses. The setting is rejected server-side and remains disabled until proxy IPs are configured.

= 1.28 =
* Security: Added admin warnings for proxy header configuration without trusted proxy IP addresses.
* Security: Added an admin notice for HTTP installations where the session cookie cannot use the Secure flag.
* Fix: Removed duplicate cron schedule registration.
* Fix: Corrected max-session enforcement so identical timestamps do not remove too many sessions.
* Cleanup: Removed an unused legacy cookie constant.
* Performance: Added a short cache for statistics used by dashboard cards, the admin bar and live refresh.
* Performance: Added a recommendation notice for persistent object cache on high-traffic installations.

= 1.24 =
* Fixed a missing settings fallback for the IP visibility option to avoid PHP warnings after updates.
* Added translator comments for strings with placeholders.
* Changed multiple placeholders to ordered placeholders.
* Rewrote the readme description in standard English for WordPress.org scanning.

= 1.22 =
* Changed the text domain to match the plugin slug.
* Removed development files from the WordPress.org release package.

= 1.21 =
* Removed the Plugin URI from the plugin header.

= 1.20 =
* Kept atomic tracking upserts without a session SELECT before writing.
* Added configurable frontend ping interval and optional WooCommerce-only frontend pings.
* Added a five-minute cleanup schedule and probabilistic cleanup after new inserts.
* Added Log4Shell and PHP wrapper patterns to suspicious request detection.
* Added the `mhuam_attack_checks` filter.
* Improved status dots for screen readers.
* Added an admin setting for deleting plugin data on uninstall.

= 1.11 =
* Added GPL license headers.
* Added a full GPLv2 license file.
* Added license notices for PHP, CSS and JavaScript files.

= 1.10 =
* Added an extended in-plugin help guide.
* Updated guide texts for included plugin languages.
* Added the `HelpDocs` class.

= 1.8 =
* Added database indexes for frequent queries.
* Replaced JSON LIKE cart filtering with a dedicated cart count column.
* Reduced large JSON fields in overview queries.
* Added an upgrade lock for database migrations.

= 1.7 =
* Split code into separate classes and files.
* Cached settings per request.
* Combined statistics into one aggregate SQL query.
* Moved cleanup and max-session handling to scheduled tasks.
* Moved admin CSS, admin JavaScript and frontend JavaScript into separate files.
