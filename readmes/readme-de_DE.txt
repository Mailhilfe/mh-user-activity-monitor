# MH User Activity Monitor

## 1. Live-Überwachung für WordPress-Websites

MH User Activity Monitor zeigt in Echtzeit, welche Benutzer, Besucher, WooCommerce-Kunden und Bots gerade auf Ihrer WordPress-Website aktiv sind. Administratoren erhalten eine kompakte Übersicht über aktive Sitzungen, Seitentypen, letzte Aktivität und auffällige Muster.

- Die Live-Ansicht hilft, normale Besucheraktivität von ungewöhnlichen Zugriffen zu unterscheiden.
- Dashboard-Kacheln, Filter, Sortierung und Live-Aktualisierung erleichtern die kurzfristige technische Überwachung.

## 2. WooCommerce-Warenkörbe im Blick behalten

Wenn WooCommerce aktiv ist, kann das Plugin aktive Warenkorb-Sitzungen anzeigen. Je nach Einstellung werden nur die Artikelanzahl, Artikelanzahl und Summe oder Produktdetails gespeichert.

- Shop-Betreiber können schneller erkennen, ob Kunden gerade Produkte im Warenkorb haben.
- Der Warenkorb-Modus sollte passend zur eigenen Datenschutzstrategie gewählt werden.

## 3. Bots und verdächtige Zugriffe erkennen

Das Plugin erkennt bekannte Bots, Crawler, KI-Crawler, SEO-Tools und typische Scanner-Zugriffe. Auffällige Muster wie XML-RPC-, Login-, .env-, .git- oder Injection-Aufrufe werden gesondert markiert.

- Die Bot-Erkennung ist eine Orientierungshilfe und keine Firewall.
- Rote oder orangefarbene Markierungen sollten geprüft werden, bedeuten aber nicht automatisch einen erfolgreichen Angriff.

## 4. Datenschutzfreundliche Einstellungen

Das Plugin verarbeitet technische Besucherdaten nur kurzfristig und bietet Optionen wie IP-Anonymisierung, Datenschutzmodus, automatische Bereinigung, gekürzte User-Agents sowie URLs und Referrer ohne Query-Parameter.

- Der Modus „Keinen“ wendet keinen zusätzlichen Datenschutzmodus an und nutzt nur die einzeln aktivierten Einstellungen.
- Neue Installationen verwenden standardmäßig anonymisierte IP-Adressen.
- Die Modi Standard, Datensparsam und Streng steuern, wie viele technische Daten gespeichert werden.
- Der Frontend-Ping kann vollständig deaktiviert oder auf WooCommerce-Seiten begrenzt werden.

## 5. Für wen ist das Plugin geeignet?

Das Plugin eignet sich für Betreiber von WordPress-Websites, WooCommerce-Shops, Mitgliederbereichen, Buchungsseiten und redaktionellen Websites, die kurzfristig sehen möchten, was auf ihrer Website gerade passiert.

- Typische Einsatzfälle sind aktive Warenkörbe, Checkout-Sitzungen, auffällige Bots, ungewöhnliche Scanner-Zugriffe und technische Supportfälle.
- Das Plugin ist besonders hilfreich, wenn keine externen Trackingdienste für die kurzfristige Live-Überwachung eingesetzt werden sollen.
- Betreiber sollten prüfen, welche Daten sie wirklich benötigen und ob Hinweise in der Datenschutzerklärung erforderlich sind.

## 6. Bot-Erkennung und Ampel

Die Bot-Erkennung unterscheidet bekannte Suchmaschinen, SEO-Tools, KI-Crawler, Social-Media-Vorschauen, Monitoring-Dienste, Scanner und unbekannte Bots. Die Ampel nutzt farbige Punkte ohne englische Textlabels.

- Grün ist unauffällig, Gelb beobachtenswert, Orange auffällig und Rot potenziell kritisch.
- Viele Aufrufe in kurzer Zeit oder verdächtige URL-Muster können die Einstufung erhöhen.

## 7. Datenschutz und Sicherheit

Das Plugin kann IP-Adressen, User-Agents, Referrer, aktuelle URLs, Seitenverläufe und Warenkorbinformationen verarbeiten. Diese Daten sollten nur berechtigten Personen angezeigt werden.

- Nutzen Sie IP-Anonymisierung oder Hash-Speicherung, wenn vollständige IPs nicht notwendig sind.
- Aktivieren Sie Proxy-Header nur bei einem vertrauenswürdigen Reverse Proxy oder CDN.

## 8. Ignorierlisten, Wartung und Fehlerbehebung

Ignorierlisten helfen, interne oder technische Aufrufe auszublenden. Außerdem protokolliert das Plugin Datenbank-Schreibfehler, damit Probleme im PHP- oder WordPress-Debug-Log nachvollziehbar sind.

- Typische URL-Ausschlüsse sind /wp-cron.php, /wp-json/, /feed/ oder eigene Monitoring-Endpunkte.
- Wenn keine Daten erscheinen, prüfen Sie JavaScript, admin-ajax.php, Cache-Regeln, Firewall-Regeln und WP-Cron.

## 9. Neue Datenschutz- und Performance-Funktionen

Aktuelle Versionen enthalten CIDR-Regeln, ausblendbare Admin-Hinweise, abschaltbaren Frontend-Ping, pausierten Admin-Live-Refresh und datensparsame Warenkorb-Modi.

- Diese Funktionen reduzieren Last und gespeicherte Daten.
- Prüfen Sie die Einstellungen nach Updates, besonders bei WooCommerce und Proxy-Konfigurationen.

## 10. Screenshots auf WordPress.org

Die Screenshot-Dateien und die Screenshot-Beschreibungen sind aufeinander abgestimmt, damit WordPress.org den Screenshot-Bereich korrekt anzeigen kann.

- Screenshot 1 zeigt die Live-Übersicht aktiver Besucher, Benutzer und Bots im WordPress-Adminbereich.
- Screenshot 2 zeigt die Detailansicht einer aktiven Sitzung mit IP-Modus, User-Agent und Seitenverlauf.
- Screenshot 3 zeigt die WooCommerce-Warenkorb-Übersicht mit aktiven Warenkorb-Sitzungen.
- Screenshot 4 zeigt die Datenschutzeinstellungen mit IP-Anonymisierung, Speicherzeit und Datensparmodus.
- Diese Version ist als stabile Fassung gekennzeichnet und wurde vor der Bereitstellung erneut geprüft.
