<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'nda_project');
define('DB_USER', 'root');
define('DB_PASS', '');

// Carga variables desde un archivo .env (si existe) sin depender de
// composer/librerias externas. Formato: CLAVE=valor, una por linea.
function loadEnv($path) {
    if (!file_exists($path)) return;
    foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#' || strpos($line, '=') === false) continue;
        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value, " \t\n\r\0\x0B\"'");
        if (!array_key_exists($key, $_ENV)) {
            $_ENV[$key] = $value;
            putenv("$key=$value");
        }
    }
}
loadEnv(__DIR__ . '/.env');

// Devuelve una variable de entorno (o el valor por defecto si no existe).
function env($key, $default = null) {
    $value = getenv($key);
    return $value !== false ? $value : $default;
}

// ---------------------------------------------------------------
// CSRF — token compartido por sesion, usado en formularios POST
// server-rendered y expuesto via <meta> para las llamadas AJAX del
// modulo escolar / sensor / chat. No requiere libreria externa.
// ---------------------------------------------------------------
function csrfToken() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Valida el token recibido (form POST o header X-CSRF-Token). Devuelve
// true/false; quien llama decide si corta la ejecucion con jsonResponse
// o con un mensaje de error de sesion, segun el tipo de endpoint.
function csrfValid($token) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (empty($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], (string)$token);
}

// Helper para imprimir el campo oculto dentro de un <form> server-rendered.
function csrfField() {
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(csrfToken(), ENT_QUOTES, 'UTF-8') . '">';
}

function getDB() {
    try {
        $pdo = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
            DB_USER,
            DB_PASS
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    } catch (PDOException $e) {
        die("Connection error: " . $e->getMessage());
    }
}
?>