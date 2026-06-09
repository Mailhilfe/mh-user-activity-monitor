=== MH User Activity Monitor ===
Contributors: schaum, mailhilfe
Tags: users, activity, woocommerce, bots, monitoring
Requires at least: 6.2
Tested up to: 7.0
Requires PHP: 7.4
Stable tag: 1.63
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Live-Überwachung für WordPress, WooCommerce-Warenkörbe, Bots und verdächtige Zugriffe mit Datenschutzoptionen.

== Description ==

MH User Activity Monitor zeigt in Echtzeit, welche Benutzer, Besucher, WooCommerce-Kunden und Bots gerade auf Ihrer WordPress-Website aktiv sind. Das Plugin hilft Administratoren, ungewöhnliche Aktivitäten, Warenkorb-Sitzungen, Bot-Zugriffe und verdächtige Anfragen schneller zu erkennen – mit Datenschutzoptionen wie IP-Anonymisierung, Datensparmodus und automatischer Bereinigung.

= Live-Überwachung für WordPress-Websites =

MH User Activity Monitor zeigt aktive Sitzungen übersichtlich im WordPress-Adminbereich. Administratoren sehen, welche Besucher gerade online sind, ob angemeldete Benutzer aktiv sind, welche Seitentypen aufgerufen werden und wann die letzte Aktivität stattgefunden hat.

Die Übersicht arbeitet mit Dashboard-Kacheln, Filtern, Sortierung und einer Live-Aktualisierung. So lässt sich schneller erkennen, ob auf der Website normaler Besucherverkehr stattfindet oder ob ungewöhnliche Muster auftreten.

= WooCommerce-Warenkörbe im Blick behalten =

Wenn WooCommerce aktiv ist, kann das Plugin aktive Warenkorb-Sitzungen anzeigen. Je nach Einstellung werden nur die Artikelanzahl, Artikelanzahl und Summe oder Produktdetails gespeichert und angezeigt.

Diese Funktion kann hilfreich sein, wenn Shop-Betreiber sehen möchten, ob Kunden gerade Produkte im Warenkorb haben, ob ein Warenkorb abbricht oder ob auffällige Sitzungen im Checkout-Bereich auftreten.

= Bots und verdächtige Zugriffe erkennen =

Das Plugin erkennt bekannte Bots, Crawler, SEO-Tools, KI-Crawler, Social-Media-Vorschauen und verdächtige Zugriffsmuster. Dazu gehören zum Beispiel Aufrufe auf Login-Bereiche, XML-RPC, .env-Dateien, .git-Verzeichnisse oder andere typische Scanner-Ziele.

Die Bot- und Risikoanzeige ist keine Firewall und ersetzt kein Sicherheitsplugin. Sie hilft aber, auffällige Aktivitäten schneller sichtbar zu machen und technische Zugriffe besser einzuordnen.

= Datenschutzfreundliche Einstellungen =

Da das Plugin technische Besucherdaten verarbeitet, enthält es mehrere Datenschutzoptionen. Neue Installationen verwenden standardmäßig anonymisierte IP-Adressen. Zusätzlich stehen Datenschutzmodi wie Standard, Datensparsam und Streng zur Verfügung.

Gespeicherte URLs und Referrer werden ohne Query-Parameter abgelegt, damit sensible Werte wie Token, E-Mail-Adressen, Suchbegriffe oder Trackingparameter nicht unnötig gespeichert werden. User-Agent, URL und Referrer werden außerdem begrenzt, um die gespeicherte Datenmenge zu reduzieren.

Weitere Optionen sind automatische Bereinigung über WordPress-Cron, IP-Ignorierlisten, CIDR-Unterstützung, WooCommerce-Warenkorb-Modi und die Möglichkeit, den Frontend-Ping vollständig zu deaktivieren.

= Für wen ist das Plugin geeignet? =

Das Plugin eignet sich für Betreiber von WordPress-Websites, WooCommerce-Shops, Mitgliederbereichen, Buchungsseiten und redaktionellen Websites, die kurzfristig sehen möchten, was auf ihrer Website gerade passiert.

Typische Einsatzfälle sind:

* Shop-Betreiber möchten aktive Warenkörbe und Checkout-Sitzungen besser beobachten.
* Administratoren möchten ungewöhnliche Bot-Zugriffe oder Scanner schneller erkennen.
* Website-Betreiber möchten sehen, welche Seiten gerade aktiv besucht werden.
* Support-Teams möchten technische Besucheraktivität kurzfristig nachvollziehen.
* Betreiber kleinerer Websites möchten eine einfache Live-Übersicht ohne externe Trackingdienste.

Das Plugin ist für kurzfristige technische Überwachung gedacht. Betreiber sollten prüfen, welche Daten sie wirklich benötigen, wie lange diese gespeichert werden und ob Hinweise in der Datenschutzerklärung erforderlich sind.

== Requirements ==

* WordPress 6.2 oder neuer.
* PHP 7.4 oder neuer.
* Getestet bis WordPress 7.0.
* WooCommerce ist optional und nur für die Warenkorbüberwachung erforderlich.

== Installation ==

1. Laden Sie den Plugin-Ordner in das Verzeichnis `/wp-content/plugins/` hoch oder installieren Sie die ZIP-Datei über den WordPress-Adminbereich.
2. Aktivieren Sie das Plugin über die Plugin-Verwaltung in WordPress.
3. Öffnen Sie im WordPress-Adminbereich den Menüpunkt `MH User Activity Monitor`.
4. Prüfen Sie vor dem Einsatz auf einer produktiven Website die Einstellungen.
5. Konfigurieren Sie IP-Anonymisierung, Speicherzeit, Ignorierlisten und WooCommerce-Optionen passend zu Ihren Datenschutzanforderungen.

== Frequently Asked Questions ==

= Speichert das Plugin Besucherdaten dauerhaft? =

Nein. Das Plugin ist für kurzfristige Aktivitätsüberwachung gedacht. Die Bereinigung erfolgt über WordPress-Cron und die eingestellte Speicherzeit.

= Unterstützt das Plugin WooCommerce? =

Ja. Wenn WooCommerce aktiv ist, kann das Plugin Warenkorbinformationen aktiver Sitzungen anzeigen, sofern die WooCommerce-Session verfügbar ist.

= Können IP-Adressen anonymisiert werden? =

Ja. Das Plugin bietet mehrere IP-Modi. Neue Installationen verwenden standardmäßig anonymisierte IP-Adressen. In den Modi Datensparsam und Streng wird die Speicherung vollständiger IP-Adressen verhindert.

= Was macht der Datenschutzmodus? =

Standard nutzt die aktivierten Optionen, entfernt aber Query-Parameter aus gespeicherten URLs und Referrern. Datensparsam speichert IPs nur als Hash, entfernt gespeicherte User-Agents, speichert Referrer nur als Domain und reduziert Warenkorbdaten. Streng deaktiviert den Frontend-Ping effektiv und speichert keine Referrer, User-Agents, Roh-IPs oder WooCommerce-Warenkorbdetails.

= Erkennt das Plugin Bots? =

Ja. Das Plugin enthält eine User-Agent-basierte Bot-Erkennung und eine einfache Erkennung auffälliger Zugriffsmuster. Es ist jedoch keine Firewall und ersetzt kein spezialisiertes Sicherheitsplugin.

= Kann der Frontend-Ping deaktiviert werden? =

Ja. In den Einstellungen kann der Frontend-Ping vollständig deaktiviert werden. Dann werden nur normale Seitenaufrufe erfasst und das regelmäßige Frontend-AJAX-Script wird nicht geladen.

= Welche IP-Regeln werden unterstützt? =

Ignorierte IP-Adressen und erlaubte Proxy-IP-Adressen unterstützen einzelne IPs, IPv4-Wildcards wie `192.168.178.*` und IPv4-/IPv6-CIDR-Bereiche wie `10.0.0.0/8` oder `2001:db8::/32`.

= Können WooCommerce-Warenkorbdaten reduziert werden? =

Ja. Der Warenkorbmodus kann nur die Artikelanzahl, Artikelanzahl und Summe oder detaillierte Produktinformationen speichern. Der datensparsame Standard ist Artikelanzahl und Summe.

= Ist das Plugin DSGVO-konform? =

Das Plugin stellt datenschutzfreundliche Einstellungen bereit. Die rechtliche Bewertung hängt jedoch von der konkreten Website-Konfiguration, dem Zweck der Verarbeitung, der Datenschutzerklärung und den lokalen Anforderungen ab. Betreiber sollten ihre Einstellungen prüfen und bei Bedarf fachkundigen Rat einholen.

== Screenshots ==

1. Live-Übersicht aktiver Besucher, Benutzer und Bots im WordPress-Adminbereich.
2. Detailansicht einer aktiven Sitzung mit IP-Modus, User-Agent und Seitenverlauf.
3. WooCommerce-Warenkorb-Übersicht mit aktiven Warenkorb-Sitzungen.
4. Datenschutzeinstellungen mit IP-Anonymisierung, Speicherzeit und Datensparmodus.

== Changelog ==

= 1.63 =
* Rechecked and completed multilingual translations for screenshot captions, cart/session plural strings and remaining admin labels.

= 1.62 =
* Added WordPress.org screenshot assets and synchronized screenshot help documentation in all included languages.

= 1.60 =
* Hardening: Improved validation of unexpected non-scalar settings values to prevent PHP deprecation notices.
* Hardening: Made cart and page-history rendering more robust against malformed stored JSON data.

= 1.57 =
* Normalized multilingual help documentation so all included languages use the same section structure.

= 1.56 =
* Added localized description sections for all included languages.

= 1.55 =
* Verbesserte deutsche Plugin-Beschreibung für WordPress.org, inklusive Abschnitten zu Live-Überwachung, WooCommerce, Bots, Datenschutz und typischen Einsatzfällen.

= 1.54 =
* Updated the plugin description and multilingual help descriptions.

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
