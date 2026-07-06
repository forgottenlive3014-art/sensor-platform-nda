<?php
$title = $title ?? '¿Qué hacer AHORA? - NDA';
ob_start();
?>

<div class="now-page">
    <div class="wrap" style="padding-top:80px; padding-bottom:60px;">

        <!-- ====== HERO DE URGENCIA ====== -->
        <div class="now-hero reveal">
            <div class="siren"></div>
            <span class="now-kicker">ACCIÓN INMEDIATA</span>
            <h1>¿Qué hacer <span class="grad">AHORA</span>?</h1>
            <p>Mantén la calma. Elige la situación que estás viviendo y sigue los pasos.
               Cada segundo bien usado cuenta.</p>
            <a href="tel:911" class="emergency-call">
                <span class="call-pulse"></span><span aria-hidden="true">📞</span> Llamar al 911
            </a>
        </div>

        <!-- ====== SELECTOR DE EMERGENCIA ====== -->
        <div class="now-selector reveal">
            <button class="now-tab active" data-em="sismo" style="--c:#f29f05;"><span aria-hidden="true">🌍</span>Sismo</button>
            <button class="now-tab" data-em="inundacion" style="--c:#2e7da6;"><span aria-hidden="true">🌊</span>Inundación</button>
            <button class="now-tab" data-em="incendio" style="--c:#d91a2a;"><span aria-hidden="true">🔥</span>Incendio</button>
            <button class="now-tab" data-em="deslizamiento" style="--c:#a16207;"><span aria-hidden="true">⛰️</span>Deslizamiento</button>
            <button class="now-tab" data-em="tormenta" style="--c:#6a6fb5;"><span aria-hidden="true">⛈️</span>Tormenta</button>
        </div>

        <!-- ====== CONTENEDOR DE PASOS (se llena por JS) ====== -->
        <div class="now-board reveal">
            <div class="now-board-head">
                <span class="now-icon" id="nowIcon">🌍</span>
                <h2 id="nowTitle">Sismo / Terremoto</h2>
            </div>

            <div class="phase-tabs">
                <button class="phase-tab active" data-phase="antes"><span aria-hidden="true">✅</span> Antes</button>
                <button class="phase-tab" data-phase="durante"><span aria-hidden="true">⚡</span> Durante</button>
                <button class="phase-tab" data-phase="despues"><span aria-hidden="true">🩹</span> Después</button>
            </div>

            <div class="steps" id="nowSteps"></div>
        </div>

        <!-- ====== CONTACTOS DE EMERGENCIA ====== -->
        <div class="contacts reveal">
            <h2><span aria-hidden="true">📇</span> Contactos clave en El Salvador</h2>
            <div class="contact-grid">
                <a href="tel:911" class="contact-card" style="--c:#d91a2a;">
                    <span class="c-emoji" aria-hidden="true">📞</span>
                    <div><b>911</b><small>Emergencias (línea única)</small></div>
                </a>
                <a href="#" class="contact-card" style="--c:#f29f05;">
                    <span class="c-emoji" aria-hidden="true">🛡️</span>
                    <div><b>Protección Civil</b><small>Dirección General</small></div>
                </a>
                <a href="#" class="contact-card" style="--c:#2e8b7f;">
                    <span class="c-emoji" aria-hidden="true">🚑</span>
                    <div><b>Cruz Roja</b><small>Salvadoreña</small></div>
                </a>
                <a href="#" class="contact-card" style="--c:#2e7da6;">
                    <span class="c-emoji" aria-hidden="true">🚒</span>
                    <div><b>Bomberos</b><small>Cuerpo de Bomberos</small></div>
                </a>
            </div>
            <p class="contact-note"><span aria-hidden="true">ℹ️</span> Verifica y guarda los números locales de tu municipio antes de una emergencia.</p>
        </div>

    </div>
</div>

<style>
.now-page .grad{ background:linear-gradient(135deg,#d91a2a,#f29f05); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }

/* HERO */
.now-hero{
    position:relative; text-align:center; background:var(--card); border:1px solid var(--border);
    border-radius:26px; padding:44px 24px; overflow:hidden; margin-bottom:30px;
}
.siren{
    position:absolute; inset:0; pointer-events:none; opacity:.5;
    background:radial-gradient(circle at 50% 0%, rgba(217, 26, 42,.25), transparent 55%);
    animation:siren 3s ease-in-out infinite;
}
@keyframes siren{ 0%,100%{opacity:.25;} 50%{opacity:.6;} }
.now-kicker{ position:relative; display:inline-block; font-size:.72rem; letter-spacing:3px; font-weight:800; color:#d91a2a; background:rgba(217, 26, 42,.14); padding:6px 14px; border-radius:100px; margin-bottom:14px; }
.now-hero h1{ position:relative; font-size:clamp(2.2rem,6vw,3.6rem); font-weight:900; color:var(--text1); margin:0 0 10px; }
.now-hero p{ position:relative; color:var(--text2); max-width:560px; margin:0 auto 22px; font-size:1.05rem; }
.emergency-call{
    position:relative; display:inline-flex; align-items:center; gap:8px; background:linear-gradient(135deg,#d91a2a,#b91c1c);
    color:#fff; text-decoration:none; font-weight:800; font-size:1.1rem; padding:15px 34px; border-radius:100px;
    box-shadow:0 8px 30px rgba(217, 26, 42,.4); transition:transform .2s; overflow:hidden;
}
.emergency-call:hover{ transform:scale(1.05); }
.call-pulse{ position:absolute; inset:0; border-radius:100px; box-shadow:0 0 0 0 rgba(217, 26, 42,.6); animation:callpulse 1.8s infinite; }
@keyframes callpulse{ 0%{box-shadow:0 0 0 0 rgba(217, 26, 42,.55);} 70%{box-shadow:0 0 0 18px rgba(217, 26, 42,0);} 100%{box-shadow:0 0 0 0 rgba(217, 26, 42,0);} }

/* SELECTOR */
.now-selector{ display:flex; gap:12px; flex-wrap:wrap; justify-content:center; margin-bottom:28px; }
.now-tab{
    display:flex; flex-direction:column; align-items:center; gap:6px; min-width:96px;
    background:var(--card2); border:1.5px solid var(--border); color:var(--text1);
    padding:14px 10px; border-radius:18px; cursor:pointer; transition:all .2s; font-weight:700; font-size:.85rem;
}
.now-tab span{ font-size:1.8rem; transition:transform .3s; }
.now-tab:hover{ transform:translateY(-3px); border-color:var(--c); }
.now-tab:hover span{ transform:scale(1.15); }
.now-tab.active{ background:color-mix(in srgb, var(--c) 16%, transparent); border-color:var(--c); box-shadow:0 6px 20px color-mix(in srgb, var(--c) 25%, transparent); }

/* BOARD */
.now-board{ background:var(--card); border:1px solid var(--border); border-radius:24px; padding:30px; margin-bottom:30px; }
.now-board-head{ display:flex; align-items:center; gap:14px; margin-bottom:20px; }
.now-icon{ font-size:2.6rem; }
.now-board-head h2{ font-size:1.6rem; font-weight:900; color:var(--text1); margin:0; }
.phase-tabs{ display:flex; gap:10px; flex-wrap:wrap; margin-bottom:24px; }
.phase-tab{
    background:var(--card2); border:1px solid var(--border); color:var(--text1);
    padding:9px 20px; border-radius:100px; cursor:pointer; font-weight:600; font-size:.88rem; transition:all .2s;
}
.phase-tab:hover{ border-color:#f29f05; }
.phase-tab.active{ background:#f29f05; color:#fff; border-color:transparent; }

/* STEPS */
.steps{ display:flex; flex-direction:column; gap:0; }
.step{
    display:flex; gap:18px; padding:18px 0; border-bottom:1px dashed var(--border);
    opacity:0; transform:translateX(-20px); animation:slideIn .5s ease forwards;
}
.step:last-child{ border-bottom:none; }
.step-num{
    flex-shrink:0; width:40px; height:40px; border-radius:50%; display:flex; align-items:center; justify-content:center;
    background:linear-gradient(135deg,#f29f05,#c2441c); color:#fff; font-weight:900; font-size:1.05rem;
    box-shadow:0 4px 14px rgba(242, 159, 5,.35);
}
.step-text{ padding-top:6px; }
.step-text b{ color:var(--text1); display:block; font-size:1.02rem; margin-bottom:3px; }
.step-text span{ color:var(--text2); font-size:.9rem; line-height:1.5; }
@keyframes slideIn{ to{ opacity:1; transform:none; } }

/* CONTACTOS */
.contacts{ background:var(--card); border:1px solid var(--border); border-radius:24px; padding:30px; }
.contacts h2{ font-size:1.4rem; font-weight:900; color:var(--text1); margin:0 0 18px; }
.contact-grid{ display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:14px; }
.contact-card{
    display:flex; align-items:center; gap:14px; background:var(--card2); border:1.5px solid var(--border);
    border-radius:16px; padding:16px; text-decoration:none; transition:all .2s;
}
.contact-card:hover{ transform:translateY(-3px); border-color:var(--c); box-shadow:0 8px 22px rgba(0,0,0,.25); }
.c-emoji{ font-size:2rem; }
.contact-card b{ color:var(--text1); font-size:1.15rem; display:block; }
.contact-card small{ color:var(--text3); font-size:.78rem; }
.contact-note{ color:var(--text3); font-size:.85rem; margin:18px 0 0; }

/* reveal */
.reveal{ opacity:0; transform:translateY(28px); transition:opacity .7s ease, transform .7s ease; }
.reveal.in{ opacity:1; transform:none; }
@media (prefers-reduced-motion: reduce){
    .reveal{opacity:1!important;transform:none!important;}
    .siren,.call-pulse{animation:none;}
    .step{opacity:1;transform:none;animation:none;}
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const io = new IntersectionObserver(es => es.forEach(e => { if(e.isIntersecting){ e.target.classList.add('in'); io.unobserve(e.target);} }), {threshold:.1});
    document.querySelectorAll('.reveal').forEach(el => io.observe(el));

    const DATA = {
        sismo: { icon:'🌍', title:'Sismo / Terremoto',
            antes:[['Asegura tu casa','Fija estantes, espejos y objetos pesados que puedan caer.'],['Define un punto de reunión','Acuerda con tu familia dónde encontrarse al salir.'],['Prepara tu mochila','Agua, linterna, botiquín y documentos siempre listos.']],
            durante:[['Agáchate','Bájate al suelo antes de que el sismo te tire.'],['Cúbrete','Protege cabeza y cuello bajo una mesa firme.'],['Agárrate','Sujétate hasta que el movimiento termine. No corras ni uses ascensores.']],
            despues:[['Revisa heridas','Atiende primero a quien lo necesite. Ten calma.'],['Cuidado con réplicas','Pueden venir más temblores. Aléjate de estructuras dañadas.'],['Corta servicios si hay riesgo','Cierra gas y revisa fugas antes de encender luces.']] },
        inundacion: { icon:'🌊', title:'Inundación',
            antes:[['Conoce tu zona de riesgo','Identifica si vives cerca de quebradas o ríos.'],['Sube lo importante','Coloca documentos y aparatos en lugares altos.'],['Ten lista la ruta','Memoriza el camino hacia el punto más alto y seguro.']],
            durante:[['Sube a un lugar alto','Busca el nivel más elevado posible.'],['No cruces corrientes','30 cm de agua pueden arrastrarte. Nunca cruces a pie o en auto.'],['Mantente informado','Escucha la radio a pilas y sigue indicaciones oficiales.']],
            despues:[['No tomes agua dudosa','Hierve o purifica antes de beber.'],['Cuidado al volver','Revisa que la estructura sea segura antes de entrar.'],['Limpia y desinfecta','El agua de inundación puede traer enfermedades.']] },
        incendio: { icon:'🔥', title:'Incendio',
            antes:[['Detectores de humo','Instálalos y prueba sus pilas con frecuencia.'],['Plan de escape','Conoce dos salidas de cada habitación.'],['Extintor a la mano','Ten uno y aprende a usarlo.']],
            durante:[['Agáchate y avanza','El humo sube; el aire limpio está abajo.'],['Toca antes de abrir','Si la puerta está caliente, busca otra salida.'],['Sal y no regreses','Una vez fuera, llama al 911. Nunca vuelvas por objetos.']],
            despues:[['Recibe atención médica','Aunque te sientas bien, revisa por inhalación de humo.'],['No entres aún','Espera el visto bueno de los bomberos.'],['Documenta daños','Toma fotos para tu reporte y seguro.']] },
        deslizamiento: { icon:'⛰️', title:'Deslizamiento de tierra',
            antes:[['Observa señales','Grietas en el suelo, árboles inclinados o agua turbia.'],['Evita zonas de pendiente','No construyas ni duermas al pie de laderas inestables.'],['Plan de evacuación','Ten claro a dónde ir si el terreno cede.']],
            durante:[['Aléjate de la pendiente','Muévete lateralmente, fuera del camino del deslave.'],['Sube a terreno firme','Busca un punto alto y estable.'],['Avisa a otros','Alerta a vecinos en la trayectoria.']],
            despues:[['Mantente alejado','Puede haber más deslizamientos.'],['Reporta a las autoridades','Informa bloqueos y personas atrapadas.'],['Revisa servicios','Cuidado con cables y tuberías rotas.']] },
        tormenta: { icon:'⛈️', title:'Tormenta eléctrica',
            antes:[['Asegura objetos sueltos','El viento puede convertirlos en proyectiles.'],['Carga dispositivos','Ten linternas y baterías listas por si se va la luz.'],['Resguarda mascotas','Tenlas dentro y seguras.']],
            durante:[['Quédate adentro','Evita ventanas y aparatos conectados.'],['No uses agua','Evita ducharte o lavar durante rayos.'],['Si estás afuera','Aléjate de árboles altos y postes; agáchate.']],
            despues:[['Revisa daños','Inspecciona techo y conexiones eléctricas.'],['Evita cables caídos','Nunca los toques; repórtalos.'],['Mantente alerta','Pueden venir nuevas células de tormenta.']] },
    };

    let curEm = 'sismo', curPhase = 'antes';
    function render() {
        const d = DATA[curEm];
        document.getElementById('nowIcon').textContent = d.icon;
        document.getElementById('nowTitle').textContent = d.title;
        const steps = d[curPhase];
        const box = document.getElementById('nowSteps'); box.innerHTML = '';
        steps.forEach((s, i) => {
            const el = document.createElement('div'); el.className = 'step'; el.style.animationDelay = (i*0.1)+'s';
            el.innerHTML = `<div class="step-num">${i+1}</div><div class="step-text"><b>${s[0]}</b><span>${s[1]}</span></div>`;
            box.appendChild(el);
        });
    }
    document.querySelectorAll('.now-tab').forEach(t => {
        t.addEventListener('click', () => {
            document.querySelectorAll('.now-tab').forEach(x => x.classList.remove('active'));
            t.classList.add('active'); curEm = t.dataset.em; render();
        });
    });
    document.querySelectorAll('.phase-tab').forEach(t => {
        t.addEventListener('click', () => {
            document.querySelectorAll('.phase-tab').forEach(x => x.classList.remove('active'));
            t.classList.add('active'); curPhase = t.dataset.phase; render();
        });
    });
    render();
});
</script>

<?php
$content = ob_get_clean();
require_once 'layout.php';
?>
