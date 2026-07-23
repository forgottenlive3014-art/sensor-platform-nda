<?php
$title = $title ?? 'Inundaciones - NDA';
$user = $user ?? null;
$currentSlug = 'inundaciones';
$extraCss = ['css/desastres-base.css', 'css/inundaciones.css'];
ob_start();
?>

<div class="dis-page dis-inundaciones">
<!-- BIG BANNER -->
<section class="dis-bigbanner" style="background-image:url('https://commons.wikimedia.org/wiki/Special:FilePath/Lo%20que%20dejo%20a%20su%20paso%20el%20huracan%20Ida%20(7%2C8%20Noviembre%202009)%20Playa%20de%20Las%20Hojas.%20-%20panoramio.jpg')">
  <div class="dis-bigbanner-overlay"></div>
  <div class="wrap dis-bigbanner-inner">
    <h2 class="dis-bigbanner-word">inundaciones</h2>
    <div class="dis-bigbanner-sub">
      <span class="dis-bigbanner-rule"></span>
      <div>
        <h3>¿Cómo se producen las inundaciones?</h3>
        <p>Las lluvias intensas saturan el suelo y superan la capacidad de ríos y quebradas, que se desbordan sobre zonas normalmente secas.</p>
        <a href="#info-general" class="dis-bigbanner-btn">Aprender más</a>
      </div>
    </div>
  </div>
  <a href="#info-general" class="scroll-hint"><span>Scroll</span><div class="sh-arr"></div></a>
</section>

<section class="dis-hero">
  <div class="dis-particles" id="inundacionesParticles" aria-hidden="true"></div>
  <div class="wrap">
    <div class="dis-hero-icon">I</div>
    <div class="sec-hd" style="text-align:left;margin:0;">
      <div class="sec-eyebrow">Temporada de lluvias · El Salvador</div>
      <h1 class="sec-title">Inundaciones: cuando el <span class="acc">agua no tiene a dónde ir</span></h1>
      <p class="sec-sub">Ríos cortos, de pendiente pronunciada, y ciudades con poco drenaje: la combinación que explica por qué El Salvador se inunda rápido.</p>
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
        <p>Ocurre cuando el volumen de agua supera la capacidad de un río, quebrada o del suelo para contenerla o absorberla, cubriendo áreas que normalmente están secas.</p>
      </div>
      <div class="dis-info-card">
        <h3>Causas</h3>
        <p>Lluvias intensas y prolongadas saturan el suelo; a partir de ahí, cada nuevo aguacero corre por la superficie en vez de infiltrarse, haciendo crecer ríos y quebradas hasta desbordarlos.</p>
      </div>
      <div class="dis-info-card">
        <h3>Tipos</h3>
        <p><strong>Fluviales</strong> (un río se desborda tras días de lluvia), <strong>repentinas o "flash floods"</strong> (quebradas que crecen en minutos por lluvia cercana) y <strong>urbanas</strong> (el agua no drena por falta de infraestructura pluvial).</p>
      </div>
    </div>

    <h3 class="dis-subhead">Información de El Salvador</h3>
    <div class="dis-info-grid">
      <div class="dis-info-card">
        <h3>¿Por qué ocurre aquí?</h3>
        <p>Es un territorio pequeño y montañoso: los ríos recorren poca distancia con mucha pendiente, así que suben muy rápido. Sumado a eso, la alta densidad urbana reduce la infiltración natural del agua.</p>
      </div>
      <div class="dis-info-card">
        <h3>Temporada lluviosa</h3>
        <p>La temporada de lluvias va de mayo a noviembre, con el mayor riesgo entre septiembre y octubre, cuando el suelo ya está saturado por meses de lluvia acumulada y cualquier sistema tropical adicional puede desbordar ríos rápidamente.</p>
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
      <div class="dis-zone-chip"><span class="dot"></span>Bajo Lempa (Usulután / San Vicente)</div>
      <div class="dis-zone-chip"><span class="dot"></span>Cuenca del río Acelhuate, San Salvador</div>
      <div class="dis-zone-chip"><span class="dot"></span>Ciudad Delgado y zonas bajas de Mejicanos</div>
      <div class="dis-zone-chip"><span class="dot"></span>Bajo Río Grande de San Miguel</div>
      <div class="dis-zone-chip"><span class="dot"></span>Zonas costeras con desembocaduras de ríos</div>
    </div>
  </div>
</section>

<!-- RIESGOS -->
<section class="sec">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Consecuencias</div>
      <h2 class="sec-title">Riesgos de una <span class="acc">inundación</span></h2>
    </div>
    <div class="dis-impact-grid">
      <div class="dis-impact-card"><h4>Pérdida de cosechas</h4><p>Los cultivos de subsistencia en zonas bajas son de los más afectados por cada temporada de lluvia.</p></div>
      <div class="dis-impact-card"><h4>Viviendas anegadas</h4><p>Comunidades enteras quedan bajo agua, muchas veces con pérdida total de enseres.</p></div>
      <div class="dis-impact-card"><h4>Enfermedades</h4><p>El agua estancada aumenta el riesgo de dengue, leptospirosis y enfermedades gastrointestinales.</p></div>
      <div class="dis-impact-card"><h4>Vías interrumpidas</h4><p>Puentes y carreteras quedan bajo agua o dañados, aislando comunidades por días.</p></div>
    </div>
  </div>
</section>

<!-- ESCALA DE ALERTAS -->
<section class="sec sec-dark">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Sistema oficial</div>
      <h2 class="sec-title">Escala de <span class="acc">alertas</span></h2>
      <p class="sec-sub">Los 4 niveles con los que Protección Civil clasifica una amenaza de inundación en desarrollo</p>
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
          <li>Averigua si tu vivienda está en una zona con historial de inundación.</li>
          <li>Sube documentos importantes y electrodomésticos a partes altas de la casa antes de que suba el agua.</li>
          <li>Sigue las alertas del MARN y Protección Civil, especialmente en alerta naranja o roja.</li>
        </ul>
      </div>
      <div class="dis-action-col">
        <div class="dis-action-hd">Durante</div>
        <ul>
          <li>Nunca cruces una corriente de agua: 30 cm pueden arrastrar a una persona, 60 cm a un vehículo.</li>
          <li>Desconecta la electricidad de tu vivienda si el agua empieza a subir.</li>
          <li>Muévete a un punto alto y espera ayuda; no intentes cruzar puentes inundados.</li>
        </ul>
      </div>
      <div class="dis-action-col">
        <div class="dis-action-hd">Después</div>
        <ul>
          <li>No bebas agua de la llave sin hervirla o tratarla hasta confirmación oficial.</li>
          <li>Evita el contacto directo con aguas estancadas: pueden estar contaminadas.</li>
          <li>Reporta daños a Protección Civil y revisa la estructura de tu vivienda antes de reingresar.</li>
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
      <h2 class="sec-title">Inundaciones que <span class="acc">marcaron</span> al país</h2>
    </div>
    <div class="tl-wrap"><div class="tl-line"></div><div class="tl-track" id="tlTrack-inundaciones"></div></div>
    <div class="tl-detail" id="tlDetail-inundaciones"></div>
  </div>
</section>
<script>
document.addEventListener('DOMContentLoaded', function () {
    ndaInitDisParticles('inundacionesParticles', 'inundaciones');
    ndaInitTimeline('inundaciones', [
        { year: '1998', title: 'Huracán Mitch', badge: 'Histórico', region: 'Todo El Salvador',
          desc: 'Uno de los huracanes más devastadores de la historia centroamericana; sus lluvias provocaron inundaciones y deslaves masivos en todo El Salvador.',
          tags: [{ t: 'Histórico', c: '' }],
          stats: [{ v: '1998', l: 'Año' }],
          img: 'assets/media/desastres/inundaciones/1998-mitch.jpg' },
        { year: '2009', title: 'Tormenta tropical Ida', badge: '198 muertos', region: 'San Vicente, San Miguel',
          desc: 'El 8 de noviembre de 2009 dejó lluvias acumuladas de más de 400 mm en algunas zonas, el río Grande de San Miguel se desbordó y un deslave en San Vicente sepultó a decenas de personas.',
          tags: [{ t: '198 muertos', c: 'r' }, { t: '15,000 damnificados', c: 'o' }],
          stats: [{ v: '198', l: 'Fallecidos' }, { v: '15,000', l: 'Damnificados' }, { v: '2009', l: 'Año' }],
          img: 'https://commons.wikimedia.org/wiki/Special:FilePath/Lo%20que%20dejo%20a%20su%20paso%20el%20huracan%20Ida%20(7%2C8%20Noviembre%202009)%20Playa%20de%20Las%20Hojas.%20-%20panoramio%20(3).jpg' },
        { year: '2011', title: 'Depresión Tropical 12-E', badge: '34 muertos', region: 'Zona central',
          desc: 'En octubre de 2011 dejó acumulados de más de 500 mm en 48 horas, con 34 muertos y 50,000 damnificados en la zona central del país.',
          tags: [{ t: '34 muertos', c: 'r' }],
          stats: [{ v: '34', l: 'Fallecidos' }, { v: '50,000', l: 'Damnificados' }, { v: '2011', l: 'Año' }],
          img: 'assets/media/desastres/inundaciones/2011-dt12e.jpg' },
        { year: '2020', title: 'Tormentas Amanda y Cristóbal', badge: '31 muertos', region: 'San Salvador, La Libertad, Cuscatlán',
          desc: 'Golpearon en plena pandemia de COVID-19: Amanda dejó 31 muertos y más de 7,000 personas en albergues; Cristóbal prolongó la emergencia días después.',
          tags: [{ t: '31 muertos', c: 'r' }, { t: 'Pandemia', c: 't' }],
          stats: [{ v: '31', l: 'Fallecidos' }, { v: '7,000', l: 'Albergados' }, { v: '2020', l: 'Año' }],
          img: 'assets/media/desastres/inundaciones/2020-amanda.jpg' }
    ]);
});
</script>

<!-- GALERIA -->
<section class="sec">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Multimedia</div>
      <h2 class="sec-title">Galería de <span class="acc">imágenes</span></h2>
      <p class="sec-sub">Espacio reservado para fotografías de zonas inundables y ríos monitoreados</p>
    </div>
    <?php $galleryItems = [
        ['img' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Lo%20que%20dejo%20a%20su%20paso%20el%20huracan%20Ida%20(7%2C8%20Noviembre%202009)%20Playa%20de%20Las%20Hojas.%20-%20panoramio.jpg', 'cap' => 'Playa de Las Hojas tras el huracán Ida (2009), El Salvador', 'credit' => 'Wikimedia Commons'],
        ['img' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Lo%20que%20dejo%20a%20su%20paso%20el%20huracan%20Ida%20(7%2C8%20Noviembre%202009)%20Playa%20de%20Las%20Hojas.%20-%20panoramio%20(1).jpg', 'cap' => 'Daños del huracán Ida en la costa salvadoreña (2009)', 'credit' => 'Wikimedia Commons'],
        ['img' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Murchison%20Goulburn%20River%20Height%20Gauge.JPG', 'cap' => 'Estación hidrométrica de nivel de río (referencial, no de El Salvador)', 'credit' => 'Wikimedia Commons'],
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
