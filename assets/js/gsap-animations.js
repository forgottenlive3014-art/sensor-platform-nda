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
        '.foco-image-card',
        // Paginas de desastres (desastres-base.css: tsunamis, inundaciones,
        // sequias, tormentas-tropicales, incendios-forestales, sismos)
        '.dis-info-card', '.dis-impact-card', '.dis-alert-card',
        '.dis-gallery-item', '.dis-action-col', '.dis-zone-chip',
        '.dis-context-card'
    ].join(', ');

    // ============================================================
    // CONFIGURACIÓN: fluida pero ligera (ScrollTrigger.batch + once:true
    // ya evitan el costo repetido, así que no hace falta recortar tanto
    // la duración/desplazamiento para que rinda bien)
    // ============================================================
    const DEFAULTS = {
        duration: 0.65,
        stagger: 0.08,
        ease: 'back.out(1.6)', // "pop": se pasa un poco y rebota, se nota mucho mas que un fade parejo
        x: 90, // entra deslizandose desde la derecha, no de abajo -- rompe la monotonia del scroll vertical
        scale: 0.9
    };

    // ============================================================
    // APLICAR will-change (solo a elementos visibles inicialmente)
    // ============================================================
    document.querySelectorAll(CARD_SELECTORS).forEach(el => {
        if (el.closest('.reveal')) return;
        el.style.willChange = 'transform, opacity';
    });

    // ============================================================
    // ANIMACIÓN DE TARJETAS: atada en vivo al scroll (scrub), no un
    // "aparece una vez y listo". Cada tarjeta tiene su propio ScrollTrigger
    // -- si scrolleas lento, se desliza lento; si volves para arriba, se
    // devuelve. ease:'none' porque con scrub la curva la da el scroll
    // mismo, un ease con rebote se ve raro atado a la posicion en vez del
    // tiempo.
    // ============================================================
    document.querySelectorAll(CARD_SELECTORS).forEach(el => {
        if (el.closest('.reveal')) return;
        gsap.fromTo(el,
            { opacity: 0, x: DEFAULTS.x, scale: DEFAULTS.scale },
            {
                opacity: 1,
                x: 0,
                scale: 1,
                ease: 'none',
                scrollTrigger: {
                    trigger: el,
                    start: 'top 90%',
                    end: 'top 55%',
                    scrub: 0.6,
                    // Limpia el transform inline al terminar de entrar:
                    // varias tarjetas (.dis-info-card, .dis-impact-card,
                    // .dis-alert-card...) ya tienen su propio transform en
                    // :hover via CSS -- sin esto, el que deja esta animacion
                    // se queda pisando ese hover para siempre.
                    onLeave: () => gsap.set(el, { clearProps: 'transform' })
                }
            }
        );
    });

    // ============================================================
    // TÍTULOS Y TEXTOS (animación muy sutil, casi imperceptible)
    // ============================================================
    const TEXT_SELECTORS = [
        '.sec-hd', '.page-title', '.rtm-title-area',
        '.sismo-intro-text', '.sismo-etymology', '.sv-description',
        '.sismo-sv-note', '.dis-bigbanner-word', '.dis-subhead'
    ].join(', ');

    document.querySelectorAll(TEXT_SELECTORS).forEach(el => {
        if (el.closest('.reveal')) return;
        gsap.fromTo(el, { opacity: 0, y: 10 }, {
            opacity: 1,
            y: 0,
            duration: 0.4,
            ease: 'power1.out',
            scrollTrigger: { trigger: el, start: 'top 92%', once: true }
        });
    });

    // ============================================================
    // IMÁGENES (fade + scale sutil, igual que en volcanes.js)
    // ============================================================
    const IMAGE_SELECTORS = [
        '.sismo-image-card', '.sv-image', '.step-image',
        '.type-card-image', '.wave-card-image', '.measure-image',
        '.guide-image', '.historic-image'
    ].join(', ');

    document.querySelectorAll(IMAGE_SELECTORS).forEach(el => {
        if (el.closest('.reveal')) return;
        gsap.fromTo(el, { opacity: 0, scale: 0.98 }, {
            opacity: 1,
            scale: 1,
            duration: 0.5,
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
        gsap.fromTo(el, { opacity: 0, x: -12 }, {
            opacity: 1,
            x: 0,
            duration: 0.45,
            ease: 'power1.out',
            scrollTrigger: { trigger: el, start: 'top 94%', once: true }
        });
    });

    // ============================================================
    // HOVER EFFECTS (duración alineada con --tr del sitio, 0.28s)
    // ============================================================
    const HOVER_SELECTORS = [
        '.mod-card', '.card', '.h3d-card', '.guide-card',
        '.sismo-step', '.type-card', '.wave-card', '.measure-card',
        '.historic-card', '.depth-card', '.term-card', '.sv-stat'
    ].join(', ');

    document.querySelectorAll(HOVER_SELECTORS).forEach(el => {
        el.addEventListener('mouseenter', () => {
            gsap.to(el, { y: -4, duration: 0.28, ease: 'power1.out' });
        });
        el.addEventListener('mouseleave', () => {
            gsap.to(el, { y: 0, duration: 0.28, ease: 'power1.out' });
        });
    });

    // ============================================================
    // CONTADORES (data-gsap-count, decimales opcionales via
    // data-gsap-decimals para numeros como "7.7")
    // ============================================================
    document.querySelectorAll('[data-gsap-count]').forEach(el => {
        const target = parseFloat(el.dataset.gsapCount) || 0;
        const decimals = parseInt(el.dataset.gsapDecimals, 10) || 0;
        const obj = { val: 0 };
        ScrollTrigger.create({
            trigger: el,
            start: 'top 92%',
            once: true,
            onEnter: () => gsap.to(obj, {
                val: target,
                duration: 0.9,
                ease: 'power1.out',
                onUpdate: () => { el.textContent = decimals ? obj.val.toFixed(decimals) : Math.round(obj.val); }
            })
        });
    });

    // ============================================================
    // CONTADORES AUTOMATICOS (.nda-count): a diferencia de data-gsap-count,
    // este lee el numero directo del texto que ya esta en el HTML (asi no
    // hay que duplicar el valor en un atributo aparte). Soporta un prefijo
    // no numerico ("~100") y un sufijo ("500+", "1.5M") que se preservan
    // tal cual y no se animan, solo la parte numerica. Si el texto no
    // matchea el patron (fechas, texto libre, etc.) no hace nada -- asi es
    // seguro agregar la clase sin tener que auditar cada caso a mano.
    // ============================================================
    document.querySelectorAll('.nda-count').forEach(el => {
        const raw = el.textContent.trim();
        const match = raw.match(/^(\D*)([\d.,]*\d)(\D*)$/);
        if (!match) return;
        const [, prefix, numStr, suffix] = match;
        const decimals = (numStr.split('.')[1] || '').length;
        const target = parseFloat(numStr.replace(/,/g, ''));
        if (isNaN(target)) return;
        const obj = { val: 0 };
        ScrollTrigger.create({
            trigger: el,
            start: 'top 92%',
            once: true,
            onEnter: () => gsap.to(obj, {
                val: target,
                duration: 0.9,
                ease: 'power1.out',
                onUpdate: () => {
                    const shown = decimals ? obj.val.toFixed(decimals) : Math.round(obj.val).toLocaleString('en-US');
                    el.textContent = prefix + shown + suffix;
                }
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