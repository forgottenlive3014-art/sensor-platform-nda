<?php
$title = $title ?? 'Sismos - NDA';
$user = $user ?? null;
$extraCss = ['css/desastres-base.css'];
ob_start();
?>

<!-- BIG BANNER -->
<section class="dis-bigbanner" style="--dis-accent:#c98a3d; background-image:url('https://commons.wikimedia.org/wiki/Special:FilePath/ElSalvadorslide.jpg')">
  <div class="dis-bigbanner-overlay"></div>
  <div class="wrap dis-bigbanner-inner">
    <h2 class="dis-bigbanner-word">sismos</h2>
    <div class="dis-bigbanner-sub">
      <span class="dis-bigbanner-rule"></span>
      <div>
        <h3>¿Cómo se produce un sismo?</h3>
        <p>La subducción de la Placa de Cocos bajo la Placa del Caribe libera energía acumulada en forma de ondas sísmicas que hacen vibrar el suelo.</p>
        <a href="#zona-sismica" class="dis-bigbanner-btn">Aprender más</a>
      </div>
    </div>
  </div>
  <a href="#zona-sismica" class="scroll-hint"><span>Scroll</span><div class="sh-arr"></div></a>
</section>

<div class="wrap" style="padding-top: 100px;">
  <div class="sec-hd">
    <div class="sec-eyebrow">Sismología · El Salvador</div>
    <h1 class="sec-title">¿Qué son los <span class="acc">sismos</span> y cómo se miden?</h1>
    <p class="sec-sub">Todo lo que necesitas saber sobre la actividad sísmica salvadoreña, explicado de forma sencilla</p>
  </div>
</div>

<!-- QUE SON LOS SISMOS / COMO SE MIDEN -->
<section class="sec">
  <div class="wrap">
    <div class="sismo-card-grid">
      <div class="sismo-card" style="--accent:#c98a3d;">
        <div class="sismo-thumb">
          <div class="sismo-img" style="background:linear-gradient(135deg,#c98a3d,#8a5a24);">
            <svg width="2.6em" height="2.6em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
          </div>
          <span class="sismo-tag">Fundamentos</span>
        </div>
        <div class="sismo-body">
          <h3>¿Qué es un sismo?</h3>
          <p>Un sismo (o terremoto) es una liberación repentina de energía acumulada en la corteza terrestre, generalmente por el roce o choque entre placas tectónicas. Esa energía viaja en forma de ondas sísmicas que hacen vibrar el suelo. En El Salvador la mayoría ocurren por la <strong>subducción de la Placa de Cocos bajo la Placa del Caribe</strong>, aunque también existen fallas superficiales locales (como la Falla Metrópolis).</p>
          <div class="sismo-meta">
            <span class="mi">Causa principal: subducción Cocos–Caribe</span>
          </div>
        </div>
      </div>
      <div class="sismo-card" style="--accent:#b8433f;">
        <div class="sismo-thumb">
          <div class="sismo-img" style="background:linear-gradient(135deg,#b8433f,#7a2b28);">
            <svg width="2.6em" height="2.6em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M8 21l4-13 4 13"/><circle cx="12" cy="6" r="1.4" fill="currentColor"/></svg>
          </div>
          <span class="sismo-tag">Escalas</span>
        </div>
        <div class="sismo-body">
          <h3>Magnitud vs. Intensidad</h3>
          <p><strong>Magnitud (Richter / Momento):</strong> mide la energía liberada en el epicentro, un solo número por sismo. <strong>Intensidad (Mercalli):</strong> mide qué tanto se siente y el daño en un lugar específico — varía según distancia, profundidad y tipo de suelo.</p>
          <div class="sismo-meta">
            <span class="mi">Richter = energía · Mercalli = daño local</span>
          </div>
        </div>
      </div>
      <div class="sismo-card" style="--accent:#3d7d73;">
        <div class="sismo-thumb">
          <div class="sismo-img" style="background:linear-gradient(135deg,#3d7d73,#22513f);">
            <svg width="2.6em" height="2.6em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12h4l3 8 4-16 3 8h4"/></svg>
          </div>
          <span class="sismo-tag">Instrumentos</span>
        </div>
        <div class="sismo-body">
          <h3>¿Cómo se miden?</h3>
          <p><strong>Sismógrafos y acelerómetros</strong> registran el movimiento del suelo en 3 ejes. Las ondas P (primarias) llegan primero; las ondas S (secundarias) llegan después y suelen causar más daño. La Red Sísmica de MARN opera más de 30 estaciones — esta plataforma incluye una maqueta con sensor Arduino, ver <a href="?url=arduino" style="color:var(--acc)">Sismógrafo Arduino</a>.</p>
          <div class="sismo-meta">
            <span class="mi">30+ estaciones · Red MARN</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Diagrama de ondas P y S -->
    <div class="wave-diagram-card">
      <div class="phdr"><span class="wdot"></span>Ondas P y S — cómo viajan desde el hipocentro</div>
      <div class="wave-diagram-body">
        <svg viewBox="0 0 700 220" preserveAspectRatio="xMidYMid meet" class="wave-diagram-svg">
          <line x1="40" y1="180" x2="660" y2="180" stroke="var(--border2)" stroke-width="1.5"/>
          <circle cx="60" cy="180" r="7" fill="var(--acc2)"/>
          <text x="60" y="205" text-anchor="middle" fill="var(--text3)" font-size="11" font-family="Space Grotesk,sans-serif">Hipocentro</text>
          <circle cx="330" cy="60" r="6" fill="var(--acc)"/>
          <text x="330" y="42" text-anchor="middle" fill="var(--text3)" font-size="11" font-family="Space Grotesk,sans-serif">Estación sísmica</text>
          <line x1="60" y1="180" x2="330" y2="60" stroke="var(--acc2)" stroke-width="2.5" stroke-dasharray="6,5">
            <animate attributeName="stroke-dashoffset" from="0" to="-22" dur="0.6s" repeatCount="indefinite"/>
          </line>
          <text x="175" y="145" fill="var(--acc2)" font-size="12" font-weight="700" font-family="Space Grotesk,sans-serif">Onda P · ~6 km/s (llega primero)</text>
          <path d="M60,180 C120,80 160,220 330,60" stroke="var(--teal)" stroke-width="2.5" fill="none" stroke-dasharray="8,6">
            <animate attributeName="stroke-dashoffset" from="0" to="-28" dur="1s" repeatCount="indefinite"/>
          </path>
          <text x="150" y="228" fill="var(--teal)" font-size="12" font-weight="700" font-family="Space Grotesk,sans-serif">Onda S · ~3.5 km/s (llega después, más daño)</text>
          <circle cx="660" cy="180" r="6" fill="var(--acc3)"/>
          <text x="640" y="205" text-anchor="end" fill="var(--text3)" font-size="11" font-family="Space Grotesk,sans-serif">Superficie</text>
        </svg>
      </div>
    </div>
  </div>
</section>

<!-- ZONA SISMICA -->
<section class="sec sec-dark" id="zona-sismica">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Mapa de Riesgo · El Salvador</div>
      <h2 class="sec-title">Zona <span class="acc">Sísmica</span></h2>
      <p class="sec-sub">Zonas de mayor actividad sísmica, volcanes y riesgos asociados — datos de MARN, USGS e IOC-UNESCO</p>
    </div>
    <div class="map-container">
      <div class="map-ctrl-bar">
        <button class="mc-btn on" data-layer="seismic">Zonas sísmicas</button>
        <button class="mc-btn" data-layer="volcanic">Volcanes</button>
        <button class="mc-btn" data-layer="quakes">Sismos recientes (USGS)</button>
        <button class="mc-btn" data-layer="flood">Riesgo de tsunami</button>
        <button class="mc-btn" data-layer="slides">Deslizamientos</button>
        <button class="mc-btn" data-layer="safe">Zonas seguras</button>
        <button class="mc-btn" data-layer="all">Ver todo</button>
      </div>
      <div id="hazardMap"></div>
      <div class="map-legend-bar">
        <div class="mli"><span class="mld" style="background:#e63946"></span>Zona sísmica activa</div>
        <div class="mli"><span class="mld" style="background:#ff9500"></span>Volcán activo</div>
        <div class="mli"><span class="mld" style="background:#555"></span>Volcán inactivo</div>
        <div class="mli"><span class="mld" style="background:#3d9bff"></span>Riesgo de tsunami</div>
        <div class="mli"><span class="mld" style="background:#ffcc00"></span>Deslizamiento</div>
        <div class="mli"><span class="mld" style="background:#22c55e"></span>Zona segura</div>
      </div>
    </div>
  </div>
</section>

<!-- MONITOR SISMICO EN TIEMPO REAL -->
<section class="sec" id="monitor-tiempo-real">
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
            <div style="min-width:0;overflow:hidden">
              <div style="font-weight:700;color:var(--text);font-size:.85rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">Sismógrafo Interactivo — El Salvador</div>
              <div style="font-size:.7rem;color:var(--text3);white-space:nowrap;overflow:hidden;text-overflow:ellipsis" id="sgSubtitle">Estación SSN · San Salvador · 13.692°N, 89.218°W · EN VIVO</div>
            </div>
            <div class="hm-live" style="margin-left:auto;flex-shrink:0"><span class="ldot"></span>EN VIVO</div>
            <div style="font-size:.72rem;color:var(--text3);background:var(--bg3);padding:4px 10px;border-radius:100px;margin-left:8px;flex-shrink:0;white-space:nowrap" id="sgFreqLabel">Frecuencia media</div>
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
        <div style="margin-top:14px;background:var(--card);border:1px solid var(--border2);border-radius:var(--r);overflow:hidden" id="quakeFeed-wrap">
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

<!-- SIMULADOR -->
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

<!-- PLACAS TECTONICAS -->
<section class="sec" id="placas">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Geodinámica · Centroamérica</div>
      <h2 class="sec-title">Placas <span class="acc">Tectónicas</span></h2>
      <p class="sec-sub">Por qué El Salvador es uno de los países más sísmicos del continente</p>
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
    <p style="text-align:center;margin-top:20px">
      <a href="?url=home#zona-sismica" class="btn-out">← Volver al Inicio</a>
    </p>
  </div>
</section>

<?php
$content = ob_get_clean();
require_once 'layout.php';
?>
