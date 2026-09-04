<?php
$title = $title ?? 'Puntos de Emergencia - NDA';
$currentSlug = 'emergencias';
$user = $user ?? null;
$extraCss = ['css/emergencias.css'];
ob_start();
?>

<div class="emg-page" id="emgRoot" style="padding-top: 84px;">
  <div class="wrap">

    <div class="emg-topnav">
      <a href="?url=monitoreo" class="emg-back-link">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Monitoreo
      </a>
    </div>

    <div class="emg-header">
      <div class="emg-eyebrow">Recursos Cercanos</div>
      <h1 class="emg-title">Puntos de Interés ante <span class="emg-acc">Emergencias</span></h1>
      <p class="emg-sub">Hospitales, albergues, estaciones de policía y de bomberos de El Salvador. Elige una categoría o un punto de la lista para ubicarlo en el mapa.</p>
    </div>

    <div class="poi-layout">
      <div class="poi-map-card" id="poiMapCard">
        <div class="phdr">
          <span class="rdot"></span> Mapa de Emergencia
          <div class="poi-map-legend">
            <span class="poi-legend-item"><i class="fa-solid fa-hospital" style="color:var(--red)"></i> Hospitales</span>
            <span class="poi-legend-item"><i class="fa-solid fa-tents" style="color:var(--purple)"></i> Albergues</span>
            <span class="poi-legend-item"><i class="fa-solid fa-shield-halved" style="color:var(--blue)"></i> Policía</span>
            <span class="poi-legend-item"><i class="fa-solid fa-fire-flame-curved" style="color:var(--acc3)"></i> Bomberos</span>
          </div>
        </div>
        <div id="poiMap"></div>
      </div>

      <div class="poi-panel">
        <div class="poi-filters" id="poiFilters">
          <button type="button" class="poi-filter-btn active" data-cat="hospital"><i class="fa-solid fa-hospital"></i> Hospitales</button>
          <button type="button" class="poi-filter-btn active" data-cat="albergue"><i class="fa-solid fa-tents"></i> Albergues</button>
          <button type="button" class="poi-filter-btn active" data-cat="policia"><i class="fa-solid fa-shield-halved"></i> Policía</button>
          <button type="button" class="poi-filter-btn active" data-cat="bomberos"><i class="fa-solid fa-fire-flame-curved"></i> Bomberos</button>
        </div>
        <div class="poi-list" id="poiList">
          <div class="loading-s"><div class="spin"></div>Ubicando puntos cercanos…</div>
        </div>
      </div>
    </div>

    <div class="poi-disclaimer">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
      <span>Ubicaciones de referencia recopiladas manualmente, pueden no reflejar cambios recientes. Ante una emergencia real, confirma siempre llamando al <strong>911</strong> (PNC) o <strong>913</strong> (Bomberos).</span>
    </div>

  </div>
</div>

<script src="<?= asset('js/nda-location.js') ?>"></script>
<script src="<?= asset('js/poi-map.js') ?>"></script>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout.php';
?>
