// Traductor ES/EN: controla el <select> oculto que inyecta el widget de Google Translate.
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
            // Recargar sin el parametro de idioma es la forma confiable de deshacer la traduccion de Google.
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

    if (current === 'en') {
        findCombo(function (combo) {
            combo.value = 'en';
            combo.dispatchEvent(new Event('change'));
        });
    }

    syncLabel();
})();
