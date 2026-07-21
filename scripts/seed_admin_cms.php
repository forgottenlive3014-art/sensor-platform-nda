<?php
if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    die('Solo CLI');
}

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../models/ContenidoModel.php';

$db = getDB();

// ============================================================
// BLOG: mismo contenido que hoy vive hardcodeado en views/blog.php
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

$BASE = 'assets/media/blog/';
$ARTICULOS = [
  '72-horas' => ['titulo'=>'Cómo preparar a tu familia en 72 horas','cat'=>'prevencion','tag'=>'Prevención','color'=>'#f29f05','autor'=>'Equipo NDA','tiempo'=>'6 min','destacado'=>true,'img'=>$BASE.'72-horas.jpg','extracto'=>'La regla de las primeras 72 horas puede marcar la diferencia. Qué hacer, paso a paso, antes de que llegue la próxima emergencia.','cuerpo'=>$b_72],
  'agachate' => ['titulo'=>'Agáchate, cúbrete y agárrate: la técnica que funciona','cat'=>'sismos','tag'=>'Sismos','color'=>'#f29f05','autor'=>'Equipo NDA','tiempo'=>'4 min','destacado'=>false,'img'=>$BASE.'agachate-cubrete....jpg','extracto'=>'Por qué tres segundos de reacción correcta valen más que correr. La ciencia detrás del protocolo.','cuerpo'=>$b_agachate],
  'lluvias'  => ['titulo'=>'Temporada de lluvias: señales que no debes ignorar','cat'=>'lluvias','tag'=>'Lluvias','color'=>'#2e7da6','autor'=>'Equipo NDA','tiempo'=>'5 min','destacado'=>false,'img'=>$BASE.'lluvias.jpg','extracto'=>'Quebradas que crecen, suelos saturados y ese olor a tierra mojada. Aprende a leer el riesgo.','cuerpo'=>$b_lluvias],
  'mochila'  => ['titulo'=>'Tu mochila de emergencia en 10 objetos','cat'=>'prevencion','tag'=>'Prevención','color'=>'#2e8b7f','autor'=>'Equipo NDA','tiempo'=>'3 min','destacado'=>false,'img'=>$BASE.'mochila.jpg','extracto'=>'Sin gastar de más. La lista mínima que cualquier hogar salvadoreño debería tener lista hoy.','cuerpo'=>$b_mochila],
  'vecinos'  => ['titulo'=>'Vecinos organizados: el primer equipo de rescate','cat'=>'comunidad','tag'=>'Comunidad','color'=>'#f2b705','autor'=>'Equipo NDA','tiempo'=>'7 min','destacado'=>false,'img'=>$BASE.'vecinos.jpg','extracto'=>'Cómo una colonia de Soyapango montó su propio plan de evacuación en un fin de semana.','cuerpo'=>$b_vecinos],
  'simulacro'=> ['titulo'=>'"El simulacro nos salvó": la historia de una escuela','cat'=>'testimonios','tag'=>'Testimonio','color'=>'#d91a2a','autor'=>'Equipo NDA','tiempo'=>'6 min','destacado'=>false,'img'=>$BASE.'simulacro.jpg','extracto'=>'Practicaron tantas veces que cuando tembló de verdad, nadie dudó. Un relato en primera persona.','cuerpo'=>$b_simulacro],
  'punto'    => ['titulo'=>'El punto de reunión que toda familia necesita','cat'=>'prevencion','tag'=>'Prevención','color'=>'#6a6fb5','autor'=>'Equipo NDA','tiempo'=>'4 min','destacado'=>false,'img'=>$BASE.'punto.jpg','extracto'=>'Si se pierde la señal y nadie sabe dónde está el otro, este simple acuerdo lo resuelve.','cuerpo'=>$b_punto],

  'noticia-2001-enero' => ['titulo'=>'Terremoto de 7.7 sacude El Salvador (2001)','cat'=>'sismos','tag'=>'Sismo Histórico','color'=>'#d91a2a','autor'=>'La Prensa Gráfica','tiempo'=>'5 min','destacado'=>false,'img'=>$BASE.'terremoto2001.jpg','extracto'=>'El 13 de enero de 2001, el terremoto más fuerte desde 1986 dejó 844 muertos.','cuerpo'=>$n_2001_enero],
  'noticia-2005' => ['titulo'=>'Erupción del volcán Santa Ana (2005)','cat'=>'volcanes','tag'=>'Volcán Histórico','color'=>'#f29f05','autor'=>'El Diario de Hoy','tiempo'=>'4 min','destacado'=>false,'img'=>$BASE.'santaAna2005.jpg','extracto'=>'El 1 de octubre de 2005, el volcán Santa Ana entró en erupción evacuando a 2,000 personas.','cuerpo'=>$n_2005],
  'noticia-2009' => ['titulo'=>'Tormenta Ida: 198 muertos en 2009','cat'=>'lluvias','tag'=>'Inundación Histórica','color'=>'#2e7da6','autor'=>'La Prensa Gráfica','tiempo'=>'4 min','destacado'=>false,'img'=>$BASE.'tormentaIda2009.jpg','extracto'=>'El 8 de noviembre de 2009, la tormenta Ida dejó 198 muertos y 15,000 damnificados.','cuerpo'=>$n_2009],
  'noticia-2011' => ['titulo'=>'Depresión Tropical 12-E (2011)','cat'=>'lluvias','tag'=>'Inundación Histórica','color'=>'#2e7da6','autor'=>'El Diario de Hoy','tiempo'=>'4 min','destacado'=>false,'img'=>$BASE.'depreTropical2011.jpg','extracto'=>'En octubre de 2011, la DT 12-E dejó 34 muertos y 50,000 damnificados.','cuerpo'=>$n_2011],
  'noticia-2020-amanda' => ['titulo'=>'Tormenta Amanda (2020)','cat'=>'lluvias','tag'=>'Inundación Reciente','color'=>'#2e7da6','autor'=>'El Diario de Hoy','tiempo'=>'4 min','destacado'=>false,'img'=>$BASE.'Amanda2020.jpg','extracto'=>'El 30 de mayo de 2020, Amanda golpeó en plena pandemia: 31 muertos.','cuerpo'=>$n_2020_amanda],
  'noticia-2020-cristobal' => ['titulo'=>'Cristóbal mantiene las lluvias (2020)','cat'=>'lluvias','tag'=>'Inundación Reciente','color'=>'#2e7da6','autor'=>'La Prensa Gráfica','tiempo'=>'3 min','destacado'=>false,'img'=>$BASE.'Cristobal2020.jpg','extracto'=>'El 2 de junio de 2020, Cristóbal prolongó la emergencia tras Amanda.','cuerpo'=>$n_2020_cristobal],
  'noticia-2022' => ['titulo'=>'Huracán Julia: 4,000 evacuados','cat'=>'huracanes','tag'=>'Huracán Reciente','color'=>'#1a7a7a','autor'=>'El Diario de Hoy','tiempo'=>'4 min','destacado'=>false,'img'=>$BASE.'HJulia2022.jpg','extracto'=>'El 9 de octubre de 2022, Julia dejó 4,000 evacuados y daños en carreteras.','cuerpo'=>$n_2022],
  'noticia-2026-enero' => ['titulo'=>'Sismo de 4.1 frente a La Libertad (2026)','cat'=>'sismos','tag'=>'Sismo Reciente','color'=>'#d91a2a','autor'=>'El Diario de Hoy','tiempo'=>'2 min','destacado'=>false,'img'=>$BASE.'sismoEnero2026.jpg','extracto'=>'El 10 de enero de 2026, un sismo de 4.1 fue percibido en San Salvador.','cuerpo'=>$n_2026_enero],
];

$stmtCheckBlog = $db->prepare('SELECT COUNT(*) FROM blog WHERE slug = ?');
$stmtInsertBlog = $db->prepare(
    'INSERT INTO blog (slug, titulo, cat, tag, color, autor_nombre, tiempo, destacado, extracto, imagen, cuerpo)
     VALUES (:slug, :titulo, :cat, :tag, :color, :autor, :tiempo, :destacado, :extracto, :imagen, :cuerpo)'
);

$blogInsertados = 0;
foreach ($ARTICULOS as $slug => $a) {
    $stmtCheckBlog->execute([$slug]);
    if ($stmtCheckBlog->fetchColumn() > 0) {
        continue;
    }
    $stmtInsertBlog->execute([
        ':slug' => $slug,
        ':titulo' => $a['titulo'],
        ':cat' => $a['cat'],
        ':tag' => $a['tag'],
        ':color' => $a['color'],
        ':autor' => $a['autor'],
        ':tiempo' => $a['tiempo'],
        ':destacado' => $a['destacado'] ? 1 : 0,
        ':extracto' => $a['extracto'],
        ':imagen' => $a['img'],
        ':cuerpo' => $a['cuerpo'],
    ]);
    $blogInsertados++;
}
echo "Blog: $blogInsertados artículos insertados.\n";

// ============================================================
// RECURSOS: los 9 PDFs actuales de assets/media/guias/
// ============================================================

$RECURSOS = [
    ['titulo' => 'Evacuación Escolar', 'categoria' => 'evacuacion', 'tags' => 'Evacuación,Escolar', 'archivo' => 'assets/media/guias/Evacuacion escolar.pdf', 'descripcion' => 'Guía completa para la evacuación en instituciones educativas. Incluye protocolos y rutas seguras.'],
    ['titulo' => 'Cartilla Evacuación Escolar', 'categoria' => 'evacuacion', 'tags' => 'Evacuación,Cartilla', 'archivo' => 'assets/media/guias/Evacuacion escolarnCartilla-Guia-de-evacuacion-Escolar-1.pdf', 'descripcion' => 'Cartilla ilustrada con pasos a seguir durante una evacuación escolar. Material educativo para niños y docentes.'],
    ['titulo' => 'Mochila de Emergencia', 'categoria' => 'mochila', 'tags' => 'Mochila,Emergencia', 'archivo' => 'assets/media/guias/Mochila emergencia.pdf', 'descripcion' => 'Lista completa de suministros esenciales para tu mochila de emergencia. Agua, alimentos, herramientas y más.'],
    ['titulo' => 'Kit de Emergencia', 'categoria' => 'mochila', 'tags' => 'Kit,72 horas', 'archivo' => 'assets/media/guias/Mochila emergencia2.pdf', 'descripcion' => 'Versión resumida del kit de emergencia con los elementos más importantes para sobrevivir 72 horas.'],
    ['titulo' => 'Plan Familiar de Emergencia', 'categoria' => 'plan', 'tags' => 'Plan Familiar,Emergencia', 'archivo' => 'assets/media/guias/Plan familiar.pdf', 'descripcion' => 'Guía para crear un plan familiar ante desastres. Incluye roles, puntos de reunión y comunicación.'],
    ['titulo' => 'Plan Familiar - Versión 2', 'categoria' => 'plan', 'tags' => 'Plan Familiar,Checklist', 'archivo' => 'assets/media/guias/plan familiar(1).pdf', 'descripcion' => 'Complemento del plan familiar con checklist, contactos de emergencia y mapa de riesgos locales.'],
    ['titulo' => 'Preparación ante Sismos', 'categoria' => 'sismo', 'tags' => 'Sismos,Prevención', 'archivo' => 'assets/media/guias/Preparacion ante sismos.pdf', 'descripcion' => 'Guía completa sobre cómo prepararse, actuar y recuperarse después de un sismo. Información del MARN y Cruz Roja.'],
    ['titulo' => 'Protocolo Lluvias', 'categoria' => 'lluvias', 'tags' => 'Lluvias,Inundaciones', 'archivo' => 'assets/media/guias/Protocolo lluvias.pdf', 'descripcion' => 'Protocolo de actuación ante lluvias intensas e inundaciones. Medidas de prevención y protección.'],
    ['titulo' => 'Protocolo Lluvias - V.2', 'categoria' => 'lluvias', 'tags' => 'Lluvias,Actualización', 'archivo' => 'assets/media/guias/Protocolo lluvias2.pdf', 'descripcion' => 'Actualización del protocolo con nuevas medidas y recomendaciones para temporada de lluvias en El Salvador.'],
    ['titulo' => 'Movimientos de Ladera', 'categoria' => 'lluvias', 'tags' => 'Deslizamientos,Prevención', 'archivo' => 'assets/media/guias/2013_ElSalvador2_movimientos_laderas.pdf', 'descripcion' => 'Guía sobre deslizamientos y movimientos de ladera en El Salvador: causas, señales de alerta y medidas de prevención.'],
    ['titulo' => 'Eventos Meteorológicos Extremos', 'categoria' => 'lluvias', 'tags' => 'Clima,Prevención', 'archivo' => 'assets/media/guias/2013_ElSalvador7_eventos_meteorol_extremos.pdf', 'descripcion' => 'Guía sobre eventos meteorológicos extremos en El Salvador y cómo prepararse ante ellos.'],
    ['titulo' => 'Guía Metodológica para Docentes', 'categoria' => 'evacuacion', 'tags' => 'Docentes,Educación', 'archivo' => 'assets/media/guias/Guía metodológica para docentes.pdf', 'descripcion' => 'Guía metodológica dirigida a docentes para la enseñanza de la gestión de riesgos y preparación ante desastres.'],
    ['titulo' => 'Afiche Simulacro 2018', 'categoria' => 'evacuacion', 'tags' => 'Simulacro,Afiche', 'archivo' => 'assets/media/guias/Simulacro2018-Afiche2.pdf', 'descripcion' => 'Afiche informativo del simulacro nacional 2018 con las pautas básicas de evacuación.'],
];

$stmtCheckRecurso = $db->prepare('SELECT COUNT(*) FROM recursos WHERE archivo = ?');
$stmtInsertRecurso = $db->prepare(
    'INSERT INTO recursos (titulo, descripcion, categoria, tags, archivo, tamano_bytes, orden)
     VALUES (:titulo, :descripcion, :categoria, :tags, :archivo, :tamano, :orden)'
);

$recursosInsertados = 0;
foreach ($RECURSOS as $i => $r) {
    $stmtCheckRecurso->execute([$r['archivo']]);
    if ($stmtCheckRecurso->fetchColumn() > 0) {
        continue;
    }
    $rutaAbsoluta = __DIR__ . '/../' . $r['archivo'];
    $tamano = file_exists($rutaAbsoluta) ? filesize($rutaAbsoluta) : null;
    $stmtInsertRecurso->execute([
        ':titulo' => $r['titulo'],
        ':descripcion' => $r['descripcion'],
        ':categoria' => $r['categoria'],
        ':tags' => $r['tags'],
        ':archivo' => $r['archivo'],
        ':tamano' => $tamano,
        ':orden' => $i,
    ]);
    $recursosInsertados++;
}
echo "Recursos: $recursosInsertados PDFs insertados.\n";

// ============================================================
// CONTENIDO: "Qué hacer ahora" y "Acerca de NDA"
// ============================================================

$stmtUpsertContenido = $db->prepare(
    'INSERT INTO contenido_paginas (pagina, campo, valor) VALUES (:pagina, :campo, :valor)
     ON DUPLICATE KEY UPDATE valor = valor'
);

$contenidoInsertados = 0;
foreach (['quehacer' => ContenidoModel::quehacerFieldDefs(), 'acercade' => ContenidoModel::acercadeFieldDefs()] as $pagina => $defs) {
    foreach ($defs as $def) {
        $stmtUpsertContenido->execute([
            ':pagina' => $pagina,
            ':campo' => $def['campo'],
            ':valor' => $def['default'],
        ]);
        $contenidoInsertados++;
    }
}
echo "Contenido: $contenidoInsertados campos procesados (quehacer + acercade).\n";

echo "Listo.\n";
