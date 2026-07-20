<?php
require_once __DIR__ . '/../models/InstitutionModel.php';

class SchoolController {

    // ---------- Helpers de permisos e institucion ----------

    // Admin global (usuarios 'admin') o director de su propia institucion.
    private function isSchoolAdmin() {
        $u = currentUser();
        if (!$u) return false;
        return $u['role'] === 'admin' || $u['role'] === 'director';
    }

    // Personal con permisos de gestion diaria (director, docente, admin).
    private function isSchoolStaff() {
        $u = currentUser();
        if (!$u) return false;
        return in_array($u['role'], ['admin', 'director', 'docente'], true);
    }

    // Institucion del usuario logueado (null si es admin global o no tiene).
    private function myInstitutionId() {
        $u = currentUser();
        return $u['institucion_id'] ?? null;
    }

    // True si el usuario pertenece de forma aprobada a alguna institucion,
    // o es un admin global del sistema.
    private function canAccessSchool() {
        $u = currentUser();
        if (!$u) return false;
        if ($u['role'] === 'admin') return true;
        return in_array($u['role'], ['director', 'docente', 'alumno', 'padre', 'administrativo'], true)
            && $u['estado_institucional'] === 'aprobado';
    }

    // Consulta las estadisticas/resumen usadas por el Panel Escolar
    // (director y docente) — no las necesita la Pagina Principal, que
    // trae sus propios datos via InicioInstitucionalController.
    private function panelStats($instId, $isGlobalAdmin) {
        $db = getDB();
        $instFilter = ($isGlobalAdmin || !$instId) ? '' : " WHERE instituciones_id = " . intval($instId);
        $instFilterAlias = ($isGlobalAdmin || !$instId) ? '' : " WHERE a.instituciones_id = " . intval($instId);

        $stats = [
            'students' => $db->query("SELECT COUNT(*) as total FROM estudiantes e JOIN aulas a ON e.aulas_id=a.aulas_id" . $instFilterAlias)->fetch()['total'] ?? 0,
            'teachers' => $db->query("SELECT COUNT(*) as total FROM usuarios WHERE (role='docente' OR role='admin' OR role='director')" . ($instId ? " AND institucion_id=" . intval($instId) : ''))->fetch()['total'] ?? 0,
            'parents' => $db->query("SELECT COUNT(*) as total FROM usuarios WHERE role='padre'" . ($instId ? " AND institucion_id=" . intval($instId) : ''))->fetch()['total'] ?? 0,
            'classrooms' => $db->query("SELECT COUNT(*) as total FROM aulas" . $instFilter)->fetch()['total'] ?? 0,
            'routes' => $db->query("SELECT COUNT(*) as total FROM rutas_evacuacion" . $instFilter)->fetch()['total'] ?? 0,
            'drills' => $db->query("SELECT COUNT(*) as total FROM simulacros" . $instFilter)->fetch()['total'] ?? 0,
            'incidents' => $db->query("SELECT COUNT(*) as total FROM incidentes" . ($instId ? " WHERE instituciones_id=" . intval($instId) : '') . ($instId ? " AND estado='abierto'" : " WHERE estado='abierto'"))->fetch()['total'] ?? 0,
        ];

        $studentsQ = "
            SELECT e.*, a.nombre as classroom, u.nombre as teacher
            FROM estudiantes e
            LEFT JOIN aulas a ON e.aulas_id = a.aulas_id
            LEFT JOIN usuarios u ON a.maestro_id = u.usuarios_id"
            . ($instId && !$isGlobalAdmin ? " WHERE a.instituciones_id = " . intval($instId) : '') .
            " ORDER BY e.created_at DESC LIMIT 10";
        $students = $db->query($studentsQ)->fetchAll();

        $drills = $db->query("SELECT * FROM simulacros" . $instFilter . " ORDER BY fecha DESC LIMIT 5")->fetchAll();
        $routes = $db->query("SELECT * FROM rutas_evacuacion" . $instFilter . " ORDER BY created_at DESC LIMIT 5")->fetchAll();

        $incidentsQ = "SELECT i.*, u.nombre as reporter FROM incidentes i LEFT JOIN usuarios u ON i.usuario_id = u.usuarios_id"
            . ($instId && !$isGlobalAdmin ? " WHERE i.instituciones_id = " . intval($instId) : '')
            . " ORDER BY i.created_at DESC LIMIT 5";
        $incidents = $db->query($incidentsQ)->fetchAll();

        return compact('stats', 'students', 'drills', 'routes', 'incidents');
    }

    // Pagina Principal Institucional (un solo archivo, compartido por
    // director/docente/alumno/padre/administrativo). El Admin General no
    // pertenece a una institucion, asi que sigue viendo su propio panel
    // global (admin-general.php) sin cambios.
    public function index() {
        if (!isLoggedIn()) {
            redirect('login');
            return;
        }
        if (!$this->canAccessSchool()) {
            redirect('profile');
            return;
        }

        $user = currentUser();

        if ($user['role'] === 'admin') {
            view('school/panels/admin-general', [
                'title' => 'Panel de Administración General',
                'user' => $user,
                'isSchoolAdmin' => true,
                'isSchoolStaff' => true,
            ]);
            return;
        }

        // Datos basicos de la institucion para pintar el encabezado de
        // inmediato (el resto — croquis, zonas, rutas, simulacros —
        // se carga por AJAX via InicioInstitucionalController).
        $institucion = null;
        if ($this->myInstitutionId()) {
            $institucion = (new InstitutionModel())->getById($this->myInstitutionId());
        }

        view('school/home', [
            'title' => 'Gestión Escolar · ' . ($user['institucion_nombre'] ?? 'NDA'),
            'user' => $user,
            'institucion' => $institucion,
            'isSchoolAdmin' => $this->isSchoolAdmin(),
            'isSchoolStaff' => $this->isSchoolStaff(),
            'panelTitle' => 'Página Principal',
            'panelSubtitle' => $user['institucion_nombre'] ?? '',
        ]);
    }

    // Panel Escolar (Gestión): archivo aparte, solo director (completo) y
    // docente (reducido a lo suyo). El resto de roles no tiene Panel — todo
    // lo suyo ya vive en la Pagina Principal.
    public function panel() {
        if (!isLoggedIn()) {
            redirect('login');
            return;
        }
        $user = currentUser();
        if (!in_array($user['role'], ['director', 'docente'], true) || $user['estado_institucional'] !== 'aprobado') {
            redirect('school');
            return;
        }

        $instId = $this->myInstitutionId();
        $isGlobalAdmin = false;
        $panelData = $this->panelStats($instId, $isGlobalAdmin);

        $pendingRequestsCount = 0;
        if ($user['role'] === 'director' && $instId) {
            $db = getDB();
            $stmt = $db->prepare("SELECT COUNT(*) as total FROM solicitudes_institucion WHERE instituciones_id = ? AND estado = 'pendiente'");
            $stmt->execute([$instId]);
            $pendingRequestsCount = $stmt->fetch()['total'] ?? 0;
        }

        $panelView = $user['role'] === 'director' ? 'panel-director' : 'panel-docente';
        $panelTitle = $user['role'] === 'director' ? 'Panel Escolar' : 'Panel Escolar — Mis Secciones';

        view('school/panels/' . $panelView, array_merge($panelData, [
            'title' => $panelTitle,
            'user' => $user,
            'isSchoolAdmin' => $this->isSchoolAdmin(),
            'isSchoolStaff' => $this->isSchoolStaff(),
            'pendingRequestsCount' => $pendingRequestsCount,
            'panelTitle' => $panelTitle,
            'panelSubtitle' => $user['role'] === 'director'
                ? 'Administra alumnos, docentes, rutas de evacuación, simulacros y más'
                : 'Tus secciones, pase de lista, rutas y croquis',
        ]));
    }

    // (ALUMNOS: ver controllers/EstudianteController.php)

    // (DOCENTES: ver controllers/DocenteController.php)

    // (AULAS: ver controllers/AulaController.php)

    // ============================================================
    //  RUTAS DE EVACUACIÓN
    // ============================================================

    public function getRoutes() {
        if (!isLoggedIn()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }

        $db = getDB();
        $u = currentUser();
        $sql = "
            SELECT r.*, i.nombre as institution
            FROM rutas_evacuacion r
            LEFT JOIN instituciones i ON r.instituciones_id = i.instituciones_id
        ";
        $params = [];
        if ($u['role'] !== 'admin' && $u['institucion_id']) {
            $sql .= " WHERE r.instituciones_id = ?";
            $params[] = $u['institucion_id'];
        }
        $sql .= " ORDER BY r.nombre";
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        jsonResponse($stmt->fetchAll());
    }

    public function addRoute() {
        if (!isLoggedIn() || !$this->isSchoolStaff()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $nombre = trim($input['nombre'] ?? '');
        $descripcion = trim($input['descripcion'] ?? '');
        $institucion_id = $input['institucion_id'] ?? $this->myInstitutionId();
        $estado = $input['estado'] ?? 'despejada';

        if (empty($nombre)) {
            jsonResponse(['error' => 'El nombre de la ruta es obligatorio'], 400);
        }

        $db = getDB();
        $stmt = $db->prepare("
            INSERT INTO rutas_evacuacion (nombre, descripcion, instituciones_id, estado)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([$nombre, $descripcion, $institucion_id, $estado]);

        jsonResponse(['success' => true, 'id' => $db->lastInsertId()]);
    }

    public function updateRoute() {
        if (!isLoggedIn() || !$this->isSchoolStaff()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['id'] ?? null;

        if (!$id) {
            jsonResponse(['error' => 'ID de ruta requerido'], 400);
        }

        $db = getDB();
        $stmt = $db->prepare("
            UPDATE rutas_evacuacion
            SET nombre = ?, descripcion = ?, estado = ?
            WHERE rutas_evacuacion_id = ?
        ");
        $stmt->execute([
            $input['nombre'] ?? '',
            $input['descripcion'] ?? '',
            $input['estado'] ?? 'despejada',
            $id
        ]);

        jsonResponse(['success' => true]);
    }

    public function deleteRoute() {
        if (!isLoggedIn() || !$this->isSchoolAdmin()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            jsonResponse(['error' => 'ID de ruta requerido'], 400);
        }

        $db = getDB();
        $stmt = $db->prepare("DELETE FROM rutas_evacuacion WHERE rutas_evacuacion_id = ?");
        $stmt->execute([$id]);

        jsonResponse(['success' => true]);
    }

    // (ASISTENCIA: ver controllers/AsistenciaController.php)

    // ============================================================
    //  INCIDENTES
    // ============================================================

    public function getIncidents() {
        if (!isLoggedIn()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }

        $db = getDB();
        $u = currentUser();
        $sql = "
            SELECT i.*, u.nombre as reporter
            FROM incidentes i
            LEFT JOIN usuarios u ON i.usuario_id = u.usuarios_id
        ";
        $params = [];
        if ($u['role'] !== 'admin' && $u['institucion_id']) {
            $sql .= " WHERE i.instituciones_id = ?";
            $params[] = $u['institucion_id'];
        }
        $sql .= " ORDER BY i.created_at DESC LIMIT 40";
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        jsonResponse($stmt->fetchAll());
    }

    public function addIncident() {
        if (!isLoggedIn()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }

        // FormData (multipart) para poder adjuntar una foto del daño.
        $tipo = trim($_POST['tipo'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $ubicacion = trim($_POST['ubicacion'] ?? '');
        $prioridad = $_POST['prioridad'] ?? 'media';
        // Ubicación exacta sobre el croquis (clic en el plano), opcional —
        // si no hay croquis cargado se usa solo el texto libre de arriba.
        $posX = isset($_POST['pos_x']) && $_POST['pos_x'] !== '' ? (float) $_POST['pos_x'] : null;
        $posY = isset($_POST['pos_y']) && $_POST['pos_y'] !== '' ? (float) $_POST['pos_y'] : null;

        if (empty($tipo) || empty($descripcion)) {
            jsonResponse(['error' => 'Faltan campos obligatorios'], 400);
        }

        $imagen = null;
        if (!empty($_FILES['imagen']['name']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $imagen = $this->storeUploadedImage($_FILES['imagen'], 'danos');
            if ($imagen === false) {
                jsonResponse(['error' => 'La imagen no es válida (usa JPG, PNG o WEBP, máx. 5MB)'], 400);
            }
        }

        $db = getDB();
        $user_id = $_SESSION['user_id'];
        $institucion_id = $this->myInstitutionId();

        $stmt = $db->prepare("
            INSERT INTO incidentes (tipo, descripcion, ubicacion, pos_x, pos_y, imagen, usuario_id, instituciones_id, prioridad)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$tipo, $descripcion, $ubicacion, $posX, $posY, $imagen, $user_id, $institucion_id, $prioridad]);

        jsonResponse(['success' => true, 'id' => $db->lastInsertId(), 'imagen' => $imagen]);
    }

    // Guarda una imagen subida en assets/media/uploads/{carpeta}/ con nombre unico.
    // Devuelve la ruta relativa (para guardar en BD) o false si no es valida.
    private function storeUploadedImage($file, $folder) {
        $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
        $mime = mime_content_type($file['tmp_name']);
        if (!isset($allowed[$mime])) return false;
        if ($file['size'] > 5 * 1024 * 1024) return false;

        $dir = __DIR__ . '/../assets/media/uploads/' . $folder;
        if (!is_dir($dir)) mkdir($dir, 0755, true);

        $name = uniqid($folder . '_', true) . '.' . $allowed[$mime];
        move_uploaded_file($file['tmp_name'], $dir . '/' . $name);

        return 'assets/media/uploads/' . $folder . '/' . $name;
    }

    // Solo admin/director, o el propio autor del reporte, pueden
    // resolver/editar/eliminar un incidente — un docente ya no puede tocar
    // reportes ajenos (spec: docente solo "consulta" incidentes).
    private function canManageIncident($incidenteId) {
        $db = getDB();
        $stmt = $db->prepare("SELECT usuario_id FROM incidentes WHERE incidentes_id = ?");
        $stmt->execute([$incidenteId]);
        $row = $stmt->fetch();
        if (!$row) return false;
        if ($this->isSchoolAdmin()) return true;
        $u = currentUser();
        return $u && (int) $row['usuario_id'] === (int) $u['id'];
    }

    public function resolveIncident() {
        $id = $_GET['id'] ?? null;
        if (!isLoggedIn() || !$id || !$this->canManageIncident($id)) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }

        $db = getDB();
        $stmt = $db->prepare("
            UPDATE incidentes SET estado = 'resuelto', resuelto_at = NOW()
            WHERE incidentes_id = ?
        ");
        $stmt->execute([$id]);

        jsonResponse(['success' => true]);
    }

    public function updateIncident() {
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['id'] ?? null;
        if (!isLoggedIn() || !$id || !$this->canManageIncident($id)) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }

        $posX = isset($input['pos_x']) && $input['pos_x'] !== '' ? (float) $input['pos_x'] : null;
        $posY = isset($input['pos_y']) && $input['pos_y'] !== '' ? (float) $input['pos_y'] : null;

        $db = getDB();
        $stmt = $db->prepare("
            UPDATE incidentes SET tipo = ?, descripcion = ?, ubicacion = ?, pos_x = ?, pos_y = ?, prioridad = ?
            WHERE incidentes_id = ?
        ");
        $stmt->execute([
            trim($input['tipo'] ?? ''),
            trim($input['descripcion'] ?? ''),
            trim($input['ubicacion'] ?? ''),
            $posX,
            $posY,
            $input['prioridad'] ?? 'media',
            $id
        ]);

        jsonResponse(['success' => true]);
    }

    public function deleteIncident() {
        $id = $_GET['id'] ?? null;
        if (!isLoggedIn() || !$id || !$this->canManageIncident($id)) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $db = getDB();
        $db->prepare("DELETE FROM incidentes WHERE incidentes_id = ?")->execute([$id]);
        jsonResponse(['success' => true]);
    }

    // (SIMULACROS: ver controllers/SimulacroController.php)

    // (REPORTES: ver controllers/ReporteController.php)

    // ============================================================
    //  SOLICITUDES DE INGRESO (aprobacion del director)
    // ============================================================

    public function getJoinRequests() {
        if (!isLoggedIn() || !$this->isSchoolAdmin()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $instId = $this->myInstitutionId();
        if (!$instId) jsonResponse([]);

        $db = getDB();
        $stmt = $db->prepare("
            SELECT s.*, u.nombre as usuario_nombre, u.email as usuario_email
            FROM solicitudes_institucion s
            JOIN usuarios u ON u.usuarios_id = s.usuarios_id
            WHERE s.instituciones_id = ? AND s.estado = 'pendiente'
            ORDER BY s.created_at ASC
        ");
        $stmt->execute([$instId]);
        jsonResponse($stmt->fetchAll());
    }

    public function approveJoinRequest() {
        if (!isLoggedIn() || !$this->isSchoolAdmin()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['id'] ?? null;
        if (!$id) jsonResponse(['error' => 'ID requerido'], 400);

        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM solicitudes_institucion WHERE solicitudes_institucion_id = ? AND instituciones_id = ?");
        $stmt->execute([$id, $this->myInstitutionId()]);
        $req = $stmt->fetch();
        if (!$req) jsonResponse(['error' => 'Solicitud no encontrada'], 404);

        $db->prepare("UPDATE solicitudes_institucion SET estado = 'aprobado', resolved_at = NOW() WHERE solicitudes_institucion_id = ?")
           ->execute([$id]);
        $db->prepare("UPDATE usuarios SET role = ?, estado_institucional = 'aprobado' WHERE usuarios_id = ?")
           ->execute([$req['rol_solicitado'], $req['usuarios_id']]);

        // Al quedar aprobado con rol institucional, se le asigna su código
        // institucional si todavía no tenía uno (ej. venía de rol 'user').
        $stmtC = $db->prepare("SELECT codigo_institucional FROM usuarios WHERE usuarios_id = ?");
        $stmtC->execute([$req['usuarios_id']]);
        $current = $stmtC->fetch();
        if ($current && empty($current['codigo_institucional'])) {
            $codigo = generateCodigoInstitucional($db);
            $db->prepare("UPDATE usuarios SET codigo_institucional = ? WHERE usuarios_id = ?")
               ->execute([$codigo, $req['usuarios_id']]);
        }

        jsonResponse(['success' => true]);
    }

    public function rejectJoinRequest() {
        if (!isLoggedIn() || !$this->isSchoolAdmin()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['id'] ?? null;
        if (!$id) jsonResponse(['error' => 'ID requerido'], 400);

        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM solicitudes_institucion WHERE solicitudes_institucion_id = ? AND instituciones_id = ?");
        $stmt->execute([$id, $this->myInstitutionId()]);
        $req = $stmt->fetch();
        if (!$req) jsonResponse(['error' => 'Solicitud no encontrada'], 404);

        $db->prepare("UPDATE solicitudes_institucion SET estado = 'rechazado', resolved_at = NOW() WHERE solicitudes_institucion_id = ?")
           ->execute([$id]);
        $db->prepare("UPDATE usuarios SET role = 'user', institucion_id = NULL, estado_institucional = 'ninguno' WHERE usuarios_id = ?")
           ->execute([$req['usuarios_id']]);

        jsonResponse(['success' => true]);
    }

    // (SECCIONES: ver controllers/SeccionController.php)

    // ============================================================
    //  CROQUIS INTERACTIVO
    // ============================================================

    public function getCroquis() {
        if (!isLoggedIn() || !$this->canAccessSchool()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $instId = $this->myInstitutionId();
        if (!$instId) jsonResponse(['imagen' => null, 'puntos' => []]);

        $db = getDB();
        $stmt = $db->prepare("SELECT imagen FROM croquis_institucion WHERE instituciones_id = ?");
        $stmt->execute([$instId]);
        $croquis = $stmt->fetch();

        $stmtP = $db->prepare("SELECT * FROM puntos_croquis WHERE instituciones_id = ? ORDER BY puntos_croquis_id");
        $stmtP->execute([$instId]);

        jsonResponse([
            'imagen' => $croquis['imagen'] ?? null,
            'puntos' => $stmtP->fetchAll(),
        ]);
    }

    public function uploadCroquisImage() {
        if (!isLoggedIn() || !$this->isSchoolAdmin()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $instId = $this->myInstitutionId();
        if (!$instId) jsonResponse(['error' => 'No tienes una institución asociada'], 400);

        if (empty($_FILES['imagen']['name']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
            jsonResponse(['error' => 'Sube una imagen del plano'], 400);
        }
        $path = $this->storeUploadedImage($_FILES['imagen'], 'croquis');
        if ($path === false) {
            jsonResponse(['error' => 'La imagen no es válida (usa JPG, PNG o WEBP, máx. 5MB)'], 400);
        }

        $db = getDB();
        $stmt = $db->prepare("
            INSERT INTO croquis_institucion (instituciones_id, imagen) VALUES (?, ?)
            ON DUPLICATE KEY UPDATE imagen = VALUES(imagen)
        ");
        $stmt->execute([$instId, $path]);

        jsonResponse(['success' => true, 'imagen' => $path]);
    }

    public function addCroquisPoint() {
        if (!isLoggedIn() || !$this->isSchoolStaff()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $instId = $this->myInstitutionId();
        if (!$instId) jsonResponse(['error' => 'No tienes una institución asociada'], 400);

        $input = json_decode(file_get_contents('php://input'), true);
        $tipo = $input['tipo'] ?? 'otro';
        $nombre = trim($input['nombre'] ?? '');
        $descripcion = trim($input['descripcion'] ?? '');
        $x = $input['pos_x'] ?? 50;
        $y = $input['pos_y'] ?? 50;

        if (empty($nombre)) jsonResponse(['error' => 'El punto necesita un nombre'], 400);

        $db = getDB();
        $stmt = $db->prepare("
            INSERT INTO puntos_croquis (instituciones_id, tipo, nombre, descripcion, pos_x, pos_y, creado_por)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$instId, $tipo, $nombre, $descripcion, $x, $y, $_SESSION['user_id']]);

        jsonResponse(['success' => true, 'id' => $db->lastInsertId()]);
    }

    public function updateCroquisPoint() {
        if (!isLoggedIn() || !$this->isSchoolStaff()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['id'] ?? null;
        $tipo = $input['tipo'] ?? 'otro';
        $nombre = trim($input['nombre'] ?? '');
        $descripcion = trim($input['descripcion'] ?? '');

        if (!$id) jsonResponse(['error' => 'ID requerido'], 400);
        if (empty($nombre)) jsonResponse(['error' => 'El punto necesita un nombre'], 400);

        $db = getDB();
        $stmt = $db->prepare("
            UPDATE puntos_croquis SET tipo = ?, nombre = ?, descripcion = ?
            WHERE puntos_croquis_id = ? AND instituciones_id = ?
        ");
        $stmt->execute([$tipo, $nombre, $descripcion, $id, $this->myInstitutionId()]);

        jsonResponse(['success' => true]);
    }

    public function deleteCroquisPoint() {
        if (!isLoggedIn() || !$this->isSchoolStaff()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $id = $_GET['id'] ?? null;
        if (!$id) jsonResponse(['error' => 'ID requerido'], 400);

        $db = getDB();
        $db->prepare("DELETE FROM puntos_croquis WHERE puntos_croquis_id = ? AND instituciones_id = ?")
           ->execute([$id, $this->myInstitutionId()]);

        jsonResponse(['success' => true]);
    }

    // Elimina el plano completo (y sus puntos, que quedarian sin sentido
    // sin la imagen sobre la que estan posicionados en %).
    public function deleteCroquisImage() {
        if (!isLoggedIn() || !$this->isSchoolAdmin()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $instId = $this->myInstitutionId();
        if (!$instId) jsonResponse(['error' => 'No tienes una institución asociada'], 400);

        $db = getDB();
        $db->prepare("DELETE FROM puntos_croquis WHERE instituciones_id = ?")->execute([$instId]);
        $db->prepare("DELETE FROM croquis_institucion WHERE instituciones_id = ?")->execute([$instId]);

        jsonResponse(['success' => true]);
    }

    // ============================================================
    //  TABLERO DE CORCHO (notas de la comunidad)
    // ============================================================

    // Roles institucionales validos para elegir como audiencia de una nota.
    private function boardVisibilityRoles() {
        return ['director', 'docente', 'alumno', 'padre', 'administrativo'];
    }

    public function getBoardNotes() {
        if (!isLoggedIn() || !$this->canAccessSchool()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $instId = $this->myInstitutionId();
        if (!$instId) jsonResponse([]);
        $u = currentUser();

        $db = getDB();
        // Una nota es visible si: es "todos", el autor eligio explicitamente
        // el rol del usuario actual, es el propio autor, o quien mira es
        // director/admin (moderacion — el director siempre ve todo lo de
        // su institucion, igual que ya podia borrar cualquier nota).
        $stmt = $db->prepare("
            SELECT c.*, u.nombre as autor
            FROM corcho_notas c
            JOIN usuarios u ON u.usuarios_id = c.usuarios_id
            WHERE c.instituciones_id = ?
              AND (
                    c.visibilidad = 'todos'
                    OR FIND_IN_SET(?, c.visibilidad)
                    OR c.usuarios_id = ?
                    OR ? = 1
                  )
            ORDER BY c.created_at DESC
            LIMIT 60
        ");
        $stmt->execute([$instId, $u['role'], $u['id'], $this->isSchoolAdmin() ? 1 : 0]);
        jsonResponse($stmt->fetchAll());
    }

    public function addBoardNote() {
        // Personal administrativo visualiza el corcho pero no crea notas
        // (spec: solo "visualiza sus notas personales y las del Administrador").
        $u = currentUser();
        if (!isLoggedIn() || !$this->canAccessSchool() || ($u && $u['role'] === 'administrativo')) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $instId = $this->myInstitutionId();
        if (!$instId) jsonResponse(['error' => 'No tienes una institución asociada'], 400);

        $input = json_decode(file_get_contents('php://input'), true);
        $texto = trim($input['texto'] ?? '');
        $color = $input['color'] ?? 'amarillo';
        $x = $input['pos_x'] ?? rand(5, 70);
        $y = $input['pos_y'] ?? rand(5, 70);
        $rot = $input['rotacion'] ?? rand(-6, 6);

        if (empty($texto)) jsonResponse(['error' => 'Escribe algo en la nota'], 400);
        if (strlen($texto) > 280) $texto = substr($texto, 0, 280);

        // audiencia: 'todos', o un array de roles (ej. ['docente','alumno']).
        $audiencia = $input['visibilidad'] ?? 'todos';
        if ($audiencia === 'todos' || empty($audiencia)) {
            $visibilidad = 'todos';
        } else {
            $roles = array_intersect((array) $audiencia, $this->boardVisibilityRoles());
            $visibilidad = $roles ? implode(',', $roles) : 'todos';
        }

        $db = getDB();
        $stmt = $db->prepare("
            INSERT INTO corcho_notas (instituciones_id, usuarios_id, texto, color, pos_x, pos_y, rotacion, visibilidad)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$instId, $_SESSION['user_id'], $texto, $color, $x, $y, $rot, $visibilidad]);

        jsonResponse(['success' => true, 'id' => $db->lastInsertId()]);
    }

    // Arrastrar y soltar: guarda la nueva posicion (%) del post-it. Solo el
    // autor o el director/admin pueden reposicionarla.
    public function moveBoardNote() {
        if (!isLoggedIn()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['id'] ?? null;
        $x = $input['pos_x'] ?? null;
        $y = $input['pos_y'] ?? null;
        if (!$id || $x === null || $y === null) {
            jsonResponse(['error' => 'Datos incompletos'], 400);
        }

        $db = getDB();
        $u = currentUser();
        if ($this->isSchoolAdmin()) {
            $stmt = $db->prepare("UPDATE corcho_notas SET pos_x = ?, pos_y = ? WHERE corcho_notas_id = ? AND instituciones_id = ?");
            $stmt->execute([$x, $y, $id, $this->myInstitutionId()]);
        } else {
            $stmt = $db->prepare("UPDATE corcho_notas SET pos_x = ?, pos_y = ? WHERE corcho_notas_id = ? AND usuarios_id = ?");
            $stmt->execute([$x, $y, $id, $u['id']]);
        }

        jsonResponse(['success' => true]);
    }

    public function deleteBoardNote() {
        if (!isLoggedIn()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $id = $_GET['id'] ?? null;
        if (!$id) jsonResponse(['error' => 'ID requerido'], 400);

        $db = getDB();
        $u = currentUser();
        if ($this->isSchoolAdmin()) {
            // El director puede quitar cualquier nota de su institucion.
            $db->prepare("DELETE FROM corcho_notas WHERE corcho_notas_id = ? AND instituciones_id = ?")
               ->execute([$id, $this->myInstitutionId()]);
        } else {
            // El resto solo puede borrar sus propias notas.
            $db->prepare("DELETE FROM corcho_notas WHERE corcho_notas_id = ? AND usuarios_id = ?")
               ->execute([$id, $u['id']]);
        }

        jsonResponse(['success' => true]);
    }
}
?>