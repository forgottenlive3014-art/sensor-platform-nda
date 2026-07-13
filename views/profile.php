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
    'alumno' => 'Alumno',
    'padre' => 'Padre / Encargado',
    'administrativo' => 'Personal administrativo',
    'admin' => 'Administrador',
];
$roleLabel = $roleLabels[$profileUser['role']] ?? $profileUser['role'];
?>

<div class="wrap profile-page" style="padding-top:100px;padding-bottom:70px;max-width:760px;">

    <?php if (isset($_SESSION['error'])): ?>
        <div class="profile-alert error"><?= e($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['success'])): ?>
        <div class="profile-alert success"><?= e($_SESSION['success']); unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <div class="profile-head">
        <div class="profile-avatar"><?= strtoupper(substr($profileUser['nombre'], 0, 1)) ?></div>
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

    <div class="profile-card">
        <h2>Datos personales</h2>
        <form method="POST" action="?url=profile/update" class="profile-form">
            <?= csrfField() ?>
            <div class="profile-field">
                <label>Nombre completo</label>
                <input type="text" name="name" value="<?= e($profileUser['nombre']) ?>" required>
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
            <p class="profile-hint">Todavía no perteneces a ninguna institución. Si formas parte de la comunidad de un colegio registrado en NDA, solicita tu ingreso aquí.</p>

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
                        <option value="alumno">Alumno</option>
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
        <?php endif; ?>
    </div>
</div>

<style>
.profile-alert { padding:12px 16px; border-radius:10px; font-size:.85rem; margin-bottom:18px; }
.profile-alert.error { background: rgba(255,59,63,.12); border:1px solid rgba(255,59,63,.3); color: var(--red); }
.profile-alert.success { background: rgba(107,161,90,.12); border:1px solid rgba(107,161,90,.3); color: var(--green); }
.profile-head { display:flex; align-items:center; gap:18px; margin-bottom:28px; }
.profile-avatar { width:64px; height:64px; border-radius:50%; background:linear-gradient(135deg,var(--acc),var(--acc3)); color:#fff; display:flex; align-items:center; justify-content:center; font-family:var(--fd); font-size:1.6rem; font-weight:700; flex-shrink:0; }
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
</style>

<script>
(function(){
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
})();
</script>

<?php
$content = ob_get_clean();
require_once 'layout.php';
?>
