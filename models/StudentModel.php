<?php
class StudentModel {

    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    // La institucion de un alumno se determina por su propia cuenta de
    // usuario (usuarios.institucion_id), NO por el aula — un alumno sin
    // aula asignada todavia pertenece a su institucion y debe seguir
    // siendo visible/editable.
    public function countAll($instId, $isGlobalAdmin, $search = '', $aulaId = '', $teacherId = null) {
        $sql = "
            SELECT COUNT(*) as total
            FROM estudiantes e
            JOIN usuarios su ON e.usuarios_id = su.usuarios_id
            LEFT JOIN aulas a ON e.aulas_id = a.aulas_id
            WHERE 1=1
        ";
        $params = [];
        if (!$isGlobalAdmin) {
            $sql .= " AND su.institucion_id = ?";
            $params[] = $instId;
        }
        if ($teacherId !== null) {
            $sql .= " AND a.maestro_id = ?";
            $params[] = $teacherId;
        }
        if ($aulaId !== '') {
            $sql .= " AND e.aulas_id = ?";
            $params[] = $aulaId;
        }
        if ($search !== '') {
            $sql .= " AND (e.nombre LIKE ? OR e.apellido LIKE ? OR e.codigo LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (int) ($stmt->fetch()['total'] ?? 0);
    }

    // $teacherId: si se pasa (docente viendo "solo mis alumnos"), se
    // restringe a estudiantes cuya aula tiene ese docente como maestro_id.
    public function getPage($instId, $isGlobalAdmin, $search = '', $aulaId = '', $page = 1, $perPage = 10, $teacherId = null) {
        $page = max(1, (int) $page);
        $perPage = max(1, min(100, (int) $perPage));
        $offset = ($page - 1) * $perPage;

        $sql = "
            SELECT e.*, a.nombre as classroom, a.grado, a.seccion, u.nombre as teacher
            FROM estudiantes e
            JOIN usuarios su ON e.usuarios_id = su.usuarios_id
            LEFT JOIN aulas a ON e.aulas_id = a.aulas_id
            LEFT JOIN usuarios u ON a.maestro_id = u.usuarios_id
            WHERE 1=1
        ";
        $params = [];
        if (!$isGlobalAdmin) {
            $sql .= " AND su.institucion_id = ?";
            $params[] = $instId;
        }
        if ($teacherId !== null) {
            $sql .= " AND a.maestro_id = ?";
            $params[] = $teacherId;
        }
        if ($aulaId !== '') {
            $sql .= " AND e.aulas_id = ?";
            $params[] = $aulaId;
        }
        if ($search !== '') {
            $sql .= " AND (e.nombre LIKE ? OR e.apellido LIKE ? OR e.codigo LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }
        $sql .= " ORDER BY e.numero_lista ASC, e.nombre ASC LIMIT $perPage OFFSET $offset";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("
            SELECT e.*, su.institucion_id as instituciones_id
            FROM estudiantes e
            JOIN usuarios su ON e.usuarios_id = su.usuarios_id
            WHERE e.estudiantes_id = ?
        ");
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
            INSERT INTO usuarios (nombre, email, contra, role, institucion_id, estado_institucional)
            VALUES (?, ?, ?, 'alumno', ?, 'aprobado')
        ");
        $stmt->execute([$data['nombre'] . ' ' . $data['apellido'], $data['email'], $hashed, $data['institucion_id']]);
        $userId = $this->db->lastInsertId();

        $codigo = 'EST' . str_pad($userId, 6, '0', STR_PAD_LEFT);
        $stmt = $this->db->prepare("
            INSERT INTO estudiantes (codigo, usuarios_id, aulas_id, nombre, apellido, numero_lista, edad, telefono_emergencia)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $codigo, $userId, $data['aulas_id'] ?: null, $data['nombre'], $data['apellido'],
            $data['numero_lista'] ?: null, $data['edad'] ?: null, $data['telefono_emergencia'] ?: null,
        ]);

        return ['estudiante_id' => $this->db->lastInsertId(), 'usuario_id' => $userId];
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE estudiantes SET nombre = ?, apellido = ?, aulas_id = ?, numero_lista = ?, edad = ?, telefono_emergencia = ?
            WHERE estudiantes_id = ?
        ");
        $stmt->execute([
            $data['nombre'], $data['apellido'], $data['aulas_id'] ?: null, $data['numero_lista'] ?: null,
            $data['edad'] ?: null, $data['telefono_emergencia'] ?: null, $id,
        ]);
        return $stmt->rowCount() > 0;
    }

    public function delete($id) {
        $stmt = $this->db->prepare("SELECT usuarios_id FROM estudiantes WHERE estudiantes_id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if (!$row) return false;
        // Borrar el usuario en cascada borra tambien la fila de estudiantes
        // (FOREIGN KEY ... ON DELETE CASCADE en sql/nda_project.sql).
        $stmt = $this->db->prepare("DELETE FROM usuarios WHERE usuarios_id = ?");
        $stmt->execute([$row['usuarios_id']]);
        return $stmt->rowCount() > 0;
    }
}
