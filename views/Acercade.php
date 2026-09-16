<?php
$title = $title ?? 'Acerca de NDA';
$extraCss = ['css/acercadenda.css'];

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
            <h2 class="section-h">¿Cómo te acompañamos?</h2>
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
