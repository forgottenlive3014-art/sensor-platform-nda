<?php
// Cookie de sesion endurecida: HttpOnly (no accesible desde JS, mitiga robo
// de sesion via XSS), SameSite=Lax (no se envia en requests cross-site, mitiga
// CSRF) y Secure solo si la conexion ya es HTTPS (en HTTP local del dev no se
// puede exigir Secure o el navegador descartaria la cookie).
$__ndaIsHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (($_SERVER['SERVER_PORT'] ?? '') == 443);
session_set_cookie_params([
    'lifetime' => 0,
    'path'     => '/',
    'domain'   => '',
    'secure'   => $__ndaIsHttps,
    'httponly' => true,
    'samesite' => 'Lax',
]);
session_start();

// Cierra la sesion sola tras 2 horas sin actividad (cada request logueado
// renueva el contador), para no dejar sesiones abiertas indefinidamente en
// equipos compartidos. No afecta a visitantes anonimos.
const NDA_SESSION_INACTIVITY_LIMIT = 7200; // 2 horas
if (isset($_SESSION['user_id'])) {
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > NDA_SESSION_INACTIVITY_LIMIT) {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();
        session_start();
        $_SESSION['error'] = 'Tu sesión se cerró por inactividad. Inicia sesión de nuevo.';
    }
    $_SESSION['last_activity'] = time();
}

// Amortigua warnings/notices de PHP para que jsonResponse() siempre mande JSON limpio.
ob_start();

require_once 'config.php';

// Evita que el navegador sirva paginas privadas desde la cache (bfcache) tras cerrar sesion.
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

// Rol y estado institucional se refrescan desde la BD en cada request para que una
// aprobacion/rechazo del director surta efecto sin cerrar sesion.
function currentUser() {
    if (!isLoggedIn()) return null;

    static $fresh = null;
    if ($fresh === null) {
        $fresh = [
            'role'                 => $_SESSION['user_role'] ?? 'user',
            'institucion_id'       => $_SESSION['institucion_id'] ?? null,
            'institucion_nombre'   => $_SESSION['institucion_nombre'] ?? null,
            'estado_institucional' => $_SESSION['estado_institucional'] ?? 'ninguno',
            'foto_perfil'          => $_SESSION['foto_perfil'] ?? null,
        ];
        try {
            $db = getDB();
            $stmt = $db->prepare("
                SELECT u.role, u.institucion_id, u.estado_institucional, u.foto_perfil, i.nombre AS institucion_nombre
                FROM usuarios u
                LEFT JOIN instituciones i ON i.instituciones_id = u.institucion_id
                WHERE u.usuarios_id = ?
            ");
            $stmt->execute([$_SESSION['user_id']]);
            $row = $stmt->fetch();
            if ($row) {
                $fresh = $row;
                $_SESSION['user_role'] = $row['role'];
                $_SESSION['institucion_id'] = $row['institucion_id'];
                $_SESSION['institucion_nombre'] = $row['institucion_nombre'];
                $_SESSION['estado_institucional'] = $row['estado_institucional'];
                $_SESSION['foto_perfil'] = $row['foto_perfil'];
            } else {
                // Usuario ya no existe en la BD: cerramos sesion para evitar errores.
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
        'foto_perfil'           => $fresh['foto_perfil'] ?? null,
    ];
}

function institutionalRoles() {
    return ['director', 'docente', 'alumno', 'padre', 'administrativo'];
}

function hasApprovedInstitution() {
    $u = currentUser();
    return $u && $u['institucion_id'] && $u['estado_institucional'] === 'aprobado';
}

function e($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function jsonResponse($data, $code = 200) {
    // Descarta cualquier salida acumulada para que el JSON llegue limpio al fetch().
    if (ob_get_level() > 0) {
        ob_clean();
    }
    http_response_code($code);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

// Agrega ?v=<fecha de modificacion> para que el navegador jamas sirva una
// copia vieja en cache de un CSS/JS despues de un deploy (sin esto, algunos
// navegadores ignoran el refresco forzado en archivos ya cacheados).
function asset($path) {
    $rel = 'assets/' . ltrim($path, '/');
    $full = __DIR__ . '/' . $rel;
    $v = file_exists($full) ? filemtime($full) : time();
    return $rel . '?v=' . $v;
}


// ENRUTAMIENTO


$url = isset($_GET['url']) ? $_GET['url'] : 'home';
$url = rtrim($url, '/');
$parts = explode('/', $url);

// Segmentos extra despues de "controlador/accion" se pasan como argumentos al metodo.
$params = array_slice($parts, 2);

$routeMap = [
    'home'       => ['MainController', 'home'],
    'login'      => ['AuthController', 'login'],
    'google-login' => ['AuthController', 'googleLogin'],
    'register'   => ['AuthController', 'register'],
    'register/verify'       => ['AuthController', 'verifyEmail'],
    'register/resend-code'  => ['AuthController', 'resendVerificationCode'],
    'register/verify-account'      => ['AuthController', 'verifyAccountEmail'],
    'register/resend-account-code' => ['AuthController', 'resendAccountVerificationCode'],
    'logout'     => ['AuthController', 'logout'],
    'profile'          => ['AuthController', 'profile'],
    'profile/update'   => ['AuthController', 'updateProfile'],
    'profile/join'     => ['AuthController', 'requestJoinInstitution'],
    'profile/cancel-join' => ['AuthController', 'cancelJoinRequest'],
    'profile/found'    => ['AuthController', 'foundInstitution'],
    'institutions-list'   => ['AuthController', 'institutionsList'],
    'chat-api'   => ['ChatController', 'send'],
    'sensor/ingest' => ['SensorController', 'ingest'],
    'sensor/latest' => ['SensorController', 'latest'],
    'notifications/latest' => ['NotificacionController', 'latest'],
    'notifications/mark-read' => ['NotificacionController', 'markRead'],
    'notifications/inbox' => ['NotificacionController', 'inbox'],
    'earthquakes'=> ['MainController', 'earthquakes'],
    'sismos'      => ['MainController', 'sismos'],
    'galeria-3d'            => ['MainController', 'desastresGaleria'],
    'volcanes'              => ['MainController', 'volcanes'],
    'tsunamis'              => ['MainController', 'tsunamis'],
    'inundaciones'          => ['MainController', 'inundaciones'],
    'deslizamientos'        => ['MainController', 'deslizamientos'],
    'incendios-forestales'  => ['MainController', 'incendiosForestales'],
    'tormentas-tropicales'  => ['MainController', 'tormentasTropicales'],
    'sequias'               => ['MainController', 'sequias'],
    'monitoreo'   => ['MainController', 'monitoreo'],
    'clima'       => ['MainController', 'clima'],
    'luna'        => ['MainController', 'luna'],
    'emergencias' => ['MainController', 'emergencias'],
    'arduino'     => ['MainController', 'arduino'],
    'resources'   => ['MainController', 'recursos'],
    'quehacer'    => ['MainController', 'quehacer'],
    'blog'        => ['MainController', 'blog'],
    'juegos'      => ['MainController', 'juegos'],
    'Acercade'    => ['MainController', 'acercaDe'],
    // ============================================================
    'school'                    => ['SchoolController', 'index'],
    'school/panel'              => ['SchoolController', 'panel'],
    'school/view-institution'   => ['SchoolController', 'viewInstitution'],
    'school/exit-view'          => ['SchoolController', 'exitInstitutionView'],
    'school/news-detail'        => ['SchoolController', 'newsDetail'],
    'school/riesgo-detail'      => ['SchoolController', 'riesgoDetail'],
    'school/incident-detail'    => ['SchoolController', 'incidentDetail'],

    // "Me gusta" y comentarios (Noticias, Lugares en riesgo, Incidentes)
    'school/toggle-like'         => ['InteraccionController', 'toggleLike'],
    'school/interaction-summary' => ['InteraccionController', 'getSummary'],
    'school/comments'            => ['InteraccionController', 'listComments'],
    'school/add-comment'         => ['InteraccionController', 'addComment'],
    'school/delete-comment'      => ['InteraccionController', 'deleteComment'],

    // Alumnos (CRUD real)
    'school/students'            => ['EstudianteController', 'list'],
    'school/add-student'         => ['EstudianteController', 'create'],
    'school/update-student'      => ['EstudianteController', 'update'],
    'school/delete-student'      => ['EstudianteController', 'delete'],
    'school/my-classroom'        => ['EstudianteController', 'myClassroom'],

    // Docentes (CRUD real)
    'school/teachers'            => ['DocenteController', 'list'],
    'school/add-teacher'         => ['DocenteController', 'create'],
    'school/delete-teacher'      => ['DocenteController', 'delete'],
    'school/update-teacher'      => ['DocenteController', 'update'],
    'school/upload-teacher-photo'=> ['DocenteController', 'uploadPhoto'],
    'school/assignable-teachers'=> ['DocenteController', 'assignable'],

    // Aulas (CRUD real)
    'school/classrooms'          => ['AulaController', 'list'],
    'school/add-classroom'       => ['AulaController', 'create'],
    'school/delete-classroom'    => ['AulaController', 'delete'],
    'school/update-classroom'    => ['AulaController', 'update'],

    // Rutas
    'school/routes'             => ['SchoolController', 'getRoutes'],
    'school/add-route'          => ['SchoolController', 'addRoute'],
    'school/update-route'       => ['SchoolController', 'updateRoute'],
    'school/delete-route'       => ['SchoolController', 'deleteRoute'],

    // Asistencia (CRUD real)
    'school/attendance'           => ['AsistenciaController', 'get'],
    'school/save-attendance'      => ['AsistenciaController', 'save'],
    'school/my-attendance'        => ['AsistenciaController', 'myAttendance'],

    // Incidentes
    'school/incidents'          => ['SchoolController', 'getIncidents'],
    'school/add-incident'       => ['SchoolController', 'addIncident'],
    'school/resolve-incident'   => ['SchoolController', 'resolveIncident'],
    'school/update-incident'    => ['SchoolController', 'updateIncident'],
    'school/delete-incident'    => ['SchoolController', 'deleteIncident'],

    // Simulacros (CRUD real)
    'school/drills'               => ['SimulacroController', 'list'],
    'school/add-drill'            => ['SimulacroController', 'create'],
    'school/update-drill'         => ['SimulacroController', 'update'],
    'school/delete-drill'         => ['SimulacroController', 'delete'],

    // Reportes
    'school/reports'              => ['ReporteController', 'get'],

    // Instituciones (CRUD real, solo Admin General)
    'school/institutions'        => ['InstitucionController', 'list'],
    'school/add-institution'     => ['InstitucionController', 'create'],
    'school/update-institution'  => ['InstitucionController', 'update'],
    'school/delete-institution'  => ['InstitucionController', 'delete'],
    'school/institution-stats'   => ['InstitucionController', 'stats'],

    // Usuarios y roles (CRUD real, Admin General y Admin Institucional)
    'school/users'         => ['UserController', 'list'],
    'school/add-user'      => ['UserController', 'create'],
    'school/update-user'   => ['UserController', 'update'],
    'school/delete-user'   => ['UserController', 'delete'],

    // Noticias internas (CRUD real)
    'school/news'          => ['NoticiaController', 'list'],
    'school/add-news'      => ['NoticiaController', 'create'],
    'school/update-news'   => ['NoticiaController', 'update'],
    'school/delete-news'   => ['NoticiaController', 'delete'],

    // Padres (CRUD real + vínculo con hijos)
    'school/parents'              => ['PadreController', 'list'],
    'school/add-parent'           => ['PadreController', 'create'],
    'school/update-parent'        => ['PadreController', 'update'],
    'school/delete-parent'        => ['PadreController', 'delete'],
    'school/link-child'           => ['PadreController', 'linkChild'],
    'school/unlink-child'         => ['PadreController', 'unlinkChild'],
    'school/parent-children-links'=> ['PadreController', 'myChildrenLinks'],
    'school/my-children'          => ['PadreController', 'myChildren'],
    'school/my-children-status'   => ['PadreController', 'myChildrenDrillStatus'],

    // Personal administrativo (CRUD real)
    'school/staff'          => ['PersonalController', 'list'],
    'school/add-staff'      => ['PersonalController', 'create'],
    'school/update-staff'   => ['PersonalController', 'update'],
    'school/delete-staff'   => ['PersonalController', 'delete'],

    // Blog de lugares en riesgo (Docente/Alumno/Personal/Director/Admin)
    'school/blog'          => ['BlogController', 'list'],
    'school/add-blog'      => ['BlogController', 'create'],
    'school/delete-blog'   => ['BlogController', 'delete'],

    // Notificaciones (gestión: Admin Institucional / Admin General)
    'school/notifications'        => ['NotificacionController', 'manageList'],
    'school/send-notification'    => ['NotificacionController', 'send'],
    'school/delete-notification'  => ['NotificacionController', 'delete'],
    'school/send-to-my-students'  => ['NotificacionController', 'sendToMyStudents'],
    'school/send-to-my-children'  => ['NotificacionController', 'sendToMyChildren'],

    // Solicitudes de ingreso (aprobacion del director)
    'school/join-requests'      => ['SchoolController', 'getJoinRequests'],
    'school/approve-request'    => ['SchoolController', 'approveJoinRequest'],
    'school/reject-request'     => ['SchoolController', 'rejectJoinRequest'],

    // Secciones (18 aulas de bachillerato) — CRUD real
    'school/sections'            => ['SeccionController', 'list'],
    'school/assign-teacher'      => ['SeccionController', 'assignTeacher'],

    // Croquis interactivo
    'school/croquis'            => ['SchoolController', 'getCroquis'],
    'school/croquis-upload'     => ['SchoolController', 'uploadCroquisImage'],
    'school/croquis-add-point'  => ['SchoolController', 'addCroquisPoint'],
    'school/croquis-del-point'  => ['SchoolController', 'deleteCroquisPoint'],
    'school/institution-location' => ['SchoolController', 'updateInstitutionLocation'],

    // Tablero de corcho
    'school/board'              => ['SchoolController', 'getBoardNotes'],
    'school/board-add'          => ['SchoolController', 'addBoardNote'],
    'school/board-move'         => ['SchoolController', 'moveBoardNote'],
    'school/board-delete'       => ['SchoolController', 'deleteBoardNote'],

    // Alerta de simulacro en vivo
    'school/activate-alert'      => ['SimulacroController', 'activate'],
    'school/finish-alert'        => ['SimulacroController', 'finish'],
    'school/active-alert'        => ['SimulacroController', 'activeAlert'],

    // CMS del Admin General: blog público (artículos y noticias)
    'admin/articulos'        => ['ArticuloController', 'list'],
    'admin/add-articulo'     => ['ArticuloController', 'create'],
    'admin/update-articulo'  => ['ArticuloController', 'update'],
    'admin/delete-articulo'  => ['ArticuloController', 'delete'],

    // CMS del Admin General: recursos PDF descargables
    'admin/recursos'        => ['RecursoController', 'list'],
    'admin/add-recurso'     => ['RecursoController', 'create'],
    'admin/update-recurso'  => ['RecursoController', 'update'],
    'admin/delete-recurso'  => ['RecursoController', 'delete'],

    // CMS del Admin General: contenido de "Qué hacer ahora" y "Acerca de NDA"
    'admin/get-quehacer-content'   => ['ContenidoController', 'getQuehacer'],
    'admin/save-quehacer-content'  => ['ContenidoController', 'saveQuehacer'],
    'admin/get-acercade-content'   => ['ContenidoController', 'getAcercade'],
    'admin/save-acercade-content'  => ['ContenidoController', 'saveAcercade'],
];

// El routeMap indexa por la ruta COMPLETA (ej. 'school/add-student'), no solo por el primer segmento.
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
            error_log('[NDA] Excepcion no capturada en ' . $className . '::' . $method . '() — ' . $e->getMessage());

            if (ob_get_level() > 0) { ob_clean(); }
            http_response_code(500);

            // Todas las rutas son AJAX (esperan JSON) salvo la carga inicial de 'school'.
            $isJsonRoute = !(
                $className === 'MainController' ||
                ($className === 'AuthController' && $method !== 'institutionsList') ||
                ($className === 'SchoolController' && in_array($method, ['index', 'panel', 'newsDetail', 'riesgoDetail', 'incidentDetail'], true))
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