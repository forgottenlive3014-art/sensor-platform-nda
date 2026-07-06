-- ============================================================
-- Migración: CRUD real del módulo de Gestión Escolar
-- ============================================================
-- Ejecutar sobre una base ya creada con sql/nda_project.sql
-- (+ sql/migracion_completa.sql si la BD es anterior a esa fecha).

-- ------------------------------------------------------------
-- ROLES: usuarios.role YA soporta los 7 roles pedidos
--   admin          = Admin General
--   director       = Admin Institucional
--   docente        = Docente
--   alumno         = Estudiante
--   padre          = Padre
--   administrativo = Personal
--   user           = Usuario registrado (sin acceso escolar)
-- "Visitante" no es un rol de BD: es cualquier request sin sesión.
-- No se agrega ningún valor nuevo al ENUM porque ya están todos.
-- ------------------------------------------------------------

-- ------------------------------------------------------------
-- Relación Padre <-> Estudiante (no existía: un padre no tenía
-- forma de saber cuáles son "sus hijos" en la base de datos).
-- Un estudiante puede tener más de un padre/encargado vinculado,
-- y un padre puede tener más de un hijo en la institución.
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS padres_estudiantes (
    padres_estudiantes_id INT PRIMARY KEY AUTO_INCREMENT,
    padre_usuario_id INT NOT NULL,
    estudiante_id INT NOT NULL,
    parentesco VARCHAR(30) DEFAULT 'padre/madre',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_padre_estudiante (padre_usuario_id, estudiante_id),
    FOREIGN KEY (padre_usuario_id) REFERENCES usuarios(usuarios_id) ON DELETE CASCADE,
    FOREIGN KEY (estudiante_id) REFERENCES estudiantes(estudiantes_id) ON DELETE CASCADE
);

-- ------------------------------------------------------------
-- Noticias internas (módulo nuevo: comunicados del director/admin
-- hacia la comunidad de su institución, o globales si los publica
-- el Admin General).
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS noticias_internas (
    noticias_internas_id INT PRIMARY KEY AUTO_INCREMENT,
    instituciones_id INT NULL,
    usuarios_id INT NOT NULL,
    titulo VARCHAR(150) NOT NULL,
    contenido TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (instituciones_id) REFERENCES instituciones(instituciones_id) ON DELETE CASCADE,
    FOREIGN KEY (usuarios_id) REFERENCES usuarios(usuarios_id) ON DELETE CASCADE
);

-- ------------------------------------------------------------
-- Materia que imparte un docente (antes no se guardaba en ningún
-- lado: SchoolController::addTeacher() recibía "materia" del form
-- y la descartaba). Columna nullable, solo aplica a role='docente'.
--
-- NOTA: MySQL real (a diferencia de MariaDB) NO soporta
-- "ADD COLUMN IF NOT EXISTS". Si esta migración ya se corrió antes,
-- comenta/borra estas dos líneas para evitar el error de columna
-- duplicada; si no, déjalas como ALTER TABLE normal.
-- ------------------------------------------------------------
ALTER TABLE usuarios ADD COLUMN materia VARCHAR(100) NULL AFTER telefono;

-- ------------------------------------------------------------
-- Foto de perfil para incidencias reportadas por docentes/estudiantes
-- (ya existía "imagen" en incidentes; esta es la foto de perfil del
-- propio usuario, usada por Docente/Estudiante al "subir fotografías").
-- ------------------------------------------------------------
ALTER TABLE usuarios ADD COLUMN foto_perfil VARCHAR(255) NULL AFTER materia;

-- ------------------------------------------------------------
-- Audiencia del corcho: quien publica una nota elige quien la ve
-- ('todos', o una lista de roles separada por comas, ej.
-- 'docente,alumno'). Antes toda nota era visible para toda la
-- institucion sin excepcion.
-- ------------------------------------------------------------
ALTER TABLE corcho_notas ADD COLUMN visibilidad VARCHAR(150) DEFAULT 'todos';

-- ------------------------------------------------------------
-- Blog de lugares en riesgo: Docente/Alumno/Personal reportan un
-- lugar de riesgo con foto + descripcion, visible como feed
-- cronologico para toda la comunidad institucional.
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS blog_riesgos (
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
-- Coordenadas reales de la institucion (geocodificadas una sola vez
-- desde su direccion, via Nominatim/OSM en el navegador, o ajustadas
-- a mano por el director). Usadas por el mapa Cesium del croquis
-- para anclar el plano y los puntos existentes sobre el mundo real,
-- sin token de Cesium ion.
-- ------------------------------------------------------------
ALTER TABLE instituciones ADD COLUMN lat DECIMAL(10,7) NULL AFTER direccion;
ALTER TABLE instituciones ADD COLUMN lng DECIMAL(10,7) NULL AFTER lat;
