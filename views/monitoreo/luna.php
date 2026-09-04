<?php
$title = $title ?? 'Fases de la Luna - NDA';
$currentSlug = 'luna';
$user = $user ?? null;
$extraCss = ['css/luna.css'];
ob_start();
?>

<div class="luna-page" id="lunaRoot" style="padding-top: 84px;">
  <div class="luna-stars" aria-hidden="true"></div>
  <div class="wrap">

    <div class="luna-topnav">
      <a href="?url=monitoreo" class="luna-back-link">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Monitoreo
      </a>
      <a href="?url=clima" class="luna-switch-link">Ver Clima en Tiempo Real →</a>
    </div>

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
      </div>
    </div>

    <!-- INFORMACION ASTRONOMICA -->
    <div class="luna-section">
      <div class="luna-section-title">Información Astronómica</div>
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
    </div>

    <!-- DESCRIPCION DE LA FASE -->
    <div class="luna-section">
      <div class="luna-desc-card">
        <div class="luna-desc-hdr">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
          <span>¿Qué significa la fase de <strong id="lunaDescTitle">—</strong>?</span>
        </div>
        <p id="lunaDescBody">Calculando la fase lunar actual a partir del ciclo sinódico (29.53 días)…</p>
        <div class="luna-desc-illum">Iluminación actual: <strong id="lunaDescIllum">—</strong></div>
      </div>
    </div>

    <!-- CALENDARIO DE FASES -->
    <div class="luna-section">
      <div class="luna-section-title">Calendario de Fases</div>
      <div class="luna-next-cards" id="lunaNextCards"></div>
    </div>

    <!-- MAREAS -->
    <div class="luna-section">
      <div class="luna-section-title">Cómo Afecta la Luna a las Mareas</div>
      <div class="luna-tide-next" id="lunaTideNext"></div>
      <div class="luna-tide-grid">
        <div class="luna-tide-card spring">
          <div class="ltc-badge">Luna Nueva · Luna Llena</div>
          <div class="ltc-title">Mareas Vivas (Spring Tides)</div>
          <p>Ocurren cuando el Sol, la Luna y la Tierra se alinean, sumando su fuerza gravitacional. La diferencia entre marea alta y baja puede llegar a <strong>2.4 metros</strong> en el Pacífico de El Salvador.</p>
        </div>
        <div class="luna-tide-card neap">
          <div class="ltc-badge">Cuarto Creciente · Cuarto Menguante</div>
          <div class="ltc-title">Mareas Muertas (Neap Tides)</div>
          <p>El Sol y la Luna forman un ángulo de 90°, reduciendo su efecto combinado. La variación entre marea alta y baja es mínima — ideal para navegación costera.</p>
        </div>
        <div class="luna-tide-card fish">
          <div class="ltc-badge">Alta actividad pesquera</div>
          <div class="ltc-title">Pesca y Ciclo Lunar</div>
          <p>Pescadores de La Libertad y Acajutla calendarizan su actividad según el ciclo lunar: las mareas altas de luna llena y nueva suelen traer más peces al litoral.</p>
        </div>
        <div class="luna-tide-card warn">
          <div class="ltc-badge">Riesgo en mareas vivas</div>
          <div class="ltc-title">Riesgo Costero en El Salvador</div>
          <p>Zonas como Los Blancos y El Espino son vulnerables cuando una marea viva coincide con lluvia intensa. El MARN intensifica el monitoreo en temporada de huracanes.</p>
        </div>
      </div>
    </div>

    <!-- CURIOSIDADES -->
    <div class="luna-section">
      <div class="luna-curio-card">
        <div class="luna-section-title" style="margin-bottom:14px">Curiosidades</div>
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
    </div>

  </div>
</div>

<script src="<?= asset('js/nda-location.js') ?>"></script>
<script src="<?= asset('js/luna.js') ?>"></script>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout.php';
?>
