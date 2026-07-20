    <!-- ==================== HEADER ==================== -->
    <div class="school-header">
        <div class="school-header-left">
            <div class="school-header-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 4h9l5 5v11a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"/><path d="M9 12h6M9 16h6"/></svg></div>
            <div>
                <h1><?= e($panelTitle ?? 'Gestión Escolar') ?></h1>
                <p class="school-header-sub"><?= e($panelSubtitle ?? 'Administra alumnos, docentes, rutas de evacuación, simulacros y más') ?></p>
            </div>
        </div>
        <div class="school-header-right">
            <span class="school-role-badge <?= $user['role'] ?? 'user' ?>">
                <?= e(!empty($user['username']) ? $user['username'] : strtok($user['nombre'] ?? 'Usuario', ' ')) ?>
                <span style="font-size:0.65rem;opacity:0.6;"><?= e($user['role'] ?? '') ?></span>
            </span>
        </div>
    </div>
