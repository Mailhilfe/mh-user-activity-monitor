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
      "1. Live-Überwachung für WordPress-Websites",
      "MH User Activity Monitor zeigt in Echtzeit, welche Benutzer, Besucher, WooCommerce-Kunden und Bots gerade auf Ihrer WordPress-Website aktiv sind. Administratoren erhalten eine kompakte Übersicht über aktive Sitzungen, Seitentypen, letzte Aktivität und auffällige Muster.",
      [
        "Die Live-Ansicht hilft, normale Besucheraktivität von ungewöhnlichen Zugriffen zu unterscheiden.",
        "Dashboard-Kacheln, Filter, Sortierung und Live-Aktualisierung erleichtern die kurzfristige technische Überwachung."
      ]
    ],
    [
      "2. WooCommerce-Warenkörbe im Blick behalten",
      "Wenn WooCommerce aktiv ist, kann das Plugin aktive Warenkorb-Sitzungen anzeigen. Je nach Einstellung werden nur die Artikelanzahl, Artikelanzahl und Summe oder Produktdetails gespeichert.",
      [
        "Shop-Betreiber können schneller erkennen, ob Kunden gerade Produkte im Warenkorb haben.",
        "Der Warenkorb-Modus sollte passend zur eigenen Datenschutzstrategie gewählt werden."
      ]
    ],
    [
      "3. Bots und verdächtige Zugriffe erkennen",
      "Das Plugin erkennt bekannte Bots, Crawler, KI-Crawler, SEO-Tools und typische Scanner-Zugriffe. Auffällige Muster wie XML-RPC-, Login-, .env-, .git- oder Injection-Aufrufe werden gesondert markiert.",
      [
        "Die Bot-Erkennung ist eine Orientierungshilfe und keine Firewall.",
        "Rote oder orangefarbene Markierungen sollten geprüft werden, bedeuten aber nicht automatisch einen erfolgreichen Angriff."
      ]
    ],
    [
      "4. Datenschutzfreundliche Einstellungen",
      "Das Plugin verarbeitet technische Besucherdaten nur kurzfristig und bietet Optionen wie IP-Anonymisierung, Datenschutzmodus, automatische Bereinigung, gekürzte User-Agents sowie URLs und Referrer ohne Query-Parameter.",
      [
        "Der Modus „Keinen“ wendet keinen zusätzlichen Datenschutzmodus an und nutzt nur die einzeln aktivierten Einstellungen.",
        "Neue Installationen verwenden standardmäßig anonymisierte IP-Adressen.",
        "Die Modi Standard, Datensparsam und Streng steuern, wie viele technische Daten gespeichert werden.",
        "Der Frontend-Ping kann vollständig deaktiviert oder auf WooCommerce-Seiten begrenzt werden."
      ]
    ],
    [
      "5. Für wen ist das Plugin geeignet?",
      "Das Plugin eignet sich für Betreiber von WordPress-Websites, WooCommerce-Shops, Mitgliederbereichen, Buchungsseiten und redaktionellen Websites, die kurzfristig sehen möchten, was auf ihrer Website gerade passiert.",
      [
        "Typische Einsatzfälle sind aktive Warenkörbe, Checkout-Sitzungen, auffällige Bots, ungewöhnliche Scanner-Zugriffe und technische Supportfälle.",
        "Das Plugin ist besonders hilfreich, wenn keine externen Trackingdienste für die kurzfristige Live-Überwachung eingesetzt werden sollen.",
        "Betreiber sollten prüfen, welche Daten sie wirklich benötigen und ob Hinweise in der Datenschutzerklärung erforderlich sind."
      ]
    ],
    [
      "6. Bot-Erkennung und Ampel",
      "Die Bot-Erkennung unterscheidet bekannte Suchmaschinen, SEO-Tools, KI-Crawler, Social-Media-Vorschauen, Monitoring-Dienste, Scanner und unbekannte Bots. Die Ampel nutzt farbige Punkte ohne englische Textlabels.",
      [
        "Grün ist unauffällig, Gelb beobachtenswert, Orange auffällig und Rot potenziell kritisch.",
        "Viele Aufrufe in kurzer Zeit oder verdächtige URL-Muster können die Einstufung erhöhen."
      ]
    ],
    [
      "7. Datenschutz und Sicherheit",
      "Das Plugin kann IP-Adressen, User-Agents, Referrer, aktuelle URLs, Seitenverläufe und Warenkorbinformationen verarbeiten. Diese Daten sollten nur berechtigten Personen angezeigt werden.",
      [
        "Nutzen Sie IP-Anonymisierung oder Hash-Speicherung, wenn vollständige IPs nicht notwendig sind.",
        "Aktivieren Sie Proxy-Header nur bei einem vertrauenswürdigen Reverse Proxy oder CDN."
      ]
    ],
    [
      "8. Ignorierlisten, Wartung und Fehlerbehebung",
      "Ignorierlisten helfen, interne oder technische Aufrufe auszublenden. Außerdem protokolliert das Plugin Datenbank-Schreibfehler, damit Probleme im PHP- oder WordPress-Debug-Log nachvollziehbar sind.",
      [
        "Typische URL-Ausschlüsse sind /wp-cron.php, /wp-json/, /feed/ oder eigene Monitoring-Endpunkte.",
        "Wenn keine Daten erscheinen, prüfen Sie JavaScript, admin-ajax.php, Cache-Regeln, Firewall-Regeln und WP-Cron."
      ]
    ],
    [
      "9. Neue Datenschutz- und Performance-Funktionen",
      "Aktuelle Versionen enthalten CIDR-Regeln, ausblendbare Admin-Hinweise, abschaltbaren Frontend-Ping, pausierten Admin-Live-Refresh und datensparsame Warenkorb-Modi.",
      [
        "Diese Funktionen reduzieren Last und gespeicherte Daten.",
        "Prüfen Sie die Einstellungen nach Updates, besonders bei WooCommerce und Proxy-Konfigurationen."
      ]
    ],
    [
      "10. Screenshots auf WordPress.org",
      "Die Screenshot-Dateien und die Screenshot-Beschreibungen sind aufeinander abgestimmt, damit WordPress.org den Screenshot-Bereich korrekt anzeigen kann.",
      [
        "Screenshot 1 zeigt die Live-Übersicht aktiver Besucher, Benutzer und Bots im WordPress-Adminbereich.",
        "Screenshot 2 zeigt die Detailansicht einer aktiven Sitzung mit IP-Modus, User-Agent und Seitenverlauf.",
        "Screenshot 3 zeigt die WooCommerce-Warenkorb-Übersicht mit aktiven Warenkorb-Sitzungen.",
        "Screenshot 4 zeigt die Datenschutzeinstellungen mit IP-Anonymisierung, Speicherzeit und Datensparmodus.",
        "Diese Version ist als stabile Fassung gekennzeichnet und wurde vor der Bereitstellung erneut geprüft."
      ]
    ]
  ],
  "en_US": [
    [
      "1. Live monitoring for WordPress websites",
      "MH User Activity Monitor shows in real time which users, visitors, WooCommerce customers and bots are currently active on your WordPress website. Administrators get a compact overview of active sessions, page types, last activity and suspicious patterns.",
      [
        "The live view helps distinguish normal visitor activity from unusual access.",
        "Dashboard cards, filters, sorting and live refresh make short-term technical monitoring easier."
      ]
    ],
    [
      "2. Keep an eye on WooCommerce carts",
      "When WooCommerce is active, the plugin can show active cart sessions. Depending on the setting, it stores only item count, item count and total, or product details.",
      [
        "Shop owners can quickly see whether customers currently have products in their carts.",
        "Choose the cart mode according to your privacy strategy."
      ]
    ],
    [
      "3. Detect bots and suspicious access",
      "The plugin detects known bots, crawlers, AI crawlers, SEO tools and common scanner requests. Suspicious patterns such as XML-RPC, login, .env, .git or injection requests are highlighted.",
      [
        "Bot detection is guidance, not a firewall.",
        "Red or orange indicators should be reviewed but do not automatically mean a successful attack."
      ]
    ],
    [
      "4. Privacy-friendly settings",
      "The plugin processes technical visitor data only temporarily and offers options such as IP anonymization, privacy mode, automatic cleanup, shortened user agents and URLs/referrers without query parameters.",
      [
        "The None mode applies no additional privacy mode and uses only the individually enabled settings.",
        "New installations use anonymized IP addresses by default.",
        "Standard, Data-saving and Strict modes control how much technical data is stored.",
        "The frontend ping can be disabled completely or limited to WooCommerce pages."
      ]
    ],
    [
      "5. Who is this plugin for?",
      "The plugin is suitable for WordPress sites, WooCommerce shops, membership areas, booking pages and editorial websites that want to see what is happening on the site right now.",
      [
        "Typical use cases include active carts, checkout sessions, suspicious bots, unusual scanner access and technical support.",
        "It is useful when no external tracking services should be used for short-term live monitoring.",
        "Site owners should check which data they really need and whether privacy policy notes are required."
      ]
    ],
    [
      "6. Bot detection and traffic light",
      "Bot detection distinguishes search engines, SEO tools, AI crawlers, social previews, monitoring services, scanners and unknown bots. The traffic light uses color dots without English text labels.",
      [
        "Green is normal, yellow should be watched, orange is suspicious and red is potentially critical.",
        "Many requests in a short time or suspicious URL patterns can increase the risk level."
      ]
    ],
    [
      "7. Privacy and security",
      "The plugin can process IP addresses, user agents, referrers, current URLs, page history and cart information. These data should only be visible to authorized users.",
      [
        "Use IP anonymization or hash storage when full IPs are not necessary.",
        "Enable proxy headers only behind a trusted reverse proxy or CDN."
      ]
    ],
    [
      "8. Ignore lists, maintenance and troubleshooting",
      "Ignore lists help hide internal or technical requests. The plugin also logs database write errors so issues can be traced in PHP or WordPress debug logs.",
      [
        "Typical URL exclusions are /wp-cron.php, /wp-json/, /feed/ or custom monitoring endpoints.",
        "If no data appears, check JavaScript, admin-ajax.php, cache rules, firewall rules and WP-Cron."
      ]
    ],
    [
      "9. New privacy and performance features",
      "Recent versions include CIDR rules, dismissible admin notices, a switchable frontend ping, paused admin live refresh and privacy-friendly cart modes.",
      [
        "These features reduce load and stored data.",
        "Review the settings after updates, especially for WooCommerce and proxy configurations."
      ]
    ],
    [
      "10. Screenshots on WordPress.org",
      "The screenshot files and screenshot descriptions are aligned so WordPress.org can display the screenshot section correctly.",
      [
        "Screenshot 1 shows the live overview of active visitors, users and bots in the WordPress admin area.",
        "Screenshot 2 shows the detail view of an active session with IP mode, user agent and page history.",
        "Screenshot 3 shows the WooCommerce cart overview with active cart sessions.",
        "Screenshot 4 shows the privacy settings with IP anonymization, retention time and data-saving mode.",
        "This version is marked as stable and was rechecked before release."
      ]
    ]
  ],
  "fr_FR": [
    [
      "1. Surveillance en direct des sites WordPress",
      "Le plugin affiche en temps réel les sessions actives, les types de pages, la dernière activité et les modèles inhabituels.",
      []
    ],
    [
      "2. Suivre les paniers WooCommerce",
      "Si WooCommerce est actif, les paniers peuvent être affichés selon le mode choisi.",
      []
    ],
    [
      "3. Détecter les bots et les accès suspects",
      "Les bots, crawlers et accès de scanner sont signalés pour une vérification rapide.",
      []
    ],
    [
      "4. Réglages respectueux de la vie privée",
      "Les options limitent les données stockées grâce à l’anonymisation IP, au mode confidentialité et au nettoyage automatique.",
      []
    ],
    [
      "5. À qui s’adresse ce plugin ?",
      "Il convient aux sites WordPress, boutiques WooCommerce, espaces membres, pages de réservation et sites éditoriaux.",
      []
    ],
    [
      "6. Détection des bots et code couleur",
      "Les couleurs indiquent un niveau de risque indicatif et ne remplacent pas une protection de sécurité.",
      []
    ],
    [
      "7. Confidentialité et sécurité",
      "Les données techniques doivent être visibles uniquement pour les personnes autorisées.",
      [
        "Le mode Aucun n’applique aucun mode de confidentialité supplémentaire et utilise uniquement les réglages activés individuellement."
      ]
    ],
    [
      "8. Listes d’exclusion, maintenance et dépannage",
      "Les listes d’exclusion masquent les appels internes ou techniques et facilitent le dépannage.",
      []
    ],
    [
      "9. Nouvelles fonctions de confidentialité et de performance",
      "Les versions récentes réduisent la charge et les données stockées grâce à de nouveaux réglages.",
      []
    ],
    [
      "10. Captures d’écran sur WordPress.org",
      "Les fichiers de capture d’écran et leurs descriptions correspondent afin que WordPress.org puisse afficher correctement la section des captures d’écran.",
      [
        "La capture 1 affiche la vue en direct des visiteurs, utilisateurs et bots actifs dans l’administration WordPress.",
        "La capture 2 affiche le détail d’une session active avec le mode IP, l’agent utilisateur et l’historique des pages.",
        "La capture 3 affiche la vue des paniers WooCommerce avec les sessions de panier actives.",
        "La capture 4 affiche les réglages de confidentialité avec anonymisation IP, durée de conservation et mode économie de données.",
        "Cette version est marquée comme stable et a été vérifiée à nouveau avant publication."
      ]
    ]
  ],
  "es_ES": [
    [
      "1. Supervisión en vivo para sitios WordPress",
      "El plugin muestra en tiempo real las sesiones activas, tipos de página, última actividad y patrones inusuales.",
      []
    ],
    [
      "2. Mantener a la vista los carritos de WooCommerce",
      "Si WooCommerce está activo, los carritos se muestran según el modo configurado.",
      []
    ],
    [
      "3. Detectar bots y accesos sospechosos",
      "Los bots, rastreadores y accesos de escáner se marcan para una revisión rápida.",
      []
    ],
    [
      "4. Ajustes respetuosos con la privacidad",
      "Las opciones reducen los datos guardados mediante anonimización de IP, modo de privacidad y limpieza automática.",
      [
        "El modo Ninguno no aplica ningún modo de privacidad adicional y utiliza solo los ajustes activados individualmente."
      ]
    ],
    [
      "5. ¿Para quién es adecuado el plugin?",
      "Es adecuado para sitios WordPress, tiendas WooCommerce, áreas de miembros, páginas de reservas y sitios editoriales.",
      []
    ],
    [
      "6. Detección de bots y semáforo",
      "Los colores indican un nivel de riesgo orientativo y no sustituyen una protección de seguridad.",
      []
    ],
    [
      "7. Privacidad y seguridad",
      "Los datos técnicos solo deben ser visibles para usuarios autorizados.",
      []
    ],
    [
      "8. Listas de ignorados, mantenimiento y solución de problemas",
      "Las listas de ignorados ocultan accesos internos o técnicos y facilitan el diagnóstico.",
      []
    ],
    [
      "9. Nuevas funciones de privacidad y rendimiento",
      "Las versiones recientes reducen carga y datos almacenados mediante nuevas opciones.",
      []
    ],
    [
      "10. Capturas en WordPress.org",
      "Los archivos de captura y sus descripciones están alineados para que WordPress.org pueda mostrar correctamente la sección de capturas.",
      [
        "La captura 1 muestra la vista en directo de visitantes, usuarios y bots activos en el área de administración de WordPress.",
        "La captura 2 muestra el detalle de una sesión activa con modo de IP, agente de usuario e historial de páginas.",
        "La captura 3 muestra la vista de carritos de WooCommerce con sesiones de carrito activas.",
        "La captura 4 muestra los ajustes de privacidad con anonimización de IP, tiempo de conservación y modo de ahorro de datos.",
        "Esta versión está marcada como estable y se volvió a comprobar antes de su publicación."
      ]
    ]
  ],
  "it_IT": [
    [
      "1. Monitoraggio live per siti WordPress",
      "Il plugin mostra in tempo reale sessioni attive, tipi di pagina, ultima attività e schemi insoliti.",
      []
    ],
    [
      "2. Tenere sotto controllo i carrelli WooCommerce",
      "Se WooCommerce è attivo, i carrelli vengono mostrati in base alla modalità scelta.",
      []
    ],
    [
      "3. Riconoscere bot e accessi sospetti",
      "Bot, crawler e accessi da scanner vengono evidenziati per una verifica rapida.",
      []
    ],
    [
      "4. Impostazioni attente alla privacy",
      "Le opzioni riducono i dati salvati tramite anonimizzazione IP, modalità privacy e pulizia automatica.",
      [
        "La modalità Nessuno non applica alcuna modalità privacy aggiuntiva e usa solo le impostazioni abilitate singolarmente."
      ]
    ],
    [
      "5. Per chi è adatto il plugin?",
      "È adatto a siti WordPress, negozi WooCommerce, aree membri, pagine di prenotazione e siti editoriali.",
      []
    ],
    [
      "6. Rilevamento bot e indicatore a semaforo",
      "I colori indicano un livello di rischio orientativo e non sostituiscono una protezione di sicurezza.",
      []
    ],
    [
      "7. Privacy e sicurezza",
      "I dati tecnici dovrebbero essere visibili solo agli utenti autorizzati.",
      []
    ],
    [
      "8. Liste di esclusione, manutenzione e risoluzione dei problemi",
      "Le liste di esclusione nascondono richieste interne o tecniche e aiutano nella diagnosi.",
      []
    ],
    [
      "9. Nuove funzioni per privacy e prestazioni",
      "Le versioni recenti riducono carico e dati salvati con nuove impostazioni.",
      []
    ],
    [
      "10. Screenshot su WordPress.org",
      "I file degli screenshot e le relative descrizioni sono allineati affinché WordPress.org possa mostrare correttamente la sezione screenshot.",
      [
        "Lo screenshot 1 mostra la panoramica live di visitatori, utenti e bot attivi nell’area di amministrazione WordPress.",
        "Lo screenshot 2 mostra il dettaglio di una sessione attiva con modalità IP, user agent e cronologia delle pagine.",
        "Lo screenshot 3 mostra la panoramica dei carrelli WooCommerce con sessioni carrello attive.",
        "Lo screenshot 4 mostra le impostazioni privacy con anonimizzazione IP, tempo di conservazione e modalità risparmio dati.",
        "Questa versione è contrassegnata come stabile ed è stata ricontrollata prima del rilascio."
      ]
    ]
  ],
  "nl_NL": [
    [
      "1. Live-bewaking voor WordPress-websites",
      "De plugin toont live actieve sessies, paginatypen, laatste activiteit en opvallende patronen.",
      []
    ],
    [
      "2. WooCommerce-winkelwagens in beeld houden",
      "Als WooCommerce actief is, worden winkelwagens weergegeven volgens de gekozen modus.",
      []
    ],
    [
      "3. Bots en verdachte toegang herkennen",
      "Bots, crawlers en scannerverzoeken worden gemarkeerd voor snelle controle.",
      []
    ],
    [
      "4. Privacyvriendelijke instellingen",
      "Opties beperken opgeslagen gegevens met IP-anonimisering, privacymodus en automatische opschoning.",
      [
        "De modus Geen past geen extra privacymodus toe en gebruikt alleen de afzonderlijk ingeschakelde instellingen."
      ]
    ],
    [
      "5. Voor wie is deze plugin geschikt?",
      "Geschikt voor WordPress-sites, WooCommerce-shops, ledenomgevingen, boekingspagina’s en redactionele sites.",
      []
    ],
    [
      "6. Botdetectie en verkeerslicht",
      "Kleuren geven een indicatief risiconiveau weer en vervangen geen beveiligingsoplossing.",
      []
    ],
    [
      "7. Privacy en beveiliging",
      "Technische gegevens mogen alleen zichtbaar zijn voor bevoegde gebruikers.",
      []
    ],
    [
      "8. Negeerlijsten, onderhoud en probleemoplossing",
      "Negeerlijsten verbergen interne of technische verzoeken en helpen bij foutopsporing.",
      []
    ],
    [
      "9. Nieuwe privacy- en prestatiefuncties",
      "Recente versies verminderen belasting en opgeslagen gegevens met nieuwe instellingen.",
      []
    ],
    [
      "10. Screenshots op WordPress.org",
      "De screenshotbestanden en beschrijvingen zijn op elkaar afgestemd zodat WordPress.org de screenshotsectie correct kan tonen.",
      [
        "Screenshot 1 toont het live-overzicht van actieve bezoekers, gebruikers en bots in het WordPress-beheer.",
        "Screenshot 2 toont de detailweergave van een actieve sessie met IP-modus, user-agent en paginageschiedenis.",
        "Screenshot 3 toont het WooCommerce-winkelwagenoverzicht met actieve winkelwagensessies.",
        "Screenshot 4 toont de privacy-instellingen met IP-anonimisering, bewaartijd en databesparende modus.",
        "Deze versie is gemarkeerd als stabiel en is vóór publicatie opnieuw gecontroleerd."
      ]
    ]
  ],
  "pl_PL": [
    [
      "1. Monitorowanie na żywo stron WordPress",
      "Monitorowanie na żywo stron WordPress.",
      []
    ],
    [
      "2. Kontrola koszyków WooCommerce",
      "Kontrola koszyków WooCommerce.",
      []
    ],
    [
      "3. Wykrywanie botów i podejrzanych dostępów",
      "Wykrywanie botów i podejrzanych dostępów.",
      []
    ],
    [
      "4. Ustawienia przyjazne prywatności",
      "Ustawienia przyjazne prywatności.",
      [
        "Tryb Brak nie stosuje dodatkowego trybu prywatności i używa tylko indywidualnie włączonych ustawień."
      ]
    ],
    [
      "5. Dla kogo jest ta wtyczka?",
      "Dla kogo jest ta wtyczka?.",
      []
    ],
    [
      "6. Wykrywanie botów i sygnalizacja kolorami",
      "Wykrywanie botów i sygnalizacja kolorami.",
      []
    ],
    [
      "7. Prywatność i bezpieczeństwo",
      "Prywatność i bezpieczeństwo.",
      []
    ],
    [
      "8. Listy ignorowania, konserwacja i rozwiązywanie problemów",
      "Listy ignorowania, konserwacja i rozwiązywanie problemów.",
      []
    ],
    [
      "9. Nowe funkcje prywatności i wydajności",
      "Nowe funkcje prywatności i wydajności.",
      []
    ],
    [
      "10. Zrzuty ekranu w WordPress.org",
      "Pliki zrzutów ekranu i ich opisy są dopasowane, aby WordPress.org mógł poprawnie wyświetlić sekcję zrzutów ekranu.",
      [
        "Zrzut 1 pokazuje podgląd na żywo aktywnych odwiedzających, użytkowników i botów w panelu WordPress.",
        "Zrzut 2 pokazuje szczegóły aktywnej sesji z trybem IP, user-agentem i historią stron.",
        "Zrzut 3 pokazuje przegląd koszyków WooCommerce z aktywnymi sesjami koszyka.",
        "Zrzut 4 pokazuje ustawienia prywatności z anonimizacją IP, czasem przechowywania i trybem oszczędzania danych.",
        "Ta wersja jest oznaczona jako stabilna i została ponownie sprawdzona przed wydaniem."
      ]
    ]
  ],
  "pt_PT": [
    [
      "1. Monitorização em direto para sites WordPress",
      "Monitorização em direto para sites WordPress.",
      []
    ],
    [
      "2. Acompanhar carrinhos WooCommerce",
      "Acompanhar carrinhos WooCommerce.",
      []
    ],
    [
      "3. Detetar bots e acessos suspeitos",
      "Detetar bots e acessos suspeitos.",
      []
    ],
    [
      "4. Definições amigas da privacidade",
      "Definições amigas da privacidade.",
      [
        "O modo Nenhum não aplica um modo de privacidade adicional e usa apenas as definições ativadas individualmente."
      ]
    ],
    [
      "5. Para quem é este plugin?",
      "Para quem é este plugin?.",
      []
    ],
    [
      "6. Deteção de bots e semáforo",
      "Deteção de bots e semáforo.",
      []
    ],
    [
      "7. Privacidade e segurança",
      "Privacidade e segurança.",
      []
    ],
    [
      "8. Listas de ignorados, manutenção e resolução de problemas",
      "Listas de ignorados, manutenção e resolução de problemas.",
      []
    ],
    [
      "9. Novas funções de privacidade e desempenho",
      "Novas funções de privacidade e desempenho.",
      []
    ],
    [
      "10. Capturas no WordPress.org",
      "Os ficheiros de captura e as respetivas descrições estão alinhados para que o WordPress.org apresente corretamente a secção de capturas.",
      [
        "A captura 1 mostra a visão em direto de visitantes, utilizadores e bots ativos na área de administração do WordPress.",
        "A captura 2 mostra a vista detalhada de uma sessão ativa com modo de IP, agente do utilizador e histórico de páginas.",
        "A captura 3 mostra a visão dos carrinhos WooCommerce com sessões de carrinho ativas.",
        "A captura 4 mostra as definições de privacidade com anonimização de IP, tempo de retenção e modo de poupança de dados.",
        "Esta versão está marcada como estável e foi revista novamente antes da publicação."
      ]
    ]
  ],
  "pt_BR": [
    [
      "1. Monitoramento ao vivo para sites WordPress",
      "Monitoramento ao vivo para sites WordPress.",
      []
    ],
    [
      "2. Acompanhar carrinhos WooCommerce",
      "Acompanhar carrinhos WooCommerce.",
      []
    ],
    [
      "3. Detectar bots e acessos suspeitos",
      "Detectar bots e acessos suspeitos.",
      []
    ],
    [
      "4. Configurações favoráveis à privacidade",
      "Configurações favoráveis à privacidade.",
      [
        "O modo Nenhum não aplica um modo de privacidade adicional e usa apenas as configurações ativadas individualmente."
      ]
    ],
    [
      "5. Para quem este plugin é indicado?",
      "Para quem este plugin é indicado?.",
      []
    ],
    [
      "6. Detecção de bots e semáforo",
      "Detecção de bots e semáforo.",
      []
    ],
    [
      "7. Privacidade e segurança",
      "Privacidade e segurança.",
      []
    ],
    [
      "8. Listas de ignorados, manutenção e solução de problemas",
      "Listas de ignorados, manutenção e solução de problemas.",
      []
    ],
    [
      "9. Novos recursos de privacidade e desempenho",
      "Novos recursos de privacidade e desempenho.",
      []
    ],
    [
      "10. Capturas no WordPress.org",
      "Os arquivos de captura e suas descrições estão alinhados para que o WordPress.org exiba corretamente a seção de capturas.",
      [
        "A captura 1 mostra a visão ao vivo de visitantes, usuários e bots ativos na área administrativa do WordPress.",
        "A captura 2 mostra a visualização detalhada de uma sessão ativa com modo de IP, agente de usuário e histórico de páginas.",
        "A captura 3 mostra a visão geral dos carrinhos WooCommerce com sessões de carrinho ativas.",
        "A captura 4 mostra as configurações de privacidade com anonimização de IP, tempo de retenção e modo de economia de dados.",
        "Esta versão está marcada como estável e foi verificada novamente antes do lançamento."
      ]
    ]
  ],
  "ru_RU": [
    [
      "1. Мониторинг WordPress-сайтов в реальном времени",
      "Мониторинг WordPress-сайтов в реальном времени.",
      []
    ],
    [
      "2. Контроль корзин WooCommerce",
      "Контроль корзин WooCommerce.",
      []
    ],
    [
      "3. Обнаружение ботов и подозрительных обращений",
      "Обнаружение ботов и подозрительных обращений.",
      []
    ],
    [
      "4. Настройки с учетом конфиденциальности",
      "Настройки с учетом конфиденциальности.",
      [
        "Режим «Нет» не применяет дополнительный режим конфиденциальности и использует только отдельно включённые настройки."
      ]
    ],
    [
      "5. Для кого предназначен этот плагин?",
      "Для кого предназначен этот плагин?.",
      []
    ],
    [
      "6. Обнаружение ботов и цветовая индикация",
      "Обнаружение ботов и цветовая индикация.",
      []
    ],
    [
      "7. Конфиденциальность и безопасность",
      "Конфиденциальность и безопасность.",
      []
    ],
    [
      "8. Списки игнорирования, обслуживание и устранение неполадок",
      "Списки игнорирования, обслуживание и устранение неполадок.",
      []
    ],
    [
      "9. Новые функции конфиденциальности и производительности",
      "Новые функции конфиденциальности и производительности.",
      []
    ],
    [
      "10. Скриншоты на WordPress.org",
      "Файлы скриншотов и их описания согласованы, чтобы WordPress.org корректно отображал раздел скриншотов.",
      [
        "Скриншот 1 показывает живой обзор активных посетителей, пользователей и ботов в админке WordPress.",
        "Скриншот 2 показывает подробности активной сессии с режимом IP, user-agent и историей страниц.",
        "Скриншот 3 показывает обзор корзин WooCommerce с активными сессиями корзины.",
        "Скриншот 4 показывает настройки конфиденциальности с анонимизацией IP, сроком хранения и режимом экономии данных.",
        "Эта версия отмечена как стабильная и была повторно проверена перед выпуском."
      ]
    ]
  ],
  "uk": [
    [
      "1. Живий моніторинг сайтів WordPress",
      "Живий моніторинг сайтів WordPress.",
      []
    ],
    [
      "2. Контроль кошиків WooCommerce",
      "Контроль кошиків WooCommerce.",
      []
    ],
    [
      "3. Виявлення ботів і підозрілих доступів",
      "Виявлення ботів і підозрілих доступів.",
      []
    ],
    [
      "4. Налаштування з урахуванням приватності",
      "Налаштування з урахуванням приватності.",
      [
        "Режим «Немає» не застосовує додатковий режим приватності й використовує лише окремо ввімкнені налаштування."
      ]
    ],
    [
      "5. Для кого призначений цей плагін?",
      "Для кого призначений цей плагін?.",
      []
    ],
    [
      "6. Виявлення ботів і кольорова індикація",
      "Виявлення ботів і кольорова індикація.",
      []
    ],
    [
      "7. Приватність і безпека",
      "Приватність і безпека.",
      []
    ],
    [
      "8. Списки ігнорування, обслуговування та усунення несправностей",
      "Списки ігнорування, обслуговування та усунення несправностей.",
      []
    ],
    [
      "9. Нові функції приватності та продуктивності",
      "Нові функції приватності та продуктивності.",
      []
    ],
    [
      "10. Знімки екрана на WordPress.org",
      "Файли знімків екрана та їхні описи узгоджені, щоб WordPress.org правильно відображав розділ знімків екрана.",
      [
        "Знімок 1 показує живий огляд активних відвідувачів, користувачів і ботів в адмінці WordPress.",
        "Знімок 2 показує деталі активної сесії з режимом IP, user-agent і історією сторінок.",
        "Знімок 3 показує огляд кошиків WooCommerce з активними сесіями кошика.",
        "Знімок 4 показує налаштування приватності з анонімізацією IP, часом зберігання і режимом економії даних.",
        "Цю версію позначено як стабільну та повторно перевірено перед випуском."
      ]
    ]
  ],
  "tr_TR": [
    [
      "1. WordPress siteleri için canlı izleme",
      "WordPress siteleri için canlı izleme.",
      []
    ],
    [
      "2. WooCommerce sepetlerini takip edin",
      "WooCommerce sepetlerini takip edin.",
      []
    ],
    [
      "3. Botları ve şüpheli erişimleri algılama",
      "Botları ve şüpheli erişimleri algılama.",
      []
    ],
    [
      "4. Gizlilik dostu ayarlar",
      "Gizlilik dostu ayarlar.",
      [
        "Yok modu ek bir gizlilik modu uygulamaz ve yalnızca ayrı ayrı etkinleştirilen ayarları kullanır."
      ]
    ],
    [
      "5. Bu eklenti kimler için uygundur?",
      "Bu eklenti kimler için uygundur?.",
      []
    ],
    [
      "6. Bot algılama ve trafik ışığı",
      "Bot algılama ve trafik ışığı.",
      []
    ],
    [
      "7. Gizlilik ve güvenlik",
      "Gizlilik ve güvenlik.",
      []
    ],
    [
      "8. Yok sayma listeleri, bakım ve sorun giderme",
      "Yok sayma listeleri, bakım ve sorun giderme.",
      []
    ],
    [
      "9. Yeni gizlilik ve performans özellikleri",
      "Yeni gizlilik ve performans özellikleri.",
      []
    ],
    [
      "10. WordPress.org ekran görüntüleri",
      "Ekran görüntüsü dosyaları ve açıklamaları, WordPress.org ekran görüntüleri bölümünü doğru gösterecek şekilde eşleştirilmiştir.",
      [
        "Ekran görüntüsü 1, WordPress yönetim alanındaki aktif ziyaretçileri, kullanıcıları ve botları canlı olarak gösterir.",
        "Ekran görüntüsü 2, IP modu, kullanıcı aracısı ve sayfa geçmişiyle aktif bir oturumun ayrıntılarını gösterir.",
        "Ekran görüntüsü 3, aktif sepet oturumlarıyla WooCommerce sepet görünümünü gösterir.",
        "Ekran görüntüsü 4, IP anonimleştirme, saklama süresi ve veri tasarrufu modu içeren gizlilik ayarlarını gösterir.",
        "Bu sürüm kararlı olarak işaretlendi ve yayımlanmadan önce yeniden kontrol edildi."
      ]
    ]
  ],
  "ar": [
    [
      "1. مراقبة مباشرة لمواقع ووردبريس",
      "مراقبة مباشرة لمواقع ووردبريس.",
      []
    ],
    [
      "2. متابعة سلال WooCommerce",
      "متابعة سلال WooCommerce.",
      []
    ],
    [
      "3. اكتشاف الروبوتات وعمليات الوصول المشبوهة",
      "اكتشاف الروبوتات وعمليات الوصول المشبوهة.",
      []
    ],
    [
      "4. إعدادات تراعي الخصوصية",
      "إعدادات تراعي الخصوصية.",
      [
        "لا يطبق وضع \"لا شيء\" أي وضع خصوصية إضافي ويستخدم فقط الإعدادات المفعلة بشكل منفرد."
      ]
    ],
    [
      "5. لمن تناسب هذه الإضافة؟",
      "لمن تناسب هذه الإضافة؟.",
      []
    ],
    [
      "6. اكتشاف الروبوتات ومؤشر الألوان",
      "اكتشاف الروبوتات ومؤشر الألوان.",
      []
    ],
    [
      "7. الخصوصية والأمان",
      "الخصوصية والأمان.",
      []
    ],
    [
      "8. قوائم التجاهل والصيانة واستكشاف الأخطاء",
      "قوائم التجاهل والصيانة واستكشاف الأخطاء.",
      []
    ],
    [
      "9. ميزات جديدة للخصوصية والأداء",
      "ميزات جديدة للخصوصية والأداء.",
      []
    ],
    [
      "10. لقطات الشاشة على WordPress.org",
      "تمت مطابقة ملفات لقطات الشاشة مع أوصافها حتى يتمكن WordPress.org من عرض قسم لقطات الشاشة بشكل صحيح.",
      [
        "تعرض اللقطة 1 النظرة الحية للزوار والمستخدمين والروبوتات النشطة في لوحة تحكم WordPress.",
        "تعرض اللقطة 2 تفاصيل جلسة نشطة مع وضع عنوان IP ووكيل المستخدم وسجل الصفحات.",
        "تعرض اللقطة 3 نظرة عامة على سلال WooCommerce مع جلسات سلة نشطة.",
        "تعرض اللقطة 4 إعدادات الخصوصية مع إخفاء عنوان IP ومدة الاحتفاظ ووضع تقليل البيانات.",
        "تم تمييز هذا الإصدار كإصدار مستقر وتمت مراجعته مرة أخرى قبل الإصدار."
      ]
    ]
  ],
  "zh_CN": [
    [
      "1. WordPress 网站实时监控",
      "WordPress 网站实时监控.",
      []
    ],
    [
      "2. 关注 WooCommerce 购物车",
      "关注 WooCommerce 购物车.",
      []
    ],
    [
      "3. 识别机器人和可疑访问",
      "识别机器人和可疑访问.",
      []
    ],
    [
      "4. 注重隐私的设置",
      "注重隐私的设置.",
      [
        "“无”模式不会应用额外的隐私模式，只使用单独启用的设置。"
      ]
    ],
    [
      "5. 这个插件适合谁？",
      "这个插件适合谁？.",
      []
    ],
    [
      "6. 机器人检测和颜色指示",
      "机器人检测和颜色指示.",
      []
    ],
    [
      "7. 隐私和安全",
      "隐私和安全.",
      []
    ],
    [
      "8. 忽略列表、维护和故障排除",
      "忽略列表、维护和故障排除.",
      []
    ],
    [
      "9. 新的隐私和性能功能",
      "新的隐私和性能功能.",
      []
    ],
    [
      "10. WordPress.org 上的截图",
      "截图文件和截图说明已对应，以便 WordPress.org 正确显示截图区域。",
      [
        "截图 1 显示 WordPress 后台中活跃访客、用户和机器人的实时概览。",
        "截图 2 显示带有 IP 模式、用户代理和页面历史的活跃会话详情。",
        "截图 3 显示包含活跃购物车会话的 WooCommerce 购物车概览。",
        "截图 4 显示包含 IP 匿名化、保留时间和节省数据模式的隐私设置。",
        "此版本已标记为稳定版本，并在发布前再次检查。"
      ]
    ]
  ],
  "ja": [
    [
      "1. WordPress サイトのライブ監視",
      "WordPress サイトのライブ監視.",
      []
    ],
    [
      "2. WooCommerce カートを把握",
      "WooCommerce カートを把握.",
      []
    ],
    [
      "3. ボットと疑わしいアクセスを検出",
      "ボットと疑わしいアクセスを検出.",
      []
    ],
    [
      "4. プライバシーに配慮した設定",
      "プライバシーに配慮した設定.",
      [
        "「なし」モードは追加のプライバシーモードを適用せず、個別に有効化された設定のみを使用します。"
      ]
    ],
    [
      "5. このプラグインに適しているサイト",
      "このプラグインに適しているサイト.",
      []
    ],
    [
      "6. ボット検出と色分け表示",
      "ボット検出と色分け表示.",
      []
    ],
    [
      "7. プライバシーとセキュリティ",
      "プライバシーとセキュリティ.",
      []
    ],
    [
      "8. 除外リスト、メンテナンス、トラブルシューティング",
      "除外リスト、メンテナンス、トラブルシューティング.",
      []
    ],
    [
      "9. 新しいプライバシーとパフォーマンス機能",
      "新しいプライバシーとパフォーマンス機能.",
      []
    ],
    [
      "10. WordPress.org のスクリーンショット",
      "スクリーンショットファイルと説明を対応させ、WordPress.org がスクリーンショット欄を正しく表示できるようにしています。",
      [
        "スクリーンショット 1 は、WordPress 管理画面でアクティブな訪問者、ユーザー、ボットのライブ概要を表示します。",
        "スクリーンショット 2 は、IP モード、ユーザーエージェント、ページ履歴を含むアクティブセッションの詳細を表示します。",
        "スクリーンショット 3 は、アクティブなカートセッションを含む WooCommerce カート概要を表示します。",
        "スクリーンショット 4 は、IP 匿名化、保存期間、データ節約モードを含むプライバシー設定を表示します。",
        "このバージョンは安定版としてマークされ、リリース前に再確認されました。"
      ]
    ]
  ],
  "ko_KR": [
    [
      "1. WordPress 웹사이트 실시간 모니터링",
      "WordPress 웹사이트 실시간 모니터링.",
      []
    ],
    [
      "2. WooCommerce 장바구니 확인",
      "WooCommerce 장바구니 확인.",
      []
    ],
    [
      "3. 봇과 의심스러운 접근 감지",
      "봇과 의심스러운 접근 감지.",
      []
    ],
    [
      "4. 개인정보 보호 친화적 설정",
      "개인정보 보호 친화적 설정.",
      [
        "없음 모드는 추가 개인정보 보호 모드를 적용하지 않고 개별적으로 활성화된 설정만 사용합니다."
      ]
    ],
    [
      "5. 이 플러그인이 적합한 경우",
      "이 플러그인이 적합한 경우.",
      []
    ],
    [
      "6. 봇 감지와 신호등 표시",
      "봇 감지와 신호등 표시.",
      []
    ],
    [
      "7. 개인정보 보호와 보안",
      "개인정보 보호와 보안.",
      []
    ],
    [
      "8. 무시 목록, 유지관리 및 문제 해결",
      "무시 목록, 유지관리 및 문제 해결.",
      []
    ],
    [
      "9. 새로운 개인정보 보호 및 성능 기능",
      "새로운 개인정보 보호 및 성능 기능.",
      []
    ],
    [
      "10. WordPress.org 스크린샷",
      "스크린샷 파일과 설명을 맞추어 WordPress.org에서 스크린샷 섹션이 올바르게 표시되도록 했습니다.",
      [
        "스크린샷 1은 WordPress 관리자 영역에서 활성 방문자, 사용자 및 봇의 실시간 개요를 보여줍니다.",
        "스크린샷 2는 IP 모드, 사용자 에이전트 및 페이지 기록이 포함된 활성 세션 상세 정보를 보여줍니다.",
        "스크린샷 3은 활성 장바구니 세션이 있는 WooCommerce 장바구니 개요를 보여줍니다.",
        "스크린샷 4는 IP 익명화, 보관 기간 및 데이터 절약 모드가 포함된 개인정보 설정을 보여줍니다.",
        "이 버전은 안정 버전으로 표시되었으며 릴리스 전에 다시 확인되었습니다."
      ]
    ]
  ],
  "sv_SE": [
    [
      "1. Liveövervakning för WordPress-webbplatser",
      "Liveövervakning för WordPress-webbplatser.",
      []
    ],
    [
      "2. Håll koll på WooCommerce-varukorgar",
      "Håll koll på WooCommerce-varukorgar.",
      []
    ],
    [
      "3. Upptäck botar och misstänkt åtkomst",
      "Upptäck botar och misstänkt åtkomst.",
      []
    ],
    [
      "4. Integritetsvänliga inställningar",
      "Integritetsvänliga inställningar.",
      [
        "Läget Ingen tillämpar inget extra integritetsläge och använder endast de inställningar som aktiverats separat."
      ]
    ],
    [
      "5. Vem passar tillägget för?",
      "Vem passar tillägget för?.",
      []
    ],
    [
      "6. Botdetektering och trafikljus",
      "Botdetektering och trafikljus.",
      []
    ],
    [
      "7. Integritet och säkerhet",
      "Integritet och säkerhet.",
      []
    ],
    [
      "8. Ignoreringslistor, underhåll och felsökning",
      "Ignoreringslistor, underhåll och felsökning.",
      []
    ],
    [
      "9. Nya integritets- och prestandafunktioner",
      "Nya integritets- och prestandafunktioner.",
      []
    ],
    [
      "10. Skärmbilder på WordPress.org",
      "Skärmbildsfilerna och beskrivningarna matchar varandra så att WordPress.org kan visa skärmbildsavsnittet korrekt.",
      [
        "Skärmbild 1 visar liveöversikten över aktiva besökare, användare och botar i WordPress-admin.",
        "Skärmbild 2 visar detaljvyn för en aktiv session med IP-läge, användaragent och sidhistorik.",
        "Skärmbild 3 visar WooCommerce-varukorgsöversikten med aktiva varukorgssessioner.",
        "Skärmbild 4 visar integritetsinställningar med IP-anonymisering, lagringstid och databesparingsläge.",
        "Den här versionen är markerad som stabil och kontrollerades igen före publicering."
      ]
    ]
  ],
  "da_DK": [
    [
      "1. Liveovervågning for WordPress-websteder",
      "Liveovervågning for WordPress-websteder.",
      []
    ],
    [
      "2. Hold øje med WooCommerce-kurve",
      "Hold øje med WooCommerce-kurve.",
      []
    ],
    [
      "3. Registrer bots og mistænkelig adgang",
      "Registrer bots og mistænkelig adgang.",
      []
    ],
    [
      "4. Privatlivsvenlige indstillinger",
      "Privatlivsvenlige indstillinger.",
      [
        "Tilstanden Ingen anvender ingen ekstra privatlivstilstand og bruger kun de individuelt aktiverede indstillinger."
      ]
    ],
    [
      "5. Hvem er pluginet egnet til?",
      "Hvem er pluginet egnet til?.",
      []
    ],
    [
      "6. Botregistrering og trafiklys",
      "Botregistrering og trafiklys.",
      []
    ],
    [
      "7. Privatliv og sikkerhed",
      "Privatliv og sikkerhed.",
      []
    ],
    [
      "8. Ignoreringslister, vedligeholdelse og fejlfinding",
      "Ignoreringslister, vedligeholdelse og fejlfinding.",
      []
    ],
    [
      "9. Nye privatlivs- og ydelsesfunktioner",
      "Nye privatlivs- og ydelsesfunktioner.",
      []
    ],
    [
      "10. Skærmbilleder på WordPress.org",
      "Skærmbilledfilerne og beskrivelserne passer sammen, så WordPress.org kan vise skærmbilledeafsnittet korrekt.",
      [
        "Skærmbillede 1 viser liveoversigten over aktive besøgende, brugere og bots i WordPress-administrationen.",
        "Skærmbillede 2 viser detaljevisningen af en aktiv session med IP-tilstand, user-agent og sidehistorik.",
        "Skærmbillede 3 viser WooCommerce-kurvoversigten med aktive kurvsessioner.",
        "Skærmbillede 4 viser privatlivsindstillinger med IP-anonymisering, opbevaringstid og databesparende tilstand.",
        "Denne version er markeret som stabil og blev kontrolleret igen før udgivelse."
      ]
    ]
  ],
  "cs_CZ": [
    [
      "1. Živé sledování webů WordPress",
      "Živé sledování webů WordPress.",
      []
    ],
    [
      "2. Sledování košíků WooCommerce",
      "Sledování košíků WooCommerce.",
      []
    ],
    [
      "3. Rozpoznání botů a podezřelých přístupů",
      "Rozpoznání botů a podezřelých přístupů.",
      []
    ],
    [
      "4. Nastavení šetrná k soukromí",
      "Nastavení šetrná k soukromí.",
      [
        "Režim Žádný nepoužívá žádný dodatečný režim soukromí a používá pouze jednotlivě zapnutá nastavení."
      ]
    ],
    [
      "5. Pro koho je plugin vhodný?",
      "Pro koho je plugin vhodný?.",
      []
    ],
    [
      "6. Detekce botů a barevná signalizace",
      "Detekce botů a barevná signalizace.",
      []
    ],
    [
      "7. Soukromí a zabezpečení",
      "Soukromí a zabezpečení.",
      []
    ],
    [
      "8. Seznamy ignorování, údržba a řešení problémů",
      "Seznamy ignorování, údržba a řešení problémů.",
      []
    ],
    [
      "9. Nové funkce soukromí a výkonu",
      "Nové funkce soukromí a výkonu.",
      []
    ],
    [
      "10. Snímky obrazovky na WordPress.org",
      "Soubory snímků obrazovky a jejich popisy jsou sladěny, aby WordPress.org správně zobrazil sekci snímků.",
      [
        "Snímek 1 zobrazuje živý přehled aktivních návštěvníků, uživatelů a botů v administraci WordPressu.",
        "Snímek 2 zobrazuje detail aktivní relace s režimem IP, user-agentem a historií stránek.",
        "Snímek 3 zobrazuje přehled košíků WooCommerce s aktivními relacemi košíku.",
        "Snímek 4 zobrazuje nastavení soukromí s anonymizací IP, dobou uchování a úsporným režimem dat.",
        "Tato verze je označena jako stabilní a před vydáním byla znovu zkontrolována."
      ]
    ]
  ],
  "hu_HU": [
    [
      "1. Élő megfigyelés WordPress webhelyekhez",
      "Élő megfigyelés WordPress webhelyekhez.",
      []
    ],
    [
      "2. WooCommerce kosarak figyelése",
      "WooCommerce kosarak figyelése.",
      []
    ],
    [
      "3. Botok és gyanús hozzáférések felismerése",
      "Botok és gyanús hozzáférések felismerése.",
      []
    ],
    [
      "4. Adatvédelembarát beállítások",
      "Adatvédelembarát beállítások.",
      [
        "A Nincs mód nem alkalmaz további adatvédelmi módot, csak az egyenként bekapcsolt beállításokat használja."
      ]
    ],
    [
      "5. Kinek ajánlott ez a bővítmény?",
      "Kinek ajánlott ez a bővítmény?.",
      []
    ],
    [
      "6. Botfelismerés és jelzőlámpa",
      "Botfelismerés és jelzőlámpa.",
      []
    ],
    [
      "7. Adatvédelem és biztonság",
      "Adatvédelem és biztonság.",
      []
    ],
    [
      "8. Mellőzési listák, karbantartás és hibaelhárítás",
      "Mellőzési listák, karbantartás és hibaelhárítás.",
      []
    ],
    [
      "9. Új adatvédelmi és teljesítményfunkciók",
      "Új adatvédelmi és teljesítményfunkciók.",
      []
    ],
    [
      "10. Képernyőképek a WordPress.org oldalon",
      "A képernyőkép-fájlok és leírásaik össze vannak hangolva, hogy a WordPress.org helyesen jelenítse meg a képernyőképek szakaszt.",
      [
        "Az 1. képernyőkép az aktív látogatók, felhasználók és botok élő áttekintését mutatja a WordPress adminban.",
        "A 2. képernyőkép egy aktív munkamenet részleteit mutatja IP móddal, user-agenttel és oldalelőzményekkel.",
        "A 3. képernyőkép a WooCommerce kosáráttekintést mutatja aktív kosár-munkamenetekkel.",
        "A 4. képernyőkép az adatvédelmi beállításokat mutatja IP-anonimizálással, megőrzési idővel és adattakarékos móddal.",
        "Ez a verzió stabilként van megjelölve, és kiadás előtt újra ellenőriztük."
      ]
    ]
  ],
  "ro_RO": [
    [
      "1. Monitorizare live pentru site-uri WordPress",
      "Monitorizare live pentru site-uri WordPress.",
      []
    ],
    [
      "2. Urmărește coșurile WooCommerce",
      "Urmărește coșurile WooCommerce.",
      []
    ],
    [
      "3. Detectează boți și accesări suspecte",
      "Detectează boți și accesări suspecte.",
      []
    ],
    [
      "4. Setări prietenoase cu confidențialitatea",
      "Setări prietenoase cu confidențialitatea.",
      [
        "Modul Niciunul nu aplică un mod suplimentar de confidențialitate și folosește doar setările activate individual."
      ]
    ],
    [
      "5. Pentru cine este potrivit pluginul?",
      "Pentru cine este potrivit pluginul?.",
      []
    ],
    [
      "6. Detectarea boților și semaforul",
      "Detectarea boților și semaforul.",
      []
    ],
    [
      "7. Confidențialitate și securitate",
      "Confidențialitate și securitate.",
      []
    ],
    [
      "8. Liste de ignorare, mentenanță și depanare",
      "Liste de ignorare, mentenanță și depanare.",
      []
    ],
    [
      "9. Funcții noi de confidențialitate și performanță",
      "Funcții noi de confidențialitate și performanță.",
      []
    ],
    [
      "10. Capturi de ecran pe WordPress.org",
      "Fișierele capturilor de ecran și descrierile lor sunt aliniate astfel încât WordPress.org să afișeze corect secțiunea de capturi.",
      [
        "Captura 1 arată prezentarea live a vizitatorilor, utilizatorilor și boților activi în zona de administrare WordPress.",
        "Captura 2 arată detaliile unei sesiuni active cu modul IP, user-agent și istoricul paginilor.",
        "Captura 3 arată prezentarea coșurilor WooCommerce cu sesiuni active de coș.",
        "Captura 4 arată setările de confidențialitate cu anonimizare IP, timp de păstrare și mod de economisire a datelor.",
        "Această versiune este marcată ca stabilă și a fost reverificată înainte de lansare."
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
