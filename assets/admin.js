/*!
 * MH User Activity Monitor
 * SPDX-License-Identifier: GPL-2.0-or-later
 */
(function ($) {
  function refreshTable() {
    var tableWrap = $('#mhuam-table-wrap');
    var cardsWrap = $('#mhuam-cards-wrap');
    if (!tableWrap.length || !window.MHUAM_ADMIN) return;
    if (document.hidden) return;
    var params = new URLSearchParams(window.location.search);
    $.post(MHUAM_ADMIN.ajaxUrl, {
      action: 'mhuam_admin_live',
      nonce: MHUAM_ADMIN.nonce,
      mhuam_filter: params.get('mhuam_filter') || 'all',
      orderby: params.get('orderby') || 'last_seen_ts',
      order: params.get('order') || 'DESC',
      paged: params.get('paged') || '1'
    }).done(function (response) {
      if (response && response.success && response.data) {
        if (response.data.cards && cardsWrap.length) {
          cardsWrap.html(response.data.cards);
        }
        if (response.data.table) {
          tableWrap.html(response.data.table);
        }
      }
    });
  }
  $(function () {
    $('#mhuam-trust-proxy').on('change', function () {
      if (this.checked) {
        var msg = this.getAttribute('data-confirm') || 'Proxy headers can be spoofed when no trusted reverse proxy is configured.';
        if (!window.confirm(msg)) {
          this.checked = false;
        }
      }
    });
    if (window.MHUAM_ADMIN && parseInt(MHUAM_ADMIN.refresh, 10) > 0) {
      var mhuamRefreshTimer = window.setInterval(refreshTable, parseInt(MHUAM_ADMIN.refresh, 10) * 1000);
      document.addEventListener('visibilitychange', function () {
        if (!document.hidden) {
          refreshTable();
        }
      });
    }
  });
})(jQuery);
