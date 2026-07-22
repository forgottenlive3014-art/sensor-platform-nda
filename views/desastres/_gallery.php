<?php
// Partial compartido: galeria de imagenes. Cada pagina define $galleryItems
// antes de incluir este archivo, como un array de:
//   ['img' => 'https://...', 'cap' => 'Descripcion', 'credit' => 'Fuente']
// Si un item no trae 'img' (o es un string plano), se muestra el placeholder
// punteado de "espacio para imagen" en su lugar.
$galleryItems = $galleryItems ?? [];
?>
<div class="dis-gallery-grid">
    <?php foreach ($galleryItems as $__g): ?>
        <?php $__cap = is_array($__g) ? ($__g['cap'] ?? '') : $__g; ?>
        <?php if (is_array($__g) && !empty($__g['img'])): ?>
        <div class="dis-gallery-item filled">
            <img src="<?= e($__g['img']) ?>" alt="<?= e($__cap) ?>" loading="lazy">
            <div class="dis-gallery-cap-ov">
                <span><?= e($__cap) ?></span>
                <?php if (!empty($__g['credit'])): ?><small><?= e($__g['credit']) ?></small><?php endif; ?>
            </div>
        </div>
        <?php else: ?>
        <div class="dis-gallery-item">
            <svg class="dis-gallery-ico" width="1.6em" height="1.6em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="9" cy="9" r="2"/><path d="M21 15l-5-5L5 21"/></svg>
            <span class="dis-gallery-cap"><?= e($__cap) ?></span>
            <span class="dis-gallery-hint">Espacio para imagen</span>
        </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
