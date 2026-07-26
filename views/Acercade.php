<?php
$title = $title ?? 'Acerca de NDA';

require_once __DIR__ . '/../models/ContenidoModel.php';

$acercadeDefs = ContenidoModel::acercadeFieldDefs();
$acercadeSaved = (new ContenidoModel())->getByPage('acercade');
$A = [];
foreach ($acercadeDefs as $def) {
    $A[$def['campo']] = $acercadeSaved[$def['campo']] ?? $def['default'];
}
$statSuffixes = ['', '', '', '%'];

ob_start();
?>

<div class="about-page">
    <div class="wrap" style="padding-top:80px; padding-bottom:60px;">

        <div class="about-hero reveal">
            <div class="about-glow"></div>
            <span class="kicker"><?= htmlspecialchars($A['hero.kicker']) ?></span>
            <?php
                // Se parte en 2 lineas en la primera coma (ej. "Preparar a El
                // Salvador, un hogar a la vez") para que no quede todo en una
                // sola linea larga. Si el texto no trae coma, se muestra normal.
                $heroTituloPartes = explode(',', $A['hero.titulo'], 2);
            ?>
            <h1 class="grad">
                <?= htmlspecialchars(trim($heroTituloPartes[0])) ?><?= isset($heroTituloPartes[1]) ? ',' : '' ?>
                <?php if (isset($heroTituloPartes[1])): ?><br><?= htmlspecialchars(trim($heroTituloPartes[1])) ?><?php endif; ?>
            </h1>
            <p><?= htmlspecialchars($A['hero.texto']) ?></p>
        </div>

        <div class="stats reveal">
            <?php for ($i = 0; $i < 4; $i++): ?>
            <div class="stat"><span class="stat-num" data-target="<?= (int) $A["stats.$i.target"] ?>" <?= $statSuffixes[$i] ? 'data-suffix="' . $statSuffixes[$i] . '"' : '' ?>>0</span><span class="stat-label"><?= htmlspecialchars($A["stats.$i.label"]) ?></span></div>
            <?php endfor; ?>
        </div>

        <div class="mv-grid">
            <div class="mv-card reveal" style="--c:#f29f05;">
                <span class="mv-icon"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="5"/><circle cx="12" cy="12" r="1"/></svg></span>
                <h3>Nuestra misión</h3>
                <p><?= htmlspecialchars($A['mision.texto']) ?></p>
            </div>
            <div class="mv-card reveal" style="--c:#2e8b7f;">
                <span class="mv-icon"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><line x1="3" y1="21" x2="10" y2="14"/><path d="M8 12l10-6 3 3-6 10z"/></svg></span>
                <h3>Nuestra visión</h3>
                <p><?= htmlspecialchars($A['vision.texto']) ?></p>
            </div>
        </div>

        <div class="offer reveal">
            <h2 class="section-h">Lo que encuentras en NDA</h2>
            <div class="offer-grid">
                <a href="?url=resources" class="offer-card" style="--c:#f29f05;">
                    <span class="o-emoji"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M12 14l9-5-9-5-9 5 9 5z"/><path d="M3 9v6c0 1.5 4 3 9 3s9-1.5 9-3V9"/></svg></span><b>Recursos</b><small>Guías y PDFs descargables</small>
                </a>
                <a href="?url=quehacer" class="offer-card" style="--c:#d91a2a;">
                    <span class="o-emoji"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.7 21a2 2 0 0 1-3.4 0"/></svg></span><b>¿Qué hacer AHORA?</b><small>Pasos de acción inmediata</small>
                </a>
                <a href="?url=juegos" class="offer-card" style="--c:#2e8b7f;">
                    <span class="o-emoji"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><rect x="2" y="7" width="20" height="10" rx="4"/><line x1="7" y1="10" x2="7" y2="14"/><line x1="5" y1="12" x2="9" y2="12"/><circle cx="16" cy="10.5" r="1"/><circle cx="18.5" cy="13" r="1"/></svg></span><b>Juegos</b><small>Aprende jugando</small>
                </a>
                <a href="?url=blog" class="offer-card" style="--c:#2e7da6;">
                    <span class="o-emoji"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M4 4h13a2 2 0 0 1 2 2v13a2 2 0 0 1-2 2H4z"/><path d="M4 4v16h-1a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1z"/><line x1="7" y1="8" x2="15" y2="8"/><line x1="7" y1="12" x2="15" y2="12"/><line x1="7" y1="16" x2="11" y2="16"/></svg></span><b>Blog</b><small>Reportajes y testimonios</small>
                </a>
            </div>
        </div>

        <div class="timeline-wrap reveal">
            <h2 class="section-h">Cómo te acompañamos</h2>
            <div class="timeline">
                <?php for ($i = 0; $i < 4; $i++): ?>
                <div class="tl-item reveal"><span class="tl-dot"><?= $i + 1 ?></span>
                    <div class="tl-card"><b><?= htmlspecialchars($A["timeline.$i.titulo"]) ?></b><span><?= htmlspecialchars($A["timeline.$i.texto"]) ?></span></div></div>
                <?php endfor; ?>
            </div>
        </div>

        <div class="values reveal">
            <h2 class="section-h">En lo que creemos</h2>
            <div class="values-grid">
                <?php
                $valorIcons = [
                    '<path d="M11 17l-4-4a2 2 0 0 1 3-3l3 3M14 20l6-6-3-3-6 6M2 14l4 4"/>',
                    '<circle cx="12" cy="12" r="10"/><polyline points="8 12 11 15 16 9"/>',
                    '<path d="M9 18h6M10 22h4M12 2a7 7 0 0 0-4 12.7c.5.4.9 1 .9 1.6V17h6.2v-.7c0-.6.4-1.2.9-1.6A7 7 0 0 0 12 2z"/>',
                    '<polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>',
                ];
                for ($i = 0; $i < 4; $i++):
                ?>
                <div class="value-card"><span><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><?= $valorIcons[$i] ?></svg></span><b><?= htmlspecialchars($A["valores.$i.titulo"]) ?></b><p><?= htmlspecialchars($A["valores.$i.texto"]) ?></p></div>
                <?php endfor; ?>
            </div>
        </div>

        <div class="about-cta reveal">
            <div class="cta-glow"></div>
            <h2><?= htmlspecialchars($A['cta.titulo']) ?></h2>
            <p><?= htmlspecialchars($A['cta.texto']) ?></p>
            <div class="cta-btns">
                <a href="?url=resources" class="cta-primary">Ver recursos</a>
                <a href="?url=quehacer" class="cta-secondary">¿Qué hacer ahora?</a>
            </div>
        </div>

    </div>
</div>

<style>
.about-page .kicker{ display:inline-block; font-size:.72rem; letter-spacing:3px; font-weight:800; color:#f29f05; background:rgba(242, 159, 5,.12); padding:6px 14px; border-radius:100px; margin-bottom:14px; }
.about-page .grad{ background:linear-gradient(135deg,#f29f05,#c2441c); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
.section-h{ font-family:var(--fd); font-size:1.7rem; font-weight:900; color:var(--text); text-align:center; margin:0 0 26px; }

/* HERO */
.about-hero{ position:relative; text-align:center; padding:50px 24px; margin-bottom:34px; overflow:hidden; border-radius:26px; border:1px solid var(--border); background:var(--card); }
.about-glow{ position:absolute; top:-40%; left:50%; transform:translateX(-50%); width:520px; height:520px; background:radial-gradient(circle, rgba(242, 159, 5,.22), transparent 70%); pointer-events:none; animation:floaty 7s ease-in-out infinite; }
.about-hero h1{ position:relative; font-family:var(--fd); font-size:clamp(2rem,5.5vw,3.4rem); font-weight:900; color:var(--text); margin:0 0 14px; line-height:1.1; }
.about-hero p{ position:relative; color:var(--text2); max-width:600px; margin:0 auto; font-size:1.1rem; line-height:1.6; }

/* STATS */
.stats{ display:grid; grid-template-columns:repeat(auto-fit,minmax(150px,1fr)); gap:16px; margin-bottom:40px; }
.stat{ background:var(--card); border:1px solid var(--border); border-radius:18px; padding:26px 16px; text-align:center; transition:transform .2s, border-color .2s; }
.stat:hover{ transform:translateY(-4px); border-color:rgba(242, 159, 5,.4); }
.stat-num{ display:block; font-size:2.6rem; font-weight:900; background:linear-gradient(135deg,#f29f05,#2e8b7f); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
.stat-label{ color:var(--text2); font-size:.85rem; }

/* MISIÓN / VISIÓN */
.mv-grid{ display:grid; grid-template-columns:repeat(auto-fit,minmax(280px,1fr)); gap:20px; margin-bottom:44px; }
.mv-card{ background:var(--card); border:1px solid var(--border); border-left:4px solid var(--c); border-radius:18px; padding:28px; transition:transform .2s, box-shadow .2s; }
.mv-card:hover{ transform:translateY(-4px); box-shadow:0 14px 40px rgba(0,0,0,.28); }
.mv-icon{ font-size:2.4rem; display:block; margin-bottom:10px; }
.mv-card h3{ font-family:var(--fd); font-size:1.3rem; font-weight:900; color:var(--text); margin:0 0 10px; }
.mv-card p{ color:var(--text2); line-height:1.65; margin:0; }

/* OFFER */
.offer{ margin-bottom:44px; }
.offer-grid{ display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:16px; }
.offer-card{ display:flex; flex-direction:column; align-items:center; text-align:center; gap:4px; background:var(--card); border:1.5px solid var(--border); border-radius:18px; padding:26px 16px; text-decoration:none; transition:all .25s; }
.offer-card:hover{ transform:translateY(-6px); border-color:var(--c); box-shadow:0 14px 36px color-mix(in srgb, var(--c) 22%, transparent); }
.o-emoji{ font-size:2.6rem; transition:transform .3s; }
.offer-card:hover .o-emoji{ transform:scale(1.18) rotate(-6deg); }
.offer-card b{ color:var(--text); font-size:1.05rem; }
.offer-card small{ color:var(--text3); font-size:.8rem; }

/* TIMELINE */
.timeline-wrap{ margin-bottom:44px; }
.timeline{ position:relative; max-width:640px; margin:0 auto; padding-left:8px; }
.timeline::before{ content:""; position:absolute; left:27px; top:10px; bottom:10px; width:2px; background:linear-gradient(180deg,#f29f05,#2e8b7f); }
.tl-item{ display:flex; gap:18px; align-items:flex-start; margin-bottom:18px; position:relative; }
.tl-dot{ flex-shrink:0; width:38px; height:38px; border-radius:50%; background:linear-gradient(135deg,#f29f05,#c2441c); color:#fff; font-weight:900; display:flex; align-items:center; justify-content:center; z-index:1; box-shadow:0 4px 14px rgba(242, 159, 5,.35); }
.tl-card{ background:var(--card); border:1px solid var(--border); border-radius:14px; padding:14px 18px; flex:1; }
.tl-card b{ color:var(--text); display:block; margin-bottom:2px; }
.tl-card span{ color:var(--text2); font-size:.9rem; }

/* VALORES */
.values{ margin-bottom:44px; }
.values-grid{ display:grid; grid-template-columns:repeat(auto-fit,minmax(160px,1fr)); gap:16px; }
.value-card{ background:var(--card); border:1px solid var(--border); border-radius:18px; padding:24px 18px; text-align:center; transition:transform .2s; }
.value-card:hover{ transform:translateY(-4px); }
.value-card span{ font-size:2.2rem; display:block; margin-bottom:8px; }
.value-card b{ color:var(--text); display:block; margin-bottom:6px; }
.value-card p{ color:var(--text2); font-size:.85rem; margin:0; line-height:1.5; }

/* CTA */
.about-cta{ position:relative; text-align:center; background:var(--card); border:1px solid var(--border); border-radius:26px; padding:46px 24px; overflow:hidden; }
.cta-glow{ position:absolute; bottom:-50%; left:50%; transform:translateX(-50%); width:500px; height:500px; background:radial-gradient(circle, rgba(46, 139, 127,.2), transparent 70%); pointer-events:none; animation:floaty 8s ease-in-out infinite; }
.about-cta h2{ position:relative; font-family:var(--fd); font-size:clamp(1.4rem,4vw,2rem); font-weight:900; color:var(--text); margin:0 0 10px; }
.about-cta p{ position:relative; color:var(--text2); margin:0 0 22px; }
.cta-btns{ position:relative; display:flex; gap:12px; justify-content:center; flex-wrap:wrap; }
.cta-primary{ background:linear-gradient(135deg,#f29f05,#c2441c); color:#fff; padding:13px 30px; border-radius:100px; font-weight:800; text-decoration:none; transition:transform .2s, box-shadow .2s; }
.cta-primary:hover{ transform:scale(1.05); box-shadow:0 8px 24px rgba(242, 159, 5,.4); }
.cta-secondary{ background:var(--card2); color:var(--text); border:1.5px solid var(--border); padding:13px 30px; border-radius:100px; font-weight:800; text-decoration:none; transition:all .2s; }
.cta-secondary:hover{ border-color:#2e8b7f; transform:scale(1.05); }

/* reveal + anims */
.reveal{ opacity:0; transform:translateY(28px); transition:opacity .7s ease, transform .7s ease; }
.reveal.in{ opacity:1; transform:none; }
@keyframes floaty{ 0%,100%{transform:translateX(-50%) translateY(0);} 50%{transform:translateX(-50%) translateY(22px);} }
@media (prefers-reduced-motion: reduce){ .reveal{opacity:1!important;transform:none!important;} .about-glow,.cta-glow{animation:none;} }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const io = new IntersectionObserver(es => es.forEach(e => { if(e.isIntersecting){ e.target.classList.add('in'); io.unobserve(e.target);} }), {threshold:.12});
    document.querySelectorAll('.reveal').forEach(el => io.observe(el));

    const counters = document.querySelectorAll('.stat-num');
    const cio = new IntersectionObserver(es => {
        es.forEach(e => {
            if (!e.isIntersecting) return;
            const el = e.target, target = +el.dataset.target, suffix = el.dataset.suffix || '';
            const dur = 1400, t0 = performance.now();
            (function tick(now){
                const p = Math.min((now - t0)/dur, 1);
                const ease = 1 - Math.pow(1-p, 3);
                el.textContent = Math.round(target*ease) + suffix;
                if (p < 1) requestAnimationFrame(tick);
            })(t0);
            cio.unobserve(el);
        });
    }, {threshold:.6});
    counters.forEach(c => cio.observe(c));
});
</script>

<?php
$content = ob_get_clean();
require_once 'layout.php';
?>
