<?php
$title = $title ?? 'Tormentas Tropicales - NDA';
$user = $user ?? null;
$currentSlug = 'tormentas-tropicales';
$extraCss = ['css/desastres-base.css', 'css/volcanes.css', 'css/tormentas-tropicales.css'];
ob_start();
?>

<div class="dis-page dis-tormentas">
<!-- BIG BANNER -->
<section class="dis-bigbanner" style="background-image:url('assets/media/img/principal.jpg')">
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
<section class="v-section" id="info-general">
  <div class="wrap">
    <div class="v-header center">
      <span class="v-tag">01 · Amenaza hidrometeorológica</span>
      <h2 class="v-title">Información <span>general</span></h2>
      <p class="v-sub">Qué es una tormenta tropical y sus distintas etapas.</p>
    </div>
    <div class="v-intro-wrapper">
      <div class="v-intro-image">
        <img src="assets/media/img/principal.jpg" alt="Tormenta tropical" loading="lazy">
        <span class="v-intro-image-label">Sistema tropical organizado sobre aguas cálidas</span>
      </div>
      <div class="v-intro-content">
        <div class="v-intro-definition">
          <p>Una <strong>tormenta tropical</strong> es un sistema de baja presión con vientos organizados alrededor de un centro, alimentado por la evaporación de aguas oceánicas cálidas.</p>
        </div>
        <div class="v-fundamentos">
          <h3 class="v-fundamentos-title">Etapas principales del sistema:</h3>
          <div class="v-fundamentos-grid">
            <div class="v-fundamento"><span class="v-fundamento-num">01</span><div class="v-fundamento-content"><h4>Depresión tropical</h4><p>Vientos organizados de hasta 62 km/h, acompañados de lluvias intensas.</p></div></div>
            <div class="v-fundamento"><span class="v-fundamento-num">02</span><div class="v-fundamento-content"><h4>Tormenta tropical</h4><p>Vientos sostenidos entre 63 y 118 km/h y mayor organización del sistema.</p></div></div>
            <div class="v-fundamento"><span class="v-fundamento-num">03</span><div class="v-fundamento-content"><h4>Huracán</h4><p>Vientos superiores a 119 km/h organizados alrededor de un ojo central.</p></div></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- INFORMACION DE EL SALVADOR -->
<section class="v-section v-section-dark" id="el-salvador">
  <div class="wrap">
    <div class="v-header center">
      <span class="v-tag">02 · El Salvador</span>
      <h2 class="v-title">Información de <span>El Salvador</span></h2>
      <p class="v-sub">Por qué el país recibe sistemas del Pacífico y del Caribe.</p>
    </div>
    <div class="v-grid-3">
      <div class="v-card"><div class="v-card-img"><img src="assets/media/img/tropical.jpeg" alt="Sistemas del Pacífico" loading="lazy"></div><div class="v-card-body"><h4>Origen pacífico</h4><p>El Salvador recibe sistemas formados en el Pacífico que aportan lluvias y vientos a la costa.</p></div></div>
      <div class="v-card"><div class="v-card-img"><img src="assets/media/img/costa.jpg" alt="Costa salvadoreña" loading="lazy"></div><div class="v-card-body"><h4>Remanentes del Caribe</h4><p>Sistemas del Atlántico y el Caribe pueden cruzar Centroamérica y conservar humedad.</p></div></div>
      <div class="v-card"><div class="v-card-img"><img src="assets/media/img/ladera.jpeg" alt="Laderas saturadas por lluvia" loading="lazy"></div><div class="v-card-body"><h4>Temporada de riesgo</h4><p>Entre mayo y noviembre, la lluvia acumulada puede saturar laderas y cuencas.</p></div></div>
    </div>
  </div>
</section>

<!-- ZONAS EXPUESTAS -->
<section class="v-section" id="zonas-expuestas">
  <div class="wrap">
    <div class="v-header center">
      <span class="v-tag">03 · Mapa de riesgo</span>
      <h2 class="v-title">Zonas más <span>expuestas</span></h2>
      <p class="v-sub">Áreas donde la lluvia, el viento y la saturación del suelo elevan el riesgo.</p>
    </div>
    <div class="in-zone-carousel-wrapper">
      <div class="in-zone-carousel-track" id="zonesCarouselTrack">
        <div class="in-zone-card">
          <div class="in-zone-card-image"><img src="assets/media/img/costa.jpg" alt="Toda la costa pacífica" loading="lazy"></div>
          <div class="in-zone-card-body"><span class="in-zone-card-num">01</span><h4>Costa pacífica</h4><p class="in-zone-card-loc">Toda la costa</p></div>
        </div>
        <div class="in-zone-card">
          <div class="in-zone-card-image"><img src="assets/media/img/lempaa.jpg" alt="Cuencas bajas de ríos" loading="lazy"></div>
          <div class="in-zone-card-body"><span class="in-zone-card-num">02</span><h4>Cuencas bajas de ríos</h4><p class="in-zone-card-loc">Lempa, Grande de San Miguel</p></div>
        </div>
        <div class="in-zone-card">
          <div class="in-zone-card-image"><img src="assets/media/img/drenage.jpg" alt="Zonas urbanas con drenaje deficiente" loading="lazy"></div>
          <div class="in-zone-card-body"><span class="in-zone-card-num">03</span><h4>Zonas urbanas</h4><p class="in-zone-card-loc">Drenaje deficiente</p></div>
        </div>
        <div class="in-zone-card">
          <div class="in-zone-card-image"><img src="assets/media/img/ladera.jpeg" alt="Laderas saturadas" loading="lazy"></div>
          <div class="in-zone-card-body"><span class="in-zone-card-num">04</span><h4>Laderas saturadas</h4><p class="in-zone-card-loc">Por lluvias previas</p></div>
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
<section class="v-section v-section-dark" id="riesgos">
  <div class="wrap">
    <div class="v-header center">
      <span class="v-tag">04 · Consecuencias</span>
      <h2 class="v-title">Riesgos de una <span>tormenta tropical</span></h2>
      <p class="v-sub">Impactos sobre viviendas, cultivos, caminos y comunidades.</p>
    </div>
    <div class="dis-impact-grid">
      <div class="dis-impact-card">
        <div class="dis-impact-card-img"><img src="assets/media/img/inundacion3.jpg" alt="Inundaciones" loading="lazy"></div>
        <h4>Inundaciones</h4><p>Las lluvias acumuladas en pocos días suelen ser la principal causa de daño, más que el viento.</p>
      </div>
      <div class="dis-impact-card">
        <div class="dis-impact-card-img"><img src="assets/media/img/desliza.jpg" alt="Deslizamientos" loading="lazy"></div>
        <h4>Deslizamientos</h4><p>El suelo saturado por días de lluvia continua se vuelve inestable en laderas.</p>
      </div>
      <div class="dis-impact-card">
        <div class="dis-impact-card-img"><img src="assets/media/img/cultivo.jpg" alt="Daño a cultivos" loading="lazy"></div>
        <h4>Daño a cultivos</h4><p>Café y granos básicos son especialmente vulnerables a lluvias prolongadas.</p>
      </div>
      <div class="dis-impact-card">
        <div class="dis-impact-card-img"><img src="assets/media/img/corte.jpg" alt="Cortes de servicios" loading="lazy"></div>
        <h4>Cortes de servicios</h4><p>Energía eléctrica, agua potable y comunicaciones suelen interrumpirse por días.</p>
      </div>
    </div>
  </div>
</section>

<!-- ESCALA DE ALERTAS -->
<section class="v-section" id="alertas">
  <div class="wrap">
    <div class="v-header center">
      <span class="v-tag">05 · Sistema oficial</span>
      <h2 class="v-title">Escala de <span>alertas</span></h2>
      <p class="v-sub">Los 4 niveles con los que Protección Civil clasifica una tormenta tropical.</p>
    </div>
    <?php include __DIR__ . '/_alert_levels.php'; ?>
  </div>
</section>

<!-- ANTES / DURANTE / DESPUES -->
<section class="v-section v-section-dark" id="prevencion">
  <div class="wrap">
    <div class="v-header center">
      <span class="v-tag">06 · Protocolo</span>
      <h2 class="v-title">¿Qué hacer <span>antes, durante y después</span>?</h2>
      <p class="v-sub">Acciones para prepararte y responder ante un sistema tropical.</p>
    </div>
    <div class="tt-actions-grid">
      <article class="tt-action-card">
        <div class="tt-action-image"><img src="assets/media/img/principal.jpg" alt="Preparación ante tormentas tropicales" loading="lazy"></div>
        <div class="tt-action-body"><span class="tt-action-step">01</span><h3>Antes: prepárate</h3>
        <ul>
          <li>Sigue el rastreo de sistemas tropicales del MARN desde que se forman, no solo cuando ya están cerca.</li>
          <li>Prepara tu mochila de emergencia y ten un plan familiar de evacuación listo.</li>
          <li>Asegura techos, canaletas y objetos sueltos que el viento pueda arrastrar.</li>
        </ul></div>
      </article>
      <article class="tt-action-card">
        <div class="tt-action-image"><img src="assets/media/img/tropical.jpeg" alt="Tormenta tropical en desarrollo" loading="lazy"></div>
        <div class="tt-action-body"><span class="tt-action-step">02</span><h3>Durante: mantente a salvo</h3>
        <ul>
          <li>Evacúa de forma preventiva si Protección Civil lo indica: no esperes a que empeore.</li>
          <li>Mantente alejado de ríos, quebradas y zonas bajas mientras dure el sistema.</li>
          <li>Usa la radio a pilas para seguir los avisos oficiales si se corta la energía.</li>
        </ul></div>
      </article>
      <article class="tt-action-card">
        <div class="tt-action-image"><img src="assets/media/img/costa.jpg" alt="Costa después de una tormenta tropical" loading="lazy"></div>
        <div class="tt-action-body"><span class="tt-action-step">03</span><h3>Después: regresa con cuidado</h3>
        <ul>
          <li>No regreses a zonas evacuadas hasta que se confirme que es seguro.</li>
          <li>Revisa tu vivienda por daños estructurales antes de reingresar.</li>
          <li>Reporta a Protección Civil los daños para el registro de damnificados.</li>
        </ul></div>
      </article>
    </div>
  </div>
</section>

<!-- MEMORIA HISTORICA -->
<section class="v-section" id="historia">
  <div class="wrap">
    <div class="v-header center">
      <span class="v-tag">07 · Memoria histórica</span>
      <h2 class="v-title">Sistemas que <span>marcaron</span> al país</h2>
      <p class="v-sub">Eventos tropicales que dejaron huella en El Salvador.</p>
    </div>
    <div class="tl-wrap"><div class="tl-line"></div><div class="tl-track" id="tlTrack-tormentas"></div></div>
    <div class="tl-detail" id="tlDetail-tormentas"></div>
  </div>
</section>
<script>
document.addEventListener('DOMContentLoaded', function () {
    ndaInitTimeline('tormentas', [
        { year: '1998', title: 'Huracán Mitch', badge: '861 mm de lluvia', region: 'Todo El Salvador',
          desc: 'El huracán Mitch afectó a El Salvador entre octubre y noviembre de 1998. Aunque el centro del huracán no pasó directamente sobre el país, sus lluvias provocaron inundaciones y deslizamientos. Protección Civil registra un acumulado de 861 mm de lluvia, que durante años fue uno de los mayores registros históricos del país. Impacto: inundaciones, deslizamientos, daños en viviendas, carreteras y cultivos.',
          tags: [{ t: 'Histórico', c: '' }],
          stats: [{ v: '861 mm', l: 'Lluvia acumulada' }, { v: '1998', l: 'Año' }],
          img: 'assets/media/img/mitch2.jpg' },
        { year: '2005', title: 'Tormenta Tropical Stan', badge: 'Coincidió con erupción del Ilamatepec', region: 'Santa Ana y zona occidental',
          desc: 'En octubre de 2005, la tormenta tropical Stan provocó fuertes lluvias en El Salvador, coincidiendo además con la erupción del volcán Ilamatepec de Santa Ana. Protección Civil conserva un informe oficial específico sobre las afectaciones provocadas por ambos eventos. Impacto: inundaciones, deslizamientos, evacuaciones y daños en viviendas, cultivos e infraestructura.',
          tags: [{ t: 'Emergencia Nacional', c: 'o' }],
          stats: [{ v: '2005', l: 'Año' }],
          img: 'assets/media/img/stan.jpg' },
        { year: '2009', title: 'Tormenta Ida', badge: '198 fallecidos', region: 'San Vicente, Verapaz, Guadalupe',
          desc: '7–8 de noviembre de 2009. La tormenta Ida, combinada con un sistema de baja presión en el Pacífico, produjo uno de los desastres hidrometeorológicos más graves de El Salvador. Las lluvias provocaron inundaciones y grandes flujos de escombros, especialmente en San Vicente, Verapaz y Guadalupe. Según Protección Civil, el evento dejó 198 personas fallecidas y daños estimados en aproximadamente $315 millones. Impacto: 198 fallecidos, inundaciones, deslizamientos, destrucción de viviendas e infraestructura.',
          tags: [{ t: '198 fallecidos', c: 'r' }],
          stats: [{ v: '198', l: 'Fallecidos' }, { v: '$315 millones', l: 'Daños estimados' }, { v: '2009', l: 'Año' }],
          img: 'https://commons.wikimedia.org/wiki/Special:FilePath/Lo%20que%20dejo%20a%20su%20paso%20el%20huracan%20Ida%20(7%2C8%20Noviembre%202009)%20Playa%20de%20Las%20Hojas.%20-%20panoramio.jpg' },
        { year: '2010', title: 'Tormenta Tropical Agatha', badge: '12 fallecidos', region: 'Todo El Salvador',
          desc: '29–30 de mayo de 2010. Agatha provocó lluvias intensas en prácticamente todo el territorio nacional. Protección Civil declaró alerta roja nacional debido al riesgo de inundaciones y deslizamientos. El Gobierno reportó 12 fallecidos y pérdidas materiales estimadas en aproximadamente $115 millones. Además, se contabilizaron 11,649 personas albergadas y 301 centros educativos dañados. Impacto: 12 fallecidos, inundaciones, deslizamientos y daños en infraestructura.',
          tags: [{ t: '12 fallecidos', c: 'r' }, { t: 'Alerta roja nacional', c: 'o' }],
          stats: [{ v: '12', l: 'Fallecidos' }, { v: '11,649', l: 'Albergados' }, { v: '301', l: 'Centros educativos dañados' }, { v: '2010', l: 'Año' }],
          img: 'assets/media/img/agata.jpeg' },
        { year: '2020', title: 'Tormenta Tropical Amanda', badge: '30 fallecidos (Amanda y Cristóbal)', region: 'Todo El Salvador',
          desc: 'Mayo–junio de 2020. Amanda fue uno de los eventos meteorológicos más importantes de los últimos años. Las lluvias provocaron inundaciones, deslizamientos y daños en viviendas, carreteras y puentes. Protección Civil declaró alerta roja para todo el país. El MARN informó posteriormente que Amanda y Cristóbal provocaron la pérdida de 30 personas y afectaron a 29,968 familias. Impacto: 30 fallecidos junto con Cristóbal, casi 30,000 familias afectadas, inundaciones y daños materiales.',
          tags: [{ t: '30 fallecidos', c: 'r' }, { t: 'Alerta roja nacional', c: 'o' }],
          stats: [{ v: '30', l: 'Fallecidos (Amanda y Cristóbal)' }, { v: '29,968', l: 'Familias afectadas' }, { v: '2020', l: 'Año' }],
          img: 'assets/media/img/amandaa.jpg' },
        { year: '2022', title: 'Tormenta Tropical Julia', badge: '11 fallecidos', region: 'Zona oriental',
          desc: 'Octubre de 2022. Julia llegó a El Salvador después de ser reclasificada de huracán a tormenta tropical. El Gobierno declaró Estado de Emergencia Nacional debido al riesgo de inundaciones, deslizamientos y desbordamientos. El informe acumulado de Protección Civil registró 11 personas fallecidas, 4,534 evacuadas, 1,671 albergadas, 87 carreteras afectadas, 3 puentes destruidos, 268 deslizamientos y 330 viviendas anegadas. Impacto: 11 fallecidos, miles de evacuados, inundaciones, deslizamientos y daños en carreteras y puentes.',
          tags: [{ t: '11 fallecidos', c: 'r' }, { t: 'Emergencia Nacional', c: 'o' }],
          stats: [{ v: '11', l: 'Fallecidos' }, { v: '4,534', l: 'Evacuados' }, { v: '1,671', l: 'Albergados' }, { v: '268', l: 'Deslizamientos' }, { v: '2022', l: 'Año' }],
          img: 'assets/media/img/julia.jpg' }
    ]);
});
</script>

<!-- GALERIA -->
<section class="v-section v-section-dark" id="galeria">
  <div class="wrap">
    <div class="v-header center">
      <span class="v-tag">08 · Multimedia</span>
      <h2 class="v-title">Galería de <span>imágenes</span></h2>
      <p class="v-sub">Sistemas tropicales y sus efectos en el territorio.</p>
    </div>
    <?php $galleryItems = [
        ['img' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Lo%20que%20dejo%20a%20su%20paso%20el%20huracan%20Ida%20(7%2C8%20Noviembre%202009)%20Playa%20de%20Las%20Hojas.%20-%20panoramio%20(4).jpg', 'cap' => 'Daños del huracán Ida en Playa de Las Hojas, El Salvador (2009)', 'credit' => 'Wikimedia Commons'],
        ['img' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Heavy%20Rain.jpg', 'cap' => 'Lluvias intensas (referencial, no de El Salvador)', 'credit' => 'Wikimedia Commons'],
        ['img' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Hurricane%20Katrina%20as%20Seen%20from%20Space%20(20749127551).jpg', 'cap' => 'Imagen satelital de un huracán (referencial, no de El Salvador)', 'credit' => 'Wikimedia Commons'],
    ]; include __DIR__ . '/_gallery.php'; ?>
  </div>
</section>

<!-- FUENTES -->
<section class="v-section" id="fuentes">
  <div class="wrap">
    <div class="v-header center">
      <span class="v-tag">09 · Transparencia</span>
      <h2 class="v-title">Fuentes <span>oficiales</span> consultadas</h2>
      <p class="v-sub">Información pública utilizada para preparar este contenido.</p>
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
require_once __DIR__ . '/layout.php';
?>
