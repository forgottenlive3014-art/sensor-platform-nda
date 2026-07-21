<?php
$title = $title ?? 'Detalle · NDA';
$user = $user ?? null;
$tipoContenido = $tipoContenido ?? 'noticia';
$contenidoId = $contenidoId ?? 0;
$backAnchor = $backAnchor ?? 'tab-inicio';
$item = $item ?? [];
$isSchoolAdmin = $isSchoolAdmin ?? false;
ob_start();

if ($tipoContenido === 'noticia') {
    $heading = $item['titulo'];
    $body = $item['contenido'];
    $autor = $item['autor'] ?? 'Administración';
    $autorRole = null;
    $esGlobal = empty($item['instituciones_id']);
} elseif ($tipoContenido === 'riesgo') {
    $heading = $item['titulo'];
    $body = $item['descripcion'];
    $autor = $item['autor'] ?? '';
    $autorRole = $item['autor_role'] ?? null;
    $esGlobal = false;
} else {
    $heading = $item['tipo'];
    $body = $item['descripcion'];
    $autor = $item['reporter'] ?? 'Anónimo';
    $autorRole = null;
    $esGlobal = false;
}
?>

<div class="school-module" style="max-width:900px;">
    <a href="?url=school#<?= e($backAnchor) ?>" class="school-btn secondary" style="margin-bottom:16px;display:inline-flex;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right:6px;"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Volver
    </a>

    <div class="school-card">
        <div class="school-detail-layout">
            <?php if (!empty($item['imagen'])): ?>
            <div class="school-detail-media">
                <img class="school-detail-img" src="<?= e($item['imagen']) ?>" alt="<?= e($heading) ?>">
            </div>
            <?php endif; ?>

            <div class="school-detail-text">
                <h1 style="font-family:var(--fd);font-size:1.6rem;margin:0 0 8px;">
                    <?= e($heading) ?>
                    <?php if ($esGlobal): ?><span class="chip b">Global</span><?php endif; ?>
                </h1>

                <?php
                $roleLabels = ['director' => 'Director', 'docente' => 'Docente', 'alumno' => 'Alumno', 'padre' => 'Padre/Encargado', 'administrativo' => 'Personal', 'admin' => 'Administración'];
                ?>
                <div class="school-blog-card-meta" style="margin-bottom:16px;">
                    <span><?= e($autor) ?><?= $autorRole ? ' (' . e($roleLabels[$autorRole] ?? $autorRole) . ')' : '' ?></span>
                    <span><?= e(date('d/m/Y H:i', strtotime($item['created_at']))) ?></span>
                </div>

                <?php if ($tipoContenido === 'incidente'): ?>
                    <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:14px;">
                        <?php if (!empty($item['ubicacion'])): ?><span class="school-incident-location"><?= e($item['ubicacion']) ?></span><?php endif; ?>
                        <span class="school-route-status <?= $item['estado'] === 'resuelto' ? 'despejada' : 'peligro' ?>"><?= $item['estado'] === 'resuelto' ? 'Resuelto' : 'Abierto' ?></span>
                    </div>
                <?php elseif ($tipoContenido === 'riesgo' && !empty($item['ubicacion'])): ?>
                    <div class="school-incident-location" style="margin-bottom:14px;"><?= e($item['ubicacion']) ?></div>
                <?php endif; ?>

                <p style="white-space:pre-wrap;line-height:1.6;"><?= e($body) ?></p>
            </div>
        </div>
    </div>

    <div class="school-card" style="margin-top:16px;">
        <button class="school-like-btn" id="likeBtn" onclick="toggleLike()">
            <span id="likeCount">0</span> Me gusta
        </button>
    </div>

    <div class="school-card" style="margin-top:16px;">
        <h3>Comentarios</h3>
        <form id="addCommentForm" style="margin-bottom:16px;">
            <div class="school-form-group">
                <textarea id="commentText" rows="2" maxlength="500" placeholder="Escribe un comentario..." required></textarea>
            </div>
            <button type="submit" class="school-btn primary">Comentar</button>
        </form>
        <div id="commentsList">
            <div class="text-center" style="padding:14px;color:var(--text3);">Cargando comentarios...</div>
        </div>
    </div>
</div>

<script>
    window.__ndaMyUserId = <?= json_encode($user['id'] ?? null) ?>;
    window.__ndaIsSchoolAdmin = <?= !empty($isSchoolAdmin) ? 'true' : 'false' ?>;
    window.__ndaContentTipo = <?= json_encode($tipoContenido) ?>;
    window.__ndaContentId = <?= json_encode((int) $contenidoId) ?>;
    document.addEventListener('DOMContentLoaded', function () { initInteractionBar(); });
</script>
<link rel="stylesheet" href="<?= asset('css/school.css') ?>">
<script src="<?= asset('js/school.js') ?>"></script>

<?php
$content = ob_get_clean();
require_once 'views/layout.php';
?>
