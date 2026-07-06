<?php
class ClassroomModel {

    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    public function countAll($instId, $isGlobalAdmin, $search = '') {
        $sql = "SELECT COUNT(*) as total FROM aulas a WHERE 1=1";
        $params = [];
        if (!$isGlobalAdmin) {
            $sql .= " AND a.instituciones_id = ?";
            $params[] = $instId;
        }
        if ($search !== '') {
            $sql .= " AND a.nombre LIKE ?";
            $params[] = "%$search%";
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (int) ($stmt->fetch()['total'] ?? 0);
    }

    public function getPage($instId, $isGlobalAdmin, $search = '', $page = 1, $perPage = 10) {
        $page = max(1, (int) $page);
        $perPage = max(1, min(100, (int) $perPage));
        $offset = ($page - 1) * $perPage;

        $sql = "
            SELECT a.*, i.nombre as institution, us.nombre as teacher,
                   (SELECT COUNT(*) FROM estudiantes e WHERE e.aulas_id = a.aulas_id) as total_alumnos
            FROM aulas a
            LEFT JOIN instituciones i ON a.instituciones_id = i.instituciones_id
            LEFT JOIN usuarios us ON a.maestro_id = us.usuarios_id
            WHERE 1=1
        ";
        $params = [];
        if (!$isGlobalAdmin) {
            $sql .= " AND a.instituciones_id = ?";
            $params[] = $instId;
        }
        if ($search !== '') {
            $sql .= " AND a.nombre LIKE ?";
            $params[] = "%$search%";
        }
        $sql .= " ORDER BY a.grado, a.seccion, a.nombre LIMIT $perPage OFFSET $offset";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM aulas WHERE aulas_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO aulas (nombre, grado, nivel, seccion, instituciones_id, maestro_id)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['nombre'], $data['grado'] ?: null, $data['nivel'] ?: null,
            $data['seccion'] ?: null, $data['instituciones_id'], $data['maestro_id'] ?: null,
        ]);
        return $this->db->lastInsertId();
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE aulas SET nombre = ?, grado = ?, nivel = ?, seccion = ?, maestro_id = ?
            WHERE aulas_id = ?
        ");
        $stmt->execute([
            $data['nombre'], $data['grado'] ?: null, $data['nivel'] ?: null,
            $data['seccion'] ?: null, $data['maestro_id'] ?: null, $id,
        ]);
        return $stmt->rowCount() > 0;
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM aulas WHERE aulas_id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }
}
