<?php
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

    // Roles con acceso al Panel de Gestion (school/panel) — a diferencia de
    // isSchoolStaff(), NO incluye al admin global (que tiene su propio panel
    // aparte, admin-general) y excluye alumno/padre/administrativo, que ya
    // no tienen panel propio: todo lo suyo vive en la Pagina Principal.
    private function isPanelRole() {
        $u = currentUser();
        if (!$u) return false;
        return in_array($u['role'], ['director', 'docente'], true);
    }

    // Institucion del usuario logueado (null si es admin global o no tiene).
    private function myInstitutionId() {
        $u = currentUser();
        return $u['institucion_id'] ?? null;
    }

    // El Admin General puede "ver" el panel completo de una institucion en
    // modo solo lectura (ver viewInstitution()/exitInstitutionView() mas
    // abajo). Esto SOLO se usa para decidir que datos leer/mostrar — nunca
    // para crear/editar/borrar, que siguen atados a myInstitutionId() (null
    // para admin), asi la vista es de solo lectura incluso si alguien
    // intenta forzar una peticion de escritura mientras esta activa.
    private function adminViewingInstitutionId() {
        $u = currentUser();
        if ($u && $u['role'] === 'admin' && !empty($_SESSION['admin_view_institucion_id'])) {
            return (int) $_SESSION['admin_view_institucion_id'];
        }
        return null;
    }

    // Institucion a usar en endpoints de LECTURA: la del usuario, o la que
    // el Admin General este viendo. No usar en escritura (ver arriba).
    private function readInstitutionId() {
        return $this->adminViewingInstitutionId() ?? $this->myInstitutionId();
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

    public function index() {
        if (!isLoggedIn()) {
            redirect('login');
            return;
        }
        if (!$this->canAccessSchool()) {
            redirect('profile');
            return;
        }

        $db = getDB();
        $user = currentUser();

        // El Admin General no gestiona "una escuela", administra toda la
        // plataforma (instituciones, usuarios, blog, recursos, contenido) —
        // no es uno de los 5 roles institucionales, su panel no cambia con
        // la separacion Pagina Principal / Panel de Gestion. Excepcion: si
        // esta "viendo" una institucion especifica (viewInstitution()), ve
        // la Pagina Principal de esa institucion en modo solo lectura.
        if ($user['role'] === 'admin' && !$this->adminViewingInstitutionId()) {
            $this->renderAdminGeneral($db, $user);
            return;
        }

        $this->renderMainPage($db, $user);
    }

    // Admin General: activa el modo "ver institucion" (solo lectura) y lo
    // manda a esa institucion — a su Pagina Principal (como la ve cualquier
    // miembro: noticias, croquis, lugares en riesgo, corcho) por defecto, o
    // directo al Panel de Gestion completo si viene con ?dest=panel. Ambas
    // paginas se pueden cruzar entre si mientras el modo vista sigue activo
    // (se guarda en sesion, asi las llamadas AJAX de cada pestaña tambien
    // leen de ahi).
    public function viewInstitution() {
        if (!isLoggedIn() || currentUser()['role'] !== 'admin') {
            redirect('school');
            return;
        }
        $id = (int) ($_GET['id'] ?? 0);
        if (!$id) {
            redirect('school');
            return;
        }
        $db = getDB();
        $stmt = $db->prepare("SELECT instituciones_id FROM instituciones WHERE instituciones_id = ?");
        $stmt->execute([$id]);
        if (!$stmt->fetch()) {
            $_SESSION['error'] = 'Esa institución no existe.';
            redirect('school');
            return;
        }
        $_SESSION['admin_view_institucion_id'] = $id;
        redirect(($_GET['dest'] ?? '') === 'panel' ? 'school/panel' : 'school');
    }

    // Sale del modo "ver institucion" y regresa al panel del Admin General.
    public function exitInstitutionView() {
        unset($_SESSION['admin_view_institucion_id']);
        redirect('school');
    }

    // Pagina Principal Institucional (ruta "school"): un solo archivo
    // compartido por los 5 roles institucionales (director, docente,
    // alumno, padre, administrativo). Deliberadamente liviana y de solo
    // lectura — el CRUD completo vive en panel() (ruta "school/panel"),
    // exclusiva de director/docente.
    private function renderMainPage($db, $user) {
        $isReadOnlyView = $user['role'] === 'admin' && $this->adminViewingInstitutionId();
        $instId = $isReadOnlyView ? $this->readInstitutionId() : $this->myInstitutionId();
        $instFilter = $instId ? " WHERE instituciones_id = " . intval($instId) : '';

        $institucion = null;
        if ($instId) {
            $stmtI = $db->prepare("SELECT * FROM instituciones WHERE instituciones_id = ?");
            $stmtI->execute([$instId]);
            $institucion = $stmtI->fetch();
        }

        $drills = $db->query("SELECT * FROM simulacros" . $instFilter . " ORDER BY fecha DESC LIMIT 5")->fetchAll();
        $routes = $db->query("SELECT * FROM rutas_evacuacion" . $instFilter . " ORDER BY created_at DESC LIMIT 20")->fetchAll();

        $croquisPoints = [];
        if ($instId) {
            $stmtP = $db->prepare("SELECT * FROM puntos_croquis WHERE instituciones_id = ? ORDER BY puntos_croquis_id");
            $stmtP->execute([$instId]);
            $croquisPoints = $stmtP->fetchAll();
        }

        $data = [
            'title' => 'Gestión Escolar',
            'user' => $user,
            'institucion' => $institucion,
            'drills' => $drills,
            'routes' => $routes,
            'croquisPoints' => $croquisPoints,
            // Ver EstudianteController::readScopeInstitutionId() y
            // SchoolController::panel(): en modo "ver institucion" del Admin
            // General se fuerza a false para que quede de solo lectura.
            'isSchoolAdmin' => $isReadOnlyView ? false : $this->isSchoolAdmin(),
            'isSchoolStaff' => $isReadOnlyView ? false : $this->isSchoolStaff(),
            'isPanelRole' => $isReadOnlyView ? true : $this->isPanelRole(),
            'isReadOnlyView' => $isReadOnlyView,
            'panelTitle' => $isReadOnlyView ? ('Gestión Escolar — ' . ($institucion['nombre'] ?? '')) : 'Gestión Escolar',
            'panelSubtitle' => $isReadOnlyView
                ? 'Estás viendo esta institución como Admin General — modo solo lectura.'
                : 'Información de seguridad, noticias y comunidad de tu institución',
        ];

        view('school/main', $data);
    }

    // Panel de Gestion (ruta "school/panel"): director (completo), docente
    // (reducido), o el Admin General "viendo" una institucion en modo solo
    // lectura (ver viewInstitution() arriba).
    public function panel() {
        if (!isLoggedIn()) {
            redirect('login');
            return;
        }
        $viewingInstId = $this->adminViewingInstitutionId();
        if (!$this->canAccessSchool() || (!$this->isPanelRole() && !$viewingInstId)) {
            redirect('school');
            return;
        }

        $db = getDB();
        $user = currentUser();
        $isReadOnlyView = $user['role'] === 'admin' && $viewingInstId;
        $instId = $this->readInstitutionId();
        $instFilter = $instId ? " WHERE instituciones_id = " . intval($instId) : '';
        $instFilterAlias = $instId ? " WHERE a.instituciones_id = " . intval($instId) : '';

        $stats = [
            'students' => $db->query("SELECT COUNT(*) as total FROM estudiantes e JOIN aulas a ON e.aulas_id=a.aulas_id" . $instFilterAlias)->fetch()['total'] ?? 0,
            'teachers' => $db->query("SELECT COUNT(*) as total FROM usuarios WHERE (role='docente' OR role='admin' OR role='director')" . ($instId ? " AND institucion_id=" . intval($instId) : ''))->fetch()['total'] ?? 0,
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
            . ($instId ? " WHERE a.instituciones_id = " . intval($instId) : '') .
            " ORDER BY e.created_at DESC LIMIT 10";
        $students = $db->query($studentsQ)->fetchAll();

        $drills = $db->query("SELECT * FROM simulacros" . $instFilter . " ORDER BY fecha DESC LIMIT 5")->fetchAll();
        $routes = $db->query("SELECT * FROM rutas_evacuacion" . $instFilter . " ORDER BY created_at DESC LIMIT 5")->fetchAll();

        $incidentsQ = "SELECT i.*, u.nombre as reporter FROM incidentes i LEFT JOIN usuarios u ON i.usuario_id = u.usuarios_id"
            . ($instId ? " WHERE i.instituciones_id = " . intval($instId) : '')
            . " ORDER BY i.created_at DESC LIMIT 5";
        $incidents = $db->query($incidentsQ)->fetchAll();

        $pendingRequestsCount = 0;
        if (!$isReadOnlyView && $this->isSchoolAdmin() && $instId) {
            $stmtPR = $db->prepare("SELECT COUNT(*) as total FROM solicitudes_institucion WHERE instituciones_id = ? AND estado = 'pendiente'");
            $stmtPR->execute([$instId]);
            $pendingRequestsCount = $stmtPR->fetch()['total'] ?? 0;
        }

        $panel = ($user['role'] === 'director' || $isReadOnlyView) ? 'panel-director' : 'panel-docente';
        $subtitles = [
            'panel-director' => 'Administra estudiantes, docentes, rutas de evacuación, simulacros y más',
            'panel-docente'  => 'Tus secciones, pase de lista, notificaciones y croquis',
        ];

        $institucionNombre = null;
        if ($isReadOnlyView && $instId) {
            $stmtN = $db->prepare("SELECT nombre FROM instituciones WHERE instituciones_id = ?");
            $stmtN->execute([$instId]);
            $institucionNombre = $stmtN->fetchColumn() ?: null;
        }

        $data = [
            'title' => 'Panel de Gestión',
            'user' => $user,
            'stats' => $stats,
            'students' => $students,
            'drills' => $drills,
            'routes' => $routes,
            'incidents' => $incidents,
            // En modo "ver institucion" del Admin General se fuerzan a false
            // sin importar lo que devuelvan isSchoolAdmin()/isSchoolStaff()
            // (que si son true para el rol admin): asi todos los botones de
            // crear/editar/borrar de las pestañas quedan ocultos y la vista
            // queda estrictamente de solo lectura.
            'isSchoolAdmin' => $isReadOnlyView ? false : $this->isSchoolAdmin(),
            'isSchoolStaff' => $isReadOnlyView ? false : $this->isSchoolStaff(),
            'isReadOnlyView' => $isReadOnlyView,
            'viewingInstitucionNombre' => $institucionNombre,
            'pendingRequestsCount' => $pendingRequestsCount,
            'panelTitle' => $isReadOnlyView ? 'Panel de Gestión (solo lectura)' : 'Panel de Gestión',
            'panelSubtitle' => $isReadOnlyView
                ? 'Estás viendo el panel de ' . ($institucionNombre ?? 'esta institución') . ' como Admin General — modo solo lectura.'
                : $subtitles[$panel],
        ];

        view('school/' . $panel, $data);
    }

    // Admin General: gestiona toda la plataforma (no una institucion
    // especifica), sin cambios respecto a lo que ya existia.
    private function renderAdminGeneral($db, $user) {
        $stats = [
            'students' => $db->query("SELECT COUNT(*) as total FROM estudiantes")->fetch()['total'] ?? 0,
            'teachers' => $db->query("SELECT COUNT(*) as total FROM usuarios WHERE (role='docente' OR role='admin' OR role='director')")->fetch()['total'] ?? 0,
            'classrooms' => $db->query("SELECT COUNT(*) as total FROM aulas")->fetch()['total'] ?? 0,
            'routes' => $db->query("SELECT COUNT(*) as total FROM rutas_evacuacion")->fetch()['total'] ?? 0,
            'drills' => $db->query("SELECT COUNT(*) as total FROM simulacros")->fetch()['total'] ?? 0,
            'incidents' => $db->query("SELECT COUNT(*) as total FROM incidentes WHERE estado='abierto'")->fetch()['total'] ?? 0,
        ];

        $students = $db->query("
            SELECT e.*, a.nombre as classroom, u.nombre as teacher
            FROM estudiantes e
            LEFT JOIN aulas a ON e.aulas_id = a.aulas_id
            LEFT JOIN usuarios u ON a.maestro_id = u.usuarios_id
            ORDER BY e.created_at DESC LIMIT 10
        ")->fetchAll();
        $drills = $db->query("SELECT * FROM simulacros ORDER BY fecha DESC LIMIT 5")->fetchAll();
        $routes = $db->query("SELECT * FROM rutas_evacuacion ORDER BY created_at DESC LIMIT 5")->fetchAll();
        $incidents = $db->query("SELECT i.*, u.nombre as reporter FROM incidentes i LEFT JOIN usuarios u ON i.usuario_id = u.usuarios_id ORDER BY i.created_at DESC LIMIT 5")->fetchAll();

        $pendingRequestsCount = 0;

        $data = [
            'title' => 'Panel de Administración General',
            'user' => $user,
            'stats' => $stats,
            'students' => $students,
            'drills' => $drills,
            'routes' => $routes,
            'incidents' => $incidents,
            'isSchoolAdmin' => true,
            'isSchoolStaff' => true,
            'pendingRequestsCount' => $pendingRequestsCount,
            'panelTitle' => 'Panel de Administración General',
            'panelSubtitle' => 'Panel global: instituciones y estadísticas de todo el sistema',
        ];

        view('school/panels/admin-general', $data);
    }

    // ============================================================
    //  PAGINAS DE DETALLE (Noticias / Lugares en riesgo / Incidentes)
    //  Reemplazan al modal de "leer mas": cada una es una pagina HTML
    //  completa (no JSON), con "Me gusta" y comentarios propios via
    //  InteraccionController.
    // ============================================================

    // Corta la ejecucion (redirect) si el usuario no puede ver esta fila:
    // debe ser admin, o la fila debe pertenecer a su institucion, o (para
    // noticias) ser un comunicado global (instituciones_id NULL).
    private function ensureCanViewContenido($row, $instColumn = 'instituciones_id') {
        $u = currentUser();
        $contenidoInstId = $row[$instColumn] ?? null;
        $esGlobal = $contenidoInstId === null;
        if ($u['role'] !== 'admin' && !$esGlobal && (int) $contenidoInstId !== (int) $u['institucion_id']) {
            redirect('school');
            exit;
        }
    }

    public function newsDetail() {
        if (!isLoggedIn()) { redirect('login'); return; }
        if (!$this->canAccessSchool()) { redirect('profile'); return; }

        $id = $_GET['id'] ?? null;
        if (!$id) { redirect('school'); return; }

        $db = getDB();
        $stmt = $db->prepare("
            SELECT n.*, u.nombre as autor, i.nombre as institucion_nombre
            FROM noticias_internas n
            LEFT JOIN usuarios u ON u.usuarios_id = n.usuarios_id
            LEFT JOIN instituciones i ON i.instituciones_id = n.instituciones_id
            WHERE n.noticias_internas_id = ?
        ");
        $stmt->execute([$id]);
        $item = $stmt->fetch();
        if (!$item) { redirect('school'); return; }
        $this->ensureCanViewContenido($item);

        view('school/detail', [
            'title' => $item['titulo'] . ' · NDA',
            'user' => currentUser(),
            'tipoContenido' => 'noticia',
            'contenidoId' => $item['noticias_internas_id'],
            'backAnchor' => 'tab-news',
            'item' => $item,
            'isSchoolAdmin' => $this->isSchoolAdmin(),
        ]);
    }

    public function riesgoDetail() {
        if (!isLoggedIn()) { redirect('login'); return; }
        if (!$this->canAccessSchool()) { redirect('profile'); return; }

        $id = $_GET['id'] ?? null;
        if (!$id) { redirect('school'); return; }

        $db = getDB();
        $stmt = $db->prepare("
            SELECT b.*, u.nombre as autor, u.role as autor_role
            FROM blog_riesgos b
            JOIN usuarios u ON u.usuarios_id = b.usuarios_id
            WHERE b.blog_riesgos_id = ?
        ");
        $stmt->execute([$id]);
        $item = $stmt->fetch();
        if (!$item) { redirect('school'); return; }
        $this->ensureCanViewContenido($item);

        view('school/detail', [
            'title' => $item['titulo'] . ' · NDA',
            'user' => currentUser(),
            'tipoContenido' => 'riesgo',
            'contenidoId' => $item['blog_riesgos_id'],
            'backAnchor' => 'tab-blog',
            'item' => $item,
            'isSchoolAdmin' => $this->isSchoolAdmin(),
        ]);
    }

    public function incidentDetail() {
        if (!isLoggedIn()) { redirect('login'); return; }
        if (!$this->canAccessSchool()) { redirect('profile'); return; }

        $id = $_GET['id'] ?? null;
        if (!$id) { redirect('school'); return; }

        $db = getDB();
        $stmt = $db->prepare("
            SELECT i.*, u.nombre as reporter
            FROM incidentes i
            LEFT JOIN usuarios u ON u.usuarios_id = i.usuario_id
            WHERE i.incidentes_id = ?
        ");
        $stmt->execute([$id]);
        $item = $stmt->fetch();
        if (!$item) { redirect('school'); return; }
        $this->ensureCanViewContenido($item);

        view('school/detail', [
            'title' => $item['tipo'] . ' · NDA',
            'user' => currentUser(),
            'tipoContenido' => 'incidente',
            'contenidoId' => $item['incidentes_id'],
            'backAnchor' => 'tab-incidents',
            'item' => $item,
            'isSchoolAdmin' => $this->isSchoolAdmin(),
        ]);
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
        $readInstId = $this->readInstitutionId();
        $sql = "
            SELECT r.*, i.nombre as institution
            FROM rutas_evacuacion r
            LEFT JOIN instituciones i ON r.instituciones_id = i.instituciones_id
        ";
        $params = [];
        if ($readInstId) {
            $sql .= " WHERE r.instituciones_id = ?";
            $params[] = $readInstId;
        }
        $sql .= " ORDER BY r.nombre";
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        jsonResponse($stmt->fetchAll());
    }

    public function addRoute() {
        // Solo admin/director gestionan rutas; el docente las ve en solo
        // lectura (antes usaba isSchoolStaff(), que tambien incluia a docente).
        if (!isLoggedIn() || !$this->isSchoolAdmin()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $nombre = trim($input['nombre'] ?? '');
        $descripcion = trim($input['descripcion'] ?? '');
        $institucion_id = $input['institucion_id'] ?? $this->myInstitutionId();
        $estado = $input['estado'] ?? 'despejada';
        $lat = isset($input['lat']) && $input['lat'] !== '' ? (float) $input['lat'] : null;
        $lng = isset($input['lng']) && $input['lng'] !== '' ? (float) $input['lng'] : null;

        if (empty($nombre)) {
            jsonResponse(['error' => 'El nombre de la ruta es obligatorio'], 400);
        }

        $db = getDB();
        $stmt = $db->prepare("
            INSERT INTO rutas_evacuacion (nombre, descripcion, instituciones_id, estado, lat, lng)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$nombre, $descripcion, $institucion_id, $estado, $lat, $lng]);

        jsonResponse(['success' => true, 'id' => $db->lastInsertId()]);
    }

    public function updateRoute() {
        if (!isLoggedIn() || !$this->isSchoolAdmin()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['id'] ?? null;

        if (!$id) {
            jsonResponse(['error' => 'ID de ruta requerido'], 400);
        }

        $lat = isset($input['lat']) && $input['lat'] !== '' ? (float) $input['lat'] : null;
        $lng = isset($input['lng']) && $input['lng'] !== '' ? (float) $input['lng'] : null;

        $db = getDB();
        $stmt = $db->prepare("
            UPDATE rutas_evacuacion
            SET nombre = ?, descripcion = ?, estado = ?, lat = ?, lng = ?
            WHERE rutas_evacuacion_id = ?
        ");
        $stmt->execute([
            $input['nombre'] ?? '',
            $input['descripcion'] ?? '',
            $input['estado'] ?? 'despejada',
            $lat,
            $lng,
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
        $readInstId = $this->readInstitutionId();
        $sql = "
            SELECT i.*, u.nombre as reporter
            FROM incidentes i
            LEFT JOIN usuarios u ON i.usuario_id = u.usuarios_id
        ";
        $params = [];
        if ($readInstId) {
            $sql .= " WHERE i.instituciones_id = ?";
            $params[] = $readInstId;
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
            INSERT INTO incidentes (tipo, descripcion, ubicacion, imagen, usuario_id, instituciones_id, prioridad)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$tipo, $descripcion, $ubicacion, $imagen, $user_id, $institucion_id, $prioridad]);

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

    public function resolveIncident() {
        if (!isLoggedIn() || !$this->isSchoolStaff()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            jsonResponse(['error' => 'ID de incidente requerido'], 400);
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
        if (!isLoggedIn()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['id'] ?? null;
        if (!$id) {
            jsonResponse(['error' => 'ID de incidente requerido'], 400);
        }

        $db = getDB();

        // Staff (admin/director/docente) puede editar cualquier incidente de su
        // institucion; cualquier otro usuario (ej. personal administrativo,
        // padre, alumno) solo puede editar el que el mismo reporto.
        if (!$this->isSchoolStaff()) {
            $u = currentUser();
            $stmtOwner = $db->prepare("SELECT usuario_id FROM incidentes WHERE incidentes_id = ?");
            $stmtOwner->execute([$id]);
            $incidente = $stmtOwner->fetch();
            if (!$incidente || (int) $incidente['usuario_id'] !== (int) $u['id']) {
                jsonResponse(['error' => 'No autorizado'], 401);
            }
        }

        $stmt = $db->prepare("
            UPDATE incidentes SET tipo = ?, descripcion = ?, ubicacion = ?, prioridad = ?
            WHERE incidentes_id = ?
        ");
        $stmt->execute([
            trim($input['tipo'] ?? ''),
            trim($input['descripcion'] ?? ''),
            trim($input['ubicacion'] ?? ''),
            $input['prioridad'] ?? 'media',
            $id
        ]);

        jsonResponse(['success' => true]);
    }

    public function deleteIncident() {
        if (!isLoggedIn()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $id = $_GET['id'] ?? null;
        if (!$id) {
            jsonResponse(['error' => 'ID de incidente requerido'], 400);
        }
        $db = getDB();

        // Igual que en updateIncident(): admin/director borran cualquiera de su
        // institucion, el resto solo el propio.
        if (!$this->isSchoolAdmin()) {
            $u = currentUser();
            $stmtOwner = $db->prepare("SELECT usuario_id FROM incidentes WHERE incidentes_id = ?");
            $stmtOwner->execute([$id]);
            $incidente = $stmtOwner->fetch();
            if (!$incidente || (int) $incidente['usuario_id'] !== (int) $u['id']) {
                jsonResponse(['error' => 'No autorizado'], 401);
            }
        }

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
        $instId = $this->readInstitutionId();
        if (!$instId) jsonResponse(['imagen' => null, 'puntos' => [], 'lat' => null, 'lng' => null]);

        $db = getDB();
        $stmt = $db->prepare("SELECT imagen FROM croquis_institucion WHERE instituciones_id = ?");
        $stmt->execute([$instId]);
        $croquis = $stmt->fetch();

        $stmtP = $db->prepare("SELECT * FROM puntos_croquis WHERE instituciones_id = ? ORDER BY puntos_croquis_id");
        $stmtP->execute([$instId]);

        $stmtI = $db->prepare("SELECT lat, lng FROM instituciones WHERE instituciones_id = ?");
        $stmtI->execute([$instId]);
        $inst = $stmtI->fetch();

        jsonResponse([
            'imagen' => $croquis['imagen'] ?? null,
            'puntos' => $stmtP->fetchAll(),
            'lat' => $inst['lat'] ?? null,
            'lng' => $inst['lng'] ?? null,
        ]);
    }

    // Fija (o corrige) las coordenadas reales de la institucion, usadas para
    // anclar el croquis sobre el mapa real (MapLibre) en la pestaña Croquis.
    public function updateInstitutionLocation() {
        if (!isLoggedIn() || !$this->isSchoolAdmin()) {
            jsonResponse(['error' => 'No autorizado'], 401);
        }
        $instId = $this->myInstitutionId();
        if (!$instId) jsonResponse(['error' => 'No tienes una institución asociada'], 400);

        $input = json_decode(file_get_contents('php://input'), true);
        $lat = isset($input['lat']) ? (float) $input['lat'] : null;
        $lng = isset($input['lng']) ? (float) $input['lng'] : null;
        if ($lat === null || $lng === null) {
            jsonResponse(['error' => 'Coordenadas requeridas'], 400);
        }

        $db = getDB();
        $db->prepare("UPDATE instituciones SET lat = ?, lng = ? WHERE instituciones_id = ?")
           ->execute([$lat, $lng, $instId]);

        jsonResponse(['success' => true]);
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
        $instId = $this->readInstitutionId();
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
        if (!isLoggedIn() || !$this->canAccessSchool()) {
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