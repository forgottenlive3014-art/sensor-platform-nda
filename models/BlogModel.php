<?php
class BlogModel {

    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    public function countAll($instId) {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM blog_riesgos WHERE instituciones_id = ?");
        $stmt->execute([$instId]);
        return (int) ($stmt->fetch()['total'] ?? 0);
    }

    public function getPage($instId, $page = 1, $perPage = 10) {
        $page = max(1, (int) $page);
        $perPage = max(1, min(100, (int) $perPage));
        $offset = ($page - 1) * $perPage;

        $stmt = $this->db->prepare("
            SELECT b.*, u.nombre as autor, u.role as autor_role,
                (SELECT COUNT(*) FROM interacciones_likes WHERE tipo_contenido = 'riesgo' AND contenido_id = b.blog_riesgos_id) as total_likes,
                (SELECT COUNT(*) FROM interacciones_comentarios WHERE tipo_contenido = 'riesgo' AND contenido_id = b.blog_riesgos_id) as total_comments
            FROM blog_riesgos b
            JOIN usuarios u ON u.usuarios_id = b.usuarios_id
            WHERE b.instituciones_id = ?
            ORDER BY b.created_at DESC
            LIMIT $perPage OFFSET $offset
        ");
        $stmt->execute([$instId]);
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM blog_riesgos WHERE blog_riesgos_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO blog_riesgos (instituciones_id, usuarios_id, titulo, descripcion, ubicacion, imagen)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['instituciones_id'], $data['usuarios_id'], $data['titulo'],
            $data['descripcion'], $data['ubicacion'] ?: null, $data['imagen'] ?: null,
        ]);
        return $this->db->lastInsertId();
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM blog_riesgos WHERE blog_riesgos_id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }
}
