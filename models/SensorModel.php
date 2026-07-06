<?php
class SensorModel {

    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    // Guarda una lectura nueva y poda la tabla a las ultimas 500 filas
    // (mismo comportamiento que tenia el controlador, solo reubicado).
    public function save($intensidad, $nivel, $ejeX, $ejeY, $ejeZ, $fuente) {
        $stmt = $this->db->prepare("
            INSERT INTO lecturas_sensor (intensidad, nivel, eje_x, eje_y, eje_z, fuente)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$intensidad, $nivel, $ejeX, $ejeY, $ejeZ, $fuente]);
        $newId = $this->db->lastInsertId();

        $this->db->exec("DELETE FROM lecturas_sensor WHERE lecturas_sensor_id NOT IN (
            SELECT id FROM (SELECT lecturas_sensor_id AS id FROM lecturas_sensor ORDER BY lecturas_sensor_id DESC LIMIT 500) t
        )");

        return $newId;
    }

    public function latestSince($sinceId, $limit = 50) {
        $stmt = $this->db->prepare("
            SELECT lecturas_sensor_id, intensidad, nivel, eje_x, eje_y, eje_z, fuente, created_at
            FROM lecturas_sensor
            WHERE lecturas_sensor_id > ?
            ORDER BY lecturas_sensor_id ASC
            LIMIT " . intval($limit) . "
        ");
        $stmt->execute([$sinceId]);
        return $stmt->fetchAll();
    }

    public function maxId() {
        $stmt = $this->db->query("SELECT MAX(lecturas_sensor_id) as max_id FROM lecturas_sensor");
        return (int)($stmt->fetch()['max_id'] ?? 0);
    }

    // "Conectado" si hubo al menos una lectura en los ultimos 15 segundos.
    public function isConnected() {
        $stmt = $this->db->query("SELECT created_at FROM lecturas_sensor ORDER BY lecturas_sensor_id DESC LIMIT 1");
        $last = $stmt->fetch();
        if (!$last) return false;
        return (time() - strtotime($last['created_at'])) < 15;
    }
}
