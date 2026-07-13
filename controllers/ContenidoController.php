<?php
require_once __DIR__ . '/../models/ContenidoModel.php';

class ContenidoController {

    // Solo el Admin General edita el contenido del sitio.
    private function isAdminGeneral() {
        $u = currentUser();
        return $u && $u['role'] === 'admin';
    }

    private function fieldDefsFor($pagina) {
        return $pagina === 'quehacer' ? ContenidoModel::quehacerFieldDefs() : ContenidoModel::acercadeFieldDefs();
    }

    // Combina lo guardado en la base de datos con los valores por defecto,
    // así el formulario de administración siempre muestra las ~140 filas
    // completas aunque algunas nunca se hayan editado.
    private function getMerged($pagina) {
        $model = new ContenidoModel();
        $saved = $model->getByPage($pagina);
        $defs = $this->fieldDefsFor($pagina);
        $out = [];
        foreach ($defs as $def) {
            $out[] = [
                'campo' => $def['campo'],
                'label' => $def['label'],
                'group' => $def['group'],
                'type' => $def['type'],
                'valor' => $saved[$def['campo']] ?? $def['default'],
            ];
        }
        return $out;
    }

    // Guarda solo los campos que existen en la definición de la página
    // (evita que se inyecten claves arbitrarias en contenido_paginas).
    private function saveMerged($pagina) {
        if (!isLoggedIn() || !$this->isAdminGeneral()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $input = json_decode(file_get_contents('php://input'), true);
        $valores = $input['valores'] ?? [];
        if (!is_array($valores)) {
            jsonResponse(['error' => 'Datos inválidos'], 400);
        }

        $defs = $this->fieldDefsFor($pagina);
        $camposValidos = array_column($defs, 'campo');
        $pares = [];
        foreach ($camposValidos as $campo) {
            if (array_key_exists($campo, $valores)) {
                $pares[$campo] = trim((string) $valores[$campo]);
            }
        }

        $model = new ContenidoModel();
        $model->saveBulk($pagina, $pares);
        jsonResponse(['success' => true]);
    }

    public function getQuehacer() {
        if (!isLoggedIn() || !$this->isAdminGeneral()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        jsonResponse(['data' => $this->getMerged('quehacer')]);
    }

    public function saveQuehacer() {
        $this->saveMerged('quehacer');
    }

    public function getAcercade() {
        if (!isLoggedIn() || !$this->isAdminGeneral()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        jsonResponse(['data' => $this->getMerged('acercade')]);
    }

    public function saveAcercade() {
        $this->saveMerged('acercade');
    }
}
