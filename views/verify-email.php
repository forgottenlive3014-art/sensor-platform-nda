<?php
$title = $title ?? 'Verifica tu institución · NDA';
$institucion = $institucion ?? [];
ob_start();
?>

<div class="auth-wrap auth-wrap-verify">

    <canvas id="wave-left"></canvas>
    <canvas id="wave-right"></canvas>
    <canvas id="particles"></canvas>

    <div class="auth-hero">
        <div class="auth-verify-bubble">¡Revisa el correo de tu institución! Te enviamos un código para confirmarla.</div>
        <div class="auth-robot-wrap">
            <div class="auth-robot-glow"></div>
            <img src="assets/media/img/alegre.png" class="auth-robot-img" alt="">
        </div>
    </div>

    <div class="auth-card">
        <div class="auth-title-row">
            <div class="auth-icon-badge">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                </svg>
            </div>
            <h1 class="auth-title">VERIFICA<br>TU INSTITUCIÓN</h1>
        </div>
        <p class="auth-subtitle">
            Enviamos un código de 6 dígitos a
            <strong><?= e($institucion['correo'] ?? '') ?></strong>
            para confirmar <?= e($institucion['nombre'] ?? 'tu institución') ?>.
        </p>

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

        <form method="POST" action="?url=register/verify">
            <?= csrfField() ?>
            <div class="auth-field">
                <label>Código de verificación</label>
                <div class="auth-inp-wrap">
                    <input type="text" name="code" inputmode="numeric" pattern="[0-9]{6}" maxlength="6"
                           placeholder="000000" style="letter-spacing:8px;text-align:center;font-size:1.3rem" required autofocus>
                </div>
                <p class="wiz-hint">El código vence 3 minutos después de enviarse.</p>
            </div>

            <button type="submit" class="auth-btn">Verificar</button>
        </form>

        <form method="POST" action="?url=register/resend-code">
            <?= csrfField() ?>
            <p class="auth-switch">¿No te llegó? <button type="submit" class="auth-link-btn">Reenviar código</button></p>
        </form>

        <p class="auth-switch"><a href="?url=logout">Cancelar y salir</a></p>
    </div>

</div>

<?php
$content = ob_get_clean();
require_once 'layout.php';
?>
