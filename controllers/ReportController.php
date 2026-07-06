<?php
require_once __DIR__ . '/../models/ReportModel.php';

class ReportController {

    public function get() {
        if (!isLoggedIn()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $u = currentUser();
        $instId = $u['institucion_id'] ?? null;
        // Admin global ve todo; el resto solo lo de su institucion.
        $filterByInst = ($u['role'] !== 'admin' && $instId);

        $model = new ReportModel();

        jsonResponse([
            'attendance' => $model->getAttendanceStats($instId, $filterByInst),
            'incidents_by_type' => $model->getIncidentsByType($instId, $filterByInst),
            'students_by_classroom' => $model->getStudentsByClassroom($instId, $filterByInst),
            'drills_by_status' => $model->getDrillsByStatus($instId, $filterByInst),
        ]);
    }
}
