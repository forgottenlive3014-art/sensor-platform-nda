Natural Disaster Alert (NDA)

Natural Disaster Alert (NDA) es una página web sobre desastres naturales en El Salvador, desarrollada por un equipo de estudiantes. El proyecto se creó con el propósito de informar y educar a la población sobre cómo prevenir y actuar ante sismos, tormentas y otros desastres, utilizando datos reales en vez de solo texto.

Se propone reunir en un solo lugar elementos que normalmente están separados: datos de sismos, del clima y de la luna, guías de qué hacer en una emergencia, y hasta un módulo para que un colegio administre sus propios simulacros de evacuación. Para los datos en tiempo real (sismos, clima, amanecer y atardecer) se utilizan APIs gratuitas ya existentes, sin generar datos propios.

Se trata de un proyecto educativo, no de un sistema oficial. Ante una emergencia real, siempre se debe recurrir a las fuentes oficiales correspondientes (MARN, Protección Civil).

-- CONTENIDO
1. Secciones de la página
2. Módulo de Gestión Escolar
3. Chatbot con IA
4. Cuentas y roles
5. Sensor de vibración con Arduino
6. Con qué está hecho
7. APIs y librerías utilizadas
8. Cómo está organizado el código
9. Base de datos
10. Cómo instalarlo
11. Seguridad

-- SECCIONES DE LA PÁGINA

Inicio
Es la página principal. Cuenta con un globo terráqueo en 3D que se recorre haciendo scroll: se comienza mostrando todo el planeta, se avanza acercándose a Centroamérica y se termina en un mapa con el relieve real de El Salvador. También se muestran las placas tectónicas que originan los sismos en el país, una línea de tiempo con desastres históricos, y tarjetas de acceso rápido a las demás secciones.

Sismos
Se explica de forma sencilla qué es un sismo, la diferencia entre magnitud e intensidad, y cómo funciona un sismógrafo (con una animación de cómo viajan las ondas P y S). Incluye:
- Un mapa de El Salvador (con Leaflet) donde se pueden activar y desactivar capas: zonas sísmicas, volcanes, sismos recientes, riesgo de tsunami, deslizamientos y zonas seguras.
- Un monitor con estadísticas del día (sismos registrados, última magnitud, profundidad) y una animación que muestra cuánto "tiembla" un edificio según la intensidad.
- Un sismógrafo interactivo: se puede elegir una magnitud (leve, moderado, fuerte, terremoto grande) o mover un control y observar la traza dibujarse en tiempo real, como en un sismógrafo real.
- Una lista de los sismos más recientes de la región, obtenida directamente de la API de USGS.
- Un simulador donde se ajustan la magnitud, la profundidad y la distancia al epicentro para observar cómo cambia el efecto.

Monitoreo (Tiempo Real)
Reúne varios datos en tiempo real: temperatura, humedad, presión y viento de distintas ciudades de El Salvador; la hora del amanecer y el atardecer; la fase lunar del día con un modelo 3D que se ilumina según la fase real; información sobre el riesgo de tsunami en la costa; y una sección que muestra en vivo lo captado por el sensor de vibración físico (si está conectado; de lo contrario, la página continúa funcionando en modo demostración con los demás datos).

Gestión Escolar
Se explica con más detalle en su propia sección, más adelante en este documento.

Blog
Incluye artículos de prevención elaborados para el proyecto (como "Agáchate, cúbrete y agárrate" o qué llevar en la mochila de emergencia), además de resúmenes de noticias de desastres reales ocurridos en El Salvador y la región (el terremoto de 2001, la erupción del volcán Santa Ana, las tormentas Ida, Amanda y Cristóbal, el huracán Julia, entre otros), cada uno con su fuente y fecha correspondiente.

Juegos Educativos
Trivias y actividades interactivas propuestas para repasar de forma más entretenida lo que se debe saber sobre seguridad y evacuación.

¿Qué hacer AHORA?
Una guía rápida de qué hacer antes, durante y después de un desastre: cómo evacuar, qué llevar en la mochila de 72 horas, números de emergencia y consejos prácticos.

Recursos Educativos
Guías en PDF disponibles para descargar (evacuación escolar, mochila de emergencia, plan familiar, preparación ante sismos, protocolo de lluvias), organizadas por categoría. Cada una muestra la portada real del PDF como miniatura (generada directamente en el navegador, no se trata de una imagen cargada manualmente) y permite previsualizar el documento completo en una ventana sin salir de la página.

Acerca de NDA
Información sobre el proyecto y los creadores del sitio web.

-- MÓDULO DE GESTIÓN ESCOLAR

Corresponde a la parte más extensa del proyecto. Se propone que un colegio administre su propio plan de prevención y respuesta ante emergencias. Lo que se puede ver y hacer varía según el rol del usuario:
- Administrador General: visualiza y administra todas las instituciones y usuarios del sistema.
- Administrador Institucional (Director/a): administra su propio colegio: aprueba solicitudes de ingreso, personal, aulas, rutas, simulacros, reportes, entre otros.
- Docente: registra asistencia, reporta incidentes y consulta su aula o sección asignada.
- Estudiante: consulta su aula, su historial de asistencia a simulacros y las alertas activas.
- Padre o madre de familia: consulta el estado de sus hijos vinculados durante los simulacros.

Lo que se puede administrar desde este módulo:
- Instituciones y usuarios, mediante un sistema de solicitud y aprobación para unirse a un colegio.
- Estudiantes, docentes, personal administrativo y padres de familia, incluyendo la vinculación entre un padre y su hijo.
- Aulas y secciones (incluye las 18 secciones de bachillerato y el docente asignado a cada una).
- Rutas de evacuación y zonas seguras de cada colegio.
- Croquis interactivo: un plano del colegio donde se marcan puntos importantes (salidas, puntos de encuentro, extintores, entre otros), incluso subiendo una imagen de fondo propia.
- Tablero de corcho: notas para la coordinación entre el personal.
- Simulacros: se crean y programan, y se puede activar una alerta en vivo que todos observan en tiempo real mientras dura el simulacro.
- Asistencia: se registra por simulacro, y cada estudiante (o su padre o madre) puede consultar su propio historial.
- Incidentes: se reportan y se les da seguimiento.
- Noticias internas del colegio.
- Notificaciones: se envían a un usuario, a todo un colegio o a todos, con un nivel de urgencia definido, y aparecen en la campanita de notificaciones del sitio.
- Reportes: estadísticas del colegio (por ejemplo, de asistencia).

-- CHATBOT CON IA

Se incluye un asistente flotante disponible en toda la página. Primero se revisa si lo escrito por el usuario coincide con una instrucción reconocida de navegación (por ejemplo, "llévame a tal sección"), para dirigirlo directamente ahí. Si no es el caso, la consulta se envía a la inteligencia artificial (se utiliza la API de Groq, con el modelo llama-3.3-70b-versatile), a la cual se le proporciona un contexto con datos reales de El Salvador (la subducción de la Placa de Cocos, la Falla Metrópolis, volcanes, sismos históricos) para evitar que genere información incorrecta. El historial de la conversación se guarda en el navegador del usuario.

-- CUENTAS Y ROLES

Se cuenta con registro e inicio de sesión, incluyendo un asistente de varios pasos para el registro (tipo de cuenta, rol dentro del colegio, institución, datos personales). También se puede editar el perfil y solicitar el ingreso a una institución. Cada usuario visualiza únicamente lo que corresponde a su rol (Administrador General, Administrador Institucional, Docente, Estudiante, Padre/Madre, Personal Administrativo). Adicionalmente, se ofrece modo claro/oscuro y traducción español/inglés.

-- SENSOR DE VIBRACIÓN CON ARDUINO

Esta parte se propuso con fines educativos, para demostrar cómo se podría detectar un movimiento sísmico con hardware real. No sustituye a los sistemas oficiales de alerta temprana. Su funcionamiento es el siguiente:
1. Un sensor MPU-6050 (mide aceleración y giro en 3 ejes), conectado por I2C a un Arduino o un ESP32, capta la vibración y la envía por el puerto serial.
2. Un programa desarrollado en Processing lee esos datos del puerto serial y los envía por HTTP a la página (a la ruta ?url=sensor/ingest), utilizando un token para evitar que se envíen datos falsos.
3. La página guarda cada lectura (se conservan solo las últimas 500) y las compara con dos límites: precaución desde 0.3 G y alerta desde 0.8 G. Si se supera 0.8 G, se genera una notificación automática para todo el colegio, de la misma forma que si se activara manualmente con el botón "Simular Alerta".
4. La página consulta periódicamente la ruta ?url=sensor/latest y muestra la lectura en vivo en Monitoreo. Si el sensor no está conectado, esa sección continúa mostrando el resto de los datos reales en modo demostración.

La guía completa sobre cómo conectar los cables, qué programa instalar y cómo resolver problemas se encuentra en hardware/README.md.

-- CON QUÉ ESTÁ HECHO

- Backend: PHP, organizado en Modelo-Vista-Controlador (MVC), con un enrutador propio en index.php que dirige cada ruta a su controlador correspondiente. No se utilizó ningún framework de PHP.
- Base de datos: MySQL, con PDO y consultas parametrizadas, para evitar inyección SQL.
- Frontend: HTML5, CSS3 y JavaScript, sin frameworks como React o Vue.
- Mapas: Leaflet para el mapa de riesgos, y MapLibre GL JS para el terreno 3D de El Salvador en el inicio.
- 3D: Three.js para el modelo de la Luna, y globe.gl (que utiliza Three.js internamente) para el globo del inicio.
- Animaciones: GSAP con ScrollTrigger, para que las tarjetas aparezcan al hacer scroll.
- PDF: pdf.js, para mostrar la portada de cada PDF como imagen y para la previsualización en Recursos.
- IA: la API de Groq para el chatbot.
- Servidor: pensado para ejecutarse con WAMP, XAMPP o Laragon (Apache + MySQL + PHP).

-- APIS Y LIBRERÍAS UTILIZADAS

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

También se enlaza como referencia (sin consumir su API) a fuentes oficiales como MARN El Salvador y Protección Civil.

-- CÓMO ESTÁ ORGANIZADO EL CÓDIGO

controllers/   La lógica de cada parte (sismos/clima, autenticación, chatbot, sensor,
                notificaciones, y todo lo relacionado con el módulo escolar)
models/        Acceso a la base de datos (una clase por cada tipo de dato)
views/         Las plantillas HTML/PHP
  school/
    panels/    El panel de cada rol dentro de Gestión Escolar
    partials/  Pestañas y ventanas modales reutilizables que conforman esos paneles
assets/css/    Estilos
assets/js/     JavaScript (un archivo por cada parte: página general, módulo escolar,
                chatbot, autenticación, notificaciones, traducción, mapas/3D, animaciones)
sql/           Scripts para crear y actualizar la base de datos
hardware/      Los programas de Arduino y Processing, y la guía de cableado del sensor

-- BASE DE DATOS

El archivo sql/nda_project.sql crea, desde cero, todas las tablas que requiere el proyecto: usuarios y roles, instituciones y solicitudes de ingreso, aulas y estudiantes, sismos, rutas de evacuación y zonas seguras, simulacros e incidentes, croquis del colegio y sus puntos, notas de corcho, blog de zonas de riesgo, lecturas del sensor, asistencia a simulacros, vínculos entre padres e hijos, noticias internas, la mochila de emergencia (con progreso por usuario, a manera de mini juego), puntajes de los juegos, y el blog público.

En caso de contar ya con una base de datos previa y desear conservar los datos existentes, se debe ejecutar sql/migracion_completa.sql en lugar de comenzar desde cero. El archivo sql/seed_demo_users.sql es opcional y crea una cuenta de prueba para cada rol.

-- CÓMO INSTALARLO

Instalación nueva (base de datos vacía):
1. Se debe crear una base de datos vacía en MySQL (o bien permitir que el script la genere automáticamente, ya que nda_project.sql incluye la instrucción CREATE DATABASE).
2. Se debe importar sql/nda_project.sql completo. Con esto quedan creadas todas las tablas necesarias, sin requerir ningún otro archivo SQL.
3. (Opcional, útil para pruebas) Importar sql/seed_demo_users.sql para contar con una cuenta de prueba de cada rol.
4. Copiar .env.example como .env y completar GROQ_API_KEY y SENSOR_INGEST_TOKEN.
5. Configurar los datos de la base de datos en config.php (DB_HOST, DB_NAME, DB_USER, DB_PASS).
6. Copiar los archivos al servidor (WAMP/XAMPP/Laragon) y abrirlo en el navegador.

Si ya se contaba con una base de datos y se desea conservar los datos:
Se debe ejecutar una sola vez sql/migracion_completa.sql. Ese archivo únicamente agrega lo nuevo, sin eliminar información existente.

Si aparece el error "Error al registrar una institución" o "Unknown column 'direccion'", se debe a que la base de datos corresponde a una versión anterior a la incorporación de los roles institucionales. Se recomienda ejecutar sql/migracion_completa.sql una vez, o bien, si no es relevante conservar los datos de prueba, eliminar la base de datos y volver a importar sql/nda_project.sql desde cero.

-- SEGURIDAD

- Contraseñas: se almacenan con password_hash() (bcrypt); no se guardan en texto plano.
- Correo electrónico: además de validar el formato, se verifica que el dominio cuente con un registro MX (o A/AAAA) real, para descartar dominios inventados.
- CSRF: los formularios incluyen un token de sesión que se valida en cada envío.
- Consultas SQL: se utilizan sentencias preparadas (PDO) en toda la aplicación, para evitar inyección SQL.
- Roles y permisos: cada endpoint verifica el rol del usuario en el servidor antes de responder; los permisos no dependen únicamente de ocultar opciones en la interfaz.
- Inicio de sesión con Google: el token recibido se verifica directamente contra los servidores de Google antes de aceptar la sesión, y las cuentas creadas por esta vía nunca reciben permisos de administrador.
