<?php
class UserModel {

    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    // $instId = null cuando quien consulta es Admin General (ve todos los usuarios).
    public function countAll($search = '', $instId = null, $role = '') {
        $sql = "SELECT COUNT(*) as total FROM usuarios WHERE 1=1";
        $params = [];
        if ($instId !== null) {
            $sql .= " AND institucion_id = ?";
            $params[] = $instId;
        }
        if ($role !== '') {
            $sql .= " AND role = ?";
            $params[] = $role;
        }
        if ($search !== '') {
            $sql .= " AND (nombre LIKE ? OR email LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (int) ($stmt->fetch()['total'] ?? 0);
    }

    public function getPage($search = '', $instId = null, $role = '', $page = 1, $perPage = 10) {
        $page = max(1, (int) $page);
        $perPage = max(1, min(100, (int) $perPage));
        $offset = ($page - 1) * $perPage;

        $sql = "
            SELECT u.usuarios_id, u.nombre, u.email, u.role, u.institucion_id,
                   u.estado_institucional, u.telefono, u.created_at, i.nombre as institucion_nombre
            FROM usuarios u
            LEFT JOIN instituciones i ON i.instituciones_id = u.institucion_id
            WHERE 1=1
        ";
        $params = [];
        if ($instId !== null) {
            $sql .= " AND u.institucion_id = ?";
            $params[] = $instId;
        }
        if ($role !== '') {
            $sql .= " AND u.role = ?";
            $params[] = $role;
        }
        if ($search !== '') {
            $sql .= " AND (u.nombre LIKE ? OR u.email LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }
        $sql .= " ORDER BY u.nombre ASC LIMIT $perPage OFFSET $offset";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE usuarios_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function emailExists($email, $excludeId = null) {
        if ($excludeId) {
            $stmt = $this->db->prepare("SELECT usuarios_id FROM usuarios WHERE email = ? AND usuarios_id != ?");
            $stmt->execute([$email, $excludeId]);
        } else {
            $stmt = $this->db->prepare("SELECT usuarios_id FROM usuarios WHERE email = ?");
            $stmt->execute([$email]);
        }
        return (bool) $stmt->fetch();
    }

    public function create($data) {
        $hashed = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("
            INSERT INTO usuarios (nombre, email, contra, role, institucion_id, estado_institucional, telefono)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['nombre'],
            $data['email'],
            $hashed,
            $data['role'],
            $data['institucion_id'] ?: null,
            $data['estado_institucional'] ?? 'aprobado',
            $data['telefono'] ?: null,
        ]);
        return $this->db->lastInsertId();
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE usuarios
            SET nombre = ?, role = ?, institucion_id = ?, estado_institucional = ?, telefono = ?
            WHERE usuarios_id = ?
        ");
        $stmt->execute([
            $data['nombre'],
            $data['role'],
            $data['institucion_id'] ?: null,
            $data['estado_institucional'] ?? 'aprobado',
            $data['telefono'] ?: null,
            $id,
        ]);
        return $stmt->rowCount() > 0;
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM usuarios WHERE usuarios_id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }
}
