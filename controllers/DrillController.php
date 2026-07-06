<?php
require_once __DIR__ . '/../models/DrillModel.php';
require_once __DIR__ . '/../models/NotificationModel.php';

class DrillController {

    private function isSchoolStaff() {
        $u = currentUser();
        if (!$u) return false;
        return in_array($u['role'], ['admin', 'director', 'docente'], true);
    }

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

    public function list() {
        if (!isLoggedIn()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $u = currentUser();
        $model = new DrillModel();
        jsonResponse($model->getRecent($this->scopeInstitutionId(), $u['role'] === 'admin'));
    }

    public function create() {
        if (!isLoggedIn() || !$this->isSchoolStaff()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $input = json_decode(file_get_contents('php://input'), true);
        $nombre = trim($input['nombre'] ?? '');
        if (empty($nombre)) {
            jsonResponse(['error' => 'El nombre del simulacro es obligatorio'], 400);
        }

        $instId = $input['institucion_id'] ?? $this->scopeInstitutionId();
        $model = new DrillModel();
        $id = $model->create([
            'nombre' => $nombre,
            'fecha' => $input['fecha'] ?? date('Y-m-d'),
            'hora' => $input['hora'] ?? date('H:i:s'),
            'instituciones_id' => $instId,
            'tipo' => $input['tipo'] ?? 'Sísmico',
            'descripcion' => trim($input['descripcion'] ?? ''),
        ]);

        jsonResponse(['success' => true, 'id' => $id]);
    }

    public function update() {
        if (!isLoggedIn() || !$this->isSchoolStaff()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['id'] ?? null;
        if (!$id) {
            jsonResponse(['error' => 'ID de simulacro requerido'], 400);
        }

        $model = new DrillModel();
        $model->update($id, [
            'nombre' => trim($input['nombre'] ?? ''),
            'fecha' => $input['fecha'] ?? date('Y-m-d'),
            'hora' => $input['hora'] ?? date('H:i:s'),
            'tipo' => $input['tipo'] ?? 'Sísmico',
            'descripcion' => trim($input['descripcion'] ?? ''),
        ]);

        jsonResponse(['success' => true]);
    }

    // El director/docente activa la alerta: pone el simulacro en curso para
    // que toda la comunidad institucional vea el banner en tiempo real.
    public function activate() {
        if (!isLoggedIn() || !$this->isSchoolStaff()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['id'] ?? null;
        if (!$id) {
            jsonResponse(['error' => 'ID de simulacro requerido'], 400);
        }

        $model = new DrillModel();
        $model->activate($id);

        // Notificacion escolar para todos los miembros de la institucion
        // dueña del simulacro (banner ya existente + campana de notificaciones).
        try {
            $sim = $model->getById($id);
            if ($sim) {
                (new NotificationModel())->create([
                    'tipo' => 'escolar',
                    'severidad' => 'alerta',
                    'destinatario_institucion_id' => $sim['instituciones_id'],
                    'mensaje' => 'Simulacro "' . $sim['nombre'] . '" (' . $sim['tipo'] . ') activado en curso.',
                    'referencia_tipo' => 'simulacros',
                    'referencia_id' => $id,
                ]);
            }
        } catch (Exception $e) { /* no bloquea la activacion del simulacro */ }

        jsonResponse(['success' => true]);
    }

    public function finish() {
        if (!isLoggedIn() || !$this->isSchoolStaff()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['id'] ?? null;
        if (!$id) {
            jsonResponse(['error' => 'ID de simulacro requerido'], 400);
        }

        $model = new DrillModel();
        $model->finish($id);

        jsonResponse(['success' => true]);
    }

    // Banner global: hay algun simulacro 'activo' para la institucion del usuario.
    public function activeAlert() {
        if (!isLoggedIn()) {
            jsonResponse(['active' => false]);
        }
        $instId = $this->scopeInstitutionId();
        if (!$instId) {
            jsonResponse(['active' => false]);
        }

        $model = new DrillModel();
        $drill = $model->getActiveForInstitution($instId);

        if ($drill) {
            jsonResponse(['active' => true, 'drill' => $drill]);
        } else {
            jsonResponse(['active' => false]);
        }
    }

    public function delete() {
        if (!isLoggedIn() || !$this->isSchoolAdmin()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $id = $_GET['id'] ?? null;
        if (!$id) {
            jsonResponse(['error' => 'ID de simulacro requerido'], 400);
        }

        $model = new DrillModel();
        $model->delete($id);

        jsonResponse(['success' => true]);
    }
}
