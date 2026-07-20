<?php
$title = $title ?? 'Verificar institución · NDA';
$pendingInstitution = $pendingInstitution ?? [];
ob_start();
?>

<div class="wrap profile-page" style="padding-top:100px;padding-bottom:70px;max-width:520px;">

    <?php if (isset($_SESSION['error'])): ?>
        <div class="profile-alert error"><?= e($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['success'])): ?>
        <div class="profile-alert success"><?= e($_SESSION['success']); unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <div class="profile-card">
        <h2>Verifica tu institución</h2>
        <p class="profile-hint">
            Enviamos un código de 6 dígitos a <strong><?= e($pendingInstitution['correo'] ?? '') ?></strong>
            para confirmar <strong><?= e($pendingInstitution['nombre'] ?? '') ?></strong>. El código expira 15 minutos después de enviarse.
        </p>

        <form method="POST" action="?url=school/verify-institution" class="profile-form">
            <?= csrfField() ?>
            <div class="profile-field">
                <label>Código de verificación</label>
                <input type="text" name="codigo" maxlength="6" pattern="[0-9]{6}" placeholder="000000" required autofocus>
            </div>
            <button type="submit" class="profile-btn">Verificar</button>
        </form>

        <form method="POST" action="?url=school/resend-verification-code" style="margin-top:14px;">
            <?= csrfField() ?>
            <button type="submit" class="profile-btn profile-btn-out">Reenviar código</button>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once 'views/layout.php';
?>
