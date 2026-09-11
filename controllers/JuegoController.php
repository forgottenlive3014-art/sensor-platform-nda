<?php
require_once __DIR__ . '/../models/PuntajeModel.php';

class JuegoController {

    // Whitelist: solo se guardan puntajes de juegos reales de views/juegos.php,
    // para que nadie mande un nombre arbitrario desde la consola del navegador.
    private $juegosValidos = [
        'Quiz de Preparación',
        'Memoria de Emergencia',
        'Arma tu Mochila',
        'Simulacro Reflejo Sísmico',
    ];

    public function saveScore() {
        if (!isLoggedIn()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $input = json_decode(file_get_contents('php://input'), true);
        $juego = $input['juego'] ?? '';
        $puntaje = $input['puntaje'] ?? null;

        if (!in_array($juego, $this->juegosValidos, true)) {
            jsonResponse(['error' => 'Juego inválido'], 400);
        }
        if (!is_numeric($puntaje)) {
            jsonResponse(['error' => 'Puntaje inválido'], 400);
        }
        $puntaje = max(0, min(999999, (int) $puntaje));

        $u = currentUser();
        $model = new PuntajeModel();
        $model->save($u['id'], $juego, $puntaje);

        jsonResponse(['success' => true]);
    }

    public function myScores() {
        if (!isLoggedIn()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $u = currentUser();
        $model = new PuntajeModel();
        jsonResponse($model->getBestByUser($u['id']));
    }
}
