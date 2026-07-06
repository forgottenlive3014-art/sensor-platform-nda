<?php
class ReportModel {

    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    public function getAttendanceStats($instId, $filterByInst) {
        $sql = "
            SELECT
                COUNT(*) as total,
                SUM(CASE WHEN a.estado = 'presente' THEN 1 ELSE 0 END) as presentes,
                SUM(CASE WHEN a.estado = 'ausente' THEN 1 ELSE 0 END) as ausentes,
                SUM(CASE WHEN a.estado = 'herido' THEN 1 ELSE 0 END) as heridos
            FROM asistencia_simulacros a
            JOIN simulacros s ON s.simulacros_id = a.simulacros_id
        " . ($filterByInst ? " WHERE s.instituciones_id = ?" : "");
        $stmt = $this->db->prepare($sql);
        $stmt->execute($filterByInst ? [$instId] : []);
        return $stmt->fetch();
    }

    public function getIncidentsByType($instId, $filterByInst) {
        $sql = "
            SELECT tipo, COUNT(*) as total
            FROM incidentes
        " . ($filterByInst ? " WHERE instituciones_id = ?" : "") . "
            GROUP BY tipo
            ORDER BY total DESC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($filterByInst ? [$instId] : []);
        return $stmt->fetchAll();
    }

    public function getStudentsByClassroom($instId, $filterByInst) {
        $sql = "
            SELECT a.nombre, COUNT(e.estudiantes_id) as total
            FROM aulas a
            LEFT JOIN estudiantes e ON e.aulas_id = a.aulas_id
        " . ($filterByInst ? " WHERE a.instituciones_id = ?" : "") . "
            GROUP BY a.aulas_id
            ORDER BY total DESC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($filterByInst ? [$instId] : []);
        return $stmt->fetchAll();
    }

    // Simulacros por estado (programado/activo/finalizado), util para el
    // panel del Admin General (vista global de todas las instituciones).
    public function getDrillsByStatus($instId, $filterByInst) {
        $sql = "
            SELECT estado, COUNT(*) as total
            FROM simulacros
        " . ($filterByInst ? " WHERE instituciones_id = ?" : "") . "
            GROUP BY estado
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($filterByInst ? [$instId] : []);
        return $stmt->fetchAll();
    }
}
