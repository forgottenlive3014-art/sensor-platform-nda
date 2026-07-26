<?php
// Partial compartido: pastillas para saltar entre las 8 paginas de
// "Desastres". $currentSlug (definido en cada vista) marca la actual.
$__disItems = [
    'galeria-3d'            => 'Desastres',
    'sismos'                => 'Sismos',
    'volcanes'              => 'Volcanes',
    'tsunamis'              => 'Tsunamis',
    'inundaciones'          => 'Inundaciones',
    'deslizamientos'        => 'Deslizamientos',
    'incendios-forestales'  => 'Incendios Forestales',
    'tormentas-tropicales'  => 'Tormentas Tropicales',
    'sequias'               => 'Sequías',
];
?>
<div class="dis-quicknav">
    <?php foreach ($__disItems as $__slug => $__label): ?>
        <a class="dis-qn-item<?= $__slug === ($currentSlug ?? '') ? ' sel' : '' ?>" href="?url=<?= $__slug ?>"><?= $__label ?></a>
    <?php endforeach; ?>
</div>
