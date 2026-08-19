<?php
$title = $title ?? 'Desastres - NDA';
$user = $user ?? null;
$currentSlug = 'galeria-3d';
$extraCss = ['css/desastres-base.css', 'css/galeria-3d.css'];

// Una escena 3D generada con Three.js (sin depender de Sketchfab) por tipo
// de desastre. Se montan solas, sin necesidad de darle clic a nada: el
// carrusel del hero monta la escena del modelo activo en cuanto se centra
// (ver sk3dRender en assets/js/app.js), y las tarjetas de la grilla de abajo
// se montan automaticamente en cuanto entran en pantalla al hacer scroll
// (ver initAutoMount3D en assets/js/app.js, usa IntersectionObserver para no
// abrir los 11 visores WebGL de golpe). window.NDA_Disaster3D vive en
// assets/js/disaster3d.js.
//
// 'infoUrl' es opcional: para los desastres que ya tienen su propia pagina
// completa (?url=<slug>, ver index.php) se omite y el enlace usa el slug.
// Los 3 tipos agregados despues (lahares, tormentas-electricas,
// erosion-costera) todavia no tienen una pagina propia, asi que su enlace
// "Ver información completa" apunta a la pagina existente mas relacionada.
//
// Los modelos 3D reales (.glb) viven en assets/modelos3d/ y se cargan desde
// assets/js/disaster3d.js (ver MODEL_FILES ahi) -- volcanes y deslizamientos
// ya tienen modelo real; el resto usa la escena procedural de respaldo
// hasta que se agregue uno. Ver el README en esa carpeta.
// 'bg': foto local de fondo detras de la escena 3D (el canvas ahora se monta
// transparente, ver disaster3d.js). Solo se agrega en los tipos que ya
// tienen una foto propia en assets/media/img/ -- el resto se queda con el
// degradado de acento de siempre para no depender de imagenes externas.
$modelos = [
    [
        'slug' => 'sismos', 'accent' => '#c98a3d', 'nombre' => 'Sismos',
        'desc' => 'Visualización 3D de edificios vibrando sobre el terreno durante un sismo.',
        'riesgo' => 'El Salvador está sobre el Cinturón de Fuego del Pacífico: es el país con más sismos por km² de Centroamérica.',
        'bg' => 'assets/media/img/SISMOS2.png',
    ],
    [
        'slug' => 'volcanes', 'accent' => '#e0631f', 'nombre' => 'Volcanes',
        'desc' => 'Visualización 3D de un cono volcánico con cráter incandescente y ceniza en el aire.',
        'riesgo' => '26 volcanes recorren el territorio; el Izalco y el Chaparrastique son los de mayor actividad histórica reciente.',
        'bg' => 'assets/media/img/volcan.jpg',
    ],
    [
        'slug' => 'tsunamis', 'accent' => '#1f7aa8', 'nombre' => 'Tsunamis',
        'desc' => 'Visualización 3D de oleaje avanzando con espuma marina.',
        'riesgo' => 'Toda la costa del Pacífico salvadoreño está en zona de riesgo por sismos submarinos frente a la fosa Mesoamericana.',
        'bg' => 'assets/media/img/tsunamiV.webp',
    ],
    [
        'slug' => 'inundaciones', 'accent' => '#2e7da6', 'nombre' => 'Inundaciones',
        'desc' => 'Visualización 3D de una zona urbana con el nivel del agua subiendo entre las viviendas.',
        'riesgo' => 'La Cuenca Baja del Río Lempa y el Bajo Lempa son las zonas más golpeadas en cada temporada lluviosa.',
    ],
    [
        'slug' => 'deslizamientos', 'accent' => '#7a6a4a', 'nombre' => 'Deslizamientos',
        'desc' => 'Visualización 3D de una ladera con rocas y sedimento deslizándose pendiente abajo.',
        'riesgo' => 'Las laderas del volcán de San Salvador y la Cordillera del Bálsamo concentran el mayor historial de deslaves.',
        'bg' => 'assets/media/img/deslizamientoTierra.jpg',
    ],
    [
        'slug' => 'incendios-forestales', 'accent' => '#d9481f', 'nombre' => 'Incendios forestales',
        'desc' => 'Visualización 3D de un bosque con brasas y humo ascendiendo entre los árboles.',
        'riesgo' => 'La estación seca (nov.–abr.) dispara los incendios por quemas agrícolas mal manejadas cerca de áreas protegidas.',
    ],
    [
        'slug' => 'tormentas-tropicales', 'accent' => '#4a6fa5', 'nombre' => 'Tormentas tropicales',
        'desc' => 'Visualización 3D de la espiral de nubes de un ciclón tropical vista desde arriba.',
        'riesgo' => 'Tormentas como Ida (2009), Ágatha (2010) e Iota-Eta (2020) dejaron algunas de las peores inundaciones recientes.',
    ],
    [
        'slug' => 'sequias', 'accent' => '#b8862e', 'nombre' => 'Sequías',
        'desc' => 'Visualización 3D de suelo agrietado con vegetación seca y calor en el ambiente.',
        'riesgo' => 'El Corredor Seco (La Unión, Morazán, San Miguel) sufre pérdidas de cosecha casi cada año por déficit de lluvia.',
    ],
];

ob_start();
?>

<div class="dis-page">
<!-- HERO 3D: info a un lado, carrusel "coverflow" con escena Three.js al otro -->
<section class="sk3d-hero" id="sk3dHero">
  <div class="sk3d-hero-bg" id="sk3dHeroBg" aria-hidden="true" style="--sk-accent:<?= e($modelos[0]['accent']) ?>"></div>

  <div class="wrap sk3d-hero-inner">
    <div class="sk3d-index-rail" aria-hidden="true">
      <span class="sk3d-index-total">01</span>
      <span class="sk3d-index-line"></span>
      <span class="sk3d-index-circle" id="sk3dIndexCircle">1</span>
      <span class="sk3d-index-total">0<?= count($modelos) ?></span>
    </div>

    <div class="sk3d-hero-info">
      <div class="sk3d-eyebrow">Amenazas Naturales · El Salvador</div>

      <div class="sk3d-stepper" id="sk3dStepper">
        <div class="sk3d-step-name prev" id="sk3dStepPrev"></div>
        <h1 class="sk3d-step-name active" id="sk3dStepActive">Desastres</h1>
        <div class="sk3d-step-name next" id="sk3dStepNext"></div>
      </div>

      <div class="sk3d-panel" id="sk3dPanel">
        <?php foreach ($modelos as $i => $m): ?>
        <div class="sk3d-panel-item<?= $i === 0 ? ' active' : '' ?>" data-index="<?= $i ?>" style="--sk-accent:<?= e($m['accent']) ?>">
          <p class="sk3d-panel-desc"><?= e($m['desc']) ?></p>
          <p class="sk3d-panel-riesgo"><strong>En El Salvador:</strong> <?= e($m['riesgo']) ?></p>
          <div class="sk3d-panel-actions">
            <a class="sk3d-link" href="?url=<?= e($m['infoUrl'] ?? $m['slug']) ?>">Ver información completa →</a>
          </div>
          <span class="sk3d-credit">Visualización 3D generada con Three.js</span>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="sk3d-hero-visual">
      <div class="sk3d-carousel">
        <button type="button" class="sk3d-arrow sk3d-arrow-prev" onclick="sk3dNav(-1)" aria-label="Modelo anterior">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        </button>

        <div class="sk3d-track-viewport" id="sk3dTrackViewport">
          <div class="sk3d-track" id="sk3dTrack">
            <?php foreach ($modelos as $i => $m): ?>
            <div class="sk3d-slide<?= $i === 0 ? ' active' : '' ?>" data-index="<?= $i ?>" data-slug="<?= e($m['slug']) ?>" data-nombre="<?= e($m['nombre']) ?>" style="--sk-accent:<?= e($m['accent']) ?>" onclick="sk3dGoTo(<?= $i ?>)">
              <div class="sk3d-slide-caption">
                <span class="sk3d-slide-name"><?= e($m['nombre']) ?></span>
              </div>
              <div class="sk3d-slide-viewport"<?= !empty($m['bg']) ? ' style="--sk-bg-img:url(\'' . e($m['bg']) . '\')"' : '' ?>>
                <div class="sk3d-placeholder">
                  <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
                </div>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>

        <button type="button" class="sk3d-arrow sk3d-arrow-next" onclick="sk3dNav(1)" aria-label="Modelo siguiente">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        </button>
      </div>

      <div class="sk3d-carousel-footer">
        <div class="sk3d-dots" id="sk3dDots">
          <?php foreach ($modelos as $i => $m): ?>
          <button type="button" class="sk3d-dot<?= $i === 0 ? ' active' : '' ?>" data-index="<?= $i ?>" onclick="sk3dGoTo(<?= $i ?>)" aria-label="Ir a <?= e($m['nombre']) ?>"></button>
          <?php endforeach; ?>
        </div>
        <div class="sk3d-counter">
          <span id="sk3dCounterActive">01</span>
          <span class="sk3d-counter-line"></span>
          <span>0<?= count($modelos) ?></span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- VISUALIZACIONES 3D: acceso directo a los 8 visores, uno por amenaza -->
<section class="sec">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Todos los modelos</div>
      <h2 class="sec-title">Explorá cada <span class="acc">amenaza</span> por separado</h2>
      <p class="sec-sub">La misma colección de arriba, en formato de tarjetas para abrir directamente el modelo que te interese.</p>
    </div>
    <div class="sk3d-grid">
      <?php foreach ($modelos as $m): ?>
      <div class="sk3d-card" style="--sk-accent:<?= e($m['accent']) ?>">
        <div class="sk3d-viewport nda-auto3d" data-slug="<?= e($m['slug']) ?>"<?= !empty($m['bg']) ? ' style="--sk-bg-img:url(\'' . e($m['bg']) . '\')"' : '' ?>>
          <div class="sk3d-placeholder">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
          </div>
        </div>
        <div class="sk3d-body">
          <h3><?= e($m['nombre']) ?></h3>
          <p><?= e($m['desc']) ?></p>
          <span class="sk3d-credit">Visualización 3D generada con Three.js</span>
          <a class="sk3d-link" href="?url=<?= e($m['infoUrl'] ?? $m['slug']) ?>">Ver información completa →</a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

</div>

<script type="module" src="<?= asset('js/disaster3d.js') ?>"></script>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout.php';
?>
