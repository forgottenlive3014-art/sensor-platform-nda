    <!-- ==================== HEADER ==================== -->
    <div class="school-header">
        <div class="school-header-left">
            <div>
                <h1><?= e($panelTitle ?? 'Gestión Escolar') ?></h1>
                <p class="school-header-sub"><?= e($panelSubtitle ?? 'Administra alumnos, docentes, rutas de evacuación, simulacros y más') ?></p>
            </div>
        </div>
        <div class="school-header-right">
            <span class="school-role-badge <?= $user['role'] ?? 'user' ?>">
                <?= e($user['nombre'] ?? 'Usuario') ?>
                <span style="font-size:0.65rem;opacity:0.6;"><?= e($user['role'] ?? '') ?></span>
            </span>
        </div>
    </div>
