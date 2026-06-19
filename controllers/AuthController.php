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
            $_SESSION['user_id'] = $user['usuarios_id'];
            $_SESSION['user'] = [
                'id' => $user['usuarios_id'],
                'name' => $user['nombre'],
                'email' => $user['email'],
                'role' => $user['role']
            ];
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
        $role = $_POST['role'] ?? 'user';
        
        if (strlen($password) < 6) {
            $_SESSION['error'] = 'Password must be at least 6 characters';
            redirect('register');
            return;
        }
        
        $db = getDB();
        
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $_SESSION['error'] = 'Email already registered';
            redirect('register');
            return;
        }
        
        $hashed = hash('sha256', $password);
        $stmt = $db->prepare("INSERT INTO usuarios (nombre, email, contra, role) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $hashed, $role]);
        
        $_SESSION['success'] = 'Account created successfully!';
        redirect('login');
    }
    
    public function logout() {
        session_destroy();
        redirect('home');
    }
}
?>