<?php
class AuthController {
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processLogin();
            return;
        }
        view('login', ['title' => 'Login']);
    }
    
    private function processLogin() {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if (empty($email) || empty($password)) {
            $_SESSION['error'] = 'Please fill all fields';
            redirect('login');
            return;
        }
        
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user && hash('sha256', $password) === $user['contra']) {
            // ===== GUARDAR SESIÓN =====
            $_SESSION['user_id'] = $user['usuarios_id'];
            $_SESSION['user_name'] = $user['nombre'];  // ← Esto es lo que muestra el layout
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'];
            
            redirect('home');
        } else {
            $_SESSION['error'] = 'Invalid email or password';
            redirect('login');
        }
    }
    
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processRegister();
            return;
        }
        view('register', ['title' => 'Register']);
    }
    
    private function processRegister() {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? 'user';  // ← Valor por defecto 'user'
        
        // Validaciones
        if (empty($name) || empty($email) || empty($password)) {
            $_SESSION['error'] = 'All fields are required';
            redirect('register');
            return;
        }
        
        if (strlen($password) < 6) {
            $_SESSION['error'] = 'Password must be at least 6 characters';
            redirect('register');
            return;
        }
        
        $db = getDB();
        
        // Verificar si el email ya existe
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $_SESSION['error'] = 'Email already registered';
            redirect('register');
            return;
        }
        
        // Insertar usuario
        $hashed = hash('sha256', $password);
        $stmt = $db->prepare("INSERT INTO usuarios (nombre, email, contra, role) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $hashed, $role]);
        
        // Obtener el ID del nuevo usuario
        $userId = $db->lastInsertId();
        
        // ===== INICIAR SESIÓN AUTOMÁTICAMENTE =====
        $_SESSION['user_id'] = $userId;
        $_SESSION['user_name'] = $name;  // ← Esto es lo que muestra el layout
        $_SESSION['user_email'] = $email;
        $_SESSION['user_role'] = $role;
        
        $_SESSION['success'] = '¡Cuenta creada exitosamente! Bienvenido ' . $name;
        redirect('home');  // ← IMPORTANTE: Redirigir a home, no a login
    }
    
    public function logout() {
    session_start();
    session_destroy();
    redirect('home');
}
}
?>