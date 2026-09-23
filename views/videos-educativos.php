<?php
$title = $title ?? 'Videos Educativos - NDA';
$currentSlug = 'videos-educativos';
$extraCss = ['css/videos-educativos.css'];

$videos = [
    [
        'id' => 'AAoTE63s5no',
        'categoria' => 'sismos',
        'titulo' => '¿Qué son los sismos y por qué suceden?',
        'autor' => 'Riesgos Ecuador',
        'autor_url' => 'https://www.youtube.com/@RiesgosEcuador',
        'descripcion' => 'Explicación introductoria sobre el origen de los sismos y sus efectos.',
    ],
    [
        'id' => '_n2UZT4Avnw',
        'categoria' => 'sismos',
        'titulo' => 'Las fuerzas más destructivas de la Tierra',
        'autor' => 'Nat Geo en Español',
        'autor_url' => 'https://www.youtube.com/@NationalGeographicEspanol',
        'descripcion' => 'Documental sobre las fuerzas naturales que transforman nuestro planeta.',
    ],
    [
        'id' => 'sk_x58kM_70',
        'categoria' => 'sismos',
        'titulo' => '¿Qué es un terremoto?',
        'autor' => 'Happy Learning Español',
        'autor_url' => 'https://www.youtube.com/@HappyLearningES',
        'descripcion' => 'Video educativo para comprender los terremotos de forma sencilla.',
    ],
    [
        'id' => 'KWvTSE9L-Ds',
        'categoria' => 'tsunamis',
        'titulo' => 'Mega tsunamis: lo inexplicable',
        'autor' => 'History Latinoamérica',
        'autor_url' => 'https://www.youtube.com/@HistoryLA',
        'descripcion' => 'Recorrido audiovisual por los tsunamis y su capacidad destructiva.',
    ],
    [
        'id' => 'DpKzWOAupCs',
        'categoria' => 'tsunamis',
        'titulo' => '¿Cómo se forma un tsunami?',
        'autor' => 'EcologíaVerde',
        'autor_url' => 'https://www.youtube.com/@EcologiaVerde',
        'descripcion' => 'Definición, fases y condiciones que pueden originar un tsunami.',
    ],
    [
        'id' => 'COy76Cu8-3M',
        'categoria' => 'volcanes',
        'titulo' => 'Los volcanes y el fuego del interior',
        'autor' => 'DOCUNAU',
        'autor_url' => 'https://www.youtube.com/@DOCUNAU',
        'descripcion' => 'Documental sobre los volcanes y la actividad del interior de la Tierra.',
    ],
    [
        'id' => 'NfNEDGN7ONg',
        'categoria' => 'volcanes',
        'titulo' => 'Krakatoa, uno de los volcanes más peligrosos',
        'autor' => 'History Latinoamérica',
        'autor_url' => 'https://www.youtube.com/@HistoryLA',
        'descripcion' => 'Historia y consecuencias de la erupción del volcán Krakatoa.',
    ],
];

ob_start();
?>

<div class="educational-videos-page">
    <div class="wrap">
        <header class="educational-videos-header">
            <span class="videos-kicker">Desastres naturales · Contenido audiovisual</span>
            <h1>Videos Educativos</h1>
            <p>Aprende cómo se originan y cómo afectan los principales desastres naturales.</p>
        </header>

        <div class="video-filter-bar" aria-label="Filtrar videos por desastre">
            <button type="button" class="video-filter-btn active" data-video-filter="all">Todos</button>
            <button type="button" class="video-filter-btn" data-video-filter="sismos">Sismos</button>
            <button type="button" class="video-filter-btn" data-video-filter="tsunamis">Tsunamis</button>
            <button type="button" class="video-filter-btn" data-video-filter="volcanes">Volcanes</button>
        </div>

        <div class="educational-videos-grid">
            <?php foreach ($videos as $video): ?>
                <article class="educational-video-card" data-video-category="<?= htmlspecialchars($video['categoria']) ?>">
                    <div class="video-frame-wrap">
                        <iframe src="https://www.youtube.com/embed/<?= htmlspecialchars($video['id']) ?>" title="<?= htmlspecialchars($video['titulo']) ?>" loading="lazy" data-video-id="<?= htmlspecialchars($video['id']) ?>" data-video-title="<?= htmlspecialchars($video['titulo']) ?>" data-video-category="<?= htmlspecialchars($video['categoria']) ?>" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                    <div class="educational-video-body">
                        <span class="educational-video-category"><?= htmlspecialchars(ucfirst($video['categoria'])) ?></span>
                        <h2><?= htmlspecialchars($video['titulo']) ?></h2>
                        <p><?= htmlspecialchars($video['descripcion']) ?></p>
                        <div class="educational-video-credit">
                            <span><strong>Autor/canal:</strong> <?= htmlspecialchars($video['autor']) ?></span>
                            <a href="<?= htmlspecialchars($video['autor_url']) ?>" target="_blank" rel="noopener noreferrer">Ver canal</a>
                        </div>
                        <a class="educational-video-link" href="https://www.youtube.com/watch?v=<?= htmlspecialchars($video['id']) ?>" target="_blank" rel="noopener noreferrer" data-video-link="<?= htmlspecialchars($video['id']) ?>">Ver en YouTube <span aria-hidden="true">↗</span></a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <p class="video-disclaimer">Los videos pertenecen a sus respectivos canales de YouTube. NDA los comparte con fines educativos.</p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.video-filter-btn');
    const videoCards = document.querySelectorAll('.educational-video-card');

    filterButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            filterButtons.forEach(function(filterButton) { filterButton.classList.remove('active'); });
            button.classList.add('active');
            const filter = button.dataset.videoFilter;
            videoCards.forEach(function(card) {
                card.hidden = filter !== 'all' && card.dataset.videoCategory !== filter;
            });
        });
    });

    document.querySelectorAll('.educational-video-card').forEach(function(card) {
        const frame = card.querySelector('iframe');
        const link = card.querySelector('[data-video-link]');
        const markViewed = function() {
            const csrf = document.querySelector('meta[name="csrf-token"]');
            if (!csrf || !frame || !link) return;
            const body = new URLSearchParams({
                csrf_token: csrf.content,
                tipo_contenido: 'video',
                contenido_clave: frame.dataset.videoId,
                titulo: frame.dataset.videoTitle,
                url: link.href,
                categoria: frame.dataset.videoCategory
            });
            fetch('?url=profile/track-view', { method: 'POST', headers: { 'Content-Type': 'application/x-www-form-urlencoded' }, body: body.toString(), credentials: 'same-origin' }).catch(function() {});
        };
        if (frame) frame.addEventListener('load', markViewed, { once: true });
        if (link) link.addEventListener('click', markViewed);
    });
});
</script>

<?php
$content = ob_get_clean();
require_once 'layout.php';
?>
