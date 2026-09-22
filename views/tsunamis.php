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
<section class="dis-bigbanner" style="background-image:url('assets/media/img/tsunami.jpg')">
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

<!-- CONTEXTO RAPIDO -->
<section class="dis-context" style="background-image:url('assets/media/img/puerto.jpg')">
  <div class="dis-context-overlay"></div>
  <div class="wrap dis-context-inner">
    <div class="dis-context-hd">
      <span class="dis-context-eyebrow">El Salvador</span>
      <h2 class="dis-context-title">Toda la costa pacífica está en riesgo</h2>
    </div>
    <div class="dis-context-cards">
      <div class="dis-context-card">
        <span class="dis-context-card-ico"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg></span>
        <h4>¿Por qué aquí?</h4>
        <p>Toda la costa está frente a la zona de subducción Cocos–Caribe, la misma falla que genera los sismos más fuertes del país.</p>
      </div>
      <div class="dis-context-card">
        <span class="dis-context-card-ico"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></span>
        <h4>Tiempo de reacción</h4>
        <p>Un tsunami de origen local puede llegar a la costa en minutos tras el sismo: no hay tiempo de esperar una alerta oficial.</p>
      </div>
      <div class="dis-context-card">
        <span class="dis-context-card-ico"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></span>
        <h4>Antecedente más letal</h4>
        <p>El tsunami de 1902 dejó 185 muertos: sigue siendo el más letal registrado en el país.</p>
      </div>
      <div class="dis-context-card">
        <span class="dis-context-card-ico"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3l10 18H2L12 3z"/><path d="M12 10v4"/><path d="M12 17h.01"/></svg></span>
        <h4>Riesgo principal</h4>
        <p>Inundación costera que puede avanzar 1-2 km tierra adentro según la topografía de cada zona.</p>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECCIÓN 1: INTRODUCCIÓN
     ============================================================ -->
<section class="v-section" id="info-general">
  <div class="wrap">
    <div class="v-header center">
      <span class="v-tag">01 · Amenaza costera</span>
      <h2 class="v-title">Información <span>general</span></h2>
      <p class="v-sub">Qué es un tsunami y cómo se forma</p>
    </div>
    <div class="ts-intro-wrapper">
      <div class="ts-intro-image">
        <img src="assets/media/img/tsunami%201.jpg" alt="Tsunami" loading="lazy">
        <span class="ts-intro-image-label">Ola de gran longitud y gran energía</span>
      </div>
      <div class="ts-intro-content">
        <div class="ts-intro-card">
          <h3>¿Qué es un tsunami?</h3>
          <p>Es una serie de olas de gran longitud de onda generadas por el desplazamiento repentino de una gran masa de agua. A diferencia de una ola normal, mueve toda la columna de agua, no solo la superficie, por eso puede inundar varios kilómetros tierra adentro.</p>
        </div>
        <div class="ts-fact-grid">
          <div class="ts-fact-item"><span class="ts-fact-num">01</span><div><h4>Origen</h4><p>La causa más común es un sismo submarino de magnitud M7+ con desplazamiento vertical del fondo marino.</p></div></div>
          <div class="ts-fact-item"><span class="ts-fact-num">02</span><div><h4>Velocidad</h4><p>En mar abierto, la ola puede viajar a gran velocidad y llegar a la costa en minutos si el origen es local.</p></div></div>
          <div class="ts-fact-item"><span class="ts-fact-num">03</span><div><h4>Impacto</h4><p>Puede arrastrar viviendas, embarcaciones y agua salada hacia zonas que normalmente no se inundan.</p></div></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECCIÓN 2: EL SALVADOR
     ============================================================ -->
<section class="v-section v-section-dark" id="el-salvador">
  <div class="wrap">
    <div class="v-header center">
      <span class="v-tag">02 · El Salvador</span>
      <h2 class="v-title">Información de <span>El Salvador</span></h2>
      <p class="v-sub">La costa pacífica frente a la zona de subducción Cocos–Caribe</p>
    </div>
    <div class="ts-country-sections">
      <article class="ts-country-row">
        <div class="ts-country-image"><img src="assets/media/img/puerto.jpg" alt="Costa salvadoreña" loading="lazy"></div>
        <div class="ts-country-card"><span class="ts-country-number">01</span><h3>Costa salvadoreña</h3><p>Toda la costa pacífica está frente a la <strong>zona de subducción Cocos–Caribe</strong>, la misma falla que produce los sismos más fuertes del país. Un sismo submarino grande puede generar un tsunami en cuestión de minutos.</p></div>
      </article>
      <article class="ts-country-row reverse">
        <div class="ts-country-image"><img src="assets/media/img/formacion%20tsunami.jpg" alt="Mapa de amenaza por tsunami" loading="lazy"></div>
        <div class="ts-country-card"><span class="ts-country-number">02</span><h3>Mapa de amenaza (MARN)</h3><p>Es un <strong>mapa agregado</strong>: combina los 23 escenarios “plausibles” más severos que podrían impactar la costa salvadoreña, calculados a partir de 23 fuentes sismotectónicas.</p></div>
      </article>
      <article class="ts-country-row">
        <div class="ts-country-image"><img src="assets/media/img/tsunami%201.jpg" alt="Impacto de un tsunami en comunidades costeras" loading="lazy"></div>
        <div class="ts-country-card"><span class="ts-country-number">03</span><h3>Qué muestra el mapa</h3><p>Para cada punto de la costa se estiman la <strong>altura máxima de ola</strong> y la <strong>zona de inundación esperada</strong>, además de la severidad del impacto para comunidades costeras.</p></div>
      </article>
    </div>
  </div>
</section>

<!-- ============================================================
     SECCIÓN 3: COMUNIDADES COSTERAS
     ============================================================ -->
<section class="v-section" id="comunidades-costeras">
  <div class="wrap">
    <div class="v-header center">
      <span class="v-tag">03 · Mapa de riesgo · MARN</span>
      <h2 class="v-title">Comunidades costeras <span>expuestas</span></h2>
      <p class="v-sub">Las 9 comunidades que el mapa oficial de amenaza identifica como más expuestas, incluyendo los 3 puertos principales del país</p>
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
            setTimeout(function () { snapIfInCloneZone(); updateCenterCard(); isAnimating = false; }, 600);
        }
        function nextSlide() { goTo(currentIndex + 1); }
        function prevSlide() { goTo(currentIndex - 1); }

        if (prevBtn) prevBtn.addEventListener('click', prevSlide);
        if (nextBtn) nextBtn.addEventListener('click', nextSlide);

        // Flechas del teclado, solo mientras el carrusel esta a la vista y
        // no se esta escribiendo en un campo de texto.
        document.addEventListener('keydown', function (e) {
            if (e.key !== 'ArrowLeft' && e.key !== 'ArrowRight') return;
            var activeTag = document.activeElement && document.activeElement.tagName;
            if (activeTag === 'INPUT' || activeTag === 'TEXTAREA' || activeTag === 'SELECT') return;
            var wrapper = track.closest('.ts-coast-carousel-wrapper');
            if (!wrapper) return;
            var r = wrapper.getBoundingClientRect();
            if (r.top >= window.innerHeight * 0.85 || r.bottom <= window.innerHeight * 0.15) return;
            e.preventDefault();
            if (e.key === 'ArrowLeft') prevSlide(); else nextSlide();
        });

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

<!-- ============================================================
     SECCIÓN 4: RIESGOS
     ============================================================ -->
<section class="v-section v-section-dark" id="riesgos">
  <div class="wrap">
    <div class="v-header center">
      <span class="v-tag">04 · Consecuencias</span>
      <h2 class="v-title">Riesgos de un <span>tsunami</span></h2>
      <p class="v-sub">Principales impactos sobre las comunidades y ecosistemas costeros.</p>
    </div>
    <div class="dis-riesgos-scrollzone">
    <div class="dis-riesgos-carousel">
    <div class="dis-riesgos-track">
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
    </div>
  </div>
</section>
<script>
(function () {
    'use strict';
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initRiesgosCarousel);
    } else {
        initRiesgosCarousel();
    }

    function initRiesgosCarousel() {
        if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') return;

        var zone = document.querySelector('.dis-riesgos-scrollzone');
        var carousel = document.querySelector('.dis-riesgos-carousel');
        var track = document.querySelector('.dis-riesgos-track');
        if (!zone || !carousel || !track) return;

        var cards = track.querySelectorAll('.dis-impact-card');
        if (!cards.length) return;

        var tween = gsap.to(track, {
            x: function () { return -Math.max(0, track.scrollWidth - carousel.clientWidth); },
            ease: 'none',
            scrollTrigger: {
                trigger: zone,
                start: 'top top+=62',
                end: 'bottom bottom',
                scrub: 1,
                snap: cards.length > 1 ? {
                    snapTo: 1 / (cards.length - 1),
                    duration: 0.3,
                    ease: 'power1.inOut'
                } : false,
                invalidateOnRefresh: true
            }
        });

        var steps = cards.length - 1;
        if (steps > 0) {
            document.addEventListener('keydown', function (e) {
                if (e.key !== 'ArrowLeft' && e.key !== 'ArrowRight') return;
                var activeTag = document.activeElement && document.activeElement.tagName;
                if (activeTag === 'INPUT' || activeTag === 'TEXTAREA' || activeTag === 'SELECT') return;
                var r = carousel.getBoundingClientRect();
                if (r.top >= window.innerHeight * 0.85 || r.bottom <= window.innerHeight * 0.15) return;
                e.preventDefault();
                var st = tween.scrollTrigger;
                var current = Math.round(st.progress * steps);
                var next = Math.min(steps, Math.max(0, current + (e.key === 'ArrowLeft' ? -1 : 1)));
                window.scrollTo({ top: st.start + (next / steps) * (st.end - st.start), behavior: 'smooth' });
            });
        }
    }
})();
</script>

<!-- ============================================================
     SECCIÓN 5: SISTEMA DE ALERTA
     ============================================================ -->
<section class="v-section" id="alertas">
  <div class="wrap">
    <div class="v-header center">
      <span class="v-tag">05 · Sistema de alerta</span>
      <h2 class="v-title">Escala de <span>alertas</span></h2>
      <p class="v-sub">Los 4 niveles con los que Protección Civil clasifica cualquier amenaza, incluida la de tsunami.</p>
    </div>
    <?php include __DIR__ . '/_alert_levels.php'; ?>
  </div>
</section>

<!-- ============================================================
     SECCIÓN 6: PREVENCIÓN Y EVACUACIÓN
     ============================================================ -->
<section class="v-section v-section-dark" id="prevencion">
  <div class="wrap">
    <div class="v-header center">
      <span class="v-tag">06 · Protocolo · Evacuación</span>
      <h2 class="v-title">¿Qué hacer <span>antes, durante y después</span>?</h2>
      <p class="v-sub">Pasos esenciales para actuar ante una amenaza de tsunami.</p>
    </div>
    <div class="ts-actions-grid">
      <article class="ts-action-card">
        <!-- Cambia esta imagen por la correspondiente a la etapa Antes -->
        <div class="ts-action-image"><img src="assets/media/img/puerto.jpg" alt="Preparación en una comunidad costera" loading="lazy"></div>
        <div class="ts-action-body">
          <div class="ts-action-step">01</div>
          <h3>Antes: prepárate</h3>
          <ul>
            <li>Identifica una ruta a pie hacia terreno alto o al menos 1-2 km tierra adentro.</li>
            <li>Reconoce las señales naturales: un sismo fuerte o el retiro anormal del mar.</li>
            <li>Ten listos tus contactos de Protección Civil y una mochila de emergencia.</li>
          </ul>
        </div>
      </article>
      <article class="ts-action-card">
        <!-- Cambia esta imagen por la correspondiente a la etapa Durante -->
        <div class="ts-action-image"><img src="assets/media/img/tsunamiV.webp" alt="Ola de tsunami" loading="lazy"></div>
        <div class="ts-action-body">
          <div class="ts-action-step">02</div>
          <h3>Durante: evacúa</h3>
          <ul>
            <li>Si sientes un sismo fuerte en la costa, evacúa de inmediato sin esperar una alerta oficial.</li>
            <li>Aléjate de la playa y nunca regreses a observar la ola o rescatar pertenencias.</li>
            <li>Recuerda que un tsunami llega en varias olas y la primera no siempre es la más grande.</li>
          </ul>
        </div>
      </article>
      <article class="ts-action-card">
        <!-- Cambia esta imagen por la correspondiente a la etapa Después -->
        <div class="ts-action-image"><img src="assets/media/img/tsunami 1.jpg" alt="Zona costera después de un tsunami" loading="lazy"></div>
        <div class="ts-action-body">
          <div class="ts-action-step">03</div>
          <h3>Después: regresa con seguridad</h3>
          <ul>
            <li>No regreses a la costa hasta recibir la confirmación de Protección Civil.</li>
            <li>Evita el agua estancada: puede contener contaminación, cables o escombros.</li>
            <li>Revisa pozos y fuentes de agua antes de utilizarlos para consumo.</li>
          </ul>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- ============================================================
     SECCIÓN 7: HISTORIA
     ============================================================ -->
<section class="v-section" id="historia">
  <div class="wrap">
    <div class="v-header center">
      <span class="v-tag">07 · Memoria histórica</span>
      <h2 class="v-title">Antecedentes en la <span>costa salvadoreña</span></h2>
      <p class="v-sub">Eventos históricos que muestran la importancia de la preparación.</p>
    </div>
    <div class="tl-wrap"><div class="tl-line"></div><div class="tl-track" id="tlTrack-tsunamis"></div></div>
    <div class="tl-detail" id="tlDetail-tsunamis"></div>
    <div class="ts-timeline-nav" aria-label="Navegación de antecedentes">
      <button type="button" class="ts-timeline-btn" aria-label="Antecedente anterior" title="Antecedente anterior" onclick="ndaSetTimeline('tsunamis', Math.max(0, (window.__ndaTlActive.tsunamis || 0) - 1))">
        <svg viewBox="0 0 24 24" aria-hidden="true"><polyline points="15 18 9 12 15 6"></polyline></svg>
        <span>Anterior</span>
      </button>
      <button type="button" class="ts-timeline-btn" aria-label="Siguiente antecedente" title="Siguiente antecedente" onclick="ndaSetTimeline('tsunamis', Math.min((window.__ndaTlData.tsunamis || []).length - 1, (window.__ndaTlActive.tsunamis || 0) + 1))">
        <span>Siguiente</span>
        <svg viewBox="0 0 24 24" aria-hidden="true"><polyline points="9 18 15 12 9 6"></polyline></svg>
      </button>
    </div>
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

<!-- ============================================================
     SECCIÓN 8: GALERÍA
     ============================================================ -->
<section class="v-section v-section-dark" id="galeria">
  <div class="wrap">
    <div class="v-header center">
      <span class="v-tag">08 · Multimedia</span>
      <h2 class="v-title">Galería de <span>imágenes</span></h2>
      <p class="v-sub">Fotografías del mapa de amenaza, señalización de rutas y comunidades costeras.</p>
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

<!-- ============================================================
     SECCIÓN 9: FUENTES
     ============================================================ -->
<section class="v-section" id="fuentes">
  <div class="wrap">
    <div class="v-header center">
      <span class="v-tag">09 · Transparencia</span>
      <h2 class="v-title">Fuentes <span>oficiales</span> consultadas</h2>
      <p class="v-sub">Información pública utilizada para preparar este contenido.</p>
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
require_once __DIR__ . '/layout.php';
?>
