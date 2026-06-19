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

<link rel="stylesheet" href="assets/css/style.css"></head>
<body>

<!-- FLOATING SEISMIC PARTICLES -->
<div class="seismic-particles" id="seismicParticles" aria-hidden="true"></div>

<!-- NAVBAR -->
<nav class="nav" id="nav">
  <a class="nav-brand" href="?url=home">
    <div class="nda-logo-wave">
      <a class="nav-brand" href="?url=home">
  <img src="assets/media/img/logo.png" alt="Logo NDA" style="height:40px; width:auto;">
  <span class="nda-logo-text">NDA</span>
</a>
  </a>
  <div class="nav-links">
    <a href="?url=home#sismos">Sismos</a>
    <a href="?url=home#placas">Placas</a>
    <a href="?url=home#timeline">Historia</a>
    <a href="?url=home#luna">Luna</a>
    <a href="?url=home#mapa">Mapa</a>
    <a href="?url=home#clima">Clima</a>
    <a href="?url=home#tsunamis">Tsunamis</a>
    <a href="?url=home#juegos">Juegos</a>
    <a href="?url=home#prevencion">Prevención</a>
    <a href="?url=home#ahora">¿Qué hacer?</a>
  </div>
  <div class="nav-right">
    <div class="nav-alert" id="navAlert"><span class="ad"></span><span id="navAlertText">Sistema Activo</span></div>
    <button class="theme-btn" id="themeBtn" title="Cambiar tema"><span id="themeIco">🌙</span></button>
    <div id="navAuthBtns" style="display:flex;gap:6px">
      <button class="btn-out" style="padding:6px 14px;font-size:.76rem" onclick="openAuth('login')">Iniciar sesión</button>
      <button class="btn-acc" style="padding:6px 14px;font-size:.76rem" onclick="openAuth('register')">Registrarse</button>
    </div>
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
    <button class="nav-ham" id="hamBtn"><span></span><span></span><span></span></button>
  </div>
</nav>
<div class="mob-nav" id="mobNav">
  <a href="?url=home#sismos">Sismos</a>
  <a href="?url=home#placas">Placas Tectónicas</a>
  <a href="?url=home#timeline">Historia</a>
  <a href="?url=home#luna">Fases Lunares</a>
  <a href="?url=home#mapa">Mapa de Peligros</a>
  <a href="?url=home#clima">Clima</a>
  <a href="?url=home#tsunamis">Tsunamis</a>
  <a href="?url=home#juegos">Juegos</a>
  <a href="?url=home#prevencion">Prevención</a>
  <a href="?url=home#arduino">Arduino</a>
  <a href="?url=home#ahora">¿Qué hacer AHORA?</a>
</div>

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

</body>
</html>