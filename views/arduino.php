<?php
$title = $title ?? 'Sismógrafo Arduino - NDA';
$user = $user ?? null;
ob_start();
?>

<!-- CENTRO SISMICO: ESTACION PROPIA EN VIVO (sensor MPU6050) -->
<section class="sec" id="centro-sismico-vivo">
  <div class="wrap" style="padding-top: 24px;">
    <div class="sec-hd" style="display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:20px">
      <div>
        <div class="page-eyebrow">Estación Propia · Sensor MPU6050</div>
        <div class="page-title">Centro <span class="acc">Sísmico</span> en Vivo</div>
        <p class="sec-sub" style="margin-top:6px">Movimiento real capturado por nuestra estación sismológica con acelerómetro — proyecto Centro Sísmico</p>
      </div>
      <div class="rtm-badge active" id="csiStatusBadge"><span class="live-dot"></span>Conectando…</div>
    </div>
    <div class="pt-rule" style="margin:0 0 20px"></div>
    <div class="seismo-layout">
      <div>
        <div class="sg-main-card">
          <div class="phdr">
            <div style="width:32px;height:32px;background:rgba(61,125,115,.15);border-radius:var(--rs);display:flex;align-items:center;justify-content:center;font-size:.9rem;flex-shrink:0"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em"><path d="M3 12h4l3 8 4-16 3 8h4"/></svg></div>
            <div style="min-width:0;overflow:hidden">
              <div style="font-weight:700;color:var(--text);font-size:.85rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">Acelerómetro MPU6050 — Ejes X / Y / Z</div>
              <div style="font-size:.7rem;color:var(--text3);white-space:nowrap;overflow:hidden;text-overflow:ellipsis" id="csiSubtitle">Señal cruda de la estación</div>
            </div>
            <div class="hm-live" style="margin-left:auto;flex-shrink:0" id="csiLiveTag"><span class="ldot"></span>EN VIVO</div>
            <div style="font-size:.72rem;color:var(--text3);background:var(--bg3);padding:4px 10px;border-radius:100px;margin-left:8px;flex-shrink:0;white-space:nowrap" id="csiSamplesLabel">— muestras</div>
          </div>
          <div class="sg-wave-area">
            <div class="sg-depth-badge">EJE CON MÁS ACTIVIDAD: <strong id="csiEjeMax">—</strong></div>
            <canvas id="csiWave"></canvas>
          </div>
          <div class="sg-stats-bar">
            <div class="sgstat"><div class="sgstat-lbl">Magnitud actual</div><div class="sgstat-val acc" id="csiMag">0.0</div><div class="sgstat-sub" id="csiNivel">Sin actividad</div></div>
            <div class="sgstat"><div class="sgstat-lbl">Magnitud máx.</div><div class="sgstat-val teal" id="csiMaxMag">—</div><div class="sgstat-sub">histórico de la estación</div></div>
            <div class="sgstat"><div class="sgstat-lbl">Eventos registrados</div><div class="sgstat-val" id="csiTotal">—</div><div class="sgstat-sub">detectados por el sensor</div></div>
            <div class="sgstat"><div class="sgstat-lbl">última detección</div><div class="sgstat-val" style="font-size:1rem" id="csiUltimo">—</div><div class="sgstat-sub">fecha y hora local</div></div>
          </div>
          <div class="csi-niveles" id="csiNiveles">
            <span class="csi-niveles-lbl">Niveles de temblor</span>
            <span class="csi-nivel-chip" data-nivel="MICRO SISMO"><span class="csi-nivel-dot ml"></span>Micro sismo <em>1.0–2.4</em></span>
            <span class="csi-nivel-chip" data-nivel="LEVE"><span class="csi-nivel-dot ml"></span>Leve <em>2.5–3.4</em></span>
            <span class="csi-nivel-chip" data-nivel="MODERADO"><span class="csi-nivel-dot mm"></span>Moderado <em>3.5–4.4</em></span>
            <span class="csi-nivel-chip" data-nivel="FUERTE"><span class="csi-nivel-dot mh"></span>Fuerte <em>4.5–5.4</em></span>
            <span class="csi-nivel-chip" data-nivel="TERREMOTO"><span class="csi-nivel-dot mx"></span>Terremoto <em>≥ 5.5</em></span>
          </div>
        </div>
      </div>
      <div class="side-mini">
        <div class="smc" style="padding:0;overflow:hidden;display:flex;flex-direction:column">
          <div class="phdr"><span class="ldot"></span>Eventos destacados <button class="sg-reset" id="csiRefresh" style="margin-left:auto;padding:4px 11px"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/></svg></button></div>
          <div id="csiFeed"><div class="loading-s"><div class="spin"></div>Conectando con la estación…</div></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SISMOGRAFO ARDUINO -->
<section class="sec sec-dark" id="arduino">
  <div class="wrap">

    <div class="ard-flow">
      <div class="ard-flow-step">
        <div class="ard-flow-icon"><svg width="1.6em" height="1.6em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="6" y="6" width="12" height="12" rx="2"/><line x1="9" y1="2" x2="9" y2="6"/><line x1="15" y1="2" x2="15" y2="6"/><line x1="9" y1="18" x2="9" y2="22"/><line x1="15" y1="18" x2="15" y2="22"/></svg></div>
        <strong>Sensor MPU-6050</strong>
        <span>Acelerómetro + giroscopio de 3 ejes conectado a un Arduino, detecta vibración del suelo en tiempo real.</span>
      </div>
      <div class="ard-flow-arrow">→</div>
      <div class="ard-flow-step">
        <div class="ard-flow-icon"><svg width="1.6em" height="1.6em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M6 8h4M6 12h6"/></svg></div>
        <strong>Puente Processing</strong>
        <span>Un sketch de Processing lee el puerto serial del Arduino y reenvía cada lectura a la plataforma vía HTTP.</span>
      </div>
      <div class="ard-flow-arrow">→</div>
      <div class="ard-flow-step">
        <div class="ard-flow-icon"><svg width="1.6em" height="1.6em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M4 12a8 8 0 1 1 8 8"/><path d="M4 12v6h6"/></svg></div>
        <strong>API NDA (sensor/ingest)</strong>
        <span>La lectura se guarda con su intensidad, ejes X/Y/Z y nivel calculado (normal, precaución o alerta).</span>
      </div>
      <div class="ard-flow-arrow">→</div>
      <div class="ard-flow-step">
        <div class="ard-flow-icon"><svg width="1.6em" height="1.6em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M10.3 3.9L1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg></div>
        <strong>Alerta en la plataforma</strong>
        <span>Si el nivel es de alerta, se genera una notificación global visible para toda la comunidad NDA.</span>
      </div>
    </div>

    <div class="sg-main-card" style="margin-top:24px">
      <div class="phdr">
        <span class="ldot"></span>
        <div style="font-weight:700;color:var(--text);font-size:.85rem">Lectura en Vivo del Sensor</div>
        <span class="chip o" id="ardLiveStatus" style="margin-left:auto">○ Comprobando conexión…</span>
      </div>
      <div style="padding:18px">
        <div class="sim-ib">
          <span class="sib-lbl">Intensidad</span>
          <div class="sib-track"><div class="sib-fill" id="ardLiveBar" style="width:2%"></div></div>
          <span class="sib-val" id="ardLiveValue">—</span>
        </div>
        <p style="font-size:.78rem;color:var(--text3);margin-top:12px">
          Si no ves lecturas, es porque el hardware físico no está conectado en este momento — la plataforma sigue funcionando en modo demo con el resto de datos reales (USGS, clima, sol y luna).
        </p>
      </div>
    </div>

    <p style="text-align:center;margin-top:24px">
      <a href="?url=monitoreo" class="btn-out">← Volver a Monitoreo</a>
    </p>
  </div>
</section>

<script src="<?= asset('js/centrosismico.js') ?>"></script>

<?php
$content = ob_get_clean();
require_once 'layout.php';
?>
