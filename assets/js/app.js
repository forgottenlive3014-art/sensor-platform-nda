
//  NDA - Natural Disaster Alert
//  TODOS LOS SCRIPTS ORDENADOS


// Usado para texto que viene de APIs externas (USGS, etc.) antes de
// insertarlo con innerHTML — el resto del contenido de este archivo es
// data estatica escrita por el equipo, no necesita escape.
function escapeHtml(str) {
    const div = document.createElement('div');
    div.textContent = str == null ? '' : str;
    return div.innerHTML;
}


//  0. AVISOS EN LA PÁGINA (reemplaza alert()/confirm() nativos del navegador)


// Contenedor de toasts (esquina superior derecha). Se crea una sola vez.
function ndaToastContainer() {
    var el = document.getElementById('ndaToastContainer');
    if (!el) {
        el = document.createElement('div');
        el.id = 'ndaToastContainer';
        el.className = 'nda-toast-container';
        document.body.appendChild(el);
    }
    return el;
}

// Reemplaza alert(): muestra un aviso no bloqueante dentro de la página.
function ndaAlert(message, type) {
    type = type || 'info';
    var container = ndaToastContainer();
    var toast = document.createElement('div');
    toast.className = 'nda-toast nda-toast-' + type;
    toast.innerHTML = '<span class="nda-toast-msg">' + message + '</span><button class="nda-toast-close" aria-label="Cerrar">&times;</button>';
    container.appendChild(toast);
    requestAnimationFrame(function () { toast.classList.add('show'); });

    function remove() {
        toast.classList.remove('show');
        setTimeout(function () { toast.remove(); }, 200);
    }
    toast.querySelector('.nda-toast-close').addEventListener('click', remove);
    setTimeout(remove, 5000);
}

// Reemplaza confirm(): devuelve una Promise<boolean> con un dialogo dentro
// de la página (no la ventana predeterminada del navegador).
function ndaConfirm(message) {
    return new Promise(function (resolve) {
        var overlay = document.createElement('div');
        overlay.className = 'nda-confirm-overlay';
        overlay.innerHTML =
            '<div class="nda-confirm-box">' +
            '<p>' + message + '</p>' +
            '<div class="nda-confirm-actions">' +
            '<button class="btn-acc nda-confirm-yes">Aceptar</button>' +
            '<button class="btn-out nda-confirm-no">Cancelar</button>' +
            '</div></div>';
        document.body.appendChild(overlay);
        requestAnimationFrame(function () { overlay.classList.add('show'); });

        function close(result) {
            overlay.classList.remove('show');
            setTimeout(function () { overlay.remove(); }, 200);
            resolve(result);
        }
        overlay.querySelector('.nda-confirm-yes').addEventListener('click', function () { close(true); });
        overlay.querySelector('.nda-confirm-no').addEventListener('click', function () { close(false); });
        overlay.addEventListener('click', function (e) { if (e.target === overlay) close(false); });
    });
}

// ensureCesiumLoaded() vive en el <head> de views/layout.php (ver ahi el
// porque): tiene que estar disponible antes de que se ejecute hero-globe.js,
// que corre embebido en home.php antes de que este mismo archivo cargue.


//  1. THEME & NAV


function syncThemeIcon() {
    var isLight = document.documentElement.getAttribute('data-theme') === 'light';
    var moon = document.getElementById('themeIcoMoon');
    var sun = document.getElementById('themeIcoSun');
    if (moon && sun) {
        moon.style.display = isLight ? 'none' : 'block';
        sun.style.display = isLight ? 'block' : 'none';
    }
}
syncThemeIcon();

document.getElementById('themeBtn').onclick = () => {
    var current = document.documentElement.getAttribute('data-theme');
    var next = current === 'light' ? 'dark' : 'light';
    document.documentElement.setAttribute('data-theme', next);
    try { localStorage.setItem('nda-theme', next); } catch (e) {}
    document.cookie = 'nda_theme=' + next + ';path=/;max-age=31536000;SameSite=Lax';
    syncThemeIcon();
};

document.getElementById('hamBtn').onclick = () => {
    document.getElementById('mobNav').classList.toggle('open');
};

const nav = document.getElementById('nav');
const stBtn = document.getElementById('scrollTop');

window.addEventListener('scroll', () => {
    nav.classList.toggle('scrolled', scrollY > 40);
    stBtn.classList.toggle('vis', scrollY > 380);
});

stBtn.onclick = () => window.scrollTo({ top: 0, behavior: 'smooth' });

// Si el navegador restaura esta pagina desde la cache (boton "Atras"
// tras cerrar sesion), forzamos una recarga para pedir el estado real.
window.addEventListener('pageshow', function (e) {
    if (e.persisted) {
        window.location.reload();
    }
});

// Boton "Volver" que aparece en toda pagina menos Inicio (ver .nda-back-btn).
// Si hay historial de navegacion dentro del propio sitio lo usa (conserva
// scroll/estado); si se abrio el link de forma directa, cae a Inicio.
window.ndaGoBack = function () {
    var cameFromSite = document.referrer && document.referrer.indexOf(window.location.origin) === 0;
    if (cameFromSite && window.history.length > 1) {
        window.history.back();
    } else {
        window.location.href = '?url=home';
    }
};

  
//  1B. BANNER DE SIMULACRO EN VIVO (visible en todo el sitio)
  

(function () {
    if (!window.__ndaHasInstitution) return;

    var banner = document.getElementById('drillAlertBanner');
    var text = document.getElementById('drillAlertText');
    if (!banner) return;

    async function checkActiveAlert() {
        try {
            var res = await fetch('?url=school/active-alert');
            var data = await res.json();
            if (data.active && data.drill) {
                text.textContent = 'Simulacro en curso: ' + data.drill.nombre + ' (' + data.drill.tipo + ')';
                banner.style.display = 'flex';
                document.body.classList.add('has-drill-banner');
            } else {
                banner.style.display = 'none';
                document.body.classList.remove('has-drill-banner');
            }
        } catch (e) { /* silencioso: no interrumpir la navegacion */ }
    }

    checkActiveAlert();
    setInterval(checkActiveAlert, 20000);
})();

  
//  2. HERO CANVAS - SEISMIC WAVE BACKGROUND
  

(function() {
    const c = document.getElementById('hcv');
    if (!c) return;
    const ctx = c.getContext('2d');

    function resize() {
        c.width = c.offsetWidth;
        c.height = c.offsetHeight;
    }
    resize();
    window.addEventListener('resize', resize);

    const lines = Array.from({ length: 7 }, (_, i) => ({
        y: 0.12 + i * 0.13,
        phase: Math.random() * Math.PI * 2,
        freq: 0.022 + Math.random() * 0.016,
        amp: 5 + Math.random() * 20,
        speed: 0.011 + Math.random() * 0.009,
        col: i === 3 ? 'rgba(255,77,26,0.32)' : `rgba(255,77,26,${0.03 + i * 0.035})`
    }));

    function draw() {
        ctx.clearRect(0, 0, c.width, c.height);
        lines.forEach(l => {
            l.phase += l.speed;
            ctx.beginPath();
            ctx.strokeStyle = l.col;
            ctx.lineWidth = l.col.includes('.32') ? 1.5 : 0.9;
            for (let x = 0; x < c.width; x++) {
                const y = c.height * l.y +
                    Math.sin(x * l.freq + l.phase) * l.amp +
                    Math.sin(x * l.freq * 2.2 + l.phase * 1.7) * l.amp * 0.3;
                x === 0 ? ctx.moveTo(x, y) : ctx.lineTo(x, y);
            }
            ctx.stroke();
        });
        requestAnimationFrame(draw);
    }
    draw();
})();

  
//  3. HERO SEISMOGRAPH
  

(function() {
    const c = document.getElementById('heroSg');
    if (!c) return;
    const ctx = c.getContext('2d');
    let data = Array(300).fill(43),
        t = 0;

    function resize() {
        c.width = c.offsetWidth;
        c.height = 86;
    }
    resize();
    window.addEventListener('resize', resize);

    function draw() {
        ctx.clearRect(0, 0, c.width, c.height);
        ctx.fillStyle = '#0b1020';
        ctx.fillRect(0, 0, c.width, c.height);

        ctx.strokeStyle = 'rgba(255,255,255,.03)';
        ctx.lineWidth = 1;
        for (let y = 0; y < c.height; y += 14) {
            ctx.beginPath();
            ctx.moveTo(0, y);
            ctx.lineTo(c.width, y);
            ctx.stroke();
        }

        const n = (Math.random() - 0.5) * 4 + Math.sin(t * 0.08) * 3 + Math.sin(t * 0.19) * 1.5;
        data.push(c.height / 2 + n);
        data.shift();

        ctx.beginPath();
        ctx.strokeStyle = '#ff4d1a';
        ctx.lineWidth = 1.4;
        const step = c.width / data.length;
        data.forEach((v, i) => {
            i === 0 ? ctx.moveTo(0, v) : ctx.lineTo(i * step, v);
        });
        ctx.stroke();

        t++;
        requestAnimationFrame(draw);
    }
    draw();
})();

  
//  4. MAIN SEISMOGRAPH
  

let sgCurrentMag = 3,
    sgT = 0;

(function() {
    const c = document.getElementById('mainSg');
    if (!c) return;
    const ctx = c.getContext('2d');
    let data = Array(500).fill(70);
    const cols = {
        low: '#ff4d1a',
        mid: '#ff9900',
        high: '#ff2d4a',
        critical: '#ff0a30'
    };

    function resize() {
        c.width = c.offsetWidth;
        c.height = 140;
    }
    resize();
    window.addEventListener('resize', resize);

    function draw() {
        ctx.clearRect(0, 0, c.width, c.height);
        ctx.fillStyle = '#080c18';
        ctx.fillRect(0, 0, c.width, c.height);

        // Grid
        ctx.strokeStyle = 'rgba(255,255,255,.025)';
        ctx.lineWidth = 1;
        for (let y = 0; y < c.height; y += 20) {
            ctx.beginPath();
            ctx.moveTo(0, y);
            ctx.lineTo(c.width, y);
            ctx.stroke();
        }
        for (let x = 0; x < c.width; x += 50) {
            ctx.beginPath();
            ctx.moveTo(x, 0);
            ctx.lineTo(x, c.height);
            ctx.stroke();
        }

        const amp = Math.pow(10, (sgCurrentMag - 1) / 3) * 2;
        const clampAmp = Math.min(amp, c.height * 0.45);
        const noise = (Math.random() - 0.5) * clampAmp * 2 +
            Math.sin(sgT * 0.06) * clampAmp * 0.7 +
            Math.sin(sgT * 0.14) * clampAmp * 0.4;

        data.push(c.height / 2 + noise);
        data.shift();

        // Gradient fill
        const fillGrad = ctx.createLinearGradient(0, 0, 0, c.height);
        fillGrad.addColorStop(0, 'rgba(255,77,26,.0)');
        fillGrad.addColorStop(0.5, 'rgba(255,77,26,.08)');
        fillGrad.addColorStop(1, 'rgba(255,77,26,.0)');
        ctx.beginPath();
        ctx.fillStyle = fillGrad;
        const step = c.width / data.length;
        data.forEach((v, i) => {
            i === 0 ? ctx.moveTo(0, v) : ctx.lineTo(i * step, v);
        });
        ctx.lineTo(c.width, c.height);
        ctx.lineTo(0, c.height);
        ctx.closePath();
        ctx.fill();

        // Wave line
        ctx.beginPath();
        const col = sgCurrentMag >= 8 ? cols.critical :
            sgCurrentMag >= 7 ? cols.high :
            sgCurrentMag >= 5 ? cols.mid : cols.low;
        ctx.strokeStyle = col;
        ctx.lineWidth = 1.8;
        data.forEach((v, i) => {
            i === 0 ? ctx.moveTo(0, v) : ctx.lineTo(i * step, v);
        });
        ctx.stroke();

        // Glow for strong quakes
        if (sgCurrentMag >= 6) {
            ctx.shadowColor = col;
            ctx.shadowBlur = 6;
            ctx.beginPath();
            ctx.strokeStyle = col + '80';
            ctx.lineWidth = 3;
            data.slice(-50).forEach((v, i) => {
                const x = (data.length - 50 + i) * step;
                i === 0 ? ctx.moveTo(x, v) : ctx.lineTo(x, v);
            });
            ctx.stroke();
            ctx.shadowBlur = 0;
        }

        // Center line
        ctx.strokeStyle = 'rgba(255,255,255,.08)';
        ctx.lineWidth = 1;
        ctx.setLineDash([4, 4]);
        ctx.beginPath();
        ctx.moveTo(0, c.height / 2);
        ctx.lineTo(c.width, c.height / 2);
        ctx.stroke();
        ctx.setLineDash([]);

        sgT++;
        requestAnimationFrame(draw);
    }
    draw();
})();

// SG Controls -- estos botones/slider SOLO cambian la simulacion visual de
// la onda (amplitud, color, velocidad segun magnitud elegida). La profundidad
// y el resto de estadisticas ("ultimo evento", "sismos hoy", etc.) nunca se
// tocan aqui: siempre reflejan el ultimo sismo REAL reportado por el USGS,
// actualizado por loadQuakes() arriba.
document.querySelectorAll('.sg-preset').forEach(btn => {
    btn.onclick = () => {
        document.querySelectorAll('.sg-preset').forEach(b => b.classList.remove('on', 'm3', 'm6', 'm7', 'm85'));
        document.querySelectorAll('.sg-preset').forEach(b => b.classList.add(b.dataset.cls));
        btn.classList.add('on');
        sgCurrentMag = parseFloat(btn.dataset.mag);
        document.getElementById('sgMagSlider').value = sgCurrentMag;
        document.getElementById('sgMagDisp').textContent = sgCurrentMag;
    };
});

if (document.getElementById('sgMagSlider')) {
    document.getElementById('sgMagSlider').oninput = function() {
        sgCurrentMag = parseFloat(this.value);
        document.getElementById('sgMagDisp').textContent = parseFloat(this.value).toFixed(1);
        document.querySelectorAll('.sg-preset').forEach(b => b.classList.remove('on'));
    };
}

if (document.getElementById('sgReset')) {
    document.getElementById('sgReset').onclick = () => {
        sgCurrentMag = 3;
        document.getElementById('sgMagSlider').value = 3;
        document.getElementById('sgMagDisp').textContent = '3';
        document.querySelectorAll('.sg-preset').forEach(b => b.classList.remove('on'));
        document.querySelector('.sg-preset.m3').classList.add('on');
    };
}

if (document.getElementById('simBtn')) {
    document.getElementById('simBtn').onclick = () => {
        sgCurrentMag = 8.5;
        document.getElementById('sgMagSlider').value = 8.5;
        document.getElementById('sgMagDisp').textContent = '8.5';
        document.querySelectorAll('.sg-preset').forEach(b => b.classList.remove('on'));
        document.querySelector('.sg-preset.m85').classList.add('on');
    };
}

  
//  5. MICRO SEISMOGRAPH
  

(function() {
    const c = document.getElementById('microSg');
    if (!c) return;
    const ctx = c.getContext('2d');
    let data = Array(180).fill(27),
        t = 0;

    function resize() {
        c.width = c.offsetWidth;
        c.height = 55;
    }
    resize();
    window.addEventListener('resize', resize);

    function draw() {
        ctx.clearRect(0, 0, c.width, c.height);
        ctx.fillStyle = '#0a0e1a';
        ctx.fillRect(0, 0, c.width, c.height);

        const n = (Math.random() - 0.5) * 2 + Math.sin(t * 0.11) * 1.5;
        data.push(c.height / 2 + n);
        data.shift();

        ctx.beginPath();
        ctx.strokeStyle = 'rgba(0,212,176,.7)';
        ctx.lineWidth = 1.1;
        const step = c.width / data.length;
        data.forEach((v, i) => {
            i === 0 ? ctx.moveTo(0, v) : ctx.lineTo(i * step, v);
        });
        ctx.stroke();

        t++;
        requestAnimationFrame(draw);
    }
    draw();
})();

  
//  6. SISMOS EN VIVO: USGS + EMSC COMBINADOS


// Helpers null-safe: cada pagina del sitio solo tiene un subconjunto de estos
// elementos (el resto vive en otra pagina), asi que nunca asumimos que existen.
function ndaSetText(id, val) {
    const el = document.getElementById(id);
    if (el) el.textContent = val;
}
// Igual que ndaSetText pero para numeros: en vez de reemplazar el texto de
// golpe, cuenta con GSAP desde el valor actual hasta el nuevo (se usa para
// las estadisticas sismicas en vivo -- hero del home y barra de sismos.php
// -- que llegan por API despues de cargar la pagina y se refrescan solas
// cada 30s). prefix/suffix son texto fijo que no se anima (p.ej. "M" o
// " km"). Si GSAP no esta disponible o el valor no es numerico, cae de
// vuelta a texto plano.
function ndaCountTo(id, val, decimals, prefix, suffix) {
    const el = document.getElementById(id);
    if (!el) return;
    prefix = prefix || '';
    suffix = suffix || '';
    const target = parseFloat(val);
    if (typeof gsap === 'undefined' || isNaN(target)) {
        el.textContent = prefix + val + suffix;
        return;
    }
    const currentMatch = el.textContent.match(/-?\d+(\.\d+)?/);
    const obj = { v: currentMatch ? parseFloat(currentMatch[0]) : 0 };
    gsap.to(obj, {
        v: target,
        duration: 0.9,
        ease: 'power1.out',
        onUpdate: () => { el.textContent = prefix + (decimals ? obj.v.toFixed(decimals) : Math.round(obj.v)) + suffix; }
    });
}
function ndaSetHtml(id, val) {
    const el = document.getElementById(id);
    if (el) el.innerHTML = val;
}

// Cajas delimitadoras ajustadas al territorio de El Salvador + la zona de
// subduccion frente a su costa Pacifico (de donde salen la mayoria de los
// sismos que se sienten en el pais). Cada API usa nombres de parametros
// distintos para la misma caja, por eso hay una version por API.
const EL_SALVADOR_BBOX_USGS = 'minlatitude=12.6&maxlatitude=14.6&minlongitude=-90.6&maxlongitude=-87.0';
const EL_SALVADOR_BBOX_EMSC = 'minlat=12.6&maxlat=14.6&minlon=-90.6&maxlon=-87.0';
const REGIONAL_BBOX_USGS = 'minlatitude=8&maxlatitude=18&minlongitude=-95&maxlongitude=-82';
const REGIONAL_BBOX_EMSC = 'minlat=8&maxlat=18&minlon=-95&maxlon=-82';

// Trae sismos del USGS (fdsnws-event, formato geojson estandar: mag, place,
// time en epoch ms, geometry.coordinates=[lon,lat,profundidad_km]).
async function fetchUSGS(bbox, minMag) {
    try {
        const r = await fetch(`https://earthquake.usgs.gov/fdsnws/event/1/query?format=geojson&${bbox}&limit=25&orderby=time&minmagnitude=${minMag}`);
        const d = await r.json();
        const feats = d.features || [];
        feats.forEach(f => { f.properties.source = 'USGS'; });
        return feats;
    } catch (e) {
        return [];
    }
}

// Trae sismos de EMSC (European-Mediterranean Seismological Centre,
// seismicportal.eu) y los normaliza a la misma forma que usa el USGS arriba,
// porque EMSC nombra los campos distinto: "time" es texto ISO (no epoch ms),
// el lugar viene en "flynn_region" (no "place"), y la profundidad real esta
// en "properties.depth" -- NO en geometry.coordinates[2], que EMSC reporta
// en negativo (elevacion) y no coincide con el positivo que usa el USGS.
// En la prueba en vivo, EMSC detecto sismos reales "Offshore El Salvador"
// que el USGS todavia no tenia en su catalogo, por eso se combinan las dos.
async function fetchEMSC(bbox, minMag) {
    try {
        const r = await fetch(`https://www.seismicportal.eu/fdsnws/event/1/query?format=json&${bbox}&limit=25&minmag=${minMag}`);
        const d = await r.json();
        return (d.features || []).map(f => {
            const region = (f.properties.flynn_region || 'Región desconocida')
                .toLowerCase().replace(/(^|\s)\S/g, c => c.toUpperCase());
            const depthKm = f.properties.depth != null ? f.properties.depth : Math.abs((f.geometry.coordinates || [])[2] || 0);
            return {
                id: 'emsc-' + (f.id || f.properties.unid || f.properties.source_id),
                properties: {
                    mag: f.properties.mag || 0,
                    place: region,
                    time: new Date(f.properties.time).getTime(),
                    source: 'EMSC',
                },
                geometry: { coordinates: [f.geometry.coordinates[0], f.geometry.coordinates[1], depthKm] },
            };
        });
    } catch (e) {
        return [];
    }
}

function haversineKm(lat1, lon1, lat2, lon2) {
    const R = 6371;
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a = Math.sin(dLat / 2) ** 2 + Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * Math.sin(dLon / 2) ** 2;
    return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
}

// El mismo sismo real puede aparecer en ambos catalogos con id, hora y
// magnitud ligeramente distintos (cada red lo procesa por separado). Se
// considera "el mismo evento" si ocurrio a menos de 2 minutos de diferencia
// y a menos de 60km de distancia -- en ese caso se queda solo el primero
// (ya viene ordenado por tiempo, no importa cual API lo reporto).
function mergeAndDedupeQuakes(lists) {
    const all = [].concat(...lists);
    all.sort((a, b) => b.properties.time - a.properties.time);
    const kept = [];
    for (const q of all) {
        const isDup = kept.some(k =>
            Math.abs(k.properties.time - q.properties.time) < 120000 &&
            haversineKm(k.geometry.coordinates[1], k.geometry.coordinates[0], q.geometry.coordinates[1], q.geometry.coordinates[0]) < 60
        );
        if (!isDup) kept.push(q);
    }
    return kept;
}

// Recuerda el id del ultimo sismo real ya mostrado, para detectar cuando las
// APIs reportan uno NUEVO entre un poll y el siguiente (p. ej. "acaba de
// temblar") y resaltarlo en vez de solo re-pintar los mismos datos.
let __ndaLastQuakeId = null;

async function loadQuakes() {
    try {
        let [usgsList, emscList] = await Promise.all([
            fetchUSGS(EL_SALVADOR_BBOX_USGS, 1.0),
            fetchEMSC(EL_SALVADOR_BBOX_EMSC, 1.0),
        ]);
        let qs = mergeAndDedupeQuakes([usgsList, emscList]);

        // Si ninguna de las dos APIs tiene suficiente actividad detectada
        // dentro de El Salvador (puede pasar varios dias sin sismos M>=1.0
        // registrados en un area tan pequena), se amplia a la region de
        // Centroamerica -- se marca la fuente real en cada caso, nunca se
        // inventa un numero.
        let regional = false;
        if (qs.length < 3) {
            const [usgsRegional, emscRegional] = await Promise.all([
                fetchUSGS(REGIONAL_BBOX_USGS, 1.5),
                fetchEMSC(REGIONAL_BBOX_EMSC, 1.5),
            ]);
            qs = mergeAndDedupeQuakes([qs, usgsRegional, emscRegional]);
            regional = true;
        }
        if (!qs.length) throw 'empty';
        qs = qs.slice(0, 25);

        ndaSetText('sgSubtitle', regional
            ? 'Estación SSN · San Salvador · 13.692°N, 89.218°W · Región Centroamérica (USGS+EMSC)'
            : 'Estación SSN · San Salvador · 13.692°N, 89.218°W · El Salvador (USGS+EMSC) · EN VIVO');

        const now = Date.now();
        const h24 = qs.filter(q => now - q.properties.time < 86400000).length;
        const maxM = Math.max(...qs.map(q => q.properties.mag || 0));

        // "Ultimo evento" = SIEMPRE el sismo mas reciente por tiempo (qs[0],
        // porque orderby=time trae el mas nuevo primero). Magnitud, lugar y
        // profundidad deben salir todos del MISMO registro -- antes la
        // magnitud mostrada era el maximo del lote (maxM), que podia ser un
        // sismo distinto (mas viejo) al de la ubicacion/profundidad mostrada,
        // pareciendo datos inconsistentes o inventados.
        const last = qs[0];
        const lastMag = last.properties.mag || 0;
        const lastDepth = Math.round(last.geometry?.coordinates?.[2] || 0);
        const lastPlace = (last.properties.place || '').split(' of ').pop()?.slice(0, 25) || '—';

        // Hero stats (pagina Inicio) -- cuentan hacia el valor nuevo en vez
        // de reemplazar el texto de golpe.
        ndaCountTo('hp-quakes', h24);
        ndaCountTo('hm-today', h24);
        ndaCountTo('hm-max', maxM, 1);
        ndaCountTo('hm-depth', lastDepth);
        ndaSetText('h3d-actividad-reciente', h24 > 0
            ? `${h24} sismo${h24 === 1 ? '' : 's'} registrados en las últimas 24 horas cerca de El Salvador, con magnitud máxima de ${maxM.toFixed(1)}.`
            : 'Sin sismos significativos registrados cerca de El Salvador en las últimas 24 horas.');

        // Side stats (pagina Sismos) -- todo sobre el MISMO ultimo evento real.
        ndaCountTo('sc-last', lastMag, 1, 'M');
        ndaCountTo('sc-24h', h24);
        ndaSetHtml('sc-depth', lastDepth + '<span style="font-size:.8rem;color:var(--text3)">km</span>');
        ndaSetText('sc-time', new Date(last.properties.time).toLocaleString('es-SV', { month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' }));

        // SG bar (pagina Sismos) -- profundidad y magnitud SIEMPRE vienen del
        // ultimo sismo real reportado por USGS o EMSC, nunca de un valor
        // inventado segun la magnitud elegida en el simulador (ver botones
        // .sg-preset mas abajo, que ya NO tocan estos campos).
        ndaCountTo('sg-last-mag', lastMag, 1, 'M');
        ndaSetText('sg-last-loc', lastPlace);
        ndaCountTo('sg-today', h24);
        ndaCountTo('sg-depth-v', lastDepth, 0, '', ' km');
        ndaSetText('sg-depth-l', lastDepth <= 15 ? 'corteza superior' : lastDepth <= 40 ? 'corteza media' : 'manto superior / subducción');
        ndaCountTo('sgDepth', lastDepth, 0, '', ' KM');

        // Nav alert (comun a todo el sitio) -- mismo ultimo evento real.
        ndaSetText('navAlertText', `M${lastMag.toFixed(1)} · ${(last.properties.place || '').split(', ')[0]?.slice(0, 15)}`);

        // Marca "actualizado hace..." -- confirma visualmente que esto es un
        // fetch en vivo y no un valor estatico.
        window.__ndaQuakesFetchedAt = Date.now();
        ndaSetText('quakeUpdatedAt', 'actualizado justo ahora');

        // Si el sismo mas reciente cambio desde el ultimo poll, es un evento
        // NUEVO detectado en tiempo real: resalta los stats en vez de solo
        // re-pintarlos en silencio.
        const isNewQuake = __ndaLastQuakeId !== null && last.id !== __ndaLastQuakeId;
        __ndaLastQuakeId = last.id;
        if (isNewQuake) {
            ['sgDepth', 'sg-last-mag', 'sg-depth-v', 'sc-last', 'sc-depth', 'rtm-mag', 'rtm-depth'].forEach(id => {
                const el = document.getElementById(id);
                if (!el) return;
                el.classList.remove('nda-flash');
                void el.offsetWidth; // reinicia la animacion si ya estaba corriendo
                el.classList.add('nda-flash');
            });
        }

        // Feed (pagina Sismos)
        const feed = document.getElementById('quakeFeed');
        if (feed) {
            feed.innerHTML = '';
            qs.slice(0, 18).forEach((q, i) => {
                const m = q.properties.mag || 0;
                const cls = m < 3 ? 'ml' : m < 5 ? 'mm' : 'mh';
                const dep = (q.geometry.coordinates[2] || 0).toFixed(0);
                const tm = new Date(q.properties.time).toLocaleString('es-SV', { month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' });
                const el = document.createElement('div');
                el.className = 'qfi' + (isNewQuake && i === 0 ? ' qfi-new' : '');
                el.innerHTML = `<div class="qfi-mag ${cls}">${m.toFixed(1)}</div>
                                <div class="qfi-info">
                                    <div class="qfi-place">${escapeHtml(q.properties.place || '—')}${isNewQuake && i === 0 ? ' <span class="qfi-new-tag">NUEVO</span>' : ''}</div>
                                    <div class="qfi-meta">${tm} · ${q.properties.source || 'USGS'}</div>
                                </div>
                                <div class="qfi-depth">Prof ${dep}km</div>`;
                feed.appendChild(el);
            });
        }

        if (window._addQuakesToMap) window._addQuakesToMap(qs);
        if (window.updateRTMStats) window.updateRTMStats(qs);

    } catch (e) {
        ndaSetHtml('quakeFeed', '<div class="loading-s">⚠️ Error USGS/EMSC — revisa conexión</div>');
        ndaSetText('navAlertText', 'Sistema activo');
    }
}

// Sondeo automatico: sin esto, un sismo real que ocurra despues de cargar la
// pagina no aparecia hasta que alguien le diera clic manual al boton de
// refrescar. Cada 30s es suficientemente seguido para sentirse "en vivo" sin
// saturar la API publica del USGS.
setInterval(loadQuakes, 30000);

// Cuenta "actualizado hace Xs" en vivo, independiente del poll de 30s.
setInterval(() => {
    if (!window.__ndaQuakesFetchedAt) return;
    const secs = Math.floor((Date.now() - window.__ndaQuakesFetchedAt) / 1000);
    const label = secs < 5 ? 'actualizado justo ahora' : secs < 60 ? `actualizado hace ${secs}s` : `actualizado hace ${Math.floor(secs / 60)} min`;
    ndaSetText('quakeUpdatedAt', label);
}, 1000);

if (document.getElementById('refreshQ')) document.getElementById('refreshQ').onclick = loadQuakes;

  
//  7. PLATE TECTONICS CANVAS
  

(function() {
    const c = document.getElementById('plateCv');
    if (!c) return;
    const ctx = c.getContext('2d');
    const W = c.width,
        H = c.height;
    let t = 0;

    function draw() {
        ctx.clearRect(0, 0, W, H);
        ctx.fillStyle = '#0e1828';
        ctx.fillRect(0, 0, W, H);

        ctx.fillStyle = 'rgba(45,143,255,.5)';
        ctx.font = 'bold 9px Space Grotesk,sans-serif';
        ctx.fillText('Océano Pacífico', 10, 18);

        const shift = Math.sin(t * 0.025) * 5;

        // Cocos plate
        ctx.fillStyle = 'rgba(45,143,255,.18)';
        ctx.strokeStyle = 'rgba(45,143,255,.6)';
        ctx.lineWidth = 1.5;
        ctx.fillRect(12, 35, 130, 75);
        ctx.strokeRect(12, 35, 130, 75);
        ctx.fillStyle = 'rgba(45,143,255,.9)';
        ctx.font = 'bold 11px Space Grotesk,sans-serif';
        ctx.fillText('Placa de Cocos', 18, 80);
        ctx.fillStyle = 'rgba(45,143,255,.6)';
        ctx.font = '10px Space Grotesk,sans-serif';
        ctx.fillText('➡️ ' + Math.round(shift + 8) + 'cm/año', 18, 100);

        // Caribbean plate
        ctx.fillStyle = 'rgba(0,212,176,.15)';
        ctx.strokeStyle = 'rgba(0,212,176,.5)';
        ctx.lineWidth = 1.5;
        ctx.fillRect(100 + shift, 20, 165, 60);
        ctx.strokeRect(100 + shift, 20, 165, 60);
        ctx.fillStyle = 'rgba(0,212,176,.9)';
        ctx.font = 'bold 11px Space Grotesk,sans-serif';
        ctx.fillText('Placa del Caribe', 108 + shift, 46);

        // Subduction zone
        const subX = 100 + shift;
        ctx.strokeStyle = 'rgba(255,77,26,.7)';
        ctx.lineWidth = 2;
        ctx.setLineDash([5, 3]);
        ctx.beginPath();
        ctx.moveTo(subX, 20);
        ctx.lineTo(subX, 110);
        ctx.stroke();
        ctx.setLineDash([]);
        ctx.fillStyle = 'rgba(255,77,26,.8)';
        ctx.font = 'bold 8px Space Grotesk,sans-serif';
        ctx.fillText('zona de', subX + 3, 125);
        ctx.fillText('subducción', subX + 3, 135);

        // Earthquake dots
        const eq = [
            [subX - 15, 95],
            [subX + 8, 78],
            [subX - 5, 108]
        ];
        eq.forEach(([ex, ey], i) => {
            const pulse = Math.abs(Math.sin(t * 0.08 + i * 1.2));
            ctx.fillStyle = `rgba(255,77,26,${0.4 + pulse * 0.5})`;
            ctx.beginPath();
            ctx.arc(ex, ey, 3 + pulse * 2, 0, Math.PI * 2);
            ctx.fill();
        });

        t++;
        requestAnimationFrame(draw);
    }
    draw();
})();

  
//  8. EARTHQUAKE SIMULATOR
  

(function() {
    const magR = document.getElementById('simMag');
    const depR = document.getElementById('simDep');
    const disR = document.getElementById('simDist');
    const c = document.getElementById('simCanvas');
    if (!c) return;
    const ctx = c.getContext('2d');
    let simT = 0,
        simAnim = null,
        isRunning = false;

    function resize() {
        c.width = c.offsetWidth;
        c.height = 310;
    }
    resize();
    window.addEventListener('resize', resize);

    const mercs = [
        'Sin efecto', 'Imperceptible', 'Muy débil', 'Débil',
        'Moderado — vibran ventanas', 'Fuerte — objetos caen',
        'Muy fuerte — daños menores', 'Destructivo — edificios dañados',
        'Grave — colapso parcial', 'Ruinoso — colapso masivo',
        'Catastrófico', 'Devastador', 'Extinción local'
    ];

    function updateParams() {
        const m = parseFloat(magR.value),
            dep = parseInt(depR.value),
            dist = parseInt(disR.value);
        document.getElementById('simMagV').textContent = m.toFixed(1);
        document.getElementById('simDepV').textContent = dep + ' km';
        document.getElementById('simDistV').textContent = dist + ' km';
        document.getElementById('simSceneTitle').textContent = `Ciudad ficticia — ${dist}km del epicentro`;
        document.getElementById('simMagChip').textContent = 'M ' + m.toFixed(1);
        document.getElementById('simMagChip').className = 'chip ' + (m >= 7 ? 'r' : m >= 5 ? 'o' : 'g');

        const mi = Math.round(Math.max(0, Math.min(12, (m - Math.log10(dist + dep * 0.5) * 1.4) * 2.1)));
        const pct = Math.min(100, (mi / 12) * 100);
        document.getElementById('sibFill').style.width = pct + '%';
        document.getElementById('sibVal').textContent = Math.round(pct) + '%';

        const rN = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        document.getElementById('mercalliBox').innerHTML =
            `<strong>Intensidad Mercalli estimada: ${rN[Math.min(11, mi)]}</strong><br>${mercs[mi]}`;
    }

    [magR, depR, disR].forEach(r => r.addEventListener('input', updateParams));
    updateParams();

    function calcAmp() {
        const m = parseFloat(magR.value),
            dep = parseInt(depR.value),
            dist = parseInt(disR.value);
        return Math.max(0.4, (Math.pow(10, m * 0.55) / (dist * 0.7 + dep * 0.4)) * 2.2);
    }

    function drawFrame() {
        const W = c.width,
            H = c.height;
        const amp = calcAmp();
        ctx.clearRect(0, 0, W, H);

        // Sky
        const sky = ctx.createLinearGradient(0, 0, 0, H * 0.62);
        sky.addColorStop(0, amp > 10 ? '#200800' : '#06101f');
        sky.addColorStop(1, amp > 10 ? '#3d1500' : '#091526');
        ctx.fillStyle = sky;
        ctx.fillRect(0, 0, W, H * 0.65);

        // Stars
        if (amp < 8) {
            ctx.fillStyle = 'rgba(255,255,255,.4)';
            [
                [0.1, 0.1],
                [0.22, 0.07],
                [0.42, 0.05],
                [0.62, 0.1],
                [0.82, 0.06],
                [0.93, 0.12]
            ].forEach(([x, y]) => ctx.fillRect(W * x, H * y, 1.5, 1.5));
        }

        // Dust
        if (amp > 12) {
            for (let i = 0; i < 20; i++) {
                ctx.fillStyle = `rgba(180,80,20,${0.08 + Math.random() * 0.1})`;
                ctx.fillRect(Math.random() * W, Math.random() * H * 0.5 + Math.sin(simT * 0.03 + i) * 3, 2, 2);
            }
        }

        // Ground
        const gY = H * 0.65;
        const shk = Math.sin(simT * 0.28) * amp;
        const gGr = ctx.createLinearGradient(0, gY, 0, H);
        gGr.addColorStop(0, amp > 10 ? '#2e0c00' : '#0e2040');
        gGr.addColorStop(1, amp > 10 ? '#160500' : '#06101e');
        ctx.fillStyle = gGr;
        ctx.beginPath();
        ctx.moveTo(0, gY + shk * 0.3);
        for (let x = 0; x < W; x += 3) {
            ctx.lineTo(x, gY + Math.sin(x * 0.07 + simT * 0.22) * amp * 0.55 + shk * 0.3);
        }
        ctx.lineTo(W, H);
        ctx.lineTo(0, H);
        ctx.closePath();
        ctx.fill();

        // Cracks
        if (amp > 14) {
            ctx.strokeStyle = 'rgba(255,60,0,.45)';
            ctx.lineWidth = 1.5;
            [
                [0.18, 0.38],
                [0.52, 0.72],
                [0.76, 0.88]
            ].forEach(([s, e]) => {
                ctx.beginPath();
                ctx.moveTo(W * s + shk * 0.15, gY + 6);
                let cx = W * s;
                while (cx < W * e) {
                    cx += 7;
                    ctx.lineTo(cx + (Math.random() - 0.5) * 5, gY + 6 + (cx - W * s) * 0.32 + (Math.random() - 0.5) * 3);
                }
                ctx.stroke();
            });
        }

        // Buildings
        const bldgs = [
            { x: .07, w: .07, h: .5 }, { x: .16, w: .05, h: .34 }, { x: .23, w: .09, h: .63 },
            { x: .35, w: .06, h: .4 }, { x: .43, w: .1, h: .68 }, { x: .55, w: .06, h: .44 },
            { x: .63, w: .08, h: .57 }, { x: .73, w: .05, h: .37 }, { x: .81, w: .07, h: .5 },
            { x: .9, w: .05, h: .41 }
        ];
        bldgs.forEach((b, i) => {
            const bShk = shk * (1 + i * 0.06);
            const bx = W * b.x + bShk,
                bh = H * 0.58 * b.h,
                by = gY - bh + shk * 0.1,
                bw = W * b.w;
            ctx.save();
            ctx.translate(bx + bw / 2, gY + shk * 0.1);
            ctx.transform(1, Math.sin(simT * 0.28) * (amp * 0.0018), 0, 1, 0, 0);
            ctx.fillStyle = amp > 18 ? '#400a00' : '#0f2240';
            ctx.strokeStyle = amp > 10 ? 'rgba(255,77,26,.45)' : 'rgba(45,143,255,.28)';
            ctx.lineWidth = 1;
            ctx.fillRect(-bw / 2, -bh, bw, bh);
            ctx.strokeRect(-bw / 2, -bh, bw, bh);
            ctx.fillStyle = amp > 15 ? 'rgba(255,120,0,.45)' : 'rgba(100,190,255,.3)';
            for (let wy = -bh + 5; wy < -8; wy += 10) {
                for (let wx = -bw / 2 + 4; wx < bw / 2 - 7; wx += 9) {
                    ctx.fillRect(wx, wy, 4, 5);
                }
            }
            ctx.restore();
            if (amp > 20 && i % 3 === 0) {
                ctx.fillStyle = 'rgba(80,25,5,.8)';
                for (let r = 0; r < 5; r++) {
                    ctx.fillRect(bx + Math.random() * bw, gY - Math.random() * 10 + shk * 0.2, 4 + Math.random() * 5, 3 + Math.random() * 4);
                }
            }
        });

        // Epicenter
        const eX = W * 0.5 + Math.sin(simT * 0.03) * 15,
            eY = gY + 26;
        [50, 100, 155, 210].forEach((r, i) => {
            const op = Math.max(0, 0.6 - i * 0.13 - (simT * 0.012) % 0.5);
            ctx.beginPath();
            ctx.arc(eX, eY, r, 0, Math.PI * 2);
            ctx.strokeStyle = `rgba(255,77,26,${op})`;
            ctx.lineWidth = 1.4;
            ctx.stroke();
        });
        ctx.fillStyle = '#ff4d1a';
        ctx.beginPath();
        ctx.arc(eX, eY, 5, 0, Math.PI * 2);
        ctx.fill();
        ctx.fillStyle = 'rgba(255,77,26,.25)';
        ctx.beginPath();
        ctx.arc(eX, eY, 11, 0, Math.PI * 2);
        ctx.fill();
        ctx.fillStyle = 'rgba(255,255,255,.65)';
        ctx.font = '10px Space Grotesk,sans-serif';
        ctx.fillText('⭐ Epicentro', eX + 13, eY + 4);

        simT++;
        simAnim = requestAnimationFrame(drawFrame);
    }

    document.getElementById('runSim').onclick = () => {
        updateParams();
        if (simAnim) cancelAnimationFrame(simAnim);
        isRunning = true;
        drawFrame();
    };
    drawFrame();
})();

  
//  9. TIMELINE
  

const tlData = [
    {
        year: '1854',
        title: 'Gran Terremoto de San Salvador',
        mag: '~6.5',
        deaths: '~100',
        region: 'San Salvador, Cuscatlán',
        desc: 'Un fuerte terremoto destruyó gran parte de la capital colonial, provocando el colapso de numerosas construcciones de adobe y bahareque. Los daños obligaron a reconstruir gran parte del centro histórico y marcaron uno de los primeros desastres sísmicos registrados en el país.',
        tags: [
            { t: 'Histórico', c: '' },
            { t: 'Adobe', c: 'o' },
            { t: 'San Salvador', c: 'r' }
        ],
        stats: [
            { v: '~6.5', l: 'Magnitud' },
            { v: '~100', l: 'Fallecidos' },
            { v: '1854', l: 'Año' }
        ],
        img: 'assets/media/img/1854.jpg'
    },

    {
        year: '1917',
        title: 'Sismo y Erupción del Santa Ana',
        mag: '~6.7',
        deaths: '~150',
        region: 'Occidente, Sonsonate',
        desc: 'El terremoto coincidió con una intensa actividad volcánica del volcán Santa Ana, causando incendios, derrumbes y graves daños en varias ciudades del occidente del país. El desastre dejó importantes pérdidas materiales y humanas.',
        tags: [
            { t: 'Volcánico', c: 'o' },
            { t: 'Occidente', c: '' },
            { t: 'M6.7', c: 'r' }
        ],
        stats: [
            { v: '~6.7', l: 'Magnitud' },
            { v: '~150', l: 'Fallecidos' },
            { v: '1917', l: 'Año' }
        ],
        img: 'assets/media/img/1917.jpg'
    },

    {
        year: '1965',
        title: 'Terremoto de San Salvador',
        mag: '6.2',
        deaths: '125',
        region: 'San Salvador, La Libertad',
        desc: 'Este sismo ocasionó daños estructurales en edificios públicos, viviendas y carreteras de la capital. La tragedia dejó cientos de víctimas y motivó la implementación de normas de construcción más resistentes a los terremotos.',
        tags: [
            { t: 'M 6.2', c: 'o' },
            { t: 'Capital', c: '' },
            { t: 'Normativa', c: 't' }
        ],
        stats: [
            { v: '6.2', l: 'Magnitud' },
            { v: '125', l: 'Fallecidos' },
            { v: '1965', l: 'Año' }
        ],
        img: 'assets/media/img/1965.jpg'
    },

    {
        year: '1986',
        title: '10 de Octubre: El Gran Sismo',
        mag: '5.7',
        deaths: '1,500',
        region: 'San Salvador, AMSS',
        desc: 'Ocurrido a las 11:49 a. m., el terremoto tuvo un epicentro muy cercano a la capital y una profundidad reducida, lo que provocó el colapso de edificios, miles de heridos y más de cien mil personas sin hogar.',
        tags: [
            { t: 'Catastrófico', c: 'r' },
            { t: '10-Oct-1986', c: 'o' },
            { t: 'Capital', c: '' }
        ],
        stats: [
            { v: '5.7', l: 'Magnitud' },
            { v: '1,500', l: 'Fallecidos' },
            { v: '100k', l: 'Sin hogar' }
        ],
        img: 'assets/media/img/1986.jpeg'
    },

    {
        year: '2001',
        title: 'La Doble Tragedia Nacional',
        mag: '7.7 / 6.6',
        deaths: '1,259',
        region: 'Todo El Salvador',
        desc: 'Los terremotos del 13 de enero y 13 de febrero de 2001 afectaron todo el territorio nacional. Dejaron miles de fallecidos, enormes pérdidas económicas y millones de personas afectadas, convirtiéndose en uno de los mayores desastres de la historia salvadoreña.',
        tags: [
            { t: 'M 7.7', c: 'r' },
            { t: 'M 6.6', c: 'r' },
            { t: 'Doble sismo', c: 'o' }
        ],
        stats: [
            { v: '7.7', l: 'Magnitud' },
            { v: '1,259', l: 'Fallecidos' },
            { v: '1.5M', l: 'Damnificados' }
        ],
        img: 'assets/media/img/2001.jpg'
    },

    {
        year: '2019',
        title: 'Enjambre Sísmico de Ilopango',
        mag: '4.9',
        deaths: '0',
        region: 'San Salvador, AMSS',
        desc: 'Durante varios días se registraron más de 1,200 movimientos sísmicos en la zona de Ilopango. Aunque no hubo víctimas mortales, las autoridades realizaron evacuaciones preventivas y reforzaron el monitoreo de la actividad sísmica.',
        tags: [
            { t: 'Enjambre', c: 'o' },
            { t: 'AMSS', c: '' },
            { t: '+1,200', c: 't' }
        ],
        stats: [
            { v: '4.9', l: 'Magnitud' },
            { v: '1,200+', l: 'Sismos/sem' },
            { v: '2019', l: 'Año' }
        ],
        img: 'assets/media/img/2019.jpg'
    }
];

let tlActive = 4;
let tlSwapTimeout = null;

function renderTL() {
    const track = document.getElementById('tlTrack');
    if (!track) return; // esta timeline solo existe en la pagina de Sismos
    track.innerHTML = tlData.map((e, i) =>
        `<div class="tl-item${i === tlActive ? ' active' : ''}" onclick="setTL(${i})">
            <div class="tli-year">${e.year}</div>
            <div class="tli-node"></div>
            <div class="tli-title">${e.title.split(' ').slice(0, 4).join(' ')}…</div>
        </div>`
    ).join('');

    // El detalle no cambia de golpe: primero se desvanece el evento
    // anterior (clase tl-fade-out, transicion CSS) y recien cuando termina
    // ese fundido se mete el contenido nuevo y se le quita la clase para
    // que entre con el mismo fundido en sentido inverso. Ritmo pensado
    // para que se note pero no se sienta lento ni marea al usuario.
    const detailEl = document.getElementById('tlDetail');
    clearTimeout(tlSwapTimeout);
    const swapContent = () => renderTLDetail(detailEl);
    if (!detailEl.innerHTML.trim()) {
        swapContent();
        return;
    }
    detailEl.classList.add('tl-fade-out');
    tlSwapTimeout = setTimeout(swapContent, 280);
}

function renderTLDetail(detailEl) {
    const e = tlData[tlActive];
    detailEl.classList.remove('tl-fade-out');

    detailEl.innerHTML = `
        <div class="tl-detail-inner">
            <div class="tld-img">
                <img src="${e.img}" alt="${e.title}" onerror="this.parentElement.style.background='linear-gradient(135deg,#182840,#0a1428)';this.style.display='none'"/>
                <div class="tld-img-ov"></div>
                <div style="position:absolute;bottom:12px;left:14px">
                    <div class="tld-img-yr">${e.year}</div>
                    <div class="tld-img-mag">M ${e.mag}</div>
                </div>
            </div>
            <div class="tld-info">
                <div class="tld-badge"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg> ${e.year}</div>
                <h3>${e.title}</h3>
                <p>${e.desc}</p>
                <div class="tld-tags">${e.tags.map(t => `<span class="tlt ${t.c}">${t.t}</span>`).join('')}</div>
                <div style="display:flex;align-items:center;gap:.45rem;font-size:.76rem;color:var(--text3);margin-bottom:12px"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em"> <path d="M21 10c0 6.5-9 13-9 13S3 16.5 3 10a9 9 0 1 1 18 0z"/> <circle cx="12" cy="10" r="3"/> </svg>
    <span>${e.region}</span>
</div>
                <div class="tld-stats">${e.stats.map(s => `<div class="tlds"><div class="tlds-v">${s.v}</div><div class="tlds-l">${s.l}</div></div>`).join('')}</div>
                <div class="tld-nav">
                    ${tlActive > 0 ? `<button class="tldn-btn" onclick="setTL(${tlActive - 1})"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg> Anterior</button>` : ''}

                    ${tlActive < tlData.length - 1 ? `<button class="tldn-btn" onclick="setTL(${tlActive + 1})">Siguiente <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></button>` : ''}
                </div>
            </div>
        </div>
    `;
}

window.setTL = function(i) {
    if (i === tlActive) return;
    tlActive = i;
    renderTL();
};


//  11B. LINEA DE TIEMPO REUTILIZABLE (paginas de Desastres)

// Misma UI/CSS que la linea de tiempo del home (tl-wrap/tl-track/tl-detail),
// generalizada para poder tener una por pagina sin pisar tlData/renderTL.
window.__ndaTlData = window.__ndaTlData || {};
window.__ndaTlActive = window.__ndaTlActive || {};
window.__ndaTlSwapTimeout = window.__ndaTlSwapTimeout || {};

function ndaRenderTimeline(key) {
    const data = window.__ndaTlData[key];
    const track = document.getElementById('tlTrack-' + key);
    const detail = document.getElementById('tlDetail-' + key);
    if (!data || !track || !detail) return;
    const active = window.__ndaTlActive[key] || 0;

    track.innerHTML = data.map((e, i) =>
        `<div class="tl-item${i === active ? ' active' : ''}" onclick="ndaSetTimeline('${key}', ${i})">
            <div class="tli-year">${e.year}</div>
            <div class="tli-node"></div>
            <div class="tli-title">${e.title.split(' ').slice(0, 4).join(' ')}…</div>
        </div>`
    ).join('');

    // Mismo fundido que renderTL() del home: primero desaparece el evento
    // anterior y recien al terminar entra el nuevo, en vez de un swap seco.
    clearTimeout(window.__ndaTlSwapTimeout[key]);
    const swapContent = () => ndaRenderTimelineDetail(key, detail);
    if (!detail.innerHTML.trim()) {
        swapContent();
        return;
    }
    detail.classList.add('tl-fade-out');
    window.__ndaTlSwapTimeout[key] = setTimeout(swapContent, 280);
}

function ndaRenderTimelineDetail(key, detail) {
    const data = window.__ndaTlData[key];
    const active = window.__ndaTlActive[key] || 0;
    const e = data[active];
    detail.classList.remove('tl-fade-out');

    detail.innerHTML = `
        <div class="tl-detail-inner">
            <div class="tld-img">
                <img src="${e.img}" alt="${e.title}" onerror="this.parentElement.style.background='linear-gradient(135deg,#182840,#0a1428)';this.style.display='none'"/>
                <div class="tld-img-ov"></div>
                <div style="position:absolute;bottom:12px;left:14px">
                    <div class="tld-img-yr">${e.year}</div>
                    <div class="tld-img-mag">${e.badge || ''}</div>
                </div>
            </div>
            <div class="tld-info">
                <div class="tld-badge"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg> ${e.year}</div>
                <h3>${e.title}</h3>
                <p>${e.desc}</p>
                <div class="tld-tags">${e.tags.map(t => `<span class="tlt ${t.c}">${t.t}</span>`).join('')}</div>
                <div style="font-size:.76rem;color:var(--text3);margin-bottom:12px">${e.region}</div>
                <div class="tld-stats">${e.stats.map(s => `<div class="tlds"><div class="tlds-v">${s.v}</div><div class="tlds-l">${s.l}</div></div>`).join('')}</div>
                <div class="tld-nav">
                    ${active > 0 ? `<button class="tldn-btn" onclick="ndaSetTimeline('${key}', ${active - 1})"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg> Anterior</button>` : ''}
                    ${active < data.length - 1 ? `<button class="tldn-btn" onclick="ndaSetTimeline('${key}', ${active + 1})">Siguiente</button>` : ''}
                </div>
            </div>
        </div>
    `;
}

window.ndaSetTimeline = function (key, i) {
    if (i === (window.__ndaTlActive[key] || 0)) return;
    window.__ndaTlActive[key] = i;
    ndaRenderTimeline(key);
};

window.ndaInitTimeline = function (key, data) {
    window.__ndaTlData[key] = data;
    window.__ndaTlActive[key] = 0;
    ndaRenderTimeline(key);
};

// Navegacion con flechas del teclado (izquierda/derecha) para cualquier
// linea de tiempo visible en pantalla, sea la del home (tlTrack) o una de
// las reutilizables de paginas de desastres (tlTrack-{key}). Se ignora si
// el foco esta en un campo de texto, y solo actua sobre una linea de
// tiempo que este realmente a la vista, para no interferir con el resto
// de la pagina.
document.addEventListener('keydown', function (e) {
    if (e.key !== 'ArrowLeft' && e.key !== 'ArrowRight') return;
    const activeTag = document.activeElement && document.activeElement.tagName;
    if (activeTag === 'INPUT' || activeTag === 'TEXTAREA' || activeTag === 'SELECT'
        || (document.activeElement && document.activeElement.isContentEditable)) return;

    let wrap = null;
    document.querySelectorAll('.tl-wrap').forEach(function (w) {
        if (wrap) return;
        const r = w.getBoundingClientRect();
        if (r.top < window.innerHeight * 0.85 && r.bottom > window.innerHeight * 0.15) wrap = w;
    });
    if (!wrap) return;

    const track = wrap.querySelector('.tl-track');
    if (!track) return;
    const dir = e.key === 'ArrowLeft' ? -1 : 1;

    if (track.id === 'tlTrack') {
        const next = tlActive + dir;
        if (next < 0 || next > tlData.length - 1) return;
        e.preventDefault();
        setTL(next);
    } else if (track.id.indexOf('tlTrack-') === 0) {
        const key = track.id.slice('tlTrack-'.length);
        const data = window.__ndaTlData[key];
        if (!data) return;
        const active = window.__ndaTlActive[key] || 0;
        const next = active + dir;
        if (next < 0 || next > data.length - 1) return;
        e.preventDefault();
        ndaSetTimeline(key, next);
    }
});


//  11. LEAFLET MAP
  

let hazMap, qLayer2, sLayer2, vLayer2, fLayer2, slideLayer, safeLayer;

function initMap() {
    if (!document.getElementById('hazardMap')) return;
    hazMap = L.map('hazardMap', { center: [13.7942, -88.8965], zoom: 8 });

    const isLightTheme = document.documentElement.getAttribute('data-theme') === 'light';
    const hazTiles = L.tileLayer(
        isLightTheme
            ? 'https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png'
            : 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png',
        { attribution: '© CARTO', maxZoom: 18 }
    ).addTo(hazMap);

    // El boton de tema claro/oscuro cambia data-theme en <html> sin recargar la pagina.
    new MutationObserver(() => {
        const light = document.documentElement.getAttribute('data-theme') === 'light';
        hazTiles.setUrl(
            light
                ? 'https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png'
                : 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png'
        );
    }).observe(document.documentElement, { attributes: true, attributeFilter: ['data-theme'] });

    sLayer2 = L.layerGroup();
    [
        { lat: 13.7, lng: -89.2, r: 38000, lbl: '[Sísmica] San Salvador', desc: 'Alta actividad tectónica. Falla Metrópolis activa.' },
        { lat: 13.43, lng: -88.18, r: 30000, lbl: '[Sísmica] San Miguel', desc: 'Alta actividad tectónica. Falla El Triunfo activa.' },
        { lat: 13.4, lng: -88.9, r: 26000, lbl: '[Sísmica] Usulután', desc: 'Zona de subducción activa.' },
        { lat: 13.9, lng: -89.8, r: 24000, lbl: '[Sísmica] Ahuachapán', desc: 'Actividad volcánica y sísmica.' }
    ].forEach(z => L.circle([z.lat, z.lng], { radius: z.r, color: '#e63946', fillColor: '#e63946', fillOpacity: .1, weight: 2,
            opacity: .55 })
        .bindPopup(`<b style="color:#e63946">${z.lbl}</b><br>${z.desc}<br><small>Fuente: SNET/MARN</small>`)
        .addTo(sLayer2));

    vLayer2 = L.layerGroup();
    [
        { lat: 13.8414, lng: -89.6339, name: 'Volcán Santa Ana', act: true },
        { lat: 13.8281, lng: -89.5864, name: 'Volcán Izalco', act: true },
        { lat: 13.6761, lng: -89.6319, name: 'Volcán Chinchontepec', act: false },
        { lat: 13.6706, lng: -89.1844, name: 'Lago Ilopango (caldera)', act: true },
        { lat: 13.7389, lng: -88.7736, name: 'Volcán San Vicente', act: false },
        { lat: 13.4433, lng: -88.2694, name: 'Volcán San Miguel', act: true }
    ].forEach(v => L.circleMarker([v.lat, v.lng], { radius: 9, color: v.act ? '#ff9500' : '#555',
            fillColor: v.act ? '#ff9500' : '#333', fillOpacity: .8, weight: 2 })
        .bindPopup(`<b>${v.act ? '<span style="display:inline-block;width:0.55em;height:0.55em;border-radius:50%;background:var(--red);vertical-align:0.05em"></span> Activo' : '<span style="display:inline-block;width:0.55em;height:0.55em;border-radius:50%;background:var(--text3);vertical-align:0.05em"></span> Inactivo'}</b><br>${v.name}<br><small>Fuente: MARN</small>`)
        .addTo(vLayer2));

    fLayer2 = L.layerGroup();
    [
        { lat: 13.2, lng: -88.85, r: 5000, lbl: '[Tsunami] Playa El Espino' },
        { lat: 13.3, lng: -89.17, r: 5000, lbl: '[Tsunami] Acajutla' },
        { lat: 13.33, lng: -88.5, r: 5000, lbl: '[Tsunami] La Unión' },
        { lat: 13.2, lng: -88.1, r: 5000, lbl: '[Tsunami] Jiquilisco' },
        { lat: 13.2, lng: -89.5, r: 5000, lbl: '[Tsunami] Sonsonate Costa' }
    ].forEach(f => L.circle([f.lat, f.lng], { radius: f.r, color: '#3d9bff', fillColor: '#3d9bff', fillOpacity: .15,
            weight: 1.5, opacity: .55 })
        .bindPopup(`<b style="color:#3d9bff">${f.lbl}</b><br>Zona de riesgo tsunamigénico<br><small>Fuente: IOC-UNESCO / MARN</small>`)
        .addTo(fLayer2));

    slideLayer = L.layerGroup();
    [
        { lat: 13.72, lng: -89.1, lbl: 'Deslizamiento — Cuscatlán' },
        { lat: 13.78, lng: -89.5, lbl: 'Deslizamiento — Santa Ana Norte' },
        { lat: 13.84, lng: -89.0, lbl: 'Deslizamiento — Chalatenango' }
    ].forEach(s => L.circleMarker([s.lat, s.lng], { radius: 7, color: '#ffcc00', fillColor: '#ffcc00', fillOpacity: .7,
            weight: 1.5 })
        .bindPopup(`<b style="color:#ffcc00">${s.lbl}</b><br><small>Fuente: MARN</small>`)
        .addTo(slideLayer));

    safeLayer = L.layerGroup();
    [
        { lat: 13.82, lng: -88.5, lbl: 'Zona Segura — Morazán Norte' },
        { lat: 14.0, lng: -89.2, lbl: 'Zona Segura — Chalatenango' }
    ].forEach(s => L.circleMarker([s.lat, s.lng], { radius: 8, color: '#22c55e', fillColor: '#22c55e', fillOpacity: .6,
            weight: 1.5 })
        .bindPopup(`<b style="color:#22c55e">${s.lbl}</b>`)
        .addTo(safeLayer));

    qLayer2 = L.layerGroup();
    sLayer2.addTo(hazMap);

    document.querySelectorAll('.mc-btn').forEach(btn => {
        btn.onclick = () => {
            document.querySelectorAll('.mc-btn').forEach(b => b.classList.remove('on'));
            btn.classList.add('on');
            [sLayer2, vLayer2, fLayer2, slideLayer, safeLayer, qLayer2].forEach(l => hazMap.removeLayer(l));
            const map = { seismic: sLayer2, volcanic: vLayer2, flood: fLayer2, slides: slideLayer, safe: safeLayer,
                quakes: qLayer2 };
            if (btn.dataset.layer === 'all') {
                [sLayer2, vLayer2, fLayer2, slideLayer, safeLayer, qLayer2].forEach(l => l.addTo(hazMap));
            } else if (map[btn.dataset.layer]) {
                map[btn.dataset.layer].addTo(hazMap);
            }
        };
    });
}

window._addQuakesToMap = function(qs) {
    if (!qLayer2) return;
    qLayer2.clearLayers();
    qs.forEach(q => {
        const [lng, lat] = q.geometry.coordinates,
            m = q.properties.mag || 1;
        const col = m < 3 ? '#22c55e' : m < 5 ? '#ff9500' : '#e63946';
        L.circleMarker([lat, lng], { radius: Math.max(4, m * 2.2), color: col, fillColor: col, fillOpacity: .5,
                weight: 1.5 })
            .bindPopup(`<b>M ${m}</b><br>${escapeHtml(q.properties.place)}<br>${new Date(q.properties.time).toLocaleString('es')}<br><small>Fuente: ${q.properties.source || 'USGS'}</small>`)
            .addTo(qLayer2);
    });
};

  
//  12. WEATHER
  

async function loadWeather() {
    if (!document.getElementById('weatherCities')) return;
    try {
        const cities = [
            { name: 'San Salvador', lat: 13.6929, lng: -89.2182 },
            { name: 'La Libertad', lat: 13.4885, lng: -89.3126 },
            { name: 'Santa Ana', lat: 13.9944, lng: -89.5597 }
        ];

        const wmo = {
            0: ['☀️', 'Despejado'],
            1: ['👥', 'Mayormente despejado'],
            2: ['👥', 'Parcialmente nublado'],
            3: ['<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M17.5 19a4.5 4.5 0 0 0 0-9 6 6 0 0 0-11.3-1.5A5 5 0 0 0 6 19z"/></svg>', 'Nublado'],
            45: ['<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><line x1="3" y1="8" x2="21" y2="8"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="16" x2="21" y2="16"/></svg>', 'Niebla'],
            51: ['❄️', 'Llovizna'],
            61: ['🌧️', 'Lluvia ligera'],
            63: ['🌧️', 'Lluvia moderada'],
            65: ['⛈️', 'Lluvia intensa'],
            80: ['❄️', 'Chubascos'],
            95: ['⛈️', 'Tormenta']
        };

        const results = await Promise.all(cities.map(c =>
            fetch(
                    `https://api.open-meteo.com/v1/forecast?latitude=${c.lat}&longitude=${c.lng}&current=temperature_2m,relative_humidity_2m,wind_speed_10m,weather_code,apparent_temperature,wind_direction_10m&daily=temperature_2m_max,temperature_2m_min,precipitation_sum&forecast_days=1&timezone=America/El_Salvador`
                    )
                .then(r => r.json())
                .then(d => ({ ...c, data: d }))
        ));

        const container = document.getElementById('weatherCities');
        container.innerHTML = results.map(r => {
            const cur = r.data.current;
            const w = wmo[cur.weather_code] || ['👥', 'Variable'];
            const max = r.data.daily?.temperature_2m_max?.[0] || '—';
            const min = r.data.daily?.temperature_2m_min?.[0] || '—';
            const dirs = ['N', 'NE', 'E', 'SE', 'S', 'SO', 'O', 'NO'];
            const dir = dirs[Math.round(cur.wind_direction_10m / 45) % 8] || '—';
            const uv = cur.apparent_temperature > 30 ? 'Extremo' : cur.apparent_temperature > 25 ? 'Alto' : 'Moderado';
            const extra = r.name === 'La Libertad' ? `${Math.round(Math.random() * 18 + 5)}mm hoy` :
                r.name === 'Santa Ana' ? 'Altitud 800 msnm' : `UV: ${uv}`;
            return `<div class="wc-card">
                <div class="wc-icon">${w[0]}</div>
                <div class="wc-city">${r.name}</div>
                <div class="wc-temp">${Math.round(cur.temperature_2m)}<span style="font-size:1.2rem">°C</span></div>
                <div class="wc-desc">${w[1]} · Humedad ${cur.relative_humidity_2m}%</div>
                <div class="wc-meta">
                    <span><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><line x1="12" y1="19" x2="12" y2="5"/><polyline points="5 12 12 5 19 12"/></svg>${Math.round(max)}° ⬇️${Math.round(min)}°</span>
                    <span><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M9.6 4.6a2 2 0 1 1 1.4 3.4H2M12.6 19.4a2 2 0 1 0 1.4-3.4H2M17.6 8.6a2.5 2.5 0 1 1 1.8 4.4H2"/></svg> ${Math.round(cur.wind_speed_10m)} km/h ${dir}</span>
                    <span>${extra}</span>
                </div>
            </div>`;
        }).join('');

        const monthly = [10, 8, 18, 52, 180, 280, 290, 270, 310, 220, 45, 12];
        const months = ['E', 'F', 'M', 'A', 'M', 'J', 'J', 'A', 'S', 'O', 'N', 'D'];
        const maxP = Math.max(...monthly);
        document.getElementById('precipChart').innerHTML = monthly.map((p, i) =>
            `<div class="prc-bar-wrap">
                <div class="prc-bar-outer"><div class="prc-bar" style="height:${(p / maxP * 100)}%"></div></div>
                <div class="prc-val">${p > 50 ? p : ''}</div>
                <div class="prc-day">${months[i]}</div>
            </div>`
        ).join('');

        const todayPrecip = results[0]?.data?.daily?.precipitation_sum?.[0] ?? 0;
        if (window.updateRadarStatus) window.updateRadarStatus(todayPrecip);

    } catch (e) {
        document.getElementById('weatherCities').innerHTML = '<div class="loading-s">⚠️ Error al cargar clima</div>';
    }
}

async function loadSun() {
    if (!document.getElementById('sunriseBig')) return;
    try {
        const resp = await fetch('https://api.sunrise-sunset.org/json?lat=13.6929&lng=-89.2182&formatted=0');
        const d = await resp.json();

        const toLocal = s => new Date(s).toLocaleTimeString('es-SV', { hour: '2-digit', minute: '2-digit',
            timeZone: 'America/El_Salvador', hour12: false });
        const srStr = toLocal(d.results.sunrise);
        const ssStr = toLocal(d.results.sunset);

        const dl = d.results.day_length;
        const hrsFmt = `${Math.floor(dl / 3600)}h ${Math.floor((dl % 3600) / 60)}min`;

        document.getElementById('sunriseBig').textContent = srStr;
        document.getElementById('sunsetBig').textContent = ssStr;
        if (document.getElementById('sunriseT')) document.getElementById('sunriseT').textContent = srStr;
        if (document.getElementById('sunsetT')) document.getElementById('sunsetT').textContent = ssStr;

        const nowHr = new Date().getHours();
        const uvIdx = nowHr >= 10 && nowHr <= 15 ? 12 : nowHr >= 8 && nowHr <= 17 ? 7 : 2;
        const uvLbl = uvIdx >= 11 ? 'Extremo' : uvIdx >= 8 ? 'Muy Alto' : uvIdx >= 6 ? 'Alto' : 'Moderado';
        document.getElementById('sunDur').textContent = `Duración: ${hrsFmt} · Índice UV: ${uvIdx} — ${uvLbl}`;

        // Draw sun arc
        const c = document.getElementById('sunArc');
        if (!c) return;

        function drawArc() {
            c.width = c.offsetWidth || 400;
            c.height = 160;
            const ctx = c.getContext('2d');
            const W = c.width,
                H = c.height;

            ctx.fillStyle = '#040810';
            ctx.fillRect(0, 0, W, H);

            const stars = [
                [0.08, 0.12],
                [0.15, 0.08],
                [0.25, 0.18],
                [0.34, 0.06],
                [0.45, 0.15],
                [0.54, 0.09],
                [0.63, 0.2],
                [0.72, 0.07],
                [0.81, 0.14],
                [0.9, 0.1],
                [0.96, 0.18],
                [0.12, 0.3],
                [0.68, 0.26],
                [0.84, 0.32],
                [0.38, 0.24]
            ];
            stars.forEach(([fx, fy]) => {
                ctx.fillStyle = 'rgba(255,255,255,.5)';
                ctx.fillRect(W * fx, H * fy, 1.5, 1.5);
            });

            const toDecH = dt => {
                const local = new Date(dt).toLocaleString('en-US', { timeZone: 'America/El_Salvador', hour: '2-digit',
                    minute: '2-digit', hour12: false });
                const parts = local.split(':');
                return parseInt(parts[0] || 0) + parseInt(parts[1] || 0) / 60;
            };

            const srDec = toDecH(d.results.sunrise);
            const ssDec = toDecH(d.results.sunset);

            const nowLocal = new Date().toLocaleString('en-US', { timeZone: 'America/El_Salvador', hour: '2-digit',
                minute: '2-digit', hour12: false });
            const np = nowLocal.split(':');
            const nowDec = parseInt(np[0] || 12) + parseInt(np[1] || 0) / 60;
            const prog = Math.max(0, Math.min(1, (nowDec - srDec) / (ssDec - srDec)));

            const AX = W * 0.5,
                AY = H + 12,
                AR = W * 0.46;

            ctx.save();
            ctx.strokeStyle = 'rgba(255,200,50,.22)';
            ctx.lineWidth = 1.5;
            ctx.setLineDash([6, 5]);
            ctx.beginPath();
            ctx.arc(AX, AY, AR, Math.PI, 0);
            ctx.stroke();
            ctx.setLineDash([]);

            ctx.strokeStyle = 'rgba(255,255,255,.06)';
            ctx.lineWidth = 1;
            ctx.beginPath();
            ctx.moveTo(W * 0.04, H - 4);
            ctx.lineTo(W * 0.96, H - 4);
            ctx.stroke();

            const srX = AX - AR,
                ssX = AX + AR;
            ['rgba(255,180,50,.6)', 'rgba(255,180,50,.6)'].forEach((col, idx) => {
                const tx = idx === 0 ? srX : ssX;
                ctx.strokeStyle = col;
                ctx.lineWidth = 1.5;
                ctx.beginPath();
                ctx.moveTo(tx, H - 4);
                ctx.lineTo(tx, H - 18);
                ctx.stroke();
            });

            ctx.fillStyle = 'rgba(200,150,60,.75)';
            ctx.font = '600 9.5px Space Grotesk,sans-serif';
            ctx.textAlign = 'center';
            ctx.fillText(srStr, srX, H - 1);
            ctx.fillText(ssStr, ssX, H - 1);
            ctx.textAlign = 'left';

            const angle = Math.PI - prog * Math.PI;
            const sx = AX + Math.cos(angle) * AR,
                sy = AY + Math.sin(angle) * AR;

            const glow = ctx.createRadialGradient(sx, sy, 0, sx, sy, 30);
            glow.addColorStop(0, 'rgba(255,200,50,.22)');
            glow.addColorStop(1, 'rgba(255,200,50,0)');
            ctx.fillStyle = glow;
            ctx.beginPath();
            ctx.arc(sx, sy, 30, 0, Math.PI * 2);
            ctx.fill();

            const sunGr = ctx.createRadialGradient(sx - 2, sy - 2, 1, sx, sy, 9);
            sunGr.addColorStop(0, '#fff4a0');
            sunGr.addColorStop(0.4, '#ffcc00');
            sunGr.addColorStop(1, '#ff8800');
            ctx.fillStyle = sunGr;
            ctx.beginPath();
            ctx.arc(sx, sy, 9, 0, Math.PI * 2);
            ctx.fill();

            const hh = String(Math.floor(nowDec)).padStart(2, '0');
            const mm = String(Math.round((nowDec % 1) * 60)).padStart(2, '0');
            ctx.fillStyle = 'rgba(255,220,60,.95)';
            ctx.font = 'bold 10px Space Grotesk,sans-serif';
            ctx.textAlign = 'center';
            const labelY = sy > 30 ? sy - 16 : sy + 24;
            ctx.fillText(`☀️ ${hh}:${mm}`, sx, labelY);
            ctx.textAlign = 'left';
            ctx.restore();
        }

        drawArc();
        window.addEventListener('resize', drawArc);

    } catch (e) {
        console.warn('Sun load error', e);
    }
}

  
//  13. RADAR CANVAS ANIMATION
  

(function initRadar() {
    const body = document.getElementById('radarBody');
    const cv = document.getElementById('radarCanvas');
    if (!body || !cv) return;

    let W, H, animFrame, t = 0;

    const cells = [
        { bx: .42, by: .38, r: .07, intensity: 'mod', phase: 0 },
        { bx: .58, by: .52, r: .05, intensity: 'light', phase: .6 },
        { bx: .33, by: .56, r: .04, intensity: 'light', phase: 1.2 },
        { bx: .65, by: .3, r: .045, intensity: 'mod', phase: 1.8 },
    ];

    const colMap = {
        light: 'rgba(59,130,246,',
        mod: 'rgba(249,115,22,',
        heavy: 'rgba(239,68,68,'
    };

    function resize() {
        const rect = body.getBoundingClientRect();
        W = rect.width || 300;
        H = rect.height || 240;
        cv.width = W;
        cv.height = H;
    }

    function draw() {
        if (!cv.width) resize();
        const ctx = cv.getContext('2d');
        ctx.clearRect(0, 0, cv.width, cv.height);

        const cx = cv.width * 0.5,
            cy = cv.height * 0.5;

        // Precipitation blobs
        cells.forEach((cell, idx) => {
            const drift = Math.sin(t * 0.012 + cell.phase) * 0.025;
            const driftY = Math.cos(t * 0.009 + cell.phase) * 0.018;
            const bx = cx + (cell.bx - 0.5) * Math.min(cv.width, cv.height) + drift * cv.width;
            const by = cy + (cell.by - 0.5) * Math.min(cv.width, cv.height) + driftY * cv.height;
            const r = cell.r * Math.min(cv.width, cv.height);
            const col = colMap[cell.intensity] || colMap.light;
            const grad = ctx.createRadialGradient(bx, by, 0, bx, by, r);
            grad.addColorStop(0, col + '0.6)');
            grad.addColorStop(0.5, col + '0.35)');
            grad.addColorStop(1, col + '0)');
            ctx.fillStyle = grad;
            ctx.beginPath();
            ctx.arc(bx, by, r, 0, Math.PI * 2);
            ctx.fill();
        });

        // Sweep glow trail
        const sweepAngle = (t * 0.022) % (Math.PI * 2) - Math.PI / 2;
        const maxR = Math.min(cv.width, cv.height) * 0.49;

        for (let trail = 0; trail < 8; trail++) {
            const trailA = sweepAngle - trail * 0.08;
            const alpha = (1 - trail / 8) * 0.15;
            ctx.save();
            ctx.translate(cx, cy);
            ctx.beginPath();
            ctx.moveTo(0, 0);
            ctx.arc(0, 0, maxR, trailA, trailA + 0.12);
            ctx.closePath();
            ctx.fillStyle = `rgba(0,210,180,${alpha})`;
            ctx.fill();
            ctx.restore();
        }

        // Main sweep line
        ctx.save();
        ctx.translate(cx, cy);
        const grd = ctx.createLinearGradient(0, 0, Math.cos(sweepAngle) * maxR, Math.sin(sweepAngle) * maxR);
        grd.addColorStop(0, 'rgba(0,220,185,.9)');
        grd.addColorStop(1, 'rgba(0,220,185,0)');
        ctx.strokeStyle = grd;
        ctx.lineWidth = 2;
        ctx.beginPath();
        ctx.moveTo(0, 0);
        ctx.lineTo(Math.cos(sweepAngle) * maxR, Math.sin(sweepAngle) * maxR);
        ctx.stroke();
        ctx.restore();

        t++;
        animFrame = requestAnimationFrame(draw);
    }

    window.addEventListener('resize', resize);
    resize();
    draw();

    window.updateRadarStatus = function(precipMm) {
        const el = document.getElementById('radarStatus');
        if (!el) return;
        if (precipMm > 15) {
            el.textContent = '⚠️ Lluvia intensa';
            el.className = 'chip r';
        } else if (precipMm > 3) {
            el.textContent = '● Lluvia ligera';
            el.className = 'chip b';
        } else {
            el.textContent = '● Vigilancia';
            el.className = 'chip o';
        }
    };
})();

  
//  14. MOON INTERACTIVE MODULE
  

(function() {
    if (!document.getElementById('moonName')) return;
    const synodic = 29.530588853;
    const known = new Date(2000, 0, 6, 18, 14);
    const now = new Date();
    const currentPhaseRaw = ((now - known) / 864e5 / synodic) % 1;

    const phases = [
        { name: '<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><circle cx="12" cy="12" r="9" fill="currentColor"/></svg> Luna Nueva', key: 'new', emoji: '<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><circle cx="12" cy="12" r="9" fill="currentColor"/></svg>', tideType: 'spring', tideLabel: 'Marea Viva', fishing: 'Alta',
            risk: 'Alto', desc: 'Alineación Sol-Luna-Tierra. Mareas vivas máximas. Pesca muy activa.' },
        { name: '<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M12 3a9 9 0 0 0 0 18z" fill="currentColor" opacity="0.5"/><circle cx="12" cy="12" r="9"/></svg> Creciente Iluminante', key: 'waxCrescent', emoji: '<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M12 3a9 9 0 0 0 0 18z" fill="currentColor" opacity="0.5"/><circle cx="12" cy="12" r="9"/></svg>', tideType: 'moderate',
            tideLabel: 'Marea Moderada', fishing: 'Media', risk: 'Bajo',
            desc: 'Luna se aleja de la alineación solar. Mareas descendiendo gradualmente.' },
        { name: '<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M12 3a9 9 0 0 0 0 18z" fill="currentColor"/><circle cx="12" cy="12" r="9"/></svg> Cuarto Creciente', key: 'firstQuarter', emoji: '<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M12 3a9 9 0 0 0 0 18z" fill="currentColor"/><circle cx="12" cy="12" r="9"/></svg>', tideType: 'neap', tideLabel: 'Marea Muerta',
            fishing: 'Baja', risk: 'Bajo',
            desc: 'Ángulo 90° con el Sol. Mareas muertas — menor variación. Buena navegación.' },
        { name: '<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M12 3a9 9 0 0 1 0 18z" fill="currentColor" opacity="0.85"/><circle cx="12" cy="12" r="9"/></svg> Gibosa Creciente', key: 'waxGibbous', emoji: '<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M12 3a9 9 0 0 1 0 18z" fill="currentColor" opacity="0.85"/><circle cx="12" cy="12" r="9"/></svg>', tideType: 'moderate',
            tideLabel: 'Marea Moderada', fishing: 'Media', risk: 'Bajo',
            desc: 'Luna casi llena. Fuerza gravitacional creciendo. Mareas aumentando.' },
        { name: '<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><circle cx="12" cy="12" r="9"/></svg> Luna Llena', key: 'full', emoji: '<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><circle cx="12" cy="12" r="9"/></svg>', tideType: 'spring', tideLabel: 'Marea Viva', fishing: 'Alta',
            risk: 'Muy Alto', desc: 'Alineación opuesta pero igualmente fuerte. Mareas vivas máximas del mes.' },
        { name: '<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M12 3a9 9 0 0 1 0 18z" fill="currentColor" opacity="0.5"/><circle cx="12" cy="12" r="9"/></svg> Gibosa Menguante', key: 'wanGibbous', emoji: '<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M12 3a9 9 0 0 1 0 18z" fill="currentColor" opacity="0.5"/><circle cx="12" cy="12" r="9"/></svg>', tideType: 'moderate',
            tideLabel: 'Marea Moderada', fishing: 'Media', risk: 'Bajo',
            desc: 'Luna pos-llena. Mareas disminuyendo paulatinamente.' },
        { name: '<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M12 3a9 9 0 0 1 0 18z" fill="currentColor"/><circle cx="12" cy="12" r="9"/></svg> Cuarto Menguante', key: 'lastQuarter', emoji: '<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M12 3a9 9 0 0 1 0 18z" fill="currentColor"/><circle cx="12" cy="12" r="9"/></svg>', tideType: 'neap', tideLabel: 'Marea Muerta',
            fishing: 'Baja', risk: 'Bajo',
            desc: 'Ángulo 90° opuesto. Segunda marea muerta del ciclo. Aguas calmadas.' },
        { name: '<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M12 3a9 9 0 0 0 0 18z" fill="currentColor" opacity="0.85"/><circle cx="12" cy="12" r="9"/></svg> Menguante', key: 'wanCrescent', emoji: '<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M12 3a9 9 0 0 0 0 18z" fill="currentColor" opacity="0.85"/><circle cx="12" cy="12" r="9"/></svg>', tideType: 'low', tideLabel: 'Marea Baja',
            fishing: 'Baja', risk: 'Bajo',
            desc: 'Luna casi nueva. Fuerza gravitacional mínima. Preparando próxima luna nueva.' },
    ];

    function getNextPhaseDate(targetPhaseIdx) {
        const target = targetPhaseIdx / 8;
        const cur = currentPhaseRaw;
        let diff = target - cur;
        if (diff <= 0) diff += 1;
        const nextMs = now.getTime() + diff * synodic * 864e5;
        const d = new Date(nextMs);
        return d.toLocaleDateString('es-SV', { weekday: 'long', day: 'numeric', month: 'long' });
    }

    let selectedPhase = Math.floor(currentPhaseRaw * 8) % 8;

    function drawMoon(phaseIdx) {
        const c = document.getElementById('moonCv');
        if (!c) return;
        const ctx = c.getContext('2d');
        const phase = phaseIdx / 8;
        const W = c.width,
            H = c.height,
            cx = W / 2,
            cy = H / 2,
            r = W / 2 - 6;
        ctx.clearRect(0, 0, W, H);

        const glow = ctx.createRadialGradient(cx, cy, r * 0.6, cx, cy, r + 18);
        glow.addColorStop(0, phase === 4 ? 'rgba(255,240,130,.18)' : 'rgba(255,210,80,.1)');
        glow.addColorStop(1, 'transparent');
        ctx.fillStyle = glow;
        ctx.beginPath();
        ctx.arc(cx, cy, r + 18, 0, Math.PI * 2);
        ctx.fill();

        ctx.fillStyle = '#070d1a';
        ctx.beginPath();
        ctx.arc(cx, cy, r, 0, Math.PI * 2);
        ctx.fill();

        ctx.save();
        ctx.beginPath();
        ctx.arc(cx, cy, r, 0, Math.PI * 2);
        ctx.clip();

        const litX = Math.cos(phase * Math.PI * 2) * r;
        const moonColor = phase === 4 ? '#fff5d0' : phase < 0.125 ? '#e8d8a0' : '#ede0b0';
        ctx.fillStyle = moonColor;
        if (phase < 0.5) {
            ctx.beginPath();
            ctx.arc(cx, cy, r, Math.PI / 2, Math.PI * 3 / 2, true);
            ctx.bezierCurveTo(cx + litX, cy - r, cx + litX, cy + r, cx, cy + r);
            ctx.fill();
        } else {
            ctx.beginPath();
            ctx.arc(cx, cy, r, Math.PI / 2, Math.PI * 3 / 2);
            ctx.bezierCurveTo(cx + litX, cy + r, cx + litX, cy - r, cx, cy - r);
            ctx.fill();
        }

        const craters = [
            [-0.25, -0.28, 0.065],
            [0.2, 0.12, 0.048],
            [-0.1, 0.32, 0.055],
            [0.32, -0.2, 0.038],
            [-0.35, 0.1, 0.03],
            [0.05, -0.4, 0.04]
        ];
        craters.forEach(([fx, fy, fr]) => {
            ctx.fillStyle = 'rgba(0,0,0,.12)';
            ctx.beginPath();
            ctx.arc(cx + fx * r, cy + fy * r, fr * r, 0, Math.PI * 2);
            ctx.fill();
            ctx.strokeStyle = 'rgba(255,255,255,.06)';
            ctx.lineWidth = 0.8;
            ctx.beginPath();
            ctx.arc(cx + fx * r - 1, cy + fy * r - 1, fr * r, 0, Math.PI * 2);
            ctx.stroke();
        });

        ctx.restore();

        ctx.strokeStyle = phase === 4 ? 'rgba(255,240,130,.4)' : 'rgba(255,210,80,.2)';
        ctx.lineWidth = 1.5;
        ctx.beginPath();
        ctx.arc(cx, cy, r, 0, Math.PI * 2);
        ctx.stroke();
    }

    function drawTideChart(phaseIdx) {
        const tc = document.getElementById('tideCv');
        if (!tc) return;
        tc.width = tc.offsetWidth;
        tc.height = 120;
        const ctx = tc.getContext('2d');
        const W = tc.width,
            H = tc.height;

        ctx.fillStyle = '#050810';
        ctx.fillRect(0, 0, W, H);

        ctx.strokeStyle = 'rgba(255,255,255,.04)';
        ctx.lineWidth = 1;
        for (let y = 0; y < H; y += 24) {
            ctx.beginPath();
            ctx.moveTo(0, y);
            ctx.lineTo(W, y);
            ctx.stroke();
        }
        for (let x = 0; x < W; x += W / 8) {
            ctx.beginPath();
            ctx.moveTo(x, 0);
            ctx.lineTo(x, H);
            ctx.stroke();
        }

        const isSpring = phaseIdx === 0 || phaseIdx === 4;
        const isNeap = phaseIdx === 2 || phaseIdx === 6;
        const amplitude = isSpring ? 0.42 : isNeap ? 0.18 : 0.28;
        const tideColor = isSpring ? '#3d9bff' : isNeap ? '#ff4d1a' : '#00d4b0';

        const fullFill = ctx.createLinearGradient(0, 0, 0, H);
        fullFill.addColorStop(0, `rgba(45,143,255,.18)`);
        fullFill.addColorStop(1, 'rgba(45,143,255,.02)');
        ctx.fillStyle = fullFill;
        ctx.beginPath();
        ctx.moveTo(0, H);
        for (let x = 0; x <= W; x++) {
            const cyclePos = (x / W * 2) * Math.PI;
            const moonEffect = Math.cos((phaseIdx / 4 + x / W) * Math.PI);
            const y = H * 0.5 - Math.sin(cyclePos * 2) * H * (amplitude + moonEffect * 0.12);
            x === 0 ? ctx.moveTo(x, y) : ctx.lineTo(x, y);
        }
        ctx.lineTo(W, H);
        ctx.closePath();
        ctx.fill();

        ctx.beginPath();
        ctx.strokeStyle = tideColor;
        ctx.lineWidth = 2.2;
        for (let x = 0; x <= W; x++) {
            const cyclePos = x / W * 2 * Math.PI;
            const moonEffect = Math.cos((phaseIdx / 4 + x / W) * Math.PI);
            const y = H * 0.5 - Math.sin(cyclePos * 2) * H * (amplitude + moonEffect * 0.12);
            x === 0 ? ctx.moveTo(x, y) : ctx.lineTo(x, y);
        }
        ctx.stroke();

        ['Día 1', 'Día 8', 'Día 15', 'Día 22', 'Día 29'].forEach((lbl, i) => {
            const x = W * i / 4;
            ctx.fillStyle = 'rgba(255,255,255,.3)';
            ctx.font = '8px Space Grotesk,sans-serif';
            ctx.textAlign = 'center';
            ctx.fillText(lbl, Math.min(x + 10, W - 20), H - 4);
        });
        ctx.textAlign = 'left';

        const curX = (phaseIdx / 8) * W;
        ctx.strokeStyle = 'rgba(255,204,0,.6)';
        ctx.lineWidth = 1.5;
        ctx.setLineDash([4, 3]);
        ctx.beginPath();
        ctx.moveTo(curX, 0);
        ctx.lineTo(curX, H);
        ctx.stroke();
        ctx.setLineDash([]);
        ctx.fillStyle = 'rgba(255,204,0,.9)';
        ctx.font = 'bold 8px Space Grotesk,sans-serif';
        ctx.textAlign = 'center';
        ctx.fillText('HOY', Math.min(curX, W - 20), 11);
        ctx.textAlign = 'left';
    }

    function updateMoonUI(phaseIdx) {
        const p = phases[phaseIdx];
        const pct = Math.round((phaseIdx / 8) * 100 + (currentPhaseRaw % 0.125) * 100 / 8);

        document.getElementById('moonName').innerHTML = p.name;
        document.getElementById('moonDateStr').textContent = now.toLocaleDateString('es-SV', { weekday: 'long',
            year: 'numeric', month: 'long', day: 'numeric' });
        document.getElementById('moonNextDate').innerHTML = `⏰ Próxima ${p.emoji}: ${getNextPhaseDate(phaseIdx)}`;
        document.getElementById('moonFill').style.width = ((phaseIdx + 0.5) / 8 * 100) + '%';
        document.getElementById('moonPct').textContent = Math.round((phaseIdx + 0.5) / 8 * 100) + '%';
        document.getElementById('tideCurPhase').textContent = `${p.tideLabel} · Pesca: ${p.fishing}`;

        const gEl = document.getElementById('moonGlowEl');
        if (gEl) {
            const gIntensity = phaseIdx === 4 ? 0.25 : phaseIdx === 0 ? 0.02 : 0.1;
            gEl.style.background = `radial-gradient(circle,rgba(255,220,90,${gIntensity}) 0%,transparent 70%)`;
        }

        drawMoon(phaseIdx);
        drawTideChart(phaseIdx);

        document.querySelectorAll('.mps-btn').forEach((btn, i) => {
            btn.classList.toggle('active', i === phaseIdx);
        });
    }

    window.setMoonPhase = function(idx) {
        selectedPhase = idx;
        updateMoonUI(idx);
    };

    document.querySelectorAll('.mps-btn').forEach((btn, i) => {
        btn.onclick = () => {
            selectedPhase = i;
            updateMoonUI(i);
            btn.style.transform = 'translateY(-4px) scale(1.1)';
            setTimeout(() => { btn.style.transform = ''; }, 300);
        };
    });

    updateMoonUI(selectedPhase);
})();

  
//  15. TSUNAMI CANVAS
  

(function() {
    const c = document.getElementById('tsunamiCv');
    if (!c) return;
    let t = 0;

    function resize() {
        c.width = c.offsetWidth;
        c.height = 200;
    }
    resize();
    window.addEventListener('resize', resize);

    const ctx = c.getContext('2d');

    function draw() {
        const W = c.width,
            H = c.height;
        ctx.clearRect(0, 0, W, H);

        const seaBg = ctx.createLinearGradient(0, 0, 0, H);
        seaBg.addColorStop(0, '#001222');
        seaBg.addColorStop(1, '#002650');
        ctx.fillStyle = seaBg;
        ctx.fillRect(0, 0, W, H);

        ctx.fillStyle = '#0a1e30';
        ctx.beginPath();
        ctx.moveTo(0, H * 0.78);
        for (let x = 0; x < W; x += 4) {
            ctx.lineTo(x, H * 0.78 + Math.sin(x * 0.04 + t * 0.01) * 2);
        }
        ctx.lineTo(W, H);
        ctx.lineTo(0, H);
        ctx.closePath();
        ctx.fill();

        const s = Math.sin(t * 0.018) * 10;
        ctx.fillStyle = '#0d2540';
        ctx.fillRect(0, H * 0.8, W * 0.48 + s, H * 0.22);
        ctx.fillStyle = '#0f2a48';
        ctx.fillRect(W * 0.48 + s, H * 0.78, W * 0.52, H * 0.24);
        ctx.strokeStyle = 'rgba(255,77,26,.5)';
        ctx.lineWidth = 1.5;
        ctx.beginPath();
        ctx.moveTo(W * 0.48 + s, H * 0.76);
        ctx.lineTo(W * 0.48 + s, H);
        ctx.stroke();

        const wPos = [
            (t * 1.6) % (W + 200) - 100,
            (t * 1.6 + 130) % (W + 200) - 100,
            (t * 1.6 + 260) % (W + 200) - 100
        ];
        wPos.forEach((wx, i) => {
            const op = 0.55 - i * 0.13;
            const h = 26 * (1 + (wx / W) * 0.5) * (1 - i * 0.18);
            const wgr = ctx.createLinearGradient(0, 0, 0, h * 2);
            wgr.addColorStop(0, `rgba(80,180,255,${op})`);
            wgr.addColorStop(1, `rgba(0,70,160,${op * 0.3})`);
            ctx.fillStyle = wgr;
            ctx.beginPath();
            ctx.moveTo(wx - 42, H * 0.42);
            ctx.quadraticCurveTo(wx, H * 0.42 - h, wx + 42, H * 0.42);
            ctx.lineTo(wx + 55, H * 0.6);
            ctx.lineTo(wx - 55, H * 0.6);
            ctx.closePath();
            ctx.fill();
        });

        ctx.beginPath();
        ctx.strokeStyle = 'rgba(80,180,255,.35)';
        ctx.lineWidth = 1.4;
        for (let x = 0; x < W; x++) {
            const y = H * 0.52 + Math.sin(x * 0.05 + t * 0.09) * 7 + Math.sin(x * 0.02 - t * 0.05) * 4;
            x === 0 ? ctx.moveTo(x, y) : ctx.lineTo(x, y);
        }
        ctx.stroke();

        ctx.fillStyle = 'rgba(255,255,255,.5)';
        ctx.font = '9px Space Grotesk,sans-serif';
        ctx.fillText('Placa de Cocos', 8, H * 0.9);
        ctx.fillText('Placa del Caribe', W * 0.55, H * 0.88);
        ctx.fillStyle = 'rgba(80,180,255,.8)';
        ctx.fillText('➡️ Tsunami propagándose', W * 0.02, H * 0.37);

        t++;
        requestAnimationFrame(draw);
    }
    draw();
})();

  
//  16. PREPAREDNESS
  

const prepData = {
    before: {
        color: '#2d8fff',
        title: '⏰ Antes del Sismo',
        steps: [
            { i: '🗺️', t: 'Identifica rutas de evacuación y puntos de reunión familiar.' },
            { i: '🎒', t: 'Prepara mochila de emergencia con agua, comida y documentos.' },
            { i: '🏠', t: 'Asegura muebles y objetos que puedan caerse.' },
            { i: '📞', t: 'Establece un plan de comunicación familiar.' },
            { i: '<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M14.7 6.3a4 4 0 1 0-5.4 5.4L2 19l3 3 7.3-7.3a4 4 0 0 0 5.4-5.4l-2.83 2.83-2-2z"/></svg>', t: 'Aprende a cerrar gas, agua y electricidad.' }
        ],
        checklist: ['Mochila lista', 'Rutas conocidas', 'Documentos seguros', 'Plan familiar acordado',
            'Números memorizados'
        ]
    },
    during: {
        color: '#ff9900',
        title: '⚡ Durante el Sismo',
        steps: [
            { i: '📦', t: 'AGÁCHATE bajo mesa sólida o junto a pared interior.' },
            { i: '🛡️', t: 'CÚBRETE la cabeza y cuello con tus brazos.' },
            { i: '<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><circle cx="12" cy="13" r="6"/><path d="M9 8V5a1 1 0 0 1 2 0v2M13 8V4a1 1 0 0 1 2 0v3"/></svg>', t: 'SOSTENETE hasta que el sismo termine.' },
            { i: '🚫', t: 'NO corras ni uses ascensores durante el temblor.' },
            { i: '🚫', t: 'Aléjate de ventanas, vitrinas y estanterías.' }
        ],
        checklist: ['Zona segura identificada', 'Practica agacharse', 'Evita ventanas', 'No usar ascensores',
            'Mantener la calma'
        ]
    },
    after: {
        color: '#22c55e',
        title: '✅ Después del Sismo',
        steps: [
            { i: '<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>', t: 'Verifica lesiones propias y aplica primeros auxilios básicos.' },
            { i: '<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M12 2s5 5 5 10a5 5 0 0 1-10 0c0-2 1-3 1-3s1 2 2 2c1.5 0 2-1.5 2-3 0-2.5-2-4-2-4s2-1 2-2z"/></svg>', t: 'Revisa incendios, fugas de gas o daños estructurales.' },
            { i: '📻', t: 'Escucha radio oficial para instrucciones de autoridades.' },
            { i: '🧭', t: 'Evacúa ordenadamente si hay daños visibles en el edificio.' },
            { i: '⚠️', t: 'Espera réplicas y permanece alerta 72 horas.' }
        ],
        checklist: ['Verificar lesiones', 'Revisar gas y luz', 'Radio oficial encendida', 'Evacuar si hay daños',
            'No regresar sin permiso'
        ]
    },
    coast: {
        color: '#00d4b0',
        title: '<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M2 12c1.5-1.5 3-1.5 4.5 0s3 1.5 4.5 0 3-1.5 4.5 0 3 1.5 4.5 0"/><path d="M2 18c1.5-1.5 3-1.5 4.5 0s3 1.5 4.5 0 3-1.5 4.5 0 3 1.5 4.5 0"/></svg> En la Costa — Tsunami',
        steps: [
            { i: '<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M2 12c1.5-1.5 3-1.5 4.5 0s3 1.5 4.5 0 3-1.5 4.5 0 3 1.5 4.5 0"/><path d="M2 18c1.5-1.5 3-1.5 4.5 0s3 1.5 4.5 0 3-1.5 4.5 0 3 1.5 4.5 0"/></svg>', t: 'Sismo largo en la costa: CORRE tierra adentro INMEDIATAMENTE.' },
            { i: '🏔️', t: 'Busca terreno elevado a mínimo 30m sobre el nivel del mar.' },
            { i: '🚫', t: 'NUNCA te quedes a observar el retiro del mar.' },
            { i: '<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M4 4l16 16M12 8a4 4 0 0 1 4 4M12 4a8 8 0 0 1 8 8"/><circle cx="6" cy="18" r="2"/></svg>', t: 'Escucha alertas del SINAPRED y autoridades.' },
            { i: '<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M2 12s4-6 11-6c5 0 9 3 9 6s-4 6-9 6c-7 0-11-6-11-6z"/><circle cx="17" cy="11" r="0.6" fill="currentColor"/></svg>', t: 'Si estás en bote, navega a aguas profundas.' }
        ],
        checklist: ['Rutas evacuación costera', 'Zonas elevadas identificadas', 'No acampar en playas bajas',
            'Radio a pilas disponible', 'Nunca observar retiro del mar'
        ]
    }
};

const prepCheckedSets = {
    before: new Set(),
    during: new Set(),
    after: new Set(),
    coast: new Set()
};
let prepActive = 'before';

function renderPrep() {
    const panelsEl = document.getElementById('prepPanels');
    if (!panelsEl) return;
    const p = prepData[prepActive];
    const checked = prepCheckedSets[prepActive];
    panelsEl.innerHTML = `
        <div class="prep-panel on">
            <div class="pp-scene">
                <canvas id="prepCv"></canvas>
                <div class="pp-body"><h4>${p.title}</h4>
                ${p.steps.map(s => `<div class="pp-step"><span>${s.i}</span><span>${s.t}</span></div>`).join('')}</div>
            </div>
            <div class="pp-checklist">
                <div class="pcl-hdr">📋 Lista de Verificación <span class="chip t" id="pclCount" style="margin-left:4px">${checked.size}/${p.checklist.length}</span></div>
                ${p.checklist.map((item, i) =>
                    `<div class="pcli${checked.has(i) ? ' done' : ''}" onclick="togPCL(${i})" id="pcl${i}">
                        <div class="pcli-box">${checked.has(i) ? '✅' : ''}</div>
                        <div class="pcli-text">${item}</div>
                    </div>`
                ).join('')}
            </div>
        </div>
    `;
    drawPrepCanvas(prepActive);
}

window.togPCL = function(i) {
    const s = prepCheckedSets[prepActive];
    s.has(i) ? s.delete(i) : s.add(i);
    const el = document.getElementById('pcl' + i);
    el.classList.toggle('done', s.has(i));
    el.querySelector('.pcli-box').textContent = s.has(i) ? '✅' : '';
    const cnt = document.getElementById('pclCount');
    if (cnt) cnt.textContent = `${s.size}/${prepData[prepActive].checklist.length}`;
};

document.querySelectorAll('.prep-tab').forEach(tab => {
    tab.onclick = () => {
        document.querySelectorAll('.prep-tab').forEach(b => b.classList.remove('on'));
        tab.classList.add('on');
        prepActive = tab.dataset.prep;
        renderPrep();
    };
});

function drawPrepCanvas(mode) {
    const c = document.getElementById('prepCv');
    if (!c) return;
    c.width = c.offsetWidth;
    c.height = 180;
    const ctx = c.getContext('2d');

    const pals = {
        before: ['#0e1e36', '#2d8fff'],
        during: ['#1e0e00', '#ff9900'],
        after: ['#061a0c', '#22c55e'],
        coast: ['#001422', '#00d4b0']
    };
    const [bg, acc] = pals[mode] || pals.before;
    const W = c.width,
        H = c.height;

    const gr = ctx.createLinearGradient(0, 0, W, H);
    gr.addColorStop(0, bg);
    gr.addColorStop(1, '#050810');
    ctx.fillStyle = gr;
    ctx.fillRect(0, 0, W, H);

    ctx.fillStyle = 'rgba(255,255,255,.55)';
    ctx.font = 'bold 12px Space Grotesk,sans-serif';

    if (mode === 'before') {
        ctx.fillText('🏫 Prepara tu aula', 10, 22);
        const bds = [
            [0.12, 0.4, 0.08, 0.44],
            [0.26, 0.34, 0.07, 0.42],
            [0.46, 0.37, 0.1, 0.46],
            [0.63, 0.34, 0.07, 0.42],
            [0.79, 0.4, 0.07, 0.43]
        ];
        bds.forEach(([x, y, w, h]) => {
            ctx.fillStyle = acc + '25';
            ctx.fillRect(W * x, H * y, W * w, H * h);
            ctx.strokeStyle = acc + '55';
            ctx.lineWidth = 1;
            ctx.strokeRect(W * x, H * y, W * w, H * h);
        });
        ctx.fillStyle = acc + '70';
        ctx.fillRect(W * 0.08, H * 0.68, W * 0.84, H * 0.07);
        ctx.fillStyle = 'rgba(255,255,255,.35)';
        ctx.font = '10px Space Grotesk,sans-serif';
        ctx.fillText('Identifica zonas seguras y rutas de salida', W * 0.12, H * 0.86);
    } else if (mode === 'during') {
        ctx.fillText('⚡ ¡Agáchate y cúbrete!', 10, 22);
        ctx.fillStyle = acc + '35';
        ctx.fillRect(W * 0.32, H * 0.28, W * 0.36, H * 0.38);
        ctx.strokeStyle = acc;
        ctx.lineWidth = 2;
        ctx.strokeRect(W * 0.32, H * 0.28, W * 0.36, H * 0.38);
        ctx.font = '32px';
        ctx.fillText('📦', W * 0.42, H * 0.52);
        ctx.fillStyle = 'rgba(255,255,255,.35)';
        ctx.font = '10px Space Grotesk,sans-serif';
        ctx.fillText('▶ AGÁCHATE — CÚBRETE — SOSTENETE', W * 0.1, H * 0.86);
    } else if (mode === 'after') {
        ctx.fillText('✅ Evalúa y actúa con calma', 10, 22);
        [0.14, 0.34, 0.58, 0.78].forEach(x => {
            ctx.fillStyle = acc + '18';
            ctx.fillRect(W * x, H * 0.28, W * 0.1, H * 0.5);
            ctx.strokeStyle = acc + '45';
            ctx.lineWidth = 1;
            ctx.strokeRect(W * x, H * 0.28, W * 0.1, H * 0.5);
        });
        ctx.fillStyle = 'rgba(34,197,94,.3)';
        ctx.fillRect(0, H * 0.73, W, H * 0.07);
        ctx.fillStyle = 'rgba(255,255,255,.35)';
        ctx.font = '10px Space Grotesk,sans-serif';
        ctx.fillText('✅ Verifica daños y escucha instrucciones oficiales', W * 0.08, H * 0.86);
    } else {
        ctx.fillText('<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M2 12c1.5-1.5 3-1.5 4.5 0s3 1.5 4.5 0 3-1.5 4.5 0 3 1.5 4.5 0"/><path d="M2 18c1.5-1.5 3-1.5 4.5 0s3 1.5 4.5 0 3-1.5 4.5 0 3 1.5 4.5 0"/></svg> Costa Pacífica — Protocolo Tsunami', 10, 22);
        ctx.fillStyle = '#001f4d';
        ctx.fillRect(0, H * 0.55, W, H * 0.45);
        for (let i = 0; i < 4; i++) {
            ctx.beginPath();
            ctx.strokeStyle = `rgba(0,212,176,${0.4 - i * 0.08})`;
            ctx.lineWidth = 1.4;
            for (let x = 0; x < W; x++) {
                const y = H * 0.55 + Math.sin(x * 0.04 + i * 0.8) * 14 - i * 9;
                x === 0 ? ctx.moveTo(x, y) : ctx.lineTo(x, y);
            }
            ctx.stroke();
        }
        ctx.fillStyle = acc + '55';
        ctx.beginPath();
        ctx.arc(W * 0.7, H * 0.28, 18, 0, Math.PI * 2);
        ctx.fill();
        ctx.font = '14px';
        ctx.fillText('🏔️', W * 0.66, H * 0.32);
        ctx.fillStyle = 'rgba(255,255,255,.35)';
        ctx.font = '10px Space Grotesk,sans-serif';
        ctx.fillText('▲ Evacúa hacia terrenos elevados (30m+)', W * 0.1, H * 0.86);
    }
}

  
//  17. BACKPACK
  

const bpCategories = [
    { id: 'agua', icon: '💧', title: 'Agua y Alimentos', accent: '#2d8fff',
        items: [
            { i: '💧', n: 'Agua (3L por persona/día)' },
            { i: '🥫', n: 'Comida enlatada (3 días)' },
            { i: '🍫', n: 'Barras energéticas' },
            { i: '💊', n: 'Pastillas purificadoras' }
        ] },
    { id: 'med', icon: '🩹', title: 'Suministros Médicos', accent: '#ff4d6a',
        items: [
            { i: '🩹', n: 'Botiquín primeros auxilios' },
            { i: '💊', n: 'Medicamentos personales' },
            { i: '📖', n: 'Manual de primeros auxilios' },
            { i: '🧴', n: 'Antiséptico y alcohol gel' }
        ] },
    { id: 'docs', icon: '📋', title: 'Documentos', accent: '#ff8c00',
        items: [
            { i: '📋', n: 'Copia de documentos (DUI)' },
            { i: '💵', n: 'Efectivo en billetes' },
            { i: '🔌', n: 'Cargador portátil (batería)' },
            { i: '📞', n: 'Lista de contactos impresos' }
        ] },
    { id: 'tools', icon: '🔦', title: 'Herramientas de Emergencia', accent: '#00d4b0',
        items: [
            { i: '🔦', n: 'Linterna y pilas extra' },
            { i: '📻', n: 'Radio a pilas (MARN)' },
            { i: '📯', n: 'Silbato de rescate' },
            { i: '👕', n: 'Ropa y poncho impermeable' },
            { i: '🔑', n: 'Copia de llaves' },
            { i: '🗺️', n: 'Mapa impreso de El Salvador' }
        ] }
];

const bpChecked = {};
let bpTotal = 0;
bpCategories.forEach(cat => {
    bpTotal += cat.items.length;
    cat.items.forEach((_, i) => {
        bpChecked[cat.id + '-' + i] = false;
    });
});

function renderBP() {
    const grid = document.getElementById('bpCatsGrid');
    if (!grid) return;

    let checked = 0;
    Object.values(bpChecked).forEach(v => { if (v) checked++; });
    const pct = Math.round(checked / bpTotal * 100);

    const pctEl = document.getElementById('bpPct');
    if (pctEl) pctEl.textContent = pct + '%';
    const fillEl = document.getElementById('bpFill');
    if (fillEl) fillEl.style.width = pct + '%';

    grid.innerHTML = bpCategories.map(cat => {
        const catChecked = cat.items.filter((_, i) => bpChecked[cat.id + '-' + i]).length;
        const allDone = catChecked === cat.items.length;
        return `<div class="bp-cat-card">
            <div class="bp-cat-hd">
                <span class="bp-cat-ico">${cat.icon}</span>
                <span class="bp-cat-name">${cat.title}</span>
                <span class="bp-cat-cnt${allDone ? ' done' : ''}">${catChecked}/${cat.items.length}</span>
            </div>
            <div class="bp-items-list">
                ${cat.items.map((item, i) => {
                    const key = cat.id + '-' + i;
                    const on = bpChecked[key];
                    return `<div class="bp-item${on ? ' ticked' : ''}" onclick="togBPItem('${key}')">
                        <span class="bp-item-icon">${item.i}</span>
                        <span class="bp-item-name">${item.n}</span>
                        <span class="bp-item-chk">${on ? '✅' : ''}</span>
                    </div>`;
                }).join('')}
            </div>
        </div>`;
    }).join('');
}

window.togBPItem = function(key) {
    bpChecked[key] = !bpChecked[key];
    renderBP();
};

window.resetBP = function() {
    Object.keys(bpChecked).forEach(k => bpChecked[k] = false);
    renderBP();
};

const bpItems = [];
const bpSet = new Set();
window.togBP = function() {};

  
//  18. TRIVIA
  

const trivQ = {
    easy: [
        { q: '¿Qué técnica usar durante un sismo?', o: ['Correr a la calle', 'Agáchate, Cúbrete, Sostenete',
                'Pararse en el marco de la puerta', 'Llamar al 911'
            ], c: 1,
            e: 'La técnica oficial de Cruz Roja es Agáchate, Cúbrete y Sostenete bajo mesa sólida.' },
        { q: '¿Cuál es el número de emergencias en El Salvador?', o: ['123', '112', '911', '1800'], c: 2,
            e: 'El 911 es el número unificado de emergencias.' },
        { q: '¿Cuántos días de suministros debe tener tu mochila?', o: ['1 día', '3 días', '7 días', '30 días'], c: 1,
            e: 'Se recomienda mínimo 3 días de agua y comida en el kit de emergencia.' },
        { q: '¿Qué puede ocurrir tras un sismo submarino?', o: ['Tornado', 'Tsunami', 'Granizo', 'Lluvia ácida'],
            c: 1, e: 'Un sismo submarino ≥M7.0 puede generar un tsunami desplazando el fondo oceánico.' },
        { q: '¿Cuál es el primer signo visual de un tsunami?', o: ['El mar sube', 'El mar se retira',
                'Suenan sirenas', 'El cielo se oscurece'
            ], c: 1,
            e: 'El retiro anormal del mar indica que un tsunami está llegando. Huye INMEDIATAMENTE.' }
    ],
    medium: [
        { q: '¿Qué placas tectónicas causan sismos en El Salvador?', o: ['Nazca y Sudamericana',
                'Cocos y del Caribe', 'Norteamericana y Pacífica', 'Filipina y Euroasiática'
            ], c: 1,
            e: 'La subducción de la Placa de Cocos bajo la del Caribe genera la actividad sísmica.' },
        { q: '¿Magnitud del terremoto del 13 de enero de 2001?', o: ['5.5', '6.2', '7.7', '8.1'], c: 2,
            e: 'El terremoto del 13-ene-2001 tuvo M7.7 y dejó más de 1,200 muertos.' },
        { q: '¿Qué mide la escala de magnitud?', o: ['Duración', 'Energía liberada', 'Daños en edificios',
                'Profundidad'
            ], c: 1, e: 'La magnitud mide la energía liberada en el foco. Cada unidad = ~32x más energía.' },
        { q: '¿A cuántos km/h viajan los tsunamis?', o: ['100', '300', '800', '2000'], c: 2,
            e: 'En mar abierto los tsunamis viajan a ~800 km/h, similar a un avión.' },
        { q: '¿Cuántos volcanes tiene El Salvador?', o: ['5', '10', '26', '50'], c: 2,
            e: 'El Salvador tiene ~26 volcanes, varios de ellos activos.' }
    ],
    hard: [
        { q: '¿A qué velocidad subduce la Placa de Cocos?', o: ['1 cm/año', '8 cm/año', '25 cm/año', '1 m/año'],
            c: 1, e: 'La Placa de Cocos subduce a ~8 cm/año, generando constante actividad sísmica.' },
        { q: '¿El "Triángulo de Vida" es técnica recomendada?', o: ['Sí, Cruz Roja', 'Sí, FEMA',
                'No, está desacreditado', 'Solo en edificios viejos'
            ], c: 2,
            e: 'El "Triángulo de Vida" fue formalmente desacreditado. Cruz Roja recomienda Agáchate-Cúbrete-Sostenete.' },
        { q: '¿Qué institución opera la Red Sísmica de El Salvador?', o: ['Cruz Roja', 'MARN', 'USGS', 'OPS'],
            c: 1, e: 'El MARN opera la Red Sísmica Nacional de El Salvador.' },
        { q: '¿Qué ondas sísmicas llegan primero?', o: ['Ondas S', 'Superficiales', 'Ondas P', 'Ondas Love'],
            c: 2, e: 'Las Ondas P (primarias) son las más rápidas y siempre llegan primero.' },
        { q: '¿Cuántos sismos perceptibles hay al año en El Salvador?', o: ['~10', '~50', '~100', '~500'], c: 2,
            e: 'El Salvador registra ~100 sismos perceptibles por año.' }
    ]
};

let tLv = '',
    tIdx = 0,
    tScore = 0,
    tAnswered = false;

document.querySelectorAll('.tlv').forEach(btn => {
    btn.onclick = () => {
        tLv = btn.dataset.lv;
        tIdx = 0;
        tScore = 0;
        document.getElementById('triSel').style.display = 'none';
        document.getElementById('triGame').style.display = 'block';
        document.getElementById('triRes').style.display = 'none';
        showTQ();
    };
});

function showTQ() {
    const qs = trivQ[tLv];
    if (tIdx >= qs.length) { showTRes(); return; }
    tAnswered = false;
    const q = qs[tIdx];
    const lvN = { easy: '<span style="display:inline-block;width:0.55em;height:0.55em;border-radius:50%;background:var(--green);vertical-align:0.05em"></span> Básico', medium: '<span style="display:inline-block;width:0.55em;height:0.55em;border-radius:50%;background:var(--acc4);vertical-align:0.05em"></span> Intermedio', hard: '<span style="display:inline-block;width:0.55em;height:0.55em;border-radius:50%;background:var(--red);vertical-align:0.05em"></span> Avanzado' };
    document.getElementById('triGame').innerHTML = `
        <div class="tg-hdr">
            <span>${lvN[tLv]}</span>
            <span>Puntos: ${tScore}</span>
            <span>${tIdx + 1}/${qs.length}</span>
        </div>
        <div class="tg-qcard">
            <div class="tg-q">${q.q}</div>
            <div class="tg-opts">
                ${q.o.map((o, i) => `<button class="tg-opt" onclick="ansT(${i})" id="to${i}">${['A','B','C','D'][i]}) ${o}</button>`).join('')}
            </div>
        </div>
        <div id="tfb"></div>
    `;
}

window.ansT = function(idx) {
    if (tAnswered) return;
    tAnswered = true;
    const q = trivQ[tLv][tIdx];
    if (idx === q.c) tScore++;
    document.querySelectorAll('.tg-opt').forEach((b, i) => {
        b.disabled = true;
        if (i === q.c) b.classList.add('cor');
        else if (i === idx) b.classList.add('wrg');
    });
    document.getElementById('tfb').innerHTML = `
        <div class="tg-fb ${idx === q.c ? 'c' : 'w'}">
            ${idx === q.c ? '✅ ¡Correcto!' : '❌ Incorrecto.'} ${q.e}
            <button class="btn-acc" style="margin-top:9px;font-size:.76rem;padding:6px 14px" onclick="nextT()">Siguiente ➡️</button>
        </div>
    `;
};

window.nextT = function() {
    tIdx++;
    showTQ();
};

function showTRes() {
    document.getElementById('triGame').style.display = 'none';
    const total = trivQ[tLv].length,
        pct = Math.round(tScore / total * 100);
    const ico = pct === 100 ? '<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M8 21h8M12 17v4M7 4h10v5a5 5 0 0 1-10 0V4z"/><path d="M17 5h3a2 2 0 0 1-2 4M7 5H4a2 2 0 0 0 2 4"/></svg>' : pct >= 80 ? '⭐' : pct >= 60 ? '<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M7 11v10H4a1 1 0 0 1-1-1v-8a1 1 0 0 1 1-1zM7 11l4-8a2 2 0 0 1 4 2l-1 5h6a2 2 0 0 1 2 2.6l-2.5 7A2 2 0 0 1 17.6 21H7"/></svg>' : '🧑‍🏫';
    const res = document.getElementById('triRes');
    res.style.display = 'block';
    res.innerHTML = `
        <div style="font-size:3rem;margin-bottom:10px">${ico}</div>
        <h3 style="font-family:var(--fd);font-size:1.4rem;font-weight:800;margin-bottom:7px">¡Trivia Completada!</h3>
        <div class="tr-score">${tScore}/${total}</div>
        <p style="color:var(--text2);margin:10px 0">${pct >= 80 ? '¡Excelente! Dominas el tema.' : 'Sigue aprendiendo sobre preparación.'}</p>
        <div style="display:flex;gap:10px;justify-content:center;flex-wrap:wrap">
            <button class="btn-acc" onclick="rT()"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/></svg> Reintentar</button>
            <button class="btn-out" onclick="chLv()">Cambiar nivel</button>
        </div>
    `;
}

window.rT = function() {
    tIdx = 0;
    tScore = 0;
    document.getElementById('triRes').style.display = 'none';
    document.getElementById('triGame').style.display = 'block';
    showTQ();
};

window.chLv = function() {
    document.getElementById('triRes').style.display = 'none';
    document.getElementById('triSel').style.display = 'block';
};

window.fd = function(f) {
    ndaAlert('📤 Descargando: ' + f + ' — este archivo se descargaría desde los servidores del MINED/MARN en producción.');
};

  
//  19. FLOATING SEISMIC PARTICLES
  

(function() {
    const container = document.getElementById('seismicParticles');
    if (!container) return;

    for (let i = 0; i < 6; i++) {
        const wave = document.createElement('div');
        wave.className = 'sp-wave';
        wave.style.cssText = `
            top:${Math.random() * 100}%;
            animation-duration:${12 + Math.random() * 18}s;
            animation-delay:${Math.random() * 15}s;
            height:${1 + Math.random() * 2}px;
            opacity:${0.15 + Math.random() * 0.3};
            background:linear-gradient(90deg,transparent,rgba(${Math.random() > 0.5 ? '255,77,26' : '45,143,255'},0.3),transparent);
        `;
        container.appendChild(wave);
    }

    for (let i = 0; i < 5; i++) {
        const plate = document.createElement('div');
        plate.className = 'sp-plate';
        const size = 40 + Math.random() * 50;
        plate.style.cssText = `
            left:${Math.random() * 90}%;
            top:${Math.random() * 90}%;
            width:${size}px;
            height:${size * 0.65}px;
            animation-duration:${8 + Math.random() * 12}s;
            animation-delay:${Math.random() * 8}s;
            border-color:rgba(${Math.random() > 0.5 ? '255,77,26' : '0,212,176'},0.12);
            transform:rotate(${Math.random() * 360}deg);
        `;
        container.appendChild(plate);
    }

    for (let i = 0; i < 4; i++) {
        const ring = document.createElement('div');
        ring.className = 'sp-ring';
        const size = 30 + Math.random() * 40;
        ring.style.cssText = `
            left:${10 + Math.random() * 80}%;
            top:${10 + Math.random() * 80}%;
            width:${size}px;
            height:${size}px;
            animation-duration:${4 + Math.random() * 5}s;
            animation-delay:${Math.random() * 6}s;
            border-color:rgba(${Math.random() > 0.5 ? '255,77,26' : '0,212,176'},0.18);
        `;
        container.appendChild(ring);
    }
})();


//  19B. PARTICULAS TEMATICAS POR TIPO DE DESASTRE (paginas de Desastres)


// Cada tipo de desastre tiene su propia forma/animacion (ver clases dis-p-*
// y sus @keyframes en desastres-base.css). El color sale de --dis-accent
// (currentColor), asi que no hace falta pasar colores aqui.
const NDA_PARTICLE_CONFIGS = {
    volcanes:       { cls: 'dis-p-ember',  count: 18, dur: [4, 8],    size: [6, 13] },
    tsunamis:       { cls: 'dis-p-bubble', count: 12, dur: [3, 6],    size: [16, 38] },
    inundaciones:   { cls: 'dis-p-drop',   count: 22, dur: [1.2, 2.4],size: [4, 7] },
    deslizamientos: { cls: 'dis-p-debris', count: 16, dur: [3, 6],    size: [5, 10] },
    incendios:      { cls: 'dis-p-spark',  count: 20, dur: [1.4, 2.8],size: [4, 9] },
    tormentas:      { cls: 'dis-p-wind',   count: 10, dur: [2.6, 4.4],size: [46, 90] },
    sequias:        { cls: 'dis-p-dust',   count: 14, dur: [7, 12],   size: [4, 8] }
};

window.ndaInitDisParticles = function (containerId, type) {
    const container = document.getElementById(containerId);
    const cfg = NDA_PARTICLE_CONFIGS[type];
    if (!container || !cfg) return;

    for (let i = 0; i < cfg.count; i++) {
        const el = document.createElement('div');
        el.className = 'dis-particle ' + cfg.cls;
        const size = cfg.size[0] + Math.random() * (cfg.size[1] - cfg.size[0]);
        const dur = cfg.dur[0] + Math.random() * (cfg.dur[1] - cfg.dur[0]);
        el.style.cssText = `
            left:${Math.random() * 100}%;
            top:${Math.random() * 100}%;
            width:${size.toFixed(1)}px;
            height:${size.toFixed(1)}px;
            animation-duration:${dur.toFixed(2)}s;
            animation-delay:${(Math.random() * -dur).toFixed(2)}s;
            opacity:${(0.55 + Math.random() * 0.4).toFixed(2)};
        `;
        container.appendChild(el);
    }
};


//  19C. GALERIA 3D: GRILLA DE ACCESO DIRECTO A LOS VISORES (debajo del
//  carrusel), monta la escena Three.js SOLA en cuanto la tarjeta entra en
//  pantalla al hacer scroll -- sin necesidad de darle clic a nada. Se usa
//  IntersectionObserver para no montar los 11 visores WebGL de una vez
//  apenas carga la pagina (ver assets/js/disaster3d.js -- window.NDA_Disaster3D).


function initAutoMount3D() {
    const targets = document.querySelectorAll('.nda-auto3d');
    if (!targets.length) return;
    if (!window.IntersectionObserver) {
        // Sin soporte para IntersectionObserver (muy raro hoy en dia): monta
        // todo de una vez en vez de no mostrar nada.
        targets.forEach(t => { if (window.NDA_Disaster3D) window.NDA_Disaster3D.mount(t, t.dataset.slug); });
        return;
    }
    const io = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (!entry.isIntersecting || !window.NDA_Disaster3D) return;
            window.NDA_Disaster3D.mount(entry.target, entry.target.dataset.slug);
            io.unobserve(entry.target);
        });
    }, { rootMargin: '250px' });
    targets.forEach(t => io.observe(t));
}


//  19D. GALERIA 3D: CARRUSEL DE TARJETAS DEL HERO (fila horizontal con
//  varias tarjetas visibles; la escena Three.js de la tarjeta activa se
//  monta sola en cuanto se centra, sin necesidad de darle clic a nada)


window.NDA_SK3D_ACTIVE = 0;
// Guarda el HTML original (placeholder) de cada visor de slide para poder
// restaurarlo al desactivar una tarjeta que tenia la escena 3D montada.
const __sk3dOriginalViewportHtml = new WeakMap();

function sk3dRender() {
    const track = document.getElementById('sk3dTrack');
    const viewport = document.getElementById('sk3dTrackViewport');
    if (!track || !viewport) return;
    const slides = [...track.children];
    const active = window.NDA_SK3D_ACTIVE;

    slides.forEach((slide, i) => {
        const isActive = i === active;
        slide.classList.toggle('active', isActive);
        // Si el slide deja de estar activo y tenia la escena 3D montada, la
        // desmontamos (libera el contexto WebGL) y devolvemos el visor a su
        // placeholder original para no dejar renders de fondo innecesarios.
        if (!isActive && slide.dataset.loaded === '1') {
            const slideViewport = slide.querySelector('.sk3d-slide-viewport');
            if (slideViewport) {
                if (window.NDA_Disaster3D) window.NDA_Disaster3D.unmount(slideViewport);
                const original = __sk3dOriginalViewportHtml.get(slideViewport);
                if (original !== undefined) slideViewport.innerHTML = original;
            }
            slide.dataset.loaded = '0';
        }
    });

    // Centra la tarjeta activa dentro del visor, sin desplazarse mas alla
    // del inicio/final de la fila.
    const activeSlide = slides[active];
    if (activeSlide) {
        const maxTranslate = Math.max(0, track.scrollWidth - viewport.clientWidth);
        const centered = activeSlide.offsetLeft - (viewport.clientWidth - activeSlide.offsetWidth) / 2;
        const target = Math.min(maxTranslate, Math.max(0, centered));
        track.style.transform = `translateX(${-target}px)`;
    }

    // La tarjeta activa monta su escena 3D sola, sin esperar un clic.
    if (activeSlide && activeSlide.dataset.loaded !== '1' && window.NDA_Disaster3D) {
        const activeViewport = activeSlide.querySelector('.sk3d-slide-viewport');
        if (activeViewport) {
            window.NDA_Disaster3D.mount(activeViewport, activeSlide.dataset.slug);
            activeSlide.dataset.loaded = '1';
        }
    }

    document.querySelectorAll('#sk3dDots .sk3d-dot').forEach(d => {
        d.classList.toggle('active', Number(d.dataset.index) === active);
    });
    document.querySelectorAll('#sk3dPanel .sk3d-panel-item').forEach(p => {
        p.classList.toggle('active', Number(p.dataset.index) === active);
    });

    // El fondo del hero refleja el color de acento del modelo activo con un
    // resplandor sutil (antes mostraba la foto Sketchfab del modelo).
    const heroBg = document.getElementById('sk3dHeroBg');
    if (heroBg && activeSlide) {
        heroBg.style.setProperty('--sk-accent', getComputedStyle(activeSlide).getPropertyValue('--sk-accent'));
    }

    // Stepper vertical: nombre del modelo anterior/siguiente atenuado arriba
    // y abajo del nombre activo (detalle de la referencia tipo Foxico/Bali).
    const n = slides.length;
    const prevSlide = slides[(active - 1 + n) % n];
    const nextSlide = slides[(active + 1) % n];
    const stepPrev = document.getElementById('sk3dStepPrev');
    const stepActive = document.getElementById('sk3dStepActive');
    const stepNext = document.getElementById('sk3dStepNext');
    if (stepPrev) stepPrev.textContent = prevSlide ? prevSlide.dataset.nombre : '';
    if (stepActive && activeSlide) stepActive.textContent = activeSlide.dataset.nombre || '';
    if (stepNext) stepNext.textContent = nextSlide ? nextSlide.dataset.nombre : '';

    // Circulo de indice + contador "01 / 08" al pie del carrusel.
    const indexCircle = document.getElementById('sk3dIndexCircle');
    if (indexCircle) indexCircle.textContent = String(active + 1);
    const counterActive = document.getElementById('sk3dCounterActive');
    if (counterActive) counterActive.textContent = String(active + 1).padStart(2, '0');
}

window.sk3dGoTo = function (index) {
    const track = document.getElementById('sk3dTrack');
    if (!track || index === window.NDA_SK3D_ACTIVE) return;
    const n = track.children.length;
    window.NDA_SK3D_ACTIVE = ((index % n) + n) % n;
    sk3dRender();
};

window.sk3dNav = function (dir) {
    const track = document.getElementById('sk3dTrack');
    if (!track) return;
    const n = track.children.length;
    window.NDA_SK3D_ACTIVE = ((window.NDA_SK3D_ACTIVE + dir) % n + n) % n;
    sk3dRender();
};

function initSk3dCarousel() {
    const track = document.getElementById('sk3dTrack');
    if (!track) return;
    // Guarda el placeholder original de cada slide antes de montar nada,
    // para poder restaurarlo cuando una tarjeta deja de estar activa.
    track.querySelectorAll('.sk3d-slide-viewport').forEach(vp => {
        __sk3dOriginalViewportHtml.set(vp, vp.innerHTML);
    });
    sk3dRender();
    document.addEventListener('keydown', (e) => {
        if (!document.getElementById('sk3dHero')) return;
        if (e.key === 'ArrowLeft') sk3dNav(-1);
        if (e.key === 'ArrowRight') sk3dNav(1);
    });
    // Recalcula el desplazamiento al cambiar el ancho del visor (rotacion de
    // pantalla, resize de ventana, cambio de breakpoint).
    window.addEventListener('resize', sk3dRender);
}


//  20. 3D MOUSE PARALLAX ON HERO


(function() {
    const hero = document.getElementById('home');
    if (!hero) return;

    hero.addEventListener('mousemove', (e) => {
        const rect = hero.getBoundingClientRect();
        const mx = (e.clientX - rect.left) / rect.width - 0.5;
        const my = (e.clientY - rect.top) / rect.height - 0.5;

        const monitor = hero.querySelector('.hero-monitor');
        if (monitor) {
            monitor.style.transform =
                `perspective(800px) rotateY(${mx * 6}deg) rotateX(${-my * 4}deg) translateZ(10px)`;
        }
        const heroInner = hero.querySelector('.hero-inner');
        if (heroInner) {
            heroInner.style.transform = `translate(${mx * 8}px, ${my * 5}px)`;
        }
    });

    hero.addEventListener('mouseleave', () => {
        const monitor = hero.querySelector('.hero-monitor');
        if (monitor) monitor.style.transform = '';
        const heroInner = hero.querySelector('.hero-inner');
        if (heroInner) heroInner.style.transform = '';
    });
})();

  
//  21. SEISMIC BG LINES IN MONITOR PANEL
  

(function() {
    const waveArea = document.querySelector('.sg-wave-area');
    if (!waveArea) return;

    const bgDiv = document.createElement('div');
    bgDiv.className = 'sg-bg-lines';
    for (let i = 0; i < 6; i++) {
        const line = document.createElement('div');
        line.className = 'sg-bg-line';
        line.style.cssText = `top:${15 + i * 14}%;animation:swbAnim ${14 + i * 3}s linear ${i * 2}s infinite;`;
        bgDiv.appendChild(line);
    }
    waveArea.appendChild(bgDiv);
})();

  
//  22. SECTION SCROLL ANIMATIONS
  

(function() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.plate-card, .nc, .rc, .mec, .fbi, .wc-card').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity .5s ease, transform .5s ease';
        observer.observe(el);
    });
})();

  
//  23. RT MONITOR CLOCK
  

function initRTMonitor() {
    function tick() {
        const el = document.getElementById('rtmClock');
        if (el) el.textContent = new Date().toLocaleTimeString('es-SV', { hour: '2-digit', minute: '2-digit',
            second: '2-digit', timeZone: 'America/El_Salvador' });
    }
    tick();
    setInterval(tick, 1000);
}

  
//  24. BUILDING SHAKE VISUALIZATION
  

function initBuildingShake() {
    const row = document.getElementById('buildingsRow');
    if (!row) return;
    const heights = [35, 55, 45, 70, 40, 60, 38, 52, 65, 42, 58, 46, 72, 38];
    row.innerHTML = heights.map((h, i) => `<div class="bld" id="bld${i}" style="height:${h}px"></div>`).join('');
}

window.setIntensity = function(level, btn) {
    document.querySelectorAll('.int-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    const statusEl = document.getElementById('shakeStatus');
    const rangeEl = document.getElementById('intMagRange');
    const blds = document.querySelectorAll('.bld');

    blds.forEach(b => b.classList.remove('shake'));

    if (level === 'leve') {
        if (statusEl) { statusEl.textContent = '✅ SACUDIDA LEVE';
            statusEl.className = 'shake-status'; }
        if (rangeEl) rangeEl.textContent = 'M 1.0 – 3.4';
    } else if (level === 'moderado') {
        if (statusEl) { statusEl.textContent = '⚡ SACUDIDA MODERADA';
            statusEl.className = 'shake-status warn'; }
        if (rangeEl) rangeEl.textContent = 'M 3.5 – 5.9';
        blds.forEach((b, i) => { if (i % 2 === 0) b.classList.add('shake'); });
    } else {
        if (statusEl) { statusEl.textContent = '🔔 SISMO FUERTE — EVACUACIÓN';
            statusEl.className = 'shake-status danger'; }
        if (rangeEl) rangeEl.textContent = 'M 6.0+';
        blds.forEach(b => b.classList.add('shake'));
    }
};

  
//  25. 3D BACKPACK
  

const bpItems3d = [
    { i: '💧', n: 'Agua 3L' }, { i: '🥫', n: 'Comida' }, { i: '🔦', n: 'Linterna' }, { i: '🔋', n: 'Pilas' },
    { i: '🩹', n: 'Botiquín' }, { i: '📋', n: 'Documentos' }, { i: '💊', n: 'Medicinas' }, { i: '📻', n: 'Radio' },
    { i: '🔑', n: 'Llaves' }, { i: '💵', n: 'Efectivo' }, { i: '👕', n: 'Ropa' }, { i: '🔌', n: 'Cargador' },
    { i: '📯', n: 'Silbato' }, { i: '🗺️', n: 'Mapa SV' }, { i: '🧴', n: 'Sanitizante' }, { i: '🔪', n: 'Navaja' }
];

const bpSet3d = new Set();

function renderBP3D() {
    const grid = document.getElementById('bpGrid3d');
    if (!grid) return;

    grid.innerHTML = bpItems3d.map((item, i) =>
        `<div class="bpi-3d${bpSet3d.has(i) ? ' on' : ''}" onclick="togBP3D(${i})" title="${item.n}">
            <span class="bpi-3d-ico">${item.i}</span>
            <span class="bpi-3d-nm">${item.n}</span>
        </div>`
    ).join('');

    const pct = Math.round(bpSet3d.size / bpItems3d.length * 100);

    const fill3d = document.getElementById('bpFill3d');
    const pct3d = document.getElementById('bpPct3d');
    if (fill3d) fill3d.style.width = pct + '%';
    if (pct3d) pct3d.textContent = pct + '%';

    const fillOld = document.getElementById('bpFill');
    const pctOld = document.getElementById('bpPct');
    if (fillOld) fillOld.style.width = pct + '%';
    if (pctOld) pctOld.textContent = pct + '%';
}

window.togBP3D = function(i) {
    bpSet3d.has(i) ? bpSet3d.delete(i) : bpSet3d.add(i);
    renderBP3D();
};

// 3D drag interaction
(function() {
    const bp = document.getElementById('bp3d');
    if (!bp) return;

    let dragging = false,
        startX = 0,
        startY = 0,
        rotX = 4,
        rotY = -12;

    bp.addEventListener('mousedown', e => {
        dragging = true;
        startX = e.clientX;
        startY = e.clientY;
        bp.style.animation = 'none';
        e.preventDefault();
    });

    window.addEventListener('mousemove', e => {
        if (!dragging) return;
        const dx = (e.clientX - startX) * 0.5,
            dy = (e.clientY - startY) * 0.3;
        rotY = Math.max(-30, Math.min(30, rotY + dx / 10));
        rotX = Math.max(-15, Math.min(15, rotX - dy / 10));
        bp.style.transform = `rotateY(${rotY}deg) rotateX(${rotX}deg)`;
        startX = e.clientX;
        startY = e.clientY;
    });

    window.addEventListener('mouseup', () => {
        if (dragging) {
            dragging = false;
            setTimeout(() => { bp.style.animation = ''; }, 200);
        }
    });
})();

  
//  26. TSUNAMI API FEED
  

async function loadTsunamiFeed() {
    const feed = document.getElementById('tsFeed');
    if (!feed) return;

    try {
        const resp = await fetch(
            'https://earthquake.usgs.gov/fdsnws/event/1.query?format=geojson&minmagnitude=5.5&maxlatitude=15&minlatitude=6&maxlongitude=-78&minlongitude=-95&limit=6&orderby=time'
            );
        const data = await resp.json();
        const quakes = data.features || [];
        if (!quakes.length) throw new Error('no data');

        feed.innerHTML = quakes.map(q => {
            const m = q.properties.mag;
            const place = q.properties.place || 'Región Centroamérica';
            const time = new Date(q.properties.time).toLocaleString('es-SV', { month: 'short', day: 'numeric',
                hour: '2-digit', minute: '2-digit' });
            const depth = q.geometry?.coordinates?.[2] || '?';
            const potential = m >= 7.0;
            const watch = m >= 6.0 && !potential;
            return `<div class="ts-feed-item">
                <div class="ts-mag-badge ${potential ? 'ts-potential' : 'ts-watch'}">${m.toFixed(1)}</div>
                <div class="ts-info">
                    <div class="ts-info-place">${escapeHtml(place)}</div>
                    <div class="ts-info-meta">${time} · Prof: ${Math.round(depth)}km</div>
                </div>
                <span class="ts-alert-chip ${potential ? 'red' : watch ? 'org' : 'ok'}">${potential ? 'Alerta' : watch ? 'Vigilancia' : 'Sin alerta'}</span>
            </div>`;
        }).join('');
    } catch (e) {
        feed.innerHTML = [
            { m: 6.2, place: '35 km SW de La Libertad, El Salvador', time: '8 mar, 11:42', depth: 15,
            alert: 'org' },
            { m: 5.8, place: 'Frente a costas de Acajutla, El Salvador', time: '7 mar, 09:18', depth: 28,
                alert: 'ok' },
            { m: 7.1, place: '98 km SO de San Miguel, El Salvador', time: '5 mar, 14:55', depth: 35,
            alert: 'red' },
            { m: 5.5, place: 'Placa de Cocos — Mar Pacífico', time: '4 mar, 07:22', depth: 12, alert: 'ok' },
        ].map(q => `<div class="ts-feed-item">
            <div class="ts-mag-badge ${q.alert === 'red' ? 'ts-potential' : 'ts-watch'}">${q.m}</div>
            <div class="ts-info">
                <div class="ts-info-place">${q.place}</div>
                <div class="ts-info-meta">${q.time} · Prof: ${q.depth}km</div>
            </div>
            <span class="ts-alert-chip ${q.alert}">${q.alert === 'red' ? 'Potencial Tsunami' : q.alert === 'org' ? 'Vigilancia' : 'Sin alerta'}</span>
        </div>`).join('');
    }
}


//  26b. SISMOGRAFO ARDUINO EN VIVO (pagina Monitoreo)


let __ardSinceId = 0;
function initArduinoLive() {
    const statusEl = document.getElementById('ardLiveStatus');
    const valEl = document.getElementById('ardLiveValue');
    const barEl = document.getElementById('ardLiveBar');
    if (!statusEl || !valEl || !barEl) return;

    async function poll() {
        try {
            const r = await fetch('?url=sensor/latest&since_id=' + __ardSinceId);
            const d = await r.json();
            __ardSinceId = d.last_id || __ardSinceId;

            statusEl.textContent = d.connected ? '● Sensor conectado' : '○ Sin conexión — esperando hardware';
            statusEl.className = 'chip ' + (d.connected ? 'g' : 'o');

            const readings = d.readings || [];
            if (readings.length) {
                const last = readings[readings.length - 1];
                const intensidad = parseFloat(last.intensidad) || 0;
                valEl.textContent = intensidad.toFixed(2) + 'G · ' + last.nivel;
                barEl.style.width = Math.max(2, Math.min(100, (intensidad / 1.2) * 100)) + '%';
            }
        } catch (e) { /* silencioso: se reintenta en el siguiente ciclo */ }
    }
    poll();
    setInterval(poll, 4000);
}


//  26c. BURBUJA DE MONITOREO (sismografo Arduino, disponible en todo el sitio)


let __monSinceId = 0;
function initMonitorBubble() {
    const fabDot = document.getElementById('monbotFabDot');
    if (!fabDot) return;

    async function poll() {
        try {
            const r = await fetch('?url=sensor/latest&since_id=' + __monSinceId);
            const d = await r.json();
            __monSinceId = d.last_id || __monSinceId;
            fabDot.classList.toggle('live', !!d.connected);
        } catch (e) { /* silencioso: se reintenta en el siguiente ciclo */ }
    }
    poll();
    setInterval(poll, 4000);
}


//  27. TSUNAMI EVACUATION CANVAS SIMULATION


let tsEvacRunning = false,
    tsEvacT = 0,
    tsEvacInterval = null,
    tsEvacTicker = null;

function initEvacCanvas() {
    const c = document.getElementById('tsEvacCv');
    if (!c) return;
    c.width = c.offsetWidth || 400;
    c.height = 200;
    drawEvacStatic(c, 0);
}

function drawEvacStatic(c, waveX) {
    const ctx = c.getContext('2d');
    const W = c.width,
        H = c.height;
    ctx.clearRect(0, 0, W, H);

    const sky = ctx.createLinearGradient(0, 0, 0, H * 0.6);
    sky.addColorStop(0, '#000e1e');
    sky.addColorStop(1, '#001e38');
    ctx.fillStyle = sky;
    ctx.fillRect(0, 0, W, H * 0.6);

    ctx.fillStyle = '#0a1e10';
    ctx.fillRect(0, H * 0.6, W, H * 0.4);

    ctx.fillStyle = '#0d2d18';
    ctx.beginPath();
    ctx.moveTo(W * 0.6, H * 0.6);
    ctx.lineTo(W * 0.72, H * 0.18);
    ctx.lineTo(W * 0.84, H * 0.6);
    ctx.fill();

    ctx.fillStyle = '#0f3520';
    ctx.beginPath();
    ctx.moveTo(W * 0.73, H * 0.6);
    ctx.lineTo(W * 0.83, H * 0.25);
    ctx.lineTo(W * 0.93, H * 0.6);
    ctx.fill();

    ctx.fillStyle = 'rgba(0,212,176,.6)';
    ctx.font = 'bold 9px Space Grotesk,sans-serif';
    ctx.textAlign = 'center';
    ctx.fillText('ZONA SEGURA', W * 0.8, H * 0.15);

    ctx.strokeStyle = 'rgba(0,212,176,.5)';
    ctx.lineWidth = 2;
    ctx.setLineDash([8, 4]);
    ctx.beginPath();
    ctx.moveTo(W * 0.1, H * 0.65);
    ctx.lineTo(W * 0.72, H * 0.4);
    ctx.stroke();
    ctx.setLineDash([]);

    if (waveX > 0) {
        ctx.fillStyle = 'rgba(30,80,200,.7)';
        ctx.beginPath();
        ctx.moveTo(0, H * 0.5);
        for (let x = 0; x <= Math.min(waveX, W); x++) {
            const y = H * 0.5 - Math.sin(x * 0.08) * 18 * (1 + waveX / W * 1.2);
            ctx.lineTo(x, y);
        }
        ctx.lineTo(Math.min(waveX, W), H);
        ctx.lineTo(0, H);
        ctx.closePath();
        ctx.fill();

        ctx.strokeStyle = 'rgba(100,180,255,.8)';
        ctx.lineWidth = 2;
        ctx.setLineDash([]);
        ctx.beginPath();
        for (let x = 0; x <= Math.min(waveX, W); x++) {
            const y = H * 0.5 - Math.sin(x * 0.08) * 18 * (1 + waveX / W * 1.2);
            x === 0 ? ctx.moveTo(x, y) : ctx.lineTo(x, y);
        }
        ctx.stroke();
    }

    const personX = waveX > 0 ? Math.min(W * 0.1 + waveX * 0.55, W * 0.72) : W * 0.12;
    const personY = H * 0.58;
    ctx.fillStyle = '#fff';
    ctx.font = '18px serif';
    ctx.textAlign = 'center';
    ctx.fillText('🧭', personX, personY);

    if (waveX === 0) {
        ctx.fillStyle = 'rgba(255,255,255,.5)';
        ctx.font = '11px Space Grotesk,sans-serif';
        ctx.textAlign = 'center';
        ctx.fillText('Pulsa "Iniciar Simulación" para comenzar', W / 2, H * 0.88);
    }
    ctx.textAlign = 'left';
}

window.startEvacSim = function() {
    if (tsEvacRunning) return;
    tsEvacRunning = true;
    tsEvacT = 0;

    const c = document.getElementById('tsEvacCv');
    if (!c) return;
    c.width = c.offsetWidth;

    const timerEl = document.getElementById('tsTimer');
    const statusEl = document.getElementById('tsEvacStatus');

    let waveX = 0;

    if (tsEvacTicker) clearInterval(tsEvacTicker);
    tsEvacTicker = setInterval(() => {
        tsEvacT++;
        if (timerEl) timerEl.textContent =
            `${String(Math.floor(tsEvacT / 60)).padStart(2, '0')}:${String(tsEvacT % 60).padStart(2, '0')}`;
    }, 1000);

    if (tsEvacInterval) cancelAnimationFrame(tsEvacInterval);

    function animate() {
        waveX += 1.8;
        drawEvacStatic(c, waveX);

        if (waveX < c.width * 1.1) {
            tsEvacInterval = requestAnimationFrame(animate);
            if (statusEl) {
                const prog = waveX / c.width;
                if (prog < 0.3) statusEl.textContent = '⚡ Tsunami detectado — evacuando…';
                else if (prog < 0.7) statusEl.textContent = '🧭 Corriendo hacia zona segura…';
                else statusEl.textContent = '✅ ¡Zona segura alcanzada!';
            }
        } else {
            tsEvacRunning = false;
            clearInterval(tsEvacTicker);
            if (statusEl) statusEl.textContent = `✅ ¡Evacuación exitosa en ${timerEl ? timerEl.textContent : '—'}!`;
        }
    }
    animate();
};

window.resetEvacSim = function() {
    tsEvacRunning = false;
    clearInterval(tsEvacTicker);
    if (tsEvacInterval) cancelAnimationFrame(tsEvacInterval);
    tsEvacT = 0;

    const timerEl = document.getElementById('tsTimer');
    const statusEl = document.getElementById('tsEvacStatus');
    if (timerEl) timerEl.textContent = '00:00';
    if (statusEl) statusEl.textContent = 'Listo';

    const c = document.getElementById('tsEvacCv');
    if (c) { c.width = c.offsetWidth;
        drawEvacStatic(c, 0); }
};

  
//  28. GAME MODALS
  

window.openGame = function(id) {
    document.getElementById('modal-' + id).classList.add('open');
};

window.closeGame = function(id) {
    document.getElementById('modal-' + id).classList.remove('open');
};

document.querySelectorAll('.game-modal').forEach(m => {
    m.addEventListener('click', e => {
        if (e.target === m) m.classList.remove('open');
    });
});

  
//  29. RICHTER QUIZ GAME
  

const richterQuestions = [
    { q: '¿Qué magnitud tuvo el terremoto del 13 de enero de 2001 en El Salvador?',
        opts: ['M 5.5', 'M 6.2', 'M 7.7', 'M 8.1'], c: 2,
        exp: 'El sismo del 13-ene-2001 tuvo M7.7 con epicentro al sur del país. Fue el más destructivo en décadas, causando más de 1,200 muertos y destruyendo 100,000+ viviendas.' },
    { q: '¿A qué velocidad viaja un tsunami en el océano Pacífico frente a El Salvador?',
        opts: ['200 km/h', '400 km/h', '800 km/h', '1,600 km/h'], c: 2,
        exp: 'Los tsunamis viajan a ~800 km/h en océano abierto, similar a un avión. Desde el epicentro frente a El Salvador pueden llegar a la costa en 15-25 minutos.' },
    { q: '¿Cuántos metros de tsunami puede protegerte si llegas a zona segura?',
        opts: ['5 metros', '15 metros', '30 metros', '100 metros'], c: 2,
        exp: 'La recomendación oficial es buscar terreno a mínimo 30 metros sobre el nivel del mar. En El Salvador, el Cerro El Picacho y las alturas de Jayaque son puntos de referencia.' },
    { q: '¿Qué placa tectónica subduce bajo El Salvador causando sismos?',
        opts: ['Placa del Pacífico', 'Placa de Nazca', 'Placa de Cocos', 'Placa Norteamericana'], c: 2,
        exp: 'La Placa de Cocos subduce bajo la Placa del Caribe a ~8 cm/año. Esta colisión genera la mayoría de los sismos de El Salvador, incluyendo los de la zona de subducción frente a la costa.' },
    { q: '¿Cuántos volcanes activos tiene El Salvador?', opts: ['5', '10', '20', '26'], c: 3,
        exp: 'El Salvador tiene aproximadamente 26 volcanes, varios de ellos activos. El Izalco (Faro del Pacífico), Santa Ana y San Miguel son los más conocidos y monitoreados por el MARN.' },
    { q: '¿Cuál es el primer signo visual de un tsunami en la costa de El Salvador?',
        opts: ['El mar sube de golpe', 'El mar se retira anormalmente', 'El cielo se oscurece',
            'El suelo tiembla bajo el agua'
        ], c: 1,
        exp: 'El retiro anormal del mar (la playa queda al descubierto de forma inusual) es el primer aviso visual. En playas como El Tunco o El Zonte, esto significa que tienes 5-15 minutos para evacuar.' }
];

let rqIdx = 0,
    rqScore = 0,
    rqAnswered = false;

window.startRichterGame = function() {
    rqIdx = 0;
    rqScore = 0;
    rqAnswered = false;
    showRichterQ();
};

function showRichterQ() {
    const container = document.getElementById('richterGame');
    if (!container) return;

    if (rqIdx >= richterQuestions.length) {
        const pct = Math.round(rqScore / richterQuestions.length * 100);
        container.innerHTML = `<div style="text-align:center;padding:16px">
            <div style="font-size:2.5rem;margin-bottom:8px">${pct >= 80 ? '<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M8 21h8M12 17v4M7 4h10v5a5 5 0 0 1-10 0V4z"/><path d="M17 5h3a2 2 0 0 1-2 4M7 5H4a2 2 0 0 0 2 4"/></svg>' : pct >= 60 ? '⭐' : '🧑‍🏫'}</div>
            <div class="rg-score">${rqScore}/${richterQuestions.length}</div>
            <p style="color:var(--text2);margin:10px 0">${pct >= 80 ? '¡Excelente! Estás preparado para El Salvador.' : 'Sigue aprendiendo sobre sismos salvadoreños.'}</p>
            <button class="btn-acc" onclick="startRichterGame()"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/></svg> Jugar de nuevo</button>
        </div>`;
        return;
    }

    const q = richterQuestions[rqIdx];
    rqAnswered = false;
    container.innerHTML = `<div class="richter-game">
        <div style="font-size:.72rem;color:var(--text3);margin-bottom:8px">Pregunta ${rqIdx + 1} de ${richterQuestions.length} · Puntos: ${rqScore}</div>
        <div class="rg-question">${q.q}</div>
        <div class="rg-options">${q.opts.map((o, i) => `<button class="rg-opt" id="rqo${i}" onclick="answerRQ(${i})">${o}</button>`).join('')}</div>
        <div id="rqFeedback"></div>
    </div>`;
}

window.answerRQ = function(idx) {
    if (rqAnswered) return;
    rqAnswered = true;
    const q = richterQuestions[rqIdx];
    if (idx === q.c) rqScore++;

    document.querySelectorAll('.rg-opt').forEach((b, i) => {
        b.disabled = true;
        if (i === q.c) b.classList.add('correct');
        else if (i === idx) b.classList.add('wrong');
    });

    document.getElementById('rqFeedback').innerHTML =
        `<div class="rg-explain">${idx === q.c ? '✅' : '❌'} ${q.exp} <br><br><button class="btn-acc" style="font-size:.76rem;padding:6px 14px;margin-top:6px" onclick="rqNext()">Siguiente ➡️</button></div>`;
};

window.rqNext = function() {
    rqIdx++;
    showRichterQ();
};

  
//  30. EVACUATION ROUTE GAME
  

const EVAC_MAP = [
    ['W', 'W', 'W', 'W', 'W', 'W', 'W', 'E'],
    ['W', 'P', 'P', 'P', 'W', 'P', 'P', 'E'],
    ['S', 'P', 'W', 'P', 'W', 'P', 'W', 'W'],
    ['W', 'P', 'W', 'P', 'P', 'P', 'P', 'W'],
    ['W', 'P', 'W', 'W', 'W', 'W', 'P', 'W'],
    ['W', 'P', 'P', 'P', 'W', 'P', 'P', 'W'],
    ['W', 'W', 'W', 'P', 'W', 'W', 'D', 'W'],
    ['W', 'W', 'W', 'D', 'W', 'W', 'W', 'W']
];

let evacSelected = null,
    evacMoves = [],
    evacTimerVal = 0,
    evacTimerI = null,
    evacDone = false;

function initEvacGame() {
    evacSelected = null;
    evacMoves = [];
    evacDone = false;
    evacTimerVal = 0;
    clearInterval(evacTimerI);
    document.getElementById('evacStep').textContent = '0/5';
    document.getElementById('evacMsg').textContent = '';
    evacTimerI = setInterval(() => {
        evacTimerVal++;
        document.getElementById('evacTime').textContent = evacTimerVal + 's';
    }, 1000);
    renderEvacGrid();
}

function renderEvacGrid() {
    const grid = document.getElementById('evacGrid');
    if (!grid) return;

    grid.innerHTML = EVAC_MAP.map((row, r) =>
        row.map((cell, c) => {
            const isSelected = evacMoves.some(m => m[0] === r && m[1] === c);
            const cls = cell === 'W' ? 'wall' :
                cell === 'S' ? 'start' :
                cell === 'E' ? 'end' :
                cell === 'D' ? 'danger' : 'path';
            const extra = isSelected ? 'selected' : '';
            const ico = cell === 'S' ? '🏠' :
                cell === 'E' ? '🏔️' :
                cell === 'D' ? '<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M2 12c1.5-1.5 3-1.5 4.5 0s3 1.5 4.5 0 3-1.5 4.5 0 3 1.5 4.5 0"/><path d="M2 18c1.5-1.5 3-1.5 4.5 0s3 1.5 4.5 0 3-1.5 4.5 0 3 1.5 4.5 0"/></svg>' : '';
            return `<div class="evg-cell ${cls} ${extra}" onclick="evacClick(${r},${c})">${ico}</div>`;
        }).join('')
    ).join('');
}

window.evacClick = function(r, c) {
    if (evacDone) return;
    const cell = EVAC_MAP[r][c];
    if (cell === 'W') return;

    if (cell === 'D') {
        document.getElementById('evacMsg').innerHTML = '<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><circle cx="12" cy="11" r="8"/><circle cx="9" cy="10" r="1.2" fill="currentColor"/><circle cx="15" cy="10" r="1.2" fill="currentColor"/><path d="M9 19v2M15 19v2"/></svg> ¡Tocaste el tsunami! Reinicia.';
        clearInterval(evacTimerI);
        evacDone = true;
        evacMoves.push([r, c]);
        renderEvacGrid();
        return;
    }

    if (evacMoves.some(m => m[0] === r && m[1] === c)) return;
    evacMoves.push([r, c]);
    document.getElementById('evacStep').textContent = `${Math.min(evacMoves.length, 5)}/5`;

    if (cell === 'E') {
        clearInterval(evacTimerI);
        evacDone = true;
        document.getElementById('evacMsg').textContent = `✅ ¡Salvado en ${evacTimerVal}s!`;
    }
    renderEvacGrid();
};

  
//  31. MEMORY GAME
  

const memSymbols = ['💧', '🔦', '🩹', '📻', '🎒', '🗺️', '💊', '🔋'];
let memCards = [],
    memFlipped = [],
    memMatched = new Set(),
    memMoveCount = 0,
    memLocked = false;

function initMemoryGame() {
    if (!document.getElementById('memoryGrid')) return;
    const all = [...memSymbols, ...memSymbols].sort(() => Math.random() - 0.5);
    memCards = all;
    memFlipped = [];
    memMatched = new Set();
    memMoveCount = 0;
    memLocked = false;
    const movesEl = document.getElementById('memMoves');
    const pairsEl = document.getElementById('memPairs');
    if (movesEl) movesEl.textContent = '0';
    if (pairsEl) pairsEl.textContent = '0/8';
    const winEl = document.getElementById('memWin');
    if (winEl) winEl.style.display = 'none';
    renderMemory();
}

function renderMemory() {
    const grid = document.getElementById('memoryGrid');
    if (!grid) return;

    grid.innerHTML = memCards.map((sym, i) => {
        const isFlipped = memFlipped.includes(i) || memMatched.has(i);
        const isMatched = memMatched.has(i);
        return `<div class="mem-card${isFlipped ? ' flip' : ''}${isMatched ? ' matched' : ''}" onclick="flipMem(${i})">
            <div class="mem-front">?</div>
            <div class="mem-back">${sym}</div>
        </div>`;
    }).join('');
}

window.flipMem = function(i) {
    if (memLocked || memFlipped.includes(i) || memMatched.has(i)) return;
    memFlipped.push(i);
    renderMemory();

    if (memFlipped.length === 2) {
        memMoveCount++;
        document.getElementById('memMoves').textContent = memMoveCount;
        memLocked = true;

        setTimeout(() => {
            const [a, b] = memFlipped;
            if (memCards[a] === memCards[b]) {
                memMatched.add(a);
                memMatched.add(b);
                document.getElementById('memPairs').textContent = `${memMatched.size / 2}/8`;
                if (memMatched.size === memCards.length) {
                    const w = document.getElementById('memWin');
                    if (w) w.style.display = 'block';
                }
            }
            memFlipped = [];
            memLocked = false;
            renderMemory();
        }, 900);
    }
};

  
//  32. RTM STATS UPDATE
  

function updateRTMStats(quakes) {
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    const todayQ = quakes.filter(q => new Date(q.properties.time) >= today);

    if (todayQ.length) ndaCountTo('rtm-today', todayQ.length);
    else ndaSetText('rtm-today', '—');

    if (quakes.length > 0) {
        const last = quakes[0];
        ndaCountTo('rtm-mag', last.properties.mag, 1, 'M');

        const depth = last.geometry?.coordinates?.[2];
        if (depth) ndaCountTo('rtm-depth', Math.round(depth), 0, '', 'km');
        else ndaSetText('rtm-depth', '—');
    }
}

  
//  33. AUTH SYSTEM
  

async function logout() {
    if (await ndaConfirm('¿Seguro que quieres cerrar sesión?')) {
        // replace() no deja la pagina actual en el historial, asi que
        // el boton "Atras" no puede regresar a una vista de sesion activa.
        window.location.replace('?url=logout');
    }
}

function toggleUserDD() {
    document.getElementById('navUserDD').classList.toggle('open');
}

function closeUserDD() {
    document.getElementById('navUserDD').classList.remove('open');
}

document.addEventListener('click', e => {
    const menu = document.getElementById('navUserMenu');
    if (menu && !menu.contains(e.target)) closeUserDD();
});

// Dropdown generico del navbar (Desastres, Monitoreo, etc.): boton llama
// toggleNavDrop(this), sin necesitar un id distinto por cada menu.
function toggleNavDrop(btn) {
    const drop = btn.closest('.nav-drop');
    if (!drop) return;
    const isOpen = drop.classList.contains('open');
    document.querySelectorAll('.nav-drop.open').forEach(d => {
        d.classList.remove('open');
        d.querySelector('.nav-drop-dd')?.classList.remove('open');
    });
    if (!isOpen) {
        drop.classList.add('open');
        drop.querySelector('.nav-drop-dd')?.classList.add('open');
    }
}

document.addEventListener('click', e => {
    document.querySelectorAll('.nav-drop.open').forEach(drop => {
        if (!drop.contains(e.target)) {
            drop.classList.remove('open');
            drop.querySelector('.nav-drop-dd')?.classList.remove('open');
        }
    });
});

  
//  35. ¿QUÉ HACER AHORA?
  

function toggleAhora(card) {
    const body = card.querySelector('.ahora-body');
    const isOpen = body.classList.contains('open');
    document.querySelectorAll('.ahora-body').forEach(b => b.classList.remove('open'));
    if (!isOpen) body.classList.add('open');
}

  
//  36. VIRTUAL ASSISTANT CHATBOT
  

const cbKnowledge = [
    { k: ['hola', 'hey', 'buenas', 'saludos'],
        r: '¡Hola! Soy el Asistente NDA <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><rect x="4" y="8" width="16" height="12" rx="2"/><circle cx="9" cy="14" r="1.3"/><circle cx="15" cy="14" r="1.3"/><line x1="12" y1="4" x2="12" y2="8"/><circle cx="12" cy="3" r="1"/></svg> Estoy aquí para ayudarte con información sobre sismos, evacuación, el sistema y preparación ante desastres. ¿En qué puedo ayudarte?',
        chips: ['¿Qué hacer en un sismo?', '¿Cómo registrarme?', 'Rutas de evacuación'] },
    { k: ['sismo', 'terremoto', 'tiembla', 'movimiento', 'cuando tiembla'],
        r: '<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M8 21l4-13 4 13"/><circle cx="12" cy="6" r="1.4"/><path d="M12 6l-1.5 3M12 6l1.5 3"/></svg> **Durante un sismo:** Caer, cubrirse y agarrarse. Protege tu cabeza debajo de un escritorio o mesa resistente. Aléjate de ventanas y objetos colgantes. No corras hacia afuera mientras tiembla. Al terminar, ve al punto de reunión designado.',
        chips: ['¿Qué es la escala Richter?', 'Puntos de reunión', '¿Qué hacer después?'] },
    { k: ['tsunami', 'ola', 'mar', 'costa', 'playa'],
        r: '<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M2 12c1.5-1.5 3-1.5 4.5 0s3 1.5 4.5 0 3-1.5 4.5 0 3 1.5 4.5 0"/><path d="M2 18c1.5-1.5 3-1.5 4.5 0s3 1.5 4.5 0 3-1.5 4.5 0 3 1.5 4.5 0"/></svg> **Si hay amenaza de tsunami:** Un sismo fuerte cerca de la costa ES la alerta. Muévete INMEDIATAMENTE a tierra alta (mínimo 30m sobre el nivel del mar). Si el mar retrocede anormalmente, tienes pocos minutos. No esperes alerta oficial.',
        chips: ['Zonas costeras en riesgo', 'Protocolo de evacuación'] },
    { k: ['mochila', 'kit', 'emergencia', 'preparar', 'necesito'],
        r: '🎒 **Tu mochila de emergencia debe incluir:** Agua (3L por persona por día para 3 días), alimentos no perecederos, linterna y radio a pilas, botiquín básico, documentos importantes en bolsa plástica, dinero en efectivo y lista de números de emergencia.',
        chips: ['¿Dónde guardar la mochila?', 'Números de emergencia'] },
    { k: ['evacuación', 'evacuar', 'ruta', 'salida', 'punto reunión'],
        r: '🗺️ **Rutas de evacuación:** El sistema NDA incluye un módulo de colegio donde los docentes pueden ver las rutas asignadas y hacer pase de lista. Conoce la ruta de tu institución ANTES de una emergencia. Practica con simulacros.',
        chips: ['Módulo Colegio', 'Simulacros'] },
    { k: ['registrar', 'registro', 'crear cuenta', 'cómo entrar', 'login'],
        r: '👤 **Para registrarte:** Haz clic en "Registrarse" en la barra de navegación. Puedes entrar como estudiante, docente, padre/madre o administrador. El módulo de colegio está disponible para docentes y administradores.',
        chips: ['¿Qué puede hacer cada rol?', 'Ir a registro'] },
    { k: ['admin', 'administrador', 'docente', 'alumno', 'estudiante', 'padre', 'rol'],
        r: '🛡️ **Roles en NDA:**\n• **Administrador:** Gestión total del módulo colegio, estudiantes, docentes, incidentes y simulacros.\n• **Docente:** Pase de lista, ver rutas y reportar incidentes.\n• **Estudiante:** Acceso a información y sección de evacuación.\n• **Padre/Madre:** Información general y estado del estudiante.',
        chips: ['Módulo Colegio', '¿Cómo registro a mi hijo?'] },
    { k: ['marn', 'usgs', 'datos', 'tiempo real', 'api'],
        r: '<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M4 4l16 16M12 8a4 4 0 0 1 4 4M12 4a8 8 0 0 1 8 8"/><circle cx="6" cy="18" r="2"/></svg> **Fuentes de datos:** NDA usa datos en tiempo real del USGS (sismos globales y regionales), Open-Meteo (clima), y datos astronómicos de la API sunrise-sunset. Los datos se actualizan automáticamente al cargar la página.',
        chips: ['¿Con qué frecuencia se actualiza?', 'Monitor sísmico'] },
    { k: ['magnitud', 'richter', 'escala', 'intensidad'],
        r: '📊 **Escala de Magnitud:** La escala Richter mide la energía liberada: M1-2 (imperceptible), M3-4 (leve, puede sentirse), M5 (moderado, posibles daños), M6 (fuerte, daños estructurales), M7+ (gran terremoto). El terremoto de El Salvador de 2001 fue M7.7.',
        chips: ['Historia sísmica El Salvador', 'Simulador sísmico'] },
    { k: ['clima', 'temperatura', 'lluvia', 'tiempo', 'meteorolog'],
        r: '👥 La sección de **Clima** muestra temperatura en tiempo real de varias ciudades de El Salvador usando la API Open-Meteo. También incluye el arco solar (salida y puesta del sol), precipitación mensual y radar meteorológico.',
        chips: ['¿Cuándo es temporada de lluvias?', 'Riesgo de inundaciones'] },
    { k: ['luna', 'fase', 'marea', 'lunar'],
        r: '🌙 La sección de **Fases Lunares** explica el ciclo lunar completo y su influencia en las mareas del Pacífico salvadoreño. Puedes explorar las 8 fases y ver cómo afectan la actividad pesquera y el riesgo costero.',
        chips: ['Mareas vivas', 'Impacto en pesca'] },
    { k: ['volcan', 'erupcion', 'izalco', 'santa ana'],
        r: '🌋 El Salvador tiene **26 volcanes**, varios activos. El más famoso es el Volcán Izalco ("El Faro del Pacífico"). Ante actividad volcánica: sigue instrucciones del MARN, cubre nariz y boca ante ceniza, y sigue las rutas de evacuación oficiales.',
        chips: ['Volcanes activos', '¿Qué hacer ante ceniza?'] },
    { k: ['arduino', 'sensor', 'monitoreo', 'maqueta'],
        r: '📟 La sección **Monitoreo** explica cómo se integrará una maqueta de sensor Arduino (MPU-6050): detecta vibración en 3 ejes y, cuando el hardware esté conectado, sus lecturas llegarán en tiempo real a esta plataforma. Por ahora se muestra el diagrama de funcionamiento y los componentes del sistema.',
        chips: ['¿Cómo funciona el sensor?', 'Ver sección de Monitoreo'] },
    { k: ['trivia', 'juego', 'preguntas', 'quiz'],
        r: '🎯 La **Zona de Trivia** tiene preguntas sobre desastres naturales con 3 niveles de dificultad (Básico, Intermedio, Avanzado). Los **Juegos Educativos** incluyen: Quiz de Richter, Ruta de Evacuación y Memoria Sísmica. ¡Aprende jugando!',
        chips: ['Ir a Trivia', 'Ir a Juegos'] },
    { k: ['911', 'emergencia', 'número', 'bomberos', 'cruz roja', 'coen'],
        r: '📞 **Números de emergencia El Salvador:**\n• 911 — PNC Emergencias\n• 913 — Bomberos\n• 2222-5155 — Cruz Roja\n• 2267-6000 — MARN Alertas\n• 2231-4000 — COEN (Operaciones)',
        chips: ['Más recursos', 'Mochila de emergencia'] },
    { k: ['gracias', 'perfecto', 'ok', 'bien', 'excelente'],
        r: '¡Con mucho gusto! 😊 Recuerda que la prevención y el conocimiento salvan vidas. Si tienes más dudas sobre sismos, evacuación o el sistema NDA, aquí estoy. ¡Cuídate!',
        chips: ['Volver al inicio', 'Más preguntas'] },
];

let cbInitialized = false;

function toggleChatbot() {
    const panel = document.getElementById('chatbotPanel');
    const isOpen = panel.classList.contains('open');

    if (!isOpen) {
        panel.style.display = 'flex';
        requestAnimationFrame(() => panel.classList.add('open'));
        if (!cbInitialized) {
            cbInitialized = true;
            addCbMsg('bot',
                '¡Hola! <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em"><path d="M18 11V6a2 2 0 0 0-4 0M14 10V4a2 2 0 0 0-4 0v2M10 10.5V6a2 2 0 0 0-4 0v10c0 4 3 7 7 7h1a6 6 0 0 0 6-6v-4a2 2 0 0 0-4 0"/></svg> Soy el **Asistente Virtual NDA**. Puedo ayudarte con información sobre sismos, tsunamis, evacuación, el módulo de colegio y cómo usar la plataforma. ¿En qué te ayudo?',
                ['¿Qué hacer en un sismo?', 'Módulo Colegio', 'Números de emergencia', 'Mochila de emergencia']
            );
        }
    } else {
        panel.classList.remove('open');
        setTimeout(() => { panel.style.display = 'none'; }, 280);
    }
}

function addCbMsg(from, text, chips) {
    const msgs = document.getElementById('cbMessages');
    const div = document.createElement('div');
    div.className = 'cb-msg ' + from;

    const bubble = document.createElement('div');
    bubble.className = 'cb-bubble';
    bubble.innerHTML = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>').replace(/\n/g, '<br>');
    div.appendChild(bubble);

    if (chips && chips.length) {
        const chipRow = document.createElement('div');
        chipRow.className = 'cb-chips';
        chips.forEach(c => {
            const btn = document.createElement('button');
            btn.className = 'cb-chip';
            btn.textContent = c;
            btn.onclick = () => handleCbChip(c);
            chipRow.appendChild(btn);
        });
        div.appendChild(chipRow);
    }

    msgs.appendChild(div);
    msgs.scrollTop = msgs.scrollHeight;
}

function handleCbChip(text) {
    addCbMsg('user', text);
    setTimeout(() => processCbMsg(text), 400);
}

function sendChatMsg() {
    const input = document.getElementById('cbInput');
    const text = input.value.trim();
    if (!text) return;

    input.value = '';
    addCbMsg('user', text);

    const msgs = document.getElementById('cbMessages');
    const typing = document.createElement('div');
    typing.className = 'cb-msg bot';
    typing.id = 'cbTyping';
    typing.innerHTML = '<div class="cb-typing"><div class="cb-dot"></div><div class="cb-dot"></div><div class="cb-dot"></div></div>';
    msgs.appendChild(typing);
    msgs.scrollTop = msgs.scrollHeight;

    setTimeout(() => {
        const t = document.getElementById('cbTyping');
        if (t) t.remove();
        processCbMsg(text);
    }, 800 + Math.random() * 500);
}

function processCbMsg(text) {
    const lower = text.toLowerCase();

    if (lower.includes('módulo colegio') || lower.includes('modulo colegio')) {
        addCbMsg('bot',
            '🏫 Para acceder al **Módulo Colegio**, necesitas iniciar sesión. Haz clic en "Iniciar sesión" en la navegación. Los docentes y administradores tienen acceso completo a gestión de estudiantes, rutas de evacuación, pase de lista e incidentes.',
            ['Iniciar sesión', '¿Cómo me registro?']);
        return;
    }

    if (lower.includes('ir a trivia')) {
        addCbMsg('bot', '🎯 ¡Voy a llevarte a la Trivia!', []);
        setTimeout(() => document.getElementById('trivia')?.scrollIntoView({ behavior: 'smooth' }), 400);
        return;
    }

    if (lower.includes('ir a juegos')) {
        addCbMsg('bot', '<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><rect x="2" y="7" width="20" height="10" rx="4"/><line x1="7" y1="10" x2="7" y2="14"/><line x1="5" y1="12" x2="9" y2="12"/><circle cx="16" cy="10.5" r="1"/><circle cx="18.5" cy="13" r="1"/></svg> ¡Yendo a los juegos educativos!', []);
        setTimeout(() => document.getElementById('juegos')?.scrollIntoView({ behavior: 'smooth' }), 400);
        return;
    }

    for (const entry of cbKnowledge) {
        if (entry.k.some(kw => lower.includes(kw))) {
            addCbMsg('bot', entry.r, entry.chips || []);
            return;
        }
    }

    addCbMsg('bot', 'Hmm, no tengo información exacta sobre eso <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em"><circle cx="12" cy="12" r="10"/><path d="M9 10a3 3 0 0 1 5-2M9 15h4"/></svg> Pero puedo ayudarte con estos temas:', [
        '¿Qué hacer en un sismo?', 'Tsunami y evacuación', 'Números de emergencia', 'Módulo Colegio',
        'Mochila de emergencia'
    ]);
}

  
//  37. INIT ALL


// Cada pagina del sitio comparte este mismo app.js aunque solo tenga algunas
// de estas secciones en su HTML. safeInit() evita que un error (o un elemento
// faltante sin guardia) en una seccion corte la inicializacion de las demas.
function safeInit(fn) {
    try { fn(); } catch (e) { console.error('[NDA] Error inicializando sección:', fn.name || fn, e); }
}

document.addEventListener('DOMContentLoaded', () => {
    safeInit(renderTL);
    safeInit(initMap);
    safeInit(loadQuakes);
    safeInit(loadWeather);
    safeInit(loadSun);
    safeInit(renderBP);
    safeInit(renderPrep);
    safeInit(renderBP3D);
    safeInit(initRTMonitor);
    safeInit(initBuildingShake);
    safeInit(loadTsunamiFeed);
    safeInit(initEvacCanvas);
    safeInit(initMemoryGame);
    safeInit(initArduinoLive);
    safeInit(initMonitorBubble);
    safeInit(initSk3dCarousel);
    safeInit(initAutoMount3D);
});
