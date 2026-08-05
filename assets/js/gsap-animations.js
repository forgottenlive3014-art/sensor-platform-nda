// NDA - Animaciones GSAP (optimizado para rendimiento)
(function () {
    if (typeof gsap === 'undefined') return;
    gsap.registerPlugin(ScrollTrigger);

    const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (prefersReduced) return;

    // ============================================================
    // SELECTORES PRINCIPALES (solo los elementos más importantes)
    // ============================================================
    const CARD_SELECTORS = [
        // Generales
        '.mod-card', '.card', '.data-card-3d', '.h3d-card',
        '.section-card', '.smc', '.rtm-stat', '.fbi',
        '.guide-card', '.blog-card', '.game-card',
        // Sismos
        '.sismo-step', '.type-card', '.wave-card', '.measure-card',
        '.historic-card', '.depth-card', '.term-card', '.sv-stat',
        '.foco-image-card'
    ].join(', ');

    // ============================================================
    // CONFIGURACIÓN RÁPIDA: DURACIONES MÁS CORTAS
    // ============================================================
    const DEFAULTS = {
        duration: 0.4,      // Antes: 0.65
        stagger: 0.04,      // Antes: 0.08
        ease: 'power1.out', // Antes: power2.out (más suave y rápido)
        y: 15               // Antes: 28 (menos movimiento)
    };

    // ============================================================
    // APLICAR will-change (solo a elementos visibles inicialmente)
    // ============================================================
    document.querySelectorAll(CARD_SELECTORS).forEach(el => {
        if (el.closest('.reveal')) return;
        el.style.willChange = 'transform, opacity';
    });

    // ============================================================
    // ANIMACIÓN DE TARJETAS (más rápida y sutil)
    // ============================================================
    const groups = new Map();
    document.querySelectorAll(CARD_SELECTORS).forEach(el => {
        if (el.closest('.reveal')) return;
        const parent = el.parentElement;
        if (!groups.has(parent)) groups.set(parent, []);
        groups.get(parent).push(el);
    });

    groups.forEach(items => {
        if (!items.length) return;
        gsap.set(items, { opacity: 0, y: DEFAULTS.y });
        ScrollTrigger.batch(items, {
            start: 'top 90%',      // Antes: 88% (se activa un poco antes)
            once: true,
            onEnter: batch => gsap.to(batch, {
                opacity: 1,
                y: 0,
                duration: DEFAULTS.duration,
                ease: DEFAULTS.ease,
                stagger: DEFAULTS.stagger,
                overwrite: true
            })
        });
    });

    // ============================================================
    // TÍTULOS Y TEXTOS (animación muy sutil, casi imperceptible)
    // ============================================================
    const TEXT_SELECTORS = [
        '.sec-hd', '.page-title', '.rtm-title-area',
        '.sismo-intro-text', '.sismo-etymology', '.sv-description',
        '.sismo-sv-note', '.dis-bigbanner-word'
    ].join(', ');

    document.querySelectorAll(TEXT_SELECTORS).forEach(el => {
        if (el.closest('.reveal')) return;
        gsap.fromTo(el, { opacity: 0, y: 8 }, {
            opacity: 1,
            y: 0,
            duration: 0.35,
            ease: 'power1.out',
            scrollTrigger: { trigger: el, start: 'top 92%', once: true }
        });
    });

    // ============================================================
    // IMÁGENES (fade in simple, sin scale)
    // ============================================================
    const IMAGE_SELECTORS = [
        '.sismo-image-card', '.sv-image', '.step-image',
        '.type-card-image', '.wave-card-image', '.measure-image',
        '.guide-image', '.historic-image'
    ].join(', ');

    document.querySelectorAll(IMAGE_SELECTORS).forEach(el => {
        if (el.closest('.reveal')) return;
        gsap.fromTo(el, { opacity: 0 }, {
            opacity: 1,
            duration: 0.45,
            ease: 'power1.out',
            scrollTrigger: { trigger: el, start: 'top 90%', once: true }
        });
    });

    // ============================================================
    // NÚMEROS DE PASOS (#01, #02, etc.) - fade in simple
    // ============================================================
    document.querySelectorAll('.step-number').forEach(el => {
        if (el.closest('.reveal')) return;
        gsap.fromTo(el, { opacity: 0 }, {
            opacity: 0.15,
            duration: 0.3,
            ease: 'power1.out',
            scrollTrigger: { trigger: el, start: 'top 92%', once: true }
        });
    });

    // ============================================================
    // ESTADÍSTICAS (contador rápido)
    // ============================================================
    document.querySelectorAll('.sv-num').forEach(el => {
        if (el.closest('.reveal')) return;
        const target = el.textContent;
        if (target.match(/^[\d\+]+$/)) {
            const num = parseInt(target);
            if (!isNaN(num)) {
                const obj = { val: 0 };
                ScrollTrigger.create({
                    trigger: el,
                    start: 'top 92%',
                    once: true,
                    onEnter: () => gsap.to(obj, {
                        val: num,
                        duration: 0.8,      // Antes: 1.8
                        ease: 'power1.out',
                        onUpdate: () => {
                            el.textContent = Math.round(obj.val) + '+';
                        }
                    })
                });
            }
        }
    });

    // ============================================================
    // BANNER SV (Cinturón de Fuego) - animación sutil
    // ============================================================
    document.querySelectorAll('.sv-banner').forEach(el => {
        if (el.closest('.reveal')) return;
        gsap.fromTo(el, { opacity: 0, x: -10 }, {
            opacity: 1,
            x: 0,
            duration: 0.4,
            ease: 'power1.out',
            scrollTrigger: { trigger: el, start: 'top 94%', once: true }
        });
    });

    // ============================================================
    // HOVER EFFECTS (más suaves y rápidos)
    // ============================================================
    const HOVER_SELECTORS = [
        '.mod-card', '.card', '.h3d-card', '.guide-card',
        '.sismo-step', '.type-card', '.wave-card', '.measure-card',
        '.historic-card', '.depth-card', '.term-card', '.sv-stat'
    ].join(', ');

    document.querySelectorAll(HOVER_SELECTORS).forEach(el => {
        el.addEventListener('mouseenter', () => {
            gsap.to(el, { y: -3, duration: 0.15, ease: 'power1.out' }); // Antes: -6, 0.25
        });
        el.addEventListener('mouseleave', () => {
            gsap.to(el, { y: 0, duration: 0.2, ease: 'power1.out' });
        });
    });

    // ============================================================
    // CONTADORES (data-gsap-count)
    // ============================================================
    document.querySelectorAll('[data-gsap-count]').forEach(el => {
        const target = parseFloat(el.dataset.gsapCount) || 0;
        const obj = { val: 0 };
        ScrollTrigger.create({
            trigger: el,
            start: 'top 92%',
            once: true,
            onEnter: () => gsap.to(obj, {
                val: target,
                duration: 0.8,
                ease: 'power1.out',
                onUpdate: () => { el.textContent = Math.round(obj.val); }
            })
        });
    });

    // ============================================================
    // REFRESH (más rápido)
    // ============================================================
    let refreshTimeout;
    const refreshTrigger = () => {
        clearTimeout(refreshTimeout);
        refreshTimeout = setTimeout(() => ScrollTrigger.refresh(), 100);
    };

    document.addEventListener('click', refreshTrigger);
    window.addEventListener('load', () => {
        setTimeout(refreshTrigger, 300);
    });

    console.log('GSAP Animations (optimized) initialized');
})();