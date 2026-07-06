<?php
class ChatController {

    private $model = "llama-3.3-70b-versatile";
    private $url = "https://api.groq.com/openai/v1/chat/completions";

    // Mapa de intenciones de navegacion: palabras clave => destino dentro del sitio.
    // Se revisa ANTES de llamar a la IA, asi el chatbot puede llevar al usuario
    // a la seccion correcta incluso si la API de IA no esta configurada.
    private function navigationMap() {
        return [
            ['keywords' => ['sismo', 'sismos', 'terremoto', 'temblor', 'magnitud'], 'url' => 'home#sismos', 'label' => 'Monitor Sísmico'],
            ['keywords' => ['placa', 'placas', 'tectonica', 'tectónicas'], 'url' => 'home#placas', 'label' => 'Placas Tectónicas'],
            ['keywords' => ['historial', 'historia', 'linea de tiempo', 'línea de tiempo'], 'url' => 'home#timeline', 'label' => 'Historial de Sismos'],
            ['keywords' => ['arduino', 'sensor', 'esp32', 'vibracion', 'vibración', 'processing'], 'url' => 'home#arduino', 'label' => 'Sensor de Vibración'],
            ['keywords' => ['mapa', 'riesgo', 'riesgos'], 'url' => 'home#mapa', 'label' => 'Mapa de Riesgos'],
            ['keywords' => ['clima', 'tiempo', 'temperatura', 'lluvia', 'lluvias'], 'url' => 'home#clima', 'label' => 'Clima en Tiempo Real'],
            ['keywords' => ['luna', 'fase lunar', 'fases de la luna', 'amanecer', 'atardecer'], 'url' => 'home#luna', 'label' => 'Fases Lunares'],
            ['keywords' => ['tsunami', 'tsunamis', 'maremoto'], 'url' => 'home#tsunamis', 'label' => 'Tsunamis'],
            ['keywords' => ['prevencion', 'prevención', 'que hacer', 'qué hacer', 'preparacion', 'preparación'], 'url' => 'home#ahora', 'label' => '¿Qué hacer AHORA?'],
            ['keywords' => ['mochila', 'kit de emergencia'], 'url' => 'home#prevencion', 'label' => 'Mochila de Emergencia'],
            ['keywords' => ['juego', 'juegos'], 'url' => 'home#juegos', 'label' => 'Juegos Educativos'],
            ['keywords' => ['trivia'], 'url' => 'home#trivia', 'label' => 'Trivia'],
            ['keywords' => ['noticia', 'noticias'], 'url' => 'home#noticias', 'label' => 'Noticias'],
            ['keywords' => ['guia', 'guía', 'guias', 'guías', 'recurso', 'recursos', 'pdf'], 'url' => 'resources', 'label' => 'Guías y Recursos'],
            ['keywords' => ['gestion escolar', 'gestión escolar', 'colegio', 'escuela', 'institucion', 'institución', 'simulacro', 'simulacros', 'croquis', 'corcho', 'secciones'], 'url' => 'school', 'label' => 'Gestión Escolar'],
            ['keywords' => ['perfil', 'mi cuenta', 'unirme a', 'unirme a una institucion'], 'url' => 'profile', 'label' => 'Mi Perfil'],
            ['keywords' => ['registrarme', 'registrar', 'crear cuenta', 'quiero registrarme', 'sign up'], 'url' => 'register', 'label' => 'Crear Cuenta'],
            ['keywords' => ['iniciar sesion', 'iniciar sesión', 'login', 'entrar a mi cuenta'], 'url' => 'login', 'label' => 'Iniciar Sesión'],
        ];
    }

    private function normalize($text) {
        $text = mb_strtolower($text, 'UTF-8');
        $replace = ['á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u', 'ñ' => 'n'];
        return strtr($text, $replace);
    }

    // Palabras que sugieren que el usuario esta viviendo una emergencia
    // AHORA, no solo preguntando de forma educativa. En ese caso el
    // chatbot responde directo y sin adornos, priorizando accion
    // inmediata sobre conversacion (ver Fase 2 — Design System, seccion 5).
    private function isEmergencyMessage($message) {
        $norm = $this->normalize($message);
        $triggers = [
            'esta temblando', 'esta temblando ahora', 'hay un sismo ahora', 'siento un temblor',
            'ayuda ahora', 'que hago ahora', 'emergencia', 'estoy atrapado', 'hay un incendio',
            'se esta moviendo todo', 'auxilio'
        ];
        foreach ($triggers as $t) {
            if (strpos($norm, $this->normalize($t)) !== false) return true;
        }
        return false;
    }

    private function matchNavigation($message) {
        $norm = $this->normalize($message);
        foreach ($this->navigationMap() as $item) {
            foreach ($item['keywords'] as $kw) {
                if (strpos($norm, $this->normalize($kw)) !== false) {
                    return $item;
                }
            }
        }
        return null;
    }

    // Etiquetas humanas para el modulo/ancla actual, usadas para darle
    // contexto al chatbot sin exponerle nombres tecnicos de rutas.
    private function moduleLabel($module) {
        $labels = [
            'sismos' => 'el monitor sísmico',
            'placas' => 'la sección de placas tectónicas',
            'timeline' => 'el historial de sismos',
            'arduino' => 'el panel del sensor de vibración (Arduino/ESP32)',
            'mapa' => 'el mapa de riesgos',
            'clima' => 'el panel de clima en tiempo real',
            'luna' => 'las fases lunares',
            'tsunamis' => 'la sección de tsunamis',
            'ahora' => 'la guía de "¿qué hacer ahora?"',
            'prevencion' => 'la mochila de emergencia',
            'juegos' => 'la zona de juegos',
            'trivia' => 'la trivia educativa',
            'school' => 'el módulo de Gestión Escolar',
            'blog' => 'el blog de NDA',
            'resources' => 'la biblioteca de recursos',
            'profile' => 'su perfil',
        ];
        return $labels[$module] ?? null;
    }

    public function send() {
        $input = json_decode(file_get_contents('php://input'), true);
        $message = trim($input['message'] ?? '');
        $history = $input['history'] ?? []; // ultimos mensajes enviados por el cliente (contexto)
        $context = $input['context'] ?? [];
        $moduleLabel = $this->moduleLabel($context['module'] ?? null);

        if (empty($message)) {
            jsonResponse(['reply' => 'Escribe tu pregunta sobre desastres naturales o dime a dónde quieres ir en el sitio.']);
            return;
        }

        // 1) Mensaje de emergencia real: responde directo, sin IA, sin
        //    adornos — prioriza la accion sobre la conversacion.
        if ($this->isEmergencyMessage($message)) {
            jsonResponse([
                'reply' => 'Mantén la calma. Aléjate de ventanas y objetos que puedan caer. Si estás en un edificio, cúbrete bajo algo resistente. Aquí tienes los pasos completos.',
                'navigate' => 'quehacer',
                'navigateLabel' => '¿Qué hacer AHORA?',
                'emergency' => true,
            ]);
            return;
        }

        // 2) Intencion de navegacion: si coincide, respondemos y sugerimos
        //    el enlace SIN necesitar la IA (mas rapido y siempre disponible).
        $navMatch = $this->matchNavigation($message);
        if ($navMatch) {
            jsonResponse([
                'reply' => 'Te llevo a "' . $navMatch['label'] . '". Si quieres, haz clic en el botón de abajo.',
                'navigate' => $navMatch['url'],
                'navigateLabel' => $navMatch['label'],
            ]);
            return;
        }

        // 3) Sin coincidencia de navegacion: usamos la IA (Groq) si hay API key.
        $apiKey = env('GROQ_API_KEY', '');
        if (empty($apiKey)) {
            jsonResponse(['reply' => 'Puedo ayudarte a moverte por NDA (sismos, clima, mapa de riesgos, gestión escolar, recursos...). Para preguntas abiertas, el administrador del sitio todavía no configuró la clave de IA (GROQ_API_KEY en el archivo .env).']);
            return;
        }

        $systemPrompt = "Eres el asistente virtual de NDA (Natural Disaster Alert), una plataforma educativa "
            . "sobre prevención de desastres naturales en El Salvador. Responde de forma breve, clara y amable, "
            . "SIEMPRE en español, salvo que el usuario escriba en inglés. Si la pregunta es sobre algo fuera de "
            . "desastres naturales, prevención o el uso de la plataforma, redirige amablemente el tema.";

        if ($moduleLabel) {
            $systemPrompt .= " El usuario está viendo ahora mismo " . $moduleLabel . " dentro de la plataforma. "
                . "Ten esto en cuenta: si su pregunta es ambigua, asume primero que se refiere a lo que está viendo, "
                . "y responde con ese contexto en mente antes de dar una explicación genérica.";
        }
        if (!empty($context['hasInstitution'])) {
            $systemPrompt .= " El usuario ya pertenece a una institución educativa aprobada en NDA, así que puede "
                . "hablarte de temas de Gestión Escolar (simulacros, aulas, incidentes) como parte de su día a día.";
        }

        $messages = [['role' => 'system', 'content' => $systemPrompt]];
        // Incluye un poco de contexto de la conversacion (maximo 6 mensajes previos).
        foreach (array_slice($history, -6) as $h) {
            if (!empty($h['role']) && !empty($h['content'])) {
                $messages[] = ['role' => $h['role'] === 'user' ? 'user' : 'assistant', 'content' => $h['content']];
            }
        }
        $messages[] = ['role' => 'user', 'content' => $message];

        $payload = [
            'model' => $this->model,
            'messages' => $messages,
            'temperature' => 0.7,
            'max_tokens' => 500,
        ];

        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey,
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            jsonResponse(['reply' => 'No pude conectarme al asistente de IA en este momento. Intenta de nuevo en unos segundos.']);
            return;
        }

        $data = json_decode($response, true);
        $reply = $data['choices'][0]['message']['content'] ?? 'No pude generar una respuesta. Intenta reformular tu pregunta.';

        jsonResponse(['reply' => $reply]);
    }
}
