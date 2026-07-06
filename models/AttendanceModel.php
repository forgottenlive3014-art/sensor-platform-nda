<?php
class AttendanceModel {

    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    public function getForDrill($drillId) {
        $stmt = $this->db->prepare("
            SELECT e.estudiantes_id, e.nombre, e.apellido, a.nombre as aula,
                   at.estado as status
            FROM estudiantes e
            JOIN aulas a ON e.aulas_id = a.aulas_id
            LEFT JOIN asistencia_simulacros at ON at.estudiantes_id = e.estudiantes_id AND at.simulacros_id = ?
            ORDER BY e.nombre
        ");
        $stmt->execute([$drillId]);
        return $stmt->fetchAll();
    }

    public function saveBulk($drillId, $attendance) {
        $stmt = $this->db->prepare("
            INSERT INTO asistencia_simulacros (simulacros_id, estudiantes_id, estado)
            VALUES (?, ?, ?)
            ON DUPLICATE KEY UPDATE estado = ?
        ");
        foreach ($attendance as $item) {
            $stmt->execute([$drillId, $item['estudiante_id'], $item['estado'], $item['estado']]);
        }
    }

    public function getForStudentUser($usuarioId) {
        $stmt = $this->db->prepare("
            SELECT s.nombre, s.fecha, at.estado as status
            FROM estudiantes e
            JOIN asistencia_simulacros at ON at.estudiantes_id = e.estudiantes_id
            JOIN simulacros s ON s.simulacros_id = at.simulacros_id
            WHERE e.usuarios_id = ?
            ORDER BY s.fecha DESC
        ");
        $stmt->execute([$usuarioId]);
        return $stmt->fetchAll();
    }
}
