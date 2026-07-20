<?php
// Página Principal Institucional: archivo separado del Panel Escolar
// (views/school/panels/panel-director.php / panel-docente.php), compartido
// por los 5 roles institucionales (director, docente, alumno, padre,
// administrativo). Se arma como una página de scroll con secciones
// (mismo lenguaje visual que views/home.php: .sec/.sec-dark/.wrap/.sec-hd),
// no como un panel de pestañas — cada sección reutiliza los mismos
// partials/controladores ya permission-aware (quién puede publicar/editar/
// borrar ya se resuelve en el backend), así que el contenido visible
// cambia solo con el rol.
$title = $title ?? 'Gestión Escolar';
$user = $user ?? null;
$institucion = $institucion ?? null;
$isSchoolAdmin = $isSchoolAdmin ?? false;
$isSchoolStaff = $isSchoolStaff ?? false;
$role = $user['role'] ?? '';

$roleLabels = [
    'director' => 'Admin Institucional',
    'docente' => 'Docente',
    'alumno' => 'Estudiante',
    'padre' => 'Padre / Encargado',
    'administrativo' => 'Personal administrativo',
];
$tipoLabels = ['colegio' => 'Colegio', 'escuela' => 'Escuela', 'instituto' => 'Instituto', 'universidad' => 'Universidad', 'otro' => 'Institución'];

ob_start();
?>
<link rel="stylesheet" href="<?= asset('css/school.css') ?>">
<style>
/* La Página Principal es una página de scroll (como el index general del
   sitio), no un panel de pestañas: se muestran todas las secciones a la
   vez en vez de alternarlas con .school-tab/.active. */
.school-home .school-panel { display: block !important; }
.school-home .sec-hd { margin-bottom: 28px; }
</style>

<div class="school-home">

<section class="sec" id="inicio">
  <div class="wrap">
    <div class="sec-hd" style="display:flex;justify-content:space-between;align-items:flex-end;gap:20px;flex-wrap:wrap;">
      <div>
        <div class="sec-eyebrow"><span class="pulsedot"></span>Página Principal Institucional</div>
        <h2 class="sec-title"><?= e($institucion['nombre'] ?? ($user['institucion_nombre'] ?? 'Tu institución')) ?></h2>
        <p class="sec-sub">
          <?= e($tipoLabels[$institucion['tipo'] ?? ''] ?? 'Institución') ?><?= !empty($institucion['direccion']) ? ' · ' . e($institucion['direccion']) : '' ?>
          — <?= e($roleLabels[$role] ?? $role) ?>
        </p>
      </div>
      <div style="display:flex;gap:10px;flex-wrap:wrap;">
        <?php if ($role === 'docente'): ?>
          <label class="btn-out" style="cursor:pointer;">
            Subir foto de perfil
            <input type="file" accept="image/*" style="display:none" onchange="uploadTeacherPhoto(this)">
          </label>
        <?php endif; ?>
      </div>
    </div>

    <div id="inicioInstitucionalBody">
      <div class="text-center" style="padding:20px;color:var(--text3);">Cargando información de tu institución...</div>
    </div>
  </div>
</section>

<section class="sec sec-dark" id="croquis">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Ubicación dentro del plantel</div>
      <h2 class="sec-title">Croquis <span class="acc">institucional</span></h2>
      <p class="sec-sub">Plano de la institución con puntos de encuentro, zonas seguras, zonas de riesgo, extintores y botiquines.</p>
    </div>
    <?php include __DIR__ . '/partials/_tab-croquis.php'; ?>
  </div>
</section>

<section class="sec" id="noticias">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Comunidad educativa</div>
      <h2 class="sec-title">Noticias <span class="acc">escolares</span></h2>
      <p class="sec-sub">Comunicados del director, docentes y del comité estudiantil autorizado.</p>
    </div>
    <?php include __DIR__ . '/partials/_tab-news.php'; ?>
  </div>
</section>

<section class="sec sec-dark" id="incidentes">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Seguridad institucional</div>
      <h2 class="sec-title">Incidentes y <span class="acc">reportes de daños</span></h2>
      <p class="sec-sub">Reporta un problema dentro de la institución con foto, título y descripción.</p>
    </div>
    <?php include __DIR__ . '/partials/_tab-incidents.php'; ?>
  </div>
</section>

<section class="sec" id="corcho">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Avisos y recordatorios</div>
      <h2 class="sec-title">Tablón de <span class="acc">Corcho</span></h2>
      <p class="sec-sub">Notas tipo Post-it institucionales, personales, de docentes o de padres de familia.</p>
    </div>
    <?php include __DIR__ . '/partials/_tab-board.php'; ?>
  </div>
</section>

<section class="sec sec-dark" id="lugares-riesgo">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Comunidad</div>
      <h2 class="sec-title">Lugares en <span class="acc">riesgo</span></h2>
      <p class="sec-sub">Reportes de la comunidad sobre zonas de riesgo cerca de la institución.</p>
    </div>
    <?php include __DIR__ . '/partials/_tab-blog.php'; ?>
  </div>
</section>

<?php if ($role === 'alumno'): ?>
<section class="sec" id="mi-aula">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Tu información</div>
      <h2 class="sec-title">Mi <span class="acc">Aula</span></h2>
      <p class="sec-sub">Tu aula, docente asignado, compañeros y encargados registrados.</p>
    </div>
    <?php include __DIR__ . '/partials/_tab-my-classroom.php'; ?>
  </div>
</section>
<?php endif; ?>

<?php if ($role === 'padre'): ?>
<section class="sec" id="mis-hijos">
  <div class="wrap">
    <div class="sec-hd">
      <div class="sec-eyebrow">Tu información</div>
      <h2 class="sec-title">Mis <span class="acc">Hijos</span></h2>
      <p class="sec-sub">Tus hijos vinculados en esta institución y su estado en el último simulacro.</p>
    </div>
    <?php include __DIR__ . '/partials/_tab-my-children.php'; ?>
  </div>
</section>
<?php endif; ?>

<?php if (in_array($role, ['director', 'docente'], true)): ?>
<section class="sec" id="panel-teaser">
  <div class="wrap">
    <div class="school-teaser">
      <div>
        <h3>¿Necesitas administrar la institución?</h3>
        <p><?= $role === 'director'
            ? 'Usuarios, croquis, simulacros, notificaciones, rutas de evacuación y más — todo desde el Panel Escolar.'
            : 'Tus secciones, alumnos, pase de lista, rutas y croquis — todo desde el Panel Escolar.' ?></p>
      </div>
      <a href="?url=school/panel" class="btn-acc">Ir al Panel de Gestión →</a>
    </div>
  </div>
</section>
<?php endif; ?>

</div><!-- /.school-home -->

<?php include __DIR__ . '/partials/_modals.php'; ?>

<script>
    window.__ndaIsSchoolStaff = <?= !empty($isSchoolStaff) ? 'true' : 'false' ?>;
    window.__ndaMyUserId = <?= json_encode($user['id'] ?? null) ?>;
    window.__ndaIsSchoolAdmin = <?= !empty($isSchoolAdmin) ? 'true' : 'false' ?>;
    window.__ndaIsGlobalAdmin = false;
    window.__ndaMyInstitutionId = <?= json_encode($user['institucion_id'] ?? null) ?>;
</script>
<script src="<?= asset('js/school.js') ?>"></script>
<script>
    // La Pagina Principal muestra todas las secciones a la vez (no hay
    // pestañas que disparen la carga al hacer clic), asi que se cargan
    // todas apenas el DOM esta listo.
    document.addEventListener('DOMContentLoaded', function () {
        if (document.getElementById('croquisBoard')) loadCroquis();
        if (document.getElementById('newsList')) loadNews(1);
        if (document.getElementById('incidentList')) loadIncidents();
        if (document.getElementById('corkboard')) loadBoard();
        if (document.getElementById('blogList')) loadBlog(1);
        if (document.getElementById('myChildrenTableBody')) loadMyChildren();
    });
</script>

<?php
$content = ob_get_clean();
require_once 'views/layout.php';
?>
