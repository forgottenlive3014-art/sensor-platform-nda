<?php
require_once __DIR__ . '/../models/TeacherModel.php';

class TeacherController {

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

    // Guarda una foto subida en assets/media/uploads/perfiles/ y devuelve
    // la ruta relativa (o false si el archivo no es una imagen valida).
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

    public function list() {
        if (!isLoggedIn() || !$this->canAccessSchool()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $u = currentUser();
        $isGlobalAdmin = $u['role'] === 'admin';
        $model = new TeacherModel();
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

    // Lista plana (sin paginar) de docentes para poblar selects de
    // asignacion (aulas/secciones). Se mantiene separada de list()
    // porque esos selects necesitan TODOS los docentes de la
    // institucion de una vez, no una pagina.
    public function assignable() {
        if (!isLoggedIn() || !$this->canAccessSchool()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $db = getDB();
        $instId = $this->scopeInstitutionId();
        $sql = "SELECT usuarios_id, nombre FROM usuarios WHERE role = 'docente'";
        $params = [];
        if ($instId !== null) {
            $sql .= " AND institucion_id = ?";
            $params[] = $instId;
        }
        $sql .= " ORDER BY nombre";
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        jsonResponse($stmt->fetchAll());
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

        $model = new TeacherModel();
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
            'materia' => trim($input['materia'] ?? ''),
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

        if (!$id) {
            jsonResponse(['error' => 'ID de docente requerido'], 400);
        }
        if (empty($nombre)) {
            jsonResponse(['error' => 'El nombre es obligatorio'], 400);
        }

        $model = new TeacherModel();
        $teacher = $model->getById($id);
        if (!$teacher) {
            jsonResponse(['error' => 'Docente no encontrado'], 404);
        }
        if ($this->scopeInstitutionId() !== null && $teacher['institucion_id'] != $this->scopeInstitutionId()) {
            jsonResponse(['error' => 'No autorizado para modificar este docente'], 403);
        }

        $model->update($id, [
            'nombre' => $nombre,
            'telefono' => trim($input['telefono'] ?? ''),
            'materia' => trim($input['materia'] ?? ''),
        ]);

        jsonResponse(['success' => true]);
    }

    // El propio docente sube su fotografía de perfil.
    public function uploadPhoto() {
        if (!isLoggedIn()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $u = currentUser();
        if ($u['role'] !== 'docente') {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        if (empty($_FILES['foto']['name']) || $_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
            jsonResponse(['error' => 'Sube una fotografía'], 400);
        }
        $path = $this->storeUploadedPhoto($_FILES['foto']);
        if ($path === false) {
            jsonResponse(['error' => 'La imagen no es válida (usa JPG, PNG o WEBP, máx. 5MB)'], 400);
        }

        $model = new TeacherModel();
        $model->updatePhoto($u['id'], $path);

        jsonResponse(['success' => true, 'foto' => $path]);
    }

    public function delete() {
        if (!isLoggedIn() || !$this->isSchoolAdmin()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $id = $_GET['id'] ?? null;
        if (!$id) {
            jsonResponse(['error' => 'ID de docente requerido'], 400);
        }

        $model = new TeacherModel();
        $teacher = $model->getById($id);
        if (!$teacher) {
            jsonResponse(['error' => 'Docente no encontrado'], 404);
        }
        if ($this->scopeInstitutionId() !== null && $teacher['institucion_id'] != $this->scopeInstitutionId()) {
            jsonResponse(['error' => 'No autorizado para eliminar este docente'], 403);
        }

        $model->delete($id);
        jsonResponse(['success' => true]);
    }
}
