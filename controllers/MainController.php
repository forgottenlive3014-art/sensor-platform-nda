<?php
class MainController {
    
    public function home() {
        $data = [
            'title' => 'NDA · Natural Disaster Alert',
            'user' => currentUser()
        ];
        view('home', $data);
    }
    
    public function earthquakes() {
        $url = 'https://earthquake.usgs.gov/fdsnws/event/1/query?format=geojson&minlatitude=8&maxlatitude=18&minlongitude=-95&maxlongitude=-82&limit=25&orderby=time&minmagnitude=1.5';
        $data = @file_get_contents($url);
        if ($data) {
            header('Content-Type: application/json');
            echo $data;
        } else {
            jsonResponse(['error' => 'Could not fetch earthquake data'], 500);
        }
    }

    public function recursos() {
        $data = [
            'title' => 'Recursos - NDA',
            'user' => currentUser()
        ];
        view('resources', $data);
    }
}
?>
