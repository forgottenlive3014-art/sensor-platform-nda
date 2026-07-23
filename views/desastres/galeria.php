<?php
$title = $title ?? 'Desastres en 3D - NDA';
$user = $user ?? null;
$currentSlug = 'galeria-3d';
$extraCss = ['css/desastres-base.css', 'css/galeria-3d.css'];

// Un modelo 3D real (Sketchfab, verificado y embebible) por tipo de
// desastre. Se cargan bajo demanda (boton "Reproducir"): abrir los 8
// visores WebGL a la vez haria la pagina muy pesada. El carrusel solo
// monta el iframe del modelo que esta activo en el centro.
$modelos = [
    [
        'slug' => 'sismos', 'accent' => '#c98a3d', 'nombre' => 'Sismos',
        'desc' => 'Simulación de la vibración del suelo durante un terremoto.',
        'riesgo' => 'El Salvador está sobre el Cinturón de Fuego del Pacífico: es el país con más sismos por km² de Centroamérica.',
        'uid' => 'af2cc67aacda48f4afd1abdc753a5238',
        'thumb' => 'https://media.sketchfab.com/models/af2cc67aacda48f4afd1abdc753a5238/thumbnails/07255ae365214f43b89d96d89b3a01e6/fddf055ca6924ff5aab537ddfa10f767.jpeg',
        'autor' => 'plankusgankus',
        'model_url' => 'https://sketchfab.com/3d-models/earthquake-animation-af2cc67aacda48f4afd1abdc753a5238',
    ],
    [
        'slug' => 'volcanes', 'accent' => '#e0631f', 'nombre' => 'Volcanes',
        'desc' => 'Una erupción volcánica con flujo de lava y columna de ceniza.',
        'riesgo' => '26 volcanes recorren el territorio; el Izalco y el Chaparrastique son los de mayor actividad histórica reciente.',
        'uid' => 'be87772bc84e4fc7970dc116ead8bd84',
        'thumb' => 'https://media.sketchfab.com/models/be87772bc84e4fc7970dc116ead8bd84/thumbnails/a0beadfba5c64e0f96ec0dd11e727c4f/da1894bfe0ae4bfdad49c355f821bf90.jpeg',
        'autor' => 'bororhan',
        'model_url' => 'https://sketchfab.com/3d-models/volcano-eruption-be87772bc84e4fc7970dc116ead8bd84',
    ],
    [
        'slug' => 'tsunamis', 'accent' => '#1f7aa8', 'nombre' => 'Tsunamis',
        'desc' => 'Una ola de tsunami avanzando hacia la costa.',
        'riesgo' => 'Toda la costa del Pacífico salvadoreño está en zona de riesgo por sismos submarinos frente a la fosa Mesoamericana.',
        'uid' => 'a58699fa796042db851dc8f1b29303c8',
        'thumb' => 'https://media.sketchfab.com/models/a58699fa796042db851dc8f1b29303c8/thumbnails/4fe3a18b9a5f4832a219488bee826513/e1dd6dca57ed4cff84fa07fd324da581.jpeg',
        'autor' => 'Matheus kobi',
        'model_url' => 'https://sketchfab.com/3d-models/tsunami-a58699fa796042db851dc8f1b29303c8',
    ],
    [
        'slug' => 'inundaciones', 'accent' => '#2e7da6', 'nombre' => 'Inundaciones',
        'desc' => 'Una escena de inundación con agua animada y escombros.',
        'riesgo' => 'La Cuenca Baja del Río Lempa y el Bajo Lempa son las zonas más golpeadas en cada temporada lluviosa.',
        'uid' => '43f78cc8060b42909b47398a954e5371',
        'thumb' => 'https://media.sketchfab.com/models/43f78cc8060b42909b47398a954e5371/thumbnails/95e13dabbdd942f792d0ca0c60d65766/a0dfade1e002407ca3795dc3608818bd.jpeg',
        'autor' => 'asern_afri',
        'model_url' => 'https://sketchfab.com/3d-models/flood-43f78cc8060b42909b47398a954e5371',
    ],
    [
        'slug' => 'deslizamientos', 'accent' => '#7a6a4a', 'nombre' => 'Deslizamientos',
        'desc' => 'Diorama de un deslizamiento de tierra sobre una ladera.',
        'riesgo' => 'Las laderas del volcán de San Salvador y la Cordillera del Bálsamo concentran el mayor historial de deslaves.',
        'uid' => '7e166ad368154712b14fcc7cdecfe2f4',
        'thumb' => 'https://media.sketchfab.com/models/7e166ad368154712b14fcc7cdecfe2f4/thumbnails/93e3b4c8dfa34161b27dc34dbe6ce6ae/83de5e7ea93748a78f61ad766be1bef2.jpeg',
        'autor' => 'ilhamsbi',
        'model_url' => 'https://sketchfab.com/3d-models/landslide-disaster-diorama-7e166ad368154712b14fcc7cdecfe2f4',
    ],
    [
        'slug' => 'incendios-forestales', 'accent' => '#d9481f', 'nombre' => 'Incendios forestales',
        'desc' => 'Animación de fuego en tiempo real.',
        'riesgo' => 'La estación seca (nov.–abr.) dispara los incendios por quemas agrícolas mal manejadas cerca de áreas protegidas.',
        'uid' => 'ebb16a3df22247dd990a04585de64741',
        'thumb' => 'https://media.sketchfab.com/models/ebb16a3df22247dd990a04585de64741/thumbnails/69a2e501e3ab4589bcc709b6f71905a0/0f3f7817d4954e1aaf773ae3fd2fa8ae.jpeg',
        'autor' => 'Yannick Deharo',
        'model_url' => 'https://sketchfab.com/3d-models/animated-fire-ebb16a3df22247dd990a04585de64741',
    ],
    [
        'slug' => 'tormentas-tropicales', 'accent' => '#4a6fa5', 'nombre' => 'Tormentas tropicales',
        'desc' => 'Modelo de un huracán / ciclón tropical.',
        'riesgo' => 'Tormentas como Ida (2009), Ágatha (2010) e Iota-Eta (2020) dejaron algunas de las peores inundaciones recientes.',
        'uid' => '4b3c66b3c2a04ebd91a12acc96345131',
        'thumb' => 'https://media.sketchfab.com/models/4b3c66b3c2a04ebd91a12acc96345131/thumbnails/19e92d531e654389a421c03cfc9d51cf/48cac2e09d8b42a89831ecaf15a65b31.jpeg',
        'autor' => 'REFODIGE',
        'model_url' => 'https://sketchfab.com/3d-models/huracan-3d-4b3c66b3c2a04ebd91a12acc96345131',
    ],
    [
        'slug' => 'sequias', 'accent' => '#b8862e', 'nombre' => 'Sequías',
        'desc' => 'Escaneo fotogramétrico real de suelo agrietado por sequía.',
        'riesgo' => 'El Corredor Seco (La Unión, Morazán, San Miguel) sufre pérdidas de cosecha casi cada año por déficit de lluvia.',
        'uid' => 'acf20f6eb25046658548b547c93038d8',
        'thumb' => 'https://media.sketchfab.com/models/acf20f6eb25046658548b547c93038d8/thumbnails/72b565d885aa49729450c41f0214643f/3fe0ed9e224940e9a05a62accd0fb8f4.jpeg',
        'autor' => 'matousekfoto',
        'model_url' => 'https://sketchfab.com/3d-models/drought-dry-soil-desert-cracks-ground-acf20f6eb25046658548b547c93038d8',
    ],
];

ob_start();
?>

<div class="dis-page">
<!-- HERO 3D: info a un lado, carrusel "coverflow" con modelo Sketchfab real al otro -->
<section class="sk3d-hero" id="sk3dHero">
  <div class="sk3d-hero-bg" aria-hidden="true"></div>

  <div class="wrap sk3d-hero-inner">
    <div class="sk3d-hero-info">
      <div class="sec-hd" style="text-align:left;margin:0 0 8px;">
        <h1 class="sec-title">Desastres en <span class="acc">3D</span></h1>
        <p class="sec-sub">Un modelo tridimensional real por cada amenaza — elegí uno y explorálo en 3D. Cortesía de la comunidad de Sketchfab.</p>
      </div>

      <div class="sk3d-panel" id="sk3dPanel">
        <?php foreach ($modelos as $i => $m): ?>
        <div class="sk3d-panel-item<?= $i === 0 ? ' active' : '' ?>" data-index="<?= $i ?>" style="--sk-accent:<?= e($m['accent']) ?>">
          <h3><?= e($m['nombre']) ?></h3>
          <p class="sk3d-panel-desc"><?= e($m['desc']) ?></p>
          <p class="sk3d-panel-riesgo"><strong>En El Salvador:</strong> <?= e($m['riesgo']) ?></p>
          <div class="sk3d-panel-actions">
            <button type="button" class="sk3d-play-btn" onclick="sk3dPlayActive()">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><polygon points="6 3 20 12 6 21 6 3"/></svg>
              Cargar modelo 3D
            </button>
            <a class="sk3d-link" href="?url=<?= e($m['slug']) ?>">Ver información completa →</a>
          </div>
          <span class="sk3d-credit">Modelo 3D: <a href="<?= e($m['model_url']) ?>" target="_blank" rel="noopener"><?= e($m['autor']) ?></a> vía Sketchfab</span>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="sk3d-hero-visual">
      <div class="sk3d-carousel">
        <button type="button" class="sk3d-arrow sk3d-arrow-prev" onclick="sk3dNav(-1)" aria-label="Modelo anterior">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        </button>

        <div class="sk3d-track" id="sk3dTrack">
          <?php foreach ($modelos as $i => $m): ?>
          <div class="sk3d-slide" data-index="<?= $i ?>" data-uid="<?= e($m['uid']) ?>" data-thumb="<?= e($m['thumb']) ?>" style="--sk-accent:<?= e($m['accent']) ?>" onclick="sk3dGoTo(<?= $i ?>)">
            <div class="sk3d-slide-viewport">
              <img src="<?= e($m['thumb']) ?>" alt="<?= e($m['nombre']) ?>" loading="lazy">
            </div>
            <div class="sk3d-slide-caption">
              <span class="sk3d-slide-name"><?= e($m['nombre']) ?></span>
            </div>
          </div>
          <?php endforeach; ?>
        </div>

        <button type="button" class="sk3d-arrow sk3d-arrow-next" onclick="sk3dNav(1)" aria-label="Modelo siguiente">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        </button>
      </div>

      <div class="sk3d-dots" id="sk3dDots">
        <?php foreach ($modelos as $i => $m): ?>
        <button type="button" class="sk3d-dot<?= $i === 0 ? ' active' : '' ?>" data-index="<?= $i ?>" onclick="sk3dGoTo(<?= $i ?>)" aria-label="Ir a <?= e($m['nombre']) ?>"></button>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- GRILLA: acceso rapido a los 8, con su propio visor bajo demanda -->
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
        <div class="sk3d-viewport" data-uid="<?= e($m['uid']) ?>">
          <img src="<?= e($m['thumb']) ?>" alt="<?= e($m['nombre']) ?>" loading="lazy">
          <button type="button" class="sk3d-play" onclick="loadSketchfabModel(this)" aria-label="Reproducir modelo 3D de <?= e($m['nombre']) ?>">
            <span class="sk3d-play-ico">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><polygon points="6 3 20 12 6 21 6 3"/></svg>
            </span>
            <span class="sk3d-play-lbl">Clic para cargar el modelo 3D</span>
          </button>
        </div>
        <div class="sk3d-body">
          <h3><?= e($m['nombre']) ?></h3>
          <p><?= e($m['desc']) ?></p>
          <span class="sk3d-credit">Modelo 3D: <a href="<?= e($m['model_url']) ?>" target="_blank" rel="noopener"><?= e($m['autor']) ?></a> vía Sketchfab</span>
          <a class="sk3d-link" href="?url=<?= e($m['slug']) ?>">Ver información completa →</a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout.php';
?>
