<?php
class ChatController {

    // Clave de Groq (https://console.groq.com/keys). Este archivo esta
    // excluido de git (ver .gitignore) precisamente porque tiene la clave
    // real escrita aqui abajo -- si alguna vez se saca del .gitignore,
    // sacar la clave de aqui primero.
    private $apiKey = "";

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
            'ayuda ahora', 'que hago ahora', 'tengo una emergencia', 'es una emergencia',
            'estoy en una emergencia', 'estoy atrapado', 'hay un incendio',
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

    // Base de preguntas frecuentes con respuesta real (no solo redireccion).
    // Se revisa ANTES de la navegacion pura y ANTES de Groq, asi el chat
    // contesta de verdad temas comunes de prevencion de desastres incluso
    // sin API key configurada. "navigate" es opcional: si aplica, ademas
    // de la respuesta se sugiere un enlace a la seccion relacionada.
    private function faqKnowledge() {
        return [
            ['keywords' => ['hola', 'hey', 'buenas', 'saludos'],
                'reply' => 'Hola. Soy el asistente de NDA. Puedo ayudarte con dudas sobre sismos, tsunamis, evacuación, la mochila de emergencia, el módulo de colegio o cómo usar la plataforma. ¿En qué te ayudo?'],
            ['keywords' => ['sismo', 'terremoto', 'tiembla', 'movimiento sismico', 'cuando tiembla'],
                'reply' => 'Durante un sismo: agáchate, cúbrete bajo un mueble resistente y agárrate hasta que termine el movimiento. No corras ni uses el ascensor. Aléjate de ventanas y objetos que puedan caer. Al terminar, revisa heridos y aléjate de estructuras dañadas antes de salir.',
                'navigate' => 'quehacer', 'navigateLabel' => '¿Qué hacer AHORA?'],
            ['keywords' => ['tsunami', 'maremoto'],
                'reply' => 'Si sientes un sismo fuerte estando en la costa, el sismo ES la alerta: no esperes aviso oficial, sube a tierra alta de inmediato (mínimo 30 metros sobre el nivel del mar). Si el mar se retira de forma anormal, tienes minutos para evacuar. No regreses hasta autorización oficial del MARN.',
                'navigate' => 'home#tsunamis', 'navigateLabel' => 'Tsunamis'],
            ['keywords' => ['mochila', 'kit de emergencia', 'que debo preparar', 'que necesito para una emergencia'],
                'reply' => 'Tu mochila de emergencia debe incluir: agua (3 litros por persona por día, para 3 días), alimentos no perecederos, linterna y radio a pilas, pilas de repuesto, botiquín básico, documentos importantes en bolsa sellada, silbato, muda de ropa y algo de efectivo. Guárdala cerca de la salida principal.',
                'navigate' => 'home#prevencion', 'navigateLabel' => 'Mochila de Emergencia'],
            ['keywords' => ['evacuacion', 'evacuar', 'ruta de evacuacion', 'punto de reunion'],
                'reply' => 'Acuerda con tu familia un punto de reunión cercano y otro más lejano por si el primero no es seguro. En instituciones educativas, el módulo de colegio permite a docentes ver las rutas asignadas y hacer pase de lista durante un simulacro. Practica la ruta antes de que ocurra una emergencia real.',
                'navigate' => 'school', 'navigateLabel' => 'Gestión Escolar'],
            ['keywords' => ['registrar', 'registro', 'crear cuenta', 'como me registro', 'como entro'],
                'reply' => 'Para registrarte, haz clic en "Registrarse" en la barra de navegación. Puedes crear una cuenta general, o vincularte a una institución educativa como docente, alumno, padre/madre o personal administrativo.',
                'navigate' => 'register', 'navigateLabel' => 'Crear Cuenta'],
            ['keywords' => ['rol', 'roles', 'que puede hacer un docente', 'que puede hacer un alumno', 'que puede hacer el admin'],
                'reply' => 'En el módulo de colegio: el Administrador gestiona toda la institución (usuarios, aulas, simulacros, reportes). El Docente pasa lista, ve sus aulas y reporta incidentes. El Alumno ve su aula y los simulacros futuros. El Padre/Madre ve el estado de sus hijos durante un simulacro. El Personal Administrativo apoya con publicaciones y estado durante una emergencia.',
                'navigate' => 'school', 'navigateLabel' => 'Gestión Escolar'],
            ['keywords' => ['marn', 'usgs', 'de donde salen los datos', 'fuente de los datos'],
                'reply' => 'Los datos sísmicos en tiempo real vienen del USGS (Servicio Geológico de EE.UU.), filtrados a la región de Centroamérica y El Salvador. La información institucional y de alertas se basa en criterios del MARN (Ministerio de Medio Ambiente de El Salvador).',
                'navigate' => 'home#sismos', 'navigateLabel' => 'Monitor Sísmico'],
            ['keywords' => ['magnitud', 'richter', 'escala sismica', 'que tan fuerte'],
                'reply' => 'La escala de magnitud mide la energía liberada por un sismo: M1-2 es imperceptible, M3-4 leve (puede sentirse), M5 moderado (posibles daños), M6 fuerte (daños estructurales), M7+ es un gran terremoto. El terremoto de El Salvador de 2001 fue de magnitud 7.7.',
                'navigate' => 'home#placas', 'navigateLabel' => 'Placas Tectónicas'],
            ['keywords' => ['clima', 'temperatura', 'lluvia', 'meteorolog'],
                'reply' => 'La sección de Clima muestra temperatura en tiempo real de varias ciudades de El Salvador, además del arco solar (amanecer y atardecer), precipitación mensual y radar meteorológico.',
                'navigate' => 'home#clima', 'navigateLabel' => 'Clima en Tiempo Real'],
            ['keywords' => ['luna', 'fase lunar', 'marea', 'fases de la luna'],
                'reply' => 'La sección de Fases Lunares explica el ciclo lunar completo y su influencia en las mareas del Pacífico salvadoreño: las mareas vivas ocurren en luna nueva y llena, con hasta 2.4 metros de diferencia entre marea alta y baja.',
                'navigate' => 'home#luna', 'navigateLabel' => 'Fases Lunares'],
            ['keywords' => ['volcan', 'erupcion', 'izalco', 'santa ana', 'chaparrastique'],
                'reply' => 'El Salvador tiene 26 volcanes a lo largo de su cordillera, varios activos, como el Izalco ("El Faro del Pacífico") y el San Miguel (Chaparrastique), uno de los más activos del país. Ante actividad volcánica: sigue las alertas del MARN, cubre nariz y boca ante caída de ceniza, y usa las rutas de evacuación oficiales.'],
            ['keywords' => ['arduino', 'sensor de vibracion', 'esp32', 'processing'],
                'reply' => 'La sección de Monitoreo explica cómo se integrará una maqueta de sensor Arduino (MPU-6050): detecta vibración en 3 ejes y, cuando el hardware esté conectado, sus lecturas llegarán en tiempo real a la plataforma.',
                'navigate' => 'home#arduino', 'navigateLabel' => 'Sensor de Vibración'],
            ['keywords' => ['trivia', 'juego', 'quiz'],
                'reply' => 'La Zona de Trivia tiene preguntas sobre desastres naturales en 3 niveles de dificultad. Los Juegos Educativos incluyen un quiz de magnitud, una ruta de evacuación y un juego de memoria sobre la mochila de emergencia.',
                'navigate' => 'home#juegos', 'navigateLabel' => 'Juegos Educativos'],
            ['keywords' => ['911', 'numero de emergencia', 'numeros de emergencia', 'bomberos', 'cruz roja', 'coen'],
                'reply' => 'Números de emergencia en El Salvador: 911 (PNC Emergencias), 913 (Bomberos), 2222-5155 (Cruz Roja), 2267-6000 (MARN Alertas), 2231-4000 (COEN Operaciones).',
                'navigate' => 'quehacer', 'navigateLabel' => '¿Qué hacer AHORA?'],
            ['keywords' => ['gracias', 'perfecto', 'muchas gracias', 'excelente'],
                'reply' => 'Con mucho gusto. Recuerda que la prevención y el conocimiento salvan vidas. Si tienes más dudas sobre sismos, evacuación o el sistema NDA, aquí estoy.'],
        ];
    }

    // Preguntas tipo "¿qué es...?", "¿qué significa...?", "¿por qué...?"
    // buscan una EXPLICACIÓN, no un paso a seguir ni un enlace. Estas se
    // saltan el FAQ de respuesta fija y van directo a la IA, que puede
    // responder la pregunta real en vez de una respuesta genérica sobre
    // la misma palabra clave.
    private function isDefinitionQuestion($message) {
        $norm = $this->normalize($message);
        $starters = [
            'que es', 'que son', 'que significa', 'que quiere decir',
            'por que', 'porque', 'como funciona', 'como se forma', 'como se produce',
            'cual es la diferencia', 'cuales son las causas', 'de donde viene', 'de donde sale',
        ];
        foreach ($starters as $s) {
            if (strpos($norm, $this->normalize($s)) !== false) return true;
        }
        return false;
    }

    private function matchFaq($message) {
        $norm = $this->normalize($message);
        foreach ($this->faqKnowledge() as $item) {
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

        // 2) Pregunta frecuente con respuesta real: contesta de verdad el
        //    tema (no solo un enlace), funciona sin necesitar la IA. Se
        //    salta si es una pregunta de definicion/explicacion (esas
        //    quedan mejor respondidas por la IA en el paso 4).
        $isDefinition = $this->isDefinitionQuestion($message);
        if (!$isDefinition) {
            $faqMatch = $this->matchFaq($message);
            if ($faqMatch) {
                $resp = ['reply' => $faqMatch['reply']];
                if (!empty($faqMatch['navigate'])) {
                    $resp['navigate'] = $faqMatch['navigate'];
                    $resp['navigateLabel'] = $faqMatch['navigateLabel'] ?? null;
                }
                jsonResponse($resp);
                return;
            }

            // 3) Intencion de navegacion (sin respuesta de contenido propia):
            //    si coincide, respondemos y sugerimos el enlace SIN necesitar
            //    la IA (mas rapido y siempre disponible).
            $navMatch = $this->matchNavigation($message);
            if ($navMatch) {
                jsonResponse([
                    'reply' => 'Te llevo a "' . $navMatch['label'] . '". Si quieres, haz clic en el botón de abajo.',
                    'navigate' => $navMatch['url'],
                    'navigateLabel' => $navMatch['label'],
                ]);
                return;
            }
        }

        // 4) Sin coincidencia de FAQ ni navegacion: usamos la IA (Groq) si
        //    hay API key configurada en $this->apiKey (arriba del archivo).
        $apiKey = $this->apiKey;
        if (empty($apiKey)) {
            jsonResponse(['reply' => 'Puedo ayudarte a moverte por NDA (sismos, clima, mapa de riesgos, gestión escolar, recursos...). Para preguntas abiertas, el administrador del sitio todavía no configuró la clave de IA (variable $apiKey en ChatController.php).']);
            return;
        }

        $systemPrompt = "Eres el asistente virtual de NDA (Natural Disaster Alert), una plataforma educativa "
            . "sobre prevención de desastres naturales en El Salvador. Responde de forma breve, clara y amable, "
            . "SIEMPRE en español, salvo que el usuario escriba en inglés. Si la pregunta es sobre algo fuera de "
            . "desastres naturales, prevención o el uso de la plataforma, redirige amablemente el tema.\n\n"
            . "Datos geológicos y geográficos de El Salvador que DEBES usar como referencia (no inventes otras "
            . "placas, fallas o cifras si el usuario pregunta sobre esto):\n"
            . "- El Salvador está en el límite entre la Placa de Cocos (oceánica) y la Placa del Caribe "
            . "(continental). La Placa de Cocos subduce (se hunde) bajo la Placa del Caribe a un ritmo de "
            . "aproximadamente 8 cm/año. Esta subducción es la causa principal de la sismicidad y el "
            . "vulcanismo del país. La Placa de Nazca NO pasa por Centroamérica (está frente a Sudamérica); "
            . "nunca la menciones para explicar sismos en El Salvador.\n"
            . "- Además de la subducción, existen fallas superficiales locales, como la Falla Metrópolis "
            . "(atraviesa San Salvador, ~15 km), que generan sismos de menor profundidad pero alto impacto "
            . "en zonas pobladas (ejemplo: terremoto del 10 de octubre de 1986).\n"
            . "- El Salvador tiene aproximadamente 26 volcanes, varios activos: Izalco (\"El Faro del "
            . "Pacífico\"), Santa Ana (Ilamatepec), San Salvador (Boquerón), San Vicente (Chinchontepec) y "
            . "San Miguel (Chaparrastique, uno de los más activos).\n"
            . "- Terremotos históricos relevantes: 1854 (San Salvador, ~M6.5), 1917 (erupción y sismo del "
            . "Santa Ana), 1965 (San Salvador, M6.2), 1986 (San Salvador, M5.7, ~1,500 muertos), 2001 "
            . "(13 de enero M7.7 y 13 de febrero M6.6, el más devastador del siglo, incluyendo el deslizamiento "
            . "de Las Colinas).\n"
            . "- La Red Sísmica de MARN (Ministerio de Medio Ambiente y Recursos Naturales) opera más de 30 "
            . "estaciones en el país. Los datos sísmicos en tiempo real de esta plataforma vienen del USGS.\n"
            . "- Riesgo de tsunami: sismos submarinos M≥7.0 frente a la costa pueden generar olas que llegan "
            . "en 15-20 minutos a zonas como La Libertad o Acajutla; la evacuación es a terreno alto (mínimo "
            . "30 m sobre el nivel del mar).\n"
            . "Si no tienes certeza de un dato específico (cifras exactas, fechas, nombres), dilo explícitamente "
            . "en vez de inventarlo.";

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
        // La verificacion SSL usa el bundle de certificados configurado a
        // nivel de PHP (curl.cainfo en php.ini), no un archivo del proyecto.

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
