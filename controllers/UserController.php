<?php
require_once __DIR__ . '/../models/UserModel.php';

class UserController {

    // Admin General o director de su propia institucion.
    private function isSchoolAdmin() {
        $u = currentUser();
        if (!$u) return false;
        return $u['role'] === 'admin' || $u['role'] === 'director';
    }

    private function isGlobalAdmin() {
        $u = currentUser();
        return $u && $u['role'] === 'admin';
    }

    // Institucion a la que esta acotado el usuario actual (null = Admin
    // General, ve/gestiona usuarios de todas las instituciones).
    private function scopeInstitutionId() {
        if ($this->isGlobalAdmin()) return null;
        $u = currentUser();
        return $u['institucion_id'] ?? null;
    }

    public function list() {
        if (!isLoggedIn() || !$this->isSchoolAdmin()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $model = new UserModel();
        $search = trim($_GET['q'] ?? '');
        $role = trim($_GET['role'] ?? '');
        $page = (int) ($_GET['page'] ?? 1);
        $perPage = (int) ($_GET['per_page'] ?? 10);
        $sort = ($_GET['sort'] ?? '') === 'created_at' ? 'created_at' : 'nombre';
        $instId = $this->scopeInstitutionId();

        $rows = $model->getPage($search, $instId, $role, $page, $perPage, $sort);
        $total = $model->countAll($search, $instId, $role);

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
        $password = $input['password'] ?? '';
        $role = $input['role'] ?? 'user';
        $institucionId = $input['institucion_id'] ?? null;

        $validRoles = ['user', 'admin', 'director', 'docente', 'alumno', 'padre', 'administrativo'];
        if (empty($nombre) || empty($email) || empty($password)) {
            jsonResponse(['error' => 'Nombre, correo y contraseña son obligatorios'], 400);
        }
        if (!in_array($role, $validRoles, true)) {
            jsonResponse(['error' => 'Rol inválido'], 400);
        }
        if (strlen($password) < 6) {
            jsonResponse(['error' => 'La contraseña debe tener al menos 6 caracteres'], 400);
        }

        // Un director solo puede crear usuarios institucionales dentro de SU
        // propia institucion (no puede crear otro admin general ni asignar
        // una institucion ajena).
        if (!$this->isGlobalAdmin()) {
            $scopeId = $this->scopeInstitutionId();
            if ($role === 'admin' || $institucionId != $scopeId) {
                jsonResponse(['error' => 'No puedes asignar ese rol o institución'], 403);
            }
        }

        $model = new UserModel();
        if ($model->emailExists($email)) {
            jsonResponse(['error' => 'Ese correo ya está registrado'], 400);
        }

        $id = $model->create([
            'nombre' => $nombre,
            'email' => $email,
            'password' => $password,
            'role' => $role,
            'institucion_id' => $institucionId,
            'estado_institucional' => $role === 'user' ? 'ninguno' : 'aprobado',
            'telefono' => trim($input['telefono'] ?? ''),
        ]);

        jsonResponse(['success' => true, 'id' => $id]);
    }

    public function update() {
        if (!isLoggedIn() || !$this->isSchoolAdmin()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['id'] ?? null;
        $nombre = trim($input['nombre'] ?? '');
        $role = $input['role'] ?? '';

        if (!$id) {
            jsonResponse(['error' => 'ID de usuario requerido'], 400);
        }
        if (empty($nombre)) {
            jsonResponse(['error' => 'El nombre es obligatorio'], 400);
        }
        $validRoles = ['user', 'admin', 'director', 'docente', 'alumno', 'padre', 'administrativo'];
        if (!in_array($role, $validRoles, true)) {
            jsonResponse(['error' => 'Rol inválido'], 400);
        }

        $model = new UserModel();
        $target = $model->getById($id);
        if (!$target) {
            jsonResponse(['error' => 'Usuario no encontrado'], 404);
        }

        // Un director solo puede editar usuarios de su propia institucion,
        // y no puede convertir a nadie en admin general.
        if (!$this->isGlobalAdmin()) {
            $scopeId = $this->scopeInstitutionId();
            if ($target['institucion_id'] != $scopeId || $role === 'admin') {
                jsonResponse(['error' => 'No autorizado para modificar este usuario'], 403);
            }
        }

        $model->update($id, [
            'nombre' => $nombre,
            'role' => $role,
            'institucion_id' => $input['institucion_id'] ?? $target['institucion_id'],
            'estado_institucional' => $input['estado_institucional'] ?? $target['estado_institucional'],
            'telefono' => trim($input['telefono'] ?? ''),
            'comite_autorizado' => !empty($input['comite_autorizado']),
        ]);

        jsonResponse(['success' => true]);
    }

    // Perfil completo de un usuario + sus noticias/reportes publicados,
    // para el modal "Ver perfil" del director/admin en la pestaña Usuarios.
    public function profile() {
        if (!isLoggedIn() || !$this->isSchoolAdmin()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $id = $_GET['id'] ?? null;
        if (!$id) {
            jsonResponse(['error' => 'ID de usuario requerido'], 400);
        }
        $model = new UserModel();
        $target = $model->getById($id);
        if (!$target) {
            jsonResponse(['error' => 'Usuario no encontrado'], 404);
        }
        if (!$this->isGlobalAdmin() && $target['institucion_id'] != $this->scopeInstitutionId()) {
            jsonResponse(['error' => 'No autorizado'], 403);
        }

        jsonResponse($model->getProfileDetail($id));
    }

    public function delete() {
        if (!isLoggedIn() || !$this->isSchoolAdmin()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $id = $_GET['id'] ?? null;
        if (!$id) {
            jsonResponse(['error' => 'ID de usuario requerido'], 400);
        }

        $model = new UserModel();
        $target = $model->getById($id);
        if (!$target) {
            jsonResponse(['error' => 'Usuario no encontrado'], 404);
        }
        if ((int)$target['usuarios_id'] === (int)$_SESSION['user_id']) {
            jsonResponse(['error' => 'No puedes eliminar tu propia cuenta desde aquí'], 400);
        }
        if (!$this->isGlobalAdmin() && $target['institucion_id'] != $this->scopeInstitutionId()) {
            jsonResponse(['error' => 'No autorizado para eliminar este usuario'], 403);
        }

        $model->delete($id);
        jsonResponse(['success' => true]);
    }
}
