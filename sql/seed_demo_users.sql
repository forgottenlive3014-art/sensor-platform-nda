-- ============================================================
-- SEED: Cuentas de demostración para probar los roles institucionales
-- (director, docente, alumno, padre, administrativo) y ver el módulo de
-- Gestión Escolar funcionando de inmediato, con datos ya cargados en vez
-- de una institución vacía.
--
-- No incluye una cuenta 'admin': ese rol es único y no se crea por
-- registro ni por seed de prueba, solo a mano (ver nda_project.sql).
--
-- Ejecutar DESPUÉS de nda_project.sql (o de las 3 migraciones,
-- si ya tenías una base de datos previa).
--
-- Contraseña para TODAS las cuentas de este seed:  Demo2026!
-- ============================================================

INSERT INTO instituciones (nombre, correo, telefono, direccion) VALUES
('Instituto Nacional Demostración NDA', 'contacto@demo-nda.edu.sv', '2200-0000', 'San Salvador, El Salvador');
SET @inst_id = LAST_INSERT_ID();

-- 18 secciones de bachillerato (6 por año, A-F)
INSERT INTO aulas (nombre, grado, nivel, seccion, instituciones_id) VALUES
('1° Año A', '1° Año', 'Bachillerato', 'A', @inst_id),
('1° Año B', '1° Año', 'Bachillerato', 'B', @inst_id),
('1° Año C', '1° Año', 'Bachillerato', 'C', @inst_id),
('1° Año D', '1° Año', 'Bachillerato', 'D', @inst_id),
('1° Año E', '1° Año', 'Bachillerato', 'E', @inst_id),
('1° Año F', '1° Año', 'Bachillerato', 'F', @inst_id),
('2° Año A', '2° Año', 'Bachillerato', 'A', @inst_id),
('2° Año B', '2° Año', 'Bachillerato', 'B', @inst_id),
('2° Año C', '2° Año', 'Bachillerato', 'C', @inst_id),
('2° Año D', '2° Año', 'Bachillerato', 'D', @inst_id),
('2° Año E', '2° Año', 'Bachillerato', 'E', @inst_id),
('2° Año F', '2° Año', 'Bachillerato', 'F', @inst_id),
('3° Año A', '3° Año', 'Bachillerato', 'A', @inst_id),
('3° Año B', '3° Año', 'Bachillerato', 'B', @inst_id),
('3° Año C', '3° Año', 'Bachillerato', 'C', @inst_id),
('3° Año D', '3° Año', 'Bachillerato', 'D', @inst_id),
('3° Año E', '3° Año', 'Bachillerato', 'E', @inst_id),
('3° Año F', '3° Año', 'Bachillerato', 'F', @inst_id);

-- Usuarios de prueba — TODOS con la contraseña: Demo2026!
INSERT INTO usuarios (nombre, email, contra, role, institucion_id, estado_institucional) VALUES
('Directora Demo',         'director.demo@nda.com',       SHA2('Demo2026!', 256), 'director',       @inst_id,  'aprobado'),
('Docente Demo',           'docente.demo@nda.com',        SHA2('Demo2026!', 256), 'docente',        @inst_id,  'aprobado'),
('Alumno Demo',            'alumno.demo@nda.com',         SHA2('Demo2026!', 256), 'alumno',         @inst_id,  'aprobado'),
('Padre Demo',             'padre.demo@nda.com',          SHA2('Demo2026!', 256), 'padre',          @inst_id,  'aprobado'),
('Administrativo Demo',    'administrativo.demo@nda.com', SHA2('Demo2026!', 256), 'administrativo', @inst_id,  'aprobado'),
('Usuario General Demo',   'usuario.demo@nda.com',        SHA2('Demo2026!', 256), 'user',           NULL,      'ninguno'),
('Docente Pendiente Demo', 'pendiente.demo@nda.com',      SHA2('Demo2026!', 256), 'docente',        @inst_id,  'pendiente');

-- La institución queda administrada por la directora demo
UPDATE instituciones SET director_id = (SELECT usuarios_id FROM usuarios WHERE email = 'director.demo@nda.com')
WHERE instituciones_id = @inst_id;

-- El docente demo queda a cargo de 1° Año A
UPDATE aulas SET maestro_id = (SELECT usuarios_id FROM usuarios WHERE email = 'docente.demo@nda.com')
WHERE instituciones_id = @inst_id AND nombre = '1° Año A';

-- El alumno demo queda matriculado en 1° Año A
INSERT INTO estudiantes (codigo, usuarios_id, aulas_id, nombre, apellido, telefono_emergencia)
SELECT 'EST-DEMO01', u.usuarios_id, a.aulas_id, 'Alumno', 'Demo', '7000-0000'
FROM usuarios u, aulas a
WHERE u.email = 'alumno.demo@nda.com' AND a.instituciones_id = @inst_id AND a.nombre = '1° Año A';

-- La solicitud pendiente del "Docente Pendiente Demo" — para que la
-- directora demo tenga algo que aprobar en la pestaña "Solicitudes".
INSERT INTO solicitudes_institucion (usuarios_id, instituciones_id, rol_solicitado, mensaje)
SELECT usuarios_id, @inst_id, 'docente', 'Hola, soy docente de nuevo ingreso y quisiera unirme al módulo escolar.'
FROM usuarios WHERE email = 'pendiente.demo@nda.com';

-- Un simulacro de ejemplo (para probar el pase de lista y la alerta en vivo)
INSERT INTO simulacros (nombre, fecha, hora, instituciones_id, tipo, descripcion, estado)
VALUES ('Simulacro Sísmico Trimestral', CURDATE(), '09:00:00', @inst_id,
        'Sísmico', 'Simulacro de evacuación programado para todo el instituto.', 'programado');

-- Una ruta de evacuación de ejemplo
INSERT INTO rutas_evacuacion (nombre, descripcion, instituciones_id, estado)
VALUES ('Ruta Pabellón A → Cancha Central', 'Salida principal por el pasillo norte hacia la cancha.', @inst_id, 'despejada');

-- Una nota de bienvenida en el tablero de corcho
INSERT INTO corcho_notas (instituciones_id, usuarios_id, texto, color, pos_x, pos_y, rotacion)
SELECT @inst_id, usuarios_id, 'Bienvenidos al tablero de la comunidad. Aquí puedes dejar avisos para todos.', 'amarillo', 15, 20, -3
FROM usuarios WHERE email = 'director.demo@nda.com';
