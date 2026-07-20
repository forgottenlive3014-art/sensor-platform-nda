-- Agrega un nombre de usuario corto y unico, independiente del nombre
-- completo (que puede ser largo y romper el layout del navbar).
-- Nullable porque las cuentas existentes no tienen uno todavia; la app
-- usa el primer nombre como respaldo mientras el usuario no configure uno.
ALTER TABLE usuarios
  ADD COLUMN username VARCHAR(20) NULL UNIQUE AFTER nombre;
