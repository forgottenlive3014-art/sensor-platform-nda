<?php
$title = $title ?? 'NDA · Natural Disaster Alert';
$user = $user ?? null;
$__canJoinInstitution = $user && !$user['institucion_id'];
$__hasApprovedInstitution = $user && $user['institucion_id'] && $user['estado_institucional'] === 'aprobado';
$extraCss = ['css/home-scroll.css'];
ob_start();
?>

<section class="hero3d" id="home">
  <div class="hero3d-sticky">
    <div id="globeViz"></div>
    <div id="globeGlb"></div>
    <div id="terrainViz"></div>
    <div class="hero3d-vignette"></div>

    <div class="h3d-phase h3d-phase-1 active" data-phase="1">
      <div class="wrap h3d-phase1-inner">
        <div class="hi-left">
          <div class="hero-eyebrow"><span class="pulsedot"></span>Plataforma Educativa — El Salvador</div>
          <h1 class="hero-h1">
            <span class="h1-w">Natural</span>
            <span class="h1-r">Disaster</span>
            <span class="h1-g">Alert System</span>
          </h1>
          <p class="hero-sub">Monitoreo sísmico en tiempo real, simulaciones interactivas y educación en prevención de desastres para la comunidad escolar salvadoreña.</p>
          <div class="hero-pills">
            <div class="hp"><strong id="hp-quakes">—</strong> sismos hoy</div>
            <div class="hp"><strong data-gsap-count="7.7" data-gsap-decimals="1">0</strong> magnitud máx. histórica</div>
            <div class="hp"><strong data-gsap-count="26">0</strong> volcanes</div>
            <div class="hp"><strong data-gsap-count="2">0</strong> placas tectónicas</div>
          </div>
          <div class="hero-cta">
            <a href="?url=arduino" class="btn-acc"> Monitor Sísmico</a>
            <a href="?url=sismos" class="btn-out"> Acerca de Sismos</a>
          </div>
        </div>
        <div class="hi-right">
          <div class="hero-monitor">
            <div class="hm-top">
              <div class="hm-dots"><span></span><span></span><span></span></div>
              <span class="hm-label">seismic_monitor.live</span>
              <div class="hm-live"><span class="ldot"></span>EN VIVO</div>
            </div>
            <div class="hm-body">
              <canvas id="heroSg"></canvas>
              <div class="hm-mini">
                <div class="hmm"><div class="hmm-v" id="hm-today">—</div><div class="hmm-l">Hoy</div></div>
                <div class="hmm"><div class="hmm-v" id="hm-max">—</div><div class="hmm-l">Mag. Máx</div></div>
                <div class="hmm"><div class="hmm-v" id="hm-depth">—</div><div class="hmm-l">Prof. km</div></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="h3d-phase h3d-phase-2" data-phase="2">
      <div class="h3d-region-label">
        <span class="h3d-region-eyebrow">Acercando</span>
        <h2>Centroamérica</h2>
        <p>Una de las regiones con mayor actividad sísmica del planeta, sobre el llamado Cinturón de Fuego del Pacífico.</p>
      </div>
    </div>

    <div class="h3d-phase h3d-phase-3" data-phase="3">
      <div class="h3d-region-label h3d-region-label-sv">
        <span class="h3d-region-eyebrow">El Salvador</span>
        <h2>El país más pequeño de Centroamérica, uno de los más sísmicos</h2>
      </div>
      <div class="h3d-cards">
        <div class="h3d-card">
          <span class="h3d-card-ico"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg></span>
          <strong>¿Por qué tantos sismos?</strong>
          <p>El Salvador está sobre el límite entre la Placa de Cocos y la Placa del Caribe, una de las zonas de subducción más activas del mundo.</p>
        </div>
        <div class="h3d-card">
          <span class="h3d-card-ico"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5M2 12l10 5 10-5"/></svg></span>
          <strong>Placas tectónicas</strong>
          <p>La subducción de la Placa de Cocos bajo la Placa del Caribe genera sismos frecuentes y actividad volcánica en toda la cordillera.</p>
        </div>
        <div class="h3d-card">
          <span class="h3d-card-ico"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></span>
          <strong>Actividad reciente</strong>
          <p id="h3d-actividad-reciente">Consultando datos sísmicos de las últimas 24 horas…</p>
        </div>
        <div class="h3d-card">
          <span class="h3d-card-ico"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.3 3.9L1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg></span>
          <strong>Riesgos principales</strong>
          <p>Sismos, erupciones volcánicas, deslizamientos y tsunamis en la costa del Pacífico son los fenómenos que más afectan al país.</p>
        </div>
      </div>
    </div>

    <div class="scroll-hint"><span>Scroll</span><div class="sh-arr"></div></div>
  </div>
  <div class="hero3d-spacer"></div>
</section>

<!-- ZONA SISMICA: mapa real con zonas de mayor sismicidad, volcanes y otros riesgos -->
<section class="sec sec-dark hp-relative" id="zona-sismica">
  <div class="hp-blob hp-blob-acc" data-speed="0.7" aria-hidden="true"></div>
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Riesgo Geológico · El Salvador</div>
      <h2 class="sec-title">Zona <span class="acc">Sísmica</span></h2>
      <p class="sec-sub">Zonas de mayor actividad sísmica, volcanes y riesgos asociados — datos de MARN, USGS e IOC-UNESCO</p>
    </div>
    <div class="map-container">
      <div class="map-ctrl-bar">
        <button class="mc-btn" data-layer="seismic"><span class="mld" style="background:#e63946"></span>Zonas sísmicas</button>
        <button class="mc-btn" data-layer="volcanic"><span class="mld" style="background:#ff9500"></span>Volcanes</button>
        <button class="mc-btn" data-layer="quakes"><span class="mld" style="background:#ff9500"></span>Sismos recientes (USGS)</button>
        <button class="mc-btn" data-layer="flood"><span class="mld" style="background:#3d9bff"></span>Riesgo de tsunami</button>
        <button class="mc-btn" data-layer="slides"><span class="mld" style="background:#ffcc00"></span>Deslizamientos</button>
        <button class="mc-btn" data-layer="safe"><span class="mld" style="background:#22c55e"></span>Zonas seguras</button>
        <button class="mc-btn on" data-layer="all">Ver todo</button>
      </div>
      <div id="hazardMap"></div>
    </div>
    <div class="facts-bar" style="margin-top:18px">
      <div class="fbi"><div class="fbi-n nda-count">26</div><div class="fbi-l">volcanes en territorio salvadoreño</div></div>
      <div class="fbi"><div class="fbi-n nda-count">6</div><div class="fbi-l">volcanes activos monitoreados por MARN</div></div>
      <div class="fbi"><div class="fbi-n nda-count">~100</div><div class="fbi-l">sismos perceptibles al año</div></div>
      <div class="fbi"><div class="fbi-n nda-count">4</div><div class="fbi-l">zonas de mayor actividad tectónica</div></div>
    </div>
    <p style="text-align:center;margin-top:20px">
      <a href="?url=sismos" class="btn-out">Ver monitor sísmico completo →</a>
    </p>
  </div>
</section>

<!-- PLACAS TECTÓNICAS -->
<section class="sec hp-relative" id="placas">
  <div class="hp-blob hp-blob-teal" data-speed="1" aria-hidden="true"></div>
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Geodinámica · Centroamérica</div>
      <h2 class="sec-title">Placas <span class="acc">Tectónicas</span></h2>
      <p class="sec-sub">Cómo el movimiento de la tierra genera terremotos</p>
    </div>
    <div class="plates-grid">
      <div class="plate-card">
        <div class="pc-visual"><canvas id="plateCv" width="280" height="170"></canvas></div>
        <div class="pc-body"><h4>Subducción</h4><p>La <strong>Placa de Cocos</strong> se hunde bajo la Placa del Caribe en la zona de subducción frente a la costa salvadoreña. Esta colisión genera enormes presiones.</p></div>
      </div>
      <div class="plate-card">
        <div class="pc-visual"><div class="wave-rings"><div class="wr"></div><div class="wr"></div><div class="wr"></div><div class="wr"></div><div class="wc-star"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><polygon points="12,2 15,9 22,9.5 16.5,14 18,21 12,17.5 6,21 7.5,14 2,9.5 9,9" fill="currentColor"/></svg></div></div></div>
        <div class="pc-body"><h4>Ondas Sísmicas</h4><p>Cuando la tensión acumulada se libera, genera <strong>ondas sísmicas P</strong> (primarias) y <strong>ondas S</strong> (secundarias) que viajan a través de la corteza terrestre.</p></div>
      </div>
      <div class="plate-card">
        <div class="pc-visual"><div class="richter-vis"><div class="rv-bar" style="width:25%">1–2</div><div class="rv-bar" style="width:38%">3–4</div><div class="rv-bar" style="width:52%">5</div><div class="rv-bar" style="width:65%">6</div><div class="rv-bar" style="width:80%">7</div><div class="rv-bar hl" style="width:100%">8+</div></div></div>
        <div class="pc-body"><h4>Escala de Richter</h4><p>La magnitud mide la energía liberada. Cada número representa <strong>10 veces más amplitud</strong> y ~32 veces más energía que el anterior.</p></div>
      </div>
    </div>
    <div class="plate-bar">
      <div class="pb-badge pb-cocos">Placa de Cocos</div>
      <div class="pb-arr"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg> subduce <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></div>
      <div class="pb-badge pb-carib">Placa del Caribe</div>
      <div class="pb-res">= Terremotos + Volcanes en El Salvador</div>
    </div>
  </div>
</section>

<!-- HISTORIA: linea de tiempo de los mayores desastres -->
<section class="sec sec-dark hp-relative" id="timeline">
  <div class="hp-blob hp-blob-blue" data-speed="0.85" aria-hidden="true"></div>
  <div class="wrap">
    <div class="sec-hd"><div class="sec-eyebrow">Historia Sísmica · El Salvador</div><h2 class="sec-title">Línea del <span class="acc">Tiempo</span></h2><p class="sec-sub">Los terremotos más significativos en la historia del país</p></div>
    <div class="tl-wrap"><div class="tl-line"></div><div class="tl-track" id="tlTrack"></div></div>
    <div class="tl-detail" id="tlDetail"></div>
    <div class="data-source-note">
      <strong>Fuentes y respaldo de datos:</strong> Servicio Nacional de Estudios Territoriales (SNET/MARN), Universidad Centroamericana "José Simeón Cañas" (UCA), 
      Ministerio de Educación de El Salvador y hemerotecas nacionales (La Prensa Gráfica, El Diario de Hoy). 
    </div>
  </div>
</section>

<!-- QUE ENCONTRARAS EN LA PAGINA -->
<section class="sec" id="encontraras">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Explora NDA</div>
      <h2 class="sec-title">¿Qué <span class="acc">encontrarás</span> en la página?</h2>
      <p class="sec-sub">Un recorrido rápido por todo lo que la plataforma tiene para ti</p>
    </div>
    <div class="fc-scrollzone">
    <div class="find-cards-grid fc-carousel">
    <div class="find-cards-track">
      <a href="?url=clima" class="find-card">
        <div class="find-card-visual"><video autoplay muted loop playsinline><source src="assets/media/video/clima.mp4" type="video/mp4"></video></div>
        <div class="find-card-body"><h3>Clima en Tiempo Real</h3><p>Consulta la temperatura, el pronóstico y las condiciones meteorológicas en tiempo real para tu ubicación.</p><span class="fc-cta">Ver clima →</span></div>
      </a>

      <a href="?url=luna" class="find-card">
        <div class="find-card-visual"><video autoplay muted loop playsinline><source src="assets/media/video/fasesdelaLuna.mp4" type="video/mp4"></video></div>
        <div class="find-card-body"><h3>Fases de la Luna en 3D</h3><p>Explora el modelo lunar interactivo, las fases actuales y datos astronómicos actualizados diariamente.</p><span class="fc-cta">Ver luna 3D →</span></div>
      </a>

      <a href="?url=sismos" class="find-card">
        <div class="find-card-visual"><video autoplay muted loop playsinline><source src="assets/media/video/sismo.mp4" type="video/mp4"></video></div>
        <div class="find-card-body"><h3>Sismos: ¿Cómo se Miden?</h3><p>Aprende sobre magnitud, intensidad, escalas sísmicas y el funcionamiento de un sismógrafo interactivo.</p><span class="fc-cta">Aprender más →</span></div>
      </a>

      <a href="?url=sismos#zona-sismica" class="find-card">
        <div class="find-card-visual"><video autoplay muted loop playsinline><source src="assets/media/video/volcanerupcion.mp4" type="video/mp4"></video></div>
        <div class="find-card-body"><h3>Volcanes de El Salvador</h3><p>Conoce los volcanes del país, su ubicación, actividad reciente y características más importantes.</p><span class="fc-cta">Ver mapa →</span></div>
      </a>

      <a href="?url=quehacer" class="find-card">
        <div class="find-card-visual"><video autoplay muted loop playsinline><source src="assets/media/video/quehacer.mp4" type="video/mp4"></video></div>
        <div class="find-card-body"><h3>¿Qué hacer AHORA?</h3><p>Descubre las acciones recomendadas antes, durante y después de un sismo u otra emergencia.</p><span class="fc-cta">Ver guía →</span></div>
      </a>

      <a href="?url=sismos#quakeFeed" class="find-card">
        <div class="find-card-visual"><video autoplay muted loop playsinline><source src="assets/media/video/historiasismo.mp4" type="video/mp4"></video></div>
        <div class="find-card-body"><h3>Historial de Sismos Recientes</h3><p>Consulta los eventos sísmicos más recientes con información detallada y registros actualizados.</p><span class="fc-cta">Ver historial →</span></div>
      </a>

      <a href="?url=juegos" class="find-card">
        <div class="find-card-visual"><video autoplay muted loop playsinline><source src="assets/media/video/juegos.mp4" type="video/mp4"></video></div>
        <div class="find-card-body"><h3>Juegos y Trivias</h3><p>Refuerza tus conocimientos mediante juegos interactivos y desafíos sobre prevención de desastres.</p><span class="fc-cta">Jugar →</span></div>
      </a>

      <a href="?url=arduino" class="find-card">
        <div class="find-card-visual"><video autoplay muted loop playsinline><source src="assets/media/video/sensor.mp4" type="video/mp4"></video></div>
        <div class="find-card-body"><h3>Sismógrafo de Arduino</h3><p>Observa cómo funciona el sensor MPU-6050 y la detección de vibraciones en tiempo real.</p><span class="fc-cta">Ver demo →</span></div>
      </a>
    </div>
    </div>
    </div>
  </div>
</section>


<!-- GESTION ESCOLAR (teaser) -->
<section class="sec sec-dark" id="gestion-escolar-teaser">
  <div class="wrap">
    <div class="school-teaser">
      <div>
        <h3>¿Formas parte de una institución educativa?</h3>
        <p>Súmate al módulo de Gestión Escolar: asistencia, simulacros, incidentes, rutas de evacuación y comunicación con tu comunidad educativa, todo en un solo lugar.</p>
      </div>
      <?php if ($__hasApprovedInstitution): ?>
        <a href="?url=school" class="btn-acc">Ir a mi Gestión Escolar →</a>
      <?php elseif ($__canJoinInstitution): ?>
        <a href="?url=profile#joinForm" class="btn-acc">Agregar mi institución →</a>
      <?php else: ?>
        <a href="?url=login" class="btn-acc">Inicia sesión para unirte →</a>
      <?php endif; ?>
    </div>
  </div>
</section>

<script src="https://unpkg.com/globe.gl"></script>
<script type="module">
import * as THREE from 'three';
import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';
import { RoomEnvironment } from 'three/addons/environments/RoomEnvironment.js';

const globeGlb = document.getElementById('globeGlb');
if (!globeGlb) {
  console.warn('No existe #globeGlb para el GLB del mundo diurno.');
} else {
  // ============================================================
  // 1) CANVAS RECTANGULAR DEL HERO — ocupa todo el marco del home
  // ============================================================
  const width = globeGlb.clientWidth || window.innerWidth;
  const height = globeGlb.clientHeight || window.innerHeight;
  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(45, width / Math.max(height, 1), 0.1, 1000);
  camera.position.set(0, 0, 3.4);
  camera.lookAt(0, 0, 0);

  const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
  renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2.5));
  renderer.setSize(width, height, false);
  renderer.outputColorSpace = THREE.SRGBColorSpace;
  renderer.setClearColor(0x000000, 0);
  renderer.domElement.setAttribute('aria-label', 'globe-glb');
  globeGlb.appendChild(renderer.domElement);

  // ============================================================
  // 2) ILUMINACIÓN REALISTA — quita el "plano"
  // ============================================================
  scene.add(new THREE.AmbientLight(0xffffff, 0.45));

  const sun = new THREE.DirectionalLight(0xffffff, 2.2);
  sun.position.set(5, 2, 3);
  scene.add(sun);

  const fill = new THREE.DirectionalLight(0x88bbff, 0.55);
  fill.position.set(-5, -2, -3);
  scene.add(fill);

  const rim = new THREE.DirectionalLight(0xffddaa, 0.4);
  rim.position.set(0, 5, -5);
  scene.add(rim);

  // ============================================================
  // 3) ENVIRONMENT MAP — reflejos realistas
  // ============================================================
  const pmrem = new THREE.PMREMGenerator(renderer);
  pmrem.compileEquirectangularShader();
  const envTex = pmrem.fromScene(new RoomEnvironment(), 0.04).texture;

  // ============================================================
  // 4) CONSTANTES GEOGRÁFICAS — EL SALVADOR
  // ------------------------------------------------------------
  // El Salvador: lat 13.7° N, lon -89.2° W
  //
  // Para una esfera THREE.js estándar (meridiano 0 → +Z):
  //   rotation.y = degToRad(-LON)   → trae esa longitud al frente
  //   rotation.x = degToRad( LAT)   → trae esa latitud al frente
  //
  // Tu GLB tiene el meridiano 0 desplazado. Offset corregido
  // tras análisis de las capturas previas:
  //   - Con -11° el frente era África (lon ≈ 0°)
  //   - Con +78° el frente era Pacífico mexicano (lon ≈ -105°)
  //   - Interpolación lineal → +18° ≈ El Salvador (lon ≈ -89°)
  //
  // AJUSTE FINO con el DEBUG activado (ver más abajo):
  //   nuevo_offset = offset_actual + (-89.2 - lon_actual)
  // ============================================================
  const SV_LON_DEG = -115;
  const SV_LAT_DEG = 13.7;

  const BASE_OFFSET_Y = THREE.MathUtils.degToRad(18); // alinea la vista a El Salvador
  const BASE_OFFSET_X = THREE.MathUtils.degToRad(8); // sube un poco la proyección de El Salvador

  const BASE_ROT_Y = THREE.MathUtils.degToRad(-SV_LON_DEG) + BASE_OFFSET_Y;
  const BASE_ROT_X = THREE.MathUtils.degToRad(SV_LAT_DEG) + BASE_OFFSET_X;

  // ============================================================
  // 5) CARGAR EL MODELO
  // ============================================================
  const loader = new GLTFLoader();
  loader.load('assets/modelos3d/earth_globe_-_atlas.glb', (gltf) => {
    const model = gltf.scene;

    // --- Arreglar materiales ---
    model.traverse((child) => {
      if (!child.isMesh) return;
      const mat = child.material;
      if (!mat) return;

      if ('flatShading' in mat) mat.flatShading = false;
      if ('roughness' in mat) mat.roughness = 0.85;
      if ('metalness' in mat) mat.metalness = 0.05;

      mat.envMap = envTex;
      mat.envMapIntensity = 0.45;
      mat.needsUpdate = true;

      child.castShadow = false;
      child.receiveShadow = false;
    });

    // --- Escalar PRIMERO ---
    const box = new THREE.Box3().setFromObject(model);
    const size3D = box.getSize(new THREE.Vector3()).length();
    const scale = 3.10 / Math.max(size3D, 1e-6);
    model.scale.setScalar(scale);

    // --- DESPUÉS centrar (con el box ya escalado) ---
    box.setFromObject(model);
    const center = box.getCenter(new THREE.Vector3());
    model.position.sub(center);

    // --- Orientación base: El Salvador al frente ---
    model.rotation.y = BASE_ROT_Y;
    model.rotation.x = BASE_ROT_X;

    // --- Guardar para animación ---
    window.__ndaGlbModel = model;
    window.__ndaGlbBaseScale = scale;

    const baseModelPosition = model.position.clone();
    const baseCameraZ = camera.position.z;
    const introStart = performance.now();
    const introDuration = 1200;

    scene.add(model);

    // ============================================================
    // 6) ANIMACIÓN
    // ============================================================
    function animate() {
      requestAnimationFrame(animate);

      const scrollPulse = window.__ndaHeroScrollProgress || 0;
      const t = Math.min(Math.max(scrollPulse, 0), 1);
      const travel = t;

      // Igual flujo visual que el modo oscuro: misma velocidad y tamaño de
      // acercamiento para que la transición se sienta consistente.
      const zoomBoost = 0.45;
      const zoom = 1 + travel * zoomBoost;
      model.scale.setScalar(window.__ndaGlbBaseScale * zoom);

      const introProgress = Math.min(1, (performance.now() - introStart) / introDuration);
      const introEase = 1 - Math.pow(1 - introProgress, 3);
      const introYaw = (1 - introEase) * THREE.MathUtils.degToRad(18);

      model.rotation.y = BASE_ROT_Y + introYaw;
      model.rotation.x = BASE_ROT_X;

      model.position.set(
        baseModelPosition.x,
        baseModelPosition.y + 0.05,
        baseModelPosition.z
      );

      camera.position.z = Math.max(1.85, baseCameraZ - travel * 1.15);
      camera.position.y = 0.08 - travel * 0.04;
      camera.lookAt(0, 0.08, 0);

      renderer.render(scene, camera);
    }
    animate();

    // ============================================================
    // 7) RESIZE
    // ============================================================
    window.addEventListener('resize', () => {
      const w = globeGlb.clientWidth || window.innerWidth;
      const h = globeGlb.clientHeight || window.innerHeight;
      camera.aspect = w / Math.max(h, 1);
      camera.updateProjectionMatrix();
      renderer.setSize(w, h, false);
      renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2.5));
    });
  }, undefined, (error) => {
    console.error('No se pudo cargar el GLB del atlas:', error);
  });
}
</script>
<script src="<?= asset('js/hero-globe.js') ?>"></script>
<script src="<?= asset('js/home-scroll.js') ?>" defer></script>

<?php
$content = ob_get_clean();
require_once 'layout.php';
?>