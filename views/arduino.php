<?php
$title = $title ?? 'Sismógrafo Arduino - NDA';
$user = $user ?? null;
ob_start();
?>

<div class="wrap" style="padding-top: 100px;">
  <div class="sec-hd">
    <div class="sec-eyebrow">Hardware Educativo · Monitoreo en Vivo</div>
    <h1 class="sec-title">Sismógrafo de <span class="acc">Arduino</span></h1>
    <p class="sec-sub">Una maqueta real de sensor de vibración, del hardware a la alerta en pantalla</p>
  </div>
</div>

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

<?php
$content = ob_get_clean();
require_once 'layout.php';
?>
