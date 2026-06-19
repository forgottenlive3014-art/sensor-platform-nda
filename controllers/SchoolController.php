<?php
class SchoolController {
    
    public function index() {
        if (!isLoggedIn()) {
            redirect('login');
            return;
        }
        
        $db = getDB();
        
        $stats = [];
        $stats['students'] = $db->query("SELECT COUNT(*) as total FROM estudiantes")->fetch()['total'] ?? 0;
        $stats['teachers'] = $db->query("SELECT COUNT(*) as total FROM usuarios WHERE role = 'user'")->fetch()['total'] ?? 0;
        $stats['classrooms'] = $db->query("SELECT COUNT(*) as total FROM aulas")->fetch()['total'] ?? 0;
        
        $students = $db->query("
            SELECT e.*, a.nombre as classroom 
            FROM estudiantes e 
            LEFT JOIN aulas a ON e.aulas_id = a.aulas_id 
            LIMIT 20
        ")->fetchAll();
        
        $data = [
            'title' => 'School Module',
            'user' => currentUser(),
            'stats' => $stats,
            'students' => $students
        ];
        
        view('school', $data);
    }
}
?>