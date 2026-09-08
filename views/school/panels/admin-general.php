<?php
$title = $title ?? 'Gestión Escolar';
$user = $user ?? null;
$stats = $stats ?? [];
$students = $students ?? [];
$drills = $drills ?? [];
$routes = $routes ?? [];
$incidents = $incidents ?? [];
$isSchoolAdmin = $isSchoolAdmin ?? false;
$isSchoolStaff = $isSchoolStaff ?? false;
ob_start();
?>
<link rel="stylesheet" href="<?= asset('css/school.css') ?>">

<div class="school-module">

    <div class="school-main">
        <?php include __DIR__ . '/../partials/_header.php'; ?>

        <div class="school-content school-content-bnav-pad">
            <?php include __DIR__ . '/../partials/tabTablero.php'; ?>
            <?php include __DIR__ . '/../partials/tabInstituciones.php'; ?>
            <?php include __DIR__ . '/../partials/tabUsuarios.php'; ?>
            <?php include __DIR__ . '/../partials/tabNoticias.php'; ?>
            <?php include __DIR__ . '/../partials/tabNotificaciones.php'; ?>
            <?php include __DIR__ . '/../partials/tabReportes.php'; ?>
            <?php include __DIR__ . '/../partials/tabArticulos.php'; ?>
            <?php include __DIR__ . '/../partials/tabRecursos.php'; ?>
            <?php include __DIR__ . '/../partials/tabQueHacerContenido.php'; ?>
            <?php include __DIR__ . '/../partials/tabAcercaDeContenido.php'; ?>
        </div>
    </div>

    <!-- Dock de navegación del panel, mismo estilo que panel-director.php
         (barra flotante abajo, icono central naranja = Tablero, con
         popover para Reportes/Notificaciones igual que en ese panel). -->
    <nav class="school-bnav" id="schoolBnav">
        <div class="school-bnav-item">
            <button class="dock-btn dock-blue school-bnav-btn" data-tab="institutions" onclick="showSchoolTab('institutions')" aria-label="Instituciones">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                <span class="dock-tip" aria-hidden="true">Instituciones</span>
            </button>
        </div>

        <div class="school-bnav-item">
            <button class="dock-btn dock-blue school-bnav-btn" data-tab="users" onclick="showSchoolTab('users')" aria-label="Usuarios">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                <span class="dock-tip" aria-hidden="true">Usuarios</span>
            </button>
        </div>

        <div class="school-bnav-item">
            <button class="dock-btn dock-blue school-bnav-btn" data-tab="news" onclick="showSchoolTab('news')" aria-label="Noticias">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                <span class="dock-tip" aria-hidden="true">Noticias</span>
            </button>
        </div>

        <div class="school-bnav-item">
            <button class="dock-btn dock-blue school-bnav-btn" data-tab="articulos" onclick="showSchoolTab('articulos')" aria-label="Blog público">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                <span class="dock-tip" aria-hidden="true">Blog público</span>
            </button>
        </div>

        <div class="school-bnav-item school-bnav-item-main">
            <button class="dock-btn dock-orange school-bnav-btn school-bnav-btn-main active" data-tab="dashboard" onclick="showSchoolTab('dashboard')" aria-label="Tablero">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/></svg>
                <span class="dock-tip" aria-hidden="true">Tablero</span>
            </button>
            <div class="school-bnav-popover">
                <div class="school-bnav-sub-wrap">
                    <button class="school-bnav-sub" data-tab="reports" onclick="showSchoolTab('reports')" aria-label="Reportes globales">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="20" x2="12" y2="10"/><line x1="18" y1="20" x2="18" y2="4"/><line x1="6" y1="20" x2="6" y2="16"/></svg>
                    </button>
                    <span class="school-bnav-sub-label">Reportes globales</span>
                </div>
                <div class="school-bnav-sub-wrap">
                    <button class="school-bnav-sub" data-tab="notifications" onclick="showSchoolTab('notifications')" aria-label="Notificaciones">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.7 21a2 2 0 0 1-3.4 0"/></svg>
                    </button>
                    <span class="school-bnav-sub-label">Notificaciones</span>
                </div>
            </div>
        </div>

        <div class="school-bnav-item">
            <button class="dock-btn dock-blue school-bnav-btn" data-tab="recursos" onclick="showSchoolTab('recursos')" aria-label="Recursos PDF">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                <span class="dock-tip" aria-hidden="true">Recursos PDF</span>
            </button>
        </div>

        <div class="school-bnav-item">
            <button class="dock-btn dock-blue school-bnav-btn" data-tab="quehacer-content" onclick="showSchoolTab('quehacer-content')" aria-label="¿Qué hacer ahora?">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="4"/><line x1="4.93" y1="4.93" x2="9.17" y2="9.17"/><line x1="19.07" y1="19.07" x2="14.83" y2="14.83"/><line x1="14.83" y1="9.17" x2="19.07" y2="4.93"/><line x1="4.93" y1="19.07" x2="9.17" y2="14.83"/></svg>
                <span class="dock-tip" aria-hidden="true">¿Qué hacer ahora?</span>
            </button>
        </div>

        <div class="school-bnav-item">
            <button class="dock-btn dock-blue school-bnav-btn" data-tab="acercade-content" onclick="showSchoolTab('acercade-content')" aria-label="Acerca de NDA">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                <span class="dock-tip" aria-hidden="true">Acerca de NDA</span>
            </button>
        </div>
    </nav>
</div>

<script>
    window.__ndaIsSchoolStaff = <?= !empty($isSchoolStaff) ? 'true' : 'false' ?>;
    window.__ndaMyUserId = <?= json_encode($user['id'] ?? null) ?>;
    window.__ndaIsSchoolAdmin = <?= !empty($isSchoolAdmin) ? 'true' : 'false' ?>;
    window.__ndaIsGlobalAdmin = true;
    window.__ndaMyInstitutionId = null;
</script>
<script src="<?= asset('js/school.js') ?>"></script>

<?php
$content = ob_get_clean();
require_once 'views/layout.php';
?>
