-- ============================================================
-- MIGRACIÓN COMPLETA — para bases de datos que ya existían
-- ANTES de los roles institucionales / gestión escolar / sensor.
--
-- ¿Cuál script correr?
--   - Instalación NUEVA (base de datos vacía): usa nda_project.sql
--     y NO uses este archivo, ya está todo incluido ahí.
--   - Base de datos YA EXISTENTE con datos que quieres conservar:
--     corre este archivo UNA sola vez, completo, de arriba a abajo.
-- ============================================================

-- ============================================================
-- MIGRACION: Roles institucionales + solicitudes de ingreso
-- Ejecutar solo si tu base de datos ya existia ANTES de este
-- cambio (si es una instalacion nueva, usa nda_project.sql).
-- ============================================================

ALTER TABLE usuarios
  MODIFY role ENUM('user','admin','director','docente','alumno','padre','administrativo') DEFAULT 'user';

ALTER TABLE usuarios
  ADD COLUMN institucion_id INT NULL AFTER role,
  ADD COLUMN estado_institucional ENUM('ninguno','pendiente','aprobado','rechazado') DEFAULT 'ninguno' AFTER institucion_id,
  ADD COLUMN telefono VARCHAR(20) NULL AFTER estado_institucional;

ALTER TABLE usuarios
  ADD CONSTRAINT fk_usuarios_institucion
  FOREIGN KEY (institucion_id) REFERENCES instituciones(instituciones_id) ON DELETE SET NULL;

ALTER TABLE instituciones
  ADD COLUMN direccion VARCHAR(255) NULL,
  ADD COLUMN director_id INT NULL;

CREATE TABLE IF NOT EXISTS solicitudes_institucion (
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

-- ============================================================
-- MIGRACION: Gestion Escolar avanzada
-- Croquis interactivo, tablero tipo corcho, registro de danos
-- con imagenes, alerta de simulacro en vivo.
-- Ejecutar despues de migration_roles.sql
-- ============================================================

-- Incidentes / reportes de daños (con imagen opcional)
CREATE TABLE IF NOT EXISTS incidentes (
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

-- Croquis interactivo por institucion (imagen de fondo del plano)
CREATE TABLE IF NOT EXISTS croquis_institucion (
croquis_institucion_id INT PRIMARY KEY AUTO_INCREMENT,
instituciones_id INT UNIQUE,
imagen VARCHAR(255) NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
FOREIGN KEY (instituciones_id) REFERENCES instituciones(instituciones_id) ON DELETE CASCADE
);

-- Puntos marcados sobre el croquis: puntos de encuentro, zonas seguras,
-- extintores, botiquines, etc. x/y en porcentaje (0-100) sobre la imagen.
CREATE TABLE IF NOT EXISTS puntos_croquis (
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

-- Tablero tipo corcho: notas / post-its de la comunidad institucional
CREATE TABLE IF NOT EXISTS corcho_notas (
corcho_notas_id INT PRIMARY KEY AUTO_INCREMENT,
instituciones_id INT,
usuarios_id INT,
texto VARCHAR(280) NOT NULL,
color VARCHAR(20) DEFAULT 'amarillo',
pos_x DECIMAL(5,2) DEFAULT 10,
pos_y DECIMAL(5,2) DEFAULT 10,
rotacion DECIMAL(4,1) DEFAULT 0,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (instituciones_id) REFERENCES instituciones(instituciones_id) ON DELETE CASCADE,
FOREIGN KEY (usuarios_id) REFERENCES usuarios(usuarios_id) ON DELETE CASCADE
);

-- Simulacros: agregamos estado en vivo, descripcion y tipo (esta ultima
-- faltaba en esta migracion — DrillController::create()/update() ya la
-- esperaba, causando "Unknown column 'tipo'" en cualquier BD que solo
-- hubiera corrido esta migracion incremental en vez de nda_project.sql).
-- NOTA: MySQL real (no MariaDB) no soporta "ADD COLUMN IF NOT EXISTS";
-- si estas columnas ya existen, borra/comenta este ALTER.
ALTER TABLE simulacros
  ADD COLUMN estado ENUM('programado','activo','finalizado') DEFAULT 'programado',
  ADD COLUMN descripcion VARCHAR(255) NULL,
  ADD COLUMN tipo VARCHAR(50) DEFAULT 'Sísmico',
  ADD COLUMN activado_at TIMESTAMP NULL;

-- ============================================================
-- MIGRACION: Lecturas del sensor de vibracion (Arduino/Processing)
-- Ejecutar despues de migration_school_gestion.sql
-- ============================================================

CREATE TABLE IF NOT EXISTS lecturas_sensor (
lecturas_sensor_id INT PRIMARY KEY AUTO_INCREMENT,
intensidad DECIMAL(5,2) NOT NULL,
nivel ENUM('normal','precaucion','alerta') DEFAULT 'normal',
eje_x DECIMAL(6,3) NULL,
eje_y DECIMAL(6,3) NULL,
eje_z DECIMAL(6,3) NULL,
fuente VARCHAR(40) DEFAULT 'arduino-processing',
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================================
-- MIGRACION: corrige rutas_evacuacion (le faltaba la columna
-- "estado" que el codigo PHP ya esperaba, causando un error SQL
-- fatal cada vez que se agregaba una ruta de evacuación).
-- ============================================================

ALTER TABLE rutas_evacuacion
  ADD COLUMN estado VARCHAR(20) DEFAULT 'despejada';

-- Sin esto, guardar el pase de lista dos veces para el mismo estudiante
-- en el mismo simulacro creaba filas duplicadas en vez de actualizar.
-- NOTA: si esta migracion falla por datos duplicados ya existentes,
-- primero borra los duplicados de asistencia_simulacros manualmente
-- (deja solo la fila mas reciente por cada par simulacros_id+estudiantes_id).
ALTER TABLE asistencia_simulacros
  ADD UNIQUE KEY uniq_simulacro_estudiante (simulacros_id, estudiantes_id);

-- El pase de lista (school.js) siempre guardó el estado de un alumno lesionado
-- como 'herido', pero el ENUM original solo aceptaba 'lesionado' — MySQL
-- descarta en silencio cualquier valor de ENUM no reconocido (queda como
-- cadena vacía), así que cada alumno marcado como herido durante un
-- simulacro se guardaba con estado vacío en vez de 'herido'.
ALTER TABLE asistencia_simulacros
  MODIFY estado ENUM('presente', 'ausente', 'herido') DEFAULT 'presente';
UPDATE asistencia_simulacros SET estado = 'herido' WHERE estado = 'lesionado';
