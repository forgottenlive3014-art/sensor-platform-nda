

<?php
// Dock flotante NDA: Monitor Sismico + Colegio + Panel/Gestion Escolar +
// Asistente NDA, unificados en un solo componente glassmorphism (ver
// .nda-dock en style.css). $__canSeeSchoolLink ya viene calculado en layout.php.
$__dockUrl = $_GET['url'] ?? 'home';
$__dockArduinoActive = ($__dockUrl === 'arduino');
$__dockSchoolActive = ($__dockUrl === 'school');
$__dockPanelActive = ($__dockUrl === 'school/panel');
?>
<div class="nda-dock" id="ndaDock">
  <a href="?url=arduino" class="dock-btn dock-orange<?= $__dockArduinoActive ? ' active' : '' ?>" aria-label="Monitor Sísmico">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12h4l2 8 4-16 3 12 2-4h5"/></svg>
    <span class="dock-dot" id="monbotFabDot"></span>
    <span class="dock-tip" aria-hidden="true">Monitor Sísmico</span>
  </a>

  <?php if ($__canSeeSchoolLink): ?>
  <a href="?url=school" class="dock-btn dock-blue<?= $__dockSchoolActive ? ' active' : '' ?>" aria-label="Colegio">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M22 10 12 5 2 10l10 5 10-5Z"/>
      <path d="M6 12v5c0 1 3 3 6 3s6-2 6-3v-5"/>
    </svg>
    <span class="dock-tip" aria-hidden="true">Colegio</span>
  </a>

  <?php if ($__canSeePanelLink): ?>
  <a href="?url=school/panel" class="dock-btn dock-blue<?= $__dockPanelActive ? ' active' : '' ?>" aria-label="Panel de Gestión Escolar">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/>
    </svg>
    <span class="dock-tip" aria-hidden="true">Panel de Gestión</span>
  </a>
  <?php endif; ?>
  <?php endif; ?>

  <button type="button" class="dock-btn dock-orange dock-btn-chat" id="ndabotFab" aria-label="Abrir chat de ayuda">
    <span class="dock-btn-chat-img"><img src="assets/media/img/chatbot.png" alt="Asistente NDA"></span>
    <span class="dock-dot live"></span>
    <span class="dock-tip" aria-hidden="true">Asistente NDA</span>
  </button>
</div>

<!-- Burbuja de "dato curioso": vive fuera del panel de chat, aparece junto
     al dock cada cierto tiempo (variable) mostrando un dato distinto. -->
<div class="nda-fact-bubble" id="ndaFactBubble" role="status" aria-live="polite">
  <button type="button" class="nda-fact-bubble-close" id="ndaFactBubbleClose" aria-label="Cerrar dato curioso">&times;</button>
  <span class="nda-fact-bubble-label">Dato curioso</span>
  <p id="ndaFactBubbleText"></p>
</div>

<!-- Panel del chatbot: se abre flotando justo encima del dock -->
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
