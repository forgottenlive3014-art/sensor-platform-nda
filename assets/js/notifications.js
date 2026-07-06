// ================================================================
// NDA — Sistema de notificaciones (campana global)
// Reutiliza el mismo patron de polling que ya usa el sensor
// (assets/js/app.js, bloque "LECTURAS REALES DEL SENSOR").
// ================================================================
(function () {
    var btn = document.getElementById('ndaNotifBtn');
    var dot = document.getElementById('ndaNotifDot');
    var panel = document.getElementById('ndaNotifPanel');
    var list = document.getElementById('ndaNotifList');
    if (!btn || !panel || !list) return;

    var csrfToken = (document.querySelector('meta[name="csrf-token"]') || {}).content || '';
    var lastId = 0;
    var items = []; // en memoria, mas recientes primero

    function severityRank(sev) {
        return { seguro: 0, informativo: 1, precaucion: 2, alerta: 3, emergencia: 4 }[sev] ?? 1;
    }

    function render() {
        if (items.length === 0) {
            list.innerHTML = '<div class="nda-notif-empty">Sin notificaciones por ahora. Todo en calma.</div>';
            return;
        }
        list.innerHTML = items.map(function (n) {
            return '<div class="nda-notif-item' + (n.leida ? '' : ' unread') + '" data-severidad="' + n.severidad + '" data-id="' + n.notificaciones_id + '">' +
                '<div>' + n.mensaje + '<br><small style="opacity:.6">' + new Date(n.created_at).toLocaleString('es-SV') + '</small></div>' +
                '</div>';
        }).join('');
    }

    function updateBadge() {
        var unread = items.filter(function (n) { return !n.leida; });
        dot.classList.toggle('has-unread', unread.length > 0);

        var worst = unread.reduce(function (acc, n) {
            return severityRank(n.severidad) > severityRank(acc) ? n.severidad : acc;
        }, 'informativo');

        btn.classList.remove('severity-alerta', 'severity-emergencia');
        if (unread.length > 0 && (worst === 'alerta' || worst === 'emergencia')) {
            btn.classList.add('severity-' + worst);
        }
    }

    async function poll() {
        try {
            var res = await fetch('?url=notifications/latest&since_id=' + lastId);
            var data = await res.json();
            if (data.notifications && data.notifications.length) {
                // Se agregan al inicio (mas recientes primero), tope de 30 en memoria.
                items = data.notifications.reverse().concat(items).slice(0, 30);
                render();
            }
            if (data.last_id) lastId = data.last_id;
            updateBadge();
        } catch (e) { /* silencioso — no debe romper el resto del sitio */ }
    }

    btn.addEventListener('click', function () {
        panel.classList.toggle('open');
    });

    document.addEventListener('click', function (e) {
        if (!panel.contains(e.target) && e.target !== btn && !btn.contains(e.target)) {
            panel.classList.remove('open');
        }
    });

    list.addEventListener('click', function (e) {
        var item = e.target.closest('.nda-notif-item');
        if (!item || !item.classList.contains('unread')) return;
        var id = item.dataset.id;
        item.classList.remove('unread');
        var n = items.find(function (x) { return String(x.notificaciones_id) === String(id); });
        if (n) n.leida = true;
        updateBadge();

        fetch('?url=notifications/mark-read', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-Token': csrfToken },
            body: JSON.stringify({ id: id, csrf_token: csrfToken })
        }).catch(function () {});
    });

    // ---- Bandeja de entrada (historial completo, paginado) ----
    var inboxList = document.getElementById('ndaNotifInboxList');
    var pagination = document.getElementById('ndaNotifPagination');
    var inboxPage = 1;

    function severityLabel(sev) {
        return { seguro: 'Seguro', informativo: 'Informativo', precaucion: 'Precaución', alerta: 'Alerta', emergencia: 'Emergencia' }[sev] || sev;
    }

    async function loadInbox(page) {
        if (!inboxList) return;
        inboxPage = page || 1;
        inboxList.innerHTML = '<div class="nda-notif-empty">Cargando historial...</div>';
        try {
            var res = await fetch('?url=notifications/inbox&page=' + inboxPage + '&per_page=15');
            var data = await res.json();
            var rows = data.data || [];
            if (rows.length === 0) {
                inboxList.innerHTML = '<div class="nda-notif-empty">Sin notificaciones en tu historial.</div>';
                pagination.style.display = 'none';
                return;
            }
            inboxList.innerHTML = rows.map(function (n) {
                return '<div class="nda-notif-item' + (n.leida ? '' : ' unread') + '" data-severidad="' + n.severidad + '">' +
                    '<div>' + n.mensaje +
                    '<br><small style="opacity:.6">' + severityLabel(n.severidad) + ' · ' + new Date(n.created_at).toLocaleString('es-SV') + '</small></div>' +
                    '</div>';
            }).join('');

            if (data.total_pages > 1) {
                pagination.style.display = 'flex';
                pagination.innerHTML =
                    '<button' + (data.page <= 1 ? ' disabled' : '') + ' onclick="ndaLoadNotifInboxPage(' + (data.page - 1) + ')">&laquo;</button>' +
                    '<span>' + data.page + ' / ' + data.total_pages + '</span>' +
                    '<button' + (data.page >= data.total_pages ? ' disabled' : '') + ' onclick="ndaLoadNotifInboxPage(' + (data.page + 1) + ')">&raquo;</button>';
            } else {
                pagination.style.display = 'none';
            }
        } catch (e) {
            inboxList.innerHTML = '<div class="nda-notif-empty">Error al cargar el historial.</div>';
        }
    }

    window.ndaLoadNotifInboxPage = function (page) { loadInbox(page); };

    window.ndaShowNotifTab = function (tab) {
        var tabRecent = document.getElementById('ndaNotifTabRecent');
        var tabInbox = document.getElementById('ndaNotifTabInbox');
        if (tab === 'inbox') {
            tabRecent.classList.remove('active');
            tabInbox.classList.add('active');
            list.style.display = 'none';
            inboxList.style.display = '';
            loadInbox(1);
        } else {
            tabInbox.classList.remove('active');
            tabRecent.classList.add('active');
            list.style.display = '';
            inboxList.style.display = 'none';
            pagination.style.display = 'none';
        }
    };

    poll();
    setInterval(poll, 15000);
})();
