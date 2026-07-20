<?php
require_once __DIR__ . '/../models/NewsModel.php';

class NoticiaController {

    private function isSchoolAdmin() {
        $u = currentUser();
        if (!$u) return false;
        return $u['role'] === 'admin' || $u['role'] === 'director';
    }

    private function canAccessSchool() {
        $u = currentUser();
        if (!$u) return false;
        if ($u['role'] === 'admin') return true;
        return in_array($u['role'], ['director', 'docente', 'alumno', 'padre', 'administrativo'], true)
            && $u['estado_institucional'] === 'aprobado';
    }

    // Docente publica directo; alumno de comité autorizado publica pero
    // queda pendiente de aprobación.
    private function canCreateNews($u) {
        if ($this->isSchoolAdmin()) return true;
        if ($u['role'] === 'docente') return true;
        if ($u['role'] === 'alumno' && !empty($u['comite_autorizado'])) return true;
        return false;
    }

    public function list() {
        if (!isLoggedIn() || !$this->canAccessSchool()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $u = currentUser();
        $isGlobalAdmin = $u['role'] === 'admin';
        $instId = $u['institucion_id'] ?? null;
        // Quien no modera (no es admin/director) solo ve noticias publicadas.
        $onlyPublished = !$this->isSchoolAdmin();

        $model = new NewsModel();
        $search = trim($_GET['q'] ?? '');
        $page = (int) ($_GET['page'] ?? 1);
        $perPage = (int) ($_GET['per_page'] ?? 10);

        $rows = $model->getPage($instId, $isGlobalAdmin, $search, $page, $perPage, $onlyPublished);
        $total = $model->countAll($instId, $isGlobalAdmin, $search, $onlyPublished);

        jsonResponse([
            'data' => $rows,
            'total' => $total,
            'page' => max(1, $page),
            'per_page' => $perPage,
            'total_pages' => $perPage > 0 ? (int) ceil($total / $perPage) : 1,
        ]);
    }

    public function create() {
        $u = currentUser();
        if (!isLoggedIn() || !$u || !$this->canCreateNews($u)) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $input = json_decode(file_get_contents('php://input'), true);
        $titulo = trim($input['titulo'] ?? '');
        $contenido = trim($input['contenido'] ?? '');

        if (empty($titulo) || empty($contenido)) {
            jsonResponse(['error' => 'Título y contenido son obligatorios'], 400);
        }

        // El director/docente publica solo para su institucion; el Admin
        // General puede publicar un comunicado global (instituciones_id = null).
        $instId = $u['role'] === 'admin' ? null : ($u['institucion_id'] ?? null);
        if ($u['role'] !== 'admin' && !$instId) {
            jsonResponse(['error' => 'No tienes una institución asociada'], 400);
        }

        // Admin/director publican directo; docente igual (ya es staff de
        // confianza); un alumno de comité queda pendiente de revisión.
        $estado = ($this->isSchoolAdmin() || $u['role'] === 'docente') ? 'publicada' : 'pendiente';

        $model = new NewsModel();
        $id = $model->create([
            'instituciones_id' => $instId,
            'usuarios_id' => $u['id'],
            'titulo' => $titulo,
            'contenido' => $contenido,
            'estado' => $estado,
        ]);

        jsonResponse(['success' => true, 'id' => $id, 'estado' => $estado]);
    }

    public function update() {
        $u = currentUser();
        if (!isLoggedIn() || !$u) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['id'] ?? null;
        $titulo = trim($input['titulo'] ?? '');
        $contenido = trim($input['contenido'] ?? '');

        if (!$id) {
            jsonResponse(['error' => 'ID de noticia requerido'], 400);
        }
        if (empty($titulo) || empty($contenido)) {
            jsonResponse(['error' => 'Título y contenido son obligatorios'], 400);
        }

        $model = new NewsModel();
        $news = $model->getById($id);
        if (!$news) {
            jsonResponse(['error' => 'Noticia no encontrada'], 404);
        }
        // Admin/director moderan cualquier noticia de su institucion; el
        // propio autor (docente o alumno de comité) solo puede editar la suya.
        $isOwner = (int) $news['usuarios_id'] === (int) $u['id'];
        $canModerate = $this->isSchoolAdmin() && ($u['role'] === 'admin' || $news['instituciones_id'] == $u['institucion_id']);
        if (!$canModerate && !$isOwner) {
            jsonResponse(['error' => 'No autorizado para editar esta noticia'], 403);
        }

        $model->update($id, ['titulo' => $titulo, 'contenido' => $contenido]);
        jsonResponse(['success' => true]);
    }

    public function delete() {
        $u = currentUser();
        if (!isLoggedIn() || !$u) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $id = $_GET['id'] ?? null;
        if (!$id) {
            jsonResponse(['error' => 'ID de noticia requerido'], 400);
        }

        $model = new NewsModel();
        $news = $model->getById($id);
        if (!$news) {
            jsonResponse(['error' => 'Noticia no encontrada'], 404);
        }
        $isOwner = (int) $news['usuarios_id'] === (int) $u['id'];
        $canModerate = $this->isSchoolAdmin() && ($u['role'] === 'admin' || $news['instituciones_id'] == $u['institucion_id']);
        if (!$canModerate && !$isOwner) {
            jsonResponse(['error' => 'No autorizado para eliminar esta noticia'], 403);
        }

        $model->delete($id);
        jsonResponse(['success' => true]);
    }

    // Aprobar/rechazar una noticia pendiente (solo admin/director).
    public function approve() {
        $this->setEstado('publicada');
    }

    public function reject() {
        $this->setEstado('rechazada');
    }

    private function setEstado($estado) {
        if (!isLoggedIn() || !$this->isSchoolAdmin()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['id'] ?? null;
        if (!$id) {
            jsonResponse(['error' => 'ID de noticia requerido'], 400);
        }

        $model = new NewsModel();
        $news = $model->getById($id);
        if (!$news) {
            jsonResponse(['error' => 'Noticia no encontrada'], 404);
        }
        $u = currentUser();
        if ($u['role'] !== 'admin' && $news['instituciones_id'] != $u['institucion_id']) {
            jsonResponse(['error' => 'No autorizado'], 403);
        }

        $model->setEstado($id, $estado, $u['id']);
        jsonResponse(['success' => true]);
    }
}
