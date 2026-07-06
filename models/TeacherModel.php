<?php
class TeacherModel {

    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    public function countAll($instId, $isGlobalAdmin, $search = '') {
        $sql = "SELECT COUNT(*) as total FROM usuarios WHERE role = 'docente'";
        $params = [];
        if (!$isGlobalAdmin) {
            $sql .= " AND institucion_id = ?";
            $params[] = $instId;
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

    public function getPage($instId, $isGlobalAdmin, $search = '', $page = 1, $perPage = 10) {
        $page = max(1, (int) $page);
        $perPage = max(1, min(100, (int) $perPage));
        $offset = ($page - 1) * $perPage;

        $sql = "
            SELECT u.usuarios_id, u.nombre, u.email, u.telefono, u.materia, u.foto_perfil,
                   GROUP_CONCAT(a.nombre SEPARATOR ', ') as aulas
            FROM usuarios u
            LEFT JOIN aulas a ON a.maestro_id = u.usuarios_id
            WHERE u.role = 'docente'
        ";
        $params = [];
        if (!$isGlobalAdmin) {
            $sql .= " AND u.institucion_id = ?";
            $params[] = $instId;
        }
        if ($search !== '') {
            $sql .= " AND (u.nombre LIKE ? OR u.email LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }
        $sql .= " GROUP BY u.usuarios_id ORDER BY u.nombre ASC LIMIT $perPage OFFSET $offset";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE usuarios_id = ? AND role = 'docente'");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function emailExists($email) {
        $stmt = $this->db->prepare("SELECT usuarios_id FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        return (bool) $stmt->fetch();
    }

    public function create($data) {
        $hashed = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("
            INSERT INTO usuarios (nombre, email, contra, role, institucion_id, estado_institucional, telefono, materia)
            VALUES (?, ?, ?, 'docente', ?, 'aprobado', ?, ?)
        ");
        $stmt->execute([
            $data['nombre'], $data['email'], $hashed, $data['institucion_id'],
            $data['telefono'] ?: null, $data['materia'] ?: null,
        ]);
        return $this->db->lastInsertId();
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE usuarios SET nombre = ?, telefono = ?, materia = ?
            WHERE usuarios_id = ? AND role = 'docente'
        ");
        $stmt->execute([$data['nombre'], $data['telefono'] ?: null, $data['materia'] ?: null, $id]);
        return $stmt->rowCount() > 0;
    }

    public function updatePhoto($id, $path) {
        $stmt = $this->db->prepare("UPDATE usuarios SET foto_perfil = ? WHERE usuarios_id = ? AND role = 'docente'");
        $stmt->execute([$path, $id]);
        return $stmt->rowCount() > 0;
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM usuarios WHERE usuarios_id = ? AND role = 'docente'");
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }
}
