-- ------------------------------------------------------------
-- Mejoras al modulo de Gestion Escolar.
--
-- Nota: la base de datos local ya tenia columnas en `instituciones`
-- (tipo, estado_verificacion, codigo_verificacion, codigo_verificacion_expira,
-- nombre_director, correo_director_personal) y en `usuarios` (codigo_institucional)
-- que no estaban en ningun script versionado ni usadas por ningun controller
-- (quedaron de un trabajo anterior no confirmado). Este script las deja
-- documentadas para instalaciones nuevas y agrega solo lo que faltaba.
-- ------------------------------------------------------------

-- NOTA: para una instalacion nueva, corre este bloque tal cual. Si tu base
-- de datos ya tiene alguna de estas columnas (por ejemplo por una prueba
-- manual previa), quita esa linea antes de ejecutar o ejecuta cada
-- ALTER TABLE por separado, ignorando el error "Duplicate column name" de
-- las que ya existan.
ALTER TABLE instituciones
    ADD COLUMN tipo ENUM('colegio','escuela','instituto','universidad','otro') NOT NULL DEFAULT 'colegio' AFTER nombre,
    ADD COLUMN correo_director_personal VARCHAR(100) NULL AFTER correo,
    ADD COLUMN estado_verificacion ENUM('pendiente','verificado') NOT NULL DEFAULT 'verificado' AFTER correo_director_personal,
    ADD COLUMN codigo_verificacion VARCHAR(6) NULL AFTER estado_verificacion,
    ADD COLUMN codigo_verificacion_expira DATETIME NULL AFTER codigo_verificacion,
    ADD COLUMN nombre_director VARCHAR(120) NULL AFTER director_id;

ALTER TABLE usuarios
    ADD COLUMN codigo_institucional VARCHAR(12) NULL UNIQUE AFTER role;

-- Coordenadas opcionales por ruta de evacuacion / zona segura, para
-- ubicarlas en el mapa Leaflet del tab "Rutas". Nulas por defecto: una
-- ruta sin coordenadas sigue funcionando igual que hoy, solo no aparece
-- en el mapa.
ALTER TABLE rutas_evacuacion
    ADD COLUMN lat DECIMAL(10,7) NULL,
    ADD COLUMN lng DECIMAL(10,7) NULL;
