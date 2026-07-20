// NDA - Luna 3D en tiempo real (Three.js), con iluminacion real segun la
// fase actual (mismo calculo del ciclo sinodico que usa app.js). El usuario
// puede arrastrar para orbitar la camara alrededor de la luna.
(function () {
    const el = document.getElementById('moon3dContainer');
    if (!el || typeof ensureThreeLoaded !== 'function') return;

    const MOON_TEXTURE = 'https://raw.githubusercontent.com/mrdoob/three.js/dev/examples/textures/planets/moon_1024.jpg';

    function currentMoonPhaseRaw() {
        const synodic = 29.530588853;
        const known = new Date(2000, 0, 6, 18, 14);
        const now = new Date();
        return ((now - known) / 864e5 / synodic) % 1;
    }

    async function init() {
        await ensureThreeLoaded();
        if (!window.THREE) return;

        const width = el.clientWidth || 260;
        const height = el.clientHeight || 260;

        const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
        renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
        renderer.setSize(width, height);
        el.appendChild(renderer.domElement);

        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(32, width / height, 0.1, 100);

        // Camara orbital manual (azimut/elevacion), sin dependencias externas.
        let az = 0, el_ = 0.15, dist = 3.4;
        function updateCamera() {
            camera.position.set(
                dist * Math.cos(el_) * Math.sin(az),
                dist * Math.sin(el_),
                dist * Math.cos(el_) * Math.cos(az)
            );
            camera.lookAt(0, 0, 0);
        }
        updateCamera();

        // Estrellas de fondo
        const starGeo = new THREE.BufferGeometry();
        const starCount = 400;
        const starPos = new Float32Array(starCount * 3);
        for (let i = 0; i < starCount * 3; i++) starPos[i] = (Math.random() - 0.5) * 60;
        starGeo.setAttribute('position', new THREE.BufferAttribute(starPos, 3));
        const stars = new THREE.Points(starGeo, new THREE.PointsMaterial({ color: 0xffffff, size: 0.05 }));
        scene.add(stars);

        const geometry = new THREE.SphereGeometry(1, 64, 64);
        const loader = new THREE.TextureLoader();
        const material = new THREE.MeshPhongMaterial({ shininess: 2 });
        loader.load(MOON_TEXTURE, (tex) => { material.map = tex; material.needsUpdate = true; });
        const moon = new THREE.Mesh(geometry, material);
        scene.add(moon);

        scene.add(new THREE.AmbientLight(0x223344, 0.55)); // "earthshine" tenue en el lado oscuro
        const sun = new THREE.DirectionalLight(0xfff4e0, 1.6);
        scene.add(sun);

        function applyPhaseLighting() {
            const phase = currentMoonPhaseRaw();
            const theta = phase * Math.PI * 2;
            const D = 8;
            sun.position.set(Math.sin(theta) * D, 0.35 * D, -Math.cos(theta) * D);
        }
        applyPhaseLighting();
        setInterval(applyPhaseLighting, 60000); // recalcula cada minuto, la fase cambia muy despacio

        // Arrastre manual para orbitar
        let dragging = false, lastX = 0, lastY = 0;
        function pointerDown(x, y) { dragging = true; lastX = x; lastY = y; }
        function pointerMove(x, y) {
            if (!dragging) return;
            az += (x - lastX) * 0.008;
            el_ = Math.max(-1.3, Math.min(1.3, el_ + (y - lastY) * 0.008));
            lastX = x; lastY = y;
            updateCamera();
        }
        function pointerUp() { dragging = false; }

        el.style.cursor = 'grab';
        el.addEventListener('mousedown', (e) => pointerDown(e.clientX, e.clientY));
        window.addEventListener('mousemove', (e) => pointerMove(e.clientX, e.clientY));
        window.addEventListener('mouseup', pointerUp);
        el.addEventListener('touchstart', (e) => { const t = e.touches[0]; pointerDown(t.clientX, t.clientY); }, { passive: true });
        el.addEventListener('touchmove', (e) => { const t = e.touches[0]; pointerMove(t.clientX, t.clientY); }, { passive: true });
        el.addEventListener('touchend', pointerUp);

        let autoRotate = true;
        el.addEventListener('mousedown', () => { autoRotate = false; });
        el.addEventListener('touchstart', () => { autoRotate = false; }, { passive: true });

        function raf() {
            requestAnimationFrame(raf);
            if (autoRotate) { az += 0.0018; updateCamera(); }
            renderer.render(scene, camera);
        }
        raf();

        function resize() {
            const w = el.clientWidth || 260;
            const h = el.clientHeight || 260;
            renderer.setSize(w, h);
            camera.aspect = w / h;
            camera.updateProjectionMatrix();
        }
        window.addEventListener('resize', resize);
    }

    init();
})();
