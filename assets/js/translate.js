// Traductor ES/EN propio (sin el widget de Google Translate): se dejo de
// usar porque al pasar el cursor sobre el texto traducido mostraba su
// propio resaltado/tooltip y corria el layout de la pagina.
//
// Traduce los nodos de texto visibles via la API gratuita de MyMemory
// (sin API key, con CORS habilitado), cachea cada frase en localStorage
// para no volver a pedirla en otra pagina o recarga, y para volver a
// español simplemente recarga la pagina (el español real solo vive en el
// HTML que sirve PHP, no hay que reconstruirlo a mano).
(function () {
    var btn = document.getElementById('langBtn');
    var label = document.getElementById('langBtnLabel');
    var mobLabel = document.getElementById('mobLangBtnLabel');
    if (!btn) return;

    var STORAGE_KEY = 'nda-lang';
    var CACHE_KEY = 'nda-translate-cache';
    var current = localStorage.getItem(STORAGE_KEY) || 'es';

    var cache = {};
    try { cache = JSON.parse(localStorage.getItem(CACHE_KEY) || '{}'); } catch (e) { cache = {}; }
    function saveCache() {
        try { localStorage.setItem(CACHE_KEY, JSON.stringify(cache)); } catch (e) { /* localStorage lleno o bloqueado */ }
    }

    function syncLabel() {
        label.textContent = current === 'en' ? 'ES' : 'EN';
        btn.title = current === 'en' ? 'Volver al español' : 'Switch to English';
        if (mobLabel) mobLabel.textContent = label.textContent;
    }

    // Nodos de texto visibles a traducir: se saltan scripts/estilos, campos
    // de formulario y todo lo marcado con data-no-translate (logo, el
    // propio boton de idioma, etc.).
    var SKIP_TAGS = { SCRIPT: 1, STYLE: 1, NOSCRIPT: 1, TEXTAREA: 1, INPUT: 1, SELECT: 1 };
    function collectTextNodes() {
        var walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT, {
            acceptNode: function (node) {
                var parent = node.parentElement;
                if (!parent || SKIP_TAGS[parent.tagName]) return NodeFilter.FILTER_REJECT;
                if (parent.closest('[data-no-translate]')) return NodeFilter.FILTER_REJECT;
                if (!node.nodeValue || !node.nodeValue.trim()) return NodeFilter.FILTER_REJECT;
                return NodeFilter.FILTER_ACCEPT;
            }
        });
        var nodes = [];
        var n;
        while ((n = walker.nextNode())) nodes.push(n);
        return nodes;
    }

    async function translateText(text) {
        if (cache[text]) return cache[text];
        try {
            var url = 'https://api.mymemory.translated.net/get?q=' + encodeURIComponent(text) +
                '&langpair=es|en&de=ndanatural68@gmail.com';
            var res = await fetch(url);
            var data = await res.json();
            var translated = data && data.responseData && data.responseData.translatedText;
            if (!translated || data.responseStatus !== 200) return text;
            cache[text] = translated;
            return translated;
        } catch (e) {
            return text; // sin conexion o la API no respondio: se deja el texto original
        }
    }

    // Traduce de a varias frases a la vez (no todas juntas, para no saturar
    // la API gratuita ni tronar si hay cientos de nodos en la pagina).
    var MAX_CONCURRENT = 4;
    function translatePage() {
        var queue = collectTextNodes();
        var active = 0;
        return new Promise(function (resolve) {
            function pump() {
                if (!queue.length && active === 0) { resolve(); return; }
                while (active < MAX_CONCURRENT && queue.length) {
                    (function (node) {
                        active++;
                        var original = node.nodeValue;
                        var trimmed = original.trim();
                        var lead = original.slice(0, original.indexOf(trimmed));
                        var trail = original.slice(lead.length + trimmed.length);
                        translateText(trimmed).then(function (translated) {
                            node.nodeValue = lead + translated + trail;
                        }).finally(function () {
                            active--;
                            pump();
                        });
                    })(queue.shift());
                }
            }
            pump();
        }).then(saveCache);
    }

    // Contenido que se agrega despues (modales, tarjetas cargadas por AJAX,
    // la burbuja de "dato curioso", etc.) no pasa por translatePage(): un
    // observador traduce cualquier nodo de texto nuevo mientras el idioma
    // siga en ingles, para no dejarlo a medias en español.
    var observer = new MutationObserver(function (mutations) {
        if (current !== 'en') return;
        mutations.forEach(function (m) {
            m.addedNodes.forEach(function (added) {
                if (added.nodeType === Node.TEXT_NODE) {
                    if (added.parentElement && added.parentElement.closest('[data-no-translate]')) return;
                    if (!added.nodeValue.trim()) return;
                    translateText(added.nodeValue.trim()).then(function (translated) {
                        added.nodeValue = added.nodeValue.replace(added.nodeValue.trim(), translated);
                    });
                } else if (added.nodeType === Node.ELEMENT_NODE) {
                    if (SKIP_TAGS[added.tagName] || added.closest('[data-no-translate]')) return;
                    var walker = document.createTreeWalker(added, NodeFilter.SHOW_TEXT, {
                        acceptNode: function (node) {
                            var parent = node.parentElement;
                            if (!parent || SKIP_TAGS[parent.tagName]) return NodeFilter.FILTER_REJECT;
                            if (parent.closest('[data-no-translate]')) return NodeFilter.FILTER_REJECT;
                            if (!node.nodeValue || !node.nodeValue.trim()) return NodeFilter.FILTER_REJECT;
                            return NodeFilter.FILTER_ACCEPT;
                        }
                    });
                    var n;
                    while ((n = walker.nextNode())) {
                        (function (node) {
                            translateText(node.nodeValue.trim()).then(function (translated) {
                                node.nodeValue = node.nodeValue.replace(node.nodeValue.trim(), translated);
                            }).then(saveCache);
                        })(n);
                    }
                }
            });
        });
    });

    btn.addEventListener('click', function () {
        current = current === 'en' ? 'es' : 'en';
        localStorage.setItem(STORAGE_KEY, current);
        syncLabel();
        if (current === 'es') {
            // Recargar sin traducir es la forma confiable de volver al
            // español real (el que vive en el HTML servido por PHP).
            window.location.reload();
            return;
        }
        btn.disabled = true;
        translatePage().finally(function () { btn.disabled = false; });
    });

    if (current === 'en') {
        translatePage();
    }
    observer.observe(document.body, { childList: true, subtree: true });

    syncLabel();
})();
