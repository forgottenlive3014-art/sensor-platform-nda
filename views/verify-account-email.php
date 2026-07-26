<?php
$title = $title ?? 'Verifica tu correo · NDA';
$accountUser = $accountUser ?? [];
ob_start();
?>

<div class="auth-wrap">

    <canvas id="wave-left"></canvas>
    <canvas id="wave-right"></canvas>
    <canvas id="particles"></canvas>

    <div class="auth-card">
        <h1 class="auth-title">VERIFICA TU CORREO</h1>
        <p class="auth-subtitle">
            Enviamos un código de 6 dígitos a
            <strong><?= e($accountUser['email'] ?? '') ?></strong>
            para confirmar tu cuenta en NDA.
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

        <form method="POST" action="?url=register/verify-account">
            <?= csrfField() ?>
            <div class="auth-field">
                <label>Código de verificación</label>
                <div class="auth-inp-wrap">
                    <input type="text" name="code" inputmode="numeric" pattern="[0-9]{6}" maxlength="6"
                           placeholder="000000" style="letter-spacing:8px;text-align:center;font-size:1.3rem" required autofocus>
                </div>
                <p class="wiz-hint">El código vence 15 minutos después de enviarse.</p>
            </div>

            <button type="submit" class="auth-btn">Verificar</button>
        </form>

        <form method="POST" action="?url=register/resend-account-code">
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
