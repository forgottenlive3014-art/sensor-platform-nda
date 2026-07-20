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

    <div class="school-body">
    <div class="school-tabs school-sidebar">
        <button class="school-tab active" data-tab="dashboard" onclick="showSchoolTab('dashboard')">
            Dashboard global
        </button>
        <button class="school-tab" data-tab="institutions" onclick="showSchoolTab('institutions')">
            Instituciones
        </button>
        <button class="school-tab" data-tab="users" onclick="showSchoolTab('users')">
            Usuarios
        </button>
        <button class="school-tab" data-tab="news" onclick="showSchoolTab('news')">
            Noticias
        </button>
        <button class="school-tab" data-tab="notifications" onclick="showSchoolTab('notifications')">
            Notificaciones
        </button>
        <button class="school-tab" data-tab="reports" onclick="showSchoolTab('reports')">
            Reportes globales
        </button>
        <button class="school-tab" data-tab="articulos" onclick="showSchoolTab('articulos')">
            Blog público
        </button>
        <button class="school-tab" data-tab="recursos" onclick="showSchoolTab('recursos')">
            Recursos PDF
        </button>
        <button class="school-tab" data-tab="quehacer-content" onclick="showSchoolTab('quehacer-content')">
            Qué hacer ahora
        </button>
        <button class="school-tab" data-tab="acercade-content" onclick="showSchoolTab('acercade-content')">
            Acerca de NDA
        </button>
    </div>

    <div class="school-content">
        <?php include __DIR__ . '/../partials/_tab-dashboard.php'; ?>
        <?php include __DIR__ . '/../partials/_tab-institutions.php'; ?>
        <?php include __DIR__ . '/../partials/_tab-users.php'; ?>
        <?php include __DIR__ . '/../partials/_tab-news.php'; ?>
        <?php include __DIR__ . '/../partials/_tab-notifications.php'; ?>
        <?php include __DIR__ . '/../partials/_tab-reports.php'; ?>
        <?php include __DIR__ . '/../partials/_tab-articulos.php'; ?>
        <?php include __DIR__ . '/../partials/_tab-recursos.php'; ?>
        <?php include __DIR__ . '/../partials/_tab-quehacer-content.php'; ?>
        <?php include __DIR__ . '/../partials/_tab-acercade-content.php'; ?>
    </div>
    </div><!-- /.school-body -->
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
