<?php
$title = $title ?? 'Gestión Escolar';
$user = $user ?? null;
$institucion = $institucion ?? null;
$drills = $drills ?? [];
$routes = $routes ?? [];
$croquisPoints = $croquisPoints ?? [];
$isSchoolAdmin = $isSchoolAdmin ?? false;
$isSchoolStaff = $isSchoolStaff ?? false;
$isPanelRole = $isPanelRole ?? false;
$isReadOnlyView = $isReadOnlyView ?? false;
$role = $user['role'] ?? '';
ob_start();
?>
<link rel="stylesheet" href="<?= asset('css/school.css') ?>">

<div class="school-module school-scroll-page">

    <?php include __DIR__ . '/partials/_header.php'; ?>

    <?php if ($isReadOnlyView): ?>
    <div class="school-readonly-banner">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>
        <span>Estás viendo <strong><?= e($institucion['nombre'] ?? 'esta institución') ?></strong> como Admin General — modo solo lectura.</span>
        <a href="?url=school/panel" class="school-btn primary">Ver Panel completo</a>
        <a href="?url=school/exit-view" class="school-btn secondary">Salir</a>
    </div>
    <?php elseif ($isPanelRole): ?>
    <div class="school-panel-header" style="padding:0 0 10px;">
        <a href="?url=school/panel" class="school-btn primary">
            Ir al Panel de Gestión
        </a>
    </div>
    <?php endif; ?>

    <nav class="school-scroll-nav">
        <a href="#tab-inicio">Inicio</a>
        <a href="#tab-croquis">Croquis</a>
        <a href="#tab-news">Noticias</a>
        <a href="#tab-blog">Lugares en riesgo</a>
        <a href="#tab-incidents">Incidentes</a>
        <a href="#tab-board">Corcho</a>
        <?php if ($role === 'alumno'): ?>
        <a href="#tab-my-classroom">Mi Aula</a>
        <?php endif; ?>
        <?php if ($role === 'padre'): ?>
        <a href="#tab-my-children">Mis Hijos</a>
        <?php endif; ?>
    </nav>

    <?php include __DIR__ . '/partials/_tab-inicio.php'; ?>
    <?php include __DIR__ . '/partials/_tab-croquis.php'; ?>
    <?php include __DIR__ . '/partials/_tab-news.php'; ?>
    <?php include __DIR__ . '/partials/_tab-blog.php'; ?>
    <?php include __DIR__ . '/partials/_tab-incidents.php'; ?>
    <?php include __DIR__ . '/partials/_tab-board.php'; ?>
    <?php if ($role === 'alumno'): ?>
        <?php include __DIR__ . '/partials/_tab-my-classroom.php'; ?>
    <?php endif; ?>
    <?php if ($role === 'padre'): ?>
        <?php include __DIR__ . '/partials/_tab-my-children.php'; ?>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/partials/_modals.php'; ?>

<script>
    window.__ndaIsSchoolStaff = <?= !empty($isSchoolStaff) ? 'true' : 'false' ?>;
    window.__ndaMyUserId = <?= json_encode($user['id'] ?? null) ?>;
    window.__ndaIsSchoolAdmin = <?= !empty($isSchoolAdmin) ? 'true' : 'false' ?>;
    window.__ndaInstitutionName = <?= json_encode($institucion['nombre'] ?? null) ?>;
    window.__ndaInstitutionLat = <?= json_encode($institucion['lat'] ?? null) ?>;
    window.__ndaInstitutionLng = <?= json_encode($institucion['lng'] ?? null) ?>;
    window.__ndaInicioRoutes = <?= json_encode($routes) ?>;
    window.__ndaInicioCroquisPoints = <?= json_encode($croquisPoints) ?>;
    document.addEventListener('DOMContentLoaded', function () {
        initInicioMap();
        loadCroquis();
        loadNews();
        loadBlog();
        loadIncidents();
        loadBoard();
        if (document.getElementById('myChildrenTableBody')) loadMyChildren();
    });
</script>
<script src="<?= asset('js/school.js') ?>"></script>

<?php
$content = ob_get_clean();
require_once 'views/layout.php';
?>
