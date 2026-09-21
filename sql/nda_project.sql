CREATE DATABASE IF NOT EXISTS nda_project
  DEFAULT CHARACTER SET utf8mb4
  DEFAULT COLLATE utf8mb4_unicode_ci;

USE nda_project;

-- Catalogo: instituciones y usuarios

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
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_institucion_estado (estado_verificacion)
);

CREATE TABLE usuarios (
    usuarios_id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100),
    username VARCHAR(20) NULL UNIQUE,
    email VARCHAR(100) UNIQUE,
    contra VARCHAR(255),
    email_verificado TINYINT(1) NOT NULL DEFAULT 0,
    codigo_verificacion_email VARCHAR(6) NULL,
    codigo_verificacion_email_expira DATETIME NULL,
    role ENUM('user','admin','director','docente','alumno','padre','administrativo') DEFAULT 'user',
    codigo_institucional VARCHAR(12) NULL UNIQUE,
    institucion_id INT NULL,
    estado_institucional ENUM('ninguno','pendiente','aprobado','rechazado') DEFAULT 'ninguno',
    telefono VARCHAR(20) NULL,
    bio VARCHAR(200) NULL,
    ubicacion VARCHAR(100) NULL,
    materia VARCHAR(100) NULL,
    foto_perfil VARCHAR(255) NULL,
    portada_perfil VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login_at DATETIME NULL,
    FOREIGN KEY (institucion_id) REFERENCES instituciones(instituciones_id) ON DELETE SET NULL,
    INDEX idx_usuario_institucion (institucion_id),
    INDEX idx_usuario_role (role)
);

-- FIX: ahora sí, la FK de director_id (usuarios ya existe)
ALTER TABLE instituciones
    ADD CONSTRAINT fk_institucion_director
    FOREIGN KEY (director_id) REFERENCES usuarios(usuarios_id) ON DELETE SET NULL;

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
    FOREIGN KEY (instituciones_id) REFERENCES instituciones(instituciones_id) ON DELETE CASCADE,
    INDEX idx_solicitud_estado (estado)
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
    FOREIGN KEY (maestro_id) REFERENCES usuarios(usuarios_id) ON DELETE SET NULL,
    INDEX idx_aula_institucion (instituciones_id)
);

CREATE TABLE estudiantes (
    estudiantes_id INT PRIMARY KEY AUTO_INCREMENT,
    codigo VARCHAR(20) UNIQUE,
    -- FIX: usuarios_id ahora es UNIQUE NULL (un estudiante = un usuario real)
    usuarios_id INT NULL UNIQUE,
    aulas_id INT,
    nombre VARCHAR(100),
    apellido VARCHAR(100),
    numero_lista INT,
    edad INT,
    telefono_emergencia VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuarios_id) REFERENCES usuarios(usuarios_id) ON DELETE CASCADE,
    FOREIGN KEY (aulas_id) REFERENCES aulas(aulas_id) ON DELETE CASCADE,
    INDEX idx_estudiante_aula (aulas_id)
);

CREATE TABLE padres_estudiantes (
    padres_estudiantes_id INT PRIMARY KEY AUTO_INCREMENT,
    padre_usuario_id INT NOT NULL,
    estudiante_id INT NOT NULL,
    parentesco VARCHAR(30) DEFAULT 'padre/madre',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_padre_estudiante (padre_usuario_id, estudiante_id),
    FOREIGN KEY (padre_usuario_id) REFERENCES usuarios(usuarios_id) ON DELETE CASCADE,
    FOREIGN KEY (estudiante_id) REFERENCES estudiantes(estudiantes_id) ON DELETE CASCADE,
    INDEX idx_padre_est (estudiante_id)
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
    -- FIX: documentado como porcentaje 0-100 sobre la imagen
    pos_x DECIMAL(5,2) NOT NULL COMMENT 'Porcentaje 0-100 sobre el ancho de la imagen',
    pos_y DECIMAL(5,2) NOT NULL COMMENT 'Porcentaje 0-100 sobre el alto de la imagen',
    creado_por INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (instituciones_id) REFERENCES instituciones(instituciones_id) ON DELETE CASCADE,
    FOREIGN KEY (creado_por) REFERENCES usuarios(usuarios_id) ON DELETE SET NULL,
    INDEX idx_punto_institucion (instituciones_id)
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
    visibilidad VARCHAR(150) DEFAULT 'todos',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (instituciones_id) REFERENCES instituciones(instituciones_id) ON DELETE CASCADE,
    FOREIGN KEY (usuarios_id) REFERENCES usuarios(usuarios_id) ON DELETE CASCADE,
    INDEX idx_nota_institucion (instituciones_id)
);

CREATE TABLE noticias_internas (
    noticias_internas_id INT PRIMARY KEY AUTO_INCREMENT,
    instituciones_id INT NULL,
    usuarios_id INT NOT NULL,
    titulo VARCHAR(150) NOT NULL,
    resumen VARCHAR(300) NULL,
    contenido TEXT NOT NULL,
    imagen VARCHAR(255) NULL,
    estado ENUM('borrador','publicada') NOT NULL DEFAULT 'publicada',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (instituciones_id) REFERENCES instituciones(instituciones_id) ON DELETE CASCADE,
    FOREIGN KEY (usuarios_id) REFERENCES usuarios(usuarios_id) ON DELETE CASCADE,
    INDEX idx_noticia_institucion (instituciones_id)
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
    FOREIGN KEY (usuarios_id) REFERENCES usuarios(usuarios_id) ON DELETE CASCADE,
    INDEX idx_riesgo_institucion (instituciones_id)
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
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    -- FIX: evita duplicados al sincronizar con APIs externas
    UNIQUE KEY uq_sismo (fecha, latitud, longitud)
);

CREATE TABLE rutas_evacuacion (
    rutas_evacuacion_id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100),
    descripcion TEXT,
    instituciones_id INT,
    estado VARCHAR(20) DEFAULT 'despejada',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    lat DECIMAL(10,7) NULL,
    lng DECIMAL(10,7) NULL,
    FOREIGN KEY (instituciones_id) REFERENCES instituciones(instituciones_id) ON DELETE CASCADE,
    INDEX idx_ruta_institucion (instituciones_id)
);

CREATE TABLE zonas_seguras (
    zonas_seguras_id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100),
    ubicacion VARCHAR(255),
    instituciones_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (instituciones_id) REFERENCES instituciones(instituciones_id) ON DELETE CASCADE,
    INDEX idx_zona_institucion (instituciones_id)
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
    FOREIGN KEY (instituciones_id) REFERENCES instituciones(instituciones_id) ON DELETE CASCADE,
    INDEX idx_simulacro_institucion (instituciones_id)
);

CREATE TABLE asistencia_simulacros (
    asistencia_simulacros_id INT PRIMARY KEY AUTO_INCREMENT,
    simulacros_id INT,
    estudiantes_id INT,
    estado ENUM('presente','ausente','herido') DEFAULT 'presente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_simulacro_estudiante (simulacros_id, estudiantes_id),
    FOREIGN KEY (simulacros_id) REFERENCES simulacros(simulacros_id) ON DELETE CASCADE,
    FOREIGN KEY (estudiantes_id) REFERENCES estudiantes(estudiantes_id) ON DELETE CASCADE,
    -- FIX: indice para buscar por estudiante solo
    INDEX idx_asistencia_estudiante (estudiantes_id)
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
    -- FIX: SET NULL en vez de CASCADE para conservar historico
    FOREIGN KEY (instituciones_id) REFERENCES instituciones(instituciones_id) ON DELETE SET NULL,
    INDEX idx_incidente_institucion (instituciones_id),
    INDEX idx_incidente_estado (estado)
);

CREATE TABLE lecturas_sensor (
    lecturas_sensor_id INT PRIMARY KEY AUTO_INCREMENT,
    intensidad DECIMAL(5,2) NOT NULL,
    nivel ENUM('normal','precaucion','alerta') DEFAULT 'normal',
    eje_x DECIMAL(6,3) NULL,
    eje_y DECIMAL(6,3) NULL,
    eje_z DECIMAL(6,3) NULL,
    fuente VARCHAR(40) DEFAULT 'arduino-processing',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_lectura_fecha (created_at)
);

-- ------------------------------------------------------------
-- Notificaciones e interacciones
-- ------------------------------------------------------------

CREATE TABLE notificaciones (
    notificaciones_id INT PRIMARY KEY AUTO_INCREMENT,
    tipo ENUM('sismica','escolar','sensor','sistema') NOT NULL DEFAULT 'sistema',
    severidad ENUM('seguro','informativo','precaucion','alerta','emergencia') NOT NULL DEFAULT 'informativo',
    destinatario_usuario_id INT NULL,
    destinatario_institucion_id INT NULL,
    es_global TINYINT(1) NOT NULL DEFAULT 0,
    mensaje VARCHAR(255) NOT NULL,
    referencia_tipo VARCHAR(40) NULL,
    referencia_id INT NULL,
    leida TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (destinatario_usuario_id) REFERENCES usuarios(usuarios_id) ON DELETE CASCADE,
    FOREIGN KEY (destinatario_institucion_id) REFERENCES instituciones(instituciones_id) ON DELETE CASCADE,
    INDEX idx_notif_usuario (destinatario_usuario_id, leida),
    INDEX idx_notif_institucion (destinatario_institucion_id, leida),
    INDEX idx_notif_global (es_global, leida)
);

-- FIX: ENUMs unificados entre likes y comentarios ('nota' incluida en ambos)
CREATE TABLE interacciones_likes (
    interacciones_likes_id INT PRIMARY KEY AUTO_INCREMENT,
    tipo_contenido ENUM('noticia','riesgo','incidente','articulo','nota') NOT NULL,
    contenido_id INT NOT NULL,
    usuarios_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_like (tipo_contenido, contenido_id, usuarios_id),
    FOREIGN KEY (usuarios_id) REFERENCES usuarios(usuarios_id) ON DELETE CASCADE,
    INDEX idx_like_contenido (tipo_contenido, contenido_id)
);

CREATE TABLE interacciones_comentarios (
    interacciones_comentarios_id INT PRIMARY KEY AUTO_INCREMENT,
    tipo_contenido ENUM('noticia','riesgo','incidente','articulo','nota') NOT NULL,
    contenido_id INT NOT NULL,
    usuarios_id INT NOT NULL,
    -- FIX: TEXT en vez de VARCHAR(500)
    texto TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuarios_id) REFERENCES usuarios(usuarios_id) ON DELETE CASCADE,
    INDEX idx_comentario_contenido (tipo_contenido, contenido_id)
);

CREATE TABLE interacciones_guardados (
    interacciones_guardados_id INT PRIMARY KEY AUTO_INCREMENT,
    tipo_contenido ENUM('articulo','noticia','riesgo','incidente','nota') NOT NULL DEFAULT 'articulo',
    contenido_id INT NOT NULL,
    usuarios_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_guardado (tipo_contenido, contenido_id, usuarios_id),
    FOREIGN KEY (usuarios_id) REFERENCES usuarios(usuarios_id) ON DELETE CASCADE,
    INDEX idx_guardado_contenido (tipo_contenido, contenido_id)
);

CREATE TABLE interacciones_reacciones (
    interacciones_reacciones_id INT PRIMARY KEY AUTO_INCREMENT,
    tipo_contenido ENUM('articulo','noticia','riesgo','incidente','nota') NOT NULL DEFAULT 'articulo',
    contenido_id INT NOT NULL,
    usuarios_id INT NOT NULL,
    emoji VARCHAR(10) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_reaccion (tipo_contenido, contenido_id, usuarios_id),
    FOREIGN KEY (usuarios_id) REFERENCES usuarios(usuarios_id) ON DELETE CASCADE,
    INDEX idx_reaccion_contenido (tipo_contenido, contenido_id)
);

-- ------------------------------------------------------------
-- CMS del Admin General
-- ------------------------------------------------------------

CREATE TABLE blog (
    blog_id INT PRIMARY KEY AUTO_INCREMENT,
    -- FIX: slug NULL por defecto para evitar colisiones en UNIQUE
    slug VARCHAR(150) NULL,
    titulo VARCHAR(200),
    cat VARCHAR(30) NOT NULL DEFAULT 'prevencion',
    tag VARCHAR(40) NOT NULL DEFAULT '',
    color CHAR(7) NOT NULL DEFAULT '#f29f05',
    contenido TEXT,
    cuerpo LONGTEXT NULL,
    autor_id INT NULL,
    autor_nombre VARCHAR(120) NOT NULL DEFAULT 'Equipo NDA',
    tiempo VARCHAR(20) NOT NULL DEFAULT '5 min',
    destacado TINYINT(1) NOT NULL DEFAULT 0,
    extracto VARCHAR(300) NOT NULL DEFAULT '',
    imagen VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_blog_slug (slug),
    FOREIGN KEY (autor_id) REFERENCES usuarios(usuarios_id) ON DELETE SET NULL,
    INDEX idx_blog_cat (cat)
);

CREATE TABLE recursos (
    recursos_id INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(150) NOT NULL,
    descripcion VARCHAR(300) NULL,
    categoria VARCHAR(30) NOT NULL,
    tags VARCHAR(150) NULL,
    archivo VARCHAR(255) NOT NULL,
    -- FIX: BIGINT por si suben archivos >2GB
    tamano_bytes BIGINT NULL,
    orden INT NOT NULL DEFAULT 0,
    usuarios_id INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    -- FIX: FK a usuarios
    FOREIGN KEY (usuarios_id) REFERENCES usuarios(usuarios_id) ON DELETE SET NULL,
    -- FIX: indice compuesto para ordenar por categoria
    INDEX idx_recurso_categoria_orden (categoria, orden)
);

CREATE TABLE contenido_paginas (
    contenido_paginas_id INT PRIMARY KEY AUTO_INCREMENT,
    pagina VARCHAR(30) NOT NULL,
    campo VARCHAR(100) NOT NULL,
    valor LONGTEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
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
    -- FIX: unico usuario+item
    UNIQUE KEY uniq_mochila_usuario_item (usuarios_id, items_mochila_id),
    FOREIGN KEY (usuarios_id) REFERENCES usuarios(usuarios_id) ON DELETE CASCADE,
    FOREIGN KEY (items_mochila_id) REFERENCES items_mochila(items_mochila_id) ON DELETE CASCADE
);

CREATE TABLE puntajes_juegos (
    puntajes_juegos_id INT PRIMARY KEY AUTO_INCREMENT,
    usuarios_id INT,
    juego_nombre VARCHAR(50),
    puntaje INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_usuario_juego (usuarios_id, juego_nombre),
    FOREIGN KEY (usuarios_id) REFERENCES usuarios(usuarios_id) ON DELETE CASCADE,
    INDEX idx_puntaje_juego (juego_nombre, puntaje)
);

-- ============================================================
-- SEEDS
-- ============================================================

-- Superadmin
INSERT INTO usuarios (nombre, email, contra, role, email_verificado) VALUES
('Super Administrador', 'admin@nda.com', SHA2('CambiaEsto2026!', 256), 'admin', 1);

-- ------------------------------------------------------------
-- Instituciones demo (1=San José, 2=Santa Ana, 3=Don Bosco)
-- ------------------------------------------------------------
INSERT INTO instituciones (nombre, correo, telefono, logo) VALUES
('Colegio San José',  'info@colegiosanjose.edu.sv',  '2233-4455', 'logo_sanjose.png'),
('Colegio Santa Ana', 'info@colegiosantaana.edu.sv', '2244-5566', 'logo_santaana.png'),
('Colegio Don Bosco', 'info@donbosco.edu.sv',        '2255-6677', 'logo_donbosco.png');

-- ------------------------------------------------------------
-- Aulas demo (mismas que antes)
-- ------------------------------------------------------------
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

-- ------------------------------------------------------------
-- Estudiantes demo: creamos 1 usuario por estudiante (sin login real, con password aleatoria)
-- FIX: antes todos apuntaban a usuarios_id=3 (que no existía).
-- ------------------------------------------------------------
INSERT INTO usuarios (nombre, email, contra, role, institucion_id, estado_institucional, email_verificado) VALUES
('María García',      'maria.garcia@demo.sv',    SHA2(RAND(), 256), 'alumno', 1, 'aprobado', 1),
('José López',        'jose.lopez@demo.sv',      SHA2(RAND(), 256), 'alumno', 1, 'aprobado', 1),
('Ana Martínez',      'ana.martinez@demo.sv',    SHA2(RAND(), 256), 'alumno', 1, 'aprobado', 1),
('Luis Rodríguez',    'luis.rodriguez@demo.sv',  SHA2(RAND(), 256), 'alumno', 1, 'aprobado', 1),
('Laura Sánchez',     'laura.sanchez@demo.sv',   SHA2(RAND(), 256), 'alumno', 1, 'aprobado', 1),
('Carlos Pérez',      'carlos.perez@demo.sv',    SHA2(RAND(), 256), 'alumno', 1, 'aprobado', 1),
('Elena Gómez',       'elena.gomez@demo.sv',     SHA2(RAND(), 256), 'alumno', 1, 'aprobado', 1),
('Miguel Fernández',  'miguel.fernandez@demo.sv',SHA2(RAND(), 256), 'alumno', 1, 'aprobado', 1),
('Sofía Díaz',        'sofia.diaz@demo.sv',      SHA2(RAND(), 256), 'alumno', 1, 'aprobado', 1),
('Diego Ramírez',     'diego.ramirez@demo.sv',   SHA2(RAND(), 256), 'alumno', 1, 'aprobado', 1),
('Andrea Torres',     'andrea.torres@demo.sv',   SHA2(RAND(), 256), 'alumno', 1, 'aprobado', 1),
('Javier Flores',     'javier.flores@demo.sv',   SHA2(RAND(), 256), 'alumno', 1, 'aprobado', 1),
('Valentina Ramos',   'valentina.ramos@demo.sv', SHA2(RAND(), 256), 'alumno', 1, 'aprobado', 1),
('Fernando Ortiz',    'fernando.ortiz@demo.sv',  SHA2(RAND(), 256), 'alumno', 1, 'aprobado', 1),
('Daniela Castro',    'daniela.castro@demo.sv',  SHA2(RAND(), 256), 'alumno', 1, 'aprobado', 1),
('Andrés Morales',    'andres.morales@demo.sv',  SHA2(RAND(), 256), 'alumno', 1, 'aprobado', 1),
('Paula Mendoza',     'paula.mendoza@demo.sv',   SHA2(RAND(), 256), 'alumno', 1, 'aprobado', 1),
('Ricardo Herrera',   'ricardo.herrera@demo.sv', SHA2(RAND(), 256), 'alumno', 1, 'aprobado', 1),
('Camila Vargas',     'camila.vargas@demo.sv',   SHA2(RAND(), 256), 'alumno', 1, 'aprobado', 1),
('Pablo Jiménez',     'pablo.jimenez@demo.sv',   SHA2(RAND(), 256), 'alumno', 1, 'aprobado', 1),
('Valeria Molina',    'valeria.molina@demo.sv',  SHA2(RAND(), 256), 'alumno', 1, 'aprobado', 1);

-- IDs de usuario 2..22 para esos 21 estudiantes
INSERT INTO estudiantes (codigo, usuarios_id, aulas_id, nombre, apellido, edad, telefono_emergencia) VALUES
('2025001', 2,  1, 'María',     'García',    15, '7777-1111'),
('2025002', 3,  1, 'José',      'López',     15, '7777-1112'),
('2025003', 4,  1, 'Ana',       'Martínez',  15, '7777-1113'),
('2025004', 5,  1, 'Luis',      'Rodríguez', 15, '7777-1114'),
('2025005', 6,  1, 'Laura',     'Sánchez',   15, '7777-1115'),
('2025006', 7,  2, 'Carlos',    'Pérez',     15, '7777-1121'),
('2025007', 8,  2, 'Elena',     'Gómez',     15, '7777-1122'),
('2025008', 9,  2, 'Miguel',    'Fernández', 15, '7777-1123'),
('2025009', 10, 3, 'Sofía',     'Díaz',      15, '7777-1131'),
('2025010', 11, 3, 'Diego',     'Ramírez',   15, '7777-1132'),
('2025011', 12, 7, 'Andrea',    'Torres',    16, '7777-2211'),
('2025012', 13, 7, 'Javier',    'Flores',    16, '7777-2212'),
('2025013', 14, 7, 'Valentina', 'Ramos',     16, '7777-2213'),
('2025014', 15, 7, 'Fernando',  'Ortiz',     16, '7777-2214'),
('2025015', 16, 8, 'Daniela',   'Castro',    16, '7777-2221'),
('2025016', 17, 8, 'Andrés',    'Morales',   16, '7777-2222'),
('2025017', 18, 13,'Paula',     'Mendoza',   17, '7777-3311'),
('2025018', 19, 13,'Ricardo',   'Herrera',   17, '7777-3312'),
('2025019', 20, 13,'Camila',    'Vargas',    17, '7777-3313'),
('2025020', 21, 14,'Pablo',     'Jiménez',   17, '7777-3321'),
('2025021', 22, 14,'Valeria',   'Molina',    17, '7777-3322');

-- ------------------------------------------------------------
-- Sismos demo
-- ------------------------------------------------------------
INSERT INTO sismos (magnitud, lugar, fecha, latitud, longitud) VALUES
(4.2,'San Miguel',   '2025-01-15 08:30:00', 13.4833, -88.1833),
(3.8,'Santa Ana',    '2025-01-12 14:20:00', 13.9942, -89.5597),
(5.1,'La Libertad',  '2025-01-10 22:15:00', 13.4890, -89.3220),
(2.5,'San Salvador', '2025-01-08 06:45:00', 13.6900, -89.1900),
(4.5,'Usulután',     '2025-01-05 11:30:00', 13.3494, -88.4563),
(3.2,'Sonsonate',    '2025-01-03 19:10:00', 13.7189, -89.7242),
(6.0,'Ahuachapán',   '2024-12-28 03:00:00', 13.9214, -89.8450),
(4.8,'San Vicente',  '2024-12-20 16:30:00', 13.6433, -88.7897);

-- ------------------------------------------------------------
-- Rutas, zonas, simulacros, asistencia
-- ------------------------------------------------------------
INSERT INTO rutas_evacuacion (nombre, descripcion, instituciones_id) VALUES
('Ruta 1 - Salida Principal',    'Por la puerta principal hacia el parque central',      1),
('Ruta 2 - Salida Lateral',      'Por el pasillo norte hacia la cancha',                 1),
('Ruta 3 - Salida de Emergencia','Por las gradas hacia el patio trasero',                1),
('Ruta Principal',               'Desde el edificio A hacia el campo de futbol',         2),
('Ruta Secundaria',              'Desde el edificio B hacia la plaza',                   2),
('Ruta de Evacuación Norte',     'Salida por la puerta norte del colegio',               3);

INSERT INTO zonas_seguras (nombre, ubicacion, instituciones_id) VALUES
('Zona 1 - Parque Central',  'Frente al colegio, en el parque',    1),
('Zona 2 - Cancha de Futbol','Detrás del colegio',                 1),
('Zona 3 - Patio Trasero',   'Zona amplia sin construcciones',     1),
('Zona Segura A',            'Campo de futbol',                    2),
('Zona Segura B',            'Plaza principal',                    2),
('Zona de Encuentro Norte',  'Área verde al norte',                3);

INSERT INTO simulacros (nombre, fecha, hora, instituciones_id) VALUES
('Simulacro 1 - Primer Trimestre',  '2025-02-15', '09:00:00', 1),
('Simulacro 2 - Segundo Trimestre', '2025-05-20', '10:30:00', 1),
('Simulacro 3 - Tercer Trimestre',  '2025-08-25', '08:45:00', 1),
('Simulacro Anual',                 '2025-10-10', '09:00:00', 2),
('Simulacro de Evacuación',         '2025-11-15', '10:00:00', 3);

INSERT INTO asistencia_simulacros (simulacros_id, estudiantes_id, estado) VALUES
(1,1,'presente'),(1,2,'presente'),(1,3,'presente'),(1,4,'ausente'),(1,5,'presente'),
(1,6,'presente'),(1,7,'herido'),(1,8,'presente'),
(2,1,'presente'),(2,2,'presente'),(2,3,'ausente'),(2,4,'presente'),(2,5,'presente'),(2,6,'presente'),
(3,1,'presente'),(3,2,'presente'),(3,3,'presente'),(3,4,'presente'),(3,5,'presente'),
(3,6,'presente'),(3,7,'presente'),(3,8,'presente');

-- ------------------------------------------------------------
-- Items de mochila y gamificacion
-- ------------------------------------------------------------
INSERT INTO items_mochila (nombre, descripcion, imagen) VALUES
('Botiquín','Vendas, gasas, alcohol, medicamentos básicos','botiquin.png'),
('Agua','2 litros de agua potable','agua.png'),
('Linterna','Linterna con baterías de repuesto','linterna.png'),
('Comida','Comida enlatada y snacks no perecederos','comida.png'),
('Silbato','Para llamar la atención en caso de emergencia','silbato.png'),
('Cargador','Cargador portátil para teléfono','cargador.png'),
('Radio','Radio de pilas para escuchar noticias','radio.png'),
('Cobija','Cobija térmica para abrigarse','cobija.png'),
('Cepillo','Cepillo de dientes y pasta','cepillo.png'),
('Documentos','Copia de documentos importantes','documentos.png');

INSERT INTO mochila_usuario (usuarios_id, items_mochila_id, cantidad) VALUES
(1,1,1),(1,2,2),(1,5,1);

INSERT INTO puntajes_juegos (usuarios_id, juego_nombre, puntaje) VALUES
(1, 'Trivia Sismos', 85),
(1, 'Simulador Evacuación', 92);

-- ------------------------------------------------------------
-- Seed: institucion demo + una cuenta por rol
-- Password para todas: Demo2026!
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

INSERT INTO usuarios (nombre, email, contra, role, institucion_id, estado_institucional, email_verificado) VALUES
('Directora Demo',         'director.demo@nda.com',       SHA2('Demo2026!', 256), 'director',       @inst_id, 'aprobado',  1),
('Docente Demo',           'docente.demo@nda.com',        SHA2('Demo2026!', 256), 'docente',        @inst_id, 'aprobado',  1),
('Alumno Demo',            'alumno.demo@nda.com',         SHA2('Demo2026!', 256), 'alumno',         @inst_id, 'aprobado',  1),
('Padre Demo',             'padre.demo@nda.com',          SHA2('Demo2026!', 256), 'padre',          @inst_id, 'aprobado',  1),
('Administrativo Demo',    'administrativo.demo@nda.com', SHA2('Demo2026!', 256), 'administrativo', @inst_id, 'aprobado',  1),
('Usuario General Demo',   'usuario.demo@nda.com',        SHA2('Demo2026!', 256), 'user',           NULL,     'ninguno',   1),
('Docente Pendiente Demo', 'pendiente.demo@nda.com',      SHA2('Demo2026!', 256), 'docente',        @inst_id, 'pendiente', 1);

UPDATE instituciones SET director_id = (SELECT usuarios_id FROM usuarios WHERE email = 'director.demo@nda.com')
WHERE instituciones_id = @inst_id;

UPDATE aulas SET maestro_id = (SELECT usuarios_id FROM usuarios WHERE email = 'docente.demo@nda.com')
WHERE instituciones_id = @inst_id AND nombre = '1° Año A';

-- Estudiante demo (vinculado al usuario alumno.demo)
INSERT INTO estudiantes (codigo, usuarios_id, aulas_id, nombre, apellido, telefono_emergencia)
SELECT 'EST-DEMO01', u.usuarios_id, a.aulas_id, 'Alumno', 'Demo', '7000-0000'
FROM usuarios u, aulas a
WHERE u.email = 'alumno.demo@nda.com' AND a.instituciones_id = @inst_id AND a.nombre = '1° Año A';

-- FIX: vincular padre.demo con el estudiante demo
INSERT INTO padres_estudiantes (padre_usuario_id, estudiante_id, parentesco)
SELECT u.usuarios_id, e.estudiantes_id, 'padre/madre'
FROM usuarios u, estudiantes e
WHERE u.email = 'padre.demo@nda.com' AND e.codigo = 'EST-DEMO01';

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
-- Seed: contenido real del CMS (blog publico y recursos PDF)
-- ------------------------------------------------------------

INSERT INTO recursos (titulo, descripcion, categoria, tags, archivo, tamano_bytes, orden) VALUES
('Afiche informativo: sismos', 'Afiche con recomendaciones básicas antes, durante y después de un sismo.', 'sismo', 'Sismos,Afiche', 'assets/media/guias/Afiche-Sismos.pdf', '178054', '5'),
('¿Qué son los sismos?', 'Explicación sencilla sobre qué son los sismos y cómo se originan.', 'sismo', 'Sismos,Educativo', 'assets/media/guias/QueSonSismos.pdf', '448292', '10'),
('Hoja informativa sobre sismos', 'Ficha técnica con datos clave sobre el fenómeno sísmico.', 'sismo', 'Sismos,Informativo', 'assets/media/guias/Hoja-informativa-Sismos-SGC.pdf', '3548140', '15'),
('Preparación ante sismos', 'Guía práctica para prepararse antes de que ocurra un sismo.', 'sismo', 'Sismos,Preparación', 'assets/media/guias/Preparacion ante sismos.pdf', '13630863', '20'),
('Folleto de sismos (PNUD)', 'Folleto informativo del PNUD sobre sismos y su prevención.', 'sismo', 'Sismos,PNUD', 'assets/media/guias/Folleto_SISMOS_ PNUD_V4.pdf', '23448888', '25'),
('Magnitud e intensidad de un sismo', 'Diferencias entre magnitud e intensidad sísmica explicadas de forma clara.', 'sismo', 'Sismos,Educativo', 'assets/media/guias/magnitudiintensidad.pdf', '106080', '30'),
('Sismos: ciencia y comunidad en la gestión de riesgos', 'Material sobre el rol de la ciencia y la comunidad en la gestión del riesgo sísmico.', 'sismo', 'Sismos,Gestión de riesgo', 'assets/media/guias/CARE_CENAIS_Cuba_SismoCienciaycomunidadenlagestiondelosriesgosnaturales.pdf', '3370760', '35'),
('Afiche de simulacro de sismo', 'Afiche de apoyo para la organización de simulacros de sismo.', 'sismo', 'Sismos,Simulacro', 'assets/media/guias/Simulacro2018-Afiche2.pdf', '2142651', '40'),
('Guía de evacuación escolar', 'Guía completa para planificar y ejecutar la evacuación escolar ante una emergencia.', 'evacuacion', 'Evacuación,Escolar', 'assets/media/guias/Evacuacion escolar.pdf', '12050842', '5'),
('Cómo armar tu mochila de emergencia', 'Lista de artículos esenciales para preparar tu mochila de emergencia.', 'mochila', 'Mochila,Preparación', 'assets/media/guias/Mochila emergencia.pdf', '615709', '5'),
('Mochila de emergencia: guía complementaria', 'Recomendaciones adicionales para equipar la mochila de emergencia familiar.', 'mochila', 'Mochila,Preparación', 'assets/media/guias/Mochila emergencia2.pdf', '710429', '10'),
('Plan familiar de emergencia', 'Guía para crear un plan familiar de emergencia ante desastres naturales.', 'plan', 'Plan Familiar,Preparación', 'assets/media/guias/Plan familiar.pdf', '14375346', '5'),
('Guía metodológica para docentes', 'Guía metodológica dirigida a docentes para la gestión del riesgo en el aula.', 'plan', 'Docentes,Educativo', 'assets/media/guias/Guía metodológica para docentes.pdf', '7332819', '10'),
('Protocolo ante lluvias e inundaciones', 'Protocolo de acción ante lluvias intensas e inundaciones.', 'lluvias', 'Lluvias,Protocolo', 'assets/media/guias/Protocolo lluvias.pdf', '2121125', '5'),
('Protocolo ante lluvias: guía complementaria', 'Recomendaciones adicionales para la temporada de lluvias.', 'lluvias', 'Lluvias,Protocolo', 'assets/media/guias/Protocolo lluvias2.pdf', '1087682', '10'),
('Los impactos del cambio climático', 'Explicación de los principales impactos del cambio climático.', 'clima', 'Clima,Cambio climático', 'assets/media/guias/Los impactos del cambio climático.pdf', '1777493', '5'),
('Eventos meteorológicos extremos', 'Descripción de los eventos meteorológicos extremos y cómo prepararse.', 'clima', 'Clima,Meteorología', 'assets/media/guias/los-eventos-meteorologicos-extremos.pdf', '2071504', '10'),
('Eventos meteorológicos extremos en El Salvador', 'Análisis de eventos meteorológicos extremos en el contexto salvadoreño.', 'clima', 'Clima,El Salvador', 'assets/media/guias/2013_ElSalvador7_eventos_meteorol_extremos.pdf', '1533261', '15'),
('Volcanes: guía general', 'Guía general sobre volcanes: qué son y cómo se forman.', 'volcanes', 'Volcanes,Educativo', 'assets/media/guias/Volcanes.pdf', '9262202', '5'),
('Atlas de volcanes', 'Atlas ilustrado con información sobre distintos volcanes.', 'volcanes', 'Volcanes,Atlas', 'assets/media/guias/3 Atlas de volcanes.pdf', '8922301', '10'),
('Chile, tierra de volcanes', 'Material educativo sobre el vulcanismo en Chile.', 'volcanes', 'Volcanes,Educativo', 'assets/media/guias/Chile-tierra-de-volcanes.pdf', '6788558', '15'),
('La ciencia de los volcanes', 'Artículo sobre la ciencia detrás de la actividad volcánica.', 'volcanes', 'Volcanes,Ciencia', 'assets/media/guias/Ciencia_Volcanes_Articulo.pdf', '487642', '20'),
('Guía sobre volcanes', 'Guía extensa e ilustrada sobre volcanes y su actividad.', 'volcanes', 'Volcanes,Guía', 'assets/media/guias/guia volcanes.pdf', '33126163', '25'),
('Vulcanismo (UNAM)', 'Material académico de la UNAM sobre vulcanismo.', 'volcanes', 'Volcanes,Académico', 'assets/media/guias/VulcanismoUNAM.pdf', '632301', '30'),
('Volcanes activos (UNAM)', 'Listado e información sobre volcanes activos, material de la UNAM.', 'volcanes', 'Volcanes,Académico', 'assets/media/guias/VolcanesActivosUNAM.pdf', '268659', '35'),
('Volcanes: conoce más', 'Material informativo para conocer más sobre los volcanes.', 'volcanes', 'Volcanes,Educativo', 'assets/media/guias/cm-feb2021-volcanoes-spanish.pdf', '4260109', '40'),
('Aprendamos a protegernos: erupciones volcánicas', 'Guía para aprender a protegerse ante erupciones volcánicas.', 'volcanes', 'Volcanes,Protección', 'assets/media/guias/Aprendamos-a-protegernos-Las-Erupciones-Volcanicas.pdf', '1590036', '45'),
('Ciencias ambientales: los volcanes', 'Material de ciencias ambientales enfocado en los volcanes.', 'volcanes', 'Volcanes,Ciencias ambientales', 'assets/media/guias/195_196_cs_ambientales_los_volcanes.pdf', '378038', '50'),
('Los volcanes de México', 'Información sobre los principales volcanes de México.', 'volcanes', 'Volcanes,México', 'assets/media/guias/Tema_1_Volcanes_Mexico.pdf', '8296835', '55'),
('Teoría de vulcanología', 'Material teórico introductorio sobre vulcanología.', 'volcanes', 'Volcanes,Teoría', 'assets/media/guias/VLC-Teoria-Volcanologia.pdf', '2286359', '60'),
('¿Qué son los deslizamientos?', 'Explicación básica sobre qué son los deslizamientos de tierra.', 'deslizamientos', 'Deslizamientos,Educativo', 'assets/media/guias/DESLIZAMIENTOS QUE SON.pdf', '520457', '5'),
('¿Por qué ocurren los deslizamientos?', 'Causas y factores que originan los deslizamientos de tierra.', 'deslizamientos', 'Deslizamientos,Educativo', 'assets/media/guias/deslizamientos_porquedesan.pdf', '1213396', '10'),
('Tipos de deslizamientos', 'Clasificación de los distintos tipos de deslizamientos de tierra.', 'deslizamientos', 'Deslizamientos,Educativo', 'assets/media/guias/tiposdeslizamientos.pdf', '2116996', '15'),
('Movimientos de laderas en El Salvador', 'Estudio sobre movimientos de laderas y deslizamientos en El Salvador.', 'deslizamientos', 'Deslizamientos,El Salvador', 'assets/media/guias/2013_ElSalvador2_movimientos_laderas.pdf', '1040797', '20'),
('Protege a tu familia de derrumbes y deslizamientos', 'Recomendaciones para proteger a la familia ante derrumbes y deslizamientos.', 'deslizamientos', 'Deslizamientos,Preparación', 'assets/media/guias/59362_protegetufamiliaderrumbesydeslizami.pdf', '8642571', '25'),
('Lista de preparación ante deslizamientos', 'Checklist de preparación familiar ante deslizamientos de tierra.', 'deslizamientos', 'Deslizamientos,Checklist', 'assets/media/guias/Landslide-Preparedness-Checklist-Spanish.pdf', '371240', '30'),
('Prepárate ante deslizamientos (SENAPRED)', 'Guía de SENAPRED para prepararse ante deslizamientos.', 'deslizamientos', 'Deslizamientos,Preparación', 'assets/media/guias/05_preparate_con_senapred_deslizamientos_esp.pdf', '1122341', '35'),
('Prepárate ante tsunamis (SENAPRED)', 'Guía de SENAPRED para prepararse ante un tsunami.', 'tsunamis', 'Tsunamis,Preparación', 'assets/media/guias/02_preparate_con_senapred_tsunami_esp.pdf', '1439686', '5'),
('Tsunamis: guía accesible', 'Guía sobre tsunamis en formato accesible.', 'tsunamis', 'Tsunamis,Educativo', 'assets/media/guias/04-Tsunamis_accesible.pdf', '1080034', '10'),
('Infografía sobre tsunamis', 'Infografía con información clave sobre los tsunamis.', 'tsunamis', 'Tsunamis,Infografía', 'assets/media/guias/303-INFOGRAFATSUNAMIS.pdf', '1536676', '15'),
('Grandes olas: qué son los tsunamis', 'Material explicativo sobre qué son los tsunamis y cómo se forman.', 'tsunamis', 'Tsunamis,Educativo', 'assets/media/guias/Grandes-Olas-Esp.pdf', '1113382', '20'),
('Tríptico informativo sobre tsunamis', 'Tríptico con recomendaciones ante un tsunami.', 'tsunamis', 'Tsunamis,Tríptico', 'assets/media/guias/Triptico sobre tsunamis.pdf', '1748541', '25'),
('Fascículo sobre tsunamis (CENAPRED)', 'Fascículo educativo de CENAPRED sobre tsunamis.', 'tsunamis', 'Tsunamis,CENAPRED', 'assets/media/guias/fasciculo_tsunamis_cenapred.pdf', '1946878', '30'),
('Glosario de términos sobre tsunamis', 'Glosario con los términos más usados relacionados a tsunamis.', 'tsunamis', 'Tsunamis,Glosario', 'assets/media/guias/glosario_tsunamis_sp.pdf', '3788463', '35'),
('Qué hacer ante terremoto y tsunami', 'Recomendaciones de qué hacer ante un terremoto seguido de tsunami.', 'tsunamis', 'Tsunamis,Sismos', 'assets/media/guias/Quehacer_Terremoto_Tsunami.pdf', '1018614', '40'),
('Get ready for tsunami (SENAPRED, English)', 'Guía en inglés de SENAPRED para prepararse ante un tsunami.', 'tsunamis', 'Tsunamis,English', 'assets/media/guias/02_get_ready_with_senapred_tsunami_eng.pdf', '1509610', '45'),
('Get ready for landslides (SENAPRED, English)', 'Guía en inglés de SENAPRED para prepararse ante deslizamientos.', 'deslizamientos', 'Deslizamientos,English', 'assets/media/guias/05_get_ready_with_senapred_landslides_eng.pdf', '1242755', '45'),
('Tsunamis: what are they? (English)', 'Ficha educativa en inglés sobre qué son los tsunamis y cómo se originan.', 'tsunamis', 'Tsunamis,English,Educativo', 'assets/media/guias/2-Tuesday-literacy-task.pdf', '1352337', '50'),
('Origen de los volcanes', 'Material extenso sobre el origen y la formación de los volcanes.', 'volcanes', 'Volcanes,Educativo', 'assets/media/guias/2021-Origen_de_volcanes.pdf', '49036825', '65'),
('Los sismos: fuerza y movimiento', 'Material didáctico sobre qué son los sismos y cómo se producen.', 'sismo', 'Sismos,Educativo', 'assets/media/guias/5.4.6.pdf', '2481479', '45'),
('Deslizamientos: guía informativa', 'Guía informativa sobre los deslizamientos de tierra.', 'deslizamientos', 'Deslizamientos,Educativo', 'assets/media/guias/Deslizamiento.pdf', '1032161', '40'),
('Los deslizamientos de tierra', 'Material informativo general sobre los deslizamientos de tierra.', 'deslizamientos', 'Deslizamientos,Educativo', 'assets/media/guias/deslizamientos.pdf', '1042992', '42'),
('Deslizamientos de tierra: información clave', 'Informaciones clave y kit de referencia sobre deslizamientos de tierra.', 'deslizamientos', 'Deslizamientos,Informativo', 'assets/media/guias/Deslizamientos de tierra-Disaster_package-Epidemic_Control_Toolkit-Volunteer.pdf', '64949', '44'),
('Las erupciones volcánicas', 'Capítulo educativo dedicado a las erupciones volcánicas.', 'volcanes', 'Volcanes,Educativo', 'assets/media/guias/doc14707-3.pdf', '158271', '62'),
('Guía de evacuación escolar (complementaria)', 'Cartilla complementaria con la guía de evacuación escolar.', 'evacuacion', 'Evacuación,Escolar', 'assets/media/guias/Evacuacion escolarnCartilla-Guia-de-evacuacion-Escolar-1.pdf', '16363456', '10'),
('Vulcanismo: origen, procesos y formas resultantes', 'Material académico sobre el vulcanismo, sus procesos y formas resultantes.', 'volcanes', 'Volcanes,Académico', 'assets/media/guias/joalberto22.pdf', '3879390', '63'),
('Tsunami: qué es y cómo se origina', 'Explicación sobre qué es un tsunami y cómo se origina en zonas costeras.', 'tsunamis', 'Tsunamis,Educativo', 'assets/media/guias/p17054coll1_7.pdf', '1203355', '42'),
('Plan familiar de emergencia: guía complementaria', 'Guía complementaria del gobierno para elaborar un plan familiar de emergencia.', 'plan', 'Plan Familiar,Preparación', 'assets/media/guias/plan familiar(1).pdf', '8002219', '12'),
('¿Qué es un sismo?', 'Ficha educativa sobre qué es un sismo.', 'sismo', 'Sismos,Educativo', 'assets/media/guias/queessismo.pdf', '284234', '12'),
('Deslizamiento de laderas', 'Material informativo sobre el deslizamiento de laderas.', 'deslizamientos', 'Deslizamientos,Educativo', 'assets/media/guias/Tema_1._Deslizamiento_de_laderas.pdf', '4792811', '46'),
('Creencias y realidades sobre sismos', 'Artículo de divulgación de la UNAM sobre creencias y realidades en torno a los sismos.', 'sismo', 'Sismos,Divulgación', 'assets/media/guias/unamirada_636.pdf', '3590405', '45'),
('Los volcanes: preguntas frecuentes', 'Preguntas y respuestas frecuentes sobre los volcanes.', 'volcanes', 'Volcanes,Educativo', 'assets/media/guias/volcan.pdf', '2200283', '64'),
('¿Qué es un volcán?', 'Explicación básica sobre qué es un volcán y cómo se forma.', 'volcanes', 'Volcanes,Educativo', 'assets/media/guias/volcanes-5efe192552c19.pdf', '8229644', '66');

INSERT INTO blog (slug, titulo, cat, tag, color, autor_nombre, tiempo, destacado, extracto, imagen, cuerpo) VALUES
('72-horas', 'Cómo preparar a tu familia en 72 horas', 'prevencion', 'Prevención', '#f29f05', 'Equipo NDA', '6 min', 1, 'La regla de las primeras 72 horas puede marcar la diferencia. Qué hacer, paso a paso, antes de que llegue la próxima emergencia.', 'assets/media/blog/Cómo preparar a tu familia en 72 horas.jpg', '<p class=\"art-lead\">Las primeras 72 horas tras un desastre son las más críticas: es el tiempo que puede pasar antes de que la ayuda externa llegue a tu zona. Prepararte para ese lapso no requiere dinero ni equipo especial, solo organización. Aquí tienes el plan completo.</p>\n<h3 class=\"art-h3\">¿Por qué 72 horas?</h3>\n<p>Cuando ocurre un sismo fuerte o una inundación, los servicios de emergencia se saturan y las vías pueden quedar bloqueadas. Protección Civil y el COEN priorizan las zonas más afectadas, y tu colonia podría quedar sola durante uno a tres días. Tener lo básico para ese periodo convierte una crisis en una incomodidad manejable.</p>\n<div class=\"art-key\"><strong>La regla de oro</strong>Agua, comida, luz, información y documentos. Si tu hogar tiene cubiertos esos cinco frentes para tres días, ya estás por delante de la mayoría.</div>\n<h3 class=\"art-h3\">Agua y alimentos</h3>\n<p>Calcula al menos 3 litros de agua por persona al día: uno para beber y dos para higiene y cocina. Para una familia de cuatro, eso son unos 36 litros para tres días. Guarda comida que no necesite refrigeración ni cocción: enlatados, granola, galletas, atún. Revisa las fechas cada seis meses.</p>\n<h3 class=\"art-h3\">Documentos y plan</h3>\n<p>Reúne copias de DUI, partidas de nacimiento, escrituras y carnets médicos en una bolsa plástica sellada. Acuerda con tu familia un punto de reunión y un contacto fuera del país a quien todos puedan llamar si se separan. Escribe los números de emergencia en papel: en una crisis el celular puede quedarse sin batería.</p>\n<h3 class=\"art-h3\">Practica antes de necesitarlo</h3>\n<p>Un plan que nunca se ensaya falla cuando más importa. Haz un simulacro en casa: corta la luz un momento, ubica la mochila a oscuras, repasa la ruta de salida. Diez minutos al mes bastan para que el cuerpo recuerde qué hacer sin pensar.</p>\n<div class=\"art-takeaway\"><h4>Para recordar</h4><ul><li>3 litros de agua por persona al día, para 3 días.</li><li>Comida sin cocción y con fecha vigente.</li><li>Documentos en bolsa sellada + números en papel.</li><li>Punto de reunión y contacto acordados.</li><li>Ensaya el plan una vez al mes.</li></ul></div>'),
('agachate', 'Agáchate, cúbrete y agárrate: la técnica que funciona', 'sismos', 'Sismos', '#f29f05', 'Equipo NDA', '4 min', 0, 'Por qué tres segundos de reacción correcta valen más que correr. La ciencia detrás del protocolo.', 'assets/media/blog/agachate-cubrete....jpg', '<p class=\"art-lead\">Cuando la tierra se mueve, tu cuerpo quiere correr. Pero los datos de miles de sismos demuestran que la mayoría de las lesiones ocurren al intentar desplazarse durante el movimiento. El protocolo internacional se resume en tres palabras: <strong>agáchate, cúbrete y agárrate</strong>.</p>\n<h3 class=\"art-h3\">1. Agáchate</h3>\n<p>Bájate al suelo antes de que el sismo te tire. Ponte sobre manos y rodillas: esa posición te protege de caídas y te permite moverte si hace falta. Estar abajo reduce la posibilidad de que objetos que vuelan te golpeen.</p>\n<h3 class=\"art-h3\">2. Cúbrete</h3>\n<p>Protege la cabeza y el cuello, que son las zonas más vulnerables. Métete debajo de una mesa o escritorio resistente. Si no hay ninguno cerca, agáchate junto a un muro interior, lejos de ventanas, y cúbrete la nuca con los brazos.</p>\n<h3 class=\"art-h3\">3. Agárrate</h3>\n<p>Sujeta la pata del mueble que te cubre y mantente con él si se desplaza. El movimiento puede durar segundos que se sienten eternos; aguanta hasta que todo se detenga por completo antes de levantarte.</p>\n<div class=\"art-key\"><strong>El mito de la puerta</strong>Durante años se dijo que el marco de la puerta era lo más seguro. En construcciones modernas no lo es: las puertas oscilan y no protegen de objetos que caen. Mejor una mesa firme.</div>\n<h3 class=\"art-h3\">Por qué no correr</h3>\n<p>Tres segundos de reacción correcta valen más que correr hacia una salida. Las escaleras, los pasillos y las fachadas son justo donde caen vidrios, repisas y escombros. Quédate, protégete y muévete solo cuando el suelo deje de temblar.</p>\n<div class=\"art-takeaway\"><h4>Para recordar</h4><ul><li>Agáchate: al suelo, sobre manos y rodillas.</li><li>Cúbrete: cabeza y cuello, bajo mueble firme.</li><li>Agárrate: sujétate hasta que termine.</li><li>No corras ni uses el ascensor.</li></ul></div>'),
('lluvias', 'Temporada de lluvias: señales que no debes ignorar', 'lluvias', 'Lluvias', '#2e7da6', 'Equipo NDA', '5 min', 0, 'Quebradas que crecen, suelos saturados y ese olor a tierra mojada. Aprende a leer el riesgo.', 'assets/media/blog/temporadaLluvias.jpg', '<p class=\"art-lead\">En El Salvador la temporada de lluvias transforma quebradas tranquilas en corrientes mortales en minutos. La diferencia entre un susto y una tragedia suele estar en saber leer las señales a tiempo. Estas son las que nunca debes ignorar.</p>\n<h3 class=\"art-h3\">El suelo ya está saturado</h3>\n<p>Tras varios días de lluvia, la tierra deja de absorber agua. A partir de ahí, cualquier aguacero corre por la superficie y multiplica el riesgo de inundación y deslizamiento. Si llovió toda la semana, trata la siguiente lluvia con más respeto.</p>\n<h3 class=\"art-h3\">Señales de deslizamiento</h3>\n<p>Presta atención a grietas nuevas en el suelo o en las paredes, árboles o postes inclinados, agua que sale turbia o con barro, y ruidos sordos provenientes de la ladera. Cualquiera de estas señales significa moverse de inmediato a un lugar firme y alto.</p>\n<div class=\"art-key\"><strong>Regla del agua en movimiento</strong>Apenas 30 cm de agua corriente pueden arrastrar a una persona, y 60 cm a un vehículo. Nunca cruces una calle, puente o vado inundado, aunque parezca poco.</div>\n<h3 class=\"art-h3\">Las quebradas crecen sin avisar</h3>\n<p>Una quebrada puede crecer aunque no esté lloviendo donde tú estás: basta con que llueva fuerte montaña arriba. Si vives cerca de una, no esperes a ver el agua subir; aléjate cuando el MARN emita alerta naranja o roja.</p>\n<h3 class=\"art-h3\">Manténte informado</h3>\n<p>Ten una radio a pilas y sigue los comunicados oficiales del MARN y Protección Civil. La información correcta a tiempo es tu mejor herramienta: te dice cuándo quedarte y cuándo evacuar.</p>\n<div class=\"art-takeaway\"><h4>Para recordar</h4><ul><li>Suelo saturado = más riesgo en la siguiente lluvia.</li><li>Grietas, árboles inclinados y agua turbia: evacúa.</li><li>Nunca cruces agua en movimiento.</li><li>Sigue alertas del MARN por radio a pilas.</li></ul></div>'),
('mochila', 'Tu mochila de emergencia en 10 objetos', 'prevencion', 'Prevención', '#2e8b7f', 'Equipo NDA', '3 min', 0, 'Sin gastar de más. La lista mínima que cualquier hogar salvadoreño debería tener lista hoy.', 'assets/media/blog/Tu mochila de emergencia en 10 objetos.jpg', '<p class=\"art-lead\">No necesitas gastar de más para tener una mochila de emergencia funcional. Estos son los diez objetos que cualquier hogar salvadoreño debería tener listos hoy, ordenados por prioridad.</p>\n<h3 class=\"art-h3\">Los esenciales</h3>\n<ol class=\"art-steps\">\n<li><strong>Agua</strong> — 3 litros por persona al día. Es lo primero que falta y lo más difícil de improvisar.</li>\n<li><strong>Comida no perecedera</strong> — enlatados, granola, atún. Sin cocción.</li>\n<li><strong>Linterna</strong> — de mano o de cabeza, mejor que velas (riesgo de incendio).</li>\n<li><strong>Radio a pilas</strong> — tu línea con el mundo cuando se va la señal.</li>\n<li><strong>Pilas de repuesto</strong> — para linterna y radio.</li>\n<li><strong>Botiquín</strong> — gasas, alcohol, vendas, analgésicos y tus medicinas habituales.</li>\n<li><strong>Documentos</strong> — copias de DUI y partidas en bolsa sellada.</li>\n<li><strong>Silbato</strong> — para pedir ayuda si quedas atrapado; gasta menos energía que gritar.</li>\n<li><strong>Abrigo y muda</strong> — ropa seca y una manta ligera.</li>\n<li><strong>Efectivo</strong> — en billetes pequeños; los cajeros y datáfonos pueden no funcionar.</li>\n</ol>\n<div class=\"art-key\"><strong>Dónde guardarla</strong>Cerca de la salida principal, en un lugar que todos conozcan y puedan alcanzar a oscuras. De nada sirve una mochila perfecta si nadie sabe dónde está.</div>\n<h3 class=\"art-h3\">Revísala dos veces al año</h3>\n<p>Marca en tu calendario dos fechas fijas (por ejemplo, el cambio de hora o el inicio de la temporada de lluvias) para revisar fechas de vencimiento, cambiar el agua y probar la linterna.</p>\n<div class=\"art-takeaway\"><h4>Para recordar</h4><ul><li>Agua y comida sin cocción primero.</li><li>Luz e información: linterna, radio y pilas.</li><li>Botiquín, documentos, silbato y efectivo.</li><li>Guárdala accesible y revísala 2 veces al año.</li></ul></div>'),
('vecinos', 'Vecinos organizados: el primer equipo de rescate', 'comunidad', 'Comunidad', '#f2b705', 'Equipo NDA', '7 min', 0, 'Cómo una colonia de Soyapango montó su propio plan de evacuación en un fin de semana.', 'assets/media/blog/el primer equipo de rescate.jpg', '<p class=\"art-lead\">En los primeros minutos de una emergencia, quien te rescata no es la ambulancia: son tus vecinos. Una colonia organizada salva más vidas que cualquier equipo que llegue después. Así puedes montar un plan comunitario en un fin de semana.</p>\n<h3 class=\"art-h3\">Empieza por conocerse</h3>\n<p>El primer paso no es técnico, es humano. Reúne a las familias de tu cuadra y hagan una lista: quién vive solo, quién tiene movilidad reducida, quién es enfermero o sabe primeros auxilios, quién tiene herramientas. Esa lista es la base de todo.</p>\n<h3 class=\"art-h3\">Asignen roles claros</h3>\n<p>En una crisis, la confusión cuesta vidas. Definan con anticipación quién avisa a Protección Civil, quién revisa a los vecinos vulnerables, quién corta el gas o la electricidad de la zona, y quién guía hacia el punto de reunión. Cuando cada quien sabe su tarea, la respuesta es inmediata.</p>\n<div class=\"art-key\"><strong>El caso de Soyapango</strong>Una colonia organizó su plan en un solo fin de semana: un mapa de la cuadra, una lista de vecinos por casa y un punto de reunión en la cancha. Cuando vino la siguiente alerta, evacuaron en orden y sin pánico.</div>\n<h3 class=\"art-h3\">Acuerden un punto de reunión</h3>\n<p>Elijan un espacio abierto y conocido por todos —una cancha, un parque, una esquina amplia— lejos de postes y muros que puedan caer. Que todos sepan llegar allí incluso de noche.</p>\n<h3 class=\"art-h3\">Practiquen una vez</h3>\n<p>Un simulacro comunitario al año mantiene el plan vivo. No necesita ser perfecto; lo importante es que la primera vez que se prueba no sea durante una emergencia real.</p>\n<div class=\"art-takeaway\"><h4>Para recordar</h4><ul><li>Conózcanse: lista de vecinos y sus necesidades.</li><li>Roles definidos antes de la crisis.</li><li>Punto de reunión abierto y seguro.</li><li>Un simulacro comunitario al año.</li></ul></div>'),
('simulacro', '\"El simulacro nos salvó\": la historia de una escuela', 'testimonios', 'Testimonio', '#d91a2a', 'Equipo NDA', '6 min', 0, 'Practicaron tantas veces que cuando tembló de verdad, nadie dudó. Un relato en primera persona.', 'assets/media/blog/El simulacro nos salvó.jpg', '<p class=\"art-lead\">\"Lo practicamos tantas veces que parecía un juego. Hasta que dejó de serlo.\" Así recuerda una maestra el día en que el simulacro que tantos estudiantes refunfuñaban terminó protegiéndolos de verdad.</p>\n<h3 class=\"art-h3\">El simulacro que nadie tomaba en serio</h3>\n<p>Cada mes, la escuela hacía lo mismo: sonaba la alarma, los niños se agachaban bajo los pupitres, se cubrían la cabeza y, al cesar la señal, salían en fila al patio. Para muchos era una pausa divertida en clase. Para la maestra, era repetición con propósito.</p>\n<h3 class=\"art-h3\">El día que tembló de verdad</h3>\n<p>Cuando el sismo real llegó, no hubo tiempo de pensar. Y precisamente por eso funcionó: los cuerpos ya sabían qué hacer. Nadie corrió, nadie gritó, nadie se quedó congelado. La fila salió al patio como cualquier otro mes, solo que esta vez el suelo se movía.</p>\n<div class=\"art-quote\">\"No tuvimos que decidir nada. Las manos de los niños ya iban hacia la cabeza antes de que yo abriera la boca.\"</div>\n<h3 class=\"art-h3\">La lección</h3>\n<p>El valor de un simulacro no está en el día que lo haces, sino en el día que no sabes que vendrá. La repetición convierte el conocimiento en reflejo, y en una emergencia el reflejo es lo único que responde a tiempo.</p>\n<h3 class=\"art-h3\">Llévalo a tu casa</h3>\n<p>No hace falta una escuela para practicar. En familia, repasen una vez al mes dónde cubrirse, por dónde salir y dónde reunirse. Háganlo aunque parezca innecesario: ese es justo el punto.</p>\n<div class=\"art-takeaway\"><h4>Para recordar</h4><ul><li>La repetición convierte el saber en reflejo.</li><li>En la emergencia real no hay tiempo de pensar.</li><li>Practica en casa una vez al mes.</li></ul></div>'),
('punto', 'El punto de reunión que toda familia necesita', 'prevencion', 'Prevención', '#6a6fb5', 'Equipo NDA', '4 min', 0, 'Si se pierde la señal y nadie sabe dónde está el otro, este simple acuerdo lo resuelve.', 'assets/media/blog/El punto de reunión que toda familia necesita.jpg', '<p class=\"art-lead\">Si una emergencia separa a tu familia y se cae la señal del celular, ¿cómo se reencuentran? La respuesta es un acuerdo simple que toda familia debería tener y que no cuesta nada: el punto de reunión.</p>\n<h3 class=\"art-h3\">Por qué lo necesitas</h3>\n<p>Los desastres no avisan ni respetan horarios. Pueden encontrarte en el trabajo, a los niños en la escuela y a alguien más en la calle. Sin un lugar acordado de antemano, cada quien buscará al otro a ciegas, justo cuando moverse es más peligroso.</p>\n<h3 class=\"art-h3\">Define dos puntos, no uno</h3>\n<p>Necesitas dos niveles. El primero, un <strong>punto cercano</strong>: un lugar fuera de casa, como la esquina o un árbol del parque, para reunirse si tienen que salir rápido. El segundo, un <strong>punto lejano</strong>: la casa de un familiar en otra zona, por si el barrio queda incomunicado o no es seguro volver.</p>\n<div class=\"art-key\"><strong>Elige bien el lugar</strong>Que sea abierto, conocido por todos y alejado de postes, muros y ventanales. Y que cada miembro sepa llegar allí por su cuenta, incluso de noche.</div>\n<h3 class=\"art-h3\">Suma un contacto puente</h3>\n<p>Acuerden una persona de confianza que viva en otra ciudad o país a quien todos llamen o escriban para reportar que están bien. A veces es más fácil comunicarse fuera de la zona afectada que dentro de ella.</p>\n<h3 class=\"art-h3\">Escríbelo y repásalo</h3>\n<p>Anota los puntos y el contacto en una tarjeta para la cartera de cada quien y en la mochila de emergencia. Repásenlo dos veces al año hasta que todos lo sepan de memoria.</p>\n<div class=\"art-takeaway\"><h4>Para recordar</h4><ul><li>Un punto cercano y uno lejano.</li><li>Lugares abiertos, seguros y conocidos por todos.</li><li>Un contacto puente fuera de la zona.</li><li>Escríbelo y repásalo dos veces al año.</li></ul></div>'),
('noticia-2001-enero', 'Terremoto de 7.7 sacude El Salvador (2001)', 'sismos', 'Sismo Histórico', '#d91a2a', 'La Prensa Gráfica', '5 min', 0, 'El 13 de enero de 2001, el terremoto más fuerte desde 1986 dejó 844 muertos.', 'assets/media/blog/terremoto2001.jpg', '<p class=\"art-lead\">El 13 de enero de 2001, un terremoto de magnitud 7.7 sacudió El Salvador, convirtiéndose en el más fuerte registrado en el país desde 1986. El epicentro fue frente a la costa de Usulután.</p>\n<p>Según La Prensa Gráfica, el sismo duró más de 40 segundos y fue sentido en toda Centroamérica. \"San Miguel, Usulután y La Unión quedaron en ruinas. Los edificios más antiguos no resistieron\", relataban los periodistas desde el lugar.</p>\n<p>El presidente Francisco Flores declaró emergencia nacional y activó los protocolos de respuesta. Los equipos de rescate trabajaron sin descanso en las zonas más afectadas.</p>\n<div class=\"art-key\"><strong>Cifras oficiales</strong>844 muertos, 5,500 heridos y 150,000 damnificados. Las pérdidas económicas superaron los 300 millones de dólares.</div>\n<p>La comunidad internacional respondió de inmediato. Más de 20 países enviaron ayuda humanitaria, equipos de rescate y especialistas en búsqueda y salvamento.</p>\n<h3 class=\"art-h3\">Una tragedia que marcó al país</h3>\n<p>El terremoto de enero de 2001 expuso las debilidades estructurales de las viviendas y edificios públicos. Muchas construcciones no cumplían con las normas antisísmicas, lo que agravó la tragedia. A partir de ese momento, se reforzaron los controles de construcción y se actualizó el código de edificación.</p>\n<div class=\"art-takeaway\"><h4>Fuente</h4><ul><li><strong>Autor:</strong> Redacción La Prensa Gráfica</li><li><strong>Fecha:</strong> 13 de enero de 2001</li><li><strong>Enlace:</strong> <a href=\"https://www.laprensagrafica.com/\" target=\"_blank\" style=\"color:#f29f05;\">laprensagrafica.com</a></li></ul></div>'),
('noticia-2005', 'Erupción del volcán Santa Ana (2005)', 'volcanes', 'Volcán Histórico', '#f29f05', 'El Diario de Hoy', '4 min', 0, 'El 1 de octubre de 2005, el volcán Santa Ana entró en erupción evacuando a 2,000 personas.', 'assets/media/blog/santaAna2005.jpg', '<p class=\"art-lead\">El 1 de octubre de 2005, el volcán Santa Ana (Ilamatepec), el más alto de El Salvador, entró en erupción, expulsando ceniza y lava que obligaron a evacuar a más de 2,000 personas.</p>\n<p>Según El Diario de Hoy, la erupción comenzó a las 8:00 de la mañana. \"Una columna de ceniza de 10 kilómetros de altura se elevó sobre el volcán, visible desde toda la zona occidental\", relataban los periodistas.</p>\n<p>Las comunidades de Santa Ana, Chalchuapa y Coatepeque fueron las más afectadas. La ceniza cubrió plantaciones de café y afectó la salud respiratoria de miles de personas.</p>\n<div class=\"art-key\"><strong>Evacuación masiva</strong>2,000 personas evacuadas de las comunidades aledañas al volcán. El gobierno de Antonio Saca declaró alerta roja en la zona.</div>\n<p>La erupción del Santa Ana fue una de las más violentas en la historia reciente de El Salvador. El cráter del volcán sufrió cambios significativos, y el lago que albergaba desapareció debido a la actividad volcánica.</p>\n<div class=\"art-takeaway\"><h4>Fuente</h4><ul><li><strong>Autor:</strong> Redacción El Diario de Hoy</li><li><strong>Fecha:</strong> 1 de octubre de 2005</li><li><strong>Enlace:</strong> <a href=\"https://www.elsalvador.com/\" target=\"_blank\" style=\"color:#f29f05;\">elsalvador.com</a></li></ul></div>'),
('noticia-2009', 'Tormenta Ida: 198 muertos en 2009', 'lluvias', 'Inundación Histórica', '#2e7da6', 'La Prensa Gráfica', '4 min', 0, 'El 8 de noviembre de 2009, la tormenta Ida dejó 198 muertos y 15,000 damnificados.', 'assets/media/blog/tormentaIda2009.jpg', '<p class=\"art-lead\">El 8 de noviembre de 2009, la tormenta tropical Ida provocó inundaciones y deslaves en todo el país, dejando 198 muertos y más de 15,000 damnificados.</p>\n<p>Según La Prensa Gráfica, Ida dejó lluvias acumuladas de más de 400 mm en algunas zonas. \"El río Grande de San Miguel se desbordó, arrasando con comunidades enteras. En San Vicente, un deslave sepultó a decenas de personas\", relataban los periodistas desde el lugar.</p>\n<p>Los departamentos de San Vicente, Usulután y Cuscatlán fueron los más afectados. El gobierno de Mauricio Funes declaró emergencia nacional y pidió ayuda a la comunidad internacional.</p>\n<div class=\"art-key\"><strong>Cifras de la tragedia</strong>198 muertos, 15,000 damnificados y pérdidas económicas que superaron los 200 millones de dólares.</div>\n<div class=\"art-takeaway\"><h4>Fuente</h4><ul><li><strong>Autor:</strong> Redacción La Prensa Gráfica</li><li><strong>Fecha:</strong> 8 de noviembre de 2009</li><li><strong>Enlace:</strong> <a href=\"https://www.laprensagrafica.com/\" target=\"_blank\" style=\"color:#f29f05;\">laprensagrafica.com</a></li></ul></div>'),
('noticia-2011', 'Depresión Tropical 12-E (2011)', 'lluvias', 'Inundación Histórica', '#2e7da6', 'El Diario de Hoy', '4 min', 0, 'En octubre de 2011, la DT 12-E dejó 34 muertos y 50,000 damnificados.', 'assets/media/blog/depreTropical2011.jpg', '<p class=\"art-lead\">El 10 de octubre de 2011, la depresión tropical 12-E dejó lluvias históricas en El Salvador, con acumulados de más de 500 mm en 48 horas, provocando inundaciones masivas y deslaves en todo el territorio.</p>\n<p>Según El Diario de Hoy, el país entró en emergencia. \"En la zona central, los ríos se desbordaron. En San Salvador, las calles se convirtieron en ríos de lodo\", relataban los periodistas. Más de 34 personas perdieron la vida.</p>\n<p>Los departamentos de San Salvador, Cuscatlán y San Vicente fueron los más afectados. Miles de familias quedaron incomunicadas, y los albergues se llenaron de damnificados.</p>\n<div class=\"art-key\"><strong>Una tormenta histórica</strong>34 muertos, 50,000 damnificados y pérdidas superiores a los 300 millones de dólares.</div>\n<div class=\"art-takeaway\"><h4>Fuente</h4><ul><li><strong>Autor:</strong> Redacción El Diario de Hoy</li><li><strong>Fecha:</strong> 10 de octubre de 2011</li><li><strong>Enlace:</strong> <a href=\"https://www.elsalvador.com/\" target=\"_blank\" style=\"color:#f29f05;\">elsalvador.com</a></li></ul></div>'),
('noticia-2020-amanda', 'Tormenta Amanda (2020)', 'lluvias', 'Inundación Reciente', '#2e7da6', 'El Diario de Hoy', '4 min', 0, 'El 30 de mayo de 2020, Amanda golpeó en plena pandemia: 31 muertos.', 'assets/media/blog/Amanda2020.jpg', '<p class=\"art-lead\">El 30 de mayo de 2020, la tormenta tropical Amanda golpeó El Salvador en medio de la pandemia de COVID-19, dejando 31 muertos y más de 7,000 personas en albergues.</p>\n<p>Según El Diario de Hoy, Amanda tocó tierra con vientos de 65 km/h y lluvias de hasta 300 mm. \"La combinación de la pandemia y la tormenta colapsó los sistemas de salud y albergues\", relataban los periodistas.</p>\n<p>Los departamentos de San Salvador, La Libertad y Cuscatlán fueron los más afectados. Miles de familias perdieron sus viviendas y pertenencias, y la emergencia sanitaria complicó las labores de rescate.</p>\n<div class=\"art-key\"><strong>La tormenta en tiempos de pandemia</strong>31 muertos, 7,000 albergados y pérdidas millonarias. La peor tormenta desde Mitch.</div>\n<div class=\"art-takeaway\"><h4>Fuente</h4><ul><li><strong>Autor:</strong> Redacción El Diario de Hoy</li><li><strong>Fecha:</strong> 30 de mayo de 2020</li><li><strong>Enlace:</strong> <a href=\"https://www.elsalvador.com/\" target=\"_blank\" style=\"color:#f29f05;\">elsalvador.com</a></li></ul></div>'),
('noticia-2020-cristobal', 'Cristóbal mantiene las lluvias (2020)', 'lluvias', 'Inundación Reciente', '#2e7da6', 'La Prensa Gráfica', '3 min', 0, 'El 2 de junio de 2020, Cristóbal prolongó la emergencia tras Amanda.', 'assets/media/blog/Cristobal2020.jpg', '<p class=\"art-lead\">El 2 de junio de 2020, la tormenta tropical Cristóbal mantuvo las lluvias y la emergencia en El Salvador, apenas tres días después del paso de Amanda, saturando suelos y complicando la respuesta humanitaria.</p>\n<p>Según La Prensa Gráfica, Cristóbal no tocó tierra directamente, pero sus bandas nubosas descargaron lluvias de hasta 200 mm en las zonas ya afectadas por Amanda.</p>\n<div class=\"art-key\"><strong>El doble golpe climático</strong>Amanda y Cristóbal en menos de una semana. Suelos saturados. Más de 10,000 personas en albergues.</div>\n<div class=\"art-takeaway\"><h4>Fuente</h4><ul><li><strong>Autor:</strong> Redacción La Prensa Gráfica</li><li><strong>Fecha:</strong> 2 de junio de 2020</li><li><strong>Enlace:</strong> <a href=\"https://www.laprensagrafica.com/\" target=\"_blank\" style=\"color:#f29f05;\">laprensagrafica.com</a></li></ul></div>'),
('noticia-2022', 'Huracán Julia: 4,000 evacuados', 'huracanes', 'Huracán Reciente', '#1a7a7a', 'El Diario de Hoy', '4 min', 0, 'El 9 de octubre de 2022, Julia dejó 4,000 evacuados y daños en carreteras.', 'assets/media/blog/HJulia2022.jpg', '<p class=\"art-lead\">El 9 de octubre de 2022, el huracán Julia impactó El Salvador como tormenta tropical, dejando más de 4,000 evacuados y daños en carreteras, puentes y viviendas.</p>\n<p>Según El Diario de Hoy, Julia llegó con vientos de 85 km/h y lluvias de hasta 250 mm. \"Los ríos Grande de San Miguel y Lempa se desbordaron. En Usulután, las comunidades quedaron incomunicadas\", relataban los periodistas.</p>\n<p>Protección Civil reportó más de 4,000 personas en albergues. Los puentes en la carretera Panamericana y la Ruta Militar sufrieron daños significativos, interrumpiendo el tránsito hacia el oriente.</p>\n<div class=\"art-key\"><strong>Julia en El Salvador</strong>4,000 evacuados, 500 viviendas afectadas y daños en la infraestructura vial. Sin víctimas mortales.</div>\n<div class=\"art-takeaway\"><h4>Fuente</h4><ul><li><strong>Autor:</strong> Redacción El Diario de Hoy</li><li><strong>Fecha:</strong> 9 de octubre de 2022</li><li><strong>Enlace:</strong> <a href=\"https://www.elsalvador.com/\" target=\"_blank\" style=\"color:#f29f05;\">elsalvador.com</a></li></ul></div>'),
('noticia-2026-enero', 'Sismo de 4.1 frente a La Libertad (2026)', 'sismos', 'Sismo Reciente', '#d91a2a', 'El Diario de Hoy', '2 min', 0, 'El 10 de enero de 2026, un sismo de 4.1 fue percibido en San Salvador.', 'assets/media/blog/sismoEnero2026.jpg', '<p class=\"art-lead\">El 10 de enero de 2026, un sismo de magnitud 4.1 frente a la costa de La Libertad fue percibido en San Salvador, Santa Tecla y Lourdes, sin reporte de daños materiales.</p>\n<p>Según El Diario de Hoy, el sismo ocurrió a las 9:15 de la mañana, con epicentro a 45 km de la costa. \"El movimiento fue sentido en varios puntos de la capital, pero no se reportaron daños en infraestructura\", informó el MARN.</p>\n<div class=\"art-key\"><strong>Sismo de enero 2026</strong>Magnitud 4.1. Epicentro frente a La Libertad. Sin daños. Percibido en la zona metropolitana.</div>\n<div class=\"art-takeaway\"><h4>Fuente</h4><ul><li><strong>Autor:</strong> Redacción El Diario de Hoy</li><li><strong>Fecha:</strong> 10 de enero de 2026</li><li><strong>Enlace:</strong> <a href=\"https://www.elsalvador.com/noticias/nacional/sismo-marn/1258019/2026/\" target=\"_blank\" style=\"color:#f29f05;\">elsalvador.com</a></li></ul></div>');
