<?php
$title = $title ?? 'Tormentas Tropicales - NDA';
$user = $user ?? null;
$currentSlug = 'tormentas-tropicales';
$extraCss = ['css/desastres-base.css', 'css/tormentas-tropicales.css'];
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
<section class="sec" id="info-general">
  <div class="wrap">
    <h3 class="dis-subhead">Información general</h3>
    <div class="dis-info-grid dis-info-grid-2">
      <div class="dis-info-card">
        <h3>¿Qué es?</h3>
        <p>Es un sistema de baja presión con vientos que giran organizados alrededor de un centro. Se forma sobre aguas oceánicas cálidas (mayores a 26°C): la evaporación lo alimenta de energía y la rotación de la Tierra organiza los vientos en espiral.</p>
      </div>
      <div class="dis-info-card">
        <h3>Depresión tropical</h3>
        <p>La etapa inicial: un sistema organizado con vientos sostenidos de hasta 62 km/h. Ya trae lluvias intensas aunque el viento todavía no sea el problema principal.</p>
      </div>
      <div class="dis-info-card">
        <h3>Huracán</h3>
        <p>Vientos sostenidos superiores a 119 km/h, organizados alrededor de un "ojo" central. El Salvador rara vez recibe un impacto directo, pero sí los remanentes de humedad de huracanes que pasan cerca.</p>
      </div>
      <div class="dis-info-card">
        <h3>Tormenta tropical</h3>
        <p>Vientos sostenidos entre 63 y 118 km/h. Es la categoría que más ha golpeado a El Salvador en la última década, con lluvias que suelen ser más destructivas que el viento.</p>
      </div>
    </div>

    <h3 class="dis-subhead">Información de El Salvador</h3>
    <div class="dis-info-card dis-info-card-split">
      <div class="dis-info-card-text">
        <h3>¿Por qué ocurre aquí?</h3>
        <p>Aunque no está en la ruta directa de los grandes huracanes del Caribe, el país recibe con frecuencia sistemas formados en el Pacífico y remanentes de sistemas del Atlántico/Caribe que cruzan Centroamérica, sobre todo durante la temporada oficial (mayo–noviembre).</p>
      </div>
      <div class="dis-info-card-photo">
        <img src="assets/media/img/tropical.jpeg" alt="Tormenta tropical" loading="lazy">
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
<section class="sec">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Consecuencias</div>
      <h2 class="sec-title">Riesgos de una <span class="acc">tormenta tropical</span></h2>
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
