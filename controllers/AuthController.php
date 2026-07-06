<?php
class AuthController {

    // ---------------------------------------------------------------
    // LOGIN
    // ---------------------------------------------------------------
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
        $stmt = $db->prepare("SELECT u.*, i.nombre AS institucion_nombre
                               FROM usuarios u
                               LEFT JOIN instituciones i ON i.instituciones_id = u.institucion_id
                               WHERE u.email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && $this->verifyPassword($password, $user)) {
            $this->startSession($user);
            redirect('home');
        } else {
            $_SESSION['error'] = 'Correo o contraseña incorrectos.';
            redirect('login');
        }
    }

    // ---------------------------------------------------------------
    // Verifica la contraseña soportando ambos formatos de hash:
    //  - password_hash() (bcrypt/argon2) -> formato nuevo, correcto.
    //  - sha256 plano -> formato legado (cuentas creadas antes de este
    //    cambio). Si el login es correcto con el hash legado, lo
    //    re-hashea de inmediato con password_hash() para que la
    //    siguiente vez ya use el algoritmo seguro. Migracion
    //    transparente, sin forzar a nadie a resetear su contraseña.
    // ---------------------------------------------------------------
    private function verifyPassword($password, $user) {
        $stored = $user['contra'];

        // Formato nuevo: password_hash() siempre produce cadenas que
        // empiezan con "$" (ej. $2y$... para bcrypt, $argon2id$...).
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

    private function startSession($user) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['usuarios_id'];
        $_SESSION['user_name'] = $user['nombre'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['institucion_id'] = $user['institucion_id'] ?? null;
        $_SESSION['institucion_nombre'] = $user['institucion_nombre'] ?? null;
        $_SESSION['estado_institucional'] = $user['estado_institucional'] ?? 'ninguno';
    }

    // ---------------------------------------------------------------
    // REGISTRO (wizard: cuenta general vs. personal de institucion)
    // ---------------------------------------------------------------
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processRegister();
            return;
        }
        $db = getDB();
        $instituciones = $db->query("SELECT instituciones_id, nombre, correo FROM instituciones ORDER BY nombre ASC")->fetchAll();
        view('register', ['title' => 'Crear cuenta · NDA', 'instituciones' => $instituciones]);
    }

    private function processRegister() {
        if (!csrfValid($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Tu sesión expiró, intenta de nuevo.';
            redirect('register');
            return;
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['password_confirm'] ?? '';
        $accountType = $_POST['account_type'] ?? 'general'; // general | institutional
        $instRole = $_POST['inst_role'] ?? '';               // director|docente|alumno|padre|administrativo

        if (empty($name) || empty($email) || empty($password)) {
            $_SESSION['error'] = 'Todos los campos son obligatorios.';
            redirect('register');
            return;
        }
        if (strlen($password) < 6) {
            $_SESSION['error'] = 'La contraseña debe tener al menos 6 caracteres.';
            redirect('register');
            return;
        }
        if ($password !== $confirm) {
            $_SESSION['error'] = 'Las contraseñas no coinciden.';
            redirect('register');
            return;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Ingresa un correo electrónico válido.';
            redirect('register');
            return;
        }

        $db = getDB();

        $stmt = $db->prepare("SELECT usuarios_id FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $_SESSION['error'] = 'Ese correo ya está registrado.';
            redirect('register');
            return;
        }

        $role = 'user';
        $institucionId = null;
        $estadoInstitucional = 'ninguno';

        if ($accountType === 'institutional') {
            $validRoles = ['director', 'docente', 'alumno', 'padre', 'administrativo'];
            if (!in_array($instRole, $validRoles, true)) {
                $_SESSION['error'] = 'Selecciona un rol institucional válido.';
                redirect('register');
                return;
            }
            $role = $instRole;

            if ($instRole === 'director') {
                // El director FUNDA la institucion: se crea y queda aprobado de inmediato.
                $instName = trim($_POST['inst_name'] ?? '');
                $instEmail = trim($_POST['inst_email'] ?? '');
                $instPhone = trim($_POST['inst_phone'] ?? '');
                $instAddress = trim($_POST['inst_address'] ?? '');

                if (empty($instName)) {
                    $_SESSION['error'] = 'Ingresa el nombre de la institución que vas a administrar.';
                    redirect('register');
                    return;
                }

                $stmtI = $db->prepare("INSERT INTO instituciones (nombre, correo, telefono, direccion) VALUES (?, ?, ?, ?)");
                $stmtI->execute([$instName, $instEmail ?: null, $instPhone ?: null, $instAddress ?: null]);
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
                    $_SESSION['error'] = 'Selecciona la institución a la que perteneces.';
                    redirect('register');
                    return;
                }
                $stmtCheck = $db->prepare("SELECT instituciones_id FROM instituciones WHERE instituciones_id = ?");
                $stmtCheck->execute([$joinId]);
                if (!$stmtCheck->fetch()) {
                    $_SESSION['error'] = 'La institución seleccionada no existe.';
                    redirect('register');
                    return;
                }
                $institucionId = $joinId;
                $estadoInstitucional = 'pendiente';
            }
        }

        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO usuarios (nombre, email, contra, role, institucion_id, estado_institucional)
                               VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $hashed, $role, $institucionId, $estadoInstitucional]);
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

        // Cargar datos completos (incluye nombre de institucion) e iniciar sesion.
        $stmtU = $db->prepare("SELECT u.*, i.nombre AS institucion_nombre
                                FROM usuarios u
                                LEFT JOIN instituciones i ON i.instituciones_id = u.institucion_id
                                WHERE u.usuarios_id = ?");
        $stmtU->execute([$userId]);
        $newUser = $stmtU->fetch();
        $this->startSession($newUser);

        if ($estadoInstitucional === 'pendiente') {
            $_SESSION['success'] = 'Cuenta creada. Tu solicitud para unirte a la institución quedó pendiente de aprobación por el director.';
        } elseif ($role === 'director') {
            $_SESSION['success'] = '¡Institución registrada! Ya puedes configurar tu módulo de gestión escolar.';
        } else {
            $_SESSION['success'] = '¡Cuenta creada exitosamente! Bienvenido/a, ' . $name . '.';
        }
        redirect('home');
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

        $instituciones = $db->query("SELECT instituciones_id, nombre, correo FROM instituciones ORDER BY nombre ASC")->fetchAll();

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

    public function updateProfile() {
        if (!isLoggedIn()) { redirect('login'); return; }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { redirect('profile'); return; }
        if (!csrfValid($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Tu sesión expiró, intenta de nuevo.';
            redirect('profile');
            return;
        }

        $name = trim($_POST['name'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');

        if (empty($name)) {
            $_SESSION['error'] = 'El nombre no puede estar vacío.';
            redirect('profile');
            return;
        }

        $db = getDB();
        $stmt = $db->prepare("UPDATE usuarios SET nombre = ?, telefono = ? WHERE usuarios_id = ?");
        $stmt->execute([$name, $telefono ?: null, $_SESSION['user_id']]);

        $_SESSION['user_name'] = $name;
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
        $stmt = $db->prepare("SELECT instituciones_id, nombre, correo FROM instituciones WHERE nombre LIKE ? ORDER BY nombre ASC LIMIT 20");
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
