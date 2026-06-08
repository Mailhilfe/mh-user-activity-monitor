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
      []
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
      []
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
      []
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
      []
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
      []
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
      []
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
      []
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
      []
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
      []
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
      []
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
      []
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
      []
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
      []
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
      []
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
      []
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
      []
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
      []
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
      []
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
      []
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
