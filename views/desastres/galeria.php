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
// Se aplica como background-image inline directo (NO como custom property
// --sk-bg-img consumida via var() en el CSS externo): un url() dentro de
// una custom property se resuelve relativo a la hoja de estilos donde se
// USA el var(), no relativo a esta pagina -- con --sk-bg-img el navegador
// buscaba la foto en assets/css/assets/media/img/... y nunca la encontraba,
// por eso no salian las imagenes de fondo en el carrusel.
$modelos = [
    [
        'slug' => 'sismos', 'accent' => '#c98a3d', 'nombre' => 'Sismos',
        'desc' => 'La subducción de la Placa de Cocos bajo la Placa del Caribe libera energía acumulada en forma de ondas sísmicas que hacen vibrar el suelo.',
        'riesgo' => 'El país está sobre el límite entre la Placa de Cocos y la Placa del Caribe, una de las zonas de subducción más activas del mundo.',
        'bg' => 'assets/media/img/SISMOS2.png',
    ],
    [
        'slug' => 'volcanes', 'accent' => '#e0631f', 'nombre' => 'Volcanes',
        'desc' => 'El magma acumulado bajo la corteza terrestre busca salida hacia la superficie cuando la presión supera la resistencia de la roca que lo cubre.',
        'riesgo' => 'El país está sobre el límite entre la Placa de Cocos y la Placa del Caribe, con 6 volcanes activos monitoreados por MARN.',
        'bg' => 'assets/media/img/volcan.jpg',
    ],
    [
        'slug' => 'tsunamis', 'accent' => '#1f7aa8', 'nombre' => 'Tsunamis',
        'desc' => 'Un sismo submarino desplaza verticalmente el fondo marino, moviendo toda la columna de agua sobre él en forma de olas de gran longitud.',
        'riesgo' => 'Toda la costa está frente a la zona de subducción Cocos–Caribe, la misma falla que genera los sismos más fuertes del país.',
        'bg' => 'assets/media/img/tsunamiV.webp',
    ],
    [
        'slug' => 'inundaciones', 'accent' => '#2e7da6', 'nombre' => 'Inundaciones',
        'desc' => 'Las lluvias intensas saturan el suelo y superan la capacidad de ríos y quebradas, que se desbordan sobre zonas normalmente secas.',
        'riesgo' => 'Territorio pequeño y montañoso: los ríos recorren poca distancia con mucha pendiente, así que suben muy rápido.',
    ],
    [
        'slug' => 'deslizamientos', 'accent' => '#7a6a4a', 'nombre' => 'Deslizamientos',
        'desc' => 'Movimiento de masas de tierra, roca o escombros ladera abajo bajo la influencia de la gravedad.',
        'riesgo' => 'El principal detonante son las lluvias intensas y la actividad sísmica, combinadas con laderas empinadas.',
        'bg' => 'assets/media/img/deslizamientoTierra.jpg',
    ],
    [
        'slug' => 'incendios-forestales', 'accent' => '#d9481f', 'nombre' => 'Incendios forestales',
        'desc' => 'Combustible seco, calor y una fuente de ignición: en El Salvador, casi siempre una quema agrícola mal manejada.',
        'riesgo' => 'Estación seca (noviembre–abril): altas temperaturas, baja humedad y quema de rastrojos para preparar tierra de cultivo.',
    ],
    [
        'slug' => 'tormentas-tropicales', 'accent' => '#4a6fa5', 'nombre' => 'Tormentas tropicales',
        'desc' => 'Se forma sobre aguas oceánicas cálidas: la evaporación alimenta de energía al sistema y la rotación de la Tierra organiza los vientos en espiral.',
        'riesgo' => 'Recibe sistemas formados en el Pacífico y remanentes del Atlántico/Caribe, sobre todo en temporada oficial (mayo–noviembre).',
    ],
    [
        'slug' => 'sequias', 'accent' => '#b8862e', 'nombre' => 'Sequías',
        'desc' => 'Un déficit prolongado de lluvia respecto al patrón normal reduce el agua disponible para consumo, agricultura y ecosistemas.',
        'riesgo' => 'El oriente del país forma parte del Corredor Seco Centroamericano, una franja con lluvias más irregulares.',
    ],
];

ob_start();
?>

<div class="dis-page">
<!-- HERO 3D: info a un lado, carrusel "coverflow" con escena Three.js al otro -->
<section class="sk3d-hero" id="sk3dHero">
  <div class="sk3d-hero-photo" id="sk3dHeroPhoto" aria-hidden="true"<?= !empty($modelos[0]['bg']) ? ' style="background-image:url(\'' . e($modelos[0]['bg']) . '\')"' : '' ?>></div>
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
            <div class="sk3d-slide<?= $i === 0 ? ' active' : '' ?>" data-index="<?= $i ?>" data-slug="<?= e($m['slug']) ?>" data-nombre="<?= e($m['nombre']) ?>" data-bg="<?= e($m['bg'] ?? '') ?>" style="--sk-accent:<?= e($m['accent']) ?>" onclick="sk3dGoTo(<?= $i ?>)">
              <div class="sk3d-slide-caption">
                <span class="sk3d-slide-name"><?= e($m['nombre']) ?></span>
              </div>
              <div class="sk3d-slide-viewport">
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

</div>

<script type="module" src="<?= asset('js/disaster3d.js') ?>"></script>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout.php';
?>
