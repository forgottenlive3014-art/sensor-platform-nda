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
ob_start();
?>
<link rel="stylesheet" href="<?= asset('css/school.css') ?>">

<div class="school-module">

    <div class="school-main">
        <div class="school-content-greeting" id="schoolGreeting">
            <div class="school-greeting-mascot" aria-hidden="true">
                <img src="<?= asset('media/img/chatbot.png') ?>" alt="">
            </div>
            <div class="school-greeting-text">
                <p class="school-eyebrow"><?= e($panelTitle ?? 'Gestión Escolar') ?></p>
                <h2><span id="schoolGreetingWord">Hola</span>, <?= e(explode(' ', trim($user['nombre'] ?? 'Usuario'))[0]) ?></h2>
                <p class="school-header-sub"><?= e($panelSubtitle ?? 'Administra tus secciones, estudiantes, rutas de evacuación y más') ?></p>
            </div>
        </div>

        <div class="school-content school-content-bnav-pad">
            <?php include __DIR__ . '/../partials/tabTablero.php'; ?>
            <?php include __DIR__ . '/../partials/tabSecciones.php'; ?>
            <?php include __DIR__ . '/../partials/tabEstudiantes.php'; ?>
            <?php include __DIR__ . '/../partials/tabPaseDeLista.php'; ?>
            <?php include __DIR__ . '/../partials/tabNotificarEstudiantes.php'; ?>
            <?php include __DIR__ . '/../partials/tabRutas.php'; ?>
        </div>
    </div>

    <!-- Dock de navegación del panel, mismo diseño que el del director
         (school-bnav en school.css): Tablero elevado al centro, con
         Mis Secciones -> Pase de Lista como submenú (igual patrón que
         Aulas -> Pase de Lista en el panel del director). -->
    <nav class="school-bnav" id="schoolBnav">
        <div class="school-bnav-item">
            <button class="dock-btn dock-blue school-bnav-btn" data-tab="sections" onclick="showSchoolTab('sections')" aria-label="Mis Secciones">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                <span class="dock-tip" aria-hidden="true">Mis Secciones</span>
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

        <div class="school-bnav-item">
            <button class="dock-btn dock-blue school-bnav-btn" data-tab="students" onclick="showSchoolTab('students')" aria-label="Estudiantes">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                <span class="dock-tip" aria-hidden="true">Estudiantes</span>
            </button>
        </div>

        <div class="school-bnav-item school-bnav-item-main">
            <button class="dock-btn dock-orange school-bnav-btn school-bnav-btn-main active" data-tab="dashboard" onclick="showSchoolTab('dashboard')" aria-label="Tablero">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/></svg>
                <span class="dock-tip" aria-hidden="true">Tablero</span>
            </button>
        </div>

        <div class="school-bnav-item">
            <button class="dock-btn dock-blue school-bnav-btn" data-tab="teacher-notify" onclick="showSchoolTab('teacher-notify')" aria-label="Notificar a mis estudiantes">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.7 21a2 2 0 0 1-3.4 0"/></svg>
                <span class="dock-tip" aria-hidden="true">Notificar a mis estudiantes</span>
            </button>
        </div>

        <div class="school-bnav-item">
            <button class="dock-btn dock-blue school-bnav-btn" data-tab="routes" onclick="showSchoolTab('routes')" aria-label="Rutas de Evacuación">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                <span class="dock-tip" aria-hidden="true">Rutas de Evacuación</span>
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
