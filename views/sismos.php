<?php
$title = $title ?? 'Sismos - NDA';
$user = $user ?? null;
$currentSlug = 'sismos';
$extraCss = ['css/desastres-base.css'];
ob_start();
?>

<!-- ============================================================
     BIG BANNER
     ============================================================ -->
<section class="dis-bigbanner" style="--dis-accent:#c98a3d; background-image:url('assets/media/img/Sismo.png')">
  <div class="dis-bigbanner-overlay"></div>
  <div class="wrap dis-bigbanner-inner">
    <div class="dis-bigbanner-badge">El Salvador · Cinturón de Fuego</div>
    <h2 class="dis-bigbanner-word">Sismos</h2>
    <div class="dis-bigbanner-sub">
      <span class="dis-bigbanner-rule"></span>
      <div>
        <p>La subducción de la Placa de Cocos bajo la Placa del Caribe libera energía acumulada en forma de ondas sísmicas que hacen vibrar el suelo.</p>
        <a href="#que-es-un-sismo" class="dis-bigbanner-btn">Explorar</a>
      </div>
    </div>
  </div>
  <a href="#que-es-un-sismo" class="scroll-hint"><span>Scroll</span><div class="sh-arr"></div></a>
</section>

<!-- CONTEXTO RAPIDO -->
<section class="dis-context" style="--dis-accent:#c98a3d; background-image:url('assets/media/img/Sismo.png')">
  <div class="dis-context-overlay"></div>
  <div class="wrap dis-context-inner">
    <div class="dis-context-hd">
      <span class="dis-context-eyebrow">El Salvador</span>
      <h2 class="dis-context-title">Uno de los países más sísmicos del mundo</h2>
    </div>
    <div class="dis-context-cards">
      <div class="dis-context-card">
        <span class="dis-context-card-ico"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg></span>
        <h4>¿Por qué aquí?</h4>
        <p>El país está sobre el límite entre la Placa de Cocos y la Placa del Caribe, una de las zonas de subducción más activas del mundo.</p>
      </div>
      <div class="dis-context-card">
        <span class="dis-context-card-ico"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg></span>
        <h4>¿Cómo se mide?</h4>
        <p>La magnitud (energía liberada) se mide con la escala de momento; la intensidad (daño percibido) con la escala de Mercalli.</p>
      </div>
      <div class="dis-context-card">
        <span class="dis-context-card-ico"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></span>
        <h4>Sismo más devastador</h4>
        <p>El terremoto del 13 de enero de 2001, magnitud 7.7, dejó 1,259 fallecidos: el más letal de la historia reciente del país.</p>
      </div>
      <div class="dis-context-card">
        <span class="dis-context-card-ico"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3l10 18H2L12 3z"/><path d="M12 10v4"/><path d="M12 17h.01"/></svg></span>
        <h4>Frecuencia</h4>
        <p>Cerca de 100 sismos perceptibles al año, aunque la gran mayoría son de baja magnitud y pasan casi desapercibidos.</p>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECCIÓN 1: ¿QUÉ ES UN SISMO? - CON IMAGEN
     ============================================================ -->
<section class="sec" id="que-es-un-sismo">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Sismología</div>
      <h2 class="sec-title">¿Qué es un <span class="acc">sismo</span>?</h2>
      <p class="sec-sub">Etimología, definición y conceptos fundamentales</p>
    </div>

    <div class="sismo-hero-grid">
      <div class="sismo-hero-text">
        <div class="sismo-etymology">
          <span class="etym-greek">σεισμός <small>· seísmos · "sacudida"</small></span>
          <p class="etym-def">
            Un <strong>sismo</strong> es un movimiento brusco de la Tierra causado por la liberación repentina de energía acumulada durante un largo tiempo en el interior del planeta. Esta energía viaja en forma de <strong>ondas sísmicas</strong> que hacen vibrar el suelo.
          </p>
        </div>
        <div class="term-grid">
          <div class="term-card">
            <span class="term-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <path d="M12 6L12 12"/>
                <path d="M12 12L16 16"/>
              </svg>
            </span>
            <h4>Sismo</h4>
            <p>Término general y técnico para cualquier vibración de la Tierra.</p>
            <span class="term-tag">Técnico</span>
          </div>
          <div class="term-card">
            <span class="term-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 2L12 22"/>
                <path d="M4 8L20 8"/>
                <path d="M4 16L20 16"/>
                <circle cx="12" cy="8" r="2"/>
                <circle cx="12" cy="16" r="2"/>
              </svg>
            </span>
            <h4>Temblor</h4>
            <p>Movimiento sentido sin daños graves. Uso común en El Salvador.</p>
            <span class="term-tag">Común</span>
          </div>
          <div class="term-card">
            <span class="term-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <polygon points="12,2 15,9 22,9.5 16.5,14 18,21 12,17.5 6,21 7.5,14 2,9.5 9,9"/>
              </svg>
            </span>
            <h4>Terremoto</h4>
            <p>Sismo de gran magnitud con daños extensos y víctimas.</p>
            <span class="term-tag">Destructivo</span>
          </div>
        </div>
      </div>
      <div class="sismo-hero-image">
        <div class="sismo-image-card">
          <img src="assets/media/img/ondasismica.jpg" alt="Representación de un sismo" loading="lazy">
          <div class="sismo-image-overlay">
            <span class="sismo-image-label">Liberación de energía sísmica</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECCIÓN 2: ¿CÓMO SE PRODUCEN? - ESTILO EDITORIAL
     ============================================================ -->
<section class="sec sec-dark" id="como-se-producen">
  <div class="wrap">
    <div class="sec-hd center">
      <div class="sec-eyebrow">Geodinámica</div>
      <h2 class="sec-title">¿Cómo se producen los <span class="acc">sismos</span>?</h2>
      <p class="sec-sub" style="margin:0 auto;">El proceso de acumulación y liberación de energía en la corteza terrestre</p>
    </div>

    <p class="sismo-intro-text">
      La <strong>litosfera</strong> está fragmentada en piezas llamadas <strong>placas tectónicas</strong> que se mueven entre sí a velocidades de pocos centímetros al año. Estos movimientos acumulan energía que, al liberarse repentinamente, genera un sismo.
    </p>

    <div class="sismo-steps">
      <!-- Paso 01 -->
      <div class="sismo-step">
        <div class="sismo-step-inner">
          <div class="step-image">
            <img src="assets/media/img/acumulaciontension.png" alt="Acumulación de tensión" loading="lazy">
          </div>
          <div class="step-content">
            <div class="step-number">#01</div>
            <h4>Acumulación de tensión</h4>
            <p>Las placas tectónicas se mueven y rozan entre sí, acumulando energía en las zonas de contacto como deformación elástica en las rocas.</p>
          </div>
        </div>
      </div>

      <!-- Paso 02 -->
      <div class="sismo-step">
        <div class="sismo-step-inner">
          <div class="step-image">
            <img src="assets/media/img/TeoriaReboteElasticoReid.png" alt="Superación del límite elástico" loading="lazy">
          </div>
          <div class="step-content">
            <div class="step-number">#02</div>
            <h4>Superación del límite elástico</h4>
            <p>Cuando la tensión supera la resistencia de las rocas, estas se fracturan o deslizan bruscamente, liberando toda la energía almacenada.</p>
          </div>
        </div>
      </div>

      <!-- Paso 03 -->
      <div class="sismo-step">
        <div class="sismo-step-inner">
          <div class="step-image">
            <img src="assets/media/img/liberacionenergia.png" alt="Liberación de energía" loading="lazy">
          </div>
          <div class="step-content">
            <div class="step-number">#03</div>
            <h4>Liberación de energía</h4>
            <p>La energía liberada se propaga en forma de <strong>ondas sísmicas</strong> que viajan a través de la Tierra, causando el movimiento que percibimos.</p>
          </div>
        </div>
      </div>

      <!-- Paso 04 -->
      <div class="sismo-step">
        <div class="sismo-step-inner">
          <div class="step-image">
            <img src="assets/media/img/replicas.png" alt="Reacomodo y réplicas" loading="lazy">
          </div>
          <div class="step-content">
            <div class="step-number">#04</div>
            <h4>Reacomodo y réplicas</h4>
            <p>Tras el sismo principal, las rocas se reacomodan generando <strong>réplicas</strong> de menor magnitud durante días o semanas.</p>
          </div>
        </div>
      </div>
    </div>

    <div class="sismo-sv-note">
      <div class="sv-note-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="12" r="10"/>
          <line x1="12" y1="8" x2="12" y2="12"/>
          <line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
      </div>
      <p><strong>En El Salvador:</strong> la subducción de la Placa de Cocos bajo la Placa del Caribe es la principal causa de la actividad sísmica, con un movimiento de aproximadamente <strong>8 cm por año</strong>.</p>
    </div>
  </div>
</section>

<!-- ============================================================
     SECCIÓN 3: FOCO Y EPICENTRO - CON DIAGRAMA + IMAGEN
     ============================================================ -->
<section class="sec" id="foco-epicentro">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Localización</div>
      <h2 class="sec-title">Foco y <span class="acc">Epicentro</span></h2>
      <p class="sec-sub">Dónde se origina un sismo y dónde se siente con mayor intensidad</p>
    </div>

    <div class="foco-grid">
      <div class="foco-epicentro-wrap">
        <div class="phdr">
          <span class="wdot"></span> Diagrama: Hipocentro vs Epicentro
          <span style="margin-left:auto;font-size:0.7rem;color:var(--text3);">El Salvador</span>
        </div>
        <div class="foco-canvas">
          <canvas id="focoEpicentroCv"></canvas>
          <div class="foco-legend">
            <div class="foco-legend-item">
              <span class="foco-dot" style="background:var(--acc);"></span>
              <div>
                <strong>Hipocentro (Foco)</strong>
                <p>Punto interior donde se origina el sismo. Profundidad de 0 a 700 km.</p>
              </div>
            </div>
            <div class="foco-legend-item">
              <span class="foco-dot" style="background:var(--acc3);"></span>
              <div>
                <strong>Epicentro</strong>
                <p>Proyección en superficie. Donde el sismo se siente con mayor intensidad.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="foco-image-card">
        <img src="assets/media/img/focoepicentro.jpg" alt="Foco y epicentro de un sismo" loading="lazy">
        <div class="foco-image-overlay">
          <span class="foco-image-label">Representación del foco y epicentro</span>
        </div>
      </div>
    </div>

    <div class="depth-grid">
      <div class="depth-card" style="border-top-color:var(--green);">
        <span class="depth-label">Superficial</span>
        <span class="depth-value">&lt; 70 km</span>
        <p>Los más destructivos. Mayor impacto en la superficie.</p>
      </div>
      <div class="depth-card" style="border-top-color:var(--acc3);">
        <span class="depth-label">Intermedio</span>
        <span class="depth-value">70 - 300 km</span>
        <p>Daños moderados dependiendo de la magnitud.</p>
      </div>
      <div class="depth-card" style="border-top-color:var(--blue);">
        <span class="depth-label">Profundo</span>
        <span class="depth-value">&gt; 300 km</span>
        <p>Generalmente imperceptibles en la superficie.</p>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECCIÓN 4: TIPOS DE SISMOS - GALERÍA CON IMÁGENES
     ============================================================ -->
<section class="sec sec-dark" id="tipos-sismos">
  <div class="wrap">
    <div class="sec-hd center">
      <div class="sec-eyebrow">Clasificación</div>
      <h2 class="sec-title">Tipos de <span class="acc">Sismos</span></h2>
      <p class="sec-sub" style="margin:0 auto;">Según su origen y causas</p>
    </div>

    <div class="types-grid">
      <div class="type-card" style="--type-color:var(--dis-accent);">
        <div class="type-card-image">
          <img src="assets/media/img/sismotectonico.jpeg" alt="Sismo tectónico" loading="lazy">
        </div>
        <div class="type-card-body">
          <h4>Tectónicos</h4>
          <p>Los más comunes y destructivos. Ocurren por el movimiento de placas tectónicas.</p>
          <span class="type-tag">Tectónico</span>
        </div>
      </div>
      <div class="type-card" style="--type-color:var(--acc2);">
        <div class="type-card-image">
          <img src="assets/media/img/sismovolcanico.jpg" alt="Sismo volcánico" loading="lazy">
        </div>
        <div class="type-card-body">
          <h4>Volcánicos</h4>
          <p>Asociados a actividad volcánica. Se generan por el movimiento de magma.</p>
          <span class="type-tag">Volcánico</span>
        </div>
      </div>
      <div class="type-card" style="--type-color:var(--teal);">
        <div class="type-card-image">
          <img src="assets/media/img/sismocolapso.png" alt="Sismo por colapso" loading="lazy">
        </div>
        <div class="type-card-body">
          <h4>Por Colapso</h4>
          <p>Ocurren cuando una caverna, mina o túnel colapsa. Eventos locales.</p>
          <span class="type-tag">Colapso</span>
        </div>
      </div>
      <div class="type-card" style="--type-color:var(--blue);">
        <div class="type-card-image">
          <img src="assets/media/img/sismoinducido.png" alt="Sismo inducido" loading="lazy">
        </div>
        <div class="type-card-body">
          <h4>Inducidos</h4>
          <p>Generados por actividades humanas: extracción de petróleo, fracking o represas.</p>
          <span class="type-tag">Inducido</span>
        </div>
      </div>
    </div>

    <div class="sv-banner">
      <svg viewBox="0 0 24 24" fill="none" stroke="#c98a3d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="10"/>
        <line x1="12" y1="8" x2="12" y2="12"/>
        <line x1="12" y1="16" x2="12.01" y2="16"/>
      </svg>
      <p><strong>El Salvador está en el Cinturón de Fuego del Pacífico,</strong> donde convergen las placas de Cocos, Caribe y Norteamérica. Es uno de los países con <strong>mayor actividad sísmica del mundo</strong>.</p>
    </div>
  </div>
</section>

<!-- ============================================================
     SECCIÓN 5: ONDAS SÍSMICAS - CON IMÁGENES
     ============================================================ -->
<section class="sec" id="ondas-sismicas">
  <div class="wrap">
    <div class="sec-hd center">
      <div class="sec-eyebrow">Propagación</div>
      <h2 class="sec-title">Ondas <span class="acc">Sísmicas</span></h2>
      <p class="sec-sub" style="margin:0 auto;">Cómo viaja la energía desde el hipocentro hasta la superficie</p>
    </div>

    <div class="waves-grid">
      <div class="wave-card p-wave">
        <div class="wave-card-image">
          <img src="assets/media/img/ondasP.png" alt="Onda P" loading="lazy">
        </div>
        <div class="wave-card-info">
          <span class="wave-tag">Primaria</span>
          <h4>Onda P</h4>
          <span class="wave-speed">~6-8 km/s</span>
          <p>Viaja comprimiendo y estirando las rocas. <strong>Llega primero</strong> al sismógrafo. Atraviesa sólidos y líquidos.</p>
        </div>
      </div>
      <div class="wave-card s-wave">
        <div class="wave-card-image">
          <img src="assets/media/img/ondasS.png" alt="Onda S" loading="lazy">
        </div>
        <div class="wave-card-info">
          <span class="wave-tag">Secundaria</span>
          <h4>Onda S</h4>
          <span class="wave-speed">~3.5-4.5 km/s</span>
          <p>Vibra perpendicular a la dirección de propagación. <strong>Llega después</strong> y causa más daño. Solo viaja por sólidos.</p>
        </div>
      </div>
      <div class="wave-card surf-wave">
        <div class="wave-card-image">
          <img src="assets/media/img/ondasRL.png" alt="Onda superficial" loading="lazy">
        </div>
        <div class="wave-card-info">
          <span class="wave-tag">Superficial</span>
          <h4>Rayleigh + Love</h4>
          <span class="wave-speed">&lt;4 km/s</span>
          <p>Viajan por la superficie terrestre. Son las <strong>más destructivas</strong>.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECCIÓN 6: ¿CÓMO SE MIDEN? - CON IMÁGENES
     ============================================================ -->
<section class="sec sec-dark" id="como-se-miden">
  <div class="wrap">
    <div class="sec-hd center">
      <div class="sec-eyebrow">Medición</div>
      <h2 class="sec-title">¿Cómo se miden los <span class="acc">sismos</span>?</h2>
      <p class="sec-sub" style="margin:0 auto;">Magnitud vs Intensidad · Escalas de Richter y Mercalli</p>
    </div>

    <div class="measure-grid">
      <div class="measure-card" style="border-top-color:var(--acc);">
        <div class="measure-inner">
          <div class="measure-image">
            <img src="assets/media/img/magnitudS.png" alt="Magnitud sísmica" loading="lazy">
          </div>
          <div class="measure-body">
            <h4>Magnitud</h4>
            <p>Cuantifica la <strong>energía liberada</strong> en el foco del sismo. Se calcula con sismógrafos. Un aumento de 1 punto representa <strong>32 veces más energía</strong>.</p>
            <span class="measure-example">Ejemplo: M7 libera 32× más energía que M6</span>
          </div>
        </div>
      </div>

      <div class="measure-card" style="border-top-color:var(--acc2);">
        <div class="measure-inner">
          <div class="measure-image">
            <img src="assets/media/img/intensidadS.png" alt="Intensidad sísmica" loading="lazy">
          </div>
          <div class="measure-body">
            <h4>Intensidad</h4>
            <p>Mide los <strong>efectos y daños</strong> en un lugar específico. Depende de la distancia al epicentro y tipo de suelo. Se expresa con <strong>números romanos</strong> del I al XII.</p>
            <span class="measure-example">Ejemplo: Intensidad VIII = daños graves en edificios</span>
          </div>
        </div>
      </div>
    </div>

    <div class="scale-table-wrap">
      <div class="phdr">
        <span class="wdot"></span> Comparativa: Magnitud vs Intensidad
        <span style="margin-left:auto;font-size:0.7rem;color:var(--text3);">Escala de medición</span>
      </div>
      <table>
        <thead>
          <tr>
            <th>Magnitud (Richter)</th>
            <th>Intensidad (Mercalli)</th>
            <th>Efectos</th>
          </tr>
        </thead>
        <tbody>
          <tr><td>&lt; 2.0</td><td>I</td><td>Imperceptible. Solo detectado por sismógrafos.</td></tr>
          <tr><td>2.0 - 3.4</td><td>II - III</td><td>Sentido por pocas personas en reposo.</td></tr>
          <tr><td>3.5 - 4.2</td><td>III - IV</td><td>Vibración ligera. Objetos se balancean.</td></tr>
          <tr><td>4.3 - 4.8</td><td>IV - V</td><td>Sentido por casi todos. Caída de objetos pequeños.</td></tr>
          <tr><td>4.9 - 5.4</td><td>V - VI</td><td>Daños en edificios mal construidos.</td></tr>
          <tr class="highlight-row"><td><strong>5.5 - 6.0</strong></td><td><strong>VI - VII</strong></td><td><strong>Daños considerables. Común en El Salvador.</strong></td></tr>
          <tr><td>6.1 - 6.9</td><td>VIII - IX</td><td>Daños severos. Colapso de estructuras.</td></tr>
          <tr><td>7.0 - 7.9</td><td>X - XI</td><td>Destrucción generalizada. Grandes deslizamientos.</td></tr>
          <tr><td>≥ 8.0</td><td>XII</td><td>Catástrofe total. Cambios en el terreno.</td></tr>
        </tbody>
      </table>
    </div>
  </div>
</section>

<!-- ============================================================
     SECCIÓN 7: SISMOLOGÍA EN EL SALVADOR
     ============================================================ -->
<section class="sec" id="sismologia-sv">
  <div class="wrap">
    <div class="sec-hd center">
      <div class="sec-eyebrow">Monitoreo Nacional</div>
      <h2 class="sec-title">Sismología en <span class="acc">El Salvador</span></h2>
      <p class="sec-sub" style="margin:0 auto;">La Red Sísmica Nacional y el monitoreo constante</p>
    </div>

    <div class="sv-sismologia">
      <!-- Grid: texto a la izquierda, imagen a la derecha -->
      <div class="sv-grid">
        <!-- Columna izquierda: texto + estadísticas -->
        <div class="sv-left">
          <div class="sv-text">
            <p class="sv-description">
              La <strong>Sismología</strong> estudia los terremotos y la propagación de ondas sísmicas. En El Salvador, el <strong>Ministerio de Medio Ambiente (MARN)</strong> opera la <strong>Red Sísmica Nacional</strong> con más de 30 estaciones en todo el territorio.
            </p>
            <p class="sv-footnote">
              La información recopilada permite determinar ubicación, magnitud y profundidad de cada sismo, ayudando a la <strong>prevención</strong> y <strong>gestión de riesgos</strong>.
            </p>
          </div>

          <!-- Estadísticas: 2 filas de 2 columnas con números arriba y texto abajo centrado -->
          <div class="sv-stats">
            <div class="sv-stat">
              <span class="sv-num">30+</span>
              <span class="sv-lbl">Estaciones sísmicas</span>
            </div>
            <div class="sv-stat">
              <span class="sv-num">100</span>
              <span class="sv-lbl">Sismos perceptibles/año</span>
            </div>
            <div class="sv-stat">
              <span class="sv-num">8 cm</span>
              <span class="sv-lbl">Subducción anual Cocos</span>
            </div>
            <div class="sv-stat">
              <span class="sv-num">24/7</span>
              <span class="sv-lbl">Monitoreo continuo</span>
            </div>
          </div>
        </div>

        <!-- Columna derecha: imagen -->
        <div class="sv-image">
          <img src="assets/media/img/sismologia.png" alt="Monitoreo sísmico en El Salvador" loading="lazy">
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECCIÓN 8: HISTORIA - LÍNEA DE TIEMPO
     ============================================================ -->
<section class="sec sec-dark" id="timeline">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Historia Sísmica · El Salvador</div>
      <h2 class="sec-title">Línea del <span class="acc">Tiempo</span></h2>
      <p class="sec-sub">Los terremotos más significativos en la historia del país</p>
    </div>
    <div class="tl-wrap">
      <div class="tl-line"></div>
      <div class="tl-track" id="tlTrack"></div>
    </div>
    <div class="tl-detail" id="tlDetail"></div>
    <div class="data-source-note">
      <strong>Fuentes y respaldo de datos:</strong> Servicio Nacional de Estudios Territoriales (SNET/MARN), Universidad Centroamericana "José Simeón Cañas" (UCA), Ministerio de Educación de El Salvador y hemerotecas nacionales (La Prensa Gráfica, El Diario de Hoy).
    </div>
  </div>
</section>

<!-- ============================================================
     SECCIÓN 9: GUÍA PRÁCTICA - CON IMÁGENES
     ============================================================ -->
<section class="sec" id="guia-practica">
  <div class="wrap">
    <div class="sec-hd center">
      <div class="sec-eyebrow">Preparación</div>
      <h2 class="sec-title">¿Qué hacer <span class="acc">antes, durante y después</span>?</h2>
      <p class="sec-sub" style="margin:0 auto;">Recomendaciones para estar preparado</p>
    </div>

    <div class="guide-grid">
      <div class="guide-card before">
        <div class="guide-image">
          <img src="assets/media/img/antesS.png" alt="Preparación antes de un sismo" loading="lazy">
        </div>
        <div class="guide-body">
          <h4>Antes</h4>
          <ul>
            <li>Prepara un plan familiar de emergencia</li>
            <li>Identifica zonas seguras en tu hogar</li>
            <li>Ten una mochila con suministros básicos</li>
            <li>Conoce las rutas de evacuación</li>
          </ul>
        </div>
      </div>
      <div class="guide-card during">
        <div class="guide-image">
          <img src="assets/media/img/duranteS.png" alt="Qué hacer durante un sismo" loading="lazy">
        </div>
        <div class="guide-body">
          <h4>Durante</h4>
          <ul>
            <li>Mantén la calma y no corras</li>
            <li>Agáchate, cúbrete y agárrate</li>
            <li>Aléjate de ventanas y objetos que caigan</li>
            <li>No uses elevadores</li>
          </ul>
        </div>
      </div>
      <div class="guide-card after">
        <div class="guide-image">
          <img src="assets/media/img/despuesS.png" alt="Qué hacer después de un sismo" loading="lazy">
        </div>
        <div class="guide-body">
          <h4>Después</h4>
          <ul>
            <li>Revisa si hay heridos y brinda ayuda</li>
            <li>Alejate de edificios dañados</li>
            <li>Escucha las indicaciones de las autoridades</li>
            <li>Prepárate para posibles réplicas</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECCIÓN 10: ZONA SÍSMICA - MAPA
     ============================================================ -->
<section class="sec sec-dark">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Mapa de Riesgo · El Salvador</div>
      <h2 class="sec-title">Zona <span class="acc">Sísmica</span></h2>
      <p class="sec-sub">Zonas de mayor actividad sísmica, volcanes y riesgos asociados — datos de MARN, USGS, EMSC e IOC-UNESCO</p>
    </div>
    <div class="map-container">
      <div class="map-ctrl-bar">
        <button class="mc-btn on" data-layer="seismic">Zonas sísmicas</button>
        <button class="mc-btn" data-layer="volcanic">Volcanes</button>
        <button class="mc-btn" data-layer="quakes">Sismos recientes (USGS+EMSC)</button>
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

<!-- ============================================================
     SECCIÓN 11: MONITOR SÍSMICO EN TIEMPO REAL
     ============================================================ -->
<section class="sec" id="monitor-tiempo-real">
  <div class="wrap">
    <div class="sec-hd" style="display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:12px">
      <div>
        <div class="page-eyebrow">Actividad Sísmica · El Salvador</div>
        <div class="page-title">Sismógrafo <span class="acc">Interactivo</span></div>
      </div>
      <button class="btn-acc" id="simBtn" style="font-size:.82rem;padding:9px 18px">Simular sismo</button>
    </div>
    <div class="pt-rule"></div>
    <div class="seismo-layout">
      <div>
        <div class="sg-main-card">
          <div class="phdr">
            <div style="width:32px;height:32px;background:rgba(255,77,26,.15);border-radius:var(--rs);display:flex;align-items:center;justify-content:center;font-size:.9rem;flex-shrink:0">
              <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em">
                <path d="M8 21l4-13 4 13"/>
                <circle cx="12" cy="6" r="1.4"/>
                <path d="M12 6l-1.5 3M12 6l1.5 3"/>
              </svg>
            </div>
            <div style="min-width:0;overflow:hidden">
              <div style="font-weight:700;color:var(--text);font-size:.85rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">Sismógrafo Interactivo — El Salvador</div>
              <div style="font-size:.7rem;color:var(--text3);white-space:nowrap;overflow:hidden;text-overflow:ellipsis" id="sgSubtitle">Estación SSN · San Salvador · 13.692°N, 89.218°W · EN VIVO</div>
            </div>
            <div class="hm-live" style="margin-left:auto;flex-shrink:0"><span class="ldot"></span>EN VIVO</div>
            <div style="font-size:.72rem;color:var(--text3);background:var(--bg3);padding:4px 10px;border-radius:100px;margin-left:8px;flex-shrink:0;white-space:nowrap" id="sgFreqLabel">Frecuencia media</div>
          </div>
          <div class="sg-wave-area">
            <div class="sg-depth-badge">PROFUNDIDAD: <strong id="sgDepth">— KM</strong></div>
            <canvas id="mainSg"></canvas>
          </div>
          <div class="sg-controls">
            <button class="sg-preset m3 on" data-mag="3" data-cls="m3">M3 <span style="font-size:.65rem;opacity:.7">leve</span></button>
            <button class="sg-preset m6" data-mag="6" data-cls="m6">M6 <span style="font-size:.65rem;opacity:.7">moderado</span></button>
            <button class="sg-preset m7" data-mag="7" data-cls="m7">M7 <span style="font-size:.65rem;opacity:.7">fuerte</span></button>
            <button class="sg-preset m85" data-mag="8.5" data-cls="m85">M8.5 <span style="font-size:.65rem;opacity:.7">gran terremoto</span></button>
            <button class="sg-reset" id="sgReset">
              <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em">
                <polyline points="1 4 1 10 7 10"/>
                <path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/>
              </svg> Reiniciar
            </button>
            <div class="sg-mag-slider">
              <label>Magnitud:</label>
              <input type="range" class="sg-slider" id="sgMagSlider" min="1" max="9" step=".1" value="3"/>
              <span class="sg-mag-val" id="sgMagDisp">3</span>
            </div>
          </div>
          <p style="font-size:.7rem;color:var(--text3);padding:0 14px 12px;margin:0;">Los controles de magnitud solo simulan cómo se vería la onda de un sismo de esa magnitud. La <strong>profundidad</strong> y las estadísticas de abajo son datos reales combinados del USGS y del EMSC (European-Mediterranean Seismological Centre) para la región de El Salvador — no se pueden editar, y se actualizan solas cada 30 segundos (o al instante si detectan un sismo nuevo).</p>
          <div class="sg-stats-bar">
            <div class="sgstat"><div class="sgstat-lbl">último Evento</div><div class="sgstat-val acc" id="sg-last-mag">M—</div><div class="sgstat-sub" id="sg-last-loc">—</div></div>
            <div class="sgstat"><div class="sgstat-lbl">Profundidad</div><div class="sgstat-val" id="sg-depth-v">— km</div><div class="sgstat-sub" id="sg-depth-l">—</div></div>
            <div class="sgstat"><div class="sgstat-lbl">Sismos Hoy</div><div class="sgstat-val teal" id="sg-today">—</div><div class="sgstat-sub">promedio: 9/día</div></div>
            <div class="sgstat"><div class="sgstat-lbl">Zona Tectónica</div><div class="sgstat-val" style="font-size:1rem">Cocos/Caribe</div><div class="sgstat-sub">Subducción activa</div></div>
          </div>
        </div>
        <div style="margin-top:14px;background:var(--card);border:1px solid var(--border2);border-radius:var(--r);overflow:hidden" id="quakeFeed-wrap">
          <div class="phdr">
            <span class="ldot"></span>Sismos Recientes — USGS + EMSC
            <span id="quakeUpdatedAt" style="margin-left:auto;font-size:.68rem;color:var(--text3)">cargando…</span>
            <button class="sg-reset" id="refreshQ" style="margin-left:8px;padding:4px 11px">
              <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em">
                <polyline points="1 4 1 10 7 10"/>
                <path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/>
              </svg>
            </button>
          </div>
          <div id="quakeFeed"><div class="loading-s"><div class="spin"></div>Cargando datos USGS + EMSC…</div></div>
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

<!-- ============================================================
     SECCIÓN 12: SIMULADOR
     ============================================================ -->
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

<!-- ============================================================
     GSAP ANIMATIONS - ARCHIVO UNIFICADO
     ============================================================ -->
<!-- Cargar GSAP desde jsdelivr (no necesitas Cloudflare) -->
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>

<!-- Tu archivo de animaciones (con los nuevos selectores para sismos) -->
<script src="assets/js/gsap-animations.js"></script>

<?php
$content = ob_get_clean();
require_once 'layout.php';
?>