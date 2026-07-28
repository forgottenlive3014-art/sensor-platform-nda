-- Seed: mas noticias y reportes de riesgo para Colegio Don Bosco (instituciones_id = 2)
-- usuarios_id 8 = director "azucena", usuarios_id 32 = docente "Azucena Hernandez"
-- Ya se ejecuto directamente contra la base nda_project; este archivo queda
-- como referencia/documentacion y para poder re-sembrar en otro entorno.

INSERT INTO noticias_internas (instituciones_id, usuarios_id, titulo, resumen, contenido, imagen, estado) VALUES
(2, 8, 'Colegio Don Bosco renueva la señalización de rutas de evacuación',
 'Se instalaron nuevos rótulos y flechas de salida de emergencia en los tres pabellones del colegio, como parte del plan de gestión de riesgos institucional.',
 'Durante las últimas semanas, el Colegio Don Bosco trabajó junto al Comité de Protección Escolar en la actualización completa de la señalización de emergencia del campus.\n\nSe instalaron rótulos fotoluminiscentes de "Salida" y flechas direccionales en los pasillos de los tres pabellones, además de mapas de rutas de evacuación colocados en la entrada de cada aula, indicando el punto de encuentro asignado.\n\nEsta actualización responde a las recomendaciones del último simulacro institucional, en el que se identificaron tramos del corredor central donde la señalización anterior era poco visible.\n\nSe pide a estudiantes, docentes y personal administrativo revisar el mapa de su aula y familiarizarse con la ruta y el punto de encuentro que les corresponde.',
 'https://commons.wikimedia.org/wiki/Special:FilePath/Emergency_Exit_ISO_Pictogram_(green).svg', 'publicada'),

(2, 32, 'Taller de primeros auxilios para docentes y personal administrativo',
 'Personal capacitado guio al cuerpo docente en atención básica de heridas, maniobras de reanimación y manejo de emergencias dentro del aula.',
 'El personal docente y administrativo del Colegio Don Bosco participó en un taller práctico de primeros auxilios, enfocado en la atención inmediata durante los primeros minutos de una emergencia dentro del aula o en el campus.\n\nEntre los temas cubiertos estuvieron: control de hemorragias, atención de golpes y caídas, maniobra de Heimlich, y los pasos básicos de reanimación cardiopulmonar (RCP) mientras se espera la llegada de ayuda especializada.\n\nEl objetivo es que, ante un accidente durante clases, recreo o un simulacro, el personal cuente con herramientas claras para actuar con calma y seguridad mientras se activa el protocolo institucional.\n\nSe espera repetir esta capacitación cada semestre e incluir próximamente una sesión dirigida a estudiantes de bachillerato.',
 'https://commons.wikimedia.org/wiki/Special:FilePath/First_aid.png', 'publicada'),

(2, 8, 'Charla informativa sobre riesgo volcánico en El Salvador: el caso del volcán de Izalco',
 'Estudiantes de bachillerato conocieron cómo identificar señales de actividad volcánica y qué hacer ante una alerta de Protección Civil.',
 'Como parte del programa de educación en gestión de riesgos, estudiantes de bachillerato del Colegio Don Bosco recibieron una charla sobre el riesgo volcánico en El Salvador, con el volcán de Izalco como caso de estudio por su historial de actividad.\n\nDurante la sesión se explicaron los principales riesgos asociados a la actividad volcánica en el país (ceniza, gases y lahares), cómo se clasifican las alertas de Protección Civil, y las medidas básicas de autoprotección en caso de una alerta naranja o roja cerca de una zona volcánica.\n\nLa charla se enmarca dentro de los contenidos de Ciencias Naturales y busca complementar lo aprendido sobre placas tectónicas y actividad sísmica en la región.',
 'https://commons.wikimedia.org/wiki/Special:FilePath/Green_Izalco_Volcano.JPG', 'publicada'),

(2, 32, 'La biblioteca del colegio suma material sobre gestión de riesgos y prevención de desastres',
 'Nuevos libros y guías ilustradas sobre sismos, inundaciones y volcanes ya están disponibles para consulta de estudiantes de todos los grados.',
 'La biblioteca del Colegio Don Bosco amplió su colección con material educativo enfocado en la prevención y gestión de riesgos, disponible para todos los grados.\n\nEntre las novedades se incluyen guías ilustradas sobre qué hacer antes, durante y después de un sismo, material sobre la temporada lluviosa y el riesgo de inundaciones y deslizamientos, y publicaciones sobre la actividad volcánica en El Salvador.\n\nLos docentes de Ciencias Naturales y Estudios Sociales podrán usar este material como apoyo en sus clases, y los estudiantes pueden solicitarlo directamente en la biblioteca durante su horario habitual.',
 'https://commons.wikimedia.org/wiki/Special:FilePath/Student_reading_a_book_in_the_library.jpg', 'publicada'),

(2, 8, 'Inicia la temporada lluviosa: así se prepara el Colegio Don Bosco ante deslizamientos e inundaciones',
 'Con el inicio del invierno, la institución revisa canaletas, taludes y zonas de riesgo del campus para evitar accidentes durante las lluvias.',
 'Con el inicio de la temporada lluviosa, el Colegio Don Bosco realizó una revisión preventiva de las zonas del campus con mayor riesgo ante lluvias intensas: canaletas, bajantes de agua, taludes perimetrales y el patio trasero, donde históricamente se acumula agua durante tormentas fuertes.\n\nEl personal de mantenimiento limpió los drenajes y se reforzó la señalización en las áreas donde el piso suele resbalar cuando llueve. Además, se recordó a los estudiantes evitar quedarse bajo aleros o árboles grandes durante tormentas eléctricas.\n\nLa institución seguirá de cerca los boletines de MARN y Protección Civil durante los próximos meses, y usará la plataforma NDA para mantener informada a la comunidad educativa ante cualquier alerta relevante para la zona.',
 'https://commons.wikimedia.org/wiki/Special:FilePath/ElSalvadorslide.jpg', 'publicada');

INSERT INTO blog_riesgos (instituciones_id, usuarios_id, titulo, descripcion, ubicacion, imagen) VALUES
(2, 32, 'Grietas visibles en la pared del pasillo del segundo piso',
 'Se observan grietas diagonales en la pared del corredor que conecta las aulas de segundo piso del pabellón B. Aunque por ahora no comprometen el paso, conviene que mantenimiento las evalúe para descartar un problema estructural antes de que se agranden, especialmente de cara a la temporada de lluvias y la actividad sísmica de la zona.',
 'Pasillo de aulas, segundo piso, pabellón B',
 'https://commons.wikimedia.org/wiki/Special:FilePath/Kerewan_Cracked_Wall.JPG'),

(2, 32, 'Cableado eléctrico expuesto cerca del aula de cómputo',
 'En el corredor exterior junto al laboratorio de informática hay un tramo de cableado eléctrico sin canaleta, colgando a la altura de paso de los estudiantes. Representa un riesgo de tropiezo y de contacto eléctrico, sobre todo cuando el área se moja con la lluvia. Se recomienda entubar o reubicar el cableado lo antes posible.',
 'Corredor exterior, junto al laboratorio de informática',
 'https://commons.wikimedia.org/wiki/Special:FilePath/Chongqing_cable_chaos.jpg'),

(2, 8, 'Tejas rotas y filtraciones en el techo del auditorio',
 'Varias tejas del techo del auditorio están rotas o desplazadas, y durante las últimas lluvias se registraron filtraciones de agua sobre parte del escenario. Además del daño al piso y al equipo eléctrico cercano, existe riesgo de que alguna teja se desprenda. Se solicita revisión y reparación antes del próximo evento programado en ese espacio.',
 'Techo del auditorio principal',
 'https://commons.wikimedia.org/wiki/Special:FilePath/Broken_black_roof_tiles_1.jpg'),

(2, 32, 'Vidrio agrietado en ventana del laboratorio de ciencias',
 'Una de las ventanas del laboratorio de ciencias naturales presenta una grieta que atraviesa todo el vidrio, posiblemente por el impacto de un objeto desde el patio contiguo. Hay riesgo de que se desprendan fragmentos, especialmente durante actividades con manipulación de materiales. Se recomienda colocar cinta de seguridad mientras se gestiona el cambio del vidrio.',
 'Laboratorio de ciencias naturales, primer piso',
 'https://commons.wikimedia.org/wiki/Special:FilePath/Broken_glass.jpg');
