<?php
/* Lista: ?url=blog · Artículo: ?url=blog&post=SLUG. Si falta la imagen en
   assets/media/blog/SLUG.jpg, se usa el color de respaldo del artículo. */

$title = $title ?? 'Blog - NDA';

// ============================================================
// CONFIGURACIÓN DEL BLOG (contenido gestionado por el Admin General
// desde el panel de Gestión Escolar > Blog público)
// ============================================================

require_once __DIR__ . '/../models/ArticuloModel.php';
$ARTÍCULOS = (new ArticuloModel())->getAllForPublic();

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
      <?php foreach ($ARTÍCULOS as $s=>$a): if ($s === $featuredSlug) continue; ?>
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