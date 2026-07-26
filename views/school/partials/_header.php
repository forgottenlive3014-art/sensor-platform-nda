    <!-- ==================== HEADER ==================== -->
    <div class="school-header">
        <div class="school-header-left">
            <div class="school-header-icon">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 10 12 5 2 10l10 5 10-5Z"/>
                    <path d="M6 12v5c0 1 3 3 6 3s6-2 6-3v-5"/>
                </svg>
            </div>
            <div>
                <h1><?= e($panelTitle ?? 'Gestión Escolar') ?></h1>
                <p class="school-header-sub"><?= e($panelSubtitle ?? 'Administra estudiantes, docentes, rutas de evacuación, simulacros y más') ?></p>
            </div>
        </div>
        <div class="school-header-right">
            <?php $__headerRoleLabels = ['director' => 'Director', 'docente' => 'Docente', 'alumno' => 'Estudiante', 'padre' => 'Padre/Encargado', 'administrativo' => 'Personal', 'admin' => 'Administración']; ?>
            <span class="school-role-badge <?= $user['role'] ?? 'user' ?>">
                <span class="school-role-avatar"><?= e(mb_strtoupper(mb_substr($user['nombre'] ?? 'U', 0, 1))) ?></span>
                <span class="school-role-badge-text">
                    <?= e($user['nombre'] ?? 'Usuario') ?>
                    <em><?= e($__headerRoleLabels[$user['role'] ?? ''] ?? ($user['role'] ?? '')) ?></em>
                </span>
            </span>
        </div>
    </div>
