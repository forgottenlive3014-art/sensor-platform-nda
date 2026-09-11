<?php
class PuntajeModel {

    private $db;

    // Juegos donde un puntaje MAS BAJO es mejor (tiempo de reaccion en ms),
    // al contrario de los demas donde mas alto es mejor.
    const JUEGOS_MENOR_ES_MEJOR = ['Simulacro Reflejo Sísmico'];

    public function __construct() {
        $this->db = getDB();
    }

    public function save($usuariosId, $juegoNombre, $puntaje) {
        $stmt = $this->db->prepare("INSERT INTO puntajes_juegos (usuarios_id, juego_nombre, puntaje) VALUES (?, ?, ?)");
        $stmt->execute([$usuariosId, $juegoNombre, (int) $puntaje]);
        return $this->db->lastInsertId();
    }

    // Mejor puntaje + fecha del ultimo intento, por juego, para el perfil.
    public function getBestByUser($usuariosId) {
        $stmt = $this->db->prepare("
            SELECT juego_nombre,
                   MAX(puntaje) as mejor,
                   MIN(puntaje) as menor,
                   COUNT(*) as intentos,
                   MAX(created_at) as ultimo
            FROM puntajes_juegos
            WHERE usuarios_id = ?
            GROUP BY juego_nombre
            ORDER BY ultimo DESC
        ");
        $stmt->execute([$usuariosId]);
        $rows = $stmt->fetchAll();
        foreach ($rows as &$row) {
            $row['mejor_real'] = in_array($row['juego_nombre'], self::JUEGOS_MENOR_ES_MEJOR, true)
                ? $row['menor']
                : $row['mejor'];
        }
        return $rows;
    }
}
