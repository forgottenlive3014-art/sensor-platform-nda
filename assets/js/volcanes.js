// ============================================================
// VOLCANES - ANIMACIONES GSAP
// ============================================================

(function() {
    'use strict';

    // ============================================================
    // PARTICULAS VOLCÁNICAS
    // ============================================================
    function initParticles() {
        // Buscar partículas en el banner
        const banner = document.querySelector('.v-hero');
        if (!banner) return;

        // Crear contenedor de partículas
        const container = document.createElement('div');
        container.style.cssText = `
            position: absolute;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
            z-index: 0;
        `;
        banner.prepend(container);

        const colors = ['#e0631f', '#f97316', '#ff6b35', '#ff4500', '#ff8c00'];
        const count = 25;

        // Estilo de las partículas
        const style = document.createElement('style');
        style.textContent = `
            .v-particle {
                position: absolute;
                border-radius: 50%;
                opacity: 0;
                pointer-events: none;
                animation: vParticleRise var(--v-duration) ease-in var(--v-delay) infinite;
                box-shadow: 0 0 10px var(--v-color);
                will-change: transform, opacity;
            }
            @keyframes vParticleRise {
                0% {
                    transform: translateY(0) translateX(0) scale(1);
                    opacity: 0;
                }
                15% {
                    opacity: 0.9;
                }
                85% {
                    opacity: 0.7;
                }
                100% {
                    transform: translateY(var(--v-rise)) translateX(var(--v-drift)) scale(0.3);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);

        for (let i = 0; i < count; i++) {
            const particle = document.createElement('span');
            particle.className = 'v-particle';
            const size = 3 + Math.random() * 8;
            const x = 10 + Math.random() * 80;
            const delay = Math.random() * 4;
            const duration = 2.5 + Math.random() * 3;
            const color = colors[Math.floor(Math.random() * colors.length)];
            const rise = 80 + Math.random() * 120;
            const drift = (Math.random() > 0.5 ? '' : '-') + (10 + Math.random() * 30);

            particle.style.cssText = `
                left: ${x}%;
                bottom: 0;
                width: ${size}px;
                height: ${size}px;
                background: ${color};
                --v-color: ${color};
                --v-duration: ${duration}s;
                --v-delay: ${delay}s;
                --v-rise: -${rise}px;
                --v-drift: ${drift}px;
            `;
            container.appendChild(particle);
        }
    }

    // ============================================================
    // ANIMACIONES GSAP
    // ============================================================
    function initGSAP() {
        if (typeof gsap === 'undefined') {
            console.warn('GSAP no está disponible');
            return;
        }

        gsap.registerPlugin(ScrollTrigger);

        const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (prefersReduced) return;

        // ============================================================
        // SELECTORES
        // ============================================================
        const CARD_SELECTORS = [
            '.v-card', '.v-stat', '.v-timeline-item',
            '.v-alerta', '.v-tab-item', '.v-gallery-item'
        ].join(', ');

        // ============================================================
        // CONFIGURACIÓN
        // ============================================================
        const DEFAULTS = {
            duration: 0.4,
            stagger: 0.05,
            ease: 'power1.out',
            y: 15
        };

        // ============================================================
        // WILL-CHANGE
        // ============================================================
        document.querySelectorAll(CARD_SELECTORS).forEach(el => {
            if (el.closest('.reveal')) return;
            el.style.willChange = 'transform, opacity';
        });

        // ============================================================
        // TARJETAS
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
                start: 'top 90%',
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
        // TÍTULOS Y TEXTOS
        // ============================================================
        const TEXT_SELECTORS = [
            '.v-header', '.v-intro', '.v-why',
            '.v-note', '.v-hero-title', '.v-hero-desc'
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
        // IMÁGENES
        // ============================================================
        const IMAGE_SELECTORS = [
            '.v-gallery-item', '.v-card-img', '.v-carousel-image',
            '.v-diagram-image', '.v-mapa'
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
        // NÚMEROS DE CARRUSEL
        // ============================================================
        document.querySelectorAll('.v-carousel-num').forEach(el => {
            if (el.closest('.reveal')) return;
            gsap.fromTo(el, { opacity: 0, scale: 0.6 }, {
                opacity: 1,
                scale: 1,
                duration: 0.4,
                ease: 'power1.out',
                scrollTrigger: { trigger: el, start: 'top 92%', once: true }
            });
        });

        // ============================================================
        // CONTADORES
        // ============================================================
        document.querySelectorAll('.v-stat-num').forEach(el => {
            if (el.closest('.reveal')) return;
            const target = el.textContent;
            const num = parseInt(target);
            if (!isNaN(num)) {
                const obj = { val: 0 };
                ScrollTrigger.create({
                    trigger: el,
                    start: 'top 92%',
                    once: true,
                    onEnter: () => gsap.to(obj, {
                        val: num,
                        duration: 1.2,
                        ease: 'power1.out',
                        onUpdate: () => {
                            el.textContent = Math.round(obj.val);
                        }
                    })
                });
            }
        });

        // ============================================================
        // HOVER EFFECTS
        // ============================================================
        const HOVER_SELECTORS = [
            '.v-card', '.v-stat', '.v-timeline-item',
            '.v-alerta', '.v-tab-item', '.v-gallery-item'
        ].join(', ');

        document.querySelectorAll(HOVER_SELECTORS).forEach(el => {
            el.addEventListener('mouseenter', () => {
                gsap.to(el, { y: -3, duration: 0.15, ease: 'power1.out' });
            });
            el.addEventListener('mouseleave', () => {
                gsap.to(el, { y: 0, duration: 0.2, ease: 'power1.out' });
            });
        });

        // ============================================================
        // ANIMACIÓN ESPECIAL: TIMELINE
        // ============================================================
        gsap.from('.v-timeline-item', {
            opacity: 0,
            x: -15,
            duration: 0.4,
            stagger: 0.08,
            scrollTrigger: {
                trigger: '.v-timeline-items',
                start: 'top 88%',
                once: true
            }
        });

        // ============================================================
        // ANIMACIÓN ESPECIAL: ALERTAS
        // ============================================================
        gsap.from('.v-alerta', {
            opacity: 0,
            y: 20,
            duration: 0.4,
            stagger: 0.08,
            scrollTrigger: {
                trigger: '.v-alertas-grid',
                start: 'top 88%',
                once: true
            }
        });

        // ============================================================
        // ANIMACIÓN ESPECIAL: DIAGRAMA PINS
        // ============================================================
        document.querySelectorAll('.v-diagram-pin').forEach(pin => {
            gsap.from(pin, {
                opacity: 0,
                scale: 0.5,
                duration: 0.4,
                delay: 0.1,
                scrollTrigger: {
                    trigger: pin,
                    start: 'top 85%',
                    once: true
                }
            });
        });

        // ============================================================
        // REFRESH
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

        console.log('Volcanes GSAP animations initialized');
    }

    // ============================================================
    // INICIALIZAR
    // ============================================================
    document.addEventListener('DOMContentLoaded', function() {
        initParticles();
        initGSAP();
    });

})();