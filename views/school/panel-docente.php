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

    <?php include __DIR__ . '/partials/_header.php'; ?>

    <div class="school-panel-header" style="padding:0 0 10px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px;">
        <a href="?url=school" class="school-btn secondary">
            Volver a la Página Principal
        </a>
        <label class="school-btn secondary" style="cursor:pointer;">
            Subir foto de perfil
            <input type="file" accept="image/*" style="display:none" onchange="uploadTeacherPhoto(this)">
        </label>
    </div>

    <div class="school-body">
    <div class="school-tabs school-sidebar">
        <button class="school-tab active" data-tab="dashboard" onclick="showSchoolTab('dashboard')">
            Dashboard
        </button>
        <button class="school-tab" data-tab="sections" onclick="showSchoolTab('sections')">
            Mis Secciones
        </button>
        <button class="school-tab" data-tab="students" onclick="showSchoolTab('students')">
            Estudiantes
        </button>
        <button class="school-tab" data-tab="attendance" onclick="showSchoolTab('attendance')">
            Pase de Lista
        </button>
        <button class="school-tab" data-tab="teacher-notify" onclick="showSchoolTab('teacher-notify')">
            Notificar a mis estudiantes
        </button>
        <button class="school-tab" data-tab="routes" onclick="showSchoolTab('routes')">
            Rutas
        </button>
        <button class="school-tab" data-tab="croquis" onclick="showSchoolTab('croquis')">
            Croquis
        </button>
    </div>

    <div class="school-content">
        <?php include __DIR__ . '/partials/_tab-dashboard.php'; ?>
        <?php include __DIR__ . '/partials/_tab-sections.php'; ?>
        <?php include __DIR__ . '/partials/_tab-students.php'; ?>
        <?php include __DIR__ . '/partials/_tab-attendance.php'; ?>
        <?php include __DIR__ . '/partials/_tab-teacher-notify.php'; ?>
        <?php include __DIR__ . '/partials/_tab-routes.php'; ?>
        <?php include __DIR__ . '/partials/_tab-croquis.php'; ?>
    </div>
    </div><!-- /.school-body -->
</div>

<?php include __DIR__ . '/partials/_modals.php'; ?>

<script>
    window.__ndaIsSchoolStaff = <?= !empty($isSchoolStaff) ? 'true' : 'false' ?>;
    window.__ndaMyUserId = <?= json_encode($user['id'] ?? null) ?>;
    window.__ndaIsSchoolAdmin = <?= !empty($isSchoolAdmin) ? 'true' : 'false' ?>;
</script>
<script src="<?= asset('js/school.js') ?>"></script>

<?php
$content = ob_get_clean();
require_once 'views/layout.php';
?>
