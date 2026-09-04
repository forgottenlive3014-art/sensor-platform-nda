<?php
class AuthController {

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processLogin();
            return;
        }
        view('login', ['title' => 'Iniciar sesión · NDA']);
    }

    private function processLogin() {
        if (!csrfValid($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Tu sesión expiró, intenta de nuevo.';
            redirect('login');
            return;
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $_SESSION['error'] = 'Completa todos los campos.';
            redirect('login');
            return;
        }

        $db = getDB();
        $stmt = $db->prepare("SELECT u.*, i.nombre AS institucion_nombre, i.estado_verificacion AS institucion_estado_verificacion
                               FROM usuarios u
                               LEFT JOIN instituciones i ON i.instituciones_id = u.institucion_id
                               WHERE u.email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && $this->verifyPassword($password, $user)) {
            // El director de una institucion cuyo correo institucional aun no
            // se verifico no debe poder entrar de largo: lo mandamos de vuelta
            // a la pantalla de codigo en vez de abrirle la sesion completa.
            if ($user['role'] === 'director' && $user['institucion_estado_verificacion'] === 'pendiente') {
                $_SESSION['pending_verify_institucion_id'] = $user['institucion_id'];
                $_SESSION['pending_verify_user_id'] = $user['usuarios_id'];
                $_SESSION['error'] = 'Primero debes verificar el correo de tu institución.';
                redirect('register/verify');
                return;
            }
            // Cuenta creada antes de confirmar el codigo de su correo personal
            // (o que nunca lo confirmo): no la dejamos entrar hasta que lo haga.
            if (empty($user['email_verificado'])) {
                $_SESSION['pending_verify_account_user_id'] = $user['usuarios_id'];
                $_SESSION['error'] = 'Primero debes verificar tu correo electrónico.';
                redirect('register/verify-account');
                return;
            }
            $this->startSession($user);
            redirect('home');
        } else {
            $_SESSION['error'] = 'Correo o contraseña incorrectos.';
            redirect('login');
        }
    }

    // Soporta hashes legados (sha256 plano) y los re-hashea a password_hash() en el login.
    private function verifyPassword($password, $user) {
        $stored = $user['contra'];

        if (strpos($stored, '$') === 0) {
            return password_verify($password, $stored);
        }

        // Formato legado: sha256 sin sal.
        if (hash('sha256', $password) === $stored) {
            $newHash = password_hash($password, PASSWORD_DEFAULT);
            $db = getDB();
            $db->prepare("UPDATE usuarios SET contra = ? WHERE usuarios_id = ?")
               ->execute([$newHash, $user['usuarios_id']]);
            return true;
        }

        return false;
    }

    // Contraseña fuerte: minimo 8 caracteres, mayuscula, minuscula, numero y simbolo.
    // Devuelve null si es valida, o el mensaje de error si no.
    private function passwordStrengthError($password) {
        if (strlen($password) < 8) {
            return 'La contraseña debe tener al menos 8 caracteres.';
        }
        if (!preg_match('/[A-Z]/', $password)) {
            return 'La contraseña debe incluir al menos una mayúscula.';
        }
        if (!preg_match('/[a-z]/', $password)) {
            return 'La contraseña debe incluir al menos una minúscula.';
        }
        if (!preg_match('/[0-9]/', $password)) {
            return 'La contraseña debe incluir al menos un número.';
        }
        if (!preg_match('/[^A-Za-z0-9]/', $password)) {
            return 'La contraseña debe incluir al menos un símbolo (por ejemplo: ! @ # $ %).';
        }
        return null;
    }

    // Ademas del formato, confirma que el dominio del correo exista de verdad
    // (tenga registro MX, o al menos A/AAAA) para filtrar dominios inventados.
    private function isRealEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        $domain = substr(strrchr($email, '@'), 1);
        if (!$domain) {
            return false;
        }
        if (checkdnsrr($domain, 'MX')) {
            return true;
        }
        // Algunos dominios reciben correo sin registro MX propio (usan el A).
        return checkdnsrr($domain, 'A') || checkdnsrr($domain, 'AAAA');
    }

    // Nombre de usuario corto para el navbar (el nombre completo puede ser
    // largo y romper el layout). Solo minusculas, numeros y guion bajo.
    // Devuelve null si es valido, o el mensaje de error si no.
    private function usernameError($username, $excludeId = null) {
        if (!preg_match('/^[a-z0-9_]{3,20}$/', $username)) {
            return 'El nombre de usuario debe tener entre 3 y 20 caracteres: solo minúsculas, números y guion bajo.';
        }
        $db = getDB();
        $sql = "SELECT usuarios_id FROM usuarios WHERE username = ?";
        $params = [$username];
        if ($excludeId) {
            $sql .= " AND usuarios_id != ?";
            $params[] = $excludeId;
        }
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        if ($stmt->fetch()) {
            return 'Ese nombre de usuario ya está en uso.';
        }
        return null;
    }

    // Chequeo en vivo de username/email mientras se escribe el paso 4 del
    // registro (assets/js/register-wizard.js), para avisar "ya está en
    // uso" antes de enviar el formulario. Sin esto, un choque de username
    // solo se detectaba al enviar todo el wizard, y el redirect() de
    // processRegister() perdia los pasos ya llenados (institucion, rol...).
    public function checkAvailability() {
        $field = $_GET['field'] ?? '';
        $value = trim($_GET['value'] ?? '');

        if ($field === 'username') {
            $error = $this->usernameError(strtolower($value));
            jsonResponse(['available' => $error === null, 'error' => $error]);
            return;
        }

        if ($field === 'email') {
            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                jsonResponse(['available' => false, 'error' => 'Ingresa un correo electrónico válido.']);
                return;
            }
            $db = getDB();
            $stmt = $db->prepare("SELECT usuarios_id FROM usuarios WHERE email = ?");
            $stmt->execute([$value]);
            $inUse = (bool) $stmt->fetch();
            jsonResponse(['available' => !$inUse, 'error' => $inUse ? 'Ese correo ya está registrado.' : null]);
            return;
        }

        jsonResponse(['error' => 'Campo inválido'], 400);
    }

    // Genera un username disponible a partir de un texto base (nombre o
    // correo), usado cuando la cuenta se crea via Google y no pedimos uno
    // a mano. Ej: "Azucena Hernández" -> "azucena_hernandez", "azucena_hernandez2"...
    private function generateUsername($base) {
        $slug = strtolower($base);
        if (function_exists('transliterator_transliterate')) {
            $slug = transliterator_transliterate('Any-Latin; Latin-ASCII;', $slug);
        } else {
            $slug = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $slug);
        }
        $slug = preg_replace('/[^a-z0-9]+/', '_', $slug);
        $slug = trim($slug, '_');
        $slug = substr($slug, 0, 16) ?: 'usuario';
        if (strlen($slug) < 3) {
            $slug = str_pad($slug, 3, '0');
        }

        $db = getDB();
        $candidate = $slug;
        $i = 2;
        $stmt = $db->prepare("SELECT usuarios_id FROM usuarios WHERE username = ?");
        while (true) {
            $stmt->execute([$candidate]);
            if (!$stmt->fetch()) {
                return $candidate;
            }
            $candidate = substr($slug, 0, 20 - strlen((string) $i)) . $i;
            $i++;
        }
    }

    private function startSession($user) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['usuarios_id'];
        $_SESSION['user_name'] = $user['nombre'];
        $_SESSION['username'] = $user['username'] ?? null;
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['institucion_id'] = $user['institucion_id'] ?? null;
        $_SESSION['institucion_nombre'] = $user['institucion_nombre'] ?? null;
        $_SESSION['estado_institucional'] = $user['estado_institucional'] ?? 'ninguno';
    }

    // Inicio de sesion con Google (Google Identity Services). Inactivo hasta que
    // se configure GOOGLE_CLIENT_ID en .env: sin esa clave, responde con error
    // en vez de intentar validar nada, para que el boton simplemente no funcione
    // todavia sin romper la pagina.
    public function googleLogin() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { redirect('login'); return; }
        if (!csrfValid($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Tu sesión expiró, intenta de nuevo.';
            redirect('login');
            return;
        }

        // "login": solo entra si la cuenta ya existe; si no, se manda a
        // completar el registro. "register": crea la cuenta si no existe,
        // o inicia sesion directamente si el correo ya estaba registrado.
        $mode = ($_POST['mode'] ?? 'login') === 'register' ? 'register' : 'login';

        $clientId = env('GOOGLE_CLIENT_ID', '');
        $credential = $_POST['credential'] ?? '';
        if (empty($clientId) || empty($credential)) {
            $_SESSION['error'] = 'El inicio de sesión con Google todavía no está disponible.';
            redirect($mode === 'register' ? 'register' : 'login');
            return;
        }

        // Verificamos el token directamente con Google (sin libreria pesada):
        // si el aud no coincide con nuestro Client ID, o el correo no viene
        // verificado por Google, lo rechazamos.
        $ch = curl_init('https://oauth2.googleapis.com/tokeninfo?id_token=' . urlencode($credential));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 8);
        $response = curl_exec($ch);
        curl_close($ch);
        $payload = $response ? json_decode($response, true) : null;

        if (!$payload || ($payload['aud'] ?? '') !== $clientId || ($payload['email_verified'] ?? 'false') !== 'true' || empty($payload['email'])) {
            $_SESSION['error'] = 'No se pudo verificar tu cuenta de Google.';
            redirect($mode === 'register' ? 'register' : 'login');
            return;
        }

        $email = $payload['email'];
        $name = $payload['name'] ?? $email;

        $db = getDB();
        $stmt = $db->prepare("SELECT u.*, i.nombre AS institucion_nombre
                               FROM usuarios u
                               LEFT JOIN instituciones i ON i.instituciones_id = u.institucion_id
                               WHERE u.email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user) {
            if ($mode === 'login') {
                // No hay cuenta con ese correo: no la creamos a ciegas desde
                // el boton de "iniciar sesion". Mandamos a completar el
                // registro, con el nombre/correo de Google ya rellenados.
                $_SESSION['google_prefill_name'] = $name;
                $_SESSION['google_prefill_email'] = $email;
                $_SESSION['error'] = 'No encontramos una cuenta con ese correo de Google. Completa tu registro para continuar.';
                redirect('register');
                return;
            }

            // Cuenta general nueva. Nunca se crea con rol admin ni institucional
            // via Google: eso solo se asigna a mano o pidiendo unirse despues.
            // Google no pide un username, asi que generamos uno disponible a
            // partir del nombre; el usuario puede cambiarlo despues en su perfil.
            $randomHash = password_hash(bin2hex(random_bytes(32)), PASSWORD_DEFAULT);
            $newUsername = $this->generateUsername($name);
            // email_verificado = 1: Google ya confirmo mas arriba que
            // email_verified === 'true' antes de llegar aqui.
            $db->prepare("INSERT INTO usuarios (nombre, username, email, contra, role, institucion_id, estado_institucional, email_verificado)
                           VALUES (?, ?, ?, ?, 'user', NULL, 'ninguno', 1)")
               ->execute([$name, $newUsername, $email, $randomHash]);
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            $this->startSession($user);
            $_SESSION['success'] = '¡Cuenta creada con Google! Bienvenido/a, ' . $name . '.';
            redirect('home');
            return;
        }

        $this->startSession($user);
        $_SESSION['success'] = $mode === 'register'
            ? 'Ya tenías una cuenta con este correo — iniciamos sesión por ti.'
            : '¡Sesión iniciada con Google!';
        redirect('home');
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processRegister();
            return;
        }
        $db = getDB();
        $instituciones = $db->query("SELECT instituciones_id, nombre, correo FROM instituciones WHERE estado_verificacion = 'verificado' ORDER BY nombre ASC")->fetchAll();

        // Si venimos de "iniciar sesion con Google" sin cuenta existente,
        // rellenamos nombre/correo para que no los vuelva a escribir.
        $prefillName = $_SESSION['google_prefill_name'] ?? '';
        $prefillEmail = $_SESSION['google_prefill_email'] ?? '';
        unset($_SESSION['google_prefill_name'], $_SESSION['google_prefill_email']);

        view('register', [
            'title' => 'Crear cuenta · NDA',
            'instituciones' => $instituciones,
            'prefillName' => $prefillName,
            'prefillEmail' => $prefillEmail,
        ]);
    }

    private function processRegister() {
        if (!csrfValid($_POST['csrf_token'] ?? '')) {
            jsonResponse(['error' => 'Tu sesión expiró, recarga la página e intenta de nuevo.'], 400);
            return;
        }

        $name = trim($_POST['name'] ?? '');
        $username = strtolower(trim($_POST['username'] ?? ''));
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['password_confirm'] ?? '';
        $accountType = $_POST['account_type'] ?? 'general'; // general | institutional
        $instRole = $_POST['inst_role'] ?? '';               // director|docente|alumno|padre|administrativo

        if (empty($name) || empty($username) || empty($email) || empty($password)) {
            jsonResponse(['error' => 'Todos los campos son obligatorios.'], 400);
            return;
        }
        $usernameError = $this->usernameError($username);
        if ($usernameError) {
            jsonResponse(['error' => $usernameError], 400);
            return;
        }
        $passwordError = $this->passwordStrengthError($password);
        if ($passwordError) {
            jsonResponse(['error' => $passwordError], 400);
            return;
        }
        if ($password !== $confirm) {
            jsonResponse(['error' => 'Las contraseñas no coinciden.'], 400);
            return;
        }
        if (empty($_POST['terms'])) {
            jsonResponse(['error' => 'Debes aceptar los Términos y la Política de Privacidad para crear tu cuenta.'], 400);
            return;
        }
        if (!$this->isRealEmail($email)) {
            jsonResponse(['error' => 'Ingresa un correo electrónico real (revisa que esté bien escrito).'], 400);
            return;
        }

        $db = getDB();

        $stmt = $db->prepare("SELECT usuarios_id FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            jsonResponse(['error' => 'Ese correo ya está registrado.'], 400);
            return;
        }

        $role = 'user';
        $institucionId = null;
        $estadoInstitucional = 'ninguno';

        if ($accountType === 'institutional') {
            $validRoles = ['director', 'docente', 'alumno', 'padre', 'administrativo'];
            if (!in_array($instRole, $validRoles, true)) {
                jsonResponse(['error' => 'Selecciona un rol institucional válido.'], 400);
                return;
            }
            $role = $instRole;

            if ($instRole === 'director') {
                // El director FUNDA la institucion: se crea con la verificacion de
                // correo pendiente. El acceso al panel escolar queda bloqueado
                // hasta que confirme el codigo que se le manda al correo
                // institucional (ver processVerifyEmail()).
                $instName = trim($_POST['inst_name'] ?? '');
                $instTipo = $_POST['inst_tipo'] ?? '';
                $instEmail = trim($_POST['inst_email'] ?? '');
                $instDirectorEmail = trim($_POST['inst_director_email'] ?? '');
                $instPhone = trim($_POST['inst_phone'] ?? '');
                $instAddress = trim($_POST['inst_address'] ?? '');

                $validTipos = ['colegio', 'escuela', 'instituto', 'universidad', 'otro'];
                if (empty($instName)) {
                    jsonResponse(['error' => 'Ingresa el nombre de la institución que vas a administrar.'], 400);
                    return;
                }
                if (!in_array($instTipo, $validTipos, true)) {
                    jsonResponse(['error' => 'Selecciona el tipo de institución.'], 400);
                    return;
                }
                if (!$this->isRealEmail($instEmail)) {
                    jsonResponse(['error' => 'Ingresa un correo institucional real: ahí te enviaremos el código de verificación.'], 400);
                    return;
                }
                if ($instDirectorEmail !== '' && !$this->isRealEmail($instDirectorEmail)) {
                    jsonResponse(['error' => 'El correo personal del director/a no es válido.'], 400);
                    return;
                }

                $verifyCode = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                $verifyExpira = date('Y-m-d H:i:s', time() + 3 * 60);

                $stmtI = $db->prepare("INSERT INTO instituciones
                    (nombre, tipo, correo, correo_director_personal, telefono, direccion, nombre_director, estado_verificacion, codigo_verificacion, codigo_verificacion_expira)
                    VALUES (?, ?, ?, ?, ?, ?, ?, 'pendiente', ?, ?)");
                $stmtI->execute([$instName, $instTipo, $instEmail, $instDirectorEmail ?: null, $instPhone ?: null, $instAddress ?: null, $name, $verifyCode, $verifyExpira]);
                $institucionId = $db->lastInsertId();
                $estadoInstitucional = 'aprobado';

                // Crea automaticamente las 18 secciones de bachillerato:
                // 6 de 1er año, 6 de 2do año, 6 de 3er año (A-F).
                $this->seedBachilleratoSections($db, $institucionId);
            } else {
                // Docente / Alumno / Padre / Administrativo: se unen a una institucion
                // ya existente. Queda pendiente hasta que el director la apruebe.
                $joinId = $_POST['institucion_id'] ?? '';
                if (empty($joinId)) {
                    jsonResponse(['error' => 'Selecciona la institución a la que perteneces.'], 400);
                    return;
                }
                $stmtCheck = $db->prepare("SELECT instituciones_id FROM instituciones WHERE instituciones_id = ?");
                $stmtCheck->execute([$joinId]);
                if (!$stmtCheck->fetch()) {
                    jsonResponse(['error' => 'La institución seleccionada no existe.'], 400);
                    return;
                }
                $institucionId = $joinId;
                $estadoInstitucional = 'pendiente';
            }
        }

        $hashed = password_hash($password, PASSWORD_DEFAULT);
        // El director verifica su correo indirectamente al confirmar el
        // codigo que se manda al correo institucional (mas abajo), asi que
        // no necesita ademas verificar su correo personal.
        $emailVerificado = $role === 'director' ? 1 : 0;
        $stmt = $db->prepare("INSERT INTO usuarios (nombre, username, email, contra, role, institucion_id, estado_institucional, email_verificado)
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $username, $email, $hashed, $role, $institucionId, $estadoInstitucional, $emailVerificado]);
        $userId = $db->lastInsertId();

        if ($role === 'director') {
            $db->prepare("UPDATE instituciones SET director_id = ? WHERE instituciones_id = ?")
               ->execute([$userId, $institucionId]);
        }

        if ($estadoInstitucional === 'pendiente') {
            $msg = trim($_POST['join_message'] ?? '');
            $stmtS = $db->prepare("INSERT INTO solicitudes_institucion (usuarios_id, instituciones_id, rol_solicitado, mensaje)
                                    VALUES (?, ?, ?, ?)");
            $stmtS->execute([$userId, $institucionId, $role, $msg ?: null]);
        }

        if ($role === 'director') {
            // No se inicia sesion todavia: primero debe confirmar el codigo
            // que se le mando al correo institucional.
            $_SESSION['pending_verify_institucion_id'] = $institucionId;
            $_SESSION['pending_verify_user_id'] = $userId;
            $sent = Mailer::sendVerificationCode($instEmail, $name, $verifyCode);
            if ($sent) {
                $_SESSION['success'] = 'Institución creada. Te enviamos un código de verificación a ' . $instEmail . '.';
            } else {
                $_SESSION['error'] = 'Institución creada, pero no pudimos enviar el correo de verificación. Usa "Reenviar código" en la siguiente pantalla.';
            }
            jsonResponse(['success' => true, 'redirect' => '?url=register/verify']);
            return;
        }

        // No se inicia sesion todavia: primero debe confirmar el codigo que
        // se le manda a SU correo personal (evita cuentas con un correo
        // inventado/ajeno que "dejaban entrar" sin comprobar nada).
        $verifyCodeAccount = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $verifyExpiraAccount = date('Y-m-d H:i:s', time() + 3 * 60);
        $db->prepare("UPDATE usuarios SET codigo_verificacion_email = ?, codigo_verificacion_email_expira = ? WHERE usuarios_id = ?")
           ->execute([$verifyCodeAccount, $verifyExpiraAccount, $userId]);

        $_SESSION['pending_verify_account_user_id'] = $userId;
        $sentAccount = Mailer::sendAccountVerificationCode($email, $name, $verifyCodeAccount);
        if ($sentAccount) {
            $_SESSION['success'] = 'Casi listo — te enviamos un código de verificación a ' . $email . '.';
        } else {
            $_SESSION['error'] = 'Cuenta creada, pero no pudimos enviar el correo de verificación. Usa "Reenviar código" en la siguiente pantalla.';
        }
        jsonResponse(['success' => true, 'redirect' => '?url=register/verify-account']);
    }

    // ---------------------------------------------------------------
    // VERIFICACION DE CORREO DE LA INSTITUCION (solo flujo de fundacion)
    // ---------------------------------------------------------------
    public function verifyEmail() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processVerifyEmail();
            return;
        }

        $institucionId = $_SESSION['pending_verify_institucion_id'] ?? null;
        if (!$institucionId) {
            redirect('login');
            return;
        }

        $db = getDB();
        $stmt = $db->prepare("SELECT nombre, correo FROM instituciones WHERE instituciones_id = ?");
        $stmt->execute([$institucionId]);
        $institucion = $stmt->fetch();
        if (!$institucion) {
            redirect('login');
            return;
        }

        view('verify-email', [
            'title' => 'Verifica tu institución · NDA',
            'institucion' => $institucion,
        ]);
    }

    private function processVerifyEmail() {
        if (!csrfValid($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Tu sesión expiró, intenta de nuevo.';
            redirect('register/verify');
            return;
        }

        $institucionId = $_SESSION['pending_verify_institucion_id'] ?? null;
        $userId = $_SESSION['pending_verify_user_id'] ?? null;
        if (!$institucionId || !$userId) {
            redirect('login');
            return;
        }

        $code = trim($_POST['code'] ?? '');
        $db = getDB();
        $stmt = $db->prepare("SELECT codigo_verificacion, codigo_verificacion_expira FROM instituciones WHERE instituciones_id = ?");
        $stmt->execute([$institucionId]);
        $institucion = $stmt->fetch();

        if (!$institucion || empty($institucion['codigo_verificacion'])) {
            $_SESSION['error'] = 'No hay una verificación pendiente. Solicita un nuevo código.';
            redirect('register/verify');
            return;
        }
        if (strtotime($institucion['codigo_verificacion_expira']) < time()) {
            $_SESSION['error'] = 'El código venció. Solicita uno nuevo.';
            redirect('register/verify');
            return;
        }
        if (!hash_equals((string) $institucion['codigo_verificacion'], $code)) {
            $_SESSION['error'] = 'El código no es correcto.';
            redirect('register/verify');
            return;
        }

        $db->prepare("UPDATE instituciones SET estado_verificacion = 'verificado', codigo_verificacion = NULL, codigo_verificacion_expira = NULL WHERE instituciones_id = ?")
           ->execute([$institucionId]);

        unset($_SESSION['pending_verify_institucion_id'], $_SESSION['pending_verify_user_id']);

        $stmtU = $db->prepare("SELECT u.*, i.nombre AS institucion_nombre
                                FROM usuarios u
                                LEFT JOIN instituciones i ON i.instituciones_id = u.institucion_id
                                WHERE u.usuarios_id = ?");
        $stmtU->execute([$userId]);
        $user = $stmtU->fetch();
        if (!$user) {
            redirect('login');
            return;
        }

        $this->startSession($user);
        $_SESSION['success'] = '¡Institución verificada! Ya puedes configurar tu módulo de gestión escolar.';
        redirect('home');
    }

    public function resendVerificationCode() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('register/verify');
            return;
        }
        if (!csrfValid($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Tu sesión expiró, intenta de nuevo.';
            redirect('register/verify');
            return;
        }

        $institucionId = $_SESSION['pending_verify_institucion_id'] ?? null;
        if (!$institucionId) {
            redirect('login');
            return;
        }

        $db = getDB();
        $stmt = $db->prepare("SELECT nombre, correo, nombre_director FROM instituciones WHERE instituciones_id = ?");
        $stmt->execute([$institucionId]);
        $institucion = $stmt->fetch();
        if (!$institucion || empty($institucion['correo'])) {
            redirect('register/verify');
            return;
        }

        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $expira = date('Y-m-d H:i:s', time() + 3 * 60);
        $db->prepare("UPDATE instituciones SET codigo_verificacion = ?, codigo_verificacion_expira = ? WHERE instituciones_id = ?")
           ->execute([$code, $expira, $institucionId]);

        $sent = Mailer::sendVerificationCode($institucion['correo'], $institucion['nombre_director'] ?: $institucion['nombre'], $code);

        if ($sent) {
            $_SESSION['success'] = 'Te enviamos un nuevo código a ' . $institucion['correo'] . '.';
        } else {
            $_SESSION['error'] = 'No pudimos enviar el correo. Intenta de nuevo en unos minutos.';
        }
        redirect('register/verify');
    }

    // ---------------------------------------------------------------
    // VERIFICACION DEL CORREO PERSONAL (registro general / institucional
    // no-director). Sin esto, isRealEmail() solo comprobaba que el DOMINIO
    // reciba correo (ej. "gmail.com"), no que esa cuenta en particular sea
    // real o le pertenezca a quien se registro — cualquier
    // "cosaqueseinventen@gmail.com" pasaba el registro y entraba de una vez.
    // ---------------------------------------------------------------
    public function verifyAccountEmail() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processVerifyAccountEmail();
            return;
        }

        $userId = $_SESSION['pending_verify_account_user_id'] ?? null;
        if (!$userId) {
            redirect('login');
            return;
        }

        $db = getDB();
        $stmt = $db->prepare("SELECT nombre, email FROM usuarios WHERE usuarios_id = ?");
        $stmt->execute([$userId]);
        $accountUser = $stmt->fetch();
        if (!$accountUser) {
            redirect('login');
            return;
        }

        view('verify-account-email', [
            'title' => 'Verifica tu correo · NDA',
            'accountUser' => $accountUser,
        ]);
    }

    private function processVerifyAccountEmail() {
        if (!csrfValid($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Tu sesión expiró, intenta de nuevo.';
            redirect('register/verify-account');
            return;
        }

        $userId = $_SESSION['pending_verify_account_user_id'] ?? null;
        if (!$userId) {
            redirect('login');
            return;
        }

        $code = trim($_POST['code'] ?? '');
        $db = getDB();
        $stmt = $db->prepare("SELECT codigo_verificacion_email, codigo_verificacion_email_expira FROM usuarios WHERE usuarios_id = ?");
        $stmt->execute([$userId]);
        $row = $stmt->fetch();

        if (!$row || empty($row['codigo_verificacion_email'])) {
            $_SESSION['error'] = 'No hay una verificación pendiente. Inicia sesión o regístrate de nuevo.';
            redirect('login');
            return;
        }
        if (strtotime($row['codigo_verificacion_email_expira']) < time()) {
            $_SESSION['error'] = 'El código venció. Solicita uno nuevo.';
            redirect('register/verify-account');
            return;
        }
        if (!hash_equals((string) $row['codigo_verificacion_email'], $code)) {
            $_SESSION['error'] = 'El código no es correcto.';
            redirect('register/verify-account');
            return;
        }

        $db->prepare("UPDATE usuarios SET email_verificado = 1, codigo_verificacion_email = NULL, codigo_verificacion_email_expira = NULL WHERE usuarios_id = ?")
           ->execute([$userId]);

        unset($_SESSION['pending_verify_account_user_id']);

        $stmtU = $db->prepare("SELECT u.*, i.nombre AS institucion_nombre
                                FROM usuarios u
                                LEFT JOIN instituciones i ON i.instituciones_id = u.institucion_id
                                WHERE u.usuarios_id = ?");
        $stmtU->execute([$userId]);
        $user = $stmtU->fetch();
        if (!$user) {
            redirect('login');
            return;
        }

        $this->startSession($user);
        $_SESSION['success'] = '¡Correo verificado! Bienvenido/a, ' . $user['nombre'] . '.';
        redirect('home');
    }

    public function resendAccountVerificationCode() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('register/verify-account');
            return;
        }
        if (!csrfValid($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Tu sesión expiró, intenta de nuevo.';
            redirect('register/verify-account');
            return;
        }

        $userId = $_SESSION['pending_verify_account_user_id'] ?? null;
        if (!$userId) {
            redirect('login');
            return;
        }

        $db = getDB();
        $stmt = $db->prepare("SELECT nombre, email FROM usuarios WHERE usuarios_id = ?");
        $stmt->execute([$userId]);
        $accountUser = $stmt->fetch();
        if (!$accountUser) {
            redirect('login');
            return;
        }

        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $expira = date('Y-m-d H:i:s', time() + 3 * 60);
        $db->prepare("UPDATE usuarios SET codigo_verificacion_email = ?, codigo_verificacion_email_expira = ? WHERE usuarios_id = ?")
           ->execute([$code, $expira, $userId]);

        $sent = Mailer::sendAccountVerificationCode($accountUser['email'], $accountUser['nombre'], $code);

        if ($sent) {
            $_SESSION['success'] = 'Te enviamos un nuevo código a ' . $accountUser['email'] . '.';
        } else {
            $_SESSION['error'] = 'No pudimos enviar el correo. Intenta de nuevo en unos minutos.';
        }
        redirect('register/verify-account');
    }

    // ---------------------------------------------------------------
    // PERFIL (editar datos + solicitar unirse a una institucion)
    // ---------------------------------------------------------------
    public function profile() {
        if (!isLoggedIn()) { redirect('login'); return; }

        $db = getDB();
        $stmt = $db->prepare("SELECT u.*, i.nombre AS institucion_nombre
                               FROM usuarios u
                               LEFT JOIN instituciones i ON i.instituciones_id = u.institucion_id
                               WHERE u.usuarios_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();

        // La sesion apunta a un usuario que ya no existe en la BD (p. ej.
        // reimportaste la base de datos pero el navegador conserva la
        // cookie de sesion vieja). Cerramos la sesion en vez de romper
        // la pagina con warnings de "array offset on false".
        if (!$user) {
            $_SESSION = [];
            session_destroy();
            $_SESSION = [];
            session_start();
            $_SESSION['error'] = 'Tu sesión ya no es válida. Inicia sesión de nuevo.';
            redirect('login');
            return;
        }

        $instituciones = $db->query("SELECT instituciones_id, nombre, correo FROM instituciones WHERE estado_verificacion = 'verificado' ORDER BY nombre ASC")->fetchAll();

        $pendingRequest = null;
        if ($user['estado_institucional'] === 'pendiente') {
            $stmtP = $db->prepare("SELECT s.*, i.nombre AS institucion_nombre
                                    FROM solicitudes_institucion s
                                    JOIN instituciones i ON i.instituciones_id = s.instituciones_id
                                    WHERE s.usuarios_id = ? AND s.estado = 'pendiente'
                                    ORDER BY s.created_at DESC LIMIT 1");
            $stmtP->execute([$_SESSION['user_id']]);
            $pendingRequest = $stmtP->fetch();
        }

        view('profile', [
            'title' => 'Mi perfil · NDA',
            'profileUser' => $user,
            'instituciones' => $instituciones,
            'pendingRequest' => $pendingRequest,
        ]);
    }

    // Guarda una foto de perfil subida en assets/media/uploads/perfiles/ y
    // devuelve la ruta relativa (o false si el archivo no es una imagen valida).
    // Disponible para cualquier rol (a diferencia de DocenteController::storeUploadedPhoto,
    // que solo aplica al flujo especifico de docentes en el modulo escolar).
    private function storeUploadedPhoto($file) {
        $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
        $mime = mime_content_type($file['tmp_name']);
        if (!isset($allowed[$mime])) return false;
        if ($file['size'] > 5 * 1024 * 1024) return false;

        $dir = __DIR__ . '/../assets/media/uploads/perfiles';
        if (!is_dir($dir)) mkdir($dir, 0755, true);

        $name = uniqid('perfil_', true) . '.' . $allowed[$mime];
        move_uploaded_file($file['tmp_name'], $dir . '/' . $name);

        return 'assets/media/uploads/perfiles/' . $name;
    }

    public function updateProfile() {
        if (!isLoggedIn()) { redirect('login'); return; }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { redirect('profile'); return; }
        if (!csrfValid($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Tu sesión expiró, intenta de nuevo.';
            redirect('profile');
            return;
        }

        $name = trim($_POST['name'] ?? '');
        $username = strtolower(trim($_POST['username'] ?? ''));
        $telefono = trim($_POST['telefono'] ?? '');

        if (empty($name) || empty($username)) {
            $_SESSION['error'] = 'El nombre y el nombre de usuario no pueden estar vacíos.';
            redirect('profile');
            return;
        }
        $usernameError = $this->usernameError($username, $_SESSION['user_id']);
        if ($usernameError) {
            $_SESSION['error'] = $usernameError;
            redirect('profile');
            return;
        }

        $fotoPath = null;
        if (!empty($_FILES['foto']['name']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $fotoPath = $this->storeUploadedPhoto($_FILES['foto']);
            if ($fotoPath === false) {
                $_SESSION['error'] = 'La imagen no es válida (usa JPG, PNG o WEBP, máx. 5MB).';
                redirect('profile');
                return;
            }
        }

        $db = getDB();
        if ($fotoPath !== null) {
            $stmt = $db->prepare("UPDATE usuarios SET nombre = ?, username = ?, telefono = ?, foto_perfil = ? WHERE usuarios_id = ?");
            $stmt->execute([$name, $username, $telefono ?: null, $fotoPath, $_SESSION['user_id']]);
            $_SESSION['foto_perfil'] = $fotoPath;
        } else {
            $stmt = $db->prepare("UPDATE usuarios SET nombre = ?, username = ?, telefono = ? WHERE usuarios_id = ?");
            $stmt->execute([$name, $username, $telefono ?: null, $_SESSION['user_id']]);
        }

        $_SESSION['user_name'] = $name;
        $_SESSION['username'] = $username;
        $_SESSION['success'] = 'Perfil actualizado.';
        redirect('profile');
    }

    // Un usuario general pide unirse a una institucion ya registrada.
    public function requestJoinInstitution() {
        if (!isLoggedIn()) { redirect('login'); return; }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { redirect('profile'); return; }
        if (!csrfValid($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Tu sesión expiró, intenta de nuevo.';
            redirect('profile');
            return;
        }
        // El Admin General ya supervisa todas las instituciones; no aplica
        // solicitar ingreso a una en particular.
        if (currentUser()['role'] === 'admin') {
            redirect('profile');
            return;
        }

        $institucionId = $_POST['institucion_id'] ?? '';
        $rol = $_POST['rol_solicitado'] ?? '';
        $mensaje = trim($_POST['join_message'] ?? '');
        $validRoles = ['docente', 'alumno', 'padre', 'administrativo'];

        if (empty($institucionId) || !in_array($rol, $validRoles, true)) {
            $_SESSION['error'] = 'Selecciona una institución y un rol válidos.';
            redirect('profile');
            return;
        }

        $db = getDB();
        $stmt = $db->prepare("INSERT INTO solicitudes_institucion (usuarios_id, instituciones_id, rol_solicitado, mensaje)
                               VALUES (?, ?, ?, ?)");
        $stmt->execute([$_SESSION['user_id'], $institucionId, $rol, $mensaje ?: null]);

        $db->prepare("UPDATE usuarios SET institucion_id = ?, estado_institucional = 'pendiente' WHERE usuarios_id = ?")
           ->execute([$institucionId, $_SESSION['user_id']]);

        $_SESSION['institucion_id'] = $institucionId;
        $_SESSION['estado_institucional'] = 'pendiente';
        $_SESSION['success'] = 'Solicitud enviada. El director de la institución debe aprobarla desde Gestión Escolar.';
        redirect('profile');
    }

    // Un usuario general (incluye cuentas creadas con Google) funda una
    // institucion nueva desde su perfil. Mismo flujo que el registro
    // tradicional: la institucion queda con verificacion de correo
    // pendiente y se cierra la sesion actual hasta que confirme el codigo.
    public function foundInstitution() {
        if (!isLoggedIn()) { redirect('login'); return; }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { redirect('profile'); return; }
        if (!csrfValid($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Tu sesión expiró, intenta de nuevo.';
            redirect('profile');
            return;
        }

        $user = currentUser();
        if ($user['role'] !== 'user' || $user['estado_institucional'] !== 'ninguno') {
            $_SESSION['error'] = 'Solo puedes fundar una institución si aún no perteneces a ninguna.';
            redirect('profile');
            return;
        }

        $instName = trim($_POST['inst_name'] ?? '');
        $instTipo = $_POST['inst_tipo'] ?? '';
        $instEmail = trim($_POST['inst_email'] ?? '');
        $instDirectorEmail = trim($_POST['inst_director_email'] ?? '');
        $instPhone = trim($_POST['inst_phone'] ?? '');
        $instAddress = trim($_POST['inst_address'] ?? '');

        $validTipos = ['colegio', 'escuela', 'instituto', 'universidad', 'otro'];
        if (empty($instName)) {
            $_SESSION['error'] = 'Ingresa el nombre de la institución que vas a administrar.';
            redirect('profile');
            return;
        }
        if (!in_array($instTipo, $validTipos, true)) {
            $_SESSION['error'] = 'Selecciona el tipo de institución.';
            redirect('profile');
            return;
        }
        if (!$this->isRealEmail($instEmail)) {
            $_SESSION['error'] = 'Ingresa un correo institucional real: ahí te enviaremos el código de verificación.';
            redirect('profile');
            return;
        }
        if ($instDirectorEmail !== '' && !$this->isRealEmail($instDirectorEmail)) {
            $_SESSION['error'] = 'El correo personal del director/a no es válido.';
            redirect('profile');
            return;
        }

        $db = getDB();
        $userId = $_SESSION['user_id'];
        $stmtName = $db->prepare("SELECT nombre FROM usuarios WHERE usuarios_id = ?");
        $stmtName->execute([$userId]);
        $name = $stmtName->fetchColumn();

        $verifyCode = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $verifyExpira = date('Y-m-d H:i:s', time() + 3 * 60);

        $stmtI = $db->prepare("INSERT INTO instituciones
            (nombre, tipo, correo, correo_director_personal, telefono, direccion, nombre_director, estado_verificacion, codigo_verificacion, codigo_verificacion_expira)
            VALUES (?, ?, ?, ?, ?, ?, ?, 'pendiente', ?, ?)");
        $stmtI->execute([$instName, $instTipo, $instEmail, $instDirectorEmail ?: null, $instPhone ?: null, $instAddress ?: null, $name, $verifyCode, $verifyExpira]);
        $institucionId = $db->lastInsertId();

        $db->prepare("UPDATE usuarios SET role = 'director', institucion_id = ?, estado_institucional = 'aprobado' WHERE usuarios_id = ?")
           ->execute([$institucionId, $userId]);
        $db->prepare("UPDATE instituciones SET director_id = ? WHERE instituciones_id = ?")
           ->execute([$userId, $institucionId]);

        $this->seedBachilleratoSections($db, $institucionId);

        // Cierra la sesion actual (como en el registro nuevo): no queda logueado
        // como director hasta que confirme el codigo de la institucion.
        unset($_SESSION['user_id'], $_SESSION['user_name'], $_SESSION['username'], $_SESSION['user_email'],
              $_SESSION['user_role'], $_SESSION['institucion_id'], $_SESSION['institucion_nombre'], $_SESSION['estado_institucional']);

        $_SESSION['pending_verify_institucion_id'] = $institucionId;
        $_SESSION['pending_verify_user_id'] = $userId;
        $sent = Mailer::sendVerificationCode($instEmail, $name, $verifyCode);
        if ($sent) {
            $_SESSION['success'] = 'Institución creada. Te enviamos un código de verificación a ' . $instEmail . '.';
        } else {
            $_SESSION['error'] = 'Institución creada, pero no pudimos enviar el correo de verificación. Usa "Reenviar código" en la siguiente pantalla.';
        }
        redirect('register/verify');
    }

    public function cancelJoinRequest() {
        if (!isLoggedIn()) { redirect('login'); return; }
        if (!csrfValid($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Tu sesión expiró, intenta de nuevo.';
            redirect('profile');
            return;
        }

        $db = getDB();
        $db->prepare("UPDATE solicitudes_institucion SET estado = 'rechazado', resolved_at = NOW()
                       WHERE usuarios_id = ? AND estado = 'pendiente'")
           ->execute([$_SESSION['user_id']]);
        $db->prepare("UPDATE usuarios SET institucion_id = NULL, estado_institucional = 'ninguno' WHERE usuarios_id = ?")
           ->execute([$_SESSION['user_id']]);

        $_SESSION['institucion_id'] = null;
        $_SESSION['estado_institucional'] = 'ninguno';
        $_SESSION['success'] = 'Solicitud cancelada.';
        redirect('profile');
    }

    // Devuelve instituciones en JSON, usado por el buscador del wizard de registro/perfil.
    public function institutionsList() {
        $db = getDB();
        $q = '%' . ($_GET['q'] ?? '') . '%';
        $stmt = $db->prepare("SELECT instituciones_id, nombre, correo FROM instituciones WHERE nombre LIKE ? AND estado_verificacion = 'verificado' ORDER BY nombre ASC LIMIT 20");
        $stmt->execute([$q]);
        jsonResponse($stmt->fetchAll());
    }

    // Crea las secciones estandar de bachillerato para una institucion nueva:
    // 1° A-F, 2° A-F, 3° A-F (18 aulas en total).
    private function seedBachilleratoSections($db, $institucionId) {
        $anios = ['1° Año', '2° Año', '3° Año'];
        $secciones = ['A', 'B', 'C', 'D', 'E', 'F'];
        $stmt = $db->prepare("INSERT INTO aulas (nombre, grado, nivel, seccion, instituciones_id)
                               VALUES (?, ?, 'Bachillerato', ?, ?)");
        foreach ($anios as $grado) {
            foreach ($secciones as $sec) {
                $nombre = $grado . ' ' . $sec;
                $stmt->execute([$nombre, $grado, $sec, $institucionId]);
            }
        }
    }

    // ---------------------------------------------------------------
    public function logout() {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();
        redirect('home');
    }
}
