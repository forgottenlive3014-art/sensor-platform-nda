<?php
$title = $title ?? 'NDA · Natural Disaster Alert';
$user = $user ?? null;
ob_start();
?>

<section class="hero3d" id="home">
  <div class="hero3d-sticky">
    <div id="globeViz"></div>
    <div class="hero3d-vignette"></div>

    <div class="h3d-phase h3d-phase-1 active" data-phase="1">
      <div class="wrap h3d-phase1-inner">
        <div class="hi-left">
          <div class="hero-eyebrow"><span class="pulsedot"></span>Plataforma Educativa — El Salvador</div>
          <h1 class="hero-h1">
            <span class="h1-w">Natural</span>
            <span class="h1-r">Disaster</span>
            <span class="h1-g">Alert System</span>
          </h1>
          <p class="hero-sub">Monitoreo sísmico en tiempo real, simulaciones interactivas y educación en prevención de desastres para la comunidad escolar salvadoreña.</p>
          <div class="hero-pills">
            <div class="hp"><strong id="hp-quakes">—</strong> sismos hoy</div>
            <div class="hp"><strong>7.7</strong> magnitud máx. histórica</div>
            <div class="hp"><strong>26</strong> volcanes</div>
            <div class="hp"><strong>2</strong> placas tectónicas</div>
          </div>
          <div class="hero-cta">
            <a href="?url=home#sismos" class="btn-acc"> Monitor Sísmico</a>
            <a href="?url=home#arduino" class="btn-out"> Demo Arduino</a>
          </div>
        </div>
        <div class="hi-right">
          <div class="hero-monitor">
            <div class="hm-top">
              <div class="hm-dots"><span></span><span></span><span></span></div>
              <span class="hm-label">seismic_monitor.live</span>
              <div class="hm-live"><span class="ldot"></span>EN VIVO</div>
            </div>
            <div class="hm-body">
              <canvas id="heroSg"></canvas>
              <div class="hm-mini">
                <div class="hmm"><div class="hmm-v" id="hm-today">—</div><div class="hmm-l">Hoy</div></div>
                <div class="hmm"><div class="hmm-v" id="hm-max">—</div><div class="hmm-l">Mag. Máx</div></div>
                <div class="hmm"><div class="hmm-v" id="hm-depth">—</div><div class="hmm-l">Prof. km</div></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="h3d-phase h3d-phase-2" data-phase="2">
      <div class="h3d-region-label">
        <span class="h3d-region-eyebrow">Acercando</span>
        <h2>Centroamérica</h2>
        <p>Una de las regiones con mayor actividad sísmica del planeta, sobre el llamado Cinturón de Fuego del Pacífico.</p>
      </div>
    </div>

    <div class="h3d-phase h3d-phase-3" data-phase="3">
      <div class="h3d-region-label h3d-region-label-sv">
        <span class="h3d-region-eyebrow">El Salvador</span>
        <h2>El país más pequeño de Centroamérica, uno de los más sísmicos</h2>
      </div>
      <div class="h3d-cards">
        <div class="h3d-card">
          <span class="h3d-card-ico"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg></span>
          <strong>¿Por qué tantos sismos?</strong>
          <p>El Salvador está sobre el límite entre la Placa de Cocos y la Placa del Caribe, una de las zonas de subducción más activas del mundo.</p>
        </div>
        <div class="h3d-card">
          <span class="h3d-card-ico"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5M2 12l10 5 10-5"/></svg></span>
          <strong>Placas tectónicas</strong>
          <p>La subducción de la Placa de Cocos bajo la Placa del Caribe genera sismos frecuentes y actividad volcánica en toda la cordillera.</p>
        </div>
        <div class="h3d-card">
          <span class="h3d-card-ico"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></span>
          <strong>Actividad reciente</strong>
          <p id="h3d-actividad-reciente">Consultando datos sísmicos de las últimas 24 horas…</p>
        </div>
        <div class="h3d-card">
          <span class="h3d-card-ico"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.3 3.9L1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg></span>
          <strong>Riesgos principales</strong>
          <p>Sismos, erupciones volcánicas, deslizamientos y tsunamis en la costa del Pacífico son los fenómenos que más afectan al país.</p>
        </div>
      </div>
    </div>

    <div class="scroll-hint"><span>Scroll</span><div class="sh-arr"></div></div>
  </div>
  <div class="hero3d-spacer"></div>
</section>

<!-- S1: SEISMIC MONITOR -->
<section class="sec sec-dark" id="sismos">
  <div class="wrap">
    <div class="rt-monitor-hero">
      <div class="rtm-top-bar">
        <div class="rtm-badge active"><span class="live-dot"></span>Sistema Activo</div>
        <span style="font-size:.7rem;color:var(--text3);margin-left:4px">Red Sísmica Nacional · MARN El Salvador · USGS</span>
        <span style="margin-left:auto;font-size:.7rem;color:var(--text3)" id="rtmClock">—</span>
      </div>
      <div class="rtm-title-area">
        <div class="rtm-eyebrow"> Sección 01</div>
        <div class="rtm-h2">Monitor Sísmico <span class="rtm-accent">en<br>Tiempo Real</span></div>
        <div class="rtm-sub">Datos en vivo del USGS — Región de Centroamérica y El Salvador</div>
      </div>
      <div class="rtm-stats-row">
        <div class="rtm-stat"><div class="rtm-stat-val acc" id="rtm-today">—</div><div class="rtm-stat-lbl">Sismos Hoy</div></div>
        <div class="rtm-stat"><div class="rtm-stat-val teal" id="rtm-mag">—</div><div class="rtm-stat-lbl">última Magnitud</div></div>
        <div class="rtm-stat"><div class="rtm-stat-val blue" id="rtm-depth">—</div><div class="rtm-stat-lbl">Profundidad</div></div>
        <div class="rtm-stat"><div class="rtm-stat-val green">~100</div><div class="rtm-stat-lbl">Sismos/Año El SV</div></div>
      </div>
      <div class="intensity-row">
        <span class="int-label">Intensidad:</span>
        <button class="int-btn leve active" onclick="setIntensity('leve',this)"><span class="int-dot g"></span>Leve</button>
        <button class="int-btn mod" onclick="setIntensity('moderado',this)"><span class="int-dot y"></span>Moderado</button>
        <button class="int-btn fuerte" onclick="setIntensity('fuerte',this)"><span class="int-dot r"></span>Fuerte</button>
        <span class="int-mag-range" id="intMagRange">M 1.0 — 3.4</span>
      </div>
      <div class="shake-viz">
        <div class="shake-status" id="shakeStatus"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><polyline points="20 6 9 17 4 12"/></svg> SACUDIDA LEVE</div>
        <div class="buildings-row" id="buildingsRow"></div>
      </div>
    </div>

    <div class="sec-hd" style="display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:12px">
      <div>
        <div class="page-eyebrow">Actividad Sísmica · El Salvador</div>
        <div class="page-title">Sismógrafo <span class="acc">Interactivo</span></div>
      </div>
      <button class="btn-acc" id="simBtn" style="font-size:.82rem;padding:9px 18px"> Simular sismo</button>
    </div>
    <div class="pt-rule"></div>
    <div class="seismo-layout">
      <div>
        <div class="sg-main-card">
          <div class="phdr">
            <div style="width:32px;height:32px;background:rgba(255,77,26,.15);border-radius:var(--rs);display:flex;align-items:center;justify-content:center;font-size:.9rem;flex-shrink:0"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M8 21l4-13 4 13"/><circle cx="12" cy="6" r="1.4"/><path d="M12 6l-1.5 3M12 6l1.5 3"/></svg></div>
            <div>
              <div style="font-weight:700;color:var(--text);font-size:.85rem">Sismógrafo Interactivo — El Salvador</div>
              <div style="font-size:.7rem;color:var(--text3)" id="sgSubtitle">Estación SSN · San Salvador · 13.692°N, 89.218°W · EN VIVO</div>
            </div>
            <div class="hm-live" style="margin-left:auto"><span class="ldot"></span>EN VIVO</div>
            <div style="font-size:.72rem;color:var(--text3);background:var(--bg3);padding:4px 10px;border-radius:100px;margin-left:8px" id="sgFreqLabel">Frecuencia media</div>
          </div>
          <div class="sg-wave-area">
            <div class="sg-depth-badge">PROFUNDIDAD: <strong id="sgDepth">36 KM</strong></div>
            <canvas id="mainSg"></canvas>
          </div>
          <div class="sg-controls">
            <button class="sg-preset m3 on" data-mag="3" data-cls="m3">M3 <span style="font-size:.65rem;opacity:.7">leve</span></button>
            <button class="sg-preset m6" data-mag="6" data-cls="m6">M6 <span style="font-size:.65rem;opacity:.7">moderado</span></button>
            <button class="sg-preset m7" data-mag="7" data-cls="m7">M7 <span style="font-size:.65rem;opacity:.7">fuerte</span></button>
            <button class="sg-preset m85" data-mag="8.5" data-cls="m85">M8.5 <span style="font-size:.65rem;opacity:.7">gran terremoto</span></button>
            <button class="sg-reset" id="sgReset"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/></svg> Reiniciar</button>
            <div class="sg-mag-slider">
              <label>Magnitud:</label>
              <input type="range" class="sg-slider" id="sgMagSlider" min="1" max="9" step=".1" value="3"/>
              <span class="sg-mag-val" id="sgMagDisp">3</span>
            </div>
          </div>
          <div class="sg-stats-bar">
            <div class="sgstat"><div class="sgstat-lbl">último Evento</div><div class="sgstat-val acc" id="sg-last-mag">M—</div><div class="sgstat-sub" id="sg-last-loc">—</div></div>
            <div class="sgstat"><div class="sgstat-lbl">Profundidad</div><div class="sgstat-val" id="sg-depth-v">— km</div><div class="sgstat-sub" id="sg-depth-l">—</div></div>
            <div class="sgstat"><div class="sgstat-lbl">Sismos Hoy</div><div class="sgstat-val teal" id="sg-today">—</div><div class="sgstat-sub">promedio: 9/día</div></div>
            <div class="sgstat"><div class="sgstat-lbl">Zona Tectónica</div><div class="sgstat-val" style="font-size:1rem">Cocos/Caribe</div><div class="sgstat-sub">Subducción activa</div></div>
          </div>
        </div>
        <div style="margin-top:14px;background:var(--card);border:1px solid var(--border2);border-radius:var(--r);overflow:hidden">
          <div class="phdr"><span class="ldot"></span>Sismos Recientes — USGS API <button class="sg-reset" id="refreshQ" style="margin-left:auto;padding:4px 11px"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/></svg></button></div>
          <div id="quakeFeed"><div class="loading-s"><div class="spin"></div>Cargando datos USGS…</div></div>
        </div>
      </div>
      <div class="side-mini">
        <div class="smc"><div class="smc-lbl">último Evento</div><div class="smc-val acc" id="sc-last">—</div></div>
        <div class="smc"><div class="smc-lbl">Profundidad</div><div class="smc-val" id="sc-depth">—<span style="font-size:.8rem;color:var(--text3)">km</span></div></div>
        <div class="smc"><div class="smc-lbl">Sismos (24h)</div><div class="smc-val teal" id="sc-24h">—</div></div>
        <div class="smc"><div class="smc-lbl">última detección</div><div class="smc-val sm" id="sc-time">—</div></div>
        <div class="smc" style="padding:0;overflow:hidden">
          <div class="phdr"><span class="ldot"></span>Micro-sismógrafo</div>
          <div style="padding:10px"><canvas id="microSg" style="width:100%;height:55px;background:var(--bg3);border-radius:var(--rs)"></canvas></div>
        </div>
      </div>
    </div>
    <div class="facts-bar">
      <div class="fbi"><div class="fbi-n">~100</div><div class="fbi-l">sismos perceptibles/año</div></div>
      <div class="fbi"><div class="fbi-n">8cm</div><div class="fbi-l">subducción anual Cocos</div></div>
      <div class="fbi"><div class="fbi-n">26</div><div class="fbi-l">volcanes en territorio</div></div>
      <div class="fbi"><div class="fbi-n">7.7</div><div class="fbi-l">magnitud máx. 2001</div></div>
    </div>
    <div class="tectonic-banner" style="margin-top:18px">
      <div class="tb-inner" id="tbInner">
        <div class="tb-item"><span class="tb-icon"></span>Placa de Cocos subduce a ~8 cm/año bajo la Placa del Caribe</div>
        <div class="tb-item"><span class="tb-icon"></span>El Salvador registra ~100 sismos perceptibles por año</div>
        <div class="tb-item"><span class="tb-icon"></span>Ondas P viajan a ~6 km/s — llegan primero al sismógrafo</div>
        <div class="tb-item"><span class="tb-icon"></span>Falla Metrópolis atraviesa San Salvador — 15 km de longitud</div>
        <div class="tb-item"><span class="tb-icon"></span>Red Sísmica MARN opera 30+ estaciones en todo el país</div>
        <div class="tb-item"><span class="tb-icon"></span>Volcán Izalco activo — apodado "El Faro del Pacífico"</div>
        <div class="tb-item"><span class="tb-icon"></span>Placa de Cocos subduce a ~8 cm/año bajo la Placa del Caribe</div>
        <div class="tb-item"><span class="tb-icon"></span>El Salvador registra ~100 sismos perceptibles por año</div>
        <div class="tb-item"><span class="tb-icon"></span>Ondas P viajan a ~6 km/s — llegan primero al sismógrafo</div>
        <div class="tb-item"><span class="tb-icon"></span>Falla Metrópolis atraviesa San Salvador — 15 km de longitud</div>
        <div class="tb-item"><span class="tb-icon"></span>Red Sísmica MARN opera 30+ estaciones en todo el país</div>
        <div class="tb-item"><span class="tb-icon"></span>Volcán Izalco activo — apodado "El Faro del Pacífico"</div>
      </div>
    </div>
  </div>
</section>

<!-- S2: PLACAS TECTÓNICAS -->
<section class="sec" id="placas">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Geodinámica · Centroamérica</div>
      <h2 class="sec-title">Placas <span class="acc">Tectónicas</span></h2>
      <p class="sec-sub">Cómo el movimiento de la tierra genera terremotos</p>
    </div>
    <div class="plates-grid">
      <div class="plate-card">
        <div class="pc-visual"><canvas id="plateCv" width="280" height="170"></canvas></div>
        <div class="pc-body"><h4>Subducción</h4><p>La <strong>Placa de Cocos</strong> se hunde bajo la Placa del Caribe en la zona de subducción frente a la costa salvadoreña. Esta colisión genera enormes presiones.</p></div>
      </div>
      <div class="plate-card">
        <div class="pc-visual"><div class="wave-rings"><div class="wr"></div><div class="wr"></div><div class="wr"></div><div class="wr"></div><div class="wc-star"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><polygon points="12,2 15,9 22,9.5 16.5,14 18,21 12,17.5 6,21 7.5,14 2,9.5 9,9" fill="currentColor"/></svg></div></div></div>
        <div class="pc-body"><h4>Ondas Sísmicas</h4><p>Cuando la tensión acumulada se libera, genera <strong>ondas sísmicas P</strong> (primarias) y <strong>ondas S</strong> (secundarias) que viajan a través de la corteza terrestre.</p></div>
      </div>
      <div class="plate-card">
        <div class="pc-visual"><div class="richter-vis"><div class="rv-bar" style="width:25%">1–2</div><div class="rv-bar" style="width:38%">3–4</div><div class="rv-bar" style="width:52%">5</div><div class="rv-bar" style="width:65%">6</div><div class="rv-bar" style="width:80%">7</div><div class="rv-bar hl" style="width:100%">8+</div></div></div>
        <div class="pc-body"><h4>Escala de Richter</h4><p>La magnitud mide la energía liberada. Cada número representa <strong>10 veces más amplitud</strong> y ~32 veces más energía que el anterior.</p></div>
      </div>
    </div>
    <div class="plate-bar">
      <div class="pb-badge pb-cocos">Placa de Cocos</div>
      <div class="pb-arr"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg> subduce <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></div>
      <div class="pb-badge pb-carib">Placa del Caribe</div>
      <div class="pb-res">= Terremotos + Volcanes en El Salvador</div>
    </div>
  </div>
</section>

<!-- S3: EARTHQUAKE SIMULATOR -->
<section class="sec sec-dark" id="sim-section">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Simulación Interactiva</div>
      <h2 class="sec-title">Simulador de <span class="acc2">Movimiento Sísmico</span></h2>
      <p class="sec-sub">Visualiza cómo un sismo afecta estructuras según magnitud, profundidad y distancia</p>
    </div>
    <div class="sim-layout">
      <div class="sim-ctrl-card">
        <div class="phdr"><span class="wdot"></span>Parámetros del Sismo</div>
        <div class="scp"><div class="scp-lbl">Magnitud <span id="simMagV">5.0</span></div><input type="range" class="scp-range" id="simMag" min="1" max="9" step=".1" value="5"/><div class="scp-ticks"><span>1.0</span><span>3.0</span><span>5.0</span><span>7.0</span><span>9.0</span></div></div>
        <div class="scp"><div class="scp-lbl">Profundidad <span id="simDepV">30 km</span></div><input type="range" class="scp-range" id="simDep" min="5" max="200" step="5" value="30"/><div class="scp-ticks"><span>5km</span><span>50km</span><span>100km</span><span>200km</span></div></div>
        <div class="scp"><div class="scp-lbl">Distancia <span id="simDistV">50 km</span></div><input type="range" class="scp-range" id="simDist" min="10" max="500" step="10" value="50"/><div class="scp-ticks"><span>10km</span><span>100km</span><span>250km</span><span>500km</span></div></div>
        <div class="scp"><button class="btn-acc" style="width:100%;justify-content:center" id="runSim">▶ Simular</button></div>
        <div class="mercalli-box" id="mercalliBox">Ajusta los parámetros y presiona Simular.</div>
      </div>
      <div class="sim-scene-card">
        <div class="ssc-hdr"><span class="wdot"></span><span id="simSceneTitle">Ciudad ficticia — 50km del epicentro</span><div class="chip o" id="simMagChip" style="margin-left:auto">M 5.0</div></div>
        <canvas id="simCanvas"></canvas>
        <div class="sim-ib"><span class="sib-lbl">Intensidad</span><div class="sib-track"><div class="sib-fill" id="sibFill" style="width:40%"></div></div><span class="sib-val" id="sibVal">40%</span></div>
      </div>
    </div>
  </div>
</section>

<!-- S4: TIMELINE -->
<section class="sec" id="timeline">
  <div class="wrap">
    <div class="sec-hd"><div class="sec-eyebrow">Historia Sísmica · El Salvador</div><h2 class="sec-title">Línea del <span class="acc">Tiempo</span></h2><p class="sec-sub">Los terremotos más significativos en la historia del país</p></div>
    <div class="tl-wrap"><div class="tl-line"></div><div class="tl-track" id="tlTrack"></div></div>
    <div class="tl-detail" id="tlDetail"></div>
  </div>
</section>

<!-- S7: WEATHER -->
<section class="sec sec-dark" id="clima">
  <div class="wrap">
    <div class="sec-hd"><div class="page-eyebrow" style="color:var(--blue)">Meteorología · El Salvador</div><div class="page-title">Clima, Lluvia <span class="acc3">& Sol</span></div></div>
    <div class="weather-cities" id="weatherCities"><div class="loading-s"><div class="spin"></div>Cargando datos de clima…</div></div>
    <div class="weather-bottom">
      <div class="solar-card"><div class="sc-hdr">Recorrido Solar — San Salvador</div><div class="sc-canvas-wrap"><canvas id="sunArc"></canvas></div><div class="sc-sunboxes"><div class="sc-sunbox"><div class="sc-sunbox-emoji"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M17 18a5 5 0 0 0-10 0"/><line x1="12" y1="2" x2="12" y2="9"/><line x1="4.2" y1="10.2" x2="5.6" y2="11.6"/><line x1="1" y1="18" x2="3" y2="18"/><line x1="21" y1="18" x2="23" y2="18"/><line x1="18.4" y1="11.6" x2="19.8" y2="10.2"/><line x1="1" y1="22" x2="23" y2="22"/></svg></div><div class="sc-sunbox-time" id="sunriseBig">—</div><div class="sc-sunbox-lbl">Amanecer</div></div><div class="sc-sunbox"><div class="sc-sunbox-emoji"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M3 21V9l6-4v16M13 21V13l6-4v12"/><line x1="3" y1="21" x2="21" y2="21"/></svg></div><div class="sc-sunbox-time" id="sunsetBig">—</div><div class="sc-sunbox-lbl">Atardecer</div></div></div><div class="sc-dur" id="sunDur">—</div></div>
      <div class="precip-card"><div class="prec-hdr"> Precipitación Mensual (mm)</div><div class="prec-chart" id="precipChart"></div></div>
    </div>
    <div class="weather-extra">
      <div class="we-radar">
        <div class="phdr"><span class="wdot"></span>Radar Meteorológico<div class="chip o" style="margin-left:auto">— Vigilancia</div></div>
        <div class="radar-body" id="radarBody">
          <div class="radar-ring"></div><div class="radar-ring"></div><div class="radar-ring"></div><div class="radar-ring"></div>
          <div class="radar-cross"></div><div class="radar-cross-h"></div><div class="radar-sweep-line"></div>
          <canvas id="radarCanvas" style="position:absolute;inset:0;width:100%;height:100%;pointer-events:none;z-index:2"></canvas>
          <div class="radar-center-dot"></div><div class="radar-city">San Salvador</div>
        </div>
        <div class="radar-legend">
          <span style="font-size:.67rem;font-weight:700;color:var(--text2);margin-right:4px">Precipitación:</span>
          <div class="radar-legend-item"><div class="rl-dot" style="background:#22c55e"></div>Nula</div>
          <div class="radar-legend-item"><div class="rl-dot" style="background:#3b82f6"></div>Ligera</div>
          <div class="radar-legend-item"><div class="rl-dot" style="background:#f97316"></div>Moderada</div>
          <div class="radar-legend-item"><div class="rl-dot" style="background:#ef4444"></div>Intensa</div>
          <div id="radarStatus" class="chip o" style="margin-left:auto;font-size:.65rem">— Vigilancia</div>
        </div>
      </div>
      <div class="we-alerts">
        <div class="phdr"><span class="ldot"></span>Alertas y Avisos</div>
        <div class="alert-list">
          <div class="al-item"><div class="al-dot orange"></div><div><strong>Vigilancia costera activa</strong>Zona de baja presión en el Pacífico. Probabilidad 40% de desarrollo en 5 días.</div></div>
          <div class="al-item"><div class="al-dot blue"></div><div><strong>Ríos Lempa y Grande en vigilancia</strong>Niveles elevados por lluvias en cabeceras. Monitoreo continuo MARN.</div></div>
          <div class="al-item"><div class="al-dot green"></div><div><strong>Sin alerta de tsunami</strong>Sistema IOC-UNESCO en estado normal. Mar en calma en toda la costa.</div></div>
        </div>
        <div class="storms-table" style="border-top:1px solid var(--border)">
          <div class="st-hdr">Tormentas más dañinas</div>
          <div class="st-row"><span class="st-name">Mitch 1998</span><span class="st-victims">240 víctimas</span><span class="st-cat c5">Categ. 5</span></div>
          <div class="st-row"><span class="st-name">Ida 2009</span><span class="st-victims">198 víctimas</span><span class="st-cat ct">Tormenta</span></div>
          <div class="st-row"><span class="st-name">Amanda 2020</span><span class="st-victims">inundaciones</span><span class="st-cat c1">Cat. 1</span></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- S8: MOON -->
<section class="sec" id="luna">
  <div class="wrap">
    <div class="sec-hd"><div class="sec-eyebrow">Astronomía · Mareas</div><h2 class="sec-title">Fases Lunares y <span class="acc2">Mareas</span></h2><p class="sec-sub">Explora el ciclo lunar completo y su influencia en las mareas del Pacífico salvadoreño</p></div>
    <div class="moon-layout">
      <div class="moon-vis-card">
        <div class="moon-phase-selector" id="moonPhaseSelector">
          <button class="mps-btn" data-phase="0"><span><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><circle cx="12" cy="12" r="9" fill="currentColor"/></svg></span><span class="mps-lbl">Nueva</span></button>
          <button class="mps-btn" data-phase="1"><span><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M12 3a9 9 0 0 0 0 18z" fill="currentColor" opacity="0.5"/><circle cx="12" cy="12" r="9"/></svg></span><span class="mps-lbl">Creciente</span></button>
          <button class="mps-btn" data-phase="2"><span><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M12 3a9 9 0 0 0 0 18z" fill="currentColor"/><circle cx="12" cy="12" r="9"/></svg></span><span class="mps-lbl">Cuarto Crec.</span></button>
          <button class="mps-btn" data-phase="3"><span><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M12 3a9 9 0 0 1 0 18z" fill="currentColor" opacity="0.85"/><circle cx="12" cy="12" r="9"/></svg></span><span class="mps-lbl">Gibosa Crec.</span></button>
          <button class="mps-btn" data-phase="4"><span><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><circle cx="12" cy="12" r="9"/></svg></span><span class="mps-lbl">Llena</span></button>
          <button class="mps-btn" data-phase="5"><span><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M12 3a9 9 0 0 1 0 18z" fill="currentColor" opacity="0.5"/><circle cx="12" cy="12" r="9"/></svg></span><span class="mps-lbl">Gibosa Men.</span></button>
          <button class="mps-btn" data-phase="6"><span><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M12 3a9 9 0 0 1 0 18z" fill="currentColor"/><circle cx="12" cy="12" r="9"/></svg></span><span class="mps-lbl">Cuarto Men.</span></button>
          <button class="mps-btn" data-phase="7"><span><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M12 3a9 9 0 0 0 0 18z" fill="currentColor" opacity="0.85"/><circle cx="12" cy="12" r="9"/></svg></span><span class="mps-lbl">Menguante</span></button>
        </div>
        <div class="moon-canvas-wr"><canvas id="moonCv" width="170" height="170"></canvas><div class="moon-glow-el" id="moonGlowEl"></div></div>
        <div class="moon-name" id="moonName">Calculando…</div>
        <div class="moon-date-str" id="moonDateStr"></div>
        <div class="moon-next-date" id="moonNextDate"> Próxima: —</div>
        <div class="moon-cycle" style="margin-top:12px"><div class="mc-lbl"><span>Ciclo Lunar</span><span id="moonPct">—%</span></div><div class="mc-track"><div class="mc-fill" id="moonFill"></div></div></div>
        <div class="moon-phases-mini"><div class="mpm" onclick="setMoonPhase(0)"><span class="mpm-i"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><circle cx="12" cy="12" r="9" fill="currentColor"/></svg></span>Nueva</div><div class="mpm" onclick="setMoonPhase(2)"><span class="mpm-i"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M12 3a9 9 0 0 0 0 18z" fill="currentColor"/><circle cx="12" cy="12" r="9"/></svg></span>Creciente</div><div class="mpm" onclick="setMoonPhase(4)"><span class="mpm-i"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><circle cx="12" cy="12" r="9"/></svg></span>Llena</div><div class="mpm" onclick="setMoonPhase(6)"><span class="mpm-i"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M12 3a9 9 0 0 1 0 18z" fill="currentColor"/><circle cx="12" cy="12" r="9"/></svg></span>Menguante</div></div>
      </div>
      <div class="moon-right">
        <div class="tide-graph-card">
          <div class="phdr"><span class="ldot"></span>Gráfico de Mareas — Costa Pacífica El Salvador</div>
          <div class="tide-chart-wrap"><canvas id="tideCv"></canvas><div class="tide-label-bar"><span><span class="tide-swatch" style="background:#3d9bff"></span>Marea alta (viva)</span><span><span class="tide-swatch" style="background:#00d4b0"></span>Marea media</span><span><span class="tide-swatch" style="background:rgba(255,77,26,.6)"></span>Marea baja (muerta)</span><span id="tideCurPhase" style="color:var(--acc3);font-weight:700">—</span></div></div>
          <div class="tide-info"><div class="ti-item"><div class="ti-icon"></div><div class="ti-name">Mareas Vivas</div><div class="ti-desc">Luna nueva y llena. Máxima diferencia entre marea alta y baja.</div></div><div class="ti-item"><div class="ti-icon"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M9.6 4.6a2 2 0 1 1 1.4 3.4H2M12.6 19.4a2 2 0 1 0 1.4-3.4H2M17.6 8.6a2.5 2.5 0 1 1 1.8 4.4H2"/></svg></div><div class="ti-name">Mareas Muertas</div><div class="ti-desc">Cuartos creciente y menguante. Menor variación de nivel.</div></div><div class="ti-item"><div class="ti-icon"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M2 12s4-6 11-6c5 0 9 3 9 6s-4 6-9 6c-7 0-11-6-11-6z"/><circle cx="17" cy="11" r="0.6" fill="currentColor"/></svg></div><div class="ti-name">Pesca Activa</div><div class="ti-desc">Mayor actividad pesquera en mareas altas con luna favorable.</div></div><div class="ti-item"><div class="ti-icon"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M10.3 3.9L1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg></div><div class="ti-name">Riesgo Costero</div><div class="ti-desc">Mareas vivas + lluvia = alto riesgo de inundación costera.</div></div></div>
        </div>
        <div class="moon-edu-cards">
          <div class="mec"><div class="mec-icon"></div><div class="mec-title">Mareas Vivas (Spring Tides)</div><div class="mec-body">Ocurren en luna nueva y llena cuando el Sol, la Luna y la Tierra se alinean. La diferencia entre marea alta y baja puede llegar a <strong>2.4 metros</strong> en el Pacífico de El Salvador.</div><span class="mec-badge spring">Luna Nueva · Luna Llena</span></div>
          <div class="mec"><div class="mec-icon"></div><div class="mec-title">Mareas Muertas (Neap Tides)</div><div class="mec-body">Suceden en cuartos creciente y menguante. El Sol y la Luna forman 90°, reduciendo la fuerza gravitacional. Variación mínima de marea, ideal para navegación costera.</div><span class="mec-badge neap">Cuarto Creciente · Cuarto Menguante</span></div>
          <div class="mec"><div class="mec-icon"></div><div class="mec-title">Pesca y Ciclo Lunar</div><div class="mec-body">Los pescadores de La Libertad y Acajutla calendarizan su actividad según el ciclo lunar. Las mareas altas traen peces al litoral. Mayor actividad en luna llena y nueva.</div><span class="mec-badge fish">Alta Actividad Pesquera</span></div>
          <div class="mec"><div class="mec-icon"></div><div class="mec-title">Efectos Costeros El Salvador</div><div class="mec-body">Zonas como Los Blancos y El Espino son vulnerables durante mareas vivas con lluvia intensa. Monitoreo MARN activo en épocas de huracanes del Atlántico.</div><span class="mec-badge warn">Riesgo en Mareas Vivas</span></div>
        </div>
        <div class="moon-facts"><div class="mf-title">Datos Astronómicos Actuales</div><div class="mf-row"><span></span><span>Ciclo sinódico: <strong>29.53 días</strong> — El tiempo de luna nueva a luna nueva.</span></div><div class="mf-row"><span><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15 15 0 0 1 0 20 15 15 0 0 1 0-20z"/></svg></span><span>Distancia media Luna-Tierra: <strong>384,400 km</strong> — varía ±5.5% en su órbita elíptica.</span></div><div class="mf-row"><span><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M2 12c1.5-1.5 3-1.5 4.5 0s3 1.5 4.5 0 3-1.5 4.5 0 3 1.5 4.5 0"/><path d="M2 18c1.5-1.5 3-1.5 4.5 0s3 1.5 4.5 0 3-1.5 4.5 0 3 1.5 4.5 0"/></svg></span><span>Las mareas del Pacífico varían hasta <strong>2.4 metros</strong> durante mareas vivas en luna llena.</span></div></div>
      </div>
    </div>
  </div>
</section>

<!-- S9: TSUNAMIS -->
<section class="sec sec-dark" id="tsunamis">
  <div class="wrap">
    <div class="sec-hd"><div class="sec-eyebrow">Peligro Costero · Pacífico El Salvador</div><h2 class="sec-title">Riesgo de <span class="acc">Tsunamis</span></h2><p class="sec-sub">Monitoreo en tiempo real, simulaciones interactivas y protocolo de evacuación para la costa salvadoreña</p></div>
    <div class="tsunami-layout">
      <div class="ts-vis-card">
        <div class="phdr" style="padding:12px 16px"><span style="font-size:.9rem"></span> Simulación de Tsunami — Pacífico El Salvador</div>
        <canvas id="tsunamiCv"></canvas>
        <div class="ts-steps">
          <div class="ts-step"><div class="ts-num">1</div><div class="ts-text">Sismo submarino M≥7.0 frente a la costa de El Salvador <strong>desplaza verticalmente</strong> el fondo oceánico.</div></div>
          <div class="ts-step"><div class="ts-num">2</div><div class="ts-text">La ola viaja a <strong>800 km/h</strong> en mar abierto — en 20 min puede llegar a La Libertad o Acajutla.</div></div>
          <div class="ts-step"><div class="ts-num">3</div><div class="ts-text">Al acercarse a la costa salvadoreña se <strong>comprime y eleva</strong> hasta 10–30 metros.</div></div>
          <div class="ts-step"><div class="ts-num">4</div><div class="ts-text">El retiro anormal del mar en playas como El Tunco o El Zonte: <strong>tienes 5–15 min para evacuar</strong>.</div></div>
        </div>
      </div>
      <div>
        <div class="evac-card" style="margin-bottom:16px">
          <div class="evac-svg-wrap">
            <svg viewBox="0 0 400 220" preserveAspectRatio="xMidYMid slice">
              <rect x="0" y="0" width="400" height="220" fill="#001428"/>
              <path d="M0,155 Q50,142 100,155 Q150,168 200,155 Q250,142 300,155 Q350,168 400,155 L400,220 L0,220Z" fill="rgba(0,90,180,0.35)"/>
              <path d="M0,168 Q50,154 100,168 Q150,182 200,168 Q250,154 300,168 Q350,182 400,168 L400,220 L0,220Z" fill="rgba(0,70,140,0.45)"/>
              <path d="M0,95 Q35,85 70,90 Q110,75 150,82 Q190,70 230,78 Q270,64 310,72 Q350,58 400,66 L400,158 Q350,150 300,154 Q250,142 200,150 Q150,158 100,150 Q50,156 0,152Z" fill="#0a1e34"/>
              <rect x="35" y="106" width="17" height="38" fill="#102840" stroke="rgba(45,143,255,.4)" stroke-width="1"/>
              <rect x="62" y="96" width="21" height="48" fill="#102840" stroke="rgba(45,143,255,.4)" stroke-width="1"/>
              <rect x="96" y="100" width="15" height="44" fill="#102840" stroke="rgba(45,143,255,.4)" stroke-width="1"/>
              <rect x="133" y="90" width="24" height="54" fill="#102840" stroke="rgba(45,143,255,.4)" stroke-width="1"/>
              <rect x="195" y="85" width="19" height="59" fill="#102840" stroke="rgba(45,143,255,.4)" stroke-width="1"/>
              <rect x="234" y="96" width="14" height="48" fill="#102840" stroke="rgba(45,143,255,.4)" stroke-width="1"/>
              <path d="M55,144 L55,72 L115,52 L195,40 L295,28" stroke="#00d4b0" stroke-width="2.5" fill="none" stroke-dasharray="8,4"><animate attributeName="stroke-dashoffset" from="0" to="-24" dur="1.5s" repeatCount="indefinite"/></path>
              <path d="M155,140 L155,78 L215,58 L305,46" stroke="#00d4b0" stroke-width="2.5" fill="none" stroke-dasharray="8,4"><animate attributeName="stroke-dashoffset" from="0" to="-24" dur="1.5s" repeatCount="indefinite"/></path>
              <path d="M245,138 L245,82 L318,62" stroke="#00d4b0" stroke-width="2.5" fill="none" stroke-dasharray="8,4"><animate attributeName="stroke-dashoffset" from="0" to="-24" dur="1.5s" repeatCount="indefinite"/></path>
              <circle cx="125" cy="48" r="13" fill="rgba(0,212,176,.18)" stroke="var(--teal)" stroke-width="1.5"/>
              <text x="125" y="52" text-anchor="middle" fill="white" font-size="11"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M8 21l4-13 4 13"/><path d="M2 21l7-15 3 6"/></svg></text>
              <circle cx="215" cy="36" r="13" fill="rgba(0,212,176,.18)" stroke="var(--teal)" stroke-width="1.5"/>
              <text x="215" y="40" text-anchor="middle" fill="white" font-size="11"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M8 21l4-13 4 13"/><path d="M2 21l7-15 3 6"/></svg></text>
              <circle cx="318" cy="58" r="13" fill="rgba(0,212,176,.18)" stroke="var(--teal)" stroke-width="1.5"/>
              <text x="318" y="62" text-anchor="middle" fill="white" font-size="11"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M8 21l4-13 4 13"/><path d="M2 21l7-15 3 6"/></svg></text>
              <text x="50" y="172" fill="rgba(255,255,255,.45)" font-size="9" font-family="Space Grotesk,sans-serif">OCÉANO PACÍFICO</text>
              <text x="20" y="88" fill="rgba(0,212,176,.6)" font-size="8" font-family="Space Grotesk,sans-serif">LA LIBERTAD <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></text>
            </svg>
          </div>
          <div class="evac-info-body">
            <h4> Protocolo de Evacuación — El Salvador</h4>
            <ul><li>Sismo fuerte en zona costera de El Salvador: corre tierra adentro <strong>sin esperar alerta</strong>.</li><li>Busca terreno elevado a <strong>mínimo 30m</strong> sobre el nivel del mar (Cerro El Picacho, alturas de Jayaque).</li><li>El retiro del mar en playas como El Tunco = tsunami llegando. Huye <strong>inmediatamente</strong>.</li><li>Nunca regreses hasta <strong>autorización oficial del MARN o Protección Civil</strong>.</li></ul>
            <div class="coast-risks" style="margin-top:12px"><span class="cr-chip crc-r">La Libertad</span><span class="cr-chip crc-r">Acajutla</span><span class="cr-chip crc-r">Usulután</span><span class="cr-chip crc-o">El Espino</span><span class="cr-chip crc-o">Jiquilisco</span><span class="cr-chip crc-o">La Unión</span></div>
          </div>
        </div>
      </div>
    </div>
    <div class="tsunami-interactive">
      <div class="ts-data-panel"><div class="phdr"><span class="rdot"></span>Sismos con Potencial Tsunamigénico — Región</div><div class="ts-api-feed" id="tsFeed"><div class="loading-s"><div class="spin"></div>Cargando datos sísmicos regionales…</div></div></div>
      <div class="ts-evacuation-sim">
        <div class="phdr"><span style="font-size:.9rem"></span> Simulador de Evacuación — La Libertad</div>
        <canvas id="tsEvacCv" style="width:100%;height:200px;background:#001428;display:block"></canvas>
        <div class="ts-evac-controls">
          <button class="ts-evac-btn primary" id="tsEvacStart" onclick="startEvacSim()">▶ Iniciar Simulación</button>
          <button class="ts-evac-btn" onclick="resetEvacSim()"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/></svg> Reiniciar</button>
          <span class="ts-timer" id="tsTimer">00:00</span>
          <span style="font-size:.72rem;color:var(--text3);margin-left:auto" id="tsEvacStatus">Listo</span>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="https://unpkg.com/globe.gl"></script>
<script src="<?= asset('js/hero-globe.js') ?>"></script>

<?php
$content = ob_get_clean();
require_once 'layout.php';
?>
