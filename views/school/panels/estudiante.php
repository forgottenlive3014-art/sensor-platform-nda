<?php
$title = $title ?? 'Gestión Escolar';
$user = $user ?? null;
$stats = $stats ?? [];
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

    <!-- ==================== TABS (sidebar) ==================== -->
    <div class="school-body">
    <div class="school-tabs school-sidebar">
        <button class="school-tab active" data-tab="dashboard" onclick="showSchoolTab('dashboard')">
            <span class="school-emoji" aria-hidden="true">🧭</span> Dashboard
        </button>
        <button class="school-tab" data-tab="my-attendance" onclick="showSchoolTab('my-attendance')">
            <span class="school-emoji" aria-hidden="true">🖊️</span> Mi Asistencia
        </button>
        <button class="school-tab" data-tab="drills" onclick="showSchoolTab('drills')">
            <span class="school-emoji" aria-hidden="true">🔔</span> Simulacros
        </button>
        <button class="school-tab" data-tab="routes" onclick="showSchoolTab('routes')">
            <span class="school-emoji" aria-hidden="true">🚸</span> Rutas
        </button>
        <button class="school-tab" data-tab="incidents" onclick="showSchoolTab('incidents')">
            <span class="school-emoji" aria-hidden="true">🧯</span> Incidentes / Daños
        </button>
        <button class="school-tab" data-tab="croquis" onclick="showSchoolTab('croquis')">
            <span class="school-emoji" aria-hidden="true">📐</span> Croquis
        </button>
        <button class="school-tab" data-tab="board" onclick="showSchoolTab('board')">
            <span class="school-emoji" aria-hidden="true">📌</span> Corcho
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
        <?php include __DIR__ . '/../partials/_tab-dashboard-simple.php'; ?>
        <?php include __DIR__ . '/../partials/_tab-blog.php'; ?>
        <?php include __DIR__ . '/../partials/_tab-news.php'; ?>
        <?php include __DIR__ . '/../partials/_tab-my-attendance.php'; ?>
        <?php include __DIR__ . '/../partials/_tab-drills.php'; ?>
        <?php include __DIR__ . '/../partials/_tab-routes.php'; ?>
        <?php include __DIR__ . '/../partials/_tab-incidents.php'; ?>
        <?php include __DIR__ . '/../partials/_tab-croquis.php'; ?>
        <?php include __DIR__ . '/../partials/_tab-board.php'; ?>
    </div>
    </div><!-- /.school-body -->
</div>

<div class="school-modal" id="addIncidentModal">
    <div class="school-modal-content">
        <div class="school-modal-header">
            <h3>Reportar Incidente</h3>
            <button class="school-modal-close" onclick="closeModal('addIncidentModal')">&times;</button>
        </div>
        <div class="school-modal-body">
            <form id="addIncidentForm">
                <div class="school-form-group">
                    <label>Tipo *</label>
                    <select id="incidentType" required>
                        <option value="">Seleccionar tipo</option>
                        <option value="Ruta bloqueada">Ruta bloqueada</option>
                        <option value="Objeto caído">Objeto caído</option>
                        <option value="Alumno lesionado">Alumno lesionado</option>
                        <option value="Espacio dañado">Espacio dañado / Daño de infraestructura</option>
                        <option value="Falla estructural">Falla estructural</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>
                <div class="school-form-group">
                    <label>Ubicación</label>
                    <input type="text" id="incidentLocation" placeholder="Ej: Pasillo norte, Pabellón B">
                </div>
                <div class="school-form-group">
                    <label>Descripción *</label>
                    <textarea id="incidentDescription" rows="3" placeholder="Describe el incidente en detalle..." required></textarea>
                </div>
                <div class="school-form-group">
                    <label>Foto del daño (opcional)</label>
                    <input type="file" id="incidentImage" accept="image/*">
                </div>
                <div class="school-form-group">
                    <label>Prioridad</label>
                    <select id="incidentPriority">
                        <option value="baja">Baja</option>
                        <option value="media" selected>Media</option>
                        <option value="alta">Alta</option>
                    </select>
                </div>
                <button type="submit" class="school-btn primary">Reportar Incidente</button>
            </form>
        </div>
    </div>
</div>

<div class="school-modal" id="addBoardNoteModal">
    <div class="school-modal-content">
        <div class="school-modal-header">
            <h3>Nueva nota</h3>
            <button class="school-modal-close" onclick="closeModal('addBoardNoteModal')">&times;</button>
        </div>
        <div class="school-modal-body">
            <form id="addBoardNoteForm">
                <div class="school-form-group">
                    <label>Mensaje *</label>
                    <textarea id="noteText" rows="3" maxlength="280" placeholder="Escribe un aviso, recordatorio o idea para la comunidad..." required></textarea>
                </div>
                <div class="school-form-group">
                    <label>Color</label>
                    <div class="note-color-picker">
                        <label><input type="radio" name="noteColor" value="amarillo" checked><span class="note-swatch amarillo"></span></label>
                        <label><input type="radio" name="noteColor" value="naranja"><span class="note-swatch naranja"></span></label>
                        <label><input type="radio" name="noteColor" value="verde"><span class="note-swatch verde"></span></label>
                        <label><input type="radio" name="noteColor" value="azul"><span class="note-swatch azul"></span></label>
                        <label><input type="radio" name="noteColor" value="rosa"><span class="note-swatch rosa"></span></label>
                    </div>
                </div>
                <div class="school-form-group">
                    <label>¿Quién la puede ver?</label>
                    <div class="note-visibility-picker">
                        <label><input type="checkbox" id="noteVisTodos" checked onchange="toggleNoteVisAll(this)"> Todos</label>
                        <span id="noteVisRoles" style="display:none;">
                            <label><input type="checkbox" class="noteVisRole" value="director"> Directores</label>
                            <label><input type="checkbox" class="noteVisRole" value="docente"> Docentes</label>
                            <label><input type="checkbox" class="noteVisRole" value="alumno"> Alumnos</label>
                            <label><input type="checkbox" class="noteVisRole" value="padre"> Padres</label>
                            <label><input type="checkbox" class="noteVisRole" value="administrativo"> Personal</label>
                        </span>
                    </div>
                </div>
                <button type="submit" class="school-btn primary">Pegar en el corcho</button>
            </form>
        </div>
    </div>
</div>

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
