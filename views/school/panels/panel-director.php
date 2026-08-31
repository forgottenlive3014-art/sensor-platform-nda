<?php
$title = $title ?? 'Panel de Gestión';
$user = $user ?? null;
$stats = $stats ?? [];
$students = $students ?? [];
$drills = $drills ?? [];
$routes = $routes ?? [];
$incidents = $incidents ?? [];
$isSchoolAdmin = $isSchoolAdmin ?? false;
$isSchoolStaff = $isSchoolStaff ?? false;
$pendingRequestsCount = $pendingRequestsCount ?? 0;
$isReadOnlyView = $isReadOnlyView ?? false;
$viewingInstitucionNombre = $viewingInstitucionNombre ?? null;
ob_start();
?>
<link rel="stylesheet" href="<?= asset('css/school.css') ?>">

<div class="school-module">

    <?php if ($isReadOnlyView): ?>
    <div class="school-readonly-banner">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>
        <span>Estás viendo el panel de <strong><?= e($viewingInstitucionNombre ?? 'esta institución') ?></strong> como Admin General — modo solo lectura, sin poder crear, editar ni borrar nada.</span>
        <a href="?url=school" class="school-btn secondary">Ver página general</a>
        <a href="?url=school/exit-view" class="school-btn secondary">Salir y volver a Instituciones</a>
    </div>
    <?php endif; ?>

    <div class="school-main">
        <div class="school-content-greeting" id="schoolGreeting">
            <div class="school-greeting-mascot" aria-hidden="true">
                <img src="<?= asset('media/img/chatbot.png') ?>" alt="">
            </div>
            <div class="school-greeting-text">
                <p class="school-eyebrow"><?= e($panelTitle ?? 'Gestión Escolar') ?></p>
                <h2><span id="schoolGreetingWord">Hola</span>, <?= e(explode(' ', trim($user['nombre'] ?? 'Usuario'))[0]) ?></h2>
                <p class="school-header-sub"><?= e($panelSubtitle ?? 'Administra estudiantes, docentes, rutas de evacuación, simulacros y más') ?></p>
            </div>
        </div>

        <div class="school-content school-content-bnav-pad">
            <?php include __DIR__ . '/../partials/tabTablero.php'; ?>
            <?php include __DIR__ . '/../partials/tabUsuarios.php'; ?>
            <?php include __DIR__ . '/../partials/tabNotificaciones.php'; ?>
            <?php include __DIR__ . '/../partials/tabEstudiantes.php'; ?>
            <?php include __DIR__ . '/../partials/tabDocentes.php'; ?>
            <?php include __DIR__ . '/../partials/tabPadres.php'; ?>
            <?php include __DIR__ . '/../partials/tabPersonal.php'; ?>
            <?php include __DIR__ . '/../partials/tabAulas.php'; ?>
            <?php include __DIR__ . '/../partials/tabRutas.php'; ?>
            <?php include __DIR__ . '/../partials/tabPaseDeLista.php'; ?>
            <?php include __DIR__ . '/../partials/tabSimulacros.php'; ?>
            <?php include __DIR__ . '/../partials/tabReportes.php'; ?>
            <?php include __DIR__ . '/../partials/tabCroquis.php'; ?>
            <?php include __DIR__ . '/../partials/tabSolicitudes.php'; ?>
        </div>
    </div>

    <!-- Dock de navegación del panel, abajo a la izquierda, mismo estilo
         que el dock del sitio (Monitor Sísmico / Colegio / Panel / Chat) —
         solo lo más usado, sin nombres fijos (tooltip al pasar el mouse). -->
    <nav class="school-bnav" id="schoolBnav">
        <div class="school-bnav-item">
            <button class="dock-btn dock-blue school-bnav-btn" data-tab="users" onclick="showSchoolTab('users')" aria-label="Usuarios">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                <span class="dock-tip" aria-hidden="true">Usuarios</span>
            </button>
        </div>

        <div class="school-bnav-item">
            <button class="dock-btn dock-blue school-bnav-btn" data-tab="requests" onclick="showSchoolTab('requests')" aria-label="Solicitudes">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-6l-2 3h-4l-2-3H2"/><path d="M5.45 5.11 2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg>
                <?php if (!empty($pendingRequestsCount)): ?>
                    <span class="school-bnav-badge"><?= (int)$pendingRequestsCount ?></span>
                <?php endif; ?>
                <span class="dock-tip" aria-hidden="true">Solicitudes</span>
            </button>
        </div>

        <div class="school-bnav-item">
            <button class="dock-btn dock-blue school-bnav-btn" data-tab="classrooms" onclick="showSchoolTab('classrooms')" aria-label="Aulas">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                <span class="dock-tip" aria-hidden="true">Aulas</span>
            </button>
            <div class="school-bnav-popover">
                <div class="school-bnav-sub-wrap">
                    <button class="school-bnav-sub" data-tab="attendance" onclick="showSchoolTab('attendance')" aria-label="Pase de Lista">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                    </button>
                    <span class="school-bnav-sub-label">Pase de Lista</span>
                </div>
            </div>
        </div>

        <div class="school-bnav-item school-bnav-item-main">
            <button class="dock-btn dock-orange school-bnav-btn school-bnav-btn-main active" data-tab="dashboard" onclick="showSchoolTab('dashboard')" aria-label="Tablero">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/></svg>
                <span class="dock-tip" aria-hidden="true">Tablero</span>
            </button>
            <div class="school-bnav-popover">
                <div class="school-bnav-sub-wrap">
                    <button class="school-bnav-sub" data-tab="reports" onclick="showSchoolTab('reports')" aria-label="Reportes">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="20" x2="12" y2="10"/><line x1="18" y1="20" x2="18" y2="4"/><line x1="6" y1="20" x2="6" y2="16"/></svg>
                    </button>
                    <span class="school-bnav-sub-label">Reportes</span>
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
            <button class="dock-btn dock-blue school-bnav-btn" data-tab="croquis" onclick="showSchoolTab('croquis')" aria-label="Croquis">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="1,6 8,3 16,6 23,3 23,18 16,21 8,18 1,21"/><line x1="8" y1="3" x2="8" y2="18"/><line x1="16" y1="6" x2="16" y2="21"/></svg>
                <span class="dock-tip" aria-hidden="true">Croquis</span>
            </button>
        </div>

        <div class="school-bnav-item">
            <button class="dock-btn dock-blue school-bnav-btn" data-tab="routes" onclick="showSchoolTab('routes')" aria-label="Rutas de Evacuación">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                <span class="dock-tip" aria-hidden="true">Rutas de Evacuación</span>
            </button>
        </div>

        <div class="school-bnav-item">
            <button class="dock-btn dock-blue school-bnav-btn" data-tab="drills" onclick="showSchoolTab('drills')" aria-label="Simulacros">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                <span class="dock-tip" aria-hidden="true">Simulacros</span>
            </button>
        </div>
    </nav>
</div>

<?php include __DIR__ . '/../partials/_modals.php'; ?>

<script>
    window.__ndaIsSchoolStaff = <?= !empty($isSchoolStaff) ? 'true' : 'false' ?>;
    window.__ndaMyUserId = <?= json_encode($user['id'] ?? null) ?>;
    window.__ndaIsSchoolAdmin = <?= !empty($isSchoolAdmin) ? 'true' : 'false' ?>;
    window.__ndaIsGlobalAdmin = false;
    window.__ndaMyInstitutionId = <?= json_encode($user['institucion_id'] ?? null) ?>;
</script>
<script src="<?= asset('js/school.js') ?>"></script>

<?php
$content = ob_get_clean();
require_once 'views/layout.php';
?>
