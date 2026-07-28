-- Seed: incidentes para Colegio Don Bosco (instituciones_id = 2)
-- Ya se ejecuto directamente contra la base nda_project; este archivo queda
-- como referencia/documentacion y para poder re-sembrar en otro entorno.
-- usuarios_id 8 = director, 32 = docente, 6 = administrativo.

INSERT INTO incidentes (tipo, descripcion, ubicacion, imagen, usuario_id, instituciones_id, prioridad, estado, resuelto_at) VALUES
('Ruta bloqueada', 'La salida trasera del auditorio está bloqueada mientras se repara el techo (tejas rotas y filtraciones ya reportadas). Se está usando la Ruta C como alterna para esa zona.', 'Salida trasera del auditorio', 'https://commons.wikimedia.org/wiki/Special:FilePath/Broken_black_roof_tiles_1.jpg', 8, 2, 'alta', 'abierto', NULL),
('Objeto caído', 'Una rama grande cayó sobre el corredor techado hacia la cancha tras la lluvia de anoche, obstruyendo parcialmente el paso. Ya fue retirada por el personal de mantenimiento.', 'Corredor techado hacia la cancha', 'https://commons.wikimedia.org/wiki/Special:FilePath/Fallen_tree_on_Sowerby_Bridge_Footpath_134,_Norland_-_geograph.org.uk_-_2942028.jpg', 32, 2, 'media', 'resuelto', NOW()),
('Alumno lesionado', 'Un estudiante sufrió una torcedura de tobillo durante la clase de educación física. Fue atendido en la enfermería del colegio y se notificó a sus padres.', 'Cancha techada', NULL, 32, 2, 'media', 'resuelto', NOW()),
('Espacio dañado', 'La puerta del salón de usos múltiples tiene una bisagra suelta y cuesta cerrarla por completo. No representa un riesgo inmediato, pero conviene ajustarla antes de que empeore.', 'Salón de usos múltiples', 'https://commons.wikimedia.org/wiki/Special:FilePath/Broken_door.png', 6, 2, 'baja', 'abierto', NULL);
