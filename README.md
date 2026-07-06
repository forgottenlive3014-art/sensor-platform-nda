-- NATURAL DISASTER ALERT
Plataforma educativa para la prevencion de desastres naturales en El Salvador.

-- CARACTERÍSTICAS
- Monitor sismico en tiempo real con datos USGS
- Simulador de terremotos interactivo
- Modulo escolar con gestion de alumnos, secciones, croquis interactivo,
  tablero de corcho, rutas de evacuacion y alerta de simulacro en vivo
- Sistema de roles institucionales (director, docente, alumno, padre,
  administrativo) con aprobacion de solicitudes de ingreso
- Juegos educativos sobre prevencion
- Mapa de riesgos de El Salvador
- Chatbot con IA + navegacion por voz de comandos, historial persistente
- Traduccion ES/EN
- Sistema de autenticacion
- Modo oscuro/claro
- Integracion con sensor de vibracion (Arduino/ESP32 + Processing), ver /hardware

-- INSTALACIÓN (instalación nueva — base de datos vacía)
1. Crea una base de datos vacía en MySQL (o deja que el script la cree: nda_project.sql incluye CREATE DATABASE).
2. Importa sql/nda_project.sql completo. Esto crea TODAS las tablas ya con roles institucionales, gestión escolar y sensor incluidos — no necesitas ningún otro archivo SQL.
3. (Opcional pero recomendado para probar) Importa sql/seed_demo_users.sql para tener cuentas de prueba de cada rol.
4. Copia .env.example como .env y completa GROQ_API_KEY y SENSOR_INGEST_TOKEN.
5. Configura las credenciales de BD en config.php (DB_HOST, DB_NAME, DB_USER, DB_PASS).
6. Coloca los archivos en tu servidor web (XAMPP/WAMP/Laragon) y ábrelo desde el navegador.

-- ACTUALIZAR UNA BASE DE DATOS QUE YA EXISTÍA (con datos que quieres conservar)
Corre UNA sola vez: sql/migracion_completa.sql
(Este archivo agrega las columnas y tablas nuevas sin borrar tus datos.)

-- "Error al registrar una institución" / "Unknown column 'direccion'"
Ese error significa que tu base de datos es de ANTES de los roles institucionales
y todavía no tiene las columnas nuevas. Solución: corre sql/migracion_completa.sql
una vez (o, si no te importa perder los datos de prueba, borra la base de datos
y vuelve a importar sql/nda_project.sql desde cero — es la opción más simple).

-- TECNOLOGÍAS
- PHP 
- MySQL, Arquitectura MVC
- JavaScript
- HTML5 / CSS3
- Leaflet para mapas
- APIs: USGS, Open-Meteo, Groq
- Arduino IDE + Processing (puente serial -> HTTP) para el sensor de vibración
- Google Translate widget para el toggle ES/EN

-- ESTRUCTURA
- controllers/ - Logica de la aplicacion
- models/ - Acceso a base de datos
- views/ - Plantillas HTML
- assets/css/ - Estilos
- assets/js/ - JavaScript
- sql/ - Scripts de base de datos
- hardware/ - Sketches de Arduino y Processing + guía de cableado

-- NOTA
Proyecto educativo. Para emergencias reales, consultar fuentes oficiales (MARN, Proteccion Civil).

--IMPORTANTE (SEGURIDAD)
Nunca subas el archivo .env a un repositorio público: contiene la API key de Groq
y el token del sensor. Si una key de API quedó expuesta alguna vez en el código o
en un zip compartido, revócala y genera una nueva antes de usarla en producción.