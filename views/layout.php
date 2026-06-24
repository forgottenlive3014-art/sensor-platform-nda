<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<title><?= $title ?? 'svNDA — Natural Disaster Alert' ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@300;400;600;700;900&family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

<link rel="stylesheet" href="assets/css/style.css">

<link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>

<!-- FLOATING SEISMIC PARTICLES -->
<div class="seismic-particles" id="seismicParticles" aria-hidden="true"></div>


<?php
// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = isset($_SESSION['user_id']) && isset($_SESSION['user_name']);
$userName = $isLoggedIn ? $_SESSION['user_name'] : 'Usuario';
$userAvatar = $isLoggedIn ? strtoupper(substr($userName, 0, 1)) : '?';
?>

<!-- NAVBAR -->
<nav class="nav" id="nav">
  <a class="nav-brand" href="?url=home">
    <div class="nda-logo-wave">
      <img src="assets/media/img/logo.png" alt="Logo NDA" style="height:40px; width:auto;">
      <span class="nda-logo-text">NDA</span>
    </div>
  </a>
  
  <div class="nav-links">
    <a href="?url=home">Inicio</a>
    <a href="?url=reportes">Sismos</a>
    <a href="?url=monitoreo">Monitoreo</a>
    <a href="?url=blog">Blog</a>
    <a href="?url=juegos">Juegos</a>
    <a href="?url=quehacer">¿Qué hacer AHORA?</a>
    <a href="?url=acercade">Acerca de NDA</a>
  </div>
  
  <div class="nav-right">
    <div class="nav-alert" id="navAlert">
      <span class="ad"></span>
      <span id="navAlertText">Sistema Activo</span>
    </div>
    <button class="theme-btn" id="themeBtn" title="Cambiar tema">
      <span id="themeIco">🌙</span>
    </button>
    
    <!-- ===== PHP SESSION AUTH ===== -->
    <?php if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])): ?>
      <!-- Usuario logueado - Mostrar menú -->
      <div class="nav-user-menu" id="navUserMenu" style="display:flex">
        <div class="nav-user" id="navUserBadge" style="cursor:pointer" onclick="toggleUserDD()">
          <div class="nav-avatar" id="navAvatar">
            <?= strtoupper(substr($_SESSION['user_name'], 0, 1)) ?>
          </div>
          <span id="navUserName"><?= htmlspecialchars($_SESSION['user_name']) ?></span>
          <span style="font-size:.6rem;color:var(--text3)">▾</span>
        </div>
        <div class="nav-user-dd" id="navUserDD">
          <div class="nud-item" onclick="openSchoolModule()">🏫 Módulo Colegio</div>
          <div class="nud-item" onclick="closeUserDD()">👤 Mi Perfil</div>
          <div class="nud-item danger" onclick="logout()">↩ Cerrar sesión</div>
        </div>
      </div>
      
      <!-- Ocultar botones de login/register -->
      <div id="navAuthBtns" style="display:none">
        <a href="?url=login" class="btn-out" style="padding:6px 14px;font-size:.76rem;text-decoration:none;">Iniciar sesión</a>
        <a href="?url=register" class="btn-acc" style="padding:6px 14px;font-size:.76rem;text-decoration:none;">Registrarse</a>
      </div>
      
    <?php else: ?>
      <!-- Usuario NO logueado - Mostrar botones -->
      <div id="navAuthBtns" style="display:flex;gap:6px">
        <a href="?url=login" class="btn-out" style="padding:6px 14px;font-size:.76rem;text-decoration:none;">Iniciar sesión</a>
        <a href="?url=register" class="btn-acc" style="padding:6px 14px;font-size:.76rem;text-decoration:none;">Registrarse</a>
      </div>
      
      <!-- Ocultar menú de usuario -->
      <div class="nav-user-menu" id="navUserMenu" style="display:none">
        <div class="nav-user" id="navUserBadge" style="cursor:pointer" onclick="toggleUserDD()">
          <div class="nav-avatar" id="navAvatar">?</div>
          <span id="navUserName">Usuario</span>
          <span style="font-size:.6rem;color:var(--text3)">▾</span>
        </div>
        <div class="nav-user-dd" id="navUserDD">
          <div class="nud-item" onclick="openSchoolModule()">🏫 Módulo Colegio</div>
          <div class="nud-item" onclick="closeUserDD()">👤 Mi Perfil</div>
          <div class="nud-item danger" onclick="logout()">↩ Cerrar sesión</div>
        </div>
      </div>
    <?php endif; ?>
    
    <button class="nav-ham" id="hamBtn">
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>

<!-- ========== CONTENIDO PRINCIPAL ========== -->
<?= $content ?? '' ?>

<!-- ========== FOOTER ========== -->
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
      <div class="ftc"><h5>Secciones</h5><a href="?url=home#sismos">Monitor Sísmico</a><a href="?url=home#placas">Placas Tectónicas</a><a href="?url=home#timeline">Historia</a><a href="?url=home#luna">Fases Lunares</a><a href="?url=home#mapa">Mapa de Peligros</a><a href="?url=home#ahora">¿Qué hacer AHORA?</a></div>
      <div class="ftc"><h5>Fuentes</h5><a href="https://earthquake.usgs.gov" target="_blank">USGS Earthquakes</a><a href="https://www.marn.gob.sv" target="_blank">MARN El Salvador</a><a href="https://api.open-meteo.com" target="_blank">Open-Meteo API</a><a href="https://api.sunrise-sunset.org" target="_blank">Sunrise-Sunset API</a></div>
    </div>
    <div class="ft-btm"><p>© 2025 svNDA — Natural Disaster Alert · Proyecto educativo El Salvador · Datos USGS · Solo fines educativos</p></div>
  </div>
</footer>

<button class="scroll-top" id="scrollTop">↑</button>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>


<script src="<?= asset('js/app.js') ?>"></script>
<script src="<?= asset('js/auth.js') ?>"></script>

</body>
</html>