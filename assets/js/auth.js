// Animacion de onda sismica
function createWave(canvasId, side) {
    var canvas = document.getElementById(canvasId);
    if (!canvas) return;
    var ctx = canvas.getContext('2d');
    var W = 420,
        H = window.innerHeight;
    canvas.width = W;
    canvas.height = H;

    function buildPoints(t) {
        var pts = [];
        var seg = 28;
        var totalW = W;
        for (var i = 0; i <= seg; i++) {
            var x = (i / seg) * totalW;
            var phase = (i / seg + t * 0.4) % 1;
            var y;
            var spike = Math.sin(phase * Math.PI * 2);
            var noise = Math.sin(phase * Math.PI * 14) * 0.3;
            y = spike * noise;
            var spike2 = Math.sin((phase + 0.3) * Math.PI * 2);
            if (Math.abs(spike2) > 0.85) y += spike2 * 2.5;
            pts.push({ x: x, y: H * 0.55 + y * 55 });
        }
        return pts;
    }

    function draw(t) {
        ctx.clearRect(0, 0, W, H);
        var pts = buildPoints(t);

        ctx.beginPath();
        ctx.moveTo(pts[0].x, pts[0].y);
        for (var i = 1; i < pts.length; i++) {
            var mx = (pts[i - 1].x + pts[i].x) / 2;
            var my = (pts[i - 1].y + pts[i].y) / 2;
            ctx.quadraticCurveTo(pts[i - 1].x, pts[i - 1].y, mx, my);
        }
        ctx.strokeStyle = 'rgba(242,159,5,0.12)';
        ctx.lineWidth = 8;
        ctx.shadowColor = '#c98a3d';
        ctx.shadowBlur = 18;
        ctx.stroke();

        ctx.beginPath();
        ctx.moveTo(pts[0].x, pts[0].y);
        for (var j = 1; j < pts.length; j++) {
            var mx2 = (pts[j - 1].x + pts[j].x) / 2;
            var my2 = (pts[j - 1].y + pts[j].y) / 2;
            ctx.quadraticCurveTo(pts[j - 1].x, pts[j - 1].y, mx2, my2);
        }
        ctx.strokeStyle = 'rgba(242,159,5,0.55)';
        ctx.lineWidth = 2;
        ctx.shadowBlur = 8;
        ctx.stroke();
        ctx.shadowBlur = 0;
    }

    var t = side === 'right' ? 0.5 : 0;

    function loop() {
        t += 0.004;
        draw(t);
        requestAnimationFrame(loop);
    }
    loop();
}

// Animacion de anillos
(function() {
    var c = document.getElementById('rings-canvas');
    if (!c) return;
    var ctx = c.getContext('2d');
    var W = c.width,
        H = c.height;
    var cx = W / 2,
        cy = H - 8;
    var t = 0;

    function draw() {
        ctx.clearRect(0, 0, W, H);
        for (var i = 0; i < 4; i++) {
            var phase = ((t + i * 0.25) % 1);
            var rx = 40 + phase * 110;
            var ry = 8 + phase * 28;
            var alpha = (1 - phase) * 0.5;
            ctx.beginPath();
            ctx.ellipse(cx, cy, rx, ry, 0, 0, Math.PI * 2);
            ctx.strokeStyle = 'rgba(242,159,5,' + alpha + ')';
            ctx.lineWidth = 1.5;
            ctx.stroke();
        }
        t += 0.004;
        requestAnimationFrame(draw);
    }
    draw();
})();

// Particulas flotantes
(function() {
    var c = document.getElementById('particles');
    if (!c) return;
    var ctx = c.getContext('2d');
    c.width = window.innerWidth;
    c.height = window.innerHeight;

    var particles = [];
    for (var i = 0; i < 30; i++) {
        particles.push({
            x: Math.random() * c.width,
            y: Math.random() * c.height,
            r: Math.random() * 2 + 0.5,
            vx: (Math.random() - 0.5) * 0.3,
            vy: (Math.random() - 0.5) * 0.3,
            alpha: Math.random() * 0.5 + 0.1,
            color: Math.random() > 0.6 ? '#c98a3d' : '#5b8e9a',
        });
    }

    function draw() {
        ctx.clearRect(0, 0, c.width, c.height);
        particles.forEach(function(p) {
            p.x += p.vx;
            p.y += p.vy;
            if (p.x < 0) p.x = c.width;
            if (p.x > c.width) p.x = 0;
            if (p.y < 0) p.y = c.height;
            if (p.y > c.height) p.y = 0;
            ctx.beginPath();
            ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
            ctx.fillStyle = p.color;
            ctx.globalAlpha = p.alpha;
            ctx.fill();
        });
        ctx.globalAlpha = 1;
        requestAnimationFrame(draw);
    }
    draw();
})();

function togglePwd() {
    var i = document.getElementById('pwd');
    if (i) i.type = i.type === 'password' ? 'text' : 'password';
}

function togglePwdReg() {
    var i = document.getElementById('pwd-reg');
    if (i) i.type = i.type === 'password' ? 'text' : 'password';
}

function togglePwdConf() {
    var i = document.getElementById('pwd-conf');
    if (i) i.type = i.type === 'password' ? 'text' : 'password';
}

// Dialogos de burbuja
(function() {
    var loginMessages = [
        '¡Hola! Soy SismoBot.',
        'Monitoreo sismos en tiempo real.',
        'Recibe alertas importantes.',
        'Información confiable y verificada.',
        '¿En qué te ayudo hoy?'
    ];

    var registerMessages = [
        'Únete y protege tu comunidad.',
        'Crea tu cuenta y comienza ahora.',
        'Monitoreo 24/7 para tu seguridad.',
        'Datos oficiales en un solo lugar.',
        'Tu seguridad es nuestra prioridad.'
    ];

    var loginIndex = 0;
    var registerIndex = 0;

    function changeDialog(textId, messages, index) {
        var el = document.getElementById(textId);
        if (!el) return;
        el.style.opacity = '0';
        el.style.transform = 'translateY(-8px)';
        setTimeout(function() {
            el.textContent = messages[index];
            el.style.opacity = '1';
            el.style.transform = 'translateY(0)';
        }, 400);
        return (index + 1) % messages.length;
    }

    setInterval(function() {
        loginIndex = changeDialog('bubbleTextLogin', loginMessages, loginIndex);
    }, 4000);

    setInterval(function() {
        registerIndex = changeDialog('bubbleTextRegister', registerMessages, registerIndex);
    }, 4000);
})();

// La validacion del formulario de registro vive en register-wizard.js
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('wave-left')) {
        createWave('wave-left', 'left');
        createWave('wave-right', 'right');
    }
});