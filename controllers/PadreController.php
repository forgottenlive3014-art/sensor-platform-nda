<?php
require_once __DIR__ . '/../models/ParentModel.php';
require_once __DIR__ . '/../models/NotificationModel.php';

class PadreController {

    private function isSchoolAdmin() {
        $u = currentUser();
        if (!$u) return false;
        return $u['role'] === 'admin' || $u['role'] === 'director';
    }

    private function scopeInstitutionId() {
        $u = currentUser();
        if ($u['role'] === 'admin') return null;
        return $u['institucion_id'] ?? null;
    }

    // Solo para LECTURA (ver EstudianteController::readScopeInstitutionId()
    // para la explicacion completa). Nunca se usa en create/update/delete.
    private function readScopeInstitutionId() {
        $u = currentUser();
        if ($u['role'] === 'admin' && !empty($_SESSION['admin_view_institucion_id'])) {
            return (int) $_SESSION['admin_view_institucion_id'];
        }
        return $this->scopeInstitutionId();
    }

    public function list() {
        if (!isLoggedIn() || !$this->isSchoolAdmin()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $u = currentUser();
        $model = new ParentModel();
        $search = trim($_GET['q'] ?? '');
        $page = (int) ($_GET['page'] ?? 1);
        $perPage = (int) ($_GET['per_page'] ?? 10);
        $instId = $this->readScopeInstitutionId();
        $isGlobalAdmin = $u['role'] === 'admin' && $instId === null;

        $rows = $model->getPage($instId, $isGlobalAdmin, $search, $page, $perPage);
        $total = $model->countAll($instId, $isGlobalAdmin, $search);

        jsonResponse([
            'data' => $rows,
            'total' => $total,
            'page' => max(1, $page),
            'per_page' => $perPage,
            'total_pages' => $perPage > 0 ? (int) ceil($total / $perPage) : 1,
        ]);
    }

    public function create() {
        if (!isLoggedIn() || !$this->isSchoolAdmin()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $input = json_decode(file_get_contents('php://input'), true);
        $nombre = trim($input['nombre'] ?? '');
        $email = trim($input['email'] ?? '');

        if (empty($nombre) || empty($email)) {
            jsonResponse(['error' => 'Nombre y correo son obligatorios'], 400);
        }

        $instId = $this->scopeInstitutionId();
        if (!$instId) {
            jsonResponse(['error' => 'No tienes una institución asociada'], 400);
        }

        $model = new ParentModel();
        if ($model->emailExists($email)) {
            jsonResponse(['error' => 'Ese correo ya está registrado'], 400);
        }

        $password = bin2hex(random_bytes(4));
        $id = $model->create([
            'nombre' => $nombre,
            'email' => $email,
            'password' => $password,
            'institucion_id' => $instId,
            'telefono' => trim($input['telefono'] ?? ''),
        ]);

        jsonResponse(['success' => true, 'id' => $id, 'password_temporal' => $password]);
    }

    public function update() {
        if (!isLoggedIn() || !$this->isSchoolAdmin()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['id'] ?? null;
        $nombre = trim($input['nombre'] ?? '');

        if (!$id || empty($nombre)) {
            jsonResponse(['error' => 'Datos incompletos'], 400);
        }

        $model = new ParentModel();
        $parent = $model->getById($id);
        if (!$parent) {
            jsonResponse(['error' => 'Padre/madre no encontrado'], 404);
        }
        if ($this->scopeInstitutionId() !== null && $parent['institucion_id'] != $this->scopeInstitutionId()) {
            jsonResponse(['error' => 'No autorizado'], 403);
        }

        $model->update($id, ['nombre' => $nombre, 'telefono' => trim($input['telefono'] ?? '')]);
        jsonResponse(['success' => true]);
    }

    public function delete() {
        if (!isLoggedIn() || !$this->isSchoolAdmin()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $id = $_GET['id'] ?? null;
        if (!$id) {
            jsonResponse(['error' => 'ID requerido'], 400);
        }

        $model = new ParentModel();
        $parent = $model->getById($id);
        if (!$parent) {
            jsonResponse(['error' => 'Padre/madre no encontrado'], 404);
        }
        if ($this->scopeInstitutionId() !== null && $parent['institucion_id'] != $this->scopeInstitutionId()) {
            jsonResponse(['error' => 'No autorizado'], 403);
        }

        $model->delete($id);
        jsonResponse(['success' => true]);
    }

    // Vincula un padre existente con un estudiante existente de la misma institucion.
    public function linkChild() {
        if (!isLoggedIn() || !$this->isSchoolAdmin()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $input = json_decode(file_get_contents('php://input'), true);
        $padreId = $input['padre_id'] ?? null;
        $estudianteId = $input['estudiante_id'] ?? null;

        if (!$padreId || !$estudianteId) {
            jsonResponse(['error' => 'Selecciona un padre/madre y un estudiante'], 400);
        }

        $model = new ParentModel();
        $parent = $model->getById($padreId);
        if (!$parent) {
            jsonResponse(['error' => 'Padre/madre no encontrado'], 404);
        }
        if ($this->scopeInstitutionId() !== null && $parent['institucion_id'] != $this->scopeInstitutionId()) {
            jsonResponse(['error' => 'No autorizado'], 403);
        }

        // La institucion del estudiante se determina por su propia cuenta
        // de usuario, no por el aula (un alumno sin aula asignada sigue
        // perteneciendo a su institucion).
        $db = getDB();
        $stmt = $db->prepare("
            SELECT su.institucion_id as instituciones_id FROM estudiantes e
            JOIN usuarios su ON su.usuarios_id = e.usuarios_id
            WHERE e.estudiantes_id = ?
        ");
        $stmt->execute([$estudianteId]);
        $student = $stmt->fetch();
        if (!$student) {
            jsonResponse(['error' => 'Estudiante no encontrado'], 404);
        }
        if ($this->scopeInstitutionId() !== null && $student['instituciones_id'] != $this->scopeInstitutionId()) {
            jsonResponse(['error' => 'El estudiante no pertenece a tu institución'], 403);
        }

        $model->linkChild($padreId, $estudianteId, trim($input['parentesco'] ?? ''));
        jsonResponse(['success' => true]);
    }

    public function unlinkChild() {
        if (!isLoggedIn() || !$this->isSchoolAdmin()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $id = $_GET['id'] ?? null;
        if (!$id) {
            jsonResponse(['error' => 'ID requerido'], 400);
        }
        $model = new ParentModel();
        $model->unlinkChild($id);
        jsonResponse(['success' => true]);
    }

    public function myChildrenLinks() {
        if (!isLoggedIn() || !$this->isSchoolAdmin()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $id = $_GET['padre_id'] ?? null;
        if (!$id) {
            jsonResponse(['error' => 'ID requerido'], 400);
        }
        $model = new ParentModel();
        jsonResponse($model->getLinksForParent($id));
    }

    public function requestChildLink() {
        if (!isLoggedIn()) jsonResponse(['error' => 'No autorizado'], 401);
        $u = currentUser();
        if ($u['role'] !== 'padre') jsonResponse(['error' => 'Solo los padres pueden enviar solicitudes'], 403);

        $input = json_decode(file_get_contents('php://input'), true) ?: [];
        $names = $input['nombres'] ?? [$input['nombre'] ?? ''];
        if (!is_array($names)) $names = [$names];
        $names = array_values(array_unique(array_filter(array_map('trim', $names))));
        if (!$names) jsonResponse(['error' => 'Escribe al menos un nombre de estudiante'], 400);

        $db = getDB();
        $model = new ParentModel();
        $notification = new NotificationModel();
        $created = 0;
        $errors = [];
        foreach ($names as $name) {
            $stmt = $db->prepare("\n                SELECT e.estudiantes_id, e.nombre, e.apellido, eu.institucion_id, i.director_id\n                FROM estudiantes e\n                JOIN usuarios eu ON eu.usuarios_id = e.usuarios_id\n                LEFT JOIN instituciones i ON i.instituciones_id = eu.institucion_id\n                WHERE LOWER(TRIM(CONCAT_WS(' ', e.nombre, e.apellido))) = LOWER(?)\n            ");
            $stmt->execute([$name]);
            $student = $stmt->fetch();
            if (!$student || empty($student['institucion_id']) || $student['institucion_id'] != ($u['institucion_id'] ?? null)) {
                $errors[] = "No se encontró a {$name} en tu institución";
                continue;
            }
            $stmt = $db->prepare("SELECT 1 FROM padres_estudiantes WHERE padre_usuario_id = ? AND estudiante_id = ?");
            $stmt->execute([$u['id'], $student['estudiantes_id']]);
            if ($stmt->fetchColumn()) { $errors[] = "{$name} ya está vinculado"; continue; }
            $stmt = $db->prepare("SELECT 1 FROM solicitudes_padre_hijo WHERE padre_usuario_id = ? AND estudiante_id = ? AND estado = 'pendiente'");
            $stmt->execute([$u['id'], $student['estudiantes_id']]);
            if ($stmt->fetchColumn()) { $errors[] = "{$name} ya tiene una solicitud pendiente"; continue; }

            $model->createChildLinkRequest($u['id'], $student['estudiantes_id'], trim($input['parentesco'] ?? 'padre/madre'));
            if (!empty($student['director_id'])) {
                $notification->create([
                    'tipo' => 'escolar', 'severidad' => 'informativo',
                    'destinatario_usuario_id' => $student['director_id'],
                    'mensaje' => $u['nombre'] . ' solicita vincularse con ' . $student['nombre'] . ' ' . $student['apellido'] . '.',
                ]);
            }
            $created++;
        }
        jsonResponse(['success' => $created > 0, 'creadas' => $created, 'errores' => $errors]);
    }

    public function childLinkRequests() {
        if (!isLoggedIn() || !$this->isSchoolAdmin()) jsonResponse(['error' => 'No autorizado'], 401);
        jsonResponse((new ParentModel())->getPendingChildLinkRequests($this->scopeInstitutionId()));
    }

    public function resolveChildLinkRequest() {
        if (!isLoggedIn() || !$this->isSchoolAdmin()) jsonResponse(['error' => 'No autorizado'], 401);
        $input = json_decode(file_get_contents('php://input'), true) ?: [];
        $id = $input['id'] ?? null;
        $approved = ($input['accion'] ?? '') === 'aprobar';
        if (!$id || !in_array($input['accion'] ?? '', ['aprobar', 'rechazar'], true)) jsonResponse(['error' => 'Solicitud inválida'], 400);
        $model = new ParentModel();
        $allowedRequests = $model->getPendingChildLinkRequests($this->scopeInstitutionId());
        $belongsToScope = false;
        foreach ($allowedRequests as $allowedRequest) {
            if ((int) $allowedRequest['solicitudes_padre_hijo_id'] === (int) $id) {
                $belongsToScope = true;
                break;
            }
        }
        if (!$belongsToScope) jsonResponse(['error' => 'Solicitud fuera de tu institución'], 403);
        $request = $model->resolveChildLinkRequest($id, $approved);
        if (!$request) jsonResponse(['error' => 'Solicitud no encontrada'], 404);
        (new NotificationModel())->create([
            'tipo' => 'escolar', 'severidad' => $approved ? 'seguro' : 'informativo',
            'destinatario_usuario_id' => $request['padre_usuario_id'],
            'mensaje' => $approved ? 'Tu solicitud para vincular a tu hijo fue aprobada.' : 'Tu solicitud para vincular a tu hijo fue rechazada.',
        ]);
        jsonResponse(['success' => true]);
    }

    // El propio padre consulta a sus hijos vinculados.
    public function myChildren() {
        if (!isLoggedIn()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $u = currentUser();
        if ($u['role'] !== 'padre') {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $model = new ParentModel();
        jsonResponse($model->getChildrenWithDetails($u['id']));
    }

    // El propio padre consulta el estado de sus hijos en el simulacro
    // mas reciente (¿ya salieron / estan a salvo?).
    public function myChildrenDrillStatus() {
        if (!isLoggedIn()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $u = currentUser();
        if ($u['role'] !== 'padre') {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $model = new ParentModel();
        jsonResponse($model->getChildrenLatestDrillStatus($u['id']));
    }
}
