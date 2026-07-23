<?php
$title = $title ?? 'Volcanes - NDA';
$user = $user ?? null;
$currentSlug = 'volcanes';
$extraCss = ['css/desastres-base.css', 'css/volcanes.css'];
ob_start();
?>

<div class="dis-page dis-volcanes">
<!-- BIG BANNER -->
<section class="dis-bigbanner" style="background-image:url('https://commons.wikimedia.org/wiki/Special:FilePath/Eruption%20of%20Santa%20Ana%20(Ilamatepec)%20Volcano%20(15656).jpg')">
  <div class="dis-bigbanner-overlay"></div>
  <div class="wrap dis-bigbanner-inner">
    <h2 class="dis-bigbanner-word">volcanes</h2>
    <div class="dis-bigbanner-sub">
      <span class="dis-bigbanner-rule"></span>
      <div>
        <h3>¿Cómo se producen los volcanes?</h3>
        <p>El magma acumulado bajo la corteza terrestre busca salida hacia la superficie cuando la presión supera la resistencia de la roca que lo cubre.</p>
        <a href="#info-general" class="dis-bigbanner-btn">Aprender más</a>
      </div>
    </div>
  </div>
  <a href="#info-general" class="scroll-hint"><span>Scroll</span><div class="sh-arr"></div></a>
</section>

<section class="dis-hero">
  <div class="dis-particles" id="volcanesParticles" aria-hidden="true"></div>
  <div class="wrap">
    <div class="dis-hero-icon">V</div>
    <div class="sec-hd" style="text-align:left;margin:0;">
      <div class="sec-eyebrow">Vulcanología · El Salvador</div>
      <h1 class="sec-title">Volcanes: la otra cara de las <span class="acc">placas tectónicas</span></h1>
      <p class="sec-sub">El Salvador tiene más de 20 volcanes en su territorio, varios activos. Esto es lo que debes saber para convivir con ellos de forma segura.</p>
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
        <h3>¿Qué es un volcán?</h3>
        <p>Es una abertura en la corteza terrestre por donde el magma (roca fundida), gases y ceniza del interior de la Tierra salen hacia la superficie.</p>
      </div>
      <div class="dis-info-card">
        <h3>¿Cómo se produce una erupción?</h3>
        <p>El magma se acumula en una cámara bajo el volcán. La presión de los gases disueltos aumenta hasta vencer la resistencia de la roca que lo cubre, y el material sale expulsado como lava, ceniza, gases o fragmentos incandescentes (piroclastos).</p>
      </div>
      <div class="dis-info-card">
        <h3>Tipos de volcán</h3>
        <p>La mayoría de los volcanes salvadoreños son <strong>estratovolcanes</strong> (conos de lava y ceniza en capas). También existen calderas, formadas cuando un volcán colapsa sobre su propia cámara magmática vacía, como el lago de Ilopango o el de Coatepeque.</p>
      </div>
    </div>

    <h3 class="dis-subhead">Información de El Salvador</h3>
    <div class="dis-info-grid">
      <div class="dis-info-card">
        <h3>¿Por qué ocurre aquí?</h3>
        <p>El país forma parte de la <strong>Cadena Volcánica Centroamericana</strong>, producto de la subducción de la Placa de Cocos bajo la Placa del Caribe. Esa misma fricción que genera sismos también alimenta las cámaras magmáticas de nuestros volcanes.</p>
      </div>
      <div class="dis-info-card">
        <h3>Monitoreo (DGOA/SNET)</h3>
        <p>La vigilancia está a cargo de la <strong>Dirección General del Observatorio de Amenazas</strong> del MARN (antes SNET, absorbido en 2007). La red nació en 1983 con 11 estaciones y se amplió en 1991 a 22, con puntos dedicados a los volcanes de San Salvador e Ilopango. Desde 2011 opera el <strong>Centro Integrado de Monitoreo de Amenazas Naturales</strong>, que vigila volcanes, sismos, deslizamientos, ríos y clima las 24 horas.</p>
      </div>
    </div>
  </div>
</section>

<!-- VOLCANES ACTIVOS -->
<section class="sec sec-dark">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Mapa de Riesgo</div>
      <h2 class="sec-title">Volcanes <span class="acc">activos</span></h2>
      <p class="sec-sub">Los complejos volcánicos con mayor actividad o monitoreo permanente del MARN</p>
    </div>
    <div class="dis-zones">
      <div class="dis-zone-chip"><span class="dot"></span>Santa Ana / Ilamatepec (el más alto del país, 2,381 msnm)</div>
      <div class="dis-zone-chip"><span class="dot"></span>San Salvador / Boquerón — Quezaltepec</div>
      <div class="dis-zone-chip"><span class="dot"></span>San Miguel / Chaparrastique</div>
      <div class="dis-zone-chip"><span class="dot"></span>San Vicente / Chichontepec</div>
      <div class="dis-zone-chip"><span class="dot"></span>Izalco — "El Faro del Pacífico"</div>
      <div class="dis-zone-chip"><span class="dot"></span>Conchagua (La Unión)</div>
    </div>
  </div>
</section>

<!-- RIESGOS -->
<section class="sec">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Consecuencias</div>
      <h2 class="sec-title">Riesgos de una <span class="acc">erupción</span></h2>
    </div>
    <div class="dis-impact-grid">
      <div class="dis-impact-card"><h4>Caída de ceniza</h4><p>Afecta cultivos, techos, vías respiratorias y visibilidad a kilómetros del cráter.</p></div>
      <div class="dis-impact-card"><h4>Gases volcánicos</h4><p>El dióxido de azufre (SO₂) irrita ojos y pulmones, y daña cultivos de café cercanos.</p></div>
      <div class="dis-impact-card"><h4>Flujos piroclásticos</h4><p>Nubes de gas y roca a alta temperatura que descienden rápido por las laderas.</p></div>
      <div class="dis-impact-card"><h4>Lahares</h4><p>Coladas de lodo volcánico que bajan por quebradas, sobre todo con lluvia posterior a la erupción.</p></div>
    </div>
  </div>
</section>

<!-- ESCALA DE ALERTAS -->
<section class="sec sec-dark">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Sistema oficial</div>
      <h2 class="sec-title">Escala de <span class="acc">alertas</span></h2>
      <p class="sec-sub">Los 4 niveles con los que Protección Civil clasifica una amenaza volcánica en desarrollo</p>
    </div>
    <?php include __DIR__ . '/_alert_levels.php'; ?>
  </div>
</section>

<!-- ANTES / DURANTE / DESPUES -->
<section class="sec">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Protocolo</div>
      <h2 class="sec-title">Qué hacer <span class="acc">antes, durante y después</span></h2>
    </div>
    <div class="dis-actions">
      <div class="dis-action-col">
        <div class="dis-action-hd">Antes</div>
        <ul>
          <li>Conoce si vives dentro de la zona de exclusión de un volcán activo.</li>
          <li>Ten mascarillas N95 y lentes de protección en tu mochila de emergencia.</li>
          <li>Sigue los reportes de actividad del MARN, no rumores de redes sociales.</li>
        </ul>
      </div>
      <div class="dis-action-col">
        <div class="dis-action-hd">Durante</div>
        <ul>
          <li>Aléjate de ríos y quebradas: pueden bajar lahares aunque la erupción sea lejana.</li>
          <li>Cubre nariz y boca con mascarilla o tela húmeda ante la caída de ceniza.</li>
          <li>Evacúa de inmediato si Protección Civil lo indica; no esperes "ver" la lava.</li>
        </ul>
      </div>
      <div class="dis-action-col">
        <div class="dis-action-hd">Después</div>
        <ul>
          <li>Retira la ceniza de techos livianos: su peso acumulado puede colapsarlos.</li>
          <li>Revisa que el agua para consumo no esté contaminada con ceniza.</li>
          <li>Mantente atento a nuevas alertas: las erupciones pueden tener varias fases.</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- ERUPCIONES HISTORICAS -->
<section class="sec sec-dark">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Memoria histórica</div>
      <h2 class="sec-title">Erupciones que <span class="acc">marcaron</span> al país</h2>
    </div>
    <div class="tl-wrap"><div class="tl-line"></div><div class="tl-track" id="tlTrack-volcanes"></div></div>
    <div class="tl-detail" id="tlDetail-volcanes"></div>
  </div>
</section>
<script>
document.addEventListener('DOMContentLoaded', function () {
    ndaInitDisParticles('volcanesParticles', 'volcanes');
    ndaInitTimeline('volcanes', [
        { year: '1658', title: 'Nacimiento de El Playón', badge: 'Erupción efusiva', region: 'Volcán de San Salvador',
          desc: 'Una erupción prolongada (1658–1671) formó el campo de lava conocido como "El Playón", al norte de la capital.',
          tags: [{ t: 'Histórico', c: '' }, { t: 'San Salvador', c: 'o' }],
          stats: [{ v: '1658', l: 'Inicio' }, { v: '13 años', l: 'Duración' }, { v: 'Efusiva', l: 'Tipo' }],
          img: 'assets/media/desastres/volcanes/1658-el-playon.jpg' },
        { year: '1770', title: 'Izalco, "El Faro del Pacífico"', badge: '196 años activo', region: 'Volcán de Izalco',
          desc: 'Casi dos siglos de actividad casi continua (1770–1966) lo hicieron visible —y usado como referencia de navegación— desde el océano.',
          tags: [{ t: 'Histórico', c: '' }, { t: 'Izalco', c: 'o' }],
          stats: [{ v: '1770', l: 'Inicio' }, { v: '1966', l: 'Reposo' }, { v: '196', l: 'Años activo' }],
          img: 'https://commons.wikimedia.org/wiki/Special:FilePath/Faro%20del%20Pacifico.jpg' },
        { year: '2005', title: 'Erupción del Santa Ana (Ilamatepec)', badge: 'VEI 3', region: 'Volcán de Santa Ana',
          desc: 'El 1 de octubre de 2005 el volcán más alto del país entró en erupción, con una columna de ceniza de 10 km de altura y la evacuación de más de 2,000 personas.',
          tags: [{ t: 'Reciente', c: 't' }, { t: 'Santa Ana', c: 'o' }],
          stats: [{ v: '2,000', l: 'Evacuados' }, { v: '10 km', l: 'Columna de ceniza' }, { v: '2005', l: 'Año' }],
          img: 'https://commons.wikimedia.org/wiki/Special:FilePath/Eruption%20of%20Santa%20Ana%20(Ilamatepec)%20Volcano%20(15656).jpg' },
        { year: '2013', title: 'Erupción del Chaparrastique', badge: 'Explosiva', region: 'Volcán de San Miguel',
          desc: 'El volcán de San Miguel tuvo una erupción explosiva el 29 de diciembre de 2013, expulsando una columna de ceniza que obligó a evacuar comunidades cercanas.',
          tags: [{ t: 'Reciente', c: 't' }, { t: 'San Miguel', c: 'o' }],
          stats: [{ v: '2013', l: 'Año' }, { v: 'Explosiva', l: 'Tipo' }],
          img: 'https://commons.wikimedia.org/wiki/Special:FilePath/Vulkan%20Chaparrastique%2C%20El%20Salvador%202013%2002.JPG' }
    ]);
});
</script>

<!-- GALERIA -->
<section class="sec">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Multimedia</div>
      <h2 class="sec-title">Galería de <span class="acc">imágenes</span></h2>
      <p class="sec-sub">Espacio reservado para fotografías de los volcanes activos y estaciones de monitoreo</p>
    </div>
    <?php $galleryItems = [
        ['img' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Ilamatepec%20Lake.jpg', 'cap' => 'Lago cratérico del volcán de Santa Ana (Ilamatepec)', 'credit' => 'Wikimedia Commons'],
        ['img' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Faro%20del%20Pacifico.jpg', 'cap' => 'Volcán de Izalco — "El Faro del Pacífico"', 'credit' => 'Wikimedia Commons'],
        ['img' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Vulkan%20Chaparrastique%2C%20El%20Salvador%202013%2001.JPG', 'cap' => 'Erupción del volcán Chaparrastique, San Miguel (2013)', 'credit' => 'Wikimedia Commons'],
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
      <a class="dis-source-item" href="https://www.snet.gob.sv/ver/sismologia/vigilancia/" target="_blank">MARN — Vigilancia sísmica y volcánica</a>
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
