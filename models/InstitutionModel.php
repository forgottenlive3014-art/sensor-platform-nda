<?php
class InstitutionModel {

    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    public function countAll($search = '') {
        $sql = "SELECT COUNT(*) as total FROM instituciones";
        $params = [];
        if ($search !== '') {
            $sql .= " WHERE nombre LIKE ? OR correo LIKE ?";
            $params = ["%$search%", "%$search%"];
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (int) ($stmt->fetch()['total'] ?? 0);
    }

    public function getPage($search = '', $page = 1, $perPage = 10) {
        $page = max(1, (int) $page);
        $perPage = max(1, min(100, (int) $perPage));
        $offset = ($page - 1) * $perPage;

        $sql = "
            SELECT i.*, u.nombre as director_nombre,
                   (SELECT COUNT(*) FROM usuarios u2 WHERE u2.institucion_id = i.instituciones_id) as total_usuarios
            FROM instituciones i
            LEFT JOIN usuarios u ON u.usuarios_id = i.director_id
        ";
        $params = [];
        if ($search !== '') {
            $sql .= " WHERE i.nombre LIKE ? OR i.correo LIKE ?";
            $params = ["%$search%", "%$search%"];
        }
        $sql .= " ORDER BY i.nombre ASC LIMIT $perPage OFFSET $offset";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM instituciones WHERE instituciones_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function emailExists($email, $excludeId = null) {
        if ($excludeId) {
            $stmt = $this->db->prepare("SELECT instituciones_id FROM instituciones WHERE correo = ? AND instituciones_id != ?");
            $stmt->execute([$email, $excludeId]);
        } else {
            $stmt = $this->db->prepare("SELECT instituciones_id FROM instituciones WHERE correo = ?");
            $stmt->execute([$email]);
        }
        return (bool) $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO instituciones (nombre, correo, telefono, direccion)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['nombre'],
            $data['correo'] ?: null,
            $data['telefono'] ?: null,
            $data['direccion'] ?: null,
        ]);
        return $this->db->lastInsertId();
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE instituciones SET nombre = ?, correo = ?, telefono = ?, direccion = ?
            WHERE instituciones_id = ?
        ");
        $stmt->execute([
            $data['nombre'],
            $data['correo'] ?: null,
            $data['telefono'] ?: null,
            $data['direccion'] ?: null,
            $id,
        ]);
        return $stmt->rowCount() > 0;
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM instituciones WHERE instituciones_id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }
}
