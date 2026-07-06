// ============================================================
// TRADUCTOR ES/EN — controla el <select> oculto que inyecta el
// widget de Google Translate. Este metodo es mucho mas confiable
// que el viejo truco de la cookie "googtrans", que Google dejo de
// respetar de forma consistente en muchos navegadores.
// ============================================================
(function () {
    var btn = document.getElementById('langBtn');
    var label = document.getElementById('langBtnLabel');
    if (!btn) return;

    var STORAGE_KEY = 'nda-lang';
    var current = localStorage.getItem(STORAGE_KEY) || 'es';

    function syncLabel() {
        label.textContent = current === 'en' ? 'ES' : 'EN';
        btn.title = current === 'en' ? 'Volver al español' : 'Switch to English';
    }

    // El widget de Google tarda un momento en inyectar el <select>.
    // Reintentamos hasta encontrarlo (maximo ~5s) antes de rendirnos.
    function findCombo(callback, attemptsLeft) {
        attemptsLeft = attemptsLeft === undefined ? 25 : attemptsLeft;
        var combo = document.querySelector('#google_translate_element select.goog-te-combo');
        if (combo) {
            callback(combo);
        } else if (attemptsLeft > 0) {
            setTimeout(function () { findCombo(callback, attemptsLeft - 1); }, 200);
        } else {
            btn.title = 'Traductor no disponible (revisa tu conexión a internet)';
        }
    }

    function applyLanguage(lang) {
        if (lang === 'es') {
            // Volver al español = idioma original de la pagina.
            // La forma confiable de "deshacer" la traduccion de Google
            // es recargar sin el parametro de idioma activo.
            localStorage.setItem(STORAGE_KEY, 'es');
            document.cookie = 'googtrans=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path=/';
            window.location.reload();
            return;
        }
        findCombo(function (combo) {
            combo.value = lang;
            combo.dispatchEvent(new Event('change'));
            localStorage.setItem(STORAGE_KEY, lang);
        });
    }

    btn.addEventListener('click', function () {
        var next = current === 'en' ? 'es' : 'en';
        current = next;
        syncLabel();
        applyLanguage(next);
    });

    // Si el usuario ya habia elegido ingles en una pagina anterior,
    // lo re-aplicamos automaticamente al cargar esta pagina.
    if (current === 'en') {
        findCombo(function (combo) {
            combo.value = 'en';
            combo.dispatchEvent(new Event('change'));
        });
    }

    syncLabel();
})();
