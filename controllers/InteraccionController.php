<?php
// "Me gusta" y comentarios, compartidos entre Noticias, Lugares en riesgo e
// Incidentes (tipo_contenido genérico) — ver sql/interacciones_migration.sql.
class InteraccionController {

    // tipo_contenido => [tabla, columna PK, columna institucion]
    private $tablas = [
        'noticia'   => ['tabla' => 'noticias_internas', 'pk' => 'noticias_internas_id', 'inst' => 'instituciones_id'],
        'riesgo'    => ['tabla' => 'blog_riesgos',       'pk' => 'blog_riesgos_id',       'inst' => 'instituciones_id'],
        'incidente' => ['tabla' => 'incidentes',         'pk' => 'incidentes_id',         'inst' => 'instituciones_id'],
    ];

    private function canAccessSchool() {
        $u = currentUser();
        if (!$u) return false;
        if ($u['role'] === 'admin') return true;
        return in_array($u['role'], ['director', 'docente', 'alumno', 'padre', 'administrativo'], true)
            && $u['estado_institucional'] === 'aprobado';
    }

    private function isSchoolAdmin() {
        $u = currentUser();
        if (!$u) return false;
        return $u['role'] === 'admin' || $u['role'] === 'director';
    }

    // Valida tipo_contenido + que el contenido exista y pertenezca a la
    // institucion del usuario actual (o sea una noticia global, o el
    // usuario sea admin). Devuelve la fila del contenido si es valido,
    // o corta la ejecucion con jsonResponse() si no.
    private function resolveContenido($tipo, $id) {
        if (!isset($this->tablas[$tipo])) {
            jsonResponse(['error' => 'Tipo de contenido inválido'], 400);
        }
        if (!$id) {
            jsonResponse(['error' => 'ID de contenido requerido'], 400);
        }
        $meta = $this->tablas[$tipo];
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM {$meta['tabla']} WHERE {$meta['pk']} = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if (!$row) {
            jsonResponse(['error' => 'Contenido no encontrado'], 404);
        }

        $u = currentUser();
        $contenidoInstId = $row[$meta['inst']] ?? null;
        $esGlobal = $contenidoInstId === null;
        if ($u['role'] !== 'admin' && !$esGlobal && (int) $contenidoInstId !== (int) $u['institucion_id']) {
            jsonResponse(['error' => 'No autorizado'], 403);
        }

        return $row;
    }

    public function toggleLike() {
        if (!isLoggedIn() || !$this->canAccessSchool()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $input = json_decode(file_get_contents('php://input'), true);
        $tipo = $input['tipo'] ?? '';
        $id = $input['id'] ?? null;
        $this->resolveContenido($tipo, $id);

        $u = currentUser();
        $db = getDB();
        $stmt = $db->prepare("SELECT interacciones_likes_id FROM interacciones_likes WHERE tipo_contenido = ? AND contenido_id = ? AND usuarios_id = ?");
        $stmt->execute([$tipo, $id, $u['id']]);
        $existing = $stmt->fetch();

        if ($existing) {
            $db->prepare("DELETE FROM interacciones_likes WHERE interacciones_likes_id = ?")->execute([$existing['interacciones_likes_id']]);
            $liked = false;
        } else {
            $db->prepare("INSERT INTO interacciones_likes (tipo_contenido, contenido_id, usuarios_id) VALUES (?, ?, ?)")
               ->execute([$tipo, $id, $u['id']]);
            $liked = true;
        }

        $stmtT = $db->prepare("SELECT COUNT(*) as total FROM interacciones_likes WHERE tipo_contenido = ? AND contenido_id = ?");
        $stmtT->execute([$tipo, $id]);
        $total = (int) ($stmtT->fetch()['total'] ?? 0);

        jsonResponse(['success' => true, 'liked' => $liked, 'total' => $total]);
    }

    public function getSummary() {
        if (!isLoggedIn() || !$this->canAccessSchool()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $tipo = $_GET['tipo'] ?? '';
        $id = $_GET['id'] ?? null;
        $this->resolveContenido($tipo, $id);

        $u = currentUser();
        $db = getDB();

        $stmtL = $db->prepare("SELECT COUNT(*) as total FROM interacciones_likes WHERE tipo_contenido = ? AND contenido_id = ?");
        $stmtL->execute([$tipo, $id]);
        $totalLikes = (int) ($stmtL->fetch()['total'] ?? 0);

        $stmtMe = $db->prepare("SELECT 1 FROM interacciones_likes WHERE tipo_contenido = ? AND contenido_id = ? AND usuarios_id = ?");
        $stmtMe->execute([$tipo, $id, $u['id']]);
        $likedByMe = (bool) $stmtMe->fetch();

        $stmtC = $db->prepare("SELECT COUNT(*) as total FROM interacciones_comentarios WHERE tipo_contenido = ? AND contenido_id = ?");
        $stmtC->execute([$tipo, $id]);
        $totalComments = (int) ($stmtC->fetch()['total'] ?? 0);

        jsonResponse(['total_likes' => $totalLikes, 'liked_by_me' => $likedByMe, 'total_comments' => $totalComments]);
    }

    public function listComments() {
        if (!isLoggedIn() || !$this->canAccessSchool()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $tipo = $_GET['tipo'] ?? '';
        $id = $_GET['id'] ?? null;
        $this->resolveContenido($tipo, $id);

        $db = getDB();
        $stmt = $db->prepare("
            SELECT c.*, u.nombre as autor, u.role as autor_role
            FROM interacciones_comentarios c
            JOIN usuarios u ON u.usuarios_id = c.usuarios_id
            WHERE c.tipo_contenido = ? AND c.contenido_id = ?
            ORDER BY c.created_at ASC
        ");
        $stmt->execute([$tipo, $id]);
        jsonResponse($stmt->fetchAll());
    }

    public function addComment() {
        if (!isLoggedIn() || !$this->canAccessSchool()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $input = json_decode(file_get_contents('php://input'), true);
        $tipo = $input['tipo'] ?? '';
        $id = $input['id'] ?? null;
        $this->resolveContenido($tipo, $id);

        $texto = trim($input['texto'] ?? '');
        if ($texto === '') {
            jsonResponse(['error' => 'Escribe un comentario'], 400);
        }
        if (mb_strlen($texto) > 500) {
            jsonResponse(['error' => 'El comentario no puede superar los 500 caracteres'], 400);
        }

        $u = currentUser();
        $db = getDB();
        $db->prepare("INSERT INTO interacciones_comentarios (tipo_contenido, contenido_id, usuarios_id, texto) VALUES (?, ?, ?, ?)")
           ->execute([$tipo, $id, $u['id'], $texto]);

        jsonResponse(['success' => true, 'id' => $db->lastInsertId()]);
    }

    public function deleteComment() {
        if (!isLoggedIn()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $id = $_GET['id'] ?? null;
        if (!$id) {
            jsonResponse(['error' => 'ID de comentario requerido'], 400);
        }

        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM interacciones_comentarios WHERE interacciones_comentarios_id = ?");
        $stmt->execute([$id]);
        $comment = $stmt->fetch();
        if (!$comment) {
            jsonResponse(['error' => 'Comentario no encontrado'], 404);
        }

        $u = currentUser();
        if ((int) $comment['usuarios_id'] !== (int) $u['id'] && !$this->isSchoolAdmin()) {
            jsonResponse(['error' => 'No autorizado'], 403);
        }

        $db->prepare("DELETE FROM interacciones_comentarios WHERE interacciones_comentarios_id = ?")->execute([$id]);
        jsonResponse(['success' => true]);
    }
}
