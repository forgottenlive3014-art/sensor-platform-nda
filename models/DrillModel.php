<?php
class DrillModel {

    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    public function getRecent($instId, $isGlobalAdmin, $limit = 10) {
        $sql = "
            SELECT s.*, i.nombre as institution,
                   (SELECT COUNT(*) FROM asistencia_simulacros WHERE simulacros_id = s.simulacros_id) as total_asistencia
            FROM simulacros s
            LEFT JOIN instituciones i ON s.instituciones_id = i.instituciones_id
        ";
        $params = [];
        if (!$isGlobalAdmin) {
            $sql .= " WHERE s.instituciones_id = ?";
            $params[] = $instId;
        }
        $sql .= " ORDER BY s.fecha DESC LIMIT " . intval($limit);
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM simulacros WHERE simulacros_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO simulacros (nombre, fecha, hora, instituciones_id, tipo, descripcion)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['nombre'], $data['fecha'], $data['hora'],
            $data['instituciones_id'], $data['tipo'], $data['descripcion'],
        ]);
        return $this->db->lastInsertId();
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE simulacros SET nombre = ?, fecha = ?, hora = ?, tipo = ?, descripcion = ?
            WHERE simulacros_id = ?
        ");
        $stmt->execute([
            $data['nombre'], $data['fecha'], $data['hora'],
            $data['tipo'], $data['descripcion'], $id,
        ]);
        return $stmt->rowCount() > 0;
    }

    public function activate($id) {
        $stmt = $this->db->prepare("UPDATE simulacros SET estado = 'activo', activado_at = NOW() WHERE simulacros_id = ?");
        $stmt->execute([$id]);
    }

    public function finish($id) {
        $stmt = $this->db->prepare("UPDATE simulacros SET estado = 'finalizado' WHERE simulacros_id = ?");
        $stmt->execute([$id]);
    }

    public function getActiveForInstitution($instId) {
        $stmt = $this->db->prepare("
            SELECT simulacros_id, nombre, tipo, activado_at FROM simulacros
            WHERE instituciones_id = ? AND estado = 'activo' LIMIT 1
        ");
        $stmt->execute([$instId]);
        return $stmt->fetch();
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM simulacros WHERE simulacros_id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }
}
