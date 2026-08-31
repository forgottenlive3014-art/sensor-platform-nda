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

<!-- CONTEXTO RAPIDO -->
<section class="dis-context" style="background-image:url('https://commons.wikimedia.org/wiki/Special:FilePath/Incendie%20de%20Landiras%2016%20juillet%202022.jpg')">
  <div class="dis-context-overlay"></div>
  <div class="wrap dis-context-inner">
    <div class="dis-context-hd">
      <span class="dis-context-eyebrow">El Salvador</span>
      <h2 class="dis-context-title">La época seca multiplica el riesgo</h2>
    </div>
    <div class="dis-context-cards">
      <div class="dis-context-card">
        <span class="dis-context-card-ico"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2s7 7.5 7 12a7 7 0 0 1-14 0c0-4.5 7-12 7-12z"/></svg></span>
        <h4>¿Cómo se produce?</h4>
        <p>Combustible seco, calor y una fuente de ignición: casi siempre, en el país, una quema agrícola mal manejada.</p>
      </div>
      <div class="dis-context-card">
        <span class="dis-context-card-ico"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></span>
        <h4>Época de mayor riesgo</h4>
        <p>Estación seca (noviembre–abril): altas temperaturas, baja humedad y quema de rastrojos para preparar tierra de cultivo.</p>
      </div>
      <div class="dis-context-card">
        <span class="dis-context-card-ico"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg></span>
        <h4>Causa principal</h4>
        <p>Quemas agrícolas, fogatas o colillas de cigarro mal apagadas: casi nunca son de origen natural.</p>
      </div>
      <div class="dis-context-card">
        <span class="dis-context-card-ico"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3l10 18H2L12 3z"/><path d="M12 10v4"/><path d="M12 17h.01"/></svg></span>
        <h4>Zona más propensa</h4>
        <p>El Parque de Los Volcanes (Cerro Verde, Izalco y Santa Ana), por su vegetación seca y afluencia turística.</p>
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
    <div class="dis-info-grid" style="grid-template-columns:1fr">
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
    <div class="in-zone-carousel-wrapper">
      <div class="in-zone-carousel-track" id="zonesCarouselTrack">
        <div class="in-zone-card">
          <div class="in-zone-card-image"><img src="assets/media/img/imposible.jpg" alt="Parque Nacional El Imposible" loading="lazy"></div>
          <div class="in-zone-card-body"><span class="in-zone-card-num">01</span><h4>Parque Nacional El Imposible</h4><p class="in-zone-card-loc">Ahuachapán</p></div>
        </div>
        <div class="in-zone-card">
          <div class="in-zone-card-image"><img src="assets/media/img/tres.jpg" alt="Parque de Los Volcanes" loading="lazy"></div>
          <div class="in-zone-card-body"><span class="in-zone-card-num">02</span><h4>Parque de Los Volcanes</h4><p class="in-zone-card-loc">Cerro Verde, Izalco, Santa Ana</p></div>
        </div>
        <div class="in-zone-card">
          <div class="in-zone-card-image"><img src="assets/media/img/monte.jpg" alt="Bosque de Montecristo" loading="lazy"></div>
          <div class="in-zone-card-body"><span class="in-zone-card-num">03</span><h4>Bosque de Montecristo</h4><p class="in-zone-card-loc">Trifinio</p></div>
        </div>
        <div class="in-zone-card">
          <div class="in-zone-card-image"><img src="assets/media/img/cordillera.jpg" alt="Cordillera del Bálsamo" loading="lazy"></div>
          <div class="in-zone-card-body"><span class="in-zone-card-num">04</span><h4>Cordillera del Bálsamo</h4><p class="in-zone-card-loc">Zona central</p></div>
        </div>
        <div class="in-zone-card">
          <div class="in-zone-card-image"><img src="assets/media/img/ca%C3%B1era.jpg" alt="Zonas cañeras de la costa" loading="lazy"></div>
          <div class="in-zone-card-body"><span class="in-zone-card-num">05</span><h4>Zonas cañeras</h4><p class="in-zone-card-loc">Costa</p></div>
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
      <h2 class="sec-title">Riesgos de un <span class="acc">incendio forestal</span></h2>
    </div>
    <div class="dis-impact-grid">
      <div class="dis-impact-card">
        <div class="dis-impact-card-img"><img src="assets/media/img/bosque.jpg" alt="Pérdida de bosque" loading="lazy"></div>
        <h4>Pérdida de bosque</h4><p>Áreas naturales protegidas tardan años o décadas en recuperar su cobertura original.</p>
      </div>
      <div class="dis-impact-card">
        <div class="dis-impact-card-img"><img src="assets/media/img/animales.jpg" alt="Daño a fauna" loading="lazy"></div>
        <h4>Daño a fauna</h4><p>Especies que no logran escapar a tiempo mueren o pierden su hábitat.</p>
      </div>
      <div class="dis-impact-card">
        <div class="dis-impact-card-img"><img src="assets/media/img/suelo.jpg" alt="Suelo más erosionable" loading="lazy"></div>
        <h4>Suelo más erosionable</h4><p>Sin cobertura vegetal, la siguiente temporada de lluvia trae más riesgo de deslizamientos e inundación.</p>
      </div>
      <div class="dis-impact-card">
        <div class="dis-impact-card-img"><img src="assets/media/img/aire.jpg" alt="Mala calidad del aire" loading="lazy"></div>
        <h4>Mala calidad del aire</h4><p>El humo afecta la salud respiratoria de comunidades cercanas, incluso a varios kilómetros.</p>
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
    ndaInitTimeline('incendios', [
        { year: '2017', title: 'Gran temporada de incendios forestales', badge: '2,624 ha afectadas', region: 'San Vicente y otros departamentos',
          desc: 'Aumentaron 29.3% los incendios respecto a 2016 y se afectaron 2,624 hectáreas. San Vicente y otros departamentos registraron incendios de gran magnitud.',
          tags: [{ t: 'Estacional', c: 'o' }],
          stats: [{ v: '29.3%', l: 'Incremento vs. 2016' }, { v: '2,624 ha', l: 'Área afectada' }, { v: '2017', l: 'Año' }],
          img: 'assets/media/img/2017%201.jpg' },
        { year: '2017', title: 'Parque Walter Thilo Deininger', badge: '800 manzanas afectadas', region: 'La Libertad',
          desc: 'Un incendio forestal afectó aproximadamente 800 manzanas de terreno en el parque, provocando importantes daños ambientales.',
          tags: [{ t: 'Área protegida', c: 't' }],
          stats: [{ v: '800 mz', l: 'Área afectada' }, { v: '2017', l: 'Año' }],
          img: 'assets/media/img/2017%202.jpg' },
        { year: '2021', title: 'Mercado Municipal de Santa Ana', badge: '2,000 puestos destruidos', region: 'Santa Ana',
          desc: 'El incendio del 10 de marzo destruyó aproximadamente 2,000 puestos de venta y dejó grandes pérdidas económicas para los comerciantes.',
          tags: [{ t: 'Incendio urbano', c: 'r' }],
          stats: [{ v: '2,000', l: 'Puestos destruidos' }, { v: '2021', l: 'Año' }],
          img: 'assets/media/img/santa%20ana.jpg' },
        { year: '2021', title: 'Mercado San Miguelito', badge: 'Mercado histórico afectado', region: 'San Salvador',
          desc: 'Un incendio destruyó una gran cantidad de locales y puestos del histórico mercado de San Salvador, afectando a numerosos comerciantes.',
          tags: [{ t: 'Incendio urbano', c: 'r' }],
          stats: [{ v: '2021', l: 'Año' }],
          img: 'assets/media/img/miguelito.jpg' },
        { year: '2022', title: 'Emergencia Nacional por incendios', badge: 'Estado de Emergencia', region: 'Todo El Salvador',
          desc: 'El incremento de incendios forestales llevó a declarar Estado de Emergencia Nacional debido a las condiciones de sequedad y fuertes vientos.',
          tags: [{ t: 'Emergencia Nacional', c: 'o' }],
          stats: [{ v: '2022', l: 'Año' }],
          img: 'assets/media/img/2022.jpg' }
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
