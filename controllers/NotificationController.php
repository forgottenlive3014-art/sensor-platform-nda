<?php
require_once __DIR__ . '/../models/NotificationModel.php';

class NotificationController {

    // Publico: incluso un visitante sin sesion puede recibir
    // notificaciones globales (ej. alerta sismica/sensor relevante
    // para todo el sitio), aunque no vea las de su institucion.
    public function latest() {
        $model = new NotificationModel();
        $u = currentUser();
        $userId = $u['id'] ?? 0;
        $institucionId = ($u && $u['estado_institucional'] === 'aprobado') ? $u['institucion_id'] : 0;

        $sinceId = $_GET['since_id'] ?? 0;

        jsonResponse([
            'notifications' => $model->latestFor($userId, $institucionId, $sinceId),
            'last_id' => $model->maxId(),
            'unread_count' => $model->countUnreadFor($userId, $institucionId),
        ]);
    }

    // Bandeja de entrada: historial completo (leidas y no leidas) del
    // usuario actual, paginado — usada por el boton "Ver historial" de
    // la campana de notificaciones en views/layout.php.
    public function inbox() {
        if (!isLoggedIn()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $u = currentUser();
        $userId = $u['id'];
        $institucionId = ($u['estado_institucional'] === 'aprobado') ? $u['institucion_id'] : 0;

        $model = new NotificationModel();
        $page = (int) ($_GET['page'] ?? 1);
        $perPage = (int) ($_GET['per_page'] ?? 15);

        $rows = $model->getInboxPage($userId, $institucionId, $page, $perPage);
        $total = $model->countInboxFor($userId, $institucionId);

        jsonResponse([
            'data' => $rows,
            'total' => $total,
            'page' => max(1, $page),
            'per_page' => $perPage,
            'total_pages' => $perPage > 0 ? (int) ceil($total / $perPage) : 1,
        ]);
    }

    public function markRead() {
        if (!isLoggedIn()) {
            jsonResponse(['error' => 'No autorizado'], 401);
            return;
        }
        $input = json_decode(file_get_contents('php://input'), true);
        if (!csrfValid($input['csrf_token'] ?? ($_SERVER['HTTP_X_CSRF_TOKEN'] ?? ''))) {
            jsonResponse(['error' => 'Token inválido'], 403);
            return;
        }

        $id = $input['id'] ?? null;
        if (!$id) {
            jsonResponse(['error' => 'ID requerido'], 400);
            return;
        }

        $u = currentUser();
        $institucionId = ($u['estado_institucional'] === 'aprobado') ? $u['institucion_id'] : 0;

        $model = new NotificationModel();
        $ok = $model->markRead($id, $u['id'], $institucionId);
        jsonResponse(['success' => $ok]);
    }

    // ---------------------------------------------------------------
    // Gestión de notificaciones (Admin Institucional / Admin General)
    // ---------------------------------------------------------------

    private function isSchoolAdmin() {
        $u = currentUser();
        if (!$u) return false;
        return $u['role'] === 'admin' || $u['role'] === 'director';
    }

    private function scopeInstitutionId() {
        $u = currentUser();
        if ($u['role'] === 'admin') return null;
        return $u['institucion_id'] ?? null;
    }

    public function manageList() {
        if (!isLoggedIn() || !$this->isSchoolAdmin()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $u = currentUser();
        $isGlobalAdmin = $u['role'] === 'admin';
        $model = new NotificationModel();
        $page = (int) ($_GET['page'] ?? 1);
        $perPage = (int) ($_GET['per_page'] ?? 10);
        $instId = $this->scopeInstitutionId();

        $rows = $model->getSentPage($instId, $isGlobalAdmin, $page, $perPage);
        $total = $model->countSent($instId, $isGlobalAdmin);

        jsonResponse([
            'data' => $rows,
            'total' => $total,
            'page' => max(1, $page),
            'per_page' => $perPage,
            'total_pages' => $perPage > 0 ? (int) ceil($total / $perPage) : 1,
        ]);
    }

    public function send() {
        if (!isLoggedIn() || !$this->isSchoolAdmin()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $input = json_decode(file_get_contents('php://input'), true);
        $mensaje = trim($input['mensaje'] ?? '');
        $severidad = $input['severidad'] ?? 'informativo';

        if (empty($mensaje)) {
            jsonResponse(['error' => 'El mensaje es obligatorio'], 400);
        }
        if (strlen($mensaje) > 255) {
            jsonResponse(['error' => 'El mensaje no puede superar los 255 caracteres'], 400);
        }
        $validSeveridad = ['seguro', 'informativo', 'precaucion', 'alerta', 'emergencia'];
        if (!in_array($severidad, $validSeveridad, true)) {
            jsonResponse(['error' => 'Severidad inválida'], 400);
        }

        $u = currentUser();
        // El director solo notifica a su institucion; el Admin General
        // puede enviar una notificacion global a todo el sitio.
        $isGlobal = $u['role'] === 'admin' && !empty($input['es_global']);
        $instId = $isGlobal ? null : ($u['role'] === 'admin' ? ($input['institucion_id'] ?? null) : $u['institucion_id']);

        if (!$isGlobal && !$instId) {
            jsonResponse(['error' => 'Selecciona una institución o marca la notificación como global'], 400);
        }

        $model = new NotificationModel();
        $id = $model->create([
            'tipo' => 'escolar',
            'severidad' => $severidad,
            'destinatario_institucion_id' => $instId,
            'es_global' => $isGlobal,
            'mensaje' => $mensaje,
        ]);

        jsonResponse(['success' => true, 'id' => $id]);
    }

    public function delete() {
        if (!isLoggedIn() || !$this->isSchoolAdmin()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $id = $_GET['id'] ?? null;
        if (!$id) {
            jsonResponse(['error' => 'ID requerido'], 400);
        }

        $model = new NotificationModel();
        $notif = $model->getById($id);
        if (!$notif) {
            jsonResponse(['error' => 'Notificación no encontrada'], 404);
        }
        $u = currentUser();
        if ($u['role'] !== 'admin' && $notif['destinatario_institucion_id'] != $this->scopeInstitutionId()) {
            jsonResponse(['error' => 'No autorizado'], 403);
        }

        $model->delete($id);
        jsonResponse(['success' => true]);
    }
}
