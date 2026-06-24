<?php
session_start();

require_once 'config.php';


// FUNCIONES AUXILIARES


function view($name, $data = []) {
    extract($data);
    $file = "views/$name.php";
    if (file_exists($file)) {
        require_once $file;
    } else {
        die("View not found: $name");
    }
}

function redirect($url) {
    header("Location: ?url=$url");
    exit;
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function currentUser() {
    return $_SESSION['user'] ?? null;
}

function e($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function jsonResponse($data, $code = 200) {
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

$controller = $parts[0];
$action = isset($parts[1]) ? $parts[1] : 'index';
$params = array_slice($parts, 2);

$routeMap = [
    'home'       => ['MainController', 'home'],
    'login'      => ['AuthController', 'login'],
    'register'   => ['AuthController', 'register'],
    'logout'     => ['AuthController', 'logout'],
    'school'     => ['SchoolController', 'index'],
    'chat-api'   => ['ChatController', 'send'],
    'earthquakes'=> ['MainController', 'earthquakes'],
    'resources'   => ['MainController', 'recursos'], 
];

if (isset($routeMap[$controller])) {
    list($className, $method) = $routeMap[$controller];
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
        call_user_func_array([$obj, $method], $params);
    } else {
        echo "Error: Method $method not found in $className";
    }
} else {
    echo "Error: Controller $className not found";
}
?>