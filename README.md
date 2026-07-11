Natural Disaster Alert (NDA)

Natural Disaster Alert (NDA) es una página web sobre desastres naturales en El Salvador. La hice para informar y educar a la gente sobre cómo prevenir y actuar ante sismos, tormentas y otros desastres, usando datos reales en vez de solo texto.

La idea es juntar en un solo lugar cosas que normalmente están separadas: datos de sismos, del clima, de la luna, guías de qué hacer en una emergencia, y hasta un módulo para que un colegio administre sus propios simulacros de evacuación. Para los datos en tiempo real (sismos, clima, amanecer/atardecer) uso APIs gratuitas que ya existen, no las invento yo.

Es un proyecto educativo, no un sistema oficial. Para una emergencia real siempre hay que guiarse por las fuentes oficiales (MARN, Protección Civil).

-- CONTENIDO
1. Secciones de la página
2. Módulo de Gestión Escolar
3. Chatbot con IA
4. Cuentas y roles
5. Sensor de vibración con Arduino
6. Con qué está hecho
7. APIs y librerías que usé
8. Cómo está organizado el código
9. Base de datos
10. Cómo instalarlo
11. Seguridad

-- SECCIONES DE LA PÁGINA

Inicio
Es la página principal. Tiene un globo terráqueo en 3D que se puede recorrer haciendo scroll: empieza mostrando todo el planeta, se va acercando a Centroamérica y termina en un mapa con el relieve real de El Salvador. También muestra las placas tectónicas que causan los sismos en el país, una línea de tiempo con desastres históricos, y tarjetas para entrar rápido a las demás secciones.

Sismos
Aquí se explica de forma sencilla qué es un sismo, la diferencia entre magnitud e intensidad, y cómo funciona un sismógrafo (con una animación de cómo viajan las ondas P y S). Tiene:
- Un mapa de El Salvador (con Leaflet) donde se pueden prender y apagar capas: zonas sísmicas, volcanes, sismos recientes, riesgo de tsunami, deslizamientos y zonas seguras.
- Un monitor con estadísticas del día (sismos hoy, última magnitud, profundidad) y una animación que muestra qué tanto "tiembla" un edificio según la intensidad.
- Un sismógrafo interactivo: uno puede elegir una magnitud (leve, moderado, fuerte, terremoto grande) o mover un control y ver la traza dibujarse en tiempo real, como en un sismógrafo de verdad.
- Una lista de los sismos más recientes de la región, sacada directo de la API de USGS.
- Un simulador donde uno mueve la magnitud, la profundidad y la distancia al epicentro para ver cómo cambia el efecto.

Monitoreo (Tiempo Real)
Junta varios datos en tiempo real: temperatura, humedad, presión y viento de distintas ciudades de El Salvador, la hora del amanecer y el atardecer, la fase de la luna de hoy con un modelo 3D que se ilumina según la fase real, información sobre el riesgo de tsunami en la costa, y una sección que muestra en vivo lo que capta el sensor de vibración físico (si está conectado; si no, la página sigue funcionando en modo demo con los demás datos).

Gestión Escolar
Está explicado con más detalle abajo, en su propia sección.

Blog
Tiene artículos de prevención escritos por mí (como "Agáchate, cúbrete y agárrate" o qué llevar en la mochila de emergencia) y también resúmenes de noticias de desastres reales que han pasado en El Salvador y la región (el terremoto de 2001, la erupción del volcán Santa Ana, las tormentas Ida, Amanda, Cristóbal, el huracán Julia, etc.), cada uno con su fuente y fecha.

Juegos Educativos
Trivias y actividades interactivas para repasar de forma más entretenida lo que hay que saber sobre seguridad y evacuación.

¿Qué hacer AHORA?
Una guía rápida de qué hacer antes, durante y después de un desastre: cómo evacuar, qué llevar en la mochila de 72 horas, números de emergencia y consejos prácticos.

Recursos Educativos
Guías en PDF para descargar (evacuación escolar, mochila de emergencia, plan familiar, preparación ante sismos, protocolo de lluvias), separadas por categoría. Cada una muestra la portada real del PDF como miniatura (se genera en el navegador mismo, no es una imagen que subí a mano) y se puede previsualizar el documento completo en una ventana sin salir de la página.

Acerca de NDA
Información sobre el proyecto.

-- MÓDULO DE GESTIÓN ESCOLAR

Es la parte más grande de todo el proyecto. Sirve para que un colegio administre su propio plan de prevención y respuesta ante emergencias. Lo que se puede ver y hacer cambia según el rol del usuario:
- Administrador General: ve y administra todas las instituciones y usuarios del sistema.
- Administrador Institucional (Director/a): administra su propio colegio: aprueba solicitudes de ingreso, personal, aulas, rutas, simulacros, reportes, etc.
- Docente: pasa asistencia, reporta incidentes y ve su aula/sección asignada.
- Estudiante: ve su aula, su historial de asistencia a simulacros y las alertas activas.
- Padre o madre de familia: ve el estado de sus hijos vinculados durante los simulacros.

Lo que se puede administrar desde este módulo:
- Instituciones y usuarios, con un sistema de solicitud y aprobación para unirse a un colegio.
- Estudiantes, docentes, personal administrativo y padres de familia, incluyendo vincular a un padre con su hijo.
- Aulas y secciones (incluye las 18 secciones de bachillerato y qué docente tiene cada una).
- Rutas de evacuación y zonas seguras de cada colegio.
- Croquis interactivo: un plano del colegio donde se pueden marcar puntos importantes (salidas, puntos de encuentro, extintores, etc.), incluso subiendo una imagen de fondo.
- Tablero de corcho: notas para coordinarse entre el personal.
- Simulacros: se pueden crear y programar, y activar una alerta en vivo que ven todos en tiempo real mientras dura el simulacro.
- Asistencia: se pasa lista por simulacro, y cada estudiante (o su padre/madre) puede ver su propio historial.
- Incidentes: reportar y darle seguimiento a algo que pasó.
- Noticias internas del colegio.
- Notificaciones: se pueden mandar a un usuario, a todo un colegio o a todos, con un nivel de urgencia, y aparecen en la campanita de notificaciones del sitio.
- Reportes: estadísticas del colegio (por ejemplo, de asistencia).

-- CHATBOT CON IA

Hay un asistente flotante en toda la página. Primero revisa si lo que escribió el usuario coincide con algo que reconoce como "llévame a tal sección" para navegar directo ahí. Si no, le pregunta a la IA (uso la API de Groq, con el modelo llama-3.3-70b-versatile) y le doy un contexto con datos reales de El Salvador (la subducción de la Placa de Cocos, la Falla Metrópolis, volcanes, sismos históricos) para que no invente datos incorrectos. El historial de la conversación se guarda en el navegador del usuario.

-- CUENTAS Y ROLES

Hay registro e inicio de sesión, con un asistente de varios pasos para registrarse (tipo de cuenta, rol dentro del colegio, institución, datos personales). También se puede editar el perfil y pedir unirse a una institución. Cada quien ve solo lo que le corresponde según su rol (Administrador General, Administrador Institucional, Docente, Estudiante, Padre/Madre, Personal Administrativo). También hay modo claro/oscuro y traducción español/inglés.

-- SENSOR DE VIBRACIÓN CON ARDUINO

Esta parte es para demostrar, de forma educativa, cómo se podría detectar un movimiento sísmico con hardware real. No reemplaza a los sistemas oficiales de alerta temprana. Así funciona:
1. Un sensor MPU-6050 (mide aceleración y giro en 3 ejes) conectado por I2C a un Arduino o un ESP32 capta la vibración y la manda por el puerto serial.
2. Un programa hecho en Processing lee esos datos del puerto serial y los manda por HTTP a la página (a la ruta ?url=sensor/ingest), con un token para que no cualquiera pueda mandar datos falsos.
3. La página guarda cada lectura (se queda solo con las últimas 500) y las compara con dos límites: precaución desde 0.3 G y alerta desde 0.8 G. Si se pasa de 0.8 G, se genera una notificación automática para todo el colegio, igual que si alguien la activara a mano con el botón de "Simular Alerta".
4. La página revisa cada cierto tiempo la ruta ?url=sensor/latest y muestra la lectura en vivo en Monitoreo. Si el sensor no está conectado, esa sección sigue mostrando el resto de los datos reales en modo demo.

La guía completa de cómo conectar los cables, qué programa instalar y cómo solucionar problemas está en hardware/README.md.

-- CON QUÉ ESTÁ HECHO

- Backend: PHP, organizado en Modelo-Vista-Controlador (MVC), con un enrutador propio en index.php que manda cada ruta a su controlador. No usé ningún framework de PHP.
- Base de datos: MySQL, con PDO y consultas parametrizadas (para evitar inyección SQL).
- Frontend: HTML5, CSS3 y JavaScript normal, sin frameworks como React o Vue.
- Mapas: Leaflet para el mapa de riesgos, y MapLibre GL JS para el terreno 3D de El Salvador en el inicio.
- 3D: Three.js para el modelo de la Luna, y globe.gl (que usa Three.js por debajo) para el globo del inicio.
- Animaciones: GSAP con ScrollTrigger para que las tarjetas aparezcan al hacer scroll.
- PDF: pdf.js, para mostrar la portada de cada PDF como imagen y para la previsualización en Recursos.
- IA: la API de Groq para el chatbot.
- Servidor: pensado para correr con WAMP, XAMPP o Laragon (Apache + MySQL + PHP).

-- APIS Y LIBRERÍAS QUE USÉ

- USGS Earthquake API: sismos recientes de la región
- Open-Meteo API: temperatura, humedad, presión y viento
- Sunrise-Sunset API: hora de amanecer y atardecer
- Groq API: respuestas del chatbot
- Leaflet: mapa de riesgos y capas de sismos, volcanes, tsunami, deslizamientos y zonas seguras
- MapLibre GL JS: mapa de terreno 3D de El Salvador
- Three.js / globe.gl: globo interactivo y modelo 3D de la Luna
- GSAP / ScrollTrigger: animaciones al hacer scroll
- pdf.js: portadas y previsualización de PDFs
- Google Translate (widget): traducción español/inglés
- Font Awesome, Google Fonts: íconos y tipografías

También enlazo como referencia (sin consumir su API) a fuentes oficiales como MARN El Salvador y Protección Civil.

-- CÓMO ESTÁ ORGANIZADO EL CÓDIGO

controllers/   La lógica de cada parte (sismos/clima, autenticación, chatbot, sensor,
                notificaciones, y todo lo del módulo escolar)
models/        Acceso a la base de datos (una clase por cada tipo de dato)
views/         Las plantillas HTML/PHP
  school/
    panels/    El panel de cada rol dentro de Gestión Escolar
    partials/  Pestañas y ventanas modales reutilizables que arman esos paneles
assets/css/    Estilos
assets/js/     JavaScript (un archivo por cada parte: página general, módulo escolar,
                chatbot, autenticación, notificaciones, traducción, mapas/3D, animaciones)
sql/           Scripts para crear/actualizar la base de datos
hardware/      Los programas de Arduino y Processing, y la guía de cableado del sensor

-- BASE DE DATOS

sql/nda_project.sql crea, desde cero, todas las tablas que necesita el proyecto: usuarios y roles, instituciones y solicitudes de ingreso, aulas y estudiantes, sismos, rutas de evacuación y zonas seguras, simulacros e incidentes, croquis del colegio y sus puntos, notas de corcho, blog de zonas de riesgo, lecturas del sensor, asistencia a simulacros, vínculos entre padres e hijos, noticias internas, la mochila de emergencia (con progreso por usuario, como un mini juego), puntajes de los juegos, y el blog público.

Si ya tenías una base de datos de antes y no quieres perder los datos, corre sql/migracion_completa.sql en vez de empezar de cero. sql/seed_demo_users.sql es opcional y crea una cuenta de prueba para cada rol.

-- CÓMO INSTALARLO

Instalación nueva (base de datos vacía):
1. Crea una base de datos vacía en MySQL (o deja que el script la cree solo: nda_project.sql ya trae CREATE DATABASE).
2. Importa sql/nda_project.sql completo. Con eso ya quedan creadas todas las tablas, no hace falta ningún otro archivo SQL.
3. (Opcional, útil para probar) Importa sql/seed_demo_users.sql para tener una cuenta de prueba de cada rol.
4. Copia .env.example como .env y pon tu GROQ_API_KEY y SENSOR_INGEST_TOKEN.
5. Pon los datos de tu base de datos en config.php (DB_HOST, DB_NAME, DB_USER, DB_PASS).
6. Copia los archivos a tu servidor (WAMP/XAMPP/Laragon) y ábrelo en el navegador.

Si ya tenías una base de datos y quieres conservar los datos:
Corre una sola vez sql/migracion_completa.sql. Ese archivo solo agrega lo nuevo, no borra nada.

Si te sale el error "Error al registrar una institución" o "Unknown column 'direccion'", es porque tu base de datos es de antes de que agregara los roles institucionales. Corre sql/migracion_completa.sql una vez, o si no te importa perder los datos de prueba, borra la base de datos y vuelve a importar sql/nda_project.sql desde cero.

-- SEGURIDAD

Nunca subas el archivo .env a un repositorio público: ahí está la API key de Groq y el token del sensor. Si alguna vez una key quedó expuesta en el código o en un zip que compartiste, revócala y crea una nueva antes de usarla en serio.
