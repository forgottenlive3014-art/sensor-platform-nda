<?php
require_once __DIR__ . '/../models/RecursoModel.php';

class RecursoController {

    // Solo el Admin General administra los recursos PDF.
    private function isAdminGeneral() {
        $u = currentUser();
        return $u && $u['role'] === 'admin';
    }

    // Guarda un PDF en assets/media/uploads/recursos/. Devuelve la ruta
    // relativa y el tamaño en bytes, o false si el archivo no es válido.
    private function storeUploadedPdf($file) {
        $mime = mime_content_type($file['tmp_name']);
        if ($mime !== 'application/pdf') return false;
        if ($file['size'] > 25 * 1024 * 1024) return false;

        $dir = __DIR__ . '/../assets/media/uploads/recursos';
        if (!is_dir($dir)) mkdir($dir, 0755, true);

        $name = uniqid('recurso_', true) . '.pdf';
        move_uploaded_file($file['tmp_name'], $dir . '/' . $name);

        $rel = 'assets/media/uploads/recursos/' . $name;
        return ['archivo' => $rel, 'tamano_bytes' => filesize($dir . '/' . $name)];
    }

    // Solo borra el archivo físico si vive dentro de la carpeta de subidas
    // del admin — nunca toca las guías originales de assets/media/guias/.
    private function deleteFileIfUploaded($rutaRelativa) {
        if (!$rutaRelativa || strpos($rutaRelativa, 'assets/media/uploads/recursos/') !== 0) return;
        $abs = __DIR__ . '/../' . $rutaRelativa;
        if (is_file($abs)) unlink($abs);
    }

    public function list() {
        if (!isLoggedIn() || !$this->isAdminGeneral()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $model = new RecursoModel();
        $search = trim($_GET['q'] ?? '');
        $page = (int) ($_GET['page'] ?? 1);
        $perPage = (int) ($_GET['per_page'] ?? 10);

        $rows = $model->getPage($search, $page, $perPage);
        $total = $model->countAll($search);

        jsonResponse([
            'data' => $rows,
            'total' => $total,
            'page' => max(1, $page),
            'per_page' => $perPage,
            'total_pages' => $perPage > 0 ? (int) ceil($total / $perPage) : 1,
        ]);
    }

    public function create() {
        if (!isLoggedIn() || !$this->isAdminGeneral()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $titulo = trim($_POST['titulo'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $categoria = trim($_POST['categoria'] ?? '');
        $tags = trim($_POST['tags'] ?? '');
        $orden = (int) ($_POST['orden'] ?? 0);

        if (empty($titulo) || empty($categoria)) {
            jsonResponse(['error' => 'Título y categoría son obligatorios'], 400);
        }
        if (empty($_FILES['archivo']['name']) || $_FILES['archivo']['error'] !== UPLOAD_ERR_OK) {
            jsonResponse(['error' => 'El archivo PDF es obligatorio'], 400);
        }

        $file = $this->storeUploadedPdf($_FILES['archivo']);
        if ($file === false) {
            jsonResponse(['error' => 'El archivo debe ser un PDF de máximo 25MB'], 400);
        }

        $u = currentUser();
        $model = new RecursoModel();
        $id = $model->create([
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'categoria' => $categoria,
            'tags' => $tags,
            'archivo' => $file['archivo'],
            'tamano_bytes' => $file['tamano_bytes'],
            'orden' => $orden,
            'usuarios_id' => $u['id'],
        ]);

        jsonResponse(['success' => true, 'id' => $id]);
    }

    public function update() {
        if (!isLoggedIn() || !$this->isAdminGeneral()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $id = $_POST['id'] ?? null;
        if (!$id) {
            jsonResponse(['error' => 'ID de recurso requerido'], 400);
        }

        $model = new RecursoModel();
        $existing = $model->getById($id);
        if (!$existing) {
            jsonResponse(['error' => 'Recurso no encontrado'], 404);
        }

        $titulo = trim($_POST['titulo'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $categoria = trim($_POST['categoria'] ?? '');
        $tags = trim($_POST['tags'] ?? '');
        $orden = (int) ($_POST['orden'] ?? 0);

        if (empty($titulo) || empty($categoria)) {
            jsonResponse(['error' => 'Título y categoría son obligatorios'], 400);
        }

        $data = [
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'categoria' => $categoria,
            'tags' => $tags,
            'orden' => $orden,
        ];

        if (!empty($_FILES['archivo']['name']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
            $file = $this->storeUploadedPdf($_FILES['archivo']);
            if ($file === false) {
                jsonResponse(['error' => 'El archivo debe ser un PDF de máximo 25MB'], 400);
            }
            $data['archivo'] = $file['archivo'];
            $data['tamano_bytes'] = $file['tamano_bytes'];
            $this->deleteFileIfUploaded($existing['archivo']);
        }

        $model->update($id, $data);
        jsonResponse(['success' => true]);
    }

    public function delete() {
        if (!isLoggedIn() || !$this->isAdminGeneral()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $id = $_GET['id'] ?? null;
        if (!$id) {
            jsonResponse(['error' => 'ID de recurso requerido'], 400);
        }

        $model = new RecursoModel();
        $existing = $model->getById($id);
        if (!$existing) {
            jsonResponse(['error' => 'Recurso no encontrado'], 404);
        }
        $model->delete($id);
        $this->deleteFileIfUploaded($existing['archivo']);

        jsonResponse(['success' => true]);
    }
}
