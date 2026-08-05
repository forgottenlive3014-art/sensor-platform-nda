<?php
$title = $title ?? 'Volcanes - NDA';
$user = $user ?? null;
$extraCss = ['css/volcanes.css'];
ob_start();
?>

<!-- ============================================================
     BANNER PRINCIPAL
     ============================================================ -->
<section class="dis-bigbanner" style="--dis-accent:#e0631f; background-image:url('assets/media/img/volcan.jpg')">
  <div class="dis-bigbanner-overlay"></div>
  <div class="wrap dis-bigbanner-inner">
    <div class="dis-bigbanner-badge">El Salvador · Anillo de Fuego</div>
    <h2 class="dis-bigbanner-word">Volcanes</h2>
    <div class="dis-bigbanner-sub">
      <span class="dis-bigbanner-rule"></span>
      <div>
        <p>El magma acumulado bajo la corteza terrestre busca salida hacia la superficie cuando la presión supera la resistencia de la roca que lo cubre.</p>
        <a href="#intro" class="dis-bigbanner-btn">Explorar</a>
      </div>
    </div>
  </div>
  <a href="#intro" class="scroll-hint"><span>Scroll</span><div class="sh-arr"></div></a>
</section>

<!-- ============================================================
     SECCIÓN 1: INTRODUCCIÓN
     ============================================================ -->
<section class="v-section" id="intro">
  <div class="wrap">
    <div class="v-header center">
      <span class="v-tag">Vulcanología</span>
      <h2 class="v-title">¿Qué es un <span>volcán</span>?</h2>
      <p class="v-sub">Definición, importancia y contexto de El Salvador</p>
    </div>

    <div class="v-grid-2">
      <div class="v-text">
        <p>Un <strong>volcán</strong> es una abertura en la superficie terrestre por donde el magma, gases y ceniza del interior de la Tierra salen hacia el exterior. Cuando este material se escapa, provoca una <strong>erupción volcánica</strong>.</p>
        <p>Los volcanes son fundamentales para la formación de la corteza terrestre, la creación de nuevas tierras y la regulación del clima.</p>
        <div class="v-why">
          <h3>¿Por qué El Salvador es un país volcánico?</h3>
          <p>El país forma parte de la <strong>Cadena Volcánica Centroamericana</strong>, producto de la subducción de la <strong>Placa de Cocos</strong> bajo la <strong>Placa del Caribe</strong>.</p>
        </div>
      </div>
      <div class="v-gallery">
        <div class="v-gallery-grid">
          <div class="v-gallery-item main">
            <img src="assets/media/img/volcan-estructura.jpg" alt="Estructura" loading="lazy">
            <span class="v-gallery-label">Corte transversal de un volcán</span>
          </div>
          <div class="v-gallery-item"><img src="assets/media/img/volcan-erupcion-1.jpg" alt="Erupción" loading="lazy"></div>
          <div class="v-gallery-item"><img src="assets/media/img/volcan-lava.jpg" alt="Lava" loading="lazy"></div>
          <div class="v-gallery-item"><img src="assets/media/img/volcan-ceniza.jpg" alt="Ceniza" loading="lazy"></div>
        </div>
      </div>
    </div>

    <div class="v-stats">
      <div class="v-stat" data-count="242">
        <span class="v-stat-num">0</span>
        <span class="v-stat-label">Formaciones volcánicas</span>
      </div>
      <div class="v-stat" data-count="36">
        <span class="v-stat-num">0</span>
        <span class="v-stat-label">Volcanes activos</span>
      </div>
      <div class="v-stat" data-count="10">
        <span class="v-stat-num">0</span>
        <span class="v-stat-label">Bajo vigilancia</span>
      </div>
      <div class="v-stat" data-count="2005">
        <span class="v-stat-num">0</span>
        <span class="v-stat-label">Última erupción importante</span>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECCIÓN 2: FORMACIÓN - CARRUSEL MODERNO
     ============================================================ -->
<section class="v-section v-section-dark" id="formacion">
  <div class="wrap">
    <div class="v-header center">
      <span class="v-tag">Geodinámica</span>
      <h2 class="v-title">Formación de los <span>Volcanes</span></h2>
      <p class="v-sub">El proceso geológico que da origen a los volcanes</p>
    </div>

    <div class="v-carousel-moderno">
      <div class="v-carousel-slides" id="carouselSlides">
        <div class="v-carousel-slide active">
          <div class="v-carousel-content">
            <span class="v-carousel-num">01</span>
            <h3>Formación de la Tierra</h3>
            <p>La Tierra se formó hace aproximadamente 4,500 millones de años. Su interior mantiene altas temperaturas que generan el calor necesario para la fusión de rocas.</p>
          </div>
          <div class="v-carousel-image">
            <img src="assets/media/img/volcan-formacion-1.jpg" alt="Formación de la Tierra" loading="lazy">
          </div>
        </div>
        <div class="v-carousel-slide">
          <div class="v-carousel-content">
            <span class="v-carousel-num">02</span>
            <h3>Tectónica de placas</h3>
            <p>La litosfera está fragmentada en placas tectónicas que se mueven. En las zonas de subducción, una placa se hunde bajo otra.</p>
          </div>
          <div class="v-carousel-image">
            <img src="assets/media/img/volcan-formacion-2.jpg" alt="Tectónica de placas" loading="lazy">
          </div>
        </div>
        <div class="v-carousel-slide">
          <div class="v-carousel-content">
            <span class="v-carousel-num">03</span>
            <h3>Cinturón de Fuego</h3>
            <p>El Salvador forma parte del Cinturón de Fuego del Pacífico, que concentra el 80% de los volcanes activos del mundo.</p>
          </div>
          <div class="v-carousel-image">
            <img src="assets/media/img/volcan-formacion-3.jpg" alt="Cinturón de Fuego" loading="lazy">
          </div>
        </div>
        <div class="v-carousel-slide">
          <div class="v-carousel-content">
            <span class="v-carousel-num">04</span>
            <h3>Formación del edificio</h3>
            <p>La sucesiva acumulación de lava, ceniza y piroclastos alrededor de la boca eruptiva forma el cono volcánico.</p>
          </div>
          <div class="v-carousel-image">
            <img src="assets/media/img/volcan-formacion-4.jpg" alt="Edificio volcánico" loading="lazy">
          </div>
        </div>
      </div>
      <div class="v-carousel-controls">
        <button class="v-carousel-btn prev" id="carouselPrev">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
        </button>
        <div class="v-carousel-dots" id="carouselDots"></div>
        <button class="v-carousel-btn next" id="carouselNext">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
        </button>
      </div>
    </div>

    <div class="v-note">
      <p><strong>En El Salvador:</strong> más del 90% del subsuelo está formado por rocas de origen magmático.</p>
    </div>
  </div>
</section>

<!-- ============================================================
     SECCIÓN 3: ANATOMÍA - DIAGRAMA INTERACTIVO
     ============================================================ -->
<section class="v-section" id="anatomia">
  <div class="wrap">
    <div class="v-header center">
      <span class="v-tag">Estructura</span>
      <h2 class="v-title">Anatomía del <span>Volcán</span></h2>
      <p class="v-sub">Partes internas y externas de un edificio volcánico</p>
    </div>

    <div class="v-diagram-wrap">
      <div class="v-diagram-image">
        <img src="assets/media/img/volcan-anatomia-diagrama.jpg" alt="Anatomía del volcán" loading="lazy">
        
        <div class="v-diagram-pin" style="top:10%; left:50%;" data-part="Cámara Magmática">
          <span class="v-pin-dot"></span>
          <div class="v-pin-tooltip">
            <strong>Cámara Magmática</strong>
            <p>Reservorio de magma fundido a varios kilómetros de profundidad.</p>
          </div>
        </div>
        <div class="v-diagram-pin" style="top:28%; left:50%;" data-part="Chimenea">
          <span class="v-pin-dot"></span>
          <div class="v-pin-tooltip">
            <strong>Chimenea</strong>
            <p>Conducto principal que comunica la cámara magmática con el cráter.</p>
          </div>
        </div>
        <div class="v-diagram-pin" style="top:55%; left:50%;" data-part="Conducto">
          <span class="v-pin-dot"></span>
          <div class="v-pin-tooltip">
            <strong>Conducto</strong>
            <p>Fisura por la que el magma asciende hacia la superficie.</p>
          </div>
        </div>
        <div class="v-diagram-pin" style="top:80%; left:50%;" data-part="Cráter">
          <span class="v-pin-dot"></span>
          <div class="v-pin-tooltip">
            <strong>Cráter</strong>
            <p>Abertura en la cima por donde salen magma, gases y ceniza.</p>
          </div>
        </div>
        <div class="v-diagram-pin" style="top:68%; left:72%;" data-part="Conos Parásitos">
          <span class="v-pin-dot"></span>
          <div class="v-pin-tooltip">
            <strong>Conos Parásitos</strong>
            <p>Formaciones secundarias en las laderas del volcán.</p>
          </div>
        </div>
        <div class="v-diagram-pin" style="top:85%; left:28%;" data-part="Fumarolas">
          <span class="v-pin-dot"></span>
          <div class="v-pin-tooltip">
            <strong>Fumarolas</strong>
            <p>Aberturas secundarias por donde se emiten gases volcánicos.</p>
          </div>
        </div>
        <div class="v-diagram-pin" style="top:18%; left:75%;" data-part="Caldera">
          <span class="v-pin-dot"></span>
          <div class="v-pin-tooltip">
            <strong>Caldera</strong>
            <p>Gran depresión circular por colapso del volcán.</p>
          </div>
        </div>
        <div class="v-diagram-pin" style="top:88%; left:72%;" data-part="Columna Eruptiva">
          <span class="v-pin-dot"></span>
          <div class="v-pin-tooltip">
            <strong>Columna Eruptiva</strong>
            <p>Nube vertical de gases, cenizas y fragmentos sólidos.</p>
          </div>
        </div>
      </div>
      <div class="v-diagram-legend">
        <span class="v-legend-dot"></span> Pasa el cursor sobre los puntos
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECCIÓN 4: MAGMA Y MATERIALES - TARJETAS
     ============================================================ -->
<section class="v-section v-section-dark" id="magma">
  <div class="wrap">
    <div class="v-header center">
      <span class="v-tag">Materiales</span>
      <h2 class="v-title">Magma y Materiales <span>Volcánicos</span></h2>
      <p class="v-sub">Composición y productos de la actividad volcánica</p>
    </div>

    <div class="v-grid-3">
      <div class="v-card">
        <div class="v-card-img"><img src="assets/media/img/volcan-magma.jpg" alt="Magma" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Magma</h4>
          <p>Roca fundida bajo la superficie terrestre. Compuesto por roca fundida, cristales y gases disueltos.</p>
        </div>
      </div>
      <div class="v-card">
        <div class="v-card-img"><img src="assets/media/img/volcan-lava-flujo.jpg" alt="Lava" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Lava</h4>
          <p>Magma que alcanza la superficie. Temperaturas entre 700 y 1,300 °C.</p>
        </div>
      </div>
      <div class="v-card">
        <div class="v-card-img"><img src="assets/media/img/volcan-ceniza-caida.jpg" alt="Ceniza" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Ceniza</h4>
          <p>Partículas de tefra del grosor de un cabello, transportadas por el viento a grandes distancias.</p>
        </div>
      </div>
      <div class="v-card">
        <div class="v-card-img"><img src="assets/media/img/volcan-piroclastos.jpg" alt="Piroclastos" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Piroclastos</h4>
          <p>Fragmentos sólidos expulsados: ceniza, lapilli, bombas y bloques.</p>
        </div>
      </div>
      <div class="v-card">
        <div class="v-card-img"><img src="assets/media/img/volcan-gases.jpg" alt="Gases" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Gases</h4>
          <p>Vapor de agua (H₂O), CO₂, SO₂, H₂S y haluros de hidrógeno.</p>
        </div>
      </div>
      <div class="v-card">
        <div class="v-card-img"><img src="assets/media/img/volcan-bomba.jpg" alt="Bombas" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Bombas</h4>
          <p>Fragmentos de lava solidificada de gran tamaño (>64 mm).</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECCIÓN 5: CLASIFICACIÓN - TABS INTERACTIVOS
     ============================================================ -->
<section class="v-section" id="clasificacion">
  <div class="wrap">
    <div class="v-header center">
      <span class="v-tag">Clasificación</span>
      <h2 class="v-title">Clasificación de los <span>Volcanes</span></h2>
      <p class="v-sub">Según su actividad, morfología y tipo de erupción</p>
    </div>

    <div class="v-tabs">
      <div class="v-tabs-header">
        <button class="v-tab-btn active" data-tab="actividad">Por Actividad</button>
        <button class="v-tab-btn" data-tab="morfologia">Por Morfología</button>
        <button class="v-tab-btn" data-tab="erupcion">Por Erupción</button>
      </div>
      <div class="v-tabs-content">
        <!-- Actividad -->
        <div class="v-tab-panel active" id="tab-actividad">
          <div class="v-tab-grid">
            <div class="v-tab-item">
              <img src="assets/media/img/volcan-activo.jpg" alt="Activo" loading="lazy">
              <span class="v-tab-badge active">Activo</span>
              <h4>Volcán Activo</h4>
              <p>Ha tenido erupciones en los últimos 11,700 años o muestra signos de actividad.</p>
            </div>
            <div class="v-tab-item">
              <img src="assets/media/img/volcan-dormido.jpg" alt="Dormido" loading="lazy">
              <span class="v-tab-badge dormant">Durmiente</span>
              <h4>Volcán Durmiente</h4>
              <p>Mantiene signos de actividad como aguas termales, pero no ha erupcionado en mucho tiempo.</p>
            </div>
            <div class="v-tab-item">
              <img src="assets/media/img/volcan-extinto.jpg" alt="Extinto" loading="lazy">
              <span class="v-tab-badge extinct">Extinto</span>
              <h4>Volcán Extinto</h4>
              <p>No muestra indicios de reactivación y su estructura está muy erosionada.</p>
            </div>
          </div>
        </div>
        <!-- Morfología -->
        <div class="v-tab-panel" id="tab-morfologia">
          <div class="v-tab-grid">
            <div class="v-tab-item">
              <img src="assets/media/img/volcan-estratovolcan.jpg" alt="Estratovolcán" loading="lazy">
              <span class="v-tab-badge">Estratovolcán</span>
              <h4>Estratovolcán</h4>
              <p>Grande y cónico, formado por capas alternadas de lava y ceniza.</p>
            </div>
            <div class="v-tab-item">
              <img src="assets/media/img/volcan-escudo.jpg" alt="Escudo" loading="lazy">
              <span class="v-tab-badge">Escudo</span>
              <h4>Volcán en Escudo</h4>
              <p>Amplia base y pendientes suaves. Formado por lava fluida.</p>
            </div>
            <div class="v-tab-item">
              <img src="assets/media/img/volcan-cono-ceniza.jpg" alt="Cono de ceniza" loading="lazy">
              <span class="v-tab-badge">Cono de ceniza</span>
              <h4>Cono de Ceniza</h4>
              <p>Pequeño y con pendientes pronunciadas. Formado por acumulación de ceniza.</p>
            </div>
            <div class="v-tab-item">
              <img src="assets/media/img/volcan-maar.jpg" alt="Maar" loading="lazy">
              <span class="v-tab-badge">Maar</span>
              <h4>Maar</h4>
              <p>Cráter amplio de origen explosivo por interacción magma-agua.</p>
            </div>
            <div class="v-tab-item">
              <img src="assets/media/img/volcan-fisural.jpg" alt="Fisural" loading="lazy">
              <span class="v-tab-badge">Fisural</span>
              <h4>Volcán Fisural</h4>
              <p>Lava emerge desde fisuras alargadas, sin formar un cono claro.</p>
            </div>
            <div class="v-tab-item">
              <img src="assets/media/img/volcan-caldera.jpg" alt="Caldera" loading="lazy">
              <span class="v-tab-badge">Caldera</span>
              <h4>Caldera</h4>
              <p>Gran depresión circular por colapso del edificio.</p>
            </div>
          </div>
        </div>
        <!-- Erupción -->
        <div class="v-tab-panel" id="tab-erupcion">
          <div class="v-tab-grid">
            <div class="v-tab-item">
              <img src="assets/media/img/erupcion-hawaiana.jpg" alt="Hawaiana" loading="lazy">
              <span class="v-tab-badge">Hawaiana</span>
              <h4>Hawaiana</h4>
              <p>Lava muy fluida. Pocos gases y cenizas. Erupciones tranquilas.</p>
            </div>
            <div class="v-tab-item">
              <img src="assets/media/img/erupcion-estromboliana.jpg" alt="Estromboliana" loading="lazy">
              <span class="v-tab-badge">Estromboliana</span>
              <h4>Estromboliana</h4>
              <p>Erupciones moderadas con explosiones esporádicas.</p>
            </div>
            <div class="v-tab-item">
              <img src="assets/media/img/erupcion-vulcaniana.jpg" alt="Vulcaniana" loading="lazy">
              <span class="v-tab-badge">Vulcaniana</span>
              <h4>Vulcaniana</h4>
              <p>Erupciones de mediana explosividad. Magma viscoso.</p>
            </div>
            <div class="v-tab-item">
              <img src="assets/media/img/erupcion-peleana.jpg" alt="Peleana" loading="lazy">
              <span class="v-tab-badge">Peleana</span>
              <h4>Peleana</h4>
              <p>Muy explosivas con nubes de gas y ceniza. Altamente destructivas.</p>
            </div>
            <div class="v-tab-item">
              <img src="assets/media/img/erupcion-pliniana.jpg" alt="Pliniana" loading="lazy">
              <span class="v-tab-badge">Pliniana</span>
              <h4>Pliniana</h4>
              <p>Extremadamente explosivas. Grandes cantidades de ceniza y gases.</p>
            </div>
            <div class="v-tab-item">
              <img src="assets/media/img/erupcion-islandesa.jpg" alt="Islandesa" loading="lazy">
              <span class="v-tab-badge">Islandesa</span>
              <h4>Islandesa</h4>
              <p>Erupciones fisurales con lava muy fluida que cubre grandes extensiones.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECCIÓN 6: ERUPCIONES
     ============================================================ -->
<section class="v-section v-section-dark" id="erupciones">
  <div class="wrap">
    <div class="v-header center">
      <span class="v-tag">Fenómeno</span>
      <h2 class="v-title">Erupciones <span>Volcánicas</span></h2>
      <p class="v-sub">Cómo ocurren, aspectos y medición</p>
    </div>

    <p class="v-intro">La roca fundida bajo la superficie terrestre se conoce como <strong>magma</strong>, pero tras su erupción se denomina <strong>lava</strong>.</p>

    <div class="v-grid-3">
      <div class="v-card">
        <div class="v-card-img"><img src="assets/media/img/erupcion-proceso-1.jpg" alt="Presión" loading="lazy"></div>
        <div class="v-card-body">
          <span class="v-card-num">01</span>
          <h4>Acumulación de presión</h4>
          <p>El magma asciende por la chimenea impulsado por la flotabilidad y la presión de los gases disueltos.</p>
        </div>
      </div>
      <div class="v-card">
        <div class="v-card-img"><img src="assets/media/img/erupcion-proceso-2.jpg" alt="Gases" loading="lazy"></div>
        <div class="v-card-body">
          <span class="v-card-num">02</span>
          <h4>Liberación de gases</h4>
          <p>A medida que el magma se acerca a la superficie, la presión disminuye y los gases se liberan violentamente.</p>
        </div>
      </div>
      <div class="v-card">
        <div class="v-card-img"><img src="assets/media/img/erupcion-proceso-3.jpg" alt="Expulsión" loading="lazy"></div>
        <div class="v-card-body">
          <span class="v-card-num">03</span>
          <h4>Expulsión de materiales</h4>
          <p>La erupción expulsa lava, ceniza, gases y fragmentos de roca. La violencia depende de la composición del magma.</p>
        </div>
      </div>
    </div>

    <div class="v-iev">
      <h4>Índice de Explosividad Volcánica (IEV)</h4>
      <p>Escala de 8 grados que mide la magnitud de una erupción.</p>
      <div class="v-iev-scale">
        <span>0</span><span>1</span><span>2</span><span>3</span><span>4</span><span>5</span><span>6</span><span>7</span><span>8</span>
      </div>
      <div class="v-iev-labels">
        <span>No explosiva</span>
        <span>Cataclísmica</span>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECCIÓN 7: VOLCANES DE EL SALVADOR
     ============================================================ -->
<section class="v-section" id="volcanes-sv">
  <div class="wrap">
    <div class="v-header center">
      <span class="v-tag">El Salvador</span>
      <h2 class="v-title">Volcanes de <span>El Salvador</span></h2>
      <p class="v-sub">La cadena volcánica salvadoreña</p>
    </div>

    <p class="v-intro">La cadena volcánica salvadoreña se extiende paralela a la costa pacífica, formando parte del <strong>Cinturón de Fuego Circumpacífico</strong>.</p>

    <div class="v-grid-2">
      <div class="v-card">
        <div class="v-card-body">
          <h4>Volcanes Terciarios</h4>
          <p>Más de 2 millones de años. Ubicados en el borde norte del graben Central Salvadoreño. Son considerados <strong>extintos</strong>.</p>
          <span class="v-badge">Extintos</span>
        </div>
      </div>
      <div class="v-card">
        <div class="v-card-body">
          <h4>Volcanes Cuaternarios</h4>
          <p>Menos de 2 millones de años. Son geológicamente jóvenes. Incluyen estratovolcanes, calderas y conos.</p>
          <span class="v-badge active">Activos</span>
        </div>
      </div>
    </div>

    <div class="v-stats">
      <div class="v-stat" data-count="242">
        <span class="v-stat-num">0</span>
        <span class="v-stat-label">Estructuras volcánicas</span>
      </div>
      <div class="v-stat" data-count="36">
        <span class="v-stat-num">0</span>
        <span class="v-stat-label">Volcanes activos</span>
      </div>
      <div class="v-stat" data-count="10">
        <span class="v-stat-num">0</span>
        <span class="v-stat-label">Bajo vigilancia</span>
      </div>
      <div class="v-stat" data-count="2">
        <span class="v-stat-num">0</span>
        <span class="v-stat-label">Calderas: Ilopango y Coatepeque</span>
      </div>
    </div>

    <div class="v-mapa">
      <img src="assets/media/img/volcan-mapa.jpg" alt="Mapa volcanes El Salvador" loading="lazy">
      <span class="v-mapa-label">Distribución de los volcanes en El Salvador</span>
    </div>
  </div>
</section>

<!-- ============================================================
     SECCIÓN 8: VOLCANES ACTIVOS - GALERÍA
     ============================================================ -->
<section class="v-section v-section-dark" id="volcanes-activos">
  <div class="wrap">
    <div class="v-header center">
      <span class="v-tag">Monitoreo Nacional</span>
      <h2 class="v-title">Volcanes Activos de <span>El Salvador</span></h2>
      <p class="v-sub">Los 10 principales volcanes bajo vigilancia del MARN</p>
    </div>

    <div class="v-grid-2">
      <!-- Santa Ana -->
      <div class="v-card v-card-horizontal">
        <div class="v-card-img">
          <img src="assets/media/img/volcan-santa-ana.jpg" alt="Santa Ana" loading="lazy">
          <span class="v-card-status active">Activo</span>
        </div>
        <div class="v-card-body">
          <h4>Santa Ana</h4>
          <div class="v-card-detail"><span>Altura:</span> 2,381 msnm</div>
          <div class="v-card-detail"><span>Departamento:</span> Santa Ana</div>
          <div class="v-card-detail"><span>Tipo:</span> Estratovolcán</div>
          <div class="v-card-detail"><span>Última erupción:</span> 2005</div>
          <p>El volcán más alto del país.</p>
          <div class="v-card-tags"><span>Estratovolcán</span><span>Fumarolas</span></div>
        </div>
      </div>

      <!-- Izalco -->
      <div class="v-card v-card-horizontal">
        <div class="v-card-img">
          <img src="assets/media/img/volcan-izalco.jpg" alt="Izalco" loading="lazy">
          <span class="v-card-status inactive">Inactivo</span>
        </div>
        <div class="v-card-body">
          <h4>Izalco</h4>
          <div class="v-card-detail"><span>Altura:</span> 1,950 msnm</div>
          <div class="v-card-detail"><span>Departamento:</span> Sonsonate</div>
          <div class="v-card-detail"><span>Tipo:</span> Estratovolcán</div>
          <div class="v-card-detail"><span>Última erupción:</span> 1966</div>
          <p>"El Faro del Pacífico".</p>
          <div class="v-card-tags"><span>Estratovolcán</span><span>Fumarolas</span></div>
        </div>
      </div>

      <!-- San Salvador -->
      <div class="v-card v-card-horizontal">
        <div class="v-card-img">
          <img src="assets/media/img/volcan-san-salvador.jpg" alt="San Salvador" loading="lazy">
          <span class="v-card-status active">Activo</span>
        </div>
        <div class="v-card-body">
          <h4>San Salvador</h4>
          <div class="v-card-detail"><span>Altura:</span> 1,850 msnm</div>
          <div class="v-card-detail"><span>Departamento:</span> San Salvador</div>
          <div class="v-card-detail"><span>Tipo:</span> Estratovolcán</div>
          <div class="v-card-detail"><span>Última erupción:</span> 1917</div>
          <p>También conocido como Boquerón.</p>
          <div class="v-card-tags"><span>Estratovolcán</span><span>Fumarolas</span></div>
        </div>
      </div>

      <!-- San Miguel -->
      <div class="v-card v-card-horizontal">
        <div class="v-card-img">
          <img src="assets/media/img/volcan-san-miguel.jpg" alt="San Miguel" loading="lazy">
          <span class="v-card-status active">Activo</span>
        </div>
        <div class="v-card-body">
          <h4>San Miguel</h4>
          <div class="v-card-detail"><span>Altura:</span> 2,130 msnm</div>
          <div class="v-card-detail"><span>Departamento:</span> San Miguel</div>
          <div class="v-card-detail"><span>Tipo:</span> Estratovolcán</div>
          <div class="v-card-detail"><span>Última erupción:</span> 2020</div>
          <p>Uno de los más activos del país.</p>
          <div class="v-card-tags"><span>Estratovolcán</span><span>Microsismicidad</span></div>
        </div>
      </div>

      <!-- Ilopango -->
      <div class="v-card v-card-horizontal">
        <div class="v-card-img">
          <img src="assets/media/img/volcan-ilopango.jpg" alt="Ilopango" loading="lazy">
          <span class="v-card-status active">Activo</span>
        </div>
        <div class="v-card-body">
          <h4>Ilopango</h4>
          <div class="v-card-detail"><span>Altura:</span> 440 msnm</div>
          <div class="v-card-detail"><span>Departamento:</span> San Salvador</div>
          <div class="v-card-detail"><span>Tipo:</span> Caldera</div>
          <div class="v-card-detail"><span>Última erupción:</span> 1880</div>
          <p>Caldera de 88,000 metros de diámetro.</p>
          <div class="v-card-tags"><span>Caldera</span><span>Microsismicidad</span></div>
        </div>
      </div>

      <!-- San Vicente -->
      <div class="v-card v-card-horizontal">
        <div class="v-card-img">
          <img src="assets/media/img/volcan-san-vicente.jpg" alt="San Vicente" loading="lazy">
          <span class="v-card-status dormant">Dormido</span>
        </div>
        <div class="v-card-body">
          <h4>San Vicente</h4>
          <div class="v-card-detail"><span>Altura:</span> 2,173 msnm</div>
          <div class="v-card-detail"><span>Departamento:</span> San Vicente</div>
          <div class="v-card-detail"><span>Tipo:</span> Estratovolcán</div>
          <div class="v-card-detail"><span>Última erupción:</span> Desconocida</div>
          <p>También conocido como Chichontepec.</p>
          <div class="v-card-tags"><span>Estratovolcán</span><span>Fumarolas</span></div>
        </div>
      </div>

      <!-- Tecapa -->
      <div class="v-card v-card-horizontal">
        <div class="v-card-img">
          <img src="assets/media/img/volcan-tecapa.jpg" alt="Tecapa" loading="lazy">
          <span class="v-card-status active">Activo</span>
        </div>
        <div class="v-card-body">
          <h4>Tecapa</h4>
          <div class="v-card-detail"><span>Altura:</span> 1,592 msnm</div>
          <div class="v-card-detail"><span>Departamento:</span> Usulután</div>
          <div class="v-card-detail"><span>Tipo:</span> Estratovolcán</div>
          <div class="v-card-detail"><span>Última erupción:</span> Desconocida</div>
          <p>Presenta actividad fumarólica y microsismicidad.</p>
          <div class="v-card-tags"><span>Estratovolcán</span><span>Fumarolas</span></div>
        </div>
      </div>

      <!-- Conchagua -->
      <div class="v-card v-card-horizontal">
        <div class="v-card-img">
          <img src="assets/media/img/volcan-conchagua.jpg" alt="Conchagua" loading="lazy">
          <span class="v-card-status active">Activo</span>
        </div>
        <div class="v-card-body">
          <h4>Conchagua</h4>
          <div class="v-card-detail"><span>Altura:</span> 1,250 msnm</div>
          <div class="v-card-detail"><span>Departamento:</span> La Unión</div>
          <div class="v-card-detail"><span>Tipo:</span> Estratovolcán</div>
          <div class="v-card-detail"><span>Última erupción:</span> Desconocida</div>
          <p>Ubicado en el extremo oriental del país.</p>
          <div class="v-card-tags"><span>Estratovolcán</span><span>Microsismicidad</span></div>
        </div>
      </div>

      <!-- Conchagüita -->
      <div class="v-card v-card-horizontal">
        <div class="v-card-img">
          <img src="assets/media/img/volcan-conchaguita.jpg" alt="Conchagüita" loading="lazy">
          <span class="v-card-status active">Activo</span>
        </div>
        <div class="v-card-body">
          <h4>Conchagüita</h4>
          <div class="v-card-detail"><span>Altura:</span> 550 msnm</div>
          <div class="v-card-detail"><span>Departamento:</span> La Unión</div>
          <div class="v-card-detail"><span>Tipo:</span> Estratovolcán</div>
          <div class="v-card-detail"><span>Última erupción:</span> 1892</div>
          <p>Isla volcánica en el Golfo de Fonseca.</p>
          <div class="v-card-tags"><span>Estratovolcán</span><span>Isla volcánica</span></div>
        </div>
      </div>

      <!-- El Hoyón -->
      <div class="v-card v-card-horizontal">
        <div class="v-card-img">
          <img src="assets/media/img/volcan-hoyon.jpg" alt="El Hoyón" loading="lazy">
          <span class="v-card-status active">Activo</span>
        </div>
        <div class="v-card-body">
          <h4>El Hoyón</h4>
          <div class="v-card-detail"><span>Altura:</span> 800 msnm</div>
          <div class="v-card-detail"><span>Departamento:</span> Santa Ana</div>
          <div class="v-card-detail"><span>Tipo:</span> Maar</div>
          <div class="v-card-detail"><span>Última erupción:</span> Desconocida</div>
          <p>Cráter de explosión por interacción magma-agua.</p>
          <div class="v-card-tags"><span>Maar</span><span>Zona volcánica activa</span></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECCIÓN 9: HISTORIA - LÍNEA DE TIEMPO
     ============================================================ -->
<section class="v-section" id="historia">
  <div class="wrap">
    <div class="v-header center">
      <span class="v-tag">Memoria histórica</span>
      <h2 class="v-title">Historia e <span>Investigaciones</span></h2>
      <p class="v-sub">Primeros estudios, geólogos importantes y misiones geológicas</p>
    </div>

    <div class="v-grid-3">
      <div class="v-card">
        <div class="v-card-img"><img src="assets/media/img/volcan-historia-1.jpg" alt="Primeros estudios" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Primeros estudios</h4>
          <p>Goodyear (1880), Karl Sapper (1925) y Montessus de Ballore realizaron los primeros estudios detallados.</p>
        </div>
      </div>
      <div class="v-card">
        <div class="v-card-img"><img src="assets/media/img/volcan-historia-2.jpg" alt="Geólogos" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Geólogos importantes</h4>
          <p>Helmut Meyer Abich, Howell Williams, Richard Stoiber y Mike Carr han realizado trabajos fundamentales.</p>
        </div>
      </div>
      <div class="v-card">
        <div class="v-card-img"><img src="assets/media/img/volcan-historia-3.jpg" alt="Misiones" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Misiones geológicas</h4>
          <p>Misión Geológica Alemana (1967-1971) comprobó más de 700 centros de erupción.</p>
        </div>
      </div>
    </div>

    <div class="v-timeline">
      <h4>Línea del tiempo</h4>
      <div class="v-timeline-items">
        <div class="v-timeline-item">
          <span class="v-timeline-year">260 DC</span>
          <p>Ilopango - Una de las erupciones más grandes de la región</p>
        </div>
        <div class="v-timeline-item">
          <span class="v-timeline-year">1658</span>
          <p>El Playón - Formación del campo de lava</p>
        </div>
        <div class="v-timeline-item">
          <span class="v-timeline-year">1770</span>
          <p>Izalco - Nacimiento del "Faro del Pacífico"</p>
        </div>
        <div class="v-timeline-item">
          <span class="v-timeline-year">1917</span>
          <p>San Salvador - Erupción del volcán Boquerón</p>
        </div>
        <div class="v-timeline-item">
          <span class="v-timeline-year">2005</span>
          <p>Santa Ana - Columna de ceniza de 10 km</p>
        </div>
        <div class="v-timeline-item">
          <span class="v-timeline-year">2013</span>
          <p>San Miguel - Erupción explosiva del Chaparrastique</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECCIÓN 10: MONITOREO
     ============================================================ -->
<section class="v-section v-section-dark" id="monitoreo">
  <div class="wrap">
    <div class="v-header center">
      <span class="v-tag">Vigilancia</span>
      <h2 class="v-title">Monitoreo <span>Volcánico</span></h2>
      <p class="v-sub">Cómo el MARN vigila los volcanes de El Salvador</p>
    </div>

    <p class="v-intro">La vigilancia está a cargo de la <strong>Dirección General del Observatorio de Amenazas</strong> del MARN. Desde 2011 opera el <strong>Centro Integrado de Monitoreo de Amenazas Naturales</strong>.</p>

    <div class="v-grid-2">
      <div class="v-card">
        <div class="v-card-img"><img src="assets/media/img/monitoreo-sismografo.jpg" alt="Sismógrafo" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Vigilancia sísmica</h4>
          <p>15 estaciones telemétricas detectan sismos volcánicos y microsismicidad.</p>
        </div>
      </div>
      <div class="v-card">
        <div class="v-card-img"><img src="assets/media/img/monitoreo-gps.jpg" alt="GPS" loading="lazy"></div>
        <div class="v-card-body">
          <h4>GPS</h4>
          <p>Mide deformaciones del terreno que indican movimiento de magma.</p>
        </div>
      </div>
      <div class="v-card">
        <div class="v-card-img"><img src="assets/media/img/monitoreo-camara.jpg" alt="Cámara" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Cámaras</h4>
          <p>Monitorean visualmente la actividad del cráter y las fumarolas.</p>
        </div>
      </div>
      <div class="v-card">
        <div class="v-card-img"><img src="assets/media/img/monitoreo-satelite.jpg" alt="Satélite" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Satélites</h4>
          <p>Detectan cambios térmicos y emisiones de gases desde el espacio.</p>
        </div>
      </div>
    </div>

    <div class="v-alertas">
      <h4>Niveles de Alerta Volcánica</h4>
      <div class="v-alertas-grid">
        <div class="v-alerta verde">
          <span class="v-alerta-dot"></span>
          <div><h5>Verde</h5><p>Condiciones normales</p></div>
        </div>
        <div class="v-alerta amarilla">
          <span class="v-alerta-dot"></span>
          <div><h5>Amarilla</h5><p>Aumento de actividad</p></div>
        </div>
        <div class="v-alerta naranja">
          <span class="v-alerta-dot"></span>
          <div><h5>Naranja</h5><p>Erupción inminente</p></div>
        </div>
        <div class="v-alerta roja">
          <span class="v-alerta-dot"></span>
          <div><h5>Roja</h5><p>Erupción en curso</p></div>
        </div>
      </div>
    </div>

    <div class="v-tags-wrap">
      <h4>Volcanes monitoreados</h4>
      <div class="v-tags">
        <span>Santa Ana</span><span>Izalco</span><span>San Salvador</span>
        <span>Ilopango</span><span>San Vicente</span><span>San Miguel</span>
        <span>Tecapa</span><span>Conchagua</span><span>Conchagüita</span>
        <span>El Hoyón</span>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECCIÓN 11: PELIGROS
     ============================================================ -->
<section class="v-section" id="peligros">
  <div class="wrap">
    <div class="v-header center">
      <span class="v-tag">Amenazas</span>
      <h2 class="v-title">Peligros <span>Volcánicos</span></h2>
      <p class="v-sub">Los riesgos asociados a la actividad eruptiva</p>
    </div>

    <div class="v-grid-3">
      <div class="v-card v-card-danger">
        <div class="v-card-img"><img src="assets/media/img/peligro-ceniza.jpg" alt="Ceniza" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Caída de Ceniza</h4>
          <p>Afecta cultivos, techos, vías respiratorias y visibilidad a kilómetros del cráter.</p>
        </div>
      </div>
      <div class="v-card v-card-danger">
        <div class="v-card-img"><img src="assets/media/img/peligro-gases.jpg" alt="Gases" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Gases Volcánicos</h4>
          <p>SO₂ irrita ojos y pulmones. CO₂ es incoloro e inodoro. H₂S es tóxico.</p>
        </div>
      </div>
      <div class="v-card v-card-danger">
        <div class="v-card-img"><img src="assets/media/img/peligro-piroclastico.jpg" alt="Piroclásticos" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Flujos Piroclásticos</h4>
          <p>Nubes de gas y roca a alta temperatura que descienden rápido por las laderas.</p>
        </div>
      </div>
      <div class="v-card v-card-danger">
        <div class="v-card-img"><img src="assets/media/img/peligro-lahar.jpg" alt="Lahares" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Lahares</h4>
          <p>Coladas de lodo volcánico que bajan por quebradas. Mortíferos por su velocidad.</p>
        </div>
      </div>
      <div class="v-card v-card-danger">
        <div class="v-card-img"><img src="assets/media/img/peligro-deslizamiento.jpg" alt="Deslizamientos" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Deslizamientos</h4>
          <p>Fragmentos del volcán se derrumban por caída de rocas o deslizamientos.</p>
        </div>
      </div>
      <div class="v-card v-card-danger">
        <div class="v-card-img"><img src="assets/media/img/peligro-tsunami.jpg" alt="Tsunamis" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Tsunamis</h4>
          <p>Olas gigantes generadas por sismos submarinos o deslizamientos en el fondo oceánico.</p>
        </div>
      </div>
    </div>

    <div class="v-mapa">
      <img src="assets/media/img/volcan-mapa-amenaza.jpg" alt="Mapa de amenaza volcánica" loading="lazy">
      <span class="v-mapa-label">Mapa de amenaza volcánica de El Salvador</span>
    </div>
  </div>
</section>

<!-- ============================================================
     SECCIÓN 12: PREVENCIÓN
     ============================================================ -->
<section class="v-section v-section-dark" id="prevencion">
  <div class="wrap">
    <div class="v-header center">
      <span class="v-tag">Preparación</span>
      <h2 class="v-title">Prevención <span>Volcánica</span></h2>
      <p class="v-sub">Qué hacer antes, durante y después de una erupción</p>
    </div>

    <div class="v-grid-3">
      <div class="v-card v-card-prevencion antes">
        <div class="v-card-img"><img src="assets/media/img/prevencion-antes.jpg" alt="Antes" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Antes</h4>
          <ul>
            <li>Conoce si vives cerca de un volcán activo</li>
            <li>Ten mascarillas N95 y lentes de protección</li>
            <li>Almacena agua y alimentos no perecederos</li>
            <li>Sigue los reportes del MARN</li>
          </ul>
        </div>
      </div>
      <div class="v-card v-card-prevencion durante">
        <div class="v-card-img"><img src="assets/media/img/prevencion-durante.jpg" alt="Durante" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Durante</h4>
          <ul>
            <li>Aléjate de ríos y quebradas (riesgo de lahares)</li>
            <li>Cubre nariz y boca con mascarilla o tela húmeda</li>
            <li>Evacúa de inmediato si Protección Civil lo indica</li>
            <li>No esperes "ver" la lava para evacuar</li>
          </ul>
        </div>
      </div>
      <div class="v-card v-card-prevencion despues">
        <div class="v-card-img"><img src="assets/media/img/prevencion-despues.jpg" alt="Después" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Después</h4>
          <ul>
            <li>Retira ceniza de techos livianos (pueden colapsar)</li>
            <li>Revisa que el agua no esté contaminada</li>
            <li>Mantente atento a nuevas alertas</li>
            <li>No uses vehículos si hay caída de ceniza</li>
          </ul>
        </div>
      </div>
    </div>

    <div class="v-mochila">
      <h4>Mochila de emergencia</h4>
      <div class="v-mochila-items">
        <span>Agua</span><span>Alimentos</span><span>Mascarilla N95</span>
        <span>Lentes</span><span>Linterna</span><span>Radio</span>
        <span>Documentos</span><span>Botiquín</span>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECCIÓN 13: BENEFICIOS
     ============================================================ -->
<section class="v-section" id="beneficios">
  <div class="wrap">
    <div class="v-header center">
      <span class="v-tag">Recursos</span>
      <h2 class="v-title">Beneficios de los <span>Volcanes</span></h2>
      <p class="v-sub">Lo positivo de la actividad volcánica</p>
    </div>

    <div class="v-grid-5">
      <div class="v-card">
        <div class="v-card-img"><img src="assets/media/img/beneficio-agricultura.jpg" alt="Agricultura" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Agricultura</h4>
          <p>Suelos volcánicos fértiles por su alto contenido de minerales.</p>
        </div>
      </div>
      <div class="v-card">
        <div class="v-card-img"><img src="assets/media/img/beneficio-geotermia.jpg" alt="Geotermia" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Geotermia</h4>
          <p>Calor del interior para generar energía limpia y renovable.</p>
        </div>
      </div>
      <div class="v-card">
        <div class="v-card-img"><img src="assets/media/img/beneficio-minerales.jpg" alt="Minerales" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Minerales</h4>
          <p>Fuente de oro, plata, cobre y materiales de construcción.</p>
        </div>
      </div>
      <div class="v-card">
        <div class="v-card-img"><img src="assets/media/img/beneficio-biodiversidad.jpg" alt="Biodiversidad" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Biodiversidad</h4>
          <p>Ecosistemas volcánicos con especies únicas de flora y fauna.</p>
        </div>
      </div>
      <div class="v-card">
        <div class="v-card-img"><img src="assets/media/img/beneficio-turismo.jpg" alt="Turismo" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Turismo</h4>
          <p>Atraen a miles de turistas nacionales e internacionales.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECCIÓN 14: TURISMO
     ============================================================ -->
<section class="v-section v-section-dark" id="turismo">
  <div class="wrap">
    <div class="v-header center">
      <span class="v-tag">Aventura</span>
      <h2 class="v-title">Turismo <span>Volcánico</span></h2>
      <p class="v-sub">La Ruta de los Volcanes y sus principales atractivos</p>
    </div>

    <p class="v-intro">El <strong>Parque Nacional Complejo Los Volcanes</strong>, a unos 60 km de San Salvador, alberga los 3 volcanes más famosos del país.</p>

    <div class="v-grid-2">
      <div class="v-card v-card-horizontal">
        <div class="v-card-img"><img src="assets/media/img/turismo-santa-ana.jpg" alt="Santa Ana" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Santa Ana</h4>
          <p>El volcán más alto del país (2,381 msnm). Sendero de 1.5 horas hasta la cima.</p>
        </div>
      </div>
      <div class="v-card v-card-horizontal">
        <div class="v-card-img"><img src="assets/media/img/turismo-izalco.jpg" alt="Izalco" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Izalco</h4>
          <p>"El Faro del Pacífico". Ascenso de 3-4 horas. Uno de los destinos más icónicos.</p>
        </div>
      </div>
      <div class="v-card v-card-horizontal">
        <div class="v-card-img"><img src="assets/media/img/turismo-cerro-verde.jpg" alt="Cerro Verde" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Cerro Verde</h4>
          <p>Parque recreativo con senderos de "Flores Misteriosas".</p>
        </div>
      </div>
      <div class="v-card v-card-horizontal">
        <div class="v-card-img"><img src="assets/media/img/turismo-coatepeque.jpg" alt="Coatepeque" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Lago de Coatepeque</h4>
          <p>Caldera volcánica con aguas turquesa. Ideal para deportes acuáticos.</p>
        </div>
      </div>
    </div>

    <div class="v-ruta">
      <h4>La Ruta de los Volcanes</h4>
      <p>Recorre la Cordillera de Apaneca-Ilamatepec, visitando los volcanes Santa Ana, Izalco y Cerro Verde, junto al lago de Coatepeque.</p>
    </div>
  </div>
</section>

<!-- ============================================================
     SECCIÓN 15: VOLCANES DEL MUNDO
     ============================================================ -->
<section class="v-section" id="volcanes-mundo">
  <div class="wrap">
    <div class="v-header center">
      <span class="v-tag">Global</span>
      <h2 class="v-title">Volcanes del <span>Mundo</span></h2>
      <p class="v-sub">Los más activos, más altos y más famosos del planeta</p>
    </div>

    <div class="v-grid-3">
      <div class="v-card">
        <div class="v-card-img"><img src="assets/media/img/mundo-activos.jpg" alt="Activos" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Los más activos</h4>
          <ul>
            <li><strong>Kilauea</strong> (Hawái) - Actividad casi continua desde 1983</li>
            <li><strong>Etna</strong> (Italia) - Erupciones casi todos los años</li>
            <li><strong>Stromboli</strong> (Italia) - Erupciones continuas desde hace siglos</li>
            <li><strong>Volcán de Fuego</strong> (Guatemala) - Erupciones frecuentes</li>
          </ul>
        </div>
      </div>
      <div class="v-card">
        <div class="v-card-img"><img src="assets/media/img/mundo-altos.jpg" alt="Altos" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Los más altos</h4>
          <ul>
            <li><strong>Ojos del Salado</strong> - 6,893 msnm</li>
            <li><strong>Monte Pissis</strong> - 6,793 msnm</li>
            <li><strong>Nevado Tres Cruces</strong> - 6,748 msnm</li>
            <li><strong>Llullaillaco</strong> - 6,739 msnm</li>
          </ul>
        </div>
      </div>
      <div class="v-card">
        <div class="v-card-img"><img src="assets/media/img/mundo-famosos.jpg" alt="Famosos" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Volcanes famosos</h4>
          <ul>
            <li><strong>Vesubio</strong> (Italia) - Sepultó Pompeya en el 79 DC</li>
            <li><strong>Krakatoa</strong> (Indonesia) - Erupción de 1883</li>
            <li><strong>Monte Santa Helena</strong> (EE.UU.) - Erupción de 1980</li>
            <li><strong>Fuji</strong> (Japón) - Símbolo de Japón</li>
          </ul>
        </div>
      </div>
    </div>

    <div class="v-solar">
      <h4>Volcanes en el Sistema Solar</h4>
      <p>¡Sí! Hay volcanes en otros planetas. Venus y Marte están cubiertos de volcanes extintos. Algunas lunas de Júpiter, Saturno y Neptuno tienen erupciones activas.</p>
    </div>
  </div>
</section>

<!-- ============================================================
     SECCIÓN 16: CURIOSIDADES
     ============================================================ -->
<section class="v-section v-section-dark" id="curiosidades">
  <div class="wrap">
    <div class="v-header center">
      <span class="v-tag">Datos curiosos</span>
      <h2 class="v-title">Curiosidades <span>Volcánicas</span></h2>
      <p class="v-sub">Datos interesantes, récords y mitos</p>
    </div>

    <div class="v-grid-3">
      <div class="v-card">
        <div class="v-card-img"><img src="assets/media/img/curiosidad-faro.jpg" alt="Faro del Pacífico" loading="lazy"></div>
        <div class="v-card-body">
          <h4>El Faro del Pacífico</h4>
          <p>El volcán Izalco fue visible desde el océano durante 196 años de actividad continua, sirviendo como referencia de navegación.</p>
        </div>
      </div>
      <div class="v-card">
        <div class="v-card-img"><img src="assets/media/img/curiosidad-datos.jpg" alt="Datos" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Datos interesantes</h4>
          <p>El Salvador tiene la mayor densidad de volcanes por kilómetro cuadrado en Centroamérica. El volcán más joven es Izalco (1770).</p>
        </div>
      </div>
      <div class="v-card">
        <div class="v-card-img"><img src="assets/media/img/curiosidad-records.jpg" alt="Récords" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Récords</h4>
          <p>El volcán más alto del mundo es el Ojos del Salado (6,893 m). El más activo es el Kilauea en Hawái.</p>
        </div>
      </div>
      <div class="v-card">
        <div class="v-card-img"><img src="assets/media/img/curiosidad-mitos.jpg" alt="Mitos" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Mitos y realidades</h4>
          <p>Mito: "Un volcán extinto no volverá a erupcionar". Realidad: Un volcán inactivo puede reactivarse.</p>
        </div>
      </div>
      <div class="v-card">
        <div class="v-card-img"><img src="assets/media/img/curiosidad-coatepeque.jpg" alt="Coatepeque" loading="lazy"></div>
        <div class="v-card-body">
          <h4>El lago que cambia de color</h4>
          <p>El lago de Coatepeque cambia a un llamativo tono turquesa de forma cíclica.</p>
        </div>
      </div>
      <div class="v-card">
        <div class="v-card-img"><img src="assets/media/img/curiosidad-submarino.jpg" alt="Submarinos" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Volcanes submarinos</h4>
          <p>Se estima que hay más de 1 millón de volcanes submarinos en los océanos.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     GSAP SCRIPTS
     ============================================================ -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    gsap.registerPlugin(ScrollTrigger);

    // ==========================================================
    // CARRUSEL MODERNO
    // ==========================================================
    let currentSlide = 0;
    const slides = document.querySelectorAll('.v-carousel-slide');
    const totalSlides = slides.length;
    const dotsContainer = document.getElementById('carouselDots');

    // Crear dots
    for (let i = 0; i < totalSlides; i++) {
        const dot = document.createElement('span');
        dot.className = i === 0 ? 'active' : '';
        dot.dataset.index = i;
        dot.addEventListener('click', () => goToSlide(i));
        dotsContainer.appendChild(dot);
    }

    function goToSlide(index) {
        currentSlide = index;
        slides.forEach((slide, i) => {
            slide.classList.toggle('active', i === index);
        });
        document.querySelectorAll('#carouselDots .dot').forEach((dot, i) => {
            dot.classList.toggle('active', i === index);
        });
    }

    function nextSlide() {
        goToSlide((currentSlide + 1) % totalSlides);
    }

    function prevSlide() {
        goToSlide((currentSlide - 1 + totalSlides) % totalSlides);
    }

    document.getElementById('carouselNext').addEventListener('click', nextSlide);
    document.getElementById('carouselPrev').addEventListener('click', prevSlide);

    // Autoplay
    let autoplay = setInterval(nextSlide, 5000);
    const carouselWrap = document.querySelector('.v-carousel-moderno');
    carouselWrap.addEventListener('mouseenter', () => clearInterval(autoplay));
    carouselWrap.addEventListener('mouseleave', () => {
        autoplay = setInterval(nextSlide, 5000);
    });

    // ==========================================================
    // TABS
    // ==========================================================
    const tabBtns = document.querySelectorAll('.v-tab-btn');
    const tabPanels = document.querySelectorAll('.v-tab-panel');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const tab = this.dataset.tab;
            tabBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            tabPanels.forEach(p => p.classList.remove('active'));
            document.getElementById('tab-' + tab).classList.add('active');
        });
    });

    // ==========================================================
    // ANIMACIONES
    // ==========================================================

    // Hero
    gsap.from('.v-hero-title', {
        opacity: 0,
        y: 40,
        duration: 1,
        delay: 0.3
    });
    gsap.from('.v-hero-desc', {
        opacity: 0,
        y: 30,
        duration: 0.8,
        delay: 0.5
    });
    gsap.from('.v-hero-btn', {
        opacity: 0,
        y: 20,
        duration: 0.6,
        delay: 0.7
    });
    gsap.from('.v-hero-badge', {
        opacity: 0,
        x: -20,
        duration: 0.6,
        delay: 0.8
    });

    // Secciones
    document.querySelectorAll('.v-section').forEach(section => {
        gsap.from(section.querySelector('.v-header'), {
            opacity: 0,
            y: 30,
            duration: 0.6,
            scrollTrigger: {
                trigger: section,
                start: 'top 88%',
                toggleActions: 'play none none none'
            }
        });
    });

    // Tarjetas
    document.querySelectorAll('.v-card, .v-stat, .v-timeline-item, .v-alerta, .v-tab-item').forEach((el, i) => {
        gsap.from(el, {
            opacity: 0,
            y: 20,
            duration: 0.5,
            delay: i * 0.04,
            scrollTrigger: {
                trigger: el,
                start: 'top 92%',
                toggleActions: 'play none none none'
            }
        });
    });

    // Contadores
    document.querySelectorAll('.v-stat[data-count]').forEach(el => {
        const target = parseInt(el.dataset.count);
        const numEl = el.querySelector('.v-stat-num');
        const obj = { val: 0 };
        ScrollTrigger.create({
            trigger: el,
            start: 'top 90%',
            once: true,
            onEnter: () => {
                gsap.to(obj, {
                    val: target,
                    duration: 1.8,
                    ease: 'power1.out',
                    onUpdate: () => {
                        numEl.textContent = Math.round(obj.val);
                    }
                });
            }
        });
    });

    // Timeline
    gsap.from('.v-timeline-item', {
        opacity: 0,
        x: -20,
        duration: 0.5,
        stagger: 0.15,
        scrollTrigger: {
            trigger: '.v-timeline-items',
            start: 'top 88%',
            toggleActions: 'play none none none'
        }
    });

    // Diagram pins
    document.querySelectorAll('.v-diagram-pin').forEach(pin => {
        gsap.from(pin, {
            opacity: 0,
            scale: 0.5,
            duration: 0.4,
            delay: 0.1,
            scrollTrigger: {
                trigger: pin,
                start: 'top 85%',
                toggleActions: 'play none none none'
            }
        });
    });

    console.log('Volcanes GSAP initialized');
});
</script>

<?php
$content = ob_get_clean();
require_once 'layout.php';
?>