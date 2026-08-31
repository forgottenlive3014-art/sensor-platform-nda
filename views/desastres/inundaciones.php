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
    <h2 class="dis-bigbanner-word">Inundaciones</h2>
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

<!-- INFORMACION GENERAL -->
<section class="sec" id="info-general">
  <div class="wrap">
    <h3 class="dis-subhead">Información general</h3>
    <div class="dis-info-grid dis-info-grid-2">
      <div class="dis-info-card">
        <h3>¿Qué es?</h3>
        <p>Ocurre cuando el volumen de agua supera la capacidad de un río, quebrada o del suelo para contenerla, cubriendo áreas normalmente secas. Las lluvias intensas y prolongadas saturan el suelo, así que cada nuevo aguacero corre por la superficie en vez de infiltrarse.</p>
        <div class="dis-info-card-img">
          <img src="assets/media/img/inundaciones.jpg" alt="Inundación" loading="lazy">
        </div>
      </div>
      <div class="dis-info-card">
        <h3>Información de El Salvador</h3>
        <p>Es un territorio pequeño y montañoso, así que los ríos suben muy rápido, y la alta densidad urbana reduce la infiltración natural del agua. La temporada lluviosa va de mayo a noviembre, con el mayor riesgo entre septiembre y octubre, cuando el suelo ya está saturado.</p>
        <div class="dis-info-card-img">
          <img src="assets/media/img/inundacion%202.jpg" alt="Inundación en El Salvador" loading="lazy">
        </div>
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
    <div class="in-zone-carousel-wrapper">
      <div class="in-zone-carousel-track" id="zonesCarouselTrack">
        <div class="in-zone-card">
          <div class="in-zone-card-image"><img src="assets/media/img/lempa.jpg" alt="Bajo Lempa" loading="lazy"></div>
          <div class="in-zone-card-body"><span class="in-zone-card-num">01</span><h4>Bajo Lempa</h4><p class="in-zone-card-loc">Usulután / San Vicente</p></div>
        </div>
        <div class="in-zone-card">
          <div class="in-zone-card-image"><img src="assets/media/img/acelhuate.jpg" alt="Cuenca del río Acelhuate" loading="lazy"></div>
          <div class="in-zone-card-body"><span class="in-zone-card-num">02</span><h4>Cuenca del río Acelhuate</h4><p class="in-zone-card-loc">San Salvador</p></div>
        </div>
        <div class="in-zone-card">
          <div class="in-zone-card-image"><img src="assets/media/img/mejicanos.jpg" alt="Ciudad Delgado y Mejicanos" loading="lazy"></div>
          <div class="in-zone-card-body"><span class="in-zone-card-num">03</span><h4>Ciudad Delgado y Mejicanos</h4><p class="in-zone-card-loc">Zonas bajas</p></div>
        </div>
        <div class="in-zone-card">
          <div class="in-zone-card-image"><img src="assets/media/img/san%20miguel.jpg" alt="Bajo Río Grande de San Miguel" loading="lazy"></div>
          <div class="in-zone-card-body"><span class="in-zone-card-num">04</span><h4>Bajo Río Grande</h4><p class="in-zone-card-loc">San Miguel</p></div>
        </div>
        <div class="in-zone-card">
          <div class="in-zone-card-image"><img src="assets/media/img/costeras.jpg" alt="Zonas costeras" loading="lazy"></div>
          <div class="in-zone-card-body"><span class="in-zone-card-num">05</span><h4>Zonas costeras</h4><p class="in-zone-card-loc">Desembocaduras de ríos</p></div>
        </div>
      </div>
      <button class="in-zone-carousel-btn prev" id="zonesPrev">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
      </button>
      <button class="in-zone-carousel-btn next" id="zonesNext">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
      </button>
    </div>
  </div>
</section>
<script>
(function () {
    'use strict';
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initZonesCarousel);
    } else {
        initZonesCarousel();
    }

    function initZonesCarousel() {
        var track = document.getElementById('zonesCarouselTrack');
        var prevBtn = document.getElementById('zonesPrev');
        var nextBtn = document.getElementById('zonesNext');
        if (!track) return;

        var originalCards = Array.prototype.slice.call(track.querySelectorAll('.in-zone-card'));
        var realTotal = originalCards.length;
        if (realTotal === 0) return;

        var EDGE = 3;
        var headClones = originalCards.slice(-EDGE).map(function (c) { return c.cloneNode(true); });
        var tailClones = originalCards.slice(0, EDGE).map(function (c) { return c.cloneNode(true); });
        headClones.forEach(function (c) { c.setAttribute('aria-hidden', 'true'); track.insertBefore(c, track.firstChild); });
        tailClones.forEach(function (c) { c.setAttribute('aria-hidden', 'true'); track.appendChild(c); });

        var cards = Array.prototype.slice.call(track.querySelectorAll('.in-zone-card'));
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
            setTimeout(function () { snapIfInCloneZone(); updateCenterCard(); isAnimating = false; }, 600);
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
      <h2 class="sec-title">Riesgos de una <span class="acc">inundación</span></h2>
    </div>
    <div class="dis-impact-grid">
      <div class="dis-impact-card">
        <div class="dis-impact-card-img"><img src="assets/media/img/perdida.jpg" alt="Pérdida de cosechas" loading="lazy"></div>
        <h4>Pérdida de cosechas</h4><p>Los cultivos de subsistencia en zonas bajas son de los más afectados por cada temporada de lluvia.</p>
      </div>
      <div class="dis-impact-card">
        <div class="dis-impact-card-img"><img src="assets/media/img/vivienda.jpg" alt="Viviendas anegadas" loading="lazy"></div>
        <h4>Viviendas anegadas</h4><p>Comunidades enteras quedan bajo agua, muchas veces con pérdida total de enseres.</p>
      </div>
      <div class="dis-impact-card">
        <div class="dis-impact-card-img"><img src="assets/media/img/estancada.jpeg" alt="Enfermedades" loading="lazy"></div>
        <h4>Enfermedades</h4><p>El agua estancada aumenta el riesgo de dengue, leptospirosis y enfermedades gastrointestinales.</p>
      </div>
      <div class="dis-impact-card">
        <div class="dis-impact-card-img"><img src="assets/media/img/vias.jpg" alt="Vías interrumpidas" loading="lazy"></div>
        <h4>Vías interrumpidas</h4><p>Puentes y carreteras quedan bajo agua o dañados, aislando comunidades por días.</p>
      </div>
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
      <h2 class="sec-title">¿Qué hacer <span class="acc">antes, durante y después</span>?</h2>
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
    ndaInitTimeline('inundaciones', [
        { year: '1998', title: 'Huracán Mitch', badge: '861 mm de lluvia', region: 'Todo El Salvador',
          desc: 'Uno de los eventos meteorológicos más destructivos de la década de 1990. Sus lluvias provocaron inundaciones, desbordamientos de ríos y deslizamientos en diferentes zonas de El Salvador. Se registró un acumulado de aproximadamente 861 mm de lluvia.',
          tags: [{ t: 'Histórico', c: '' }],
          stats: [{ v: '861 mm', l: 'Lluvia acumulada' }, { v: '1998', l: 'Año' }],
          img: 'assets/media/img/mitch.jpg' },
        { year: '2009', title: 'Tormenta Tropical Ida', badge: '13,680 albergados', region: 'Zona costera y San Vicente',
          desc: 'Las lluvias asociadas a la Tormenta Tropical Ida provocaron graves inundaciones, especialmente en la zona costera. El desbordamiento de ríos como el Acelhuate, Jiboa, Quezalapa y Acahuapa causó daños en viviendas, cultivos y otras infraestructuras.',
          tags: [{ t: 'Emergencia Nacional', c: 'o' }],
          stats: [{ v: '13,680', l: 'Albergados' }, { v: '2009', l: 'Año' }],
          img: 'assets/media/img/ida.jpg' },
        { year: '2011', title: 'Depresión Tropical 12-E', badge: '10% territorio anegado', region: 'Costa y cadena volcánica',
          desc: 'Las lluvias persistentes de la Depresión Tropical 12-E provocaron inundaciones y deslizamientos en gran parte del país. El desbordamiento de numerosos ríos afectó principalmente la zona costera y la cadena volcánica.',
          tags: [{ t: 'Emergencia Nacional', c: 'o' }],
          stats: [{ v: '1,256 mm', l: 'Lluvia acumulada' }, { v: '10%', l: 'Territorio anegado' }, { v: '2011', l: 'Año' }],
          img: 'assets/media/img/12e.jpg' },
        { year: '2020', title: 'Tormentas Amanda y Cristóbal', badge: 'SNPC activado', region: 'Diferentes zonas del país',
          desc: 'Las tormentas Amanda y Cristóbal generaron un fuerte temporal que provocó inundaciones, desbordamientos de ríos y deslizamientos en diferentes partes del territorio. Las autoridades activaron alertas debido al riesgo provocado por las lluvias.',
          tags: [{ t: 'Emergencia Nacional', c: 'o' }],
          stats: [{ v: 'Activo', l: 'Sistema Nacional de Protección Civil' }, { v: '2020', l: 'Año' }],
          img: 'assets/media/img/amanda.jpeg' }
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
      <a class="dis-source-item" href="https://www.proteccioncivil.gob.sv/?utm_source" target="_blank">Dirección General de Protección Civil</a>
      <a class="dis-source-item" href="https://www.proteccioncivil.gob.sv/contactenos/?utm_source" target="_blank">Contacto de Protección Civil</a>
      <a class="dis-source-item" href="https://snet.gob.sv/?utm_source" target="_blank">MARN — Observatorio de Amenazas</a>
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
