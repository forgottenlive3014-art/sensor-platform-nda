<?php
$title = $title ?? 'Deslizamientos - NDA';
$user = $user ?? null;
$currentSlug = 'deslizamientos';
$extraCss = ['css/deslizamientos.css'];
ob_start();
?>

<!-- ============================================================
     BANNER PRINCIPAL
     ============================================================ -->
<section class="dis-bigbanner" style="background-image:url('assets/media/img/deslizamientoTierra.jpg')">
  <div class="dis-bigbanner-overlay"></div>
  <div class="wrap dis-bigbanner-inner">
    <div class="dis-bigbanner-badge">El Salvador · Movimientos de Tierra</div>
    <h2 class="dis-bigbanner-word">Des<span class="highlight">liz</span>amientos</h2>
    <div class="dis-bigbanner-sub">
      <span class="dis-bigbanner-rule"></span>
      <div>
        <p>"Cuando la tierra se mueve, la prevención es nuestra mejor herramienta."</p>
        <a href="#que-es" class="dis-bigbanner-btn">Explorar</a>
      </div>
    </div>
  </div>
  <a href="#que-es" class="scroll-hint"><span>Scroll</span><div class="sh-arr"></div></a>
</section>


<!-- ============================================================
     SECCIÓN 1: ¿QUÉ ES UN DESLIZAMIENTO?
     ============================================================ -->
<section class="des-section" id="que-es">
  <div class="wrap">
    <div class="des-header">
      <span class="des-tag">Geodinámica</span>
      <h2 class="des-title">¿Qué es un <span>deslizamiento</span>?</h2>
      <p class="des-sub">Movimiento de masas de tierra, roca o escombros ladera abajo bajo la influencia de la gravedad.</p>
    </div>

    <div class="des-intro-wrapper">
      <div class="des-intro-image">
        <img src="assets/media/img/deslizamientoV.jpeg" alt="Deslizamiento de tierra" loading="lazy">
        <span class="des-intro-image-label">Ladera con deslizamiento de tierra</span>
      </div>
      <div class="des-intro-content">
        <div class="des-intro-definition">
          <p>Un <strong>deslizamiento de tierra</strong> es el movimiento de una masa de roca, suelo, escombros o tierra ladera abajo, bajo la influencia directa de la <strong>gravedad</strong>. Ocurre cuando las fuerzas que actúan pendiente abajo superan la resistencia de los materiales que componen la ladera.</p>
        </div>
        <div class="des-intro-features">
          <div class="des-intro-feature">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
            <span>Movimiento de masas</span>
          </div>
          <div class="des-intro-feature">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83"/></svg>
            <span>Gravedad</span>
          </div>
          <div class="des-intro-feature">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v8M12 18v4M4.93 10.93l5.66-5.66M13.41 5.27l5.66 5.66"/><path d="M4.93 19.07l5.66-5.66M13.41 18.73l5.66-5.66"/></svg>
            <span>Rápido o lento</span>
          </div>
        </div>
      </div>
    </div>

    <div class="des-intro-footer">
      <strong>En El Salvador:</strong> el principal detonante son las <strong>lluvias intensas</strong> y la <strong>actividad sísmica</strong>.
    </div>
  </div>
</section>


<!-- ============================================================
     SECCIÓN 2: TIPOS DE DESLIZAMIENTOS
     ============================================================ -->
<section class="des-section des-section-dark" id="tipos">
  <div class="wrap">
    <div class="des-header">
      <span class="des-tag">Clasificación</span>
      <h2 class="des-title">Tipos de <span>deslizamientos</span></h2>
      <p class="des-sub">Clasificación según el movimiento y la velocidad</p>
    </div>

    <div class="des-tipos-grid">
      <div class="des-tipo-card">
        <div class="des-tipo-img">
          <img src="assets/media/img/deslizamientoTierra.jpg" alt="Caída de rocas" loading="lazy">
        </div>
        <div class="des-tipo-body">
          <h4>Caídas (Falls)</h4>
          <p>Material se desprende y cae en caída libre. Común en pendientes muy empinadas.</p>
          <div class="des-tipo-speed">Velocidad:
            <div class="des-speed-dots"><span class="des-speed-dot active"></span><span class="des-speed-dot active"></span><span class="des-speed-dot active"></span><span class="des-speed-dot active"></span><span class="des-speed-dot active"></span></div>
            Rápida
          </div>
        </div>
      </div>

      <div class="des-tipo-card">
        <div class="des-tipo-img">
          <img src="https://commons.wikimedia.org/wiki/Special:FilePath/Oso%20Landslide%20(east%20of%20Oso%2C%20Washington%20State%2C%20USA)%202.jpg" alt="Deslizamiento" loading="lazy">
        </div>
        <div class="des-tipo-body">
          <h4>Deslizamientos (Slides)</h4>
          <p>Movimiento a lo largo de una superficie de ruptura. Rotacionales o traslacionales.</p>
          <div class="des-tipo-speed">Velocidad:
            <div class="des-speed-dots"><span class="des-speed-dot active"></span><span class="des-speed-dot active"></span><span class="des-speed-dot active"></span><span class="des-speed-dot"></span><span class="des-speed-dot"></span></div>
            Variable
          </div>
        </div>
      </div>

      <div class="des-tipo-card">
        <div class="des-tipo-img">
          <img src="https://commons.wikimedia.org/wiki/Special:FilePath/DebrisFlowDepositRestingSpringsPass.JPG" alt="Flujo de lodo" loading="lazy">
        </div>
        <div class="des-tipo-body">
          <h4>Flujos (Flows)</h4>
          <p>Movimiento como fluido viscoso. Incluye flujos de lodo, escombros y tierra.</p>
          <div class="des-tipo-speed">Velocidad:
            <div class="des-speed-dots"><span class="des-speed-dot active"></span><span class="des-speed-dot active"></span><span class="des-speed-dot active"></span><span class="des-speed-dot active"></span><span class="des-speed-dot active"></span></div>
            Muy rápida
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- ============================================================
     SECCIÓN 3: CAUSAS
     ============================================================ -->
<section class="des-section" id="causas">
  <div class="wrap">
    <div class="des-header">
      <span class="des-tag">Origen</span>
      <h2 class="des-title">¿Por qué se <span>producen</span>?</h2>
      <p class="des-sub">Causas naturales y humanas de los deslizamientos</p>
    </div>

    <div class="des-causas-grid">
      <div class="des-causa-card">
        <div class="des-causa-img"><img src="https://commons.wikimedia.org/wiki/Special:FilePath/Heavy%20Rain.jpg" alt="Lluvias intensas" loading="lazy"></div>
        <div class="des-causa-body">
          <div class="des-causa-icon-chip"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M20 16.2A4.5 4.5 0 0 0 17.5 8h-1.8A7 7 0 1 0 4 14.9"/><path d="M8 19v2M12 19v2M16 19v2"/></svg></div>
          <h4>Lluvias intensas</h4>
          <p>El principal detonante en El Salvador. El agua satura el suelo y reduce su resistencia.</p>
        </div>
      </div>
      <div class="des-causa-card">
        <div class="des-causa-img"><img src="assets/media/img/terremoto del 13 de enero de 2001.jpg" alt="Sismos y terremotos" loading="lazy"></div>
        <div class="des-causa-body">
          <div class="des-causa-icon-chip"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg></div>
          <h4>Sismos y terremotos</h4>
          <p>Las sacudidas sísmicas desestabilizan laderas y pueden provocar deslizamientos masivos.</p>
        </div>
      </div>
      <div class="des-causa-card">
        <div class="des-causa-img"><img src="https://commons.wikimedia.org/wiki/Special:FilePath/Hillside%20deforestation%20in%20Rio%20de%20Janeiro.jpg" alt="Deforestación" loading="lazy"></div>
        <div class="des-causa-body">
          <div class="des-causa-icon-chip"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3l6 9h-4l3 5H7l3-5H6l6-9z"/><path d="M12 17v4"/></svg></div>
          <h4>Deforestación</h4>
          <p>La tala de árboles elimina la vegetación que sujeta el suelo con sus raíces.</p>
        </div>
      </div>
      <div class="des-causa-card">
        <div class="des-causa-img"><img src="https://commons.wikimedia.org/wiki/Special:FilePath/Steep%20hillside%20-%20geograph.org.uk%20-%20938085.jpg" alt="Topografía" loading="lazy"></div>
        <div class="des-causa-body">
          <div class="des-causa-icon-chip"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M3 20l6-11 4 6 3-5 5 10z"/></svg></div>
          <h4>Topografía</h4>
          <p>Las pendientes pronunciadas son más propensas a deslizamientos.</p>
        </div>
      </div>
      <div class="des-causa-card">
        <div class="des-causa-img"><img src="https://commons.wikimedia.org/wiki/Special:FilePath/Gully%20Erosion.jpg" alt="Erosión" loading="lazy"></div>
        <div class="des-causa-body">
          <div class="des-causa-icon-chip"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2s7 7.5 7 12a7 7 0 0 1-14 0c0-4.5 7-12 7-12z"/></svg></div>
          <h4>Erosión</h4>
          <p>El agua socava la base de las laderas y las desestabiliza.</p>
        </div>
      </div>
      <div class="des-causa-card">
        <div class="des-causa-img"><img src="https://commons.wikimedia.org/wiki/Special:FilePath/Aley%20Lebanon%20Houses%20and%20hillside.jpg" alt="Urbanización" loading="lazy"></div>
        <div class="des-causa-body">
          <div class="des-causa-icon-chip"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="3" width="14" height="18" rx="1"/><path d="M9 7h1M14 7h1M9 11h1M14 11h1M9 15h1M14 15h1"/><path d="M10 21v-4h4v4"/></svg></div>
          <h4>Urbanización</h4>
          <p>La construcción en laderas sin planificación aumenta el riesgo.</p>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- ============================================================
     SECCIÓN 4: ZONAS DE RIESGO EN EL SALVADOR
     ============================================================ -->
<section class="des-section des-section-dark" id="zonas">
  <div class="wrap">
    <div class="des-header">
      <span class="des-tag">El Salvador</span>
      <h2 class="des-title">Zonas de <span>riesgo</span></h2>
      <p class="des-sub">Distribución de las áreas más propensas a deslizamientos en el país</p>
    </div>

    <div class="des-mapa-wrapper">
      <div class="des-mapa-container">
        <!-- PROVISIONAL: pon aquí tu propio mapa de riesgo -->
        <img src="assets/media/img/riesgosD.jpg" alt="Mapa de riesgo de El Salvador" loading="lazy">
        <div class="des-mapa-legend">
          <span class="des-mapa-legend-item"><span class="dot alto"></span> Alto riesgo</span>
          <span class="des-mapa-legend-item"><span class="dot medio"></span> Riesgo medio</span>
          <span class="des-mapa-legend-item"><span class="dot bajo"></span> Riesgo bajo</span>
        </div>
      </div>

      <div class="des-mapa-info">
        <div class="des-mapa-info-item">
          <span class="des-mapa-info-dot" style="background:#C62828;"></span>
          <div>
            <h4>Cadena montañosa del norte</h4>
            <p>Deslizamientos rotacionales y traslacionales, generalmente lentos.</p>
          </div>
        </div>
        <div class="des-mapa-info-item">
          <span class="des-mapa-info-dot" style="background:#E86A2A;"></span>
          <div>
            <h4>Cadena volcánica central</h4>
            <p>Deslaves, lahares y flujos de escombros, súbitos y rápidos.</p>
          </div>
        </div>
        <div class="des-mapa-info-item">
          <span class="des-mapa-info-dot" style="background:#F2C94C;"></span>
          <div>
            <h4>Cadena costera</h4>
            <p>Flujos de escombros y caída de rocas, frecuentes en carreteras.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- ============================================================
     SECCIÓN 5: SEÑALES DE ALERTA
     ============================================================ -->
<section class="des-section" id="alertas">
  <div class="wrap">
    <div class="des-header">
      <span class="des-tag">Prevención</span>
      <h2 class="des-title">Señales de <span>alerta</span></h2>
      <p class="des-sub">Indicadores naturales de un posible deslizamiento</p>
    </div>

    <div class="des-senales-grid">
      <div class="des-senal-card">
        <svg class="des-senal-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12h4l2-5 3 10 2-7 3 5h4"/></svg>
        <h4>Grietas en el suelo</h4>
        <p>Grietas en el terreno, caminos o paredes que aparecen sin razón aparente.</p>
      </div>
      <div class="des-senal-card">
        <svg class="des-senal-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" style="transform:rotate(-16deg)"><path d="M12 3l6 9h-4l3 5H7l3-5H6l6-9z"/><path d="M12 17v4"/></svg>
        <h4>Árboles inclinados</h4>
        <p>Troncos curvos o inclinados ("pata de palo") que indican movimiento del terreno.</p>
      </div>
      <div class="des-senal-card">
        <svg class="des-senal-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2s7 7.5 7 12a7 7 0 0 1-14 0c0-4.5 7-12 7-12z"/></svg>
        <h4>Agua turbia</h4>
        <p>Aumento repentino de turbidez en quebradas o ríos cercanos.</p>
      </div>
      <div class="des-senal-card">
        <svg class="des-senal-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M5 9v6M9 6v12M13 9v6M17 5v14M21 9v6"/></svg>
        <h4>Estruendos anormales</h4>
        <p>Ruidos como árboles rompiéndose o rocas chocando en la ladera.</p>
      </div>
      <div class="des-senal-card">
        <svg class="des-senal-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v11"/><path d="M8 10l4 4 4-4"/><path d="M4 21h16"/></svg>
        <h4>Hundimientos</h4>
        <p>Depresiones o abultamientos en la base de laderas.</p>
      </div>
      <div class="des-senal-card">
        <svg class="des-senal-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M14 21l-2-16-2 1"/><path d="M6 21h12"/><path d="M9 6l6-1"/></svg>
        <h4>Postes inclinados</h4>
        <p>Cercas, postes o muros que se inclinan sin razón aparente.</p>
      </div>
    </div>

    <div class="des-senal-warning">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3l10 18H2L12 3z"/><path d="M12 10v4"/><path d="M12 17h.01"/></svg>
      <span>Si observas estas señales, <strong>evacúa de inmediato</strong> y avisa a las autoridades locales.</span>
    </div>
  </div>
</section>


<!-- ============================================================
     SECCIÓN 6: PREVENCIÓN Y ACTUACIÓN
     ============================================================ -->
<section class="des-section des-section-dark" id="prevencion">
  <div class="wrap">
    <div class="des-header">
      <span class="des-tag">Actuación</span>
      <h2 class="des-title">Prevención y <span>actuación</span></h2>
      <p class="des-sub">Qué hacer antes, durante y después de un deslizamiento</p>
    </div>

    <div class="des-prevencion-grid">
      <div class="des-prevencion-card antes">
        <div class="des-prevencion-top"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3l7 3v6c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V6l7-3z"/><path d="M9 12l2 2 4-4"/></svg></div>
        <h4>Antes</h4>
        <ul>
          <li>No construir en zonas de riesgo</li>
          <li>Reforestar laderas con árboles de raíces profundas</li>
          <li>Mantener drenajes y canales limpios</li>
          <li>Preparar un plan de emergencia familiar</li>
          <li>Participar en simulacros de evacuación</li>
        </ul>
      </div>

      <div class="des-prevencion-card durante">
        <div class="des-prevencion-top"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3l10 18H2L12 3z"/><path d="M12 10v4"/><path d="M12 17h.01"/></svg></div>
        <h4>Durante</h4>
        <ul>
          <li>Mantener la calma y evacuar inmediatamente</li>
          <li>Dirigirse a terreno elevado</li>
          <li>No intentar rescatar bienes materiales</li>
          <li>No cruzar áreas afectadas</li>
          <li>Avisar a vecinos y autoridades</li>
        </ul>
      </div>

      <div class="des-prevencion-card despues">
        <div class="des-prevencion-top"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 0 1 15-6.7L21 8"/><path d="M21 3v5h-5"/><path d="M21 12a9 9 0 0 1-15 6.7L3 16"/><path d="M3 21v-5h5"/></svg></div>
        <h4>Después</h4>
        <ul>
          <li>Mantener distancia del área afectada</li>
          <li>No caminar sobre escombros</li>
          <li>Colaborar con las autoridades</li>
          <li>No construir sobre material deslizado</li>
          <li>Acatar instrucciones de Protección Civil</li>
        </ul>
      </div>
    </div>
  </div>
</section>


<!-- ============================================================
     SECCIÓN 7: DESLIZAMIENTOS HISTÓRICOS
     ============================================================ -->
<section class="des-section" id="historicos">
  <div class="wrap">
    <div class="des-header">
      <span class="des-tag">Historia</span>
      <h2 class="des-title">Deslizamientos <span>históricos</span></h2>
      <p class="des-sub">Los eventos más significativos en El Salvador</p>
    </div>

    <div class="tl-wrap"><div class="tl-line"></div><div class="tl-track" id="tlTrack-deslizamientos"></div></div>
    <div class="tl-detail" id="tlDetail-deslizamientos"></div>
    <div class="data-source-note">
      <strong>Fuentes:</strong> Ministerio de Medio Ambiente y Recursos Naturales (MARN/SNET), Protección Civil y hemerotecas nacionales.
    </div>
  </div>
</section>
<script>
document.addEventListener('DOMContentLoaded', function () {
    ndaInitTimeline('deslizamientos', [
        { year: '1982', title: 'Deslizamiento de Montebello', badge: '500 fallecidos', region: 'San Salvador',
          desc: 'La mañana del 19 de septiembre de 1982, aproximadamente 400,000 m³ de suelo y roca se desprendieron de El Picacho, en el volcán de San Salvador, y descendieron hacia la zona de Montebello y sectores cercanos. El deslizamiento sepultó viviendas y causó numerosas víctimas. Según un informe técnico del SNET, 500 personas fallecieron y 2,380 resultaron damnificadas.',
          tags: [{ t: '400,000 m³', c: 'o' }, { t: '500 fallecidos', c: 'r' }],
          stats: [{ v: '500', l: 'Fallecidos' }, { v: '2,380', l: 'Damnificados' }, { v: '400,000 m³', l: 'Material desprendido' }],
          img: 'assets/media/img/des 1982.jpg' },
        { year: '1996', title: 'Deslizamiento de La Zompopera', badge: '500 × 1,500 m', region: 'Cerro Miramundo, Chalatenango',
          desc: 'En 1996, se registraron importantes movimientos de tierra en el Cerro Miramundo, Chalatenango, en la zona conocida como La Zompopera. El área afectada tiene aproximadamente 500 metros de ancho por 1,500 metros de largo, con pendientes de entre 70° y 80°. El MARN/SNET señala que los movimientos de la zona están relacionados principalmente con las condiciones de inestabilidad y las lluvias. No se reporta una cifra específica de fallecidos para este evento.',
          tags: [{ t: '500 × 1,500 m', c: 'o' }, { t: '70°-80°', c: '' }],
          stats: [{ v: '500 × 1,500 m', l: 'Área afectada' }, { v: '70°-80°', l: 'Pendiente' }, { v: 'No especificado', l: 'Fallecidos' }],
          img: 'assets/media/img/1996.jpg' },
        { year: '1998', title: 'Deslizamiento de La Zompopera – Huracán Mitch', badge: 'Huracán Mitch', region: 'Cerro Miramundo, Chalatenango',
          desc: 'Durante 1998, las lluvias asociadas al huracán Mitch provocaron nuevos movimientos de tierra en la zona de La Zompopera, en el Cerro Miramundo, Chalatenango. El MARN/SNET registra este evento como parte de los movimientos recurrentes de la zona. No se reporta una cifra específica de fallecidos atribuida a este deslizamiento.',
          tags: [{ t: 'Huracán Mitch', c: 'o' }, { t: 'Recurrente', c: '' }],
          stats: [{ v: 'Huracán Mitch', l: 'Causa asociada' }, { v: '1998', l: 'Año' }, { v: 'No especificado', l: 'Fallecidos' }],
          img: 'assets/media/img/1998.jpg' },
        { year: '2001', title: 'Deslizamiento de Las Colinas', badge: '536 fallecidos', region: 'Santa Tecla, La Libertad',
          desc: 'El 13 de enero de 2001, un terremoto de magnitud 7.6 provocó un enorme deslizamiento en la colonia Las Colinas, Santa Tecla. Una gran masa de tierra se desprendió de una ladera de aproximadamente 400 metros de altura y sepultó parte de la zona residencial. El evento ocasionó 536 fallecidos y destruyó aproximadamente 300 viviendas.',
          tags: [{ t: 'M 7.6', c: 'r' }, { t: '536 fallecidos', c: 'r' }],
          stats: [{ v: '536', l: 'Fallecidos' }, { v: '~300', l: 'Viviendas destruidas' }, { v: '7.6', l: 'Magnitud del terremoto' }],
          img: 'assets/media/img/Deslizamiento de Las Colinas provocado por el terremoto del 13 de enero de 2001.webp' },
        { year: '2009', title: 'Deslizamientos del volcán de San Vicente', badge: '157 fallecidos (emergencia)', region: 'San Vicente',
          desc: 'Entre el 7 y 8 de noviembre de 2009, las lluvias extremadamente intensas provocaron varios flujos de escombros en las laderas del volcán de San Vicente. Se registraron aproximadamente 355 mm de lluvia en seis horas, activando quebradas como El Derrumbo, La Quebradona, El Infiernillo y Amate Blanco. Los flujos afectaron principalmente Verapaz, Guadalupe y Tepetitán. El evento formó parte de una emergencia nacional que registró 176 deslizamientos y 157 fallecidos al 12 de noviembre; posteriormente la cifra nacional de fallecidos continuó aumentando. Nota: los 157 fallecidos corresponden a toda la emergencia por las lluvias, no exclusivamente a los deslizamientos del volcán de San Vicente.',
          tags: [{ t: '355 mm / 6h', c: 'o' }, { t: '176 deslizamientos', c: '' }],
          stats: [{ v: '355 mm / 6h', l: 'Lluvia registrada' }, { v: '176', l: 'Deslizamientos registrados' }, { v: '157*', l: 'Fallecidos en la emergencia nacional (al 12/11/2009)' }],
          img: 'assets/media/img/Volcán San Vicente (Chinchontepec).jpg' },
        { year: '2011', title: 'Deslizamiento de Vainillas y El Camalote', badge: 'Rotacional', region: 'Chalatenango',
          desc: 'El 26 de septiembre de 2011, se registró un deslizamiento de tipo rotacional en el cantón Vainillas y el caserío El Camalote, en Chalatenango. El movimiento estuvo relacionado con las condiciones de humedad y las lluvias que afectaron la zona. No se reporta una cifra específica de fallecidos para este evento.',
          tags: [{ t: 'Rotacional', c: 'o' }, { t: 'Lluvias', c: '' }],
          stats: [{ v: '2011', l: 'Año' }, { v: 'Rotacional', l: 'Tipo de deslizamiento' }, { v: 'No especificado', l: 'Fallecidos' }],
          img: 'assets/media/img/2011.jpg' }
    ]);
});
</script>


<!-- ============================================================
     SECCIÓN 8: MITOS Y REALIDADES
     ============================================================ -->
<section class="des-section des-section-dark" id="mitos">
  <div class="wrap">
    <div class="des-header">
      <span class="des-tag">Información</span>
      <h2 class="des-title">Mitos y <span>realidades</span></h2>
      <p class="des-sub">Desmintiendo creencias comunes sobre los deslizamientos</p>
    </div>

    <div class="des-mitos-grid">
      <div class="des-mito-card mito">
        <svg class="des-mito-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M9 9l6 6M15 9l-6 6"/></svg>
        <div class="des-mito-text"><strong>"Solo ocurren en época de lluvia"</strong>También pueden ocurrir por sismos, actividad volcánica o deforestación en cualquier época.</div>
      </div>
      <div class="des-mito-card realidad">
        <svg class="des-mito-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M8 12l3 3 5-6"/></svg>
        <div class="des-mito-text"><strong>"Ya ocurrió, no volverá a pasar"</strong>Pueden repetirse en el mismo lugar si las condiciones no cambian.</div>
      </div>
      <div class="des-mito-card mito">
        <svg class="des-mito-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M9 9l6 6M15 9l-6 6"/></svg>
        <div class="des-mito-text"><strong>"Los árboles evitan todos los deslizamientos"</strong>Ayudan pero no son suficientes contra lluvias extremas o sismos de gran magnitud.</div>
      </div>
      <div class="des-mito-card realidad">
        <svg class="des-mito-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M8 12l3 3 5-6"/></svg>
        <div class="des-mito-text"><strong>"Un deslizamiento lento no es peligroso"</strong>Puede acelerarse repentinamente y volverse catastrófico.</div>
      </div>
    </div>
  </div>
</section>


<!-- ============================================================
     SCRIPTS
     ============================================================ -->
<!-- GSAP -->
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>

<!-- Tu archivo JS -->
<script src="assets/js/deslizamientos.js"></script>

<?php
$content = ob_get_clean();
require_once 'layout.php';
?>
