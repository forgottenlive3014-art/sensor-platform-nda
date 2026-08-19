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
        '.des-mapa-info-item'
    ].join(', ');

    const cards = document.querySelectorAll(CARD_SELECTORS);

    cards.forEach(function(el) {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
    });

    ScrollTrigger.batch(cards, {
        start: 'top 92%',
        once: true,
        onEnter: function(batch) {
            gsap.to(batch, {
                opacity: 1,
                y: 0,
                duration: 0.5,
                stagger: 0.08,
                ease: 'power1.out'
            });
        }
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
