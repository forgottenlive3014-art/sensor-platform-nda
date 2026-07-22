<?php
$title = $title ?? 'Deslizamientos - NDA';
$user = $user ?? null;
$currentSlug = 'deslizamientos';
$extraCss = ['css/desastres-base.css', 'css/deslizamientos.css'];
ob_start();
?>

<div class="dis-page dis-deslizamientos">
<section class="dis-hero">
  <div class="dis-particles" id="deslizamientosParticles" aria-hidden="true"></div>
  <div class="wrap">
    <div class="dis-hero-icon">D</div>
    <div class="sec-hd" style="text-align:left;margin:0;">
      <div class="sec-eyebrow">Movimientos de ladera · El Salvador</div>
      <h1 class="sec-title">Deslizamientos: la ladera que <span class="acc">deja de sostenerse</span></h1>
      <p class="sec-sub">Suelos volcánicos poco cohesivos, alta sismicidad y urbanización en pendiente: por qué El Salvador es tan propenso a los deslaves.</p>
    </div>
    <?php include __DIR__ . '/_quicknav.php'; ?>
  </div>
</section>

<!-- INFORMACION GENERAL -->
<section class="sec">
  <div class="wrap">
    <h3 class="dis-subhead">Información general</h3>
    <div class="dis-info-grid">
      <div class="dis-info-card">
        <h3>¿Qué es?</h3>
        <p>Un deslizamiento (o deslave) es el movimiento de una masa de tierra, roca o lodo ladera abajo por efecto de la gravedad, cuando la fuerza que la sostiene deja de ser suficiente.</p>
      </div>
      <div class="dis-info-card">
        <h3>Causas</h3>
        <p>La lluvia intensa satura el suelo y añade peso, reduciendo la fricción entre capas. Un sismo puede desestabilizar la ladera al mismo tiempo, o los cortes de talud para construcción pueden dejarla sin soporte.</p>
      </div>
      <div class="dis-info-card">
        <h3>Prevención</h3>
        <p>No construir ni cortar taludes en laderas sin estudio técnico, mantener la cobertura vegetal que retiene el suelo, y dar seguimiento a grietas o inclinaciones nuevas antes de que se conviertan en un deslave.</p>
      </div>
    </div>

    <h3 class="dis-subhead">Información de El Salvador</h3>
    <div class="dis-info-grid">
      <div class="dis-info-card">
        <h3>¿Por qué ocurre aquí?</h3>
        <p>El país tiene suelos de origen volcánico (cenizas y piroclastos) que son poco cohesivos cuando se saturan, combinados con topografía montañosa, alta sismicidad y urbanización acelerada en laderas sin planificación adecuada.</p>
      </div>
      <div class="dis-info-card">
        <h3>Factores de riesgo</h3>
        <p>Cuatro factores se combinan en El Salvador: <strong>pendiente pronunciada</strong>, <strong>suelo volcánico suelto</strong>, <strong>saturación por lluvia</strong> y <strong>sismicidad frecuente</strong> — cualquiera puede ser el disparador final de una ladera ya debilitada.</p>
      </div>
    </div>
  </div>
</section>

<!-- ZONAS VULNERABLES -->
<section class="sec sec-dark">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Mapa de Riesgo</div>
      <h2 class="sec-title">Zonas más <span class="acc">vulnerables</span></h2>
    </div>
    <div class="dis-zones">
      <div class="dis-zone-chip"><span class="dot"></span>Las Colinas, Santa Tecla</div>
      <div class="dis-zone-chip"><span class="dot"></span>Laderas del volcán de San Salvador</div>
      <div class="dis-zone-chip"><span class="dot"></span>Cordillera del Bálsamo</div>
      <div class="dis-zone-chip"><span class="dot"></span>Zona de Berlín y Alegría, Usulután</div>
      <div class="dis-zone-chip"><span class="dot"></span>Laderas urbanizadas de Ilopango</div>
    </div>
  </div>
</section>

<!-- RIESGOS -->
<section class="sec">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Consecuencias</div>
      <h2 class="sec-title">Riesgos de un <span class="acc">deslizamiento</span></h2>
    </div>
    <div class="dis-impact-grid">
      <div class="dis-impact-card"><h4>Sepultamiento de viviendas</h4><p>Comunidades enteras en la base de una ladera pueden quedar cubiertas en segundos.</p></div>
      <div class="dis-impact-card"><h4>Bloqueo de carreteras</h4><p>Vías interurbanas y rurales quedan cortadas, aislando comunidades por días.</p></div>
      <div class="dis-impact-card"><h4>Daño a fuentes de agua</h4><p>Tuberías y pozos cercanos a la ladera pueden romperse o contaminarse.</p></div>
      <div class="dis-impact-card"><h4>Cortes de servicios</h4><p>Postes eléctricos y tendido de servicios básicos suelen dañarse en la zona del deslave.</p></div>
    </div>
  </div>
</section>

<!-- ESCALA DE ALERTAS -->
<section class="sec sec-dark">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Sistema oficial</div>
      <h2 class="sec-title">Escala de <span class="acc">alertas</span></h2>
      <p class="sec-sub">Los 4 niveles con los que Protección Civil clasifica una amenaza de deslizamiento en desarrollo</p>
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
          <li>Presta atención a grietas nuevas en el suelo o paredes, y árboles o postes inclinados cerca de tu vivienda.</li>
          <li>No construyas ni permitas cortes de talud sin estudio técnico en laderas.</li>
          <li>Identifica una ruta de evacuación hacia terreno firme y plano.</li>
        </ul>
      </div>
      <div class="dis-action-col">
        <div class="dis-action-hd">Durante</div>
        <ul>
          <li>Si escuchas ruidos sordos provenientes de la ladera o ves agua turbia con barro, aléjate de inmediato.</li>
          <li>No intentes cruzar o quedarte cerca de una zona donde ya empezó a moverse tierra.</li>
          <li>Ayuda a evacuar a vecinos con movilidad reducida, si es seguro hacerlo.</li>
        </ul>
      </div>
      <div class="dis-action-col">
        <div class="dis-action-hd">Después</div>
        <ul>
          <li>No regreses a la zona hasta que Protección Civil confirme que el terreno es estable.</li>
          <li>Reporta grietas nuevas o inclinaciones de terreno que veas tras el evento.</li>
          <li>Evita caminar sobre suelo suelto o saturado: puede haber un segundo deslizamiento.</li>
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
      <h2 class="sec-title">El desastre que <span class="acc">cambió la norma</span></h2>
    </div>
    <div class="tl-wrap"><div class="tl-line"></div><div class="tl-track" id="tlTrack-deslizamientos"></div></div>
    <div class="tl-detail" id="tlDetail-deslizamientos"></div>
  </div>
</section>
<script>
document.addEventListener('DOMContentLoaded', function () {
    ndaInitDisParticles('deslizamientosParticles', 'deslizamientos');
    ndaInitTimeline('deslizamientos', [
        { year: '2001', title: 'Deslizamiento de Las Colinas', badge: 'M 7.7', region: 'Santa Tecla, La Libertad',
          desc: 'El terremoto de magnitud 7.7 del 13 de enero de 2001 desprendió la ladera del volcán de San Salvador sobre la colonia Las Colinas, en Santa Tecla, sepultando cientos de viviendas en segundos. Es uno de los deslizamientos más mortales en la historia de Centroamérica.',
          tags: [{ t: 'M 7.7', c: 'r' }, { t: 'Las Colinas', c: 'o' }],
          stats: [{ v: '7.7', l: 'Magnitud del sismo' }, { v: '2001', l: 'Año' }],
          img: 'https://commons.wikimedia.org/wiki/Special:FilePath/ElSalvadorslide.jpg' },
        { year: '2011', title: 'Deslaves de la Depresión Tropical 12-E', badge: 'Múltiples deslaves', region: 'Zona central',
          desc: 'Las lluvias históricas de octubre de 2011 provocaron decenas de deslizamientos en la zona central del país, sumándose a los daños por inundación.',
          tags: [{ t: 'Lluvias', c: 't' }],
          stats: [{ v: '2011', l: 'Año' }],
          img: 'assets/media/desastres/deslizamientos/2011-dt12e.jpg' }
    ]);
});
</script>

<!-- GALERIA -->
<section class="sec">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Multimedia</div>
      <h2 class="sec-title">Galería de <span class="acc">imágenes</span></h2>
      <p class="sec-sub">Espacio reservado para fotografías de laderas inestables y zonas afectadas</p>
    </div>
    <?php $galleryItems = [
        ['img' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Volcan%20Santa%20Ana%202004%20-%20panoramio.jpg', 'cap' => 'Ladera del volcán de Santa Ana, El Salvador', 'credit' => 'Wikimedia Commons'],
        ['img' => 'https://commons.wikimedia.org/wiki/Special:FilePath/ElSalvadorslide.jpg', 'cap' => 'Deslizamiento de Las Colinas, Santa Tecla (2001)', 'credit' => 'Wikimedia Commons'],
        ['img' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Bosque%20interior%20Parque%20Nacional%20Montecristo%2001.JPG', 'cap' => 'Cobertura forestal, Parque Nacional Montecristo, El Salvador', 'credit' => 'Wikimedia Commons'],
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
