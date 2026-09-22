<?php
$title = $title ?? 'Incendios Forestales - NDA';
$user = $user ?? null;
$currentSlug = 'incendios-forestales';
$extraCss = ['css/desastres-base.css', 'css/volcanes.css', 'css/incendios-forestales.css'];
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
<section class="v-section" id="info-general">
  <div class="wrap">
    <div class="v-header center">
      <span class="v-tag">01 · Amenaza forestal</span>
      <h2 class="v-title">Información <span>general</span></h2>
      <p class="v-sub">Qué es un incendio forestal, sus causas y cómo prevenirlo.</p>
    </div>
    <div class="v-intro-wrapper">
      <div class="v-intro-image">
        <img src="assets/media/img/bosque.jpg" alt="Bosque en riesgo de incendio forestal" loading="lazy">
        <span class="v-intro-image-label">Vegetación seca durante la época de mayor riesgo</span>
      </div>
      <div class="v-intro-content">
        <div class="v-intro-definition">
          <p>Un <strong>incendio forestal</strong> es un fuego no controlado que se propaga sobre bosques, matorrales, potreros o cañales sin una barrera que lo detenga a tiempo.</p>
        </div>
        <div class="v-fundamentos">
          <h3 class="v-fundamentos-title">Para que un incendio se propague se necesitan:</h3>
          <div class="v-fundamentos-grid">
            <div class="v-fundamento"><span class="v-fundamento-num">01</span><div class="v-fundamento-content"><h4>Combustible seco</h4><p>Hojarasca, pasto, ramas y vegetación que pueden arder con facilidad.</p></div></div>
            <div class="v-fundamento"><span class="v-fundamento-num">02</span><div class="v-fundamento-content"><h4>Calor y baja humedad</h4><p>La época seca facilita que el fuego avance con rapidez y alcance mayor extensión.</p></div></div>
            <div class="v-fundamento"><span class="v-fundamento-num">03</span><div class="v-fundamento-content"><h4>Fuente de ignición</h4><p>Quemas agrícolas, fogatas o colillas mal apagadas son las causas más comunes.</p></div></div>
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
      <p class="v-sub">La época seca y su relación con los incendios forestales.</p>
    </div>
    <div class="v-grid-3">
      <div class="v-card"><div class="v-card-img"><img src="assets/media/img/aire.jpg" alt="Época seca" loading="lazy"></div><div class="v-card-body"><h4>Época seca</h4><p>De noviembre a abril hay altas temperaturas y baja humedad, condiciones que favorecen la propagación del fuego.</p></div></div>
      <div class="v-card"><div class="v-card-img"><img src="assets/media/img/ca%C3%B1era.jpg" alt="Quema agrícola" loading="lazy"></div><div class="v-card-body"><h4>Quemas agrícolas</h4><p>La quema de rastrojos y caña de azúcar puede salirse de control si no se realiza con medidas de seguridad.</p></div></div>
      <div class="v-card"><div class="v-card-img"><img src="assets/media/img/tres.jpg" alt="Zona natural vulnerable" loading="lazy"></div><div class="v-card-body"><h4>Áreas naturales</h4><p>Parques y bosques con vegetación seca requieren vigilancia y reportes tempranos durante toda la temporada.</p></div></div>
    </div>
  </div>
</section>

<!-- ZONAS VULNERABLES -->
<section class="v-section" id="zonas-vulnerables">
  <div class="wrap">
    <div class="v-header center">
      <span class="v-tag">03 · Mapa de riesgo</span>
      <h2 class="v-title">Zonas más <span>propensas</span></h2>
      <p class="v-sub">Áreas naturales y productivas con mayor exposición al fuego.</p>
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
<section class="v-section v-section-dark" id="riesgos">
  <div class="wrap">
    <div class="v-header center">
      <span class="v-tag">04 · Consecuencias</span>
      <h2 class="v-title">Riesgos de un <span>incendio forestal</span></h2>
      <p class="v-sub">Impactos sobre bosques, fauna, suelo y comunidades.</p>
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
<section class="v-section" id="alertas">
  <div class="wrap">
    <div class="v-header center">
      <span class="v-tag">05 · Sistema oficial</span>
      <h2 class="v-title">Escala de <span>alertas</span></h2>
      <p class="v-sub">Los 4 niveles con los que Protección Civil clasifica una amenaza en desarrollo.</p>
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
      <p class="v-sub">Acciones para prevenir, responder y recuperarse de un incendio forestal.</p>
    </div>
    <div class="fi-actions-grid">
      <article class="fi-action-card">
        <div class="fi-action-image"><img src="assets/media/img/bosque.jpg" alt="Prevención de incendios forestales" loading="lazy"></div>
        <div class="fi-action-body"><span class="fi-action-step">01</span><h3>Antes: prevén</h3>
        <ul>
          <li>No hagas quemas agrícolas ni fogatas en época seca, sobre todo con viento.</li>
          <li>Si vas a hacer una quema controlada y autorizada, ten una ronda cortafuego y agua cerca.</li>
          <li>Reporta humo sospechoso a Cuerpo de Bomberos o al MARN lo antes posible.</li>
        </ul></div>
      </article>
      <article class="fi-action-card">
        <div class="fi-action-image"><img src="assets/media/img/aire.jpg" alt="Humo de incendio forestal" loading="lazy"></div>
        <div class="fi-action-body"><span class="fi-action-step">02</span><h3>Durante: aléjate</h3>
        <ul>
          <li>Aléjate en dirección contraria al viento y cuesta abajo del fuego, nunca cuesta arriba.</li>
          <li>Cúbrete nariz y boca con tela húmeda para reducir la inhalación de humo.</li>
          <li>No intentes combatir un incendio grande por tu cuenta: llama a Bomberos de inmediato.</li>
        </ul></div>
      </article>
      <article class="fi-action-card">
        <div class="fi-action-image"><img src="assets/media/img/suelo.jpg" alt="Zona forestal después de un incendio" loading="lazy"></div>
        <div class="fi-action-body"><span class="fi-action-step">03</span><h3>Después: recupera</h3>
        <ul>
          <li>Evita caminar por zonas recién quemadas: los árboles debilitados pueden caer.</li>
          <li>Apoya o participa en jornadas de reforestación de las áreas afectadas.</li>
          <li>Denuncia quemas agrícolas ilegales que veas en tu comunidad.</li>
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
      <h2 class="v-title">Un riesgo <span>estacional recurrente</span></h2>
      <p class="v-sub">Eventos que muestran el impacto de los incendios en el país.</p>
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
<section class="v-section v-section-dark" id="galeria">
  <div class="wrap">
    <div class="v-header center">
      <span class="v-tag">08 · Multimedia</span>
      <h2 class="v-title">Galería de <span>imágenes</span></h2>
      <p class="v-sub">Áreas naturales afectadas y labores de control.</p>
    </div>
    <?php $galleryItems = [
        ['img' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Forest%20fires.jpg', 'cap' => 'Incendio forestal en época seca (referencial, no de El Salvador)', 'credit' => 'Wikimedia Commons'],
        ['img' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Wildland%20firefighters%20for%20the%20Gila%20District%20(27783853537).jpg', 'cap' => 'Cuadrilla de bomberos forestales (referencial, no de El Salvador)', 'credit' => 'Wikimedia Commons'],
        ['img' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Bosque%20interior%20Parque%20Nacional%20Montecristo%2001.JPG', 'cap' => 'Bosque del Parque Nacional Montecristo, El Salvador', 'credit' => 'Wikimedia Commons'],
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
require_once __DIR__ . '/layout.php';
?>
