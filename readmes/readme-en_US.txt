# MH User Activity Monitor

## 1. Live monitoring for WordPress websites

MH User Activity Monitor shows in real time which users, visitors, WooCommerce customers and bots are currently active on your WordPress website. Administrators get a compact overview of active sessions, page types, last activity and suspicious patterns.

- The live view helps distinguish normal visitor activity from unusual access.
- Dashboard cards, filters, sorting and live refresh make short-term technical monitoring easier.

## 2. Keep an eye on WooCommerce carts

When WooCommerce is active, the plugin can show active cart sessions. Depending on the setting, it stores only item count, item count and total, or product details.

- Shop owners can quickly see whether customers currently have products in their carts.
- Choose the cart mode according to your privacy strategy.

## 3. Detect bots and suspicious access

The plugin detects known bots, crawlers, AI crawlers, SEO tools and common scanner requests. Suspicious patterns such as XML-RPC, login, .env, .git or injection requests are highlighted.

- Bot detection is guidance, not a firewall.
- Red or orange indicators should be reviewed but do not automatically mean a successful attack.

## 4. Privacy-friendly settings

The plugin processes technical visitor data only temporarily and offers options such as IP anonymization, privacy mode, automatic cleanup, shortened user agents and URLs/referrers without query parameters.

- The None mode applies no additional privacy mode and uses only the individually enabled settings.
- New installations use anonymized IP addresses by default.
- Standard, Data-saving and Strict modes control how much technical data is stored.
- The frontend ping can be disabled completely or limited to WooCommerce pages.

## 5. Who is this plugin for?

The plugin is suitable for WordPress sites, WooCommerce shops, membership areas, booking pages and editorial websites that want to see what is happening on the site right now.

- Typical use cases include active carts, checkout sessions, suspicious bots, unusual scanner access and technical support.
- It is useful when no external tracking services should be used for short-term live monitoring.
- Site owners should check which data they really need and whether privacy policy notes are required.

## 6. Bot detection and traffic light

Bot detection distinguishes search engines, SEO tools, AI crawlers, social previews, monitoring services, scanners and unknown bots. The traffic light uses color dots without English text labels.

- Green is normal, yellow should be watched, orange is suspicious and red is potentially critical.
- Many requests in a short time or suspicious URL patterns can increase the risk level.

## 7. Privacy and security

The plugin can process IP addresses, user agents, referrers, current URLs, page history and cart information. These data should only be visible to authorized users.

- Use IP anonymization or hash storage when full IPs are not necessary.
- Enable proxy headers only behind a trusted reverse proxy or CDN.

## 8. Ignore lists, maintenance and troubleshooting

Ignore lists help hide internal or technical requests. The plugin also logs database write errors so issues can be traced in PHP or WordPress debug logs.

- Typical URL exclusions are /wp-cron.php, /wp-json/, /feed/ or custom monitoring endpoints.
- If no data appears, check JavaScript, admin-ajax.php, cache rules, firewall rules and WP-Cron.

## 9. New privacy and performance features

Recent versions include CIDR rules, dismissible admin notices, a switchable frontend ping, paused admin live refresh and privacy-friendly cart modes.

- These features reduce load and stored data.
- Review the settings after updates, especially for WooCommerce and proxy configurations.

## 10. Screenshots on WordPress.org

The screenshot files and screenshot descriptions are aligned so WordPress.org can display the screenshot section correctly.

- Screenshot 1 shows the live overview of active visitors, users and bots in the WordPress admin area.
- Screenshot 2 shows the detail view of an active session with IP mode, user agent and page history.
- Screenshot 3 shows the WooCommerce cart overview with active cart sessions.
- Screenshot 4 shows the privacy settings with IP anonymization, retention time and data-saving mode.
- This version is marked as stable and was rechecked before release.
