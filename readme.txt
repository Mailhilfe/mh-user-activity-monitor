=== MH User Activity Monitor ===
Contributors: schaum, mailhilfe
Tags: users, activity, woocommerce, bots, monitoring
Requires at least: 6.2
Tested up to: 7.0
Requires PHP: 7.4
Stable tag: 1.65
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Live monitoring for WordPress visitors, users, WooCommerce carts, bots and suspicious requests with privacy-friendly options.

== Description ==

MH User Activity Monitor shows in real time which users, visitors, WooCommerce customers and bots are currently active on your WordPress website. The plugin helps administrators identify unusual activity, cart sessions, bot traffic and suspicious requests more quickly, with privacy options such as IP anonymization, data-saving mode and automatic cleanup.

= Live monitoring for WordPress websites =

MH User Activity Monitor displays active sessions directly in the WordPress admin area. Administrators can see which visitors are currently online, whether logged-in users are active, which page types are being viewed and when the last activity occurred.

The overview uses dashboard cards, filters, sorting and live refresh. This makes it easier to distinguish normal visitor activity from unusual access patterns.

= Keep an eye on WooCommerce carts =

When WooCommerce is active, the plugin can display active cart sessions. Depending on the selected setting, it stores and displays only the item count, item count and cart total, or detailed product information.

This can help shop owners see whether customers currently have products in their cart, whether carts are abandoned or whether unusual sessions appear in the checkout area.

= Detect bots and suspicious requests =

The plugin detects known bots, crawlers, SEO tools, AI crawlers, social media preview bots and suspicious request patterns. Examples include requests to login areas, XML-RPC, .env files, .git directories or other typical scanner targets.

The bot and risk indicators are not a firewall and do not replace a dedicated security plugin. They help make suspicious technical traffic more visible and easier to classify.

= Privacy-friendly settings =

Because the plugin processes technical visitor data, it includes several privacy options. New installations use anonymized IP addresses by default. Additional privacy modes such as Standard, Data-saving and Strict are available.

Stored URLs and referrers are saved without query parameters so sensitive values such as tokens, email addresses, search terms or tracking parameters are not stored unnecessarily. User-agent, URL and referrer values are also length-limited to reduce the amount of stored data.

Additional options include automatic cleanup via WordPress-Cron, ignored IP rules, CIDR support, WooCommerce cart modes and the ability to disable the frontend ping completely.

= Who is this plugin for? =

The plugin is suitable for operators of WordPress websites, WooCommerce shops, membership areas, booking sites and editorial websites who want a short-term view of what is happening on their website right now.

Typical use cases include:

* Shop owners want to monitor active carts and checkout sessions.
* Administrators want to identify unusual bot traffic or scanners more quickly.
* Website operators want to see which pages are currently being visited.
* Support teams want to understand short-term technical visitor activity.
* Operators of smaller websites want a simple live overview without external tracking services.

The plugin is intended for short-term technical monitoring. Site operators should check which data they really need, how long it is stored and whether information must be added to their privacy policy.

= Stability note =

This version is marked as the current stable build. Translations, help texts, screenshots, version metadata and basic PHP/ZIP checks were reviewed again before release.

== Requirements ==

* WordPress 6.2 or newer.
* PHP 7.4 or newer.
* Tested up to WordPress 7.0.
* WooCommerce is optional and only required for cart monitoring.

== Installation ==

1. Upload the plugin folder to `/wp-content/plugins/` or install the ZIP file through the WordPress admin area.
2. Activate the plugin from the Plugins screen in WordPress.
3. Open `MH User Activity Monitor` in the WordPress admin menu.
4. Review the settings before using the plugin on a production website.
5. Configure IP anonymization, retention time, ignore lists and WooCommerce options according to your privacy requirements.

== Frequently Asked Questions ==

= Does the plugin store visitor data permanently? =

No. The plugin is designed for short-term activity monitoring. Cleanup is handled by WordPress-Cron and the configured retention time.

= Does the plugin support WooCommerce? =

Yes. When WooCommerce is active, the plugin can display cart information for active sessions if the WooCommerce session is available.

= Can IP addresses be anonymized? =

Yes. The plugin provides multiple IP modes. New installations use anonymized IP addresses by default. In Data-saving and Strict modes, storing full raw IP addresses is prevented.

= What does the privacy mode do? =

Standard uses the enabled options but removes query parameters from stored URLs and referrers. Data-saving stores IPs only as hashes, removes stored user agents, stores referrers only as domains and reduces cart data. Strict effectively disables the frontend ping and does not store referrers, user agents, raw IPs or WooCommerce cart details.

= Does the plugin detect bots? =

Yes. The plugin includes user-agent based bot detection and simple detection of suspicious request patterns. It is not a firewall and does not replace a dedicated security plugin.

= Can the frontend ping be disabled? =

Yes. The frontend ping can be disabled completely in the settings. In that case only normal page views are recorded and the recurring frontend AJAX script is not loaded.

= Which IP rules are supported? =

Ignored IP addresses and trusted proxy IP addresses support exact IPs, IPv4 wildcards such as `192.168.178.*` and IPv4/IPv6 CIDR ranges such as `10.0.0.0/8` or `2001:db8::/32`.

= Can WooCommerce cart data be reduced? =

Yes. The cart mode can store only the item count, the item count and cart total, or detailed product information. The privacy-friendly default is item count and cart total.

= Is the plugin GDPR compliant? =

The plugin provides privacy-friendly settings. The legal assessment depends on the actual website configuration, processing purpose, privacy policy and local requirements. Site operators should review their settings and seek professional advice if needed.

== Screenshots ==

1. Live overview of active visitors, users and bots in the WordPress admin area.
2. Detail view of an active session with IP mode, user agent and page history.
3. WooCommerce cart overview with active cart sessions.
4. Privacy settings with IP anonymization, retention time and data-saving mode.

== Changelog ==

= 1.65 =
* Changed the readme.txt source language to English for better WordPress.org compatibility.
* Kept the complete German translation in de_DE language files for translate.wordpress.org.
* Kept multilingual HelpDocs and screenshot assets in place.

= 1.64 =
* Stable release: This version has been reviewed, translations were synchronized, screenshots were added and the current build is marked as stable.
* Stability note: This version is intended as the current stable release for WordPress.org submission and production testing.

= 1.63 =
* Rechecked and completed multilingual translations for screenshot captions, cart/session plural strings and remaining admin labels.

= 1.62 =
* Added WordPress.org screenshot assets and synchronized screenshot help documentation in all included languages.

= 1.61 =
* Added a Screenshots section to the readme and included screenshot assets for the WordPress.org plugin page.

= 1.60 =
* Added localized AI bot detection category strings and updated language files.

= 1.59 =
* Extended AI bot detection with categories for AI assistants, AI search engines, AI training/data collection and AI crawlers.

= 1.58 =
* Hardened settings validation against unexpected non-scalar values.
* Made cart and page-history rendering more robust against malformed stored JSON data.

= 1.57 =
* Normalized multilingual help documentation so all included languages use the same section structure.

= 1.56 =
* Added localized description sections for all included languages.

= 1.55 =
* Added an improved German plugin description for WordPress.org.

= 1.54 =
* Updated the plugin description and multilingual help descriptions.

= 1.53 =
* Updated the WordPress tested-up-to metadata to 7.0 in the plugin header and readme.

= 1.52 =
* Added translator comments for placeholder-based strings.

= 1.51 =
* Synchronized POT, PO and MO language files.

= 1.50 =
* Added dismiss links for the object-cache recommendation and privacy notice. Each dismissed notice is hidden per administrator for four weeks.

= 1.49 =
* WooCommerce cart cards, filters, columns, detail blocks and cart settings are hidden when WooCommerce is not installed or active.

= 1.48 =
* Improved WooCommerce cart product name display and fallback handling.

= 1.47 =
* Cart column now displays product names when product details are stored.

= 1.46 =
* Added cart hover tooltip for stored product details.

= 1.45 =
* Reduced PHPCS warnings for dynamic superglobal helper access.

= 1.44 =
* Fixed unslash and sanitize handling for GET, POST, SERVER, COOKIE and REQUEST values.

= 1.43 =
* Hardened request, cookie and server value handling to avoid PHP 8.1+ deprecation notices for unexpected null values.

= 1.42 =
* Frontend AJAX pings are no longer classified as admin-area activity.

= 1.41 =
* Reworked remaining database calls to use wpdb::prepare() identifier placeholders.

= 1.40 =
* Removed the legacy raw INSERT ... SELECT migration path.

= 1.39 =
* Refactored database migration and reviewed remaining direct database calls.

= 1.38 =
* Added privacy mode, URL/referrer query stripping, length limits and data-saving cleanup options.

= 1.37 =
* Centralized capability checks and hardened admin/AJAX request handling.

= 1.36 =
* Removed global PHPCS disable comments and documented SQL identifier handling.

= 1.35 =
* Fixed WordPress.org review issues related to contributors, nonce error responses and session upsert SQL.

= 1.34 =
* Added WordPress and PHP requirements to the plugin header and readme.

= 1.33 =
* Updated language files and help documentation for newly added privacy and performance options.

= 1.32 =
* Added CIDR support for ignored IPs and trusted proxy rules, frontend ping control and admin refresh pause behavior.
