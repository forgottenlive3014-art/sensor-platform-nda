<?php
require_once __DIR__ . '/../models/SensorModel.php';
require_once __DIR__ . '/../models/NotificationModel.php';

class SensorController {

    const UMBRAL_PRECAUCION = 0.3;
    const UMBRAL_ALERTA = 0.8;

    // Recibe una lectura del sketch de Processing: { token, intensidad, eje_x, eje_y, eje_z }
    public function ingest() {
        $input = json_decode(file_get_contents('php://input'), true);

        // Autenticacion simple por token compartido (definido en .env).
        $expected = env('SENSOR_INGEST_TOKEN', '');
        $token = $input['token'] ?? ($_SERVER['HTTP_X_SENSOR_TOKEN'] ?? '');
        if (empty($expected) || !hash_equals($expected, (string)$token)) {
            jsonResponse(['error' => 'Token inválido o no configurado (SENSOR_INGEST_TOKEN en .env)'], 401);
            return;
        }

        $intensidad = isset($input['intensidad']) ? floatval($input['intensidad']) : null;
        if ($intensidad === null) {
            jsonResponse(['error' => 'Falta el campo intensidad'], 400);
            return;
        }

        $nivel = 'normal';
        if ($intensidad >= self::UMBRAL_ALERTA) {
            $nivel = 'alerta';
        } elseif ($intensidad >= self::UMBRAL_PRECAUCION) {
            $nivel = 'precaucion';
        }

        $ejeX = isset($input['eje_x']) ? floatval($input['eje_x']) : null;
        $ejeY = isset($input['eje_y']) ? floatval($input['eje_y']) : null;
        $ejeZ = isset($input['eje_z']) ? floatval($input['eje_z']) : null;
        $fuente = trim($input['fuente'] ?? 'arduino-processing');

        $model = new SensorModel();
        $model->save($intensidad, $nivel, $ejeX, $ejeY, $ejeZ, $fuente);

        // Alerta real: genera notificacion global visible en toda la plataforma.
        if ($nivel === 'alerta') {
            try {
                (new NotificationModel())->create([
                    'tipo' => 'sensor',
                    'severidad' => 'emergencia',
                    'destinatario_usuario_id' => null,
                    'destinatario_institucion_id' => null,
                    'es_global' => true,
                    'mensaje' => 'El sensor de vibración registró una intensidad de ' . number_format($intensidad, 2) . 'G — nivel de alerta.',
                    'referencia_tipo' => 'lecturas_sensor',
                ]);
            } catch (Exception $e) { /* la ingesta del sensor nunca debe fallar por esto */ }
        }

        jsonResponse(['success' => true, 'nivel' => $nivel]);
    }

    public function latest() {
        $model = new SensorModel();
        $since = $_GET['since_id'] ?? 0;

        jsonResponse([
            'readings' => $model->latestSince($since),
            'last_id' => $model->maxId(),
            'connected' => $model->isConnected(),
        ]);
    }
}
