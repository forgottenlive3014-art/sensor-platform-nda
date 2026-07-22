<?php
$title = $title ?? 'Monitoreo - NDA';
$user = $user ?? null;
ob_start();
?>

<div class="wrap" style="padding-top: 100px;">
  <div class="sec-hd">
    <div class="sec-eyebrow">Monitoreo en Vivo · El Salvador</div>
    <h1 class="sec-title">Sol, Luna y <span class="acc3">Clima</span></h1>
    <p class="sec-sub">Datos astronómicos y meteorológicos reales, actualizados en tiempo real</p>
  </div>
</div>

<!-- SOL Y CLIMA -->
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
          <div class="st-hdr">Tormentas más dañinas — su relación con lluvias intensas</div>
          <div class="st-row"><span class="st-name">Mitch 1998</span><span class="st-victims">240 víctimas</span><span class="st-cat c5">Categ. 5</span></div>
          <div class="st-row"><span class="st-name">Ida 2009</span><span class="st-victims">198 víctimas</span><span class="st-cat ct">Tormenta</span></div>
          <div class="st-row"><span class="st-name">Amanda 2020</span><span class="st-victims">inundaciones</span><span class="st-cat c1">Cat. 1</span></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- LUNA Y MAREAS -->
<section class="sec" id="luna">
  <div class="wrap">
    <div class="sec-hd"><div class="sec-eyebrow">Astronomía · Mareas</div><h2 class="sec-title">Fases Lunares y <span class="acc2">Mareas</span></h2><p class="sec-sub">Explora el ciclo lunar completo, su modelo 3D en tiempo real y su influencia en las mareas del Pacífico salvadoreño</p></div>
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
        <div class="moon3d-card">
          <div class="phdr"><span class="ldot"></span>Luna 3D en Vivo (posición e iluminación reales)</div>
          <div id="moon3dContainer"></div>
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

<!-- ZONAS DE MAYOR RIESGO -->
<section class="sec sec-dark" id="zonas-riesgo">
  <div class="wrap">
    <div class="sec-hd"><div class="sec-eyebrow">Geografía del Riesgo</div><h2 class="sec-title">Lugares con Mayor <span class="acc">Frecuencia de Desastres</span></h2><p class="sec-sub">Zonas del país donde históricamente se concentran más eventos sísmicos, volcánicos e hidrometeorológicos</p></div>
    <div class="plates-grid">
      <div class="plate-card">
        <div class="pc-body">
          <h4>San Salvador y AMSS</h4>
          <p>Mayor densidad poblacional del país. Falla Metrópolis activa bajo la capital: sismos superficiales de gran impacto (1965, 1986). Zonas de laderas vulnerables a deslizamientos tras lluvias intensas.</p>
        </div>
      </div>
      <div class="plate-card">
        <div class="pc-body">
          <h4>Costa del Pacífico (La Libertad, Acajutla, La Unión)</h4>
          <p>Riesgo de tsunami ante sismos submarinos M≥7.0. También primeras zonas en recibir el impacto de tormentas tropicales y huracanes del Pacífico.</p>
        </div>
      </div>
      <div class="plate-card">
        <div class="pc-body">
          <h4>Cordillera Volcánica (Santa Ana, Izalco, San Vicente, San Miguel)</h4>
          <p>Actividad volcánica activa y monitoreada por el MARN. El Izalco y Santa Ana son los de mayor vigilancia histórica.</p>
        </div>
      </div>
      <div class="plate-card">
        <div class="pc-body">
          <h4>Bajo Lempa y Jiquilisco (zona oriental)</h4>
          <p>Zonas bajas altamente vulnerables a inundaciones durante la temporada lluviosa (mayo–octubre) y ante huracanes del Atlántico como Mitch (1998) e Ida (2009).</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- TSUNAMIS -->
<section class="sec" id="tsunamis">
  <div class="wrap">
    <div class="sec-hd"><div class="sec-eyebrow">Peligro Costero · Pacífico El Salvador</div><h2 class="sec-title">Riesgo de <span class="acc">Tsunamis</span></h2><p class="sec-sub">Monitoreo en tiempo real, simulaciones interactivas y protocolo de evacuación para la costa salvadoreña</p></div>
    <div class="tsunami-layout">
      <div class="ts-vis-card">
        <div class="phdr" style="padding:12px 16px"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em"><path d="M2 6c.6.5 1.2 1 2.5 1C7 7 7 5 9.5 5c2.3 0 2.3 2 4.5 2 2.3 0 2.3-2 4.5-2 1.3 0 1.9.5 2.5 1"/><path d="M2 12c.6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 2.3 0 2.3 2 4.5 2 2.3 0 2.3-2 4.5-2 1.3 0 1.9.5 2.5 1"/><path d="M2 18c.6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 2.3 0 2.3 2 4.5 2 2.3 0 2.3-2 4.5-2 1.3 0 1.9.5 2.5 1"/></svg> Simulación de Tsunami — Pacífico El Salvador</div>
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
              <g transform="translate(117.8,40.8) scale(0.6)" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 21l4-13 4 13"/><path d="M2 21l7-15 3 6"/></g>
              <circle cx="215" cy="36" r="13" fill="rgba(0,212,176,.18)" stroke="var(--teal)" stroke-width="1.5"/>
              <g transform="translate(207.8,28.8) scale(0.6)" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 21l4-13 4 13"/><path d="M2 21l7-15 3 6"/></g>
              <circle cx="318" cy="58" r="13" fill="rgba(0,212,176,.18)" stroke="var(--teal)" stroke-width="1.5"/>
              <g transform="translate(310.8,50.8) scale(0.6)" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 21l4-13 4 13"/><path d="M2 21l7-15 3 6"/></g>
              <text x="50" y="172" fill="rgba(255,255,255,.45)" font-size="9" font-family="Space Grotesk,sans-serif">OCÉANO PACÍFICO</text>
              <text x="20" y="88" fill="rgba(0,212,176,.6)" font-size="8" font-family="Space Grotesk,sans-serif">LA LIBERTAD</text>
              <g transform="translate(70,80) scale(0.4)" fill="none" stroke="rgba(0,212,176,.75)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></g>
            </svg>
          </div>
          <div class="evac-info-body">
            <h4><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em"><path d="M20 13c0 5-3.5 7.5-7.5 8.5-.4.1-.6.1-1 0C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.9 17 5 19 5a1 1 0 0 1 1 1z"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg> Protocolo de Evacuación — El Salvador</h4>
            <ul><li>Sismo fuerte en zona costera de El Salvador: corre tierra adentro <strong>sin esperar alerta</strong>.</li><li>Busca terreno elevado a <strong>mínimo 30m</strong> sobre el nivel del mar (Cerro El Picacho, alturas de Jayaque).</li><li>El retiro del mar en playas como El Tunco = tsunami llegando. Huye <strong>inmediatamente</strong>.</li><li>Nunca regreses hasta <strong>autorización oficial del MARN o Protección Civil</strong>.</li></ul>
            <div class="coast-risks" style="margin-top:12px"><span class="cr-chip crc-r">La Libertad</span><span class="cr-chip crc-r">Acajutla</span><span class="cr-chip crc-r">Usulután</span><span class="cr-chip crc-o">El Espino</span><span class="cr-chip crc-o">Jiquilisco</span><span class="cr-chip crc-o">La Unión</span></div>
          </div>
        </div>
      </div>
    </div>
    <div class="tsunami-interactive">
      <div class="ts-data-panel"><div class="phdr"><span class="rdot"></span>Sismos con Potencial Tsunamigénico — Región</div><div class="ts-api-feed" id="tsFeed"><div class="loading-s"><div class="spin"></div>Cargando datos sísmicos regionales…</div></div></div>
      <div class="ts-evacuation-sim">
        <div class="phdr"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg> Simulador de Evacuación — La Libertad</div>
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

<?php
$content = ob_get_clean();
require_once 'layout.php';
?>
