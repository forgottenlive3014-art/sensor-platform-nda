<?php
require_once __DIR__ . '/../models/ArticuloModel.php';

class ArticuloController {

    // Solo el Admin General administra el blog público.
    private function isAdminGeneral() {
        $u = currentUser();
        return $u && $u['role'] === 'admin';
    }

    private function slugify($text) {
        $text = trim($text);
        if (function_exists('transliterator_transliterate')) {
            $text = transliterator_transliterate('Any-Latin; Latin-ASCII;', $text);
        } else {
            $text = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text);
        }
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        return trim($text, '-');
    }

    private function uniqueSlug($base, $excludeId = null) {
        $model = new ArticuloModel();
        $slug = $base !== '' ? $base : 'articulo';
        $i = 2;
        while ($model->slugExists($slug, $excludeId)) {
            $slug = $base . '-' . $i;
            $i++;
        }
        return $slug;
    }

    // El color se inserta tal cual en un atributo style (blog.php) — sin
    // esto, un admin comprometido podria salirse del atributo (') o inyectar
    // reglas CSS. Solo se acepta un codigo hex valido; cualquier otra cosa
    // cae al color por defecto.
    private function sanitizeColor($color) {
        return preg_match('/^#[0-9a-fA-F]{3,8}$/', $color) ? $color : '#f29f05';
    }

    // El cuerpo del articulo se guarda como HTML (el editor permite negritas,
    // links, imagenes, etc.), asi que no se puede escapar por completo sin
    // romper el formato. En su lugar se limpia con una lista blanca de tags
    // y atributos: cualquier <script>, atributo onerror/onclick, o tag fuera
    // de la lista se elimina (desenvolviendo su texto/hijos en vez de
    // borrarlos, para no perder contenido legitimo mal etiquetado).
    private function sanitizeArticleHtml($html) {
        $html = trim($html);
        if ($html === '') return '';

        $allowedTags = ['p','br','b','strong','i','em','u','a','ul','ol','li','h2','h3','h4','blockquote','img','span'];
        $allowedAttrs = ['a' => ['href', 'title', 'target', 'rel'], 'img' => ['src', 'alt', 'title']];

        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML('<?xml encoding="utf-8"?><html><body>' . $html . '</body></html>', LIBXML_NOERROR | LIBXML_NOWARNING);
        libxml_clear_errors();

        $body = $doc->getElementsByTagName('body')->item(0);
        if (!$body) return '';
        $this->sanitizeNode($body, $allowedTags, $allowedAttrs);

        $out = '';
        foreach ($body->childNodes as $child) {
            $out .= $doc->saveHTML($child);
        }
        return $out;
    }

    private function sanitizeNode($node, $allowedTags, $allowedAttrs) {
        foreach (iterator_to_array($node->childNodes) as $child) {
            if ($child->nodeType === XML_COMMENT_NODE) {
                $node->removeChild($child);
                continue;
            }
            if ($child->nodeType !== XML_ELEMENT_NODE) {
                continue; // nodo de texto: se deja tal cual
            }

            $tag = strtolower($child->nodeName);
            if (!in_array($tag, $allowedTags, true)) {
                // Tag no permitido (incluye <script>, <iframe>, <svg>...): se
                // descarta el tag pero se conserva su contenido interno.
                while ($child->firstChild) {
                    $node->insertBefore($child->firstChild, $child);
                }
                $node->removeChild($child);
                continue;
            }

            $allowed = $allowedAttrs[$tag] ?? [];
            foreach (iterator_to_array($child->attributes) as $attr) {
                $name = strtolower($attr->nodeName);
                $value = trim($attr->nodeValue);
                $isUrlAttr = in_array($name, ['href', 'src'], true);
                if (!in_array($name, $allowed, true) || ($isUrlAttr && stripos($value, 'javascript:') === 0)) {
                    $child->removeAttribute($attr->nodeName);
                }
            }

            $this->sanitizeNode($child, $allowedTags, $allowedAttrs);
        }
    }

    // Guarda una imagen de portada en assets/media/uploads/articulos/.
    private function storeUploadedImage($file) {
        $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
        $mime = mime_content_type($file['tmp_name']);
        if (!isset($allowed[$mime])) return false;
        if ($file['size'] > 5 * 1024 * 1024) return false;

        $dir = __DIR__ . '/../assets/media/uploads/articulos';
        if (!is_dir($dir)) mkdir($dir, 0755, true);

        $name = uniqid('articulo_', true) . '.' . $allowed[$mime];
        move_uploaded_file($file['tmp_name'], $dir . '/' . $name);

        return 'assets/media/uploads/articulos/' . $name;
    }

    public function list() {
        if (!isLoggedIn() || !$this->isAdminGeneral()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $model = new ArticuloModel();
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
        $cat = trim($_POST['cat'] ?? 'prevencion');
        $tag = trim($_POST['tag'] ?? '');
        $color = trim($_POST['color'] ?? '#f29f05');
        $autorNombre = trim($_POST['autor_nombre'] ?? 'Equipo NDA');
        $tiempo = trim($_POST['tiempo'] ?? '5 min');
        $destacado = !empty($_POST['destacado']);
        $extracto = trim($_POST['extracto'] ?? '');
        $cuerpo = trim($_POST['cuerpo'] ?? '');

        if (empty($titulo) || empty($extracto) || empty($cuerpo)) {
            jsonResponse(['error' => 'Título, extracto y contenido son obligatorios'], 400);
        }

        $imagen = null;
        if (!empty($_FILES['imagen']['name']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $imagen = $this->storeUploadedImage($_FILES['imagen']);
            if ($imagen === false) {
                jsonResponse(['error' => 'La imagen no es válida (usa JPG, PNG o WEBP, máx. 5MB)'], 400);
            }
        }

        $slugInput = trim($_POST['slug'] ?? '');
        $slug = $this->uniqueSlug($this->slugify($slugInput !== '' ? $slugInput : $titulo));

        $u = currentUser();
        $model = new ArticuloModel();
        $id = $model->create([
            'slug' => $slug,
            'titulo' => $titulo,
            'cat' => $cat,
            'tag' => $tag,
            'color' => $this->sanitizeColor($color),
            'autor_id' => $u['id'],
            'autor_nombre' => $autorNombre,
            'tiempo' => $tiempo,
            'destacado' => $destacado,
            'extracto' => $extracto,
            'imagen' => $imagen,
            'cuerpo' => $this->sanitizeArticleHtml($cuerpo),
        ]);

        jsonResponse(['success' => true, 'id' => $id, 'slug' => $slug]);
    }

    public function update() {
        if (!isLoggedIn() || !$this->isAdminGeneral()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $id = $_POST['id'] ?? null;
        if (!$id) {
            jsonResponse(['error' => 'ID de artículo requerido'], 400);
        }

        $model = new ArticuloModel();
        $existing = $model->getById($id);
        if (!$existing) {
            jsonResponse(['error' => 'Artículo no encontrado'], 404);
        }

        $titulo = trim($_POST['titulo'] ?? '');
        $cat = trim($_POST['cat'] ?? 'prevencion');
        $tag = trim($_POST['tag'] ?? '');
        $color = trim($_POST['color'] ?? '#f29f05');
        $autorNombre = trim($_POST['autor_nombre'] ?? 'Equipo NDA');
        $tiempo = trim($_POST['tiempo'] ?? '5 min');
        $destacado = !empty($_POST['destacado']);
        $extracto = trim($_POST['extracto'] ?? '');
        $cuerpo = trim($_POST['cuerpo'] ?? '');

        if (empty($titulo) || empty($extracto) || empty($cuerpo)) {
            jsonResponse(['error' => 'Título, extracto y contenido son obligatorios'], 400);
        }

        $slugInput = trim($_POST['slug'] ?? '');
        $baseSlug = $this->slugify($slugInput !== '' ? $slugInput : $titulo);
        $slug = $baseSlug === $existing['slug'] ? $baseSlug : $this->uniqueSlug($baseSlug, $id);

        $imagen = null;
        if (!empty($_FILES['imagen']['name']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $imagen = $this->storeUploadedImage($_FILES['imagen']);
            if ($imagen === false) {
                jsonResponse(['error' => 'La imagen no es válida (usa JPG, PNG o WEBP, máx. 5MB)'], 400);
            }
        }

        $model->update($id, [
            'slug' => $slug,
            'titulo' => $titulo,
            'cat' => $cat,
            'tag' => $tag,
            'color' => $this->sanitizeColor($color),
            'autor_nombre' => $autorNombre,
            'tiempo' => $tiempo,
            'destacado' => $destacado,
            'extracto' => $extracto,
            'imagen' => $imagen,
            'cuerpo' => $this->sanitizeArticleHtml($cuerpo),
        ]);

        jsonResponse(['success' => true]);
    }

    public function delete() {
        if (!isLoggedIn() || !$this->isAdminGeneral()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $id = $_GET['id'] ?? null;
        if (!$id) {
            jsonResponse(['error' => 'ID de artículo requerido'], 400);
        }

        $model = new ArticuloModel();
        if (!$model->getById($id)) {
            jsonResponse(['error' => 'Artículo no encontrado'], 404);
        }
        $model->delete($id);

        jsonResponse(['success' => true]);
    }
}
