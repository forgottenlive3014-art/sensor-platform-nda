<?php
/* ===========================================================
   BLOG NDA  ·  lista + artículo, con FOTOGRAFÍAS reales
   - Lista:    ?url=blog
   - Artículo: ?url=blog&post=SLUG
   Imágenes en: assets/media/blog/SLUG.jpg  (ver guía al final)
   Si una imagen falta, queda un fondo de color elegante.
   =========================================================== */

$title = $title ?? 'Blog - NDA';

<<<<<<< Updated upstream
/* ---------- CUERPOS DE LOS ARTÍCULOS ---------- */
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

/* ---------- METADATOS ('img' = foto local; 'color' = respaldo si falta) ---------- */
$BASE = 'assets/media/blog/';
$ARTÍCULOS = [
  '72-horas' => ['titulo'=>'Cómo preparar a tu familia en 72 horas','cat'=>'prevencion','tag'=>'Prevención','color'=>'#f29f05','autor'=>'Equipo NDA','tiempo'=>'6 min','destacado'=>true,'img'=>$BASE.'72-horas.jpg','extracto'=>'La regla de las primeras 72 horas puede marcar la diferencia. Qué hacer, paso a paso, antes de que llegue la próxima emergencia.','cuerpo'=>$b_72],
  'agachate' => ['titulo'=>'Agáchate, cúbrete y agárrate: la técnica que funciona','cat'=>'sismos','tag'=>'Sismos','color'=>'#f29f05','autor'=>'Equipo NDA','tiempo'=>'4 min','destacado'=>false,'img'=>$BASE.'agachate.jpg','extracto'=>'Por qué tres segundos de reacción correcta valen más que correr. La ciencia detrás del protocolo.','cuerpo'=>$b_agachate],
  'lluvias'  => ['titulo'=>'Temporada de lluvias: señales que no debes ignorar','cat'=>'lluvias','tag'=>'Lluvias','color'=>'#2e7da6','autor'=>'Equipo NDA','tiempo'=>'5 min','destacado'=>false,'img'=>$BASE.'lluvias.jpg','extracto'=>'Quebradas que crecen, suelos saturados y ese olor a tierra mojada. Aprende a leer el riesgo.','cuerpo'=>$b_lluvias],
  'mochila'  => ['titulo'=>'Tu mochila de emergencia en 10 objetos','cat'=>'prevencion','tag'=>'Prevención','color'=>'#2e8b7f','autor'=>'Equipo NDA','tiempo'=>'3 min','destacado'=>false,'img'=>$BASE.'mochila.jpg','extracto'=>'Sin gastar de más. La lista mínima que cualquier hogar salvadoreño debería tener lista hoy.','cuerpo'=>$b_mochila],
  'vecinos'  => ['titulo'=>'Vecinos organizados: el primer equipo de rescate','cat'=>'comunidad','tag'=>'Comunidad','color'=>'#f2b705','autor'=>'Equipo NDA','tiempo'=>'7 min','destacado'=>false,'img'=>$BASE.'vecinos.jpg','extracto'=>'Cómo una colonia de Soyapango montó su propio plan de evacuación en un fin de semana.','cuerpo'=>$b_vecinos],
  'simulacro'=> ['titulo'=>'"El simulacro nos salvó": la historia de una escuela','cat'=>'testimonios','tag'=>'Testimonio','color'=>'#d91a2a','autor'=>'Equipo NDA','tiempo'=>'6 min','destacado'=>false,'img'=>$BASE.'simulacro.jpg','extracto'=>'Practicaron tantas veces que cuando tembló de verdad, nadie dudó. Un relato en primera persona.','cuerpo'=>$b_simulacro],
  'punto'    => ['titulo'=>'El punto de reunión que toda familia necesita','cat'=>'prevencion','tag'=>'Prevención','color'=>'#6a6fb5','autor'=>'Equipo NDA','tiempo'=>'4 min','destacado'=>false,'img'=>$BASE.'punto.jpg','extracto'=>'Si se pierde la señal y nadie sabe dónde está el otro, este simple acuerdo lo resuelve.','cuerpo'=>$b_punto],
];

/* iconos SVG reutilizables (sin emojis) */
=======
// ============================================================
// CONFIGURACIÓN DEL BLOG (contenido gestionado por el Admin General
// desde el panel de Gestión Escolar > Blog público)
// ============================================================

require_once __DIR__ . '/../models/ArticuloModel.php';
$ARTÍCULOS = (new ArticuloModel())->getAllForPublic();

// ============================================================
// ÍCONOS Y FUNCIONES
// ============================================================

>>>>>>> Stashed changes
$icoUser = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><circle cx="12" cy="8" r="3.2"/><path d="M5 20c0-3.6 3.1-5.5 7-5.5s7 1.9 7 5.5"/></svg>';
$icoClock = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><circle cx="12" cy="12" r="8.2"/><path d="M12 7.5V12l3 1.8"/></svg>';

$slug = isset($_GET['post']) ? $_GET['post'] : null;
$post = ($slug !== null && isset($ARTÍCULOS[$slug])) ? $ARTÍCULOS[$slug] : null;
if ($post) { $title = $post['titulo'] . ' - NDA'; }

ob_start();
?>

<?php if ($post): /* ===================== ARTÍCULO ===================== */ ?>
<div class="blog-page" data-no-anim>
  <div class="wrap" style="padding-top:80px; padding-bottom:60px; max-width:780px;">

    <a href="?url=blog" class="art-back reveal"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg> Volver al blog</a>

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

    <article class="art-body reveal"><?= $post['cuerpo'] ?></article>

    <div class="art-more reveal">
      <h3>Sigue leyendo</h3>
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

<?php else: /* ===================== LISTA ===================== */ ?>
<div class="blog-page" data-no-anim>
  <div class="wrap" style="padding-top:80px; padding-bottom:60px;">

    <div class="blog-head reveal">
      <span class="kicker">REVISTA NDA · EDICIÓN VIVA</span>
      <h1 class="blog-title">Historias que <span class="grad">salvan vidas</span></h1>
      <p class="blog-intro">Reportajes, guías y testimonios sobre prevención de desastres en El Salvador. Información clara, visual y lista para actuar.</p>
    </div>

<<<<<<< Updated upstream
    <?php $f = $ARTÍCULOS['72-horas']; ?>
    <a class="featured reveal" href="?url=blog&post=72-horas">
=======
    <?php if (empty($ARTÍCULOS)): ?>
      <p class="school-hint" style="text-align:center;padding:40px 0;">Todavía no hay artículos publicados. El Admin General puede agregarlos desde Gestión Escolar &rsaquo; Blog público.</p>
    <?php else: ?>
    <?php
      $featuredSlug = null;
      foreach ($ARTÍCULOS as $s => $a) { if (!empty($a['destacado'])) { $featuredSlug = $s; break; } }
      if ($featuredSlug === null) { $featuredSlug = array_key_first($ARTÍCULOS); }
      $f = $ARTÍCULOS[$featuredSlug];
    ?>
    <a class="featured reveal" href="?url=blog&post=<?= urlencode($featuredSlug) ?>">
>>>>>>> Stashed changes
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
      <button class="bfilter" data-cat="lluvias">Lluvias</button>
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
            <div class="post-meta"><span class="mi"><?= $icoClock ?><?= htmlspecialchars($a['tiempo']) ?></span><span class="read-more">Leer <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></span></div>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

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

/* meta con iconos svg */
.mi{ display:inline-flex; align-items:center; gap:6px; }
.mi svg{ width:15px; height:15px; opacity:.8; }
.dot{ width:3px; height:3px; border-radius:50%; background:currentColor; opacity:.5; display:inline-block; }

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
.read-more{ color:var(--accent); font-weight:700; transition:transform .2s; }
.post-card:hover .read-more{ transform:translateX(4px); }

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
.art-back{ display:inline-block; color:var(--text2,#a1a1aa); text-decoration:none; font-size:.9rem; margin-bottom:24px; transition:color .2s, transform .2s; }
.art-back:hover{ color:#f29f05; transform:translateX(-3px); }
.art-hero{ margin-bottom:34px; }
.art-cover{ position:relative; height:340px; border-radius:22px; background-size:cover; background-position:center; overflow:hidden; margin-bottom:26px; }
.art-cover::after{ content:""; position:absolute; inset:0; background:linear-gradient(to top, rgba(8,10,14,.5), transparent 50%); }
.art-tag{ position:absolute; top:18px; left:18px; z-index:1; background:rgba(8,10,14,.55); color:#fff; backdrop-filter:blur(8px); font-size:.72rem; font-weight:700; letter-spacing:.5px; padding:6px 15px; border-radius:100px; border:1px solid rgba(255,255,255,.14); }
.art-title{ font-size:clamp(1.9rem,4.5vw,3rem); font-weight:900; line-height:1.1; color:var(--text1,var(--text,#fff)); margin:0 0 16px; letter-spacing:-.02em; }
.art-meta{ display:flex; gap:12px; align-items:center; flex-wrap:wrap; color:var(--text3,#71717a); font-size:.88rem; }

.art-body{ font-size:1.08rem; line-height:1.85; color:var(--text2,#c4c4cc); }
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

.art-more{ margin-top:54px; padding-top:32px; border-top:1px solid var(--border,#27272a); }
.art-more h3{ font-size:1.3rem; font-weight:900; color:var(--text1,var(--text,#fff)); margin:0 0 20px; letter-spacing:-.01em; }
.art-more-grid{ display:grid; grid-template-columns:repeat(auto-fill,minmax(210px,1fr)); gap:16px; }
.art-more-card{ display:flex; flex-direction:column; gap:10px; background:var(--card,#15161a); border:1px solid var(--border,#27272a); border-radius:16px; overflow:hidden; padding-bottom:16px; text-decoration:none; transition:transform .25s, border-color .25s; }
.art-more-card:hover{ transform:translateY(-4px); border-color:var(--c); }
.amc-img{ height:110px; background-size:cover; background-position:center; }
.amc-tag{ font-size:.66rem; font-weight:700; color:var(--c); text-transform:uppercase; letter-spacing:1px; padding:0 16px; }
.art-more-card strong{ color:var(--text1,var(--text,#fff)); font-size:.96rem; line-height:1.3; padding:0 16px; }

/* reveal propio */
.reveal{ opacity:0; transform:translateY(28px); transition:opacity .7s ease, transform .7s ease; }
.reveal.in{ opacity:1; transform:none; }
@keyframes floaty{ 0%,100%{ transform:translateX(-50%) translateY(0);} 50%{ transform:translateX(-50%) translateY(20px);} }
@media (prefers-reduced-motion: reduce){ .reveal{opacity:1!important;transform:none!important;} .news-glow,.featured-img{animation:none;} }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const io = new IntersectionObserver((entries) => {
    entries.forEach((e,i) => { if(e.isIntersecting){ setTimeout(()=>e.target.classList.add('in'),(i%6)*80); io.unobserve(e.target);} });
  }, { threshold: 0.12 });
  document.querySelectorAll('.reveal, .post-card').forEach(el => io.observe(el));

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

  const btn = document.getElementById('newsBtn');
  if (btn) {
    const email = document.getElementById('newsEmail'), msg = document.getElementById('newsMsg');
    btn.addEventListener('click', () => {
      const v = email.value.trim();
      if (!/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(v)) { msg.style.color='#d91a2a'; msg.textContent='Escribe un correo válido para continuar.'; return; }
      msg.style.color='#2e8b7f'; msg.textContent='<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><polyline points="20 6 9 17 4 12"/></svg> ¡Listo! Te avisaremos en la próxima edición.'; email.value='';
    });
  }
});
</script>

<?php
$content = ob_get_clean();
require_once 'layout.php';
?>
