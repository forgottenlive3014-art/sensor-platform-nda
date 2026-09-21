<?php
require_once __DIR__ . '/../models/InstitutionModel.php';
require_once __DIR__ . '/../models/NotificationModel.php';

class InstitucionController {

    // Solo el Admin General administra instituciones.
    private function isAdminGeneral() {
        $u = currentUser();
        return $u && $u['role'] === 'admin';
    }

    public function list() {
        if (!isLoggedIn() || !$this->isAdminGeneral()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $model = new InstitutionModel();
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
        $input = json_decode(file_get_contents('php://input'), true);
        $nombre = trim($input['nombre'] ?? '');
        $correo = trim($input['correo'] ?? '');

        if (empty($nombre)) {
            jsonResponse(['error' => 'El nombre de la institución es obligatorio'], 400);
        }

        $model = new InstitutionModel();
        if ($correo !== '' && $model->emailExists($correo)) {
            jsonResponse(['error' => 'Ese correo institucional ya está registrado'], 400);
        }

        $id = $model->create([
            'nombre' => $nombre,
            'tipo' => trim($input['tipo'] ?? ''),
            'correo' => $correo,
            'telefono' => trim($input['telefono'] ?? ''),
            'direccion' => trim($input['direccion'] ?? ''),
        ]);

        jsonResponse(['success' => true, 'id' => $id]);
    }

    public function update() {
        if (!isLoggedIn() || !$this->isAdminGeneral()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['id'] ?? null;
        $nombre = trim($input['nombre'] ?? '');

        if (!$id) {
            jsonResponse(['error' => 'ID de institución requerido'], 400);
        }
        if (empty($nombre)) {
            jsonResponse(['error' => 'El nombre de la institución es obligatorio'], 400);
        }

        $model = new InstitutionModel();
        if (!$model->getById($id)) {
            jsonResponse(['error' => 'Institución no encontrada'], 404);
        }
        $correo = trim($input['correo'] ?? '');
        if ($correo !== '' && $model->emailExists($correo, $id)) {
            jsonResponse(['error' => 'Ese correo institucional ya está registrado'], 400);
        }

        $model->update($id, [
            'nombre' => $nombre,
            'tipo' => trim($input['tipo'] ?? ''),
            'correo' => $correo,
            'telefono' => trim($input['telefono'] ?? ''),
            'direccion' => trim($input['direccion'] ?? ''),
        ]);

        jsonResponse(['success' => true]);
    }

    public function stats() {
        if (!isLoggedIn() || !$this->isAdminGeneral()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $id = $_GET['id'] ?? null;
        if (!$id) {
            jsonResponse(['error' => 'ID de institución requerido'], 400);
        }
        $model = new InstitutionModel();
        if (!$model->getById($id)) {
            jsonResponse(['error' => 'Institución no encontrada'], 404);
        }
        jsonResponse(['success' => true, 'stats' => $model->getStats($id)]);
    }

    public function requests() {
        if (!isLoggedIn() || !$this->isAdminGeneral()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        jsonResponse(['data' => (new InstitutionModel())->getPendingFoundations()]);
    }

    public function approveRequest() {
        if (!isLoggedIn() || !$this->isAdminGeneral()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['id'] ?? null;
        if (!$id) jsonResponse(['error' => 'ID de institución requerido'], 400);

        $model = new InstitutionModel();
        $institution = $model->getById($id);
        if (!$institution || $institution['estado_verificacion'] !== 'pendiente' || !empty($institution['codigo_verificacion'])) {
            jsonResponse(['error' => 'Solicitud no encontrada o ya revisada'], 404);
        }

        $verifyCode = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $verifyExpira = date('Y-m-d H:i:s', time() + 3 * 60);
        $nombreDestino = $institution['nombre_director'] ?: 'Director de la institución';
        if (!Mailer::sendVerificationCode($institution['correo'], $nombreDestino, $verifyCode)) {
            jsonResponse(['error' => 'La solicitud fue revisada, pero no se pudo enviar el código al correo institucional'], 502);
        }

        $db = getDB();
        $db->prepare("UPDATE instituciones SET codigo_verificacion = ?, codigo_verificacion_expira = ? WHERE instituciones_id = ?")
           ->execute([$verifyCode, $verifyExpira, $id]);
        if (!empty($institution['director_id'])) {
                $db->prepare("UPDATE usuarios SET role = 'director', estado_institucional = 'pendiente' WHERE usuarios_id = ?")
                    ->execute([$institution['director_id']]);
            (new NotificationModel())->create([
                'tipo' => 'sistema',
                'severidad' => 'informativo',
                'destinatario_usuario_id' => $institution['director_id'],
                'mensaje' => 'Tu solicitud para fundar "' . $institution['nombre'] . '" fue aprobada. Revisa el correo institucional para confirmar con el código enviado.',
                'referencia_tipo' => 'solicitud_institucion_aprobada',
                'referencia_id' => $id,
            ]);
        }
        jsonResponse(['success' => true]);
    }

    public function rejectRequest() {
        if (!isLoggedIn() || !$this->isAdminGeneral()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['id'] ?? null;
        $reason = trim($input['reason'] ?? '');
        if (!$id) jsonResponse(['error' => 'ID de institución requerido'], 400);
        if ($reason === '') jsonResponse(['error' => 'Escribe el motivo del rechazo'], 400);

        $model = new InstitutionModel();
        $institution = $model->getById($id);
        if (!$institution || $institution['estado_verificacion'] !== 'pendiente') {
            jsonResponse(['error' => 'Solicitud no encontrada o ya revisada'], 404);
        }

        $db = getDB();
        $db->beginTransaction();
        try {
            if (!empty($institution['director_id'])) {
                (new NotificationModel())->create([
                    'tipo' => 'sistema',
                    'severidad' => 'alerta',
                    'destinatario_usuario_id' => $institution['director_id'],
                    'mensaje' => 'Tu solicitud para fundar "' . $institution['nombre'] . '" no fue aceptada. Motivo: ' . $reason,
                    'referencia_tipo' => 'solicitud_institucion_rechazada',
                    'referencia_id' => $id,
                ]);
                $db->prepare("UPDATE usuarios SET role = 'user', institucion_id = NULL, estado_institucional = 'ninguno' WHERE usuarios_id = ?")
                   ->execute([$institution['director_id']]);
            }
            $db->prepare("DELETE FROM instituciones WHERE instituciones_id = ?")->execute([$id]);
            $db->commit();
        } catch (Throwable $e) {
            $db->rollBack();
            jsonResponse(['error' => 'No se pudo rechazar la solicitud'], 500);
        }
        jsonResponse(['success' => true]);
    }

    public function delete() {
        if (!isLoggedIn() || !$this->isAdminGeneral()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $id = $_GET['id'] ?? null;
        if (!$id) {
            jsonResponse(['error' => 'ID de institución requerido'], 400);
        }

        $model = new InstitutionModel();
        $institution = $model->getById($id);
        if (!$institution) {
            jsonResponse(['error' => 'Institución no encontrada'], 404);
        }

        $db = getDB();
        $stmtUsers = $db->prepare("SELECT usuarios_id FROM usuarios WHERE institucion_id = ?");
        $stmtUsers->execute([$id]);
        $userIds = array_column($stmtUsers->fetchAll(), 'usuarios_id');

        $db->beginTransaction();
        try {
            $notification = new NotificationModel();
            foreach ($userIds as $userId) {
                $notification->create([
                    'tipo' => 'sistema',
                    'severidad' => 'alerta',
                    'destinatario_usuario_id' => $userId,
                    'mensaje' => 'La institución "' . $institution['nombre'] . '" fue eliminada por el administrador. Tu vínculo y el acceso a sus datos fueron retirados.',
                    'referencia_tipo' => 'institucion_eliminada',
                    'referencia_id' => $id,
                ]);
            }

                $db->prepare("UPDATE usuarios SET role = 'user', institucion_id = NULL, estado_institucional = 'ninguno' WHERE institucion_id = ?")
               ->execute([$id]);
            $deleteStmt = $db->prepare("DELETE FROM instituciones WHERE instituciones_id = ?");
            $deleteStmt->execute([$id]);
            if ($deleteStmt->rowCount() !== 1) {
                throw new RuntimeException('La institución no pudo eliminarse de la base de datos');
            }
            $db->commit();

            if (!empty($_SESSION['admin_view_institucion_id'])
                && (int) $_SESSION['admin_view_institucion_id'] === (int) $id) {
                unset($_SESSION['admin_view_institucion_id']);
            }
        } catch (Throwable $e) {
            $db->rollBack();
            error_log('Error al eliminar institución ' . $id . ': ' . $e->getMessage());
            jsonResponse(['error' => 'No se pudo eliminar la institución: ' . $e->getMessage()], 500);
        }

        jsonResponse(['success' => true]);
    }
}
