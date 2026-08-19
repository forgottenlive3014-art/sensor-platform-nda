
import * as THREE from 'three';
import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';

const MODEL_DIR = 'assets/modelos3d/';

// Archivos .glb reales ya colocados en assets/modelos3d/ (nombres tal cual
// se descargaron, no siguen la convencion "<slug>.glb"). Cuando un slug
// tiene varios archivos, se elige uno al azar cada vez que se monta la
// escena, para variar el diorama que se ve en cada visita/tarjeta.
const MODEL_FILES = {
    'volcanes': ['volcan.glb'],
    // deslizamiento.glb (77.9 MB, sin comprimir) se cambio por estas 4
    // variantes (2-2.8 MB cada una) que ya estaban en la carpeta: cargan en
    // un instante en vez de tardar decenas de segundos por archivo.
    'deslizamientos': ['deslizamiento.glb'],
    'sismos': ['sismo.glb'],
    'tsunamis': ['tsunami.glb'],
    'inundaciones': ['inundacion.glb'],
    'incendios-forestales': ['incendio.glb'],
    'tormentas-tropicales': ['tormentasTropicales.glb'],
    'sequias': ['sequía.glb'],
};

const SCENES = {
    'sismos':                { bg: 0x0c0f14, ground: 'shake',   accent: 0xff5500, mist: 0x6b7280, particles: 'dust' },
    'volcanes':              { bg: 0x140a08, ground: 'cone',    accent: 0xff5500, mist: 0x3a2a20, particles: 'embers' },
    'tsunamis':              { bg: 0x081018, ground: 'wave',    accent: 0x3d9bff, mist: 0x123a52, particles: 'foam' },
    'inundaciones':          { bg: 0x081018, ground: 'flood',   accent: 0x2e7da6, mist: 0x2a3b30, particles: 'rain' },
    'deslizamientos':        { bg: 0x0e0c08, ground: 'incline', accent: 0xc9a86a, mist: 0x5a4a30, particles: 'rocks' },
    'incendios-forestales':  { bg: 0x0e0704, ground: 'flat',    accent: 0xff5500, mist: 0x1a1410, particles: 'embers' },
    'tormentas-tropicales':  { bg: 0x0a0e16, ground: 'none',    accent: 0xcfd8e3, mist: 0x1a2233, particles: 'spiral' },
    'sequias':               { bg: 0x140d06, ground: 'cracked', accent: 0xd9b06a, mist: 0x8a6a3a, particles: 'heat' },
};

const activeViewers = new Map(); // container -> Viewer, para desmontar limpio

class Viewer {
    constructor(container, slug) {
        this.container = container;
        this.slug = slug;
        this.cfg = SCENES[slug] || SCENES['sismos'];
        this.disposed = false;
    }

    async mount() {
        const { container, cfg } = this;
        const w = container.clientWidth || 300, h = container.clientHeight || 300;

        const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
        // alpha:true en el constructor solo habilita el canal alfa del canvas;
        // el color de "clear" por defecto sigue siendo negro 100% opaco hasta
        // que se pone en 0 aqui. Sin esto, cada frame se limpiaba a negro
        // opaco y tapaba por completo la foto de fondo puesta en CSS.
        renderer.setClearColor(0x000000, 0);
        renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
        renderer.setSize(w, h);
        renderer.domElement.style.cssText = 'width:100%;height:100%;display:block;cursor:grab';
        container.innerHTML = '';
        container.appendChild(renderer.domElement);
        this.renderer = renderer;

        const scene = new THREE.Scene();
        // Sin scene.background: el canvas queda transparente (renderer con
        // alpha:true) para que se vea la foto de fondo puesta en CSS
        // (--sk-bg-img) detras del modelo, en vez de un color solido fijo
        // que además no cambiaba con el tema claro/oscuro del sitio.
        scene.fog = new THREE.FogExp2(cfg.bg, 0.05);
        this.scene = scene;

        const camera = new THREE.PerspectiveCamera(38, w / h, 0.1, 100);
        this.camera = camera;

        scene.add(new THREE.AmbientLight(0xffffff, 0.6));
        const key = new THREE.DirectionalLight(0xffffff, 1.1);
        key.position.set(4, 6, 5);
        scene.add(key);
        const accentLight = new THREE.PointLight(cfg.accent, 1.3, 12);
        accentLight.position.set(0, 1.6, 1.5);
        scene.add(accentLight);
        this.accentLight = accentLight;

        // Orbita manual con arrastre (mismo patron que assets/js/moon3d.js).
        let az = 0.5, elv = 0.32, dist = 4.6, autoRotate = true, dragging = false, lastX = 0, lastY = 0;
        const updateCam = () => {
            camera.position.set(dist * Math.cos(elv) * Math.sin(az), dist * Math.sin(elv), dist * Math.cos(elv) * Math.cos(az));
            camera.lookAt(0, 0.3, 0);
        };
        updateCam();
        const down = (x, y) => { dragging = true; autoRotate = false; lastX = x; lastY = y; };
        const move = (x, y) => {
            if (!dragging) return;
            az += (x - lastX) * 0.006;
            elv = Math.max(-0.2, Math.min(1.3, elv + (y - lastY) * 0.006));
            lastX = x; lastY = y;
            updateCam();
        };
        const up = () => { dragging = false; };
        const el = renderer.domElement;
        el.addEventListener('mousedown', e => down(e.clientX, e.clientY));
        window.addEventListener('mousemove', e => move(e.clientX, e.clientY));
        window.addEventListener('mouseup', up);
        el.addEventListener('touchstart', e => { const t = e.touches[0]; down(t.clientX, t.clientY); }, { passive: true });
        el.addEventListener('touchmove', e => { const t = e.touches[0]; move(t.clientX, t.clientY); }, { passive: true });
        el.addEventListener('touchend', up);
        this._cleanupDrag = () => {
            window.removeEventListener('mousemove', move);
            window.removeEventListener('mouseup', up);
        };
        this._isAutoRotating = () => autoRotate;
        this._spinCamera = (dt) => { az += dt; updateCam(); };

        // Intenta un modelo .glb real primero (uno al azar si el slug tiene
        // varios archivos); si no hay ninguno o falla la carga, respaldo
        // procedural.
        const candidates = MODEL_FILES[this.slug] || [this.slug + '.glb'];
        const chosenFile = candidates[Math.floor(Math.random() * candidates.length)];

        // Indicador de progreso mientras carga (algunos .glb todavia pesan
        // varias decenas de MB): sin esto, el visor se ve vacio y sin
        // respuesta durante la espera.
        const progressEl = document.createElement('div');
        progressEl.style.cssText = 'position:absolute;inset:0;display:flex;align-items:center;justify-content:center;font:700 .8rem var(--fn,sans-serif);color:#fff;text-shadow:0 1px 4px rgba(0,0,0,.6);pointer-events:none;z-index:2;';
        progressEl.textContent = 'Cargando…';
        container.style.position = container.style.position || 'relative';
        container.appendChild(progressEl);
        this._progressEl = progressEl;

        try {
            const gltf = await new Promise((resolve, reject) => {
                new GLTFLoader().load(
                    MODEL_DIR + encodeURIComponent(chosenFile),
                    resolve,
                    (evt) => {
                        if (progressEl.isConnected && evt.lengthComputable) {
                            progressEl.textContent = 'Cargando… ' + Math.round((evt.loaded / evt.total) * 100) + '%';
                        }
                    },
                    reject
                );
            });
            progressEl.remove();
            const model = gltf.scene;
            const box = new THREE.Box3().setFromObject(model);
            const size = new THREE.Vector3();
            box.getSize(size);
            // 2.9 en vez de 2.6: modelo mas grande dentro del mismo encuadre,
            // sin tocar la camara (dist/lookAt) para no romper el centrado.
            const scale = 2.9 / Math.max(size.x, size.y, size.z, 0.001);
            model.scale.setScalar(scale);
            const center = new THREE.Vector3();
            box.getCenter(center);
            model.position.sub(center.multiplyScalar(scale));
            scene.add(model);
            this.model = model;
        } catch (e) {
            progressEl.remove();
            this.buildProcedural(cfg);
        }

        const clock = new THREE.Clock();
        const animate = () => {
            if (this.disposed) return;
            this._raf = requestAnimationFrame(animate);
            const t = clock.getElapsedTime();
            if (this._isAutoRotating()) this._spinCamera(0.0022);
            this.tick(t);
            if (cfg.lightning) {
                this.tickLightning(t);
            } else {
                accentLight.intensity = 1.1 + Math.sin(t * 3) * 0.3;
            }
            if (this.model && this._isAutoRotating()) this.model.rotation.y = t * 0.15;
            renderer.render(scene, camera);
        };
        animate();

        this._resize = () => {
            const nw = container.clientWidth || w, nh = container.clientHeight || h;
            renderer.setSize(nw, nh);
            camera.aspect = nw / nh;
            camera.updateProjectionMatrix();
        };
        window.addEventListener('resize', this._resize);
        // Corrige el tamano si al montar el contenedor todavia media 0 (layout no pintado aun).
        setTimeout(this._resize, 60);
    }

    buildProcedural(cfg) {
        const { scene } = this;
        const groundMat = new THREE.MeshStandardMaterial({ color: cfg.mist, roughness: 0.95, metalness: 0.05, flatShading: true });

        if (cfg.ground === 'cone') {
            const cone = new THREE.Mesh(new THREE.ConeGeometry(1.4, 2.2, 24, 4, true), groundMat);
            cone.position.y = -0.6;
            scene.add(cone);
            const crater = new THREE.Mesh(new THREE.CircleGeometry(0.35, 24), new THREE.MeshBasicMaterial({ color: cfg.accent }));
            crater.rotation.x = -Math.PI / 2;
            crater.position.y = 0.52;
            scene.add(crater);
            this.accentLight.position.set(0, 0.6, 0);
        } else if (cfg.ground === 'incline') {
            const plane = new THREE.Mesh(new THREE.PlaneGeometry(6, 6), groundMat);
            plane.rotation.x = -Math.PI / 2.6;
            plane.position.y = -1.1;
            scene.add(plane);
        } else if (cfg.ground === 'lahar') {
            // Volcan de origen al fondo + ladera inclinada por donde baja el
            // flujo de lodo volcanico (las particulas 'mudflow' de abajo).
            const plane = new THREE.Mesh(new THREE.PlaneGeometry(6, 6), groundMat);
            plane.rotation.x = -Math.PI / 2.7;
            plane.position.y = -1.1;
            scene.add(plane);
            const cone = new THREE.Mesh(new THREE.ConeGeometry(1, 1.8, 20, 3, true), new THREE.MeshStandardMaterial({ color: 0x3a2a20, roughness: 0.95, flatShading: true }));
            cone.position.set(-0.6, 0.55, -1.6);
            scene.add(cone);
        } else if (cfg.ground === 'none') {
            // Tormenta tropical: sin piso, solo la espiral de nubes (particulas).
        } else {
            const segs = (cfg.ground === 'shake' || cfg.ground === 'wave' || cfg.ground === 'cracked') ? 40 : 1;
            const mat = cfg.ground === 'wave'
                ? new THREE.MeshStandardMaterial({ color: cfg.accent, roughness: 0.25, metalness: 0.1, transparent: true, opacity: 0.88, flatShading: true })
                : groundMat;
            const plane = new THREE.Mesh(new THREE.PlaneGeometry(6, 6, segs, segs), mat);
            plane.rotation.x = -Math.PI / 2;
            plane.position.y = cfg.ground === 'flood' ? -0.9 : -1.1;
            scene.add(plane);
            this.ground = plane;
            if (cfg.ground === 'cracked') {
                const pos = plane.geometry.attributes.position;
                for (let i = 0; i < pos.count; i++) pos.setZ(i, (Math.random() - 0.5) * 0.06);
                pos.needsUpdate = true;
                plane.geometry.computeVertexNormals();
            }
        }

        if (cfg.ground === 'flood') {
            const water = new THREE.Mesh(
                new THREE.PlaneGeometry(6, 6, 30, 30),
                new THREE.MeshStandardMaterial({ color: cfg.accent, transparent: true, opacity: 0.75, roughness: 0.3 })
            );
            water.rotation.x = -Math.PI / 2;
            water.position.y = -0.35;
            scene.add(water);
            this.water = water;
            for (let i = 0; i < 6; i++) {
                const box = new THREE.Mesh(new THREE.BoxGeometry(0.4, 0.9, 0.4), new THREE.MeshStandardMaterial({ color: 0x555b66, flatShading: true }));
                box.position.set((Math.random() - 0.5) * 4, -0.55, (Math.random() - 0.5) * 4);
                scene.add(box);
            }
        }

        if (cfg.ground === 'shake') {
            this.buildings = [];
            for (let i = 0; i < 10; i++) {
                const bh = 0.6 + Math.random() * 1.1;
                const box = new THREE.Mesh(new THREE.BoxGeometry(0.35, bh, 0.35), new THREE.MeshStandardMaterial({ color: 0x9aa3ad, flatShading: true }));
                box.position.set((Math.random() - 0.5) * 4.4, -1.1 + bh / 2, (Math.random() - 0.5) * 4.4);
                box.userData.baseX = box.position.x;
                box.userData.phase = Math.random() * Math.PI * 2;
                scene.add(box);
                this.buildings.push(box);
            }
        }

        if (this.slug === 'incendios-forestales') {
            for (let i = 0; i < 9; i++) {
                const tree = new THREE.Mesh(new THREE.ConeGeometry(0.28, 0.9, 6), new THREE.MeshStandardMaterial({ color: 0x2e4a2a, flatShading: true }));
                tree.position.set((Math.random() - 0.5) * 4.6, -0.65, (Math.random() - 0.5) * 4.6);
                scene.add(tree);
            }
        }
        if (this.slug === 'sequias') {
            for (let i = 0; i < 4; i++) {
                const tree = new THREE.Mesh(new THREE.ConeGeometry(0.16, 0.6, 5), new THREE.MeshStandardMaterial({ color: 0x6b5a3a, flatShading: true }));
                tree.position.set((Math.random() - 0.5) * 4, -0.8, (Math.random() - 0.5) * 4);
                scene.add(tree);
            }
        }

        // ---- Particulas (humo, embers, lluvia, rocas, espiral de nubes...) ----
        const count = cfg.particles === 'spiral' ? 700 : 220;
        const geo = new THREE.BufferGeometry();
        const pos = new Float32Array(count * 3);
        const seed = new Float32Array(count);
        for (let i = 0; i < count; i++) {
            seed[i] = Math.random();
            if (cfg.particles === 'spiral') {
                const r = 0.3 + Math.random() * 2.4;
                const a = Math.random() * Math.PI * 2;
                pos[i * 3] = Math.cos(a) * r;
                pos[i * 3 + 1] = (Math.random() - 0.5) * 0.6;
                pos[i * 3 + 2] = Math.sin(a) * r;
            } else {
                pos[i * 3] = (Math.random() - 0.5) * 4.5;
                pos[i * 3 + 1] = Math.random() * 2.4 - (cfg.particles === 'rain' ? 0 : 1.1);
                pos[i * 3 + 2] = (Math.random() - 0.5) * 4.5;
            }
        }
        geo.setAttribute('position', new THREE.BufferAttribute(pos, 3));
        const particleColor = cfg.particles === 'embers' ? cfg.accent
            : cfg.particles === 'foam' ? 0xdff3ff
            : cfg.particles === 'rain' ? 0x6fa8dc
            : cfg.particles === 'rocks' ? 0x5a4a30
            : cfg.particles === 'mudflow' ? 0x8a5a2c
            : cfg.particles === 'heat' ? 0xffd08a
            : cfg.particles === 'spiral' ? 0xcfd8e3
            : 0x9a9a9a;
        const mat = new THREE.PointsMaterial({
            color: particleColor,
            size: cfg.particles === 'rocks' ? 0.09 : cfg.particles === 'mudflow' ? 0.11 : cfg.particles === 'spiral' ? 0.05 : 0.055,
            transparent: true,
            opacity: cfg.particles === 'spiral' ? 0.55 : 0.85,
            blending: (cfg.particles === 'embers' || cfg.particles === 'heat') ? THREE.AdditiveBlending : THREE.NormalBlending,
            depthWrite: false,
        });
        const points = new THREE.Points(geo, mat);
        scene.add(points);
        this.points = points;
        this.seed = seed;
        this.particleCfg = cfg.particles;
    }

    tick(t) {
        if (this.ground && (this.cfg.ground === 'shake' || this.cfg.ground === 'wave')) {
            const pos = this.ground.geometry.attributes.position;
            const amp = this.cfg.ground === 'wave' ? 0.35 : 0.05;
            const freq = this.cfg.ground === 'wave' ? 1.1 : 3;
            const speed = this.cfg.ground === 'wave' ? 1.4 : 6;
            for (let i = 0; i < pos.count; i++) {
                pos.setZ(i, Math.sin(pos.getX(i) * freq + t * speed) * amp);
            }
            pos.needsUpdate = true;
            this.ground.geometry.computeVertexNormals();
        }
        if (this.water) this.water.position.y = -0.35 + Math.sin(t * 0.6) * 0.05;
        if (this.buildings) {
            this.buildings.forEach(b => {
                b.position.x = b.userData.baseX + Math.sin(t * 9 + b.userData.phase) * 0.035;
                b.rotation.z = Math.sin(t * 9 + b.userData.phase) * 0.02;
            });
        }
        if (this.points) {
            const pos = this.points.geometry.attributes.position;
            const n = pos.count;
            for (let i = 0; i < n; i++) {
                if (this.particleCfg === 'spiral') {
                    const x = pos.getX(i), z = pos.getZ(i);
                    const r = Math.sqrt(x * x + z * z);
                    const a = Math.atan2(z, x) + 0.006 + (1 / (r + 0.6)) * 0.018;
                    pos.setX(i, Math.cos(a) * r);
                    pos.setZ(i, Math.sin(a) * r);
                    pos.setY(i, pos.getY(i) + Math.sin(t + i) * 0.0007);
                    continue;
                }
                let y = pos.getY(i);
                if (this.particleCfg === 'embers' || this.particleCfg === 'heat') {
                    y += 0.006 + this.seed[i] * 0.006;
                    if (y > 2.2) y = -1.1;
                } else if (this.particleCfg === 'rain') {
                    y -= 0.05 + this.seed[i] * 0.03;
                    if (y < -1.1) y = 2.2;
                } else if (this.particleCfg === 'rocks') {
                    y -= 0.012;
                    if (y < -1.1) y = 1.6;
                } else if (this.particleCfg === 'mudflow') {
                    // Ladera del volcan hacia el frente: cae mas lento que
                    // 'rocks' (mas viscoso) y deriva un poco en X/Z al bajar.
                    y -= 0.007;
                    pos.setX(i, pos.getX(i) + 0.006);
                    pos.setZ(i, pos.getZ(i) + 0.004);
                    if (y < -1.1) {
                        y = 1.3;
                        pos.setX(i, -2.6 + this.seed[i] * 1.2);
                        pos.setZ(i, -2.4 + this.seed[i] * 1.2);
                    }
                } else {
                    y += Math.sin(t + i) * 0.001;
                }
                pos.setY(i, y);
            }
            pos.needsUpdate = true;
        }
    }

    // Relampago aleatorio para la escena de tormentas electricas: destello
    // corto de luz blanca a intervalos impredecibles (en vez del pulso suave
    // de --acc que usan las demas escenas).
    tickLightning(t) {
        if (this._flashUntil === undefined) {
            this._flashUntil = -1;
            this._nextFlashAt = t + 1 + Math.random() * 3;
        }
        if (t >= this._nextFlashAt && t > this._flashUntil) {
            this._flashUntil = t + 0.1 + Math.random() * 0.12;
            this._nextFlashAt = t + 1.5 + Math.random() * 4;
        }
        if (t < this._flashUntil) {
            this.accentLight.color.setHex(0xe8f2ff);
            this.accentLight.intensity = 6 + Math.random() * 4;
        } else {
            this.accentLight.color.setHex(this.cfg.accent);
            this.accentLight.intensity = 0.35;
        }
    }

    dispose() {
        this.disposed = true;
        if (this._raf) cancelAnimationFrame(this._raf);
        if (this._resize) window.removeEventListener('resize', this._resize);
        if (this._cleanupDrag) this._cleanupDrag();
        if (this._progressEl) this._progressEl.remove();
        if (this.renderer) {
            this.renderer.dispose();
            if (this.renderer.forceContextLoss) this.renderer.forceContextLoss();
        }
    }
}

window.NDA_Disaster3D = {
    mount(container, slug) {
        if (!container) return;
        this.unmount(container);
        const viewer = new Viewer(container, slug);
        activeViewers.set(container, viewer);
        viewer.mount();
    },
    unmount(container) {
        const prev = activeViewers.get(container);
        if (prev) {
            prev.dispose();
            activeViewers.delete(container);
        }
    },
};
