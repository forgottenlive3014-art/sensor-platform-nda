<?php
$title = $title ?? 'Fases de la Luna - NDA';
$currentSlug = 'luna';
$user = $user ?? null;
$extraCss = ['css/volcanes.css', 'css/luna.css'];
ob_start();
?>

<div class="luna-page" id="lunaRoot" style="padding-top: 104px;">
  <div class="luna-stars" aria-hidden="true"></div>
  <div class="wrap">

    <!-- ENCABEZADO -->
    <div class="luna-header">
      <div class="luna-eyebrow">Observación Astronómica</div>
      <div class="luna-loc-line">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
        <span id="lunaLoc">Detectando ubicación…</span>
        <span id="lunaLocNote" class="luna-approx-badge" style="display:none">Aproximada</span>
      </div>
      <div class="luna-date-line"><span id="lunaDate"></span> · <span id="lunaUpdated"></span></div>
    </div>

    <!-- TARJETA PRINCIPAL: MODELO 3D -->
    <section class="luna-block" id="bloque-3d">
    <div class="luna-hero-card">
      <div class="luna-hero-glow" aria-hidden="true"></div>

      <div class="luna-hero-layout">
        <div class="luna-phase-selector" id="lunaPhaseSelector"></div>

        <div class="luna-hero-center">
          <div class="luna-explore-status" id="lunaExploreStatus">
            <span class="les-dot" id="lunaExploreDot"></span>
            <span id="lunaExploreLabel">En vivo</span>
            <button type="button" id="lunaLiveBtn" style="display:none">Volver a tiempo real</button>
          </div>

          <div id="moon3dContainer" class="luna-moon3d"></div>
          <div class="luna-hero-info">
            <div class="luna-phase-name" id="lunaPhaseName">Calculando…</div>
            <div class="luna-illum-big" id="lunaIllumBig">—</div>
            <div class="luna-age-big" id="lunaAgeBig">—</div>
          </div>
        </div>

        <div class="luna-hero-description">
          <div class="luna-desc-card">
            <div class="luna-desc-kicker">02 · Fase actual</div>
            <div class="luna-desc-hdr">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
              <span>¿Qué significa la fase de <strong id="lunaDescTitle">—</strong>?</span>
            </div>
            <p id="lunaDescBody">Calculando la fase lunar actual a partir del ciclo sinódico (29.53 días)…</p>
            <div class="luna-desc-illum">Iluminación actual: <strong id="lunaDescIllum">—</strong></div>
          </div>
        </div>
      </div>
    </div>
    </section>

    <!-- INFORMACION ASTRONOMICA -->
    <section class="luna-block luna-section v-section" id="informacion-astronomica">
      <div class="v-header center">
        <span class="v-tag">01 · Observación</span>
        <h2 class="v-title">Información <span>astronómica</span></h2>
        <p class="v-sub">Datos actuales de la Luna y su posición para tu ubicación.</p>
      </div>
      <div class="luna-astro-grid">
        <div class="luna-astro-card">
          <div class="lac-lbl">Iluminación Lunar</div>
          <div class="lac-val" id="lunaCardIllum">—</div>
        </div>
        <div class="luna-astro-card">
          <div class="lac-lbl">Edad de la Luna</div>
          <div class="lac-val" id="lunaCardAge">—</div>
        </div>
        <div class="luna-astro-card">
          <div class="lac-lbl">Distancia Tierra–Luna</div>
          <div class="lac-val" id="lunaCardDistance">—</div>
        </div>
        <div class="luna-astro-card">
          <div class="lac-lbl">Ciclo Lunar Actual</div>
          <div class="lac-val" id="lunaCardCycle">—</div>
        </div>
        <div class="luna-astro-card">
          <div class="lac-lbl">Próxima Luna Llena</div>
          <div class="lac-val" id="lunaCardNextFull">—</div>
        </div>
      </div>
    </section>

    <!-- CONOCE LA LUNA -->
    <section class="luna-block luna-section v-section v-section-dark" id="conoce-la-luna">
      <div class="v-header center">
        <span class="v-tag">02 · Fundamentos</span>
        <h2 class="v-title">Conoce la <span>Luna</span></h2>
        <p class="v-sub">El satélite natural de la Tierra y su influencia sobre nuestro planeta.</p>
      </div>
      <div class="luna-knowledge-grid">
        <article class="luna-knowledge-card luna-knowledge-wide">
          <span class="luna-knowledge-number">01</span>
          <div class="luna-knowledge-icon">◐</div>
          <h3>¿Qué es la Luna?</h3>
          <p>Es el único satélite natural de la Tierra. No produce luz propia: refleja la luz del Sol y es uno de los cuerpos celestes más cercanos a nuestro planeta.</p>
        </article>
        <article class="luna-knowledge-card">
          <span class="luna-knowledge-number">02</span>
          <div class="luna-knowledge-icon">↔</div>
          <h3>La Luna y la Tierra</h3>
          <p>Se encuentra a una distancia media de <strong>384,400 km</strong>. Su gravedad influye especialmente en el movimiento de las mareas.</p>
        </article>
        <article class="luna-knowledge-card">
          <span class="luna-knowledge-number">03</span>
          <div class="luna-knowledge-icon">◌</div>
          <h3>Características</h3>
          <p>Diámetro de <strong>3,474 km</strong>, gravedad equivalente a un sexto de la terrestre y una superficie llena de cráteres, montañas y llanuras.</p>
        </article>
      </div>
      <div class="luna-facts-strip">
        <div><strong>4,500 M</strong><span>años de antigüedad</span></div>
        <div><strong>1/6</strong><span>de la gravedad terrestre</span></div>
        <div><strong>29.5 días</strong><span>duración del ciclo de fases</span></div>
      </div>
    </section>

    <!-- FASES Y EXPLORACION -->
    <section class="luna-block luna-section v-section" id="fases-exploracion">
      <div class="v-header center">
        <span class="v-tag">03 · Ciclo y exploración</span>
        <h2 class="v-title">Un ciclo de <span>fases y descubrimientos</span></h2>
        <p class="v-sub">La posición de la Luna cambia cómo la vemos y cómo la estudiamos.</p>
      </div>
      <div class="luna-cycle-panel">
        <div class="luna-cycle-visual" aria-hidden="true"><div class="luna-cycle-moon"></div><span>29.5 días</span></div>
        <div class="luna-cycle-copy">
          <div class="luna-cycle-line">
            <span class="luna-phase-dot new"></span><b>Luna nueva</b><i></i><span class="luna-phase-dot first"></span><b>Cuarto creciente</b><i></i><span class="luna-phase-dot full"></span><b>Luna llena</b><i></i><span class="luna-phase-dot last"></span><b>Cuarto menguante</b>
          </div>
          <p>Las fases ocurren por el movimiento de la Luna alrededor de la Tierra y su posición respecto al Sol. El ciclo completo dura aproximadamente <strong>29.5 días</strong>.</p>
        </div>
      </div>
      <div class="luna-explore-grid">
        <article><div class="luna-explore-media"><img src="assets/media/img/exploracionLunar.webp" alt="Exploración de la Luna" loading="lazy"></div><span class="luna-knowledge-number">04</span><h3>Exploración lunar</h3><p>Telescopios, sondas y misiones espaciales han permitido estudiar su origen y su superficie. En <strong>1969</strong>, Apollo 11 llevó a los primeros seres humanos a la Luna.</p></article>
        <article><div class="luna-explore-media"><img src="assets/media/img/SuperficieLunar.jpg" alt="Superficie de la Luna" loading="lazy"></div><span class="luna-knowledge-number">05</span><h3>Superficie lunar</h3><p>Sus “mares” no son océanos: son zonas oscuras formadas principalmente por antiguas erupciones volcánicas. También conserva cráteres, montañas y valles.</p></article>
        <article><div class="luna-explore-media"><img src="assets/media/img/laluna.webp" alt="La Luna y su importancia para la Tierra" loading="lazy"></div><span class="luna-knowledge-number">06</span><h3>Importancia</h3><p>Ayuda a comprender la historia del Sistema Solar y, mediante su gravedad, contribuye al funcionamiento de las mareas terrestres.</p></article>
      </div>
    </section>

    <!-- CALENDARIO DE FASES -->
    <section class="luna-block luna-section v-section" id="calendario-fases">
      <div class="v-header center">
        <span class="v-tag">04 · Calendario</span>
        <h2 class="v-title">Calendario de <span>fases</span></h2>
        <p class="v-sub">Próximos cambios visibles del ciclo lunar.</p>
      </div>
      <div class="luna-next-cards" id="lunaNextCards"></div>
    </section>

    <!-- MAREAS -->
    <section class="luna-block luna-section v-section v-section-dark" id="mareas">
      <div class="v-header center">
        <span class="v-tag">05 · Mareas</span>
        <h2 class="v-title">Cómo afecta la Luna a las <span>mareas</span></h2>
        <p class="v-sub">La relación entre el ciclo lunar, el océano y la costa salvadoreña.</p>
      </div>
      <div class="luna-tide-next" id="lunaTideNext"></div>
      <div class="luna-tide-grid">
        <div class="luna-tide-card spring luna-tide-feature">
          <div class="luna-tide-media"><img src="assets/media/img/costa.jpg" alt="Costa del Pacífico salvadoreño" loading="lazy"></div>
          <div class="luna-tide-content">
            <div class="ltc-badge">Luna Nueva · Luna Llena</div>
            <div class="ltc-title">Mareas Vivas</div>
            <p>El Sol, la Luna y la Tierra se alinean y suman su fuerza gravitacional. La diferencia entre marea alta y baja puede llegar a <strong>2.4 metros</strong> en el Pacífico de El Salvador.</p>
          </div>
        </div>
        <div class="luna-tide-card neap luna-tide-feature">
          <div class="luna-tide-media"><img src="assets/media/img/puerto.jpg" alt="Puerto en la costa salvadoreña" loading="lazy"></div>
          <div class="luna-tide-content">
            <div class="ltc-badge">Cuarto Creciente · Cuarto Menguante</div>
            <div class="ltc-title">Mareas Muertas</div>
            <p>El Sol y la Luna forman un ángulo de 90° y reducen su efecto combinado. La variación entre marea alta y baja es mínima, ideal para navegación costera.</p>
          </div>
        </div>
        <div class="luna-tide-card fish luna-tide-context">
          <div class="luna-tide-media"><img src="assets/media/img/costeras.jpg" alt="Comunidades costeras de El Salvador" loading="lazy"></div>
          <div class="luna-tide-content">
            <div class="ltc-badge">Alta actividad pesquera</div>
            <div class="ltc-title">Pesca y ciclo lunar</div>
            <p>Pescadores de La Libertad y Acajutla organizan su actividad según el ciclo lunar y las mareas altas.</p>
          </div>
        </div>
        <div class="luna-tide-card warn luna-tide-context">
          <div class="luna-tide-media"><img src="assets/media/img/inundación costera.jpg" alt="Inundación costera" loading="lazy"></div>
          <div class="luna-tide-content">
            <div class="ltc-badge">Riesgo en mareas vivas</div>
            <div class="ltc-title">Riesgo costero</div>
            <p>Los Blancos y El Espino son vulnerables cuando una marea viva coincide con lluvia intensa.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- CURIOSIDADES -->
    <section class="luna-block luna-section v-section" id="curiosidades">
      <div class="luna-curio-card">
        <div class="v-header center" style="margin-bottom:24px">
          <span class="v-tag">06 · Curiosidades</span>
          <h2 class="v-title">Curiosidades de la <span>Luna</span></h2>
        </div>
        <div class="luna-curio-grid">
          <div class="luna-curio-item">
            <div class="lci-icon lci-icon-a"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 1 1-3-6.7"/><polyline points="21 3 21 9 15 9"/></svg></div>
            <div class="lci-title">Ciclo sinódico</div>
            <p>La Luna tarda 29.53 días en completar un ciclo de fases (de Luna Nueva a Luna Nueva), aunque orbita la Tierra en solo 27.3 días — la diferencia se debe a que la Tierra también se mueve alrededor del Sol.</p>
          </div>
          <div class="luna-curio-item">
            <div class="lci-icon lci-icon-b"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12c1.5-1.5 3-1.5 4.5 0s3 1.5 4.5 0 3-1.5 4.5 0 3 1.5 4.5 0"/><path d="M2 18c1.5-1.5 3-1.5 4.5 0s3 1.5 4.5 0 3-1.5 4.5 0 3 1.5 4.5 0"/></svg></div>
            <div class="lci-title">Influencia en la Tierra</div>
            <p>La gravedad lunar es la principal responsable de las mareas oceánicas. En Luna Nueva y Llena, el Sol y la Luna se alinean y producen las mareas vivas, de mayor amplitud.</p>
          </div>
          <div class="luna-curio-item">
            <div class="lci-icon lci-icon-c"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="4" cy="12" r="2"/><circle cx="12" cy="12" r="3.2"/><circle cx="20" cy="12" r="2.4"/><line x1="6.2" y1="12" x2="8.6" y2="12"/><line x1="15.4" y1="12" x2="17.4" y2="12"/></svg></div>
            <div class="lci-title">Sol, Tierra y Luna</div>
            <p>Cada fase depende del ángulo entre el Sol, la Tierra y la Luna: vemos iluminada la porción de la superficie lunar que refleja luz solar hacia nosotros en cada punto de su órbita.</p>
          </div>
          <div class="luna-curio-item">
            <div class="lci-icon lci-icon-d"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 15l-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"/><path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"/><path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"/><path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2"/></svg></div>
            <div class="lci-title">Exploración lunar</div>
            <p>Desde el alunizaje del Apolo 11 en 1969, doce astronautas han caminado sobre la Luna. Hoy varias misiones internacionales buscan volver a establecer presencia humana permanente allí.</p>
          </div>
        </div>
      </div>
    </section>

  </div>
</div>

<script src="<?= asset('js/nda-location.js') ?>"></script>
<script src="<?= asset('js/luna.js') ?>"></script>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout.php';
?>
