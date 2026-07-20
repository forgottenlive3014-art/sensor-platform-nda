<?php
$title = $title ?? 'Register';
$instituciones = $instituciones ?? [];
$prefillName = $prefillName ?? '';
$prefillEmail = $prefillEmail ?? '';
ob_start();
?>

<div class="auth-wrap auth-wrap-wizard">

    <canvas id="wave-left"></canvas>
    <canvas id="wave-right"></canvas>
    <canvas id="particles"></canvas>

    <div class="auth-card auth-card-wizard">
        <h1 class="auth-title">CREAR CUENTA</h1>
        <p class="auth-subtitle">Únete y comienza a monitorear</p>

        <div class="wiz-steps" id="wizSteps">
            <div class="wiz-step on" data-wiz-dot="1"><span>1</span>Tipo de cuenta</div>
            <div class="wiz-step" data-wiz-dot="2"><span>2</span>Rol</div>
            <div class="wiz-step" data-wiz-dot="3"><span>3</span>Institución</div>
            <div class="wiz-step" data-wiz-dot="4"><span>4</span>Tus datos</div>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="auth-alert error">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
                </svg>
                <?= e($_SESSION['error']); unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="?url=register" id="registerForm" novalidate>
            <?= csrfField() ?>
            <input type="hidden" name="account_type" id="fAccountType" value="general">
            <input type="hidden" name="inst_role" id="fInstRole" value="">
            <input type="hidden" name="institucion_id" id="fInstitucionId" value="">

            <!-- Paso 1: tipo de cuenta -->
            <div class="wiz-screen on" data-screen="1">
                <p class="wiz-question">¿Cómo vas a usar NDA?</p>
                <div class="wiz-cards">
                    <button type="button" class="wiz-card" data-account-type="general">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-6 8-6s8 2 8 6"/></svg>
                        <strong>Usuario general</strong>
                        <span>Información, simuladores y trivias. Podrás unirte a una institución después desde tu perfil.</span>
                    </button>
                    <button type="button" class="wiz-card" data-account-type="institutional">
                        <strong>Comunidad de una institución</strong>
                        <span>Director, docente, alumno, padre/encargado o personal administrativo de un centro educativo.</span>
                    </button>
                </div>
                <div class="wiz-nav">
                    <span></span>
                    <button type="button" class="auth-btn wiz-next" data-next="1" disabled>Continuar</button>
                </div>
            </div>

            <!-- Paso 2: rol institucional -->
            <div class="wiz-screen" data-screen="2">
                <p class="wiz-question">¿Cuál es tu rol en la institución?</p>
                <div class="wiz-cards wiz-cards-roles">
                    <button type="button" class="wiz-card wiz-card-sm" data-inst-role="director">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="7" width="18" height="14" rx="2"/><path d="M3 7l3-4h12l3 4"/><path d="M9 21v-6h6v6"/></svg>
                        <strong>Director / Administra la institución</strong>
                        <span>Registra el colegio y administra todo el módulo escolar.</span>
                    </button>
                    <button type="button" class="wiz-card wiz-card-sm" data-inst-role="docente">
                        <strong>Docente</strong>
                        <span>Gestiona tus secciones y pasa lista en simulacros.</span>
                    </button>
                    <button type="button" class="wiz-card wiz-card-sm" data-inst-role="alumno">
                        <strong>Alumno</strong>
                        <span>Consulta rutas, participa en simulacros y actividades.</span>
                    </button>
                    <button type="button" class="wiz-card wiz-card-sm" data-inst-role="padre">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="9" cy="7" r="3"/><circle cx="17" cy="8" r="2.4"/><path d="M2 21c0-3.5 3-5.5 7-5.5s7 2 7 5.5"/><path d="M15.5 15c2.7.4 4.5 2.1 4.5 4.5"/></svg>
                        <strong>Padre / Encargado</strong>
                        <span>Sigue el estado de tus hijos y recibe comunicados.</span>
                    </button>
                    <button type="button" class="wiz-card wiz-card-sm" data-inst-role="administrativo">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="8" width="18" height="12" rx="2"/><path d="M8 8V6a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                        <strong>Personal administrativo</strong>
                        <span>Anuncios, recursos e incidencias de apoyo logístico.</span>
                    </button>
                </div>
                <div class="wiz-nav">
                    <button type="button" class="auth-btn auth-btn-ghost wiz-back" data-back="1">Atrás</button>
                    <button type="button" class="auth-btn wiz-next" data-next="2" disabled>Continuar</button>
                </div>
            </div>

            <!-- Paso 3: institución -->
            <div class="wiz-screen" data-screen="3">
                <!-- 3a: crear institución (solo director) -->
                <div id="wizInstCreate" style="display:none">
                    <p class="wiz-question">Datos de la institución que administrarás</p>
                    <div class="auth-field">
                        <label>Nombre de la institución</label>
                        <div class="auth-inp-wrap">
                            <input type="text" name="inst_name" id="fInstName" placeholder="Ej. Colegio San José">
                        </div>
                    </div>
                    <div class="auth-field">
                        <label>Correo institucional (opcional)</label>
                        <div class="auth-inp-wrap">
                            <input type="email" name="inst_email" placeholder="info@colegio.edu.sv">
                        </div>
                    </div>
                    <div class="auth-field">
                        <label>Teléfono (opcional)</label>
                        <div class="auth-inp-wrap">
                            <input type="text" name="inst_phone" placeholder="2233-4455">
                        </div>
                    </div>
                    <div class="auth-field">
                        <label>Dirección (opcional)</label>
                        <div class="auth-inp-wrap">
                            <input type="text" name="inst_address" placeholder="San Salvador, El Salvador">
                        </div>
                    </div>
                </div>

                <!-- 3b: unirse a institución existente -->
                <div id="wizInstJoin" style="display:none">
                    <p class="wiz-question">Selecciona tu institución</p>
                    <div class="auth-field">
                        <label>Buscar institución</label>
                        <div class="auth-inp-wrap">
                            <span class="auth-inp-ico">
                                <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                            </span>
                            <input type="text" id="fInstSearch" placeholder="Escribe el nombre del colegio...">
                        </div>
                    </div>
                    <div class="wiz-inst-list" id="wizInstList">
                        <?php foreach ($instituciones as $inst): ?>
                            <button type="button" class="wiz-inst-item" data-id="<?= e($inst['instituciones_id']) ?>" data-name="<?= e($inst['nombre']) ?>">
                                <span><?= e($inst['nombre']) ?></span>
                            </button>
                        <?php endforeach; ?>
                        <?php if (empty($instituciones)): ?>
                            <p class="wiz-inst-empty">Aún no hay instituciones registradas. Pídele a tu director que cree la cuenta institucional primero.</p>
                        <?php endif; ?>
                    </div>
                    <p class="wiz-hint" id="wizInstSelected"></p>
                    <p class="wiz-hint">Tu solicitud quedará <strong>pendiente</strong> hasta que el director de esa institución la apruebe.</p>
                </div>

                <div class="wiz-nav">
                    <button type="button" class="auth-btn auth-btn-ghost wiz-back" data-back="2">Atrás</button>
                    <button type="button" class="auth-btn wiz-next" data-next="3">Continuar</button>
                </div>
            </div>

            <!-- Paso 4: datos personales -->
            <div class="wiz-screen" data-screen="4">
                <p class="wiz-question">Tus datos de acceso</p>
                <div class="auth-field">
                    <label>Nombre completo</label>
                    <div class="auth-inp-wrap">
                        <span class="auth-inp-ico"></span>
                        <input type="text" name="name" value="<?= e($prefillName) ?>" placeholder="Tu nombre completo" required>
                    </div>
                </div>

                <div class="auth-field">
                    <label>Nombre de usuario</label>
                    <div class="auth-inp-wrap">
                        <span class="auth-inp-ico">
                            <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="3.2"/><path d="M5 20c0-3.6 3.1-5.5 7-5.5s7 1.9 7 5.5"/></svg>
                        </span>
                        <input type="text" name="username" id="username-reg" placeholder="ej. azucena_hz" pattern="[a-z0-9_]{3,20}" title="3 a 20 caracteres: minúsculas, números y guion bajo" required>
                    </div>
                    <p class="wiz-hint" id="usernameHint">Es el nombre corto que se muestra en la barra de navegación: 3 a 20 caracteres, solo minúsculas, números y guion bajo.</p>
                </div>

                <div class="auth-field">
                    <label>Correo electrónico</label>
                    <div class="auth-inp-wrap">
                        <span class="auth-inp-ico">
                            <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        </span>
                        <input type="email" name="email" value="<?= e($prefillEmail) ?>" placeholder="ejemplo@correo.com" required>
                    </div>
                </div>

                <div class="auth-field">
                    <label>Contraseña</label>
                    <div class="auth-inp-wrap">
                        <span class="auth-inp-ico">
                            <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </span>
                        <input type="password" name="password" id="pwd-reg" placeholder="••••••••" required minlength="8">
                        <button type="button" class="auth-eye-btn" onclick="togglePwdReg()">
                            <svg viewBox="0 0 24 24" id="eye-ico-reg"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                    <ul class="pwd-rules" id="pwdRules">
                        <li data-rule="len">Al menos 8 caracteres</li>
                        <li data-rule="upper">Una mayúscula</li>
                        <li data-rule="lower">Una minúscula</li>
                        <li data-rule="num">Un número</li>
                        <li data-rule="sym">Un símbolo (!@#$%...)</li>
                    </ul>
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
                        <a>Acepto los Términos y la Política de Privacidad</a>
                    </label>
                </div>

                <div class="wiz-nav">
                    <button type="button" class="auth-btn auth-btn-ghost wiz-back" data-back="3">Atrás</button>
                    <button type="submit" class="auth-btn">Crear cuenta</button>
                </div>
            </div>
        </form>

        <div class="auth-divider">o continúa con</div>

        <div class="auth-socials" style="justify-content:center;">
            <div class="auth-social" id="googleSignInBtn" data-google-client-id="<?= e(env('GOOGLE_CLIENT_ID', '')) ?>" title="Registrarme con Google (crea una cuenta general)">
                <svg width="22" height="22" viewBox="0 0 48 48">
                    <path fill="#4285f4" d="M24 9.5c3.1 0 5.8 1.1 8 2.9l6-6C34.4 3.1 29.5 1 24 1 14.8 1 7 6.7 3.7 14.6l7 5.4C12.5 13.6 17.8 9.5 24 9.5z"/>
                    <path fill="#34a853" d="M46.1 24.5c0-1.6-.1-3.1-.4-4.5H24v8.5h12.4c-.5 2.8-2.1 5.2-4.5 6.8l7 5.4c4.1-3.8 6.5-9.4 6.5-16.2z"/>
                    <path fill="#fbbc04" d="M10.7 28.5A14.8 14.8 0 0 1 9.5 24c0-1.6.3-3.1.7-4.5l-7-5.4A23.9 23.9 0 0 0 0 24c0 3.9.9 7.6 2.6 10.9l7-5.4z"/>
                    <path fill="#ea4335" d="M24 47c5.4 0 10-1.8 13.3-4.8l-7-5.4C28.5 38.3 26.4 39 24 39c-6.2 0-11.5-4.2-13.3-9.9l-7 5.4C7 42.3 14.8 47 24 47z"/>
                </svg>
            </div>
        </div>

        <form id="googleLoginForm" method="POST" action="?url=google-login" style="display:none">
            <?= csrfField() ?>
            <input type="hidden" name="mode" value="register">
            <input type="hidden" name="credential" id="googleCredential">
        </form>

        <p class="auth-switch">¿Ya tienes cuenta? <a href="?url=login">Inicia sesión</a></p>
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

<script src="<?= asset('js/register-wizard.js') ?>"></script>

<?php
$content = ob_get_clean();
require_once 'layout.php';
?>
