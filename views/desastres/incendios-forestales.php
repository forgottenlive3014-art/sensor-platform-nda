<?php
$title = $title ?? 'Incendios Forestales - NDA';
$user = $user ?? null;
$currentSlug = 'incendios-forestales';
$extraCss = ['css/desastres-base.css', 'css/incendios-forestales.css'];
ob_start();
?>

<div class="dis-page dis-incendios">
<!-- BIG BANNER -->
<section class="dis-bigbanner" style="background-image:url('https://commons.wikimedia.org/wiki/Special:FilePath/Incendie%20de%20Landiras%2016%20juillet%202022.jpg')">
  <div class="dis-bigbanner-overlay"></div>
  <div class="wrap dis-bigbanner-inner">
    <h2 class="dis-bigbanner-word">Incendios</h2>
    <div class="dis-bigbanner-sub">
      <span class="dis-bigbanner-rule"></span>
      <div>
        <h3>¿Cómo se produce un incendio forestal?</h3>
        <p>Combustible seco, calor y una fuente de ignición: en El Salvador, casi siempre una quema agrícola mal manejada.</p>
        <a href="#info-general" class="dis-bigbanner-btn">Aprender más</a>
      </div>
    </div>
  </div>
  <a href="#info-general" class="scroll-hint"><span>Scroll</span><div class="sh-arr"></div></a>
</section>

<section class="dis-hero">
  <div class="dis-particles" id="incendiosParticles" aria-hidden="true"></div>
  <div class="wrap">
    <div class="dis-hero-icon">I</div>
    <div class="sec-hd" style="text-align:left;margin:0;">
      <div class="sec-eyebrow">Estación seca · El Salvador</div>
      <h1 class="sec-title">Incendios forestales: el riesgo que <span class="acc">encendemos nosotros mismos</span></h1>
      <p class="sec-sub">La gran mayoría de los incendios forestales en El Salvador tienen origen humano. Conocer la causa es el primer paso para prevenirlos.</p>
    </div>
    <?php include __DIR__ . '/_quicknav.php'; ?>
  </div>
</section>

<!-- INFORMACION GENERAL -->
<section class="sec" id="info-general">
  <div class="wrap">
    <h3 class="dis-subhead">Información general</h3>
    <div class="dis-info-grid">
      <div class="dis-info-card">
        <h3>¿Qué es?</h3>
        <p>Un incendio forestal es un fuego no controlado que se propaga sobre vegetación: bosques, matorrales, potreros o cañales, sin que exista una barrera natural o humana que lo detenga a tiempo.</p>
      </div>
      <div class="dis-info-card">
        <h3>Causas</h3>
        <p>Se necesitan tres elementos: combustible (hojarasca, pasto seco), condiciones cálidas y secas que favorezcan su propagación, y una fuente de ignición. En el país, la mayoría son provocados por quemas agrícolas mal manejadas, fogatas o colillas de cigarro.</p>
      </div>
      <div class="dis-info-card">
        <h3>Prevención</h3>
        <p>Evitar quemas agrícolas y fogatas en época seca, mantener rondas cortafuego alrededor de áreas naturales, y reportar humo sospechoso apenas se detecta.</p>
      </div>
    </div>

    <h3 class="dis-subhead">Información de El Salvador</h3>
    <div class="dis-info-grid">
      <div class="dis-info-card">
        <h3>Época seca</h3>
        <p>La estación seca (noviembre a abril) trae altas temperaturas y baja humedad, justo cuando es más común la quema de rastrojos para preparar tierra de cultivo o cosechar caña de azúcar, una práctica muy extendida en el país.</p>
      </div>
    </div>
  </div>
</section>

<!-- ZONAS VULNERABLES -->
<section class="sec sec-dark">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Mapa de Riesgo</div>
      <h2 class="sec-title">Zonas más <span class="acc">propensas</span></h2>
    </div>
    <div class="dis-zones">
      <div class="dis-zone-chip"><span class="dot"></span>Parque Nacional El Imposible, Ahuachapán</div>
      <div class="dis-zone-chip"><span class="dot"></span>Parque de Los Volcanes (Cerro Verde, Izalco, Santa Ana)</div>
      <div class="dis-zone-chip"><span class="dot"></span>Bosque de Montecristo (Trifinio)</div>
      <div class="dis-zone-chip"><span class="dot"></span>Cordillera del Bálsamo</div>
      <div class="dis-zone-chip"><span class="dot"></span>Zonas cañeras de la costa</div>
    </div>
  </div>
</section>

<!-- RIESGOS -->
<section class="sec">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Consecuencias</div>
      <h2 class="sec-title">Riesgos de un <span class="acc">incendio forestal</span></h2>
    </div>
    <div class="dis-impact-grid">
      <div class="dis-impact-card"><h4>Pérdida de bosque</h4><p>Áreas naturales protegidas tardan años o décadas en recuperar su cobertura original.</p></div>
      <div class="dis-impact-card"><h4>Daño a fauna</h4><p>Especies que no logran escapar a tiempo mueren o pierden su hábitat.</p></div>
      <div class="dis-impact-card"><h4>Suelo más erosionable</h4><p>Sin cobertura vegetal, la siguiente temporada de lluvia trae más riesgo de deslizamientos e inundación.</p></div>
      <div class="dis-impact-card"><h4>Mala calidad del aire</h4><p>El humo afecta la salud respiratoria de comunidades cercanas, incluso a varios kilómetros.</p></div>
    </div>
  </div>
</section>

<!-- ESCALA DE ALERTAS -->
<section class="sec sec-dark">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Sistema oficial</div>
      <h2 class="sec-title">Escala de <span class="acc">alertas</span></h2>
      <p class="sec-sub">Los 4 niveles con los que Protección Civil clasifica una amenaza de incendio forestal en desarrollo</p>
    </div>
    <?php include __DIR__ . '/_alert_levels.php'; ?>
  </div>
</section>

<!-- ANTES / DURANTE / DESPUES -->
<section class="sec">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Protocolo</div>
      <h2 class="sec-title">¿Qué hacer <span class="acc">antes, durante y después</span>?</h2>
    </div>
    <div class="dis-actions">
      <div class="dis-action-col">
        <div class="dis-action-hd">Antes</div>
        <ul>
          <li>No hagas quemas agrícolas ni fogatas en época seca, sobre todo con viento.</li>
          <li>Si vas a hacer una quema controlada y autorizada, ten una ronda cortafuego y agua cerca.</li>
          <li>Reporta humo sospechoso a Cuerpo de Bomberos o al MARN lo antes posible.</li>
        </ul>
      </div>
      <div class="dis-action-col">
        <div class="dis-action-hd">Durante</div>
        <ul>
          <li>Aléjate en dirección contraria al viento y cuesta abajo del fuego, nunca cuesta arriba.</li>
          <li>Cúbrete nariz y boca con tela húmeda para reducir la inhalación de humo.</li>
          <li>No intentes combatir un incendio grande por tu cuenta: llama a Bomberos de inmediato.</li>
        </ul>
      </div>
      <div class="dis-action-col">
        <div class="dis-action-hd">Después</div>
        <ul>
          <li>Evita caminar por zonas recién quemadas: los árboles debilitados pueden caer.</li>
          <li>Apoya o participa en jornadas de reforestación de las áreas afectadas.</li>
          <li>Denuncia quemas agrícolas ilegales que veas en tu comunidad.</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- MEMORIA HISTORICA -->
<section class="sec sec-dark">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Memoria histórica</div>
      <h2 class="sec-title">Un riesgo <span class="acc">estacional recurrente</span></h2>
    </div>
    <div class="tl-wrap"><div class="tl-line"></div><div class="tl-track" id="tlTrack-incendios"></div></div>
    <div class="tl-detail" id="tlDetail-incendios"></div>
  </div>
</section>
<script>
document.addEventListener('DOMContentLoaded', function () {
    ndaInitDisParticles('incendiosParticles', 'incendios');
    ndaInitTimeline('incendios', [
        { year: 'Nov–Abr', title: 'Temporada de incendios forestales', badge: 'Recurrente cada año', region: 'El Imposible, Los Volcanes, Montecristo',
          desc: 'El MARN y el Cuerpo de Bomberos registran cientos de conatos e incendios forestales cada estación seca, concentrados en áreas naturales protegidas. La mayoría se originan por quemas agrícolas.',
          tags: [{ t: 'Estacional', c: 'o' }, { t: 'Origen humano', c: 't' }],
          stats: [{ v: 'Nov–Abr', l: 'Temporada' }],
          img: 'assets/media/desastres/incendios/temporada.jpg' }
    ]);
});
</script>

<!-- GALERIA -->
<section class="sec">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Multimedia</div>
      <h2 class="sec-title">Galería de <span class="acc">imágenes</span></h2>
      <p class="sec-sub">Espacio reservado para fotografías de áreas naturales afectadas y labores de control</p>
    </div>
    <?php $galleryItems = [
        ['img' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Forest%20fires.jpg', 'cap' => 'Incendio forestal en época seca (referencial, no de El Salvador)', 'credit' => 'Wikimedia Commons'],
        ['img' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Wildland%20firefighters%20for%20the%20Gila%20District%20(27783853537).jpg', 'cap' => 'Cuadrilla de bomberos forestales (referencial, no de El Salvador)', 'credit' => 'Wikimedia Commons'],
        ['img' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Bosque%20interior%20Parque%20Nacional%20Montecristo%2001.JPG', 'cap' => 'Bosque del Parque Nacional Montecristo, El Salvador', 'credit' => 'Wikimedia Commons'],
    ]; include __DIR__ . '/_gallery.php'; ?>
  </div>
</section>

<!-- FUENTES -->
<section class="sec sec-dark">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Transparencia</div>
      <h2 class="sec-title">Fuentes <span class="acc">oficiales</span> consultadas</h2>
    </div>
    <div class="dis-sources">
      <a class="dis-source-item" href="https://www.snet.gob.sv/" target="_blank">MARN — DGOA/SNET, Observatorio de Amenazas</a>
      <a class="dis-source-item" href="https://www.proteccioncivil.gob.sv/" target="_blank">Dirección General de Protección Civil</a>
    </div>
    <p style="text-align:center;margin-top:24px">
      <a href="?url=home#zona-sismica" class="btn-out">← Ver mapa de peligros</a>
    </p>
  </div>
</section>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout.php';
?>
