    <!-- ==================== HEADER ==================== -->
    <!-- Mismo diseño de saludo que el Panel de Gestión (mascota +
         eyebrow + saludo + subtítulo), para que se vea igual en todo
         el módulo de Gestión Escolar (esta página, panel del docente
         y panel de Admin General). -->
    <div class="school-content-greeting" id="schoolGreeting">
        <div class="school-greeting-mascot" aria-hidden="true">
            <img src="<?= asset('media/img/chatbot.png') ?>" alt="">
        </div>
        <div class="school-greeting-text">
            <p class="school-eyebrow"><?= e($panelTitle ?? 'Gestión Escolar') ?></p>
            <h2><span id="schoolGreetingWord">Hola</span>, <?= e(explode(' ', trim($user['nombre'] ?? 'Usuario'))[0]) ?></h2>
            <p class="school-header-sub"><?= e($panelSubtitle ?? 'Administra estudiantes, docentes, rutas de evacuación, simulacros y más') ?></p>
        </div>
    </div>
