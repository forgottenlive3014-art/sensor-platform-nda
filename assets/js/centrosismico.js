
//  CENTRO SISMICO — estacion propia (sensor MPU6050)
//  Consume las APIs ya funcionando en /CentroSismico/API/*.php y las pinta
//  reutilizando el look & feel del resto del sitio (paleta de variables CSS,
//  tarjetas .sg-main-card / .smc / .qfi). Este archivo se carga antes que
//  app.js, asi que no depende de sus helpers (ndaSetText, escapeHtml, etc.).

(function () {
    const waveEl = document.getElementById('csiWave');
    if (!waveEl) return; // esta pagina no tiene el widget de Centro Sismico

    const API_BASE = 'CentroSismico/API/';

    function escapeHtmlLocal(str) {
        const div = document.createElement('div');
        div.textContent = str == null ? '' : str;
        return div.innerHTML;
    }

    function setText(id, val) {
        const el = document.getElementById(id);
        if (el) el.textContent = val;
    }
    function setHtml(id, val) {
        const el = document.getElementById(id);
        if (el) el.innerHTML = val;
    }
    function cssVar(name, fallback) {
        const v = getComputedStyle(document.documentElement).getPropertyValue(name).trim();
        return v || fallback;
    }

    // Clasificacion de nivel -> clase visual (mismos tonos que el feed de USGS)
    function nivelClase(nivel) {
        switch ((nivel || '').toUpperCase()) {
            case 'MODERADO': return 'mm';
            case 'FUERTE': return 'mh';
            case 'TERREMOTO': return 'mx';
            default: return 'ml'; // LEVE / MICRO SISMO / desconocido
        }
    }

    function ejePredominante(fila) {
        const ejes = { X: Math.abs(fila.ax || 0), Y: Math.abs(fila.ay || 0), Z: Math.abs(fila.az || 0) };
        return Object.keys(ejes).reduce((a, b) => (ejes[a] >= ejes[b] ? a : b));
    }

    //  1. SEÑAL EN VIVO (canvas manual, animado como el sketch de Processing:
    //  un buffer circular que se desplaza una muestra a la vez + un loop de
    //  dibujo aparte a 60fps, en vez de redibujar solo cuando llega un fetch)
    const waveCtx = waveEl.getContext('2d');
    const BUFFER_SIZE = 140; // ~14s de historia a 10 lecturas/seg — mas corto = trazo mas veloz
    const buf = {
        x: new Array(BUFFER_SIZE).fill(0),
        y: new Array(BUFFER_SIZE).fill(0),
        z: new Array(BUFFER_SIZE).fill(0)
    };
    let ultimoTs = null;
    let bufferListo = false;

    // Processing se ve fluido porque el serial le entrega una muestra nueva
    // cada ~20ms y draw() repinta esa posición 60 veces/seg. Aquí el dato real
    // solo llega cada ~100ms (limite del puente Processing->API), asi que sin
    // ayuda el trazo se ve "a saltos" cada vez que llega un fetch. Para
    // disimularlo, todo el trazo se desliza en subpixeles frame a frame entre
    // una llegada de datos y la siguiente (como un papel de sismógrafo que
    // avanza continuo), no de golpe cuando cambia el buffer.
    const INTERVALO_NOMINAL_MS = 100;
    let ultimoCommit = performance.now();

    // Equivalente a actualizar() en Graficas.pde: recorre el arreglo y mete
    // el valor nuevo al final, tal cual el sketch de Processing.
    function empujar(eje, valor) {
        buf[eje].shift();
        buf[eje].push(valor || 0);
    }

    // getComputedStyle() fuerza un recalculo de estilos: llamarlo 4 veces por
    // frame a 60fps era una causa directa de los tirones. Se lee una vez y
    // solo se refresca cuando cambia el tema claro/oscuro.
    const colores = { bg3: '', acc: '', teal: '', blue: '' };
    function refrescarColores() {
        colores.bg3 = cssVar('--bg3', '#071f33');
        colores.acc = cssVar('--acc', '#c98a3d');
        colores.teal = cssVar('--teal', '#3d7d73');
        colores.blue = cssVar('--blue', '#3d6f8f');
    }
    refrescarColores();
    new MutationObserver(refrescarColores).observe(document.documentElement, { attributes: true, attributeFilter: ['data-theme'] });

    function resizeWave() {
        waveEl.width = waveEl.offsetWidth;
        waveEl.height = waveEl.clientHeight || 186;
    }
    resizeWave();
    window.addEventListener('resize', resizeWave);

    // Un carril por eje (como un sismógrafo de 3 canales), cada uno con su
    // propia línea base — así no se encima X/Y/Z como pasaba en un solo trazo.
    function drawWave() {
        const w = waveEl.width, h = waveEl.height;
        if (!w || !h) return;
        waveCtx.clearRect(0, 0, w, h);
        waveCtx.fillStyle = colores.bg3;
        waveCtx.fillRect(0, 0, w, h);

        const lanes = [
            { label: 'X', data: buf.x, color: colores.acc },
            { label: 'Y', data: buf.y, color: colores.teal },
            { label: 'Z', data: buf.z, color: colores.blue }
        ];
        const laneH = h / lanes.length;
        const ampPx = laneH / 2 - 8; // px disponibles a cada lado de la línea base
        const gRange = 2.6; // g que ocupan todo ampPx — subido para que el trazo se vea menos exagerado

        // 0 justo despues de un commit -> 1 justo antes del siguiente dato
        // esperado. Desplaza todo el trazo ese % de un paso hacia la
        // izquierda; al llegar el dato real el buffer se desplaza exactamente
        // un paso y el contador vuelve a 0, asi que no hay salto visible.
        const step = w / (buf.x.length - 1);
        const frac = Math.min(1, (performance.now() - ultimoCommit) / INTERVALO_NOMINAL_MS);
        const scrollPx = -frac * step;

        lanes.forEach((lane, idx) => {
            const top = idx * laneH;
            const mid = top + laneH / 2;

            if (idx > 0) {
                waveCtx.strokeStyle = 'rgba(255,255,255,.06)';
                waveCtx.lineWidth = 1;
                waveCtx.beginPath();
                waveCtx.moveTo(0, top);
                waveCtx.lineTo(w, top);
                waveCtx.stroke();
            }

            waveCtx.strokeStyle = 'rgba(255,255,255,.08)';
            waveCtx.setLineDash([4, 4]);
            waveCtx.beginPath();
            waveCtx.moveTo(0, mid);
            waveCtx.lineTo(w, mid);
            waveCtx.stroke();
            waveCtx.setLineDash([]);

            waveCtx.beginPath();
            waveCtx.strokeStyle = lane.color;
            waveCtx.lineWidth = 1.5;
            lane.data.forEach((v, i) => {
                const clamped = Math.max(-gRange, Math.min(gRange, v || 0));
                const x = i * step + scrollPx;
                const y = mid - (clamped / gRange) * ampPx;
                i === 0 ? waveCtx.moveTo(x, y) : waveCtx.lineTo(x, y);
            });
            waveCtx.stroke();

            waveCtx.font = '700 10px "Space Grotesk", sans-serif';
            waveCtx.fillStyle = lane.color;
            waveCtx.fillText(lane.label, 8, top + 13);
        });
    }

    //  2. ESTADO DE CONEXION
    function setEstado(online) {
        const badge = document.getElementById('csiStatusBadge');
        const liveTag = document.getElementById('csiLiveTag');
        if (badge) {
            badge.classList.toggle('active', online);
            badge.classList.toggle('offline', !online);
            badge.innerHTML = '<span class="live-dot"></span>' + (online ? 'Estación en línea' : 'Estación desconectada');
        }
        if (liveTag) liveTag.style.display = online ? '' : 'none';
    }

    //  3. SEÑAL CRUDA (lecturas)
    // Igual que serialEvent() en Sismografo.pde: cada lectura nueva entra por
    // un extremo del buffer y empuja afuera la más vieja (no se reemplaza la
    // ventana completa), así el trazo se desliza en vez de saltar de golpe.
    async function cargarLecturas() {
        try {
            const r = await fetch(API_BASE + 'obtener_lecturas.php', { cache: 'no-store' });
            if (!r.ok) throw new Error('http ' + r.status);
            const datos = await r.json();
            if (!Array.isArray(datos)) throw new Error('respuesta invalida');

            if (datos.length) {
                const nuevas = (bufferListo && ultimoTs)
                    ? datos.filter((d) => d.ts > ultimoTs)
                    : datos.slice(-BUFFER_SIZE);

                nuevas.forEach((d) => {
                    empujar('x', d.ax);
                    empujar('y', d.ay);
                    empujar('z', d.az);
                });

                if (nuevas.length) ultimoCommit = performance.now();
                bufferListo = true;
                ultimoTs = datos[datos.length - 1].ts;

                const ultima = datos[datos.length - 1];
                setText('csiEjeMax', ejePredominante(ultima));
            }

            setText('csiSamplesLabel', 'buffer ~' + (BUFFER_SIZE / 10).toFixed(0) + 's');
            setEstado(true);
        } catch (e) {
            setEstado(false);
        }
    }

    // Loop de dibujo aparte del fetch, como draw() en Processing corriendo a
    // 60fps: siempre repinta el estado actual del buffer, así el trazo se ve
    // fluido aunque el próximo dato tarde unos ms más en llegar.
    (function loopDibujo() {
        drawWave();
        requestAnimationFrame(loopDibujo);
    })();

    //  4. EVENTOS SISMICOS (feed)
    async function cargarEventos() {
        try {
            const r = await fetch(API_BASE + 'obtener_sismo.php', { cache: 'no-store' });
            if (!r.ok) throw new Error('http ' + r.status);
            const datos = await r.json();
            if (!Array.isArray(datos)) throw new Error('respuesta invalida');

            actualizarEstado(datos);
            actualizarFeed(datos);
            setEstado(true);
        } catch (e) {
            if (!document.getElementById('csiFeed').dataset.loaded) {
                setHtml('csiFeed', '<div class="loading-s">⚠️ Estación sin datos aún</div>');
            }
            setEstado(false);
        }
    }

    // Resalta en la leyenda (MICRO SISMO / LEVE / MODERADO / FUERTE / TERREMOTO)
    // el nivel que coincide con la ultima lectura de la estacion.
    function actualizarNivelActivo(nivel) {
        const chips = document.querySelectorAll('.csi-nivel-chip');
        const actual = (nivel || '').toUpperCase();
        chips.forEach((chip) => {
            chip.classList.toggle('active', chip.dataset.nivel === actual);
        });
    }

    // La alerta de pantalla completa (FUERTE / TERREMOTO) es global y vive
    // en assets/js/centrosismico-alerta.js, cargado en todas las paginas
    // desde layout.php — no en este archivo, que solo corre en la pagina
    // del sismografo.
    function actualizarEstado(datos) {
        setText('csiTotal', datos.length);
        if (!datos.length) {
            setText('csiMag', '0.0');
            setText('csiNivel', 'Sin actividad');
            setText('csiMaxMag', '—');
            setText('csiUltimo', '—');
            actualizarNivelActivo(null);
            return;
        }

        const ultimo = datos[0];
        const mag = parseFloat(ultimo.magnitud) || 0;
        setText('csiMag', mag.toFixed(2));
        setText('csiNivel', ultimo.nivel || '—');
        setText('csiUltimo', (ultimo.fecha || '') + ' ' + (ultimo.hora || ''));
        actualizarNivelActivo(ultimo.nivel);

        const maxMag = Math.max(...datos.map((s) => parseFloat(s.magnitud) || 0));
        setText('csiMaxMag', maxMag.toFixed(2));
    }

    //  5. EVENTOS DESTACADOS (lista vertical en el panel lateral)
    function actualizarFeed(datos) {
        const feed = document.getElementById('csiFeed');
        if (!feed) return;
        feed.dataset.loaded = '1';

        if (!datos.length) {
            feed.innerHTML = '<div class="loading-s">Sin eventos detectados todavía</div>';
            feed.style.maxHeight = '';
            return;
        }

        feed.innerHTML = '';
        datos.slice(0, 18).forEach((sismo) => {
            const mag = parseFloat(sismo.magnitud) || 0;
            const cls = nivelClase(sismo.nivel);
            const el = document.createElement('div');
            el.className = 'qfi';
            el.innerHTML =
                '<div class="qfi-mag ' + cls + '">' + mag.toFixed(1) + '</div>' +
                '<div class="qfi-info">' +
                '<div class="qfi-place">' + escapeHtmlLocal(sismo.nivel || 'Evento detectado') + '</div>' +
                '<div class="qfi-meta">' + escapeHtmlLocal((sismo.fecha || '') + ' ' + (sismo.hora || '')) + '</div>' +
                '</div>' +
                '<div class="qfi-depth">Eje ' + escapeHtmlLocal(ejePredominante(sismo)) + '</div>';
            feed.appendChild(el);
        });

        // Cada tarjeta cambia de alto segun el largo del nivel (LEVE vs
        // TERREMOTO), asi que en vez de fijar un max-height a ojo en CSS se
        // mide la posicion real de la 5ta tarjeta: se ven exactamente 4 y de
        // ahi para abajo entra el scroll.
        const filas = feed.children;
        if (filas.length > 4) {
            const quinta = filas[4];
            const alto = quinta.getBoundingClientRect().top - feed.getBoundingClientRect().top + feed.scrollTop;
            feed.style.maxHeight = alto + 'px';
        } else {
            feed.style.maxHeight = '';
        }
    }

    const refreshBtn = document.getElementById('csiRefresh');
    if (refreshBtn) refreshBtn.onclick = cargarEventos;

    cargarLecturas();
    cargarEventos();
    // El puente Processing inserta una lectura cada 100ms (10/seg) — se
    // consulta a ese mismo ritmo para que la señal no se sienta retrasada.
    setInterval(cargarLecturas, 100);
    setInterval(cargarEventos, 2000);
})();
