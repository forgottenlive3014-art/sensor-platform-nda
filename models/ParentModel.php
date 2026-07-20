<?php
class ParentModel {

    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    public function countAll($instId, $isGlobalAdmin, $search = '') {
        $sql = "SELECT COUNT(*) as total FROM usuarios WHERE role = 'padre'";
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
            SELECT u.usuarios_id, u.nombre, u.email, u.telefono,
                   GROUP_CONCAT(CONCAT(e.nombre, ' ', e.apellido) SEPARATOR ', ') as hijos
            FROM usuarios u
            LEFT JOIN padres_estudiantes pe ON pe.padre_usuario_id = u.usuarios_id
            LEFT JOIN estudiantes e ON e.estudiantes_id = pe.estudiante_id
            WHERE u.role = 'padre'
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
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE usuarios_id = ? AND role = 'padre'");
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
        $codigoInstitucional = generateCodigoInstitucional($this->db);
        $stmt = $this->db->prepare("
            INSERT INTO usuarios (nombre, email, contra, role, institucion_id, estado_institucional, telefono, codigo_institucional)
            VALUES (?, ?, ?, 'padre', ?, 'aprobado', ?, ?)
        ");
        $stmt->execute([$data['nombre'], $data['email'], $hashed, $data['institucion_id'], $data['telefono'] ?: null, $codigoInstitucional]);
        return $this->db->lastInsertId();
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE usuarios SET nombre = ?, telefono = ? WHERE usuarios_id = ? AND role = 'padre'");
        $stmt->execute([$data['nombre'], $data['telefono'] ?: null, $id]);
        return $stmt->rowCount() > 0;
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM usuarios WHERE usuarios_id = ? AND role = 'padre'");
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }

    // --- Vínculo Padre <-> Estudiante ---

    public function linkChild($padreUsuarioId, $estudianteId, $parentesco) {
        $stmt = $this->db->prepare("
            INSERT INTO padres_estudiantes (padre_usuario_id, estudiante_id, parentesco)
            VALUES (?, ?, ?)
            ON DUPLICATE KEY UPDATE parentesco = VALUES(parentesco)
        ");
        $stmt->execute([$padreUsuarioId, $estudianteId, $parentesco ?: 'padre/madre']);
        return $this->db->lastInsertId();
    }

    public function unlinkChild($linkId, $padreUsuarioId = null) {
        if ($padreUsuarioId !== null) {
            $stmt = $this->db->prepare("DELETE FROM padres_estudiantes WHERE padres_estudiantes_id = ? AND padre_usuario_id = ?");
            $stmt->execute([$linkId, $padreUsuarioId]);
        } else {
            $stmt = $this->db->prepare("DELETE FROM padres_estudiantes WHERE padres_estudiantes_id = ?");
            $stmt->execute([$linkId]);
        }
        return $stmt->rowCount() > 0;
    }

    public function getLinksForParent($padreUsuarioId) {
        $stmt = $this->db->prepare("
            SELECT pe.padres_estudiantes_id, pe.parentesco, e.estudiantes_id, e.nombre, e.apellido, e.codigo
            FROM padres_estudiantes pe
            JOIN estudiantes e ON e.estudiantes_id = pe.estudiante_id
            WHERE pe.padre_usuario_id = ?
            ORDER BY e.nombre
        ");
        $stmt->execute([$padreUsuarioId]);
        return $stmt->fetchAll();
    }

    // Hijos de un padre con datos enriquecidos (aula, docente) para el
    // panel de solo lectura del propio padre.
    public function getChildrenWithDetails($padreUsuarioId) {
        $stmt = $this->db->prepare("
            SELECT e.estudiantes_id, e.codigo, e.nombre, e.apellido, a.nombre as classroom, u.nombre as teacher
            FROM padres_estudiantes pe
            JOIN estudiantes e ON e.estudiantes_id = pe.estudiante_id
            LEFT JOIN aulas a ON a.aulas_id = e.aulas_id
            LEFT JOIN usuarios u ON u.usuarios_id = a.maestro_id
            WHERE pe.padre_usuario_id = ?
            ORDER BY e.nombre
        ");
        $stmt->execute([$padreUsuarioId]);
        return $stmt->fetchAll();
    }

    // Estado de cada hijo en el simulacro mas reciente que tenga registro
    // de asistencia (para que el padre sepa "si ya salio" en el ultimo
    // simulacro realizado).
    public function getChildrenLatestDrillStatus($padreUsuarioId) {
        $stmt = $this->db->prepare("
            SELECT e.estudiantes_id, e.nombre, e.apellido,
                   at.estado as status, s.nombre as simulacro, s.fecha as simulacro_fecha
            FROM padres_estudiantes pe
            JOIN estudiantes e ON e.estudiantes_id = pe.estudiante_id
            LEFT JOIN (
                SELECT at1.*
                FROM asistencia_simulacros at1
                JOIN simulacros s1 ON s1.simulacros_id = at1.simulacros_id
                WHERE at1.created_at = (
                    SELECT MAX(at2.created_at)
                    FROM asistencia_simulacros at2
                    WHERE at2.estudiantes_id = at1.estudiantes_id
                )
            ) at ON at.estudiantes_id = e.estudiantes_id
            LEFT JOIN simulacros s ON s.simulacros_id = at.simulacros_id
            WHERE pe.padre_usuario_id = ?
            ORDER BY e.nombre
        ");
        $stmt->execute([$padreUsuarioId]);
        return $stmt->fetchAll();
    }
}
