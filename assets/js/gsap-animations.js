/* ================================================================
   NDA — Animaciones GSAP (sitio completo)
   No toca elementos que ya usan el sistema propio de reveal (".reveal"),
   presente en algunas paginas de contenido — evita animar dos veces.
   ================================================================ */
(function () {
    if (typeof gsap === 'undefined') return;
    gsap.registerPlugin(ScrollTrigger);

    const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (prefersReduced) return;

    // ---------- Reveal en lote para tarjetas y bloques de contenido ----------
    const CARD_SELECTORS = [
        '.mod-card', '.card', '.data-card-3d', '.ahora-card', '.h3d-card',
        '.section-card', '.request-card', '.smc', '.rtm-stat', '.fbi',
        '.school-stat-card', '.wt-steps .wts', '.guide-card', '.blog-card',
        '.game-card', '.resource-card'
    ].join(', ');

    document.querySelectorAll(CARD_SELECTORS).forEach(el => {
        if (el.closest('.reveal')) return; // ya animado por el sistema propio de la pagina
        el.style.willChange = 'transform, opacity';
    });

    // Agrupa por contenedor padre para que el stagger se vea coordinado
    const groups = new Map();
    document.querySelectorAll(CARD_SELECTORS).forEach(el => {
        if (el.closest('.reveal')) return;
        const parent = el.parentElement;
        if (!groups.has(parent)) groups.set(parent, []);
        groups.get(parent).push(el);
    });

    groups.forEach(items => {
        if (!items.length) return;
        gsap.set(items, { opacity: 0, y: 28 });
        ScrollTrigger.batch(items, {
            start: 'top 88%',
            once: true,
            onEnter: batch => gsap.to(batch, {
                opacity: 1, y: 0, duration: 0.65, ease: 'power2.out',
                stagger: 0.08, overwrite: true
            })
        });
    });

    // ---------- Encabezados de sección ----------
    document.querySelectorAll('.sec-hd, .page-title, .rtm-title-area, .section-group h4').forEach(el => {
        if (el.closest('.reveal')) return;
        gsap.fromTo(el, { opacity: 0, x: -18 }, {
            opacity: 1, x: 0, duration: 0.6, ease: 'power2.out',
            scrollTrigger: { trigger: el, start: 'top 90%', once: true }
        });
    });

    // ---------- Micro-interaccion: elevar tarjetas al pasar el mouse ----------
    document.querySelectorAll('.mod-card, .card, .h3d-card, .section-card, .guide-card, .blog-card, .game-card').forEach(el => {
        el.addEventListener('mouseenter', () => {
            gsap.to(el, { y: -6, duration: 0.25, ease: 'power2.out' });
        });
        el.addEventListener('mouseleave', () => {
            gsap.to(el, { y: 0, duration: 0.3, ease: 'power2.out' });
        });
    });

    // ---------- Contadores numericos con GSAP (stats con data-count) ----------
    document.querySelectorAll('[data-gsap-count]').forEach(el => {
        const target = parseFloat(el.dataset.gsapCount) || 0;
        const obj = { val: 0 };
        ScrollTrigger.create({
            trigger: el,
            start: 'top 90%',
            once: true,
            onEnter: () => gsap.to(obj, {
                val: target, duration: 1.4, ease: 'power1.out',
                onUpdate: () => { el.textContent = Math.round(obj.val); }
            })
        });
    });

    // Refresca ScrollTrigger cuando el layout cambia bastante (p. ej. al
    // abrir/cerrar tabs del modulo escolar, que muestran/ocultan contenido).
    document.addEventListener('click', () => {
        setTimeout(() => ScrollTrigger.refresh(), 350);
    });
})();
