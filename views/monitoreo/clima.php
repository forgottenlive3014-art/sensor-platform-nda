<?php
$title = $title ?? 'Clima en Tiempo Real - NDA';
$currentSlug = 'clima';
$user = $user ?? null;
$extraCss = ['css/clima.css'];
ob_start();
?>

<div class="clima-page" id="climaRoot" style="padding-top: 84px;" data-owm-key="<?= e(env('OPENWEATHER_API_KEY', '')) ?>">

  <div class="clima-atmosphere" aria-hidden="true">
    <div class="clima-sun-glow" id="climaSunGlow"></div>
    <div class="clima-cloud-blob c1"></div>
    <div class="clima-cloud-blob c2"></div>
    <div class="clima-cloud-blob c3"></div>
    <div class="clima-stars" id="climaStars"></div>
  </div>

  <div class="wrap">

    <!-- HERO: lo unico visible al entrar, centrado, sin scroll -->
    <div class="clima-hero">
      <div class="clima-hero-inner">

        <div class="clima-hero-text">
          <div class="clima-hero-head">
            <div class="clima-loc-line">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
              <span id="climaLoc">Detectando ubicación…</span>
              <span id="climaLocNote" class="clima-approx-badge" style="display:none">Aproximada</span>
            </div>
            <div class="clima-date-line"><span id="climaDate"></span> · <span id="climaUpdated"></span></div>
          </div>

          <div class="clima-hero-main">
            <div class="clima-hero-temp-wrap">
              <div class="clima-hero-temp" id="climaTemp">—°</div>
              <div class="clima-hero-icon" id="climaIconBig"><div class="loading-s"><div class="spin"></div></div></div>
            </div>
            <div class="clima-hero-cond" id="climaCondLabel">Cargando…</div>
            <div class="clima-hero-sub">
              <span id="climaFeels">Sensación —°</span>
              <span class="chs-sep">·</span>
              <span id="climaHiLo">—</span>
            </div>
          </div>

          <div class="clima-sky-line" id="climaSkyLine">Analizando el cielo…</div>

          <div class="clima-indicators-row" id="climaIndicators"></div>
        </div>

        <div class="clima-hero-image">
          <img id="climaWxImage" src="assets/media/img/clima/soleado.png" alt="Ilustración del clima actual">
        </div>

      </div>

      <a href="#climaMapCard" class="clima-scroll-hint" aria-label="Desplázate para ver más">
        <span>Desplázate para ver más</span>
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
      </a>
    </div>

    <!-- MAPA -->
    <div class="clima-map-card" id="climaMapCard">
      <div class="clima-card-hdr">
        <span class="cch-dot"></span>Mapa Meteorológico
        <div class="clima-map-layers">
          <button type="button" class="clima-layer-btn active" id="climaLayerRain">Lluvia</button>
          <button type="button" class="clima-layer-btn" id="climaLayerCloud">Nubosidad</button>
        </div>
        <button type="button" class="clima-map-expand-btn" id="climaMapExpand" aria-label="Ampliar mapa">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 3 21 3 21 9"/><polyline points="9 21 3 21 3 15"/><line x1="21" y1="3" x2="14" y2="10"/><line x1="3" y1="21" x2="10" y2="14"/></svg>
        </button>
      </div>
      <div id="climaMap"></div>
    </div>

    <!-- MAPA OPENWEATHERMAP: capas independientes del radar de RainViewer de arriba -->
    <div class="clima-map-card" id="climaMapOwmCard">
      <div class="clima-card-hdr">
        <span class="cch-dot"></span>Mapa OpenWeatherMap
        <div class="clima-map-layers">
          <button type="button" class="clima-layer-btn active" id="climaOwmLayerPrecip" data-owm-layer="precipitation_new">Precipitación</button>
          <button type="button" class="clima-layer-btn" id="climaOwmLayerClouds" data-owm-layer="clouds_new">Nubes</button>
          <button type="button" class="clima-layer-btn" id="climaOwmLayerTemp" data-owm-layer="temp_new">Temperatura</button>
          <button type="button" class="clima-layer-btn" id="climaOwmLayerWind" data-owm-layer="wind_new">Viento</button>
        </div>
        <button type="button" class="clima-map-expand-btn" id="climaMapOwmExpand" aria-label="Ampliar mapa">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 3 21 3 21 9"/><polyline points="9 21 3 21 3 15"/><line x1="21" y1="3" x2="14" y2="10"/><line x1="3" y1="21" x2="10" y2="14"/></svg>
        </button>
      </div>
      <div id="climaMapOwm"></div>
    </div>

    <!-- PRONOSTICO POR HORAS -->
    <div class="clima-section">
      <div class="clima-section-title">Próximas 24 horas</div>
      <div class="clima-hourly-card">
        <div class="clima-hourly-scroll">
          <div class="clima-hourly-strip" id="climaHourly"><div class="loading-s"><div class="spin"></div>Cargando…</div></div>
        </div>
      </div>
    </div>

    <!-- PRONOSTICO SEMANAL -->
    <div class="clima-section">
      <div class="clima-section-title">Pronóstico de 7 días</div>
      <div class="clima-daily-card">
        <div class="clima-daily-scroll">
          <div class="clima-daily-strip" id="climaDaily"><div class="loading-s"><div class="spin"></div>Cargando…</div></div>
        </div>
      </div>
    </div>

    <!-- ALERTAS (solo si existen) -->
    <div class="clima-alerts" id="climaAlerts" style="display:none"></div>

    <!-- RECOMENDACIONES -->
    <div class="clima-section">
      <div class="clima-section-title">Recomendaciones</div>
      <div class="clima-recs" id="climaRecs"></div>
    </div>

  </div>
</div>

<script src="<?= asset('js/nda-location.js') ?>"></script>
<script src="<?= asset('js/clima.js') ?>"></script>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout.php';
?>
