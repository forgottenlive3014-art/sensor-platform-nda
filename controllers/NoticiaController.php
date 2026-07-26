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

    // Solo para LECTURA (ver EstudianteController::readScopeInstitutionId()
    // para la explicacion completa). Nunca se usa en escritura.
    private function readScopeInstitutionId() {
        $u = currentUser();
        if ($u['role'] === 'admin' && !empty($_SESSION['admin_view_institucion_id'])) {
            return (int) $_SESSION['admin_view_institucion_id'];
        }
        return $u['institucion_id'] ?? null;
    }

    public function list() {
        if (!isLoggedIn() || !$this->canAccessSchool()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $u = currentUser();
        $instId = $this->readScopeInstitutionId();
        $isGlobalAdmin = $u['role'] === 'admin' && $instId === null;

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

    // Guarda una imagen subida en assets/media/uploads/noticias/. Mismo
    // patron que BlogController::storeUploadedImage() / SchoolController.
    private function storeUploadedImage($file) {
        $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
        $mime = mime_content_type($file['tmp_name']);
        if (!isset($allowed[$mime])) return false;
        if ($file['size'] > 5 * 1024 * 1024) return false;

        $dir = __DIR__ . '/../assets/media/uploads/noticias';
        if (!is_dir($dir)) mkdir($dir, 0755, true);

        $name = uniqid('noticia_', true) . '.' . $allowed[$mime];
        move_uploaded_file($file['tmp_name'], $dir . '/' . $name);

        return 'assets/media/uploads/noticias/' . $name;
    }

    // Resumen corto para la tarjeta: si no lo escriben a mano, se deriva
    // del contenido para no dejar tarjetas vacias en noticias viejas o
    // publicadas sin ese campo.
    private function autoResumen($resumen, $contenido) {
        $resumen = trim($resumen);
        if ($resumen !== '') return $resumen;
        $plain = trim(preg_replace('/\s+/', ' ', strip_tags($contenido)));
        return mb_strlen($plain) > 160 ? mb_substr($plain, 0, 157) . '...' : $plain;
    }

    public function create() {
        if (!isLoggedIn() || !$this->isSchoolAdmin()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $titulo = trim($_POST['titulo'] ?? '');
        $contenido = trim($_POST['contenido'] ?? '');
        $resumen = $this->autoResumen($_POST['resumen'] ?? '', $contenido);

        if (empty($titulo) || empty($contenido)) {
            jsonResponse(['error' => 'Título y contenido son obligatorios'], 400);
        }

        $imagen = null;
        if (!empty($_FILES['imagen']['name']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $imagen = $this->storeUploadedImage($_FILES['imagen']);
            if ($imagen === false) {
                jsonResponse(['error' => 'La imagen no es válida (usa JPG, PNG o WEBP, máx. 5MB)'], 400);
            }
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
            'resumen' => $resumen,
            'contenido' => $contenido,
            'imagen' => $imagen,
        ]);

        jsonResponse(['success' => true, 'id' => $id, 'imagen' => $imagen]);
    }

    public function update() {
        if (!isLoggedIn() || !$this->isSchoolAdmin()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $id = $_POST['id'] ?? null;
        $titulo = trim($_POST['titulo'] ?? '');
        $contenido = trim($_POST['contenido'] ?? '');
        $resumen = $this->autoResumen($_POST['resumen'] ?? '', $contenido);

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

        $imagen = $news['imagen'];
        if (!empty($_FILES['imagen']['name']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $uploaded = $this->storeUploadedImage($_FILES['imagen']);
            if ($uploaded === false) {
                jsonResponse(['error' => 'La imagen no es válida (usa JPG, PNG o WEBP, máx. 5MB)'], 400);
            }
            $imagen = $uploaded;
        }

        $model->update($id, ['titulo' => $titulo, 'resumen' => $resumen, 'contenido' => $contenido, 'imagen' => $imagen]);
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
