<?php
$title = $title ?? 'Mi perfil · NDA';
$profileUser = $profileUser ?? [];
$instituciones = $instituciones ?? [];
$pendingRequest = $pendingRequest ?? null;
$previousLoginAt = $previousLoginAt ?? null;
ob_start();

// Formatea fechas en español sin depender de la extension intl (no siempre
// disponible), calcando el estilo "Vie, 8 may 2026" que ya usa el resto del sitio.
if (!function_exists('ndaFormatFecha')) {
    function ndaFormatFecha($fecha) {
        if (!$fecha) return null;
        $dias = ['Dom','Lun','Mar','Mié','Jue','Vie','Sáb'];
        $meses = ['ene','feb','mar','abr','may','jun','jul','ago','sep','oct','nov','dic'];
        $ts = strtotime($fecha);
        return $dias[date('w', $ts)] . ', ' . date('j', $ts) . ' ' . $meses[date('n', $ts) - 1] . ' ' . date('Y', $ts) . ' · ' . date('H:i', $ts);
    }
}

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
// Si el guardado del formulario de edicion fallo, se reabre automaticamente
// para que el usuario vea el error junto a los campos, no perdido arriba del todo.
$openEditForm = isset($_SESSION['error']);

// La portada puede ser una foto subida (ruta real) o uno de los degradados
// predefinidos (guardado como "preset:<nombre>"), ver AuthController::updateProfile().
$portada = $profileUser['portada_perfil'] ?? '';
$portadaPresetActual = 'sunset';
$bannerClass = 'profile-banner';
$bannerStyle = '';
if ($portada !== '' && str_starts_with($portada, 'preset:')) {
    $portadaPresetActual = substr($portada, 7);
    if ($portadaPresetActual !== 'sunset') {
        $bannerClass .= ' cp-' . preg_replace('/[^a-z]/', '', $portadaPresetActual);
    }
} elseif ($portada !== '') {
    $bannerStyle = "background-image:url('" . e($portada) . "')";
}
?>

<div class="wrap profile-page" style="padding-top:100px;padding-bottom:70px;">

    <?php if (isset($_SESSION['error'])): ?>
        <div class="profile-alert error"><?= e($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['success'])): ?>
        <div class="profile-alert success"><?= e($_SESSION['success']); unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <div class="<?= e($bannerClass) ?>" id="profileBannerImg"<?= $bannerStyle ? ' style="' . $bannerStyle . '"' : '' ?>></div>

    <div class="profile-layout">
    <div class="profile-card-float">
        <div class="profile-float-avatar">
            <?php if (!empty($profileUser['foto_perfil'])): ?>
                <img src="<?= e($profileUser['foto_perfil']) ?>" alt="">
            <?php else: ?>
                <?= strtoupper(substr($profileUser['nombre'], 0, 1)) ?>
            <?php endif; ?>
        </div>
        <span class="profile-role-badge"><?= e($roleLabel) ?></span>
        <h1><?= e($profileUser['nombre']) ?></h1>
        <?php if (!empty($profileUser['username'])): ?>
            <p class="profile-handle">@<?= e($profileUser['username']) ?></p>
        <?php endif; ?>
        <?php if (!empty($profileUser['bio'])): ?>
            <p class="profile-bio"><?= e($profileUser['bio']) ?></p>
        <?php endif; ?>
        <ul class="profile-meta-list">
            <?php if (!empty($profileUser['ubicacion'])): ?>
            <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/></svg><?= e($profileUser['ubicacion']) ?></li>
            <?php endif; ?>
            <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16v16H4z" opacity="0"/><path d="M22 6 12 13 2 6"/><path d="M2 6h20v12H2z"/></svg><?= e($profileUser['email']) ?></li>
            <?php if ($profileUser['institucion_nombre']): ?>
            <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6"/></svg><?= e($profileUser['institucion_nombre']) ?></li>
            <?php endif; ?>
            <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>Miembro desde <?= e(ndaFormatFecha($profileUser['created_at'])) ?></li>
            <?php if ($previousLoginAt): ?>
            <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>Último acceso: <?= e(ndaFormatFecha($previousLoginAt)) ?></li>
            <?php endif; ?>
        </ul>

        <button type="button" class="profile-edit-toggle" id="profileEditToggle">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
            Editar perfil
        </button>
    </div>

    <div class="profile-right">
    <div class="profile-stats-row" id="profileStatsRow">
        <div class="profile-stat"><span class="n" id="statSaved">–</span><span class="l">Guardados</span></div>
        <div class="profile-stat"><span class="n" id="statLikes">–</span><span class="l">Me gusta</span></div>
        <div class="profile-stat"><span class="n" id="statReactions">–</span><span class="l">Reacciones</span></div>
        <div class="profile-stat"><span class="n" id="statComments">–</span><span class="l">Comentarios</span></div>
        <div class="profile-stat"><span class="n" id="statGames">–</span><span class="l">Juegos jugados</span></div>
    </div>

    <div class="profile-maintabs">
        <button type="button" class="ptab active" data-ptab="institucion">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6"/></svg>
            Institución
        </button>
        <button type="button" class="ptab" data-ptab="guardados">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg>
            Guardados
        </button>
        <button type="button" class="ptab" data-ptab="megusta">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l8.8 8.8 8.8-8.8a5.5 5.5 0 0 0 0-7.8z"/></svg>
            Me gusta
        </button>
        <button type="button" class="ptab" data-ptab="actividad">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
            Actividad
        </button>
        <button type="button" class="ptab" data-ptab="juegos">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="6" width="20" height="12" rx="4"/><line x1="7" y1="9" x2="7" y2="15"/><line x1="4" y1="12" x2="10" y2="12"/><circle cx="16" cy="10" r="1"/><circle cx="18.5" cy="13" r="1"/></svg>
            Juegos
        </button>
    </div>

    <div class="profile-tabpanel active" data-ptabpanel="institucion">
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
    </div><!-- /panel institucion -->

    <div class="profile-tabpanel" data-ptabpanel="guardados">
        <div class="profile-card">
            <h2>Mis artículos guardados</h2>
            <div id="profileSavedList" class="profile-saved-grid">
                <p class="profile-hint">Cargando...</p>
            </div>
        </div>
    </div>

    <div class="profile-tabpanel" data-ptabpanel="megusta">
        <div class="profile-card">
            <h2>Mis me gusta</h2>
            <div id="profileLikesListMain" class="profile-saved-grid">
                <p class="profile-hint">Cargando...</p>
            </div>
        </div>
    </div>

    <div class="profile-tabpanel" data-ptabpanel="actividad">
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
    </div>

    <div class="profile-tabpanel" data-ptabpanel="juegos">
        <div class="profile-card">
            <h2>Mis puntajes en Juegos</h2>
            <div id="profileScoresList" class="profile-scores-grid">
                <p class="profile-hint">Cargando...</p>
            </div>
        </div>
    </div>
    </div><!-- /.profile-right -->
    </div><!-- /.profile-layout -->

    <div class="profile-modal-overlay<?= $openEditForm ? ' open' : '' ?>" id="profileEditModal">
        <div class="profile-modal">
            <button type="button" class="profile-modal-close" id="profileEditModalClose" aria-label="Cerrar">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
            <h2>Editar perfil</h2>
            <form method="POST" action="?url=profile/update" class="profile-form" enctype="multipart/form-data">
                <?= csrfField() ?>
                <div class="profile-field">
                    <label>Foto de perfil</label>
                    <div class="profile-avatar-picker">
                        <div class="profile-photo-preview" id="profilePhotoPreview">
                            <?php if (!empty($profileUser['foto_perfil'])): ?>
                                <img src="<?= e($profileUser['foto_perfil']) ?>" alt="" id="profilePhotoImg">
                            <?php else: ?>
                                <span id="profilePhotoInitial"><?= strtoupper(substr($profileUser['nombre'], 0, 1)) ?></span>
                                <img src="" alt="" id="profilePhotoImg" style="display:none">
                            <?php endif; ?>
                        </div>
                        <div class="profile-avatar-presets">
                            <button type="button" class="profile-avatar-preset" data-preset="robot" data-src="<?= e(asset('media/img/chatbot.png')) ?>" title="Robot NDA">
                                <img src="<?= e(asset('media/img/chatbot.png')) ?>" alt="Robot NDA">
                            </button>
                            <button type="button" class="profile-avatar-preset" data-preset="bot1" data-src="<?= e(asset('media/img/bot1.png')) ?>" title="Robot NDA (sentado)">
                                <img src="<?= e(asset('media/img/bot1.png')) ?>" alt="Robot NDA sentado">
                            </button>
                            <button type="button" class="profile-avatar-preset" data-preset="alegre" data-src="<?= e(asset('media/img/alegre.png')) ?>" title="Robot NDA (alegre)">
                                <img src="<?= e(asset('media/img/alegre.png')) ?>" alt="Robot NDA alegre">
                            </button>
                            <button type="button" class="profile-avatar-preset" data-preset="default" data-src="<?= e(asset('media/img/user.png')) ?>" title="Avatar predeterminado">
                                <img src="<?= e(asset('media/img/user.png')) ?>" alt="Avatar predeterminado">
                            </button>
                        </div>
                    </div>
                    <label for="profilePhotoInput" class="profile-btn profile-btn-out" style="cursor:pointer;display:inline-block;margin-top:10px;">Cambiar foto</label>
                    <input type="file" name="foto" id="profilePhotoInput" accept="image/png,image/jpeg,image/webp" style="display:none">
                    <input type="hidden" name="foto_preset" id="fotoPresetInput" value="">
                    <p class="profile-hint" style="margin:6px 0 0;">JPG, PNG o WEBP, máx. 5MB, o elige un avatar.</p>
                </div>
                <div class="profile-field">
                    <label>Foto de portada</label>
                    <div class="profile-avatar-picker">
                        <div class="profile-cover-preview" id="profileCoverPreview" style="<?= $bannerStyle ?>"></div>
                        <div class="profile-cover-presets">
                            <button type="button" class="profile-cover-preset cp-sunset<?= $portadaPresetActual === 'sunset' ? ' sel' : '' ?>" data-preset="sunset" title="Atardecer"></button>
                            <button type="button" class="profile-cover-preset cp-ocean<?= $portadaPresetActual === 'ocean' ? ' sel' : '' ?>" data-preset="ocean" title="Océano"></button>
                            <button type="button" class="profile-cover-preset cp-forest<?= $portadaPresetActual === 'forest' ? ' sel' : '' ?>" data-preset="forest" title="Bosque"></button>
                            <button type="button" class="profile-cover-preset cp-ember<?= $portadaPresetActual === 'ember' ? ' sel' : '' ?>" data-preset="ember" title="Alerta"></button>
                        </div>
                    </div>
                    <label for="profileCoverInput" class="profile-btn profile-btn-out" style="cursor:pointer;display:inline-block;margin-top:10px;">Cambiar portada</label>
                    <input type="file" name="portada" id="profileCoverInput" accept="image/png,image/jpeg,image/webp" style="display:none">
                    <input type="hidden" name="portada_preset" id="portadaPresetInput" value="">
                    <p class="profile-hint" style="margin:6px 0 0;">JPG, PNG o WEBP, máx. 5MB, o elige un color.</p>
                </div>
                <div class="profile-field-row">
                    <div class="profile-field">
                        <label>Nombre completo</label>
                        <input type="text" name="name" value="<?= e($profileUser['nombre']) ?>" required>
                    </div>
                    <div class="profile-field">
                        <label>Nombre de usuario</label>
                        <input type="text" name="username" value="<?= e($profileUser['username'] ?? '') ?>" placeholder="ej. azucena_hz" pattern="[a-z0-9_]{3,20}" title="3 a 20 caracteres: minúsculas, números y guion bajo" required>
                        <small class="profile-hint" style="display:block;margin-top:4px;">Nombre corto de la barra de navegación.</small>
                    </div>
                </div>
                <div class="profile-field-row">
                    <div class="profile-field">
                        <label>Correo electrónico</label>
                        <input type="email" value="<?= e($profileUser['email']) ?>" disabled>
                    </div>
                    <div class="profile-field">
                        <label>Teléfono</label>
                        <input type="text" name="telefono" value="<?= e($profileUser['telefono'] ?? '') ?>" placeholder="Ej. 7000-0000">
                    </div>
                </div>
                <div class="profile-field">
                    <label>Ubicación</label>
                    <input type="text" name="ubicacion" value="<?= e($profileUser['ubicacion'] ?? '') ?>" placeholder="Ej. San Salvador, El Salvador">
                </div>
                <div class="profile-field">
                    <label>Biografía</label>
                    <textarea name="bio" rows="3" maxlength="200" placeholder="Cuéntanos algo breve sobre ti..."><?= e($profileUser['bio'] ?? '') ?></textarea>
                    <small class="profile-hint" style="display:block;margin-top:4px;">Máximo 200 caracteres. Aparece en tu perfil público.</small>
                </div>
                <button type="submit" class="profile-btn">Guardar cambios</button>
            </form>
        </div>
    </div>
</div>

<style>
.profile-alert { padding:12px 16px; border-radius:10px; font-size:.85rem; margin-bottom:18px; }
.profile-alert.error { background: rgba(255,59,63,.12); border:1px solid rgba(255,59,63,.3); color: var(--red); }
.profile-alert.success { background: rgba(107,161,90,.12); border:1px solid rgba(107,161,90,.3); color: var(--green); }
.profile-page { max-width:1040px; }
.profile-banner {
    height:260px;
    width:calc(100% + 120px);
    margin-left:-60px;
    border-radius:var(--rl);
    position:relative;
    overflow:hidden;
    background:
        radial-gradient(ellipse 60% 90% at 50% 30%, color-mix(in srgb, var(--acc) 48%, transparent), transparent 70%),
        linear-gradient(180deg, var(--bg3), var(--bg2));
    background-size: cover;
    background-position: center;
}
.profile-banner.cp-ocean { background-image: radial-gradient(ellipse 60% 90% at 50% 30%, color-mix(in srgb, var(--blue) 52%, transparent), transparent 70%), linear-gradient(180deg, var(--bg3), var(--bg2)); }
.profile-banner.cp-forest { background-image: radial-gradient(ellipse 60% 90% at 50% 30%, color-mix(in srgb, var(--green) 52%, transparent), transparent 70%), linear-gradient(180deg, var(--bg3), var(--bg2)); }
.profile-banner.cp-ember { background-image: radial-gradient(ellipse 60% 90% at 50% 30%, color-mix(in srgb, var(--red) 52%, transparent), transparent 70%), linear-gradient(180deg, var(--bg3), var(--bg2)); }
.profile-layout { display:grid; grid-template-columns:300px 1fr; align-items:start; gap:24px; }
.profile-card-float {
    position:relative;
    margin:-70px 0 0;
    background:var(--card);
    border:1px solid var(--border);
    border-radius:var(--rl);
    box-shadow:var(--shl);
    padding:0 22px 22px;
    text-align:left;
}
.profile-right { min-width:0; padding-top:36px; }
.profile-edit-toggle {
    display:inline-flex; align-items:center; gap:7px; margin-top:18px;
    background:var(--card2); border:1px solid var(--border2); color:var(--text);
    font-size:.82rem; font-weight:600; padding:9px 16px; border-radius:50px; cursor:pointer;
    transition:border-color var(--tr);
}
.profile-edit-toggle:hover { border-color:var(--acc); color:var(--acc); }
.profile-edit-toggle svg { width:15px; height:15px; }

.profile-modal-overlay {
    position:fixed; inset:0; z-index:9999;
    background:rgba(2,21,38,.72);
    display:flex; align-items:center; justify-content:center; padding:20px;
    opacity:0; pointer-events:none;
    transition:opacity .2s var(--ez);
}
.profile-modal-overlay.open { opacity:1; pointer-events:auto; }
.profile-modal {
    position:relative;
    background:var(--card); border:1px solid var(--border); border-radius:var(--rl);
    box-shadow:var(--shl);
    width:100%; max-width:680px; max-height:85vh; overflow-y:auto;
    padding:32px 36px;
    transform:translateY(14px); transition:transform .2s var(--ez);
}
.profile-modal-overlay.open .profile-modal { transform:translateY(0); }
.profile-modal h2 { font-family:var(--fd); font-size:1.1rem; color:var(--text); margin-bottom:18px; }
.profile-modal-close {
    position:absolute; top:18px; right:18px;
    background:var(--card2); border:1px solid var(--border2); color:var(--text2);
    width:32px; height:32px; border-radius:50%; cursor:pointer;
    display:flex; align-items:center; justify-content:center;
}
.profile-modal-close:hover { color:var(--text); border-color:var(--acc); }
.profile-modal-close svg { width:16px; height:16px; }
.profile-field-row { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
@media (max-width:560px) {
    .profile-modal { max-width:460px; padding:26px 22px; }
    .profile-field-row { grid-template-columns:1fr; }
}
.profile-float-avatar {
    width:88px; height:88px; border-radius:50%;
    margin-top:-44px;
    background:linear-gradient(135deg,var(--acc),var(--acc3)); color:#fff;
    display:flex; align-items:center; justify-content:center;
    font-family:var(--fd); font-size:2rem; font-weight:700;
    overflow:hidden; border:4px solid var(--card);
    box-shadow:0 8px 20px -6px rgba(0,0,0,.5);
}
.profile-float-avatar img { width:100%; height:100%; object-fit:cover; }
.profile-avatar-picker { display:flex; align-items:center; gap:14px; flex-wrap:wrap; }
.profile-photo-preview { width:72px; height:72px; border-radius:50%; background:linear-gradient(135deg,var(--acc),var(--acc3)); color:#fff; display:flex; align-items:center; justify-content:center; font-family:var(--fd); font-size:1.7rem; font-weight:700; flex-shrink:0; overflow:hidden; border:2px solid var(--border2); }
.profile-photo-preview img { width:100%; height:100%; object-fit:cover; }
.profile-avatar-presets { display:flex; gap:8px; flex-wrap:wrap; }
.profile-avatar-preset { width:40px; height:40px; border-radius:50%; padding:0; border:2px solid var(--border2); background:var(--card2); cursor:pointer; overflow:hidden; transition:border-color .2s; flex-shrink:0; }
.profile-avatar-preset img { width:100%; height:100%; object-fit:cover; }
.profile-avatar-preset:hover, .profile-avatar-preset.sel { border-color:var(--acc); }
.profile-cover-preview { width:96px; height:56px; border-radius:9px; background:linear-gradient(135deg,var(--bg3),var(--bg2)); background-size:cover; background-position:center; flex-shrink:0; border:2px solid var(--border2); }
.profile-cover-presets { display:flex; gap:8px; flex-wrap:wrap; }
.profile-cover-preset { width:40px; height:40px; border-radius:9px; padding:0; border:2px solid var(--border2); cursor:pointer; flex-shrink:0; transition:border-color .2s, transform .2s; }
.profile-cover-preset:hover { transform:translateY(-2px); }
.profile-cover-preset.sel { border-color:var(--text); box-shadow:0 0 0 2px var(--acc); }
.profile-cover-preset.cp-sunset { background: radial-gradient(circle at 30% 30%, var(--acc), transparent 65%), radial-gradient(circle at 80% 80%, var(--blue), transparent 65%), var(--bg3); }
.profile-cover-preset.cp-ocean { background: radial-gradient(circle at 30% 30%, var(--blue), transparent 65%), radial-gradient(circle at 80% 80%, var(--purple), transparent 65%), var(--bg3); }
.profile-cover-preset.cp-forest { background: radial-gradient(circle at 30% 30%, var(--green), transparent 65%), radial-gradient(circle at 80% 80%, var(--teal), transparent 65%), var(--bg3); }
.profile-cover-preset.cp-ember { background: radial-gradient(circle at 30% 30%, var(--red), transparent 65%), radial-gradient(circle at 80% 80%, var(--acc), transparent 65%), var(--bg3); }
.profile-card-float h1 { font-family:var(--fd); font-size:1.15rem; color:var(--text); margin-top:12px; margin-bottom:2px; }
.profile-handle { color:var(--text3); font-size:.82rem; }
.profile-bio { color:var(--text2); font-size:.85rem; line-height:1.5; margin:8px 0 0; }
.profile-meta-list { list-style:none; margin:14px 0 0; padding:0; display:flex; flex-direction:column; gap:8px; }
.profile-meta-list li { display:flex; align-items:center; gap:9px; font-size:.8rem; color:var(--text3); }
.profile-meta-list svg { width:15px; height:15px; flex-shrink:0; }
.profile-role-badge { display:inline-flex; align-items:center; gap:5px; background:var(--card2); border:1px solid var(--border2); color:var(--text2); font-size:.72rem; font-weight:600; padding:4px 10px; border-radius:100px; margin-top:14px; }
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

.profile-stats-row { display:grid; grid-template-columns:repeat(5,1fr); gap:10px; margin-bottom:24px; }
.profile-stat { background:var(--card); border:1px solid var(--border); border-radius:14px; padding:14px 10px; text-align:center; }
.profile-stat .n { display:block; font-family:var(--fd); font-size:1.35rem; font-weight:800; color:var(--acc); line-height:1.2; }
.profile-stat .l { display:block; font-size:.66rem; color:var(--text3); margin-top:4px; text-transform:uppercase; letter-spacing:.04em; }

.profile-maintabs { display:flex; gap:6px; flex-wrap:wrap; margin-bottom:20px; border-bottom:1px solid var(--border); padding-bottom:2px; }
.ptab {
    display:inline-flex; align-items:center; gap:7px;
    background:transparent; border:none; border-bottom:2px solid transparent;
    color:var(--text3); font-size:.86rem; font-weight:600; cursor:pointer;
    padding:10px 14px; margin-bottom:-2px; transition:color .2s, border-color .2s;
}
.ptab svg { width:16px; height:16px; }
.ptab:hover { color:var(--text2); }
.ptab.active { color:var(--acc); border-color:var(--acc); }
.profile-tabpanel { display:none; grid-template-columns:repeat(auto-fit,minmax(280px,1fr)); gap:20px; align-items:start; }
.profile-tabpanel.active { display:grid; }
.profile-tabpanel .profile-card { margin-bottom:0; }
.profile-tabpanel[data-ptabpanel="actividad"] { grid-template-columns:1fr; }

.profile-saved-grid, .profile-scores-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:14px; }
.profile-saved-item { display:flex; gap:12px; background:var(--card2); border:1px solid var(--border2); border-radius:12px; padding:10px; text-decoration:none; transition:border-color .2s; }
.profile-saved-item:hover { border-color:var(--acc); }
.profile-saved-thumb { width:56px; height:56px; border-radius:8px; background-size:cover; background-position:center; flex-shrink:0; }
.profile-saved-info strong { display:block; font-size:.85rem; color:var(--text); line-height:1.35; margin-bottom:4px; }
.profile-saved-info span { font-size:.72rem; color:var(--text3); }

.profile-activity-item, .profile-reaction-item {
    background:var(--card2); border:1px solid var(--border2); border-radius:12px;
    padding:12px 14px; margin-bottom:10px; transition:border-color .2s;
}
.profile-activity-item:last-child, .profile-reaction-item:last-child { margin-bottom:0; }
.profile-activity-item:hover, .profile-reaction-item:hover { border-color:var(--acc); }

.profile-activity-item { display:flex; flex-direction:column; gap:4px; }
.profile-activity-item a { font-size:.85rem; font-weight:700; color:var(--acc); text-decoration:none; }
.profile-activity-item a:hover { text-decoration:underline; }
.profile-activity-item p { font-size:.82rem; color:var(--text2); line-height:1.5; margin:0; }
.profile-activity-item span { font-size:.7rem; color:var(--text3); }

.profile-reaction-item { display:flex; align-items:center; gap:12px; }
.profile-reaction-item .emoji { font-size:1.5rem; flex-shrink:0; }
.profile-reaction-item a { font-size:.85rem; font-weight:700; color:var(--text); text-decoration:none; display:block; }
.profile-reaction-item a:hover { color:var(--acc); text-decoration:underline; }
.profile-reaction-item span { font-size:.7rem; color:var(--text3); }

.profile-score-card { background:var(--card2); border:1px solid var(--border2); border-radius:12px; padding:14px 16px; }
.profile-score-card strong { display:block; font-size:.85rem; color:var(--text); margin-bottom:6px; }
.profile-score-card .val { display:block; font-family:var(--fd); font-size:1.4rem; font-weight:800; color:var(--acc); }
.profile-score-card span.tries { display:block; font-size:.7rem; color:var(--text3); margin-top:4px; }

@media (max-width:860px) {
    .profile-layout { grid-template-columns:1fr; }
    .profile-card-float { margin:-70px 0 0; }
}
@media (max-width:700px) {
    .profile-stats-row { grid-template-columns:repeat(3,1fr); }
}
@media (max-width:520px) {
    .profile-saved-grid, .profile-scores-grid { grid-template-columns:1fr; }
    .profile-stats-row { grid-template-columns:repeat(2,1fr); }
    .profile-banner { height:170px; width:100%; margin-left:0; }
    .profile-card-float { margin:-56px 0 0; }
    .profile-float-avatar { width:76px; height:76px; font-size:1.7rem; margin-top:-38px; }
}
</style>

<script>
(function(){
    var editToggle = document.getElementById('profileEditToggle');
    var editModal = document.getElementById('profileEditModal');
    var editModalClose = document.getElementById('profileEditModalClose');
    if (editToggle && editModal) {
        var openEditModal = function(){ editModal.classList.add('open'); };
        var closeEditModal = function(){ editModal.classList.remove('open'); };
        editToggle.addEventListener('click', openEditModal);
        if (editModalClose) editModalClose.addEventListener('click', closeEditModal);
        editModal.addEventListener('click', function(e){ if (e.target === editModal) closeEditModal(); });
        document.addEventListener('keydown', function(e){ if (e.key === 'Escape') closeEditModal(); });
    }

    var fotoPresetInput = document.getElementById('fotoPresetInput');

    var photoInput = document.getElementById('profilePhotoInput');
    if (photoInput) {
        photoInput.addEventListener('change', function(){
            var file = photoInput.files && photoInput.files[0];
            if (!file) return;
            if (fotoPresetInput) fotoPresetInput.value = '';
            document.querySelectorAll('.profile-avatar-preset').forEach(function(b){ b.classList.remove('sel'); });
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

    document.querySelectorAll('.profile-avatar-preset').forEach(function(btn){
        btn.addEventListener('click', function(){
            if (photoInput) photoInput.value = '';
            if (fotoPresetInput) fotoPresetInput.value = btn.dataset.preset;
            document.querySelectorAll('.profile-avatar-preset').forEach(function(b){ b.classList.remove('sel'); });
            btn.classList.add('sel');
            var img = document.getElementById('profilePhotoImg');
            var initial = document.getElementById('profilePhotoInitial');
            img.src = btn.dataset.src;
            img.style.display = 'block';
            if (initial) initial.style.display = 'none';
        });
    });

    var portadaPresetInput = document.getElementById('portadaPresetInput');
    var coverPreview = document.getElementById('profileCoverPreview');

    var coverInput = document.getElementById('profileCoverInput');
    if (coverInput) {
        coverInput.addEventListener('change', function(){
            var file = coverInput.files && coverInput.files[0];
            if (!file) return;
            if (portadaPresetInput) portadaPresetInput.value = '';
            document.querySelectorAll('.profile-cover-preset').forEach(function(b){ b.classList.remove('sel'); });
            var reader = new FileReader();
            reader.onload = function(e){
                if (coverPreview) {
                    coverPreview.style.background = '';
                    coverPreview.style.backgroundImage = "url('" + e.target.result + "')";
                }
            };
            reader.readAsDataURL(file);
        });
    }

    document.querySelectorAll('.profile-cover-preset').forEach(function(btn){
        btn.addEventListener('click', function(){
            if (coverInput) coverInput.value = '';
            if (portadaPresetInput) portadaPresetInput.value = btn.dataset.preset;
            document.querySelectorAll('.profile-cover-preset').forEach(function(b){ b.classList.remove('sel'); });
            btn.classList.add('sel');
            if (coverPreview) {
                coverPreview.style.backgroundImage = '';
                coverPreview.style.background = getComputedStyle(btn).background;
            }
        });
    });

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
    // Pestañas principales (Institución/Guardados/Actividad/Juegos). En un
    // <script> propio: el bloque de arriba corta con "return" cuando no
    // existe el formulario de unirse/fundar institución (usuario que ya
    // pertenece a una), y eso dejaba estas pestañas sin funcionar.
    document.querySelectorAll('.ptab').forEach(function(tab){
        tab.addEventListener('click', function(){
            document.querySelectorAll('.ptab').forEach(function(t){ t.classList.remove('active'); });
            tab.classList.add('active');
            document.querySelectorAll('.profile-tabpanel').forEach(function(panel){
                panel.classList.toggle('active', panel.dataset.ptabpanel === tab.dataset.ptab);
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

    var likesListMain = document.getElementById('profileLikesListMain');
    if (likesListMain) {
        var tipoLabels = { articulo: 'Blog', riesgo: 'Riesgo', noticia: 'Noticia', incidente: 'Incidente', nota: 'Nota' };
        fetch('?url=blog/my-likes').then(function(r){ return r.json(); }).then(function(items){
            if (!Array.isArray(items)) items = [];
            setStat('statLikes', items.length);
            likesListMain.innerHTML = items.length === 0
                ? '<p class="profile-hint">Aún no has dado "me gusta" a nada.</p>'
                : items.map(function(l){
                    var bg = l.imagen ? "background-image:url('" + escapeHtml(l.imagen) + "')" : 'background-color:' + escapeHtml(l.color || '#f29f05');
                    return '<a class="profile-saved-item" href="' + escapeHtml(l.link) + '">' +
                        '<span class="profile-saved-thumb" style="' + bg + '"></span>' +
                        '<span class="profile-saved-info"><strong>' + escapeHtml(l.titulo) + '</strong><span>' + escapeHtml(tipoLabels[l.tipo] || l.tipo) + '</span></span>' +
                        '</a>';
                }).join('');
        }).catch(function(){
            likesListMain.innerHTML = '<p class="profile-hint">No se pudieron cargar tus "me gusta".</p>';
        });
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
