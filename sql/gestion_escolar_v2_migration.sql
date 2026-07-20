-- Ampliación de Gestión Escolar v2: código institucional, comité de
-- noticias, moderación de noticias, ubicación exacta de incidentes en el
-- croquis y zonas de riesgo. Ver plan completo en el historial del proyecto.

ALTER TABLE usuarios
  ADD COLUMN codigo_institucional VARCHAR(12) NULL UNIQUE AFTER username,
  ADD COLUMN comite_autorizado TINYINT(1) NOT NULL DEFAULT 0 AFTER role;

ALTER TABLE noticias_internas
  ADD COLUMN estado ENUM('pendiente','publicada','rechazada') NOT NULL DEFAULT 'publicada' AFTER contenido,
  ADD COLUMN revisado_por INT NULL AFTER estado;

ALTER TABLE incidentes
  ADD COLUMN pos_x DECIMAL(5,2) NULL AFTER ubicacion,
  ADD COLUMN pos_y DECIMAL(5,2) NULL AFTER pos_x;

ALTER TABLE puntos_croquis
  MODIFY COLUMN tipo ENUM('encuentro','zona_segura','zona_riesgo','extintor','botiquin','salida','otro') DEFAULT 'otro';
