// NDA - Hero: globo real (globe.gl / Three.js) para la vista de planeta y
// Centroamerica, que se funde con un mapa MapLibre GL JS con TERRENO real
// (elevacion de El Salvador) al acercarse. Sin puntos de sismos: esos datos
// viven en la seccion "Zona Sismica" y en la pagina /sismos.
(function () {
    const globeEl = document.getElementById('globeViz');
    const terrainEl = document.getElementById('terrainViz');
    const heroEl = document.getElementById('home');
    if (!globeEl || !terrainEl || !heroEl || typeof Globe === 'undefined') return;

    // MapLibre (a diferencia de Leaflet) no sustituye {s} ni {r} en las URLs
    // de tiles -- hay que dar la lista real de subdominios y pedir @2x a
    // proposito para que el mapa se vea nitido, no solo el relieve sin foto.
    // CARTO ahora exige API key hasta en el tier gratuito (window.__ndaCartoKey,
    // ver layout.php); sin ella los tiles salen con el watermark "API KEY REQUIRED".
    const cartoKey = window.__ndaCartoKey ? '?key=' + encodeURIComponent(window.__ndaCartoKey) : '';
    const CARTO_SUBDOMAINS = ['a', 'b', 'c', 'd'];
    const DARK_TILES = CARTO_SUBDOMAINS.map(s => `https://${s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}@2x.png${cartoKey}`);
    const LIGHT_TILES = CARTO_SUBDOMAINS.map(s => `https://${s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}@2x.png${cartoKey}`);
    const TERRAIN_TILES = 'https://s3.amazonaws.com/elevation-tiles-prod/terrarium/{z}/{x}/{y}.png';

    function currentTheme() {
        return document.documentElement.getAttribute('data-theme') === 'light' ? 'light' : 'dark';
    }

    // ---------------- Globo lejano (planeta / Centroamerica) ----------------
    // Textura fotorrealista real (NASA Blue Marble) en ambos temas -- el
    // globo en si se ve igual de "foto real" que un globo de Google Maps,
    // el tema claro/oscuro del sitio solo cambia el fondo detras de el.
    const globe = Globe()(globeEl)
        .globeImageUrl('https://unpkg.com/three-globe/example/img/earth-blue-marble.jpg')
        .bumpImageUrl('https://unpkg.com/three-globe/example/img/earth-topology.png')
        .backgroundColor('rgba(0,0,0,0)')
        .showAtmosphere(true)
        .atmosphereColor('#8fc6ff')
        .atmosphereAltitude(0.2)
        .pointOfView({ lat: 12, lng: -75, altitude: 2.4 }, 0);

    globe.controls().autoRotate = true;
    globe.controls().autoRotateSpeed = 0.35;
    globe.controls().enableZoom = false;
    globe.controls().enabled = false; // el usuario navega con scroll, no arrastrando el globo

    // ---------------- Mapa cercano con terreno real (El Salvador) ----------------
    let map = null;
    let appliedMapTheme = null;

    function mapStyle(theme) {
        return {
            version: 8,
            sources: {
                'nda-base': { type: 'raster', tiles: theme === 'light' ? LIGHT_TILES : DARK_TILES, tileSize: 512, attribution: '© CARTO © OpenStreetMap' },
                'nda-terrain': { type: 'raster-dem', tiles: [TERRAIN_TILES], tileSize: 256, encoding: 'terrarium' },
            },
            layers: [{ id: 'nda-base-layer', type: 'raster', source: 'nda-base' }],
            terrain: { source: 'nda-terrain', exaggeration: 1.6 },
        };
    }

    function ensureMap() {
        if (map || typeof ensureMapLibreLoaded !== 'function') return;
        ensureMapLibreLoaded().then(() => {
            if (!window.maplibregl || map) return;
            appliedMapTheme = currentTheme();
            map = new maplibregl.Map({
                container: terrainEl,
                style: mapStyle(appliedMapTheme),
                center: [-89.15, 13.75],
                zoom: 10.8,
                pitch: 65,
                bearing: -18,
                interactive: false,
                attributionControl: false,
            });
        }).catch(() => {});
    }

    function applyMapTheme(theme) {
        if (!map || theme === appliedMapTheme) return;
        appliedMapTheme = theme;
        map.setStyle(mapStyle(theme));
    }

    // Reacciona al boton de tema claro/oscuro (app.js cambia data-theme en <html>).
    // El globo ya no cambia de textura por tema (siempre fotorrealista); solo
    // el mapa MapLibre del acercamiento final cambia de estilo claro/oscuro.
    new MutationObserver(() => {
        applyMapTheme(currentTheme());
    }).observe(document.documentElement, { attributes: true, attributeFilter: ['data-theme'] });

    ensureMap();

    // ---------------- SCROLL: 3 fases ----------------
    const phase1 = document.querySelector('.h3d-phase-1');
    const phase2 = document.querySelector('.h3d-phase-2');
    const phase3 = document.querySelector('.h3d-phase-3');
    const globeWrap = document.querySelector('.hero3d-sticky');

    const POV_PLANET = { lat: 12, lng: -75, altitude: 2.4 };
    const POV_CENTROAMERICA = { lat: 13.5, lng: -87, altitude: 0.9 };
    // No se acerca mas que esto con la textura del globo: es una sola imagen
    // de toda la Tierra (4096x2048px), asi que El Salvador ocupa apenas unos
    // pixeles ahi y se ve borroso si se acerca demasiado. El acercamiento real
    // lo hace el mapa MapLibre con terreno (nitido), que toma el relevo antes
    // de llegar a este punto (ver mapT mas abajo).
    const POV_EL_SALVADOR = { lat: 13.7942, lng: -88.8965, altitude: 0.38 };

    function lerp(a, b, t) { return a + (b - a) * t; }

    function lerpPOV(p) {
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

        // El mapa con terreno (nitido) toma el relevo bastante antes de que
        // el globo llegue a su zoom mas cercano, para que nunca se alcance
        // a notar que la textura del globo completo se ve borrosa de cerca.
        const mapT = Math.max(0, Math.min(1, (p - 0.6) / 0.28));
        if (mapT > 0) ensureMap();
        terrainEl.style.opacity = mapT;
        terrainEl.classList.toggle('visible', mapT > 0.5);
        globeEl.style.opacity = 1 - mapT * 0.95;
        if (map && mapT > 0.05) {
            try { map.resize(); } catch (e) {}
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
        globe.width(globeEl.clientWidth);
        globe.height(globeEl.clientHeight);
        if (map) { try { map.resize(); } catch (e) {} }
    }
    window.addEventListener('resize', resize);
    resize();
})();
