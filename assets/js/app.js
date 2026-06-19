  
//  NDA - Natural Disaster Alert
//  TODOS LOS SCRIPTS ORDENADOS
  

  
//  1. THEME & NAV
  

let dark = true;

document.getElementById('themeBtn').onclick = () => {
    dark = !dark;
    document.documentElement.setAttribute('data-theme', dark ? 'dark' : 'light');
    document.getElementById('themeIco').textContent = dark ? '🌙' : '☀️';
};

document.getElementById('hamBtn').onclick = () => {
    document.getElementById('mobNav').classList.toggle('open');
};

const nav = document.getElementById('nav');
const stBtn = document.getElementById('scrollTop');

window.addEventListener('scroll', () => {
    nav.classList.toggle('scrolled', scrollY > 40);
    stBtn.classList.toggle('vis', scrollY > 380);
});

stBtn.onclick = () => window.scrollTo({ top: 0, behavior: 'smooth' });

  
//  2. HERO CANVAS - SEISMIC WAVE BACKGROUND
  

(function() {
    const c = document.getElementById('hcv');
    const ctx = c.getContext('2d');

    function resize() {
        c.width = c.offsetWidth;
        c.height = c.offsetHeight;
    }
    resize();
    window.addEventListener('resize', resize);

    const lines = Array.from({ length: 7 }, (_, i) => ({
        y: 0.12 + i * 0.13,
        phase: Math.random() * Math.PI * 2,
        freq: 0.022 + Math.random() * 0.016,
        amp: 5 + Math.random() * 20,
        speed: 0.011 + Math.random() * 0.009,
        col: i === 3 ? 'rgba(255,77,26,0.32)' : `rgba(255,77,26,${0.03 + i * 0.035})`
    }));

    function draw() {
        ctx.clearRect(0, 0, c.width, c.height);
        lines.forEach(l => {
            l.phase += l.speed;
            ctx.beginPath();
            ctx.strokeStyle = l.col;
            ctx.lineWidth = l.col.includes('.32') ? 1.5 : 0.9;
            for (let x = 0; x < c.width; x++) {
                const y = c.height * l.y +
                    Math.sin(x * l.freq + l.phase) * l.amp +
                    Math.sin(x * l.freq * 2.2 + l.phase * 1.7) * l.amp * 0.3;
                x === 0 ? ctx.moveTo(x, y) : ctx.lineTo(x, y);
            }
            ctx.stroke();
        });
        requestAnimationFrame(draw);
    }
    draw();
})();

  
//  3. HERO SEISMOGRAPH
  

(function() {
    const c = document.getElementById('heroSg');
    if (!c) return;
    const ctx = c.getContext('2d');
    let data = Array(300).fill(43),
        t = 0;

    function resize() {
        c.width = c.offsetWidth;
        c.height = 86;
    }
    resize();
    window.addEventListener('resize', resize);

    function draw() {
        ctx.clearRect(0, 0, c.width, c.height);
        ctx.fillStyle = '#0b1020';
        ctx.fillRect(0, 0, c.width, c.height);

        ctx.strokeStyle = 'rgba(255,255,255,.03)';
        ctx.lineWidth = 1;
        for (let y = 0; y < c.height; y += 14) {
            ctx.beginPath();
            ctx.moveTo(0, y);
            ctx.lineTo(c.width, y);
            ctx.stroke();
        }

        const n = (Math.random() - 0.5) * 4 + Math.sin(t * 0.08) * 3 + Math.sin(t * 0.19) * 1.5;
        data.push(c.height / 2 + n);
        data.shift();

        ctx.beginPath();
        ctx.strokeStyle = '#ff4d1a';
        ctx.lineWidth = 1.4;
        const step = c.width / data.length;
        data.forEach((v, i) => {
            i === 0 ? ctx.moveTo(0, v) : ctx.lineTo(i * step, v);
        });
        ctx.stroke();

        t++;
        requestAnimationFrame(draw);
    }
    draw();
})();

  
//  4. MAIN SEISMOGRAPH
  

let sgCurrentMag = 3,
    sgT = 0;

(function() {
    const c = document.getElementById('mainSg');
    if (!c) return;
    const ctx = c.getContext('2d');
    let data = Array(500).fill(70);
    const cols = {
        low: '#ff4d1a',
        mid: '#ff9900',
        high: '#ff2d4a',
        critical: '#ff0a30'
    };

    function resize() {
        c.width = c.offsetWidth;
        c.height = 140;
    }
    resize();
    window.addEventListener('resize', resize);

    function draw() {
        ctx.clearRect(0, 0, c.width, c.height);
        ctx.fillStyle = '#080c18';
        ctx.fillRect(0, 0, c.width, c.height);

        // Grid
        ctx.strokeStyle = 'rgba(255,255,255,.025)';
        ctx.lineWidth = 1;
        for (let y = 0; y < c.height; y += 20) {
            ctx.beginPath();
            ctx.moveTo(0, y);
            ctx.lineTo(c.width, y);
            ctx.stroke();
        }
        for (let x = 0; x < c.width; x += 50) {
            ctx.beginPath();
            ctx.moveTo(x, 0);
            ctx.lineTo(x, c.height);
            ctx.stroke();
        }

        const amp = Math.pow(10, (sgCurrentMag - 1) / 3) * 2;
        const clampAmp = Math.min(amp, c.height * 0.45);
        const noise = (Math.random() - 0.5) * clampAmp * 2 +
            Math.sin(sgT * 0.06) * clampAmp * 0.7 +
            Math.sin(sgT * 0.14) * clampAmp * 0.4;

        data.push(c.height / 2 + noise);
        data.shift();

        // Gradient fill
        const fillGrad = ctx.createLinearGradient(0, 0, 0, c.height);
        fillGrad.addColorStop(0, 'rgba(255,77,26,.0)');
        fillGrad.addColorStop(0.5, 'rgba(255,77,26,.08)');
        fillGrad.addColorStop(1, 'rgba(255,77,26,.0)');
        ctx.beginPath();
        ctx.fillStyle = fillGrad;
        const step = c.width / data.length;
        data.forEach((v, i) => {
            i === 0 ? ctx.moveTo(0, v) : ctx.lineTo(i * step, v);
        });
        ctx.lineTo(c.width, c.height);
        ctx.lineTo(0, c.height);
        ctx.closePath();
        ctx.fill();

        // Wave line
        ctx.beginPath();
        const col = sgCurrentMag >= 8 ? cols.critical :
            sgCurrentMag >= 7 ? cols.high :
            sgCurrentMag >= 5 ? cols.mid : cols.low;
        ctx.strokeStyle = col;
        ctx.lineWidth = 1.8;
        data.forEach((v, i) => {
            i === 0 ? ctx.moveTo(0, v) : ctx.lineTo(i * step, v);
        });
        ctx.stroke();

        // Glow for strong quakes
        if (sgCurrentMag >= 6) {
            ctx.shadowColor = col;
            ctx.shadowBlur = 6;
            ctx.beginPath();
            ctx.strokeStyle = col + '80';
            ctx.lineWidth = 3;
            data.slice(-50).forEach((v, i) => {
                const x = (data.length - 50 + i) * step;
                i === 0 ? ctx.moveTo(x, v) : ctx.lineTo(x, v);
            });
            ctx.stroke();
            ctx.shadowBlur = 0;
        }

        // Center line
        ctx.strokeStyle = 'rgba(255,255,255,.08)';
        ctx.lineWidth = 1;
        ctx.setLineDash([4, 4]);
        ctx.beginPath();
        ctx.moveTo(0, c.height / 2);
        ctx.lineTo(c.width, c.height / 2);
        ctx.stroke();
        ctx.setLineDash([]);

        sgT++;
        requestAnimationFrame(draw);
    }
    draw();
})();

// SG Controls
document.querySelectorAll('.sg-preset').forEach(btn => {
    btn.onclick = () => {
        document.querySelectorAll('.sg-preset').forEach(b => b.classList.remove('on', 'm3', 'm6', 'm7', 'm85'));
        document.querySelectorAll('.sg-preset').forEach(b => b.classList.add(b.dataset.cls));
        btn.classList.add('on');
        sgCurrentMag = parseFloat(btn.dataset.mag);
        document.getElementById('sgMagSlider').value = sgCurrentMag;
        document.getElementById('sgMagDisp').textContent = sgCurrentMag;
        document.getElementById('sgDepth').textContent = sgCurrentMag >= 7 ? '8 KM' : '36 KM';
        document.getElementById('sg-depth-v').textContent = (sgCurrentMag >= 7 ? '8' : '36') + ' km';
        document.getElementById('sg-depth-l').textContent = sgCurrentMag >= 7 ? 'corteza superior' : 'corteza media';
        document.getElementById('sg-last-mag').textContent = 'M' + sgCurrentMag;
    };
});

document.getElementById('sgMagSlider').oninput = function() {
    sgCurrentMag = parseFloat(this.value);
    document.getElementById('sgMagDisp').textContent = parseFloat(this.value).toFixed(1);
    document.querySelectorAll('.sg-preset').forEach(b => b.classList.remove('on'));
};

document.getElementById('sgReset').onclick = () => {
    sgCurrentMag = 3;
    document.getElementById('sgMagSlider').value = 3;
    document.getElementById('sgMagDisp').textContent = '3';
    document.querySelectorAll('.sg-preset').forEach(b => b.classList.remove('on'));
    document.querySelector('.sg-preset.m3').classList.add('on');
};

document.getElementById('simBtn').onclick = () => {
    sgCurrentMag = 8.5;
    document.getElementById('sgMagSlider').value = 8.5;
    document.getElementById('sgMagDisp').textContent = '8.5';
    document.querySelectorAll('.sg-preset').forEach(b => b.classList.remove('on'));
    document.querySelector('.sg-preset.m85').classList.add('on');
    document.getElementById('sgDepth').textContent = '8 KM';
    document.getElementById('sg-last-mag').textContent = 'M8.5';
    document.getElementById('sg-last-loc').textContent = 'San Miguel';
};

  
//  5. MICRO SEISMOGRAPH
  

(function() {
    const c = document.getElementById('microSg');
    if (!c) return;
    const ctx = c.getContext('2d');
    let data = Array(180).fill(27),
        t = 0;

    function resize() {
        c.width = c.offsetWidth;
        c.height = 55;
    }
    resize();
    window.addEventListener('resize', resize);

    function draw() {
        ctx.clearRect(0, 0, c.width, c.height);
        ctx.fillStyle = '#0a0e1a';
        ctx.fillRect(0, 0, c.width, c.height);

        const n = (Math.random() - 0.5) * 2 + Math.sin(t * 0.11) * 1.5;
        data.push(c.height / 2 + n);
        data.shift();

        ctx.beginPath();
        ctx.strokeStyle = 'rgba(0,212,176,.7)';
        ctx.lineWidth = 1.1;
        const step = c.width / data.length;
        data.forEach((v, i) => {
            i === 0 ? ctx.moveTo(0, v) : ctx.lineTo(i * step, v);
        });
        ctx.stroke();

        t++;
        requestAnimationFrame(draw);
    }
    draw();
})();

  
//  6. USGS EARTHQUAKE DATA
  

async function loadQuakes() {
    try {
        const url = 'https://earthquake.usgs.gov/fdsnws/event/1/query?format=geojson&minlatitude=8&maxlatitude=18&minlongitude=-95&maxlongitude=-82&limit=25&orderby=time&minmagnitude=1.5';
        const r = await fetch(url);
        const d = await r.json();
        const qs = d.features;
        if (!qs.length) throw 'empty';

        const now = Date.now();
        const h24 = qs.filter(q => now - q.properties.time < 86400000).length;
        const maxM = Math.max(...qs.map(q => q.properties.mag || 0));
        const avgD = Math.round(qs.reduce((s, q) => s + (q.geometry.coordinates[2] || 0), 0) / qs.length);

        // Hero stats
        document.getElementById('hp-quakes').textContent = h24;
        document.getElementById('hm-today').textContent = h24;
        document.getElementById('hm-max').textContent = maxM.toFixed(1);
        document.getElementById('hm-depth').textContent = avgD;

        // Side stats
        document.getElementById('sc-last').textContent = 'M' + maxM.toFixed(1);
        document.getElementById('sc-24h').textContent = h24;
        document.getElementById('sc-depth').innerHTML = avgD + '<span style="font-size:.8rem;color:var(--text3)">km</span>';

        const last = qs[0];
        document.getElementById('sc-time').textContent = new Date(last.properties.time).toLocaleString('es-SV', { month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' });

        // SG bar
        document.getElementById('sg-last-mag').textContent = 'M' + maxM.toFixed(1);
        document.getElementById('sg-last-loc').textContent = (qs[0].properties.place || '').split(' of ').pop()?.slice(0, 25) || '—';
        document.getElementById('sg-today').textContent = h24;
        document.getElementById('sg-depth-v').textContent = avgD + ' km';

        // Nav alert
        document.getElementById('navAlertText').textContent = `M${maxM.toFixed(1)} · ${(qs[0].properties.place || '').split(', ')[0]?.slice(0, 15)}`;

        // Feed
        const feed = document.getElementById('quakeFeed');
        feed.innerHTML = '';
        qs.slice(0, 18).forEach((q) => {
            const m = q.properties.mag || 0;
            const cls = m < 3 ? 'ml' : m < 5 ? 'mm' : 'mh';
            const dep = (q.geometry.coordinates[2] || 0).toFixed(0);
            const tm = new Date(q.properties.time).toLocaleString('es-SV', { month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' });
            const el = document.createElement('div');
            el.className = 'qfi';
            el.innerHTML = `<div class="qfi-mag ${cls}">${m.toFixed(1)}</div>
                            <div class="qfi-info">
                                <div class="qfi-place">${q.properties.place || '—'}</div>
                                <div class="qfi-meta">${tm}</div>
                            </div>
                            <div class="qfi-depth">Prof ${dep}km</div>`;
            feed.appendChild(el);
        });

        if (window._addQuakesToMap) window._addQuakesToMap(qs);
        if (window.updateRTMStats) window.updateRTMStats(qs);

    } catch (e) {
        document.getElementById('quakeFeed').innerHTML = '<div class="loading-s">⚠️ Error USGS — revisa conexión</div>';
        document.getElementById('navAlertText').textContent = 'Sistema activo';
    }
}

document.getElementById('refreshQ').onclick = loadQuakes;

  
//  7. PLATE TECTONICS CANVAS
  

(function() {
    const c = document.getElementById('plateCv');
    if (!c) return;
    const ctx = c.getContext('2d');
    const W = c.width,
        H = c.height;
    let t = 0;

    function draw() {
        ctx.clearRect(0, 0, W, H);
        ctx.fillStyle = '#0e1828';
        ctx.fillRect(0, 0, W, H);

        ctx.fillStyle = 'rgba(45,143,255,.5)';
        ctx.font = 'bold 9px Space Grotesk,sans-serif';
        ctx.fillText('Océano Pacífico', 10, 18);

        const shift = Math.sin(t * 0.025) * 5;

        // Cocos plate
        ctx.fillStyle = 'rgba(45,143,255,.18)';
        ctx.strokeStyle = 'rgba(45,143,255,.6)';
        ctx.lineWidth = 1.5;
        ctx.fillRect(12, 35, 130, 75);
        ctx.strokeRect(12, 35, 130, 75);
        ctx.fillStyle = 'rgba(45,143,255,.9)';
        ctx.font = 'bold 11px Space Grotesk,sans-serif';
        ctx.fillText('Placa de Cocos', 18, 80);
        ctx.fillStyle = 'rgba(45,143,255,.6)';
        ctx.font = '10px Space Grotesk,sans-serif';
        ctx.fillText('→ ' + Math.round(shift + 8) + 'cm/año', 18, 100);

        // Caribbean plate
        ctx.fillStyle = 'rgba(0,212,176,.15)';
        ctx.strokeStyle = 'rgba(0,212,176,.5)';
        ctx.lineWidth = 1.5;
        ctx.fillRect(100 + shift, 20, 165, 60);
        ctx.strokeRect(100 + shift, 20, 165, 60);
        ctx.fillStyle = 'rgba(0,212,176,.9)';
        ctx.font = 'bold 11px Space Grotesk,sans-serif';
        ctx.fillText('Placa del Caribe', 108 + shift, 46);

        // Subduction zone
        const subX = 100 + shift;
        ctx.strokeStyle = 'rgba(255,77,26,.7)';
        ctx.lineWidth = 2;
        ctx.setLineDash([5, 3]);
        ctx.beginPath();
        ctx.moveTo(subX, 20);
        ctx.lineTo(subX, 110);
        ctx.stroke();
        ctx.setLineDash([]);
        ctx.fillStyle = 'rgba(255,77,26,.8)';
        ctx.font = 'bold 8px Space Grotesk,sans-serif';
        ctx.fillText('zona de', subX + 3, 125);
        ctx.fillText('subducción', subX + 3, 135);

        // Earthquake dots
        const eq = [
            [subX - 15, 95],
            [subX + 8, 78],
            [subX - 5, 108]
        ];
        eq.forEach(([ex, ey], i) => {
            const pulse = Math.abs(Math.sin(t * 0.08 + i * 1.2));
            ctx.fillStyle = `rgba(255,77,26,${0.4 + pulse * 0.5})`;
            ctx.beginPath();
            ctx.arc(ex, ey, 3 + pulse * 2, 0, Math.PI * 2);
            ctx.fill();
        });

        t++;
        requestAnimationFrame(draw);
    }
    draw();
})();

  
//  8. EARTHQUAKE SIMULATOR
  

(function() {
    const magR = document.getElementById('simMag');
    const depR = document.getElementById('simDep');
    const disR = document.getElementById('simDist');
    const c = document.getElementById('simCanvas');
    if (!c) return;
    const ctx = c.getContext('2d');
    let simT = 0,
        simAnim = null,
        isRunning = false;

    function resize() {
        c.width = c.offsetWidth;
        c.height = 310;
    }
    resize();
    window.addEventListener('resize', resize);

    const mercs = [
        'Sin efecto', 'Imperceptible', 'Muy débil', 'Débil',
        'Moderado — vibran ventanas', 'Fuerte — objetos caen',
        'Muy fuerte — daños menores', 'Destructivo — edificios dañados',
        'Grave — colapso parcial', 'Ruinoso — colapso masivo',
        'Catastrófico', 'Devastador', 'Extinción local'
    ];

    function updateParams() {
        const m = parseFloat(magR.value),
            dep = parseInt(depR.value),
            dist = parseInt(disR.value);
        document.getElementById('simMagV').textContent = m.toFixed(1);
        document.getElementById('simDepV').textContent = dep + ' km';
        document.getElementById('simDistV').textContent = dist + ' km';
        document.getElementById('simSceneTitle').textContent = `Ciudad ficticia — ${dist}km del epicentro`;
        document.getElementById('simMagChip').textContent = 'M ' + m.toFixed(1);
        document.getElementById('simMagChip').className = 'chip ' + (m >= 7 ? 'r' : m >= 5 ? 'o' : 'g');

        const mi = Math.round(Math.max(0, Math.min(12, (m - Math.log10(dist + dep * 0.5) * 1.4) * 2.1)));
        const pct = Math.min(100, (mi / 12) * 100);
        document.getElementById('sibFill').style.width = pct + '%';
        document.getElementById('sibVal').textContent = Math.round(pct) + '%';

        const rN = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        document.getElementById('mercalliBox').innerHTML =
            `<strong>Intensidad Mercalli estimada: ${rN[Math.min(11, mi)]}</strong><br>${mercs[mi]}`;
    }

    [magR, depR, disR].forEach(r => r.addEventListener('input', updateParams));
    updateParams();

    function calcAmp() {
        const m = parseFloat(magR.value),
            dep = parseInt(depR.value),
            dist = parseInt(disR.value);
        return Math.max(0.4, (Math.pow(10, m * 0.55) / (dist * 0.7 + dep * 0.4)) * 2.2);
    }

    function drawFrame() {
        const W = c.width,
            H = c.height;
        const amp = calcAmp();
        ctx.clearRect(0, 0, W, H);

        // Sky
        const sky = ctx.createLinearGradient(0, 0, 0, H * 0.62);
        sky.addColorStop(0, amp > 10 ? '#200800' : '#06101f');
        sky.addColorStop(1, amp > 10 ? '#3d1500' : '#091526');
        ctx.fillStyle = sky;
        ctx.fillRect(0, 0, W, H * 0.65);

        // Stars
        if (amp < 8) {
            ctx.fillStyle = 'rgba(255,255,255,.4)';
            [
                [0.1, 0.1],
                [0.22, 0.07],
                [0.42, 0.05],
                [0.62, 0.1],
                [0.82, 0.06],
                [0.93, 0.12]
            ].forEach(([x, y]) => ctx.fillRect(W * x, H * y, 1.5, 1.5));
        }

        // Dust
        if (amp > 12) {
            for (let i = 0; i < 20; i++) {
                ctx.fillStyle = `rgba(180,80,20,${0.08 + Math.random() * 0.1})`;
                ctx.fillRect(Math.random() * W, Math.random() * H * 0.5 + Math.sin(simT * 0.03 + i) * 3, 2, 2);
            }
        }

        // Ground
        const gY = H * 0.65;
        const shk = Math.sin(simT * 0.28) * amp;
        const gGr = ctx.createLinearGradient(0, gY, 0, H);
        gGr.addColorStop(0, amp > 10 ? '#2e0c00' : '#0e2040');
        gGr.addColorStop(1, amp > 10 ? '#160500' : '#06101e');
        ctx.fillStyle = gGr;
        ctx.beginPath();
        ctx.moveTo(0, gY + shk * 0.3);
        for (let x = 0; x < W; x += 3) {
            ctx.lineTo(x, gY + Math.sin(x * 0.07 + simT * 0.22) * amp * 0.55 + shk * 0.3);
        }
        ctx.lineTo(W, H);
        ctx.lineTo(0, H);
        ctx.closePath();
        ctx.fill();

        // Cracks
        if (amp > 14) {
            ctx.strokeStyle = 'rgba(255,60,0,.45)';
            ctx.lineWidth = 1.5;
            [
                [0.18, 0.38],
                [0.52, 0.72],
                [0.76, 0.88]
            ].forEach(([s, e]) => {
                ctx.beginPath();
                ctx.moveTo(W * s + shk * 0.15, gY + 6);
                let cx = W * s;
                while (cx < W * e) {
                    cx += 7;
                    ctx.lineTo(cx + (Math.random() - 0.5) * 5, gY + 6 + (cx - W * s) * 0.32 + (Math.random() - 0.5) * 3);
                }
                ctx.stroke();
            });
        }

        // Buildings
        const bldgs = [
            { x: .07, w: .07, h: .5 }, { x: .16, w: .05, h: .34 }, { x: .23, w: .09, h: .63 },
            { x: .35, w: .06, h: .4 }, { x: .43, w: .1, h: .68 }, { x: .55, w: .06, h: .44 },
            { x: .63, w: .08, h: .57 }, { x: .73, w: .05, h: .37 }, { x: .81, w: .07, h: .5 },
            { x: .9, w: .05, h: .41 }
        ];
        bldgs.forEach((b, i) => {
            const bShk = shk * (1 + i * 0.06);
            const bx = W * b.x + bShk,
                bh = H * 0.58 * b.h,
                by = gY - bh + shk * 0.1,
                bw = W * b.w;
            ctx.save();
            ctx.translate(bx + bw / 2, gY + shk * 0.1);
            ctx.transform(1, Math.sin(simT * 0.28) * (amp * 0.0018), 0, 1, 0, 0);
            ctx.fillStyle = amp > 18 ? '#400a00' : '#0f2240';
            ctx.strokeStyle = amp > 10 ? 'rgba(255,77,26,.45)' : 'rgba(45,143,255,.28)';
            ctx.lineWidth = 1;
            ctx.fillRect(-bw / 2, -bh, bw, bh);
            ctx.strokeRect(-bw / 2, -bh, bw, bh);
            ctx.fillStyle = amp > 15 ? 'rgba(255,120,0,.45)' : 'rgba(100,190,255,.3)';
            for (let wy = -bh + 5; wy < -8; wy += 10) {
                for (let wx = -bw / 2 + 4; wx < bw / 2 - 7; wx += 9) {
                    ctx.fillRect(wx, wy, 4, 5);
                }
            }
            ctx.restore();
            if (amp > 20 && i % 3 === 0) {
                ctx.fillStyle = 'rgba(80,25,5,.8)';
                for (let r = 0; r < 5; r++) {
                    ctx.fillRect(bx + Math.random() * bw, gY - Math.random() * 10 + shk * 0.2, 4 + Math.random() * 5, 3 + Math.random() * 4);
                }
            }
        });

        // Epicenter
        const eX = W * 0.5 + Math.sin(simT * 0.03) * 15,
            eY = gY + 26;
        [50, 100, 155, 210].forEach((r, i) => {
            const op = Math.max(0, 0.6 - i * 0.13 - (simT * 0.012) % 0.5);
            ctx.beginPath();
            ctx.arc(eX, eY, r, 0, Math.PI * 2);
            ctx.strokeStyle = `rgba(255,77,26,${op})`;
            ctx.lineWidth = 1.4;
            ctx.stroke();
        });
        ctx.fillStyle = '#ff4d1a';
        ctx.beginPath();
        ctx.arc(eX, eY, 5, 0, Math.PI * 2);
        ctx.fill();
        ctx.fillStyle = 'rgba(255,77,26,.25)';
        ctx.beginPath();
        ctx.arc(eX, eY, 11, 0, Math.PI * 2);
        ctx.fill();
        ctx.fillStyle = 'rgba(255,255,255,.65)';
        ctx.font = '10px Space Grotesk,sans-serif';
        ctx.fillText('⭐ Epicentro', eX + 13, eY + 4);

        simT++;
        simAnim = requestAnimationFrame(drawFrame);
    }

    document.getElementById('runSim').onclick = () => {
        updateParams();
        if (simAnim) cancelAnimationFrame(simAnim);
        isRunning = true;
        drawFrame();
    };
    drawFrame();
})();

  
//  9. TIMELINE
  

const tlData = [
    { year: '1854', title: 'Gran Terremoto de San Salvador', mag: '~6.5', deaths: '~100', region: 'San Salvador, Cuscatlán',
        desc: 'Destruyó gran parte de la capital colonial. Los edificios de adobe y bahareque colapsaron masivamente, obligando a la reconstrucción del centro histórico.',
        tags: [{ t: 'Histórico', c: '' }, { t: 'Adobe', c: 'o' }, { t: 'San Salvador', c: 'r' }],
        stats: [{ v: '~6.5', l: 'Magnitud' }, { v: '~100', l: 'Fallecidos' }, { v: '1854', l: 'Año' }],
        img: 'assets/media/img/1854.jpg'
    },
    { year: '1917', title: 'Sismo y Erupción del Santa Ana', mag: '~6.7', deaths: '~150', region: 'Occidente, Sonsonate',
        desc: 'Terremoto acompañado de erupción volcánica en el Santa Ana. Causó incendios y destrucción masiva en el occidente. Los daños se extendieron por múltiples departamentos.',
        tags: [{ t: 'Volcánico', c: 'o' }, { t: 'Occidente', c: '' }, { t: 'M6.7', c: 'r' }],
        stats: [{ v: '~6.7', l: 'Magnitud' }, { v: '~150', l: 'Fallecidos' }, { v: '1917', l: 'Año' }],
        img: 'assets/media/img/1917.jpg'
    },
    { year: '1965', title: 'Terremoto de San Salvador', mag: '6.2', deaths: '125', region: 'San Salvador, La Libertad',
        desc: 'Sismo que causó daños significativos en la capital con 125 muertos y miles de damnificados. Evidenció la vulnerabilidad urbana y llevó a nuevas normativas de construcción.',
        tags: [{ t: 'M 6.2', c: 'o' }, { t: 'Capital', c: '' }, { t: 'Normativa', c: 't' }],
        stats: [{ v: '6.2', l: 'Magnitud' }, { v: '125', l: 'Fallecidos' }, { v: '1965', l: 'Año' }],
        img: 'assets/media/img/1965.jpg'
    },
    { year: '1986', title: '10 de Octubre: El Gran Sismo', mag: '5.7', deaths: '1,500', region: 'San Salvador, AMSS',
        desc: 'A las 11:49am un sismo de 5.7 destruyó colonias enteras. 1,500 muertos, 10,000 heridos, 100,000 sin hogar. La poca profundidad y el epicentro bajo la capital lo hicieron catastrófico.',
        tags: [{ t: 'Catastrófico', c: 'r' }, { t: '10-Oct-1986', c: 'o' }, { t: 'Capital', c: '' }],
        stats: [{ v: '5.7', l: 'Magnitud' }, { v: '1,500', l: 'Fallecidos' }, { v: '100k', l: 'Sin hogar' }],
        img: 'assets/media/img/1986.jpeg'
    },
    { year: '2001', title: 'La Doble Tragedia Nacional', mag: '7.7 / 6.6', deaths: '1,259', region: 'Todo El Salvador',
        desc: '13 enero: M 7.7 — el más devastador del siglo. 1,200+ muertos, 8,000 heridos, 1.5 millones damnificados. Las Colinas fue sepultada. 13 febrero: M 6.6 golpeó cuando el país aún se recuperaba.',
        tags: [{ t: 'M 7.7', c: 'r' }, { t: 'M 6.6', c: 'r' }, { t: 'Doble sismo', c: 'o' }],
        stats: [{ v: '7.7', l: 'Magnitud' }, { v: '1,259', l: 'Fallecidos' }, { v: '1.5M', l: 'Damnificados' }],
        img: 'assets/media/img/2001.jpg'
    },
    { year: '2019', title: 'Enjambre Ilopango', mag: '4.9', deaths: '0', region: 'San Salvador, AMSS',
        desc: 'Más de 1,200 sismos en una semana. El M 4.9 principal generó pánico en el AMSS. Autoridades evacuaron edificios preventivamente. Demuestra la importancia de la preparación continua.',
        tags: [{ t: 'Enjambre', c: 'o' }, { t: 'AMSS', c: '' }, { t: '+1,200', c: 't' }],
        stats: [{ v: '4.9', l: 'Magnitud' }, { v: '1,200+', l: 'Sismos/sem' }, { v: '2019', l: 'Año' }],
        img: 'assets/media/img/2019.jpg'
    }
];

let tlActive = 4;

function renderTL() {
    const track = document.getElementById('tlTrack');
    track.innerHTML = tlData.map((e, i) =>
        `<div class="tl-item${i === tlActive ? ' active' : ''}" onclick="setTL(${i})">
            <div class="tli-year">${e.year}</div>
            <div class="tli-node"></div>
            <div class="tli-title">${e.title.split(' ').slice(0, 4).join(' ')}…</div>
        </div>`
    ).join('');

    const e = tlData[tlActive];
    document.getElementById('tlDetail').innerHTML = `
        <div class="tl-detail-inner">
            <div class="tld-img">
                <img src="${e.img}" alt="${e.title}" onerror="this.parentElement.style.background='linear-gradient(135deg,#182840,#0a1428)';this.style.display='none'"/>
                <div class="tld-img-ov"></div>
                <div style="position:absolute;bottom:12px;left:14px">
                    <div class="tld-img-yr">${e.year}</div>
                    <div class="tld-img-mag">M ${e.mag}</div>
                </div>
            </div>
            <div class="tld-info">
                <div class="tld-badge">📅 ${e.year}</div>
                <h3>${e.title}</h3>
                <p>${e.desc}</p>
                <div class="tld-tags">${e.tags.map(t => `<span class="tlt ${t.c}">${t.t}</span>`).join('')}</div>
                <div style="font-size:.76rem;color:var(--text3);margin-bottom:12px">📍 ${e.region}</div>
                <div class="tld-stats">${e.stats.map(s => `<div class="tlds"><div class="tlds-v">${s.v}</div><div class="tlds-l">${s.l}</div></div>`).join('')}</div>
                <div class="tld-nav">
                    ${tlActive > 0 ? `<button class="tldn-btn" onclick="setTL(${tlActive - 1})">← Anterior</button>` : ''}
                    ${tlActive < tlData.length - 1 ? `<button class="tldn-btn" onclick="setTL(${tlActive + 1})">Siguiente →</button>` : ''}
                </div>
            </div>
        </div>
    `;
}

window.setTL = function(i) {
    tlActive = i;
    renderTL();
};

  
//  10. ARDUINO DEMO
  

let ardRunning = false,
    ardT = 0,
    ardSimAnim = null;
let ardPhase = 0,
    ardPhaseT = 0;

const ardPhases = [
    { label: 'Normal', g: 0.05, cls: '', color: 'var(--teal)', level: 'normal',
        todo: ['Sistema monitoreando continuamente.', 'Vibración ambiental normal. Sin riesgo.'] },
    { label: 'Leve', g: 0.18, cls: 'la', color: 'var(--teal)', level: 'normal',
        todo: ['Mantente calmado.', 'Aléjate de objetos que puedan caer.'] },
    { label: 'Moderado', g: 0.45, cls: 'wa', color: 'var(--acc3)', level: 'warning',
        todo: ['⚠️ Posible actividad sísmica.', 'Agáchate, cúbrete y sostenete bajo mesa sólida.', 'Aléjate de ventanas.'] },
    { label: 'FUERTE', g: 0.82, cls: 'da', color: 'var(--acc2)', level: 'alert',
        todo: ['🚨 ALERTA SÍSMICA DETECTADA', 'AGÁCHATE — CÚBRETE — SOSTENETE', 'Permanece bajo mesa hasta que pare.',
            'NO corras a la calle durante el sismo.'] },
    { label: 'MUY FUERTE', g: 1.24, cls: 'da', color: 'var(--acc2)', level: 'alert',
        todo: ['🚨 SISMO GRAVE — EVACUA', 'Busca zona de reunión exterior.', 'Aléjate de edificios, cables y árboles.',
            'Llama al 911 si hay heridos.'] },
    { label: 'Disminuyendo', g: 0.55, cls: 'wa', color: 'var(--acc3)', level: 'warning',
        todo: ['Permanece en posición de protección.', 'Espera réplicas.', 'Escucha instrucciones de autoridades.'] },
    { label: 'Débil', g: 0.22, cls: 'la', color: 'var(--teal)', level: 'normal',
        todo: ['Sismo en disminución.', 'Verifica tu entorno por daños.'] },
    { label: 'Normal', g: 0.04, cls: '', color: 'var(--teal)', level: 'normal',
        todo: ['Sistema volviendo a estado normal.', 'Evalúa daños. Reporta a autoridades.'] }
];

let ardData = Array(200).fill(60);

(function() {
    const c = document.getElementById('ardSg');
    if (!c) return;
    const ctx = c.getContext('2d');

    function resize() {
        c.width = c.offsetWidth;
        c.height = 120;
    }
    resize();
    window.addEventListener('resize', resize);

    function draw() {
        ctx.clearRect(0, 0, c.width, c.height);
        ctx.fillStyle = '#080c18';
        ctx.fillRect(0, 0, c.width, c.height);

        ctx.strokeStyle = 'rgba(255,255,255,.03)';
        ctx.lineWidth = 1;
        for (let y = 0; y < c.height; y += 20) {
            ctx.beginPath();
            ctx.moveTo(0, y);
            ctx.lineTo(c.width, y);
            ctx.stroke();
        }

        const ph = ardRunning ? ardPhases[ardPhase] : ardPhases[0];
        const amp = ph.g * c.height * 0.45;
        const noise = (Math.random() - 0.5) * amp * 2 +
            Math.sin(ardT * 0.1) * amp * 0.8 +
            Math.sin(ardT * 0.21) * amp * 0.4;

        ardData.push(c.height / 2 + noise);
        ardData.shift();

        const step = c.width / ardData.length;

        // Fill
        const fg = ctx.createLinearGradient(0, 0, 0, c.height);
        fg.addColorStop(0, 'rgba(0,212,176,0)');
        fg.addColorStop(0.5, `rgba(0,212,176,${ph.g * 0.12})`);
        fg.addColorStop(1, 'rgba(0,212,176,0)');
        ctx.beginPath();
        ctx.fillStyle = fg;
        ardData.forEach((v, i) => {
            i === 0 ? ctx.moveTo(0, v) : ctx.lineTo(i * step, v);
        });
        ctx.lineTo(c.width, c.height);
        ctx.lineTo(0, c.height);
        ctx.closePath();
        ctx.fill();

        // Wave line
        ctx.beginPath();
        ctx.strokeStyle = ph.level === 'alert' ? '#ff2d4a' : ph.level === 'warning' ? '#ff9900' : '#00d4b0';
        ctx.lineWidth = 1.8;
        ardData.forEach((v, i) => {
            i === 0 ? ctx.moveTo(0, v) : ctx.lineTo(i * step, v);
        });
        ctx.stroke();

        // G value
        const gVal = Math.abs(noise / (c.height * 0.45)) * ph.g + ph.g * 0.1;
        document.getElementById('aiVal').textContent = Math.max(0.01, gVal).toFixed(2) + ' G';
        document.getElementById('aiVal').style.color = ph.level === 'alert' ? '#ff2d4a' : ph.level === 'warning' ? '#ff9900' :
            '#00d4b0';

        // Bars
        const bars = document.getElementById('aiBars').children;
        Array.from(bars).forEach((bar, i) => {
            const baseH = Math.max(5, Math.min(95, (Math.abs(noise) * 1.5 + ph.g * 80 + (Math.random() - 0.5) * 20) * (i *
                0.12 + 0.7)));
            bar.style.height = baseH + '%';
            bar.className = 'ai-bar ' + ph.cls;
        });

        ardT++;
        requestAnimationFrame(draw);
    }
    draw();
})();

// Arduino 3D sensor model
(function() {
    const c = document.getElementById('ardModel');
    if (!c) return;
    const ctx = c.getContext('2d');
    let t = 0;

    function resize() {
        c.width = c.offsetWidth;
        c.height = 200;
    }
    resize();
    window.addEventListener('resize', resize);

    function draw() {
        const W = c.width,
            H = c.height;
        ctx.clearRect(0, 0, W, H);
        ctx.fillStyle = '#080c18';
        ctx.fillRect(0, 0, W, H);

        const ph = ardRunning ? ardPhases[ardPhase] : ardPhases[0];
        const shk = ph.g * 15;
        const cx = W * 0.5 + Math.sin(t * 0.08) * shk * 0.8,
            cy = H * 0.5 + Math.cos(t * 0.1) * shk * 0.5;
        const angle = Math.sin(t * 0.06) * shk * 0.04;

        ctx.save();
        ctx.translate(cx, cy);
        ctx.rotate(angle);

        // Arduino board
        ctx.fillStyle = '#1a5c2a';
        ctx.strokeStyle = 'rgba(0,212,176,.5)';
        ctx.lineWidth = 1.5;
        ctx.fillRect(-55, -32, 110, 64);
        ctx.strokeRect(-55, -32, 110, 64);

        // MPU-6050 chip
        ctx.fillStyle = '#0a0a0a';
        ctx.fillRect(-20, -15, 40, 30);
        ctx.strokeStyle = 'rgba(45,143,255,.6)';
        ctx.lineWidth = 1;
        ctx.strokeRect(-20, -15, 40, 30);
        ctx.fillStyle = 'rgba(45,143,255,.8)';
        ctx.font = 'bold 7px Space Grotesk,sans-serif';
        ctx.textAlign = 'center';
        ctx.fillText('MPU-6050', 0, 3);
        ctx.textAlign = 'left';

        // Axis indicators
        const axisColor = { x: '#ff4d1a', y: '#00d4b0', z: '#2d8fff' };

        ctx.strokeStyle = axisColor.x;
        ctx.lineWidth = 2;
        ctx.beginPath();
        ctx.moveTo(0, 0);
        ctx.lineTo(30 + Math.sin(t * 0.08) * shk, 0);
        ctx.stroke();
        ctx.fillStyle = axisColor.x;
        ctx.font = 'bold 9px Space Grotesk,sans-serif';
        ctx.textAlign = 'center';
        ctx.fillText('X', 34 + Math.sin(t * 0.08) * shk, 4);

        ctx.strokeStyle = axisColor.y;
        ctx.lineWidth = 2;
        ctx.beginPath();
        ctx.moveTo(0, 0);
        ctx.lineTo(0, -30 + Math.cos(t * 0.1) * shk);
        ctx.stroke();
        ctx.fillStyle = axisColor.y;
        ctx.fillText('Y', 0, -34 + Math.cos(t * 0.1) * shk);

        ctx.strokeStyle = axisColor.z;
        ctx.lineWidth = 2;
        ctx.beginPath();
        ctx.moveTo(0, 0);
        ctx.lineTo(20 + Math.sin(t * 0.07) * shk * 0.5, -20 + Math.cos(t * 0.09) * shk * 0.5);
        ctx.stroke();
        ctx.fillStyle = axisColor.z;
        ctx.fillText('Z', 24 + Math.sin(t * 0.07) * shk * 0.5, -22);
        ctx.textAlign = 'left';

        // LED
        const ledColor = ph.level === 'alert' ? '#ff2d4a' : ph.level === 'warning' ? '#ff9900' : '#22c55e';
        ctx.fillStyle = ledColor;
        ctx.beginPath();
        ctx.arc(45, 25, 6, 0, Math.PI * 2);
        ctx.fill();
        ctx.fillStyle = 'rgba(255,255,255,.1)';
        ctx.beginPath();
        ctx.arc(45, 25, 10, 0, Math.PI * 2);
        ctx.fill();

        // Pins
        ctx.fillStyle = 'rgba(255,200,50,.6)';
        for (let i = 0; i < 8; i++) {
            ctx.fillRect(-54 + i * 12, -31, 2, 5);
            ctx.fillRect(-54 + i * 12, 27, 2, 5);
        }

        ctx.restore();

        // Axis labels
        ctx.fillStyle = 'rgba(255,255,255,.3)';
        ctx.font = '10px Space Grotesk,sans-serif';
        ctx.fillText(
            `Eje X: ${(Math.sin(t * 0.08) * shk * 0.06).toFixed(3)}G  Eje Y: ${(Math.cos(t * 0.1) * shk * 0.06).toFixed(3)}G  Eje Z: ${(Math.sin(t * 0.13) * shk * 0.04 + 0.98).toFixed(3)}G`,
            8, H - 10
        );

        t++;
        requestAnimationFrame(draw);
    }
    draw();
})();

function ardAddLog(msg, cls = '') {
    const log = document.getElementById('ardLog');
    const el = document.createElement('div');
    el.className = 'ald ' + cls;
    el.textContent = '[' + new Date().toLocaleTimeString('es-SV') + '] ' + msg;
    log.appendChild(el);
    log.scrollTop = log.scrollHeight;
}

function ardUpdateStatus() {
    const ph = ardPhases[ardPhase];
    const dot = document.getElementById('aapDot');
    const txt = document.getElementById('aapText');
    document.getElementById('aapTime').textContent = new Date().toLocaleTimeString('es-SV');

    if (ph.level === 'alert') {
        dot.className = 'aap-status-dot alert';
        txt.textContent = '⚠️ ALERTA SÍSMICA ACTIVA';
        txt.style.color = 'var(--acc2)';
    } else if (ph.level === 'warning') {
        dot.className = 'aap-status-dot';
        dot.style.background = 'var(--acc3)';
        txt.textContent = '⚡ Actividad Detectada';
        txt.style.color = 'var(--acc3)';
    } else {
        dot.className = 'aap-status-dot';
        dot.style.background = 'var(--teal)';
        txt.textContent = '✓ Sistema en Estado Normal';
        txt.style.color = 'var(--text2)';
    }

    const wt = document.getElementById('wtSteps');
    const ph2 = ardPhases[ardPhase];
    wt.innerHTML = ph2.todo.map(s =>
        `<div class="wts ${ph2.level === 'alert' ? 'danger' : 'safe'}">
            <span class="wts-icon">${ph2.level === 'alert' ? '⚠️' : ph2.level === 'warning' ? '⚡' : '✓'}</span>
            ${s}
        </div>`
    ).join('');
}

let ardInterval = null;

document.getElementById('ardSimBtn').onclick = function() {
    if (ardRunning) return;
    ardRunning = true;
    ardPhase = 0;
    ardPhaseT = 0;
    this.disabled = true;
    this.textContent = '⏳ Simulando…';
    ardAddLog('Iniciando secuencia de simulación sísmica…', 'i');

    const phaseLabels = [
        'Vibración leve detectada', 'Señal creciente — actividad sísmica',
        '⚠️ UMBRAL DE ALERTA SUPERADO — 0.8G', '🚨 SISMO FUERTE DETECTADO — evacuación',
        'Señal disminuyendo…', 'Actividad residual', 'Vuelta a estado normal', 'Simulación completada'
    ];
    const phaseCls = ['i', 'i', 'w', 'c', 'w', 'i', 'i', 'i'];
    let pi = 0;

    ardInterval = setInterval(() => {
        if (pi < ardPhases.length) {
            ardPhase = pi;
            ardAddLog(phaseLabels[pi], phaseCls[pi]);
            ardUpdateStatus();
            pi++;
        } else {
            clearInterval(ardInterval);
            ardRunning = false;
            document.getElementById('ardSimBtn').disabled = false;
            document.getElementById('ardSimBtn').textContent = '▶ Simular Alerta';
            ardPhase = 0;
            ardUpdateStatus();
        }
    }, 1400);
};

document.getElementById('ardResetBtn').onclick = function() {
    clearInterval(ardInterval);
    ardRunning = false;
    ardPhase = 0;
    document.getElementById('ardSimBtn').disabled = false;
    document.getElementById('ardSimBtn').textContent = '▶ Simular Alerta';
    ardData = Array(200).fill(60);
    document.getElementById('ardLog').innerHTML = '<div class="ald i">🟢 Sistema reiniciado</div>';
    ardUpdateStatus();
};

ardUpdateStatus();
setInterval(() => {
    if (!ardRunning) document.getElementById('aapTime').textContent = new Date().toLocaleTimeString('es-SV');
}, 1000);

  
//  11. LEAFLET MAP
  

let hazMap, qLayer2, sLayer2, vLayer2, fLayer2, slideLayer, safeLayer;

function initMap() {
    hazMap = L.map('hazardMap', { center: [13.7942, -88.8965], zoom: 8 });
    L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', { attribution: '© CARTO', maxZoom: 18 })
        .addTo(hazMap);

    sLayer2 = L.layerGroup();
    [
        { lat: 13.7, lng: -89.2, r: 38000, lbl: '[Sísmica] San Salvador', desc: 'Alta actividad tectónica. Falla Metrópolis activa.' },
        { lat: 13.43, lng: -88.18, r: 30000, lbl: '[Sísmica] San Miguel', desc: 'Alta actividad tectónica. Falla El Triunfo activa.' },
        { lat: 13.4, lng: -88.9, r: 26000, lbl: '[Sísmica] Usulután', desc: 'Zona de subducción activa.' },
        { lat: 13.9, lng: -89.8, r: 24000, lbl: '[Sísmica] Ahuachapán', desc: 'Actividad volcánica y sísmica.' }
    ].forEach(z => L.circle([z.lat, z.lng], { radius: z.r, color: '#e63946', fillColor: '#e63946', fillOpacity: .1, weight: 2,
            opacity: .55 })
        .bindPopup(`<b style="color:#e63946">${z.lbl}</b><br>${z.desc}<br><small>Fuente: SNET/MARN</small>`)
        .addTo(sLayer2));

    vLayer2 = L.layerGroup();
    [
        { lat: 13.8414, lng: -89.6339, name: 'Volcán Santa Ana', act: true },
        { lat: 13.8281, lng: -89.5864, name: 'Volcán Izalco', act: true },
        { lat: 13.6761, lng: -89.6319, name: 'Volcán Chinchontepec', act: false },
        { lat: 13.6706, lng: -89.1844, name: 'Lago Ilopango (caldera)', act: true },
        { lat: 13.7389, lng: -88.7736, name: 'Volcán San Vicente', act: false },
        { lat: 13.4433, lng: -88.2694, name: 'Volcán San Miguel', act: true }
    ].forEach(v => L.circleMarker([v.lat, v.lng], { radius: 9, color: v.act ? '#ff9500' : '#555',
            fillColor: v.act ? '#ff9500' : '#333', fillOpacity: .8, weight: 2 })
        .bindPopup(`<b>${v.act ? '🔴 Activo' : '⚪ Inactivo'}</b><br>${v.name}<br><small>Fuente: MARN</small>`)
        .addTo(vLayer2));

    fLayer2 = L.layerGroup();
    [
        { lat: 13.2, lng: -88.85, r: 5000, lbl: '[Tsunami] Playa El Espino' },
        { lat: 13.3, lng: -89.17, r: 5000, lbl: '[Tsunami] Acajutla' },
        { lat: 13.33, lng: -88.5, r: 5000, lbl: '[Tsunami] La Unión' },
        { lat: 13.2, lng: -88.1, r: 5000, lbl: '[Tsunami] Jiquilisco' },
        { lat: 13.2, lng: -89.5, r: 5000, lbl: '[Tsunami] Sonsonate Costa' }
    ].forEach(f => L.circle([f.lat, f.lng], { radius: f.r, color: '#3d9bff', fillColor: '#3d9bff', fillOpacity: .15,
            weight: 1.5, opacity: .55 })
        .bindPopup(`<b style="color:#3d9bff">${f.lbl}</b><br>Zona de riesgo tsunamigénico<br><small>Fuente: IOC-UNESCO / MARN</small>`)
        .addTo(fLayer2));

    slideLayer = L.layerGroup();
    [
        { lat: 13.72, lng: -89.1, lbl: 'Deslizamiento — Cuscatlán' },
        { lat: 13.78, lng: -89.5, lbl: 'Deslizamiento — Santa Ana Norte' },
        { lat: 13.84, lng: -89.0, lbl: 'Deslizamiento — Chalatenango' }
    ].forEach(s => L.circleMarker([s.lat, s.lng], { radius: 7, color: '#ffcc00', fillColor: '#ffcc00', fillOpacity: .7,
            weight: 1.5 })
        .bindPopup(`<b style="color:#ffcc00">${s.lbl}</b><br><small>Fuente: MARN</small>`)
        .addTo(slideLayer));

    safeLayer = L.layerGroup();
    [
        { lat: 13.82, lng: -88.5, lbl: 'Zona Segura — Morazán Norte' },
        { lat: 14.0, lng: -89.2, lbl: 'Zona Segura — Chalatenango' }
    ].forEach(s => L.circleMarker([s.lat, s.lng], { radius: 8, color: '#22c55e', fillColor: '#22c55e', fillOpacity: .6,
            weight: 1.5 })
        .bindPopup(`<b style="color:#22c55e">${s.lbl}</b>`)
        .addTo(safeLayer));

    qLayer2 = L.layerGroup();
    sLayer2.addTo(hazMap);

    document.querySelectorAll('.mc-btn').forEach(btn => {
        btn.onclick = () => {
            document.querySelectorAll('.mc-btn').forEach(b => b.classList.remove('on'));
            btn.classList.add('on');
            [sLayer2, vLayer2, fLayer2, slideLayer, safeLayer, qLayer2].forEach(l => hazMap.removeLayer(l));
            const map = { seismic: sLayer2, volcanic: vLayer2, flood: fLayer2, slides: slideLayer, safe: safeLayer,
                quakes: qLayer2 };
            if (btn.dataset.layer === 'all') {
                [sLayer2, vLayer2, fLayer2, slideLayer, safeLayer, qLayer2].forEach(l => l.addTo(hazMap));
            } else if (map[btn.dataset.layer]) {
                map[btn.dataset.layer].addTo(hazMap);
            }
        };
    });
}

window._addQuakesToMap = function(qs) {
    if (!qLayer2) return;
    qLayer2.clearLayers();
    qs.forEach(q => {
        const [lng, lat] = q.geometry.coordinates,
            m = q.properties.mag || 1;
        const col = m < 3 ? '#22c55e' : m < 5 ? '#ff9500' : '#e63946';
        L.circleMarker([lat, lng], { radius: Math.max(4, m * 2.2), color: col, fillColor: col, fillOpacity: .5,
                weight: 1.5 })
            .bindPopup(`<b>M ${m}</b><br>${q.properties.place}<br>${new Date(q.properties.time).toLocaleString('es')}<br><small>Fuente: USGS</small>`)
            .addTo(qLayer2);
    });
};

  
//  12. WEATHER
  

async function loadWeather() {
    try {
        const cities = [
            { name: 'San Salvador', lat: 13.6929, lng: -89.2182 },
            { name: 'La Libertad', lat: 13.4885, lng: -89.3126 },
            { name: 'Santa Ana', lat: 13.9944, lng: -89.5597 }
        ];

        const wmo = {
            0: ['☀️', 'Despejado'],
            1: ['🌤', 'Mayormente despejado'],
            2: ['⛅', 'Parcialmente nublado'],
            3: ['☁️', 'Nublado'],
            45: ['🌫', 'Niebla'],
            51: ['🌦', 'Llovizna'],
            61: ['🌧', 'Lluvia ligera'],
            63: ['🌧', 'Lluvia moderada'],
            65: ['⛈', 'Lluvia intensa'],
            80: ['🌦', 'Chubascos'],
            95: ['⛈', 'Tormenta']
        };

        const results = await Promise.all(cities.map(c =>
            fetch(
                    `https://api.open-meteo.com/v1/forecast?latitude=${c.lat}&longitude=${c.lng}&current=temperature_2m,relative_humidity_2m,wind_speed_10m,weather_code,apparent_temperature,wind_direction_10m&daily=temperature_2m_max,temperature_2m_min,precipitation_sum&forecast_days=1&timezone=America/El_Salvador`
                    )
                .then(r => r.json())
                .then(d => ({ ...c, data: d }))
        ));

        const container = document.getElementById('weatherCities');
        container.innerHTML = results.map(r => {
            const cur = r.data.current;
            const w = wmo[cur.weather_code] || ['🌤', 'Variable'];
            const max = r.data.daily?.temperature_2m_max?.[0] || '—';
            const min = r.data.daily?.temperature_2m_min?.[0] || '—';
            const dirs = ['N', 'NE', 'E', 'SE', 'S', 'SO', 'O', 'NO'];
            const dir = dirs[Math.round(cur.wind_direction_10m / 45) % 8] || '—';
            const uv = cur.apparent_temperature > 30 ? 'Extremo' : cur.apparent_temperature > 25 ? 'Alto' : 'Moderado';
            const extra = r.name === 'La Libertad' ? `${Math.round(Math.random() * 18 + 5)}mm hoy` :
                r.name === 'Santa Ana' ? 'Altitud 800 msnm' : `UV: ${uv}`;
            return `<div class="wc-card">
                <div class="wc-icon">${w[0]}</div>
                <div class="wc-city">${r.name}</div>
                <div class="wc-temp">${Math.round(cur.temperature_2m)}<span style="font-size:1.2rem">°C</span></div>
                <div class="wc-desc">${w[1]} · Humedad ${cur.relative_humidity_2m}%</div>
                <div class="wc-meta">
                    <span>↑${Math.round(max)}° ↓${Math.round(min)}°</span>
                    <span>💨 ${Math.round(cur.wind_speed_10m)} km/h ${dir}</span>
                    <span>${extra}</span>
                </div>
            </div>`;
        }).join('');

        const monthly = [10, 8, 18, 52, 180, 280, 290, 270, 310, 220, 45, 12];
        const months = ['E', 'F', 'M', 'A', 'M', 'J', 'J', 'A', 'S', 'O', 'N', 'D'];
        const maxP = Math.max(...monthly);
        document.getElementById('precipChart').innerHTML = monthly.map((p, i) =>
            `<div class="prc-bar-wrap">
                <div class="prc-bar-outer"><div class="prc-bar" style="height:${(p / maxP * 100)}%"></div></div>
                <div class="prc-val">${p > 50 ? p : ''}</div>
                <div class="prc-day">${months[i]}</div>
            </div>`
        ).join('');

        const todayPrecip = results[0]?.data?.daily?.precipitation_sum?.[0] ?? 0;
        if (window.updateRadarStatus) window.updateRadarStatus(todayPrecip);

    } catch (e) {
        document.getElementById('weatherCities').innerHTML = '<div class="loading-s">⚠️ Error al cargar clima</div>';
    }
}

async function loadSun() {
    try {
        const resp = await fetch('https://api.sunrise-sunset.org/json?lat=13.6929&lng=-89.2182&formatted=0');
        const d = await resp.json();

        const toLocal = s => new Date(s).toLocaleTimeString('es-SV', { hour: '2-digit', minute: '2-digit',
            timeZone: 'America/El_Salvador', hour12: false });
        const srStr = toLocal(d.results.sunrise);
        const ssStr = toLocal(d.results.sunset);

        const dl = d.results.day_length;
        const hrsFmt = `${Math.floor(dl / 3600)}h ${Math.floor((dl % 3600) / 60)}min`;

        document.getElementById('sunriseBig').textContent = srStr;
        document.getElementById('sunsetBig').textContent = ssStr;
        if (document.getElementById('sunriseT')) document.getElementById('sunriseT').textContent = srStr;
        if (document.getElementById('sunsetT')) document.getElementById('sunsetT').textContent = ssStr;

        const nowHr = new Date().getHours();
        const uvIdx = nowHr >= 10 && nowHr <= 15 ? 12 : nowHr >= 8 && nowHr <= 17 ? 7 : 2;
        const uvLbl = uvIdx >= 11 ? 'Extremo' : uvIdx >= 8 ? 'Muy Alto' : uvIdx >= 6 ? 'Alto' : 'Moderado';
        document.getElementById('sunDur').textContent = `Duración: ${hrsFmt} · Índice UV: ${uvIdx} — ${uvLbl}`;

        // Draw sun arc
        const c = document.getElementById('sunArc');
        if (!c) return;

        function drawArc() {
            c.width = c.offsetWidth || 400;
            c.height = 160;
            const ctx = c.getContext('2d');
            const W = c.width,
                H = c.height;

            ctx.fillStyle = '#040810';
            ctx.fillRect(0, 0, W, H);

            const stars = [
                [0.08, 0.12],
                [0.15, 0.08],
                [0.25, 0.18],
                [0.34, 0.06],
                [0.45, 0.15],
                [0.54, 0.09],
                [0.63, 0.2],
                [0.72, 0.07],
                [0.81, 0.14],
                [0.9, 0.1],
                [0.96, 0.18],
                [0.12, 0.3],
                [0.68, 0.26],
                [0.84, 0.32],
                [0.38, 0.24]
            ];
            stars.forEach(([fx, fy]) => {
                ctx.fillStyle = 'rgba(255,255,255,.5)';
                ctx.fillRect(W * fx, H * fy, 1.5, 1.5);
            });

            const toDecH = dt => {
                const local = new Date(dt).toLocaleString('en-US', { timeZone: 'America/El_Salvador', hour: '2-digit',
                    minute: '2-digit', hour12: false });
                const parts = local.split(':');
                return parseInt(parts[0] || 0) + parseInt(parts[1] || 0) / 60;
            };

            const srDec = toDecH(d.results.sunrise);
            const ssDec = toDecH(d.results.sunset);

            const nowLocal = new Date().toLocaleString('en-US', { timeZone: 'America/El_Salvador', hour: '2-digit',
                minute: '2-digit', hour12: false });
            const np = nowLocal.split(':');
            const nowDec = parseInt(np[0] || 12) + parseInt(np[1] || 0) / 60;
            const prog = Math.max(0, Math.min(1, (nowDec - srDec) / (ssDec - srDec)));

            const AX = W * 0.5,
                AY = H + 12,
                AR = W * 0.46;

            ctx.save();
            ctx.strokeStyle = 'rgba(255,200,50,.22)';
            ctx.lineWidth = 1.5;
            ctx.setLineDash([6, 5]);
            ctx.beginPath();
            ctx.arc(AX, AY, AR, Math.PI, 0);
            ctx.stroke();
            ctx.setLineDash([]);

            ctx.strokeStyle = 'rgba(255,255,255,.06)';
            ctx.lineWidth = 1;
            ctx.beginPath();
            ctx.moveTo(W * 0.04, H - 4);
            ctx.lineTo(W * 0.96, H - 4);
            ctx.stroke();

            const srX = AX - AR,
                ssX = AX + AR;
            ['rgba(255,180,50,.6)', 'rgba(255,180,50,.6)'].forEach((col, idx) => {
                const tx = idx === 0 ? srX : ssX;
                ctx.strokeStyle = col;
                ctx.lineWidth = 1.5;
                ctx.beginPath();
                ctx.moveTo(tx, H - 4);
                ctx.lineTo(tx, H - 18);
                ctx.stroke();
            });

            ctx.fillStyle = 'rgba(200,150,60,.75)';
            ctx.font = '600 9.5px Space Grotesk,sans-serif';
            ctx.textAlign = 'center';
            ctx.fillText(srStr, srX, H - 1);
            ctx.fillText(ssStr, ssX, H - 1);
            ctx.textAlign = 'left';

            const angle = Math.PI - prog * Math.PI;
            const sx = AX + Math.cos(angle) * AR,
                sy = AY + Math.sin(angle) * AR;

            const glow = ctx.createRadialGradient(sx, sy, 0, sx, sy, 30);
            glow.addColorStop(0, 'rgba(255,200,50,.22)');
            glow.addColorStop(1, 'rgba(255,200,50,0)');
            ctx.fillStyle = glow;
            ctx.beginPath();
            ctx.arc(sx, sy, 30, 0, Math.PI * 2);
            ctx.fill();

            const sunGr = ctx.createRadialGradient(sx - 2, sy - 2, 1, sx, sy, 9);
            sunGr.addColorStop(0, '#fff4a0');
            sunGr.addColorStop(0.4, '#ffcc00');
            sunGr.addColorStop(1, '#ff8800');
            ctx.fillStyle = sunGr;
            ctx.beginPath();
            ctx.arc(sx, sy, 9, 0, Math.PI * 2);
            ctx.fill();

            const hh = String(Math.floor(nowDec)).padStart(2, '0');
            const mm = String(Math.round((nowDec % 1) * 60)).padStart(2, '0');
            ctx.fillStyle = 'rgba(255,220,60,.95)';
            ctx.font = 'bold 10px Space Grotesk,sans-serif';
            ctx.textAlign = 'center';
            const labelY = sy > 30 ? sy - 16 : sy + 24;
            ctx.fillText(`☀ ${hh}:${mm}`, sx, labelY);
            ctx.textAlign = 'left';
            ctx.restore();
        }

        drawArc();
        window.addEventListener('resize', drawArc);

    } catch (e) {
        console.warn('Sun load error', e);
    }
}

  
//  13. RADAR CANVAS ANIMATION
  

(function initRadar() {
    const body = document.getElementById('radarBody');
    const cv = document.getElementById('radarCanvas');
    if (!body || !cv) return;

    let W, H, animFrame, t = 0;

    const cells = [
        { bx: .42, by: .38, r: .07, intensity: 'mod', phase: 0 },
        { bx: .58, by: .52, r: .05, intensity: 'light', phase: .6 },
        { bx: .33, by: .56, r: .04, intensity: 'light', phase: 1.2 },
        { bx: .65, by: .3, r: .045, intensity: 'mod', phase: 1.8 },
    ];

    const colMap = {
        light: 'rgba(59,130,246,',
        mod: 'rgba(249,115,22,',
        heavy: 'rgba(239,68,68,'
    };

    function resize() {
        const rect = body.getBoundingClientRect();
        W = rect.width || 300;
        H = rect.height || 240;
        cv.width = W;
        cv.height = H;
    }

    function draw() {
        if (!cv.width) resize();
        const ctx = cv.getContext('2d');
        ctx.clearRect(0, 0, cv.width, cv.height);

        const cx = cv.width * 0.5,
            cy = cv.height * 0.5;

        // Precipitation blobs
        cells.forEach((cell, idx) => {
            const drift = Math.sin(t * 0.012 + cell.phase) * 0.025;
            const driftY = Math.cos(t * 0.009 + cell.phase) * 0.018;
            const bx = cx + (cell.bx - 0.5) * Math.min(cv.width, cv.height) + drift * cv.width;
            const by = cy + (cell.by - 0.5) * Math.min(cv.width, cv.height) + driftY * cv.height;
            const r = cell.r * Math.min(cv.width, cv.height);
            const col = colMap[cell.intensity] || colMap.light;
            const grad = ctx.createRadialGradient(bx, by, 0, bx, by, r);
            grad.addColorStop(0, col + '0.6)');
            grad.addColorStop(0.5, col + '0.35)');
            grad.addColorStop(1, col + '0)');
            ctx.fillStyle = grad;
            ctx.beginPath();
            ctx.arc(bx, by, r, 0, Math.PI * 2);
            ctx.fill();
        });

        // Sweep glow trail
        const sweepAngle = (t * 0.022) % (Math.PI * 2) - Math.PI / 2;
        const maxR = Math.min(cv.width, cv.height) * 0.49;

        for (let trail = 0; trail < 8; trail++) {
            const trailA = sweepAngle - trail * 0.08;
            const alpha = (1 - trail / 8) * 0.15;
            ctx.save();
            ctx.translate(cx, cy);
            ctx.beginPath();
            ctx.moveTo(0, 0);
            ctx.arc(0, 0, maxR, trailA, trailA + 0.12);
            ctx.closePath();
            ctx.fillStyle = `rgba(0,210,180,${alpha})`;
            ctx.fill();
            ctx.restore();
        }

        // Main sweep line
        ctx.save();
        ctx.translate(cx, cy);
        const grd = ctx.createLinearGradient(0, 0, Math.cos(sweepAngle) * maxR, Math.sin(sweepAngle) * maxR);
        grd.addColorStop(0, 'rgba(0,220,185,.9)');
        grd.addColorStop(1, 'rgba(0,220,185,0)');
        ctx.strokeStyle = grd;
        ctx.lineWidth = 2;
        ctx.beginPath();
        ctx.moveTo(0, 0);
        ctx.lineTo(Math.cos(sweepAngle) * maxR, Math.sin(sweepAngle) * maxR);
        ctx.stroke();
        ctx.restore();

        t++;
        animFrame = requestAnimationFrame(draw);
    }

    window.addEventListener('resize', resize);
    resize();
    draw();

    window.updateRadarStatus = function(precipMm) {
        const el = document.getElementById('radarStatus');
        if (!el) return;
        if (precipMm > 15) {
            el.textContent = '⚠ Lluvia intensa';
            el.className = 'chip r';
        } else if (precipMm > 3) {
            el.textContent = '● Lluvia ligera';
            el.className = 'chip b';
        } else {
            el.textContent = '● Vigilancia';
            el.className = 'chip o';
        }
    };
})();

  
//  14. MOON INTERACTIVE MODULE
  

(function() {
    const synodic = 29.530588853;
    const known = new Date(2000, 0, 6, 18, 14);
    const now = new Date();
    const currentPhaseRaw = ((now - known) / 864e5 / synodic) % 1;

    const phases = [
        { name: '🌑 Luna Nueva', key: 'new', emoji: '🌑', tideType: 'spring', tideLabel: 'Marea Viva', fishing: 'Alta',
            risk: 'Alto', desc: 'Alineación Sol-Luna-Tierra. Mareas vivas máximas. Pesca muy activa.' },
        { name: '🌒 Creciente Iluminante', key: 'waxCrescent', emoji: '🌒', tideType: 'moderate',
            tideLabel: 'Marea Moderada', fishing: 'Media', risk: 'Bajo',
            desc: 'Luna se aleja de la alineación solar. Mareas descendiendo gradualmente.' },
        { name: '🌓 Cuarto Creciente', key: 'firstQuarter', emoji: '🌓', tideType: 'neap', tideLabel: 'Marea Muerta',
            fishing: 'Baja', risk: 'Bajo',
            desc: 'Ángulo 90° con el Sol. Mareas muertas — menor variación. Buena navegación.' },
        { name: '🌔 Gibosa Creciente', key: 'waxGibbous', emoji: '🌔', tideType: 'moderate',
            tideLabel: 'Marea Moderada', fishing: 'Media', risk: 'Bajo',
            desc: 'Luna casi llena. Fuerza gravitacional creciendo. Mareas aumentando.' },
        { name: '🌕 Luna Llena', key: 'full', emoji: '🌕', tideType: 'spring', tideLabel: 'Marea Viva', fishing: 'Alta',
            risk: 'Muy Alto', desc: 'Alineación opuesta pero igualmente fuerte. Mareas vivas máximas del mes.' },
        { name: '🌖 Gibosa Menguante', key: 'wanGibbous', emoji: '🌖', tideType: 'moderate',
            tideLabel: 'Marea Moderada', fishing: 'Media', risk: 'Bajo',
            desc: 'Luna pos-llena. Mareas disminuyendo paulatinamente.' },
        { name: '🌗 Cuarto Menguante', key: 'lastQuarter', emoji: '🌗', tideType: 'neap', tideLabel: 'Marea Muerta',
            fishing: 'Baja', risk: 'Bajo',
            desc: 'Ángulo 90° opuesto. Segunda marea muerta del ciclo. Aguas calmadas.' },
        { name: '🌘 Menguante', key: 'wanCrescent', emoji: '🌘', tideType: 'low', tideLabel: 'Marea Baja',
            fishing: 'Baja', risk: 'Bajo',
            desc: 'Luna casi nueva. Fuerza gravitacional mínima. Preparando próxima luna nueva.' },
    ];

    function getNextPhaseDate(targetPhaseIdx) {
        const target = targetPhaseIdx / 8;
        const cur = currentPhaseRaw;
        let diff = target - cur;
        if (diff <= 0) diff += 1;
        const nextMs = now.getTime() + diff * synodic * 864e5;
        const d = new Date(nextMs);
        return d.toLocaleDateString('es-SV', { weekday: 'long', day: 'numeric', month: 'long' });
    }

    let selectedPhase = Math.floor(currentPhaseRaw * 8) % 8;

    function drawMoon(phaseIdx) {
        const c = document.getElementById('moonCv');
        if (!c) return;
        const ctx = c.getContext('2d');
        const phase = phaseIdx / 8;
        const W = c.width,
            H = c.height,
            cx = W / 2,
            cy = H / 2,
            r = W / 2 - 6;
        ctx.clearRect(0, 0, W, H);

        const glow = ctx.createRadialGradient(cx, cy, r * 0.6, cx, cy, r + 18);
        glow.addColorStop(0, phase === 4 ? 'rgba(255,240,130,.18)' : 'rgba(255,210,80,.1)');
        glow.addColorStop(1, 'transparent');
        ctx.fillStyle = glow;
        ctx.beginPath();
        ctx.arc(cx, cy, r + 18, 0, Math.PI * 2);
        ctx.fill();

        ctx.fillStyle = '#070d1a';
        ctx.beginPath();
        ctx.arc(cx, cy, r, 0, Math.PI * 2);
        ctx.fill();

        ctx.save();
        ctx.beginPath();
        ctx.arc(cx, cy, r, 0, Math.PI * 2);
        ctx.clip();

        const litX = Math.cos(phase * Math.PI * 2) * r;
        const moonColor = phase === 4 ? '#fff5d0' : phase < 0.125 ? '#e8d8a0' : '#ede0b0';
        ctx.fillStyle = moonColor;
        if (phase < 0.5) {
            ctx.beginPath();
            ctx.arc(cx, cy, r, Math.PI / 2, Math.PI * 3 / 2, true);
            ctx.bezierCurveTo(cx + litX, cy - r, cx + litX, cy + r, cx, cy + r);
            ctx.fill();
        } else {
            ctx.beginPath();
            ctx.arc(cx, cy, r, Math.PI / 2, Math.PI * 3 / 2);
            ctx.bezierCurveTo(cx + litX, cy + r, cx + litX, cy - r, cx, cy - r);
            ctx.fill();
        }

        const craters = [
            [-0.25, -0.28, 0.065],
            [0.2, 0.12, 0.048],
            [-0.1, 0.32, 0.055],
            [0.32, -0.2, 0.038],
            [-0.35, 0.1, 0.03],
            [0.05, -0.4, 0.04]
        ];
        craters.forEach(([fx, fy, fr]) => {
            ctx.fillStyle = 'rgba(0,0,0,.12)';
            ctx.beginPath();
            ctx.arc(cx + fx * r, cy + fy * r, fr * r, 0, Math.PI * 2);
            ctx.fill();
            ctx.strokeStyle = 'rgba(255,255,255,.06)';
            ctx.lineWidth = 0.8;
            ctx.beginPath();
            ctx.arc(cx + fx * r - 1, cy + fy * r - 1, fr * r, 0, Math.PI * 2);
            ctx.stroke();
        });

        ctx.restore();

        ctx.strokeStyle = phase === 4 ? 'rgba(255,240,130,.4)' : 'rgba(255,210,80,.2)';
        ctx.lineWidth = 1.5;
        ctx.beginPath();
        ctx.arc(cx, cy, r, 0, Math.PI * 2);
        ctx.stroke();
    }

    function drawTideChart(phaseIdx) {
        const tc = document.getElementById('tideCv');
        if (!tc) return;
        tc.width = tc.offsetWidth;
        tc.height = 120;
        const ctx = tc.getContext('2d');
        const W = tc.width,
            H = tc.height;

        ctx.fillStyle = '#050810';
        ctx.fillRect(0, 0, W, H);

        ctx.strokeStyle = 'rgba(255,255,255,.04)';
        ctx.lineWidth = 1;
        for (let y = 0; y < H; y += 24) {
            ctx.beginPath();
            ctx.moveTo(0, y);
            ctx.lineTo(W, y);
            ctx.stroke();
        }
        for (let x = 0; x < W; x += W / 8) {
            ctx.beginPath();
            ctx.moveTo(x, 0);
            ctx.lineTo(x, H);
            ctx.stroke();
        }

        const isSpring = phaseIdx === 0 || phaseIdx === 4;
        const isNeap = phaseIdx === 2 || phaseIdx === 6;
        const amplitude = isSpring ? 0.42 : isNeap ? 0.18 : 0.28;
        const tideColor = isSpring ? '#3d9bff' : isNeap ? '#ff4d1a' : '#00d4b0';

        const fullFill = ctx.createLinearGradient(0, 0, 0, H);
        fullFill.addColorStop(0, `rgba(45,143,255,.18)`);
        fullFill.addColorStop(1, 'rgba(45,143,255,.02)');
        ctx.fillStyle = fullFill;
        ctx.beginPath();
        ctx.moveTo(0, H);
        for (let x = 0; x <= W; x++) {
            const cyclePos = (x / W * 2) * Math.PI;
            const moonEffect = Math.cos((phaseIdx / 4 + x / W) * Math.PI);
            const y = H * 0.5 - Math.sin(cyclePos * 2) * H * (amplitude + moonEffect * 0.12);
            x === 0 ? ctx.moveTo(x, y) : ctx.lineTo(x, y);
        }
        ctx.lineTo(W, H);
        ctx.closePath();
        ctx.fill();

        ctx.beginPath();
        ctx.strokeStyle = tideColor;
        ctx.lineWidth = 2.2;
        for (let x = 0; x <= W; x++) {
            const cyclePos = x / W * 2 * Math.PI;
            const moonEffect = Math.cos((phaseIdx / 4 + x / W) * Math.PI);
            const y = H * 0.5 - Math.sin(cyclePos * 2) * H * (amplitude + moonEffect * 0.12);
            x === 0 ? ctx.moveTo(x, y) : ctx.lineTo(x, y);
        }
        ctx.stroke();

        ['Día 1', 'Día 8', 'Día 15', 'Día 22', 'Día 29'].forEach((lbl, i) => {
            const x = W * i / 4;
            ctx.fillStyle = 'rgba(255,255,255,.3)';
            ctx.font = '8px Space Grotesk,sans-serif';
            ctx.textAlign = 'center';
            ctx.fillText(lbl, Math.min(x + 10, W - 20), H - 4);
        });
        ctx.textAlign = 'left';

        const curX = (phaseIdx / 8) * W;
        ctx.strokeStyle = 'rgba(255,204,0,.6)';
        ctx.lineWidth = 1.5;
        ctx.setLineDash([4, 3]);
        ctx.beginPath();
        ctx.moveTo(curX, 0);
        ctx.lineTo(curX, H);
        ctx.stroke();
        ctx.setLineDash([]);
        ctx.fillStyle = 'rgba(255,204,0,.9)';
        ctx.font = 'bold 8px Space Grotesk,sans-serif';
        ctx.textAlign = 'center';
        ctx.fillText('HOY', Math.min(curX, W - 20), 11);
        ctx.textAlign = 'left';
    }

    function updateMoonUI(phaseIdx) {
        const p = phases[phaseIdx];
        const pct = Math.round((phaseIdx / 8) * 100 + (currentPhaseRaw % 0.125) * 100 / 8);

        document.getElementById('moonName').textContent = p.name;
        document.getElementById('moonDateStr').textContent = now.toLocaleDateString('es-SV', { weekday: 'long',
            year: 'numeric', month: 'long', day: 'numeric' });
        document.getElementById('moonNextDate').textContent = `⏰ Próxima ${p.emoji}: ${getNextPhaseDate(phaseIdx)}`;
        document.getElementById('moonFill').style.width = ((phaseIdx + 0.5) / 8 * 100) + '%';
        document.getElementById('moonPct').textContent = Math.round((phaseIdx + 0.5) / 8 * 100) + '%';
        document.getElementById('tideCurPhase').textContent = `${p.tideLabel} · Pesca: ${p.fishing}`;

        const gEl = document.getElementById('moonGlowEl');
        if (gEl) {
            const gIntensity = phaseIdx === 4 ? 0.25 : phaseIdx === 0 ? 0.02 : 0.1;
            gEl.style.background = `radial-gradient(circle,rgba(255,220,90,${gIntensity}) 0%,transparent 70%)`;
        }

        drawMoon(phaseIdx);
        drawTideChart(phaseIdx);

        document.querySelectorAll('.mps-btn').forEach((btn, i) => {
            btn.classList.toggle('active', i === phaseIdx);
        });
    }

    window.setMoonPhase = function(idx) {
        selectedPhase = idx;
        updateMoonUI(idx);
    };

    document.querySelectorAll('.mps-btn').forEach((btn, i) => {
        btn.onclick = () => {
            selectedPhase = i;
            updateMoonUI(i);
            btn.style.transform = 'translateY(-4px) scale(1.1)';
            setTimeout(() => { btn.style.transform = ''; }, 300);
        };
    });

    updateMoonUI(selectedPhase);
})();

  
//  15. TSUNAMI CANVAS
  

(function() {
    const c = document.getElementById('tsunamiCv');
    if (!c) return;
    let t = 0;

    function resize() {
        c.width = c.offsetWidth;
        c.height = 200;
    }
    resize();
    window.addEventListener('resize', resize);

    const ctx = c.getContext('2d');

    function draw() {
        const W = c.width,
            H = c.height;
        ctx.clearRect(0, 0, W, H);

        const seaBg = ctx.createLinearGradient(0, 0, 0, H);
        seaBg.addColorStop(0, '#001222');
        seaBg.addColorStop(1, '#002650');
        ctx.fillStyle = seaBg;
        ctx.fillRect(0, 0, W, H);

        ctx.fillStyle = '#0a1e30';
        ctx.beginPath();
        ctx.moveTo(0, H * 0.78);
        for (let x = 0; x < W; x += 4) {
            ctx.lineTo(x, H * 0.78 + Math.sin(x * 0.04 + t * 0.01) * 2);
        }
        ctx.lineTo(W, H);
        ctx.lineTo(0, H);
        ctx.closePath();
        ctx.fill();

        const s = Math.sin(t * 0.018) * 10;
        ctx.fillStyle = '#0d2540';
        ctx.fillRect(0, H * 0.8, W * 0.48 + s, H * 0.22);
        ctx.fillStyle = '#0f2a48';
        ctx.fillRect(W * 0.48 + s, H * 0.78, W * 0.52, H * 0.24);
        ctx.strokeStyle = 'rgba(255,77,26,.5)';
        ctx.lineWidth = 1.5;
        ctx.beginPath();
        ctx.moveTo(W * 0.48 + s, H * 0.76);
        ctx.lineTo(W * 0.48 + s, H);
        ctx.stroke();

        const wPos = [
            (t * 1.6) % (W + 200) - 100,
            (t * 1.6 + 130) % (W + 200) - 100,
            (t * 1.6 + 260) % (W + 200) - 100
        ];
        wPos.forEach((wx, i) => {
            const op = 0.55 - i * 0.13;
            const h = 26 * (1 + (wx / W) * 0.5) * (1 - i * 0.18);
            const wgr = ctx.createLinearGradient(0, 0, 0, h * 2);
            wgr.addColorStop(0, `rgba(80,180,255,${op})`);
            wgr.addColorStop(1, `rgba(0,70,160,${op * 0.3})`);
            ctx.fillStyle = wgr;
            ctx.beginPath();
            ctx.moveTo(wx - 42, H * 0.42);
            ctx.quadraticCurveTo(wx, H * 0.42 - h, wx + 42, H * 0.42);
            ctx.lineTo(wx + 55, H * 0.6);
            ctx.lineTo(wx - 55, H * 0.6);
            ctx.closePath();
            ctx.fill();
        });

        ctx.beginPath();
        ctx.strokeStyle = 'rgba(80,180,255,.35)';
        ctx.lineWidth = 1.4;
        for (let x = 0; x < W; x++) {
            const y = H * 0.52 + Math.sin(x * 0.05 + t * 0.09) * 7 + Math.sin(x * 0.02 - t * 0.05) * 4;
            x === 0 ? ctx.moveTo(x, y) : ctx.lineTo(x, y);
        }
        ctx.stroke();

        ctx.fillStyle = 'rgba(255,255,255,.5)';
        ctx.font = '9px Space Grotesk,sans-serif';
        ctx.fillText('Placa de Cocos', 8, H * 0.9);
        ctx.fillText('Placa del Caribe', W * 0.55, H * 0.88);
        ctx.fillStyle = 'rgba(80,180,255,.8)';
        ctx.fillText('→ Tsunami propagándose', W * 0.02, H * 0.37);

        t++;
        requestAnimationFrame(draw);
    }
    draw();
})();

  
//  16. PREPAREDNESS
  

const prepData = {
    before: {
        color: '#2d8fff',
        title: '⏰ Antes del Sismo',
        steps: [
            { i: '🗺', t: 'Identifica rutas de evacuación y puntos de reunión familiar.' },
            { i: '🎒', t: 'Prepara mochila de emergencia con agua, comida y documentos.' },
            { i: '🏠', t: 'Asegura muebles y objetos que puedan caerse.' },
            { i: '📞', t: 'Establece un plan de comunicación familiar.' },
            { i: '🔧', t: 'Aprende a cerrar gas, agua y electricidad.' }
        ],
        checklist: ['Mochila lista', 'Rutas conocidas', 'Documentos seguros', 'Plan familiar acordado',
            'Números memorizados'
        ]
    },
    during: {
        color: '#ff9900',
        title: '⚡ Durante el Sismo',
        steps: [
            { i: '🪑', t: 'AGÁCHATE bajo mesa sólida o junto a pared interior.' },
            { i: '🛡', t: 'CÚBRETE la cabeza y cuello con tus brazos.' },
            { i: '✊', t: 'SOSTENETE hasta que el sismo termine.' },
            { i: '🚫', t: 'NO corras ni uses ascensores durante el temblor.' },
            { i: '🚫', t: 'Aléjate de ventanas, vitrinas y estanterías.' }
        ],
        checklist: ['Zona segura identificada', 'Practica agacharse', 'Evita ventanas', 'No usar ascensores',
            'Mantener la calma'
        ]
    },
    after: {
        color: '#22c55e',
        title: '✅ Después del Sismo',
        steps: [
            { i: '🔍', t: 'Verifica lesiones propias y aplica primeros auxilios básicos.' },
            { i: '🔥', t: 'Revisa incendios, fugas de gas o daños estructurales.' },
            { i: '📻', t: 'Escucha radio oficial para instrucciones de autoridades.' },
            { i: '🏃', t: 'Evacúa ordenadamente si hay daños visibles en el edificio.' },
            { i: '⚠️', t: 'Espera réplicas y permanece alerta 72 horas.' }
        ],
        checklist: ['Verificar lesiones', 'Revisar gas y luz', 'Radio oficial encendida', 'Evacuar si hay daños',
            'No regresar sin permiso'
        ]
    },
    coast: {
        color: '#00d4b0',
        title: '🌊 En la Costa — Tsunami',
        steps: [
            { i: '🌊', t: 'Sismo largo en la costa: CORRE tierra adentro INMEDIATAMENTE.' },
            { i: '⛰', t: 'Busca terreno elevado a mínimo 30m sobre el nivel del mar.' },
            { i: '🚫', t: 'NUNCA te quedes a observar el retiro del mar.' },
            { i: '📡', t: 'Escucha alertas del SINAPRED y autoridades.' },
            { i: '🐟', t: 'Si estás en bote, navega a aguas profundas.' }
        ],
        checklist: ['Rutas evacuación costera', 'Zonas elevadas identificadas', 'No acampar en playas bajas',
            'Radio a pilas disponible', 'Nunca observar retiro del mar'
        ]
    }
};

const prepCheckedSets = {
    before: new Set(),
    during: new Set(),
    after: new Set(),
    coast: new Set()
};
let prepActive = 'before';

function renderPrep() {
    const p = prepData[prepActive];
    const checked = prepCheckedSets[prepActive];
    document.getElementById('prepPanels').innerHTML = `
        <div class="prep-panel on">
            <div class="pp-scene">
                <canvas id="prepCv"></canvas>
                <div class="pp-body"><h4>${p.title}</h4>
                ${p.steps.map(s => `<div class="pp-step"><span>${s.i}</span><span>${s.t}</span></div>`).join('')}</div>
            </div>
            <div class="pp-checklist">
                <div class="pcl-hdr">📋 Lista de Verificación <span class="chip t" id="pclCount" style="margin-left:4px">${checked.size}/${p.checklist.length}</span></div>
                ${p.checklist.map((item, i) =>
                    `<div class="pcli${checked.has(i) ? ' done' : ''}" onclick="togPCL(${i})" id="pcl${i}">
                        <div class="pcli-box">${checked.has(i) ? '✓' : ''}</div>
                        <div class="pcli-text">${item}</div>
                    </div>`
                ).join('')}
            </div>
        </div>
    `;
    drawPrepCanvas(prepActive);
}

window.togPCL = function(i) {
    const s = prepCheckedSets[prepActive];
    s.has(i) ? s.delete(i) : s.add(i);
    const el = document.getElementById('pcl' + i);
    el.classList.toggle('done', s.has(i));
    el.querySelector('.pcli-box').textContent = s.has(i) ? '✓' : '';
    const cnt = document.getElementById('pclCount');
    if (cnt) cnt.textContent = `${s.size}/${prepData[prepActive].checklist.length}`;
};

document.querySelectorAll('.prep-tab').forEach(tab => {
    tab.onclick = () => {
        document.querySelectorAll('.prep-tab').forEach(b => b.classList.remove('on'));
        tab.classList.add('on');
        prepActive = tab.dataset.prep;
        renderPrep();
    };
});

function drawPrepCanvas(mode) {
    const c = document.getElementById('prepCv');
    if (!c) return;
    c.width = c.offsetWidth;
    c.height = 180;
    const ctx = c.getContext('2d');

    const pals = {
        before: ['#0e1e36', '#2d8fff'],
        during: ['#1e0e00', '#ff9900'],
        after: ['#061a0c', '#22c55e'],
        coast: ['#001422', '#00d4b0']
    };
    const [bg, acc] = pals[mode] || pals.before;
    const W = c.width,
        H = c.height;

    const gr = ctx.createLinearGradient(0, 0, W, H);
    gr.addColorStop(0, bg);
    gr.addColorStop(1, '#050810');
    ctx.fillStyle = gr;
    ctx.fillRect(0, 0, W, H);

    ctx.fillStyle = 'rgba(255,255,255,.55)';
    ctx.font = 'bold 12px Space Grotesk,sans-serif';

    if (mode === 'before') {
        ctx.fillText('🏫 Prepara tu aula', 10, 22);
        const bds = [
            [0.12, 0.4, 0.08, 0.44],
            [0.26, 0.34, 0.07, 0.42],
            [0.46, 0.37, 0.1, 0.46],
            [0.63, 0.34, 0.07, 0.42],
            [0.79, 0.4, 0.07, 0.43]
        ];
        bds.forEach(([x, y, w, h]) => {
            ctx.fillStyle = acc + '25';
            ctx.fillRect(W * x, H * y, W * w, H * h);
            ctx.strokeStyle = acc + '55';
            ctx.lineWidth = 1;
            ctx.strokeRect(W * x, H * y, W * w, H * h);
        });
        ctx.fillStyle = acc + '70';
        ctx.fillRect(W * 0.08, H * 0.68, W * 0.84, H * 0.07);
        ctx.fillStyle = 'rgba(255,255,255,.35)';
        ctx.font = '10px Space Grotesk,sans-serif';
        ctx.fillText('Identifica zonas seguras y rutas de salida', W * 0.12, H * 0.86);
    } else if (mode === 'during') {
        ctx.fillText('⚡ ¡Agáchate y cúbrete!', 10, 22);
        ctx.fillStyle = acc + '35';
        ctx.fillRect(W * 0.32, H * 0.28, W * 0.36, H * 0.38);
        ctx.strokeStyle = acc;
        ctx.lineWidth = 2;
        ctx.strokeRect(W * 0.32, H * 0.28, W * 0.36, H * 0.38);
        ctx.font = '32px';
        ctx.fillText('🪑', W * 0.42, H * 0.52);
        ctx.fillStyle = 'rgba(255,255,255,.35)';
        ctx.font = '10px Space Grotesk,sans-serif';
        ctx.fillText('▶ AGÁCHATE — CÚBRETE — SOSTENETE', W * 0.1, H * 0.86);
    } else if (mode === 'after') {
        ctx.fillText('✅ Evalúa y actúa con calma', 10, 22);
        [0.14, 0.34, 0.58, 0.78].forEach(x => {
            ctx.fillStyle = acc + '18';
            ctx.fillRect(W * x, H * 0.28, W * 0.1, H * 0.5);
            ctx.strokeStyle = acc + '45';
            ctx.lineWidth = 1;
            ctx.strokeRect(W * x, H * 0.28, W * 0.1, H * 0.5);
        });
        ctx.fillStyle = 'rgba(34,197,94,.3)';
        ctx.fillRect(0, H * 0.73, W, H * 0.07);
        ctx.fillStyle = 'rgba(255,255,255,.35)';
        ctx.font = '10px Space Grotesk,sans-serif';
        ctx.fillText('✓ Verifica daños y escucha instrucciones oficiales', W * 0.08, H * 0.86);
    } else {
        ctx.fillText('🌊 Costa Pacífica — Protocolo Tsunami', 10, 22);
        ctx.fillStyle = '#001f4d';
        ctx.fillRect(0, H * 0.55, W, H * 0.45);
        for (let i = 0; i < 4; i++) {
            ctx.beginPath();
            ctx.strokeStyle = `rgba(0,212,176,${0.4 - i * 0.08})`;
            ctx.lineWidth = 1.4;
            for (let x = 0; x < W; x++) {
                const y = H * 0.55 + Math.sin(x * 0.04 + i * 0.8) * 14 - i * 9;
                x === 0 ? ctx.moveTo(x, y) : ctx.lineTo(x, y);
            }
            ctx.stroke();
        }
        ctx.fillStyle = acc + '55';
        ctx.beginPath();
        ctx.arc(W * 0.7, H * 0.28, 18, 0, Math.PI * 2);
        ctx.fill();
        ctx.font = '14px';
        ctx.fillText('⛰', W * 0.66, H * 0.32);
        ctx.fillStyle = 'rgba(255,255,255,.35)';
        ctx.font = '10px Space Grotesk,sans-serif';
        ctx.fillText('▲ Evacúa hacia terrenos elevados (30m+)', W * 0.1, H * 0.86);
    }
}

  
//  17. BACKPACK
  

const bpCategories = [
    { id: 'agua', icon: '💧', title: 'Agua y Alimentos', accent: '#2d8fff',
        items: [
            { i: '💧', n: 'Agua (3L por persona/día)' },
            { i: '🥫', n: 'Comida enlatada (3 días)' },
            { i: '🍫', n: 'Barras energéticas' },
            { i: '🥤', n: 'Pastillas purificadoras' }
        ] },
    { id: 'med', icon: '🩹', title: 'Suministros Médicos', accent: '#ff4d6a',
        items: [
            { i: '🩹', n: 'Botiquín primeros auxilios' },
            { i: '💊', n: 'Medicamentos personales' },
            { i: '🩺', n: 'Manual de primeros auxilios' },
            { i: '🧴', n: 'Antiséptico y alcohol gel' }
        ] },
    { id: 'docs', icon: '📋', title: 'Documentos', accent: '#ff8c00',
        items: [
            { i: '📋', n: 'Copia de documentos (DUI)' },
            { i: '💰', n: 'Efectivo en billetes' },
            { i: '📱', n: 'Cargador portátil (batería)' },
            { i: '📞', n: 'Lista de contactos impresos' }
        ] },
    { id: 'tools', icon: '🔦', title: 'Herramientas de Emergencia', accent: '#00d4b0',
        items: [
            { i: '🔦', n: 'Linterna y pilas extra' },
            { i: '📻', n: 'Radio a pilas (MARN)' },
            { i: '🪦', n: 'Silbato de rescate' },
            { i: '🧥', n: 'Ropa y poncho impermeable' },
            { i: '🔑', n: 'Copia de llaves' },
            { i: '🗺', n: 'Mapa impreso de El Salvador' }
        ] }
];

const bpChecked = {};
let bpTotal = 0;
bpCategories.forEach(cat => {
    bpTotal += cat.items.length;
    cat.items.forEach((_, i) => {
        bpChecked[cat.id + '-' + i] = false;
    });
});

function renderBP() {
    const grid = document.getElementById('bpCatsGrid');
    if (!grid) return;

    let checked = 0;
    Object.values(bpChecked).forEach(v => { if (v) checked++; });
    const pct = Math.round(checked / bpTotal * 100);

    const pctEl = document.getElementById('bpPct');
    if (pctEl) pctEl.textContent = pct + '%';
    const fillEl = document.getElementById('bpFill');
    if (fillEl) fillEl.style.width = pct + '%';

    grid.innerHTML = bpCategories.map(cat => {
        const catChecked = cat.items.filter((_, i) => bpChecked[cat.id + '-' + i]).length;
        const allDone = catChecked === cat.items.length;
        return `<div class="bp-cat-card">
            <div class="bp-cat-hd">
                <span class="bp-cat-ico">${cat.icon}</span>
                <span class="bp-cat-name">${cat.title}</span>
                <span class="bp-cat-cnt${allDone ? ' done' : ''}">${catChecked}/${cat.items.length}</span>
            </div>
            <div class="bp-items-list">
                ${cat.items.map((item, i) => {
                    const key = cat.id + '-' + i;
                    const on = bpChecked[key];
                    return `<div class="bp-item${on ? ' ticked' : ''}" onclick="togBPItem('${key}')">
                        <span class="bp-item-icon">${item.i}</span>
                        <span class="bp-item-name">${item.n}</span>
                        <span class="bp-item-chk">${on ? '✓' : ''}</span>
                    </div>`;
                }).join('')}
            </div>
        </div>`;
    }).join('');
}

window.togBPItem = function(key) {
    bpChecked[key] = !bpChecked[key];
    renderBP();
};

window.resetBP = function() {
    Object.keys(bpChecked).forEach(k => bpChecked[k] = false);
    renderBP();
};

const bpItems = [];
const bpSet = new Set();
window.togBP = function() {};

  
//  18. TRIVIA
  

const trivQ = {
    easy: [
        { q: '¿Qué técnica usar durante un sismo?', o: ['Correr a la calle', 'Agáchate, Cúbrete, Sostenete',
                'Pararse en el marco de la puerta', 'Llamar al 911'
            ], c: 1,
            e: 'La técnica oficial de Cruz Roja es Agáchate, Cúbrete y Sostenete bajo mesa sólida.' },
        { q: '¿Cuál es el número de emergencias en El Salvador?', o: ['123', '112', '911', '1800'], c: 2,
            e: 'El 911 es el número unificado de emergencias.' },
        { q: '¿Cuántos días de suministros debe tener tu mochila?', o: ['1 día', '3 días', '7 días', '30 días'], c: 1,
            e: 'Se recomienda mínimo 3 días de agua y comida en el kit de emergencia.' },
        { q: '¿Qué puede ocurrir tras un sismo submarino?', o: ['Tornado', 'Tsunami', 'Granizo', 'Lluvia ácida'],
            c: 1, e: 'Un sismo submarino ≥M7.0 puede generar un tsunami desplazando el fondo oceánico.' },
        { q: '¿Cuál es el primer signo visual de un tsunami?', o: ['El mar sube', 'El mar se retira',
                'Suenan sirenas', 'El cielo se oscurece'
            ], c: 1,
            e: 'El retiro anormal del mar indica que un tsunami está llegando. Huye INMEDIATAMENTE.' }
    ],
    medium: [
        { q: '¿Qué placas tectónicas causan sismos en El Salvador?', o: ['Nazca y Sudamericana',
                'Cocos y del Caribe', 'Norteamericana y Pacífica', 'Filipina y Euroasiática'
            ], c: 1,
            e: 'La subducción de la Placa de Cocos bajo la del Caribe genera la actividad sísmica.' },
        { q: '¿Magnitud del terremoto del 13 de enero de 2001?', o: ['5.5', '6.2', '7.7', '8.1'], c: 2,
            e: 'El terremoto del 13-ene-2001 tuvo M7.7 y dejó más de 1,200 muertos.' },
        { q: '¿Qué mide la escala de magnitud?', o: ['Duración', 'Energía liberada', 'Daños en edificios',
                'Profundidad'
            ], c: 1, e: 'La magnitud mide la energía liberada en el foco. Cada unidad = ~32x más energía.' },
        { q: '¿A cuántos km/h viajan los tsunamis?', o: ['100', '300', '800', '2000'], c: 2,
            e: 'En mar abierto los tsunamis viajan a ~800 km/h, similar a un avión.' },
        { q: '¿Cuántos volcanes tiene El Salvador?', o: ['5', '10', '26', '50'], c: 2,
            e: 'El Salvador tiene ~26 volcanes, varios de ellos activos.' }
    ],
    hard: [
        { q: '¿A qué velocidad subduce la Placa de Cocos?', o: ['1 cm/año', '8 cm/año', '25 cm/año', '1 m/año'],
            c: 1, e: 'La Placa de Cocos subduce a ~8 cm/año, generando constante actividad sísmica.' },
        { q: '¿El "Triángulo de Vida" es técnica recomendada?', o: ['Sí, Cruz Roja', 'Sí, FEMA',
                'No, está desacreditado', 'Solo en edificios viejos'
            ], c: 2,
            e: 'El "Triángulo de Vida" fue formalmente desacreditado. Cruz Roja recomienda Agáchate-Cúbrete-Sostenete.' },
        { q: '¿Qué institución opera la Red Sísmica de El Salvador?', o: ['Cruz Roja', 'MARN', 'USGS', 'OPS'],
            c: 1, e: 'El MARN opera la Red Sísmica Nacional de El Salvador.' },
        { q: '¿Qué ondas sísmicas llegan primero?', o: ['Ondas S', 'Superficiales', 'Ondas P', 'Ondas Love'],
            c: 2, e: 'Las Ondas P (primarias) son las más rápidas y siempre llegan primero.' },
        { q: '¿Cuántos sismos perceptibles hay al año en El Salvador?', o: ['~10', '~50', '~100', '~500'], c: 2,
            e: 'El Salvador registra ~100 sismos perceptibles por año.' }
    ]
};

let tLv = '',
    tIdx = 0,
    tScore = 0,
    tAnswered = false;

document.querySelectorAll('.tlv').forEach(btn => {
    btn.onclick = () => {
        tLv = btn.dataset.lv;
        tIdx = 0;
        tScore = 0;
        document.getElementById('triSel').style.display = 'none';
        document.getElementById('triGame').style.display = 'block';
        document.getElementById('triRes').style.display = 'none';
        showTQ();
    };
});

function showTQ() {
    const qs = trivQ[tLv];
    if (tIdx >= qs.length) { showTRes(); return; }
    tAnswered = false;
    const q = qs[tIdx];
    const lvN = { easy: '🟢 Básico', medium: '🟡 Intermedio', hard: '🔴 Avanzado' };
    document.getElementById('triGame').innerHTML = `
        <div class="tg-hdr">
            <span>${lvN[tLv]}</span>
            <span>Puntos: ${tScore}</span>
            <span>${tIdx + 1}/${qs.length}</span>
        </div>
        <div class="tg-qcard">
            <div class="tg-q">${q.q}</div>
            <div class="tg-opts">
                ${q.o.map((o, i) => `<button class="tg-opt" onclick="ansT(${i})" id="to${i}">${['A','B','C','D'][i]}) ${o}</button>`).join('')}
            </div>
        </div>
        <div id="tfb"></div>
    `;
}

window.ansT = function(idx) {
    if (tAnswered) return;
    tAnswered = true;
    const q = trivQ[tLv][tIdx];
    if (idx === q.c) tScore++;
    document.querySelectorAll('.tg-opt').forEach((b, i) => {
        b.disabled = true;
        if (i === q.c) b.classList.add('cor');
        else if (i === idx) b.classList.add('wrg');
    });
    document.getElementById('tfb').innerHTML = `
        <div class="tg-fb ${idx === q.c ? 'c' : 'w'}">
            ${idx === q.c ? '✅ ¡Correcto!' : '❌ Incorrecto.'} ${q.e}
            <button class="btn-acc" style="margin-top:9px;font-size:.76rem;padding:6px 14px" onclick="nextT()">Siguiente →</button>
        </div>
    `;
};

window.nextT = function() {
    tIdx++;
    showTQ();
};

function showTRes() {
    document.getElementById('triGame').style.display = 'none';
    const total = trivQ[tLv].length,
        pct = Math.round(tScore / total * 100);
    const ico = pct === 100 ? '🏆' : pct >= 80 ? '🌟' : pct >= 60 ? '👍' : '📚';
    const res = document.getElementById('triRes');
    res.style.display = 'block';
    res.innerHTML = `
        <div style="font-size:3rem;margin-bottom:10px">${ico}</div>
        <h3 style="font-family:var(--fd);font-size:1.4rem;font-weight:800;margin-bottom:7px">¡Trivia Completada!</h3>
        <div class="tr-score">${tScore}/${total}</div>
        <p style="color:var(--text2);margin:10px 0">${pct >= 80 ? '¡Excelente! Dominas el tema.' : 'Sigue aprendiendo sobre preparación.'}</p>
        <div style="display:flex;gap:10px;justify-content:center;flex-wrap:wrap">
            <button class="btn-acc" onclick="rT()">↺ Reintentar</button>
            <button class="btn-out" onclick="chLv()">Cambiar nivel</button>
        </div>
    `;
}

window.rT = function() {
    tIdx = 0;
    tScore = 0;
    document.getElementById('triRes').style.display = 'none';
    document.getElementById('triGame').style.display = 'block';
    showTQ();
};

window.chLv = function() {
    document.getElementById('triRes').style.display = 'none';
    document.getElementById('triSel').style.display = 'block';
};

window.fd = function(f) {
    alert('📥 Descargando: ' + f + '\n\nEste archivo se descargaría desde los servidores del MINED/MARN en producción.');
};

  
//  19. FLOATING SEISMIC PARTICLES
  

(function() {
    const container = document.getElementById('seismicParticles');
    if (!container) return;

    for (let i = 0; i < 6; i++) {
        const wave = document.createElement('div');
        wave.className = 'sp-wave';
        wave.style.cssText = `
            top:${Math.random() * 100}%;
            animation-duration:${12 + Math.random() * 18}s;
            animation-delay:${Math.random() * 15}s;
            height:${1 + Math.random() * 2}px;
            opacity:${0.15 + Math.random() * 0.3};
            background:linear-gradient(90deg,transparent,rgba(${Math.random() > 0.5 ? '255,77,26' : '45,143,255'},0.3),transparent);
        `;
        container.appendChild(wave);
    }

    for (let i = 0; i < 5; i++) {
        const plate = document.createElement('div');
        plate.className = 'sp-plate';
        const size = 40 + Math.random() * 50;
        plate.style.cssText = `
            left:${Math.random() * 90}%;
            top:${Math.random() * 90}%;
            width:${size}px;
            height:${size * 0.65}px;
            animation-duration:${8 + Math.random() * 12}s;
            animation-delay:${Math.random() * 8}s;
            border-color:rgba(${Math.random() > 0.5 ? '255,77,26' : '0,212,176'},0.12);
            transform:rotate(${Math.random() * 360}deg);
        `;
        container.appendChild(plate);
    }

    for (let i = 0; i < 4; i++) {
        const ring = document.createElement('div');
        ring.className = 'sp-ring';
        const size = 30 + Math.random() * 40;
        ring.style.cssText = `
            left:${10 + Math.random() * 80}%;
            top:${10 + Math.random() * 80}%;
            width:${size}px;
            height:${size}px;
            animation-duration:${4 + Math.random() * 5}s;
            animation-delay:${Math.random() * 6}s;
            border-color:rgba(${Math.random() > 0.5 ? '255,77,26' : '0,212,176'},0.18);
        `;
        container.appendChild(ring);
    }
})();

  
//  20. 3D MOUSE PARALLAX ON HERO
  

(function() {
    const hero = document.getElementById('home');
    if (!hero) return;

    hero.addEventListener('mousemove', (e) => {
        const rect = hero.getBoundingClientRect();
        const mx = (e.clientX - rect.left) / rect.width - 0.5;
        const my = (e.clientY - rect.top) / rect.height - 0.5;

        const monitor = hero.querySelector('.hero-monitor');
        if (monitor) {
            monitor.style.transform =
                `perspective(800px) rotateY(${mx * 6}deg) rotateX(${-my * 4}deg) translateZ(10px)`;
        }
        const heroInner = hero.querySelector('.hero-inner');
        if (heroInner) {
            heroInner.style.transform = `translate(${mx * 8}px, ${my * 5}px)`;
        }
    });

    hero.addEventListener('mouseleave', () => {
        const monitor = hero.querySelector('.hero-monitor');
        if (monitor) monitor.style.transform = '';
        const heroInner = hero.querySelector('.hero-inner');
        if (heroInner) heroInner.style.transform = '';
    });
})();

  
//  21. SEISMIC BG LINES IN MONITOR PANEL
  

(function() {
    const waveArea = document.querySelector('.sg-wave-area');
    if (!waveArea) return;

    const bgDiv = document.createElement('div');
    bgDiv.className = 'sg-bg-lines';
    for (let i = 0; i < 6; i++) {
        const line = document.createElement('div');
        line.className = 'sg-bg-line';
        line.style.cssText = `top:${15 + i * 14}%;animation:swbAnim ${14 + i * 3}s linear ${i * 2}s infinite;`;
        bgDiv.appendChild(line);
    }
    waveArea.appendChild(bgDiv);
})();

  
//  22. SECTION SCROLL ANIMATIONS
  

(function() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.plate-card, .nc, .rc, .mec, .fbi, .wc-card').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity .5s ease, transform .5s ease';
        observer.observe(el);
    });
})();

  
//  23. RT MONITOR CLOCK
  

function initRTMonitor() {
    function tick() {
        const el = document.getElementById('rtmClock');
        if (el) el.textContent = new Date().toLocaleTimeString('es-SV', { hour: '2-digit', minute: '2-digit',
            second: '2-digit', timeZone: 'America/El_Salvador' });
    }
    tick();
    setInterval(tick, 1000);
}

  
//  24. BUILDING SHAKE VISUALIZATION
  

function initBuildingShake() {
    const row = document.getElementById('buildingsRow');
    if (!row) return;
    const heights = [35, 55, 45, 70, 40, 60, 38, 52, 65, 42, 58, 46, 72, 38];
    row.innerHTML = heights.map((h, i) => `<div class="bld" id="bld${i}" style="height:${h}px"></div>`).join('');
}

window.setIntensity = function(level, btn) {
    document.querySelectorAll('.int-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    const statusEl = document.getElementById('shakeStatus');
    const rangeEl = document.getElementById('intMagRange');
    const blds = document.querySelectorAll('.bld');

    blds.forEach(b => b.classList.remove('shake'));

    if (level === 'leve') {
        if (statusEl) { statusEl.textContent = '✓ SACUDIDA LEVE';
            statusEl.className = 'shake-status'; }
        if (rangeEl) rangeEl.textContent = 'M 1.0 – 3.4';
    } else if (level === 'moderado') {
        if (statusEl) { statusEl.textContent = '⚡ SACUDIDA MODERADA';
            statusEl.className = 'shake-status warn'; }
        if (rangeEl) rangeEl.textContent = 'M 3.5 – 5.9';
        blds.forEach((b, i) => { if (i % 2 === 0) b.classList.add('shake'); });
    } else {
        if (statusEl) { statusEl.textContent = '🚨 SISMO FUERTE — EVACUACIÓN';
            statusEl.className = 'shake-status danger'; }
        if (rangeEl) rangeEl.textContent = 'M 6.0+';
        blds.forEach(b => b.classList.add('shake'));
    }
};

  
//  25. 3D BACKPACK
  

const bpItems3d = [
    { i: '💧', n: 'Agua 3L' }, { i: '🥫', n: 'Comida' }, { i: '🔦', n: 'Linterna' }, { i: '🔋', n: 'Pilas' },
    { i: '🩹', n: 'Botiquín' }, { i: '📋', n: 'Documentos' }, { i: '💊', n: 'Medicinas' }, { i: '📻', n: 'Radio' },
    { i: '🔑', n: 'Llaves' }, { i: '💰', n: 'Efectivo' }, { i: '🧥', n: 'Ropa' }, { i: '📱', n: 'Cargador' },
    { i: '🪦', n: 'Silbato' }, { i: '🗺', n: 'Mapa SV' }, { i: '🧴', n: 'Sanitizante' }, { i: '🪛', n: 'Navaja' }
];

const bpSet3d = new Set();

function renderBP3D() {
    const grid = document.getElementById('bpGrid3d');
    if (!grid) return;

    grid.innerHTML = bpItems3d.map((item, i) =>
        `<div class="bpi-3d${bpSet3d.has(i) ? ' on' : ''}" onclick="togBP3D(${i})" title="${item.n}">
            <span class="bpi-3d-ico">${item.i}</span>
            <span class="bpi-3d-nm">${item.n}</span>
        </div>`
    ).join('');

    const pct = Math.round(bpSet3d.size / bpItems3d.length * 100);

    const fill3d = document.getElementById('bpFill3d');
    const pct3d = document.getElementById('bpPct3d');
    if (fill3d) fill3d.style.width = pct + '%';
    if (pct3d) pct3d.textContent = pct + '%';

    const fillOld = document.getElementById('bpFill');
    const pctOld = document.getElementById('bpPct');
    if (fillOld) fillOld.style.width = pct + '%';
    if (pctOld) pctOld.textContent = pct + '%';
}

window.togBP3D = function(i) {
    bpSet3d.has(i) ? bpSet3d.delete(i) : bpSet3d.add(i);
    renderBP3D();
};

// 3D drag interaction
(function() {
    const bp = document.getElementById('bp3d');
    if (!bp) return;

    let dragging = false,
        startX = 0,
        startY = 0,
        rotX = 4,
        rotY = -12;

    bp.addEventListener('mousedown', e => {
        dragging = true;
        startX = e.clientX;
        startY = e.clientY;
        bp.style.animation = 'none';
        e.preventDefault();
    });

    window.addEventListener('mousemove', e => {
        if (!dragging) return;
        const dx = (e.clientX - startX) * 0.5,
            dy = (e.clientY - startY) * 0.3;
        rotY = Math.max(-30, Math.min(30, rotY + dx / 10));
        rotX = Math.max(-15, Math.min(15, rotX - dy / 10));
        bp.style.transform = `rotateY(${rotY}deg) rotateX(${rotX}deg)`;
        startX = e.clientX;
        startY = e.clientY;
    });

    window.addEventListener('mouseup', () => {
        if (dragging) {
            dragging = false;
            setTimeout(() => { bp.style.animation = ''; }, 200);
        }
    });
})();

  
//  26. TSUNAMI API FEED
  

async function loadTsunamiFeed() {
    const feed = document.getElementById('tsFeed');
    if (!feed) return;

    try {
        const resp = await fetch(
            'https://earthquake.usgs.gov/fdsnws/event/1.query?format=geojson&minmagnitude=5.5&maxlatitude=15&minlatitude=6&maxlongitude=-78&minlongitude=-95&limit=6&orderby=time'
            );
        const data = await resp.json();
        const quakes = data.features || [];
        if (!quakes.length) throw new Error('no data');

        feed.innerHTML = quakes.map(q => {
            const m = q.properties.mag;
            const place = q.properties.place || 'Región Centroamérica';
            const time = new Date(q.properties.time).toLocaleString('es-SV', { month: 'short', day: 'numeric',
                hour: '2-digit', minute: '2-digit' });
            const depth = q.geometry?.coordinates?.[2] || '?';
            const potential = m >= 7.0;
            const watch = m >= 6.0 && !potential;
            return `<div class="ts-feed-item">
                <div class="ts-mag-badge ${potential ? 'ts-potential' : 'ts-watch'}">${m.toFixed(1)}</div>
                <div class="ts-info">
                    <div class="ts-info-place">${place}</div>
                    <div class="ts-info-meta">${time} · Prof: ${Math.round(depth)}km</div>
                </div>
                <span class="ts-alert-chip ${potential ? 'red' : watch ? 'org' : 'ok'}">${potential ? 'Alerta' : watch ? 'Vigilancia' : 'Sin alerta'}</span>
            </div>`;
        }).join('');
    } catch (e) {
        feed.innerHTML = [
            { m: 6.2, place: '35 km SW de La Libertad, El Salvador', time: '8 mar, 11:42', depth: 15,
            alert: 'org' },
            { m: 5.8, place: 'Frente a costas de Acajutla, El Salvador', time: '7 mar, 09:18', depth: 28,
                alert: 'ok' },
            { m: 7.1, place: '98 km SO de San Miguel, El Salvador', time: '5 mar, 14:55', depth: 35,
            alert: 'red' },
            { m: 5.5, place: 'Placa de Cocos — Mar Pacífico', time: '4 mar, 07:22', depth: 12, alert: 'ok' },
        ].map(q => `<div class="ts-feed-item">
            <div class="ts-mag-badge ${q.alert === 'red' ? 'ts-potential' : 'ts-watch'}">${q.m}</div>
            <div class="ts-info">
                <div class="ts-info-place">${q.place}</div>
                <div class="ts-info-meta">${q.time} · Prof: ${q.depth}km</div>
            </div>
            <span class="ts-alert-chip ${q.alert}">${q.alert === 'red' ? 'Potencial Tsunami' : q.alert === 'org' ? 'Vigilancia' : 'Sin alerta'}</span>
        </div>`).join('');
    }
}

  
//  27. TSUNAMI EVACUATION CANVAS SIMULATION
  

let tsEvacRunning = false,
    tsEvacT = 0,
    tsEvacInterval = null,
    tsEvacTicker = null;

function initEvacCanvas() {
    const c = document.getElementById('tsEvacCv');
    if (!c) return;
    c.width = c.offsetWidth || 400;
    c.height = 200;
    drawEvacStatic(c, 0);
}

function drawEvacStatic(c, waveX) {
    const ctx = c.getContext('2d');
    const W = c.width,
        H = c.height;
    ctx.clearRect(0, 0, W, H);

    const sky = ctx.createLinearGradient(0, 0, 0, H * 0.6);
    sky.addColorStop(0, '#000e1e');
    sky.addColorStop(1, '#001e38');
    ctx.fillStyle = sky;
    ctx.fillRect(0, 0, W, H * 0.6);

    ctx.fillStyle = '#0a1e10';
    ctx.fillRect(0, H * 0.6, W, H * 0.4);

    ctx.fillStyle = '#0d2d18';
    ctx.beginPath();
    ctx.moveTo(W * 0.6, H * 0.6);
    ctx.lineTo(W * 0.72, H * 0.18);
    ctx.lineTo(W * 0.84, H * 0.6);
    ctx.fill();

    ctx.fillStyle = '#0f3520';
    ctx.beginPath();
    ctx.moveTo(W * 0.73, H * 0.6);
    ctx.lineTo(W * 0.83, H * 0.25);
    ctx.lineTo(W * 0.93, H * 0.6);
    ctx.fill();

    ctx.fillStyle = 'rgba(0,212,176,.6)';
    ctx.font = 'bold 9px Space Grotesk,sans-serif';
    ctx.textAlign = 'center';
    ctx.fillText('ZONA SEGURA', W * 0.8, H * 0.15);

    ctx.strokeStyle = 'rgba(0,212,176,.5)';
    ctx.lineWidth = 2;
    ctx.setLineDash([8, 4]);
    ctx.beginPath();
    ctx.moveTo(W * 0.1, H * 0.65);
    ctx.lineTo(W * 0.72, H * 0.4);
    ctx.stroke();
    ctx.setLineDash([]);

    if (waveX > 0) {
        ctx.fillStyle = 'rgba(30,80,200,.7)';
        ctx.beginPath();
        ctx.moveTo(0, H * 0.5);
        for (let x = 0; x <= Math.min(waveX, W); x++) {
            const y = H * 0.5 - Math.sin(x * 0.08) * 18 * (1 + waveX / W * 1.2);
            ctx.lineTo(x, y);
        }
        ctx.lineTo(Math.min(waveX, W), H);
        ctx.lineTo(0, H);
        ctx.closePath();
        ctx.fill();

        ctx.strokeStyle = 'rgba(100,180,255,.8)';
        ctx.lineWidth = 2;
        ctx.setLineDash([]);
        ctx.beginPath();
        for (let x = 0; x <= Math.min(waveX, W); x++) {
            const y = H * 0.5 - Math.sin(x * 0.08) * 18 * (1 + waveX / W * 1.2);
            x === 0 ? ctx.moveTo(x, y) : ctx.lineTo(x, y);
        }
        ctx.stroke();
    }

    const personX = waveX > 0 ? Math.min(W * 0.1 + waveX * 0.55, W * 0.72) : W * 0.12;
    const personY = H * 0.58;
    ctx.fillStyle = '#fff';
    ctx.font = '18px serif';
    ctx.textAlign = 'center';
    ctx.fillText('🏃', personX, personY);

    if (waveX === 0) {
        ctx.fillStyle = 'rgba(255,255,255,.5)';
        ctx.font = '11px Space Grotesk,sans-serif';
        ctx.textAlign = 'center';
        ctx.fillText('Pulsa "Iniciar Simulación" para comenzar', W / 2, H * 0.88);
    }
    ctx.textAlign = 'left';
}

window.startEvacSim = function() {
    if (tsEvacRunning) return;
    tsEvacRunning = true;
    tsEvacT = 0;

    const c = document.getElementById('tsEvacCv');
    if (!c) return;
    c.width = c.offsetWidth;

    const timerEl = document.getElementById('tsTimer');
    const statusEl = document.getElementById('tsEvacStatus');

    let waveX = 0;

    if (tsEvacTicker) clearInterval(tsEvacTicker);
    tsEvacTicker = setInterval(() => {
        tsEvacT++;
        if (timerEl) timerEl.textContent =
            `${String(Math.floor(tsEvacT / 60)).padStart(2, '0')}:${String(tsEvacT % 60).padStart(2, '0')}`;
    }, 1000);

    if (tsEvacInterval) cancelAnimationFrame(tsEvacInterval);

    function animate() {
        waveX += 1.8;
        drawEvacStatic(c, waveX);

        if (waveX < c.width * 1.1) {
            tsEvacInterval = requestAnimationFrame(animate);
            if (statusEl) {
                const prog = waveX / c.width;
                if (prog < 0.3) statusEl.textContent = '⚡ Tsunami detectado — evacuando…';
                else if (prog < 0.7) statusEl.textContent = '🏃 Corriendo hacia zona segura…';
                else statusEl.textContent = '✓ ¡Zona segura alcanzada!';
            }
        } else {
            tsEvacRunning = false;
            clearInterval(tsEvacTicker);
            if (statusEl) statusEl.textContent = `✓ ¡Evacuación exitosa en ${timerEl ? timerEl.textContent : '—'}!`;
        }
    }
    animate();
};

window.resetEvacSim = function() {
    tsEvacRunning = false;
    clearInterval(tsEvacTicker);
    if (tsEvacInterval) cancelAnimationFrame(tsEvacInterval);
    tsEvacT = 0;

    const timerEl = document.getElementById('tsTimer');
    const statusEl = document.getElementById('tsEvacStatus');
    if (timerEl) timerEl.textContent = '00:00';
    if (statusEl) statusEl.textContent = 'Listo';

    const c = document.getElementById('tsEvacCv');
    if (c) { c.width = c.offsetWidth;
        drawEvacStatic(c, 0); }
};

  
//  28. GAME MODALS
  

window.openGame = function(id) {
    document.getElementById('modal-' + id).classList.add('open');
};

window.closeGame = function(id) {
    document.getElementById('modal-' + id).classList.remove('open');
};

document.querySelectorAll('.game-modal').forEach(m => {
    m.addEventListener('click', e => {
        if (e.target === m) m.classList.remove('open');
    });
});

  
//  29. RICHTER QUIZ GAME
  

const richterQuestions = [
    { q: '¿Qué magnitud tuvo el terremoto del 13 de enero de 2001 en El Salvador?',
        opts: ['M 5.5', 'M 6.2', 'M 7.7', 'M 8.1'], c: 2,
        exp: 'El sismo del 13-ene-2001 tuvo M7.7 con epicentro al sur del país. Fue el más destructivo en décadas, causando más de 1,200 muertos y destruyendo 100,000+ viviendas.' },
    { q: '¿A qué velocidad viaja un tsunami en el océano Pacífico frente a El Salvador?',
        opts: ['200 km/h', '400 km/h', '800 km/h', '1,600 km/h'], c: 2,
        exp: 'Los tsunamis viajan a ~800 km/h en océano abierto, similar a un avión. Desde el epicentro frente a El Salvador pueden llegar a la costa en 15-25 minutos.' },
    { q: '¿Cuántos metros de tsunami puede protegerte si llegas a zona segura?',
        opts: ['5 metros', '15 metros', '30 metros', '100 metros'], c: 2,
        exp: 'La recomendación oficial es buscar terreno a mínimo 30 metros sobre el nivel del mar. En El Salvador, el Cerro El Picacho y las alturas de Jayaque son puntos de referencia.' },
    { q: '¿Qué placa tectónica subduce bajo El Salvador causando sismos?',
        opts: ['Placa del Pacífico', 'Placa de Nazca', 'Placa de Cocos', 'Placa Norteamericana'], c: 2,
        exp: 'La Placa de Cocos subduce bajo la Placa del Caribe a ~8 cm/año. Esta colisión genera la mayoría de los sismos de El Salvador, incluyendo los de la zona de subducción frente a la costa.' },
    { q: '¿Cuántos volcanes activos tiene El Salvador?', opts: ['5', '10', '20', '26'], c: 3,
        exp: 'El Salvador tiene aproximadamente 26 volcanes, varios de ellos activos. El Izalco (Faro del Pacífico), Santa Ana y San Miguel son los más conocidos y monitoreados por el MARN.' },
    { q: '¿Cuál es el primer signo visual de un tsunami en la costa de El Salvador?',
        opts: ['El mar sube de golpe', 'El mar se retira anormalmente', 'El cielo se oscurece',
            'El suelo tiembla bajo el agua'
        ], c: 1,
        exp: 'El retiro anormal del mar (la playa queda al descubierto de forma inusual) es el primer aviso visual. En playas como El Tunco o El Zonte, esto significa que tienes 5-15 minutos para evacuar.' }
];

let rqIdx = 0,
    rqScore = 0,
    rqAnswered = false;

window.startRichterGame = function() {
    rqIdx = 0;
    rqScore = 0;
    rqAnswered = false;
    showRichterQ();
};

function showRichterQ() {
    const container = document.getElementById('richterGame');
    if (!container) return;

    if (rqIdx >= richterQuestions.length) {
        const pct = Math.round(rqScore / richterQuestions.length * 100);
        container.innerHTML = `<div style="text-align:center;padding:16px">
            <div style="font-size:2.5rem;margin-bottom:8px">${pct >= 80 ? '🏆' : pct >= 60 ? '🌟' : '📚'}</div>
            <div class="rg-score">${rqScore}/${richterQuestions.length}</div>
            <p style="color:var(--text2);margin:10px 0">${pct >= 80 ? '¡Excelente! Estás preparado para El Salvador.' : 'Sigue aprendiendo sobre sismos salvadoreños.'}</p>
            <button class="btn-acc" onclick="startRichterGame()">↺ Jugar de nuevo</button>
        </div>`;
        return;
    }

    const q = richterQuestions[rqIdx];
    rqAnswered = false;
    container.innerHTML = `<div class="richter-game">
        <div style="font-size:.72rem;color:var(--text3);margin-bottom:8px">Pregunta ${rqIdx + 1} de ${richterQuestions.length} · Puntos: ${rqScore}</div>
        <div class="rg-question">${q.q}</div>
        <div class="rg-options">${q.opts.map((o, i) => `<button class="rg-opt" id="rqo${i}" onclick="answerRQ(${i})">${o}</button>`).join('')}</div>
        <div id="rqFeedback"></div>
    </div>`;
}

window.answerRQ = function(idx) {
    if (rqAnswered) return;
    rqAnswered = true;
    const q = richterQuestions[rqIdx];
    if (idx === q.c) rqScore++;

    document.querySelectorAll('.rg-opt').forEach((b, i) => {
        b.disabled = true;
        if (i === q.c) b.classList.add('correct');
        else if (i === idx) b.classList.add('wrong');
    });

    document.getElementById('rqFeedback').innerHTML =
        `<div class="rg-explain">${idx === q.c ? '✅' : '❌'} ${q.exp} <br><br><button class="btn-acc" style="font-size:.76rem;padding:6px 14px;margin-top:6px" onclick="rqNext()">Siguiente →</button></div>`;
};

window.rqNext = function() {
    rqIdx++;
    showRichterQ();
};

  
//  30. EVACUATION ROUTE GAME
  

const EVAC_MAP = [
    ['W', 'W', 'W', 'W', 'W', 'W', 'W', 'E'],
    ['W', 'P', 'P', 'P', 'W', 'P', 'P', 'E'],
    ['S', 'P', 'W', 'P', 'W', 'P', 'W', 'W'],
    ['W', 'P', 'W', 'P', 'P', 'P', 'P', 'W'],
    ['W', 'P', 'W', 'W', 'W', 'W', 'P', 'W'],
    ['W', 'P', 'P', 'P', 'W', 'P', 'P', 'W'],
    ['W', 'W', 'W', 'P', 'W', 'W', 'D', 'W'],
    ['W', 'W', 'W', 'D', 'W', 'W', 'W', 'W']
];

let evacSelected = null,
    evacMoves = [],
    evacTimerVal = 0,
    evacTimerI = null,
    evacDone = false;

function initEvacGame() {
    evacSelected = null;
    evacMoves = [];
    evacDone = false;
    evacTimerVal = 0;
    clearInterval(evacTimerI);
    document.getElementById('evacStep').textContent = '0/5';
    document.getElementById('evacMsg').textContent = '';
    evacTimerI = setInterval(() => {
        evacTimerVal++;
        document.getElementById('evacTime').textContent = evacTimerVal + 's';
    }, 1000);
    renderEvacGrid();
}

function renderEvacGrid() {
    const grid = document.getElementById('evacGrid');
    if (!grid) return;

    grid.innerHTML = EVAC_MAP.map((row, r) =>
        row.map((cell, c) => {
            const isSelected = evacMoves.some(m => m[0] === r && m[1] === c);
            const cls = cell === 'W' ? 'wall' :
                cell === 'S' ? 'start' :
                cell === 'E' ? 'end' :
                cell === 'D' ? 'danger' : 'path';
            const extra = isSelected ? 'selected' : '';
            const ico = cell === 'S' ? '🏠' :
                cell === 'E' ? '⛰' :
                cell === 'D' ? '🌊' : '';
            return `<div class="evg-cell ${cls} ${extra}" onclick="evacClick(${r},${c})">${ico}</div>`;
        }).join('')
    ).join('');
}

window.evacClick = function(r, c) {
    if (evacDone) return;
    const cell = EVAC_MAP[r][c];
    if (cell === 'W') return;

    if (cell === 'D') {
        document.getElementById('evacMsg').textContent = '💀 ¡Tocaste el tsunami! Reinicia.';
        clearInterval(evacTimerI);
        evacDone = true;
        evacMoves.push([r, c]);
        renderEvacGrid();
        return;
    }

    if (evacMoves.some(m => m[0] === r && m[1] === c)) return;
    evacMoves.push([r, c]);
    document.getElementById('evacStep').textContent = `${Math.min(evacMoves.length, 5)}/5`;

    if (cell === 'E') {
        clearInterval(evacTimerI);
        evacDone = true;
        document.getElementById('evacMsg').textContent = `✅ ¡Salvado en ${evacTimerVal}s!`;
    }
    renderEvacGrid();
};

  
//  31. MEMORY GAME
  

const memSymbols = ['💧', '🔦', '🩹', '📻', '🎒', '🗺', '💊', '🔋'];
let memCards = [],
    memFlipped = [],
    memMatched = new Set(),
    memMoveCount = 0,
    memLocked = false;

function initMemoryGame() {
    const all = [...memSymbols, ...memSymbols].sort(() => Math.random() - 0.5);
    memCards = all;
    memFlipped = [];
    memMatched = new Set();
    memMoveCount = 0;
    memLocked = false;
    document.getElementById('memMoves').textContent = '0';
    document.getElementById('memPairs').textContent = '0/8';
    const winEl = document.getElementById('memWin');
    if (winEl) winEl.style.display = 'none';
    renderMemory();
}

function renderMemory() {
    const grid = document.getElementById('memoryGrid');
    if (!grid) return;

    grid.innerHTML = memCards.map((sym, i) => {
        const isFlipped = memFlipped.includes(i) || memMatched.has(i);
        const isMatched = memMatched.has(i);
        return `<div class="mem-card${isFlipped ? ' flip' : ''}${isMatched ? ' matched' : ''}" onclick="flipMem(${i})">
            <div class="mem-front">?</div>
            <div class="mem-back">${sym}</div>
        </div>`;
    }).join('');
}

window.flipMem = function(i) {
    if (memLocked || memFlipped.includes(i) || memMatched.has(i)) return;
    memFlipped.push(i);
    renderMemory();

    if (memFlipped.length === 2) {
        memMoveCount++;
        document.getElementById('memMoves').textContent = memMoveCount;
        memLocked = true;

        setTimeout(() => {
            const [a, b] = memFlipped;
            if (memCards[a] === memCards[b]) {
                memMatched.add(a);
                memMatched.add(b);
                document.getElementById('memPairs').textContent = `${memMatched.size / 2}/8`;
                if (memMatched.size === memCards.length) {
                    const w = document.getElementById('memWin');
                    if (w) w.style.display = 'block';
                }
            }
            memFlipped = [];
            memLocked = false;
            renderMemory();
        }, 900);
    }
};

  
//  32. RTM STATS UPDATE
  

function updateRTMStats(quakes) {
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    const todayQ = quakes.filter(q => new Date(q.properties.time) >= today);

    const el1 = document.getElementById('rtm-today');
    if (el1) el1.textContent = todayQ.length || '—';

    if (quakes.length > 0) {
        const last = quakes[0];
        const el2 = document.getElementById('rtm-mag');
        if (el2) el2.textContent = 'M' + last.properties.mag;

        const depth = last.geometry?.coordinates?.[2];
        const el3 = document.getElementById('rtm-depth');
        if (el3) el3.textContent = depth ? Math.round(depth) + 'km' : '—';
    }
}

  
//  33. AUTH SYSTEM
  

let currentUser = null;
let registeredUsers = JSON.parse(localStorage.getItem('ndaUsers') || '[]');

function openAuth(tab) {
    document.getElementById('authOverlay').classList.add('open');
    switchAuthTab(tab || 'login');
}

function closeAuth() {
    document.getElementById('authOverlay').classList.remove('open');
}

function handleAuthOverlayClick(e) {
    if (e.target === document.getElementById('authOverlay')) closeAuth();
}

function switchAuthTab(tab) {
    const loginForm = document.getElementById('formLogin');
    const regForm = document.getElementById('formRegister');
    const tabL = document.getElementById('tabLogin');
    const tabR = document.getElementById('tabRegister');

    if (tab === 'login') {
        loginForm.style.display = 'flex';
        regForm.style.display = 'none';
        tabL.classList.add('on');
        tabR.classList.remove('on');
    } else {
        loginForm.style.display = 'none';
        regForm.style.display = 'flex';
        tabR.classList.add('on');
        tabL.classList.remove('on');
    }
}

let selectedRole = 'alumno';

function selectRole(el) {
    document.querySelectorAll('.role-opt').forEach(r => r.classList.remove('on'));
    el.classList.add('on');
    selectedRole = el.dataset.role;
}

function showAuthMsg(id, msg, type) {
    const el = document.getElementById(id);
    el.textContent = msg;
    el.className = 'auth-msg ' + type;
    el.style.display = 'block';
    setTimeout(() => { el.style.display = 'none'; }, 3500);
}

function doLogin() {
    const email = document.getElementById('loginEmail').value.trim();
    const pwd = document.getElementById('loginPwd').value;

    if (!email || !pwd) return showAuthMsg('loginMsg', 'Completa todos los campos.', 'err');

    if (email === 'admin@nda.edu.sv' && pwd === 'admin123') {
        loginSuccess({ name: 'Administrador NDA', email, role: 'admin' });
        return;
    }

    const user = registeredUsers.find(u => u.email === email && u.pwd === pwd);
    if (!user) return showAuthMsg('loginMsg', 'Correo o contraseña incorrectos.', 'err');
    loginSuccess(user);
}

function doRegister() {
    const name = document.getElementById('regName').value.trim();
    const email = document.getElementById('regEmail').value.trim();
    const pwd = document.getElementById('regPwd').value;

    if (!name || !email || !pwd) return showAuthMsg('registerMsg', 'Completa todos los campos.', 'err');
    if (pwd.length < 6) return showAuthMsg('registerMsg', 'La contraseña debe tener al menos 6 caracteres.', 'err');
    if (registeredUsers.find(u => u.email === email)) return showAuthMsg('registerMsg', 'Este correo ya está registrado.',
        'err');

    const user = { name, email, pwd, role: selectedRole };
    registeredUsers.push(user);
    localStorage.setItem('ndaUsers', JSON.stringify(registeredUsers));

    showAuthMsg('registerMsg', '¡Cuenta creada! Iniciando sesión…', 'ok');
    setTimeout(() => loginSuccess(user), 1200);
}

function loginSuccess(user) {
    currentUser = user;
    closeAuth();
    document.getElementById('navAuthBtns').style.display = 'none';
    document.getElementById('navUserMenu').style.display = 'flex';

    const initials = user.name.split(' ').map(w => w[0]).join('').substring(0, 2).toUpperCase();
    document.getElementById('navAvatar').textContent = initials;
    document.getElementById('navUserName').textContent = user.name.split(' ')[0];

    if (['admin', 'docente'].includes(user.role)) {
        document.getElementById('mobNav').insertAdjacentHTML('beforeend',
            `<a href="#colegio" onclick="openSchoolModule()">🏫 Módulo Colegio</a>`);
    }
}

function logout() {
    currentUser = null;
    document.getElementById('navAuthBtns').style.display = 'flex';
    document.getElementById('navUserMenu').style.display = 'none';
    document.getElementById('colegio').style.display = 'none';
    closeUserDD();
}

function toggleUserDD() {
    document.getElementById('navUserDD').classList.toggle('open');
}

function closeUserDD() {
    document.getElementById('navUserDD').classList.remove('open');
}

document.addEventListener('click', e => {
    const menu = document.getElementById('navUserMenu');
    if (menu && !menu.contains(e.target)) closeUserDD();
});

  
//  34. SCHOOL MODULE
  

const schoolData = {
    alumnos: [
        { id: 1, name: 'Carlos Martínez', grado: '10°A', tutor: 'Prof. López', estado: 'activo' },
        { id: 2, name: 'María González', grado: '10°A', tutor: 'Prof. López', estado: 'activo' },
        { id: 3, name: 'José Ramírez', grado: '11°B', tutor: 'Prof. Flores', estado: 'activo' },
        { id: 4, name: 'Ana Hernández', grado: '10°A', tutor: 'Prof. López', estado: 'activo' },
        { id: 5, name: 'Luis Pérez', grado: '11°B', tutor: 'Prof. Flores', estado: 'activo' },
        { id: 6, name: 'Sofía Torres', grado: '9°C', tutor: 'Prof. Mena', estado: 'activo' },
        { id: 7, name: 'Diego Salinas', grado: '9°C', tutor: 'Prof. Mena', estado: 'activo' },
        { id: 8, name: 'Valeria Cruz', grado: '10°A', tutor: 'Prof. López', estado: 'activo' },
    ],
    docentes: [
        { id: 1, name: 'Prof. Ana López', materia: 'Ciencias', aula: '10°A', ruta: 'R-1', tel: '7788-0001' },
        { id: 2, name: 'Prof. Marco Flores', materia: 'Matemáticas', aula: '11°B', ruta: 'R-2', tel: '7788-0002' },
        { id: 3, name: 'Prof. Elena Mena', materia: 'Lenguaje', aula: '9°C', ruta: 'R-1', tel: '7788-0003' },
        { id: 4, name: 'Prof. Roberto Díaz', materia: 'Sociales', aula: '12°D', ruta: 'R-3', tel: '7788-0004' },
    ],
    rutas: [
        { id: 'R-1', nombre: 'Ruta Norte', descripcion: 'Pabellón A → Pasillo norte → Cancha → Punto 1',
            estado: 'despejada', color: '#00d4b0' },
        { id: 'R-2', nombre: 'Ruta Sur', descripcion: 'Pabellón B → Salida sur → Jardín → Punto 2',
            estado: 'despejada', color: '#3d9bff' },
        { id: 'R-3', nombre: 'Ruta Este', descripcion: 'Pabellón C → Pasilllo este → Portón → Punto 3',
            estado: 'bloqueada', color: '#ff9900' },
    ],
    incidentes: [],
    simulacros: [
        { id: 1, fecha: '2025-03-15', tipo: 'Sísmico', duracion: '4:32', aulas: 8, issues: 'Ruta R-3 obstruida',
            nota: 'Buen tiempo de evacuación' },
        { id: 2, fecha: '2024-10-22', tipo: 'Incendio', duracion: '5:10', aulas: 8, issues: 'Ninguno',
            nota: 'Simulacro completado exitosamente' },
    ]
};

let pasList = schoolData.alumnos.map(a => ({ ...a, status: 'pendiente' }));

function openSchoolModule() {
    if (!currentUser) { openAuth('login'); return; }
    closeUserDD();

    const sec = document.getElementById('colegio');
    sec.style.display = 'block';

    const roleMap = { admin: '🛡 Administrador', docente: '📚 Docente', alumno: '🎒 Alumno',
        padre: '👨‍👩‍👧 Padre/Madre' };
    const badge = document.getElementById('schoolRoleBadge');
    badge.textContent = roleMap[currentUser.role] || currentUser.role;
    badge.className = 'sh-role-badge ' + currentUser.role;

    const tabs = document.getElementById('schoolTabsBar');
    if (currentUser.role === 'alumno') {
        tabs.querySelectorAll('.school-tab').forEach(t => {
            if (!['dashboard', 'evacuacion'].includes(t.textContent.trim().toLowerCase().replace(/[^a-z]/g, '')))
                t.style.display = 'none';
        });
    } else if (currentUser.role === 'padre') {
        tabs.querySelectorAll('.school-tab').forEach(t => {
            if (!['dashboard', 'evacuación'].includes(t.textContent.trim().toLowerCase())) t.style.display =
                'none';
        });
    }

    sec.scrollIntoView({ behavior: 'smooth', block: 'start' });
    showSchoolTab('dashboard', tabs.querySelector('.school-tab.on') || tabs.querySelector('.school-tab'));
}

function showSchoolTab(tab, btn) {
    document.querySelectorAll('.school-tab').forEach(t => t.classList.remove('on'));
    if (btn) btn.classList.add('on');

    const content = document.getElementById('schoolContent');
    const templates = {
        dashboard: renderDashboard,
        alumnos: renderAlumnos,
        docentes: renderDocentes,
        evacuacion: renderEvacuacion,
        paselista: renderPaseLista,
        incidentes: renderIncidentes,
        simulacros: renderSimulacros
    };

    if (templates[tab]) content.innerHTML = templates[tab]();
    if (tab === 'evacuacion') initSchoolEvacMap();
}

function renderDashboard() {
    return `<div class="admin-stats">
        <div class="ast"><div class="ast-ico">🎒</div><div class="ast-val">${schoolData.alumnos.length}</div><div class="ast-lbl">Alumnos</div></div>
        <div class="ast"><div class="ast-ico">📚</div><div class="ast-val">${schoolData.docentes.length}</div><div class="ast-lbl">Docentes</div></div>
        <div class="ast"><div class="ast-ico">🗺</div><div class="ast-val">${schoolData.rutas.length}</div><div class="ast-lbl">Rutas Evacuación</div></div>
        <div class="ast"><div class="ast-ico">🔔</div><div class="ast-val">${schoolData.simulacros.length}</div><div class="ast-lbl">Simulacros</div></div>
    </div>
    <div class="school-table-wrap" style="margin-bottom:16px">
        <div class="school-table-hdr"><h4>📋 Estado de Rutas de Evacuación</h4></div>
        <table class="school-table"><thead><tr><th>Ruta</th><th>Nombre</th><th>Descripción</th><th>Estado</th></tr></thead><tbody>
        ${schoolData.rutas.map(r => `<tr><td><strong>${r.id}</strong></td><td>${r.nombre}</td><td>${r.descripcion}</td><td><span class="st-badge ${r.estado === 'despejada' ? 'ok' : 'warn'}">${r.estado}</span></td></tr>`).join('')}
        </tbody></table>
    </div>
    <div class="school-table-wrap">
        <div class="school-table-hdr"><h4>🔔 Últimos Simulacros</h4></div>
        <table class="school-table"><thead><tr><th>Fecha</th><th>Tipo</th><th>Tiempo</th><th>Observaciones</th></tr></thead><tbody>
        ${schoolData.simulacros.map(s => `<tr><td>${s.fecha}</td><td>${s.tipo}</td><td style="color:var(--teal);font-weight:700">${s.duracion}</td><td style="color:var(--text3);font-size:.78rem">${s.nota}</td></tr>`).join('')}
        </tbody></table>
    </div>`;
}

function renderAlumnos() {
    return `<div class="school-table-wrap">
        <div class="school-table-hdr">
            <h4>🎒 Lista de Alumnos (${schoolData.alumnos.length})</h4>
            <button class="btn-acc" style="font-size:.74rem;padding:6px 14px" onclick="addAlumnoPrompt()">+ Agregar</button>
        </div>
        <table class="school-table"><thead><tr><th>#</th><th>Nombre</th><th>Grado/Sección</th><th>Docente Tutor</th><th>Estado</th></tr></thead><tbody>
        ${schoolData.alumnos.map(a => `<tr><td style="color:var(--text3)">${a.id}</td><td><strong>${a.name}</strong></td><td>${a.grado}</td><td>${a.tutor}</td><td><span class="st-badge ok">${a.estado}</span></td></tr>`).join('')}
        </tbody></table>
    </div>`;
}

function renderDocentes() {
    return `<div class="school-table-wrap">
        <div class="school-table-hdr">
            <h4>📚 Docentes (${schoolData.docentes.length})</h4>
            <button class="btn-acc" style="font-size:.74rem;padding:6px 14px" onclick="addDocentePrompt()">+ Agregar</button>
        </div>
        <table class="school-table"><thead><tr><th>Nombre</th><th>Materia</th><th>Aula</th><th>Ruta Evacuación</th><th>Teléfono</th></tr></thead><tbody>
        ${schoolData.docentes.map(d => `<tr><td><strong>${d.name}</strong></td><td>${d.materia}</td><td>${d.aula}</td><td><span class="st-badge ok">${d.ruta}</span></td><td style="font-family:monospace">${d.tel}</td></tr>`).join('')}
        </tbody></table>
    </div>`;
}

function renderEvacuacion() {
    return `<div class="school-map-wrap">
        <div class="phdr"><span class="ldot"></span>Plano del Colegio — Rutas de Evacuación</div>
        <div id="schoolEvacMap"></div>
        <div class="evac-legend">
            <div class="evl-item"><div class="evl-dot" style="background:#00d4b0"></div>Ruta despejada</div>
            <div class="evl-item"><div class="evl-dot" style="background:#ff9900"></div>Ruta bloqueada</div>
            <div class="evl-item"><div class="evl-dot" style="background:#22c55e"></div>Punto de reunión</div>
            <div class="evl-item"><div class="evl-dot" style="background:#e63946"></div>Zona peligro</div>
        </div>
    </div>
    <div class="g3" style="gap:14px">
    ${schoolData.rutas.map(r => `<div class="card" style="padding:14px">
        <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px">
            <div style="width:10px;height:10px;border-radius:50%;background:${r.color}"></div>
            <strong style="font-size:.88rem">${r.id} — ${r.nombre}</strong>
            <span class="st-badge ${r.estado === 'despejada' ? 'ok' : 'warn'}" style="margin-left:auto">${r.estado}</span>
        </div>
        <p style="font-size:.78rem;color:var(--text2)">${r.descripcion}</p>
    </div>`).join('')}
    </div>`;
}

function renderPaseLista() {
    return `<div class="pase-lista-wrap">
        <div class="school-table-hdr">
            <h4>✅ Pase de Lista — Emergencia</h4>
            <div style="display:flex;gap:8px;align-items:center">
                <span style="font-size:.76rem;color:var(--teal)" id="paseSummary">Toca cada alumno para marcar estado</span>
                <button class="btn-acc" style="font-size:.73rem;padding:5px 12px" onclick="exportPaseLista()">⬇ Exportar</button>
            </div>
        </div>
        <div style="display:flex;gap:8px;padding:10px 14px;border-bottom:1px solid var(--border);flex-wrap:wrap">
            <span style="font-size:.74rem;color:var(--text3)">Toca para cambiar estado:</span>
            <span style="font-size:.72rem;padding:3px 9px;border-radius:100px;background:rgba(0,212,176,.1);color:var(--teal);border:1px solid rgba(0,212,176,.2)">✓ Presente</span>
            <span style="font-size:.72px;padding:3px 9px;border-radius:100px;background:rgba(230,57,70,.1);color:var(--acc2);border:1px solid rgba(230,57,70,.2)">✗ Ausente</span>
            <span style="font-size:.72rem;padding:3px 9px;border-radius:100px;background:rgba(255,153,0,.1);color:var(--acc3);border:1px solid rgba(255,153,0,.2)">⚠ Herido</span>
        </div>
        <div class="pl-grid" id="paseGrid">
        ${pasList.map((a, i) => `<div class="pl-student" onclick="cyclePase(${i})" id="pal-${i}">
            <div class="pl-stu-ico">🎒</div>
            <div class="pl-stu-name">${a.name.split(' ')[0]}<br><span style="font-size:.6rem;color:var(--text3)">${a.name.split(' ')[1] || ''}</span></div>
            <div class="pl-stu-status" id="pasSt-${i}">—</div>
        </div>`).join('')}
        </div>
    </div>`;
}

function cyclePase(i) {
    const states = ['pendiente', 'presente', 'ausente', 'herido'];
    const next = { pendiente: 'presente', presente: 'ausente', ausente: 'herido', herido: 'presente' };
    pasList[i].status = next[pasList[i].status];

    const el = document.getElementById('pal-' + i);
    const st = document.getElementById('pasSt-' + i);
    el.className = 'pl-student ' + (pasList[i].status !== 'pendiente' ? pasList[i].status : '');
    const labels = { pendiente: '—', presente: '✓ Presente', ausente: '✗ Ausente', herido: '⚠ Herido' };
    st.textContent = labels[pasList[i].status];

    const p = pasList.filter(s => s.status === 'presente').length;
    const a = pasList.filter(s => s.status === 'ausente').length;
    const h = pasList.filter(s => s.status === 'herido').length;
    const sum = document.getElementById('paseSummary');
    if (sum) sum.innerHTML =
        `✓ <span style="color:var(--teal)">${p} presentes</span> · ✗ <span style="color:var(--acc2)">${a} ausentes</span> · ⚠ <span style="color:var(--acc3)">${h} heridos</span>`;
}

function exportPaseLista() {
    let txt = 'PASE DE LISTA — NDA Colegio\n' + new Date().toLocaleString('es-SV') + '\n\n';
    pasList.forEach(a => { txt += `${a.name} | ${a.grado} | ${a.status.toUpperCase()}\n`; });
    const blob = new Blob([txt], { type: 'text/plain' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'pase_lista_nda.txt';
    a.click();
}

function renderIncidentes() {
    return `<div class="incident-form">
        <h4 style="font-family:var(--fd);font-weight:700;margin-bottom:14px">⚠ Reportar Incidente</h4>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
            <div class="inc-field">
                <label>Tipo de Incidente</label>
                <select id="incTipo">
                    <option>Ruta bloqueada</option>
                    <option>Objeto caído</option>
                    <option>Alumno lesionado</option>
                    <option>Espacio dañado</option>
                    <option>Falla estructural</option>
                    <option>Otro</option>
                </select>
            </div>
            <div class="inc-field">
                <label>Ubicación</label>
                <input type="text" id="incLugar" placeholder="Ej: Pasillo norte, Pabellón B"/>
            </div>
        </div>
        <div class="inc-field">
            <label>Descripción</label>
            <textarea id="incDesc" rows="3" placeholder="Describe el incidente con detalle..."></textarea>
        </div>
        <button class="btn-acc" style="font-size:.82rem;padding:9px 20px" onclick="addIncidente()">➕ Registrar Incidente</button>
    </div>
    <div class="inc-log" id="incLog" style="margin-top:18px">
        <div style="font-size:.78rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.08em;margin-bottom:6px">📋 Incidentes Registrados</div>
        ${schoolData.incidentes.length === 0 ? '<div style="font-size:.82rem;color:var(--text3);padding:14px;text-align:center">No hay incidentes registrados.</div>' :
            schoolData.incidentes.map(inc => `<div class="inc-entry">
                <div class="inc-entry-hd"><span class="inc-entry-type">${inc.tipo}</span><span class="inc-entry-time">${inc.hora}</span></div>
                <div style="font-size:.74rem;color:var(--acc3);margin-bottom:3px">📍 ${inc.lugar}</div>
                <div class="inc-entry-desc">${inc.desc}</div>
            </div>`).join('')}
    </div>`;
}

function addIncidente() {
    const tipo = document.getElementById('incTipo').value;
    const lugar = document.getElementById('incLugar').value.trim();
    const desc = document.getElementById('incDesc').value.trim();

    if (!lugar || !desc) { alert('Completa ubicación y descripción.'); return; }

    schoolData.incidentes.unshift({ tipo, lugar, desc, hora: new Date().toLocaleTimeString('es-SV') });
    document.getElementById('incDesc').value = '';
    document.getElementById('incLugar').value = '';
    showSchoolTab('incidentes', null);
}

function renderSimulacros() {
    return `<div class="school-table-hdr" style="background:var(--card2);border-radius:var(--r) var(--r) 0 0;padding:12px 16px;margin-bottom:0">
        <h4>🔔 Historial de Simulacros</h4>
        <button class="btn-acc" style="font-size:.74rem;padding:6px 14px" onclick="addSimulacroPrompt()">+ Nuevo</button>
    </div>
    <div class="drill-history">
    ${schoolData.simulacros.map(s => `<div class="drill-item">
        <div class="drill-item-hd">
            <div class="drill-item-title">Simulacro ${s.tipo} — ${s.fecha}</div>
            <div class="drill-item-date">${s.fecha}</div>
        </div>
        <div class="drill-stats">
            <div class="drill-stat"><div class="drill-stat-val">${s.duracion}</div><div class="drill-stat-lbl">Tiempo evacuación</div></div>
            <div class="drill-stat"><div class="drill-stat-val">${s.aulas}</div><div class="drill-stat-lbl">Aulas evacuadas</div></div>
            <div class="drill-stat" style="flex:2;text-align:left"><div style="font-size:.74rem;color:var(--acc3);margin-bottom:2px">Problemas: ${s.issues}</div><div style="font-size:.74rem;color:var(--text3)">${s.nota}</div></div>
        </div>
    </div>`).join('')}
    </div>`;
}

function addAlumnoPrompt() {
    const name = prompt('Nombre completo del alumno:');
    if (!name) return;
    const grado = prompt('Grado y sección (ej: 10°A):');
    if (!grado) return;
    schoolData.alumnos.push({ id: schoolData.alumnos.length + 1, name, grado, tutor: 'Por asignar', estado: 'activo' });
    pasList = schoolData.alumnos.map(a => ({ ...a, status: 'pendiente' }));
    showSchoolTab('alumnos', null);
}

function addDocentePrompt() {
    const name = prompt('Nombre del docente (ej: Prof. Juan García):');
    if (!name) return;
    const materia = prompt('Materia que imparte:');
    if (!materia) return;
    schoolData.docentes.push({ id: schoolData.docentes.length + 1, name, materia, aula: 'Por asignar', ruta: 'R-1',
        tel: '0000-0000' });
    showSchoolTab('docentes', null);
}

function addSimulacroPrompt() {
    const tipo = prompt('Tipo de simulacro (ej: Sísmico, Incendio):');
    if (!tipo) return;
    const dur = prompt('Tiempo de evacuación (ej: 4:30):') || '—';
    const nota = prompt('Observaciones generales:') || 'Sin observaciones';
    const today = new Date().toISOString().split('T')[0];
    schoolData.simulacros.unshift({ id: schoolData.simulacros.length + 1, fecha: today, tipo, duracion: dur,
        aulas: schoolData.docentes.length, issues: 'Por registrar', nota });
    showSchoolTab('simulacros', null);
}

function initSchoolEvacMap() {
    setTimeout(() => {
        const el = document.getElementById('schoolEvacMap');
        if (!el) return;
        if (el._leaflet_id) return;

        const map = L.map('schoolEvacMap', { zoomControl: true, scrollWheelZoom: false }).setView([13.692, -89.218],
            17);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OSM' }).addTo(map);

        const schoolBounds = [
            [13.6928, -89.2188],
            [13.6928, -89.2172],
            [13.6912, -89.2172],
            [13.6912, -89.2188]
        ];
        L.polygon(schoolBounds, { color: '#2d8fff', fillColor: 'rgba(45,143,255,.07)', weight: 2 }).addTo(map)
            .bindPopup('🏫 Centro Escolar NDA');

        const mp = [
            [13.6930, -89.2180],
            [13.6910, -89.2175],
            [13.6920, -89.2165]
        ];
        mp.forEach((p, i) => L.circleMarker(p, { radius: 9, color: '#22c55e', fillColor: '#22c55e', fillOpacity: .8 })
            .addTo(map).bindPopup(`🟢 Punto de reunión ${i + 1}`));

        L.circleMarker([13.6915, -89.2185], { radius: 8, color: '#e63946', fillColor: '#e63946', fillOpacity: .6 })
            .addTo(map).bindPopup('🔴 Zona de riesgo');

        schoolData.rutas.forEach(r => {
            const clr = r.estado === 'despejada' ? '#00d4b0' : '#ff9900';
            L.polyline([
                [13.6920, -89.2185],
                [13.6928, -89.2178]
            ], { color: clr, weight: 4, dashArray: '8,4' }).addTo(map).bindPopup(`${r.id}: ${r.nombre}`);
        });
    }, 200);
}

  
//  35. ¿QUÉ HACER AHORA?
  

function toggleAhora(card) {
    const body = card.querySelector('.ahora-body');
    const isOpen = body.classList.contains('open');
    document.querySelectorAll('.ahora-body').forEach(b => b.classList.remove('open'));
    if (!isOpen) body.classList.add('open');
}

  
//  36. VIRTUAL ASSISTANT CHATBOT
  

const cbKnowledge = [
    { k: ['hola', 'hey', 'buenas', 'saludos'],
        r: '¡Hola! Soy el Asistente NDA 🤖 Estoy aquí para ayudarte con información sobre sismos, evacuación, el sistema y preparación ante desastres. ¿En qué puedo ayudarte?',
        chips: ['¿Qué hacer en un sismo?', '¿Cómo registrarme?', 'Rutas de evacuación'] },
    { k: ['sismo', 'terremoto', 'tiembla', 'movimiento', 'cuando tiembla'],
        r: '🌋 **Durante un sismo:** Caer, cubrirse y agarrarse. Protege tu cabeza debajo de un escritorio o mesa resistente. Aléjate de ventanas y objetos colgantes. No corras hacia afuera mientras tiembla. Al terminar, ve al punto de reunión designado.',
        chips: ['¿Qué es la escala Richter?', 'Puntos de reunión', '¿Qué hacer después?'] },
    { k: ['tsunami', 'ola', 'mar', 'costa', 'playa'],
        r: '🌊 **Si hay amenaza de tsunami:** Un sismo fuerte cerca de la costa ES la alerta. Muévete INMEDIATAMENTE a tierra alta (mínimo 30m sobre el nivel del mar). Si el mar retrocede anormalmente, tienes pocos minutos. No esperes alerta oficial.',
        chips: ['Zonas costeras en riesgo', 'Protocolo de evacuación'] },
    { k: ['mochila', 'kit', 'emergencia', 'preparar', 'necesito'],
        r: '🎒 **Tu mochila de emergencia debe incluir:** Agua (3L por persona por día para 3 días), alimentos no perecederos, linterna y radio a pilas, botiquín básico, documentos importantes en bolsa plástica, dinero en efectivo y lista de números de emergencia.',
        chips: ['¿Dónde guardar la mochila?', 'Números de emergencia'] },
    { k: ['evacuación', 'evacuar', 'ruta', 'salida', 'punto reunión'],
        r: '🗺 **Rutas de evacuación:** El sistema NDA incluye un módulo de colegio donde los docentes pueden ver las rutas asignadas y hacer pase de lista. Conoce la ruta de tu institución ANTES de una emergencia. Practica con simulacros.',
        chips: ['Módulo Colegio', 'Simulacros'] },
    { k: ['registrar', 'registro', 'crear cuenta', 'cómo entrar', 'login'],
        r: '👤 **Para registrarte:** Haz clic en "Registrarse" en la barra de navegación. Puedes entrar como alumno, docente, padre/madre o administrador. El módulo de colegio está disponible para docentes y administradores.',
        chips: ['¿Qué puede hacer cada rol?', 'Ir a registro'] },
    { k: ['admin', 'administrador', 'docente', 'alumno', 'padre', 'rol'],
        r: '🛡 **Roles en NDA:**\n• **Administrador:** Gestión total del módulo colegio, alumnos, docentes, incidentes y simulacros.\n• **Docente:** Pase de lista, ver rutas y reportar incidentes.\n• **Alumno:** Acceso a información y sección de evacuación.\n• **Padre/Madre:** Información general y estado del estudiante.',
        chips: ['Módulo Colegio', '¿Cómo registro a mi hijo?'] },
    { k: ['marn', 'usgs', 'datos', 'tiempo real', 'api'],
        r: '📡 **Fuentes de datos:** NDA usa datos en tiempo real del USGS (sismos globales y regionales), Open-Meteo (clima), y datos astronómicos de la API sunrise-sunset. Los datos se actualizan automáticamente al cargar la página.',
        chips: ['¿Con qué frecuencia se actualiza?', 'Monitor sísmico'] },
    { k: ['magnitud', 'richter', 'escala', 'intensidad'],
        r: '📊 **Escala de Magnitud:** La escala Richter mide la energía liberada: M1-2 (imperceptible), M3-4 (leve, puede sentirse), M5 (moderado, posibles daños), M6 (fuerte, daños estructurales), M7+ (gran terremoto). El terremoto de El Salvador de 2001 fue M7.7.',
        chips: ['Historia sísmica El Salvador', 'Simulador sísmico'] },
    { k: ['clima', 'temperatura', 'lluvia', 'tiempo', 'meteorolog'],
        r: '🌤 La sección de **Clima** muestra temperatura en tiempo real de varias ciudades de El Salvador usando la API Open-Meteo. También incluye el arco solar (salida y puesta del sol), precipitación mensual y radar meteorológico.',
        chips: ['¿Cuándo es temporada de lluvias?', 'Riesgo de inundaciones'] },
    { k: ['luna', 'fase', 'marea', 'lunar'],
        r: '🌕 La sección de **Fases Lunares** explica el ciclo lunar completo y su influencia en las mareas del Pacífico salvadoreño. Puedes explorar las 8 fases y ver cómo afectan la actividad pesquera y el riesgo costero.',
        chips: ['Mareas vivas', 'Impacto en pesca'] },
    { k: ['volcan', 'erupcion', 'izalco', 'santa ana'],
        r: '🌋 El Salvador tiene **26 volcanes**, varios activos. El más famoso es el Volcán Izalco ("El Faro del Pacífico"). Ante actividad volcánica: sigue instrucciones del MARN, cubre nariz y boca ante ceniza, y sigue las rutas de evacuación oficiales.',
        chips: ['Volcanes activos', '¿Qué hacer ante ceniza?'] },
    { k: ['arduino', 'sensor', 'maqueta', 'demo'],
        r: '🔬 La sección **Arduino/Demo** muestra cómo un sensor de vibración conectado a una maqueta puede simular alertas sísmicas. Al detectar movimiento, envía la intensidad aproximada a la página. Es solo una demostración educativa, no un sistema oficial.',
        chips: ['¿Cómo funciona el sensor?', 'Ver demo Arduino'] },
    { k: ['trivia', 'juego', 'preguntas', 'quiz'],
        r: '🎯 La **Zona de Trivia** tiene preguntas sobre desastres naturales con 3 niveles de dificultad (Básico, Intermedio, Avanzado). Los **Juegos Educativos** incluyen: Quiz de Richter, Ruta de Evacuación y Memoria Sísmica. ¡Aprende jugando!',
        chips: ['Ir a Trivia', 'Ir a Juegos'] },
    { k: ['911', 'emergencia', 'número', 'bomberos', 'cruz roja', 'coen'],
        r: '📞 **Números de emergencia El Salvador:**\n• 911 — PNC Emergencias\n• 913 — Bomberos\n• 2222-5155 — Cruz Roja\n• 2267-6000 — MARN Alertas\n• 2231-4000 — COEN (Operaciones)',
        chips: ['Más recursos', 'Mochila de emergencia'] },
    { k: ['gracias', 'perfecto', 'ok', 'bien', 'excelente'],
        r: '¡Con mucho gusto! 😊 Recuerda que la prevención y el conocimiento salvan vidas. Si tienes más dudas sobre sismos, evacuación o el sistema NDA, aquí estoy. ¡Cuídate!',
        chips: ['Volver al inicio', 'Más preguntas'] },
];

let cbInitialized = false;

function toggleChatbot() {
    const panel = document.getElementById('chatbotPanel');
    const isOpen = panel.classList.contains('open');

    if (!isOpen) {
        panel.style.display = 'flex';
        requestAnimationFrame(() => panel.classList.add('open'));
        if (!cbInitialized) {
            cbInitialized = true;
            addCbMsg('bot',
                '¡Hola! 👋 Soy el **Asistente Virtual NDA**. Puedo ayudarte con información sobre sismos, tsunamis, evacuación, el módulo de colegio y cómo usar la plataforma. ¿En qué te ayudo?',
                ['¿Qué hacer en un sismo?', 'Módulo Colegio', 'Números de emergencia', 'Mochila de emergencia']
            );
        }
    } else {
        panel.classList.remove('open');
        setTimeout(() => { panel.style.display = 'none'; }, 280);
    }
}

function addCbMsg(from, text, chips) {
    const msgs = document.getElementById('cbMessages');
    const div = document.createElement('div');
    div.className = 'cb-msg ' + from;

    const bubble = document.createElement('div');
    bubble.className = 'cb-bubble';
    bubble.innerHTML = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>').replace(/\n/g, '<br>');
    div.appendChild(bubble);

    if (chips && chips.length) {
        const chipRow = document.createElement('div');
        chipRow.className = 'cb-chips';
        chips.forEach(c => {
            const btn = document.createElement('button');
            btn.className = 'cb-chip';
            btn.textContent = c;
            btn.onclick = () => handleCbChip(c);
            chipRow.appendChild(btn);
        });
        div.appendChild(chipRow);
    }

    msgs.appendChild(div);
    msgs.scrollTop = msgs.scrollHeight;
}

function handleCbChip(text) {
    addCbMsg('user', text);
    setTimeout(() => processCbMsg(text), 400);
}

function sendChatMsg() {
    const input = document.getElementById('cbInput');
    const text = input.value.trim();
    if (!text) return;

    input.value = '';
    addCbMsg('user', text);

    const msgs = document.getElementById('cbMessages');
    const typing = document.createElement('div');
    typing.className = 'cb-msg bot';
    typing.id = 'cbTyping';
    typing.innerHTML = '<div class="cb-typing"><div class="cb-dot"></div><div class="cb-dot"></div><div class="cb-dot"></div></div>';
    msgs.appendChild(typing);
    msgs.scrollTop = msgs.scrollHeight;

    setTimeout(() => {
        const t = document.getElementById('cbTyping');
        if (t) t.remove();
        processCbMsg(text);
    }, 800 + Math.random() * 500);
}

function processCbMsg(text) {
    const lower = text.toLowerCase();

    if (lower.includes('módulo colegio') || lower.includes('modulo colegio')) {
        addCbMsg('bot',
            '🏫 Para acceder al **Módulo Colegio**, necesitas iniciar sesión. Haz clic en "Iniciar sesión" en la navegación. Los docentes y administradores tienen acceso completo a gestión de alumnos, rutas de evacuación, pase de lista e incidentes.',
            ['Iniciar sesión', '¿Cómo me registro?']);
        return;
    }

    if (lower.includes('ir a trivia')) {
        addCbMsg('bot', '🎯 ¡Voy a llevarte a la Trivia!', []);
        setTimeout(() => document.getElementById('trivia')?.scrollIntoView({ behavior: 'smooth' }), 400);
        return;
    }

    if (lower.includes('ir a juegos')) {
        addCbMsg('bot', '🎮 ¡Yendo a los juegos educativos!', []);
        setTimeout(() => document.getElementById('juegos')?.scrollIntoView({ behavior: 'smooth' }), 400);
        return;
    }

    for (const entry of cbKnowledge) {
        if (entry.k.some(kw => lower.includes(kw))) {
            addCbMsg('bot', entry.r, entry.chips || []);
            return;
        }
    }

    addCbMsg('bot', 'Hmm, no tengo información exacta sobre eso 🤔 Pero puedo ayudarte con estos temas:', [
        '¿Qué hacer en un sismo?', 'Tsunami y evacuación', 'Números de emergencia', 'Módulo Colegio',
        'Mochila de emergencia'
    ]);
}

  
//  37. INIT ALL


document.addEventListener('DOMContentLoaded', () => {
    renderTL();
    initMap();
    loadQuakes();
    loadWeather();
    loadSun();
    renderBP();
    renderPrep();
    renderBP3D();
    initRTMonitor();
    initBuildingShake();
    loadTsunamiFeed();
    initEvacCanvas();
    initMemoryGame();
});