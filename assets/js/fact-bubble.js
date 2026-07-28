// Burbuja de "dato curioso": vive fuera del panel del chat (junto al dock)
// y va cambiando de dato sola, apareciendo a intervalos de duracion variable
// para que no se sienta mecanica. Se pausa mientras el chat esta abierto.
(function () {
    var bubble = document.getElementById('ndaFactBubble');
    var textEl = document.getElementById('ndaFactBubbleText');
    var closeBtn = document.getElementById('ndaFactBubbleClose');
    var fab = document.getElementById('ndabotFab');
    var panel = document.getElementById('ndabotPanel');
    if (!bubble || !textEl || !fab) return;

    var FACTS = [
        'El Salvador registra en promedio unos 100 sismos perceptibles al año por la subducción de la Placa de Cocos bajo la Placa del Caribe.',
        'El Salvador es conocido como "La Tierra de los Volcanes": tiene más de 20 volcanes, varios de ellos aún activos.',
        'El terremoto de 2001 (7.7) provocó un gran deslizamiento en Las Colinas, Santa Tecla, uno de los más letales de la historia reciente del país.',
        '"Agáchate, cúbrete y agárrate" es la técnica recomendada mundialmente durante un sismo: nunca salgas corriendo en pleno movimiento.',
        'La escala de Richter mide la energía liberada por un sismo; la de Mercalli mide los daños percibidos, por eso varía según la zona.',
        'Un tsunami puede viajar en mar abierto a más de 700 km/h, tan rápido como un avión comercial, y frenarse solo al llegar a la costa.',
        'El volcán de Izalco fue apodado "El Faro del Pacífico": su actividad casi constante entre 1770 y 1958 servía de guía a los barcos.',
        'Tu mochila de emergencia debería revisarse cada 6 meses: el agua, las medicinas y los documentos pueden caducar o quedar desactualizados.',
        'El Salvador está en el llamado "Cinturón de Fuego del Pacífico", la zona donde ocurre cerca del 90% de los sismos del planeta.',
        'Después de un sismo fuerte pueden ocurrir réplicas por días o semanas: no bajes la guardia solo porque ya pasó el primero.',
        'Guardar copias digitales de tus documentos importantes (DUI, escrituras, pólizas) es tan útil como tener la mochila de emergencia física.',
        'Un simulacro practicado con regularidad reduce muchísimo el tiempo real de reacción de las personas ante un sismo.'
    ];

    var SHOW_MS = 9000;
    var MIN_GAP_MS = 22000;
    var MAX_GAP_MS = 48000;
    var FIRST_DELAY_MIN = 6000;
    var FIRST_DELAY_MAX = 13000;
    var STORAGE_KEY = 'nda-fact-dismissed';

    var pool = [];
    var timer = null;
    var visible = false;
    var dismissed = false;

    try { dismissed = sessionStorage.getItem(STORAGE_KEY) === '1'; } catch (e) {}

    function nextFact() {
        if (pool.length === 0) {
            pool = FACTS.map(function (_, i) { return i; });
            for (var i = pool.length - 1; i > 0; i--) {
                var j = Math.floor(Math.random() * (i + 1));
                var tmp = pool[i]; pool[i] = pool[j]; pool[j] = tmp;
            }
        }
        return FACTS[pool.pop()];
    }

    function randomGap() {
        return MIN_GAP_MS + Math.random() * (MAX_GAP_MS - MIN_GAP_MS);
    }

    function schedule(delay) {
        clearTimeout(timer);
        timer = setTimeout(showBubble, delay);
    }

    function chatOpen() {
        return panel && panel.classList.contains('open');
    }

    function showBubble() {
        if (dismissed) return;
        if (chatOpen()) { schedule(SHOW_MS); return; }
        textEl.textContent = nextFact();
        bubble.classList.add('show');
        visible = true;
        timer = setTimeout(hideBubble, SHOW_MS);
    }

    function hideBubble() {
        bubble.classList.remove('show');
        visible = false;
        if (!dismissed) schedule(randomGap());
    }

    closeBtn.addEventListener('click', function () {
        clearTimeout(timer);
        bubble.classList.remove('show');
        visible = false;
        dismissed = true;
        try { sessionStorage.setItem(STORAGE_KEY, '1'); } catch (e) {}
    });

    fab.addEventListener('click', function () {
        clearTimeout(timer);
        if (visible) { bubble.classList.remove('show'); visible = false; }
    });

    if (!dismissed) {
        schedule(FIRST_DELAY_MIN + Math.random() * (FIRST_DELAY_MAX - FIRST_DELAY_MIN));
    }
})();
