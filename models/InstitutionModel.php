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

    // Desglose de una institucion para el superadmin: cuantos docentes,
    // alumnos, personal administrativo, padres, rutas de evacuacion e
    // incidentes ("danos") tiene. Una sola consulta con subconsultas,
    // mismo estilo que el total_usuarios de getPage().
    public function getStats($institucionId) {
        $stmt = $this->db->prepare("
            SELECT
                (SELECT COUNT(*) FROM usuarios WHERE institucion_id = ? AND role = 'docente') AS docentes,
                (SELECT COUNT(*) FROM usuarios WHERE institucion_id = ? AND role = 'alumno') AS alumnos,
                (SELECT COUNT(*) FROM usuarios WHERE institucion_id = ? AND role = 'administrativo') AS administrativos,
                (SELECT COUNT(*) FROM usuarios WHERE institucion_id = ? AND role = 'padre') AS padres,
                (SELECT COUNT(*) FROM rutas_evacuacion WHERE instituciones_id = ?) AS rutas,
                (SELECT COUNT(*) FROM incidentes WHERE instituciones_id = ? AND estado = 'abierto') AS incidentes_abiertos,
                (SELECT COUNT(*) FROM incidentes WHERE instituciones_id = ? AND estado = 'resuelto') AS incidentes_resueltos
        ");
        $stmt->execute([$institucionId, $institucionId, $institucionId, $institucionId, $institucionId, $institucionId, $institucionId]);
        $row = $stmt->fetch();
        return [
            'docentes' => (int) ($row['docentes'] ?? 0),
            'alumnos' => (int) ($row['alumnos'] ?? 0),
            'administrativos' => (int) ($row['administrativos'] ?? 0),
            'padres' => (int) ($row['padres'] ?? 0),
            'rutas' => (int) ($row['rutas'] ?? 0),
            'incidentes_abiertos' => (int) ($row['incidentes_abiertos'] ?? 0),
            'incidentes_resueltos' => (int) ($row['incidentes_resueltos'] ?? 0),
        ];
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
            INSERT INTO instituciones (nombre, correo, telefono, direccion, lat, lng)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['nombre'],
            $data['correo'] ?: null,
            $data['telefono'] ?: null,
            $data['direccion'] ?: null,
            $data['lat'] !== '' && $data['lat'] !== null ? (float) $data['lat'] : null,
            $data['lng'] !== '' && $data['lng'] !== null ? (float) $data['lng'] : null,
        ]);
        return $this->db->lastInsertId();
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE instituciones SET nombre = ?, correo = ?, telefono = ?, direccion = ?, lat = ?, lng = ?
            WHERE instituciones_id = ?
        ");
        $stmt->execute([
            $data['nombre'],
            $data['correo'] ?: null,
            $data['telefono'] ?: null,
            $data['direccion'] ?: null,
            $data['lat'] !== '' && $data['lat'] !== null ? (float) $data['lat'] : null,
            $data['lng'] !== '' && $data['lng'] !== null ? (float) $data['lng'] : null,
            $id,
        ]);
        return $stmt->rowCount() > 0;
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM instituciones WHERE instituciones_id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }

    // ------------------------------------------------------------------
    // Registro público de instituciones con verificación por correo.
    // ------------------------------------------------------------------

    // Crea la institución en estado 'pendiente' de verificación, ligada
    // al usuario que la registra (aun no es 'director' hasta verificar).
    public function createPending($data, $codigo, $expira) {
        $stmt = $this->db->prepare("
            INSERT INTO instituciones
                (nombre, tipo, correo, correo_director_personal, nombre_director,
                 telefono, direccion, director_id, estado_verificacion,
                 codigo_verificacion, codigo_verificacion_expira)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pendiente', ?, ?)
        ");
        $stmt->execute([
            $data['nombre'],
            $data['tipo'],
            $data['correo'],
            $data['correo_director_personal'] ?: null,
            $data['nombre_director'],
            $data['telefono'] ?: null,
            $data['direccion'] ?: null,
            $data['director_id'],
            $codigo,
            $expira,
        ]);
        return $this->db->lastInsertId();
    }

    // Institución sin verificar que este usuario registró (si existe).
    public function getPendingByDirector($userId) {
        $stmt = $this->db->prepare("
            SELECT * FROM instituciones
            WHERE director_id = ? AND estado_verificacion = 'pendiente'
            ORDER BY instituciones_id DESC LIMIT 1
        ");
        $stmt->execute([$userId]);
        return $stmt->fetch();
    }

    public function updateVerificationCode($id, $codigo, $expira) {
        $stmt = $this->db->prepare("
            UPDATE instituciones SET codigo_verificacion = ?, codigo_verificacion_expira = ?
            WHERE instituciones_id = ?
        ");
        $stmt->execute([$codigo, $expira, $id]);
    }

    public function markVerified($id) {
        $stmt = $this->db->prepare("
            UPDATE instituciones
            SET estado_verificacion = 'verificado', codigo_verificacion = NULL, codigo_verificacion_expira = NULL
            WHERE instituciones_id = ?
        ");
        $stmt->execute([$id]);
    }
}
