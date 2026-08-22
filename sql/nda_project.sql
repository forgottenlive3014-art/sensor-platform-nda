-- ============================================================
-- NDA — Esquema completo. Un solo archivo, correr una vez sobre
-- una base vacia. Motor: MyISAM (default del servidor); FOREIGN KEY
-- se deja solo como documentacion de relaciones, MyISAM no la aplica.
-- Orden: catalogo -> gestion escolar -> desastres/sensor ->
-- notificaciones/interacciones -> CMS -> gamificacion -> seeds.
-- ============================================================

CREATE DATABASE IF NOT EXISTS nda_project;
USE nda_project;

-- ------------------------------------------------------------
-- Catalogo: instituciones y usuarios
-- ------------------------------------------------------------

CREATE TABLE instituciones (
    instituciones_id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100),
    tipo ENUM('colegio','escuela','instituto','universidad','otro') NOT NULL DEFAULT 'colegio',
    correo VARCHAR(255),
    correo_director_personal VARCHAR(100) NULL,
    estado_verificacion ENUM('pendiente','verificado') NOT NULL DEFAULT 'verificado',
    codigo_verificacion VARCHAR(6) NULL,
    codigo_verificacion_expira DATETIME NULL,
    telefono VARCHAR(20),
    logo VARCHAR(255),
    direccion VARCHAR(255) NULL,
    lat DECIMAL(10,7) NULL,
    lng DECIMAL(10,7) NULL,
    director_id INT NULL,
    nombre_director VARCHAR(120) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE usuarios (
    usuarios_id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100),
    username VARCHAR(20) NULL UNIQUE, -- alias corto para el navbar; nulo hasta configurarlo
    email VARCHAR(100) UNIQUE,
    contra VARCHAR(255),
    email_verificado TINYINT(1) NOT NULL DEFAULT 0,
    codigo_verificacion_email VARCHAR(6) NULL,
    codigo_verificacion_email_expira DATETIME NULL,
    role ENUM('user','admin','director','docente','alumno','padre','administrativo') DEFAULT 'user',
    codigo_institucional VARCHAR(12) NULL UNIQUE, -- reservada, sin uso actual en los controllers
    institucion_id INT NULL,
    estado_institucional ENUM('ninguno','pendiente','aprobado','rechazado') DEFAULT 'ninguno',
    telefono VARCHAR(20) NULL,
    materia VARCHAR(100) NULL,
    foto_perfil VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (institucion_id) REFERENCES instituciones(instituciones_id) ON DELETE SET NULL
);

CREATE TABLE solicitudes_institucion (
    solicitudes_institucion_id INT PRIMARY KEY AUTO_INCREMENT,
    usuarios_id INT,
    instituciones_id INT,
    rol_solicitado ENUM('docente','alumno','padre','administrativo') NOT NULL,
    estado ENUM('pendiente','aprobado','rechazado') DEFAULT 'pendiente',
    mensaje VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    resolved_at TIMESTAMP NULL,
    FOREIGN KEY (usuarios_id) REFERENCES usuarios(usuarios_id) ON DELETE CASCADE,
    FOREIGN KEY (instituciones_id) REFERENCES instituciones(instituciones_id) ON DELETE CASCADE
);

-- ------------------------------------------------------------
-- Gestion escolar
-- ------------------------------------------------------------

CREATE TABLE aulas (
    aulas_id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50),
    grado VARCHAR(50),
    nivel VARCHAR(20),
    seccion VARCHAR(5),
    instituciones_id INT,
    maestro_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (instituciones_id) REFERENCES instituciones(instituciones_id) ON DELETE CASCADE,
    FOREIGN KEY (maestro_id) REFERENCES usuarios(usuarios_id) ON DELETE SET NULL
);

CREATE TABLE estudiantes (
    estudiantes_id INT PRIMARY KEY AUTO_INCREMENT,
    codigo VARCHAR(20) UNIQUE,
    usuarios_id INT,
    aulas_id INT,
    nombre VARCHAR(100),
    apellido VARCHAR(100),
    edad INT,
    telefono_emergencia VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuarios_id) REFERENCES usuarios(usuarios_id) ON DELETE CASCADE,
    FOREIGN KEY (aulas_id) REFERENCES aulas(aulas_id) ON DELETE CASCADE
);

CREATE TABLE padres_estudiantes (
    padres_estudiantes_id INT PRIMARY KEY AUTO_INCREMENT,
    padre_usuario_id INT NOT NULL,
    estudiante_id INT NOT NULL,
    parentesco VARCHAR(30) DEFAULT 'padre/madre',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_padre_estudiante (padre_usuario_id, estudiante_id),
    FOREIGN KEY (padre_usuario_id) REFERENCES usuarios(usuarios_id) ON DELETE CASCADE,
    FOREIGN KEY (estudiante_id) REFERENCES estudiantes(estudiantes_id) ON DELETE CASCADE
);

CREATE TABLE croquis_institucion (
    croquis_institucion_id INT PRIMARY KEY AUTO_INCREMENT,
    instituciones_id INT UNIQUE,
    imagen VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (instituciones_id) REFERENCES instituciones(instituciones_id) ON DELETE CASCADE
);

CREATE TABLE puntos_croquis (
    puntos_croquis_id INT PRIMARY KEY AUTO_INCREMENT,
    instituciones_id INT,
    tipo ENUM('encuentro','zona_segura','extintor','botiquin','salida','otro') DEFAULT 'otro',
    nombre VARCHAR(100),
    descripcion VARCHAR(255) NULL,
    pos_x DECIMAL(5,2) NOT NULL,
    pos_y DECIMAL(5,2) NOT NULL,
    creado_por INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (instituciones_id) REFERENCES instituciones(instituciones_id) ON DELETE CASCADE,
    FOREIGN KEY (creado_por) REFERENCES usuarios(usuarios_id) ON DELETE SET NULL
);

CREATE TABLE corcho_notas (
    corcho_notas_id INT PRIMARY KEY AUTO_INCREMENT,
    instituciones_id INT,
    usuarios_id INT,
    texto VARCHAR(280) NOT NULL,
    color VARCHAR(20) DEFAULT 'amarillo',
    pos_x DECIMAL(5,2) DEFAULT 10,
    pos_y DECIMAL(5,2) DEFAULT 10,
    rotacion DECIMAL(4,1) DEFAULT 0,
    visibilidad VARCHAR(150) DEFAULT 'todos', -- 'todos' o roles separados por coma, ej. 'docente,alumno'
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (instituciones_id) REFERENCES instituciones(instituciones_id) ON DELETE CASCADE,
    FOREIGN KEY (usuarios_id) REFERENCES usuarios(usuarios_id) ON DELETE CASCADE
);

CREATE TABLE noticias_internas (
    noticias_internas_id INT PRIMARY KEY AUTO_INCREMENT,
    instituciones_id INT NULL,
    usuarios_id INT NOT NULL,
    titulo VARCHAR(150) NOT NULL,
    resumen VARCHAR(300) NULL,
    contenido TEXT NOT NULL,
    imagen VARCHAR(255) NULL,
    estado ENUM('borrador','publicada') NOT NULL DEFAULT 'publicada', -- usada por los seeds; sin migracion propia (mismo caso que estado_verificacion en instituciones)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (instituciones_id) REFERENCES instituciones(instituciones_id) ON DELETE CASCADE,
    FOREIGN KEY (usuarios_id) REFERENCES usuarios(usuarios_id) ON DELETE CASCADE
);

CREATE TABLE blog_riesgos (
    blog_riesgos_id INT PRIMARY KEY AUTO_INCREMENT,
    instituciones_id INT NOT NULL,
    usuarios_id INT NOT NULL,
    titulo VARCHAR(150) NOT NULL,
    descripcion TEXT NOT NULL,
    ubicacion VARCHAR(150) NULL,
    imagen VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (instituciones_id) REFERENCES instituciones(instituciones_id) ON DELETE CASCADE,
    FOREIGN KEY (usuarios_id) REFERENCES usuarios(usuarios_id) ON DELETE CASCADE
);

-- ------------------------------------------------------------
-- Desastres, rutas de evacuacion y sensor de vibracion
-- ------------------------------------------------------------

CREATE TABLE sismos (
    sismos_id INT PRIMARY KEY AUTO_INCREMENT,
    magnitud DECIMAL(4,2),
    lugar VARCHAR(255),
    fecha DATETIME,
    latitud DECIMAL(10,8),
    longitud DECIMAL(11,8),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE rutas_evacuacion (
    rutas_evacuacion_id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100),
    descripcion TEXT,
    instituciones_id INT,
    estado VARCHAR(20) DEFAULT 'despejada',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    lat DECIMAL(10,7) NULL, -- opcional, para ubicarla en el mapa Leaflet del tab "Rutas"
    lng DECIMAL(10,7) NULL,
    FOREIGN KEY (instituciones_id) REFERENCES instituciones(instituciones_id) ON DELETE CASCADE
);

CREATE TABLE zonas_seguras (
    zonas_seguras_id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100),
    ubicacion VARCHAR(255),
    instituciones_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (instituciones_id) REFERENCES instituciones(instituciones_id) ON DELETE CASCADE
);

CREATE TABLE simulacros (
    simulacros_id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100),
    fecha DATE,
    hora TIME,
    instituciones_id INT,
    estado ENUM('programado','activo','finalizado') DEFAULT 'programado',
    descripcion VARCHAR(255) NULL,
    tipo VARCHAR(50) DEFAULT 'Sísmico',
    activado_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (instituciones_id) REFERENCES instituciones(instituciones_id) ON DELETE CASCADE
);

CREATE TABLE asistencia_simulacros (
    asistencia_simulacros_id INT PRIMARY KEY AUTO_INCREMENT,
    simulacros_id INT,
    estudiantes_id INT,
    estado ENUM('presente','ausente','herido') DEFAULT 'presente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_simulacro_estudiante (simulacros_id, estudiantes_id),
    FOREIGN KEY (simulacros_id) REFERENCES simulacros(simulacros_id) ON DELETE CASCADE,
    FOREIGN KEY (estudiantes_id) REFERENCES estudiantes(estudiantes_id) ON DELETE CASCADE
);

CREATE TABLE incidentes (
    incidentes_id INT PRIMARY KEY AUTO_INCREMENT,
    tipo VARCHAR(50) NOT NULL,
    descripcion TEXT,
    ubicacion VARCHAR(150) NULL,
    imagen VARCHAR(255) NULL,
    usuario_id INT,
    instituciones_id INT NULL,
    prioridad ENUM('baja','media','alta') DEFAULT 'media',
    estado ENUM('abierto','resuelto') DEFAULT 'abierto',
    resuelto_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(usuarios_id) ON DELETE SET NULL,
    FOREIGN KEY (instituciones_id) REFERENCES instituciones(instituciones_id) ON DELETE CASCADE
);

CREATE TABLE lecturas_sensor (
    lecturas_sensor_id INT PRIMARY KEY AUTO_INCREMENT,
    intensidad DECIMAL(5,2) NOT NULL,
    nivel ENUM('normal','precaucion','alerta') DEFAULT 'normal',
    eje_x DECIMAL(6,3) NULL,
    eje_y DECIMAL(6,3) NULL,
    eje_z DECIMAL(6,3) NULL,
    fuente VARCHAR(40) DEFAULT 'arduino-processing',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ------------------------------------------------------------
-- Notificaciones e interacciones (likes/comentarios genericos)
-- ------------------------------------------------------------

CREATE TABLE notificaciones (
    notificaciones_id INT PRIMARY KEY AUTO_INCREMENT,
    tipo ENUM('sismica','escolar','sensor','sistema') NOT NULL,
    severidad ENUM('seguro','informativo','precaucion','alerta','emergencia') NOT NULL DEFAULT 'informativo',
    destinatario_usuario_id INT NULL,
    destinatario_institucion_id INT NULL,
    es_global BOOLEAN NOT NULL DEFAULT FALSE,
    mensaje VARCHAR(255) NOT NULL,
    referencia_tipo VARCHAR(40) NULL, -- ej. 'lecturas_sensor', 'simulacros'
    referencia_id INT NULL,
    leida BOOLEAN NOT NULL DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (destinatario_usuario_id) REFERENCES usuarios(usuarios_id) ON DELETE CASCADE,
    FOREIGN KEY (destinatario_institucion_id) REFERENCES instituciones(instituciones_id) ON DELETE CASCADE,
    INDEX idx_notif_usuario (destinatario_usuario_id, leida),
    INDEX idx_notif_institucion (destinatario_institucion_id, leida),
    INDEX idx_notif_global (es_global, leida)
);

-- Genericas por tipo_contenido + contenido_id, para no triplicar esquema
-- por cada tipo de contenido (noticia/riesgo/incidente).
CREATE TABLE interacciones_likes (
    interacciones_likes_id INT PRIMARY KEY AUTO_INCREMENT,
    tipo_contenido ENUM('noticia','riesgo','incidente') NOT NULL,
    contenido_id INT NOT NULL,
    usuarios_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_like (tipo_contenido, contenido_id, usuarios_id),
    FOREIGN KEY (usuarios_id) REFERENCES usuarios(usuarios_id) ON DELETE CASCADE,
    INDEX idx_contenido (tipo_contenido, contenido_id)
);

CREATE TABLE interacciones_comentarios (
    interacciones_comentarios_id INT PRIMARY KEY AUTO_INCREMENT,
    tipo_contenido ENUM('noticia','riesgo','incidente') NOT NULL,
    contenido_id INT NOT NULL,
    usuarios_id INT NOT NULL,
    texto VARCHAR(500) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuarios_id) REFERENCES usuarios(usuarios_id) ON DELETE CASCADE,
    INDEX idx_contenido (tipo_contenido, contenido_id)
);

-- ------------------------------------------------------------
-- CMS del Admin General: blog publico y recursos PDF
-- ------------------------------------------------------------

CREATE TABLE blog (
    blog_id INT PRIMARY KEY AUTO_INCREMENT,
    slug VARCHAR(150) NOT NULL DEFAULT '',
    titulo VARCHAR(200),
    cat VARCHAR(30) NOT NULL DEFAULT 'prevencion',
    tag VARCHAR(40) NOT NULL DEFAULT '',
    color VARCHAR(7) NOT NULL DEFAULT '#f29f05',
    contenido TEXT,
    cuerpo LONGTEXT NULL,
    autor_id INT,
    autor_nombre VARCHAR(120) NOT NULL DEFAULT 'Equipo NDA',
    tiempo VARCHAR(20) NOT NULL DEFAULT '5 min',
    destacado TINYINT(1) NOT NULL DEFAULT 0,
    extracto VARCHAR(300) NOT NULL DEFAULT '',
    imagen VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_blog_slug (slug),
    FOREIGN KEY (autor_id) REFERENCES usuarios(usuarios_id) ON DELETE CASCADE
);

CREATE TABLE recursos (
    recursos_id INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(150) NOT NULL,
    descripcion VARCHAR(300) NULL,
    categoria VARCHAR(30) NOT NULL,
    tags VARCHAR(150) NULL,
    archivo VARCHAR(255) NOT NULL,
    tamano_bytes INT NULL,
    orden INT NOT NULL DEFAULT 0,
    usuarios_id INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE contenido_paginas (
    contenido_paginas_id INT PRIMARY KEY AUTO_INCREMENT,
    pagina VARCHAR(30) NOT NULL,
    campo VARCHAR(100) NOT NULL,
    valor TEXT NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_pagina_campo (pagina, campo)
);

-- ------------------------------------------------------------
-- Gamificacion
-- ------------------------------------------------------------

CREATE TABLE items_mochila (
    items_mochila_id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    imagen VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE mochila_usuario (
    mochila_usuario_id INT PRIMARY KEY AUTO_INCREMENT,
    usuarios_id INT,
    items_mochila_id INT,
    cantidad INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuarios_id) REFERENCES usuarios(usuarios_id) ON DELETE CASCADE,
    FOREIGN KEY (items_mochila_id) REFERENCES items_mochila(items_mochila_id) ON DELETE CASCADE
);

CREATE TABLE puntajes_juegos (
    puntajes_juegos_id INT PRIMARY KEY AUTO_INCREMENT,
    usuarios_id INT,
    juego_nombre VARCHAR(50),
    puntaje INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuarios_id) REFERENCES usuarios(usuarios_id) ON DELETE CASCADE
);


-- ============================================================
-- SEEDS — datos de ejemplo. Opcional: si vas a produccion, corta
-- el script aqui y no ejecutes lo que sigue.
-- ============================================================

-- Superadmin unico (no se registra desde el formulario publico).
-- Cambia el correo/contraseña antes de usarlo en serio.
INSERT INTO usuarios (nombre, email, contra, role, email_verificado) VALUES
('Super Administrador', 'admin@nda.com', SHA2('CambiaEsto2026!', 256), 'admin', 1);

-- Instituciones demo (San José=1, Santa Ana=2, Don Bosco=3)
INSERT INTO instituciones (nombre, correo, telefono, logo) VALUES
('Colegio San José', 'info@colegiosanjose.edu.sv', '2233-4455', 'logo_sanjose.png'),
('Colegio Santa Ana', 'info@colegiosantaana.edu.sv', '2244-5566', 'logo_santaana.png'),
('Colegio Don Bosco', 'info@donbosco.edu.sv', '2255-6677', 'logo_donbosco.png');

INSERT INTO aulas (nombre, grado, nivel, seccion, instituciones_id) VALUES
('1° A','Primero','Bachillerato','A',1),('1° B','Primero','Bachillerato','B',1),('1° C','Primero','Bachillerato','C',1),
('1° D','Primero','Bachillerato','D',1),('1° E','Primero','Bachillerato','E',1),('1° F','Primero','Bachillerato','F',1),
('2° A','Segundo','Bachillerato','A',1),('2° B','Segundo','Bachillerato','B',1),('2° C','Segundo','Bachillerato','C',1),
('2° D','Segundo','Bachillerato','D',1),('2° E','Segundo','Bachillerato','E',1),('2° F','Segundo','Bachillerato','F',1),
('3° A','Tercero','Bachillerato','A',1),('3° B','Tercero','Bachillerato','B',1),('3° C','Tercero','Bachillerato','C',1),
('3° D','Tercero','Bachillerato','D',1),('3° E','Tercero','Bachillerato','E',1),('3° F','Tercero','Bachillerato','F',1),
('1° A','Primero','Bachillerato','A',2),('1° B','Primero','Bachillerato','B',2),('1° C','Primero','Bachillerato','C',2),
('2° A','Segundo','Bachillerato','A',2),('2° B','Segundo','Bachillerato','B',2),('2° C','Segundo','Bachillerato','C',2),
('3° A','Tercero','Bachillerato','A',2),('3° B','Tercero','Bachillerato','B',2),('3° C','Tercero','Bachillerato','C',2),
('1° A','Primero','Bachillerato','A',3),('1° B','Primero','Bachillerato','B',3),('1° C','Primero','Bachillerato','C',3),
('2° A','Segundo','Bachillerato','A',3),('2° B','Segundo','Bachillerato','B',3),('2° C','Segundo','Bachillerato','C',3),
('3° A','Tercero','Bachillerato','A',3),('3° B','Tercero','Bachillerato','B',3),('3° C','Tercero','Bachillerato','C',3);

INSERT INTO estudiantes (codigo, usuarios_id, aulas_id, nombre, apellido, edad, telefono_emergencia) VALUES
('2025001',3,1,'María','García',15,'7777-1111'),('2025002',3,1,'José','López',15,'7777-1112'),
('2025003',3,1,'Ana','Martínez',15,'7777-1113'),('2025004',3,1,'Luis','Rodríguez',15,'7777-1114'),
('2025005',3,1,'Laura','Sánchez',15,'7777-1115'),('2025006',3,2,'Carlos','Pérez',15,'7777-1121'),
('2025007',3,2,'Elena','Gómez',15,'7777-1122'),('2025008',3,2,'Miguel','Fernández',15,'7777-1123'),
('2025009',3,3,'Sofía','Díaz',15,'7777-1131'),('2025010',3,3,'Diego','Ramírez',15,'7777-1132'),
('2025011',3,7,'Andrea','Torres',16,'7777-2211'),('2025012',3,7,'Javier','Flores',16,'7777-2212'),
('2025013',3,7,'Valentina','Ramos',16,'7777-2213'),('2025014',3,7,'Fernando','Ortiz',16,'7777-2214'),
('2025015',3,8,'Daniela','Castro',16,'7777-2221'),('2025016',3,8,'Andrés','Morales',16,'7777-2222'),
('2025017',3,13,'Paula','Mendoza',17,'7777-3311'),('2025018',3,13,'Ricardo','Herrera',17,'7777-3312'),
('2025019',3,13,'Camila','Vargas',17,'7777-3313'),('2025020',3,14,'Pablo','Jiménez',17,'7777-3321'),
('2025021',3,14,'Valeria','Molina',17,'7777-3322');

INSERT INTO sismos (magnitud, lugar, fecha, latitud, longitud) VALUES
(4.2,'San Miguel','2025-01-15 08:30:00',13.4833,-88.1833),
(3.8,'Santa Ana','2025-01-12 14:20:00',13.9942,-89.5597),
(5.1,'La Libertad','2025-01-10 22:15:00',13.4890,-89.3220),
(2.5,'San Salvador','2025-01-08 06:45:00',13.6900,-89.1900),
(4.5,'Usulután','2025-01-05 11:30:00',13.3494,-88.4563),
(3.2,'Sonsonate','2025-01-03 19:10:00',13.7189,-89.7242),
(6.0,'Ahuachapán','2024-12-28 03:00:00',13.9214,-89.8450),
(4.8,'San Vicente','2024-12-20 16:30:00',13.6433,-88.7897);

INSERT INTO rutas_evacuacion (nombre, descripcion, instituciones_id) VALUES
('Ruta 1 - Salida Principal', 'Por la puerta principal hacia el parque central', 1),
('Ruta 2 - Salida Lateral', 'Por el pasillo norte hacia la cancha', 1),
('Ruta 3 - Salida de Emergencia', 'Por las gradas hacia el patio trasero', 1),
('Ruta Principal', 'Desde el edificio A hacia el campo de futbol', 2),
('Ruta Secundaria', 'Desde el edificio B hacia la plaza', 2),
('Ruta de Evacuación Norte', 'Salida por la puerta norte del colegio', 3);

INSERT INTO zonas_seguras (nombre, ubicacion, instituciones_id) VALUES
('Zona 1 - Parque Central', 'Frente al colegio, en el parque', 1),
('Zona 2 - Cancha de Futbol', 'Detrás del colegio', 1),
('Zona 3 - Patio Trasero', 'Zona amplia sin construcciones', 1),
('Zona Segura A', 'Campo de futbol', 2),
('Zona Segura B', 'Plaza principal', 2),
('Zona de Encuentro Norte', 'Área verde al norte', 3);

INSERT INTO simulacros (nombre, fecha, hora, instituciones_id) VALUES
('Simulacro 1 - Primer Trimestre', '2025-02-15', '09:00:00', 1),
('Simulacro 2 - Segundo Trimestre', '2025-05-20', '10:30:00', 1),
('Simulacro 3 - Tercer Trimestre', '2025-08-25', '08:45:00', 1),
('Simulacro Anual', '2025-10-10', '09:00:00', 2),
('Simulacro de Evacuación', '2025-11-15', '10:00:00', 3);

INSERT INTO asistencia_simulacros (simulacros_id, estudiantes_id, estado) VALUES
(1,1,'presente'),(1,2,'presente'),(1,3,'presente'),(1,4,'ausente'),(1,5,'presente'),
(1,6,'presente'),(1,7,'herido'),(1,8,'presente'),
(2,1,'presente'),(2,2,'presente'),(2,3,'ausente'),(2,4,'presente'),(2,5,'presente'),(2,6,'presente'),
(3,1,'presente'),(3,2,'presente'),(3,3,'presente'),(3,4,'presente'),(3,5,'presente'),
(3,6,'presente'),(3,7,'presente'),(3,8,'presente');

INSERT INTO items_mochila (nombre, descripcion, imagen) VALUES
('Botiquín', 'Vendas, gasas, alcohol, medicamentos básicos', 'botiquin.png'),
('Agua', '2 litros de agua potable', 'agua.png'),
('Linterna', 'Linterna con baterías de repuesto', 'linterna.png'),
('Comida', 'Comida enlatada y snacks no perecederos', 'comida.png'),
('Silbato', 'Para llamar la atención en caso de emergencia', 'silbato.png'),
('Cargador', 'Cargador portátil para teléfono', 'cargador.png'),
('Radio', 'Radio de pilas para escuchar noticias', 'radio.png'),
('Cobija', 'Cobija térmica para abrigarse', 'cobija.png'),
('Cepillo', 'Cepillo de dientes y pasta', 'cepillo.png'),
('Documentos', 'Copia de documentos importantes', 'documentos.png');

INSERT INTO mochila_usuario (usuarios_id, items_mochila_id, cantidad) VALUES
(1,1,1),(1,2,2),(1,5,1);

INSERT INTO puntajes_juegos (usuarios_id, juego_nombre, puntaje) VALUES
(1, 'Trivia Sismos', 85),
(1, 'Simulador Evacuación', 92);

-- Nota: el blog publico de demo (articulos de ejemplo sobre sismos) se
-- retiro al agregar slug/cat/tag con UNIQUE KEY; el contenido real se
-- administra desde el CMS del Admin General (admin/articulos).

-- ------------------------------------------------------------
-- Seed: institucion + una cuenta de cada rol institucional.
-- Contraseña para todas las cuentas de este bloque: Demo2026!
-- ------------------------------------------------------------

INSERT INTO instituciones (nombre, correo, telefono, direccion) VALUES
('Instituto Nacional Demostración NDA', 'contacto@demo-nda.edu.sv', '2200-0000', 'San Salvador, El Salvador');
SET @inst_id = LAST_INSERT_ID();

INSERT INTO aulas (nombre, grado, nivel, seccion, instituciones_id) VALUES
('1° Año A','1° Año','Bachillerato','A',@inst_id),('1° Año B','1° Año','Bachillerato','B',@inst_id),
('1° Año C','1° Año','Bachillerato','C',@inst_id),('1° Año D','1° Año','Bachillerato','D',@inst_id),
('1° Año E','1° Año','Bachillerato','E',@inst_id),('1° Año F','1° Año','Bachillerato','F',@inst_id),
('2° Año A','2° Año','Bachillerato','A',@inst_id),('2° Año B','2° Año','Bachillerato','B',@inst_id),
('2° Año C','2° Año','Bachillerato','C',@inst_id),('2° Año D','2° Año','Bachillerato','D',@inst_id),
('2° Año E','2° Año','Bachillerato','E',@inst_id),('2° Año F','2° Año','Bachillerato','F',@inst_id),
('3° Año A','3° Año','Bachillerato','A',@inst_id),('3° Año B','3° Año','Bachillerato','B',@inst_id),
('3° Año C','3° Año','Bachillerato','C',@inst_id),('3° Año D','3° Año','Bachillerato','D',@inst_id),
('3° Año E','3° Año','Bachillerato','E',@inst_id),('3° Año F','3° Año','Bachillerato','F',@inst_id);

-- email_verificado=1: correos @nda.com inventados, no tiene sentido pedir codigo.
INSERT INTO usuarios (nombre, email, contra, role, institucion_id, estado_institucional, email_verificado) VALUES
('Directora Demo',         'director.demo@nda.com',       SHA2('Demo2026!', 256), 'director',       @inst_id,  'aprobado', 1),
('Docente Demo',           'docente.demo@nda.com',        SHA2('Demo2026!', 256), 'docente',        @inst_id,  'aprobado', 1),
('Alumno Demo',            'alumno.demo@nda.com',         SHA2('Demo2026!', 256), 'alumno',         @inst_id,  'aprobado', 1),
('Padre Demo',             'padre.demo@nda.com',          SHA2('Demo2026!', 256), 'padre',          @inst_id,  'aprobado', 1),
('Administrativo Demo',    'administrativo.demo@nda.com', SHA2('Demo2026!', 256), 'administrativo', @inst_id,  'aprobado', 1),
('Usuario General Demo',   'usuario.demo@nda.com',        SHA2('Demo2026!', 256), 'user',           NULL,      'ninguno',  1),
('Docente Pendiente Demo', 'pendiente.demo@nda.com',      SHA2('Demo2026!', 256), 'docente',        @inst_id,  'pendiente', 1);

UPDATE instituciones SET director_id = (SELECT usuarios_id FROM usuarios WHERE email = 'director.demo@nda.com')
WHERE instituciones_id = @inst_id;

UPDATE aulas SET maestro_id = (SELECT usuarios_id FROM usuarios WHERE email = 'docente.demo@nda.com')
WHERE instituciones_id = @inst_id AND nombre = '1° Año A';

INSERT INTO estudiantes (codigo, usuarios_id, aulas_id, nombre, apellido, telefono_emergencia)
SELECT 'EST-DEMO01', u.usuarios_id, a.aulas_id, 'Alumno', 'Demo', '7000-0000'
FROM usuarios u, aulas a
WHERE u.email = 'alumno.demo@nda.com' AND a.instituciones_id = @inst_id AND a.nombre = '1° Año A';

-- Solicitud pendiente, para que la directora demo tenga algo que aprobar.
INSERT INTO solicitudes_institucion (usuarios_id, instituciones_id, rol_solicitado, mensaje)
SELECT usuarios_id, @inst_id, 'docente', 'Hola, soy docente de nuevo ingreso y quisiera unirme al módulo escolar.'
FROM usuarios WHERE email = 'pendiente.demo@nda.com';

INSERT INTO simulacros (nombre, fecha, hora, instituciones_id, tipo, descripcion, estado)
VALUES ('Simulacro Sísmico Trimestral', CURDATE(), '09:00:00', @inst_id,
        'Sísmico', 'Simulacro de evacuación programado para todo el instituto.', 'programado');

INSERT INTO rutas_evacuacion (nombre, descripcion, instituciones_id, estado)
VALUES ('Ruta Pabellón A → Cancha Central', 'Salida principal por el pasillo norte hacia la cancha.', @inst_id, 'despejada');

INSERT INTO corcho_notas (instituciones_id, usuarios_id, texto, color, pos_x, pos_y, rotacion)
SELECT @inst_id, usuarios_id, 'Bienvenidos al tablero de la comunidad. Aquí puedes dejar avisos para todos.', 'amarillo', 15, 20, -3
FROM usuarios WHERE email = 'director.demo@nda.com';

-- ------------------------------------------------------------
-- Seed: incidentes, noticias/riesgos y rutas/simulacros de
-- Colegio Don Bosco (instituciones_id=3 en este archivo). Los
-- usuarios_id 8/32/6 (director/docente/administrativo) asumen tu
-- BD real con esas cuentas ya registradas; en instalacion nueva
-- ajusta esos IDs a los usuarios correspondientes.
-- ------------------------------------------------------------

INSERT INTO incidentes (tipo, descripcion, ubicacion, imagen, usuario_id, instituciones_id, prioridad, estado, resuelto_at) VALUES
('Ruta bloqueada', 'La salida trasera del auditorio está bloqueada mientras se repara el techo (tejas rotas y filtraciones ya reportadas). Se está usando la Ruta C como alterna para esa zona.', 'Salida trasera del auditorio', 'https://commons.wikimedia.org/wiki/Special:FilePath/Broken_black_roof_tiles_1.jpg', 8, 3, 'alta', 'abierto', NULL),
('Objeto caído', 'Una rama grande cayó sobre el corredor techado hacia la cancha tras la lluvia de anoche, obstruyendo parcialmente el paso. Ya fue retirada por el personal de mantenimiento.', 'Corredor techado hacia la cancha', 'https://commons.wikimedia.org/wiki/Special:FilePath/Fallen_tree_on_Sowerby_Bridge_Footpath_134,_Norland_-_geograph.org.uk_-_2942028.jpg', 32, 3, 'media', 'resuelto', NOW()),
('Alumno lesionado', 'Un estudiante sufrió una torcedura de tobillo durante la clase de educación física. Fue atendido en la enfermería del colegio y se notificó a sus padres.', 'Cancha techada', NULL, 32, 3, 'media', 'resuelto', NOW()),
('Espacio dañado', 'La puerta del salón de usos múltiples tiene una bisagra suelta y cuesta cerrarla por completo. No representa un riesgo inmediato, pero conviene ajustarla antes de que empeore.', 'Salón de usos múltiples', 'https://commons.wikimedia.org/wiki/Special:FilePath/Broken_door.png', 6, 3, 'baja', 'abierto', NULL);

INSERT INTO noticias_internas (instituciones_id, usuarios_id, titulo, resumen, contenido, imagen, estado) VALUES
(3, 8, 'Colegio Don Bosco renueva la señalización de rutas de evacuación',
 'Se instalaron nuevos rótulos y flechas de salida de emergencia en los tres pabellones del colegio, como parte del plan de gestión de riesgos institucional.',
 'Durante las últimas semanas, el Colegio Don Bosco trabajó junto al Comité de Protección Escolar en la actualización completa de la señalización de emergencia del campus.\n\nSe instalaron rótulos fotoluminiscentes de "Salida" y flechas direccionales en los pasillos de los tres pabellones, además de mapas de rutas de evacuación colocados en la entrada de cada aula, indicando el punto de encuentro asignado.\n\nEsta actualización responde a las recomendaciones del último simulacro institucional, en el que se identificaron tramos del corredor central donde la señalización anterior era poco visible.\n\nSe pide a estudiantes, docentes y personal administrativo revisar el mapa de su aula y familiarizarse con la ruta y el punto de encuentro que les corresponde.',
 'https://commons.wikimedia.org/wiki/Special:FilePath/Emergency_Exit_ISO_Pictogram_(green).svg', 'publicada'),

(3, 32, 'Taller de primeros auxilios para docentes y personal administrativo',
 'Personal capacitado guio al cuerpo docente en atención básica de heridas, maniobras de reanimación y manejo de emergencias dentro del aula.',
 'El personal docente y administrativo del Colegio Don Bosco participó en un taller práctico de primeros auxilios, enfocado en la atención inmediata durante los primeros minutos de una emergencia dentro del aula o en el campus.\n\nEntre los temas cubiertos estuvieron: control de hemorragias, atención de golpes y caídas, maniobra de Heimlich, y los pasos básicos de reanimación cardiopulmonar (RCP) mientras se espera la llegada de ayuda especializada.\n\nEl objetivo es que, ante un accidente durante clases, recreo o un simulacro, el personal cuente con herramientas claras para actuar con calma y seguridad mientras se activa el protocolo institucional.\n\nSe espera repetir esta capacitación cada semestre e incluir próximamente una sesión dirigida a estudiantes de bachillerato.',
 'https://commons.wikimedia.org/wiki/Special:FilePath/First_aid.png', 'publicada'),

(3, 8, 'Charla informativa sobre riesgo volcánico en El Salvador: el caso del volcán de Izalco',
 'Estudiantes de bachillerato conocieron cómo identificar señales de actividad volcánica y qué hacer ante una alerta de Protección Civil.',
 'Como parte del programa de educación en gestión de riesgos, estudiantes de bachillerato del Colegio Don Bosco recibieron una charla sobre el riesgo volcánico en El Salvador, con el volcán de Izalco como caso de estudio por su historial de actividad.\n\nDurante la sesión se explicaron los principales riesgos asociados a la actividad volcánica en el país (ceniza, gases y lahares), cómo se clasifican las alertas de Protección Civil, y las medidas básicas de autoprotección en caso de una alerta naranja o roja cerca de una zona volcánica.\n\nLa charla se enmarca dentro de los contenidos de Ciencias Naturales y busca complementar lo aprendido sobre placas tectónicas y actividad sísmica en la región.',
 'https://commons.wikimedia.org/wiki/Special:FilePath/Green_Izalco_Volcano.JPG', 'publicada'),

(3, 32, 'La biblioteca del colegio suma material sobre gestión de riesgos y prevención de desastres',
 'Nuevos libros y guías ilustradas sobre sismos, inundaciones y volcanes ya están disponibles para consulta de estudiantes de todos los grados.',
 'La biblioteca del Colegio Don Bosco amplió su colección con material educativo enfocado en la prevención y gestión de riesgos, disponible para todos los grados.\n\nEntre las novedades se incluyen guías ilustradas sobre qué hacer antes, durante y después de un sismo, material sobre la temporada lluviosa y el riesgo de inundaciones y deslizamientos, y publicaciones sobre la actividad volcánica en El Salvador.\n\nLos docentes de Ciencias Naturales y Estudios Sociales podrán usar este material como apoyo en sus clases, y los estudiantes pueden solicitarlo directamente en la biblioteca durante su horario habitual.',
 'https://commons.wikimedia.org/wiki/Special:FilePath/Student_reading_a_book_in_the_library.jpg', 'publicada'),

(3, 8, 'Inicia la temporada lluviosa: así se prepara el Colegio Don Bosco ante deslizamientos e inundaciones',
 'Con el inicio del invierno, la institución revisa canaletas, taludes y zonas de riesgo del campus para evitar accidentes durante las lluvias.',
 'Con el inicio de la temporada lluviosa, el Colegio Don Bosco realizó una revisión preventiva de las zonas del campus con mayor riesgo ante lluvias intensas: canaletas, bajantes de agua, taludes perimetrales y el patio trasero, donde históricamente se acumula agua durante tormentas fuertes.\n\nEl personal de mantenimiento limpió los drenajes y se reforzó la señalización en las áreas donde el piso suele resbalar cuando llueve. Además, se recordó a los estudiantes evitar quedarse bajo aleros o árboles grandes durante tormentas eléctricas.\n\nLa institución seguirá de cerca los boletines de MARN y Protección Civil durante los próximos meses, y usará la plataforma NDA para mantener informada a la comunidad educativa ante cualquier alerta relevante para la zona.',
 'https://commons.wikimedia.org/wiki/Special:FilePath/ElSalvadorslide.jpg', 'publicada');

INSERT INTO blog_riesgos (instituciones_id, usuarios_id, titulo, descripcion, ubicacion, imagen) VALUES
(3, 32, 'Grietas visibles en la pared del pasillo del segundo piso',
 'Se observan grietas diagonales en la pared del corredor que conecta las aulas de segundo piso del pabellón B. Aunque por ahora no comprometen el paso, conviene que mantenimiento las evalúe para descartar un problema estructural antes de que se agranden, especialmente de cara a la temporada de lluvias y la actividad sísmica de la zona.',
 'Pasillo de aulas, segundo piso, pabellón B',
 'https://commons.wikimedia.org/wiki/Special:FilePath/Kerewan_Cracked_Wall.JPG'),

(3, 32, 'Cableado eléctrico expuesto cerca del aula de cómputo',
 'En el corredor exterior junto al laboratorio de informática hay un tramo de cableado eléctrico sin canaleta, colgando a la altura de paso de los estudiantes. Representa un riesgo de tropiezo y de contacto eléctrico, sobre todo cuando el área se moja con la lluvia. Se recomienda entubar o reubicar el cableado lo antes posible.',
 'Corredor exterior, junto al laboratorio de informática',
 'https://commons.wikimedia.org/wiki/Special:FilePath/Chongqing_cable_chaos.jpg'),

(3, 8, 'Tejas rotas y filtraciones en el techo del auditorio',
 'Varias tejas del techo del auditorio están rotas o desplazadas, y durante las últimas lluvias se registraron filtraciones de agua sobre parte del escenario. Además del daño al piso y al equipo eléctrico cercano, existe riesgo de que alguna teja se desprenda. Se solicita revisión y reparación antes del próximo evento programado en ese espacio.',
 'Techo del auditorio principal',
 'https://commons.wikimedia.org/wiki/Special:FilePath/Broken_black_roof_tiles_1.jpg'),

(3, 32, 'Vidrio agrietado en ventana del laboratorio de ciencias',
 'Una de las ventanas del laboratorio de ciencias naturales presenta una grieta que atraviesa todo el vidrio, posiblemente por el impacto de un objeto desde el patio contiguo. Hay riesgo de que se desprendan fragmentos, especialmente durante actividades con manipulación de materiales. Se recomienda colocar cinta de seguridad mientras se gestiona el cambio del vidrio.',
 'Laboratorio de ciencias naturales, primer piso',
 'https://commons.wikimedia.org/wiki/Special:FilePath/Broken_glass.jpg');

INSERT INTO rutas_evacuacion (nombre, descripcion, instituciones_id, estado) VALUES
('Ruta A — Pabellón A hacia cancha techada', 'Sale del pasillo principal del pabellón A directo a la cancha techada, designada como punto de encuentro principal.', 3, 'despejada'),
('Ruta B — Pabellón B hacia patio central', 'Desciende por la escalera del pabellón B y desemboca en el patio central, punto de encuentro secundario.', 3, 'despejada'),
('Ruta C — Biblioteca y laboratorios hacia portón principal', 'Cubre biblioteca y laboratorios de ciencias/informática, saliendo directo por el portón principal hacia la calle.', 3, 'despejada'),
('Ruta D — Auditorio hacia parqueo trasero', 'Ruta temporalmente bloqueada: mientras se repara el techo del auditorio (tejas rotas y filtraciones reportadas), usar la Ruta C como alterna para esa zona.', 3, 'bloqueada');

INSERT INTO simulacros (nombre, fecha, hora, instituciones_id, tipo, descripcion, estado) VALUES
('Simulacro sísmico de mitad de año', '2026-06-18', '09:30:00', 3, 'Sísmico', 'Evacuación general del campus tras alerta sísmica simulada. Tiempo de evacuación total: 3 minutos 40 segundos, dentro de la meta institucional de 4 minutos.', 'finalizado'),
('Simulacro de incendio — cocina y comedor', '2026-05-05', '10:15:00', 3, 'Incendio', 'Simulacro enfocado en el área de cocina y comedor, con activación de la ruta B como salida principal para esa zona.', 'finalizado'),
('Simulacro sísmico — aulas de parvularia', '2026-03-20', '08:45:00', 3, 'Sísmico', 'Ejercicio adaptado para los grados más pequeños, con apoyo de docentes y personal administrativo para guiar la evacuación.', 'finalizado'),
('Simulacro sísmico — segundo semestre', '2026-09-15', '09:00:00', 3, 'Sísmico', 'Próximo simulacro institucional, con enfoque en la nueva señalización de rutas de evacuación instalada recientemente.', 'programado');
