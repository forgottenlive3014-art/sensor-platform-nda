<?php
class NewsModel {

    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    // $onlyPublished = true para lectores sin permiso de moderación (solo ven 'publicada').
    public function countAll($instId, $isGlobalAdmin, $search = '', $onlyPublished = false) {
        $sql = "SELECT COUNT(*) as total FROM noticias_internas WHERE 1=1";
        $params = [];
        if (!$isGlobalAdmin) {
            $sql .= " AND (instituciones_id = ? OR instituciones_id IS NULL)";
            $params[] = $instId;
        }
        if ($onlyPublished) {
            $sql .= " AND estado = 'publicada'";
        }
        if ($search !== '') {
            $sql .= " AND (titulo LIKE ? OR contenido LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (int) ($stmt->fetch()['total'] ?? 0);
    }

    public function getPage($instId, $isGlobalAdmin, $search = '', $page = 1, $perPage = 10, $onlyPublished = false) {
        $page = max(1, (int) $page);
        $perPage = max(1, min(100, (int) $perPage));
        $offset = ($page - 1) * $perPage;

        $sql = "
            SELECT n.*, u.nombre as autor, i.nombre as institucion_nombre
            FROM noticias_internas n
            LEFT JOIN usuarios u ON u.usuarios_id = n.usuarios_id
            LEFT JOIN instituciones i ON i.instituciones_id = n.instituciones_id
            WHERE 1=1
        ";
        $params = [];
        if (!$isGlobalAdmin) {
            $sql .= " AND (n.instituciones_id = ? OR n.instituciones_id IS NULL)";
            $params[] = $instId;
        }
        if ($onlyPublished) {
            $sql .= " AND n.estado = 'publicada'";
        }
        if ($search !== '') {
            $sql .= " AND (n.titulo LIKE ? OR n.contenido LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }
        $sql .= " ORDER BY n.created_at DESC LIMIT $perPage OFFSET $offset";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM noticias_internas WHERE noticias_internas_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO noticias_internas (instituciones_id, usuarios_id, titulo, contenido, estado)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([$data['instituciones_id'], $data['usuarios_id'], $data['titulo'], $data['contenido'], $data['estado'] ?? 'publicada']);
        return $this->db->lastInsertId();
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE noticias_internas SET titulo = ?, contenido = ? WHERE noticias_internas_id = ?
        ");
        $stmt->execute([$data['titulo'], $data['contenido'], $id]);
        return $stmt->rowCount() > 0;
    }

    public function setEstado($id, $estado, $revisorId) {
        $stmt = $this->db->prepare("
            UPDATE noticias_internas SET estado = ?, revisado_por = ? WHERE noticias_internas_id = ?
        ");
        $stmt->execute([$estado, $revisorId, $id]);
        return $stmt->rowCount() > 0;
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM noticias_internas WHERE noticias_internas_id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }
}
