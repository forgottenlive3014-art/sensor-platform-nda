-- Seed: rutas de evacuacion y simulacros para Colegio Don Bosco (instituciones_id = 2)
-- Ya se ejecuto directamente contra la base nda_project; este archivo queda
-- como referencia/documentacion y para poder re-sembrar en otro entorno.

INSERT INTO rutas_evacuacion (nombre, descripcion, instituciones_id, estado) VALUES
('Ruta A — Pabellón A hacia cancha techada', 'Sale del pasillo principal del pabellón A directo a la cancha techada, designada como punto de encuentro principal.', 2, 'despejada'),
('Ruta B — Pabellón B hacia patio central', 'Desciende por la escalera del pabellón B y desemboca en el patio central, punto de encuentro secundario.', 2, 'despejada'),
('Ruta C — Biblioteca y laboratorios hacia portón principal', 'Cubre biblioteca y laboratorios de ciencias/informática, saliendo directo por el portón principal hacia la calle.', 2, 'despejada'),
('Ruta D — Auditorio hacia parqueo trasero', 'Ruta temporalmente bloqueada: mientras se repara el techo del auditorio (tejas rotas y filtraciones reportadas), usar la Ruta C como alterna para esa zona.', 2, 'bloqueada');

INSERT INTO simulacros (nombre, fecha, hora, instituciones_id, tipo, descripcion, estado) VALUES
('Simulacro sísmico de mitad de año', '2026-06-18', '09:30:00', 2, 'Sísmico', 'Evacuación general del campus tras alerta sísmica simulada. Tiempo de evacuación total: 3 minutos 40 segundos, dentro de la meta institucional de 4 minutos.', 'finalizado'),
('Simulacro de incendio — cocina y comedor', '2026-05-05', '10:15:00', 2, 'Incendio', 'Simulacro enfocado en el área de cocina y comedor, con activación de la ruta B como salida principal para esa zona.', 'finalizado'),
('Simulacro sísmico — aulas de parvularia', '2026-03-20', '08:45:00', 2, 'Sísmico', 'Ejercicio adaptado para los grados más pequeños, con apoyo de docentes y personal administrativo para guiar la evacuación.', 'finalizado'),
('Simulacro sísmico — segundo semestre', '2026-09-15', '09:00:00', 2, 'Sísmico', 'Próximo simulacro institucional, con enfoque en la nueva señalización de rutas de evacuación instalada recientemente.', 'programado');
