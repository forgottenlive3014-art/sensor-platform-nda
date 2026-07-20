<!DOCTYPE html>
<html lang="es" data-theme="<?= isset($_COOKIE['nda_theme']) && $_COOKIE['nda_theme'] === 'light' ? 'light' : 'dark' ?>">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<meta name="csrf-token" content="<?= csrfToken() ?>">
<title><?= $title ?? 'svNDA — Natural Disaster Alert' ?></title>
<script>
// Evita el flash del tema incorrecto antes de que cargue el CSS/JS.
(function(){
  try {
    var saved = localStorage.getItem('nda-theme');
    if (saved && saved !== document.documentElement.getAttribute('data-theme')) {
      document.documentElement.setAttribute('data-theme', saved);
    }
  } catch(e) {}
})();
</script>
<script>
// Carga perezosa de MapLibre GL JS, usada por el mapa 3D del home (terreno
// real de El Salvador) y por Three.js (globo + luna 3D). Viven aqui (no en
// app.js) porque hero-globe.js corre embebido en home.php antes de que
// app.js se cargue al final del body.
var MAPLIBRE_CSS = 'https://unpkg.com/maplibre-gl@4/dist/maplibre-gl.css';
var MAPLIBRE_JS = 'https://unpkg.com/maplibre-gl@4/dist/maplibre-gl.js';
var __ndaMapLibreLoading = null;
function ensureMapLibreLoaded() {
    if (window.maplibregl) return Promise.resolve();
    if (__ndaMapLibreLoading) return __ndaMapLibreLoading;
    __ndaMapLibreLoading = new Promise(function (resolve, reject) {
        var css = document.createElement('link');
        css.rel = 'stylesheet';
        css.href = MAPLIBRE_CSS;
        document.head.appendChild(css);

        var script = document.createElement('script');
        script.src = MAPLIBRE_JS;
        script.onload = function () { resolve(); };
        script.onerror = function () { reject(new Error('No se pudo cargar MapLibre GL JS')); };
        document.head.appendChild(script);
    });
    return __ndaMapLibreLoading;
}

var THREE_JS = 'https://unpkg.com/three@0.160.0/build/three.min.js';
var __ndaThreeLoading = null;
function ensureThreeLoaded() {
    if (window.THREE) return Promise.resolve();
    if (__ndaThreeLoading) return __ndaThreeLoading;
    __ndaThreeLoading = new Promise(function (resolve, reject) {
        var script = document.createElement('script');
        script.src = THREE_JS;
        script.onload = function () { resolve(); };
        script.onerror = function () { reject(new Error('No se pudo cargar Three.js')); };
        document.head.appendChild(script);
    });
    return __ndaThreeLoading;
}
</script>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@300;400;600;700;800;900&family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

<link rel="stylesheet" href="<?= asset('css/style.css') ?>">

<link rel="stylesheet" href="<?= asset('css/auth.css') ?>">

<!-- No redeclara --bg/--bg2/--bg3/--bg4, solo agrega estado y componentes nuevos -->
<link rel="stylesheet" href="<?= asset('css/nda-extensions.css') ?>">
</head>
<body>

<div class="seismic-particles" id="seismicParticles" aria-hidden="true"></div>


<?php
// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = isset($_SESSION['user_id']) && isset($_SESSION['user_name']);
$userName = $isLoggedIn ? $_SESSION['user_name'] : 'Usuario';
$userAvatar = $isLoggedIn ? strtoupper(substr($userName, 0, 1)) : '?';
// El nombre completo puede ser largo y romper el layout del navbar: se
// muestra el nombre de usuario corto, o el primer nombre como respaldo
// mientras la cuenta (vieja, o creada via Google) no tenga uno configurado.
$navDisplayName = $isLoggedIn
    ? (!empty($_SESSION['username']) ? $_SESSION['username'] : strtok($userName, ' '))
    : 'Usuario';
?>
<script>
    window.__ndaHasInstitution = <?= ($isLoggedIn && !empty($_SESSION['institucion_id']) && ($_SESSION['estado_institucional'] ?? '') === 'aprobado') ? 'true' : 'false' ?>;
</script>

<!-- Se llena via JS si hay una alerta de simulacro activa -->
<div class="drill-alert-banner" id="drillAlertBanner" style="display:none">
    <span id="drillAlertText">Simulacro en curso</span>
</div>

<nav class="nav" id="nav">
  <a class="nav-brand" href="?url=home">
    <div class="nda-logo-wave">
      <img src="assets/media/img/logo.png" alt="Logo NDA" style="height:40px; width:auto;">
      <span class="nda-logo-text">NDA</span>
    </div>
  </a>
  
  <div class="nav-links">
    <a href="?url=home">Inicio</a>
    <a href="?url=sismos">Sismos</a>
    <a href="?url=monitoreo">Monitoreo</a>
    <a href="?url=blog">Blog</a>
    <a href="?url=juegos">Juegos</a>
    <?php
        // Debe coincidir con SchoolController::canAccessSchool().
        $__navUser = currentUser();
        $__schoolEligibleRoles = ['director', 'docente', 'alumno', 'padre', 'administrativo'];
        $__canSeeSchoolLink = $__navUser && (
            $__navUser['role'] === 'admin'
            || (in_array($__navUser['role'], $__schoolEligibleRoles, true) && $__navUser['estado_institucional'] === 'aprobado')
        );
    ?>
    <?php if ($__canSeeSchoolLink): ?>
    <a href="?url=school" class="nav-school-link">
      <?= $__navUser['role'] === 'admin' ? 'Panel de Administración' : 'Gestión Escolar' ?>
    </a>
    <?php endif; ?>
    <a href="?url=resources">Recursos</a>
    <a href="?url=quehacer">¿Qué hacer AHORA?</a>
    <a href="?url=Acercade">Acerca de NDA</a>
  </div>
  
  <div class="nav-right">
    <div class="nav-alert" id="navAlert">
      <span class="ad"></span>
      <span id="navAlertText">Sistema Activo</span>
    </div>
    <button class="theme-btn" id="themeBtn" title="Cambiar tema" aria-label="Cambiar tema claro/oscuro">
      <svg id="themeIcoMoon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
    </button>
    <button class="lang-btn" id="langBtn" title="Switch language / Cambiar idioma" aria-label="Cambiar idioma">
      <span id="langBtnLabel">EN</span>
    </button>

    <div style="position:relative;">
      <button class="nda-notif-btn" id="ndaNotifBtn" title="Notificaciones" aria-label="Ver notificaciones">
        <span class="nda-notif-dot" id="ndaNotifDot"></span>
      </button>
      <div class="nda-notif-panel nda-glass" id="ndaNotifPanel">
        <div class="nda-notif-tabs">
          <button class="nda-notif-tab active" id="ndaNotifTabRecent" onclick="ndaShowNotifTab('recent')">Recientes</button>
          <button class="nda-notif-tab" id="ndaNotifTabInbox" onclick="ndaShowNotifTab('inbox')">Historial</button>
        </div>
        <div id="ndaNotifList"><div class="nda-notif-empty">Cargando…</div></div>
        <div id="ndaNotifInboxList" style="display:none;"></div>
        <div class="nda-notif-pagination" id="ndaNotifPagination" style="display:none;"></div>
      </div>
    </div>
    
    <?php if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])): ?>
      <div class="nav-user-menu" id="navUserMenu" style="display:flex">
        <div class="nav-user" id="navUserBadge" style="cursor:pointer" onclick="toggleUserDD()">
          <div class="nav-avatar" id="navAvatar">
            <?= strtoupper(substr($_SESSION['user_name'], 0, 1)) ?>
          </div>
          <span id="navUserName"><?= htmlspecialchars($navDisplayName) ?></span>
          <span style="font-size:.6rem;color:var(--text3)">▾</span>
        </div>
        <div class="nav-user-dd" id="navUserDD">
          <?php if ($__canSeeSchoolLink): ?>
          <a class="nud-item" href="?url=school">
            Módulo Colegio
          </a>
          <?php endif; ?>
          <a class="nud-item" href="?url=profile">
            Mi Perfil
          </a>
          <div class="nud-item danger" onclick="logout()">
            Cerrar sesión
          </div>
        </div>
      </div>

      <div id="navAuthBtns" style="display:none">
        <a href="?url=login" class="btn-out" style="padding:6px 14px;font-size:.76rem;text-decoration:none;">Iniciar sesión</a>
        <a href="?url=register" class="btn-acc" style="padding:6px 14px;font-size:.76rem;text-decoration:none;">Registrarse</a>
      </div>
      
    <?php else: ?>
      <div id="navAuthBtns" style="display:flex;gap:6px">
        <a href="?url=login" class="btn-out" style="padding:6px 14px;font-size:.76rem;text-decoration:none;">Iniciar sesión</a>
        <a href="?url=register" class="btn-acc" style="padding:6px 14px;font-size:.76rem;text-decoration:none;">Registrarse</a>
      </div>

      <div class="nav-user-menu" id="navUserMenu" style="display:none">
        <div class="nav-user" id="navUserBadge" style="cursor:pointer" onclick="toggleUserDD()">
          <div class="nav-avatar" id="navAvatar">?</div>
          <span id="navUserName">Usuario</span>
          <span style="font-size:.6rem;color:var(--text3)">▾</span>
        </div>
        <div class="nav-user-dd" id="navUserDD">
          <?php if ($__canSeeSchoolLink): ?>
          <a class="nud-item" href="?url=school">
            Módulo Colegio
          </a>
          <?php endif; ?>
          <a class="nud-item" href="?url=profile">
            Mi Perfil
          </a>
          <div class="nud-item danger" onclick="logout()">
            Cerrar sesión
          </div>
        </div>
      </div>
    <?php endif; ?>
    
    <button class="nav-ham" id="hamBtn">
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>

<?= $content ?? '' ?>

<footer class="footer">
  <div class="wrap">
    <div class="ft-inner">
      <div class="ftb">
        <div class="nav-brand">
          <div class="nda-logo-wave">
            <svg width="42" height="18" viewBox="0 0 50 22" fill="none">
              <polyline points="1,11 5,11 7,3 9,19 11,8 13,14 15,11 19,11" stroke="#ff5500" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"/>
              <line x1="19" y1="11" x2="22" y2="11" stroke="#ff7700" stroke-width="1.9" stroke-linecap="round"/>
              <line x1="24" y1="11" x2="30" y2="11" stroke="#ff9200" stroke-width="1.4" stroke-linecap="round"/>
              <polyline points="30,11 33,6 36,11" stroke="#ff9200" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
              <line x1="37" y1="11" x2="42" y2="11" stroke="#ff9200" stroke-width="1.4" stroke-linecap="round"/>
            </svg>
          </div>
          <span class="nda-logo-text">NDA</span>
        </div>
        <p>Natural Disaster Alert — Plataforma educativa para la comunidad escolar de El Salvador. Datos en tiempo real y simulaciones interactivas.</p>
      </div>
      <div class="ftc"><h5>Secciones</h5><a href="?url=sismos">Monitor Sísmico</a><a href="?url=home#placas">Placas Tectónicas</a><a href="?url=home#timeline">Historia</a><a href="?url=monitoreo#luna">Fases Lunares</a><a href="?url=home#zona-sismica">Mapa de Peligros</a><a href="?url=quehacer">¿Qué hacer AHORA?</a></div>
      <div class="ftc"><h5>Fuentes</h5><a href="https://earthquake.usgs.gov" target="_blank">USGS Earthquakes</a><a href="https://www.marn.gob.sv" target="_blank">MARN El Salvador</a><a href="https://api.open-meteo.com" target="_blank">Open-Meteo API</a><a href="https://api.sunrise-sunset.org" target="_blank">Sunrise-Sunset API</a></div>
    </div>
    <div class="ft-btm"><p>© 2025 svNDA — Natural Disaster Alert · Proyecto educativo El Salvador · Datos USGS · Solo fines educativos</p></div>
  </div>
</footer>

<button class="scroll-top" id="scrollTop"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><line x1="12" y1="19" x2="12" y2="5"/><polyline points="5 12 12 5 19 12"/></svg></button>

<?php if (!empty($__canSeeSchoolLink)): ?>
<?php
    // Director/docente si tienen Panel de Gestión propio; el resto de
    // roles (admin, alumno, padre, administrativo) solo tiene la Página
    // Principal — mismo criterio que el enlace de la barra de navegación.
    $__schoolFabUrl = in_array($__navUser['role'], ['director', 'docente'], true) ? 'school/panel' : 'school';
    $__schoolFabLabel = $__navUser['role'] === 'admin' ? 'Panel de Administración' : ($__schoolFabUrl === 'school/panel' ? 'Panel de Gestión Escolar' : 'Gestión Escolar');
?>
<!-- Acceso rápido a Gestión Escolar, junto al chatbot (solo si el rol tiene acceso) -->
<a href="?url=<?= e($__schoolFabUrl) ?>" class="school-fab" id="schoolFab" aria-label="Ir a <?= e($__schoolFabLabel) ?>" title="<?= e($__schoolFabLabel) ?>">
  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 4h9l5 5v11a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"/><path d="M9 12h6M9 16h6"/></svg>
</a>
<?php endif; ?>

<!-- Chatbot, disponible en todo el sitio -->
<div class="ndabot" id="ndabot">
  <button class="ndabot-fab" id="ndabotFab" aria-label="Abrir chat de ayuda">
    <img src="assets/media/img/chatbot.png" alt="Asistente NDA">
    <span class="ndabot-fab-dot"></span>
  </button>

  <div class="ndabot-panel" id="ndabotPanel">
    <div class="ndabot-head">
      <img src="assets/media/img/chatbot.png" alt="">
      <div>
        <strong>Asistente NDA</strong>
        <span>Pregúntame o pide que te lleve a una sección</span>
      </div>
      <button class="ndabot-close" id="ndabotClose" aria-label="Cerrar chat">
        &times;
      </button>
    </div>

    <div class="ndabot-messages" id="ndabotMessages"></div>

    <div class="ndabot-suggestions" id="ndabotSuggestions">
      <button data-q="¿Qué hacer durante un sismo?">¿Qué hacer durante un sismo?</button>
      <button data-q="Llévame a Gestión Escolar">Gestión Escolar</button>
      <button data-q="Muéstrame el clima">Clima ahora</button>
      <button data-q="Quiero registrarme">Registrarme</button>
    </div>

    <form class="ndabot-input" id="ndabotForm">
      <input type="text" id="ndabotInput" placeholder="Escribe tu pregunta..." autocomplete="off">
      <button type="submit" aria-label="Enviar">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
      </button>
    </form>
    <button class="ndabot-clear" id="ndabotClear">Borrar historial</button>
  </div>
</div>

<!-- Traductor ES/EN -->
<div id="google_translate_element" style="display:none"></div>
<script>
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({ pageLanguage: 'es', includedLanguages: 'en', autoDisplay: false }, 'google_translate_element');
    }
</script>
<script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>


<script src="<?= asset('js/app.js') ?>"></script>
<?php if (isset($_SESSION['success']) || isset($_SESSION['error'])): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    <?php if (isset($_SESSION['success'])): ?>
    if (typeof ndaAlert === 'function') ndaAlert(<?= json_encode($_SESSION['success']) ?>, 'success');
    <?php unset($_SESSION['success']); endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
    if (typeof ndaAlert === 'function') ndaAlert(<?= json_encode($_SESSION['error']) ?>, 'error');
    <?php unset($_SESSION['error']); endif; ?>
});
</script>
<?php endif; ?>
<script src="<?= asset('js/moon3d.js') ?>"></script>
<script src="<?= asset('js/auth.js') ?>"></script>
<script src="<?= asset('js/chatbot.js') ?>"></script>
<script src="<?= asset('js/notifications.js') ?>"></script>
<script src="<?= asset('js/translate.js') ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
<script src="<?= asset('js/gsap-animations.js') ?>"></script>

</body>
</html>