<?php
class ChatController {

    // Clave de Groq (https://console.groq.com/keys), leida de .env
    // (GROQ_API_KEY) -- igual que MAIL_* en Mailer.php. Este archivo SI
    // esta trackeado por git, asi que la clave real nunca va aqui escrita.
    private $apiKey = null;

    // Groq retiro los modelos "llama-3.x-*" de su catalogo (ver /v1/models);
    // gpt-oss-120b es el reemplazo actual: buena calidad en español y rapido.
    private $model = "openai/gpt-oss-120b";
    private $url = "https://api.groq.com/openai/v1/chat/completions";

    // Mapa de intenciones de navegacion: palabras clave => destino dentro del sitio.
    // Se revisa ANTES de llamar a la IA, asi el chatbot puede llevar al usuario
    // a la seccion correcta incluso si la API de IA no esta configurada.
    private function navigationMap() {
        return [
            ['keywords' => ['sismo', 'sismos', 'terremoto', 'temblor'], 'url' => 'sismos', 'label' => 'Monitor Sísmico'],
            ['keywords' => ['volcan', 'volcán', 'volcanes', 'erupcion', 'erupción', 'izalco', 'chaparrastique', 'ilamatepec'], 'url' => 'volcanes', 'label' => 'Volcanes'],
            ['keywords' => ['tsunami', 'tsunamis', 'maremoto'], 'url' => 'tsunamis', 'label' => 'Tsunamis'],
            ['keywords' => ['inundacion', 'inundación', 'inundaciones', 'crecida', 'desborde'], 'url' => 'inundaciones', 'label' => 'Inundaciones'],
            ['keywords' => ['deslizamiento', 'deslizamientos', 'deslave', 'derrumbe', 'ladera'], 'url' => 'deslizamientos', 'label' => 'Deslizamientos'],
            ['keywords' => ['incendio forestal', 'incendios forestales', 'quema agricola', 'quema agrícola', 'fuego en el bosque'], 'url' => 'incendios-forestales', 'label' => 'Incendios Forestales'],
            ['keywords' => ['tormenta tropical', 'tormentas tropicales', 'huracan', 'huracán', 'ciclon', 'ciclón'], 'url' => 'tormentas-tropicales', 'label' => 'Tormentas Tropicales'],
            ['keywords' => ['sequia', 'sequía', 'sequias', 'sequías', 'falta de lluvia'], 'url' => 'sequias', 'label' => 'Sequías'],
            ['keywords' => ['galeria 3d', 'galería 3d', 'modelo 3d', 'modelos 3d', 'visualizacion 3d', 'visualización 3d'], 'url' => 'galeria-3d', 'label' => 'Galería 3D de Desastres'],
            ['keywords' => ['placa', 'placas', 'tectonica', 'tectónicas'], 'url' => 'home#placas', 'label' => 'Placas Tectónicas'],
            ['keywords' => ['historial', 'historia', 'linea de tiempo', 'línea de tiempo'], 'url' => 'home#timeline', 'label' => 'Historial de Sismos'],
            ['keywords' => ['arduino', 'sensor', 'esp32', 'vibracion', 'vibración', 'processing'], 'url' => 'arduino', 'label' => 'Sensor de Vibración'],
            ['keywords' => ['mapa', 'riesgo', 'riesgos'], 'url' => 'home#zona-sismica', 'label' => 'Mapa de Peligros'],
            ['keywords' => ['clima', 'tiempo', 'temperatura', 'lluvia', 'lluvias'], 'url' => 'clima', 'label' => 'Clima en Tiempo Real'],
            ['keywords' => ['luna', 'fase lunar', 'fases de la luna', 'amanecer', 'atardecer'], 'url' => 'luna', 'label' => 'Fases Lunares'],
            ['keywords' => ['punto de emergencia', 'puntos de emergencia', 'refugio', 'refugios', 'albergue', 'albergues', 'hospital cercano'], 'url' => 'emergencias', 'label' => 'Puntos de Emergencia'],
            ['keywords' => ['prevencion', 'prevención', 'que hacer', 'qué hacer', 'preparacion', 'preparación'], 'url' => 'quehacer', 'label' => '¿Qué hacer AHORA?'],
            ['keywords' => ['mochila', 'kit de emergencia'], 'url' => 'resources', 'label' => 'Mochila de Emergencia'],
            ['keywords' => ['juego', 'juegos', 'trivia'], 'url' => 'juegos', 'label' => 'Juegos Educativos'],
            ['keywords' => ['noticia', 'noticias'], 'url' => 'blog', 'label' => 'Blog'],
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
                'reply' => 'Hola, soy el asistente de NDA. Pregúntame sobre sismos, volcanes, tsunamis, evacuación, la mochila de emergencia o cómo usar la plataforma.'],
            ['keywords' => ['que es nda', 'que es esta pagina', 'que es este sitio', 'de que trata', 'de que se trata', 'para que sirve esta pagina', 'para que sirve esta plataforma', 'que hace esta plataforma', 'que hace este sitio', 'que puedo hacer en esta pagina', 'que puedo hacer aqui'],
                'reply' => 'NDA es una plataforma educativa de prevención de desastres en El Salvador: monitoreo sísmico en tiempo real, páginas por amenaza (sismos, volcanes, tsunamis, inundaciones, deslizamientos, incendios, tormentas, sequías) con galería 3D, clima y fases lunares, guías de "¿qué hacer AHORA?", recursos descargables, juegos educativos y un módulo de Gestión Escolar para simulacros.',
                'navigate' => 'home', 'navigateLabel' => 'Explorar NDA'],
            ['keywords' => ['sismo', 'terremoto', 'tiembla', 'movimiento sismico', 'cuando tiembla'],
                'reply' => 'Durante un sismo: agáchate, cúbrete bajo un mueble resistente y agárrate hasta que termine el movimiento. No corras ni uses el ascensor. Aléjate de ventanas y objetos que puedan caer. Al terminar, revisa heridos y aléjate de estructuras dañadas antes de salir.',
                'navigate' => 'quehacer', 'navigateLabel' => '¿Qué hacer AHORA?'],
            ['keywords' => ['tsunami', 'maremoto'],
                'reply' => 'Si sientes un sismo fuerte estando en la costa, el sismo ES la alerta: no esperes aviso oficial, sube a tierra alta de inmediato (mínimo 30 metros sobre el nivel del mar). Si el mar se retira de forma anormal, tienes minutos para evacuar. No regreses hasta autorización oficial del MARN.',
                'navigate' => 'tsunamis', 'navigateLabel' => 'Tsunamis'],
            ['keywords' => ['mochila', 'kit de emergencia', 'que debo preparar', 'que necesito para una emergencia'],
                'reply' => 'Tu mochila de emergencia debe incluir: agua (3 litros por persona por día, para 3 días), alimentos no perecederos, linterna y radio a pilas, pilas de repuesto, botiquín básico, documentos importantes en bolsa sellada, silbato, muda de ropa y algo de efectivo. Guárdala cerca de la salida principal.',
                'navigate' => 'resources', 'navigateLabel' => 'Mochila de Emergencia'],
            ['keywords' => ['evacuacion', 'evacuar', 'ruta de evacuacion', 'punto de reunion'],
                'reply' => 'Acuerda con tu familia un punto de reunión cercano y otro más lejano por si el primero no es seguro. En instituciones educativas, el módulo de colegio permite a docentes ver las rutas asignadas y hacer pase de lista durante un simulacro. Practica la ruta antes de que ocurra una emergencia real.',
                'navigate' => 'school', 'navigateLabel' => 'Gestión Escolar'],
            ['keywords' => ['registrar', 'registro', 'crear cuenta', 'como me registro', 'como entro'],
                'reply' => 'Para registrarte, haz clic en "Registrarse" en la barra de navegación. Puedes crear una cuenta general, o vincularte a una institución educativa como docente, estudiante, padre/madre o personal administrativo.',
                'navigate' => 'register', 'navigateLabel' => 'Crear Cuenta'],
            ['keywords' => ['rol', 'roles', 'que puede hacer un docente', 'que puede hacer un alumno', 'que puede hacer un estudiante', 'que puede hacer el admin'],
                'reply' => 'En Gestión Escolar: el Administrador gestiona toda la institución, el Docente pasa lista y reporta incidentes, el Estudiante ve su aula y simulacros, el Padre/Madre ve el estado de sus hijos, y el Personal Administrativo apoya con publicaciones.',
                'navigate' => 'school', 'navigateLabel' => 'Gestión Escolar'],
            ['keywords' => ['marn', 'usgs', 'emsc', 'de donde salen los datos', 'fuente de los datos'],
                'reply' => 'Los sismos en tiempo real combinan dos catálogos públicos, USGS y EMSC, para no depender de uno solo. La información institucional se basa en criterios del MARN, que no publica una API propia.',
                'navigate' => 'sismos', 'navigateLabel' => 'Monitor Sísmico'],
            ['keywords' => ['magnitud', 'richter', 'escala sismica', 'que tan fuerte'],
                'reply' => 'La escala de magnitud mide la energía liberada por un sismo: M1-2 es imperceptible, M3-4 leve (puede sentirse), M5 moderado (posibles daños), M6 fuerte (daños estructurales), M7+ es un gran terremoto. El terremoto de El Salvador de 2001 fue de magnitud 7.7.',
                'navigate' => 'home#placas', 'navigateLabel' => 'Placas Tectónicas'],
            ['keywords' => ['clima', 'temperatura', 'lluvia', 'meteorolog'],
                'reply' => 'La sección de Clima muestra temperatura en tiempo real de varias ciudades de El Salvador, además del arco solar (amanecer y atardecer), precipitación mensual y radar meteorológico.',
                'navigate' => 'clima', 'navigateLabel' => 'Clima en Tiempo Real'],
            ['keywords' => ['luna', 'fase lunar', 'marea', 'fases de la luna'],
                'reply' => 'La sección de Fases Lunares explica el ciclo lunar completo y su influencia en las mareas del Pacífico salvadoreño: las mareas vivas ocurren en luna nueva y llena, con hasta 2.4 metros de diferencia entre marea alta y baja.',
                'navigate' => 'luna', 'navigateLabel' => 'Fases Lunares'],
            ['keywords' => ['volcan', 'erupcion', 'izalco', 'santa ana', 'chaparrastique'],
                'reply' => 'El Salvador tiene 26 volcanes a lo largo de su cordillera, varios activos, como el Izalco ("El Faro del Pacífico") y el San Miguel (Chaparrastique), uno de los más activos del país. La sección de Volcanes tiene el detalle de cada uno (estado, tipo, causas y qué hacer ante ceniza o actividad eruptiva). Ante actividad volcánica: sigue las alertas del MARN, cubre nariz y boca ante caída de ceniza, y usa las rutas de evacuación oficiales.',
                'navigate' => 'volcanes', 'navigateLabel' => 'Volcanes'],
            ['keywords' => ['inundacion', 'inundación', 'crecida', 'desborde'],
                'reply' => 'Ante una inundación: muévete a terreno alto de inmediato, no cruces ríos ni calles inundadas a pie o en vehículo (con 15 cm de corriente ya puedes perder el equilibrio), y desconecta la electricidad de tu casa si el agua se acerca. La Cuenca Baja del Río Lempa es la zona más golpeada en cada temporada lluviosa.',
                'navigate' => 'inundaciones', 'navigateLabel' => 'Inundaciones'],
            ['keywords' => ['deslizamiento', 'deslave', 'derrumbe', 'ladera'],
                'reply' => 'Un deslizamiento suele avisar antes de ocurrir: grietas nuevas en el suelo o paredes, árboles o postes inclinados, sonidos de tronido o crujido, y manantiales que cambian de caudal. Si notas estas señales en una ladera, evacúa y avisa a las autoridades; no esperes a que el terreno se mueva.',
                'navigate' => 'deslizamientos', 'navigateLabel' => 'Deslizamientos'],
            ['keywords' => ['incendio forestal', 'incendios forestales', 'quema agricola', 'quema agrícola'],
                'reply' => 'La mayoría de incendios forestales en El Salvador ocurren en la estación seca (nov.-abr.) por quemas agrícolas mal manejadas cerca de áreas protegidas. Si ves humo o fuego cerca de una zona boscosa, aléjate a favor del viento y reporta a Bomberos (913).',
                'navigate' => 'incendios-forestales', 'navigateLabel' => 'Incendios Forestales'],
            ['keywords' => ['tormenta tropical', 'huracan', 'huracán', 'ciclon', 'ciclón'],
                'reply' => 'Las tormentas tropicales suelen dar varios días de aviso: sigue los boletines oficiales, asegura techos y objetos sueltos, y ten lista tu mochila de emergencia. Tormentas como Ida (2009), Ágatha (2010) e Iota-Eta (2020) dejaron algunas de las peores inundaciones recientes del país.',
                'navigate' => 'tormentas-tropicales', 'navigateLabel' => 'Tormentas Tropicales'],
            ['keywords' => ['sequia', 'sequía', 'falta de lluvia'],
                'reply' => 'El Corredor Seco salvadoreño (La Unión, Morazán, San Miguel) sufre pérdidas de cosecha casi cada año por déficit de lluvia. Ante sequía, la prioridad es cuidar el agua potable disponible y priorizar cultivos y consumo humano sobre otros usos.',
                'navigate' => 'sequias', 'navigateLabel' => 'Sequías'],
            ['keywords' => ['modelo 3d', 'modelos 3d', 'galeria 3d', 'galería 3d', 'visualizacion 3d', 'visualización 3d'],
                'reply' => 'La Galería 3D te deja explorar en tres dimensiones cómo se ve cada amenaza natural (sismos, volcanes, tsunamis, inundaciones, deslizamientos, incendios, tormentas tropicales y sequías), con un carrusel interactivo por cada tipo de desastre.',
                'navigate' => 'galeria-3d', 'navigateLabel' => 'Galería 3D de Desastres'],
            ['keywords' => ['arduino', 'sensor de vibracion', 'esp32', 'processing'],
                'reply' => 'La sección de Monitoreo explica cómo se integrará una maqueta de sensor Arduino (MPU-6050): detecta vibración en 3 ejes y, cuando el hardware esté conectado, sus lecturas llegarán en tiempo real a la plataforma.',
                'navigate' => 'arduino', 'navigateLabel' => 'Sensor de Vibración'],
            ['keywords' => ['punto de emergencia', 'puntos de emergencia', 'refugio', 'albergue', 'hospital cercano'],
                'reply' => 'La sección de Puntos de Emergencia ubica en el mapa los refugios, hospitales y centros de atención más cercanos ante un desastre en El Salvador.',
                'navigate' => 'emergencias', 'navigateLabel' => 'Puntos de Emergencia'],
            ['keywords' => ['trivia', 'juego', 'quiz'],
                'reply' => 'La Zona de Juegos tiene un quiz de magnitud, un juego de memoria, "arma tu mochila de emergencia" y un simulacro por reflejos, todo sobre desastres naturales.',
                'navigate' => 'juegos', 'navigateLabel' => 'Juegos Educativos'],
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

    // Pregunta de "como hago X" (procedimiento dentro de la plataforma),
    // ej. "y como vero las personas qeu han ingresado a mi colegio" (con
    // errores de tipeo y todo). Estas NO deben caer en matchNavigation
    // (paso 3): esa tabla solo tiene palabras sueltas como "colegio"/
    // "escuela" y devuelve un simple "Te llevo a X" sin contestar la
    // pregunta real. Si no hay FAQ que la cubra, mejor dejarla pasar
    // directo a la IA (paso 4).
    //
    // En vez de una lista de frases exactas (fragil ante errores de
    // tipeo: "como vero" no calza con "como veo"), se detecta por señales
    // mas generales: palabras de pregunta sueltas, termina en "?", o el
    // mensaje es largo (mas de 5 palabras casi siempre es una oracion/
    // pregunta real, no solo el nombre corto de una seccion). Los
    // comandos de navegacion explicitos ("llevame a...", "ir a...")
    // siguen usando el atajo rapido aunque sean mensajes largos.
    private function isProceduralQuestion($message) {
        $norm = $this->normalize($message);

        $navCommands = ['llevame', 'llevarme', 'ir a', 'vamos a', 'quiero ir', 'muestrame', 'abrir', 'abre'];
        foreach ($navCommands as $c) {
            if (strpos($norm, $this->normalize($c)) !== false) return false;
        }

        if (substr(rtrim($message), -1) === '?') return true;
        if (str_word_count($norm) > 5) return true;

        $questionWords = ['como ', 'donde ', 'cuando ', 'quien ', 'quienes ', 'cual ', 'cuales ', 'para que'];
        foreach ($questionWords as $w) {
            if (strpos($norm, $this->normalize($w)) !== false) return true;
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
            'volcanes' => 'la sección de volcanes',
            'tsunamis' => 'la sección de tsunamis',
            'inundaciones' => 'la sección de inundaciones',
            'deslizamientos' => 'la sección de deslizamientos',
            'incendios-forestales' => 'la sección de incendios forestales',
            'tormentas-tropicales' => 'la sección de tormentas tropicales',
            'sequias' => 'la sección de sequías',
            'galeria-3d' => 'la galería 3D de desastres',
            'placas' => 'la sección de placas tectónicas',
            'timeline' => 'el historial de sismos',
            'zona-sismica' => 'el mapa de peligros',
            'zonas-riesgo' => 'el mapa de riesgos',
            'encontraras' => 'la portada de secciones de NDA',
            'arduino' => 'el panel del sensor de vibración (Arduino/ESP32)',
            'clima' => 'el panel de clima en tiempo real',
            'luna' => 'las fases lunares',
            'monitoreo' => 'el panel de monitoreo',
            'emergencias' => 'los puntos de emergencia',
            'quehacer' => 'la guía de "¿qué hacer ahora?"',
            'juegos' => 'la zona de juegos',
            'school' => 'el módulo de Gestión Escolar',
            'blog' => 'el blog de NDA',
            'resources' => 'la biblioteca de recursos',
            'profile' => 'su perfil',
            'Acercade' => 'la página "Acerca de NDA"',
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
            //    la IA (mas rapido y siempre disponible). Se salta si es una
            //    pregunta de procedimiento ("como veo...", "donde esta...",
            //    termina en "?"): esas quedan mejor respondidas por la IA en
            //    el paso 4, en vez de solo un "Te llevo a X" sin contenido.
            if (!$this->isProceduralQuestion($message)) {
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
        }

        // 4) Sin coincidencia de FAQ ni navegacion: usamos la IA (Groq) si
        //    hay API key configurada en .env (GROQ_API_KEY).
        $apiKey = $this->apiKey ?? env('GROQ_API_KEY', '');
        if (empty($apiKey)) {
            jsonResponse(['reply' => 'Puedo ayudarte a moverte por NDA (sismos, clima, mapa de riesgos, gestión escolar, recursos...). Para preguntas abiertas, el administrador del sitio todavía no configuró la clave de IA (variable GROQ_API_KEY en .env).']);
            return;
        }

        $systemPrompt = "Eres el asistente virtual de NDA (Natural Disaster Alert), una plataforma educativa "
            . "sobre prevención de desastres naturales en El Salvador dirigida a la comunidad escolar. Responde "
            . "SIEMPRE en español (salvo que el usuario escriba en inglés), de forma directa y al punto: "
            . "maximo 3 a 4 oraciones cortas, sin rodeos ni relleno. Organiza esas oraciones en 2 parrafos cortos "
            . "(separa los parrafos con una linea en blanco), nunca en un solo bloque de texto largo. PROHIBIDO "
            . "usar formato Markdown de cualquier tipo: nunca escribas **, __, #, ni guiones o numeros de lista al "
            . "inicio de linea, ni siquiera para resaltar un nombre propio. Tu respuesta se muestra como texto "
            . "plano tal cual la escribas, asi que cualquier simbolo de Markdown apareceria literal (por ejemplo "
            . "\"**Izalco**\" se veria con los asteriscos incluidos) y eso se ve mal. Si la pregunta requiere pasos "
            . "a seguir, sepáralos con comas o punto y coma dentro de la misma oracion, no en lineas separadas. "
            . "Si la pregunta es sobre algo fuera de desastres "
            . "naturales, prevención o el uso de la plataforma, redirige amablemente el tema en una sola frase. "
            . "Incluye un dato concreto (cifra, nombre de volcán o falla) solo si aporta valor real a esa "
            . "respuesta puntual, nunca como relleno para alargarla.\n\n"
            . "Qué es NDA y qué contiene la plataforma (usa esto si preguntan de qué trata el sitio): monitoreo "
            . "sísmico en tiempo real con datos del USGS, sismógrafo interactivo y simulador de movimiento sísmico, "
            . "páginas propias por amenaza (sismos, volcanes, tsunamis, inundaciones, deslizamientos, incendios "
            . "forestales, tormentas tropicales, sequías) más una galería 3D con modelos interactivos de cada una, "
            . "mapa de peligros y puntos de emergencia, clima y fases lunares en tiempo real, "
            . "una maqueta de sensor Arduino/ESP32 (MPU-6050) que mide vibración en 3 ejes, guías de \"¿qué hacer "
            . "AHORA?\", una biblioteca de recursos con guías PDF descargables, juegos/trivias educativas, y un "
            . "módulo de Gestión Escolar (simulacros, rutas de evacuación, reportes de incidentes) para directores, "
            . "docentes, estudiantes, padres y personal administrativo.\n\n"
            . "Navegación dentro del Panel de Gestión del director (usa esto si preguntan cómo hacer algo ahí "
            . "dentro, ej. \"cómo veo quién se unió a mi colegio\"): la barra inferior del panel tiene Usuarios "
            . "(lista de todos los miembros ya aceptados en la institución, filtrable por docentes/personal/"
            . "estudiantes/padres), Solicitudes (pedidos pendientes de unirse a la institución, para aprobar o "
            . "rechazar), Aulas (las 6 secciones A-F de cada año de bachillerato, con su docente asignado y pase "
            . "de lista), Tablero (resumen general, con Reportes y Notificaciones), Croquis, Rutas de Evacuación "
            . "y Simulacros.\n\n"
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
            . "estaciones en el país. Los datos sísmicos en tiempo real de esta plataforma combinan el USGS y el "
            . "EMSC (European-Mediterranean Seismological Centre), dos catálogos públicos internacionales.\n"
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
            'temperature' => 0.6,
            // gpt-oss-120b gasta parte del presupuesto en razonamiento interno
            // (oculto, no se muestra) antes del texto visible. Con esfuerzo
            // "high" (default) esto a veces se comia TODO max_tokens en
            // preguntas abiertas (ej. "que es lluvia"), dejando el campo
            // "content" vacio -> el chat mostraba "No pude responder eso.".
            // "low" alcanza de sobra para las 3-4 oraciones cortas que pide
            // el prompt, y deja casi todo el presupuesto para el texto real.
            'reasoning_effort' => 'low',
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
        $reply = $data['choices'][0]['message']['content'] ?? '';
        $reply = trim($this->stripMarkdown($reply));
        if ($reply === '') {
            $reply = 'No pude generar una respuesta. Intenta reformular tu pregunta.';
        }

        $resp = ['reply' => $reply];
        // La IA no elige a donde redirigir: reusamos el mismo mapa de
        // navegacion por palabras clave que los pasos 2/3 (deterministico y
        // ya probado), asi las respuestas generadas por la IA tambien pueden
        // traer el boton de "ir a la seccion" cuando el mensaje lo amerita.
        $navMatch = $this->matchNavigation($message);
        if ($navMatch) {
            $resp['navigate'] = $navMatch['url'];
            $resp['navigateLabel'] = $navMatch['label'];
        }

        jsonResponse($resp);
    }

    // Red de seguridad por si la IA ignora la instruccion de no usar
    // Markdown: el chat pinta la respuesta con textContent (texto plano), asi
    // que un "**Izalco**" sin limpiar se veria literal con los asteriscos.
    private function stripMarkdown($text) {
        $text = preg_replace('/\*\*(.+?)\*\*/s', '$1', $text);   // **negrita**
        $text = preg_replace('/__(.+?)__/s', '$1', $text);        // __negrita__
        $text = preg_replace('/(?<!\*)\*([^\*\n]+)\*(?!\*)/', '$1', $text); // *cursiva*
        $text = preg_replace('/^#{1,6}\s*/m', '', $text);         // # encabezados
        $text = preg_replace('/^[\-\*]\s+/m', '', $text);         // - viñetas
        $text = preg_replace('/^\d+\.\s+/m', '', $text);          // 1. listas numeradas
        $text = str_replace("\r\n", "\n", $text);
        $text = preg_replace('/[ \t]{2,}/', ' ', $text);
        // Un salto de linea "suelto" (sobrante de una vineta ya limpiada) se
        // une en la misma oracion; dos o mas saltos SI se respetan como
        // separacion de parrafo (el CSS del chat usa white-space:pre-wrap).
        $text = preg_replace('/\n{3,}/', "\n\n", $text);
        $text = preg_replace('/(?<!\n)\n(?!\n)/', ' ', $text);
        $text = implode("\n\n", array_filter(array_map('trim', explode("\n\n", $text)), 'strlen'));
        return trim($text);
    }
}
