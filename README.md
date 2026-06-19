-- NATURAL DISASTER ALERT
Plataforma educativa para la prevencion de desastres naturales en El Salvador.

-- CARACTERÍSTICAS
- Monitor sismico en tiempo real con datos USGS
- Simulador de terremotos interactivo
- Modulo escolar con gestion de alumnos y rutas de evacuacion
- Juegos educativos sobre prevencion
- Mapa de riesgos de El Salvador
- Chatbot con IA para consultas
- Sistema de autenticacion
- Modo oscuro/claro

-- INSTALACIÓN
1. Importar el archivo SQL en tu base de datos MySQL
2. Configurar las credenciales en config.php
3. Colocar los archivos en tu servidor web (XAMPP/WAMP/Laragon)
4. Abrir desde el navegador

-- TECNOLOGÍAS
- PHP 
- MySQL, Arquitectura MVC
- JavaScript
- HTML5 / CSS3
- Leaflet para mapas
- APIs: USGS, Open-Meteo, Groq

-- ESTRUCTURA
- controllers/ - Logica de la aplicacion
- models/ - Acceso a base de datos
- views/ - Plantillas HTML
- assets/css/ - Estilos
- assets/js/ - JavaScript
- sql/ - Scripts de base de datos

-- NOTA
Proyecto educativo. Para emergencias reales, consultar fuentes oficiales (MARN, Proteccion Civil).

--IMPORTANTE
Para activar el chatbot, dirigirse al archivo .env, donde encontrará la APIKEY de Groq, la cual debes copiar y modificar en el archivo controllers/ChatController.php en la línea 4, dentro de las comillas.