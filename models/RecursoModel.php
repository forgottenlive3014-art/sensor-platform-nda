<?php
class RecursoModel {

    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    public function countAll($search = '') {
        $sql = "SELECT COUNT(*) as total FROM recursos WHERE 1=1";
        $params = [];
        if ($search !== '') {
            $sql .= " AND (titulo LIKE ? OR descripcion LIKE ?)";
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

        $sql = "SELECT * FROM recursos WHERE 1=1";
        $params = [];
        if ($search !== '') {
            $sql .= " AND (titulo LIKE ? OR descripcion LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }
        $sql .= " ORDER BY orden ASC, created_at DESC LIMIT $perPage OFFSET $offset";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM recursos WHERE recursos_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getAllForPublic() {
        $stmt = $this->db->query("SELECT * FROM recursos ORDER BY orden ASC, created_at DESC");
        return $stmt->fetchAll();
    }

    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO recursos (titulo, descripcion, categoria, tags, archivo, tamano_bytes, orden, usuarios_id)
            VALUES (:titulo, :descripcion, :categoria, :tags, :archivo, :tamano, :orden, :usuarios_id)
        ");
        $stmt->execute([
            ':titulo' => $data['titulo'],
            ':descripcion' => $data['descripcion'],
            ':categoria' => $data['categoria'],
            ':tags' => $data['tags'],
            ':archivo' => $data['archivo'],
            ':tamano' => $data['tamano_bytes'],
            ':orden' => $data['orden'],
            ':usuarios_id' => $data['usuarios_id'],
        ]);
        return $this->db->lastInsertId();
    }

    public function update($id, $data) {
        $sql = "UPDATE recursos SET titulo = :titulo, descripcion = :descripcion,
                categoria = :categoria, tags = :tags, orden = :orden";
        $params = [
            ':titulo' => $data['titulo'],
            ':descripcion' => $data['descripcion'],
            ':categoria' => $data['categoria'],
            ':tags' => $data['tags'],
            ':orden' => $data['orden'],
            ':id' => $id,
        ];
        if (!empty($data['archivo'])) {
            $sql .= ", archivo = :archivo, tamano_bytes = :tamano";
            $params[':archivo'] = $data['archivo'];
            $params[':tamano'] = $data['tamano_bytes'];
        }
        $sql .= " WHERE recursos_id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount() > 0;
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM recursos WHERE recursos_id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }
}
