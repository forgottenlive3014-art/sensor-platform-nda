<?php
$title = $title ?? 'Tsunamis - NDA';
$user = $user ?? null;
$currentSlug = 'tsunamis';
$extraCss = ['css/desastres-base.css', 'css/tsunamis.css'];
ob_start();
?>

<div class="dis-page dis-tsunamis">
<!-- BIG BANNER -->
<section class="dis-bigbanner" style="background-image:url('https://commons.wikimedia.org/wiki/Special:FilePath/PLAYA%20SAN%20DIEGO%2C%20LA%20LIBERTAD%2C%20EL%20SALVADOR.%20-%20panoramio.jpg')">
  <div class="dis-bigbanner-overlay"></div>
  <div class="wrap dis-bigbanner-inner">
    <h2 class="dis-bigbanner-word">Tsunamis</h2>
    <div class="dis-bigbanner-sub">
      <span class="dis-bigbanner-rule"></span>
      <div>
        <h3>¿Cómo se forma un tsunami?</h3>
        <p>Un sismo submarino desplaza verticalmente el fondo marino, moviendo toda la columna de agua sobre él en forma de olas de gran longitud.</p>
        <a href="#info-general" class="dis-bigbanner-btn">Aprender más</a>
      </div>
    </div>
  </div>
  <a href="#info-general" class="scroll-hint"><span>Scroll</span><div class="sh-arr"></div></a>
</section>

<!-- INFORMACION GENERAL -->
<section class="sec" id="info-general">
  <div class="wrap">
    <h3 class="dis-subhead">Información general</h3>
    <div class="dis-info-grid">
      <div class="dis-info-card">
        <h3>¿Qué es un tsunami?</h3>
        <p>Es una serie de olas de gran longitud de onda generadas por el desplazamiento repentino de una gran masa de agua. A diferencia de una ola normal, mueve toda la columna de agua, no solo la superficie, por eso puede inundar varios kilómetros tierra adentro.</p>
      </div>
      <div class="dis-info-card">
        <h3>Formación</h3>
        <p>La causa más común es un sismo submarino de gran magnitud (M7+) con desplazamiento vertical del fondo marino. También puede originarse por deslizamientos submarinos o erupciones volcánicas cerca de la costa.</p>
      </div>
    </div>

    <h3 class="dis-subhead">Información de El Salvador</h3>
    <div class="dis-info-grid">
      <div class="dis-info-card">
        <h3>Costa salvadoreña</h3>
        <p>Toda la costa pacífica está frente a la <strong>zona de subducción Cocos–Caribe</strong>, la misma falla que produce los sismos más fuertes del país. Un sismo submarino grande frente a la costa puede generar un tsunami en cuestión de minutos.</p>
      </div>
      <div class="dis-info-card">
        <h3>El mapa de amenaza (MARN)</h3>
        <p>Es un <strong>mapa agregado</strong>: combina los 23 escenarios "plausibles" más severos que podrían impactar la costa salvadoreña, calculados a partir de 23 fuentes sismotectónicas — fuentes lejanas (Chile 1960/2010, Kamchatka 1952, Alaska 1964, Samoa 2009), intermedias (México 1787, Colombia 1906) y 16 fuentes cercanas en la propia subducción. Para cada punto de la costa muestra la altura máxima de ola y la zona de inundación esperada.</p>
      </div>
    </div>
  </div>
</section>

<!-- COSTA EXPUESTA -->
<section class="sec sec-dark">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Mapa de Riesgo · MARN</div>
      <h2 class="sec-title">Comunidades costeras <span class="acc">expuestas</span></h2>
      <p class="sec-sub">Las 9 comunidades que el mapa oficial de amenaza identifica como más expuestas, incluyendo los 3 puertos principales del país</p>
    </div>
    <div class="dis-zones">
      <div class="dis-zone-chip"><span class="dot"></span>La Unión (puerto principal)</div>
      <div class="dis-zone-chip"><span class="dot"></span>San Rafael de Tasajera</div>
      <div class="dis-zone-chip"><span class="dot"></span>El Zapote</div>
      <div class="dis-zone-chip"><span class="dot"></span>Marcelino</div>
      <div class="dis-zone-chip"><span class="dot"></span>La Libertad (puerto)</div>
      <div class="dis-zone-chip"><span class="dot"></span>El Majahual</div>
      <div class="dis-zone-chip"><span class="dot"></span>Acajutla (puerto)</div>
      <div class="dis-zone-chip"><span class="dot"></span>Barra de Santiago</div>
      <div class="dis-zone-chip"><span class="dot"></span>Garita Palmera</div>
    </div>
    <p style="margin-top:14px;font-size:.8rem;color:var(--text3)">La Unión, La Libertad y Acajutla concentran además los tres puertos más grandes del país y la mayor densidad de población costera.</p>
  </div>
</section>

<!-- RIESGOS -->
<section class="sec">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Consecuencias</div>
      <h2 class="sec-title">Riesgos de un <span class="acc">tsunami</span></h2>
    </div>
    <div class="dis-impact-grid">
      <div class="dis-impact-card"><h4>Inundación costera</h4><p>Arrastra viviendas, embarcaciones y vehículos hasta 1-2 km tierra adentro según la topografía.</p></div>
      <div class="dis-impact-card"><h4>Salinización de suelos</h4><p>El agua salada inutiliza cultivos y pozos de agua dulce por meses o años.</p></div>
      <div class="dis-impact-card"><h4>Daño a manglares</h4><p>Ecosistemas como Jiquilisco, que además amortiguan futuras olas, quedan dañados.</p></div>
      <div class="dis-impact-card"><h4>Escombros y contaminación</h4><p>El agua de retorno arrastra desechos, combustibles y aguas negras hacia el mar y los esteros.</p></div>
    </div>
  </div>
</section>

<!-- SISTEMA DE ALERTA -->
<section class="sec sec-dark">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Sistema de alerta</div>
      <h2 class="sec-title">Escala de <span class="acc">alertas</span></h2>
      <p class="sec-sub">Los 4 niveles con los que Protección Civil clasifica cualquier amenaza, incluida la de tsunami</p>
    </div>
    <?php include __DIR__ . '/_alert_levels.php'; ?>
  </div>
</section>

<!-- ANTES / DURANTE / DESPUES (EVACUACION) -->
<section class="sec">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Protocolo · Evacuación</div>
      <h2 class="sec-title">¿Qué hacer <span class="acc">antes, durante y después</span>?</h2>
    </div>
    <div class="dis-actions">
      <div class="dis-action-col">
        <div class="dis-action-hd">Antes</div>
        <ul>
          <li>Si vives o visitas la costa, identifica de antemano una ruta a pie hacia terreno alto (o al menos 1-2 km tierra adentro).</li>
          <li>Aprende las señales naturales: sismo fuerte sintiéndose en la costa, o el mar retirándose de forma anómala.</li>
          <li>Guarda los contactos de Protección Civil y el número de alerta de tu municipio costero.</li>
        </ul>
      </div>
      <div class="dis-action-col">
        <div class="dis-action-hd">Durante</div>
        <ul>
          <li>Si sientes un sismo fuerte estando en la costa, <strong>no esperes una alerta oficial</strong>: evacúa de inmediato a terreno alto.</li>
          <li>Nunca vayas hacia la playa a "ver" la ola o a rescatar pertenencias.</li>
          <li>Un tsunami llega como una serie de olas: la primera no siempre es la más grande.</li>
        </ul>
      </div>
      <div class="dis-action-col">
        <div class="dis-action-hd">Después</div>
        <ul>
          <li>No regreses a la zona costera hasta que Protección Civil confirme que pasó el peligro.</li>
          <li>Evita el contacto con agua estancada: puede tener contaminación o escombros peligrosos.</li>
          <li>Revisa el estado de pozos y fuentes de agua antes de usarlos para consumo.</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- ANTECEDENTES -->
<section class="sec sec-dark">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Memoria histórica</div>
      <h2 class="sec-title">Antecedentes en la <span class="acc">costa salvadoreña</span></h2>
    </div>
    <div class="tl-wrap"><div class="tl-line"></div><div class="tl-track" id="tlTrack-tsunamis"></div></div>
    <div class="tl-detail" id="tlDetail-tsunamis"></div>
  </div>
</section>
<script>
document.addEventListener('DOMContentLoaded', function () {
    ndaInitTimeline('tsunamis', [
        { year: '1859', title: 'Registro histórico', badge: 'Histórico', region: 'Costa pacífica de El Salvador',
          desc: 'Las bases de datos históricas de tsunamis del Pacífico documentan un evento asociado a la costa de El Salvador, entre los más antiguos con registro para la región.',
          tags: [{ t: 'Histórico', c: '' }],
          stats: [{ v: '1859', l: 'Año' }],
          img: 'assets/media/desastres/tsunamis/1859.jpg' },
        { year: '2012', title: 'Alerta preventiva regional', badge: 'M 7.3', region: 'Costa Rica / Nicaragua (regional)',
          desc: 'Un sismo de magnitud 7.3 frente a Costa Rica/Nicaragua activó por primera vez a gran escala el protocolo de evacuación costera en El Salvador. No hubo impacto mayor, pero sirvió para probar los planes municipales.',
          tags: [{ t: 'Alerta', c: 'o' }, { t: 'Regional', c: '' }],
          stats: [{ v: '7.3', l: 'Magnitud' }, { v: '2012', l: 'Año' }],
          img: 'assets/media/desastres/tsunamis/2012-alerta.jpg' },
        { year: '2012', title: 'Fortalecimiento del sistema de alerta', badge: 'Prevención', region: 'Centroamérica',
          desc: 'A partir de este evento, MARN y CEPREDENAC reforzaron el Sistema de Alerta Temprana de Tsunamis para Centroamérica, con mejor coordinación con el Pacific Tsunami Warning Center (PTWC).',
          tags: [{ t: 'Prevención', c: 't' }],
          stats: [{ v: 'PTWC', l: 'Coordinación' }],
          img: 'assets/media/desastres/tsunamis/sat.jpg' }
    ]);
});
</script>

<!-- GALERIA -->
<section class="sec">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Multimedia</div>
      <h2 class="sec-title">Galería de <span class="acc">imágenes</span></h2>
      <p class="sec-sub">Espacio reservado para fotografías del mapa de amenaza, señalización de rutas y comunidades costeras</p>
    </div>
    <?php $galleryItems = [
        ['img' => 'https://commons.wikimedia.org/wiki/Special:FilePath/PLAYA%20SAN%20DIEGO%2C%20LA%20LIBERTAD%2C%20EL%20SALVADOR.%20-%20panoramio.jpg', 'cap' => 'Costa de La Libertad, El Salvador', 'credit' => 'Wikimedia Commons'],
        ['img' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Tsunami-dart-system3.jpg', 'cap' => 'Sistema DART de boyas de alerta temprana (referencial, no de El Salvador)', 'credit' => 'Wikimedia Commons'],
        ['img' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Nusa-Dua%20Bali%20Indonesia%20Tsunami-evacuation-sign-01.jpg', 'cap' => 'Señalización de ruta de evacuación vertical (referencial, no de El Salvador)', 'credit' => 'Wikimedia Commons'],
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
      <a class="dis-source-item" href="https://www.snet.gob.sv/ver/oceanografia/amenaza/mapa+de+amenaza+por+tsunami/" target="_blank">MARN — Mapa de amenaza por tsunami</a>
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
