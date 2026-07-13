<?php
class ContenidoModel {

    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    // Devuelve un array plano [campo => valor] para la página dada.
    public function getByPage($pagina) {
        $stmt = $this->db->prepare("SELECT campo, valor FROM contenido_paginas WHERE pagina = ?");
        $stmt->execute([$pagina]);
        $out = [];
        foreach ($stmt->fetchAll() as $row) {
            $out[$row['campo']] = $row['valor'];
        }
        return $out;
    }

    // $pares es un array [campo => valor]. Guarda todos los campos de una
    // sola vez en una transacción, creando o actualizando cada fila.
    public function saveBulk($pagina, $pares) {
        $stmt = $this->db->prepare("
            INSERT INTO contenido_paginas (pagina, campo, valor)
            VALUES (:pagina, :campo, :valor)
            ON DUPLICATE KEY UPDATE valor = VALUES(valor)
        ");
        $this->db->beginTransaction();
        try {
            foreach ($pares as $campo => $valor) {
                $stmt->execute([':pagina' => $pagina, ':campo' => $campo, ':valor' => $valor]);
            }
            $this->db->commit();
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
        return true;
    }

    // ============================================================
    // Definiciones de los campos editables de "Que hacer ahora" y
    // "Acerca de NDA". Una sola fuente de verdad, usada por: el
    // formulario de administracion (arma los inputs), el script de
    // siembra (usa 'default' para poblar la tabla la primera vez) y
    // las paginas publicas (si un campo no esta en la base de datos,
    // usa 'default' como respaldo para que la pagina nunca se vea vacia).
    // ============================================================

    public static function quehacerFieldDefs() {
        $defs = [];

        $defs[] = ['campo' => 'hero.kicker', 'label' => 'Etiqueta superior', 'group' => 'Encabezado', 'type' => 'text', 'default' => 'ACCIÓN INMEDIATA'];
        $defs[] = ['campo' => 'hero.titulo', 'label' => 'Título', 'group' => 'Encabezado', 'type' => 'text', 'default' => '¿Qué hacer AHORA?'];
        $defs[] = ['campo' => 'hero.texto', 'label' => 'Subtítulo', 'group' => 'Encabezado', 'type' => 'textarea', 'default' => 'Mantén la calma. Elige la situación que estás viviendo y sigue los pasos. Cada segundo bien usado cuenta.'];

        $tipos = [
            'sismo' => [
                'title' => 'Sismo / Terremoto',
                'antes' => [
                    ['Asegura tu casa', 'Fija estantes, espejos y objetos pesados que puedan caer.'],
                    ['Define un punto de reunión', 'Acuerda con tu familia dónde encontrarse al salir.'],
                    ['Prepara tu mochila', 'Agua, linterna, botiquín y documentos siempre listos.'],
                ],
                'durante' => [
                    ['Agáchate', 'Bájate al suelo antes de que el sismo te tire.'],
                    ['Cúbrete', 'Protege cabeza y cuello bajo una mesa firme.'],
                    ['Agárrate', 'Sujétate hasta que el movimiento termine. No corras ni uses ascensores.'],
                ],
                'despues' => [
                    ['Revisa heridas', 'Atiende primero a quien lo necesite. Ten calma.'],
                    ['Cuidado con réplicas', 'Pueden venir más temblores. Aléjate de estructuras dañadas.'],
                    ['Corta servicios si hay riesgo', 'Cierra gas y revisa fugas antes de encender luces.'],
                ],
            ],
            'inundacion' => [
                'title' => 'Inundación',
                'antes' => [
                    ['Conoce tu zona de riesgo', 'Identifica si vives cerca de quebradas o ríos.'],
                    ['Sube lo importante', 'Coloca documentos y aparatos en lugares altos.'],
                    ['Ten lista la ruta', 'Memoriza el camino hacia el punto más alto y seguro.'],
                ],
                'durante' => [
                    ['Sube a un lugar alto', 'Busca el nivel más elevado posible.'],
                    ['No cruces corrientes', '30 cm de agua pueden arrastrarte. Nunca cruces a pie o en auto.'],
                    ['Mantente informado', 'Escucha la radio a pilas y sigue indicaciones oficiales.'],
                ],
                'despues' => [
                    ['No tomes agua dudosa', 'Hierve o purifica antes de beber.'],
                    ['Cuidado al volver', 'Revisa que la estructura sea segura antes de entrar.'],
                    ['Limpia y desinfecta', 'El agua de inundación puede traer enfermedades.'],
                ],
            ],
            'incendio' => [
                'title' => 'Incendio',
                'antes' => [
                    ['Detectores de humo', 'Instálalos y prueba sus pilas con frecuencia.'],
                    ['Plan de escape', 'Conoce dos salidas de cada habitación.'],
                    ['Extintor a la mano', 'Ten uno y aprende a usarlo.'],
                ],
                'durante' => [
                    ['Agáchate y avanza', 'El humo sube; el aire limpio está abajo.'],
                    ['Toca antes de abrir', 'Si la puerta está caliente, busca otra salida.'],
                    ['Sal y no regreses', 'Una vez fuera, llama al 911. Nunca vuelvas por objetos.'],
                ],
                'despues' => [
                    ['Recibe atención médica', 'Aunque te sientas bien, revisa por inhalación de humo.'],
                    ['No entres aún', 'Espera el visto bueno de los bomberos.'],
                    ['Documenta daños', 'Toma fotos para tu reporte y seguro.'],
                ],
            ],
            'deslizamiento' => [
                'title' => 'Deslizamiento de tierra',
                'antes' => [
                    ['Observa señales', 'Grietas en el suelo, árboles inclinados o agua turbia.'],
                    ['Evita zonas de pendiente', 'No construyas ni duermas al pie de laderas inestables.'],
                    ['Plan de evacuación', 'Ten claro a dónde ir si el terreno cede.'],
                ],
                'durante' => [
                    ['Aléjate de la pendiente', 'Muévete lateralmente, fuera del camino del deslave.'],
                    ['Sube a terreno firme', 'Busca un punto alto y estable.'],
                    ['Avisa a otros', 'Alerta a vecinos en la trayectoria.'],
                ],
                'despues' => [
                    ['Mantente alejado', 'Puede haber más deslizamientos.'],
                    ['Reporta a las autoridades', 'Informa bloqueos y personas atrapadas.'],
                    ['Revisa servicios', 'Cuidado con cables y tuberías rotas.'],
                ],
            ],
            'tormenta' => [
                'title' => 'Tormenta eléctrica',
                'antes' => [
                    ['Asegura objetos sueltos', 'El viento puede convertirlos en proyectiles.'],
                    ['Carga dispositivos', 'Ten linternas y baterías listas por si se va la luz.'],
                    ['Resguarda mascotas', 'Tenlas dentro y seguras.'],
                ],
                'durante' => [
                    ['Quédate adentro', 'Evita ventanas y aparatos conectados.'],
                    ['No uses agua', 'Evita ducharte o lavar durante rayos.'],
                    ['Si estás afuera', 'Aléjate de árboles altos y postes; agáchate.'],
                ],
                'despues' => [
                    ['Revisa daños', 'Inspecciona techo y conexiones eléctricas.'],
                    ['Evita cables caídos', 'Nunca los toques; repórtalos.'],
                    ['Mantente alerta', 'Pueden venir nuevas células de tormenta.'],
                ],
            ],
        ];
        $faseLabels = ['antes' => 'Antes', 'durante' => 'Durante', 'despues' => 'Después'];

        foreach ($tipos as $tipoKey => $tipo) {
            $defs[] = ['campo' => "$tipoKey.title", 'label' => 'Título de la tarjeta', 'group' => $tipo['title'], 'type' => 'text', 'default' => $tipo['title']];
            foreach ($faseLabels as $faseKey => $faseLabel) {
                foreach ($tipo[$faseKey] as $i => $paso) {
                    $defs[] = ['campo' => "$tipoKey.$faseKey.$i.titulo", 'label' => 'Paso ' . ($i + 1) . ' — título', 'group' => $tipo['title'] . ' / ' . $faseLabel, 'type' => 'text', 'default' => $paso[0]];
                    $defs[] = ['campo' => "$tipoKey.$faseKey.$i.texto", 'label' => 'Paso ' . ($i + 1) . ' — descripción', 'group' => $tipo['title'] . ' / ' . $faseLabel, 'type' => 'textarea', 'default' => $paso[1]];
                }
            }
        }

        $defs[] = ['campo' => 'contacts.titulo', 'label' => 'Título de la sección', 'group' => 'Contactos clave', 'type' => 'text', 'default' => 'Contactos clave en El Salvador'];
        $contactos = [
            ['911', 'Emergencias (línea única)', 'tel:911'],
            ['Protección Civil', 'Dirección General', '#'],
            ['Cruz Roja', 'Salvadoreña', '#'],
            ['Bomberos', 'Cuerpo de Bomberos', '#'],
        ];
        foreach ($contactos as $i => $c) {
            $defs[] = ['campo' => "contacts.$i.nombre", 'label' => 'Contacto ' . ($i + 1) . ' — nombre', 'group' => 'Contactos clave', 'type' => 'text', 'default' => $c[0]];
            $defs[] = ['campo' => "contacts.$i.subtitulo", 'label' => 'Contacto ' . ($i + 1) . ' — descripción', 'group' => 'Contactos clave', 'type' => 'text', 'default' => $c[1]];
            $defs[] = ['campo' => "contacts.$i.link", 'label' => 'Contacto ' . ($i + 1) . ' — teléfono o enlace', 'group' => 'Contactos clave', 'type' => 'text', 'default' => $c[2]];
        }

        return $defs;
    }

    public static function acercadeFieldDefs() {
        $defs = [];

        $defs[] = ['campo' => 'hero.kicker', 'label' => 'Etiqueta superior', 'group' => 'Hero', 'type' => 'text', 'default' => 'QUIÉNES SOMOS'];
        $defs[] = ['campo' => 'hero.titulo', 'label' => 'Título principal', 'group' => 'Hero', 'type' => 'text', 'default' => 'Preparar a El Salvador, un hogar a la vez'];
        $defs[] = ['campo' => 'hero.texto', 'label' => 'Subtítulo', 'group' => 'Hero', 'type' => 'textarea', 'default' => 'NDA es una plataforma educativa que convierte la prevención de desastres en algo claro, visual y al alcance de todos. Porque estar informado salva vidas.'];

        $stats = [
            ['9', 'Guías educativas'],
            ['5', 'Tipos de emergencia'],
            ['72', 'Horas que enseñamos a resistir'],
            ['100', 'Acceso gratuito (%)'],
        ];
        foreach ($stats as $i => $s) {
            $defs[] = ['campo' => "stats.$i.target", 'label' => 'Estadística ' . ($i + 1) . ' — número', 'group' => 'Estadísticas', 'type' => 'text', 'default' => $s[0]];
            $defs[] = ['campo' => "stats.$i.label", 'label' => 'Estadística ' . ($i + 1) . ' — etiqueta', 'group' => 'Estadísticas', 'type' => 'text', 'default' => $s[1]];
        }

        $defs[] = ['campo' => 'mision.texto', 'label' => 'Texto de misión', 'group' => 'Misión y visión', 'type' => 'textarea', 'default' => 'Llevar información práctica de prevención y respuesta ante desastres a familias, escuelas y comunidades de El Salvador, en un lenguaje sencillo y con herramientas que cualquiera pueda usar hoy mismo.'];
        $defs[] = ['campo' => 'vision.texto', 'label' => 'Texto de visión', 'group' => 'Misión y visión', 'type' => 'textarea', 'default' => 'Un país donde cada persona sepa exactamente qué hacer antes, durante y después de una emergencia, y donde la preparación sea un hábito y no una sorpresa.'];

        $timeline = [
            ['Te informas', 'Lees guías y reportajes claros, sin tecnicismos.'],
            ['Practicas', 'Pones a prueba lo aprendido con juegos y simulacros.'],
            ['Te preparas', 'Armas tu mochila y tu plan familiar de emergencia.'],
            ['Actúas', 'Cuando llega la emergencia, ya sabes qué hacer.'],
        ];
        foreach ($timeline as $i => $t) {
            $defs[] = ['campo' => "timeline.$i.titulo", 'label' => 'Paso ' . ($i + 1) . ' — título', 'group' => 'Cómo te acompañamos', 'type' => 'text', 'default' => $t[0]];
            $defs[] = ['campo' => "timeline.$i.texto", 'label' => 'Paso ' . ($i + 1) . ' — descripción', 'group' => 'Cómo te acompañamos', 'type' => 'textarea', 'default' => $t[1]];
        }

        $valores = [
            ['Para todos', 'Información gratuita y accesible, sin barreras.'],
            ['Confiable', 'Basada en fuentes oficiales y buenas prácticas.'],
            ['Clara', 'Lenguaje sencillo y diseño que se entiende rápido.'],
            ['Útil hoy', 'Acciones que puedes tomar de inmediato.'],
        ];
        foreach ($valores as $i => $v) {
            $defs[] = ['campo' => "valores.$i.titulo", 'label' => 'Valor ' . ($i + 1) . ' — título', 'group' => 'En lo que creemos', 'type' => 'text', 'default' => $v[0]];
            $defs[] = ['campo' => "valores.$i.texto", 'label' => 'Valor ' . ($i + 1) . ' — descripción', 'group' => 'En lo que creemos', 'type' => 'textarea', 'default' => $v[1]];
        }

        $defs[] = ['campo' => 'cta.titulo', 'label' => 'CTA — título', 'group' => 'Llamado a la acción', 'type' => 'text', 'default' => 'La mejor emergencia es la que sabes enfrentar'];
        $defs[] = ['campo' => 'cta.texto', 'label' => 'CTA — texto', 'group' => 'Llamado a la acción', 'type' => 'textarea', 'default' => 'Empieza hoy. Tu preparación protege a quienes más quieres.'];

        return $defs;
    }
}
