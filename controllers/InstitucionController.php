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
}
