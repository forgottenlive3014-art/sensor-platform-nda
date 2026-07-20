<?php
$title = $title ?? 'Login';
ob_start();
?>

<div class="auth-wrap">

    <canvas id="wave-left"></canvas>
    <canvas id="wave-right"></canvas>
    <canvas id="particles"></canvas>

    <div class="auth-card">
        <h1 class="auth-title">INICIAR SESIÓN</h1>
        <p class="auth-subtitle">Accede a tu cuenta para continuar</p>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="auth-alert error">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
                </svg>
                <?= e($_SESSION['error']); unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="auth-alert success">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                <?= e($_SESSION['success']); unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="?url=login">
            <?= csrfField() ?>
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
                    <input type="password" name="password" placeholder="••••••••" id="pwd" required>
                    <button type="button" class="auth-eye-btn" onclick="togglePwd()">
                        <svg viewBox="0 0 24 24" id="eye-ico"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
            </div>

            <div class="auth-remember">
                <label><input type="checkbox" name="remember"> Recuérdame</label>
                <a href="#" class="auth-forgot">¿Olvidaste tu contraseña?</a>
            </div>

            <button type="submit" class="auth-btn">Ingresar</button>

            <div class="auth-divider">o continúa con</div>

            <div class="auth-socials">
                <div class="auth-social" id="googleSignInBtn" data-google-client-id="<?= e(env('GOOGLE_CLIENT_ID', '')) ?>" title="Continuar con Google">
                    <svg width="22" height="22" viewBox="0 0 48 48">
                        <path fill="#4285f4" d="M24 9.5c3.1 0 5.8 1.1 8 2.9l6-6C34.4 3.1 29.5 1 24 1 14.8 1 7 6.7 3.7 14.6l7 5.4C12.5 13.6 17.8 9.5 24 9.5z"/>
                        <path fill="#34a853" d="M46.1 24.5c0-1.6-.1-3.1-.4-4.5H24v8.5h12.4c-.5 2.8-2.1 5.2-4.5 6.8l7 5.4c4.1-3.8 6.5-9.4 6.5-16.2z"/>
                        <path fill="#fbbc04" d="M10.7 28.5A14.8 14.8 0 0 1 9.5 24c0-1.6.3-3.1.7-4.5l-7-5.4A23.9 23.9 0 0 0 0 24c0 3.9.9 7.6 2.6 10.9l7-5.4z"/>
                        <path fill="#ea4335" d="M24 47c5.4 0 10-1.8 13.3-4.8l-7-5.4C28.5 38.3 26.4 39 24 39c-6.2 0-11.5-4.2-13.3-9.9l-7 5.4C7 42.3 14.8 47 24 47z"/>
                    </svg>
                </div>
            </div>

            <p class="auth-switch">¿No tienes cuenta? <a href="?url=register">Regístrate</a></p>
        </form>

        <form id="googleLoginForm" method="POST" action="?url=google-login" style="display:none">
            <?= csrfField() ?>
            <input type="hidden" name="mode" value="login">
            <input type="hidden" name="credential" id="googleCredential">
        </form>
    </div>

    <div class="auth-hero">
        <div class="auth-robot-wrap">
            <div class="auth-robot-glow"></div>
            <canvas id="rings-canvas" width="320" height="80"></canvas>
             <img src="assets/media/img/bot1.png" class="auth-robot-img" alt="BotA">
        </div>
    </div>

    <div class="auth-bubble">
        <div class="auth-bubble-box">
            <div class="auth-bubble-head">
                <span class="auth-bubble-ico">
                    <svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                </span>
                <div class="auth-bubble-title">¿Qué verás en NDA? <span></span></div>
            </div>
            <p class="auth-bubble-desc" id="bubbleTextLogin"> - Sismógrafo en tiemo real con  Arduino.       
                - Información sobre la prevención de sismos</p>
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