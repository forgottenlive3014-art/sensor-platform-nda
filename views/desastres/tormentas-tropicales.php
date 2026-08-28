<?php
$title = $title ?? 'Tormentas Tropicales - NDA';
$user = $user ?? null;
$currentSlug = 'tormentas-tropicales';
$extraCss = ['css/desastres-base.css', 'css/tormentas-tropicales.css'];
ob_start();
?>

<div class="dis-page dis-tormentas">
<!-- BIG BANNER -->
<section class="dis-bigbanner" style="background-image:url('https://commons.wikimedia.org/wiki/Special:FilePath/Hurricane%20Katrina%20as%20Seen%20from%20Space%20(20749127551).jpg')">
  <div class="dis-bigbanner-overlay"></div>
  <div class="wrap dis-bigbanner-inner">
    <h2 class="dis-bigbanner-word">Tormentas</h2>
    <div class="dis-bigbanner-sub">
      <span class="dis-bigbanner-rule"></span>
      <div>
        <h3>¿Cómo se forma una tormenta tropical?</h3>
        <p>Se forma sobre aguas oceánicas cálidas: la evaporación alimenta de energía al sistema y la rotación de la Tierra organiza los vientos en espiral.</p>
        <a href="#info-general" class="dis-bigbanner-btn">Aprender más</a>
      </div>
    </div>
  </div>
  <a href="#info-general" class="scroll-hint"><span>Scroll</span><div class="sh-arr"></div></a>
</section>

<!-- CONTEXTO RAPIDO -->
<section class="dis-context" style="background-image:url('https://commons.wikimedia.org/wiki/Special:FilePath/Hurricane%20Katrina%20as%20Seen%20from%20Space%20(20749127551).jpg')">
  <div class="dis-context-overlay"></div>
  <div class="wrap dis-context-inner">
    <div class="dis-context-hd">
      <span class="dis-context-eyebrow">El Salvador</span>
      <h2 class="dis-context-title">Fuera de la ruta directa, pero no fuera de riesgo</h2>
    </div>
    <div class="dis-context-cards">
      <div class="dis-context-card">
        <span class="dis-context-card-ico"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 16.2A4.5 4.5 0 0 0 17.5 8h-1.8A7 7 0 1 0 4 14.9"/></svg></span>
        <h4>¿Cómo se forma?</h4>
        <p>Sobre aguas oceánicas cálidas (+26°C): la evaporación aporta energía y la rotación terrestre organiza los vientos en espiral.</p>
      </div>
      <div class="dis-context-card">
        <span class="dis-context-card-ico"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M8 12l3 3 5-6"/></svg></span>
        <h4>Categoría más frecuente</h4>
        <p>Tormenta tropical (63–118 km/h): la que más ha golpeado al país en la última década.</p>
      </div>
      <div class="dis-context-card">
        <span class="dis-context-card-ico"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg></span>
        <h4>¿Por qué aquí?</h4>
        <p>Recibe sistemas formados en el Pacífico y remanentes del Atlántico/Caribe, sobre todo en temporada oficial (mayo–noviembre).</p>
      </div>
      <div class="dis-context-card">
        <span class="dis-context-card-ico"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3l10 18H2L12 3z"/><path d="M12 10v4"/><path d="M12 17h.01"/></svg></span>
        <h4>Mayor riesgo</h4>
        <p>Las lluvias, no el viento: suelen ser más destructivas que el propio sistema al pasar cerca del país.</p>
      </div>
    </div>
  </div>
</section>

<!-- INFORMACION GENERAL -->
<section class="sec" id="info-general">
  <div class="wrap">
    <h3 class="dis-subhead">Información general</h3>
    <div class="dis-info-grid">
      <div class="dis-info-card">
        <h3>¿Qué es?</h3>
        <p>Es un sistema de baja presión con vientos que giran organizados alrededor de un centro. Se forma sobre aguas oceánicas cálidas (mayores a 26°C): la evaporación lo alimenta de energía y la rotación de la Tierra organiza los vientos en espiral.</p>
      </div>
      <div class="dis-info-card">
        <h3>Depresión tropical</h3>
        <p>La etapa inicial: un sistema organizado con vientos sostenidos de hasta 62 km/h. Ya trae lluvias intensas aunque el viento todavía no sea el problema principal.</p>
      </div>
      <div class="dis-info-card">
        <h3>Tormenta tropical</h3>
        <p>Vientos sostenidos entre 63 y 118 km/h. Es la categoría que más ha golpeado a El Salvador en la última década, con lluvias que suelen ser más destructivas que el viento.</p>
      </div>
      <div class="dis-info-card">
        <h3>Huracán</h3>
        <p>Vientos sostenidos superiores a 119 km/h, organizados alrededor de un "ojo" central. El Salvador rara vez recibe un impacto directo, pero sí los remanentes de humedad de huracanes que pasan cerca.</p>
      </div>
    </div>

    <h3 class="dis-subhead">Información de El Salvador</h3>
    <div class="dis-info-grid">
      <div class="dis-info-card">
        <h3>¿Por qué ocurre aquí?</h3>
        <p>Aunque no está en la ruta directa de los grandes huracanes del Caribe, el país recibe con frecuencia sistemas formados en el Pacífico y remanentes de sistemas del Atlántico/Caribe que cruzan Centroamérica, sobre todo durante la temporada oficial (mayo–noviembre).</p>
      </div>
    </div>
  </div>
</section>

<!-- ZONAS EXPUESTAS -->
<section class="sec sec-dark">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Mapa de Riesgo</div>
      <h2 class="sec-title">Zonas más <span class="acc">expuestas</span></h2>
    </div>
    <div class="dis-zones">
      <div class="dis-zone-chip"><span class="dot"></span>Toda la costa pacífica</div>
      <div class="dis-zone-chip"><span class="dot"></span>Cuencas bajas de ríos (Lempa, Grande de San Miguel)</div>
      <div class="dis-zone-chip"><span class="dot"></span>Zonas urbanas con drenaje deficiente</div>
      <div class="dis-zone-chip"><span class="dot"></span>Laderas ya saturadas por lluvias previas</div>
    </div>
  </div>
</section>

<!-- RIESGOS -->
<section class="sec">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Consecuencias</div>
      <h2 class="sec-title">Riesgos de una <span class="acc">tormenta tropical</span></h2>
    </div>
    <div class="dis-impact-grid">
      <div class="dis-impact-card"><h4>Inundaciones</h4><p>Las lluvias acumuladas en pocos días suelen ser la principal causa de daño, más que el viento.</p></div>
      <div class="dis-impact-card"><h4>Deslizamientos</h4><p>El suelo saturado por días de lluvia continua se vuelve inestable en laderas.</p></div>
      <div class="dis-impact-card"><h4>Daño a cultivos</h4><p>Café y granos básicos son especialmente vulnerables a lluvias prolongadas.</p></div>
      <div class="dis-impact-card"><h4>Cortes de servicios</h4><p>Energía eléctrica, agua potable y comunicaciones suelen interrumpirse por días.</p></div>
    </div>
  </div>
</section>

<!-- ESCALA DE ALERTAS -->
<section class="sec sec-dark">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Sistema oficial</div>
      <h2 class="sec-title">Escala de <span class="acc">alertas</span></h2>
      <p class="sec-sub">Los 4 niveles con los que Protección Civil clasifica una tormenta tropical en desarrollo</p>
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
          <li>Sigue el rastreo de sistemas tropicales del MARN desde que se forman, no solo cuando ya están cerca.</li>
          <li>Prepara tu mochila de emergencia y ten un plan familiar de evacuación listo.</li>
          <li>Asegura techos, canaletas y objetos sueltos que el viento pueda arrastrar.</li>
        </ul>
      </div>
      <div class="dis-action-col">
        <div class="dis-action-hd">Durante</div>
        <ul>
          <li>Evacúa de forma preventiva si Protección Civil lo indica: no esperes a que empeore.</li>
          <li>Mantente alejado de ríos, quebradas y zonas bajas mientras dure el sistema.</li>
          <li>Usa la radio a pilas para seguir los avisos oficiales si se corta la energía.</li>
        </ul>
      </div>
      <div class="dis-action-col">
        <div class="dis-action-hd">Después</div>
        <ul>
          <li>No regreses a zonas evacuadas hasta que se confirme que es seguro.</li>
          <li>Revisa tu vivienda por daños estructurales antes de reingresar.</li>
          <li>Reporta a Protección Civil los daños para el registro de damnificados.</li>
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
      <h2 class="sec-title">Sistemas que <span class="acc">marcaron</span> al país</h2>
    </div>
    <div class="tl-wrap"><div class="tl-line"></div><div class="tl-track" id="tlTrack-tormentas"></div></div>
    <div class="tl-detail" id="tlDetail-tormentas"></div>
  </div>
</section>
<script>
document.addEventListener('DOMContentLoaded', function () {
    ndaInitTimeline('tormentas', [
        { year: '1998', title: 'Huracán Mitch', badge: 'Histórico', region: 'Toda Centroamérica',
          desc: 'Uno de los ciclones más mortales del Atlántico; sus lluvias remanentes provocaron inundaciones y deslaves masivos en toda la región centroamericana.',
          tags: [{ t: 'Histórico', c: '' }],
          stats: [{ v: '1998', l: 'Año' }],
          img: 'assets/media/desastres/tormentas/1998-mitch.jpg' },
        { year: '2009', title: 'Tormenta tropical Ida', badge: '198 muertos', region: 'San Vicente, San Miguel',
          desc: '198 muertos y más de 15,000 damnificados el 8 de noviembre de 2009, uno de los eventos más mortales de la última década.',
          tags: [{ t: '198 muertos', c: 'r' }],
          stats: [{ v: '198', l: 'Fallecidos' }, { v: '2009', l: 'Año' }],
          img: 'https://commons.wikimedia.org/wiki/Special:FilePath/Lo%20que%20dejo%20a%20su%20paso%20el%20huracan%20Ida%20(7%2C8%20Noviembre%202009)%20Playa%20de%20Las%20Hojas.%20-%20panoramio.jpg' },
        { year: '2011', title: 'Depresión Tropical 12-E', badge: '34 muertos', region: 'Zona central',
          desc: 'Lluvias históricas en octubre de 2011: 34 muertos y 50,000 damnificados.',
          tags: [{ t: '34 muertos', c: 'r' }],
          stats: [{ v: '34', l: 'Fallecidos' }, { v: '2011', l: 'Año' }],
          img: 'assets/media/desastres/tormentas/2011-dt12e.jpg' },
        { year: '2020', title: 'Amanda y Cristóbal', badge: '31 muertos', region: 'San Salvador, La Libertad',
          desc: 'Dos sistemas en menos de una semana durante la pandemia de COVID-19: 31 muertos y miles de albergados.',
          tags: [{ t: '31 muertos', c: 'r' }, { t: 'Pandemia', c: 't' }],
          stats: [{ v: '31', l: 'Fallecidos' }, { v: '2020', l: 'Año' }],
          img: 'assets/media/desastres/tormentas/2020-amanda.jpg' },
        { year: '2022', title: 'Huracán Julia', badge: '4,000 evacuados', region: 'Zona oriental',
          desc: 'Impactó como tormenta tropical el 9 de octubre de 2022, dejando más de 4,000 evacuados y daños en carreteras y puentes, sin víctimas mortales.',
          tags: [{ t: 'Sin víctimas', c: '' }],
          stats: [{ v: '4,000', l: 'Evacuados' }, { v: '2022', l: 'Año' }],
          img: 'assets/media/desastres/tormentas/2022-julia.jpg' }
    ]);
});
</script>

<!-- GALERIA -->
<section class="sec">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Multimedia</div>
      <h2 class="sec-title">Galería de <span class="acc">imágenes</span></h2>
      <p class="sec-sub">Espacio reservado para fotografías de sistemas tropicales y sus efectos</p>
    </div>
    <?php $galleryItems = [
        ['img' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Lo%20que%20dejo%20a%20su%20paso%20el%20huracan%20Ida%20(7%2C8%20Noviembre%202009)%20Playa%20de%20Las%20Hojas.%20-%20panoramio%20(4).jpg', 'cap' => 'Daños del huracán Ida en Playa de Las Hojas, El Salvador (2009)', 'credit' => 'Wikimedia Commons'],
        ['img' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Heavy%20Rain.jpg', 'cap' => 'Lluvias intensas (referencial, no de El Salvador)', 'credit' => 'Wikimedia Commons'],
        ['img' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Hurricane%20Katrina%20as%20Seen%20from%20Space%20(20749127551).jpg', 'cap' => 'Imagen satelital de un huracán (referencial, no de El Salvador)', 'credit' => 'Wikimedia Commons'],
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
