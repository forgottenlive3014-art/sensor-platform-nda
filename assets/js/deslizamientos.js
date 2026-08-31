// ============================================================
// DESLIZAMIENTOS - ANIMACIONES GSAP
// ============================================================

(function() {
    'use strict';

    if (typeof gsap === 'undefined') {
        console.warn('GSAP no está disponible');
        return;
    }

    gsap.registerPlugin(ScrollTrigger);

    const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (prefersReduced) return;

    // ============================================================
    // ANIMACIONES DE TARJETAS
    // ============================================================
    const CARD_SELECTORS = [
        '.des-causa-card',
        '.des-tipo-card',
        '.des-senal-card',
        '.des-prevencion-card',
        '.des-mito-card',
        '.des-recurso-card',
        '.des-fundamento',
        '.des-mapa-info-item',
        '.dis-context-card'
    ].join(', ');

    const cards = document.querySelectorAll(CARD_SELECTORS);

    // Entra deslizandose desde la derecha, atada en vivo al scroll (scrub):
    // si scrolleas lento se desliza lento, si volves para arriba se
    // devuelve. Cada tarjeta tiene su propio ScrollTrigger.
    cards.forEach(function (el) {
        gsap.fromTo(el,
            { opacity: 0, x: 90, scale: 0.9 },
            {
                opacity: 1,
                x: 0,
                scale: 1,
                ease: 'none',
                scrollTrigger: {
                    trigger: el,
                    start: 'top 92%',
                    end: 'top 57%',
                    scrub: 0.6,
                    // Varias de estas tarjetas (.des-tipo-card, .des-causa-card...)
                    // ya tienen su propio transform en :hover via CSS; sin
                    // limpiar esto se queda pisado para siempre.
                    onLeave: function () { gsap.set(el, { clearProps: 'transform' }); }
                }
            }
        );
    });

    // ============================================================
    // ANIMACIÓN DE SECCIONES
    // ============================================================
    document.querySelectorAll('.des-header, .des-intro-wrapper, .des-intro-footer, .des-mapa-wrapper, .des-belt, .tl-wrap').forEach(function(el) {
        gsap.fromTo(el, { opacity: 0, y: 15 }, {
            opacity: 1,
            y: 0,
            duration: 0.4,
            ease: 'power1.out',
            scrollTrigger: {
                trigger: el,
                start: 'top 94%',
                once: true
            }
        });
    });

    // ============================================================
    // ANIMACIÓN DE MAPA LEGEND
    // ============================================================
    gsap.from('.des-mapa-legend-item', {
        opacity: 0,
        y: 10,
        duration: 0.3,
        stagger: 0.08,
        scrollTrigger: {
            trigger: '.des-mapa-legend',
            start: 'top 95%',
            once: true
        }
    });

    console.log('Deslizamientos GSAP animations initialized');

})();
