<?php
require_once __DIR__ . '/../models/InstitutionModel.php';

class InstitucionController {

    // Solo el Admin General administra instituciones.
    private function isAdminGeneral() {
        $u = currentUser();
        return $u && $u['role'] === 'admin';
    }

    public function list() {
        if (!isLoggedIn() || !$this->isAdminGeneral()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $model = new InstitutionModel();
        $search = trim($_GET['q'] ?? '');
        $page = (int) ($_GET['page'] ?? 1);
        $perPage = (int) ($_GET['per_page'] ?? 10);

        $rows = $model->getPage($search, $page, $perPage);
        $total = $model->countAll($search);

        jsonResponse([
            'data' => $rows,
            'total' => $total,
            'page' => max(1, $page),
            'per_page' => $perPage,
            'total_pages' => $perPage > 0 ? (int) ceil($total / $perPage) : 1,
        ]);
    }

    public function create() {
        if (!isLoggedIn() || !$this->isAdminGeneral()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $input = json_decode(file_get_contents('php://input'), true);
        $nombre = trim($input['nombre'] ?? '');
        $correo = trim($input['correo'] ?? '');

        if (empty($nombre)) {
            jsonResponse(['error' => 'El nombre de la institución es obligatorio'], 400);
        }

        $model = new InstitutionModel();
        if ($correo !== '' && $model->emailExists($correo)) {
            jsonResponse(['error' => 'Ese correo institucional ya está registrado'], 400);
        }

        $id = $model->create([
            'nombre' => $nombre,
            'correo' => $correo,
            'telefono' => trim($input['telefono'] ?? ''),
            'direccion' => trim($input['direccion'] ?? ''),
            'lat' => $input['lat'] ?? null,
            'lng' => $input['lng'] ?? null,
        ]);

        jsonResponse(['success' => true, 'id' => $id]);
    }

    public function update() {
        if (!isLoggedIn() || !$this->isAdminGeneral()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['id'] ?? null;
        $nombre = trim($input['nombre'] ?? '');

        if (!$id) {
            jsonResponse(['error' => 'ID de institución requerido'], 400);
        }
        if (empty($nombre)) {
            jsonResponse(['error' => 'El nombre de la institución es obligatorio'], 400);
        }

        $model = new InstitutionModel();
        if (!$model->getById($id)) {
            jsonResponse(['error' => 'Institución no encontrada'], 404);
        }
        $correo = trim($input['correo'] ?? '');
        if ($correo !== '' && $model->emailExists($correo, $id)) {
            jsonResponse(['error' => 'Ese correo institucional ya está registrado'], 400);
        }

        $model->update($id, [
            'nombre' => $nombre,
            'correo' => $correo,
            'telefono' => trim($input['telefono'] ?? ''),
            'direccion' => trim($input['direccion'] ?? ''),
            'lat' => $input['lat'] ?? null,
            'lng' => $input['lng'] ?? null,
        ]);

        jsonResponse(['success' => true]);
    }

    public function stats() {
        if (!isLoggedIn() || !$this->isAdminGeneral()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $id = $_GET['id'] ?? null;
        if (!$id) {
            jsonResponse(['error' => 'ID de institución requerido'], 400);
        }
        $model = new InstitutionModel();
        if (!$model->getById($id)) {
            jsonResponse(['error' => 'Institución no encontrada'], 404);
        }
        jsonResponse(['success' => true, 'stats' => $model->getStats($id)]);
    }

    public function delete() {
        if (!isLoggedIn() || !$this->isAdminGeneral()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $id = $_GET['id'] ?? null;
        if (!$id) {
            jsonResponse(['error' => 'ID de institución requerido'], 400);
        }

        $model = new InstitutionModel();
        if (!$model->getById($id)) {
            jsonResponse(['error' => 'Institución no encontrada'], 404);
        }
        $model->delete($id);

        jsonResponse(['success' => true]);
    }

    // ------------------------------------------------------------------
    // Registro público de instituciones con verificación por correo.
    // Cualquier usuario logueado con role='user' (todavía sin institución)
    // puede registrar una institución nueva y convertirse en su director
    // una vez que verifica el código enviado al correo institucional.
    // ------------------------------------------------------------------

    private function generateVerificationCode() {
        return str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    public function registerInstitution() {
        if (!isLoggedIn()) { redirect('login'); return; }
        if (currentUser()['role'] !== 'user') { redirect('profile'); return; }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processRegisterInstitution();
            return;
        }
        view('school/register-institution', ['title' => 'Registrar institución · NDA']);
    }

    private function processRegisterInstitution() {
        if (!csrfValid($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Tu sesión expiró, intenta de nuevo.';
            redirect('school/register-institution');
            return;
        }

        $nombre = trim($_POST['nombre'] ?? '');
        $tipo = $_POST['tipo'] ?? '';
        $correo = trim($_POST['correo'] ?? '');
        $nombreDirector = trim($_POST['nombre_director'] ?? '');
        $direccion = trim($_POST['direccion'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $correoDirectorPersonal = trim($_POST['correo_director_personal'] ?? '');
        $validTipos = ['colegio', 'escuela', 'instituto', 'universidad', 'otro'];

        if (empty($nombre) || empty($nombreDirector) || empty($direccion) || empty($telefono)) {
            $_SESSION['error'] = 'Completa todos los campos obligatorios.';
            redirect('school/register-institution');
            return;
        }
        if (!in_array($tipo, $validTipos, true)) {
            $_SESSION['error'] = 'Selecciona un tipo de institución válido.';
            redirect('school/register-institution');
            return;
        }
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Ingresa un correo institucional válido.';
            redirect('school/register-institution');
            return;
        }
        if ($correoDirectorPersonal !== '' && !filter_var($correoDirectorPersonal, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'El correo personal del director no es válido.';
            redirect('school/register-institution');
            return;
        }

        $model = new InstitutionModel();
        if ($model->emailExists($correo)) {
            $_SESSION['error'] = 'Ese correo institucional ya está registrado en NDA.';
            redirect('school/register-institution');
            return;
        }

        $codigo = $this->generateVerificationCode();
        $expira = date('Y-m-d H:i:s', strtotime('+15 minutes'));
        $id = $model->createPending([
            'nombre' => $nombre,
            'tipo' => $tipo,
            'correo' => $correo,
            'correo_director_personal' => $correoDirectorPersonal,
            'nombre_director' => $nombreDirector,
            'telefono' => $telefono,
            'direccion' => $direccion,
            'director_id' => currentUser()['id'],
        ], $codigo, $expira);

        $enviado = sendVerificationEmail($correo, $nombre, $codigo);
        $_SESSION[$enviado ? 'success' : 'error'] = $enviado
            ? 'Institución registrada. Te enviamos un código de verificación a ' . $correo . '.'
            : 'La institución se registró, pero no pudimos enviar el correo. Usa "Reenviar código" para intentar de nuevo.';
        redirect('school/verify-institution');
    }

    public function verifyInstitution() {
        if (!isLoggedIn()) { redirect('login'); return; }
        if (currentUser()['role'] !== 'user') { redirect('profile'); return; }

        $model = new InstitutionModel();
        $pending = $model->getPendingByDirector(currentUser()['id']);
        if (!$pending) {
            $_SESSION['error'] = 'No tienes ninguna institución pendiente de verificación.';
            redirect('school/register-institution');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processVerifyInstitution($model, $pending);
            return;
        }
        view('school/verify-institution', ['title' => 'Verificar institución · NDA', 'pendingInstitution' => $pending]);
    }

    private function processVerifyInstitution($model, $pending) {
        if (!csrfValid($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Tu sesión expiró, intenta de nuevo.';
            redirect('school/verify-institution');
            return;
        }
        $codigo = trim($_POST['codigo'] ?? '');

        if ($codigo === '' || $codigo !== $pending['codigo_verificacion']) {
            $_SESSION['error'] = 'El código ingresado no es correcto.';
            redirect('school/verify-institution');
            return;
        }
        if (strtotime($pending['codigo_verificacion_expira']) < time()) {
            $_SESSION['error'] = 'El código expiró. Solicita uno nuevo.';
            redirect('school/verify-institution');
            return;
        }

        $model->markVerified($pending['instituciones_id']);

        $db = getDB();
        $codigoInstitucional = generateCodigoInstitucional($db);
        $stmt = $db->prepare("
            UPDATE usuarios
            SET role = 'director', institucion_id = ?, estado_institucional = 'aprobado', codigo_institucional = ?
            WHERE usuarios_id = ?
        ");
        $stmt->execute([$pending['instituciones_id'], $codigoInstitucional, currentUser()['id']]);

        $_SESSION['success'] = '¡Institución verificada! Ya puedes acceder a Gestión Escolar como director.';
        redirect('school');
    }

    public function resendVerificationCode() {
        if (!isLoggedIn() || $_SERVER['REQUEST_METHOD'] !== 'POST') { redirect('school/verify-institution'); return; }
        if (!csrfValid($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Tu sesión expiró, intenta de nuevo.';
            redirect('school/verify-institution');
            return;
        }

        $model = new InstitutionModel();
        $pending = $model->getPendingByDirector(currentUser()['id']);
        if (!$pending) {
            redirect('school/register-institution');
            return;
        }

        $codigo = $this->generateVerificationCode();
        $expira = date('Y-m-d H:i:s', strtotime('+15 minutes'));
        $model->updateVerificationCode($pending['instituciones_id'], $codigo, $expira);

        $enviado = sendVerificationEmail($pending['correo'], $pending['nombre'], $codigo);
        $_SESSION[$enviado ? 'success' : 'error'] = $enviado
            ? 'Te reenviamos el código a ' . $pending['correo'] . '.'
            : 'No pudimos reenviar el correo. Intenta de nuevo en un momento.';
        redirect('school/verify-institution');
    }
}
