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
            $sql .= " AND (nombre LIKE ? OR email LIKE ? OR codigo_institucional LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (int) ($stmt->fetch()['total'] ?? 0);
    }

    public function getPage($search = '', $instId = null, $role = '', $page = 1, $perPage = 10, $sort = 'nombre') {
        $page = max(1, (int) $page);
        $perPage = max(1, min(100, (int) $perPage));
        $offset = ($page - 1) * $perPage;
        $orderBy = $sort === 'created_at' ? 'u.created_at DESC' : 'u.nombre ASC';

        $sql = "
            SELECT u.usuarios_id, u.nombre, u.email, u.role, u.institucion_id,
                   u.estado_institucional, u.telefono, u.created_at, u.codigo_institucional,
                   u.comite_autorizado, i.nombre as institucion_nombre
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
            $sql .= " AND (u.nombre LIKE ? OR u.email LIKE ? OR u.codigo_institucional LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }
        $sql .= " ORDER BY $orderBy LIMIT $perPage OFFSET $offset";

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
        $codigoInstitucional = $data['role'] !== 'user' ? generateCodigoInstitucional($this->db) : null;
        $stmt = $this->db->prepare("
            INSERT INTO usuarios (nombre, email, contra, role, institucion_id, estado_institucional, telefono, codigo_institucional)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['nombre'],
            $data['email'],
            $hashed,
            $data['role'],
            $data['institucion_id'] ?: null,
            $data['estado_institucional'] ?? 'aprobado',
            $data['telefono'] ?: null,
            $codigoInstitucional,
        ]);
        return $this->db->lastInsertId();
    }

    public function update($id, $data) {
        // Si el usuario pasa a tener un rol institucional y todavia no
        // tiene codigo (ej. era 'user' y un admin lo convierte en 'docente'
        // directamente desde esta pestaña), se le genera uno aqui.
        $codigoUpdate = '';
        $params = [
            $data['nombre'],
            $data['role'],
            $data['institucion_id'] ?: null,
            $data['estado_institucional'] ?? 'aprobado',
            $data['telefono'] ?: null,
        ];
        if ($data['role'] !== 'user') {
            $stmt = $this->db->prepare("SELECT codigo_institucional FROM usuarios WHERE usuarios_id = ?");
            $stmt->execute([$id]);
            $existing = $stmt->fetch();
            if ($existing && empty($existing['codigo_institucional'])) {
                $codigoUpdate = ', codigo_institucional = ?';
                $params[] = generateCodigoInstitucional($this->db);
            }
        }
        $params[] = !empty($data['comite_autorizado']) ? 1 : 0;
        $params[] = $id;

        $stmt = $this->db->prepare("
            UPDATE usuarios
            SET nombre = ?, role = ?, institucion_id = ?, estado_institucional = ?, telefono = ?" . $codigoUpdate . ", comite_autorizado = ?
            WHERE usuarios_id = ?
        ");
        $stmt->execute($params);
        return $stmt->rowCount() > 0;
    }

    // Perfil completo + lo publicado por el usuario, para el modal "Ver
    // perfil" de la pestaña de Usuarios (consultar noticias/reportes).
    public function getProfileDetail($id) {
        $user = $this->getById($id);
        if (!$user) return null;
        unset($user['contra']);

        $stmtN = $this->db->prepare("
            SELECT noticias_internas_id, titulo, estado, created_at
            FROM noticias_internas WHERE usuarios_id = ? ORDER BY created_at DESC LIMIT 10
        ");
        $stmtN->execute([$id]);

        $stmtI = $this->db->prepare("
            SELECT incidentes_id, tipo, descripcion, estado, created_at
            FROM incidentes WHERE usuario_id = ? ORDER BY created_at DESC LIMIT 10
        ");
        $stmtI->execute([$id]);

        $user['noticias'] = $stmtN->fetchAll();
        $user['incidentes'] = $stmtI->fetchAll();
        return $user;
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM usuarios WHERE usuarios_id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }
}
