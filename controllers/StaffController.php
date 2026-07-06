<?php
require_once __DIR__ . '/../models/StaffModel.php';

class StaffController {

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
        $model = new StaffModel();
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
        $email = trim($input['email'] ?? '');

        if (empty($nombre) || empty($email)) {
            jsonResponse(['error' => 'Nombre y correo son obligatorios'], 400);
        }
        $instId = $this->scopeInstitutionId();
        if (!$instId) {
            jsonResponse(['error' => 'No tienes una institución asociada'], 400);
        }

        $model = new StaffModel();
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

        $model = new StaffModel();
        $staff = $model->getById($id);
        if (!$staff) {
            jsonResponse(['error' => 'Registro no encontrado'], 404);
        }
        if ($this->scopeInstitutionId() !== null && $staff['institucion_id'] != $this->scopeInstitutionId()) {
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

        $model = new StaffModel();
        $staff = $model->getById($id);
        if (!$staff) {
            jsonResponse(['error' => 'Registro no encontrado'], 404);
        }
        if ($this->scopeInstitutionId() !== null && $staff['institucion_id'] != $this->scopeInstitutionId()) {
            jsonResponse(['error' => 'No autorizado'], 403);
        }

        $model->delete($id);
        jsonResponse(['success' => true]);
    }
}
