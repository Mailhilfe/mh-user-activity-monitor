/*!
 * MH User Activity Monitor
 * SPDX-License-Identifier: GPL-2.0-or-later
 */
(function () {
  var storageKey = 'mhuam_page_history';

  function config() {
    return window.MHUAM_FRONTEND || {};
  }

  function shouldPing() {
    var c = config();
    if (!c.ajaxUrl) return false;
    if (c.woocommerceOnly && !c.isWooCommercePage) return false;
    return true;
  }

  function nowTime() {
    var d = new Date();
    return String(d.getHours()).padStart(2, '0') + ':' + String(d.getMinutes()).padStart(2, '0') + ':' + String(d.getSeconds()).padStart(2, '0');
  }

  function pageType() {
    var path = window.location.pathname || '/';
    if (path.indexOf('/cart') !== -1 || path.indexOf('/warenkorb') !== -1) return 'WooCommerce Warenkorb';
    if (path.indexOf('/checkout') !== -1 || path.indexOf('/kasse') !== -1) return 'WooCommerce Kasse';
    if (path.indexOf('/my-account') !== -1 || path.indexOf('/mein-konto') !== -1) return 'WooCommerce Mein Konto';
    return document.body && document.body.classList.contains('single-product') ? 'WooCommerce Produkt' : 'Frontend-Seite';
  }

  function updateHistory() {
    var history = [];
    try {
      history = JSON.parse(window.localStorage.getItem(storageKey) || '[]');
      if (!Array.isArray(history)) history = [];
    } catch (e) {
      history = [];
    }

    var current = {
      time: nowTime(),
      url: window.location.href,
      type: pageType()
    };
    var last = history.length ? history[history.length - 1] : null;
    if (!last || last.url !== current.url) history.push(current);
    history = history.slice(-10);

    try {
      window.localStorage.setItem(storageKey, JSON.stringify(history));
    } catch (e) {}
    return history;
  }

  function ping() {
    if (!shouldPing()) return;
    var c = config();
    var body = new URLSearchParams();
    body.append('action', c.action || 'mhuam_ping');
    body.append('nonce', c.nonce || '');
    body.append('current_url', window.location.href);
    body.append('referrer', document.referrer || '');
    body.append('page_type', pageType());
    body.append('history', JSON.stringify(updateHistory()));
    fetch(c.ajaxUrl, {
      method: 'POST',
      credentials: 'same-origin',
      headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'},
      body: body.toString(),
      keepalive: true
    }).catch(function () {});
  }

  var interval = Math.max(30, Math.min(600, parseInt(config().interval || 60, 10))) * 1000;
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', ping);
  } else {
    ping();
  }
  window.setInterval(ping, interval);
})();
