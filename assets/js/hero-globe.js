/* ================================================================
   NDA — Hero: globo sismico real (globe.gl) con vuelo por scroll
   Fase 1 (scroll 0%):    planeta completo, sismos del dia a nivel mundial
   Fase 2 (scroll ~33%):  vuelo hacia Centroamerica
   Fase 3 (scroll ~66%+): aterriza en El Salvador, marcador propio
   ================================================================ */
(function () {
    const el = document.getElementById('globeViz');
    const heroEl = document.getElementById('home');
    if (!el || !heroEl || typeof Globe === 'undefined') return;

    const COLOR_ALERT = '#b8433f';   // --red / --acc2
    const COLOR_SV_MARKER = '#c98a3d'; // --acc

    const globe = Globe()(el)
        .globeImageUrl('https://unpkg.com/three-globe/example/img/earth-night.jpg')
        .bumpImageUrl('https://unpkg.com/three-globe/example/img/earth-topology.png')
        .backgroundColor('rgba(0,0,0,0)')
        .showAtmosphere(true)
        .atmosphereColor('#c98a3d')
        .atmosphereAltitude(0.18)
        .pointOfView({ lat: 12, lng: -75, altitude: 2.4 }, 0);

    globe.controls().autoRotate = true;
    globe.controls().autoRotateSpeed = 0.35;
    globe.controls().enableZoom = false;
    globe.controls().enabled = false; // el usuario navega con scroll, no arrastrando el globo

    // ---------------- MAPA LEAFLET (reemplaza el zoom cercano del globo) ----------------
    // La textura del globo se ve borrosa si se acerca demasiado; en vez de
    // forzar ese zoom, a partir de cierto punto del scroll se cambia a un
    // mapa Leaflet real (nitido a cualquier nivel de zoom) centrado en
    // El Salvador.
    let leafletMap = null;
    function ensureLeafletMap() {
        if (leafletMap || typeof L === 'undefined') return;
        const mapEl = document.getElementById('svMapLeaflet');
        if (!mapEl) return;
        leafletMap = L.map(mapEl, {
            zoomControl: false,
            attributionControl: false,
            dragging: true,
            scrollWheelZoom: false,
        }).setView([13.7942, -88.8965], 8);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
        }).addTo(leafletMap);

        L.circleMarker([13.7942, -88.8965], {
            radius: 7, color: COLOR_SV_MARKER, weight: 2, fillColor: COLOR_SV_MARKER, fillOpacity: 0.5
        }).addTo(leafletMap).bindTooltip('El Salvador', { permanent: false });
    }

    function magColor(mag) {
        if (mag >= 6) return '#b8433f';
        if (mag >= 5) return '#a85736';
        if (mag >= 4) return '#c9a63f';
        return '#5c7a54';
    }

    // Marcador fijo de El Salvador (siempre visible, para ubicar el pais
    // incluso antes de que lleguen datos de sismos).
    const svMarker = { lat: 13.7942, lng: -88.8965, size: 1, place: 'El Salvador', isSV: true };

    // Antes este fetch iba directo a USGS (feed mundial, sin filtro
    // regional y desincronizado del resto del sitio). Ahora usa el mismo
    // proxy que ya consume el monitor sismico (MainController::earthquakes,
    // filtrado a Centroamerica y con cache de 2 minutos) — un solo punto
    // de verdad para "sismos recientes" en toda la plataforma.
    fetch('?url=earthquakes')
        .then(r => r.json())
        .then(data => {
            const quakes = (data.features || []).map(f => ({
                lat: f.geometry.coordinates[1],
                lng: f.geometry.coordinates[0],
                mag: f.properties.mag || 0,
                place: f.properties.place,
                depth: f.geometry.coordinates[2],
                time: new Date(f.properties.time).toLocaleString('es-SV'),
                color: magColor(f.properties.mag || 0),
            }));

            globe
                .pointsData([...quakes, svMarker])
                .pointLat('lat')
                .pointLng('lng')
                .pointColor(d => d.isSV ? COLOR_SV_MARKER : d.color)
                .pointAltitude(d => d.isSV ? 0.02 : Math.max((d.mag || 1) * 0.015, 0.01))
                .pointRadius(d => d.isSV ? 0.55 : Math.max((d.mag || 1) * 0.16, 0.18))
                .pointLabel(d => d.isSV
                    ? '<div style="background:#0d1420;color:#fff;padding:6px 10px;border-radius:8px;font:600 12px Space Grotesk,sans-serif">El Salvador</div>'
                    : `<div style="background:#0d1420;color:#fff;padding:8px 12px;border-radius:8px;font:12px Space Grotesk,sans-serif;max-width:220px">
                         <b>${d.place || 'Ubicación desconocida'}</b><br>
                         Magnitud ${d.mag?.toFixed?.(1) ?? '—'} · ${Math.round(d.depth || 0)} km de profundidad<br>
                         ${d.time || ''}
                       </div>`);

            // Ondas expansivas para sismos moderados/fuertes — matching
            // el efecto "pulsaciones / ondas expansivas" del anteproyecto.
            const strong = quakes.filter(q => q.mag >= 4.2);
            globe
                .ringsData(strong)
                .ringLat('lat')
                .ringLng('lng')
                .ringColor(() => t => `rgba(255,90,40,${1 - t})`)
                .ringMaxRadius(d => Math.max(d.mag * 1.4, 3))
                .ringPropagationSpeed(2.4)
                .ringRepeatPeriod(1400);
        })
        .catch(() => {
            // Sin conexion a USGS: al menos mostramos el marcador de El Salvador.
            globe.pointsData([svMarker]).pointLat('lat').pointLng('lng')
                .pointColor(() => COLOR_SV_MARKER).pointAltitude(0.02).pointRadius(0.55);
        });

    // ---------------- SCROLL: 3 fases ----------------
    const phase1 = document.querySelector('.h3d-phase-1');
    const phase2 = document.querySelector('.h3d-phase-2');
    const phase3 = document.querySelector('.h3d-phase-3');
    const globeWrap = document.querySelector('.hero3d-sticky');

    // Puntos de vista clave del vuelo (lat, lng, altitude de la camara)
    const POV_PLANET = { lat: 12, lng: -75, altitude: 2.4 };
    const POV_CENTROAMERICA = { lat: 13.5, lng: -87, altitude: 0.9 };
    const POV_EL_SALVADOR = { lat: 13.7942, lng: -88.8965, altitude: 0.55 };

    function lerp(a, b, t) { return a + (b - a) * t; }

    function lerpPOV(p) {
        // 0 -> 0.5 interpola planeta -> centroamerica
        // 0.5 -> 1 interpola centroamerica -> el salvador
        if (p <= 0.5) {
            const t = p / 0.5;
            return {
                lat: lerp(POV_PLANET.lat, POV_CENTROAMERICA.lat, t),
                lng: lerp(POV_PLANET.lng, POV_CENTROAMERICA.lng, t),
                altitude: lerp(POV_PLANET.altitude, POV_CENTROAMERICA.altitude, t),
            };
        }
        const t = (p - 0.5) / 0.5;
        return {
            lat: lerp(POV_CENTROAMERICA.lat, POV_EL_SALVADOR.lat, t),
            lng: lerp(POV_CENTROAMERICA.lng, POV_EL_SALVADOR.lng, t),
            altitude: lerp(POV_CENTROAMERICA.altitude, POV_EL_SALVADOR.altitude, t),
        };
    }

    let progress = 0;
    let targetProgress = 0;

    function computeProgress() {
        const total = heroEl.offsetHeight - window.innerHeight;
        if (total <= 0) { targetProgress = 0; return; }
        const scrolled = -heroEl.getBoundingClientRect().top;
        targetProgress = Math.min(1, Math.max(0, scrolled / total));
    }
    window.addEventListener('scroll', computeProgress, { passive: true });
    computeProgress();

    function setPhaseVisibility(p) {
        const activePhase = p < 0.3 ? 1 : p < 0.62 ? 2 : 3;
        phase1.classList.toggle('active', activePhase === 1);
        phase2.classList.toggle('active', activePhase === 2);
        phase3.classList.toggle('active', activePhase === 3);
        if (globeWrap) globeWrap.dataset.phase = activePhase;
        globe.controls().autoRotate = activePhase === 1;

        // Cruce de opacidad: el globo se desvanece y el mapa Leaflet
        // (nitido) toma su lugar al llegar al acercamiento final.
        const mapEl = document.getElementById('svMapLeaflet');
        const globeEl = document.getElementById('globeViz');
        if (mapEl && globeEl) {
            const mapT = Math.max(0, Math.min(1, (p - 0.8) / 0.2));
            if (mapT > 0 && !leafletMap) ensureLeafletMap();
            mapEl.style.opacity = mapT;
            mapEl.classList.toggle('visible', mapT > 0.5);
            globeEl.style.opacity = 1 - mapT * 0.9;
            if (leafletMap && mapT > 0.05) {
                leafletMap.invalidateSize();
            }
        }
    }

    function raf() {
        requestAnimationFrame(raf);
        progress += (targetProgress - progress) * 0.08;
        globe.pointOfView(lerpPOV(progress), 0);
        setPhaseVisibility(progress);
    }
    raf();

    function resize() {
        globe.width(el.clientWidth);
        globe.height(el.clientHeight);
    }
    window.addEventListener('resize', resize);
    resize();
})();
