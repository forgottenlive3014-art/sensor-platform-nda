// NDA - Fases de la Luna
// Todos los datos se calculan con formulas astronomicas reales (ciclo
// sinodico, anomalia media orbital) a partir de la fecha/hora actual — nada
// de datos de ejemplo. El modelo 3D central lo renderiza moon3d.js
// (Three.js, cargado globalmente en layout.php), que ya ilumina la esfera
// segun la fase real y la rota lentamente solo.
(function () {
    if (!document.getElementById('lunaRoot')) return;

    const SYNODIC_DAYS = 29.530588853;
    const SYNODIC_MS = SYNODIC_DAYS * 86400000;
    const KNOWN_NEW_MOON = Date.UTC(2000, 0, 6, 18, 14, 0); // luna nueva de referencia (NASA)
    const J2000 = Date.UTC(2000, 0, 1, 12, 0, 0);

    const PHASES = [
        { key: 'nueva', frac: 0.0, name: 'Luna Nueva', desc: 'La cara visible de la Luna no recibe luz solar directa: está entre la Tierra y el Sol. Es invisible a simple vista salvo por un tenue resplandor terrestre.' },
        { key: 'creciente', frac: 0.125, name: 'Creciente Iluminante', desc: 'Un delgado filo de luz aparece por el lado oeste, creciendo noche tras noche a medida que la Luna se aleja del Sol en el cielo.' },
        { key: 'cuarto-creciente', frac: 0.25, name: 'Cuarto Creciente', desc: 'Exactamente la mitad del disco lunar está iluminada. La Luna forma un ángulo de 90° entre el Sol y la Tierra.' },
        { key: 'gibosa-creciente', frac: 0.375, name: 'Gibosa Creciente', desc: 'Más de la mitad del disco está iluminado y sigue creciendo, acercándose a la fase de Luna Llena.' },
        { key: 'llena', frac: 0.5, name: 'Luna Llena', desc: 'La Tierra queda entre el Sol y la Luna: el disco completo se ve iluminado. Es la fase de mayor brillo y la más fácil de observar toda la noche.' },
        { key: 'gibosa-menguante', frac: 0.625, name: 'Gibosa Menguante', desc: 'La iluminación empieza a reducirse tras la Luna Llena, aunque todavía se ve más de la mitad del disco iluminado.' },
        { key: 'cuarto-menguante', frac: 0.75, name: 'Cuarto Menguante', desc: 'De nuevo la mitad del disco está iluminada, pero ahora por el lado este, camino de la siguiente Luna Nueva.' },
        { key: 'menguante', frac: 0.875, name: 'Menguante', desc: 'Un delgado filo de luz remanente antes de la siguiente Luna Nueva, visible solo brevemente antes del amanecer.' }
    ];

    function phaseIconSVG(key, size) {
        size = size || 40;
        const common = `width="${size}" height="${size}" viewBox="0 0 24 24"`;
        switch (key) {
            case 'nueva': return `<svg ${common}><circle cx="12" cy="12" r="9" fill="currentColor" opacity=".25"/><circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.4"/></svg>`;
            case 'creciente': return `<svg ${common}><circle cx="12" cy="12" r="9" fill="currentColor" opacity=".25"/><path d="M12 3a9 9 0 0 0 0 18z" fill="currentColor" opacity=".55"/></svg>`;
            case 'cuarto-creciente': return `<svg ${common}><circle cx="12" cy="12" r="9" fill="currentColor" opacity=".25"/><path d="M12 3a9 9 0 0 0 0 18z" fill="currentColor"/></svg>`;
            case 'gibosa-creciente': return `<svg ${common}><circle cx="12" cy="12" r="9" fill="currentColor" opacity=".25"/><path d="M12 3a9 9 0 0 1 0 18z" fill="currentColor" opacity=".85"/></svg>`;
            case 'llena': return `<svg ${common}><circle cx="12" cy="12" r="9" fill="currentColor"/></svg>`;
            case 'gibosa-menguante': return `<svg ${common}><circle cx="12" cy="12" r="9" fill="currentColor" opacity=".25"/><path d="M12 3a9 9 0 0 1 0 18z" fill="currentColor" opacity=".5"/></svg>`;
            case 'cuarto-menguante': return `<svg ${common}><circle cx="12" cy="12" r="9" fill="currentColor" opacity=".25"/><path d="M12 3a9 9 0 0 1 0 18z" fill="currentColor"/></svg>`;
            case 'menguante': return `<svg ${common}><circle cx="12" cy="12" r="9" fill="currentColor" opacity=".25"/><path d="M12 3a9 9 0 0 0 0 18z" fill="currentColor" opacity=".85"/></svg>`;
            default: return `<svg ${common}><circle cx="12" cy="12" r="9" fill="currentColor"/></svg>`;
        }
    }

    function phaseForFrac(frac) {
        const buckets = [0.0625, 0.1875, 0.3125, 0.4375, 0.5625, 0.6875, 0.8125, 0.9375, 1.0625];
        for (let i = 0; i < 8; i++) {
            if (frac < buckets[i]) return PHASES[i % 8];
        }
        return PHASES[0];
    }

    function computeNow() {
        const now = Date.now();
        const daysSinceRef = (now - KNOWN_NEW_MOON) / 86400000;
        const cyclePos = daysSinceRef / SYNODIC_DAYS; // puede ser grande, no acotado a [0,1)
        const cycleNumber = Math.floor(cyclePos);
        const frac = cyclePos - cycleNumber; // 0..1
        const ageDays = frac * SYNODIC_DAYS;
        const illumination = (1 - Math.cos(2 * Math.PI * frac)) / 2 * 100;

        const daysSinceJ2000 = (now - J2000) / 86400000;
        const M = ((134.963 + 13.064993 * daysSinceJ2000) % 360 + 360) % 360;
        const distanceKm = 385000 - 20905 * Math.cos(M * Math.PI / 180);

        const nextPhases = [0, 0.25, 0.5, 0.75].map(target => {
            let candidate = cycleNumber + target;
            if (candidate <= cyclePos) candidate += 1;
            const date = new Date(KNOWN_NEW_MOON + candidate * SYNODIC_MS);
            const phaseInfo = PHASES.find(p => p.frac === target);
            return { ...phaseInfo, date };
        }).sort((a, b) => a.date - b.date);

        const nextFull = nextPhases.find(p => p.key === 'llena') || nextPhases[0];
        const daysToFull = Math.ceil((nextFull.date.getTime() - now) / 86400000);

        return {
            frac, ageDays, illumination, distanceKm, cycleNumber,
            phase: phaseForFrac(frac === 0 ? 0 : frac),
            nextPhases,
            daysToFull
        };
    }

    function fmtDateTime(d) {
        return d.toLocaleDateString('es-SV', { day: 'numeric', month: 'long' }) + ' · ' +
            d.toLocaleTimeString('es-SV', { hour: '2-digit', minute: '2-digit' });
    }

    // ---------------------------------------------------------------
    // Explorador de fases: el usuario puede elegir cualquiera de las 8
    // fases y el modelo 3D (moon3d.js) se queda iluminado en esa fase
    // hasta que elija otra o vuelva a "tiempo real". La fase REAL actual
    // sigue mostrandose siempre en las secciones de abajo (descripcion,
    // info astronomica, mareas), independientemente de lo que se explore.
    // ---------------------------------------------------------------
    let selectedPhase = null;

    function heroLabelsFor(phaseLike, illum, age) {
        document.getElementById('lunaPhaseName').textContent = phaseLike.name;
        document.getElementById('lunaIllumBig').textContent = Math.round(illum) + '% iluminada';
        document.getElementById('lunaAgeBig').textContent = age.toFixed(1) + ' días desde Luna Nueva';
    }

    function highlightSelector(key) {
        document.querySelectorAll('#lunaPhaseSelector .lps-btn').forEach(b => {
            b.classList.toggle('active', b.dataset.key === key);
        });
    }

    function updateExploreStatus() {
        const label = document.getElementById('lunaExploreLabel');
        const dot = document.getElementById('lunaExploreDot');
        const liveBtn = document.getElementById('lunaLiveBtn');
        if (selectedPhase) {
            label.textContent = 'Explorando: ' + selectedPhase.name;
            dot.classList.add('exploring');
            liveBtn.style.display = 'inline-flex';
        } else {
            label.textContent = 'En vivo';
            dot.classList.remove('exploring');
            liveBtn.style.display = 'none';
        }
    }

    function selectPhase(p) {
        selectedPhase = p;
        window.__ndaMoonPhaseOverride = p.frac;
        window.dispatchEvent(new Event('nda-moon-phase-change'));
        const illum = (1 - Math.cos(2 * Math.PI * p.frac)) / 2 * 100;
        const age = p.frac * SYNODIC_DAYS;
        heroLabelsFor(p, illum, age);
        updateExploreStatus();
        highlightSelector(p.key);
    }

    function resetLive() {
        selectedPhase = null;
        window.__ndaMoonPhaseOverride = null;
        window.dispatchEvent(new Event('nda-moon-phase-change'));
        const c = computeNow();
        heroLabelsFor(c.phase, c.illumination, c.ageDays);
        updateExploreStatus();
        highlightSelector(c.phase.key);
    }

    function buildSelector() {
        const wrap = document.getElementById('lunaPhaseSelector');
        wrap.innerHTML = PHASES.map(p => `
            <button type="button" class="lps-btn" data-key="${p.key}" title="${p.name}">
                ${phaseIconSVG(p.key, 22)}<span>${p.name}</span>
            </button>`).join('');
        wrap.addEventListener('click', e => {
            const btn = e.target.closest('.lps-btn');
            if (!btn) return;
            const p = PHASES.find(ph => ph.key === btn.dataset.key);
            if (p) selectPhase(p);
        });
        document.getElementById('lunaLiveBtn').addEventListener('click', resetLive);
    }

    function render(loc) {
        const c = computeNow();

        document.getElementById('lunaLoc').textContent = [loc.municipio, loc.departamento, loc.pais].filter(Boolean).join(', ');
        document.getElementById('lunaLocNote').style.display = loc.approx ? 'inline-flex' : 'none';
        document.getElementById('lunaDate').textContent = new Date().toLocaleDateString('es-SV', { weekday: 'long', day: 'numeric', month: 'long' });
        document.getElementById('lunaUpdated').textContent = 'Actualizado ' + new Date().toLocaleTimeString('es-SV', { hour: '2-digit', minute: '2-digit' });

        if (!selectedPhase) {
            heroLabelsFor(c.phase, c.illumination, c.ageDays);
            highlightSelector(c.phase.key);
        }

        // Tarjetas de datos astronomicos (siempre en tiempo real, sin importar lo explorado arriba)
        document.getElementById('lunaCardIllum').textContent = Math.round(c.illumination) + '%';
        document.getElementById('lunaCardAge').textContent = c.ageDays.toFixed(1) + ' días';
        document.getElementById('lunaCardDistance').textContent = Math.round(c.distanceKm).toLocaleString('es-SV') + ' km';
        document.getElementById('lunaCardCycle').textContent = 'Ciclo #' + (c.cycleNumber + 1);
        document.getElementById('lunaCardNextFull').textContent = c.daysToFull <= 0 ? 'Hoy' : c.daysToFull + ' días';

        // Descripcion de la fase actual
        document.getElementById('lunaDescTitle').textContent = c.phase.name;
        document.getElementById('lunaDescBody').textContent = c.phase.desc;
        document.getElementById('lunaDescIllum').textContent = Math.round(c.illumination) + '%';

        // Calendario de fases: proximas 4 fases, con la mas cercana a la fase
        // actual real resaltada (antes esto vivia duplicado en dos secciones
        // — timeline + tarjetas — mostrando exactamente los mismos 4 datos).
        document.getElementById('lunaNextCards').innerHTML = c.nextPhases.map(p => {
            const days = Math.ceil((p.date.getTime() - Date.now()) / 86400000);
            const isCurrent = p.key === c.phase.key;
            return `<div class="luna-next-card${isCurrent ? ' current' : ''}">
                <div class="lnc-icon">${phaseIconSVG(p.key, 52)}</div>
                <div class="lnc-name">${p.name}</div>
                <div class="lnc-date">${fmtDateTime(p.date)}</div>
                <div class="lnc-days">${days <= 0 ? 'Hoy' : days + ' días restantes'}</div>
            </div>`;
        }).join('');

        // Como afecta la fase real actual a las mareas: proxima marea viva
        // (luna nueva o llena, la que este mas cerca) y proxima marea muerta
        // (cuarto creciente o menguante, la que este mas cerca).
        const daysTo = d => Math.ceil((d.getTime() - Date.now()) / 86400000);
        const nextSpring = c.nextPhases.filter(p => p.key === 'nueva' || p.key === 'llena').sort((a, b) => a.date - b.date)[0];
        const nextNeap = c.nextPhases.filter(p => p.key === 'cuarto-creciente' || p.key === 'cuarto-menguante').sort((a, b) => a.date - b.date)[0];
        document.getElementById('lunaTideNext').innerHTML = `
            <div class="luna-tide-next-item spring">
                <span class="ltn-lbl">Próxima marea viva</span>
                <span class="ltn-val">${nextSpring.name} — ${fmtDateTime(nextSpring.date)}</span>
                <span class="ltn-days">${daysTo(nextSpring.date) <= 0 ? 'Hoy' : 'en ' + daysTo(nextSpring.date) + ' días'}</span>
            </div>
            <div class="luna-tide-next-item neap">
                <span class="ltn-lbl">Próxima marea muerta</span>
                <span class="ltn-val">${nextNeap.name} — ${fmtDateTime(nextNeap.date)}</span>
                <span class="ltn-days">${daysTo(nextNeap.date) <= 0 ? 'Hoy' : 'en ' + daysTo(nextNeap.date) + ' días'}</span>
            </div>`;
    }

    async function boot() {
        buildSelector();
        const loc = await window.ndaGetLocation();
        render(loc);
        setInterval(() => render(loc), 60000); // la fase cambia muy despacio, basta con refrescar cada minuto
    }

    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', boot);
    else boot();
})();
