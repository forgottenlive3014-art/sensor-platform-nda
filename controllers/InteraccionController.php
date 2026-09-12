<?php
// "Me gusta" y comentarios, compartidos entre Noticias, Lugares en riesgo e
// Incidentes (tipo_contenido genérico) — ver sql/nda_project.sql.
class InteraccionController {

    // tipo_contenido => [tabla, columna PK, columna institucion]
    private $tablas = [
        'noticia'   => ['tabla' => 'noticias_internas', 'pk' => 'noticias_internas_id', 'inst' => 'instituciones_id'],
        'riesgo'    => ['tabla' => 'blog_riesgos',       'pk' => 'blog_riesgos_id',       'inst' => 'instituciones_id'],
        'incidente' => ['tabla' => 'incidentes',         'pk' => 'incidentes_id',         'inst' => 'instituciones_id'],
        // Blog publico: no pertenece a ninguna institucion, lo puede comentar
        // cualquier usuario registrado (ver canAccessTipo()).
        'articulo'  => ['tabla' => 'blog',               'pk' => 'blog_id',               'inst' => null],
        'nota'      => ['tabla' => 'corcho_notas',        'pk' => 'corcho_notas_id',        'inst' => 'instituciones_id'],
    ];

    private function canAccessSchool() {
        $u = currentUser();
        if (!$u) return false;
        if ($u['role'] === 'admin') return true;
        return in_array($u['role'], ['director', 'docente', 'alumno', 'padre', 'administrativo'], true)
            && $u['estado_institucional'] === 'aprobado';
    }

    // Los articulos del blog publico son de acceso general: basta con tener
    // cuenta, sin necesidad de pertenecer a una institucion aprobada.
    private function canAccessTipo($tipo) {
        if ($tipo === 'articulo') return isLoggedIn();
        return $this->canAccessSchool();
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
        $input = json_decode(file_get_contents('php://input'), true);
        $tipo = $input['tipo'] ?? '';
        if (!isLoggedIn() || !$this->canAccessTipo($tipo)) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
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
        $tipo = $_GET['tipo'] ?? '';
        if (!isset($this->tablas[$tipo])) {
            jsonResponse(['error' => 'Tipo de contenido inválido'], 400);
        }
        // El conteo es publico (como un contador de "me gusta" cualquiera);
        // solo hace falta sesion para saber si YO ya di like — y para tipos
        // de contenido escolar, ni siquiera se expone el conteo a quien no
        // tiene acceso a esa institucion.
        if ($tipo !== 'articulo' && (!isLoggedIn() || !$this->canAccessTipo($tipo))) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $id = $_GET['id'] ?? null;
        $this->resolveContenido($tipo, $id);

        $db = getDB();

        $stmtL = $db->prepare("SELECT COUNT(*) as total FROM interacciones_likes WHERE tipo_contenido = ? AND contenido_id = ?");
        $stmtL->execute([$tipo, $id]);
        $totalLikes = (int) ($stmtL->fetch()['total'] ?? 0);

        $likedByMe = false;
        if (isLoggedIn() && $this->canAccessTipo($tipo)) {
            $u = currentUser();
            $stmtMe = $db->prepare("SELECT 1 FROM interacciones_likes WHERE tipo_contenido = ? AND contenido_id = ? AND usuarios_id = ?");
            $stmtMe->execute([$tipo, $id, $u['id']]);
            $likedByMe = (bool) $stmtMe->fetch();
        }

        $stmtC = $db->prepare("SELECT COUNT(*) as total FROM interacciones_comentarios WHERE tipo_contenido = ? AND contenido_id = ?");
        $stmtC->execute([$tipo, $id]);
        $totalComments = (int) ($stmtC->fetch()['total'] ?? 0);

        jsonResponse(['total_likes' => $totalLikes, 'liked_by_me' => $likedByMe, 'total_comments' => $totalComments]);
    }

    public function listComments() {
        $tipo = $_GET['tipo'] ?? '';
        if (!isLoggedIn() || !$this->canAccessTipo($tipo)) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $id = $_GET['id'] ?? null;
        $this->resolveContenido($tipo, $id);

        $db = getDB();
        $stmt = $db->prepare("
            SELECT c.*, u.nombre as autor, u.role as autor_role, u.foto_perfil as autor_foto
            FROM interacciones_comentarios c
            JOIN usuarios u ON u.usuarios_id = c.usuarios_id
            WHERE c.tipo_contenido = ? AND c.contenido_id = ?
            ORDER BY c.created_at ASC
        ");
        $stmt->execute([$tipo, $id]);
        jsonResponse($stmt->fetchAll());
    }

    public function addComment() {
        $input = json_decode(file_get_contents('php://input'), true);
        $tipo = $input['tipo'] ?? '';
        if (!isLoggedIn() || !$this->canAccessTipo($tipo)) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
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

    // ===== GUARDADOS / FAVORITOS (por ahora solo articulos del blog) =====

    public function toggleSave() {
        $input = json_decode(file_get_contents('php://input'), true);
        $tipo = $input['tipo'] ?? '';
        if (!isLoggedIn() || !$this->canAccessTipo($tipo)) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $id = $input['id'] ?? null;
        $this->resolveContenido($tipo, $id);

        $u = currentUser();
        $db = getDB();
        $stmt = $db->prepare("SELECT interacciones_guardados_id FROM interacciones_guardados WHERE tipo_contenido = ? AND contenido_id = ? AND usuarios_id = ?");
        $stmt->execute([$tipo, $id, $u['id']]);
        $existing = $stmt->fetch();

        if ($existing) {
            $db->prepare("DELETE FROM interacciones_guardados WHERE interacciones_guardados_id = ?")->execute([$existing['interacciones_guardados_id']]);
            $saved = false;
        } else {
            $db->prepare("INSERT INTO interacciones_guardados (tipo_contenido, contenido_id, usuarios_id) VALUES (?, ?, ?)")
               ->execute([$tipo, $id, $u['id']]);
            $saved = true;
        }

        jsonResponse(['success' => true, 'saved' => $saved]);
    }

    public function saveStatus() {
        $tipo = $_GET['tipo'] ?? '';
        if (!isLoggedIn() || !$this->canAccessTipo($tipo)) {
            jsonResponse(['saved' => false]);
        }
        $id = $_GET['id'] ?? null;
        $this->resolveContenido($tipo, $id);

        $u = currentUser();
        $db = getDB();
        $stmt = $db->prepare("SELECT 1 FROM interacciones_guardados WHERE tipo_contenido = ? AND contenido_id = ? AND usuarios_id = ?");
        $stmt->execute([$tipo, $id, $u['id']]);
        jsonResponse(['saved' => (bool) $stmt->fetch()]);
    }

    // Articulos guardados por el usuario actual, para la pagina de perfil.
    public function misGuardados() {
        if (!isLoggedIn()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $u = currentUser();
        $db = getDB();
        $stmt = $db->prepare("
            SELECT b.slug, b.titulo, b.imagen, b.color, g.created_at
            FROM interacciones_guardados g
            JOIN blog b ON b.blog_id = g.contenido_id
            WHERE g.tipo_contenido = 'articulo' AND g.usuarios_id = ?
            ORDER BY g.created_at DESC
        ");
        $stmt->execute([$u['id']]);
        jsonResponse($stmt->fetchAll());
    }

    // Comentarios recientes del usuario actual en articulos del blog, para
    // la seccion "Mi actividad" del perfil.
    public function misComentarios() {
        if (!isLoggedIn()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $u = currentUser();
        $db = getDB();
        $stmt = $db->prepare("
            SELECT c.texto, c.created_at, b.slug, b.titulo
            FROM interacciones_comentarios c
            JOIN blog b ON b.blog_id = c.contenido_id
            WHERE c.tipo_contenido = 'articulo' AND c.usuarios_id = ?
            ORDER BY c.created_at DESC
            LIMIT 10
        ");
        $stmt->execute([$u['id']]);
        jsonResponse($stmt->fetchAll());
    }

    // ===== REACCIONES DE SENTIMIENTO (5 opciones excluyentes entre sí) =====

    private $emojisValidos = ['😢', '😮', '🙏', '💪', '❤️'];

    public function toggleReaction() {
        $input = json_decode(file_get_contents('php://input'), true);
        $tipo = $input['tipo'] ?? '';
        if (!isLoggedIn() || !$this->canAccessTipo($tipo)) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $id = $input['id'] ?? null;
        $emoji = $input['emoji'] ?? '';
        if (!in_array($emoji, $this->emojisValidos, true)) {
            jsonResponse(['error' => 'Reacción inválida'], 400);
        }
        $this->resolveContenido($tipo, $id);

        $u = currentUser();
        $db = getDB();
        $stmt = $db->prepare("SELECT interacciones_reacciones_id, emoji FROM interacciones_reacciones WHERE tipo_contenido = ? AND contenido_id = ? AND usuarios_id = ?");
        $stmt->execute([$tipo, $id, $u['id']]);
        $existing = $stmt->fetch();

        if ($existing && $existing['emoji'] === $emoji) {
            // Repetir la misma reacción la quita.
            $db->prepare("DELETE FROM interacciones_reacciones WHERE interacciones_reacciones_id = ?")->execute([$existing['interacciones_reacciones_id']]);
            $myReaction = null;
        } elseif ($existing) {
            $db->prepare("UPDATE interacciones_reacciones SET emoji = ? WHERE interacciones_reacciones_id = ?")->execute([$emoji, $existing['interacciones_reacciones_id']]);
            $myReaction = $emoji;
        } else {
            $db->prepare("INSERT INTO interacciones_reacciones (tipo_contenido, contenido_id, usuarios_id, emoji) VALUES (?, ?, ?, ?)")
               ->execute([$tipo, $id, $u['id'], $emoji]);
            $myReaction = $emoji;
        }

        jsonResponse(['success' => true, 'my_reaction' => $myReaction, 'counts' => $this->reactionCounts($tipo, $id)]);
    }

    public function reactionStatus() {
        $tipo = $_GET['tipo'] ?? '';
        $id = $_GET['id'] ?? null;
        if (!isset($this->tablas[$tipo]) || !$id) {
            jsonResponse(['error' => 'Solicitud inválida'], 400);
        }

        $myReaction = null;
        if (isLoggedIn() && $this->canAccessTipo($tipo)) {
            $u = currentUser();
            $db = getDB();
            $stmt = $db->prepare("SELECT emoji FROM interacciones_reacciones WHERE tipo_contenido = ? AND contenido_id = ? AND usuarios_id = ?");
            $stmt->execute([$tipo, $id, $u['id']]);
            $row = $stmt->fetch();
            $myReaction = $row ? $row['emoji'] : null;
        }

        jsonResponse(['my_reaction' => $myReaction, 'counts' => $this->reactionCounts($tipo, $id)]);
    }

    private function reactionCounts($tipo, $id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT emoji, COUNT(*) as total FROM interacciones_reacciones WHERE tipo_contenido = ? AND contenido_id = ? GROUP BY emoji");
        $stmt->execute([$tipo, $id]);
        $counts = array_fill_keys($this->emojisValidos, 0);
        foreach ($stmt->fetchAll() as $row) {
            $counts[$row['emoji']] = (int) $row['total'];
        }
        return $counts;
    }

    // Reacciones del usuario actual en articulos del blog, para el perfil.
    public function misReacciones() {
        if (!isLoggedIn()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $u = currentUser();
        $db = getDB();
        $stmt = $db->prepare("
            SELECT r.emoji, r.created_at, b.slug, b.titulo
            FROM interacciones_reacciones r
            JOIN blog b ON b.blog_id = r.contenido_id
            WHERE r.tipo_contenido = 'articulo' AND r.usuarios_id = ?
            ORDER BY r.created_at DESC
        ");
        $stmt->execute([$u['id']]);
        jsonResponse($stmt->fetchAll());
    }

    // "Me gusta" del usuario actual en todo lo que puede tener like: blog
    // publico, blog de la institucion (si pertenece a una), noticias,
    // incidentes y notas del tablero. Cada tipo vive en su propia tabla asi
    // que se arman por separado y se combinan ordenados por fecha.
    public function misLikes() {
        if (!isLoggedIn()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $u = currentUser();
        $db = getDB();
        $out = [];

        $stmtA = $db->prepare("
            SELECT 'articulo' as tipo, b.titulo, CONCAT('?url=blog&post=', b.slug) as link, b.imagen, b.color, l.created_at
            FROM interacciones_likes l JOIN blog b ON b.blog_id = l.contenido_id
            WHERE l.tipo_contenido = 'articulo' AND l.usuarios_id = ?
        ");
        $stmtA->execute([$u['id']]);
        $out = array_merge($out, $stmtA->fetchAll());

        // El resto son de contenido institucional: solo tiene sentido buscarlos
        // si el usuario pertenece (o perteneció) a una institución. No tienen
        // columna de color propia (solo el blog publico la tiene) asi que se
        // les asigna un acento fijo por tipo, para pintar la miniatura cuando
        // no tienen imagen.
        if ($u['institucion_id']) {
            $stmtR = $db->prepare("
                SELECT 'riesgo' as tipo, r.titulo, CONCAT('?url=school/riesgo-detail&id=', r.blog_riesgos_id) as link, r.imagen, '#a85736' as color, l.created_at
                FROM interacciones_likes l JOIN blog_riesgos r ON r.blog_riesgos_id = l.contenido_id
                WHERE l.tipo_contenido = 'riesgo' AND l.usuarios_id = ?
            ");
            $stmtR->execute([$u['id']]);
            $out = array_merge($out, $stmtR->fetchAll());

            $stmtN = $db->prepare("
                SELECT 'noticia' as tipo, n.titulo, CONCAT('?url=school/news-detail&id=', n.noticias_internas_id) as link, n.imagen, '#3d6f8f' as color, l.created_at
                FROM interacciones_likes l JOIN noticias_internas n ON n.noticias_internas_id = l.contenido_id
                WHERE l.tipo_contenido = 'noticia' AND l.usuarios_id = ?
            ");
            $stmtN->execute([$u['id']]);
            $out = array_merge($out, $stmtN->fetchAll());

            $stmtI = $db->prepare("
                SELECT 'incidente' as tipo, i.tipo as titulo, CONCAT('?url=school/incident-detail&id=', i.incidentes_id) as link, i.imagen, '#b8433f' as color, l.created_at
                FROM interacciones_likes l JOIN incidentes i ON i.incidentes_id = l.contenido_id
                WHERE l.tipo_contenido = 'incidente' AND l.usuarios_id = ?
            ");
            $stmtI->execute([$u['id']]);
            $out = array_merge($out, $stmtI->fetchAll());

            $stmtC = $db->prepare("
                SELECT 'nota' as tipo, LEFT(c.texto, 60) as titulo, '?url=school/panel#board' as link, NULL as imagen, c.color as color, l.created_at
                FROM interacciones_likes l JOIN corcho_notas c ON c.corcho_notas_id = l.contenido_id
                WHERE l.tipo_contenido = 'nota' AND l.usuarios_id = ?
            ");
            $stmtC->execute([$u['id']]);
            $out = array_merge($out, $stmtC->fetchAll());
        }

        // Las notas del tablero guardan su color como nombre ('amarillo',
        // 'naranja'...) en vez de un hex, para pintar la miniatura igual que
        // el resto hay que traducirlo.
        $notaColores = ['amarillo' => '#f2c94c', 'naranja' => '#e86a2a', 'verde' => '#6ba15a', 'azul' => '#3d6f8f', 'rosa' => '#c9a6c9'];
        foreach ($out as &$item) {
            if ($item['tipo'] === 'nota' && isset($notaColores[$item['color']])) {
                $item['color'] = $notaColores[$item['color']];
            }
        }
        unset($item);

        usort($out, fn($a, $b) => strcmp($b['created_at'], $a['created_at']));
        jsonResponse(array_slice($out, 0, 30));
    }
}
