<?php
$title = $title ?? 'Recursos - NDA';

require_once __DIR__ . '/../models/RecursoModel.php';
$RECURSOS = (new RecursoModel())->getAllForPublic();

$catColors = [
    'evacuacion' => ['#f97316', 'rgba(249, 115, 22, 0.15)'],
    'mochila'    => ['#00d4b0', 'rgba(0, 212, 176, 0.15)'],
    'plan'       => ['#2d8fff', 'rgba(45, 143, 255, 0.15)'],
    'sismo'      => ['#f97316', 'rgba(249, 115, 22, 0.15)'],
    'lluvias'    => ['#2d8fff', 'rgba(45, 143, 255, 0.15)'],
    'volcanes'   => ['#e0631f', 'rgba(224, 99, 31, 0.15)'],
    'clima'      => ['#7c3aed', 'rgba(124, 58, 237, 0.15)'],
];
$catLabels = [
    'evacuacion' => 'Evacuación', 'mochila' => 'Mochila', 'plan' => 'Plan Familiar',
    'sismo' => 'Sismos', 'lluvias' => 'Lluvias', 'volcanes' => 'Volcanes', 'clima' => 'Clima',
];
function formatResourceSize($bytes) {
    if (!$bytes || $bytes <= 0) return '';
    $mb = $bytes / (1024 * 1024);
    return $mb >= 1 ? number_format($mb, 1) . ' MB' : number_format($bytes / 1024, 0) . ' KB';
}

ob_start();
?>

<div class="resources-page">
    <div class="wrap" style="padding-top: 80px; padding-bottom: 60px;">

        <div style="text-align: center; margin-bottom: 40px;">
            <h1 style="font-family: var(--fd); font-size: 2.5rem; font-weight: 900; background: linear-gradient(135deg, #f97316, #ff5500); -webkit-background-clip: text; -webkit-text-fill-color: transparent; display: inline-block;">
                 Guías y Recursos Educativos
            </h1>
            <p style="color: var(--text2); font-size: 1.1rem; margin-top: 10px;">
                Materiales informativos para la preparación ante desastres naturales
            </p>
        </div>

        <div style="display: flex; gap: 10px; flex-wrap: wrap; justify-content: center; margin-bottom: 30px;">
            <button class="filter-btn active" data-filter="all" style="background: #f97316; color: #fff; border: none; padding: 8px 20px; border-radius: 50px; font-size: 0.85rem; cursor: pointer; transition: all 0.2s;">Todos</button>
            <button class="filter-btn" data-filter="evacuacion" style="background: var(--card2); color: var(--text); border: 1px solid var(--border); padding: 8px 20px; border-radius: 50px; font-size: 0.85rem; cursor: pointer; transition: all 0.2s;"> Evacuación</button>
            <button class="filter-btn" data-filter="mochila" style="background: var(--card2); color: var(--text); border: 1px solid var(--border); padding: 8px 20px; border-radius: 50px; font-size: 0.85rem; cursor: pointer; transition: all 0.2s;"> Mochila</button>
            <button class="filter-btn" data-filter="plan" style="background: var(--card2); color: var(--text); border: 1px solid var(--border); padding: 8px 20px; border-radius: 50px; font-size: 0.85rem; cursor: pointer; transition: all 0.2s;"> Plan Familiar</button>
            <button class="filter-btn" data-filter="sismo" style="background: var(--card2); color: var(--text); border: 1px solid var(--border); padding: 8px 20px; border-radius: 50px; font-size: 0.85rem; cursor: pointer; transition: all 0.2s;"> Sismos</button>
            <button class="filter-btn" data-filter="lluvias" style="background: var(--card2); color: var(--text); border: 1px solid var(--border); padding: 8px 20px; border-radius: 50px; font-size: 0.85rem; cursor: pointer; transition: all 0.2s;"> Lluvias</button>
            <button class="filter-btn" data-filter="volcanes" style="background: var(--card2); color: var(--text); border: 1px solid var(--border); padding: 8px 20px; border-radius: 50px; font-size: 0.85rem; cursor: pointer; transition: all 0.2s;"> Volcanes</button>
            <button class="filter-btn" data-filter="clima" style="background: var(--card2); color: var(--text); border: 1px solid var(--border); padding: 8px 20px; border-radius: 50px; font-size: 0.85rem; cursor: pointer; transition: all 0.2s;"> Clima</button>
        </div>

        <div class="resources-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px;">

            <?php foreach ($RECURSOS as $r):
                $cat = $r['categoria'];
                $accent = $catColors[$cat][0] ?? '#f97316';
                $accentBg = $catColors[$cat][1] ?? 'rgba(249, 115, 22, 0.15)';
                $tagList = array_filter(array_map('trim', explode(',', $r['tags'] ?? '')));
                if (empty($tagList)) { $tagList = [$catLabels[$cat] ?? ucfirst($cat)]; }
                $sizeLabel = formatResourceSize($r['tamano_bytes']);
            ?>
            <div class="resource-card" data-category="<?= htmlspecialchars($cat) ?>" style="background: var(--card); border: 1px solid var(--border); border-radius: 16px; padding: 24px; transition: transform 0.2s, box-shadow 0.2s;">
                <div style="display: flex; gap: 14px; margin-bottom: 14px;">
                    <div class="res-thumb" data-pdf="<?= htmlspecialchars($r['archivo']) ?>" style="width:120px;height:164px;flex-shrink:0;border-radius:8px;overflow:hidden;background:<?= $accentBg ?>;display:flex;align-items:center;justify-content:center;color:<?= $accent ?>;position:relative;border:1px solid rgba(255,255,255,.08);box-shadow:0 4px 14px rgba(0,0,0,.35);transition:transform .25s ease, box-shadow .25s ease;">
                        <svg class="res-thumb-fallback" width="1.3em" height="1.3em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="9" y1="13" x2="15" y2="13"/><line x1="9" y1="17" x2="13" y2="17"/></svg>
                    </div>
                    <div style="min-width:0;height:164px;overflow:hidden;">
                        <div style="display:flex;align-items:baseline;gap:8px;flex-wrap:nowrap;">
                            <h3 style="font-size: 1rem; font-weight: 700; color: var(--text); margin: 0; min-width: 0; flex: 1 1 auto; min-height: 3.6em; line-height: 1.2;"><?= htmlspecialchars($r['titulo']) ?></h3>
                            <span style="font-size: 0.75rem; color: var(--text3); white-space:nowrap; flex-shrink: 0;">PDF<?= $sizeLabel ? ' · ' . $sizeLabel : '' ?></span>
                        </div>
                        <p style="font-size: 0.85rem; color: var(--text2); margin: 6px 0 0; line-height: 1.5; height: 4.5em; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">
                            <?= htmlspecialchars($r['descripcion'] ?? '') ?>
                        </p>
                        <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-top: 10px;">
                            <?php foreach (array_slice($tagList, 0, 2) as $i => $tag): ?>
                                <span style="background: <?= $i === 0 ? $accentBg : 'rgba(0, 212, 176, 0.15)' ?>; color: <?= $i === 0 ? $accent : '#00d4b0' ?>; font-size: 0.7rem; padding: 3px 10px; border-radius: 100px;"><?= htmlspecialchars($tag) ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div style="display: flex; gap: 8px;">
                    <a href="<?= htmlspecialchars($r['archivo']) ?>" target="_blank" onclick="return openPdfPreview(this.href,'<?= htmlspecialchars(addslashes($r['titulo'])) ?>')" style="flex: 1; background: linear-gradient(135deg, #f97316, #ea6c0a); color: #fff; border: none; border-radius: 8px; padding: 8px 12px; font-size: 0.8rem; text-align: center; text-decoration: none; cursor: pointer; transition: opacity 0.2s;">
                        <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg> Previsualizar
                    </a>
                    <a href="<?= htmlspecialchars($r['archivo']) ?>" download style="background: var(--card2); color: var(--text); border: 1px solid var(--border); border-radius: 8px; padding: 8px 12px; font-size: 0.8rem; text-decoration: none; cursor: pointer; transition: background 0.2s;">
                        <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/></svg>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>

        </div>

        <div style="text-align: center; margin-top: 30px; color: var(--text3); font-size: 0.85rem;">
            <span id="resourceCount"><?= count($RECURSOS) ?></span> recursos educativos disponibles
        </div>

    </div>
</div>

<div id="pdfPreviewModal" class="pdf-modal" aria-hidden="true">
    <div class="pdf-modal-backdrop" onclick="closePdfPreview()"></div>
    <div class="pdf-modal-panel" onclick="restorePdfPreview()">
        <div class="pdf-modal-hdr">
            <span id="pdfModalTitle" class="pdf-modal-title">Documento</span>
            <div class="pdf-modal-actions">
                <a id="pdfModalOpenTab" href="#" target="_blank" class="pdf-modal-btn" title="Abrir en pestaña nueva" onclick="event.stopPropagation()">
                    <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                </a>
                <a id="pdfModalDownload" href="#" download class="pdf-modal-btn" title="Descargar" onclick="event.stopPropagation()">
                    <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                </a>
                <span class="pdf-modal-sep"></span>
                <button type="button" class="pdf-modal-btn" onclick="event.stopPropagation(); minimizePdfPreview()" title="Minimizar">
                    <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/></svg>
                </button>
                <button type="button" class="pdf-modal-btn pdf-modal-btn-close" onclick="event.stopPropagation(); closePdfPreview()" title="Cerrar">
                    <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
        </div>
        <div class="pdf-modal-body">
            <iframe id="pdfModalFrame" src="" title="Previsualización de PDF"></iframe>
            <div class="pdf-modal-loading" id="pdfModalLoading"><div class="pdf-modal-spin"></div><span>Cargando documento…</span></div>
        </div>
    </div>
</div>

<style>
.pdf-modal { position: fixed; inset: 0; z-index: 9500; display: none; }
.pdf-modal.open {
    display: flex; align-items: flex-start; justify-content: center;
    padding: calc(var(--nh) + 6px) 16px 16px;
}
.pdf-modal-backdrop {
    position: absolute; inset: 0; background: rgba(3, 8, 16, 0.72); backdrop-filter: blur(3px);
    opacity: 0; transition: opacity .25s ease;
}
.pdf-modal.show-anim .pdf-modal-backdrop { opacity: 1; }
.pdf-modal-panel {
    position: relative; margin: 0; width: min(1180px, 96vw);
    height: 100%; max-height: calc(100vh - var(--nh) - 22px);
    background: var(--card); border: 1px solid var(--border); border-top: 3px solid #f97316; border-radius: 16px;
    display: flex; flex-direction: column; overflow: hidden; box-shadow: 0 30px 80px rgba(0,0,0,.55);
    opacity: 0; transform: scale(.96) translateY(8px);
    transition: opacity .25s ease, transform .25s cubic-bezier(.16,1,.3,1);
}
.pdf-modal.show-anim .pdf-modal-panel { opacity: 1; transform: scale(1) translateY(0); }
.pdf-modal-hdr {
    display: flex; align-items: center; justify-content: space-between; gap: 12px;
    padding: 12px 16px; border-bottom: 1px solid var(--border); background: var(--card2); flex-shrink: 0;
}
.pdf-modal-title { font-weight: 700; font-size: .9rem; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.pdf-modal-actions { display: flex; align-items: center; gap: 6px; flex-shrink: 0; }
.pdf-modal-sep { width: 1px; height: 20px; background: var(--border); margin: 0 2px; flex-shrink: 0; }
.pdf-modal-btn {
    width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;
    border-radius: 8px; border: 1px solid var(--border); background: var(--card3, var(--card2));
    color: var(--text); cursor: pointer; text-decoration: none; font-size: .95rem; transition: background .2s, border-color .2s, color .2s;
}
.pdf-modal-btn:hover { background: rgba(249, 115, 22, 0.15); border-color: #f97316; color: #f97316; }
.pdf-modal-btn-close:hover { background: rgba(239, 68, 68, 0.15); border-color: #ef4444; color: #ef4444; }
.pdf-modal-body { flex: 1; background: #52565c; position: relative; }
.pdf-modal-loading {
    position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center;
    gap: 12px; background: #52565c; color: rgba(255,255,255,.65); font-size: .82rem;
    opacity: 1; transition: opacity .3s ease; pointer-events: none;
}
.pdf-modal-loading.hidden { opacity: 0; }
.pdf-modal-spin {
    width: 34px; height: 34px; border-radius: 50%;
    border: 3px solid rgba(255,255,255,.18); border-top-color: #f97316;
    animation: pdfModalSpin .8s linear infinite;
}
@keyframes pdfModalSpin { to { transform: rotate(360deg); } }
.pdf-modal-body iframe { width: 100%; height: 100%; border: 0; display: block; }
@media (max-width: 640px) {
    .pdf-modal.open { padding: var(--nh) 0 0; }
    .pdf-modal-panel { width: 100vw; height: 100%; max-height: calc(100vh - var(--nh)); border-radius: 0; }
}

.pdf-modal.minimized { pointer-events: none; }
.pdf-modal.minimized .pdf-modal-backdrop { display: none; }
.pdf-modal.minimized .pdf-modal-panel {
    position: fixed; right: 20px; bottom: 20px; left: auto; margin: 0;
    width: 280px; height: 52px; cursor: pointer; pointer-events: auto;
}
.pdf-modal.minimized .pdf-modal-body { display: none; }
.pdf-modal.minimized .pdf-modal-hdr { border-bottom: 0; }
.pdf-modal.minimized #pdfModalOpenTab,
.pdf-modal.minimized #pdfModalDownload { display: none; }
</style>

<script>
function openPdfPreview(url, title) {
    const modal = document.getElementById('pdfPreviewModal');
    const frame = document.getElementById('pdfModalFrame');
    const loading = document.getElementById('pdfModalLoading');
    loading.classList.remove('hidden');
    frame.onload = function() { loading.classList.add('hidden'); };
    frame.src = url + '#view=FitH';
    document.getElementById('pdfModalTitle').textContent = title || 'Documento';
    document.getElementById('pdfModalOpenTab').href = url;
    document.getElementById('pdfModalDownload').href = url;
    modal.classList.remove('minimized');
    modal.classList.add('open');
    modal.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
    requestAnimationFrame(function() {
        requestAnimationFrame(function() { modal.classList.add('show-anim'); });
    });
    return false;
}
function closePdfPreview() {
    const modal = document.getElementById('pdfPreviewModal');
    if (!modal.classList.contains('open')) return;
    modal.classList.remove('show-anim');
    modal.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
    setTimeout(function() {
        modal.classList.remove('open', 'minimized');
        document.getElementById('pdfModalFrame').src = '';
        document.getElementById('pdfModalLoading').classList.remove('hidden');
    }, 250);
}
function minimizePdfPreview() {
    const modal = document.getElementById('pdfPreviewModal');
    modal.classList.add('minimized');
    document.body.style.overflow = '';
}
function restorePdfPreview() {
    const modal = document.getElementById('pdfPreviewModal');
    if (!modal.classList.contains('minimized')) return;
    modal.classList.remove('minimized');
    document.body.style.overflow = 'hidden';
}
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closePdfPreview();
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const cards = document.querySelectorAll('.resource-card');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            filterBtns.forEach(b => {
                b.style.background = 'var(--card2)';
                b.style.color = 'var(--text)';
                b.style.border = '1px solid var(--border)';
            });
            this.style.background = '#f97316';
            this.style.color = '#fff';
            this.style.border = 'none';

            const filter = this.dataset.filter;
            let visibleCount = 0;
            cards.forEach(card => {
                if (filter === 'all' || card.dataset.category === filter) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });
            document.getElementById('resourceCount').textContent = visibleCount;
        });
    });

    const visible = document.querySelectorAll('.resource-card[style*="display: block"]');
    document.getElementById('resourceCount').textContent = visible.length || cards.length;
});
</script>

<style>
.resource-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.3);
    border-color: rgba(249, 115, 22, 0.3);
}

.resource-card a:hover {
    opacity: 0.85;
}

.resource-card a[download]:hover {
    background: var(--card3);
}

.filter-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(249, 115, 22, 0.2);
}

.filter-btn.active {
    background: #f97316 !important;
    color: #fff !important;
    border: none !important;
}
.res-thumb canvas { width: 100%; height: 100%; display: block; object-fit: cover; object-position: center; }
.resource-card:hover .res-thumb { transform: scale(1.045); box-shadow: 0 8px 22px rgba(0,0,0,.45); }
.res-thumb.loading { animation: resThumbPulse 1.6s ease-in-out infinite; }
@keyframes resThumbPulse {
    0%, 100% { background-color: rgba(249, 115, 22, 0.15); }
    50% { background-color: rgba(249, 115, 22, 0.28); }
}
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
(function() {
    if (typeof pdfjsLib === 'undefined') return;
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

    function renderThumb(el) {
        var url = el.dataset.pdf;
        if (!url || el.dataset.rendered) return;
        el.dataset.rendered = '1';
        el.classList.add('loading');
        pdfjsLib.getDocument(url).promise
            .then(function(pdf) { return pdf.getPage(1); })
            .then(function(page) {
                var boxW = el.clientWidth, boxH = el.clientHeight;
                var baseVp = page.getViewport({ scale: 1 });
                var scale = Math.max(boxW / baseVp.width, boxH / baseVp.height) * (window.devicePixelRatio || 1);
                var vp = page.getViewport({ scale: scale });
                var canvas = document.createElement('canvas');
                canvas.width = vp.width;
                canvas.height = vp.height;
                return page.render({ canvasContext: canvas.getContext('2d'), viewport: vp }).promise.then(function() {
                    var fallback = el.querySelector('.res-thumb-fallback');
                    if (fallback) fallback.remove();
                    el.style.background = '#fff';
                    el.appendChild(canvas);
                    el.classList.remove('loading');
                });
            })
            .catch(function() { el.classList.remove('loading'); /* deja el ícono de respaldo si el PDF no carga */ });
    }

    var thumbs = document.querySelectorAll('.res-thumb[data-pdf]');
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    renderThumb(entry.target);
                    io.unobserve(entry.target);
                }
            });
        }, { rootMargin: '200px' });
        thumbs.forEach(function(el) { io.observe(el); });
    } else {
        thumbs.forEach(renderThumb);
    }
})();
</script>

<?php
$content = ob_get_clean();
require_once 'layout.php';
?>
