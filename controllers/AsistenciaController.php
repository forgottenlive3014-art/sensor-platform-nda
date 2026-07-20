<?php
require_once __DIR__ . '/../models/AttendanceModel.php';

class AsistenciaController {

    private function isSchoolStaff() {
        $u = currentUser();
        if (!$u) return false;
        return in_array($u['role'], ['admin', 'director', 'docente'], true);
    }

    public function get() {
        if (!isLoggedIn()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $drillId = $_GET['drill_id'] ?? null;
        if (!$drillId) {
            jsonResponse(['error' => 'Falta ID del simulacro'], 400);
        }

        $model = new AttendanceModel();
        jsonResponse($model->getForDrill($drillId));
    }

    public function save() {
        if (!isLoggedIn() || !$this->isSchoolStaff()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $input = json_decode(file_get_contents('php://input'), true);
        $drillId = $input['drill_id'] ?? null;
        $attendance = $input['attendance'] ?? [];

        if (!$drillId || empty($attendance)) {
            jsonResponse(['error' => 'Faltan datos'], 400);
        }

        $model = new AttendanceModel();
        $model->saveBulk($drillId, $attendance);

        jsonResponse(['success' => true]);
    }

    // El alumno consulta su propio historial de asistencia (no el de otros).
    public function myAttendance() {
        if (!isLoggedIn()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $model = new AttendanceModel();
        jsonResponse($model->getForStudentUser($_SESSION['user_id']));
    }
}
