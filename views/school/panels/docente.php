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

    <?php include __DIR__ . '/../partials/_header.php'; ?>

    <div class="school-panel-header" style="padding:0 0 10px;">
        <label class="school-btn secondary" style="cursor:pointer;">
            <span class="school-emoji" aria-hidden="true">📷</span> Subir foto de perfil
            <input type="file" accept="image/*" style="display:none" onchange="uploadTeacherPhoto(this)">
        </label>
    </div>

    <!-- ==================== TABS (sidebar) ==================== -->
    <div class="school-body">
    <div class="school-tabs school-sidebar">
        <button class="school-tab active" data-tab="dashboard" onclick="showSchoolTab('dashboard')">
            <span class="school-emoji" aria-hidden="true">🧭</span> Dashboard
        </button>
        <button class="school-tab" data-tab="sections" onclick="showSchoolTab('sections')">
            <span class="school-emoji" aria-hidden="true">🧩</span> Mis Secciones
        </button>
        <button class="school-tab" data-tab="students" onclick="showSchoolTab('students')">
            <span class="school-emoji" aria-hidden="true">🎒</span> Alumnos
        </button>
        <button class="school-tab" data-tab="attendance" onclick="showSchoolTab('attendance')">
            <span class="school-emoji" aria-hidden="true">🖊️</span> Pase de Lista
        </button>
        <button class="school-tab" data-tab="incidents" onclick="showSchoolTab('incidents')">
            <span class="school-emoji" aria-hidden="true">🧯</span> Incidentes / Daños
        </button>
        <button class="school-tab" data-tab="drills" onclick="showSchoolTab('drills')">
            <span class="school-emoji" aria-hidden="true">🔔</span> Simulacros
        </button>
        <button class="school-tab" data-tab="routes" onclick="showSchoolTab('routes')">
            <span class="school-emoji" aria-hidden="true">🚸</span> Rutas
        </button>
        <button class="school-tab" data-tab="croquis" onclick="showSchoolTab('croquis')">
            <span class="school-emoji" aria-hidden="true">📐</span> Croquis
        </button>
        <button class="school-tab" data-tab="board" onclick="showSchoolTab('board')">
            <span class="school-emoji" aria-hidden="true">📌</span> Corcho
        </button>
        <button class="school-tab" data-tab="reports" onclick="showSchoolTab('reports')">
            <span class="school-emoji" aria-hidden="true">🗂️</span> Reportes
        </button>
        <button class="school-tab" data-tab="news" onclick="showSchoolTab('news')">
            <span class="school-emoji" aria-hidden="true">📰</span> Noticias
        </button>
        <button class="school-tab" data-tab="blog" onclick="showSchoolTab('blog')">
            <span class="school-emoji" aria-hidden="true">📍</span> Lugares en riesgo
        </button>
    </div>

    <!-- ==================== CONTENIDO ==================== -->
    <div class="school-content">
        <?php include __DIR__ . '/../partials/_tab-dashboard.php'; ?>
        <?php include __DIR__ . '/../partials/_tab-news.php'; ?>
        <?php include __DIR__ . '/../partials/_tab-blog.php'; ?>
        <?php include __DIR__ . '/../partials/_tab-sections.php'; ?>
        <?php include __DIR__ . '/../partials/_tab-students.php'; ?>
        <?php include __DIR__ . '/../partials/_tab-attendance.php'; ?>
        <?php include __DIR__ . '/../partials/_tab-incidents.php'; ?>
        <?php include __DIR__ . '/../partials/_tab-drills.php'; ?>
        <?php include __DIR__ . '/../partials/_tab-routes.php'; ?>
        <?php include __DIR__ . '/../partials/_tab-croquis.php'; ?>
        <?php include __DIR__ . '/../partials/_tab-board.php'; ?>
        <?php include __DIR__ . '/../partials/_tab-reports.php'; ?>
    </div>
    </div><!-- /.school-body -->
</div>

<?php include __DIR__ . '/../partials/_modals.php'; ?>

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
