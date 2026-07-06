<?php
class SectionModel {

    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    public function getForInstitution($instId, $onlyTeacherId = null) {
        $sql = "
            SELECT a.*, us.nombre as teacher,
                   (SELECT COUNT(*) FROM estudiantes e WHERE e.aulas_id = a.aulas_id) as total_alumnos
            FROM aulas a
            LEFT JOIN usuarios us ON a.maestro_id = us.usuarios_id
            WHERE a.instituciones_id = ?
        ";
        $params = [$instId];
        if ($onlyTeacherId !== null) {
            $sql .= " AND a.maestro_id = ?";
            $params[] = $onlyTeacherId;
        }
        $sql .= " ORDER BY a.grado, a.seccion";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function assignTeacher($aulaId, $maestroId, $instId) {
        $stmt = $this->db->prepare("UPDATE aulas SET maestro_id = ? WHERE aulas_id = ? AND instituciones_id = ?");
        $stmt->execute([$maestroId ?: null, $aulaId, $instId]);
        return $stmt->rowCount() > 0;
    }
}
