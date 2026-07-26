<?php
require_once __DIR__ . '/../models/ReportModel.php';

class ReporteController {

    public function get() {
        if (!isLoggedIn()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $u = currentUser();
        // Admin viendo una institucion especifica (SchoolController::
        // viewInstitution()) reporta solo de esa; el resto de admin ve todo.
        $instId = ($u['role'] === 'admin' && !empty($_SESSION['admin_view_institucion_id']))
            ? (int) $_SESSION['admin_view_institucion_id']
            : ($u['institucion_id'] ?? null);
        $filterByInst = ($u['role'] !== 'admin' && $instId) || ($u['role'] === 'admin' && !empty($_SESSION['admin_view_institucion_id']));

        $model = new ReportModel();

        jsonResponse([
            'attendance' => $model->getAttendanceStats($instId, $filterByInst),
            'incidents_by_type' => $model->getIncidentsByType($instId, $filterByInst),
            'students_by_classroom' => $model->getStudentsByClassroom($instId, $filterByInst),
            'drills_by_status' => $model->getDrillsByStatus($instId, $filterByInst),
        ]);
    }
}
