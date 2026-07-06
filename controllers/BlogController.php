<?php
require_once __DIR__ . '/../models/BlogModel.php';

class BlogController {

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

    // Guarda una imagen subida en assets/media/uploads/blog/.
    private function storeUploadedImage($file) {
        $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
        $mime = mime_content_type($file['tmp_name']);
        if (!isset($allowed[$mime])) return false;
        if ($file['size'] > 5 * 1024 * 1024) return false;

        $dir = __DIR__ . '/../assets/media/uploads/blog';
        if (!is_dir($dir)) mkdir($dir, 0755, true);

        $name = uniqid('blog_', true) . '.' . $allowed[$mime];
        move_uploaded_file($file['tmp_name'], $dir . '/' . $name);

        return 'assets/media/uploads/blog/' . $name;
    }

    public function list() {
        if (!isLoggedIn() || !$this->canAccessSchool()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $u = currentUser();
        $instId = $u['institucion_id'] ?? null;
        if (!$instId) {
            jsonResponse(['data' => [], 'total' => 0, 'page' => 1, 'per_page' => 10, 'total_pages' => 0]);
        }

        $model = new BlogModel();
        $page = (int) ($_GET['page'] ?? 1);
        $perPage = (int) ($_GET['per_page'] ?? 10);

        $rows = $model->getPage($instId, $page, $perPage);
        $total = $model->countAll($instId);

        jsonResponse([
            'data' => $rows,
            'total' => $total,
            'page' => max(1, $page),
            'per_page' => $perPage,
            'total_pages' => $perPage > 0 ? (int) ceil($total / $perPage) : 1,
        ]);
    }

    // Docente, Alumno, Personal, Director y Admin pueden publicar
    // (cualquiera con acceso al modulo escolar de su institucion).
    public function create() {
        if (!isLoggedIn() || !$this->canAccessSchool()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $u = currentUser();
        $instId = $u['institucion_id'] ?? null;
        if (!$instId) {
            jsonResponse(['error' => 'No tienes una institución asociada'], 400);
        }

        $titulo = trim($_POST['titulo'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $ubicacion = trim($_POST['ubicacion'] ?? '');

        if (empty($titulo) || empty($descripcion)) {
            jsonResponse(['error' => 'Título y descripción son obligatorios'], 400);
        }

        $imagen = null;
        if (!empty($_FILES['imagen']['name']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $imagen = $this->storeUploadedImage($_FILES['imagen']);
            if ($imagen === false) {
                jsonResponse(['error' => 'La imagen no es válida (usa JPG, PNG o WEBP, máx. 5MB)'], 400);
            }
        }

        $model = new BlogModel();
        $id = $model->create([
            'instituciones_id' => $instId,
            'usuarios_id' => $u['id'],
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'ubicacion' => $ubicacion,
            'imagen' => $imagen,
        ]);

        jsonResponse(['success' => true, 'id' => $id, 'imagen' => $imagen]);
    }

    public function delete() {
        if (!isLoggedIn()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $id = $_GET['id'] ?? null;
        if (!$id) {
            jsonResponse(['error' => 'ID requerido'], 400);
        }

        $model = new BlogModel();
        $post = $model->getById($id);
        if (!$post) {
            jsonResponse(['error' => 'Publicación no encontrada'], 404);
        }
        $u = currentUser();
        if (!$this->isSchoolAdmin() && $post['usuarios_id'] != $u['id']) {
            jsonResponse(['error' => 'No autorizado para eliminar esta publicación'], 403);
        }

        $model->delete($id);
        jsonResponse(['success' => true]);
    }
}
