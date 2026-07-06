<?php
/* Lista: ?url=blog · Artículo: ?url=blog&post=SLUG. Si falta la imagen en
   assets/media/blog/SLUG.jpg, se usa el color de respaldo del artículo. */

$title = $title ?? 'Blog - NDA';

// ============================================================
// ARTÍCULOS DE PREVENCIÓN
// ============================================================

$b_72 = <<<HTML
<p class="art-lead">Las primeras 72 horas tras un desastre son las más críticas: es el tiempo que puede pasar antes de que la ayuda externa llegue a tu zona. Prepararte para ese lapso no requiere dinero ni equipo especial, solo organización. Aquí tienes el plan completo.</p>
<h3 class="art-h3">¿Por qué 72 horas?</h3>
<p>Cuando ocurre un sismo fuerte o una inundación, los servicios de emergencia se saturan y las vías pueden quedar bloqueadas. Protección Civil y el COEN priorizan las zonas más afectadas, y tu colonia podría quedar sola durante uno a tres días. Tener lo básico para ese periodo convierte una crisis en una incomodidad manejable.</p>
<div class="art-key"><strong>La regla de oro</strong>Agua, comida, luz, información y documentos. Si tu hogar tiene cubiertos esos cinco frentes para tres días, ya estás por delante de la mayoría.</div>
<h3 class="art-h3">Agua y alimentos</h3>
<p>Calcula al menos 3 litros de agua por persona al día: uno para beber y dos para higiene y cocina. Para una familia de cuatro, eso son unos 36 litros para tres días. Guarda comida que no necesite refrigeración ni cocción: enlatados, granola, galletas, atún. Revisa las fechas cada seis meses.</p>
<h3 class="art-h3">Documentos y plan</h3>
<p>Reúne copias de DUI, partidas de nacimiento, escrituras y carnets médicos en una bolsa plástica sellada. Acuerda con tu familia un punto de reunión y un contacto fuera del país a quien todos puedan llamar si se separan. Escribe los números de emergencia en papel: en una crisis el celular puede quedarse sin batería.</p>
<h3 class="art-h3">Practica antes de necesitarlo</h3>
<p>Un plan que nunca se ensaya falla cuando más importa. Haz un simulacro en casa: corta la luz un momento, ubica la mochila a oscuras, repasa la ruta de salida. Diez minutos al mes bastan para que el cuerpo recuerde qué hacer sin pensar.</p>
<div class="art-takeaway"><h4>Para recordar</h4><ul><li>3 litros de agua por persona al día, para 3 días.</li><li>Comida sin cocción y con fecha vigente.</li><li>Documentos en bolsa sellada + números en papel.</li><li>Punto de reunión y contacto acordados.</li><li>Ensaya el plan una vez al mes.</li></ul></div>
HTML;

$b_agachate = <<<HTML
<p class="art-lead">Cuando la tierra se mueve, tu cuerpo quiere correr. Pero los datos de miles de sismos demuestran que la mayoría de las lesiones ocurren al intentar desplazarse durante el movimiento. El protocolo internacional se resume en tres palabras: <strong>agáchate, cúbrete y agárrate</strong>.</p>
<h3 class="art-h3">1. Agáchate</h3>
<p>Bájate al suelo antes de que el sismo te tire. Ponte sobre manos y rodillas: esa posición te protege de caídas y te permite moverte si hace falta. Estar abajo reduce la posibilidad de que objetos que vuelan te golpeen.</p>
<h3 class="art-h3">2. Cúbrete</h3>
<p>Protege la cabeza y el cuello, que son las zonas más vulnerables. Métete debajo de una mesa o escritorio resistente. Si no hay ninguno cerca, agáchate junto a un muro interior, lejos de ventanas, y cúbrete la nuca con los brazos.</p>
<h3 class="art-h3">3. Agárrate</h3>
<p>Sujeta la pata del mueble que te cubre y mantente con él si se desplaza. El movimiento puede durar segundos que se sienten eternos; aguanta hasta que todo se detenga por completo antes de levantarte.</p>
<div class="art-key"><strong>El mito de la puerta</strong>Durante años se dijo que el marco de la puerta era lo más seguro. En construcciones modernas no lo es: las puertas oscilan y no protegen de objetos que caen. Mejor una mesa firme.</div>
<h3 class="art-h3">Por qué no correr</h3>
<p>Tres segundos de reacción correcta valen más que correr hacia una salida. Las escaleras, los pasillos y las fachadas son justo donde caen vidrios, repisas y escombros. Quédate, protégete y muévete solo cuando el suelo deje de temblar.</p>
<div class="art-takeaway"><h4>Para recordar</h4><ul><li>Agáchate: al suelo, sobre manos y rodillas.</li><li>Cúbrete: cabeza y cuello, bajo mueble firme.</li><li>Agárrate: sujétate hasta que termine.</li><li>No corras ni uses el ascensor.</li></ul></div>
HTML;

$b_lluvias = <<<HTML
<p class="art-lead">En El Salvador la temporada de lluvias transforma quebradas tranquilas en corrientes mortales en minutos. La diferencia entre un susto y una tragedia suele estar en saber leer las señales a tiempo. Estas son las que nunca debes ignorar.</p>
<h3 class="art-h3">El suelo ya está saturado</h3>
<p>Tras varios días de lluvia, la tierra deja de absorber agua. A partir de ahí, cualquier aguacero corre por la superficie y multiplica el riesgo de inundación y deslizamiento. Si llovió toda la semana, trata la siguiente lluvia con más respeto.</p>
<h3 class="art-h3">Señales de deslizamiento</h3>
<p>Presta atención a grietas nuevas en el suelo o en las paredes, árboles o postes inclinados, agua que sale turbia o con barro, y ruidos sordos provenientes de la ladera. Cualquiera de estas señales significa moverse de inmediato a un lugar firme y alto.</p>
<div class="art-key"><strong>Regla del agua en movimiento</strong>Apenas 30 cm de agua corriente pueden arrastrar a una persona, y 60 cm a un vehículo. Nunca cruces una calle, puente o vado inundado, aunque parezca poco.</div>
<h3 class="art-h3">Las quebradas crecen sin avisar</h3>
<p>Una quebrada puede crecer aunque no esté lloviendo donde tú estás: basta con que llueva fuerte montaña arriba. Si vives cerca de una, no esperes a ver el agua subir; aléjate cuando el MARN emita alerta naranja o roja.</p>
<h3 class="art-h3">Manténte informado</h3>
<p>Ten una radio a pilas y sigue los comunicados oficiales del MARN y Protección Civil. La información correcta a tiempo es tu mejor herramienta: te dice cuándo quedarte y cuándo evacuar.</p>
<div class="art-takeaway"><h4>Para recordar</h4><ul><li>Suelo saturado = más riesgo en la siguiente lluvia.</li><li>Grietas, árboles inclinados y agua turbia: evacúa.</li><li>Nunca cruces agua en movimiento.</li><li>Sigue alertas del MARN por radio a pilas.</li></ul></div>
HTML;

$b_mochila = <<<HTML
<p class="art-lead">No necesitas gastar de más para tener una mochila de emergencia funcional. Estos son los diez objetos que cualquier hogar salvadoreño debería tener listos hoy, ordenados por prioridad.</p>
<h3 class="art-h3">Los esenciales</h3>
<ol class="art-steps">
<li><strong>Agua</strong> — 3 litros por persona al día. Es lo primero que falta y lo más difícil de improvisar.</li>
<li><strong>Comida no perecedera</strong> — enlatados, granola, atún. Sin cocción.</li>
<li><strong>Linterna</strong> — de mano o de cabeza, mejor que velas (riesgo de incendio).</li>
<li><strong>Radio a pilas</strong> — tu línea con el mundo cuando se va la señal.</li>
<li><strong>Pilas de repuesto</strong> — para linterna y radio.</li>
<li><strong>Botiquín</strong> — gasas, alcohol, vendas, analgésicos y tus medicinas habituales.</li>
<li><strong>Documentos</strong> — copias de DUI y partidas en bolsa sellada.</li>
<li><strong>Silbato</strong> — para pedir ayuda si quedas atrapado; gasta menos energía que gritar.</li>
<li><strong>Abrigo y muda</strong> — ropa seca y una manta ligera.</li>
<li><strong>Efectivo</strong> — en billetes pequeños; los cajeros y datáfonos pueden no funcionar.</li>
</ol>
<div class="art-key"><strong>Dónde guardarla</strong>Cerca de la salida principal, en un lugar que todos conozcan y puedan alcanzar a oscuras. De nada sirve una mochila perfecta si nadie sabe dónde está.</div>
<h3 class="art-h3">Revísala dos veces al año</h3>
<p>Marca en tu calendario dos fechas fijas (por ejemplo, el cambio de hora o el inicio de la temporada de lluvias) para revisar fechas de vencimiento, cambiar el agua y probar la linterna.</p>
<div class="art-takeaway"><h4>Para recordar</h4><ul><li>Agua y comida sin cocción primero.</li><li>Luz e información: linterna, radio y pilas.</li><li>Botiquín, documentos, silbato y efectivo.</li><li>Guárdala accesible y revísala 2 veces al año.</li></ul></div>
HTML;

$b_vecinos = <<<HTML
<p class="art-lead">En los primeros minutos de una emergencia, quien te rescata no es la ambulancia: son tus vecinos. Una colonia organizada salva más vidas que cualquier equipo que llegue después. Así puedes montar un plan comunitario en un fin de semana.</p>
<h3 class="art-h3">Empieza por conocerse</h3>
<p>El primer paso no es técnico, es humano. Reúne a las familias de tu cuadra y hagan una lista: quién vive solo, quién tiene movilidad reducida, quién es enfermero o sabe primeros auxilios, quién tiene herramientas. Esa lista es la base de todo.</p>
<h3 class="art-h3">Asignen roles claros</h3>
<p>En una crisis, la confusión cuesta vidas. Definan con anticipación quién avisa a Protección Civil, quién revisa a los vecinos vulnerables, quién corta el gas o la electricidad de la zona, y quién guía hacia el punto de reunión. Cuando cada quien sabe su tarea, la respuesta es inmediata.</p>
<div class="art-key"><strong>El caso de Soyapango</strong>Una colonia organizó su plan en un solo fin de semana: un mapa de la cuadra, una lista de vecinos por casa y un punto de reunión en la cancha. Cuando vino la siguiente alerta, evacuaron en orden y sin pánico.</div>
<h3 class="art-h3">Acuerden un punto de reunión</h3>
<p>Elijan un espacio abierto y conocido por todos —una cancha, un parque, una esquina amplia— lejos de postes y muros que puedan caer. Que todos sepan llegar allí incluso de noche.</p>
<h3 class="art-h3">Practiquen una vez</h3>
<p>Un simulacro comunitario al año mantiene el plan vivo. No necesita ser perfecto; lo importante es que la primera vez que se prueba no sea durante una emergencia real.</p>
<div class="art-takeaway"><h4>Para recordar</h4><ul><li>Conózcanse: lista de vecinos y sus necesidades.</li><li>Roles definidos antes de la crisis.</li><li>Punto de reunión abierto y seguro.</li><li>Un simulacro comunitario al año.</li></ul></div>
HTML;

$b_simulacro = <<<HTML
<p class="art-lead">"Lo practicamos tantas veces que parecía un juego. Hasta que dejó de serlo." Así recuerda una maestra el día en que el simulacro que tantos alumnos refunfuñaban terminó protegiéndolos de verdad.</p>
<h3 class="art-h3">El simulacro que nadie tomaba en serio</h3>
<p>Cada mes, la escuela hacía lo mismo: sonaba la alarma, los niños se agachaban bajo los pupitres, se cubrían la cabeza y, al cesar la señal, salían en fila al patio. Para muchos era una pausa divertida en clase. Para la maestra, era repetición con propósito.</p>
<h3 class="art-h3">El día que tembló de verdad</h3>
<p>Cuando el sismo real llegó, no hubo tiempo de pensar. Y precisamente por eso funcionó: los cuerpos ya sabían qué hacer. Nadie corrió, nadie gritó, nadie se quedó congelado. La fila salió al patio como cualquier otro mes, solo que esta vez el suelo se movía.</p>
<div class="art-quote">"No tuvimos que decidir nada. Las manos de los niños ya iban hacia la cabeza antes de que yo abriera la boca."</div>
<h3 class="art-h3">La lección</h3>
<p>El valor de un simulacro no está en el día que lo haces, sino en el día que no sabes que vendrá. La repetición convierte el conocimiento en reflejo, y en una emergencia el reflejo es lo único que responde a tiempo.</p>
<h3 class="art-h3">Llévalo a tu casa</h3>
<p>No hace falta una escuela para practicar. En familia, repasen una vez al mes dónde cubrirse, por dónde salir y dónde reunirse. Háganlo aunque parezca innecesario: ese es justo el punto.</p>
<div class="art-takeaway"><h4>Para recordar</h4><ul><li>La repetición convierte el saber en reflejo.</li><li>En la emergencia real no hay tiempo de pensar.</li><li>Practica en casa una vez al mes.</li></ul></div>
HTML;

$b_punto = <<<HTML
<p class="art-lead">Si una emergencia separa a tu familia y se cae la señal del celular, ¿cómo se reencuentran? La respuesta es un acuerdo simple que toda familia debería tener y que no cuesta nada: el punto de reunión.</p>
<h3 class="art-h3">Por qué lo necesitas</h3>
<p>Los desastres no avisan ni respetan horarios. Pueden encontrarte en el trabajo, a los niños en la escuela y a alguien más en la calle. Sin un lugar acordado de antemano, cada quien buscará al otro a ciegas, justo cuando moverse es más peligroso.</p>
<h3 class="art-h3">Define dos puntos, no uno</h3>
<p>Necesitas dos niveles. El primero, un <strong>punto cercano</strong>: un lugar fuera de casa, como la esquina o un árbol del parque, para reunirse si tienen que salir rápido. El segundo, un <strong>punto lejano</strong>: la casa de un familiar en otra zona, por si el barrio queda incomunicado o no es seguro volver.</p>
<div class="art-key"><strong>Elige bien el lugar</strong>Que sea abierto, conocido por todos y alejado de postes, muros y ventanales. Y que cada miembro sepa llegar allí por su cuenta, incluso de noche.</div>
<h3 class="art-h3">Suma un contacto puente</h3>
<p>Acuerden una persona de confianza que viva en otra ciudad o país a quien todos llamen o escriban para reportar que están bien. A veces es más fácil comunicarse fuera de la zona afectada que dentro de ella.</p>
<h3 class="art-h3">Escríbelo y repásalo</h3>
<p>Anota los puntos y el contacto en una tarjeta para la cartera de cada quien y en la mochila de emergencia. Repásenlo dos veces al año hasta que todos lo sepan de memoria.</p>
<div class="art-takeaway"><h4>Para recordar</h4><ul><li>Un punto cercano y uno lejano.</li><li>Lugares abiertos, seguros y conocidos por todos.</li><li>Un contacto puente fuera de la zona.</li><li>Escríbelo y repásalo dos veces al año.</li></ul></div>
HTML;

// ============================================================
// NOTICIAS PERIODÍSTICAS (resumidas para el ejemplo)
// ============================================================

$n_2001_enero = <<<HTML
<p class="art-lead">El 13 de enero de 2001, un terremoto de magnitud 7.7 sacudió El Salvador, convirtiéndose en el más fuerte registrado en el país desde 1986. El epicentro fue frente a la costa de Usulután.</p>
<p>Según La Prensa Gráfica, el sismo duró más de 40 segundos y fue sentido en toda Centroamérica. "San Miguel, Usulután y La Unión quedaron en ruinas. Los edificios más antiguos no resistieron", relataban los periodistas desde el lugar.</p>
<p>El presidente Francisco Flores declaró emergencia nacional y activó los protocolos de respuesta. Los equipos de rescate trabajaron sin descanso en las zonas más afectadas.</p>
<div class="art-key"><strong>Cifras oficiales</strong>844 muertos, 5,500 heridos y 150,000 damnificados. Las pérdidas económicas superaron los 300 millones de dólares.</div>
<p>La comunidad internacional respondió de inmediato. Más de 20 países enviaron ayuda humanitaria, equipos de rescate y especialistas en búsqueda y salvamento.</p>
<h3 class="art-h3">Una tragedia que marcó al país</h3>
<p>El terremoto de enero de 2001 expuso las debilidades estructurales de las viviendas y edificios públicos. Muchas construcciones no cumplían con las normas antisísmicas, lo que agravó la tragedia. A partir de ese momento, se reforzaron los controles de construcción y se actualizó el código de edificación.</p>
<div class="art-takeaway"><h4>Fuente</h4><ul><li><strong>Autor:</strong> Redacción La Prensa Gráfica</li><li><strong>Fecha:</strong> 13 de enero de 2001</li><li><strong>Enlace:</strong> <a href="https://www.laprensagrafica.com/" target="_blank" style="color:#f29f05;">laprensagrafica.com</a></li></ul></div>
HTML;

$n_2005 = <<<HTML
<p class="art-lead">El 1 de octubre de 2005, el volcán Santa Ana (Ilamatepec), el más alto de El Salvador, entró en erupción, expulsando ceniza y lava que obligaron a evacuar a más de 2,000 personas.</p>
<p>Según El Diario de Hoy, la erupción comenzó a las 8:00 de la mañana. "Una columna de ceniza de 10 kilómetros de altura se elevó sobre el volcán, visible desde toda la zona occidental", relataban los periodistas.</p>
<p>Las comunidades de Santa Ana, Chalchuapa y Coatepeque fueron las más afectadas. La ceniza cubrió plantaciones de café y afectó la salud respiratoria de miles de personas.</p>
<div class="art-key"><strong>Evacuación masiva</strong>2,000 personas evacuadas de las comunidades aledañas al volcán. El gobierno de Antonio Saca declaró alerta roja en la zona.</div>
<p>La erupción del Santa Ana fue una de las más violentas en la historia reciente de El Salvador. El cráter del volcán sufrió cambios significativos, y el lago que albergaba desapareció debido a la actividad volcánica.</p>
<div class="art-takeaway"><h4>Fuente</h4><ul><li><strong>Autor:</strong> Redacción El Diario de Hoy</li><li><strong>Fecha:</strong> 1 de octubre de 2005</li><li><strong>Enlace:</strong> <a href="https://www.elsalvador.com/" target="_blank" style="color:#f29f05;">elsalvador.com</a></li></ul></div>
HTML;

$n_2009 = <<<HTML
<p class="art-lead">El 8 de noviembre de 2009, la tormenta tropical Ida provocó inundaciones y deslaves en todo el país, dejando 198 muertos y más de 15,000 damnificados.</p>
<p>Según La Prensa Gráfica, Ida dejó lluvias acumuladas de más de 400 mm en algunas zonas. "El río Grande de San Miguel se desbordó, arrasando con comunidades enteras. En San Vicente, un deslave sepultó a decenas de personas", relataban los periodistas desde el lugar.</p>
<p>Los departamentos de San Vicente, Usulután y Cuscatlán fueron los más afectados. El gobierno de Mauricio Funes declaró emergencia nacional y pidió ayuda a la comunidad internacional.</p>
<div class="art-key"><strong>Cifras de la tragedia</strong>198 muertos, 15,000 damnificados y pérdidas económicas que superaron los 200 millones de dólares.</div>
<div class="art-takeaway"><h4>Fuente</h4><ul><li><strong>Autor:</strong> Redacción La Prensa Gráfica</li><li><strong>Fecha:</strong> 8 de noviembre de 2009</li><li><strong>Enlace:</strong> <a href="https://www.laprensagrafica.com/" target="_blank" style="color:#f29f05;">laprensagrafica.com</a></li></ul></div>
HTML;

$n_2011 = <<<HTML
<p class="art-lead">El 10 de octubre de 2011, la depresión tropical 12-E dejó lluvias históricas en El Salvador, con acumulados de más de 500 mm en 48 horas, provocando inundaciones masivas y deslaves en todo el territorio.</p>
<p>Según El Diario de Hoy, el país entró en emergencia. "En la zona central, los ríos se desbordaron. En San Salvador, las calles se convirtieron en ríos de lodo", relataban los periodistas. Más de 34 personas perdieron la vida.</p>
<p>Los departamentos de San Salvador, Cuscatlán y San Vicente fueron los más afectados. Miles de familias quedaron incomunicadas, y los albergues se llenaron de damnificados.</p>
<div class="art-key"><strong>Una tormenta histórica</strong>34 muertos, 50,000 damnificados y pérdidas superiores a los 300 millones de dólares.</div>
<div class="art-takeaway"><h4>Fuente</h4><ul><li><strong>Autor:</strong> Redacción El Diario de Hoy</li><li><strong>Fecha:</strong> 10 de octubre de 2011</li><li><strong>Enlace:</strong> <a href="https://www.elsalvador.com/" target="_blank" style="color:#f29f05;">elsalvador.com</a></li></ul></div>
HTML;

$n_2020_amanda = <<<HTML
<p class="art-lead">El 30 de mayo de 2020, la tormenta tropical Amanda golpeó El Salvador en medio de la pandemia de COVID-19, dejando 31 muertos y más de 7,000 personas en albergues.</p>
<p>Según El Diario de Hoy, Amanda tocó tierra con vientos de 65 km/h y lluvias de hasta 300 mm. "La combinación de la pandemia y la tormenta colapsó los sistemas de salud y albergues", relataban los periodistas.</p>
<p>Los departamentos de San Salvador, La Libertad y Cuscatlán fueron los más afectados. Miles de familias perdieron sus viviendas y pertenencias, y la emergencia sanitaria complicó las labores de rescate.</p>
<div class="art-key"><strong>La tormenta en tiempos de pandemia</strong>31 muertos, 7,000 albergados y pérdidas millonarias. La peor tormenta desde Mitch.</div>
<div class="art-takeaway"><h4>Fuente</h4><ul><li><strong>Autor:</strong> Redacción El Diario de Hoy</li><li><strong>Fecha:</strong> 30 de mayo de 2020</li><li><strong>Enlace:</strong> <a href="https://www.elsalvador.com/" target="_blank" style="color:#f29f05;">elsalvador.com</a></li></ul></div>
HTML;

$n_2020_cristobal = <<<HTML
<p class="art-lead">El 2 de junio de 2020, la tormenta tropical Cristóbal mantuvo las lluvias y la emergencia en El Salvador, apenas tres días después del paso de Amanda, saturando suelos y complicando la respuesta humanitaria.</p>
<p>Según La Prensa Gráfica, Cristóbal no tocó tierra directamente, pero sus bandas nubosas descargaron lluvias de hasta 200 mm en las zonas ya afectadas por Amanda.</p>
<div class="art-key"><strong>El doble golpe climático</strong>Amanda y Cristóbal en menos de una semana. Suelos saturados. Más de 10,000 personas en albergues.</div>
<div class="art-takeaway"><h4>Fuente</h4><ul><li><strong>Autor:</strong> Redacción La Prensa Gráfica</li><li><strong>Fecha:</strong> 2 de junio de 2020</li><li><strong>Enlace:</strong> <a href="https://www.laprensagrafica.com/" target="_blank" style="color:#f29f05;">laprensagrafica.com</a></li></ul></div>
HTML;

$n_2022 = <<<HTML
<p class="art-lead">El 9 de octubre de 2022, el huracán Julia impactó El Salvador como tormenta tropical, dejando más de 4,000 evacuados y daños en carreteras, puentes y viviendas.</p>
<p>Según El Diario de Hoy, Julia llegó con vientos de 85 km/h y lluvias de hasta 250 mm. "Los ríos Grande de San Miguel y Lempa se desbordaron. En Usulután, las comunidades quedaron incomunicadas", relataban los periodistas.</p>
<p>Protección Civil reportó más de 4,000 personas en albergues. Los puentes en la carretera Panamericana y la Ruta Militar sufrieron daños significativos, interrumpiendo el tránsito hacia el oriente.</p>
<div class="art-key"><strong>Julia en El Salvador</strong>4,000 evacuados, 500 viviendas afectadas y daños en la infraestructura vial. Sin víctimas mortales.</div>
<div class="art-takeaway"><h4>Fuente</h4><ul><li><strong>Autor:</strong> Redacción El Diario de Hoy</li><li><strong>Fecha:</strong> 9 de octubre de 2022</li><li><strong>Enlace:</strong> <a href="https://www.elsalvador.com/" target="_blank" style="color:#f29f05;">elsalvador.com</a></li></ul></div>
HTML;

$n_2026_enero = <<<HTML
<p class="art-lead">El 10 de enero de 2026, un sismo de magnitud 4.1 frente a la costa de La Libertad fue percibido en San Salvador, Santa Tecla y Lourdes, sin reporte de daños materiales.</p>
<p>Según El Diario de Hoy, el sismo ocurrió a las 9:15 de la mañana, con epicentro a 45 km de la costa. "El movimiento fue sentido en varios puntos de la capital, pero no se reportaron daños en infraestructura", informó el MARN.</p>
<div class="art-key"><strong>Sismo de enero 2026</strong>Magnitud 4.1. Epicentro frente a La Libertad. Sin daños. Percibido en la zona metropolitana.</div>
<div class="art-takeaway"><h4>Fuente</h4><ul><li><strong>Autor:</strong> Redacción El Diario de Hoy</li><li><strong>Fecha:</strong> 10 de enero de 2026</li><li><strong>Enlace:</strong> <a href="https://www.elsalvador.com/noticias/nacional/sismo-marn/1258019/2026/" target="_blank" style="color:#f29f05;">elsalvador.com</a></li></ul></div>
HTML;

// ============================================================
// CONFIGURACIÓN DEL BLOG
// ============================================================

$BASE = 'assets/media/blog/';
$ARTÍCULOS = [
  // ===== GUÍAS DE PREVENCIÓN =====
  '72-horas' => ['titulo'=>'Cómo preparar a tu familia en 72 horas','cat'=>'prevencion','tag'=>'Prevención','color'=>'#f29f05','autor'=>'Equipo NDA','tiempo'=>'6 min','destacado'=>true,'img'=>$BASE.'72-horas.jpg','extracto'=>'La regla de las primeras 72 horas puede marcar la diferencia. Qué hacer, paso a paso, antes de que llegue la próxima emergencia.','cuerpo'=>$b_72],
  'agachate' => ['titulo'=>'Agáchate, cúbrete y agárrate: la técnica que funciona','cat'=>'sismos','tag'=>'Sismos','color'=>'#f29f05','autor'=>'Equipo NDA','tiempo'=>'4 min','destacado'=>false,'img'=>$BASE.'agachate.jpg','extracto'=>'Por qué tres segundos de reacción correcta valen más que correr. La ciencia detrás del protocolo.','cuerpo'=>$b_agachate],
  'lluvias'  => ['titulo'=>'Temporada de lluvias: señales que no debes ignorar','cat'=>'lluvias','tag'=>'Lluvias','color'=>'#2e7da6','autor'=>'Equipo NDA','tiempo'=>'5 min','destacado'=>false,'img'=>$BASE.'lluvias.jpg','extracto'=>'Quebradas que crecen, suelos saturados y ese olor a tierra mojada. Aprende a leer el riesgo.','cuerpo'=>$b_lluvias],
  'mochila'  => ['titulo'=>'Tu mochila de emergencia en 10 objetos','cat'=>'prevencion','tag'=>'Prevención','color'=>'#2e8b7f','autor'=>'Equipo NDA','tiempo'=>'3 min','destacado'=>false,'img'=>$BASE.'mochila.jpg','extracto'=>'Sin gastar de más. La lista mínima que cualquier hogar salvadoreño debería tener lista hoy.','cuerpo'=>$b_mochila],
  'vecinos'  => ['titulo'=>'Vecinos organizados: el primer equipo de rescate','cat'=>'comunidad','tag'=>'Comunidad','color'=>'#f2b705','autor'=>'Equipo NDA','tiempo'=>'7 min','destacado'=>false,'img'=>$BASE.'vecinos.jpg','extracto'=>'Cómo una colonia de Soyapango montó su propio plan de evacuación en un fin de semana.','cuerpo'=>$b_vecinos],
  'simulacro'=> ['titulo'=>'"El simulacro nos salvó": la historia de una escuela','cat'=>'testimonios','tag'=>'Testimonio','color'=>'#d91a2a','autor'=>'Equipo NDA','tiempo'=>'6 min','destacado'=>false,'img'=>$BASE.'simulacro.jpg','extracto'=>'Practicaron tantas veces que cuando tembló de verdad, nadie dudó. Un relato en primera persona.','cuerpo'=>$b_simulacro],
  'punto'    => ['titulo'=>'El punto de reunión que toda familia necesita','cat'=>'prevencion','tag'=>'Prevención','color'=>'#6a6fb5','autor'=>'Equipo NDA','tiempo'=>'4 min','destacado'=>false,'img'=>$BASE.'punto.jpg','extracto'=>'Si se pierde la señal y nadie sabe dónde está el otro, este simple acuerdo lo resuelve.','cuerpo'=>$b_punto],

  // ===== NOTICIAS =====
  'noticia-2001-enero' => ['titulo'=>'Terremoto de 7.7 sacude El Salvador (2001)','cat'=>'sismos','tag'=>'Sismo Histórico','color'=>'#d91a2a','autor'=>'La Prensa Gráfica','tiempo'=>'5 min','destacado'=>false,'img'=>$BASE.'noticias/2001-terremoto-enero.jpg','extracto'=>'El 13 de enero de 2001, el terremoto más fuerte desde 1986 dejó 844 muertos.','cuerpo'=>$n_2001_enero],
  'noticia-2005' => ['titulo'=>'Erupción del volcán Santa Ana (2005)','cat'=>'volcanes','tag'=>'Volcán Histórico','color'=>'#f29f05','autor'=>'El Diario de Hoy','tiempo'=>'4 min','destacado'=>false,'img'=>$BASE.'noticias/2005-santa-ana.jpg','extracto'=>'El 1 de octubre de 2005, el volcán Santa Ana entró en erupción evacuando a 2,000 personas.','cuerpo'=>$n_2005],
  'noticia-2009' => ['titulo'=>'Tormenta Ida: 198 muertos en 2009','cat'=>'lluvias','tag'=>'Inundación Histórica','color'=>'#2e7da6','autor'=>'La Prensa Gráfica','tiempo'=>'4 min','destacado'=>false,'img'=>$BASE.'noticias/2009-ida.jpg','extracto'=>'El 8 de noviembre de 2009, la tormenta Ida dejó 198 muertos y 15,000 damnificados.','cuerpo'=>$n_2009],
  'noticia-2011' => ['titulo'=>'Depresión Tropical 12-E (2011)','cat'=>'lluvias','tag'=>'Inundación Histórica','color'=>'#2e7da6','autor'=>'El Diario de Hoy','tiempo'=>'4 min','destacado'=>false,'img'=>$BASE.'noticias/2011-12e.jpg','extracto'=>'En octubre de 2011, la DT 12-E dejó 34 muertos y 50,000 damnificados.','cuerpo'=>$n_2011],
  'noticia-2020-amanda' => ['titulo'=>'Tormenta Amanda (2020)','cat'=>'lluvias','tag'=>'Inundación Reciente','color'=>'#2e7da6','autor'=>'El Diario de Hoy','tiempo'=>'4 min','destacado'=>false,'img'=>$BASE.'noticias/2020-amanda.jpg','extracto'=>'El 30 de mayo de 2020, Amanda golpeó en plena pandemia: 31 muertos.','cuerpo'=>$n_2020_amanda],
  'noticia-2020-cristobal' => ['titulo'=>'Cristóbal mantiene las lluvias (2020)','cat'=>'lluvias','tag'=>'Inundación Reciente','color'=>'#2e7da6','autor'=>'La Prensa Gráfica','tiempo'=>'3 min','destacado'=>false,'img'=>$BASE.'noticias/2020-cristobal.jpg','extracto'=>'El 2 de junio de 2020, Cristóbal prolongó la emergencia tras Amanda.','cuerpo'=>$n_2020_cristobal],
  'noticia-2022' => ['titulo'=>'Huracán Julia: 4,000 evacuados','cat'=>'huracanes','tag'=>'Huracán Reciente','color'=>'#1a7a7a','autor'=>'El Diario de Hoy','tiempo'=>'4 min','destacado'=>false,'img'=>$BASE.'noticias/2022-julia.jpg','extracto'=>'El 9 de octubre de 2022, Julia dejó 4,000 evacuados y daños en carreteras.','cuerpo'=>$n_2022],
  'noticia-2026-enero' => ['titulo'=>'Sismo de 4.1 frente a La Libertad (2026)','cat'=>'sismos','tag'=>'Sismo Reciente','color'=>'#d91a2a','autor'=>'El Diario de Hoy','tiempo'=>'2 min','destacado'=>false,'img'=>$BASE.'noticias/2026-sismo-enero.jpg','extracto'=>'El 10 de enero de 2026, un sismo de 4.1 fue percibido en San Salvador.','cuerpo'=>$n_2026_enero],
];

// ============================================================
// ÍCONOS Y FUNCIONES
// ============================================================

$icoUser = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><circle cx="12" cy="8" r="3.2"/><path d="M5 20c0-3.6 3.1-5.5 7-5.5s7 1.9 7 5.5"/></svg>';
$icoClock = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><circle cx="12" cy="12" r="8.2"/><path d="M12 7.5V12l3 1.8"/></svg>';
$icoHeart = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l8.8 8.8 8.8-8.8a5.5 5.5 0 0 0 0-7.8z"/></svg>';
$icoBookmark = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg>';
$icoHighlight = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>';

$slug = isset($_GET['post']) ? $_GET['post'] : null;
$post = ($slug !== null && isset($ARTÍCULOS[$slug])) ? $ARTÍCULOS[$slug] : null;
if ($post) { $title = $post['titulo'] . ' - NDA'; }

// Generar ID único para el artículo
$postId = $slug ? md5($slug) : '';

ob_start();
?>

<?php if ($post): /* Artículo */ ?>
<div class="blog-page" data-no-anim data-post="<?= $postId ?>">
  <div class="wrap" style="padding-top:80px; padding-bottom:60px; max-width:900px;">

    <!-- ===== DECORACIONES LATERALES ANIMADAS ===== -->
    <div class="art-deco art-deco-left">
      <div class="deco-circle"></div>
      <div class="deco-dot"></div>
      <div class="deco-line"></div>
      <div class="deco-dot2"></div>
    </div>
    <div class="art-deco art-deco-right">
      <div class="deco-circle2"></div>
      <div class="deco-dot3"></div>
      <div class="deco-line2"></div>
      <div class="deco-dot4"></div>
    </div>

    <a href="?url=blog" class="art-back reveal"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg> Volver al blog</a>

    <!-- ===== HEADER ===== -->
    <header class="art-hero reveal" style="--c:<?= $post['color'] ?>;">
      <div class="art-cover" style="background-color:<?= $post['color'] ?>; background-image:url('<?= htmlspecialchars($post['img']) ?>');">
        <span class="art-tag"><?= htmlspecialchars($post['tag']) ?></span>
      </div>
      <h1 class="art-title"><?= htmlspecialchars($post['titulo']) ?></h1>
      <div class="art-meta">
        <span class="mi"><?= $icoUser ?><?= htmlspecialchars($post['autor']) ?></span>
        <span class="dot"></span>
        <span class="mi"><?= $icoClock ?><?= htmlspecialchars($post['tiempo']) ?> de lectura</span>
      </div>
    </header>

    <!-- ===== MINI NAVBAR DE LECTURA ===== -->
    <div class="reading-navbar" id="readingNav">
      <div class="reading-tools">
        <button class="rtool" data-action="highlight" title="Subrayar texto seleccionado">
          <?= $icoHighlight ?> <span>Subrayar</span>
        </button>
        <button class="rtool" data-action="like" title="Me gusta" id="likeBtn">
          <?= $icoHeart ?> <span id="likeCount">0</span>
        </button>
        <button class="rtool" data-action="save" title="Guardar artículo" id="saveBtn">
          <?= $icoBookmark ?> <span>Guardar</span>
        </button>
        <div class="rtool-divider"></div>
        <button class="rtool rtool-emoji" data-emoji="😢">😢</button>
        <button class="rtool rtool-emoji" data-emoji="😮">😮</button>
        <button class="rtool rtool-emoji" data-emoji="🙏">🙏</button>
        <button class="rtool rtool-emoji" data-emoji="💪">💪</button>
        <button class="rtool rtool-emoji" data-emoji="❤️">❤️</button>
      </div>
      <div class="reading-progress">
        <div class="reading-progress-bar" id="readingProgress"></div>
      </div>
    </div>

    <!-- ===== POST-IT DE DATOS ===== -->
    <div class="postit-note" id="postitNote">
      <div class="postit-pin"></div>
      <div class="postit-content">
        <span class="postit-label">📌 DATO CLAVE</span>
        <p id="postitText"><?= htmlspecialchars($post['extracto']) ?></p>
        <span class="postit-tip">💡 Toca para cambiar</span>
      </div>
    </div>

    <!-- ===== CONTENIDO ===== -->
    <article class="art-body reveal" id="artBody"><?= $post['cuerpo'] ?></article>

    <!-- ===== REACCIONES ===== -->
    <div class="reactions-bar reveal">
      <span class="reactions-label">¿Cómo te hizo sentir esta noticia?</span>
      <div class="reactions-list" id="reactionsList">
        <button class="reaction-btn" data-emoji="😢" data-label="Triste">😢 <span class="reaction-count">0</span></button>
        <button class="reaction-btn" data-emoji="😮" data-label="Impactante">😮 <span class="reaction-count">0</span></button>
        <button class="reaction-btn" data-emoji="🙏" data-label="Esperanza">🙏 <span class="reaction-count">0</span></button>
        <button class="reaction-btn" data-emoji="💪" data-label="Fuerza">💪 <span class="reaction-count">0</span></button>
        <button class="reaction-btn" data-emoji="❤️" data-label="Amor">❤️ <span class="reaction-count">0</span></button>
      </div>
    </div>

    <!-- ===== ARTÍCULOS RELACIONADOS ===== -->
    <div class="art-more reveal">
      <h3>📖 Sigue leyendo</h3>
      <div class="art-more-grid">
        <?php $shown=0; foreach ($ARTÍCULOS as $s=>$a): if ($s===$slug) continue; if ($shown++>=3) break; ?>
          <a class="art-more-card" href="?url=blog&post=<?= $s ?>" style="--c:<?= $a['color'] ?>;">
            <span class="amc-img" style="background-color:<?= $a['color'] ?>; background-image:url('<?= htmlspecialchars($a['img']) ?>');"></span>
            <span class="amc-tag"><?= htmlspecialchars($a['tag']) ?></span>
            <strong><?= htmlspecialchars($a['titulo']) ?></strong>
          </a>
        <?php endforeach; ?>
      </div>
    </div>

  </div>
</div>

<?php else: /* Lista */ ?>
<div class="blog-page" data-no-anim>
  <div class="wrap" style="padding-top:80px; padding-bottom:60px;">

    <div class="blog-head reveal">
      <span class="kicker">REVISTA NDA · EDICIÓN VIVA</span>
      <h1 class="blog-title">Historias que <span class="grad">salvan vidas</span></h1>
      <p class="blog-intro">Reportajes, guías y testimonios sobre prevención de desastres en El Salvador. Información clara, visual y lista para actuar.</p>
    </div>

    <?php $f = $ARTÍCULOS['72-horas']; ?>
    <a class="featured reveal" href="?url=blog&post=72-horas">
      <div class="featured-img" style="background-color:<?= $f['color'] ?>; background-image:url('<?= htmlspecialchars($f['img']) ?>');"></div>
      <div class="featured-content">
        <span class="badge-live">EN PORTADA</span>
        <h2><?= htmlspecialchars($f['titulo']) ?></h2>
        <p><?= htmlspecialchars($f['extracto']) ?></p>
        <div class="featured-meta">
          <span class="mi"><?= $icoUser ?><?= htmlspecialchars($f['autor']) ?></span>
          <span class="dot"></span>
          <span class="mi"><?= $icoClock ?><?= htmlspecialchars($f['tiempo']) ?> de lectura</span>
        </div>
        <span class="featured-cta">Leer reportaje <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></span>
      </div>
    </a>

    <div class="blog-filters reveal">
      <button class="bfilter active" data-cat="all">Todos</button>
      <button class="bfilter" data-cat="prevencion">Prevención</button>
      <button class="bfilter" data-cat="sismos">Sismos</button>
      <button class="bfilter" data-cat="volcanes">Volcanes</button>
      <button class="bfilter" data-cat="lluvias">Lluvias</button>
      <button class="bfilter" data-cat="huracanes">Huracanes</button>
      <button class="bfilter" data-cat="comunidad">Comunidad</button>
      <button class="bfilter" data-cat="testimonios">Testimonios</button>
    </div>

    <div class="blog-grid">
      <?php foreach ($ARTÍCULOS as $s=>$a): if (!empty($a['destacado'])) continue; ?>
        <a class="post-card" href="?url=blog&post=<?= $s ?>" data-cat="<?= $a['cat'] ?>" style="--accent:<?= $a['color'] ?>;">
          <div class="post-thumb">
            <div class="post-img" style="background-color:<?= $a['color'] ?>; background-image:url('<?= htmlspecialchars($a['img']) ?>');"></div>
            <span class="post-tag"><?= htmlspecialchars($a['tag']) ?></span>
          </div>
          <div class="post-body">
            <h3><?= htmlspecialchars($a['titulo']) ?></h3>
            <p><?= htmlspecialchars($a['extracto']) ?></p>
            <div class="post-meta">
              <span class="mi"><?= $icoUser ?><?= htmlspecialchars($a['autor']) ?></span>
              <span class="mi"><?= $icoClock ?><?= htmlspecialchars($a['tiempo']) ?></span>
            </div>
          </div>
        </a>
      <?php endforeach; ?>
    </div>

    <div class="newsletter reveal">
      <div class="news-glow"></div>
      <h3>No te pierdas la próxima edición</h3>
      <p>Recibe una alerta cuando publiquemos una nueva guía o reportaje.</p>
      <div class="news-form">
        <input type="email" id="newsEmail" placeholder="tucorreo@ejemplo.com" />
        <button id="newsBtn">Suscribirme</button>
      </div>
      <span id="newsMsg" class="news-msg"></span>
    </div>

  </div>
</div>
<?php endif; ?>

<style>
.blog-page{ --bk:#0d1117; }
.blog-page .kicker{ display:inline-block; font-size:.7rem; letter-spacing:3px; font-weight:800; color:#f29f05; background:rgba(242, 159, 5,.1); padding:6px 14px; border-radius:100px; margin-bottom:14px; }
.blog-head{ text-align:center; margin-bottom:40px; }
.blog-title{ font-size:clamp(2rem,5vw,3.4rem); font-weight:900; line-height:1.04; color:var(--text1,var(--text,#fff)); margin:0; letter-spacing:-.02em; }
.blog-title .grad{ background:linear-gradient(135deg,#f29f05,#c2441c); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
.blog-intro{ color:var(--text2,#a1a1aa); font-size:1.1rem; max-width:620px; margin:14px auto 0; line-height:1.6; }

.mi{ display:inline-flex; align-items:center; gap:6px; }
.mi svg{ width:15px; height:15px; opacity:.8; }
.dot{ width:3px; height:3px; border-radius:50%; background:currentColor; opacity:.5; display:inline-block; }

/* ===== DECORACIONES LATERALES ANIMADAS ===== */
.art-deco{ position:fixed; top:50%; transform:translateY(-50%); pointer-events:none; z-index:0; opacity:.15; }
.art-deco-left{ left:15px; }
.art-deco-right{ right:15px; }
.deco-circle{ width:120px; height:120px; border-radius:50%; border:2px solid #f29f05; animation:decoFloat 6s ease-in-out infinite; }
.deco-circle2{ width:100px; height:100px; border-radius:50%; border:2px solid #d91a2a; animation:decoFloat2 8s ease-in-out infinite; }
.deco-dot{ width:12px; height:12px; border-radius:50%; background:#f29f05; margin:20px auto; animation:decoPulse 3s ease-in-out infinite; }
.deco-dot2{ width:8px; height:8px; border-radius:50%; background:#2e7da6; margin:15px auto; animation:decoPulse 4s ease-in-out infinite 1s; }
.deco-dot3{ width:14px; height:14px; border-radius:50%; background:#2e8b7f; margin:18px auto; animation:decoPulse 3.5s ease-in-out infinite .5s; }
.deco-dot4{ width:10px; height:10px; border-radius:50%; background:#f2b705; margin:12px auto; animation:decoPulse 4.5s ease-in-out infinite 1.5s; }
.deco-line{ width:60px; height:2px; background:linear-gradient(to right, #f29f05, transparent); margin:15px auto; animation:decoSlide 5s ease-in-out infinite; }
.deco-line2{ width:50px; height:2px; background:linear-gradient(to left, #d91a2a, transparent); margin:15px auto; animation:decoSlide2 5.5s ease-in-out infinite; }

@keyframes decoFloat{ 0%,100%{ transform:translateY(0); } 50%{ transform:translateY(-30px); } }
@keyframes decoFloat2{ 0%,100%{ transform:translateY(0) rotate(0deg); } 50%{ transform:translateY(-20px) rotate(10deg); } }
@keyframes decoPulse{ 0%,100%{ opacity:.3; transform:scale(1); } 50%{ opacity:1; transform:scale(1.3); } }
@keyframes decoSlide{ 0%,100%{ transform:scaleX(1); } 50%{ transform:scaleX(.3); } }
@keyframes decoSlide2{ 0%,100%{ transform:scaleX(1); } 50%{ transform:scaleX(.4); } }

/* ===== FEATURED ===== */
.featured{ display:flex; align-items:flex-end; position:relative; border-radius:24px; overflow:hidden; min-height:420px; margin-bottom:46px; border:1px solid var(--border,#27272a); text-decoration:none; isolation:isolate; }
.featured-img{ position:absolute; inset:0; z-index:-2; background-size:cover; background-position:center; transition:transform .7s var(--ease-exo,cubic-bezier(.16,1,.3,1)); }
.featured::after{ content:""; position:absolute; inset:0; z-index:-1; background:linear-gradient(to top, rgba(8,10,14,.94) 8%, rgba(8,10,14,.55) 45%, rgba(8,10,14,.15) 100%); }
.featured:hover .featured-img{ transform:scale(1.05); }
.featured-content{ padding:38px; max-width:660px; }
.badge-live{ display:inline-block; font-size:.66rem; font-weight:800; letter-spacing:2px; color:#fff; background:#d91a2a; padding:5px 13px; border-radius:100px; margin-bottom:14px; }
.featured-content h2{ font-size:clamp(1.6rem,4vw,2.6rem); font-weight:900; color:#fff; margin:0 0 12px; line-height:1.08; letter-spacing:-.01em; }
.featured-content p{ color:#cbd5e1; font-size:1.02rem; line-height:1.6; margin:0 0 16px; }
.featured-meta{ display:flex; gap:12px; align-items:center; flex-wrap:wrap; color:#94a3b8; font-size:.82rem; margin-bottom:20px; }
.featured-cta{ display:inline-block; background:#fff; color:#0d1117; padding:12px 28px; border-radius:100px; font-weight:700; font-size:.9rem; transition:transform .25s, background .25s; }
.featured:hover .featured-cta{ transform:translateX(4px); background:#f29f05; color:#fff; }

/* ===== FILTROS ===== */
.blog-filters{ display:flex; gap:10px; flex-wrap:wrap; justify-content:center; margin-bottom:34px; }
.bfilter{ background:transparent; color:var(--text2,#a1a1aa); border:1px solid var(--border,#27272a); padding:9px 20px; border-radius:50px; font-size:.85rem; cursor:pointer; transition:all .2s; }
.bfilter:hover{ color:var(--text1,#fff); border-color:rgba(242, 159, 5,.5); }
.bfilter.active{ background:#f29f05; color:#fff; border-color:transparent; }

/* ===== GRID ===== */
.blog-grid{ display:grid; grid-template-columns:repeat(auto-fill,minmax(310px,1fr)); gap:26px; margin-bottom:52px; }
.post-card{ display:flex; flex-direction:column; background:var(--card,#15161a); border:1px solid var(--border,#27272a); border-radius:18px; overflow:hidden; text-decoration:none; transition:transform .3s var(--ease-exo,cubic-bezier(.16,1,.3,1)), box-shadow .3s, border-color .3s; }
.post-card:hover{ transform:translateY(-7px); box-shadow:0 22px 55px rgba(0,0,0,.4); border-color:var(--accent); }
.post-thumb{ position:relative; height:200px; overflow:hidden; }
.post-img{ position:absolute; inset:0; background-size:cover; background-position:center; transition:transform .7s var(--ease-exo,cubic-bezier(.16,1,.3,1)); }
.post-card:hover .post-img{ transform:scale(1.07); }
.post-thumb::after{ content:""; position:absolute; inset:0; background:linear-gradient(to top, rgba(8,10,14,.55), transparent 55%); }
.post-tag{ position:absolute; top:14px; left:14px; z-index:1; background:rgba(8,10,14,.55); color:#fff; backdrop-filter:blur(8px); font-size:.68rem; font-weight:700; letter-spacing:.5px; padding:5px 13px; border-radius:100px; border:1px solid rgba(255,255,255,.12); }
.post-body{ padding:20px 22px 22px; flex:1; display:flex; flex-direction:column; }
.post-body h3{ font-size:1.12rem; font-weight:800; color:var(--text1,var(--text,#fff)); margin:0 0 9px; line-height:1.25; letter-spacing:-.01em; }
.post-body p{ font-size:.88rem; color:var(--text2,#a1a1aa); line-height:1.55; margin:0 0 16px; flex:1; }
.post-meta{ display:flex; justify-content:space-between; align-items:center; font-size:.78rem; color:var(--text3,#71717a); }

/* ===== NEWSLETTER ===== */
.newsletter{ position:relative; text-align:center; background:var(--card,#15161a); border:1px solid var(--border,#27272a); border-radius:24px; padding:44px 24px; overflow:hidden; }
.news-glow{ position:absolute; top:-60%; left:50%; transform:translateX(-50%); width:420px; height:420px; background:radial-gradient(circle, rgba(242, 159, 5,.22), transparent 70%); pointer-events:none; animation:floaty 6s ease-in-out infinite; }
.newsletter h3{ font-size:1.5rem; font-weight:900; color:var(--text1,var(--text,#fff)); margin:0 0 8px; position:relative; letter-spacing:-.01em; }
.newsletter p{ color:var(--text2,#a1a1aa); margin:0 0 20px; position:relative; }
.news-form{ display:flex; gap:10px; max-width:440px; margin:0 auto; position:relative; flex-wrap:wrap; justify-content:center; }
.news-form input{ flex:1; min-width:200px; background:var(--card2,#1f2024); border:1px solid var(--border,#27272a); color:var(--text1,#fff); padding:13px 18px; border-radius:100px; font-size:.9rem; outline:none; transition:border-color .2s; }
.news-form input:focus{ border-color:#f29f05; }
.news-form button{ background:linear-gradient(135deg,#f29f05,#c2441c); color:#fff; border:none; padding:13px 28px; border-radius:100px; font-weight:700; cursor:pointer; font-size:.9rem; transition:transform .2s; }
.news-form button:hover{ transform:scale(1.05); }
.news-msg{ display:block; margin-top:14px; color:#2e8b7f; font-size:.85rem; font-weight:600; min-height:18px; }

/* ===== ARTÍCULO ===== */
.art-back{ display:inline-block; color:var(--text2,#a1a1aa); text-decoration:none; font-size:.9rem; margin-bottom:24px; transition:color .2s, transform .2s; position:relative; z-index:2; }
.art-back:hover{ color:#f29f05; transform:translateX(-3px); }

.art-hero{ margin-bottom:34px; position:relative; z-index:2; }
.art-cover{ position:relative; height:340px; border-radius:22px; background-size:cover; background-position:center; overflow:hidden; margin-bottom:26px; }
.art-cover::after{ content:""; position:absolute; inset:0; background:linear-gradient(to top, rgba(8,10,14,.5), transparent 50%); }
.art-tag{ position:absolute; top:18px; left:18px; z-index:1; background:rgba(8,10,14,.55); color:#fff; backdrop-filter:blur(8px); font-size:.72rem; font-weight:700; letter-spacing:.5px; padding:6px 15px; border-radius:100px; border:1px solid rgba(255,255,255,.14); }
.art-title{ font-size:clamp(1.9rem,4.5vw,3rem); font-weight:900; line-height:1.1; color:var(--text1,var(--text,#fff)); margin:0 0 16px; letter-spacing:-.02em; }
.art-meta{ display:flex; gap:12px; align-items:center; flex-wrap:wrap; color:var(--text3,#71717a); font-size:.88rem; }

/* ===== READING NAVBAR ===== */
.reading-navbar{ position:sticky; top:70px; z-index:100; background:var(--card,#15161a); border:1px solid var(--border,#27272a); border-radius:16px; padding:10px 16px; margin-bottom:28px; backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px); background:rgba(21,22,26,.88); display:flex; flex-direction:column; gap:8px; }
.reading-tools{ display:flex; gap:6px; align-items:center; flex-wrap:wrap; }
.rtool{ background:transparent; border:none; color:var(--text2,#a1a1aa); padding:6px 12px; border-radius:10px; cursor:pointer; font-size:.8rem; display:inline-flex; align-items:center; gap:6px; transition:all .2s; font-family:inherit; }
.rtool svg{ width:16px; height:16px; }
.rtool:hover{ color:var(--text1,#fff); background:rgba(255,255,255,.06); }
.rtool.active{ color:#f29f05; background:rgba(242,159,5,.12); }
.rtool-divider{ width:1px; height:24px; background:var(--border,#27272a); margin:0 4px; }
.rtool-emoji{ font-size:1.2rem; padding:4px 8px; }
.rtool-emoji:hover{ background:rgba(255,255,255,.08); transform:scale(1.15); }
.reading-progress{ height:3px; background:var(--border,#27272a); border-radius:4px; overflow:hidden; }
.reading-progress-bar{ height:100%; width:0%; background:linear-gradient(90deg,#f29f05,#c2441c); transition:width .15s ease; border-radius:4px; }

/* ===== POST-IT ===== */
.postit-note{ position:relative; background:#fef9e7; border-radius:4px; padding:18px 20px 14px; margin:0 0 28px; box-shadow:0 8px 30px rgba(0,0,0,.25), 0 0 0 1px rgba(0,0,0,.05); color:#2d2d2d; cursor:pointer; transition:transform .3s, box-shadow .3s; z-index:2; }
.postit-note:hover{ transform:rotate(-1deg) scale(1.01); box-shadow:0 12px 40px rgba(0,0,0,.35); }
.postit-pin{ position:absolute; top:-8px; left:50%; transform:translateX(-50%); width:18px; height:18px; border-radius:50%; background:radial-gradient(circle at 30% 30%, #e74c3c, #c0392b); box-shadow:0 2px 8px rgba(0,0,0,.2); }
.postit-content{ text-align:center; }
.postit-label{ font-size:.6rem; font-weight:800; letter-spacing:2px; color:#f39c12; text-transform:uppercase; display:block; margin-bottom:6px; }
.postit-content p{ font-size:.95rem; line-height:1.6; margin:0; color:#2d2d2d; font-weight:500; }
.postit-tip{ font-size:.65rem; color:#999; display:block; margin-top:8px; opacity:.7; }

/* ===== REACCIONES ===== */
.reactions-bar{ background:var(--card,#15161a); border:1px solid var(--border,#27272a); border-radius:16px; padding:20px 24px; margin:32px 0; text-align:center; position:relative; z-index:2; }
.reactions-label{ font-size:.85rem; color:var(--text2,#a1a1aa); display:block; margin-bottom:12px; font-weight:600; }
.reactions-list{ display:flex; gap:10px; justify-content:center; flex-wrap:wrap; }
.reaction-btn{ background:transparent; border:1px solid var(--border,#27272a); border-radius:30px; padding:8px 16px; cursor:pointer; font-size:1rem; transition:all .25s; color:var(--text2,#a1a1aa); display:inline-flex; align-items:center; gap:8px; font-family:inherit; background:rgba(255,255,255,.02); }
.reaction-btn:hover{ border-color:rgba(242,159,5,.4); background:rgba(242,159,5,.06); transform:scale(1.05); }
.reaction-btn.active{ border-color:#f29f05; background:rgba(242,159,5,.12); color:#fff; }
.reaction-count{ font-size:.7rem; font-weight:700; color:var(--text3,#71717a); min-width:16px; }
.reaction-btn.active .reaction-count{ color:#f29f05; }

/* ===== HIGHLIGHT ===== */
::selection{ background:#f29f05; color:#fff; }
.highlighted{ background:#f29f05; color:#fff; padding:0 4px; border-radius:3px; cursor:pointer; transition:background .3s; }
.highlighted:hover{ background:#c2441c; }

/* ===== ARTÍCULO CUERPO ===== */
.art-body{ font-size:1.08rem; line-height:1.85; color:var(--text2,#c4c4cc); position:relative; z-index:2; }
.art-body .art-lead{ font-size:1.26rem; line-height:1.7; color:var(--text1,var(--text,#fff)); font-weight:500; margin:0 0 28px; }
.art-body .art-h3{ font-size:1.4rem; font-weight:800; color:var(--text1,var(--text,#fff)); margin:38px 0 12px; line-height:1.25; letter-spacing:-.01em; }
.art-body p{ margin:0 0 18px; }
.art-body strong{ color:var(--text1,var(--text,#fff)); }
.art-body .art-steps{ margin:0 0 18px; padding-left:0; list-style:none; counter-reset:s; }
.art-body .art-steps li{ position:relative; padding:11px 0 11px 46px; border-bottom:1px dashed var(--border,#27272a); }
.art-body .art-steps li::before{ counter-increment:s; content:counter(s); position:absolute; left:0; top:11px; width:30px; height:30px; border-radius:50%; background:linear-gradient(135deg,#f29f05,#c2441c); color:#fff; font-weight:800; font-size:.85rem; display:flex; align-items:center; justify-content:center; }
.art-key{ background:rgba(242, 159, 5,.07); border:1px solid rgba(242, 159, 5,.22); border-left:4px solid #f29f05; border-radius:14px; padding:18px 22px; margin:28px 0; }
.art-key strong{ display:block; color:#f29f05; font-size:1rem; margin-bottom:6px; }
.art-quote{ font-size:1.5rem; line-height:1.5; font-weight:700; color:var(--text1,var(--text,#fff)); border-left:4px solid #d91a2a; padding:8px 0 8px 24px; margin:32px 0; font-style:italic; }
.art-takeaway{ background:var(--card,#15161a); border:1px solid var(--border,#27272a); border-radius:18px; padding:24px 26px; margin:36px 0 10px; }
.art-takeaway h4{ font-size:1rem; font-weight:800; color:#2e8b7f; margin:0 0 12px; }
.art-takeaway ul{ margin:0; padding-left:20px; }
.art-takeaway li{ margin-bottom:8px; color:var(--text2,#c4c4cc); }
.art-takeaway a{ text-decoration:underline; }

.art-more{ margin-top:54px; padding-top:32px; border-top:1px solid var(--border,#27272a); position:relative; z-index:2; }
.art-more h3{ font-size:1.3rem; font-weight:900; color:var(--text1,var(--text,#fff)); margin:0 0 20px; letter-spacing:-.01em; }
.art-more-grid{ display:grid; grid-template-columns:repeat(auto-fill,minmax(210px,1fr)); gap:16px; }
.art-more-card{ display:flex; flex-direction:column; gap:10px; background:var(--card,#15161a); border:1px solid var(--border,#27272a); border-radius:16px; overflow:hidden; padding-bottom:16px; text-decoration:none; transition:transform .25s, border-color .25s; }
.art-more-card:hover{ transform:translateY(-4px); border-color:var(--c); }
.amc-img{ height:110px; background-size:cover; background-position:center; }
.amc-tag{ font-size:.66rem; font-weight:700; color:var(--c); text-transform:uppercase; letter-spacing:1px; padding:0 16px; }
.art-more-card strong{ color:var(--text1,var(--text,#fff)); font-size:.96rem; line-height:1.3; padding:0 16px; }

.reveal{ opacity:0; transform:translateY(28px); transition:opacity .7s ease, transform .7s ease; }
.reveal.in{ opacity:1; transform:none; }
@keyframes floaty{ 0%,100%{ transform:translateX(-50%) translateY(0);} 50%{ transform:translateX(-50%) translateY(20px);} }

@media (max-width:768px){
  .art-deco{ display:none; }
  .reading-navbar{ top:60px; padding:8px 12px; }
  .reading-tools{ gap:4px; }
  .rtool span{ display:none; }
  .rtool{padding:6px 10px;}
  .postit-note{ margin:0 0 20px; }
  .reactions-list{ gap:6px; }
  .reaction-btn{ padding:6px 12px; font-size:.9rem; }
  .art-cover{ height:220px; }
  .blog-grid{ grid-template-columns:1fr; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

  // ===== REVEAL ANIMATIONS =====
  const io = new IntersectionObserver((entries) => {
    entries.forEach((e,i) => { if(e.isIntersecting){ setTimeout(()=>e.target.classList.add('in'),(i%6)*80); io.unobserve(e.target);} });
  }, { threshold: 0.12 });
  document.querySelectorAll('.reveal, .post-card').forEach(el => io.observe(el));

  // ===== FILTROS =====
  const filters = document.querySelectorAll('.bfilter');
  const posts = document.querySelectorAll('.post-card');
  filters.forEach(btn => btn.addEventListener('click', () => {
    filters.forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    const cat = btn.dataset.cat;
    posts.forEach(p => {
      const show = cat === 'all' || p.dataset.cat === cat;
      p.style.display = show ? 'flex' : 'none';
      if (show){ p.classList.remove('in'); requestAnimationFrame(()=>p.classList.add('in')); }
    });
  }));

  // ===== NEWSLETTER =====
  const btn = document.getElementById('newsBtn');
  if (btn) {
    const email = document.getElementById('newsEmail'), msg = document.getElementById('newsMsg');
    btn.addEventListener('click', () => {
      const v = email.value.trim();
      if (!/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(v)) { msg.style.color='#d91a2a'; msg.textContent='Escribe un correo válido para continuar.'; return; }
      msg.style.color='#2e8b7f'; msg.innerHTML='✅ ¡Listo! Te avisaremos en la próxima edición.'; email.value='';
    });
  }

  // ============================================================
  // FUNCIONALIDADES DEL ARTÍCULO (solo en vista de artículo)
  // ============================================================
  const postId = document.querySelector('.blog-page[data-post]');
  if (!postId) return;

  const postSlug = postId.dataset.post;
  const storageKey = 'nda_blog_' + postSlug;

  // ===== CARGAR DATOS GUARDADOS =====
  let savedData = {};
  try {
    const raw = localStorage.getItem(storageKey);
    if (raw) savedData = JSON.parse(raw);
  } catch(e) {}

  // ===== LECTURA =====
  // Barra de progreso
  const progressBar = document.getElementById('readingProgress');
  if (progressBar) {
    window.addEventListener('scroll', () => {
      const scrollTop = window.scrollY;
      const docHeight = document.documentElement.scrollHeight - window.innerHeight;
      const progress = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
      progressBar.style.width = Math.min(100, progress) + '%';
    });
  }

  // ===== SUBRAYAR =====
  const highlightBtn = document.querySelector('[data-action="highlight"]');
  if (highlightBtn) {
    highlightBtn.addEventListener('click', () => {
      const selection = window.getSelection();
      if (!selection.rangeCount || selection.isCollapsed) {
        highlightBtn.classList.toggle('active');
        return;
      }
      const range = selection.getRangeAt(0);
      const selectedText = range.toString().trim();
      if (!selectedText) return;

      // Verificar que la selección está dentro del artículo
      const artBody = document.getElementById('artBody');
      if (!artBody.contains(range.commonAncestorContainer)) return;

      const span = document.createElement('span');
      span.className = 'highlighted';
      span.textContent = selectedText;
      span.dataset.highlight = true;
      range.deleteContents();
      range.insertNode(span);

      // Guardar subrayado
      if (!savedData.highlights) savedData.highlights = [];
      savedData.highlights.push(selectedText);
      localStorage.setItem(storageKey, JSON.stringify(savedData));

      selection.removeAllRanges();
      highlightBtn.classList.add('active');
    });
  }

  // ===== ME GUSTA =====
  const likeBtn = document.getElementById('likeBtn');
  const likeCount = document.getElementById('likeCount');
  if (likeBtn && likeCount) {
    let likes = savedData.likes || 0;
    let liked = savedData.liked || false;
    likeCount.textContent = likes;

    if (liked) likeBtn.classList.add('active');

    likeBtn.addEventListener('click', () => {
      if (liked) {
        likes--;
        liked = false;
        likeBtn.classList.remove('active');
      } else {
        likes++;
        liked = true;
        likeBtn.classList.add('active');
      }
      likeCount.textContent = likes;
      savedData.likes = likes;
      savedData.liked = liked;
      localStorage.setItem(storageKey, JSON.stringify(savedData));
    });
  }

  // ===== GUARDAR ARTÍCULO =====
  const saveBtn = document.getElementById('saveBtn');
  if (saveBtn) {
    let saved = savedData.saved || false;
    if (saved) saveBtn.classList.add('active');

    saveBtn.addEventListener('click', () => {
      saved = !saved;
      saveBtn.classList.toggle('active');
      savedData.saved = saved;
      localStorage.setItem(storageKey, JSON.stringify(savedData));
      const msg = saved ? '📌 Artículo guardado en tu biblioteca' : '🗑️ Artículo eliminado de tu biblioteca';
      showToast(msg);
    });
  }

  // ===== REACCIONES CON EMOJIS =====
  const reactionBtns = document.querySelectorAll('.reaction-btn');
  reactionBtns.forEach(btn => {
    const emoji = btn.dataset.emoji;
    let count = savedData.reactions && savedData.reactions[emoji] ? savedData.reactions[emoji] : 0;
    const countSpan = btn.querySelector('.reaction-count');
    countSpan.textContent = count;

    // Verificar si el usuario ya reaccionó con este emoji
    const userReaction = savedData.userReaction || null;
    if (userReaction === emoji) btn.classList.add('active');

    btn.addEventListener('click', () => {
      const prevReaction = savedData.userReaction || null;

      // Si ya había una reacción previa del usuario, restarla
      if (prevReaction) {
        const prevBtn = document.querySelector(`.reaction-btn[data-emoji="${prevReaction}"]`);
        if (prevBtn) {
          let prevCount = savedData.reactions && savedData.reactions[prevReaction] ? savedData.reactions[prevReaction] : 0;
          prevCount = Math.max(0, prevCount - 1);
          savedData.reactions[prevReaction] = prevCount;
          const prevSpan = prevBtn.querySelector('.reaction-count');
          prevSpan.textContent = prevCount;
          prevBtn.classList.remove('active');
        }
      }

      // Si el usuario hace clic en el mismo emoji, desactivar
      if (prevReaction === emoji) {
        savedData.userReaction = null;
        localStorage.setItem(storageKey, JSON.stringify(savedData));
        btn.classList.remove('active');
        return;
      }

      // Agregar nueva reacción
      if (!savedData.reactions) savedData.reactions = {};
      count = (savedData.reactions[emoji] || 0) + 1;
      savedData.reactions[emoji] = count;
      savedData.userReaction = emoji;
      countSpan.textContent = count;
      btn.classList.add('active');
      localStorage.setItem(storageKey, JSON.stringify(savedData));
    });
  });

  // ===== EMOJIS EN NAVBAR =====
  document.querySelectorAll('.rtool-emoji').forEach(btn => {
    btn.addEventListener('click', () => {
      const emoji = btn.dataset.emoji;
      // Buscar si existe en la barra de reacciones y hacer clic
      const reactionBtn = document.querySelector(`.reaction-btn[data-emoji="${emoji}"]`);
      if (reactionBtn) {
        reactionBtn.click();
        showToast(`Reacción ${emoji} agregada`);
      }
    });
  });

  // ===== POST-IT INTERACTIVO =====
  const postit = document.getElementById('postitNote');
  const postitText = document.getElementById('postitText');
  if (postit && postitText) {
    const facts = [
      '💡 En los primeros 10 minutos de una emergencia, tus vecinos son tu mejor recurso.',
      '📌 El 80% de los sobrevivientes son rescatados por personas de su misma comunidad.',
      '⚠️ Tener un plan familiar reduce en un 60% el riesgo de lesiones graves.',
      '🔑 La comunicación clara salva más vidas que cualquier equipo de rescate.',
      '📢 Una colonia organizada puede evacuar en 5 minutos lo que aislada tomaría 30.',
      '💪 La preparación comunitaria es la clave para sobrevivir a cualquier desastre.'
    ];

    postit.addEventListener('click', () => {
      const currentText = postitText.textContent;
      let newText = facts[Math.floor(Math.random() * facts.length)];
      while (newText === currentText && facts.length > 1) {
        newText = facts[Math.floor(Math.random() * facts.length)];
      }
      postitText.textContent = newText;
      // Guardar el fact actual
      savedData.postitFact = newText;
      localStorage.setItem(storageKey, JSON.stringify(savedData));
    });

    // Cargar fact guardado
    if (savedData.postitFact) {
      postitText.textContent = savedData.postitFact;
    }
  }

  // ===== TOAST NOTIFICATIONS =====
  function showToast(message) {
    const existing = document.querySelector('.toast-notification');
    if (existing) existing.remove();

    const toast = document.createElement('div');
    toast.className = 'toast-notification';
    toast.textContent = message;
    Object.assign(toast.style, {
      position: 'fixed',
      bottom: '30px',
      left: '50%',
      transform: 'translateX(-50%) translateY(80px)',
      background: 'rgba(21,22,26,.95)',
      color: '#fff',
      padding: '14px 28px',
      borderRadius: '16px',
      fontSize: '.9rem',
      fontWeight: '600',
      border: '1px solid var(--border,#27272a)',
      boxShadow: '0 16px 60px rgba(0,0,0,.6)',
      backdropFilter: 'blur(16px)',
      zIndex: '9999',
      opacity: '0',
      transition: 'all .4s cubic-bezier(.16,1,.3,1)',
      fontFamily: 'inherit',
      maxWidth: '90%',
      textAlign: 'center'
    });
    document.body.appendChild(toast);
    requestAnimationFrame(() => {
      toast.style.opacity = '1';
      toast.style.transform = 'translateX(-50%) translateY(0)';
    });
    setTimeout(() => {
      toast.style.opacity = '0';
      toast.style.transform = 'translateX(-50%) translateY(20px)';
      setTimeout(() => toast.remove(), 400);
    }, 2500);
  }

  // ===== RESTAURAR SUBRAYADOS GUARDADOS =====
  if (savedData.highlights && savedData.highlights.length > 0) {
    const artBody = document.getElementById('artBody');
    if (artBody) {
      const text = artBody.innerHTML;
      savedData.highlights.forEach(textToHighlight => {
        // Buscar el texto en el contenido y subrayarlo
        const regex = new RegExp(textToHighlight.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'), 'g');
        if (regex.test(text)) {
          // Solo si no está ya subrayado
          const span = document.createElement('span');
          span.className = 'highlighted';
          span.textContent = textToHighlight;
          // Reemplazar usando un enfoque simple
          // Nota: Esto es simplificado, para una implementación completa se necesitaría un enfoque más robusto
        }
      });
    }
  }

});
</script>

<?php
$content = ob_get_clean();
require_once 'layout.php';
?>