<?php
$title = $title ?? 'Mi perfil · NDA';
$profileUser = $profileUser ?? [];
$instituciones = $instituciones ?? [];
$pendingRequest = $pendingRequest ?? null;
ob_start();

$roleLabels = [
    'user' => 'Usuario general',
    'director' => 'Director',
    'docente' => 'Docente',
    'alumno' => 'Estudiante',
    'padre' => 'Padre / Encargado',
    'administrativo' => 'Personal administrativo',
    'admin' => 'Administrador',
];
$roleLabel = $roleLabels[$profileUser['role']] ?? $profileUser['role'];
?>

<div class="wrap profile-page" style="padding-top:100px;padding-bottom:70px;">

    <?php if (isset($_SESSION['error'])): ?>
        <div class="profile-alert error"><?= e($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['success'])): ?>
        <div class="profile-alert success"><?= e($_SESSION['success']); unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <div class="profile-main">
    <div class="profile-head">
        <div class="profile-avatar">
            <?php if (!empty($profileUser['foto_perfil'])): ?>
                <img src="<?= e($profileUser['foto_perfil']) ?>" alt="">
            <?php else: ?>
                <?= strtoupper(substr($profileUser['nombre'], 0, 1)) ?>
            <?php endif; ?>
        </div>
        <div>
            <h1><?= e($profileUser['nombre']) ?></h1>
            <p><?= e($profileUser['email']) ?></p>
            <span class="profile-role-badge"><?= e($roleLabel) ?></span>
            <?php if ($profileUser['institucion_nombre']): ?>
                <span class="profile-role-badge inst">
                    <?= e($profileUser['institucion_nombre']) ?>
                </span>
            <?php endif; ?>
        </div>
    </div>

    <div class="profile-stats-row" id="profileStatsRow">
        <div class="profile-stat"><span class="n" id="statSaved">–</span><span class="l">Guardados</span></div>
        <div class="profile-stat"><span class="n" id="statComments">–</span><span class="l">Comentarios</span></div>
        <div class="profile-stat"><span class="n" id="statReactions">–</span><span class="l">Reacciones</span></div>
        <div class="profile-stat"><span class="n" id="statGames">–</span><span class="l">Juegos jugados</span></div>
    </div>

    <div class="profile-card">
        <h2>Datos personales</h2>
        <form method="POST" action="?url=profile/update" class="profile-form" enctype="multipart/form-data">
            <?= csrfField() ?>
            <div class="profile-field">
                <label>Foto de perfil</label>
                <div class="profile-photo-row">
                    <div class="profile-photo-preview" id="profilePhotoPreview">
                        <?php if (!empty($profileUser['foto_perfil'])): ?>
                            <img src="<?= e($profileUser['foto_perfil']) ?>" alt="" id="profilePhotoImg">
                        <?php else: ?>
                            <span id="profilePhotoInitial"><?= strtoupper(substr($profileUser['nombre'], 0, 1)) ?></span>
                            <img src="" alt="" id="profilePhotoImg" style="display:none">
                        <?php endif; ?>
                    </div>
                    <div>
                        <label for="profilePhotoInput" class="profile-btn profile-btn-out" style="cursor:pointer;display:inline-block;">Cambiar foto</label>
                        <input type="file" name="foto" id="profilePhotoInput" accept="image/png,image/jpeg,image/webp" style="display:none">
                        <p class="profile-hint" style="margin:6px 0 0;">JPG, PNG o WEBP, máx. 5MB.</p>
                    </div>
                </div>
            </div>
            <div class="profile-field">
                <label>Nombre completo</label>
                <input type="text" name="name" value="<?= e($profileUser['nombre']) ?>" required>
            </div>
            <div class="profile-field">
                <label>Nombre de usuario</label>
                <input type="text" name="username" value="<?= e($profileUser['username'] ?? '') ?>" placeholder="ej. azucena_hz" pattern="[a-z0-9_]{3,20}" title="3 a 20 caracteres: minúsculas, números y guion bajo" required>
                <small class="profile-hint" style="display:block;margin-top:4px;">Es el nombre corto que se muestra en la barra de navegación.</small>
            </div>
            <div class="profile-field">
                <label>Correo electrónico</label>
                <input type="email" value="<?= e($profileUser['email']) ?>" disabled>
            </div>
            <div class="profile-field">
                <label>Teléfono</label>
                <input type="text" name="telefono" value="<?= e($profileUser['telefono'] ?? '') ?>" placeholder="Ej. 7000-0000">
            </div>
            <button type="submit" class="profile-btn">Guardar cambios</button>
        </form>
    </div>

    <div class="profile-card">
        <h2>Institución educativa</h2>

        <?php if ($profileUser['role'] === 'admin'): ?>
            <div class="profile-inst-status ok">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                <div>
                    <strong>Acceso global a todas las instituciones</strong>
                    <p>Como Administrador General no perteneces a una institución en particular: supervisas todas las que están registradas en NDA.</p>
                </div>
            </div>
            <a href="?url=school" class="profile-btn profile-btn-out" style="margin-top:14px;display:inline-block;">Ir al Panel de Administración</a>

        <?php elseif ($profileUser['estado_institucional'] === 'aprobado'): ?>
            <div class="profile-inst-status ok">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                <div>
                    <strong>Perteneces a <?= e($profileUser['institucion_nombre']) ?></strong>
                    <p>Rol: <?= e($roleLabel) ?>. Ya puedes acceder al módulo de Gestión Escolar.</p>
                </div>
            </div>
            <a href="?url=school" class="profile-btn profile-btn-out" style="margin-top:14px;display:inline-block;">Ir a Gestión Escolar</a>

        <?php elseif ($profileUser['estado_institucional'] === 'pendiente' && $pendingRequest): ?>
            <div class="profile-inst-status pending">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <div>
                    <strong>Solicitud pendiente</strong>
                    <p>Esperando que el director de <?= e($pendingRequest['institucion_nombre']) ?> apruebe tu ingreso como <?= e($roleLabels[$pendingRequest['rol_solicitado']] ?? $pendingRequest['rol_solicitado']) ?>.</p>
                </div>
            </div>
            <form method="POST" action="?url=profile/cancel-join" style="margin-top:14px;">
                <?= csrfField() ?>
                <button type="submit" class="profile-btn profile-btn-out">Cancelar solicitud</button>
            </form>

        <?php else: ?>
            <p class="profile-hint">Todavía no perteneces a ninguna institución.</p>

            <div class="profile-inst-tabs">
                <button type="button" class="profile-tab sel" data-panel="joinPanel">Unirme a una institución</button>
                <button type="button" class="profile-tab" data-panel="foundPanel">Fundar una institución</button>
            </div>

            <div id="joinPanel">
                <p class="profile-hint">Si formas parte de la comunidad de un colegio registrado en NDA, solicita tu ingreso aquí.</p>
                <form method="POST" action="?url=profile/join" class="profile-form" id="joinForm">
                    <?= csrfField() ?>
                    <div class="profile-field">
                        <label>Institución</label>
                        <input type="text" id="joinInstSearch" placeholder="Buscar institución...">
                        <div class="profile-inst-list" id="joinInstList">
                            <?php foreach ($instituciones as $inst): ?>
                                <button type="button" class="profile-inst-item" data-id="<?= e($inst['instituciones_id']) ?>" data-name="<?= e($inst['nombre']) ?>">
                                    <span><?= e($inst['nombre']) ?></span>
                                </button>
                            <?php endforeach; ?>
                        </div>
                        <input type="hidden" name="institucion_id" id="joinInstId" required>
                    </div>
                    <div class="profile-field">
                        <label>Tu rol en la institución</label>
                        <select name="rol_solicitado" required>
                            <option value="">Selecciona...</option>
                            <option value="docente">Docente</option>
                            <option value="alumno">Estudiante</option>
                            <option value="padre">Padre / Encargado</option>
                            <option value="administrativo">Personal administrativo</option>
                        </select>
                    </div>
                    <div class="profile-field">
                        <label>Mensaje para el director (opcional)</label>
                        <textarea name="join_message" rows="2" placeholder="Ej. Soy docente de 3er año, sección B"></textarea>
                    </div>
                    <button type="submit" class="profile-btn">Enviar solicitud</button>
                </form>
            </div>

            <div id="foundPanel" style="display:none;">
                <p class="profile-hint">Funda una institución nueva y conviértete en su director/a. Te enviaremos un código al correo institucional para confirmar que es real.</p>
                <form method="POST" action="?url=profile/found" class="profile-form" id="foundForm">
                    <?= csrfField() ?>
                    <div class="profile-field">
                        <label>Nombre de la institución</label>
                        <input type="text" name="inst_name" placeholder="Ej. Colegio San José" required>
                    </div>
                    <div class="profile-field">
                        <label>Tipo de institución</label>
                        <select name="inst_tipo" required>
                            <option value="colegio">Colegio</option>
                            <option value="escuela">Escuela</option>
                            <option value="instituto">Instituto</option>
                            <option value="universidad">Universidad</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>
                    <div class="profile-field">
                        <label>Correo institucional</label>
                        <input type="email" name="inst_email" placeholder="info@colegio.edu.sv" required>
                    </div>
                    <div class="profile-field">
                        <label>Tu correo personal/profesional (opcional)</label>
                        <input type="email" name="inst_director_email" placeholder="tunombre@gmail.com">
                    </div>
                    <div class="profile-field">
                        <label>Teléfono (opcional)</label>
                        <input type="text" name="inst_phone" placeholder="2233-4455">
                    </div>
                    <div class="profile-field">
                        <label>Dirección (opcional)</label>
                        <input type="text" name="inst_address" placeholder="San Salvador, El Salvador">
                    </div>
                    <button type="submit" class="profile-btn">Fundar institución</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
    </div><!-- /.profile-main -->

    <div class="profile-activity-grid">
        <div class="profile-card">
            <h2>Mis artículos guardados</h2>
            <div id="profileSavedList" class="profile-saved-grid">
                <p class="profile-hint">Cargando...</p>
            </div>
        </div>

        <div class="profile-card">
            <h2>Mis reacciones</h2>
            <div id="profileReactionsList">
                <p class="profile-hint">Cargando...</p>
            </div>
        </div>

        <div class="profile-card">
            <h2>Mi actividad reciente</h2>
            <div id="profileActivityList">
                <p class="profile-hint">Cargando...</p>
            </div>
        </div>

        <div class="profile-card">
            <h2>Mis puntajes en Juegos</h2>
            <div id="profileScoresList" class="profile-scores-grid">
                <p class="profile-hint">Cargando...</p>
            </div>
        </div>
    </div>
</div>

<style>
.profile-alert { padding:12px 16px; border-radius:10px; font-size:.85rem; margin-bottom:18px; }
.profile-alert.error { background: rgba(255,59,63,.12); border:1px solid rgba(255,59,63,.3); color: var(--red); }
.profile-alert.success { background: rgba(107,161,90,.12); border:1px solid rgba(107,161,90,.3); color: var(--green); }
.profile-page { max-width:1040px; }
.profile-main { max-width:700px; margin:0 auto; }
.profile-head { display:flex; align-items:center; gap:20px; margin-bottom:18px; background:linear-gradient(135deg,var(--card),var(--card2)); border:1px solid var(--border); border-radius:var(--rl); padding:24px 28px; }
.profile-avatar { width:76px; height:76px; border-radius:50%; background:linear-gradient(135deg,var(--acc),var(--acc3)); color:#fff; display:flex; align-items:center; justify-content:center; font-family:var(--fd); font-size:1.9rem; font-weight:700; flex-shrink:0; overflow:hidden; box-shadow:0 8px 24px -8px var(--acc); }
.profile-avatar img { width:100%; height:100%; object-fit:cover; }
.profile-photo-row { display:flex; align-items:center; gap:16px; }
.profile-photo-preview { width:72px; height:72px; border-radius:50%; background:linear-gradient(135deg,var(--acc),var(--acc3)); color:#fff; display:flex; align-items:center; justify-content:center; font-family:var(--fd); font-size:1.7rem; font-weight:700; flex-shrink:0; overflow:hidden; border:2px solid var(--border2); }
.profile-photo-preview img { width:100%; height:100%; object-fit:cover; }
.profile-head h1 { font-family:var(--fd); font-size:1.3rem; color:var(--text); margin-bottom:2px; }
.profile-head p { color:var(--text2); font-size:.85rem; margin-bottom:8px; }
.profile-role-badge { display:inline-flex; align-items:center; gap:5px; background:var(--card2); border:1px solid var(--border2); color:var(--text2); font-size:.72rem; font-weight:600; padding:4px 10px; border-radius:100px; margin-right:6px; }
.profile-role-badge.inst { color:var(--acc); border-color:var(--acc); }
.profile-card { background:var(--card); border:1px solid var(--border); border-radius:var(--rl); padding:26px; margin-bottom:20px; }
.profile-card h2 { font-family:var(--fd); font-size:1rem; color:var(--text); margin-bottom:18px; }
.profile-form { display:flex; flex-direction:column; gap:14px; }
.profile-field label { display:block; font-size:.78rem; color:var(--text2); margin-bottom:6px; font-weight:600; }
.profile-field input, .profile-field select, .profile-field textarea {
    width:100%; background:var(--card2); border:1px solid var(--border2); border-radius:9px;
    color:var(--text); font-size:.86rem; padding:10px 12px; font-family:var(--fn); outline:none;
    transition: border-color var(--tr);
}
.profile-field input:focus, .profile-field select:focus, .profile-field textarea:focus { border-color:var(--acc); }
.profile-field input:disabled { opacity:.6; cursor:not-allowed; }
.profile-btn {
    background:linear-gradient(135deg,var(--acc),var(--acc3)); color:#fff; border:none; border-radius:50px;
    font-size:.86rem; font-weight:700; padding:11px 22px; cursor:pointer; align-self:flex-start;
    transition: transform .15s; text-decoration:none;
}
.profile-btn:hover { transform: translateY(-2px); }
.profile-btn-out { background:transparent; color:var(--text2); border:1.5px solid var(--border2); }
.profile-inst-status { display:flex; gap:12px; align-items:flex-start; padding:14px; border-radius:10px; }
.profile-inst-status.ok { background:rgba(107,161,90,.1); color:var(--green); }
.profile-inst-status.pending { background:rgba(242,159,5,.1); color:var(--acc); }
.profile-inst-status strong { display:block; color:var(--text); font-size:.9rem; margin-bottom:3px; }
.profile-inst-status p { font-size:.8rem; color:var(--text2); line-height:1.5; }
.profile-hint { font-size:.85rem; color:var(--text2); margin-bottom:16px; line-height:1.6; }
.profile-inst-list { max-height:170px; overflow-y:auto; display:flex; flex-direction:column; gap:5px; margin-top:8px; }
.profile-inst-item { display:flex; align-items:center; gap:8px; background:var(--card2); border:1.5px solid var(--border2); border-radius:8px; padding:8px 10px; color:var(--text2); font-size:.8rem; cursor:pointer; text-align:left; }
.profile-inst-item svg { color:var(--acc); flex-shrink:0; }
.profile-inst-item:hover { border-color:var(--acc); color:var(--text); }
.profile-inst-item.sel { border-color:var(--acc); background:var(--card3); color:var(--text); font-weight:600; }
.profile-inst-tabs { display:flex; gap:8px; margin-bottom:16px; }
.profile-tab { background:var(--card2); border:1.5px solid var(--border2); color:var(--text2); font-size:.82rem; font-weight:600; padding:8px 16px; border-radius:50px; cursor:pointer; }
.profile-tab.sel { border-color:var(--acc); color:var(--acc); }

.profile-stats-row { display:grid; grid-template-columns:repeat(4,1fr); gap:10px; margin-bottom:24px; }
.profile-stat { background:var(--card); border:1px solid var(--border); border-radius:14px; padding:14px 10px; text-align:center; }
.profile-stat .n { display:block; font-family:var(--fd); font-size:1.35rem; font-weight:800; color:var(--acc); line-height:1.2; }
.profile-stat .l { display:block; font-size:.66rem; color:var(--text3); margin-top:4px; text-transform:uppercase; letter-spacing:.04em; }

.profile-activity-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(300px,1fr)); gap:20px; align-items:start; margin-top:28px; }
.profile-activity-grid .profile-card { margin-bottom:0; }

.profile-saved-grid, .profile-scores-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:14px; }
.profile-saved-item { display:flex; gap:12px; background:var(--card2); border:1px solid var(--border2); border-radius:12px; padding:10px; text-decoration:none; transition:border-color .2s; }
.profile-saved-item:hover { border-color:var(--acc); }
.profile-saved-thumb { width:56px; height:56px; border-radius:8px; background-size:cover; background-position:center; flex-shrink:0; }
.profile-saved-info strong { display:block; font-size:.85rem; color:var(--text); line-height:1.35; margin-bottom:4px; }
.profile-saved-info span { font-size:.72rem; color:var(--text3); }

.profile-activity-item { display:flex; flex-direction:column; gap:4px; padding:12px 0; border-bottom:1px solid var(--border); }
.profile-activity-item:last-child { border-bottom:none; }
.profile-activity-item a { font-size:.85rem; font-weight:700; color:var(--acc); text-decoration:none; }
.profile-activity-item a:hover { text-decoration:underline; }
.profile-activity-item p { font-size:.82rem; color:var(--text2); line-height:1.5; margin:0; }
.profile-activity-item span { font-size:.7rem; color:var(--text3); }

.profile-reaction-item { display:flex; align-items:center; gap:10px; padding:10px 0; border-bottom:1px solid var(--border); }
.profile-reaction-item:last-child { border-bottom:none; }
.profile-reaction-item .emoji { font-size:1.3rem; flex-shrink:0; }
.profile-reaction-item a { font-size:.85rem; font-weight:700; color:var(--acc); text-decoration:none; display:block; }
.profile-reaction-item a:hover { text-decoration:underline; }
.profile-reaction-item span { font-size:.7rem; color:var(--text3); }

.profile-score-card { background:var(--card2); border:1px solid var(--border2); border-radius:12px; padding:14px 16px; }
.profile-score-card strong { display:block; font-size:.85rem; color:var(--text); margin-bottom:6px; }
.profile-score-card .val { display:block; font-family:var(--fd); font-size:1.4rem; font-weight:800; color:var(--acc); }
.profile-score-card span.tries { display:block; font-size:.7rem; color:var(--text3); margin-top:4px; }

@media (max-width:520px) {
    .profile-saved-grid, .profile-scores-grid { grid-template-columns:1fr; }
    .profile-stats-row { grid-template-columns:repeat(2,1fr); }
    .profile-head { flex-direction:column; text-align:center; padding:22px 18px; }
}
</style>

<script>
(function(){
    var photoInput = document.getElementById('profilePhotoInput');
    if (photoInput) {
        photoInput.addEventListener('change', function(){
            var file = photoInput.files && photoInput.files[0];
            if (!file) return;
            var reader = new FileReader();
            reader.onload = function(e){
                var img = document.getElementById('profilePhotoImg');
                var initial = document.getElementById('profilePhotoInitial');
                img.src = e.target.result;
                img.style.display = 'block';
                if (initial) initial.style.display = 'none';
            };
            reader.readAsDataURL(file);
        });
    }

    var search = document.getElementById('joinInstSearch');
    var list = document.getElementById('joinInstList');
    var hidden = document.getElementById('joinInstId');
    if (!list) return;
    list.addEventListener('click', function(e){
        var item = e.target.closest('.profile-inst-item');
        if (!item) return;
        document.querySelectorAll('.profile-inst-item').forEach(function(i){ i.classList.remove('sel'); });
        item.classList.add('sel');
        hidden.value = item.dataset.id;
        if (search) search.value = item.dataset.name;
    });
    if (search) {
        search.addEventListener('input', function(){
            var q = search.value.toLowerCase();
            document.querySelectorAll('.profile-inst-item').forEach(function(item){
                var name = (item.dataset.name || '').toLowerCase();
                item.style.display = name.indexOf(q) !== -1 ? 'flex' : 'none';
            });
        });
    }

    document.querySelectorAll('.profile-tab').forEach(function(tab){
        tab.addEventListener('click', function(){
            document.querySelectorAll('.profile-tab').forEach(function(t){ t.classList.remove('sel'); });
            tab.classList.add('sel');
            ['joinPanel', 'foundPanel'].forEach(function(id){
                var panel = document.getElementById(id);
                if (panel) panel.style.display = (id === tab.dataset.panel) ? '' : 'none';
            });
        });
    });
})();
</script>

<script>
(function(){
    function escapeHtml(str) {
        var div = document.createElement('div');
        div.textContent = str == null ? '' : String(str);
        return div.innerHTML;
    }

    function setStat(id, value) {
        var el = document.getElementById(id);
        if (el) el.textContent = value;
    }

    var savedList = document.getElementById('profileSavedList');
    if (savedList) {
        fetch('?url=blog/my-saved').then(function(r){ return r.json(); }).then(function(items){
            if (!Array.isArray(items)) items = [];
            setStat('statSaved', items.length);
            if (items.length === 0) {
                savedList.innerHTML = '<p class="profile-hint">Aún no has guardado ningún artículo.</p>';
                return;
            }
            savedList.innerHTML = items.map(function(a){
                var bg = a.imagen ? "background-image:url('" + escapeHtml(a.imagen) + "')" : 'background-color:' + escapeHtml(a.color || '#f29f05');
                return '<a class="profile-saved-item" href="?url=blog&post=' + encodeURIComponent(a.slug) + '">' +
                    '<span class="profile-saved-thumb" style="' + bg + '"></span>' +
                    '<span class="profile-saved-info"><strong>' + escapeHtml(a.titulo) + '</strong><span>Guardado</span></span>' +
                    '</a>';
            }).join('');
        }).catch(function(){ savedList.innerHTML = '<p class="profile-hint">No se pudieron cargar tus guardados.</p>'; });
    }

    var reactionsList = document.getElementById('profileReactionsList');
    if (reactionsList) {
        fetch('?url=blog/my-reactions').then(function(r){ return r.json(); }).then(function(items){
            if (!Array.isArray(items)) items = [];
            setStat('statReactions', items.length);
            if (items.length === 0) {
                reactionsList.innerHTML = '<p class="profile-hint">Aún no has reaccionado a ningún artículo.</p>';
                return;
            }
            reactionsList.innerHTML = items.map(function(r){
                var fecha = new Date(r.created_at).toLocaleDateString('es-SV', { day: 'numeric', month: 'short', year: 'numeric' });
                return '<div class="profile-reaction-item">' +
                    '<span class="emoji">' + r.emoji + '</span>' +
                    '<span><a href="?url=blog&post=' + encodeURIComponent(r.slug) + '">' + escapeHtml(r.titulo) + '</a><span>' + fecha + '</span></span>' +
                    '</div>';
            }).join('');
        }).catch(function(){ reactionsList.innerHTML = '<p class="profile-hint">No se pudieron cargar tus reacciones.</p>'; });
    }

    var activityList = document.getElementById('profileActivityList');
    if (activityList) {
        fetch('?url=blog/my-comments').then(function(r){ return r.json(); }).then(function(items){
            if (!Array.isArray(items)) items = [];
            setStat('statComments', items.length);
            if (items.length === 0) {
                activityList.innerHTML = '<p class="profile-hint">Aún no has comentado en ningún artículo.</p>';
                return;
            }
            activityList.innerHTML = items.map(function(c){
                var fecha = new Date(c.created_at).toLocaleDateString('es-SV', { day: 'numeric', month: 'short', year: 'numeric' });
                return '<div class="profile-activity-item">' +
                    '<a href="?url=blog&post=' + encodeURIComponent(c.slug) + '">' + escapeHtml(c.titulo) + '</a>' +
                    '<p>&ldquo;' + escapeHtml(c.texto) + '&rdquo;</p>' +
                    '<span>' + fecha + '</span>' +
                    '</div>';
            }).join('');
        }).catch(function(){ activityList.innerHTML = '<p class="profile-hint">No se pudo cargar tu actividad.</p>'; });
    }

    var scoresList = document.getElementById('profileScoresList');
    if (scoresList) {
        var isTimeGame = { 'Simulacro Reflejo Sísmico': true };
        fetch('?url=juegos/my-scores').then(function(r){ return r.json(); }).then(function(items){
            if (!Array.isArray(items)) items = [];
            setStat('statGames', items.length);
            if (items.length === 0) {
                scoresList.innerHTML = '<p class="profile-hint">Aún no has jugado. <a href="?url=juegos">Ir a Juegos</a></p>';
                return;
            }
            scoresList.innerHTML = items.map(function(s){
                var val = isTimeGame[s.juego_nombre] ? (s.mejor_real / 1000).toFixed(2) + ' s' : s.mejor_real + ' pts';
                return '<div class="profile-score-card">' +
                    '<strong>' + escapeHtml(s.juego_nombre) + '</strong>' +
                    '<span class="val">' + val + '</span>' +
                    '<span class="tries">' + s.intentos + ' intento(s)</span>' +
                    '</div>';
            }).join('');
        }).catch(function(){ scoresList.innerHTML = '<p class="profile-hint">No se pudieron cargar tus puntajes.</p>'; });
    }
})();
</script>

<?php
$content = ob_get_clean();
require_once 'layout.php';
?>
