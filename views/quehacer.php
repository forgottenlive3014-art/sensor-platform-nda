<?php
$title = $title ?? '¿Qué hacer AHORA? - NDA';

require_once __DIR__ . '/../models/ContenidoModel.php';

$quehacerDefs = ContenidoModel::quehacerFieldDefs();
$quehacerSaved = (new ContenidoModel())->getByPage('quehacer');
$C = [];
foreach ($quehacerDefs as $def) {
    $C[$def['campo']] = $quehacerSaved[$def['campo']] ?? $def['default'];
}

$tiposKeys = ['sismo', 'inundacion', 'incendio', 'deslizamiento', 'tormenta'];
$fases = ['antes', 'durante', 'despues'];
$DATA_PHP = [];
foreach ($tiposKeys as $tipo) {
    $DATA_PHP[$tipo] = ['title' => $C["$tipo.title"]];
    foreach ($fases as $fase) {
        $steps = [];
        for ($i = 0; $i < 3; $i++) {
            $steps[] = [$C["$tipo.$fase.$i.titulo"], $C["$tipo.$fase.$i.texto"]];
        }
        $DATA_PHP[$tipo][$fase] = $steps;
    }
}

$contactos = [];
for ($i = 0; $i < 4; $i++) {
    $contactos[] = [
        'nombre' => $C["contacts.$i.nombre"],
        'subtitulo' => $C["contacts.$i.subtitulo"],
        'link' => $C["contacts.$i.link"],
    ];
}
$contactColors = ['#d91a2a', '#f29f05', '#2e8b7f', '#2e7da6'];

ob_start();
?>

<div class="now-page">
    <div class="wrap" style="padding-top:80px; padding-bottom:60px;">

        <div class="now-hero reveal">
            <div class="siren"></div>
            <span class="now-kicker"><?= htmlspecialchars($C['hero.kicker']) ?></span>
            <h1 class="grad"><?= htmlspecialchars($C['hero.titulo']) ?></h1>
            <p><?= htmlspecialchars($C['hero.texto']) ?></p>
            <a href="tel:911" class="emergency-call">
                <span class="call-pulse"></span> Llamar al 911
            </a>
        </div>

        <div class="now-selector reveal">
            <button class="now-tab active" data-em="sismo" style="--c:#f29f05;">Sismo</button>
            <button class="now-tab" data-em="inundacion" style="--c:#2e7da6;">Inundación</button>
            <button class="now-tab" data-em="incendio" style="--c:#d91a2a;">Incendio</button>
            <button class="now-tab" data-em="deslizamiento" style="--c:#a16207;">Deslizamiento</button>
            <button class="now-tab" data-em="tormenta" style="--c:#6a6fb5;">Tormenta</button>
        </div>

        <div class="now-board reveal">
            <div class="now-board-head">
                <span class="now-icon" id="nowIcon"></span>
                <h2 id="nowTitle">Sismo / Terremoto</h2>
            </div>

            <div class="phase-tabs">
                <button class="phase-tab active" data-phase="antes">Antes</button>
                <button class="phase-tab" data-phase="durante">Durante</button>
                <button class="phase-tab" data-phase="despues">Después</button>
            </div>

            <div class="steps" id="nowSteps"></div>
        </div>

        <div class="contacts reveal">
            <h2><?= htmlspecialchars($C['contacts.titulo']) ?></h2>
            <div class="contact-grid">
                <?php foreach ($contactos as $i => $c): ?>
                <a href="<?= htmlspecialchars($c['link'] ?: '#') ?>" class="contact-card" style="--c:<?= $contactColors[$i] ?? '#f29f05' ?>;">
                    <div><b><?= htmlspecialchars($c['nombre']) ?></b><small><?= htmlspecialchars($c['subtitulo']) ?></small></div>
                </a>
                <?php endforeach; ?>
            </div>
            <p class="contact-note">Verifica y guarda los números locales de tu municipio antes de una emergencia.</p>
        </div>

    </div>
</div>

<style>
.now-page .grad{ background:linear-gradient(135deg,#d91a2a,#f29f05); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }

/* HERO */
.now-hero{
    position:relative; text-align:center; background:var(--card); border:1px solid var(--border);
    border-radius:26px; padding:44px 24px; overflow:hidden; margin-bottom:30px;
}
.siren{
    position:absolute; inset:0; pointer-events:none; opacity:.5;
    background:radial-gradient(circle at 50% 0%, rgba(217, 26, 42,.25), transparent 55%);
    animation:siren 3s ease-in-out infinite;
}
@keyframes siren{ 0%,100%{opacity:.25;} 50%{opacity:.6;} }
.now-kicker{ position:relative; display:inline-block; font-size:.72rem; letter-spacing:3px; font-weight:800; color:#d91a2a; background:rgba(217, 26, 42,.14); padding:6px 14px; border-radius:100px; margin-bottom:14px; }
.now-hero h1{ position:relative; font-family:var(--fd); font-size:clamp(2.2rem,6vw,3.6rem); font-weight:900; color:var(--text); margin:0 0 10px; }
.now-hero p{ position:relative; color:var(--text2); max-width:560px; margin:0 auto 22px; font-size:1.05rem; }
.emergency-call{
    position:relative; display:inline-flex; align-items:center; gap:8px; background:linear-gradient(135deg,#d91a2a,#b91c1c);
    color:#fff; text-decoration:none; font-weight:800; font-size:1.1rem; padding:15px 34px; border-radius:100px;
    box-shadow:0 8px 30px rgba(217, 26, 42,.4); transition:transform .2s; overflow:hidden;
}
.emergency-call:hover{ transform:scale(1.05); }
.call-pulse{ position:absolute; inset:0; border-radius:100px; box-shadow:0 0 0 0 rgba(217, 26, 42,.6); animation:callpulse 1.8s infinite; }
@keyframes callpulse{ 0%{box-shadow:0 0 0 0 rgba(217, 26, 42,.55);} 70%{box-shadow:0 0 0 18px rgba(217, 26, 42,0);} 100%{box-shadow:0 0 0 0 rgba(217, 26, 42,0);} }

/* SELECTOR */
.now-selector{ display:flex; gap:12px; flex-wrap:wrap; justify-content:center; margin-bottom:28px; }
.now-tab{
    display:flex; flex-direction:column; align-items:center; gap:6px; min-width:96px;
    background:var(--card2); border:1.5px solid var(--border); color:var(--text);
    padding:14px 10px; border-radius:18px; cursor:pointer; transition:all .2s; font-weight:700; font-size:.85rem;
}
.now-tab span{ font-size:1.8rem; transition:transform .3s; }
.now-tab:hover{ transform:translateY(-3px); border-color:var(--c); }
.now-tab:hover span{ transform:scale(1.15); }
.now-tab.active{ background:color-mix(in srgb, var(--c) 16%, transparent); border-color:var(--c); box-shadow:0 6px 20px color-mix(in srgb, var(--c) 25%, transparent); }

/* BOARD */
.now-board{ background:var(--card); border:1px solid var(--border); border-radius:24px; padding:30px; margin-bottom:30px; }
.now-board-head{ display:flex; align-items:center; gap:14px; margin-bottom:20px; }
.now-icon{ font-size:2.6rem; }
.now-board-head h2{ font-family:var(--fd); font-size:1.6rem; font-weight:900; color:var(--text); margin:0; }
.phase-tabs{ display:flex; gap:10px; flex-wrap:wrap; margin-bottom:24px; }
.phase-tab{
    background:var(--card2); border:1px solid var(--border); color:var(--text);
    padding:9px 20px; border-radius:100px; cursor:pointer; font-weight:600; font-size:.88rem; transition:all .2s;
}
.phase-tab:hover{ border-color:#f29f05; }
.phase-tab.active{ background:#f29f05; color:#fff; border-color:transparent; }

/* STEPS */
.steps{ display:flex; flex-direction:column; gap:0; }
.step{
    display:flex; gap:18px; padding:18px 0; border-bottom:1px dashed var(--border);
    opacity:0; transform:translateX(-20px); animation:slideIn .5s ease forwards;
}
.step:last-child{ border-bottom:none; }
.step-num{
    flex-shrink:0; width:40px; height:40px; border-radius:50%; display:flex; align-items:center; justify-content:center;
    background:linear-gradient(135deg,#f29f05,#c2441c); color:#fff; font-weight:900; font-size:1.05rem;
    box-shadow:0 4px 14px rgba(242, 159, 5,.35);
}
.step-text{ padding-top:6px; }
.step-text b{ color:var(--text); display:block; font-size:1.02rem; margin-bottom:3px; }
.step-text span{ color:var(--text2); font-size:.9rem; line-height:1.5; }
@keyframes slideIn{ to{ opacity:1; transform:none; } }

/* CONTACTOS */
.contacts{ background:var(--card); border:1px solid var(--border); border-radius:24px; padding:30px; }
.contacts h2{ font-family:var(--fd); font-size:1.4rem; font-weight:900; color:var(--text); margin:0 0 18px; }
.contact-grid{ display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:14px; }
.contact-card{
    display:flex; align-items:center; gap:14px; background:var(--card2); border:1.5px solid var(--border);
    border-radius:16px; padding:16px; text-decoration:none; transition:all .2s;
}
.contact-card:hover{ transform:translateY(-3px); border-color:var(--c); box-shadow:0 8px 22px rgba(0,0,0,.25); }
.c-emoji{ font-size:2rem; }
.contact-card b{ color:var(--text); font-size:1.15rem; display:block; }
.contact-card small{ color:var(--text3); font-size:.78rem; }
.contact-note{ color:var(--text3); font-size:.85rem; margin:18px 0 0; }

/* reveal */
.reveal{ opacity:0; transform:translateY(28px); transition:opacity .7s ease, transform .7s ease; }
.reveal.in{ opacity:1; transform:none; }
@media (prefers-reduced-motion: reduce){
    .reveal{opacity:1!important;transform:none!important;}
    .siren,.call-pulse{animation:none;}
    .step{opacity:1;transform:none;animation:none;}
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const io = new IntersectionObserver(es => es.forEach(e => { if(e.isIntersecting){ e.target.classList.add('in'); io.unobserve(e.target);} }), {threshold:.1});
    document.querySelectorAll('.reveal').forEach(el => io.observe(el));

    const DATA = <?= json_encode($DATA_PHP, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS) ?>;

    let curEm = 'sismo', curPhase = 'antes';
    function render() {
        const d = DATA[curEm];
        document.getElementById('nowTitle').textContent = d.title;
        const steps = d[curPhase];
        const box = document.getElementById('nowSteps'); box.innerHTML = '';
        steps.forEach((s, i) => {
            const el = document.createElement('div'); el.className = 'step'; el.style.animationDelay = (i*0.1)+'s';
            el.innerHTML = `<div class="step-num">${i+1}</div><div class="step-text"><b>${s[0]}</b><span>${s[1]}</span></div>`;
            box.appendChild(el);
        });
    }
    document.querySelectorAll('.now-tab').forEach(t => {
        t.addEventListener('click', () => {
            document.querySelectorAll('.now-tab').forEach(x => x.classList.remove('active'));
            t.classList.add('active'); curEm = t.dataset.em; render();
        });
    });
    document.querySelectorAll('.phase-tab').forEach(t => {
        t.addEventListener('click', () => {
            document.querySelectorAll('.phase-tab').forEach(x => x.classList.remove('active'));
            t.classList.add('active'); curPhase = t.dataset.phase; render();
        });
    });
    render();
});
</script>

<?php
$content = ob_get_clean();
require_once 'layout.php';
?>
