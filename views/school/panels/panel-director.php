<?php
// Panel Escolar (Gestión) del director — archivo separado de la Página
// Principal (views/school/home.php). Noticias/Incidentes/Corcho ya viven
// ahí (los mismos partials, permission-aware) y no se duplican aquí.
$title = $title ?? 'Panel Escolar';
$user = $user ?? null;
$stats = $stats ?? [];
$students = $students ?? [];
$drills = $drills ?? [];
$routes = $routes ?? [];
$incidents = $incidents ?? [];
$isSchoolAdmin = $isSchoolAdmin ?? false;
$isSchoolStaff = $isSchoolStaff ?? false;
$pendingRequestsCount = $pendingRequestsCount ?? 0;
ob_start();
?>
<link rel="stylesheet" href="<?= asset('css/school.css') ?>">

<div class="school-module">

    <?php include __DIR__ . '/../partials/_header.php'; ?>

    <div class="school-panel-header" style="padding:0 0 10px;">
        <a href="?url=school" class="school-btn secondary">&larr; Página Principal</a>
    </div>

    <div class="school-body">
    <div class="school-tabs school-sidebar">
        <button class="school-tab active" data-tab="dashboard" onclick="showSchoolTab('dashboard')">
            Dashboard
        </button>
        <button class="school-tab" data-tab="users" onclick="showSchoolTab('users')">
            Usuarios
        </button>
        <button class="school-tab" data-tab="notifications" onclick="showSchoolTab('notifications')">
            Notificaciones
        </button>
        <button class="school-tab" data-tab="students" onclick="showSchoolTab('students')">
            Alumnos
        </button>
        <button class="school-tab" data-tab="teachers" onclick="showSchoolTab('teachers')">
            Docentes
        </button>
        <button class="school-tab" data-tab="parents" onclick="showSchoolTab('parents')">
            Padres
        </button>
        <button class="school-tab" data-tab="staff" onclick="showSchoolTab('staff')">
            Personal
        </button>
        <button class="school-tab" data-tab="classrooms" onclick="showSchoolTab('classrooms')">
            Aulas
        </button>
        <button class="school-tab" data-tab="routes" onclick="showSchoolTab('routes')">
            Rutas
        </button>
        <button class="school-tab" data-tab="attendance" onclick="showSchoolTab('attendance')">
            Pase de Lista
        </button>
        <button class="school-tab" data-tab="sections" onclick="showSchoolTab('sections')">
            Secciones
        </button>
        <button class="school-tab" data-tab="croquis" onclick="showSchoolTab('croquis')">
            Croquis
        </button>
        <button class="school-tab" data-tab="requests" onclick="showSchoolTab('requests')">
            Solicitudes
            <?php if (!empty($pendingRequestsCount)): ?>
                <span class="school-tab-badge"><?= (int)$pendingRequestsCount ?></span>
            <?php endif; ?>
        </button>
        <button class="school-tab" data-tab="drills" onclick="showSchoolTab('drills')">
            Simulacros
        </button>
        <button class="school-tab" data-tab="reports" onclick="showSchoolTab('reports')">
            Reportes
        </button>
    </div>

    <div class="school-content">
        <?php include __DIR__ . '/../partials/_tab-dashboard.php'; ?>
        <?php include __DIR__ . '/../partials/_tab-users.php'; ?>
        <?php include __DIR__ . '/../partials/_tab-notifications.php'; ?>
        <?php include __DIR__ . '/../partials/_tab-students.php'; ?>
        <?php include __DIR__ . '/../partials/_tab-teachers.php'; ?>
        <?php include __DIR__ . '/../partials/_tab-parents.php'; ?>
        <?php include __DIR__ . '/../partials/_tab-staff.php'; ?>
        <?php include __DIR__ . '/../partials/_tab-classrooms.php'; ?>
        <?php include __DIR__ . '/../partials/_tab-routes.php'; ?>
        <?php include __DIR__ . '/../partials/_tab-attendance.php'; ?>
        <?php include __DIR__ . '/../partials/_tab-drills.php'; ?>
        <?php include __DIR__ . '/../partials/_tab-reports.php'; ?>
        <?php include __DIR__ . '/../partials/_tab-sections.php'; ?>
        <?php include __DIR__ . '/../partials/_tab-croquis.php'; ?>
        <?php include __DIR__ . '/../partials/_tab-requests.php'; ?>
    </div>
    </div><!-- /.school-body -->
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
