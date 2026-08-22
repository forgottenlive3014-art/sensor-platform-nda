// NDA - Home: animaciones conectadas AL PROGRESO del scroll (parallax,
// barra de progreso, "colision" de placas tectonicas, dibujado de la linea
// de tiempo). Se separa de gsap-animations.js porque ese archivo solo hace
// fade-ins de una vez (once:true); aqui todo usa scrub:true, o sea que la
// posicion de cada elemento sigue el scroll en vivo, en vez de dispararse
// una sola vez al entrar en pantalla.
(function () {
    if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') return;
    gsap.registerPlugin(ScrollTrigger);

    // A diferencia de gsap-animations.js, aqui no se respeta
    // prefers-reduced-motion: son desplazamientos chicos (px, no saltos
    // bruscos) y el usuario pidio explicitamente mas movimiento conectado
    // al scroll en esta pagina.

    // ============================================================
    // BARRA DE PROGRESO DE SCROLL (creada por JS: si algo de esto
    // falla en cargar, simplemente no aparece, no rompe nada)
    // ============================================================
    const progressWrap = document.createElement('div');
    progressWrap.className = 'hp-progress';
    progressWrap.setAttribute('aria-hidden', 'true');
    const progressBar = document.createElement('div');
    progressBar.className = 'hp-progress-bar';
    progressWrap.appendChild(progressBar);
    document.body.appendChild(progressWrap);
    gsap.set(progressBar, { scaleX: 0, transformOrigin: 'left center' });

    ScrollTrigger.create({
        start: 0,
        end: 'max',
        onUpdate: self => gsap.set(progressBar, { scaleX: self.progress })
    });

    // ============================================================
    // PARALLAX: blobs decorativos de fondo (.hp-blob, agregados en
    // home.php dentro de las secciones con clase .hp-relative)
    // ============================================================
    document.querySelectorAll('.hp-blob').forEach(blob => {
        const speed = parseFloat(blob.dataset.speed) || 1;
        const section = blob.closest('section') || blob.parentElement;
        gsap.to(blob, {
            y: () => -130 * speed,
            ease: 'none',
            scrollTrigger: {
                trigger: section,
                start: 'top bottom',
                end: 'bottom top',
                scrub: true
            }
        });
    });

    // ============================================================
    // PLACAS TECTONICAS: Cocos y Caribe se acercan mientras se hace
    // scroll por la seccion, como si el scroll empujara las placas
    // ============================================================
    const plateBar = document.querySelector('.plate-bar');
    if (plateBar) {
        const cocos = plateBar.querySelector('.pb-cocos');
        const carib = plateBar.querySelector('.pb-carib');
        const res = plateBar.querySelector('.pb-res');
        const plateTl = gsap.timeline({
            scrollTrigger: {
                trigger: plateBar,
                start: 'top 85%',
                end: 'top 35%',
                scrub: true
            }
        });
        if (cocos) plateTl.to(cocos, { x: 16, ease: 'none' }, 0);
        if (carib) plateTl.to(carib, { x: -16, ease: 'none' }, 0);
        if (res) plateTl.fromTo(res, { opacity: 0.45, scale: 0.94 }, { opacity: 1, scale: 1, ease: 'none' }, 0);
    }

    // ============================================================
    // LINEA DE TIEMPO: se "dibuja" de izquierda a derecha al entrar
    // ============================================================
    const tlLine = document.querySelector('#timeline .tl-line');
    if (tlLine) {
        gsap.fromTo(tlLine, { scaleX: 0 }, {
            scaleX: 1,
            transformOrigin: 'left center',
            ease: 'none',
            scrollTrigger: {
                trigger: '#timeline .tl-wrap',
                start: 'top 80%',
                end: 'top 25%',
                scrub: true
            }
        });
    }

    // ============================================================
    // "QUE ENCONTRARAS": leve efecto ken-burns + parallax en los
    // videos de cada tarjeta (se anima el <video>, no la tarjeta,
    // para no pisar el transform del hover de .find-card en CSS)
    // ============================================================
    document.querySelectorAll('.find-cards-grid .find-card-visual video').forEach((video, i) => {
        gsap.set(video, { scale: 1.14, transformOrigin: 'center center' });
        const offset = i % 2 === 0 ? -12 : 12;
        gsap.to(video, {
            y: offset,
            ease: 'none',
            scrollTrigger: {
                trigger: video.closest('.find-card'),
                start: 'top bottom',
                end: 'bottom top',
                scrub: true
            }
        });
    });

    window.addEventListener('load', () => {
        setTimeout(() => ScrollTrigger.refresh(), 300);
    });

    console.log('Home scroll animations initialized');
})();
