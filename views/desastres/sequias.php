<?php
$title = $title ?? 'Sequías - NDA';
$user = $user ?? null;
$currentSlug = 'sequias';
$extraCss = ['css/desastres-base.css', 'css/sequias.css'];
ob_start();
?>

<div class="dis-page dis-sequias">
<!-- BIG BANNER -->
<section class="dis-bigbanner" style="background-image:url('https://commons.wikimedia.org/wiki/Special:FilePath/Drought%20land%20dry%20mud%20BOUHANIFIA%20Algeria%2002.jpg')">
  <div class="dis-bigbanner-overlay"></div>
  <div class="wrap dis-bigbanner-inner">
    <h2 class="dis-bigbanner-word">Sequías</h2>
    <div class="dis-bigbanner-sub">
      <span class="dis-bigbanner-rule"></span>
      <div>
        <h3>¿Cómo se produce una sequía?</h3>
        <p>Un déficit prolongado de lluvia respecto al patrón normal reduce el agua disponible para consumo, agricultura y ecosistemas.</p>
        <a href="#info-general" class="dis-bigbanner-btn">Aprender más</a>
      </div>
    </div>
  </div>
  <a href="#info-general" class="scroll-hint"><span>Scroll</span><div class="sh-arr"></div></a>
</section>

<!-- CONTEXTO RAPIDO -->
<section class="dis-context" style="background-image:url('https://commons.wikimedia.org/wiki/Special:FilePath/Drought%20land%20dry%20mud%20BOUHANIFIA%20Algeria%2002.jpg')">
  <div class="dis-context-overlay"></div>
  <div class="wrap dis-context-inner">
    <div class="dis-context-hd">
      <span class="dis-context-eyebrow">El Salvador</span>
      <h2 class="dis-context-title">El oriente del país, parte del Corredor Seco</h2>
    </div>
    <div class="dis-context-cards">
      <div class="dis-context-card">
        <span class="dis-context-card-ico"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg></span>
        <h4>¿Por qué aquí?</h4>
        <p>El oriente del país forma parte del Corredor Seco Centroamericano, una franja con lluvias más irregulares.</p>
      </div>
      <div class="dis-context-card">
        <span class="dis-context-card-ico"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2s7 7.5 7 12a7 7 0 0 1-14 0c0-4.5 7-12 7-12z"/></svg></span>
        <h4>Cómo se origina</h4>
        <p>El fenómeno de El Niño reduce las lluvias en Centroamérica, o una "canícula" (veranillo) se alarga más de lo normal.</p>
      </div>
      <div class="dis-context-card">
        <span class="dis-context-card-ico"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5M2 12l10 5 10-5"/></svg></span>
        <h4>Impacto principal</h4>
        <p>Pérdida de cosechas de maíz y frijol, y escasez de agua para consumo humano y ganado.</p>
      </div>
      <div class="dis-context-card">
        <span class="dis-context-card-ico"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3l10 18H2L12 3z"/><path d="M12 10v4"/><path d="M12 17h.01"/></svg></span>
        <h4>Zona más afectada</h4>
        <p>La Unión, Morazán y San Miguel, el llamado "corredor seco" salvadoreño.</p>
      </div>
    </div>
  </div>
</section>

<!-- INFORMACION GENERAL -->
<section class="sec" id="info-general">
  <div class="wrap">
    <h3 class="dis-subhead">Información general</h3>
    <div class="dis-info-grid">
      <div class="dis-info-card" style="display:flex;flex-direction:column;justify-content:center">
        <h3>¿Qué es una sequía?</h3>
        <p>Es un déficit prolongado de lluvia respecto al patrón normal de una zona, que reduce la disponibilidad de agua para consumo humano, agricultura y ecosistemas.</p>
      </div>
      <div class="dis-info-card" style="display:flex;flex-direction:column;justify-content:center">
        <h3>¿Cómo se produce?</h3>
        <p>Se origina por variabilidad climática natural —el fenómeno de El Niño reduce las lluvias en Centroamérica— o por una "canícula" (veranillo) más larga de lo normal en medio de la temporada lluviosa.</p>
      </div>
      <div class="dis-info-card" style="padding:0;overflow:hidden">
        <img src="assets/media/img/Sequia.jpg" alt="Sequía" loading="lazy" style="width:100%;height:100%;object-fit:cover;display:block">
      </div>
    </div>

    <h3 class="dis-subhead">Información de El Salvador</h3>
    <div class="dis-info-grid">
      <div class="dis-info-card" style="display:flex;flex-direction:column;justify-content:center">
        <h3>¿Por qué ocurre aquí?</h3>
        <p>El oriente del país forma parte del <strong>Corredor Seco Centroamericano</strong>, una franja con lluvias más irregulares. Ahí la agricultura depende en gran parte de granos básicos de secano (sin riego), lo que la hace muy sensible a cualquier retraso o déficit de lluvia.</p>
      </div>
      <div class="dis-info-card" style="display:flex;flex-direction:column;justify-content:center">
        <h3>Impacto en El Salvador</h3>
        <p>Pérdida de cosechas de maíz y frijol, escasez de agua para consumo humano y ganado, inseguridad alimentaria en familias de subsistencia, y migración rural hacia zonas urbanas o fuera del país.</p>
      </div>
      <div class="dis-info-card" style="padding:0;overflow:hidden">
        <img src="assets/media/img/sequia1.jpg" alt="Impacto de la sequía en El Salvador" loading="lazy" style="width:100%;height:100%;object-fit:cover;display:block">
      </div>
    </div>
  </div>
</section>

<!-- ZONAS AFECTADAS -->
<section class="sec sec-dark">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Mapa de Riesgo</div>
      <h2 class="sec-title">Zonas más <span class="acc">afectadas</span></h2>
    </div>
    <div class="in-zone-carousel-wrapper">
      <div class="in-zone-carousel-track" id="zonesCarouselTrack">
        <div class="in-zone-card">
          <div class="in-zone-card-image"><img src="assets/media/img/union.jpg" alt="La Unión" loading="lazy"></div>
          <div class="in-zone-card-body"><span class="in-zone-card-num">01</span><h4>La Unión</h4><p class="in-zone-card-loc">Corredor Seco</p></div>
        </div>
        <div class="in-zone-card">
          <div class="in-zone-card-image"><img src="assets/media/img/morazan.jpg" alt="Morazán" loading="lazy"></div>
          <div class="in-zone-card-body"><span class="in-zone-card-num">02</span><h4>Morazán</h4><p class="in-zone-card-loc">Corredor Seco</p></div>
        </div>
        <div class="in-zone-card">
          <div class="in-zone-card-image"><img src="assets/media/img/miguelito.jpg" alt="San Miguel" loading="lazy"></div>
          <div class="in-zone-card-body"><span class="in-zone-card-num">03</span><h4>San Miguel</h4><p class="in-zone-card-loc">Corredor Seco</p></div>
        </div>
        <div class="in-zone-card">
          <div class="in-zone-card-image"><img src="assets/media/img/usu.jpg" alt="Parte de Usulután" loading="lazy"></div>
          <div class="in-zone-card-body"><span class="in-zone-card-num">04</span><h4>Usulután</h4><p class="in-zone-card-loc">Parte del departamento</p></div>
        </div>
        <div class="in-zone-card">
          <div class="in-zone-card-image"><img src="assets/media/img/chalate.jpg" alt="Zonas secas de Chalatenango" loading="lazy"></div>
          <div class="in-zone-card-body"><span class="in-zone-card-num">05</span><h4>Chalatenango</h4><p class="in-zone-card-loc">Zonas secas</p></div>
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
      <h2 class="sec-title">Riesgos de una <span class="acc">sequía</span></h2>
    </div>
    <div class="dis-impact-grid">
      <div class="dis-impact-card"><h4>Pérdida de cosechas</h4><p>Maíz y frijol de secano son los cultivos más golpeados por la falta de lluvia oportuna.</p></div>
      <div class="dis-impact-card"><h4>Escasez de agua</h4><p>Pozos y fuentes superficiales bajan su nivel, afectando el consumo humano y del ganado.</p></div>
      <div class="dis-impact-card"><h4>Inseguridad alimentaria</h4><p>Familias de agricultura de subsistencia quedan sin reservas para el resto del año.</p></div>
      <div class="dis-impact-card"><h4>Migración rural</h4><p>La falta de ingresos agrícolas empuja a familias a migrar hacia zonas urbanas o fuera del país.</p></div>
    </div>
  </div>
</section>

<!-- ESCALA DE ALERTAS -->
<section class="sec sec-dark">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Sistema oficial</div>
      <h2 class="sec-title">Escala de <span class="acc">alertas</span></h2>
      <p class="sec-sub">Los 4 niveles con los que Protección Civil clasifica una amenaza de sequía en desarrollo</p>
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
          <li>Instala sistemas de captación de agua de lluvia para la temporada seca.</li>
          <li>Diversifica cultivos con variedades más resistentes a la sequía cuando sea posible.</li>
          <li>Sigue los pronósticos estacionales del MARN sobre El Niño / La Niña.</li>
        </ul>
      </div>
      <div class="dis-action-col">
        <div class="dis-action-hd">Durante</div>
        <ul>
          <li>Racionaliza el uso de agua, priorizando consumo humano sobre otros usos.</li>
          <li>Evita quemas agrícolas: el riesgo de incendio forestal aumenta con la sequía.</li>
          <li>Reporta la pérdida de cosechas a las autoridades locales para acceder a apoyo.</li>
        </ul>
      </div>
      <div class="dis-action-col">
        <div class="dis-action-hd">Después</div>
        <ul>
          <li>Prioriza la recuperación de suelos antes de la siguiente siembra.</li>
          <li>Busca apoyo alimentario y agrícola a través del MAG o el Programa Mundial de Alimentos.</li>
          <li>Guarda agua y semilla de reserva para reducir el impacto de la próxima sequía.</li>
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
      <h2 class="sec-title">Sequías que <span class="acc">golpearon</span> el Corredor Seco</h2>
    </div>
    <div class="tl-wrap"><div class="tl-line"></div><div class="tl-track" id="tlTrack-sequias"></div></div>
    <div class="tl-detail" id="tlDetail-sequias"></div>
  </div>
</section>
<script>
document.addEventListener('DOMContentLoaded', function () {
    ndaInitTimeline('sequias', [
        { year: '2014', title: 'Sequía asociada a El Niño', badge: 'El Niño', region: 'Corredor Seco (oriente)',
          desc: 'Uno de los eventos de El Niño más fuertes registrados afectó severamente el Corredor Seco Centroamericano (2014–2016), con pérdidas importantes de maíz y frijol en el oriente de El Salvador.',
          tags: [{ t: 'El Niño', c: 'o' }, { t: 'Corredor Seco', c: '' }],
          stats: [{ v: '2014–2016', l: 'Periodo' }],
          img: 'assets/media/desastres/sequias/2014-el-nino.jpg' },
        { year: '2018', title: 'Canícula prolongada', badge: 'Veranillo largo', region: 'Varias zonas del país',
          desc: 'Un "veranillo" más largo de lo habitual, en plena temporada lluviosa, redujo cosechas de granos básicos en varias zonas del país.',
          tags: [{ t: 'Canícula', c: 't' }],
          stats: [{ v: '2018', l: 'Año' }],
          img: 'assets/media/desastres/sequias/2018-canicula.jpg' }
    ]);
});
</script>

<!-- GALERIA -->
<section class="sec">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Multimedia</div>
      <h2 class="sec-title">Galería de <span class="acc">imágenes</span></h2>
      <p class="sec-sub">Espacio reservado para fotografías del Corredor Seco y cultivos afectados</p>
    </div>
    <?php $galleryItems = [
        ['img' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Drought%20land%20dry%20mud%20BOUHANIFIA%20Algeria%2002.jpg', 'cap' => 'Suelo agrietado por sequía (referencial, no de El Salvador)', 'credit' => 'Wikimedia Commons'],
        ['img' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Zea%20mays%20drought%20(01).jpg', 'cap' => 'Cultivo de maíz afectado por sequía (referencial, no de El Salvador)', 'credit' => 'Wikimedia Commons'],
        ['img' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Rainwater%20harvesting%20tank%20(5981896147).jpg', 'cap' => 'Sistema de captación de agua de lluvia (referencial, no de El Salvador)', 'credit' => 'Wikimedia Commons'],
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
