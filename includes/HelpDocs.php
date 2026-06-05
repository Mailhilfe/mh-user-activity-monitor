<?php
/**
 * MH User Activity Monitor
 *
 * @package MHUAM
 * @license GPL-2.0-or-later
 */

namespace MHUAM;

if (!defined('ABSPATH')) { exit; }

final class HelpDocs {
    private const DOCS_JSON = <<<'JSON'
{
  "de": [
    [
      "1. Zweck des Plugins",
      "Der MH User Activity Monitor ist ein internes Werkzeug für WordPress-Administratoren. Er zeigt aktive Besucher, angemeldete Benutzer, WooCommerce-Kunden und erkannte Bots in einer Live-Übersicht. Das Plugin ist keine klassische Statistiksoftware und keine Firewall. Es dient der kurzfristigen technischen Beobachtung der Website und des Shops.",
      [
        "Typische Einsatzfälle sind die Kontrolle aktiver Shop-Besucher, das Erkennen auffälliger Bots, die Beobachtung von Warenkörben und die Prüfung, welche Seite ein Besucher gerade geöffnet hat.",
        "Die Sessions werden in einer eigenen Datenbanktabelle gespeichert und regelmäßig über WordPress-Cron bereinigt."
      ]
    ],
    [
      "2. Erste Einrichtung",
      "Öffnen Sie nach der Aktivierung den Menüpunkt „MH User Activity Monitor“ und danach die Einstellungen. Prüfen Sie zuerst, welche Daten wirklich benötigt werden und welche Rollen Zugriff erhalten sollen.",
      [
        "Blenden Sie Administratoren und die eigene IP-Adresse aus, wenn interne Aufrufe die Übersicht stören.",
        "Wählen Sie für IP-Adressen den passenden Modus: vollständig, anonymisiert oder nur als Hash.",
        "Aktivieren Sie Warenkorbdaten nur, wenn diese Information für Shop-Betreuung oder Fehleranalyse erforderlich ist."
      ]
    ],
    [
      "3. Übersicht und Kacheln",
      "Die Übersichtsseite enthält Kacheln für Online-Sessions, Bots, Kunden, Warenkörbe, auffällige Muster und die Gesamtzahl gespeicherter Sessions. So ist die aktuelle Lage sofort sichtbar.",
      [
        "„Online“ meint Sessions innerhalb des eingestellten Aktivitätsfensters.",
        "„Bots online“ zählt erkannte Crawler und automatisierte Zugriffe.",
        "„Auffällige Muster“ weist auf Scanner-, Login-, XML-RPC-, .env-, .git- oder Injection-Zugriffe hin."
      ]
    ],
    [
      "4. Tabelle, Filter und Live-Aktualisierung",
      "Die Tabelle zeigt Status, Besuchertyp, IP-Information, Seitentyp, aktuelle Seite, letzte Aktivität, Aufrufzähler, Warenkorb und Bot-Hinweise. Sie kann live aktualisiert und sortiert werden.",
      [
        "Nutzen Sie die Filter „Nur Bots“, „Nur Kunden“ und „Nur Warenkorb“, um große Listen schneller auszuwerten.",
        "Lange URLs und User-Agents werden in der Übersicht gekürzt. Die vollständigen Daten stehen in der Detailansicht.",
        "Das Live-Intervall sollte nicht zu kurz gewählt werden, damit die Datenbank nicht unnötig belastet wird."
      ]
    ],
    [
      "5. Detailansicht pro Besucher",
      "Über „Details“ öffnen Sie eine vollständige Sessionansicht. Dort erscheinen erste und letzte Aktivität, Aufrufe, Referrer, User-Agent, Bot-Kategorie, Risikostufe, Sicherheitsmuster, Warenkorb und Seitenverlauf.",
      [
        "Der Seitenverlauf zeigt nur die letzten Einträge und ist zur kurzfristigen Orientierung gedacht.",
        "Bei WooCommerce werden Warenkorbartikel erst angezeigt, wenn WooCommerce die Session sicher laden kann."
      ]
    ],
    [
      "6. Bot-Erkennung und Ampel",
      "Die Bot-Erkennung unterscheidet bekannte Suchmaschinen, SEO-Tools, KI-Crawler, Social-Media-Vorschauen, Monitoring-Dienste, Scanner und unbekannte Bots. Die Ampel nutzt farbige Punkte ohne englische Textlabels.",
      [
        "Grün ist unauffällig, Gelb beobachtenswert, Orange auffällig und Rot potenziell kritisch.",
        "Eine rote Markierung bedeutet nicht automatisch einen erfolgreichen Angriff, sondern dass der Zugriff geprüft werden sollte.",
        "Viele Aufrufe in kurzer Zeit können die Einstufung erhöhen."
      ]
    ],
    [
      "7. Datenschutz und Sicherheit",
      "Das Plugin kann IP-Adressen, User-Agents, Referrer, aktuelle URLs, Seitenverläufe und Warenkorbinformationen verarbeiten. Diese Daten sollten nur berechtigten Personen angezeigt werden.",
      [
        "Nutzen Sie IP-Anonymisierung oder Hash-Speicherung, wenn vollständige IPs nicht notwendig sind.",
        "Ergänzen Sie Ihre Datenschutzerklärung, wenn die kurzfristige technische Verarbeitung für Ihre Website relevant ist.",
        "Aktivieren Sie Proxy-Header nur bei einem vertrauenswürdigen Reverse Proxy oder CDN."
      ]
    ],
    [
      "8. Ignorierlisten, Wartung und Fehlerbehebung",
      "Ignorierlisten helfen, interne oder technische Aufrufe auszublenden. Außerdem protokolliert das Plugin Datenbank-Schreibfehler, damit Probleme im PHP- oder WordPress-Debug-Log nachvollziehbar sind.",
      [
        "Typische URL-Ausschlüsse sind /wp-cron.php, /wp-json/, /feed/ oder eigene Monitoring-Endpunkte.",
        "Typische User-Agent-Ausschlüsse sind UptimeRobot, Pingdom oder bekannte interne Prüfdienste.",
        "Wenn keine Daten erscheinen, prüfen Sie JavaScript, admin-ajax.php, Cache-Regeln, Firewall-Regeln und WP-Cron."
      ]
    ],
    [
      "9. Neue Datenschutz- und Performance-Funktionen",
      "Die aktuellen Einstellungen reduzieren unnötige Datenerfassung und verbessern die Serverlast bei größeren Websites.",
      [
        "Neue Installationen verwenden standardmäßig anonymisierte IP-Adressen. Vollständige IP-Adressen sollten nur aktiviert werden, wenn sie wirklich erforderlich sind.",
        "Der neue Datenschutzmodus bietet Standard, Datensparsam und Streng. Streng reduziert die Speicherung auf das technische Minimum und deaktiviert den Frontend-Ping effektiv.",
        "Aktuelle URLs und Referrer werden ohne Query-Parameter gespeichert, damit Token, E-Mail-Adressen, Suchbegriffe oder andere sensible Werte nicht unnötig in der Datenbank landen.",
        "User-Agent, URL und Referrer werden vor der Speicherung hart gekürzt, um Datenbankgröße und Missbrauchsrisiken zu begrenzen.",
        "Ignorierte IP-Adressen und erlaubte Proxy-Adressen unterstützen einzelne IPs, IPv4-Wildcards sowie IPv4- und IPv6-CIDR-Bereiche. Ungültige Proxy-Regeln werden beim Speichern abgewiesen.",
        "Der Frontend-Ping kann komplett deaktiviert oder auf WooCommerce-Seiten begrenzt werden. Der Live-Refresh im Adminbereich pausiert automatisch, wenn der Browser-Tab im Hintergrund liegt.",
        "Für WooCommerce kann gewählt werden, ob nur die Artikelanzahl, Artikelanzahl und Summe oder Produktdetails gespeichert werden. Der datensparsame Standard ist Artikelanzahl und Summe."
      ]
    ]
  ],
  "en_US": [
    [
      "1. Purpose of the plugin",
      "MH User Activity Monitor is an internal tool for WordPress administrators. It shows active visitors, logged-in users, WooCommerce customers and detected bots in a live overview. It is not a full analytics platform and not a firewall. It is intended for short-term technical monitoring of the website and shop.",
      [
        "Typical use cases are checking active shop visitors, spotting suspicious bots, viewing cart activity and seeing which page a visitor is currently on.",
        "Sessions are stored in a dedicated database table and cleaned up regularly by WordPress-Cron."
      ]
    ],
    [
      "2. Initial setup",
      "After activation, open the “MH User Activity Monitor” menu and then the settings page. First decide which data is really needed and which roles should be allowed to access it.",
      [
        "Hide administrators and your own IP address if internal visits clutter the overview.",
        "Choose the right IP mode: full IP, anonymized IP or hash only.",
        "Enable cart data only when it is needed for shop support or troubleshooting."
      ]
    ],
    [
      "3. Overview and dashboard cards",
      "The overview page contains cards for online sessions, bots, customers, carts, suspicious patterns and total stored sessions. This makes the current situation visible immediately.",
      [
        "“Online” means sessions within the configured activity window.",
        "“Bots online” counts detected crawlers and automated requests.",
        "“Suspicious patterns” points to scanner, login, XML-RPC, .env, .git or injection requests."
      ]
    ],
    [
      "4. Table, filters and live refresh",
      "The table shows status, visitor type, IP information, page type, current page, last activity, request counter, cart status and bot hints. It can be refreshed live and sorted.",
      [
        "Use the filters “Only bots”, “Only customers” and “Only cart” to evaluate larger lists faster.",
        "Long URLs and user agents are shortened in the overview. Full data is available in the detail view.",
        "Do not set the live interval too low, otherwise the database may receive unnecessary load."
      ]
    ],
    [
      "5. Visitor detail view",
      "Use “Details” to open the full session view. It shows first and last activity, request count, referrer, user agent, bot category, risk level, security patterns, cart and page history.",
      [
        "The page history contains only the latest entries and is intended for short-term orientation.",
        "WooCommerce cart items are shown only when WooCommerce can safely load the session."
      ]
    ],
    [
      "6. Bot detection and traffic light",
      "Bot detection distinguishes known search engines, SEO tools, AI crawlers, social media previews, monitoring services, scanners and unknown bots. The traffic light uses colored dots without English text labels.",
      [
        "Green means normal, yellow means worth watching, orange means suspicious and red means potentially critical.",
        "A red marker does not automatically mean a successful attack. It means the request should be reviewed.",
        "Many requests in a short time can increase the risk level."
      ]
    ],
    [
      "7. Privacy and security",
      "The plugin may process IP addresses, user agents, referrers, current URLs, page histories and cart information. These data should only be visible to authorized people.",
      [
        "Use IP anonymization or hash storage if full IP addresses are not necessary.",
        "Update your privacy notice if short-term technical processing is relevant for your website.",
        "Enable proxy headers only when using a trusted reverse proxy or CDN."
      ]
    ],
    [
      "8. Ignore lists, maintenance and troubleshooting",
      "Ignore lists help hide internal or technical requests. The plugin also logs database write errors so problems can be traced in the PHP or WordPress debug log.",
      [
        "Typical URL exclusions are /wp-cron.php, /wp-json/, /feed/ or your own monitoring endpoints.",
        "Typical user-agent exclusions are UptimeRobot, Pingdom or known internal checking services.",
        "If no data appears, check JavaScript, admin-ajax.php, cache rules, firewall rules and WP-Cron."
      ]
    ],
    [
      "9. New privacy and performance settings",
      "The current settings reduce unnecessary data collection and improve server load on larger websites.",
      [
        "New installations use anonymized IP addresses by default. Full IP addresses should only be enabled when they are really required.",
        "The new privacy mode offers Standard, Data-saving and Strict. Strict reduces stored data to the technical minimum and effectively disables frontend ping.",
        "Current URLs and referrers are stored without query parameters so tokens, email addresses, search terms or other sensitive values are not unnecessarily written to the database.",
        "User-Agent, URL and referrer values are strictly shortened before storage to limit database size and abuse risks.",
        "Ignored IP addresses and allowed proxy addresses support single IPs, IPv4 wildcards and IPv4/IPv6 CIDR ranges. Invalid proxy rules are rejected when saving.",
        "Frontend ping can be disabled completely or limited to WooCommerce pages. Admin live refresh pauses automatically when the browser tab is in the background.",
        "For WooCommerce you can choose whether to store only item count, item count and total, or product details. The data-minimizing default is item count and total."
      ]
    ]
  ],
  "fr_FR": [
    [
      "Guide détaillé",
      "Ce guide explique la configuration, l’utilisation quotidienne, la protection des données et les fonctions de sécurité du MH User Activity Monitor.",
      [
        "Le plugin affiche les visiteurs actifs, les utilisateurs connectés, les clients WooCommerce et les bots détectés dans l’administration WordPress. Vérifiez les réglages, limitez l’accès aux personnes autorisées, utilisez l’anonymisation des IP si nécessaire, servez-vous des filtres pour les bots, clients et paniers, ouvrez la vue détaillée pour l’historique court des pages et contrôlez régulièrement les listes d’exclusion, le cache, admin-ajax.php et WP-Cron."
      ]
    ],
    [
      "1. Purpose / Zweck",
      "This plugin is intended for short-term technical monitoring of visitors, bots and WooCommerce carts. It is not a replacement for analytics software or a firewall. Use it only in the admin area and only for authorized staff.",
      []
    ],
    [
      "2. Setup",
      "Open the plugin settings, choose the IP storage mode, hide administrators or internal IPs if needed, and configure ignore lists for URLs and user agents.",
      []
    ],
    [
      "3. Overview",
      "The dashboard cards show online sessions, bots, customers, carts, suspicious patterns and total sessions. Filters help you focus on bots, customers or carts.",
      []
    ],
    [
      "4. Details and privacy",
      "The detail view shows technical session data, short page history and cart data if enabled. Limit retention, use anonymization and document the processing in your privacy information where required.",
      []
    ],
    [
      "6. Nouveaux réglages de confidentialité et de performance",
      "Les réglages actuels réduisent la collecte inutile de données et améliorent la charge serveur sur les sites plus importants.",
      [
        "Les nouvelles installations utilisent par défaut des adresses IP anonymisées. Les adresses IP complètes ne doivent être activées que si elles sont réellement nécessaires.",
        "Les adresses IP ignorées et les adresses de proxy autorisées prennent en charge les IP uniques, les jokers IPv4 et les plages CIDR IPv4/IPv6. Les règles de proxy non valides sont refusées lors de l’enregistrement.",
        "Le ping frontal peut être complètement désactivé ou limité aux pages WooCommerce. Le rafraîchissement en direct de l’administration se met automatiquement en pause lorsque l’onglet du navigateur est en arrière-plan.",
        "Pour WooCommerce, il est possible de choisir entre le nombre d’articles seul, le nombre d’articles avec total, ou les détails des produits. Le réglage par défaut le plus sobre est nombre d’articles et total."
      ]
    ]
  ],
  "es_ES": [
    [
      "Guía detallada",
      "Esta guía explica la configuración, el uso diario, las opciones de privacidad y las funciones de seguridad de MH User Activity Monitor.",
      [
        "El plugin muestra visitantes activos, usuarios conectados, clientes de WooCommerce y bots detectados en el administrador de WordPress. Revise los ajustes, limite el acceso a personas autorizadas, use anonimización de IP cuando sea necesario, utilice los filtros de bots, clientes y carritos, abra la vista de detalles para ver el historial corto de páginas y revise las listas de exclusión, la caché, admin-ajax.php y WP-Cron."
      ]
    ],
    [
      "1. Purpose / Zweck",
      "This plugin is intended for short-term technical monitoring of visitors, bots and WooCommerce carts. It is not a replacement for analytics software or a firewall. Use it only in the admin area and only for authorized staff.",
      []
    ],
    [
      "2. Setup",
      "Open the plugin settings, choose the IP storage mode, hide administrators or internal IPs if needed, and configure ignore lists for URLs and user agents.",
      []
    ],
    [
      "3. Overview",
      "The dashboard cards show online sessions, bots, customers, carts, suspicious patterns and total sessions. Filters help you focus on bots, customers or carts.",
      []
    ],
    [
      "4. Details and privacy",
      "The detail view shows technical session data, short page history and cart data if enabled. Limit retention, use anonymization and document the processing in your privacy information where required.",
      []
    ],
    [
      "6. Nuevos ajustes de privacidad y rendimiento",
      "Los ajustes actuales reducen la recopilación innecesaria de datos y mejoran la carga del servidor en sitios grandes.",
      [
        "Las nuevas instalaciones usan direcciones IP anonimizadas de forma predeterminada. Las IP completas solo deberían activarse cuando sean realmente necesarias.",
        "Las IP ignoradas y las direcciones de proxy permitidas admiten IP individuales, comodines IPv4 y rangos CIDR IPv4/IPv6. Las reglas de proxy no válidas se rechazan al guardar.",
        "El ping del frontend puede desactivarse por completo o limitarse a páginas de WooCommerce. La actualización en vivo del área de administración se pausa automáticamente cuando la pestaña del navegador está en segundo plano.",
        "Para WooCommerce puede elegirse si se guarda solo la cantidad de artículos, cantidad y total, o detalles de producto. El valor predeterminado más respetuoso con los datos es cantidad y total."
      ]
    ]
  ],
  "it_IT": [
    [
      "Guida dettagliata",
      "Questa guida spiega configurazione, uso quotidiano, opzioni privacy e funzioni di sicurezza di MH User Activity Monitor.",
      [
        "Il plugin mostra visitatori attivi, utenti connessi, clienti WooCommerce e bot rilevati nell’area amministrativa di WordPress. Controllare le impostazioni, limitare l’accesso agli utenti autorizzati, usare l’anonimizzazione IP se necessario, utilizzare i filtri per bot, clienti e carrelli, aprire la vista dettagli per lo storico breve delle pagine e verificare liste di esclusione, cache, admin-ajax.php e WP-Cron."
      ]
    ],
    [
      "1. Purpose / Zweck",
      "This plugin is intended for short-term technical monitoring of visitors, bots and WooCommerce carts. It is not a replacement for analytics software or a firewall. Use it only in the admin area and only for authorized staff.",
      []
    ],
    [
      "2. Setup",
      "Open the plugin settings, choose the IP storage mode, hide administrators or internal IPs if needed, and configure ignore lists for URLs and user agents.",
      []
    ],
    [
      "3. Overview",
      "The dashboard cards show online sessions, bots, customers, carts, suspicious patterns and total sessions. Filters help you focus on bots, customers or carts.",
      []
    ],
    [
      "4. Details and privacy",
      "The detail view shows technical session data, short page history and cart data if enabled. Limit retention, use anonymization and document the processing in your privacy information where required.",
      []
    ],
    [
      "6. Nuove impostazioni per privacy e prestazioni",
      "Le impostazioni attuali riducono la raccolta non necessaria di dati e migliorano il carico del server sui siti più grandi.",
      [
        "Le nuove installazioni usano per impostazione predefinita indirizzi IP anonimizzati. Gli indirizzi IP completi dovrebbero essere attivati solo quando sono davvero necessari.",
        "Gli IP ignorati e gli indirizzi proxy consentiti supportano IP singoli, wildcard IPv4 e intervalli CIDR IPv4/IPv6. Le regole proxy non valide vengono rifiutate al salvataggio.",
        "Il ping del frontend può essere disattivato completamente o limitato alle pagine WooCommerce. L’aggiornamento live dell’area admin si mette automaticamente in pausa quando la scheda del browser è in background.",
        "Per WooCommerce si può scegliere se salvare solo il numero di articoli, numero e totale, oppure i dettagli dei prodotti. Il valore predefinito più parsimonioso è numero articoli e totale."
      ]
    ]
  ],
  "nl_NL": [
    [
      "Uitgebreide handleiding",
      "Deze handleiding legt de configuratie, het dagelijks gebruik, privacyopties en beveiligingsfuncties van MH User Activity Monitor uit.",
      [
        "De plugin toont actieve bezoekers, ingelogde gebruikers, WooCommerce-klanten en herkende bots in het WordPress-beheer. Controleer de instellingen, beperk toegang tot bevoegde personen, gebruik IP-anonimisering indien nodig, gebruik filters voor bots, klanten en winkelwagens, open de detailweergave voor korte paginageschiedenis en controleer negeerlijsten, cache, admin-ajax.php en WP-Cron."
      ]
    ],
    [
      "1. Purpose / Zweck",
      "This plugin is intended for short-term technical monitoring of visitors, bots and WooCommerce carts. It is not a replacement for analytics software or a firewall. Use it only in the admin area and only for authorized staff.",
      []
    ],
    [
      "2. Setup",
      "Open the plugin settings, choose the IP storage mode, hide administrators or internal IPs if needed, and configure ignore lists for URLs and user agents.",
      []
    ],
    [
      "3. Overview",
      "The dashboard cards show online sessions, bots, customers, carts, suspicious patterns and total sessions. Filters help you focus on bots, customers or carts.",
      []
    ],
    [
      "4. Details and privacy",
      "The detail view shows technical session data, short page history and cart data if enabled. Limit retention, use anonymization and document the processing in your privacy information where required.",
      []
    ],
    [
      "6. Nieuwe privacy- en prestatie-instellingen",
      "De huidige instellingen verminderen onnodige gegevensverzameling en verbeteren de serverbelasting op grotere websites.",
      [
        "Nieuwe installaties gebruiken standaard geanonimiseerde IP-adressen. Volledige IP-adressen moeten alleen worden ingeschakeld wanneer ze echt nodig zijn.",
        "Genegeerde IP-adressen en toegestane proxyadressen ondersteunen losse IP’s, IPv4-wildcards en IPv4/IPv6-CIDR-bereiken. Ongeldige proxyregels worden bij het opslaan geweigerd.",
        "De frontend-ping kan volledig worden uitgeschakeld of worden beperkt tot WooCommerce-pagina’s. De live-verversing in de beheeromgeving pauzeert automatisch wanneer het browsertabblad op de achtergrond staat.",
        "Voor WooCommerce kan worden gekozen of alleen het aantal artikelen, aantal en totaal, of productdetails worden opgeslagen. De privacyvriendelijke standaard is aantal en totaal."
      ]
    ]
  ],
  "pl_PL": [
    [
      "Szczegółowa instrukcja",
      "Ta instrukcja wyjaśnia konfigurację, codzienne użycie, opcje prywatności i funkcje bezpieczeństwa MH User Activity Monitor.",
      [
        "Wtyczka pokazuje aktywnych odwiedzających, zalogowanych użytkowników, klientów WooCommerce oraz wykryte boty w panelu WordPress. Sprawdź ustawienia, ogranicz dostęp do uprawnionych osób, używaj anonimizacji IP, korzystaj z filtrów botów, klientów i koszyków, otwieraj widok szczegółów dla krótkiej historii stron oraz sprawdzaj listy ignorowania, cache, admin-ajax.php i WP-Cron."
      ]
    ],
    [
      "1. Purpose / Zweck",
      "This plugin is intended for short-term technical monitoring of visitors, bots and WooCommerce carts. It is not a replacement for analytics software or a firewall. Use it only in the admin area and only for authorized staff.",
      []
    ],
    [
      "2. Setup",
      "Open the plugin settings, choose the IP storage mode, hide administrators or internal IPs if needed, and configure ignore lists for URLs and user agents.",
      []
    ],
    [
      "3. Overview",
      "The dashboard cards show online sessions, bots, customers, carts, suspicious patterns and total sessions. Filters help you focus on bots, customers or carts.",
      []
    ],
    [
      "4. Details and privacy",
      "The detail view shows technical session data, short page history and cart data if enabled. Limit retention, use anonymization and document the processing in your privacy information where required.",
      []
    ],
    [
      "6. Nowe ustawienia prywatności i wydajności",
      "Aktualne ustawienia ograniczają niepotrzebne gromadzenie danych i zmniejszają obciążenie serwera na większych stronach.",
      [
        "Nowe instalacje domyślnie używają zanonimizowanych adresów IP. Pełne adresy IP należy włączać tylko wtedy, gdy są naprawdę potrzebne.",
        "Ignorowane adresy IP i dozwolone adresy proxy obsługują pojedyncze IP, symbole wieloznaczne IPv4 oraz zakresy CIDR IPv4/IPv6. Nieprawidłowe reguły proxy są odrzucane podczas zapisywania.",
        "Ping frontendu można całkowicie wyłączyć lub ograniczyć do stron WooCommerce. Odświeżanie na żywo w panelu administracyjnym zatrzymuje się automatycznie, gdy karta przeglądarki jest w tle.",
        "Dla WooCommerce można wybrać zapisywanie tylko liczby produktów, liczby i sumy albo szczegółów produktów. Domyślne ustawienie oszczędzające dane to liczba i suma."
      ]
    ]
  ],
  "pt_PT": [
    [
      "Guia detalhado",
      "Este guia explica a configuração, a utilização diária, as opções de privacidade e as funções de segurança do MH User Activity Monitor.",
      [
        "O plugin mostra visitantes ativos, utilizadores com sessão iniciada, clientes WooCommerce e bots detetados na administração do WordPress. Reveja as definições, limite o acesso a pessoas autorizadas, use anonimização de IP quando necessário, utilize filtros para bots, clientes e carrinhos, abra a vista de detalhes para o histórico curto de páginas e verifique listas de exclusão, cache, admin-ajax.php e WP-Cron."
      ]
    ],
    [
      "1. Purpose / Zweck",
      "This plugin is intended for short-term technical monitoring of visitors, bots and WooCommerce carts. It is not a replacement for analytics software or a firewall. Use it only in the admin area and only for authorized staff.",
      []
    ],
    [
      "2. Setup",
      "Open the plugin settings, choose the IP storage mode, hide administrators or internal IPs if needed, and configure ignore lists for URLs and user agents.",
      []
    ],
    [
      "3. Overview",
      "The dashboard cards show online sessions, bots, customers, carts, suspicious patterns and total sessions. Filters help you focus on bots, customers or carts.",
      []
    ],
    [
      "4. Details and privacy",
      "The detail view shows technical session data, short page history and cart data if enabled. Limit retention, use anonymization and document the processing in your privacy information where required.",
      []
    ],
    [
      "6. Novas definições de privacidade e desempenho",
      "As definições atuais reduzem a recolha desnecessária de dados e melhoram a carga do servidor em sites maiores.",
      [
        "As novas instalações usam endereços IP anonimizados por predefinição. Os IP completos só devem ser ativados quando forem realmente necessários.",
        "Os IP ignorados e os endereços de proxy permitidos suportam IPs individuais, curingas IPv4 e intervalos CIDR IPv4/IPv6. Regras de proxy inválidas são rejeitadas ao guardar.",
        "O ping do frontend pode ser totalmente desativado ou limitado a páginas WooCommerce. A atualização em direto na administração pausa automaticamente quando o separador do navegador está em segundo plano.",
        "No WooCommerce pode escolher guardar apenas a quantidade de artigos, quantidade e total, ou detalhes dos produtos. A predefinição mais económica em dados é quantidade e total."
      ]
    ]
  ],
  "pt_BR": [
    [
      "Guia detalhado",
      "Este guia explica a configuração, o uso diário, as opções de privacidade e os recursos de segurança do MH User Activity Monitor.",
      [
        "O plugin mostra visitantes ativos, usuários logados, clientes WooCommerce e bots detectados no painel do WordPress. Revise as configurações, limite o acesso a pessoas autorizadas, use anonimização de IP quando necessário, utilize filtros de bots, clientes e carrinhos, abra a visualização de detalhes para o histórico curto de páginas e verifique listas de ignorados, cache, admin-ajax.php e WP-Cron."
      ]
    ],
    [
      "1. Purpose / Zweck",
      "This plugin is intended for short-term technical monitoring of visitors, bots and WooCommerce carts. It is not a replacement for analytics software or a firewall. Use it only in the admin area and only for authorized staff.",
      []
    ],
    [
      "2. Setup",
      "Open the plugin settings, choose the IP storage mode, hide administrators or internal IPs if needed, and configure ignore lists for URLs and user agents.",
      []
    ],
    [
      "3. Overview",
      "The dashboard cards show online sessions, bots, customers, carts, suspicious patterns and total sessions. Filters help you focus on bots, customers or carts.",
      []
    ],
    [
      "4. Details and privacy",
      "The detail view shows technical session data, short page history and cart data if enabled. Limit retention, use anonymization and document the processing in your privacy information where required.",
      []
    ],
    [
      "6. Novas configurações de privacidade e desempenho",
      "As configurações atuais reduzem a coleta desnecessária de dados e melhoram a carga do servidor em sites maiores.",
      [
        "Novas instalações usam endereços IP anonimizados por padrão. IPs completos só devem ser ativados quando forem realmente necessários.",
        "IPs ignorados e endereços de proxy permitidos aceitam IPs individuais, curingas IPv4 e intervalos CIDR IPv4/IPv6. Regras de proxy inválidas são rejeitadas ao salvar.",
        "O ping do frontend pode ser totalmente desativado ou limitado a páginas WooCommerce. A atualização ao vivo no admin pausa automaticamente quando a aba do navegador está em segundo plano.",
        "No WooCommerce, é possível escolher entre salvar apenas a quantidade de itens, quantidade e total, ou detalhes dos produtos. O padrão mais econômico em dados é quantidade e total."
      ]
    ]
  ],
  "ru_RU": [
    [
      "Подробное руководство",
      "Это руководство описывает настройку, ежедневное использование, параметры конфиденциальности и функции безопасности MH User Activity Monitor.",
      [
        "Плагин показывает активных посетителей, вошедших пользователей, клиентов WooCommerce и обнаруженных ботов в панели WordPress. Проверьте настройки, ограничьте доступ уполномоченными пользователями, используйте анонимизацию IP при необходимости, применяйте фильтры для ботов, клиентов и корзин, открывайте подробный просмотр для краткой истории страниц и проверяйте списки исключений, кэш, admin-ajax.php и WP-Cron."
      ]
    ],
    [
      "1. Purpose / Zweck",
      "This plugin is intended for short-term technical monitoring of visitors, bots and WooCommerce carts. It is not a replacement for analytics software or a firewall. Use it only in the admin area and only for authorized staff.",
      []
    ],
    [
      "2. Setup",
      "Open the plugin settings, choose the IP storage mode, hide administrators or internal IPs if needed, and configure ignore lists for URLs and user agents.",
      []
    ],
    [
      "3. Overview",
      "The dashboard cards show online sessions, bots, customers, carts, suspicious patterns and total sessions. Filters help you focus on bots, customers or carts.",
      []
    ],
    [
      "4. Details and privacy",
      "The detail view shows technical session data, short page history and cart data if enabled. Limit retention, use anonymization and document the processing in your privacy information where required.",
      []
    ],
    [
      "6. Новые настройки конфиденциальности и производительности",
      "Текущие настройки уменьшают лишний сбор данных и снижают нагрузку на сервер на крупных сайтах.",
      [
        "Новые установки по умолчанию используют анонимизированные IP-адреса. Полные IP-адреса следует включать только при реальной необходимости.",
        "Игнорируемые IP-адреса и разрешенные адреса прокси поддерживают отдельные IP, шаблоны IPv4 и диапазоны CIDR IPv4/IPv6. Недопустимые правила прокси отклоняются при сохранении.",
        "Frontend ping можно полностью отключить или ограничить страницами WooCommerce. Живое обновление в админке автоматически приостанавливается, когда вкладка браузера находится в фоне.",
        "Для WooCommerce можно выбрать сохранение только количества товаров, количества и суммы или подробностей товаров. Наиболее экономичный по данным вариант по умолчанию — количество и сумма."
      ]
    ]
  ],
  "uk": [
    [
      "Докладна інструкція",
      "Ця інструкція пояснює налаштування, щоденне використання, параметри приватності та функції безпеки MH User Activity Monitor.",
      [
        "Плагін показує активних відвідувачів, авторизованих користувачів, клієнтів WooCommerce і виявлених ботів в адмінпанелі WordPress. Перевірте налаштування, обмежте доступ уповноваженим особам, використовуйте анонімізацію IP за потреби, застосовуйте фільтри для ботів, клієнтів і кошиків, відкривайте деталі для короткої історії сторінок та перевіряйте списки ігнорування, кеш, admin-ajax.php і WP-Cron."
      ]
    ],
    [
      "1. Purpose / Zweck",
      "This plugin is intended for short-term technical monitoring of visitors, bots and WooCommerce carts. It is not a replacement for analytics software or a firewall. Use it only in the admin area and only for authorized staff.",
      []
    ],
    [
      "2. Setup",
      "Open the plugin settings, choose the IP storage mode, hide administrators or internal IPs if needed, and configure ignore lists for URLs and user agents.",
      []
    ],
    [
      "3. Overview",
      "The dashboard cards show online sessions, bots, customers, carts, suspicious patterns and total sessions. Filters help you focus on bots, customers or carts.",
      []
    ],
    [
      "4. Details and privacy",
      "The detail view shows technical session data, short page history and cart data if enabled. Limit retention, use anonymization and document the processing in your privacy information where required.",
      []
    ],
    [
      "6. Нові налаштування конфіденційності та продуктивності",
      "Поточні налаштування зменшують зайвий збір даних і покращують навантаження на сервер на більших сайтах.",
      [
        "Нові встановлення за замовчуванням використовують анонімізовані IP-адреси. Повні IP-адреси слід вмикати лише тоді, коли вони справді потрібні.",
        "Ігноровані IP-адреси та дозволені адреси проксі підтримують окремі IP, шаблони IPv4 і діапазони CIDR IPv4/IPv6. Недійсні правила проксі відхиляються під час збереження.",
        "Frontend ping можна повністю вимкнути або обмежити сторінками WooCommerce. Живе оновлення в адмінці автоматично призупиняється, коли вкладка браузера у фоновому режимі.",
        "Для WooCommerce можна вибрати збереження лише кількості товарів, кількості й суми або деталей товарів. Найбільш ощадний стандарт — кількість і сума."
      ]
    ]
  ],
  "tr_TR": [
    [
      "Ayrıntılı kılavuz",
      "Bu kılavuz MH User Activity Monitor için kurulum, günlük kullanım, gizlilik seçenekleri ve güvenlik işlevlerini açıklar.",
      [
        "Eklenti WordPress yönetim alanında aktif ziyaretçileri, oturum açmış kullanıcıları, WooCommerce müşterilerini ve algılanan botları gösterir. Ayarları kontrol edin, erişimi yetkili kişilerle sınırlayın, gerekiyorsa IP anonimleştirme kullanın, bot, müşteri ve sepet filtrelerini kullanın, kısa sayfa geçmişi için ayrıntı görünümünü açın ve yok sayma listeleri, önbellek, admin-ajax.php ile WP-Cron durumunu kontrol edin."
      ]
    ],
    [
      "1. Purpose / Zweck",
      "This plugin is intended for short-term technical monitoring of visitors, bots and WooCommerce carts. It is not a replacement for analytics software or a firewall. Use it only in the admin area and only for authorized staff.",
      []
    ],
    [
      "2. Setup",
      "Open the plugin settings, choose the IP storage mode, hide administrators or internal IPs if needed, and configure ignore lists for URLs and user agents.",
      []
    ],
    [
      "3. Overview",
      "The dashboard cards show online sessions, bots, customers, carts, suspicious patterns and total sessions. Filters help you focus on bots, customers or carts.",
      []
    ],
    [
      "4. Details and privacy",
      "The detail view shows technical session data, short page history and cart data if enabled. Limit retention, use anonymization and document the processing in your privacy information where required.",
      []
    ],
    [
      "6. Yeni gizlilik ve performans ayarları",
      "Güncel ayarlar gereksiz veri toplamayı azaltır ve daha büyük sitelerde sunucu yükünü iyileştirir.",
      [
        "Yeni kurulumlarda varsayılan olarak anonimleştirilmiş IP adresleri kullanılır. Tam IP adresleri yalnızca gerçekten gerekli olduğunda etkinleştirilmelidir.",
        "Yok sayılan IP adresleri ve izin verilen proxy adresleri tekil IP’leri, IPv4 jokerlerini ve IPv4/IPv6 CIDR aralıklarını destekler. Geçersiz proxy kuralları kaydetme sırasında reddedilir.",
        "Frontend ping tamamen devre dışı bırakılabilir veya WooCommerce sayfalarıyla sınırlandırılabilir. Yönetici canlı yenilemesi, tarayıcı sekmesi arka plandayken otomatik olarak duraklar.",
        "WooCommerce için yalnızca ürün sayısı, ürün sayısı ve toplam ya da ürün ayrıntıları kaydedilebilir. Veri açısından daha tutumlu varsayılan değer ürün sayısı ve toplamdır."
      ]
    ]
  ],
  "ar": [
    [
      "دليل مفصل",
      "يشرح هذا الدليل إعداد MH User Activity Monitor والاستخدام اليومي وخيارات الخصوصية ووظائف الأمان.",
      [
        "يعرض الإضافة الزوار النشطين والمستخدمين المسجلين وعملاء WooCommerce والروبوتات المكتشفة داخل لوحة تحكم ووردبريس. راجع الإعدادات، واقصر الوصول على الأشخاص المخولين، واستخدم إخفاء عنوان IP عند الحاجة، واستعمل فلاتر الروبوتات والعملاء وسلات الشراء، وافتح عرض التفاصيل لمراجعة سجل الصفحات القصير، وتحقق من قوائم التجاهل والذاكرة المؤقتة و admin-ajax.php و WP-Cron."
      ]
    ],
    [
      "1. Purpose / Zweck",
      "This plugin is intended for short-term technical monitoring of visitors, bots and WooCommerce carts. It is not a replacement for analytics software or a firewall. Use it only in the admin area and only for authorized staff.",
      []
    ],
    [
      "2. Setup",
      "Open the plugin settings, choose the IP storage mode, hide administrators or internal IPs if needed, and configure ignore lists for URLs and user agents.",
      []
    ],
    [
      "3. Overview",
      "The dashboard cards show online sessions, bots, customers, carts, suspicious patterns and total sessions. Filters help you focus on bots, customers or carts.",
      []
    ],
    [
      "4. Details and privacy",
      "The detail view shows technical session data, short page history and cart data if enabled. Limit retention, use anonymization and document the processing in your privacy information where required.",
      []
    ],
    [
      "6. إعدادات جديدة للخصوصية والأداء",
      "تقلل الإعدادات الحالية جمع البيانات غير الضروري وتحسن حمل الخادم في المواقع الأكبر.",
      [
        "تستخدم التثبيتات الجديدة عناوين IP مجهولة الهوية افتراضياً. يجب تفعيل عناوين IP الكاملة فقط عند الحاجة الفعلية إليها.",
        "تدعم عناوين IP المستثناة وعناوين البروكسي المسموح بها عناوين IP مفردة وبدائل IPv4 ونطاقات CIDR لـ IPv4 وIPv6. يتم رفض قواعد البروكسي غير الصالحة عند الحفظ.",
        "يمكن تعطيل ping الواجهة الأمامية بالكامل أو حصره بصفحات WooCommerce. يتوقف التحديث الحي في لوحة الإدارة تلقائياً عندما تكون علامة تبويب المتصفح في الخلفية.",
        "في WooCommerce يمكن اختيار حفظ عدد العناصر فقط أو العدد والإجمالي أو تفاصيل المنتجات. الإعداد الافتراضي الأقل جمعاً للبيانات هو العدد والإجمالي."
      ]
    ]
  ],
  "zh_CN": [
    [
      "详细说明",
      "本说明介绍 MH User Activity Monitor 的设置、日常使用、隐私选项和安全功能。",
      [
        "该插件在 WordPress 后台显示在线访客、已登录用户、WooCommerce 客户以及检测到的机器人。请检查设置，只允许授权人员访问，在需要时启用 IP 匿名化，使用机器人、客户和购物车筛选器，在详情视图中查看简短页面历史，并定期检查忽略列表、缓存、admin-ajax.php 和 WP-Cron。"
      ]
    ],
    [
      "1. Purpose / Zweck",
      "This plugin is intended for short-term technical monitoring of visitors, bots and WooCommerce carts. It is not a replacement for analytics software or a firewall. Use it only in the admin area and only for authorized staff.",
      []
    ],
    [
      "2. Setup",
      "Open the plugin settings, choose the IP storage mode, hide administrators or internal IPs if needed, and configure ignore lists for URLs and user agents.",
      []
    ],
    [
      "3. Overview",
      "The dashboard cards show online sessions, bots, customers, carts, suspicious patterns and total sessions. Filters help you focus on bots, customers or carts.",
      []
    ],
    [
      "4. Details and privacy",
      "The detail view shows technical session data, short page history and cart data if enabled. Limit retention, use anonymization and document the processing in your privacy information where required.",
      []
    ],
    [
      "6. 新的隐私和性能设置",
      "当前设置可减少不必要的数据收集，并改善大型网站的服务器负载。",
      [
        "新安装默认使用匿名化 IP 地址。只有在确实需要时才应启用完整 IP 地址。",
        "忽略的 IP 地址和允许的代理地址支持单个 IP、IPv4 通配符以及 IPv4/IPv6 CIDR 范围。保存时会拒绝无效的代理规则。",
        "前端 ping 可以完全禁用，也可以限制为仅在 WooCommerce 页面启用。当浏览器标签页处于后台时，管理区实时刷新会自动暂停。",
        "对于 WooCommerce，可以选择仅保存商品数量、商品数量和总计，或保存商品详情。默认的最小化数据设置是商品数量和总计。"
      ]
    ]
  ],
  "ja": [
    [
      "詳しい操作ガイド",
      "このガイドでは、MH User Activity Monitor の設定、日常利用、プライバシー設定、セキュリティ機能を説明します。",
      [
        "このプラグインは WordPress 管理画面で、アクティブな訪問者、ログイン中のユーザー、WooCommerce 顧客、検出されたボットを表示します。設定を確認し、アクセス権を許可された担当者に限定し、必要に応じて IP 匿名化を使用し、ボット、顧客、カートのフィルターを使い、詳細表示で短いページ履歴を確認し、除外リスト、キャッシュ、admin-ajax.php、WP-Cron を点検してください。"
      ]
    ],
    [
      "1. Purpose / Zweck",
      "This plugin is intended for short-term technical monitoring of visitors, bots and WooCommerce carts. It is not a replacement for analytics software or a firewall. Use it only in the admin area and only for authorized staff.",
      []
    ],
    [
      "2. Setup",
      "Open the plugin settings, choose the IP storage mode, hide administrators or internal IPs if needed, and configure ignore lists for URLs and user agents.",
      []
    ],
    [
      "3. Overview",
      "The dashboard cards show online sessions, bots, customers, carts, suspicious patterns and total sessions. Filters help you focus on bots, customers or carts.",
      []
    ],
    [
      "4. Details and privacy",
      "The detail view shows technical session data, short page history and cart data if enabled. Limit retention, use anonymization and document the processing in your privacy information where required.",
      []
    ],
    [
      "6. 新しいプライバシーとパフォーマンス設定",
      "現在の設定では不要なデータ収集を減らし、大規模サイトでのサーバー負荷を抑えられます。",
      [
        "新規インストールでは、既定で匿名化された IP アドレスを使用します。完全な IP アドレスは、本当に必要な場合にのみ有効にしてください。",
        "無視する IP アドレスと許可するプロキシアドレスは、単一 IP、IPv4 ワイルドカード、IPv4/IPv6 CIDR 範囲に対応しています。無効なプロキシルールは保存時に拒否されます。",
        "フロントエンド ping は完全に無効化することも、WooCommerce ページのみに制限することもできます。管理画面のライブ更新は、ブラウザータブがバックグラウンドにあると自動的に一時停止します。",
        "WooCommerce では、商品数のみ、商品数と合計、または商品詳細の保存を選択できます。データを最小限にする既定値は商品数と合計です。"
      ]
    ]
  ],
  "ko_KR": [
    [
      "자세한 안내",
      "이 안내서는 MH User Activity Monitor의 설정, 일상 사용, 개인정보 옵션 및 보안 기능을 설명합니다.",
      [
        "이 플러그인은 WordPress 관리자 화면에서 활성 방문자, 로그인 사용자, WooCommerce 고객, 감지된 봇을 표시합니다. 설정을 확인하고 접근 권한을 허가된 사람으로 제한하며, 필요한 경우 IP 익명화를 사용하고, 봇, 고객, 장바구니 필터를 활용하며, 상세 보기에서 짧은 페이지 기록을 확인하고, 무시 목록, 캐시, admin-ajax.php 및 WP-Cron을 점검하십시오."
      ]
    ],
    [
      "1. Purpose / Zweck",
      "This plugin is intended for short-term technical monitoring of visitors, bots and WooCommerce carts. It is not a replacement for analytics software or a firewall. Use it only in the admin area and only for authorized staff.",
      []
    ],
    [
      "2. Setup",
      "Open the plugin settings, choose the IP storage mode, hide administrators or internal IPs if needed, and configure ignore lists for URLs and user agents.",
      []
    ],
    [
      "3. Overview",
      "The dashboard cards show online sessions, bots, customers, carts, suspicious patterns and total sessions. Filters help you focus on bots, customers or carts.",
      []
    ],
    [
      "4. Details and privacy",
      "The detail view shows technical session data, short page history and cart data if enabled. Limit retention, use anonymization and document the processing in your privacy information where required.",
      []
    ],
    [
      "6. 새로운 개인정보 및 성능 설정",
      "현재 설정은 불필요한 데이터 수집을 줄이고 규모가 큰 사이트의 서버 부하를 개선합니다.",
      [
        "새 설치에서는 기본적으로 익명화된 IP 주소를 사용합니다. 전체 IP 주소는 실제로 필요한 경우에만 활성화해야 합니다.",
        "무시된 IP 주소와 허용된 프록시 주소는 단일 IP, IPv4 와일드카드, IPv4/IPv6 CIDR 범위를 지원합니다. 잘못된 프록시 규칙은 저장 시 거부됩니다.",
        "프론트엔드 ping은 완전히 비활성화하거나 WooCommerce 페이지로 제한할 수 있습니다. 관리자 실시간 새로고침은 브라우저 탭이 백그라운드에 있을 때 자동으로 일시 중지됩니다.",
        "WooCommerce에서는 상품 수만, 상품 수와 합계, 또는 상품 세부정보 저장을 선택할 수 있습니다. 데이터 최소화 기본값은 상품 수와 합계입니다."
      ]
    ]
  ],
  "sv_SE": [
    [
      "Utförlig guide",
      "Denna guide förklarar konfiguration, daglig användning, integritetsalternativ och säkerhetsfunktioner i MH User Activity Monitor.",
      [
        "Tillägget visar aktiva besökare, inloggade användare, WooCommerce-kunder och identifierade botar i WordPress-admin. Kontrollera inställningarna, begränsa åtkomst till behöriga personer, använd IP-anonymisering vid behov, använd filter för botar, kunder och varukorgar, öppna detaljvyn för kort sidhistorik och kontrollera ignoreringslistor, cache, admin-ajax.php och WP-Cron."
      ]
    ],
    [
      "1. Purpose / Zweck",
      "This plugin is intended for short-term technical monitoring of visitors, bots and WooCommerce carts. It is not a replacement for analytics software or a firewall. Use it only in the admin area and only for authorized staff.",
      []
    ],
    [
      "2. Setup",
      "Open the plugin settings, choose the IP storage mode, hide administrators or internal IPs if needed, and configure ignore lists for URLs and user agents.",
      []
    ],
    [
      "3. Overview",
      "The dashboard cards show online sessions, bots, customers, carts, suspicious patterns and total sessions. Filters help you focus on bots, customers or carts.",
      []
    ],
    [
      "4. Details and privacy",
      "The detail view shows technical session data, short page history and cart data if enabled. Limit retention, use anonymization and document the processing in your privacy information where required.",
      []
    ],
    [
      "6. Nya inställningar för integritet och prestanda",
      "De aktuella inställningarna minskar onödig datainsamling och förbättrar serverbelastningen på större webbplatser.",
      [
        "Nya installationer använder anonymiserade IP-adresser som standard. Fullständiga IP-adresser bör bara aktiveras när de verkligen behövs.",
        "Ignorerade IP-adresser och tillåtna proxyadresser stöder enskilda IP:n, IPv4-jokertecken och IPv4/IPv6-CIDR-intervall. Ogiltiga proxyregler avvisas vid sparning.",
        "Frontend-ping kan stängas av helt eller begränsas till WooCommerce-sidor. Liveuppdateringen i admin pausas automatiskt när webbläsarfliken ligger i bakgrunden.",
        "För WooCommerce kan du välja om bara artikelantal, artikelantal och total eller produktdetaljer ska sparas. Den datasnåla standarden är artikelantal och total."
      ]
    ]
  ],
  "da_DK": [
    [
      "Udførlig vejledning",
      "Denne vejledning forklarer opsætning, daglig brug, privatlivsindstillinger og sikkerhedsfunktioner i MH User Activity Monitor.",
      [
        "Pluginet viser aktive besøgende, indloggede brugere, WooCommerce-kunder og registrerede bots i WordPress-administrationen. Gennemgå indstillingerne, begræns adgang til autoriserede personer, brug IP-anonymisering ved behov, brug filtre for bots, kunder og kurve, åbn detaljevisningen for kort sidehistorik og kontroller ignoreringslister, cache, admin-ajax.php og WP-Cron."
      ]
    ],
    [
      "1. Purpose / Zweck",
      "This plugin is intended for short-term technical monitoring of visitors, bots and WooCommerce carts. It is not a replacement for analytics software or a firewall. Use it only in the admin area and only for authorized staff.",
      []
    ],
    [
      "2. Setup",
      "Open the plugin settings, choose the IP storage mode, hide administrators or internal IPs if needed, and configure ignore lists for URLs and user agents.",
      []
    ],
    [
      "3. Overview",
      "The dashboard cards show online sessions, bots, customers, carts, suspicious patterns and total sessions. Filters help you focus on bots, customers or carts.",
      []
    ],
    [
      "4. Details and privacy",
      "The detail view shows technical session data, short page history and cart data if enabled. Limit retention, use anonymization and document the processing in your privacy information where required.",
      []
    ],
    [
      "6. Nye privatlivs- og ydelsesindstillinger",
      "De aktuelle indstillinger reducerer unødvendig dataindsamling og forbedrer serverbelastningen på større websteder.",
      [
        "Nye installationer bruger anonymiserede IP-adresser som standard. Fulde IP-adresser bør kun aktiveres, når de virkelig er nødvendige.",
        "Ignorerede IP-adresser og tilladte proxyadresser understøtter enkelte IP’er, IPv4-wildcards og IPv4/IPv6-CIDR-områder. Ugyldige proxyregler afvises ved lagring.",
        "Frontend-ping kan deaktiveres helt eller begrænses til WooCommerce-sider. Liveopdatering i administrationen sættes automatisk på pause, når browserfanen er i baggrunden.",
        "For WooCommerce kan du vælge, om kun vareantal, vareantal og total eller produktdetaljer skal gemmes. Den databesparende standard er vareantal og total."
      ]
    ]
  ],
  "cs_CZ": [
    [
      "Podrobný návod",
      "Tento návod vysvětluje nastavení, každodenní použití, možnosti ochrany soukromí a bezpečnostní funkce MH User Activity Monitor.",
      [
        "Plugin zobrazuje aktivní návštěvníky, přihlášené uživatele, zákazníky WooCommerce a rozpoznané boty ve správě WordPressu. Zkontrolujte nastavení, omezte přístup na oprávněné osoby, v případě potřeby použijte anonymizaci IP, využívejte filtry pro boty, zákazníky a košíky, otevřete detail pro krátkou historii stránek a kontrolujte seznamy ignorování, cache, admin-ajax.php a WP-Cron."
      ]
    ],
    [
      "1. Purpose / Zweck",
      "This plugin is intended for short-term technical monitoring of visitors, bots and WooCommerce carts. It is not a replacement for analytics software or a firewall. Use it only in the admin area and only for authorized staff.",
      []
    ],
    [
      "2. Setup",
      "Open the plugin settings, choose the IP storage mode, hide administrators or internal IPs if needed, and configure ignore lists for URLs and user agents.",
      []
    ],
    [
      "3. Overview",
      "The dashboard cards show online sessions, bots, customers, carts, suspicious patterns and total sessions. Filters help you focus on bots, customers or carts.",
      []
    ],
    [
      "4. Details and privacy",
      "The detail view shows technical session data, short page history and cart data if enabled. Limit retention, use anonymization and document the processing in your privacy information where required.",
      []
    ],
    [
      "6. Nová nastavení ochrany soukromí a výkonu",
      "Aktuální nastavení omezují zbytečné shromažďování dat a zlepšují zatížení serveru u větších webů.",
      [
        "Nové instalace používají ve výchozím stavu anonymizované IP adresy. Úplné IP adresy zapínejte pouze tehdy, když jsou skutečně potřeba.",
        "Ignorované IP adresy a povolené proxy adresy podporují jednotlivé IP, zástupné znaky IPv4 a rozsahy CIDR IPv4/IPv6. Neplatná pravidla proxy se při ukládání odmítnou.",
        "Frontend ping lze úplně vypnout nebo omezit na stránky WooCommerce. Živé obnovení v administraci se automaticky pozastaví, když je karta prohlížeče na pozadí.",
        "U WooCommerce lze zvolit ukládání pouze počtu položek, počtu a součtu, nebo detailů produktů. Výchozí úsporné nastavení je počet a součet."
      ]
    ]
  ],
  "hu_HU": [
    [
      "Részletes útmutató",
      "Ez az útmutató bemutatja az MH User Activity Monitor beállítását, napi használatát, adatvédelmi opcióit és biztonsági funkcióit.",
      [
        "A bővítmény a WordPress adminfelületén mutatja az aktív látogatókat, bejelentkezett felhasználókat, WooCommerce ügyfeleket és észlelt botokat. Ellenőrizze a beállításokat, korlátozza a hozzáférést jogosult személyekre, szükség esetén használjon IP-anonimizálást, alkalmazza a bot, ügyfél és kosár szűrőket, nyissa meg a részletes nézetet a rövid oldaltörténethez, és ellenőrizze a mellőzési listákat, a gyorsítótárat, az admin-ajax.php-t és a WP-Cront."
      ]
    ],
    [
      "1. Purpose / Zweck",
      "This plugin is intended for short-term technical monitoring of visitors, bots and WooCommerce carts. It is not a replacement for analytics software or a firewall. Use it only in the admin area and only for authorized staff.",
      []
    ],
    [
      "2. Setup",
      "Open the plugin settings, choose the IP storage mode, hide administrators or internal IPs if needed, and configure ignore lists for URLs and user agents.",
      []
    ],
    [
      "3. Overview",
      "The dashboard cards show online sessions, bots, customers, carts, suspicious patterns and total sessions. Filters help you focus on bots, customers or carts.",
      []
    ],
    [
      "4. Details and privacy",
      "The detail view shows technical session data, short page history and cart data if enabled. Limit retention, use anonymization and document the processing in your privacy information where required.",
      []
    ],
    [
      "6. Új adatvédelmi és teljesítménybeállítások",
      "A jelenlegi beállítások csökkentik a felesleges adatgyűjtést és javítják a szerverterhelést nagyobb webhelyeken.",
      [
        "Az új telepítések alapértelmezetten anonimizált IP-címeket használnak. A teljes IP-címeket csak akkor érdemes engedélyezni, ha valóban szükségesek.",
        "A figyelmen kívül hagyott IP-címek és az engedélyezett proxycímek támogatják az egyedi IP-ket, az IPv4 helyettesítő karaktereket és az IPv4/IPv6 CIDR-tartományokat. Az érvénytelen proxyszabályok mentéskor elutasításra kerülnek.",
        "A frontend ping teljesen kikapcsolható vagy WooCommerce oldalakra korlátozható. Az admin élő frissítés automatikusan szünetel, amikor a böngészőfül a háttérben van.",
        "WooCommerce esetén választható, hogy csak a tételszám, a tételszám és összeg, vagy a termékrészletek kerüljenek mentésre. Az adatminimalizáló alapértelmezés a tételszám és összeg."
      ]
    ]
  ],
  "ro_RO": [
    [
      "Ghid detaliat",
      "Acest ghid explică configurarea, utilizarea zilnică, opțiunile de confidențialitate și funcțiile de securitate ale MH User Activity Monitor.",
      [
        "Pluginul afișează vizitatori activi, utilizatori autentificați, clienți WooCommerce și boți detectați în administrarea WordPress. Verificați setările, limitați accesul la persoane autorizate, folosiți anonimizarea IP când este necesar, utilizați filtre pentru boți, clienți și coșuri, deschideți vizualizarea detaliată pentru istoricul scurt al paginilor și verificați listele de ignorare, cache-ul, admin-ajax.php și WP-Cron."
      ]
    ],
    [
      "1. Purpose / Zweck",
      "This plugin is intended for short-term technical monitoring of visitors, bots and WooCommerce carts. It is not a replacement for analytics software or a firewall. Use it only in the admin area and only for authorized staff.",
      []
    ],
    [
      "2. Setup",
      "Open the plugin settings, choose the IP storage mode, hide administrators or internal IPs if needed, and configure ignore lists for URLs and user agents.",
      []
    ],
    [
      "3. Overview",
      "The dashboard cards show online sessions, bots, customers, carts, suspicious patterns and total sessions. Filters help you focus on bots, customers or carts.",
      []
    ],
    [
      "4. Details and privacy",
      "The detail view shows technical session data, short page history and cart data if enabled. Limit retention, use anonymization and document the processing in your privacy information where required.",
      []
    ],
    [
      "6. Setări noi de confidențialitate și performanță",
      "Setările actuale reduc colectarea inutilă de date și îmbunătățesc încărcarea serverului pe site-uri mai mari.",
      [
        "Instalările noi folosesc implicit adrese IP anonimizate. Adresele IP complete ar trebui activate doar când sunt cu adevărat necesare.",
        "Adresele IP ignorate și adresele proxy permise acceptă IP-uri individuale, wildcard-uri IPv4 și intervale CIDR IPv4/IPv6. Regulile proxy nevalide sunt respinse la salvare.",
        "Pingul din frontend poate fi dezactivat complet sau limitat la paginile WooCommerce. Reîmprospătarea live din administrare se oprește automat când fila browserului este în fundal.",
        "Pentru WooCommerce puteți alege dacă se salvează doar numărul de articole, numărul și totalul sau detaliile produselor. Valoarea implicită cu minim de date este numărul și totalul."
      ]
    ]
  ]
}
JSON;

    public static function sections(?string $locale = null): array {
        $docs = json_decode(self::DOCS_JSON, true);
        if (!is_array($docs)) { return []; }
        $locale = $locale ?: (function_exists('determine_locale') ? determine_locale() : get_locale());
        if (isset($docs[$locale])) { return self::normalize($docs[$locale]); }
        $short = strtolower(substr((string)$locale, 0, 2));
        foreach ($docs as $key => $value) {
            if (strtolower(substr((string)$key, 0, 2)) === $short) { return self::normalize($value); }
        }
        return self::normalize($docs['en_US'] ?? $docs['de'] ?? []);
    }

    private static function normalize(array $sections): array {
        $out = [];
        foreach ($sections as $section) {
            $out[] = [
                'title' => (string)($section[0] ?? ''),
                'intro' => (string)($section[1] ?? ''),
                'items' => array_values(array_map('strval', (array)($section[2] ?? []))),
            ];
        }
        return $out;
    }
}
