-- Registro público de instituciones con verificación por correo: tipo de
-- institución, datos del director, y estado/código de verificación.
-- estado_verificacion nace 'verificado' por defecto para no afectar
-- instituciones ya existentes (creadas manualmente por el Admin General) —
-- solo las nuevas registradas por el flujo público nacen 'pendiente'.

ALTER TABLE instituciones
  ADD COLUMN tipo ENUM('colegio','escuela','instituto','universidad','otro') NOT NULL DEFAULT 'colegio' AFTER nombre,
  ADD COLUMN nombre_director VARCHAR(120) NULL AFTER director_id,
  ADD COLUMN correo_director_personal VARCHAR(100) NULL AFTER correo,
  ADD COLUMN estado_verificacion ENUM('pendiente','verificado') NOT NULL DEFAULT 'verificado' AFTER correo_director_personal,
  ADD COLUMN codigo_verificacion VARCHAR(6) NULL AFTER estado_verificacion,
  ADD COLUMN codigo_verificacion_expira DATETIME NULL AFTER codigo_verificacion;
