<?php
class SchoolModel {

    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    // ============================================================
    //  ALUMNOS
    // ============================================================

    public function getStudents($limit = null) {
        $sql = "
            SELECT e.*, a.nombre as classroom, u.nombre as teacher
            FROM estudiantes e
            LEFT JOIN aulas a ON e.aulas_id = a.aulas_id
            LEFT JOIN usuarios u ON a.maestro_id = u.usuarios_id
            ORDER BY e.nombre
        ";
        if ($limit) {
            $sql .= " LIMIT $limit";
        }
        return $this->db->query($sql)->fetchAll();
    }

    public function getStudentById($id) {
        $stmt = $this->db->prepare("
            SELECT e.*, a.nombre as classroom
            FROM estudiantes e
            LEFT JOIN aulas a ON e.aulas_id = a.aulas_id
            WHERE e.estudiantes_id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getStudentsByClassroom($classroom_id) {
        $stmt = $this->db->prepare("
            SELECT * FROM estudiantes
            WHERE aulas_id = ?
            ORDER BY nombre
        ");
        $stmt->execute([$classroom_id]);
        return $stmt->fetchAll();
    }

    // ============================================================
    //  DOCENTES
    // ============================================================

    public function getTeachers() {
        return $this->db->query("
            SELECT u.*, a.nombre as classroom
            FROM usuarios u
            LEFT JOIN aulas a ON a.maestro_id = u.usuarios_id
            WHERE u.role = 'docente' OR u.role = 'admin'
            ORDER BY u.nombre
        ")->fetchAll();
    }

    // ============================================================
    //  AULAS
    // ============================================================

    public function getClassrooms() {
        return $this->db->query("
            SELECT a.*, i.nombre as institution, u.nombre as teacher
            FROM aulas a
            LEFT JOIN instituciones i ON a.instituciones_id = i.instituciones_id
            LEFT JOIN usuarios u ON a.maestro_id = u.usuarios_id
            ORDER BY a.nombre
        ")->fetchAll();
    }

    // ============================================================
    //  RUTAS
    // ============================================================

    public function getRoutes() {
        return $this->db->query("
            SELECT r.*, i.nombre as institution
            FROM rutas_evacuacion r
            LEFT JOIN instituciones i ON r.instituciones_id = i.instituciones_id
            ORDER BY r.nombre
        ")->fetchAll();
    }

    // ============================================================
    //  SIMULACROS
    // ============================================================

    public function getDrills($limit = null) {
        $sql = "
            SELECT s.*, i.nombre as institution,
                   (SELECT COUNT(*) FROM asistencia_simulacros WHERE simulacros_id = s.simulacros_id) as total_asistencia
            FROM simulacros s
            LEFT JOIN instituciones i ON s.instituciones_id = i.instituciones_id
            ORDER BY s.fecha DESC
        ";
        if ($limit) {
            $sql .= " LIMIT $limit";
        }
        return $this->db->query($sql)->fetchAll();
    }

    public function getDrillById($id) {
        $stmt = $this->db->prepare("
            SELECT * FROM simulacros WHERE simulacros_id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // ============================================================
    //  ASISTENCIA
    // ============================================================

    public function getAttendanceByDrill($drill_id) {
        $stmt = $this->db->prepare("
            SELECT e.estudiantes_id, e.nombre, e.apellido, a.nombre as aula,
                   at.estado as status
            FROM estudiantes e
            JOIN aulas a ON e.aulas_id = a.aulas_id
            LEFT JOIN asistencia_simulacros at ON at.estudiantes_id = e.estudiantes_id AND at.simulacros_id = ?
            ORDER BY e.nombre
        ");
        $stmt->execute([$drill_id]);
        return $stmt->fetchAll();
    }

    public function getAttendanceStats() {
        return $this->db->query("
            SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN estado = 'presente' THEN 1 ELSE 0 END) as presentes,
                SUM(CASE WHEN estado = 'ausente' THEN 1 ELSE 0 END) as ausentes,
                SUM(CASE WHEN estado = 'herido' THEN 1 ELSE 0 END) as heridos
            FROM asistencia_simulacros
        ")->fetch();
    }

    // ============================================================
    //  INCIDENTES
    // ============================================================

    public function getIncidents($limit = null) {
        $sql = "
            SELECT i.*, u.nombre as reporter
            FROM incidentes i
            LEFT JOIN usuarios u ON i.usuario_id = u.usuarios_id
            ORDER BY i.created_at DESC
        ";
        if ($limit) {
            $sql .= " LIMIT $limit";
        }
        return $this->db->query($sql)->fetchAll();
    }

    public function getIncidentsByType() {
        return $this->db->query("
            SELECT tipo, COUNT(*) as total
            FROM incidentes
            GROUP BY tipo
            ORDER BY total DESC
        ")->fetchAll();
    }

    // ============================================================
    //  ESTADÍSTICAS
    // ============================================================

    public function getStats() {
        return [
            'students' => $this->db->query("SELECT COUNT(*) as total FROM estudiantes")->fetch()['total'] ?? 0,
            'teachers' => $this->db->query("SELECT COUNT(*) as total FROM usuarios WHERE role = 'docente' OR role = 'admin'")->fetch()['total'] ?? 0,
            'classrooms' => $this->db->query("SELECT COUNT(*) as total FROM aulas")->fetch()['total'] ?? 0,
            'routes' => $this->db->query("SELECT COUNT(*) as total FROM rutas_evacuacion")->fetch()['total'] ?? 0,
            'drills' => $this->db->query("SELECT COUNT(*) as total FROM simulacros")->fetch()['total'] ?? 0,
            'incidents' => $this->db->query("SELECT COUNT(*) as total FROM incidentes")->fetch()['total'] ?? 0,
            'pending_incidents' => $this->db->query("SELECT COUNT(*) as total FROM incidentes WHERE estado = 'pendiente' OR estado IS NULL")->fetch()['total'] ?? 0,
        ];
    }
}
?>