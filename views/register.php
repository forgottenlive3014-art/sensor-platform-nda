<?php
$title = $title ?? 'Register';
ob_start();
?>

<div class="auth-wrap">

    <!-- CANVAS PARA ONDAS Y PARTÍCULAS -->
    <canvas id="wave-left"></canvas>
    <canvas id="wave-right"></canvas>
    <canvas id="particles"></canvas>

    <!-- FORM CARD -->
    <div class="auth-card">
        <h1 class="auth-title">CREAR CUENTA</h1>
        <p class="auth-subtitle">Únete y comienza a monitorear</p>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="auth-alert error">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
                </svg>
                <?= e($_SESSION['error']); unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="?url=register">
            <div class="auth-field">
                <label>Nombre completo</label>
                <div class="auth-inp-wrap">
                    <span class="auth-inp-ico">
                        <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </span>
                    <input type="text" name="name" placeholder="Tu nombre completo" required>
                </div>
            </div>

            <div class="auth-field">
                <label>Correo electrónico</label>
                <div class="auth-inp-wrap">
                    <span class="auth-inp-ico">
                        <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    </span>
                    <input type="email" name="email" placeholder="ejemplo@correo.com" required>
                </div>
            </div>

            <div class="auth-field">
                <label>Contraseña</label>
                <div class="auth-inp-wrap">
                    <span class="auth-inp-ico">
                        <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    </span>
                    <input type="password" name="password" id="pwd-reg" placeholder="••••••••" required minlength="6">
                    <button type="button" class="auth-eye-btn" onclick="togglePwdReg()">
                        <svg viewBox="0 0 24 24" id="eye-ico-reg"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
            </div>

            <div class="auth-field">
                <label>Confirmar contraseña</label>
                <div class="auth-inp-wrap">
                    <span class="auth-inp-ico">
                        <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    </span>
                    <input type="password" name="password_confirm" id="pwd-conf" placeholder="••••••••" required>
                    <button type="button" class="auth-eye-btn" onclick="togglePwdConf()">
                        <svg viewBox="0 0 24 24" id="eye-ico-conf"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
            </div>

            <div class="auth-remember">
                <label class="auth-terms">
                    <input type="checkbox" name="terms" required>
                    <a>Acepto losTérminos Política de Privacidad</a>
                </label>
            </div>

            <button type="submit" class="auth-btn">Crear cuenta</button>

            <p class="auth-switch">¿Ya tienes cuenta? <a href="?url=login">Inicia sesión</a></p>
        </form>
    </div>

    <!-- HERO CENTER - ROBOT -->
    <div class="auth-hero">
        <div class="auth-robot-wrap">
            <div class="auth-robot-glow"></div>
            <canvas id="rings-canvas" width="320" height="80"></canvas>
             <img src="assets/media/img/bot1.png" class="auth-robot-img" alt="BotA">
        </div>
    </div>

    <!-- BUBBLE -->
    <div class="auth-bubble">
        <div class="auth-bubble-box">
            <div class="auth-bubble-head">
                <span class="auth-bubble-ico">
                    <svg viewBox="0 0 24 24"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26 12,2"/></svg>
                </span>
                <div class="auth-bubble-title">SismoBot <span>dice...</span></div>
            </div>
            <p class="auth-bubble-desc" id="bubbleTextRegister">Únete y protege tu comunidad</p>
            <div class="auth-bubble-foot">
                <div class="auth-dots">
                    <span class="auth-dot on"></span>
                    <span class="auth-dot"></span>
                    <span class="auth-dot"></span>
                </div>
            </div>
        </div>
    </div>

</div>

<?php
$content = ob_get_clean();
require_once 'layout.php';
?>