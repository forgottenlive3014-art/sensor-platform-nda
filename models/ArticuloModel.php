<?php
class ArticuloModel {

    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    public function countAll($search = '') {
        $sql = "SELECT COUNT(*) as total FROM blog WHERE 1=1";
        $params = [];
        if ($search !== '') {
            $sql .= " AND (titulo LIKE ? OR extracto LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (int) ($stmt->fetch()['total'] ?? 0);
    }

    public function getPage($search = '', $page = 1, $perPage = 10) {
        $page = max(1, (int) $page);
        $perPage = max(1, min(100, (int) $perPage));
        $offset = ($page - 1) * $perPage;

        $sql = "SELECT * FROM blog WHERE 1=1";
        $params = [];
        if ($search !== '') {
            $sql .= " AND (titulo LIKE ? OR extracto LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }
        $sql .= " ORDER BY destacado DESC, created_at DESC LIMIT $perPage OFFSET $offset";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM blog WHERE blog_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getBySlug($slug) {
        $stmt = $this->db->prepare("SELECT * FROM blog WHERE slug = ?");
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }

    // Indexado por slug, para calzar con lo que ya espera views/blog.php.
    public function getAllForPublic() {
        $stmt = $this->db->query("SELECT * FROM blog ORDER BY destacado DESC, created_at DESC");
        $rows = $stmt->fetchAll();
        $out = [];
        foreach ($rows as $r) {
            $out[$r['slug']] = [
                'titulo' => $r['titulo'],
                'cat' => $r['cat'],
                'tag' => $r['tag'],
                'color' => $r['color'],
                'autor' => $r['autor_nombre'],
                'tiempo' => $r['tiempo'],
                'destacado' => (bool) $r['destacado'],
                'img' => $r['imagen'],
                'extracto' => $r['extracto'],
                'cuerpo' => $r['cuerpo'],
            ];
        }
        return $out;
    }

    public function slugExists($slug, $excludeId = null) {
        $sql = "SELECT COUNT(*) as total FROM blog WHERE slug = ?";
        $params = [$slug];
        if ($excludeId) {
            $sql .= " AND blog_id != ?";
            $params[] = $excludeId;
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return ((int) ($stmt->fetch()['total'] ?? 0)) > 0;
    }

    public function create($data) {
        if (!empty($data['destacado'])) {
            $this->db->exec("UPDATE blog SET destacado = 0");
        }
        $stmt = $this->db->prepare("
            INSERT INTO blog (slug, titulo, cat, tag, color, autor_id, autor_nombre, tiempo, destacado, extracto, imagen, cuerpo)
            VALUES (:slug, :titulo, :cat, :tag, :color, :autor_id, :autor_nombre, :tiempo, :destacado, :extracto, :imagen, :cuerpo)
        ");
        $stmt->execute([
            ':slug' => $data['slug'],
            ':titulo' => $data['titulo'],
            ':cat' => $data['cat'],
            ':tag' => $data['tag'],
            ':color' => $data['color'],
            ':autor_id' => $data['autor_id'],
            ':autor_nombre' => $data['autor_nombre'],
            ':tiempo' => $data['tiempo'],
            ':destacado' => $data['destacado'] ? 1 : 0,
            ':extracto' => $data['extracto'],
            ':imagen' => $data['imagen'],
            ':cuerpo' => $data['cuerpo'],
        ]);
        return $this->db->lastInsertId();
    }

    public function update($id, $data) {
        if (!empty($data['destacado'])) {
            $this->db->exec("UPDATE blog SET destacado = 0");
        }
        $sql = "UPDATE blog SET slug = :slug, titulo = :titulo, cat = :cat, tag = :tag, color = :color,
                autor_nombre = :autor_nombre, tiempo = :tiempo, destacado = :destacado,
                extracto = :extracto, cuerpo = :cuerpo";
        $params = [
            ':slug' => $data['slug'],
            ':titulo' => $data['titulo'],
            ':cat' => $data['cat'],
            ':tag' => $data['tag'],
            ':color' => $data['color'],
            ':autor_nombre' => $data['autor_nombre'],
            ':tiempo' => $data['tiempo'],
            ':destacado' => $data['destacado'] ? 1 : 0,
            ':extracto' => $data['extracto'],
            ':cuerpo' => $data['cuerpo'],
            ':id' => $id,
        ];
        if (array_key_exists('imagen', $data) && $data['imagen'] !== null) {
            $sql .= ", imagen = :imagen";
            $params[':imagen'] = $data['imagen'];
        }
        $sql .= " WHERE blog_id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount() > 0;
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM blog WHERE blog_id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }
}
