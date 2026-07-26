<?php
require_once __DIR__ . '/../models/StudentModel.php';

class EstudianteController {

    private function isSchoolStaff() {
        $u = currentUser();
        if (!$u) return false;
        return in_array($u['role'], ['admin', 'director', 'docente'], true);
    }

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

    // Solo para LECTURA: si el Admin General esta "viendo" una institucion
    // (SchoolController::viewInstitution()), las listas deben mostrar esa
    // institucion en vez de todo el sistema. Nunca se usa para escritura —
    // create()/update()/delete() siguen con scopeInstitutionId() sin tocar.
    private function readScopeInstitutionId() {
        $u = currentUser();
        if ($u['role'] === 'admin' && !empty($_SESSION['admin_view_institucion_id'])) {
            return (int) $_SESSION['admin_view_institucion_id'];
        }
        return $this->scopeInstitutionId();
    }

    public function list() {
        if (!isLoggedIn() || !$this->canAccessSchool()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $u = currentUser();
        $model = new StudentModel();
        $search = trim($_GET['q'] ?? '');
        $aulaId = trim($_GET['aula_id'] ?? '');
        $page = (int) ($_GET['page'] ?? 1);
        $perPage = (int) ($_GET['per_page'] ?? 10);
        $instId = $this->readScopeInstitutionId();
        $isGlobalAdmin = $u['role'] === 'admin' && $instId === null;

        // Un docente ve por defecto solo los alumnos de sus propias aulas
        // asignadas (igual que ya hacia SeccionController con "?all=1").
        $teacherId = ($u['role'] === 'docente' && empty($_GET['all'])) ? $u['id'] : null;

        $rows = $model->getPage($instId, $isGlobalAdmin, $search, $aulaId, $page, $perPage, $teacherId);
        $total = $model->countAll($instId, $isGlobalAdmin, $search, $aulaId, $teacherId);

        jsonResponse([
            'data' => $rows,
            'total' => $total,
            'page' => max(1, $page),
            'per_page' => $perPage,
            'total_pages' => $perPage > 0 ? (int) ceil($total / $perPage) : 1,
        ]);
    }

    // El propio alumno consulta su aula asignada, docente y compañeros.
    public function myClassroom() {
        if (!isLoggedIn()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $u = currentUser();
        if ($u['role'] !== 'alumno') {
            jsonResponse(['error' => 'No autorizado'], 401);
        }

        $db = getDB();
        $stmt = $db->prepare("
            SELECT a.aulas_id, a.nombre as classroom, a.grado, a.seccion, us.nombre as teacher,
                   (SELECT COUNT(*) FROM estudiantes e2 WHERE e2.aulas_id = a.aulas_id) as total_alumnos
            FROM estudiantes e
            LEFT JOIN aulas a ON a.aulas_id = e.aulas_id
            LEFT JOIN usuarios us ON us.usuarios_id = a.maestro_id
            WHERE e.usuarios_id = ?
        ");
        $stmt->execute([$u['id']]);
        $row = $stmt->fetch();

        jsonResponse($row ?: ['classroom' => null]);
    }

    public function create() {
        if (!isLoggedIn() || !$this->isSchoolStaff()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $input = json_decode(file_get_contents('php://input'), true);
        $nombre = trim($input['nombre'] ?? '');
        $apellido = trim($input['apellido'] ?? '');
        $email = trim($input['email'] ?? '');

        if (empty($nombre) || empty($apellido) || empty($email)) {
            jsonResponse(['error' => 'Faltan campos obligatorios'], 400);
        }

        $instId = $this->scopeInstitutionId();
        if (!$instId) {
            jsonResponse(['error' => 'No tienes una institución asociada'], 400);
        }

        $model = new StudentModel();
        if ($model->emailExists($email)) {
            jsonResponse(['error' => 'Este correo ya está registrado'], 400);
        }

        $password = bin2hex(random_bytes(4));
        $ids = $model->create([
            'nombre' => $nombre,
            'apellido' => $apellido,
            'email' => $email,
            'password' => $password,
            'institucion_id' => $instId,
            'aulas_id' => $input['aula_id'] ?? null,
            'edad' => $input['edad'] ?? null,
            'telefono_emergencia' => trim($input['telefono'] ?? ''),
        ]);

        jsonResponse(['success' => true, 'id' => $ids['estudiante_id'], 'password_temporal' => $password]);
    }

    public function update() {
        if (!isLoggedIn() || !$this->isSchoolStaff()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['id'] ?? null;

        if (!$id) {
            jsonResponse(['error' => 'ID de estudiante requerido'], 400);
        }

        $model = new StudentModel();
        $student = $model->getById($id);
        if (!$student) {
            jsonResponse(['error' => 'Estudiante no encontrado'], 404);
        }
        if ($this->scopeInstitutionId() !== null && $student['instituciones_id'] != $this->scopeInstitutionId()) {
            jsonResponse(['error' => 'No autorizado para modificar este estudiante'], 403);
        }

        $model->update($id, [
            'nombre' => trim($input['nombre'] ?? ''),
            'apellido' => trim($input['apellido'] ?? ''),
            'aulas_id' => $input['aula_id'] ?? null,
            'edad' => $input['edad'] ?? null,
            'telefono_emergencia' => trim($input['telefono'] ?? ''),
        ]);

        jsonResponse(['success' => true]);
    }

    public function delete() {
        if (!isLoggedIn() || !$this->isSchoolAdmin()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $id = $_GET['id'] ?? null;
        if (!$id) {
            jsonResponse(['error' => 'ID de estudiante requerido'], 400);
        }

        $model = new StudentModel();
        $student = $model->getById($id);
        if (!$student) {
            jsonResponse(['error' => 'Estudiante no encontrado'], 404);
        }
        if ($this->scopeInstitutionId() !== null && $student['instituciones_id'] != $this->scopeInstitutionId()) {
            jsonResponse(['error' => 'No autorizado para eliminar este estudiante'], 403);
        }

        $model->delete($id);
        jsonResponse(['success' => true]);
    }
}
