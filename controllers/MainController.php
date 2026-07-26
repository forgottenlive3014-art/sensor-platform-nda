<?php
class MainController {
    
    public function home() {
        $data = [
            'title' => 'NDA · Natural Disaster Alert',
            'user' => currentUser()
        ];
        view('home', $data);
    }
    
    // Cache en archivo para no golpear USGS en cada visita.
    const EARTHQUAKE_CACHE_TTL = 120; // segundos

    public function earthquakes() {
        $cacheFile = __DIR__ . '/../cache/earthquakes.json';
        $cacheDir = dirname($cacheFile);

        if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < self::EARTHQUAKE_CACHE_TTL) {
            header('Content-Type: application/json');
            header('X-NDA-Cache: hit');
            readfile($cacheFile);
            return;
        }

        $url = 'https://earthquake.usgs.gov/fdsnws/event/1/query?format=geojson&minlatitude=8&maxlatitude=18&minlongitude=-95&maxlongitude=-82&limit=25&orderby=time&minmagnitude=1.5';

        $ctx = stream_context_create(['http' => ['timeout' => 8]]);
        $data = @file_get_contents($url, false, $ctx);

        if ($data) {
            if (!is_dir($cacheDir)) { @mkdir($cacheDir, 0775, true); }
            if (is_dir($cacheDir) && is_writable($cacheDir)) {
                @file_put_contents($cacheFile, $data);
            }
            header('Content-Type: application/json');
            header('X-NDA-Cache: miss');
            echo $data;
        } elseif (file_exists($cacheFile)) {
            // USGS no respondio, pero hay una copia vieja: mejor eso que un error.
            header('Content-Type: application/json');
            header('X-NDA-Cache: stale');
            readfile($cacheFile);
        } else {
            jsonResponse(['error' => 'Could not fetch earthquake data'], 500);
        }
    }

    public function sismos() {
        $data = [
            'title' => 'Sismos - NDA',
            'user' => currentUser()
        ];
        view('sismos', $data);
    }

    public function monitoreo() {
        $data = [
            'title' => 'Monitoreo - NDA',
            'user' => currentUser()
        ];
        view('monitoreo', $data);
    }

    public function clima() {
        $data = [
            'title' => 'Clima en Tiempo Real - NDA',
            'user' => currentUser()
        ];
        view('monitoreo/clima', $data);
    }

    public function luna() {
        $data = [
            'title' => 'Fases de la Luna - NDA',
            'user' => currentUser()
        ];
        view('monitoreo/luna', $data);
    }

    public function arduino() {
        $data = [
            'title' => 'Sismógrafo Arduino - NDA',
            'user' => currentUser()
        ];
        view('arduino', $data);
    }

    // ---------------------------------------------------------------
    // "Desastres" (dropdown del navbar): Sismos vive aparte (sismos()),
    // estos 7 comparten la misma plantilla en views/desastres/.
    // ---------------------------------------------------------------
    public function desastresGaleria() {
        view('desastres/galeria', ['title' => 'Desastres - NDA', 'user' => currentUser()]);
    }

    public function volcanes() {
        view('desastres/volcanes', ['title' => 'Volcanes - NDA', 'user' => currentUser()]);
    }

    public function tsunamis() {
        view('desastres/tsunamis', ['title' => 'Tsunamis - NDA', 'user' => currentUser()]);
    }

    public function inundaciones() {
        view('desastres/inundaciones', ['title' => 'Inundaciones - NDA', 'user' => currentUser()]);
    }

    public function deslizamientos() {
        view('desastres/deslizamientos', ['title' => 'Deslizamientos - NDA', 'user' => currentUser()]);
    }

    public function incendiosForestales() {
        view('desastres/incendios-forestales', ['title' => 'Incendios forestales - NDA', 'user' => currentUser()]);
    }

    public function tormentasTropicales() {
        view('desastres/tormentas-tropicales', ['title' => 'Tormentas tropicales - NDA', 'user' => currentUser()]);
    }

    public function sequias() {
        view('desastres/sequias', ['title' => 'Sequías - NDA', 'user' => currentUser()]);
    }

    public function recursos() {
        $data = [
            'title' => 'Recursos - NDA',
            'user' => currentUser()
        ];
        view('resources', $data);
    }

    public function acercaDe() {
        $data = [
            'title' => 'Acerca de NDA',
            'user' => currentUser()
        ];
        view('Acercade', $data);
    }

    public function blog() {
        $data = [
            'title' => 'Blog - NDA',
            'user' => currentUser()
        ];
        view('blog', $data);
    }

    public function juegos() {
        $data = [
            'title' => 'Juegos - NDA',
            'user' => currentUser()
        ];
        view('juegos', $data);
    }

    public function quehacer() {
        $data = [
            'title' => '¿Qué hacer AHORA? - NDA',
            'user' => currentUser()
        ];
        view('quehacer', $data);
    }

    public function gestionEscolar() {
        view('gestion_escolar_demo', ['title' => 'Gestión Escolar - NDA']);
}
}
?>
