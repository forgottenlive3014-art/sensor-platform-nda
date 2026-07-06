<?php
session_start();

// Todo el request queda "amortiguado": si algun warning/notice de PHP se
// imprime antes de tiempo (comun en XAMPP/WAMP con display_errors activo),
// jsonResponse() lo puede descartar antes de mandar el JSON limpio. Sin
// esto, un solo warning rompe TODAS las respuestas AJAX del sitio (asi se
// ve como si el modulo escolar "no cargara nada" aunque el HTML si se vea).
ob_start();

require_once 'config.php';

// Evita que el navegador sirva paginas privadas desde la cache
// (bfcache) despues de cerrar sesion al presionar "Atras".
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");


// FUNCIONES AUXILIARES


function ndaErrorPage($title, $message) {
    echo '<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8">'
       . '<title>' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '</title>'
       . '<style>body{background:#021526;color:#f6f4ef;font-family:sans-serif;'
       . 'display:flex;align-items:center;justify-content:center;height:100vh;margin:0;text-align:center;padding:20px}'
       . 'a{color:#c98a3d}</style></head><body><div>'
       . '<h1 style="font-size:1.4rem">' . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . '</h1>'
       . '<p>Intenta de nuevo en unos minutos, o <a href="?url=home">vuelve al inicio</a>.</p>'
       . '</div></body></html>';
    exit;
}

function view($name, $data = []) {
    extract($data);
    $file = "views/$name.php";
    if (file_exists($file)) {
        require_once $file;
    } else {
        // Antes: die("View not found: $name") — un error crudo sin estilo,
        // que en producción se ve exactamente como una "pantalla en blanco
        // rota". Se mantiene el codigo 500 (es un error real de servidor,
        // no un 404 de ruta), pero con una pagina legible en vez de texto
        // plano.
        http_response_code(500);
        ndaErrorPage('NDA — No disponible', 'Esta sección no está disponible ahora mismo.');
    }
}

function redirect($url) {
    header("Location: ?url=$url");
    exit;
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Devuelve un array con los datos de sesion del usuario actual.
// El rol y el estado institucional se refrescan desde la base de datos
// en cada request (una sola consulta, cacheada durante el request) para
// que una aprobacion/rechazo del director surta efecto de inmediato sin
// que el usuario tenga que cerrar sesion y volver a entrar.
function currentUser() {
    if (!isLoggedIn()) return null;

    static $fresh = null;
    if ($fresh === null) {
        $fresh = [
            'role'                 => $_SESSION['user_role'] ?? 'user',
            'institucion_id'       => $_SESSION['institucion_id'] ?? null,
            'institucion_nombre'   => $_SESSION['institucion_nombre'] ?? null,
            'estado_institucional' => $_SESSION['estado_institucional'] ?? 'ninguno',
        ];
        try {
            $db = getDB();
            $stmt = $db->prepare("
                SELECT u.role, u.institucion_id, u.estado_institucional, i.nombre AS institucion_nombre
                FROM usuarios u
                LEFT JOIN instituciones i ON i.instituciones_id = u.institucion_id
                WHERE u.usuarios_id = ?
            ");
            $stmt->execute([$_SESSION['user_id']]);
            $row = $stmt->fetch();
            if ($row) {
                $fresh = $row;
                // Mantiene la sesion sincronizada para el resto de la peticion.
                $_SESSION['user_role'] = $row['role'];
                $_SESSION['institucion_id'] = $row['institucion_id'];
                $_SESSION['institucion_nombre'] = $row['institucion_nombre'];
                $_SESSION['estado_institucional'] = $row['estado_institucional'];
            } else {
                // El usuario de esta sesion ya no existe en la BD (p. ej. se
                // reimporto la base de datos). Cerramos sesion para evitar
                // que cualquier pagina truene con "array offset on false".
                $_SESSION = [];
                session_destroy();
                if (!headers_sent()) {
                    redirect('login');
                }
                return null;
            }
        } catch (Exception $e) {
            // Si la BD no responde, seguimos con lo que ya habia en sesion.
        }
    }

    return [
        'id'                    => $_SESSION['user_id'],
        'nombre'                => $_SESSION['user_name'] ?? '',
        'email'                 => $_SESSION['user_email'] ?? '',
        'role'                  => $fresh['role'],
        'institucion_id'        => $fresh['institucion_id'],
        'institucion_nombre'    => $fresh['institucion_nombre'],
        'estado_institucional'  => $fresh['estado_institucional'],
    ];
}

// Roles que pertenecen al personal/comunidad de una institucion
function institutionalRoles() {
    return ['director', 'docente', 'alumno', 'padre', 'administrativo'];
}

// True si el usuario ya pertenece de forma aprobada a una institucion
function hasApprovedInstitution() {
    $u = currentUser();
    return $u && $u['institucion_id'] && $u['estado_institucional'] === 'aprobado';
}

function e($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function jsonResponse($data, $code = 200) {
    // Descarta cualquier salida acumulada (warnings, notices, espacios en
    // blanco antes de "<?php", etc.) para que el JSON llegue limpio al
    // fetch() del navegador — un solo caracter de mas rompe el parseo.
    if (ob_get_level() > 0) {
        ob_clean();
    }
    http_response_code($code);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

function asset($path) {
    return 'assets/' . ltrim($path, '/');
}


// ENRUTAMIENTO


$url = isset($_GET['url']) ? $_GET['url'] : 'home';
$url = rtrim($url, '/');
$parts = explode('/', $url);

// Cualquier segmento despues de "controlador/accion" se pasa como
// argumento posicional extra al metodo del controlador.
$params = array_slice($parts, 2);

$routeMap = [
    'home'       => ['MainController', 'home'],
    'login'      => ['AuthController', 'login'],
    'register'   => ['AuthController', 'register'],
    'logout'     => ['AuthController', 'logout'],
    'profile'          => ['AuthController', 'profile'],
    'profile/update'   => ['AuthController', 'updateProfile'],
    'profile/join'     => ['AuthController', 'requestJoinInstitution'],
    'profile/cancel-join' => ['AuthController', 'cancelJoinRequest'],
    'institutions-list'   => ['AuthController', 'institutionsList'],
    'chat-api'   => ['ChatController', 'send'],
    'sensor/ingest' => ['SensorController', 'ingest'],
    'sensor/latest' => ['SensorController', 'latest'],
    'notifications/latest' => ['NotificationController', 'latest'],
    'notifications/mark-read' => ['NotificationController', 'markRead'],
    'notifications/inbox' => ['NotificationController', 'inbox'],
    'earthquakes'=> ['MainController', 'earthquakes'],
    'resources'   => ['MainController', 'recursos'],
    'quehacer'    => ['MainController', 'quehacer'],
    'blog'        => ['MainController', 'blog'],
    'juegos'      => ['MainController', 'juegos'],
    'Acercade'    => ['MainController', 'acercaDe'],
    // ============================================================
    'school'                    => ['SchoolController', 'index'],

    // Alumnos (CRUD real)
    'school/students'            => ['StudentController', 'list'],
    'school/add-student'         => ['StudentController', 'create'],
    'school/update-student'      => ['StudentController', 'update'],
    'school/delete-student'      => ['StudentController', 'delete'],
    'school/my-classroom'        => ['StudentController', 'myClassroom'],

    // Docentes (CRUD real)
    'school/teachers'            => ['TeacherController', 'list'],
    'school/add-teacher'         => ['TeacherController', 'create'],
    'school/delete-teacher'      => ['TeacherController', 'delete'],
    'school/update-teacher'      => ['TeacherController', 'update'],
    'school/upload-teacher-photo'=> ['TeacherController', 'uploadPhoto'],
    'school/assignable-teachers'=> ['TeacherController', 'assignable'],

    // Aulas (CRUD real)
    'school/classrooms'          => ['ClassroomController', 'list'],
    'school/add-classroom'       => ['ClassroomController', 'create'],
    'school/delete-classroom'    => ['ClassroomController', 'delete'],
    'school/update-classroom'    => ['ClassroomController', 'update'],

    // Rutas
    'school/routes'             => ['SchoolController', 'getRoutes'],
    'school/add-route'          => ['SchoolController', 'addRoute'],
    'school/update-route'       => ['SchoolController', 'updateRoute'],
    'school/delete-route'       => ['SchoolController', 'deleteRoute'],

    // Asistencia (CRUD real)
    'school/attendance'           => ['AttendanceController', 'get'],
    'school/save-attendance'      => ['AttendanceController', 'save'],
    'school/my-attendance'        => ['AttendanceController', 'myAttendance'],

    // Incidentes
    'school/incidents'          => ['SchoolController', 'getIncidents'],
    'school/add-incident'       => ['SchoolController', 'addIncident'],
    'school/resolve-incident'   => ['SchoolController', 'resolveIncident'],
    'school/update-incident'    => ['SchoolController', 'updateIncident'],
    'school/delete-incident'    => ['SchoolController', 'deleteIncident'],

    // Simulacros (CRUD real)
    'school/drills'               => ['DrillController', 'list'],
    'school/add-drill'            => ['DrillController', 'create'],
    'school/update-drill'         => ['DrillController', 'update'],
    'school/delete-drill'         => ['DrillController', 'delete'],

    // Reportes
    'school/reports'              => ['ReportController', 'get'],

    // Instituciones (CRUD real, solo Admin General)
    'school/institutions'        => ['InstitutionController', 'list'],
    'school/add-institution'     => ['InstitutionController', 'create'],
    'school/update-institution'  => ['InstitutionController', 'update'],
    'school/delete-institution'  => ['InstitutionController', 'delete'],

    // Usuarios y roles (CRUD real, Admin General y Admin Institucional)
    'school/users'         => ['UserController', 'list'],
    'school/add-user'      => ['UserController', 'create'],
    'school/update-user'   => ['UserController', 'update'],
    'school/delete-user'   => ['UserController', 'delete'],

    // Noticias internas (CRUD real)
    'school/news'          => ['NewsController', 'list'],
    'school/add-news'      => ['NewsController', 'create'],
    'school/update-news'   => ['NewsController', 'update'],
    'school/delete-news'   => ['NewsController', 'delete'],

    // Padres (CRUD real + vínculo con hijos)
    'school/parents'              => ['ParentController', 'list'],
    'school/add-parent'           => ['ParentController', 'create'],
    'school/update-parent'        => ['ParentController', 'update'],
    'school/delete-parent'        => ['ParentController', 'delete'],
    'school/link-child'           => ['ParentController', 'linkChild'],
    'school/unlink-child'         => ['ParentController', 'unlinkChild'],
    'school/parent-children-links'=> ['ParentController', 'myChildrenLinks'],
    'school/my-children'          => ['ParentController', 'myChildren'],
    'school/my-children-status'   => ['ParentController', 'myChildrenDrillStatus'],

    // Personal administrativo (CRUD real)
    'school/staff'          => ['StaffController', 'list'],
    'school/add-staff'      => ['StaffController', 'create'],
    'school/update-staff'   => ['StaffController', 'update'],
    'school/delete-staff'   => ['StaffController', 'delete'],

    // Blog de lugares en riesgo (Docente/Alumno/Personal/Director/Admin)
    'school/blog'          => ['BlogController', 'list'],
    'school/add-blog'      => ['BlogController', 'create'],
    'school/delete-blog'   => ['BlogController', 'delete'],

    // Notificaciones (gestión: Admin Institucional / Admin General)
    'school/notifications'        => ['NotificationController', 'manageList'],
    'school/send-notification'    => ['NotificationController', 'send'],
    'school/delete-notification'  => ['NotificationController', 'delete'],

    // Solicitudes de ingreso (aprobacion del director)
    'school/join-requests'      => ['SchoolController', 'getJoinRequests'],
    'school/approve-request'    => ['SchoolController', 'approveJoinRequest'],
    'school/reject-request'     => ['SchoolController', 'rejectJoinRequest'],

    // Secciones (18 aulas de bachillerato) — CRUD real
    'school/sections'            => ['SectionController', 'list'],
    'school/assign-teacher'      => ['SectionController', 'assignTeacher'],

    // Croquis interactivo
    'school/croquis'            => ['SchoolController', 'getCroquis'],
    'school/croquis-upload'     => ['SchoolController', 'uploadCroquisImage'],
    'school/croquis-add-point'  => ['SchoolController', 'addCroquisPoint'],
    'school/croquis-del-point'  => ['SchoolController', 'deleteCroquisPoint'],

    // Tablero de corcho
    'school/board'              => ['SchoolController', 'getBoardNotes'],
    'school/board-add'          => ['SchoolController', 'addBoardNote'],
    'school/board-move'         => ['SchoolController', 'moveBoardNote'],
    'school/board-delete'       => ['SchoolController', 'deleteBoardNote'],

    // Alerta de simulacro en vivo
    'school/activate-alert'      => ['DrillController', 'activate'],
    'school/finish-alert'        => ['DrillController', 'finish'],
    'school/active-alert'        => ['DrillController', 'activeAlert'],
];

// El routeMap indexa por la ruta COMPLETA (ej. 'school/add-student',
// 'profile/update'), no solo por el primer segmento. Antes se buscaba
// con $controller (= $parts[0]), asi que CUALQUIER ruta de mas de un
// segmento (practicamente todo el sitio: school/*, profile/update,
// notifications/*, etc.) siempre caia en la entrada de un solo
// segmento que coincidiera (o en el 404) sin importar el resto de la
// URL — ej. 'school/add-student' terminaba ejecutando
// SchoolController::index() en vez de SchoolController::addStudent().
if (isset($routeMap[$url])) {
    list($className, $method) = $routeMap[$url];
} else {
    http_response_code(404);
    echo "<h1>404 - Page not found</h1>";
    exit;
}

$file = "controllers/$className.php";
if (file_exists($file)) {
    require_once $file;
    $obj = new $className();
    if (method_exists($obj, $method)) {
        try {
            call_user_func_array([$obj, $method], $params);
        } catch (Throwable $e) {
            // Antes de esto, una excepcion no capturada (ej. una consulta SQL
            // que falla) terminaba en una pagina en blanco o en un error crudo
            // de PHP, sin ningun mensaje util — exactamente el sintoma de
            // "aparece pero no se puede editar nada". Ahora se registra el
            // detalle real en el log del servidor, y el usuario recibe una
            // respuesta legible segun el tipo de ruta.
            error_log('[NDA] Excepcion no capturada en ' . $className . '::' . $method . '() — ' . $e->getMessage());

            if (ob_get_level() > 0) { ob_clean(); }
            http_response_code(500);

            // Las acciones del modulo escolar, sensor, chat y notificaciones
            // son todas AJAX (esperan JSON) salvo la carga inicial de 'school'.
            $isJsonRoute = !(
                $className === 'MainController' ||
                ($className === 'AuthController' && $method !== 'institutionsList') ||
                ($className === 'SchoolController' && $method === 'index')
            );

            if ($isJsonRoute) {
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Ocurrió un error interno al procesar la solicitud. Intenta de nuevo en unos segundos.']);
                exit;
            } else {
                ndaErrorPage('NDA — Error', 'Ocurrió un error al cargar esta sección.');
            }
        }
    } else {
        echo "Error: Method $method not found in $className";
    }
} else {
    echo "Error: Controller $className not found";
}
?>