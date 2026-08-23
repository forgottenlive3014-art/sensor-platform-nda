<?php
$title = $title ?? 'Tsunamis - NDA';
$user = $user ?? null;
$currentSlug = 'tsunamis';
$extraCss = ['css/desastres-base.css', 'css/tsunamis.css'];
ob_start();
?>

<div class="dis-page dis-tsunamis">
<!-- BIG BANNER -->
<!-- TODO IMAGEN: banner principal. Actualmente usa una foto de la playa de La Libertad (Wikimedia).
     Reemplazar la URL de background-image por una imagen local en assets/media/desastres/tsunamis/ si se quiere una propia. -->
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
      <div class="dis-gallery-item filled">
        <img src="assets/media/img/tsunami%201.jpg" alt="Tsunami" loading="lazy">
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
      <div class="dis-gallery-item filled">
        <img src="assets/media/img/formacion%20tsunami.jpg" alt="Formación de un tsunami" loading="lazy">
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
    <div class="ts-coast-carousel-wrapper">
      <div class="ts-coast-carousel-track" id="coastCarouselTrack">
        <div class="ts-coast-card">
          <div class="ts-coast-card-image"><img src="assets/media/img/la%20union.jpg" alt="La Unión" loading="lazy"></div>
          <div class="ts-coast-card-body"><span class="ts-coast-card-num">01</span><h4>La Unión</h4></div>
        </div>
        <div class="ts-coast-card">
          <div class="ts-coast-card-image"><img src="assets/media/img/san%20rafel.jpg" alt="San Rafael de Tasajera" loading="lazy"></div>
          <div class="ts-coast-card-body"><span class="ts-coast-card-num">02</span><h4>San Rafael de Tasajera</h4></div>
        </div>
        <div class="ts-coast-card">
          <div class="ts-coast-card-image"><img src="assets/media/img/zapote.jpg" alt="El Zapote" loading="lazy"></div>
          <div class="ts-coast-card-body"><span class="ts-coast-card-num">03</span><h4>El Zapote</h4></div>
        </div>
        <div class="ts-coast-card">
          <div class="ts-coast-card-image"><img src="assets/media/img/marce.jpg" alt="Marcelino" loading="lazy"></div>
          <div class="ts-coast-card-body"><span class="ts-coast-card-num">04</span><h4>Marcelino</h4></div>
        </div>
        <div class="ts-coast-card">
          <div class="ts-coast-card-image"><img src="assets/media/img/puerto.jpg" alt="La Libertad" loading="lazy"></div>
          <div class="ts-coast-card-body"><span class="ts-coast-card-num">05</span><h4>La Libertad</h4></div>
        </div>
        <div class="ts-coast-card">
          <div class="ts-coast-card-image"><img src="assets/media/img/maja.jpg" alt="El Majahual" loading="lazy"></div>
          <div class="ts-coast-card-body"><span class="ts-coast-card-num">06</span><h4>El Majahual</h4></div>
        </div>
        <div class="ts-coast-card">
          <div class="ts-coast-card-image"><img src="assets/media/img/acajutla.jpg" alt="Acajutla" loading="lazy"></div>
          <div class="ts-coast-card-body"><span class="ts-coast-card-num">07</span><h4>Acajutla</h4></div>
        </div>
        <div class="ts-coast-card">
          <div class="ts-coast-card-image"><img src="assets/media/img/santiago.jpeg" alt="Barra de Santiago" loading="lazy"></div>
          <div class="ts-coast-card-body"><span class="ts-coast-card-num">08</span><h4>Barra de Santiago</h4></div>
        </div>
        <div class="ts-coast-card">
          <div class="ts-coast-card-image"><img src="assets/media/img/garita.jpg" alt="Garita Palmera" loading="lazy"></div>
          <div class="ts-coast-card-body"><span class="ts-coast-card-num">09</span><h4>Garita Palmera</h4></div>
        </div>
      </div>
      <button class="ts-coast-carousel-btn prev" id="coastPrev">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
      </button>
      <button class="ts-coast-carousel-btn next" id="coastNext">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
      </button>
    </div>
    <p style="margin-top:14px;font-size:.8rem;color:var(--text3)">La Unión, La Libertad y Acajutla concentran además los tres puertos más grandes del país y la mayor densidad de población costera.</p>
  </div>
</section>
<script>
(function () {
    'use strict';
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCoastCarousel);
    } else {
        initCoastCarousel();
    }

    function initCoastCarousel() {
        var track = document.getElementById('coastCarouselTrack');
        var prevBtn = document.getElementById('coastPrev');
        var nextBtn = document.getElementById('coastNext');
        if (!track) return;

        var originalCards = Array.prototype.slice.call(track.querySelectorAll('.ts-coast-card'));
        var realTotal = originalCards.length;
        if (realTotal === 0) return;

        var EDGE = 3;
        var headClones = originalCards.slice(-EDGE).map(function (c) { return c.cloneNode(true); });
        var tailClones = originalCards.slice(0, EDGE).map(function (c) { return c.cloneNode(true); });
        headClones.forEach(function (c) { c.setAttribute('aria-hidden', 'true'); track.insertBefore(c, track.firstChild); });
        tailClones.forEach(function (c) { c.setAttribute('aria-hidden', 'true'); track.appendChild(c); });

        var cards = Array.prototype.slice.call(track.querySelectorAll('.ts-coast-card'));
        var currentIndex = EDGE;
        var visibleCards = 3;
        var isAnimating = false;

        function getVisibleCards() {
            if (window.innerWidth <= 700) return 1;
            if (window.innerWidth <= 1024) return 2;
            return 3;
        }
        function getCardWidth() {
            var gap = parseFloat(window.getComputedStyle(track).columnGap) || 0;
            return cards[0].getBoundingClientRect().width + gap;
        }
        function setTransform(withTransition) {
            track.style.transition = withTransition ? '' : 'none';
            track.style.transform = 'translateX(-' + (currentIndex * getCardWidth()) + 'px)';
            if (!withTransition) void track.offsetWidth;
        }
        function updateCarousel() {
            visibleCards = getVisibleCards();
            setTransform(true);
            updateCenterCard();
        }
        function updateCenterCard() {
            var centerIndex = currentIndex + Math.floor(visibleCards / 2);
            cards.forEach(function (card, i) { card.classList.toggle('center', i === centerIndex); });
        }
        function snapIfInCloneZone() {
            if (currentIndex < EDGE) {
                currentIndex += realTotal;
                setTransform(false);
            } else if (currentIndex >= EDGE + realTotal) {
                currentIndex -= realTotal;
                setTransform(false);
            }
        }
        function goTo(index) {
            if (isAnimating) return;
            isAnimating = true;
            currentIndex = index;
            setTransform(true);
            updateCenterCard();
            setTimeout(function () { snapIfInCloneZone(); isAnimating = false; }, 600);
        }
        function nextSlide() { goTo(currentIndex + 1); }
        function prevSlide() { goTo(currentIndex - 1); }

        if (prevBtn) prevBtn.addEventListener('click', prevSlide);
        if (nextBtn) nextBtn.addEventListener('click', nextSlide);

        var resizeTimeout;
        window.addEventListener('resize', function () {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(function () {
                visibleCards = getVisibleCards();
                setTransform(false);
                updateCenterCard();
            }, 200);
        });

        setTimeout(function () { setTransform(false); updateCenterCard(); }, 300);
        window.addEventListener('load', function () {
            setTimeout(function () { setTransform(false); updateCenterCard(); }, 100);
        });
    }
})();
</script>

<!-- RIESGOS -->
<section class="sec">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Consecuencias</div>
      <h2 class="sec-title">Riesgos de un <span class="acc">tsunami</span></h2>
    </div>
    <div class="dis-impact-grid">
      <div class="dis-impact-card">
        <div class="dis-impact-card-img"><img src="assets/media/img/inundaci%C3%B3n%20costera.jpg" alt="Inundación costera" loading="lazy"></div>
        <h4>Inundación costera</h4><p>Arrastra viviendas, embarcaciones y vehículos hasta 1-2 km tierra adentro según la topografía.</p>
      </div>
      <div class="dis-impact-card">
        <div class="dis-impact-card-img"><img src="assets/media/img/salinizaci%C3%B3n.jpg" alt="Salinización de suelos" loading="lazy"></div>
        <h4>Salinización de suelos</h4><p>El agua salada inutiliza cultivos y pozos de agua dulce por meses o años.</p>
      </div>
      <div class="dis-impact-card">
        <div class="dis-impact-card-img"><img src="assets/media/img/manglares.jpg" alt="Daño a manglares" loading="lazy"></div>
        <h4>Daño a manglares</h4><p>Ecosistemas como Jiquilisco, que además amortiguan futuras olas, quedan dañados.</p>
      </div>
      <div class="dis-impact-card">
        <div class="dis-impact-card-img"><img src="assets/media/img/contaminacion.jpg" alt="Escombros y contaminación" loading="lazy"></div>
        <h4>Escombros y contaminación</h4><p>El agua de retorno arrastra desechos, combustibles y aguas negras hacia el mar y los esteros.</p>
      </div>
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
        { year: '1859', title: 'Primeros registros históricos', badge: 'Histórico', region: 'Costa pacífica de El Salvador',
          desc: 'Las bases de datos históricas de tsunamis del Pacífico documentan dos eventos asociados a la costa de El Salvador en este año, siendo los más antiguos con registro para la región. El 25 de agosto se registró un sismo de magnitud 6.2 y el 8 de diciembre uno de 7.5, este último generó un tsunami en la Bahía de Acajutla.',
          tags: [{ t: 'Histórico', c: '' }],
          stats: [{ v: '8 dic', l: 'M 7.5 · tsunami' }, { v: '25 ago', l: 'M 6.2' }],
          img: 'assets/media/img/1859.jpg' },
        { year: '1902', title: 'El tsunami más mortífero en El Salvador', badge: '185 muertos', region: 'Costa pacífica de El Salvador y Guatemala',
          desc: 'Este es el tsunami más letal registrado en el país. Se originó por un terremoto de magnitud 7.0-8.3 frente a las costas de Garita Palmera, en Ahuachapán, fronterizo con Guatemala. Causó la muerte de 185 personas y una destrucción masiva. El mayor golpe lo recibió Acajutla, en Sonsonate, con un centenar de muertes; le siguió la Barra de Santiago, en Ahuachapán, con 85 víctimas. Fueron tres olas de hasta 20 metros que se adentraron hasta 100 metros en la playa.',
          tags: [{ t: '185 muertos', c: 'r' }, { t: 'Más letal', c: 'r' }],
          stats: [{ v: '185', l: 'Muertos' }, { v: '20 m', l: 'Altura máx. de ola' }],
          img: 'assets/media/img/1902.jpg' },
        { year: '1957', title: 'Tsunami transoceánico', badge: 'M 8.6', region: 'Costa de Acajutla, El Salvador',
          desc: 'El 9 de marzo, un terremoto de magnitud 8.6 en las Islas Andreanof (Alaska) generó un tsunami que causó daños en 6 países. En El Salvador, impactó principalmente la zona de Acajutla, aunque con menor intensidad.',
          tags: [{ t: 'Transoceánico', c: 't' }, { t: 'Origen: Alaska', c: '' }],
          stats: [{ v: '9 mar', l: 'M 8.6 · Alaska' }, { v: '6', l: 'Países afectados' }],
          img: 'assets/media/img/1957.jpg' },
        { year: '2012', title: 'Alerta y prevención regional', badge: 'M 7.3', region: 'El Salvador / Nicaragua',
          desc: 'El sismo de magnitud 7.3 frente a las costas de El Salvador y Nicaragua generó olas de hasta 6.3 metros. El tsunami golpeó principalmente la región de la Bahía de Jiquilisco y también afectó las Islas Galápagos, a más de 1,400 km de distancia. Aunque se activaron protocolos de evacuación, no hubo víctimas mortales, lo que sirvió como un exitoso ejercicio de preparación para el país.',
          tags: [{ t: 'Alerta', c: 'o' }, { t: 'Sin víctimas', c: 't' }],
          stats: [{ v: '27 ago', l: 'M 7.3' }, { v: '6.3 m', l: 'Altura máx. de ola' }],
          img: 'assets/media/img/2012.jpg' },
        { year: '2017', title: 'Amenaza por tsunami lejano', badge: 'M 8.0', region: 'Origen: Chiapas, México',
          desc: 'Un terremoto de magnitud 8.0 frente a las costas de Chiapas, México, activó una alerta de tsunami para toda Centroamérica, incluido El Salvador. El Sistema Nacional de Protección Civil activó las comunicaciones con Comisiones Municipales y Comunales para evacuación inmediata en caso necesario. Se pidió a las comunidades cercanas a las playas vigilar posibles cambios en el mar. No se reportaron daños mayores.',
          tags: [{ t: 'Alerta', c: 'o' }, { t: 'Tsunami lejano', c: '' }],
          stats: [{ v: '8 sep', l: 'M 8.0 · Chiapas' }, { v: '2017', l: 'Año' }],
          img: 'assets/media/img/2017.jpg' },
        { year: '2019', title: 'Alerta local por sismo en La Libertad', badge: 'M 6.8', region: 'La Libertad, El Salvador',
          desc: 'Un terremoto de magnitud 6.8 con epicentro frente a la costa del departamento de La Libertad, a 66 km al sur de la playa Mizata, generó una alerta de tsunami. El Centro de Alerta de Tsunamis del Pacífico (PTWC) emitió una advertencia y se activaron protocolos de evacuación en la zona costera. No se reportaron víctimas mortales.',
          tags: [{ t: 'Advertencia', c: 'o' }],
          stats: [{ v: '30 may', l: 'M 6.8' }, { v: '66 km', l: 'S de playa Mizata' }],
          img: 'assets/media/img/2019%202.jpg' }
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
    <?php
    // TODO IMAGEN: las 3 imágenes actuales son referenciales de Wikimedia Commons (2 de ellas ni siquiera son de El Salvador).
    // Hay un archivo nuevo sin usar en assets/media/img/tsunami 1.jpg -- agregarlo aquí (o a la carpeta
    // assets/media/desastres/tsunamis/ propuesta arriba) y sustituir las URLs externas por rutas locales cuando haya fotos reales.
    $galleryItems = [
        ['img' => 'https://commons.wikimedia.org/wiki/Special:FilePath/PLAYA%20SAN%20DIEGO%2C%20LA%20LIBERTAD%2C%20EL%20SALVADOR.%20-%20panoramio.jpg', 'cap' => 'Costa de La Libertad, El Salvador', 'credit' => 'Wikimedia Commons'],
        ['img' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Tsunami-dart-system3.jpg', 'cap' => 'Sistema DART de boyas de alerta temprana (referencial, no de El Salvador)', 'credit' => 'Wikimedia Commons'],
        ['img' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Nusa-Dua%20Bali%20Indonesia%20Tsunami-evacuation-sign-01.jpg', 'cap' => 'Señalización de ruta de evacuación vertical (referencial, no de El Salvador)', 'credit' => 'Wikimedia Commons'],
        // TODO IMAGEN: ['img' => 'assets/media/img/tsunami 1.jpg', 'cap' => '...', 'credit' => '...'],
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
      <a class="dis-source-item" href="https://www.pnc.gob.sv/servicios/sistema-911/" target="_blank">Policía Nacional Civil — Sistema 911</a>
      <a class="dis-source-item" href="https://www.bomberos.gob.sv/" target="_blank">Cuerpo de Bomberos de El Salvador</a>
      <a class="dis-source-item" href="https://www.gobernacion.gob.sv/" target="_blank">Ministerio de Gobernación y Desarrollo Territorial</a>
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
