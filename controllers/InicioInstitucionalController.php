<?php
require_once __DIR__ . '/../models/InstitutionModel.php';

// Página Principal Institucional: resumen de una institución para sus
// propios miembros (nombre, dirección, mapa, croquis/zonas, rutas,
// noticias recientes y simulacros próximos). Todo agrega datos que ya
// existen en otros modelos/tablas — no crea nada nuevo.
class InicioInstitucionalController {

    private function canAccessSchool() {
        $u = currentUser();
        if (!$u) return false;
        if ($u['role'] === 'admin') return true;
        return in_array($u['role'], ['director', 'docente', 'alumno', 'padre', 'administrativo'], true)
            && $u['estado_institucional'] === 'aprobado';
    }

    public function get() {
        if (!isLoggedIn() || !$this->canAccessSchool()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $u = currentUser();
        $instId = $u['institucion_id'] ?? null;
        if (!$instId) {
            jsonResponse(['error' => 'No tienes una institución asociada'], 400);
        }

        $db = getDB();
        $institucion = (new InstitutionModel())->getById($instId);

        $croquisStmt = $db->prepare("SELECT imagen FROM croquis_institucion WHERE instituciones_id = ?");
        $croquisStmt->execute([$instId]);
        $croquis = $croquisStmt->fetch();

        $puntosStmt = $db->prepare("SELECT * FROM puntos_croquis WHERE instituciones_id = ? ORDER BY puntos_croquis_id");
        $puntosStmt->execute([$instId]);
        $puntos = $puntosStmt->fetchAll();
        $zonasSeguras = array_values(array_filter($puntos, fn($p) => $p['tipo'] === 'zona_segura'));
        $zonasRiesgo = array_values(array_filter($puntos, fn($p) => $p['tipo'] === 'zona_riesgo'));

        $rutasStmt = $db->prepare("SELECT * FROM rutas_evacuacion WHERE instituciones_id = ? ORDER BY nombre");
        $rutasStmt->execute([$instId]);
        $rutas = $rutasStmt->fetchAll();

        $noticiasStmt = $db->prepare("
            SELECT n.*, u.nombre as autor FROM noticias_internas n
            LEFT JOIN usuarios u ON u.usuarios_id = n.usuarios_id
            WHERE (n.instituciones_id = ? OR n.instituciones_id IS NULL) AND n.estado = 'publicada'
            ORDER BY n.created_at DESC LIMIT 5
        ");
        $noticiasStmt->execute([$instId]);
        $noticias = $noticiasStmt->fetchAll();

        $simulacrosStmt = $db->prepare("
            SELECT * FROM simulacros
            WHERE instituciones_id = ? AND estado = 'programado' AND fecha >= CURDATE()
            ORDER BY fecha ASC, hora ASC LIMIT 5
        ");
        $simulacrosStmt->execute([$instId]);
        $simulacrosProximos = $simulacrosStmt->fetchAll();

        jsonResponse([
            'institucion' => $institucion,
            'croquis_imagen' => $croquis['imagen'] ?? null,
            'zonas_seguras' => $zonasSeguras,
            'zonas_riesgo' => $zonasRiesgo,
            'rutas' => $rutas,
            'noticias' => $noticias,
            'simulacros_proximos' => $simulacrosProximos,
        ]);
    }
}
