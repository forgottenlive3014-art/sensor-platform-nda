<?php
$title = $title ?? 'Monitoreo - NDA';
$currentSlug = 'monitoreo';
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

<!-- CLIMA Y LUNA: paginas dedicadas -->
<section class="sec sec-dark" id="clima">
  <div class="wrap">
    <div class="sec-hd"><div class="page-eyebrow" style="color:var(--blue)">Meteorología y Astronomía</div><div class="page-title">Clima <span class="acc3">& Luna</span></div></div>
    <div class="find-cards-grid">
      <a href="?url=clima" class="find-card">
        <div class="find-card-visual" style="background:linear-gradient(135deg,#2d8fff,#3d6f8f)"><svg width="1.8em" height="1.8em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17.5 19a4.5 4.5 0 0 0 0-9 6 6 0 0 0-11.3-1.5A5 5 0 0 0 6 19z"/><path d="M12 2v2M4.2 4.2l1.4 1.4"/></svg></div>
        <div class="find-card-body"><h3>Clima en Tiempo Real</h3><p>Temperatura, pronóstico por horas y 7 días, mapa de lluvia en vivo, alertas e indicadores completos según tu ubicación.</p><span class="fc-cta">Ver clima →</span></div>
      </a>
      <a href="?url=luna" class="find-card">
        <div class="find-card-visual" style="background:linear-gradient(135deg,#4b3f72,#26314f)"><svg width="1.8em" height="1.8em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg></div>
        <div class="find-card-body"><h3>Fases de la Luna</h3><p>Modelo lunar 3D en tiempo real, calendario de fases, iluminación, edad y distancia Tierra-Luna calculadas al minuto.</p><span class="fc-cta">Ver fases lunares →</span></div>
      </a>
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
