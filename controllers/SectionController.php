<?php
require_once __DIR__ . '/../models/SectionModel.php';

class SectionController {

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

    public function list() {
        if (!isLoggedIn() || !$this->canAccessSchool()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $u = currentUser();
        $instId = $u['institucion_id'] ?? null;
        if (!$instId) {
            jsonResponse([]);
        }

        $model = new SectionModel();
        // Un docente ve por defecto solo sus secciones asignadas.
        $onlyTeacherId = ($u['role'] === 'docente' && empty($_GET['all'])) ? $u['id'] : null;
        jsonResponse($model->getForInstitution($instId, $onlyTeacherId));
    }

    public function assignTeacher() {
        if (!isLoggedIn() || !$this->isSchoolAdmin()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $input = json_decode(file_get_contents('php://input'), true);
        $aulaId = $input['aula_id'] ?? null;
        if (!$aulaId) {
            jsonResponse(['error' => 'Aula requerida'], 400);
        }

        $u = currentUser();
        $model = new SectionModel();
        $model->assignTeacher($aulaId, $input['maestro_id'] ?? null, $u['institucion_id'] ?? null);

        jsonResponse(['success' => true]);
    }
}
