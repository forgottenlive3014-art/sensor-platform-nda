<?php
require_once __DIR__ . '/../models/ClassroomModel.php';

class ClassroomController {

    private function isSchoolAdmin() {
        $u = currentUser();
        if (!$u) return false;
        return $u['role'] === 'admin' || $u['role'] === 'director';
    }

    private function canAccessSchool() {
        $u = currentUser();
        if (!$u) return false;
        if ($u['role'] === 'admin') return true;
        return in_array($u['role'], ['director', 'docente', 'alumno', 'padre', 'administrativo'], true)
            && $u['estado_institucional'] === 'aprobado';
    }

    private function scopeInstitutionId() {
        $u = currentUser();
        if ($u['role'] === 'admin') return null;
        return $u['institucion_id'] ?? null;
    }

    public function list() {
        if (!isLoggedIn() || !$this->canAccessSchool()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $u = currentUser();
        $isGlobalAdmin = $u['role'] === 'admin';
        $model = new ClassroomModel();
        $search = trim($_GET['q'] ?? '');
        $page = (int) ($_GET['page'] ?? 1);
        $perPage = (int) ($_GET['per_page'] ?? 10);
        $instId = $this->scopeInstitutionId();

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
        if (empty($nombre)) {
            jsonResponse(['error' => 'El nombre del aula es obligatorio'], 400);
        }

        $instId = $input['institucion_id'] ?? $this->scopeInstitutionId();
        if (!$this->isGlobalAdminCheck() && $instId != $this->scopeInstitutionId()) {
            jsonResponse(['error' => 'No autorizado para crear aulas en esa institución'], 403);
        }
        if (!$instId) {
            jsonResponse(['error' => 'Selecciona una institución'], 400);
        }

        $model = new ClassroomModel();
        $id = $model->create([
            'nombre' => $nombre,
            'grado' => trim($input['grado'] ?? ''),
            'nivel' => trim($input['nivel'] ?? ''),
            'seccion' => trim($input['seccion'] ?? ''),
            'instituciones_id' => $instId,
            'maestro_id' => $input['maestro_id'] ?? null,
        ]);

        jsonResponse(['success' => true, 'id' => $id]);
    }

    private function isGlobalAdminCheck() {
        $u = currentUser();
        return $u['role'] === 'admin';
    }

    public function update() {
        if (!isLoggedIn() || !$this->isSchoolAdmin()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['id'] ?? null;
        if (!$id) {
            jsonResponse(['error' => 'ID de aula requerido'], 400);
        }

        $model = new ClassroomModel();
        $aula = $model->getById($id);
        if (!$aula) {
            jsonResponse(['error' => 'Aula no encontrada'], 404);
        }
        if ($this->scopeInstitutionId() !== null && $aula['instituciones_id'] != $this->scopeInstitutionId()) {
            jsonResponse(['error' => 'No autorizado para modificar esta aula'], 403);
        }

        $model->update($id, [
            'nombre' => trim($input['nombre'] ?? ''),
            'grado' => trim($input['grado'] ?? ''),
            'nivel' => trim($input['nivel'] ?? ''),
            'seccion' => trim($input['seccion'] ?? ''),
            'maestro_id' => $input['maestro_id'] ?? null,
        ]);

        jsonResponse(['success' => true]);
    }

    public function delete() {
        if (!isLoggedIn() || !$this->isSchoolAdmin()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $id = $_GET['id'] ?? null;
        if (!$id) {
            jsonResponse(['error' => 'ID de aula requerido'], 400);
        }

        $model = new ClassroomModel();
        $aula = $model->getById($id);
        if (!$aula) {
            jsonResponse(['error' => 'Aula no encontrada'], 404);
        }
        if ($this->scopeInstitutionId() !== null && $aula['instituciones_id'] != $this->scopeInstitutionId()) {
            jsonResponse(['error' => 'No autorizado para eliminar esta aula'], 403);
        }

        $model->delete($id);
        jsonResponse(['success' => true]);
    }
}
