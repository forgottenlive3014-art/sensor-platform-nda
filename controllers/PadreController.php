<?php
require_once __DIR__ . '/../models/ParentModel.php';

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
