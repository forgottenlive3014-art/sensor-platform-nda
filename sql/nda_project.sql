CREATE DATABASE nda_project;
USE nda_project;

CREATE TABLE usuarios (
usuarios_id INT PRIMARY KEY AUTO_INCREMENT,
nombre VARCHAR(100),
email VARCHAR(100) UNIQUE,
contra VARCHAR(255),
-- Verificacion del correo personal al registrarse (codigo de 6 digitos
-- enviado por correo). Los directores no lo usan: verifican en su lugar
-- el correo institucional (ver codigo_verificacion en instituciones).
email_verificado TINYINT(1) NOT NULL DEFAULT 0,
codigo_verificacion_email VARCHAR(6) NULL,
codigo_verificacion_email_expira DATETIME NULL,
role ENUM('user','admin','director','docente','alumno','padre','administrativo') DEFAULT 'user',
institucion_id INT NULL,
estado_institucional ENUM('ninguno','pendiente','aprobado','rechazado') DEFAULT 'ninguno',
telefono VARCHAR(20) NULL,
materia VARCHAR(100) NULL,
foto_perfil VARCHAR(255) NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE instituciones (
instituciones_id INT PRIMARY KEY AUTO_INCREMENT,
nombre VARCHAR(100),
correo VARCHAR(255),
telefono VARCHAR(20),
logo VARCHAR(255),
direccion VARCHAR(255) NULL,
lat DECIMAL(10,7) NULL,
lng DECIMAL(10,7) NULL,
director_id INT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE usuarios
ADD CONSTRAINT fk_usuarios_institucion
FOREIGN KEY (institucion_id) REFERENCES instituciones(instituciones_id) ON DELETE SET NULL;

-- Solicitudes de personal/comunidad para unirse a una institucion existente.
-- El director (o admin) las aprueba o rechaza desde el modulo de gestion escolar.
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
visibilidad VARCHAR(150) DEFAULT 'todos',
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

-- Lecturas del sensor de vibracion (Arduino -> Processing -> PHP).
-- Es un demostrador educativo, NO un sistema oficial de alerta temprana.
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

CREATE TABLE asistencia_simulacros (
asistencia_simulacros_id INT PRIMARY KEY AUTO_INCREMENT,
simulacros_id INT,
estudiantes_id INT,
estado ENUM('presente', 'ausente', 'herido') DEFAULT 'presente',
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
UNIQUE KEY uniq_simulacro_estudiante (simulacros_id, estudiantes_id),
FOREIGN KEY (simulacros_id) REFERENCES simulacros(simulacros_id) ON DELETE CASCADE,
FOREIGN KEY (estudiantes_id) REFERENCES estudiantes(estudiantes_id) ON DELETE CASCADE
);

-- Relación Padre <-> Estudiante: un padre ve a sus hijos, un estudiante
-- puede tener más de un padre/encargado vinculado.
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

-- Noticias internas: comunicados del director/admin institucional hacia
-- su comunidad, o globales si los publica el Admin General.
CREATE TABLE noticias_internas (
noticias_internas_id INT PRIMARY KEY AUTO_INCREMENT,
instituciones_id INT NULL,
usuarios_id INT NOT NULL,
titulo VARCHAR(150) NOT NULL,
contenido TEXT NOT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (instituciones_id) REFERENCES instituciones(instituciones_id) ON DELETE CASCADE,
FOREIGN KEY (usuarios_id) REFERENCES usuarios(usuarios_id) ON DELETE CASCADE
);

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

CREATE TABLE blog (
blog_id INT PRIMARY KEY AUTO_INCREMENT,
titulo VARCHAR(200),
contenido TEXT,
autor_id INT,
imagen VARCHAR(255),
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
FOREIGN KEY (autor_id) REFERENCES usuarios(usuarios_id) ON DELETE CASCADE
);

-- DATOS DE PRUEBA --
-- Superadmin unico. El admin NO se registra desde el formulario publico (el
-- rol 'admin' no esta en la lista de roles institucionales que acepta
-- AuthController::processRegister): esta cuenta se crea solo aqui, a mano.
-- Cambia el correo y la contraseña antes de usarlo en serio -- esta
-- contraseña de ejemplo cumple los requisitos minimos (8+ caracteres,
-- mayuscula, minuscula, numero y simbolo) pero es publica en este repo.
INSERT INTO usuarios (nombre, email, contra, role) VALUES
('Super Administrador', 'admin@nda.com', SHA2('CambiaEsto2026!', 256), 'admin');

-- Instituciones
INSERT INTO instituciones (nombre, correo, telefono, logo) VALUES
('Colegio San José', 'info@colegiosanjose.edu.sv', '2233-4455', 'logo_sanjose.png'),
('Colegio Santa Ana', 'info@colegiosantaana.edu.sv', '2244-5566', 'logo_santaana.png'),
('Colegio Don Bosco', 'info@donbosco.edu.sv', '2255-6677', 'logo_donbosco.png');

-- Aulas
INSERT INTO aulas (nombre, grado, nivel, seccion, instituciones_id) VALUES
-- Colegio San José (instituciones_id = 1)
('1° A', 'Primero', 'Bachillerato', 'A', 1),
('1° B', 'Primero', 'Bachillerato', 'B', 1),
('1° C', 'Primero', 'Bachillerato', 'C', 1),
('1° D', 'Primero', 'Bachillerato', 'D', 1),
('1° E', 'Primero', 'Bachillerato', 'E', 1),
('1° F', 'Primero', 'Bachillerato', 'F', 1),
('2° A', 'Segundo', 'Bachillerato', 'A', 1),
('2° B', 'Segundo', 'Bachillerato', 'B', 1),
('2° C', 'Segundo', 'Bachillerato', 'C', 1),
('2° D', 'Segundo', 'Bachillerato', 'D', 1),
('2° E', 'Segundo', 'Bachillerato', 'E', 1),
('2° F', 'Segundo', 'Bachillerato', 'F', 1),
('3° A', 'Tercero', 'Bachillerato', 'A', 1),
('3° B', 'Tercero', 'Bachillerato', 'B', 1),
('3° C', 'Tercero', 'Bachillerato', 'C', 1),
('3° D', 'Tercero', 'Bachillerato', 'D', 1),
('3° E', 'Tercero', 'Bachillerato', 'E', 1),
('3° F', 'Tercero', 'Bachillerato', 'F', 1),

-- Colegio Santa Ana (instituciones_id = 2)
('1° A', 'Primero', 'Bachillerato', 'A', 2),
('1° B', 'Primero', 'Bachillerato', 'B', 2),
('1° C', 'Primero', 'Bachillerato', 'C', 2),
('2° A', 'Segundo', 'Bachillerato', 'A', 2),
('2° B', 'Segundo', 'Bachillerato', 'B', 2),
('2° C', 'Segundo', 'Bachillerato', 'C', 2),
('3° A', 'Tercero', 'Bachillerato', 'A', 2),
('3° B', 'Tercero', 'Bachillerato', 'B', 2),
('3° C', 'Tercero', 'Bachillerato', 'C', 2),

-- Colegio Don Bosco (instituciones_id = 3)
('1° A', 'Primero', 'Bachillerato', 'A', 3),
('1° B', 'Primero', 'Bachillerato', 'B', 3),
('1° C', 'Primero', 'Bachillerato', 'C', 3),
('2° A', 'Segundo', 'Bachillerato', 'A', 3),
('2° B', 'Segundo', 'Bachillerato', 'B', 3),
('2° C', 'Segundo', 'Bachillerato', 'C', 3),
('3° A', 'Tercero', 'Bachillerato', 'A', 3),
('3° B', 'Tercero', 'Bachillerato', 'B', 3),
('3° C', 'Tercero', 'Bachillerato', 'C', 3);

-- Estudiantes
INSERT INTO estudiantes (codigo, usuarios_id, aulas_id, nombre, apellido, edad, telefono_emergencia) VALUES
-- 1° A (aulas_id = 1)
('2025001', 3, 1, 'María', 'García', 15, '7777-1111'),
('2025002', 3, 1, 'José', 'López', 15, '7777-1112'),
('2025003', 3, 1, 'Ana', 'Martínez', 15, '7777-1113'),
('2025004', 3, 1, 'Luis', 'Rodríguez', 15, '7777-1114'),
('2025005', 3, 1, 'Laura', 'Sánchez', 15, '7777-1115'),
-- 1° B (aulas_id = 2)
('2025006', 3, 2, 'Carlos', 'Pérez', 15, '7777-1121'),
('2025007', 3, 2, 'Elena', 'Gómez', 15, '7777-1122'),
('2025008', 3, 2, 'Miguel', 'Fernández', 15, '7777-1123'),
-- 1° C (aulas_id = 3)
('2025009', 3, 3, 'Sofía', 'Díaz', 15, '7777-1131'),
('2025010', 3, 3, 'Diego', 'Ramírez', 15, '7777-1132'),
-- 2° A (aulas_id = 7)
('2025011', 3, 7, 'Andrea', 'Torres', 16, '7777-2211'),
('2025012', 3, 7, 'Javier', 'Flores', 16, '7777-2212'),
('2025013', 3, 7, 'Valentina', 'Ramos', 16, '7777-2213'),
('2025014', 3, 7, 'Fernando', 'Ortiz', 16, '7777-2214'),
-- 2° B (aulas_id = 8)
('2025015', 3, 8, 'Daniela', 'Castro', 16, '7777-2221'),
('2025016', 3, 8, 'Andrés', 'Morales', 16, '7777-2222'),
-- 3° A (aulas_id = 13)
('2025017', 3, 13, 'Paula', 'Mendoza', 17, '7777-3311'),
('2025018', 3, 13, 'Ricardo', 'Herrera', 17, '7777-3312'),
('2025019', 3, 13, 'Camila', 'Vargas', 17, '7777-3313'),
-- 3° B (aulas_id = 14)
('2025020', 3, 14, 'Pablo', 'Jiménez', 17, '7777-3321'),
('2025021', 3, 14, 'Valeria', 'Molina', 17, '7777-3322');

-- Sismos
INSERT INTO sismos (magnitud, lugar, fecha, latitud, longitud) VALUES
(4.2, 'San Miguel', '2025-01-15 08:30:00', 13.4833, -88.1833),
(3.8, 'Santa Ana', '2025-01-12 14:20:00', 13.9942, -89.5597),
(5.1, 'La Libertad', '2025-01-10 22:15:00', 13.4890, -89.3220),
(2.5, 'San Salvador', '2025-01-08 06:45:00', 13.6900, -89.1900),
(4.5, 'Usulután', '2025-01-05 11:30:00', 13.3494, -88.4563),
(3.2, 'Sonsonate', '2025-01-03 19:10:00', 13.7189, -89.7242),
(6.0, 'Ahuachapán', '2024-12-28 03:00:00', 13.9214, -89.8450),
(4.8, 'San Vicente', '2024-12-20 16:30:00', 13.6433, -88.7897);

-- Rutas evacuación
INSERT INTO rutas_evacuacion (nombre, descripcion, instituciones_id) VALUES
('Ruta 1 - Salida Principal', 'Por la puerta principal hacia el parque central', 1),
('Ruta 2 - Salida Lateral', 'Por el pasillo norte hacia la cancha', 1),
('Ruta 3 - Salida de Emergencia', 'Por las gradas hacia el patio trasero', 1),
('Ruta Principal', 'Desde el edificio A hacia el campo de futbol', 2),
('Ruta Secundaria', 'Desde el edificio B hacia la plaza', 2),
('Ruta de Evacuación Norte', 'Salida por la puerta norte del colegio', 3);

-- Zonas seguras
INSERT INTO zonas_seguras (nombre, ubicacion, instituciones_id) VALUES
('Zona 1 - Parque Central', 'Frente al colegio, en el parque', 1),
('Zona 2 - Cancha de Futbol', 'Detrás del colegio', 1),
('Zona 3 - Patio Trasero', 'Zona amplia sin construcciones', 1),
('Zona Segura A', 'Campo de futbol', 2),
('Zona Segura B', 'Plaza principal', 2),
('Zona de Encuentro Norte', 'Área verde al norte', 3);

-- Simulacros
INSERT INTO simulacros (nombre, fecha, hora, instituciones_id) VALUES
('Simulacro 1 - Primer Trimestre', '2025-02-15', '09:00:00', 1),
('Simulacro 2 - Segundo Trimestre', '2025-05-20', '10:30:00', 1),
('Simulacro 3 - Tercer Trimestre', '2025-08-25', '08:45:00', 1),
('Simulacro Anual', '2025-10-10', '09:00:00', 2),
('Simulacro de Evacuación', '2025-11-15', '10:00:00', 3);

-- Asistencia
INSERT INTO asistencia_simulacros (simulacros_id, estudiantes_id, estado) VALUES
-- Simulacro 1 (simulacros_id = 1)
(1, 1, 'presente'),
(1, 2, 'presente'),
(1, 3, 'presente'),
(1, 4, 'ausente'),
(1, 5, 'presente'),
(1, 6, 'presente'),
(1, 7, 'herido'),
(1, 8, 'presente'),
-- Simulacro 2 (simulacros_id = 2)
(2, 1, 'presente'),
(2, 2, 'presente'),
(2, 3, 'ausente'),
(2, 4, 'presente'),
(2, 5, 'presente'),
(2, 6, 'presente'),
-- Simulacro 3 (simulacros_id = 3)
(3, 1, 'presente'),
(3, 2, 'presente'),
(3, 3, 'presente'),
(3, 4, 'presente'),
(3, 5, 'presente'),
(3, 6, 'presente'),
(3, 7, 'presente'),
(3, 8, 'presente');

-- Items mochila
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

-- Mochila usuarios
INSERT INTO mochila_usuario (usuarios_id, items_mochila_id, cantidad) VALUES
(1, 1, 1), (1, 2, 2), (1, 5, 1), (2, 1, 1), (2, 2, 1), 
(2, 4, 2), (3, 1, 1), (3, 6, 1),  (3, 7, 1); 
 
-- Puntaje Juegos
INSERT INTO puntajes_juegos (usuarios_id, juego_nombre, puntaje) VALUES
(1, 'Trivia Sismos', 85),
(1, 'Simulador Evacuación', 92),
(2, 'Trivia Sismos', 70),
(2, 'Simulador Evacuación', 65),
(3, 'Trivia Sismos', 95),
(3, 'Simulador Evacuación', 88),
(4, 'Trivia Sismos', 60),
(5, 'Simulador Evacuación', 75);

-- Blog
INSERT INTO blog (titulo, contenido, autor_id, imagen) VALUES
('¿Qué hacer antes de un sismo?', 
 'Preparar una mochila de emergencia es fundamental. También debemos conocer las rutas de evacuación y zonas seguras de nuestra institución. Es importante realizar simulacros periódicamente para estar preparados.', 
 1, 'sismo_prevencion.png'),
('Historia de los sismos en El Salvador', 
 'El Salvador ha sido escenario de importantes sismos a lo largo de su historia. El terremoto de 1986, el de 2001 y el más reciente en 2020 son eventos que marcaron al país. Conocer nuestra historia nos ayuda a estar mejor preparados.', 
 1, 'historia_sismos.png'),
('La ciencia detrás de los sismos', 
 'Los sismos son causados por el movimiento de las placas tectónicas. El Salvador se encuentra en una zona de alta actividad sísmica debido a la interacción de la Placa de Cocos y la Placa del Caribe.', 
 2, 'ciencia_sismos.png'),
('Cómo armar tu mochila de emergencia', 
 'La mochila de emergencia debe contener: agua, comida no perecedera, botiquín, linterna, silbato, documentos importantes, radio y cobija. Revisa tu mochila cada 6 meses.', 
 1, 'mochila.png'),
('Importancia de los simulacros', 
 'Los simulacros nos preparan para actuar de manera rápida y segura durante un sismo. Cada simulacro nos enseña a identificar errores y mejorar nuestros protocolos de evacuación.', 
 3, 'simulacro.png'),
('Tsunamis: ¿Qué son y cómo afectan a El Salvador?', 
 'Los tsunamis son olas gigantes causadas por sismos bajo el mar. La costa salvadoreña es vulnerable, por eso es importante conocer las rutas de evacuación hacia zonas altas.', 
 2, 'tsunami.png');


