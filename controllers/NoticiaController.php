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

    public function list() {
        if (!isLoggedIn() || !$this->canAccessSchool()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $u = currentUser();
        $isGlobalAdmin = $u['role'] === 'admin';
        $instId = $u['institucion_id'] ?? null;

        $model = new NewsModel();
        $search = trim($_GET['q'] ?? '');
        $page = (int) ($_GET['page'] ?? 1);
        $perPage = (int) ($_GET['per_page'] ?? 10);

        $rows = $model->getPage($instId, $isGlobalAdmin, $search, $page, $perPage);
        $total = $model->countAll($instId, $isGlobalAdmin, $search);

        jsonResponse([
            'data' => $rows,
            'total' => $total,
            'page' => max(1, $page),
            'per_page' => $perPage,
            'total_pages' => $perPage > 0 ? (int) ceil($total / $perPage) : 1,
        ]);
    }

    public function create() {
        if (!isLoggedIn() || !$this->isSchoolAdmin()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $input = json_decode(file_get_contents('php://input'), true);
        $titulo = trim($input['titulo'] ?? '');
        $contenido = trim($input['contenido'] ?? '');

        if (empty($titulo) || empty($contenido)) {
            jsonResponse(['error' => 'Título y contenido son obligatorios'], 400);
        }

        $u = currentUser();
        // El director publica solo para su institucion; el Admin General
        // puede publicar un comunicado global (instituciones_id = null).
        $instId = $u['role'] === 'admin' ? null : ($u['institucion_id'] ?? null);
        if ($u['role'] !== 'admin' && !$instId) {
            jsonResponse(['error' => 'No tienes una institución asociada'], 400);
        }

        $model = new NewsModel();
        $id = $model->create([
            'instituciones_id' => $instId,
            'usuarios_id' => $u['id'],
            'titulo' => $titulo,
            'contenido' => $contenido,
        ]);

        jsonResponse(['success' => true, 'id' => $id]);
    }

    public function update() {
        if (!isLoggedIn() || !$this->isSchoolAdmin()) {
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
        $u = currentUser();
        if ($u['role'] !== 'admin' && $news['instituciones_id'] != $u['institucion_id']) {
            jsonResponse(['error' => 'No autorizado para editar esta noticia'], 403);
        }

        $model->update($id, ['titulo' => $titulo, 'contenido' => $contenido]);
        jsonResponse(['success' => true]);
    }

    public function delete() {
        if (!isLoggedIn() || !$this->isSchoolAdmin()) {
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
        $u = currentUser();
        if ($u['role'] !== 'admin' && $news['instituciones_id'] != $u['institucion_id']) {
            jsonResponse(['error' => 'No autorizado para eliminar esta noticia'], 403);
        }

        $model->delete($id);
        jsonResponse(['success' => true]);
    }
}
