<?php
$title = $title ?? 'Registrar institución · NDA';
ob_start();
?>

<div class="wrap profile-page" style="padding-top:100px;padding-bottom:70px;max-width:640px;">

    <?php if (isset($_SESSION['error'])): ?>
        <div class="profile-alert error"><?= e($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['success'])): ?>
        <div class="profile-alert success"><?= e($_SESSION['success']); unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <div class="profile-card">
        <h2>Registrar mi institución</h2>
        <p class="profile-hint">Registra tu colegio, escuela, instituto o universidad en NDA. Verificaremos el correo institucional antes de activar tu acceso como director/a.</p>

        <form method="POST" action="?url=school/register-institution" class="profile-form">
            <?= csrfField() ?>
            <div class="profile-field">
                <label>Nombre de la institución *</label>
                <input type="text" name="nombre" required>
            </div>
            <div class="profile-field">
                <label>Tipo de institución *</label>
                <select name="tipo" required>
                    <option value="colegio">Colegio</option>
                    <option value="escuela">Escuela</option>
                    <option value="instituto">Instituto</option>
                    <option value="universidad">Universidad</option>
                    <option value="otro">Otro</option>
                </select>
            </div>
            <div class="profile-field">
                <label>Correo institucional *</label>
                <input type="email" name="correo" placeholder="direccion@tuinstitucion.edu.sv" required>
            </div>
            <div class="profile-field">
                <label>Nombre del director/a *</label>
                <input type="text" name="nombre_director" required>
            </div>
            <div class="profile-field">
                <label>Dirección *</label>
                <input type="text" name="direccion" required>
            </div>
            <div class="profile-field">
                <label>Teléfono *</label>
                <input type="text" name="telefono" required>
            </div>
            <div class="profile-field">
                <label>Correo personal del director/a (opcional)</label>
                <input type="email" name="correo_director_personal" placeholder="tu-correo-profesional@gmail.com">
            </div>
            <button type="submit" class="profile-btn">Registrar y enviar código de verificación</button>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once 'views/layout.php';
?>
