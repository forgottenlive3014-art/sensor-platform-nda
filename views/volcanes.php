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

<!-- CONTEXTO RAPIDO -->
<section class="dis-context" style="background-image:url('assets/media/img/volcanBanner.jpg')">
  <div class="dis-context-overlay"></div>
  <div class="wrap dis-context-inner">
    <div class="dis-context-hd">
      <span class="dis-context-eyebrow">El Salvador</span>
      <h2 class="dis-context-title">Uno de los países más volcánicos del mundo</h2>
    </div>
    <div class="dis-context-cards">
      <div class="dis-context-card">
        <span class="dis-context-card-ico"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg></span>
        <h4>¿Por qué aquí?</h4>
        <p>El país está sobre el límite entre la Placa de Cocos y la Placa del Caribe, con 6 volcanes activos monitoreados por MARN.</p>
      </div>
      <div class="dis-context-card">
        <span class="dis-context-card-ico"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2s7 7.5 7 12a7 7 0 0 1-14 0c0-4.5 7-12 7-12z"/></svg></span>
        <h4>Volcán más activo</h4>
        <p>El Izalco, "El Faro del Pacífico", estuvo casi siempre activo entre 1770 y 1966.</p>
      </div>
      <div class="dis-context-card">
        <span class="dis-context-card-ico"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5M2 12l10 5 10-5"/></svg></span>
        <h4>Beneficio principal</h4>
        <p>Suelos volcánicos fértiles: la base de gran parte de la agricultura del país.</p>
      </div>
      <div class="dis-context-card">
        <span class="dis-context-card-ico"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3l10 18H2L12 3z"/><path d="M12 10v4"/><path d="M12 17h.01"/></svg></span>
        <h4>Mayor riesgo</h4>
        <p>Lahares y flujos piroclásticos: más rápidos y letales que la propia lava.</p>
      </div>
    </div>
  </div>
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

    <div class="v-intro-wrapper">
      <!-- Imagen principal (izquierda) -->
      <div class="v-intro-image">
        <img src="assets/media/img/volcanBanner.jpg" alt="Estructura de un volcán" loading="lazy">
        <span class="v-intro-image-label">Corte transversal de un volcán</span>
      </div>

      <!-- Columna derecha: definición + fundamentos -->
      <div class="v-intro-content">
        <!-- Definición -->
        <div class="v-intro-definition">
          <p>
            Un <strong>volcán</strong> es una abertura en la superficie terrestre por donde el <strong>magma</strong>, <strong>gases</strong> y <strong>ceniza</strong> del interior de la Tierra salen hacia el exterior. Cuando este material se escapa, provoca una <strong>erupción volcánica</strong>.
          </p>
        </div>

        <!-- Fundamentos en recuadros -->
        <div class="v-fundamentos">
          <h3 class="v-fundamentos-title">Los volcanes son fundamentales para:</h3>
          <div class="v-fundamentos-grid">
            <div class="v-fundamento">
              <span class="v-fundamento-num">01</span>
              <div class="v-fundamento-content">
                <h4>Formación de la corteza terrestre</h4>
                <p>Contribuyen a la construcción de la litosfera, añadiendo nuevas capas de roca.</p>
              </div>
            </div>
            <div class="v-fundamento">
              <span class="v-fundamento-num">02</span>
              <div class="v-fundamento-content">
                <h4>Creación de nuevas tierras</h4>
                <p>Islas como Hawái o Islandia deben su existencia a erupciones volcánicas.</p>
              </div>
            </div>
            <div class="v-fundamento">
              <span class="v-fundamento-num">03</span>
              <div class="v-fundamento-content">
                <h4>Regulación del clima</h4>
                <p>Las erupciones liberan gases que influyen en la temperatura global.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Dato clave de El Salvador (abajo, ancho completo) -->
    <div class="v-intro-footer">
      <span class="v-intro-footer-line"></span>
      <p>
        <strong>El Salvador</strong> forma parte de la <strong>Cadena Volcánica Centroamericana</strong>, producto de la subducción de la <strong>Placa de Cocos</strong> bajo la <strong>Placa del Caribe</strong>.
      </p>
      <span class="v-intro-footer-line"></span>
    </div>
  </div>
</section>

<!-- ============================================================
     SECCIÓN 2: FORMACIÓN DE LOS VOLCANES
     ============================================================ -->
<section class="v-section v-section-dark" id="formacion">
  <div class="wrap">
    <div class="v-header center">
      <span class="v-tag">Geodinámica</span>
      <h2 class="v-title">Formación de los <span>Volcanes</span></h2>
      <p class="v-sub">El proceso geológico que da origen a los volcanes</p>
    </div>

    <!-- Cinturón de Fuego -->
    <div class="v-fire-belt">
      <svg class="v-fire-belt-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M12 2C8 6 6 9 6 13c0 3.3 2.7 6 6 6s6-2.7 6-6c0-4-2-7-6-11z"/>
        <path d="M12 19v3"/>
        <path d="M8 22h8"/>
      </svg>
      <div class="v-fire-belt-content">
        <h3>Cinturón de Fuego del Pacífico</h3>
        <p>El Salvador forma parte del <strong>Cinturón de Fuego del Pacífico</strong>, que concentra el <strong>80%</strong> de los volcanes activos del mundo.</p>
      </div>
    </div>

    <!-- CARRUSEL CON STEP PROGRESS INDICATOR -->
    <div class="v-carousel-wrapper">
      <div class="v-carousel-container">
        
        <!-- Step Indicator -->
        <div class="v-step-indicator">
          <div class="v-step-line"></div>
          <div class="v-step-dots">
            <div class="v-step-dot active" data-slide="0">
              <span class="v-step-num">01</span>
            </div>
            <div class="v-step-dot" data-slide="1">
              <span class="v-step-num">02</span>
            </div>
            <div class="v-step-dot" data-slide="2">
              <span class="v-step-num">03</span>
            </div>
            <div class="v-step-dot" data-slide="3">
              <span class="v-step-num">04</span>
            </div>
            <div class="v-step-dot" data-slide="4">
              <span class="v-step-num">05</span>
            </div>
          </div>
        </div>

        <!-- Slides -->
        <div class="v-carousel-slides-wrapper">
          <div class="v-carousel-slides-container" id="formacionCarousel">
            
            <!-- Slide 1 -->
            <div class="v-carousel-slide active" data-slide="0">
              <div class="v-carousel-inner">
                <div class="v-carousel-image">
                  <img src="assets/media/img/formacionTierra.png" alt="Formación de la Tierra" loading="lazy">
                  <span class="v-carousel-image-label">Corte transversal de la Tierra</span>
                </div>
                <div class="v-carousel-content">
                  <span class="v-carousel-num">01</span>
                  <h3>Formación de la Tierra</h3>
                  <p>La Tierra se formó hace aproximadamente <strong>4,540 millones de años</strong>. El calor interno generado permitió que los materiales más densos se concentraran en el núcleo y los más ligeros formaran la corteza. Ese calor aún se conserva y es responsable de la actividad volcánica.</p>
                  <div class="v-carousel-tags">
                    <span>4,540 millones de años</span>
                    <span>Corteza, manto y núcleo</span>
                    <span>Calor interno activo</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Slide 2 -->
            <div class="v-carousel-slide" data-slide="1">
              <div class="v-carousel-inner">
                <div class="v-carousel-image">
                  <img src="assets/media/img/placasVolcan.png" alt="Tectónica de placas" loading="lazy">
                  <span class="v-carousel-image-label">Subducción de placas tectónicas</span>
                </div>
                <div class="v-carousel-content">
                  <span class="v-carousel-num">02</span>
                  <h3>Tectónica de placas</h3>
                  <p>La superficie terrestre está dividida en grandes bloques llamados <strong>placas tectónicas</strong> que se desplazan lentamente. Cuando chocan, una puede hundirse bajo la otra en un proceso llamado <strong>subducción</strong>, generando las condiciones ideales para la formación de magma y volcanes.</p>
                  <div class="v-carousel-tags">
                    <span>Movimiento constante</span>
                    <span>Límites convergentes</span>
                    <span>Subducción</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Slide 3 -->
            <div class="v-carousel-slide" data-slide="2">
              <div class="v-carousel-inner">
                <div class="v-carousel-image">
                  <img src="assets/media/img/formacionMagma.png" alt="Formación del magma" loading="lazy">
                  <span class="v-carousel-image-label">Formación y ascenso del magma</span>
                </div>
                <div class="v-carousel-content">
                  <span class="v-carousel-num">03</span>
                  <h3>Formación del magma</h3>
                  <p>En las zonas de subducción, las altas temperaturas y la presión provocan la <strong>fusión parcial</strong> de las rocas del manto, formando el <strong>magma</strong>. Este material asciende por su menor densidad y se acumula en una <strong>cámara magmática</strong>.</p>
                  <div class="v-carousel-tags">
                    <span>Fusión parcial</span>
                    <span>Ascenso del magma</span>
                    <span>Cámara magmática</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Slide 4 -->
            <div class="v-carousel-slide" data-slide="3">
              <div class="v-carousel-inner">
                <div class="v-carousel-image">
                  <img src="assets/media/img/formacionVolcanica.png" alt="Edificio volcánico" loading="lazy">
                  <span class="v-carousel-image-label">Crecimiento del edificio volcánico</span>
                </div>
                <div class="v-carousel-content">
                  <span class="v-carousel-num">04</span>
                  <h3>Formación del edificio volcánico</h3>
                  <p>Cuando la presión dentro de la cámara magmática aumenta, el magma asciende por la <strong>chimenea</strong> y emerge en la superficie durante una <strong>erupción</strong>. La acumulación de lava, ceniza y piroclastos forma gradualmente el <strong>cono volcánico</strong>.</p>
                  <div class="v-carousel-tags">
                    <span>Ascenso del magma</span>
                    <span>Erupción volcánica</span>
                    <span>Cono volcánico</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Slide 5 -->
            <div class="v-carousel-slide" data-slide="4">
              <div class="v-carousel-inner">
                <div class="v-carousel-image">
                  <img src="assets/media/img/CadenaVolcanica.png" alt="Volcanes de El Salvador" loading="lazy">
                  <span class="v-carousel-image-label">Cadena Volcánica de El Salvador</span>
                </div>
                <div class="v-carousel-content">
                  <span class="v-carousel-num">05</span>
                  <h3>El Salvador y los volcanes</h3>
                  <p><strong>El Salvador</strong> forma parte de la <strong>Cadena Volcánica Centroamericana</strong>, con más de <strong>20 volcanes</strong> en su territorio. La subducción de la <strong>Placa de Cocos</strong> bajo la <strong>Placa del Caribe</strong> es la responsable de esta intensa actividad volcánica.</p>
                  <div class="v-carousel-tags">
                    <span>20+ volcanes activos</span>
                    <span>Cadena Volcánica Centroamericana</span>
                    <span>Placa de Cocos</span>
                  </div>
                </div>
              </div>
            </div>

          </div>

          <!-- Controles -->
          <div class="v-carousel-controls">
            <button class="v-carousel-btn prev" id="carouselPrev">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <div class="v-carousel-dots" id="carouselDots"></div>
            <button class="v-carousel-btn next" id="carouselNext">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
            </button>
          </div>
        </div>

      </div>
    </div>

    <!-- Footer -->
    <div class="v-formacion-footer">
      <span class="v-formacion-footer-line"></span>
      <p><strong>En El Salvador:</strong> más del <strong>90%</strong> del subsuelo está formado por rocas de origen magmático.</p>
      <span class="v-formacion-footer-line"></span>
    </div>
  </div>
</section>


<!-- ============================================================
     SECCIÓN 3: ANATOMÍA DEL VOLCÁN (con diagrama interactivo)
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
        <img src="assets/media/img/anatomiaVolcan.png" alt="Anatomía del volcán" loading="lazy">

        <!-- ==========================================================
             ESTRUCTURA EXTERNA (puntos en la imagen)
             ========================================================== -->

        <!-- 1. Columna Eruptiva -->
        <div class="v-diagram-pin tooltip-bottom" style="top:11%; left:54%;">
          <span class="v-pin-dot"></span>
          <div class="v-pin-tooltip">
            <span class="v-pin-category">Estructura externa</span>
            <strong>Columna Eruptiva</strong>
            <p>Nube vertical de gases, cenizas y fragmentos sólidos expulsados durante la erupción.</p>
          </div>
        </div>

        <!-- 2. Cráter -->
        <div class="v-diagram-pin tooltip-bottom" style="top:17%; left:46%;">
          <span class="v-pin-dot"></span>
          <div class="v-pin-tooltip">
            <span class="v-pin-category">Estructura externa</span>
            <strong>Cráter</strong>
            <p>Abertura en la cima del volcán por donde salen magma, gases y ceniza.</p>
          </div>
        </div>

        <!-- 3. Fumarolas -->
        <div class="v-diagram-pin tooltip-bottom" style="top:20%; left:58%;">
          <span class="v-pin-dot"></span>
          <div class="v-pin-tooltip">
            <span class="v-pin-category">Estructura externa</span>
            <strong>Fumarolas</strong>
            <p>Aberturas secundarias por donde se emiten gases volcánicos y vapor de agua.</p>
          </div>
        </div>

        <!-- 4. Colada de Lava -->
        <div class="v-diagram-pin tooltip-bottom" style="top:27%; left:40%;">
          <span class="v-pin-dot"></span>
          <div class="v-pin-tooltip">
            <span class="v-pin-category">Estructura externa</span>
            <strong>Colada de Lava</strong>
            <p>Flujo de lava que desciende por las laderas del volcán después de una erupción.</p>
          </div>
        </div>

        <!-- 5. Cono Volcánico -->
        <div class="v-diagram-pin" style="top:34%; left:35%;">
          <span class="v-pin-dot"></span>
          <div class="v-pin-tooltip">
            <span class="v-pin-category">Estructura externa</span>
            <strong>Cono Volcánico</strong>
            <p>Montaña formada por la acumulación de lava, ceniza y piroclastos.</p>
          </div>
        </div>

        <!-- 6. Capas de Lava y Ceniza -->
        <div class="v-diagram-pin" style="top:39%; left:34%;">
          <span class="v-pin-dot"></span>
          <div class="v-pin-tooltip">
            <span class="v-pin-category">Estructura externa</span>
            <strong>Capas de Lava y Ceniza</strong>
            <p>Estratos formados por la acumulación de materiales expulsados en diferentes erupciones.</p>
          </div>
        </div>

        <!-- 7. Cono Secundario -->
        <div class="v-diagram-pin" style="top:31.5%; left:58%;">
          <span class="v-pin-dot"></span>
          <div class="v-pin-tooltip">
            <span class="v-pin-category">Estructura externa</span>
            <strong>Cono Secundario</strong>
            <p>Pequeño cono formado por erupciones a través de una chimenea secundaria.</p>
          </div>
        </div>

        <!-- ==========================================================
             ESTRUCTURA INTERNA (puntos en la imagen)
             ========================================================== -->

        <!-- 8. Chimenea Secundaria -->
        <div class="v-diagram-pin" style="top:43%; left:57%;">
          <span class="v-pin-dot"></span>
          <div class="v-pin-tooltip">
            <span class="v-pin-category">Estructura interna</span>
            <strong>Chimenea Secundaria</strong>
            <p>Conducto alterno que permite la salida del magma por los flancos del volcán.</p>
          </div>
        </div>

        <!-- 9. Chimenea Principal -->
        <div class="v-diagram-pin" style="top:49.5%; left:48%;">
          <span class="v-pin-dot"></span>
          <div class="v-pin-tooltip">
            <span class="v-pin-category">Estructura interna</span>
            <strong>Chimenea Principal</strong>
            <p>Conducto principal que comunica la cámara magmática con el cráter.</p>
          </div>
        </div>

        <!-- 10. Dique -->
        <div class="v-diagram-pin" style="top:73%; left:51.5%;">
          <span class="v-pin-dot"></span>
          <div class="v-pin-tooltip">
            <span class="v-pin-category">Estructura interna</span>
            <strong>Dique</strong>
            <p>Intrusión vertical de magma que atraviesa las rocas y puede alimentar nuevas chimeneas.</p>
          </div>
        </div>

        <!-- 11. Sill (Filón Capa) -->
        <div class="v-diagram-pin" style="top:66.5%; left:32%;">
          <span class="v-pin-dot"></span>
          <div class="v-pin-tooltip">
            <span class="v-pin-category">Estructura interna</span>
            <strong>Sill (Filón Capa)</strong>
            <p>Intrusión horizontal de magma entre los estratos de roca.</p>
          </div>
        </div>

        <!-- 12. Cámara Magmática -->
        <div class="v-diagram-pin" style="top:89%; left:47%;">
          <span class="v-pin-dot"></span>
          <div class="v-pin-tooltip">
            <span class="v-pin-category">Estructura interna</span>
            <strong>Cámara Magmática</strong>
            <p>Reservorio de magma fundido a varios kilómetros de profundidad.</p>
          </div>
        </div>

        <!-- ==========================================================
             CAPAS DE LA TIERRA (puntos en la imagen)
             ========================================================== -->

        <!-- 13. Corteza Terrestre -->
        <div class="v-diagram-pin" style="top:69%; left:77%;">
          <span class="v-pin-dot"></span>
          <div class="v-pin-tooltip">
            <span class="v-pin-category">Capa de la Tierra</span>
            <strong>Corteza Terrestre</strong>
            <p>Capa superficial sólida de la Tierra donde se forman los volcanes.</p>
          </div>
        </div>

        <!-- 14. Manto -->
        <div class="v-diagram-pin" style="top:83%; left:78%;">
          <span class="v-pin-dot"></span>
          <div class="v-pin-tooltip">
            <span class="v-pin-category">Capa de la Tierra</span>
            <strong>Manto</strong>
            <p>Capa intermedia donde se origina el magma por fusión parcial de las rocas.</p>
          </div>
        </div>

      </div>
      <div class="v-diagram-legend">
        <span class="v-legend-dot"></span> Pasa el cursor sobre los puntos para conocer cada parte
      </div>
    </div>

    <!-- Lista de partes del volcán -->
    <div class="v-anatomia-lista">
      <div class="v-anatomia-lista-col">
        <h4>
          <svg class="v-anatomia-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
            <circle cx="12" cy="12" r="4"/>
          </svg>
          Estructura interna
        </h4>
        <ul>
          <li><strong>01.</strong> Cámara magmática</li>
          <li><strong>02.</strong> Chimenea principal</li>
          <li><strong>03.</strong> Chimeneas secundarias</li>
          <li><strong>04.</strong> Dique</li>
          <li><strong>05.</strong> Sill o filón capa</li>
        </ul>
      </div>
      <div class="v-anatomia-lista-col">
        <h4>
          <svg class="v-anatomia-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 2L2 7l10 5 10-5-10-5z"/>
            <path d="M2 17l10 5 10-5"/>
            <path d="M2 12l10 5 10-5"/>
            <path d="M2 7l10 5 10-5"/>
          </svg>
          Estructura externa
        </h4>
        <ul>
          <li><strong>01.</strong> Cráter</li>
          <li><strong>02.</strong> Cono volcánico</li>
          <li><strong>03.</strong> Cono secundario</li>
          <li><strong>04.</strong> Colada de lava</li>
          <li><strong>05.</strong> Fumarolas</li>
          <li><strong>06.</strong> Capas de lava y ceniza</li>
          <li><strong>07.</strong> Columna eruptiva</li>
        </ul>
      </div>
      <div class="v-anatomia-lista-col full">
        <h4>
          <svg class="v-anatomia-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"/>
            <line x1="2" y1="12" x2="22" y2="12"/>
            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
          </svg>
          Capas de la Tierra (relacionadas)
        </h4>
        <ul>
          <li><strong>01.</strong> Manto (origen del magma)</li>
          <li><strong>02.</strong> Corteza terrestre (capa donde se encuentra el volcán)</li>
        </ul>
      </div>
    </div>

    <!-- Footer -->
    <div class="v-intro-footer">
      <span class="v-intro-footer-line"></span>
      <p>
        <strong>En El Salvador:</strong> los volcanes presentan cráteres bien definidos y sistemas de fumarolas activas, monitoreados constantemente por el <strong>MARN</strong>.
      </p>
      <span class="v-intro-footer-line"></span>
    </div>
  </div>
</section>

<!-- ============================================================
     SECCIÓN 4: MAGMA Y MATERIALES - CARRUSEL 3D (CON IMÁGENES)
     ============================================================ -->
<section class="v-section v-section-dark" id="magma">
  <div class="wrap">
    <div class="v-header center">
      <span class="v-tag">Materiales</span>
      <h2 class="v-title">Magma y Materiales <span>Volcánicos</span></h2>
      <p class="v-sub">Composición y productos de la actividad volcánica</p>
    </div>

    <div class="v-magma-carousel-wrapper">
      <div class="v-magma-carousel-track" id="magmaCarouselTrack">
        
        <!-- Tarjeta 1: Magma -->
        <div class="v-magma-card">
          <div class="v-magma-card-image">
            <img src="assets/media/img/margmaV.png" alt="Magma" loading="lazy">
          </div>
          <div class="v-magma-card-body">
            <span class="v-magma-card-num">01</span>
            <h4>Magma</h4>
            <p>Roca fundida que permanece bajo la superficie terrestre. Contiene minerales fundidos, cristales y gases disueltos.</p>
            <a href="#" class="v-magma-card-btn">Explorar</a>
          </div>
        </div>

        <!-- Tarjeta 2: Lava -->
        <div class="v-magma-card">
          <div class="v-magma-card-image">
            <img src="assets/media/img/lavaV.png" alt="Lava" loading="lazy">
          </div>
          <div class="v-magma-card-body">
            <span class="v-magma-card-num">02</span>
            <h4>Lava</h4>
            <p>Cuando el magma alcanza la superficie recibe el nombre de lava. Dependiendo de su composición puede ser más fluida o viscosa.</p>
            <a href="#" class="v-magma-card-btn">Explorar</a>
          </div>
        </div>

        <!-- Tarjeta 3: Ceniza volcánica -->
        <div class="v-magma-card">
          <div class="v-magma-card-image">
            <img src="assets/media/img/cenizaV.png" alt="Ceniza volcánica" loading="lazy">
          </div>
          <div class="v-magma-card-body">
            <span class="v-magma-card-num">03</span>
            <h4>Ceniza volcánica</h4>
            <p>Diminutas partículas de roca y vidrio volcánico transportadas por el viento a grandes distancias.</p>
            <a href="#" class="v-magma-card-btn">Explorar</a>
          </div>
        </div>

        <!-- Tarjeta 4: Piroclastos -->
        <div class="v-magma-card">
          <div class="v-magma-card-image">
            <img src="assets/media/img/piroclastosV.png" alt="Piroclastos" loading="lazy">
          </div>
          <div class="v-magma-card-body">
            <span class="v-magma-card-num">04</span>
            <h4>Piroclastos</h4>
            <p>Fragmentos sólidos expulsados durante una erupción: ceniza, lapilli, bombas y bloques volcánicos.</p>
            <a href="#" class="v-magma-card-btn">Explorar</a>
          </div>
        </div>

        <!-- Tarjeta 5: Gases volcánicos -->
        <div class="v-magma-card">
          <div class="v-magma-card-image">
            <img src="assets/media/img/gasV.jpg" alt="Gases volcánicos" loading="lazy">
          </div>
          <div class="v-magma-card-body">
            <span class="v-magma-card-num">05</span>
            <h4>Gases volcánicos</h4>
            <p>Vapor de agua, dióxido de carbono, dióxido de azufre y otros gases liberados durante la actividad volcánica.</p>
            <a href="#" class="v-magma-card-btn">Explorar</a>
          </div>
        </div>

        <!-- Tarjeta 6: Bombas volcánicas -->
        <div class="v-magma-card">
          <div class="v-magma-card-image">
            <img src="assets/media/img/bombasV.jpg" alt="Bombas volcánicas" loading="lazy">
          </div>
          <div class="v-magma-card-body">
            <span class="v-magma-card-num">06</span>
            <h4>Bombas volcánicas</h4>
            <p>Grandes fragmentos de lava expulsados aún calientes que se solidifican mientras viajan por el aire.</p>
            <a href="#" class="v-magma-card-btn">Explorar</a>
          </div>
        </div>

        <!-- Tarjeta 7: Flujos piroclásticos -->
        <div class="v-magma-card">
          <div class="v-magma-card-image">
            <img src="assets/media/img/flujosV.jpg" alt="Flujos piroclásticos" loading="lazy">
          </div>
          <div class="v-magma-card-body">
            <span class="v-magma-card-num">07</span>
            <h4>Flujos piroclásticos</h4>
            <p>Mezcla de gases extremadamente calientes, ceniza y fragmentos de roca que descienden a gran velocidad.</p>
            <a href="#" class="v-magma-card-btn">Explorar</a>
          </div>
        </div>

      </div>

      <!-- Controles -->
      <button class="v-magma-carousel-btn prev" id="magmaPrev">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
      </button>
      <button class="v-magma-carousel-btn next" id="magmaNext">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
      </button>
    </div>
  </div>
</section>

<!-- ============================================================
     SCRIPT INLINE - CARRUSEL CON LOOP INFINITO
     ============================================================ -->
<script>
(function() {
    'use strict';

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCarousel);
    } else {
        initCarousel();
    }

    function initCarousel() {
        var track = document.getElementById('magmaCarouselTrack');
        var prevBtn = document.getElementById('magmaPrev');
        var nextBtn = document.getElementById('magmaNext');

        if (!track) return;

        var originalCards = Array.prototype.slice.call(track.querySelectorAll('.v-magma-card'));
        var realTotal = originalCards.length;
        if (realTotal === 0) return;

        // Loop infinito real: clonamos las ultimas EDGE tarjetas al inicio y
        // las primeras EDGE al final. Asi "Siguiente" desde la ultima tarjeta
        // sigue deslizando hacia adelante (entra un clon identico a la
        // primera) en vez de saltar de golpe el track completo de regreso al
        // indice 0, que es lo que se veia "feo" antes.
        var EDGE = 3; // = maximo de tarjetas visibles (ver getVisibleCards)
        var headClones = originalCards.slice(-EDGE).map(function(c) { return c.cloneNode(true); });
        var tailClones = originalCards.slice(0, EDGE).map(function(c) { return c.cloneNode(true); });
        headClones.forEach(function(c) {
            c.setAttribute('aria-hidden', 'true');
            track.insertBefore(c, track.firstChild);
        });
        tailClones.forEach(function(c) {
            c.setAttribute('aria-hidden', 'true');
            track.appendChild(c);
        });

        var cards = Array.prototype.slice.call(track.querySelectorAll('.v-magma-card'));
        var currentIndex = EDGE; // arranca en la primera tarjeta real
        var visibleCards = 3;
        var isAnimating = false;

        function getVisibleCards() {
            if (window.innerWidth <= 700) return 1;
            if (window.innerWidth <= 1024) return 2;
            return 3;
        }

        function getCardWidth() {
            var gap = parseFloat(window.getComputedStyle(track).columnGap) || 0;
            return cards[0].getBoundingClientRect().width + gap;
        }

        function setTransform(withTransition) {
            track.style.transition = withTransition ? '' : 'none';
            track.style.transform = 'translateX(-' + (currentIndex * getCardWidth()) + 'px)';
            if (!withTransition) void track.offsetWidth; // fuerza reflow antes de restaurar la transicion
        }

        function updateCarousel() {
            visibleCards = getVisibleCards();
            setTransform(true);
            updateCenterCard();
        }

        function updateCenterCard() {
            var centerIndex = currentIndex + Math.floor(visibleCards / 2);
            cards.forEach(function(card, i) {
                card.classList.toggle('center', i === centerIndex);
            });
        }

        // Si el indice actual quedo dentro de la zona de clones (porque el
        // usuario siguio avanzando/retrocediendo mas alla de las tarjetas
        // reales), lo reposicionamos sin transicion al indice real
        // equivalente -- el clon es visualmente identico, asi que el salto
        // es imperceptible y el loop se siente continuo.
        function snapIfInCloneZone() {
            if (currentIndex < EDGE) {
                currentIndex += realTotal;
                setTransform(false);
            } else if (currentIndex >= EDGE + realTotal) {
                currentIndex -= realTotal;
                setTransform(false);
            }
        }

        function goTo(index) {
            if (isAnimating) return;
            isAnimating = true;
            currentIndex = index;
            setTransform(true);
            updateCenterCard();
            setTimeout(function() {
                snapIfInCloneZone();
                updateCenterCard();
                isAnimating = false;
            }, 600);
        }

        function nextSlide() { goTo(currentIndex + 1); }
        function prevSlide() { goTo(currentIndex - 1); }

        if (prevBtn) prevBtn.addEventListener('click', prevSlide);
        if (nextBtn) nextBtn.addEventListener('click', nextSlide);

        var resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(function() {
                visibleCards = getVisibleCards();
                setTransform(false);
                updateCenterCard();
            }, 200);
        });

        setTimeout(function() { setTransform(false); updateCenterCard(); }, 300);
        window.addEventListener('load', function() {
            setTimeout(function() { setTransform(false); updateCenterCard(); }, 100);
        });
    }

})();
</script>

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
        
        <!-- ============================================================
             TAB 1: POR ACTIVIDAD
             ============================================================ -->
        <div class="v-tab-panel active" id="tab-actividad">
          <p class="v-tab-intro">Los volcanes se clasifican según su <strong>frecuencia eruptiva</strong> y el estado actual de su actividad magmática. Esta clasificación permite evaluar el riesgo volcánico y planificar medidas de monitoreo y prevención.</p>
          <div class="v-tab-grid">
            <div class="v-tab-item">
              <div class="v-tab-img">
                <img src="assets/media/img/ActivoV.jpg" alt="Activo" loading="lazy">
              </div>
              <span class="v-tab-badge active">Activo</span>
              <h4>Volcán Activo</h4>
              <p>Ha registrado erupciones durante los últimos <strong>11,700 años</strong> o presenta señales actuales de actividad, como emisiones de gases, sismos o deformación del terreno.</p>
            </div>
            <div class="v-tab-item">
              <div class="v-tab-img">
                <img src="assets/media/img/DormidoV.png" alt="Dormido" loading="lazy">
              </div>
              <span class="v-tab-badge dormant">Durmiente</span>
              <h4>Volcán Durmiente</h4>
              <p>No ha erupcionado en mucho tiempo, pero aún conserva la <strong>capacidad de reactivarse</strong> y volver a entrar en erupción.</p>
            </div>
            <div class="v-tab-item">
              <div class="v-tab-img">
                <img src="assets/media/img/ExtintoV.jpg" alt="Extinto" loading="lazy">
              </div>
              <span class="v-tab-badge extinct">Extinto</span>
              <h4>Volcán Extinto</h4>
              <p>Se considera que ya no posee una <strong>fuente de magma activa</strong> y no se espera que vuelva a presentar erupciones.</p>
            </div>
          </div>
        </div>

        <!-- ============================================================
             TAB 2: POR MORFOLOGÍA
             ============================================================ -->
        <div class="v-tab-panel" id="tab-morfologia">
          <p class="v-tab-intro">La morfología de un volcán está determinada por la <strong>composición química del magma</strong>, su <strong>viscosidad</strong> y el <strong>tipo de erupción</strong> que le da origen. Estas características definen la forma final del edificio volcánico.</p>
          <div class="v-tab-grid v-tab-grid-4">
            <div class="v-tab-item">
              <div class="v-tab-img">
                <img src="assets/media/img/estratovolcan.jpg" alt="Estratovolcán" loading="lazy">
              </div>
              <span class="v-tab-badge">Estratovolcán</span>
              <h4>Estratovolcán</h4>
              <p>Volcán alto y de forma cónica, formado por <strong>capas alternadas</strong> de lava, ceniza y otros materiales volcánicos. Es el tipo más común en El Salvador.</p>
            </div>
            <div class="v-tab-item">
              <div class="v-tab-img">
                <img src="assets/media/img/escudoV.jpg" alt="Escudo" loading="lazy">
              </div>
              <span class="v-tab-badge">Escudo</span>
              <h4>Volcán en Escudo</h4>
              <p>Presenta una base muy amplia y <strong>pendientes suaves</strong> debido a la acumulación de lava muy fluida que recorre grandes distancias.</p>
            </div>
            <div class="v-tab-item">
              <div class="v-tab-img">
                <img src="assets/media/img/conocenizaV.jpg" alt="Cono de ceniza" loading="lazy">
              </div>
              <span class="v-tab-badge">Cono de ceniza</span>
              <h4>Cono de Ceniza</h4>
              <p>Volcán pequeño y de <strong>laderas empinadas</strong>, formado por la acumulación de ceniza, escoria y otros fragmentos expulsados.</p>
            </div>
            <div class="v-tab-item">
              <div class="v-tab-img">
                <img src="assets/media/img/domolavV.jpeg" alt="Domo de lava" loading="lazy">
              </div>
              <span class="v-tab-badge">Domo de lava</span>
              <h4>Domo de Lava</h4>
              <p>Se forma cuando la lava es muy <strong>viscosa</strong> y se acumula sobre el cráter, creando una estructura redondeada de crecimiento lento.</p>
            </div>
            <div class="v-tab-item">
              <div class="v-tab-img">
                <img src="assets/media/img/maarV.jpg" alt="Maar" loading="lazy">
              </div>
              <span class="v-tab-badge">Maar</span>
              <h4>Maar</h4>
              <p>Gran cráter de origen <strong>explosivo</strong>, formado cuando el magma entra en contacto con agua subterránea.</p>
            </div>
            <div class="v-tab-item">
              <div class="v-tab-img">
                <img src="assets/media/img/calderaV.jpg" alt="Caldera" loading="lazy">
              </div>
              <span class="v-tab-badge">Caldera</span>
              <h4>Caldera</h4>
              <p>Amplia depresión circular que se forma cuando la cámara magmática se <strong>vacía</strong> y el terreno colapsa tras una gran erupción.</p>
            </div>
            <div class="v-tab-item">
              <div class="v-tab-img">
                <img src="assets/media/img/fisuralV.jpg" alt="Fisural" loading="lazy">
              </div>
              <span class="v-tab-badge">Fisural</span>
              <h4>Volcán Fisural</h4>
              <p>La lava emerge a través de <strong>largas grietas o fisuras</strong> de la corteza terrestre, formando extensos campos de lava.</p>
            </div>
          </div>
        </div>

        <!-- ============================================================
             TAB 3: POR ERUPCIÓN
             ============================================================ -->
        <div class="v-tab-panel" id="tab-erupcion">
          <p class="v-tab-intro">La clasificación por tipo de erupción se basa en la <strong>violencia del fenómeno eruptivo</strong>, determinada por la composición del magma, su contenido de gases y su viscosidad. Se ordenan de <strong>menor a mayor explosividad</strong>.</p>
          <div class="v-tab-grid">
            <div class="v-tab-item">
              <div class="v-tab-img">
                <img src="assets/media/img/Hawaianae.png" alt="Hawaiana" loading="lazy">
              </div>
              <span class="v-tab-badge">Hawaiana</span>
              <div class="v-explosivity-bar low">
                <span class="v-explosivity-label">Baja</span>
                <div class="v-explosivity-track"><div class="v-explosivity-fill" style="width:20%;"></div></div>
              </div>
              <h4>Hawaiana</h4>
              <p>Erupciones tranquilas con lava muy <strong>fluida</strong> que forma largos ríos de lava y genera poca ceniza.</p>
            </div>
            <div class="v-tab-item">
              <div class="v-tab-img">
                <img src="assets/media/img/islandesaE.png" alt="Islandesa" loading="lazy">
              </div>
              <span class="v-tab-badge">Islandesa</span>
              <div class="v-explosivity-bar low">
                <span class="v-explosivity-label">Baja</span>
                <div class="v-explosivity-track"><div class="v-explosivity-fill" style="width:20%;"></div></div>
              </div>
              <h4>Islandesa</h4>
              <p>La lava brota por <strong>largas fisuras</strong> de la corteza terrestre y cubre grandes extensiones con flujos poco explosivos.</p>
            </div>
            <div class="v-tab-item">
              <div class="v-tab-img">
                <img src="assets/media/img/estrombolianaE.png" alt="Estromboliana" loading="lazy">
              </div>
              <span class="v-tab-badge">Estromboliana</span>
              <div class="v-explosivity-bar moderate">
                <span class="v-explosivity-label">Moderada</span>
                <div class="v-explosivity-track"><div class="v-explosivity-fill" style="width:45%;"></div></div>
              </div>
              <h4>Estromboliana</h4>
              <p>Presenta explosiones <strong>moderadas e intermitentes</strong> que expulsan lava, ceniza y fragmentos volcánicos.</p>
            </div>
            <div class="v-tab-item">
              <div class="v-tab-img">
                <img src="assets/media/img/vulcanianaE.png" alt="Vulcaniana" loading="lazy">
              </div>
              <span class="v-tab-badge">Vulcaniana</span>
              <div class="v-explosivity-bar high">
                <span class="v-explosivity-label">Alta</span>
                <div class="v-explosivity-track"><div class="v-explosivity-fill" style="width:70%;"></div></div>
              </div>
              <h4>Vulcaniana</h4>
              <p>Erupciones de <strong>intensidad media</strong> con magma viscoso, columnas de ceniza y explosiones de corta duración.</p>
            </div>
            <div class="v-tab-item">
              <div class="v-tab-img">
                <img src="assets/media/img/peleanaE.png" alt="Peleana" loading="lazy">
              </div>
              <span class="v-tab-badge">Peleana</span>
              <div class="v-explosivity-bar very-high">
                <span class="v-explosivity-label">Muy alta</span>
                <div class="v-explosivity-track"><div class="v-explosivity-fill" style="width:90%;"></div></div>
              </div>
              <h4>Peleana</h4>
              <p>Erupciones <strong>muy explosivas</strong> caracterizadas por el colapso de domos de lava y la formación de peligrosos <strong>flujos piroclásticos</strong>.</p>
            </div>
            <div class="v-tab-item">
              <div class="v-tab-img">
                <img src="assets/media/img/plinianaE.png" alt="Pliniana" loading="lazy">
              </div>
              <span class="v-tab-badge">Pliniana</span>
              <div class="v-explosivity-bar extreme">
                <span class="v-explosivity-label">Extrema</span>
                <div class="v-explosivity-track"><div class="v-explosivity-fill" style="width:100%;"></div></div>
              </div>
              <h4>Pliniana</h4>
              <p>Las erupciones <strong>más violentas</strong>. Expulsan enormes columnas de ceniza, gases y roca que pueden alcanzar decenas de kilómetros de altura.</p>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<script>
  // ============================================================
// TABS - CLASIFICACIÓN DE VOLCANES
// ============================================================

document.addEventListener('DOMContentLoaded', function() {
    const tabBtns = document.querySelectorAll('.v-tab-btn');
    const tabPanels = document.querySelectorAll('.v-tab-panel');

    if (tabBtns.length === 0) return;

    tabBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            // Remover active de todos los botones
            tabBtns.forEach(function(b) {
                b.classList.remove('active');
            });
            // Activar el botón clickeado
            this.classList.add('active');

            // Obtener el tab destino
            var tab = this.dataset.tab;

            // Ocultar todos los paneles
            tabPanels.forEach(function(panel) {
                panel.classList.remove('active');
            });

            // Mostrar el panel correspondiente
            var targetPanel = document.getElementById('tab-' + tab);
            if (targetPanel) {
                targetPanel.classList.add('active');
            }
        });
    });
});
</script>

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
        <div class="v-card-img">
          <img src="assets/media/img/acumulacionPresion.jpg" alt="Presión" loading="lazy">
        </div>
        <div class="v-card-body">
          <span class="v-card-num">01</span>
          <h4>Acumulación de presión</h4>
          <p>El magma asciende por la chimenea impulsado por la flotabilidad y la presión de los gases disueltos.</p>
        </div>
      </div>
      <div class="v-card">
        <div class="v-card-img">
          <img src="assets/media/img/liberaciongases.jpg" alt="Gases" loading="lazy">
        </div>
        <div class="v-card-body">
          <span class="v-card-num">02</span>
          <h4>Liberación de gases</h4>
          <p>A medida que el magma se acerca a la superficie, la presión disminuye y los gases se liberan violentamente.</p>
        </div>
      </div>
      <div class="v-card">
        <div class="v-card-img">
          <img src="assets/media/img/expulsionV.jpeg" alt="Expulsión" loading="lazy">
        </div>
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
     SECCIÓN 7: VOLCANES DE EL SALVADOR - MAPA INTERACTIVO
     ============================================================ -->
<section class="v-section" id="volcanes-sv">
  <div class="wrap">
    <div class="v-header center">
      <span class="v-tag">El Salvador</span>
      <h2 class="v-title">Volcanes de <span>El Salvador</span></h2>
      <p class="v-sub">Explora la distribución de los principales centros volcánicos y conoce su actividad.</p>
    </div>

    <p class="v-intro">El Salvador forma parte de la <strong>cadena volcánica centroamericana</strong> y posee numerosos centros volcánicos distribuidos a lo largo del territorio. Explora el mapa para conocer su ubicación, características y estado.</p>

    <!-- Controles del mapa -->
    <div class="volcanes-controls">
      <div class="volcanes-search">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" id="volcanesSearch" placeholder="Buscar volcán..." autocomplete="off">
      </div>
      <div class="volcanes-filters">
        <button class="volcanes-filter-btn active" data-filter="all">Todos</button>
        <button class="volcanes-filter-btn" data-filter="activo"><span class="volcanes-filter-dot active"></span> Activos</button>
        <button class="volcanes-filter-btn" data-filter="dormido"><span class="volcanes-filter-dot dormant"></span> Dormidos</button>
        <button class="volcanes-filter-btn" data-filter="inactivo"><span class="volcanes-filter-dot inactive"></span> Inactivos</button>
      </div>
      <div class="volcanes-type-filters">
        <button class="volcanes-type-btn active" data-type="all">Todos</button>
        <button class="volcanes-type-btn" data-type="estratovolcan">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px;height:14px;"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
          Estratovolcán
        </button>
        <button class="volcanes-type-btn" data-type="caldera">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px;height:14px;"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="4"/></svg>
          Caldera
        </button>
        <button class="volcanes-type-btn" data-type="maar">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px;height:14px;"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><line x1="12" y1="2" x2="12" y2="22"/></svg>
          Maar
        </button>
      </div>
    </div>

    <!-- Layout mapa + panel -->
    <div class="volcanes-layout">
      <!-- Mapa -->
      <div class="volcanes-map-card">
        <div class="phdr">
          <span class="rdot"></span> 
          <span id="volcanesCount">10</span> estructuras mostradas
          <div class="volcanes-map-legend">
            <span class="volcanes-legend-item"><span class="volcanes-legend-dot active"></span> Activo</span>
            <span class="volcanes-legend-item"><span class="volcanes-legend-dot dormant"></span> Dormido</span>
            <span class="volcanes-legend-item"><span class="volcanes-legend-dot inactive"></span> Inactivo</span>
          </div>
        </div>
        <div id="volcanesMap"></div>
        <div class="volcanes-map-footer">
          <div class="volcanes-legend-full">
            <div class="volcanes-legend-group">
              <span class="volcanes-legend-title">Estado volcánico</span>
              <span class="volcanes-legend-item"><span class="volcanes-legend-dot active"></span> Activo</span>
              <span class="volcanes-legend-item"><span class="volcanes-legend-dot dormant"></span> Dormido</span>
              <span class="volcanes-legend-item"><span class="volcanes-legend-dot inactive"></span> Inactivo</span>
            </div>
            <div class="volcanes-legend-group">
              <span class="volcanes-legend-title">Tipo</span>
              <span class="volcanes-legend-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px;height:14px;"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
                Estratovolcán
              </span>
              <span class="volcanes-legend-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px;height:14px;"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="4"/></svg>
                Caldera
              </span>
              <span class="volcanes-legend-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px;height:14px;"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><line x1="12" y1="2" x2="12" y2="22"/></svg>
                Maar
              </span>
            </div>
            <div class="volcanes-legend-group">
              <span class="volcanes-legend-title">Monitoreo</span>
              <span class="volcanes-legend-item"><span class="volcanes-legend-dot monitored"></span> Monitoreado por MARN</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Panel lateral -->
      <div class="volcanes-panel">
        <div class="volcanes-panel-header">
          <h4>Lista de volcanes</h4>
          <span id="volcanesCountPanel">10</span>
        </div>
        <div class="volcanes-list" id="volcanesList">
          <div class="loading-s"><div class="spin"></div>Cargando volcanes…</div>
        </div>
      </div>
    </div>

    <div class="volcanes-disclaimer">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
      <span>Los volcanes clasificados como <strong>Activos</strong> corresponden a una clasificación geológica basada en actividad durante el Holoceno, lo que no significa necesariamente que estén en erupción actualmente. Información basada en registros del <strong>MARN</strong> y estudios geológicos.</span>
    </div>
  </div>
</section>

<script>
// ============================================================
// VOLCANES DE EL SALVADOR - MAPA INTERACTIVO (20 VOLCANES)
// ============================================================

(function() {
    'use strict';

    // ============================================================
    // 20 VOLCANES Y CENTROS VOLCÁNICOS DE EL SALVADOR
    // ============================================================

    // Coordenadas: GPS de alta precision verificadas por el usuario (no de
    // Wikipedia/OSM) para los 20 volcanes principales de El Salvador.
    // "imagen": ruta real cuando existe una foto en assets/media/img/ con ese
    // nombre; si no hay foto especifica se usa volcanBanner.jpg como
    // provisional -- buscar "PROVISIONAL" abajo para encontrar y reemplazar
    // esas rutas cuando se consiga la foto real de cada una.
    const VOLCANES = [
        {
            id: 1,
            nombre: 'Volcán de Santa Ana',
            nombreAlt: 'Ilamatepec',
            estado: 'activo',
            altura: '2,382 msnm',
            departamento: 'Santa Ana',
            tipo: 'estratovolcan',
            ultimaErupcion: '2005',
            descripcion: 'El volcán más alto de El Salvador. Presenta un cráter con una laguna ácida.',
            imagen: 'assets/media/img/Volcán Santa Ana (Ilamatepec).jpg',
            lat: 13.850395376810262,
            lon: -89.62935864135811,
            monitored: true
        },
        {
            id: 2,
            nombre: 'Volcán de Izalco',
            nombreAlt: null,
            estado: 'activo',
            altura: '1,965 msnm',
            departamento: 'Sonsonate',
            tipo: 'estratovolcan',
            ultimaErupcion: '1966',
            descripcion: 'Conocido como "El Faro del Pacífico" por su actividad casi continua entre 1770 y 1958. Monitoreado por MARN junto a Santa Ana y San Salvador.',
            imagen: 'assets/media/img/Volcán Izalco.jpg',
            lat: 13.815116,
            lon: -89.632853,
            monitored: true
        },
        {
            id: 3,
            nombre: 'Volcán de San Salvador',
            nombreAlt: 'Boquerón / Quetzaltepec',
            estado: 'activo',
            altura: '1,850–1,867 msnm',
            departamento: 'San Salvador',
            tipo: 'estratovolcan',
            ultimaErupcion: '1917',
            descripcion: 'Complejo volcánico conocido principalmente por su cráter El Boquerón, al norte de la capital.',
            imagen: 'assets/media/img/Volcán San Salvador (Boquerón).jpg',
            lat: 13.73734212519635,
            lon: -89.28704748688723,
            monitored: true
        },
        {
            id: 4,
            nombre: 'Volcán de San Miguel',
            nombreAlt: 'Chaparrastique',
            estado: 'activo',
            altura: '2,130 msnm',
            departamento: 'San Miguel',
            tipo: 'estratovolcan',
            ultimaErupcion: '2022',
            descripcion: 'Uno de los volcanes más activos de El Salvador, con erupciones registradas desde la época colonial y varias en la última década.',
            imagen: 'assets/media/img/Volcán San Miguel (Chaparrastique).jpg',
            lat: 13.436004263879635,
            lon: -88.26928460811901,
            monitored: true
        },
        {
            id: 5,
            nombre: 'Volcán de San Vicente',
            nombreAlt: 'Chichontepec',
            estado: 'dormido',
            altura: '2,173 msnm',
            departamento: 'San Vicente',
            tipo: 'estratovolcan',
            ultimaErupcion: 'Sin registro histórico',
            descripcion: 'Segundo volcán más alto de El Salvador. Su nombre en náhuat significa "Cerro de los dos picos". Actividad sísmica/fumarólica, sin erupciones registradas en tiempos históricos.',
            imagen: 'assets/media/img/Volcán San Vicente (Chinchontepec).jpg',
            lat: 13.592574680152275,
            lon: -88.84862678461693,
            monitored: true
        },
        {
            id: 6,
            nombre: 'Volcán de Tecapa',
            nombreAlt: 'Laguna de Alegría',
            estado: 'activo',
            altura: '1,592 msnm',
            departamento: 'Usulután',
            tipo: 'estratovolcan',
            ultimaErupcion: 'Sin registro histórico',
            descripcion: 'Presenta actividad fumarólica y microsismicidad constante, sin erupciones registradas. Su cráter alberga la Laguna de Alegría.',
            imagen: 'assets/media/img/Volcán Tecapa.jpg',
            lat: 13.494625498691782,
            lon: -88.50204298749738,
            monitored: true
        },
        {
            id: 7,
            nombre: 'Volcán de Usulután',
            nombreAlt: null,
            estado: 'dormido',
            altura: '1,450 msnm',
            departamento: 'Usulután',
            tipo: 'estratovolcan',
            ultimaErupcion: 'Sin registro histórico',
            descripcion: 'Ubicado al norte de la ciudad de Usulután, forma parte del arco volcánico centroamericano.',
            imagen: 'assets/media/img/Volcán Usulután.jpeg',
            lat: 13.419591922772971,
            lon: -88.47440272626477,
            monitored: false
        },
        {
            id: 8,
            nombre: 'Volcán de Chinameca',
            nombreAlt: 'Pacayal',
            estado: 'dormido',
            altura: '1,300 msnm',
            departamento: 'San Miguel',
            tipo: 'estratovolcan',
            ultimaErupcion: 'Sin registro histórico',
            descripcion: 'Presenta un cráter bien conservado y fumarolas en sus laderas.',
            imagen: 'assets/media/img/Volcán Chinameca.jpg',
            lat: 13.47866727416521,
            lon: -88.3298284107852,
            monitored: false
        },
        {
            id: 9,
            nombre: 'Volcán de Conchagua',
            nombreAlt: null,
            estado: 'dormido',
            altura: '1,250 msnm',
            departamento: 'La Unión',
            tipo: 'estratovolcan',
            ultimaErupcion: 'Sin registro histórico',
            descripcion: 'Ubicado en el extremo oriental de El Salvador, domina la bahía y el puerto de La Unión. Actividad fumarólica en ambos picos, sin erupciones registradas.',
            imagen: 'assets/media/img/Volcán Conchagua.jpg',
            lat: 13.276862473450333,
            lon: -87.8458965955024,
            monitored: false
        },
        {
            id: 10,
            nombre: 'Complejo Apaneca-Ilamatepec',
            nombreAlt: 'Cordillera de Apaneca',
            estado: 'activo',
            altura: '2,036 msnm',
            departamento: 'Ahuachapán',
            tipo: 'estratovolcan',
            ultimaErupcion: 'Sin registro histórico',
            descripcion: 'Cordillera volcánica con múltiples cráteres y actividad geotérmica; alimenta el campo geotérmico de Ahuachapán. Incluye picos como Cerro Verde, Las Ranas y Laguna Verde.',
            imagen: 'assets/media/img/Volcán Cerro Verde.jpg',
            lat: 13.917624311397633,
            lon: -89.71683843339771,
            monitored: false
        },
        {
            id: 11,
            nombre: 'Caldera de Ilopango',
            nombreAlt: null,
            estado: 'activo',
            altura: '438 msnm',
            departamento: 'San Salvador',
            tipo: 'caldera',
            ultimaErupcion: '1880',
            descripcion: 'Caldera volcánica formada por una gran erupción prehistórica. Su lago es uno de los más grandes de El Salvador; la última erupción registrada fue en 1880.',
            imagen: 'assets/media/img/Caldera de Ilopango.jpg',
            lat: 13.670757340285553,
            lon: -89.09190853324328,
            monitored: true
        },
        {
            id: 12,
            nombre: 'Caldera de Coatepeque',
            nombreAlt: 'Lago de Coatepeque',
            estado: 'dormido',
            altura: '746 msnm',
            departamento: 'Santa Ana',
            tipo: 'caldera',
            ultimaErupcion: 'Sin registro histórico',
            descripcion: 'Una de las calderas más grandes de El Salvador. Su lago es conocido por su color turquesa; sin erupciones registradas en tiempos históricos.',
            imagen: 'assets/media/img/volcanBanner.jpg', // PROVISIONAL: no hay foto especifica de Coatepeque en assets/media/img/
            lat: 13.83643110387805,
            lon: -89.56647764591264,
            monitored: false
        },
        {
            id: 13,
            nombre: 'Cerro El Tigre',
            nombreAlt: null,
            estado: 'dormido',
            altura: '1,640 msnm',
            departamento: 'San Miguel',
            tipo: 'maar',
            ultimaErupcion: 'Sin registro histórico',
            descripcion: 'Cráter de origen explosivo en el departamento de San Miguel, sin erupciones registradas.',
            imagen: 'assets/media/img/volcanBanner.jpg', // PROVISIONAL: no hay foto especifica de El Tigre en assets/media/img/
            lat: 13.468611617186859,
            lon: -88.42717794153612,
            monitored: false
        },
        {
            id: 14,
            nombre: 'Laguna de Aramuaca',
            nombreAlt: null,
            estado: 'dormido',
            altura: '181 msnm',
            departamento: 'San Miguel',
            tipo: 'maar',
            ultimaErupcion: 'Sin registro histórico',
            descripcion: 'Maar (cráter de explosión) con una laguna, en tierras bajas del departamento de San Miguel.',
            imagen: 'assets/media/img/volcanBanner.jpg', // PROVISIONAL: no hay foto especifica de Aramuaca en assets/media/img/
            lat: 13.430056052983089,
            lon: -88.10569874513598,
            monitored: false
        },
        {
            id: 15,
            nombre: 'Caldera Volcánica de Apastepeque',
            nombreAlt: 'Laguna de Apastepeque',
            estado: 'dormido',
            altura: '700 msnm',
            departamento: 'San Vicente',
            tipo: 'caldera',
            ultimaErupcion: 'Sin registro histórico',
            descripcion: 'Conjunto de lagunas y maares de origen volcánico en el departamento de San Vicente.',
            imagen: 'assets/media/img/volcanBanner.jpg', // PROVISIONAL: no hay foto especifica de Apastepeque en assets/media/img/
            lat: 13.717083450430055,
            lon: -88.76666707208607,
            monitored: false
        },
        {
            id: 16,
            nombre: 'Cerro Cinotepeque',
            nombreAlt: null,
            estado: 'dormido',
            altura: '665 msnm',
            departamento: 'San Salvador',
            tipo: 'cono',
            ultimaErupcion: 'Sin registro histórico',
            descripcion: 'Edificio volcánico menor cerca de El Paisnal, sin actividad registrada.',
            imagen: 'assets/media/img/volcanBanner.jpg', // PROVISIONAL: no hay foto especifica de Cinotepeque en assets/media/img/
            lat: 14.007249368287832,
            lon: -89.24494420955051,
            monitored: false
        },
        {
            id: 17,
            nombre: 'Volcán Singüil',
            nombreAlt: null,
            estado: 'dormido',
            altura: '957 msnm',
            departamento: 'Santa Ana',
            tipo: 'cono',
            ultimaErupcion: 'Sin registro histórico',
            descripcion: 'Cono volcánico en el norte de Santa Ana, cerca de Metapán, sin actividad registrada.',
            imagen: 'assets/media/img/volcanBanner.jpg', // PROVISIONAL: no hay foto especifica de Singüil en assets/media/img/
            lat: 14.05387014135534,
            lon: -89.63292472414422,
            monitored: false
        },
        {
            id: 18,
            nombre: 'Cerro San Diego',
            nombreAlt: null,
            estado: 'dormido',
            altura: '781 msnm',
            departamento: 'Santa Ana',
            tipo: 'campo',
            ultimaErupcion: 'Sin registro histórico',
            descripcion: 'Campo volcánico en el extremo norte del país, cerca de la frontera con Guatemala.',
            imagen: 'assets/media/img/volcanBanner.jpg', // PROVISIONAL: no hay foto especifica de San Diego en assets/media/img/
            lat: 14.274165455972623,
            lon: -89.48064373090531,
            monitored: false
        },
        {
            id: 19,
            nombre: 'Volcán Taburete',
            nombreAlt: null,
            estado: 'dormido',
            altura: '1,172 msnm',
            departamento: 'Usulután',
            tipo: 'cono',
            ultimaErupcion: 'Sin registro histórico',
            descripcion: 'Cono volcánico en el departamento de Usulután, cerca del campo geotérmico de Berlín.',
            imagen: 'assets/media/img/volcanBanner.jpg', // PROVISIONAL: no hay foto especifica de Taburete en assets/media/img/
            lat: 13.442418337185178,
            lon: -88.5328379283413,
            monitored: false
        },
        {
            id: 20,
            nombre: 'Volcán Guazapa',
            nombreAlt: null,
            estado: 'inactivo',
            altura: '1,438 msnm',
            departamento: 'Cuscatlán',
            tipo: 'cono',
            ultimaErupcion: 'Sin evidencia de actividad en el Holoceno',
            descripcion: 'Edificio volcánico erosionado cerca de Suchitoto, sin evidencia de actividad reciente.',
            imagen: 'assets/media/img/volcanBanner.jpg', // PROVISIONAL: no hay foto especifica de Guazapa en assets/media/img/
            lat: 13.902555765790117,
            lon: -89.11129247202877,
            monitored: false
        }
    ];

    // ============================================================
    // CONFIGURACIÓN DE ESTADOS Y COLORES
    // ============================================================

    const ESTADO_LABELS = {
        activo: 'Activo',
        dormido: 'Dormido',
        inactivo: 'Inactivo'
    };

    const ESTADO_COLORS = {
        activo: '#e0631f',
        dormido: '#4fc3f7',
        inactivo: '#90a4ae'
    };

    // ============================================================
    // ICONOS SVG
    // ============================================================

    const VOLCANO_SVG = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>';

    const TYPE_SVGS = {
        estratovolcan: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>',
        caldera: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="4"/></svg>',
        maar: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><line x1="12" y1="2" x2="12" y2="22"/></svg>',
        cono: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 22 22 2 22 12 2"/></svg>',
        campo: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4l16 16M20 4L4 20"/><circle cx="12" cy="12" r="4"/></svg>'
    };

    // ============================================================
    // ESTADO DE LA APLICACIÓN
    // ============================================================

    var map = null;
    var markersLayer = null;
    var allItems = [];
    var currentFilter = 'all';
    var currentType = 'all';
    var searchTerm = '';

    // ============================================================
    // FUNCIONES DEL MAPA
    // ============================================================

    function waitForLeaflet() {
        return new Promise(function(resolve) {
            if (window.L) { resolve(); return; }
            var iv = setInterval(function() {
                if (window.L) { clearInterval(iv); resolve(); }
            }, 50);
        });
    }

    function markerIcon(volcan) {
        var isMonitored = volcan.monitored;
        var color = ESTADO_COLORS[volcan.estado] || '#90a4ae';
        var size = isMonitored ? 36 : 30;
        var html = '<div class="volcan-marker ' + (isMonitored ? 'monitored' : '') + '" style="background:' + color + '; width:' + size + 'px; height:' + size + 'px;">' + VOLCANO_SVG + '</div>';
        return L.divIcon({
            className: '',
            html: html,
            iconSize: [size, size],
            iconAnchor: [size/2, size/2]
        });
    }

    function createPopupContent(volcan) {
        var statusLabel = ESTADO_LABELS[volcan.estado] || volcan.estado;
        var typeSvg = TYPE_SVGS[volcan.tipo] || '';
        var monitoredBadge = volcan.monitored ? '<span class="popup-monitored-badge">Monitoreado por MARN</span>' : '';
        var altName = volcan.nombreAlt ? '<span class="popup-alt-name">(' + volcan.nombreAlt + ')</span>' : '';
        var lastEruption = (volcan.ultimaErupcion && volcan.ultimaErupcion !== 'Desconocida') ?
            '<div class="popup-detail"><span class="popup-detail-label">Última erupción:</span> ' + volcan.ultimaErupcion + '</div>' : '';

        var heightDisplay = (volcan.altura && volcan.altura !== '0 msnm') ?
            '<div class="popup-detail"><span class="popup-detail-label">Altura:</span> ' + volcan.altura + '</div>' : '';

        // Enlaces a Google Maps en formato correcto
        var mapsUrl = 'https://www.google.com/maps?q=' + volcan.lat + ',' + volcan.lon + '&hl=es';
        var directionsUrl = 'https://www.google.com/maps/dir/?api=1&destination=' + volcan.lat + ',' + volcan.lon + '&travelmode=driving&hl=es';

        // Iconos SVG
        var locationSvg = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>';
        var arrowSvg = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>';

        // Sin foto real todavia (volcan.imagen === null): mostramos un
        // marcador de posicion en vez de un <img> roto. Cuando se agregue la
        // foto real basta con poner su ruta en el campo "imagen" de VOLCANES.
        var imageBlock = volcan.imagen
            ? '<div class="volcan-popup-image"><img src="' + volcan.imagen + '" alt="' + volcan.nombre + '" loading="lazy"></div>'
            : '<div class="volcan-popup-image placeholder">' + typeSvg + '</div>';

        // Imagen a la izquierda + nombre/estado a la derecha, para que el
        // popup quede compacto en vez de apilar todo hacia abajo.
        return '<div class="volcan-popup">' +
            '<div class="volcan-popup-top">' +
            imageBlock +
            '<div class="volcan-popup-top-info">' +
            '<div class="popup-name">' + volcan.nombre + ' ' + altName + '</div>' +
            '<div class="popup-depto">' + locationSvg + ' ' + volcan.departamento + '</div>' +
            '<div class="popup-status-row">' +
            '<span class="popup-status ' + volcan.estado + '">' + statusLabel + '</span>' +
            monitoredBadge +
            '</div>' +
            '</div>' +
            '</div>' +
            '<div class="popup-detail"><span class="popup-detail-label">Tipo:</span> ' + typeSvg + ' ' + volcan.tipo + '</div>' +
            heightDisplay +
            lastEruption +
            '<div class="popup-desc">' + volcan.descripcion + '</div>' +
            '<div class="popup-actions">' +
            '<a href="' + mapsUrl + '" target="_blank" rel="noopener" class="popup-btn">' + locationSvg + ' Ubicación</a>' +
            '<a href="' + directionsUrl + '" target="_blank" rel="noopener" class="popup-btn popup-btn-secondary">' + arrowSvg + ' Cómo llegar</a>' +
            '</div>' +
            '</div>';
    }

    function getChainPoints() {
        return [
            [13.917624311397633, -89.71683843339771], // Apaneca-Ilamatepec
            [13.850395376810262, -89.62935864135811], // Santa Ana
            [13.815116, -89.632853], // Izalco
            [13.73734212519635, -89.28704748688723], // San Salvador
            [13.670757340285553, -89.09190853324328], // Ilopango
            [13.592574680152275, -88.84862678461693], // San Vicente
            [13.494625498691782, -88.50204298749738], // Tecapa
            [13.436004263879635, -88.26928460811901], // San Miguel
            [13.276862473450333, -87.8458965955024]   // Conchagua
        ];
    }

    async function initMap() {
        var el = document.getElementById('volcanesMap');
        if (!el) return;
        await waitForLeaflet();

        function tileUrlForTheme() {
            var isDark = document.documentElement.getAttribute('data-theme') !== 'light';
            return isDark
                ? 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png'
                : 'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png';
        }

        map = L.map(el, {
            zoomControl: false,
            attributionControl: false,
            center: [13.7, -88.8],
            zoom: 8
        });

        L.control.zoom({ position: 'topright' }).addTo(map);

        var mapTiles = L.tileLayer(tileUrlForTheme(), {
            subdomains: 'abcd',
            maxZoom: 18,
            attribution: '© CARTO · © OpenStreetMap'
        }).addTo(map);

        // El boton de tema claro/oscuro cambia data-theme en <html> sin
        // recargar la pagina, igual que en el mapa de riesgo de Sismos.
        new MutationObserver(function() {
            mapTiles.setUrl(tileUrlForTheme());
        }).observe(document.documentElement, { attributes: true, attributeFilter: ['data-theme'] });

        // Línea de la cadena volcánica
        var chainPoints = getChainPoints();
        L.polyline(chainPoints, {
            color: 'rgba(224, 99, 31, 0.25)',
            weight: 2,
            dashArray: '6, 8',
            opacity: 0.5
        }).addTo(map);

        markersLayer = L.layerGroup().addTo(map);
    }

    // ============================================================
    // FUNCIONES DE RENDERIZADO
    // ============================================================

    function getFilteredItems() {
        var items = allItems.slice();

        // Filtro por estado
        if (currentFilter !== 'all') {
            items = items.filter(function(it) { return it.estado === currentFilter; });
        }

        // Filtro por tipo
        if (currentType !== 'all') {
            items = items.filter(function(it) { return it.tipo === currentType; });
        }

        // Búsqueda por nombre (incluye nombre completo y alternativo)
        if (searchTerm.trim()) {
            var term = searchTerm.toLowerCase().trim();
            items = items.filter(function(it) {
                var nombreCompleto = it.nombre.toLowerCase();
                var nombreAlt = it.nombreAlt ? it.nombreAlt.toLowerCase() : '';
                var departamento = it.departamento.toLowerCase();
                // Buscar en nombre completo, nombre alternativo y departamento
                return nombreCompleto.indexOf(term) !== -1 ||
                    nombreAlt.indexOf(term) !== -1 ||
                    departamento.indexOf(term) !== -1;
            });
        }

        return items;
    }

    function renderMarkers() {
        if (!markersLayer) return;
        markersLayer.clearLayers();

        var items = getFilteredItems();

        items.forEach(function(volcan) {
            var m = L.marker([volcan.lat, volcan.lon], {
                icon: markerIcon(volcan),
                title: volcan.nombre
            });
            m.bindPopup(createPopupContent(volcan), {
                className: 'volcan-popup-container',
                maxWidth: 310,
                minWidth: 240
            });
            m.addTo(markersLayer);
        });

        updateCounts();
    }

    function renderList() {
        var list = document.getElementById('volcanesList');
        if (!list) return;

        var items = getFilteredItems();

        if (!items.length) {
            list.innerHTML = '<div class="volcanes-empty">No hay volcanes con estos filtros.</div>';
            return;
        }

        var html = '';
        items.forEach(function(it) {
            var statusLabel = ESTADO_LABELS[it.estado] || it.estado;
            var monitoredBadge = it.monitored ? '<span class="volcanes-item-monitored">MARN</span>' : '';
            var iconColor = it.estado;

            html += '<div class="volcanes-item" data-lat="' + it.lat + '" data-lon="' + it.lon + '" data-id="' + it.id + '">' +
                '<div class="volcanes-item-icon ' + iconColor + '">' + VOLCANO_SVG + '</div>' +
                '<div class="volcanes-item-body">' +
                '<div class="volcanes-item-name-row">' +
                '<span class="volcanes-item-name ' + iconColor + '">' + it.nombre + '</span>' + monitoredBadge +
                '</div>' +
                '<div class="volcanes-item-meta">' +
                '<span class="volcanes-item-altura">' + it.altura + ' · ' + it.departamento + '</span>' +
                '<span class="volcanes-item-status ' + it.estado + '">' + statusLabel + '</span>' +
                '</div>' +
                '</div>' +
                '</div>';
        });

        list.innerHTML = html;

        list.querySelectorAll('.volcanes-item').forEach(function(node) {
            node.addEventListener('click', function(e) {
                var lat = parseFloat(this.dataset.lat);
                var lon = parseFloat(this.dataset.lon);
                if (map) {
                    map.setView([lat, lon], 12);
                    markersLayer.eachLayer(function(layer) {
                        if (layer.getLatLng && layer.getLatLng().lat === lat && layer.getLatLng().lng === lon) {
                            layer.openPopup();
                        }
                    });
                }
            });
        });
    }

    function updateCounts() {
        var items = getFilteredItems();
        var countEl = document.getElementById('volcanesCount');
        var countPanelEl = document.getElementById('volcanesCountPanel');
        if (countEl) countEl.textContent = items.length;
        if (countPanelEl) countPanelEl.textContent = items.length;
    }

    // ============================================================
    // FILTROS Y BÚSQUEDA
    // ============================================================

    function wireFilters() {
        // Filtros de estado
        document.querySelectorAll('.volcanes-filter-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var filter = this.dataset.filter;
                document.querySelectorAll('.volcanes-filter-btn').forEach(function(b) {
                    b.classList.remove('active');
                });
                this.classList.add('active');
                currentFilter = filter;
                renderMarkers();
                renderList();
            });
        });

        // Filtros de tipo
        document.querySelectorAll('.volcanes-type-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var type = this.dataset.type;
                document.querySelectorAll('.volcanes-type-btn').forEach(function(b) {
                    b.classList.remove('active');
                });
                this.classList.add('active');
                currentType = type;
                renderMarkers();
                renderList();
            });
        });

        // Búsqueda - CORREGIDA
        var searchInput = document.getElementById('volcanesSearch');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                searchTerm = this.value;
                renderMarkers();
                renderList();

                // Debug: mostrar cuántos resultados hay
                var filtered = getFilteredItems();
                console.log('🔍 Búsqueda: "' + searchTerm + '" → ' + filtered.length + ' resultados');
            });

            // Buscar también al presionar Enter
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    searchTerm = this.value;
                    renderMarkers();
                    renderList();
                    var filtered = getFilteredItems();
                    console.log('🔍 Búsqueda Enter: "' + searchTerm + '" → ' + filtered.length + ' resultados');
                }
            });
        }
    }

    // ============================================================
    // INICIALIZACIÓN
    // ============================================================

    function boot() {
        var listEl = document.getElementById('volcanesList');
        if (!document.getElementById('volcanesMap')) return;

        initMap().then(function() {
            allItems = VOLCANES;
            renderMarkers();
            renderList();
            wireFilters();

            // Mostrar número total en consola
            console.log('✅ Volcanes de El Salvador cargados: ' + allItems.length + ' estructuras');
            console.log('📊 Activos: ' + allItems.filter(function(v) { return v.estado === 'activo'; }).length);
            console.log('📊 Dormidos: ' + allItems.filter(function(v) { return v.estado === 'dormido'; }).length);
            console.log('📊 Inactivos: ' + allItems.filter(function(v) { return v.estado === 'inactivo'; }).length);
            console.log('📊 Monitoreados por MARN: ' + allItems.filter(function(v) { return v.monitored; }).length);

        }).catch(function(e) {
            console.error('Error al cargar el mapa:', e);
            if (listEl) listEl.innerHTML = '<div class="volcanes-error">No se pudo cargar el mapa de volcanes.</div>';
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }

})();
</script>

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
      <div class="v-card-horizontal">
        <div class="v-card-img">
          <img src="assets/media/img/Volcán Santa Ana (Ilamatepec).jpg" alt="Santa Ana" loading="lazy">
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
      <div class="v-card-horizontal">
        <div class="v-card-img">
          <img src="assets/media/img/Volcán Izalco.jpg" alt="Izalco" loading="lazy">
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
      <div class="v-card-horizontal">
        <div class="v-card-img">
          <img src="assets/media/img/Volcán San Salvador (Boquerón).jpg" alt="San Salvador" loading="lazy">
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
      <div class="v-card-horizontal">
        <div class="v-card-img">
          <img src="assets/media/img/Volcán San Miguel (Chaparrastique).jpg" alt="San Miguel" loading="lazy">
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
      <div class="v-card-horizontal">
        <div class="v-card-img">
          <img src="assets/media/img/ilopangoV.jpg" alt="Ilopango" loading="lazy">
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
      <div class="v-card-horizontal">
        <div class="v-card-img">
          <img src="assets/media/img/Volcán San Vicente (Chinchontepec).jpg" alt="San Vicente" loading="lazy">
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
      <div class="v-card-horizontal">
        <div class="v-card-img">
          <img src="assets/media/img/Volcán Tecapa.jpg" alt="Tecapa" loading="lazy">
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
      <div class="v-card-horizontal">
        <div class="v-card-img">
          <img src="assets/media/img/Volcán Conchagua.jpg" alt="Conchagua" loading="lazy">
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
      <div class="v-card-horizontal">
        <div class="v-card-img">
          <img src="assets/media/img/conchaguitaV.jpg" alt="Conchagüita" loading="lazy">
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
      <div class="v-card-horizontal">
        <div class="v-card-img">
          <img src="assets/media/img/hoyonV.jpg" alt="El Hoyón" loading="lazy">
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
        <div class="v-card-img"><img src="assets/media/img/estudiosSV.jpg" alt="Primeros estudios" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Primeros estudios</h4>
          <p>Goodyear (1880), Karl Sapper (1925) y Montessus de Ballore realizaron los primeros estudios detallados.</p>
        </div>
      </div>
      <div class="v-card">
        <div class="v-card-img"><img src="assets/media/img/geologosSV.jpg" alt="Geólogos" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Geólogos importantes</h4>
          <p>Helmut Meyer Abich, Howell Williams, Richard Stoiber y Mike Carr han realizado trabajos fundamentales.</p>
        </div>
      </div>
      <div class="v-card">
        <div class="v-card-img"><img src="assets/media/img/misionAlemana.jpg" alt="Misiones" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Misiones geológicas</h4>
          <p>Misión Geológica Alemana (1967-1971) comprobó más de 700 centros de erupción.</p>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- ============================================================
     SECCIÓN 9B: HISTORIA VOLCÁNICA - LÍNEA DE TIEMPO
     ============================================================ -->
<section class="v-section v-section-dark" id="timeline-volcanes">
  <div class="wrap">
    <div class="v-header center">
      <span class="v-tag">Historia Volcánica</span>
      <h2 class="v-title">Línea del <span>Tiempo</span></h2>
      <p class="v-sub">Las erupciones más significativas en la historia del país</p>
    </div>
    <div class="tl-wrap">
      <div class="tl-line"></div>
      <div class="tl-track" id="tlTrack-volcanes"></div>
    </div>
    <div class="tl-detail" id="tlDetail-volcanes"></div>
    <div class="data-source-note">
      <strong>Fuentes y respaldo de datos:</strong> Global Volcanism Program (Smithsonian Institution), Ministerio de Medio Ambiente y Recursos Naturales (MARN/SNET) y hemerotecas nacionales (La Prensa Gráfica, El Diario de Hoy).
    </div>
  </div>
</section>
<script>
document.addEventListener('DOMContentLoaded', function () {
    ndaInitTimeline('volcanes', [
        { year: '1658', title: 'Erupción de El Playón', badge: 'Sepultó Nejapa', region: 'San Salvador',
          desc: 'Un cono lateral del volcán de San Salvador entró en erupción entre 1658 y 1671. Su flujo de lava sepultó el poblado de Nejapa, obligando a sus habitantes a reubicarse en el sitio donde hoy se encuentra la ciudad.',
          tags: [{ t: 'Histórico', c: '' }, { t: 'Flujo de lava', c: 'o' }],
          stats: [{ v: '1658', l: 'Inicio' }, { v: '13', l: 'Años de actividad' }, { v: '660 msnm', l: 'Altura' }],
          img: 'assets/media/img/Volcán El Playón.webp' },
        { year: '1880', title: 'Nacen las Islas Quemadas', badge: 'Erupción en el lago', region: 'Lago de Ilopango, San Salvador',
          desc: 'Una erupción dentro del lago de Ilopango, entre 1879 y 1880, formó un domo de lava que emergió en el centro del lago: las Islas Quemadas, visibles hasta hoy.',
          tags: [{ t: '1879-1880', c: '' }, { t: 'Domo de lava', c: 'o' }],
          stats: [{ v: '1880', l: 'Año' }, { v: '450 msnm', l: 'Altura del domo' }, { v: '438 msnm', l: 'Caldera' }],
          img: 'assets/media/img/Caldera de Ilopango.jpg' },
        { year: '1917', title: 'Terremoto y erupción del Boquerón', badge: '~1,050 fallecidos', region: 'San Salvador',
          desc: 'La noche del 7 de junio de 1917, tres fuertes sismos (hasta M6.7) sacudieron la capital y desencadenaron una erupción del volcán de San Salvador. La laguna del cráter hirvió y se evaporó, dejando el cono conocido como "El Boqueroncito".',
          tags: [{ t: 'M 6.7', c: 'r' }, { t: '~1,050 muertos', c: 'r' }],
          stats: [{ v: '6.7', l: 'Magnitud máx.' }, { v: '~1,050', l: 'Fallecidos' }, { v: '1917', l: 'Año' }],
          img: 'assets/media/img/Erupción del volcán de San Salvador (1917).jpg' },
        { year: '1926', title: 'Izalco sepulta El Matazano', badge: '56 fallecidos', region: 'Sonsonate',
          desc: 'El 8 de noviembre de 1926, un flujo de lava del Izalco sepultó el cantón El Matazano. Varios trabajadores fueron sorprendidos en sus cafetales sin tiempo para escapar.',
          tags: [{ t: '56 muertos', c: 'r' }, { t: 'Flujo de lava', c: 'o' }],
          stats: [{ v: '56', l: 'Fallecidos' }, { v: '1926', l: 'Año' }, { v: 'El Matazano', l: 'Cantón sepultado' }],
          img: 'assets/media/img/Volcán Izalco.jpg' },
        { year: '1966', title: 'Última erupción del Izalco', badge: 'Fin del Faro del Pacífico', region: 'Sonsonate',
          desc: 'Tras casi dos siglos de actividad casi continua desde su nacimiento (1770), el Izalco tuvo su última erupción registrada en 1966, apagando el "Faro del Pacífico".',
          tags: [{ t: '1966', c: '' }, { t: 'Fin de ciclo', c: 't' }],
          stats: [{ v: '1966', l: 'Última erupción' }, { v: '~196', l: 'Años activo' }, { v: '1,965 msnm', l: 'Altura' }],
          img: 'assets/media/img/Volcán Izalco2.jpg' },
        { year: '2005', title: 'Erupción del volcán de Santa Ana', badge: '2 fallecidos', region: 'Santa Ana',
          desc: 'El 1 de octubre de 2005 a las 8:20 a.m., el Santa Ana tuvo una explosión freática que generó una columna de ceniza de 10 km. Un lahar caliente causó 2 muertes y se evacuó a más de 7,500 personas.',
          tags: [{ t: '2005', c: 'r' }, { t: '2 fallecidos', c: 'r' }],
          stats: [{ v: '2005', l: 'Año' }, { v: '2', l: 'Fallecidos' }, { v: '7,500+', l: 'Evacuados' }],
          img: 'assets/media/img/Volcán Santa Ana (Ilamatepec).jpg' }
    ]);
});
</script>

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

    <div class="v-grid-4">
      <div class="v-card">
        <div class="v-card-img"><img src="assets/media/img/vigilancia.jpg" alt="Sismógrafo" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Vigilancia sísmica</h4>
          <p>15 estaciones telemétricas detectan sismos volcánicos y microsismicidad.</p>
        </div>
      </div>
      <div class="v-card">
        <div class="v-card-img"><img src="assets/media/img/gpsV.jpg" alt="GPS" loading="lazy"></div>
        <div class="v-card-body">
          <h4>GPS</h4>
          <p>Mide deformaciones del terreno que indican movimiento de magma.</p>
        </div>
      </div>
      <div class="v-card">
        <div class="v-card-img"><img src="assets/media/img/camaraV.jpg" alt="Cámara" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Cámaras</h4>
          <p>Monitorean visualmente la actividad del cráter y las fumarolas.</p>
        </div>
      </div>
      <div class="v-card">
        <div class="v-card-img"><img src="assets/media/img/vigilanciaV.png" alt="Satélite" loading="lazy"></div>
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
        <span>Tecapa</span>
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
        <div class="v-card-img"><img src="assets/media/img/cenizaV.png" alt="Ceniza" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Caída de Ceniza</h4>
          <p>Afecta cultivos, techos, vías respiratorias y visibilidad a kilómetros del cráter.</p>
        </div>
      </div>
      <div class="v-card v-card-danger">
        <div class="v-card-img"><img src="assets/media/img/gasV.jpg" alt="Gases" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Gases Volcánicos</h4>
          <p>SO₂ irrita ojos y pulmones. CO₂ es incoloro e inodoro. H₂S es tóxico.</p>
        </div>
      </div>
      <div class="v-card v-card-danger">
        <div class="v-card-img"><img src="assets/media/img/piroclastosV.png" alt="Piroclásticos" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Flujos Piroclásticos</h4>
          <p>Nubes de gas y roca a alta temperatura que descienden rápido por las laderas.</p>
        </div>
      </div>
      <div class="v-card v-card-danger">
        <div class="v-card-img"><img src="assets/media/img/lavaV.png" alt="Lahares" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Lahares</h4>
          <p>Coladas de lodo volcánico que bajan por quebradas. Mortíferos por su velocidad.</p>
        </div>
      </div>
      <div class="v-card v-card-danger">
        <div class="v-card-img"><img src="assets/media/img/deslizamientoV.jpeg" alt="Deslizamientos" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Deslizamientos</h4>
          <p>Fragmentos del volcán se derrumban por caída de rocas o deslizamientos.</p>
        </div>
      </div>
      <div class="v-card v-card-danger">
        <div class="v-card-img"><img src="assets/media/img/tsunamiV.webp" alt="Tsunamis" loading="lazy"></div>
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
        <div class="v-card-img"><img src="assets/media/img/antesV.png" alt="Antes" loading="lazy"></div>
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
        <div class="v-card-img"><img src="assets/media/img/duranteV.png" alt="Durante" loading="lazy"></div>
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
        <div class="v-card-img"><img src="assets/media/img/despuesV.png" alt="Después" loading="lazy"></div>
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

    <div class="v-beneficios-scrollzone">
    <div class="v-beneficios-carousel">
    <div class="v-beneficios-track">
      <div class="v-card">
        <div class="v-card-img"><img src="assets/media/img/agriculturaV.jpg" alt="Agricultura" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Agricultura</h4>
          <p>Suelos volcánicos fértiles por su alto contenido de minerales.</p>
        </div>
      </div>
      <div class="v-card">
        <div class="v-card-img"><img src="assets/media/img/geotermiaV.webp" alt="Geotermia" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Geotermia</h4>
          <p>Calor del interior para generar energía limpia y renovable.</p>
        </div>
      </div>
      <div class="v-card">
        <div class="v-card-img"><img src="assets/media/img/mineralesV.webp" alt="Minerales" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Minerales</h4>
          <p>Fuente de oro, plata, cobre y materiales de construcción.</p>
        </div>
      </div>
      <div class="v-card">
        <div class="v-card-img"><img src="assets/media/img/biodiversidadV.jpg" alt="Biodiversidad" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Biodiversidad</h4>
          <p>Ecosistemas volcánicos con especies únicas de flora y fauna.</p>
        </div>
      </div>
      <div class="v-card">
        <div class="v-card-img"><img src="assets/media/img/turismoV.jpg" alt="Turismo" loading="lazy"></div>
        <div class="v-card-body">
          <h4>Turismo</h4>
          <p>Atraen a miles de turistas nacionales e internacionales.</p>
        </div>
      </div>
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

    <p class="v-intro">El <strong>Parque Nacional Complejo Los Volcanes</strong>, a unos 60 km de San Salvador, reúne los 3 volcanes más visitados del país en un mismo macizo: Santa Ana, Izalco y Cerro Verde. Junto al cercano lago de Coatepeque, forman el destino de aventura volcánica más popular de El Salvador.</p>

    <div class="v-grid-2">
      <div class="v-card-horizontal">
        <div class="v-card-img"><img src="assets/media/img/Volcán Santa Ana (Ilamatepec).jpg" alt="Santa Ana" loading="lazy"></div>
        <div class="v-card-body">
          <span class="v-card-chip">2,381 msnm · 1.5 h</span>
          <h4>Santa Ana</h4>
          <p>El volcán más alto del país. Su cráter guarda una <strong>laguna turquesa</strong> teñida por el alto contenido de azufre, uno de los cráteres más fotografiados de Centroamérica. El sendero llega hasta el borde, con vistas al lago de Coatepeque y, en días despejados, hasta Guatemala.</p>
        </div>
      </div>
      <div class="v-card-horizontal">
        <div class="v-card-img"><img src="assets/media/img/Volcán Izalco.jpg" alt="Izalco" loading="lazy"></div>
        <div class="v-card-body">
          <span class="v-card-chip">1,965 msnm · 3-4 h</span>
          <h4>Izalco</h4>
          <p><strong>"El Faro del Pacífico"</strong>: entre 1770 y 1966 estuvo casi siempre activo, guiando de noche a los barcos que navegaban frente a la costa. Hoy se asciende por su cono de ceniza casi perfecto, uno de los paisajes más icónicos del país.</p>
        </div>
      </div>
      <div class="v-card-horizontal">
        <div class="v-card-img"><img src="assets/media/img/Volcán Cerro Verde.jpg" alt="Cerro Verde" loading="lazy"></div>
        <div class="v-card-body">
          <span class="v-card-chip">2,030 msnm · Fácil</span>
          <h4>Cerro Verde</h4>
          <p>El más antiguo de los tres y hoy sin actividad eruptiva, cubierto por un fresco bosque nuboso. El sendero de las <strong>"Flores Misteriosas"</strong> lleva a miradores con vista directa al Izalco y al lago de Coatepeque.</p>
        </div>
      </div>
      <div class="v-card-horizontal">
        <div class="v-card-img"><img src="assets/media/img/volcanBanner.jpg" alt="Coatepeque" loading="lazy"></div>
        <div class="v-card-body">
          <span class="v-card-chip">746 msnm · Caldera</span>
          <h4>Lago de Coatepeque</h4>
          <p>Una caldera volcánica inundada, sin erupciones registradas en tiempos históricos y de <strong>aguas turquesa</strong>. Sus orillas con restaurantes, muelles y deportes acuáticos la convierten en el balneario favorito de la ruta.</p>
        </div>
      </div>
    </div>

    <div class="v-ruta">
      <h4>La Ruta de los Volcanes</h4>
      <p>Un recorrido por la Cordillera de Apaneca-Ilamatepec que conecta los volcanes Santa Ana, Izalco y Cerro Verde con el lago de Coatepeque, todos accesibles desde el mismo parque nacional en un solo día de excursión.</p>
    </div>
  </div>
</section>


<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<!-- GSAP -->
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>

<!-- Tu archivo JS -->
<script src="assets/js/volcanes.js"></script>

<?php
$content = ob_get_clean();
require_once 'layout.php';
?>