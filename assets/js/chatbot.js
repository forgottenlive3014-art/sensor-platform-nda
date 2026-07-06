// ============================================================
// CHATBOT NDA — disponible en todas las paginas.
// Guarda el historial en localStorage para que persista al navegar.
// ============================================================
(function () {
    var fab = document.getElementById('ndabotFab');
    var panel = document.getElementById('ndabotPanel');
    var closeBtn = document.getElementById('ndabotClose');
    var messagesEl = document.getElementById('ndabotMessages');
    var form = document.getElementById('ndabotForm');
    var input = document.getElementById('ndabotInput');
    var clearBtn = document.getElementById('ndabotClear');
    var suggestions = document.getElementById('ndabotSuggestions');
    if (!fab || !panel) return;

    var STORAGE_KEY = 'nda-chat-history';
    var history = [];

    // ------------------------------------------------------------
    // Contexto de modulo actual: se resuelve por la ruta (?url=...) y,
    // si estamos en home.php, por el ancla visible del scroll (#sismos,
    // #arduino, #clima...). Se manda junto al mensaje para que el
    // backend pueda responder con el contexto real del usuario.
    // ------------------------------------------------------------
    function currentModule() {
        var params = new URLSearchParams(window.location.search);
        var url = (params.get('url') || 'home').split('/')[0];
        if (url !== 'home') return url;

        var hash = (window.location.hash || '').replace('#', '');
        if (hash) return hash;

        // Si no hay hash en la URL, se usa la ultima seccion de home.php
        // que haya cruzado el centro del viewport (si el propio sitio
        // expone esa variable global; si no, se omite sin romper nada).
        return window.__ndaCurrentSection || null;
    }

    function currentContext() {
        return {
            module: currentModule(),
            hasInstitution: !!window.__ndaHasInstitution,
        };
    }

    function loadHistory() {
        try {
            var raw = localStorage.getItem(STORAGE_KEY);
            history = raw ? JSON.parse(raw) : [];
        } catch (e) {
            history = [];
        }
    }

    function saveHistory() {
        try {
            // Solo guardamos los ultimos 30 mensajes para no crecer indefinidamente.
            localStorage.setItem(STORAGE_KEY, JSON.stringify(history.slice(-30)));
        } catch (e) { /* almacenamiento no disponible, seguimos sin persistir */ }
    }

    function renderMessage(msg) {
        var row = document.createElement('div');
        row.className = 'ndabot-msg ' + (msg.role === 'user' ? 'user' : 'bot');

        var bubble = document.createElement('div');
        bubble.className = 'ndabot-bubble' + (msg.emergency ? ' ndabot-bubble-emergency' : '');
        bubble.textContent = msg.content;
        row.appendChild(bubble);

        if (msg.navigate) {
            var link = document.createElement('a');
            link.className = 'ndabot-navigate';
            link.href = '?url=' + msg.navigate;
            link.textContent = 'Ir a ' + (msg.navigateLabel || 'la sección') + ' ➡️';
            row.appendChild(link);
        }

        messagesEl.appendChild(row);
        messagesEl.scrollTop = messagesEl.scrollHeight;
    }

    function renderAll() {
        messagesEl.innerHTML = '';
        if (history.length === 0) {
            var welcome = document.createElement('div');
            welcome.className = 'ndabot-msg bot';
            var b = document.createElement('div');
            b.className = 'ndabot-bubble';
            b.textContent = 'Hola, soy el asistente de NDA. Puedo explicarte qué hacer ante un desastre, o llevarte directo a cualquier sección del sitio (sismos, clima, gestión escolar, recursos...). ¿En qué te ayudo?';
            welcome.appendChild(b);
            messagesEl.appendChild(welcome);
        } else {
            history.forEach(renderMessage);
        }
    }

    function togglePanel(open) {
        var isOpen = typeof open === 'boolean' ? open : !panel.classList.contains('open');
        panel.classList.toggle('open', isOpen);
        fab.classList.toggle('active', isOpen);
        if (isOpen) {
            input.focus();
            suggestions.style.display = history.length === 0 ? 'flex' : 'none';
        }
    }

    fab.addEventListener('click', function () { togglePanel(); });
    closeBtn.addEventListener('click', function () { togglePanel(false); });

    suggestions.addEventListener('click', function (e) {
        var btn = e.target.closest('button[data-q]');
        if (!btn) return;
        sendMessage(btn.dataset.q);
    });

    clearBtn.addEventListener('click', async function () {
        if (!(await ndaConfirm('¿Borrar todo el historial de este chat?'))) return;
        history = [];
        saveHistory();
        renderAll();
    });

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        var text = input.value.trim();
        if (!text) return;
        input.value = '';
        sendMessage(text);
    });

    async function sendMessage(text) {
        suggestions.style.display = 'none';
        var userMsg = { role: 'user', content: text };
        history.push(userMsg);
        renderMessage(userMsg);
        saveHistory();

        var typing = document.createElement('div');
        typing.className = 'ndabot-msg bot';
        typing.innerHTML = '<div class="ndabot-bubble ndabot-typing"><span></span><span></span><span></span></div>';
        messagesEl.appendChild(typing);
        messagesEl.scrollTop = messagesEl.scrollHeight;

        try {
            var res = await fetch('?url=chat-api', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': (document.querySelector('meta[name="csrf-token"]') || {}).content || ''
                },
                body: JSON.stringify({ message: text, history: history.slice(-8), context: currentContext() })
            });
            var data = await res.json();
            typing.remove();

            var botMsg = { role: 'assistant', content: data.reply || 'No pude responder eso.', emergency: !!data.emergency };
            if (data.navigate) {
                botMsg.navigate = data.navigate;
                botMsg.navigateLabel = data.navigateLabel;
            }
            history.push(botMsg);
            renderMessage(botMsg);
            saveHistory();
            if (data.emergency && panel) {
                panel.classList.add('ndabot-emergency-flash');
                setTimeout(function () { panel.classList.remove('ndabot-emergency-flash'); }, 1200);
            }
        } catch (e) {
            typing.remove();
            var errMsg = { role: 'assistant', content: 'No pude conectarme. Revisa tu conexión e intenta de nuevo.' };
            history.push(errMsg);
            renderMessage(errMsg);
            saveHistory();
        }
    }

    loadHistory();
    renderAll();
})();
