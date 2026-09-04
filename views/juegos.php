<?php
$title = $title ?? 'Juegos - NDA';
ob_start();
?>

<div class="games-page">
    <div class="wrap" style="padding-top:80px; padding-bottom:60px;">

        <div class="reveal" style="text-align:center; margin-bottom:36px;">
            <span class="kicker">APRENDE JUGANDO</span>
            <h1 class="games-title">Zona de <span class="grad">Juegos NDA</span></h1>
            <p style="color:var(--text2); font-size:1.1rem; max-width:600px; margin:12px auto 0;">
                Prepararse no tiene que ser aburrido. Pon a prueba lo que sabes y conviértete en un experto en emergencias.
            </p>
        </div>

        <div class="game-tabs reveal">
            <button class="gtab active" data-game="quiz"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M9 3a3 3 0 0 0-3 3 3 3 0 0 0-2 5 3 3 0 0 0 2 5 3 3 0 0 0 3 3h1V3H9zM15 3a3 3 0 0 1 3 3 3 3 0 0 1 2 5 3 3 0 0 1-2 5 3 3 0 0 1-3 3h-1V3h1z"/></svg> Quiz</button>
            <button class="gtab" data-game="memory"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em"><rect x="4" y="3" width="12" height="17" rx="2" transform="rotate(-8 10 11)"/><rect x="9" y="4" width="12" height="17" rx="2"/></svg> Memoria</button>
            <button class="gtab" data-game="backpack"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M6 4h9l5 5v11a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"/><path d="M9 12h6M9 16h6"/></svg> Arma tu Mochila</button>
            <button class="gtab" data-game="drill"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg> Simulacro Reflejo</button>
        </div>

        <!-- Juego 1: quiz -->
        <section class="game-panel active" id="game-quiz">
            <div class="game-card reveal">
                <div id="quizStart" class="quiz-screen">
                    <div class="big-emoji"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M9 3a3 3 0 0 0-3 3 3 3 0 0 0-2 5 3 3 0 0 0 2 5 3 3 0 0 0 3 3h1V3H9zM15 3a3 3 0 0 1 3 3 3 3 0 0 1 2 5 3 3 0 0 1-2 5 3 3 0 0 1-3 3h-1V3h1z"/></svg></div>
                    <h2>¿Qué tan preparado estás?</h2>
                    <p><span id="quizTotalQ">10</span> preguntas. Descubre tu nivel de preparación ante desastres.</p>
                    <button class="play-btn" id="quizStartBtn">Comenzar quiz</button>
                </div>

                <div id="quizPlay" class="quiz-screen" style="display:none;">
                    <div class="quiz-top">
                        <span id="quizProgress">Pregunta 1 de 5</span>
                        <span id="quizScore"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><polygon points="12,2 15,9 22,9.5 16.5,14 18,21 12,17.5 6,21 7.5,14 2,9.5 9,9"/></svg> 0</span>
                    </div>
                    <div class="quiz-bar"><div class="quiz-bar-fill" id="quizBar"></div></div>
                    <h3 id="quizQuestion" class="quiz-q"></h3>
                    <div id="quizOptions" class="quiz-options"></div>
                    <div id="quizExplain" class="quiz-explain"></div>
                    <button class="play-btn quiz-next" id="quizNext" style="display:none;">Siguiente pregunta →</button>
                </div>

                <div id="quizEnd" class="quiz-screen" style="display:none;">
                    <div class="big-emoji" id="quizResultEmoji"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M5 3l2 5-5 2 14 11 2-15z"/><circle cx="18" cy="6" r="1"/></svg></div>
                    <h2 id="quizResultTitle"></h2>
                    <p id="quizResultText"></p>
                    <div class="quiz-final-score" id="quizFinalScore"></div>
                    <button class="play-btn" id="quizRetry">Jugar de nuevo</button>
                </div>
            </div>
        </section>

        <!-- Juego 2: memoria -->
        <section class="game-panel" id="game-memory">
            <div class="game-card reveal">
                <div class="game-card-head">
                    <h2><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em"><rect x="4" y="3" width="12" height="17" rx="2" transform="rotate(-8 10 11)"/><rect x="9" y="4" width="12" height="17" rx="2"/></svg> Memoria de Emergencia</h2>
                    <div class="mem-stats">
                        <span>Pares: <b id="memPairs">0</b>/8</span>
                        <span>Intentos: <b id="memTries">0</b></span>
                        <button class="mini-btn" id="memReset"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg> Reiniciar</button>
                    </div>
                </div>
                <p class="game-hint">Encuentra las parejas de objetos esenciales para una emergencia.</p>
                <div class="mem-board" id="memBoard"></div>
                <div class="mem-win" id="memWin" style="display:none;">
                    <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M8 21h8M12 17v4M7 4h10v5a5 5 0 0 1-10 0V4z"/><path d="M17 5h3a2 2 0 0 1-2 4M7 5H4a2 2 0 0 0 2 4"/></svg> ¡Completado! Lo lograste en <b id="memWinTries"></b> intentos.
                </div>
            </div>
        </section>

        <!-- Juego 3: arma tu mochila -->
        <section class="game-panel" id="game-backpack">
            <div class="game-card reveal">
                <div class="game-card-head">
                    <h2><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M6 4h9l5 5v11a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"/><path d="M9 12h6M9 16h6"/></svg> Arma tu Mochila de Emergencia</h2>
                    <span class="bp-counter"><b id="bpCount">0</b>/8 esenciales</span>
                </div>
                <p class="game-hint">Toca solo los objetos que SÍ debe llevar tu mochila de 72 horas. ¡Cuidado con los distractores!</p>
                <div class="bp-grid" id="bpGrid"></div>
                <button class="play-btn" id="bpCheck">Revisar mi mochila</button>
                <div class="bp-result" id="bpResult"></div>
            </div>
        </section>

        <!-- Juego 4: simulacro reflejo -->
        <section class="game-panel" id="game-drill">
            <div class="game-card reveal">
                <div class="game-card-head">
                    <h2><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg> Simulacro: Reflejo Sísmico</h2>
                    <span class="drill-best">Mejor tiempo: <b id="drillBest">—</b></span>
                </div>
                <p class="game-hint">Cuando aparezca la acción correcta, tócala lo más rápido que puedas. Mide tu reflejo.</p>
                <div class="drill-stage" id="drillStage">
                    <div class="drill-msg" id="drillMsg">Toca "Empezar" y prepárate…</div>
                </div>
                <div class="drill-actions">
                    <button class="drill-act" data-act="agachate"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><circle cx="12" cy="4" r="2"/><path d="M12 6v6l-4 4M12 12l4 4"/></svg> Agáchate</button>
                    <button class="drill-act" data-act="cubrete"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M12 2l8 4v6c0 5-3.5 8.5-8 10-4.5-1.5-8-5-8-10V6l8-4z"/></svg> Cúbrete</button>
                    <button class="drill-act" data-act="agarrate"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><circle cx="12" cy="13" r="6"/><path d="M9 8V5a1 1 0 0 1 2 0v2M13 8V4a1 1 0 0 1 2 0v3"/></svg> Agárrate</button>
                </div>
                <button class="play-btn" id="drillStart">Empezar simulacro</button>
            </div>
        </section>

    </div>
</div>

<style>
.games-page .kicker{
    display:inline-block; font-size:.72rem; letter-spacing:3px; font-weight:800;
    color:#2e8b7f; background:rgba(46, 139, 127,.12); padding:6px 14px; border-radius:100px; margin-bottom:14px;
}
.games-title{ font-family:var(--fd); font-size:clamp(2rem,5vw,3rem); font-weight:900; color:var(--text); margin:0; }
.games-title .grad{ background:linear-gradient(135deg,#f29f05,#c2441c); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }

/* ===== Tabs ===== */
.game-tabs{ display:flex; gap:10px; flex-wrap:wrap; justify-content:center; margin-bottom:30px; }
.gtab{
    background:var(--card2); color:var(--text); border:1px solid var(--border);
    padding:10px 22px; border-radius:50px; font-size:.9rem; cursor:pointer; transition:all .2s; font-weight:600;
}
.gtab:hover{ transform:translateY(-2px); border-color:rgba(46, 139, 127,.4); }
.gtab.active{ background:linear-gradient(135deg,#2e8b7f,#018d76); color:#fff; border-color:transparent; box-shadow:0 4px 16px rgba(46, 139, 127,.3); }

/* ===== Paneles ===== */
.game-panel{ display:none; }
.game-panel.active{ display:block; animation:fadeUp .5s ease; }
.game-card{
    background:var(--card); border:1px solid var(--border); border-radius:24px; padding:30px;
    max-width:760px; margin:0 auto; position:relative; overflow:hidden;
}
.game-card-head{ display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:6px; }
.game-card-head h2{ font-family:var(--fd); font-size:1.4rem; font-weight:900; color:var(--text); margin:0; }
.game-hint{ color:var(--text2); font-size:.9rem; margin:0 0 20px; }
.big-emoji{ font-size:4.5rem; margin-bottom:8px; animation:bob 3s ease-in-out infinite; }
.play-btn{
    background:linear-gradient(135deg,#f29f05,#c2441c); color:#fff; border:none; padding:14px 34px;
    border-radius:100px; font-weight:800; font-size:1rem; cursor:pointer; transition:transform .2s, box-shadow .2s; margin-top:8px;
}
.play-btn:hover{ transform:scale(1.05); box-shadow:0 8px 26px rgba(242, 159, 5,.4); }
.mini-btn{ background:var(--card2); border:1px solid var(--border); color:var(--text); padding:6px 14px; border-radius:100px; cursor:pointer; font-size:.8rem; transition:all .2s; }
.mini-btn:hover{ border-color:#f29f05; }

/* ===== QUIZ ===== */
.quiz-screen{ text-align:center; }
.quiz-screen h2{ font-family:var(--fd); font-size:1.6rem; font-weight:900; color:var(--text); margin:6px 0; }
.quiz-screen > p{ color:var(--text2); margin:0 0 18px; }
.quiz-top{ display:flex; justify-content:space-between; font-size:.85rem; color:var(--text2); font-weight:600; margin-bottom:8px; }
.quiz-bar{ height:8px; background:var(--card2); border-radius:100px; overflow:hidden; margin-bottom:24px; }
.quiz-bar-fill{ height:100%; width:0; background:linear-gradient(90deg,#f29f05,#2e8b7f); border-radius:100px; transition:width .4s ease; }
.quiz-q{ font-size:1.25rem; font-weight:800; color:var(--text); margin:0 0 22px; line-height:1.3; text-align:left; }
.quiz-options{ display:grid; gap:12px; }
.quiz-opt{
    background:var(--card2); border:1.5px solid var(--border); color:var(--text); text-align:left;
    padding:15px 18px; border-radius:14px; cursor:pointer; font-size:.95rem; transition:all .2s;
}
.quiz-opt:hover{ border-color:#f29f05; transform:translateX(4px); }
.quiz-opt.correct{ background:rgba(46, 139, 127,.18); border-color:#2e8b7f; }
.quiz-opt.wrong{ background:rgba(217, 26, 42,.16); border-color:#d91a2a; }
.quiz-opt:disabled{ cursor:default; }
.quiz-final-score{ font-size:2.4rem; font-weight:900; background:linear-gradient(135deg,#f29f05,#2e8b7f); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; margin:10px 0 18px; }
.quiz-explain{ display:none; text-align:left; background:var(--card2); border:1px solid var(--border); border-radius:14px; padding:16px 18px; margin:16px 0 0; animation:fadeUp .35s ease; }
.quiz-explain-verdict{ display:flex; align-items:center; gap:8px; font-weight:800; margin:0 0 8px; font-size:.98rem; }
.quiz-explain-verdict svg{ flex-shrink:0; }
.quiz-explain-verdict.correct{ color:#2e8b7f; }
.quiz-explain-verdict.wrong{ color:#d91a2a; }
.quiz-explain-text{ color:var(--text2); font-size:.88rem; line-height:1.55; margin:0 0 12px; }
.quiz-explain-link{ display:inline-flex; align-items:center; gap:6px; color:#f29f05; font-weight:700; font-size:.86rem; text-decoration:none; }
.quiz-explain-link:hover{ text-decoration:underline; }
.quiz-next{ width:100%; }

/* ===== MEMORIA ===== */
.mem-stats{ display:flex; gap:16px; align-items:center; font-size:.85rem; color:var(--text2); }
.mem-board{ display:grid; grid-template-columns:repeat(4,1fr); gap:12px; margin-top:8px; }
.mem-cell{ aspect-ratio:1; perspective:600px; cursor:pointer; }
.mem-inner{ position:relative; width:100%; height:100%; transition:transform .5s; transform-style:preserve-3d; }
.mem-cell.flipped .mem-inner, .mem-cell.matched .mem-inner{ transform:rotateY(180deg); }
.mem-face{ position:absolute; inset:0; display:flex; align-items:center; justify-content:center; border-radius:14px; backface-visibility:hidden; font-size:2rem; }
.mem-front{ background:linear-gradient(135deg,#f29f05,#c2441c); color:#fff; font-weight:900; }
.mem-back{ background:var(--card2); border:1.5px solid var(--border); transform:rotateY(180deg); }
.mem-cell.matched .mem-back{ border-color:#2e8b7f; background:rgba(46, 139, 127,.15); animation:pop .4s ease; }
.mem-win{ text-align:center; margin-top:20px; font-size:1.1rem; font-weight:800; color:#2e8b7f; }

/* ===== MOCHILA ===== */
.bp-counter{ font-size:.9rem; color:var(--text2); }
.bp-counter b{ color:#f29f05; font-size:1.1rem; }
.bp-grid{ display:grid; grid-template-columns:repeat(auto-fill,minmax(110px,1fr)); gap:12px; margin-bottom:22px; }
.bp-item{
    background:var(--card2); border:2px solid var(--border); border-radius:16px; padding:16px 8px;
    text-align:center; cursor:pointer; transition:all .2s; user-select:none;
}
.bp-item:hover{ transform:translateY(-3px); border-color:rgba(242, 159, 5,.5); }
.bp-item.selected{ border-color:#f29f05; background:rgba(242, 159, 5,.14); transform:translateY(-3px); }
.bp-item .bp-emoji{ font-size:2.2rem; display:block; }
.bp-item .bp-label{ font-size:.75rem; color:var(--text2); margin-top:6px; display:block; }
.bp-item.reveal-good{ border-color:#2e8b7f; background:rgba(46, 139, 127,.16); }
.bp-item.reveal-bad{ border-color:#d91a2a; background:rgba(217, 26, 42,.16); }
.bp-result{ text-align:center; margin-top:18px; font-size:1.05rem; font-weight:700; min-height:24px; }

/* ===== SIMULACRO ===== */
.drill-best{ font-size:.9rem; color:var(--text2); }
.drill-stage{
    min-height:160px; border-radius:18px; background:var(--card2); border:1.5px solid var(--border);
    display:flex; align-items:center; justify-content:center; margin-bottom:18px; transition:background .2s, border-color .2s; text-align:center; padding:16px;
}
.drill-stage.go{ background:rgba(46, 139, 127,.16); border-color:#2e8b7f; }
.drill-stage.wait{ background:rgba(242, 159, 5,.1); border-color:#f29f05; }
.drill-msg{ display:flex; flex-direction:column; align-items:center; gap:10px; font-size:1.3rem; font-weight:800; color:var(--text); padding:0 16px; }
.drill-act-img{
    width:200px; height:200px; object-fit:contain; mix-blend-mode:multiply;
}
.drill-actions{ display:grid; grid-template-columns:repeat(3,1fr); gap:12px; margin-bottom:18px; }
.drill-act{
    background:var(--card2); border:1.5px solid var(--border); color:var(--text); padding:18px 8px;
    border-radius:14px; cursor:pointer; font-size:.95rem; font-weight:700; transition:all .15s;
}
.drill-act:hover{ border-color:#2e8b7f; transform:translateY(-2px); }
.drill-act:active{ transform:scale(.96); }

/* ===== Animaciones ===== */
.reveal{ opacity:0; transform:translateY(28px); transition:opacity .7s ease, transform .7s ease; }
.reveal.in{ opacity:1; transform:none; }
@keyframes fadeUp{ from{opacity:0; transform:translateY(18px);} to{opacity:1; transform:none;} }
@keyframes bob{ 0%,100%{transform:translateY(0);} 50%{transform:translateY(-10px);} }
@keyframes pop{ 0%{transform:rotateY(180deg) scale(.8);} 60%{transform:rotateY(180deg) scale(1.12);} 100%{transform:rotateY(180deg) scale(1);} }
@media (prefers-reduced-motion: reduce){ .reveal{opacity:1!important;transform:none!important;} .big-emoji{animation:none;} }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const io = new IntersectionObserver(es => es.forEach(e => { if(e.isIntersecting){ e.target.classList.add('in'); io.unobserve(e.target);} }), {threshold:.12});
    document.querySelectorAll('.reveal').forEach(el => io.observe(el));

    document.querySelectorAll('.gtab').forEach(tab => {
        tab.addEventListener('click', () => {
            document.querySelectorAll('.gtab').forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            document.querySelectorAll('.game-panel').forEach(p => p.classList.remove('active'));
            document.getElementById('game-' + tab.dataset.game).classList.add('active');
        });
    });

    // Cada pregunta esta basada en datos reales que ya existen en otras
    // partes del sitio (ver ChatController::faqKnowledge/systemPrompt,
    // quehacer.php, y las paginas propias de cada amenaza), asi el quiz no
    // inventa cifras que despues contradigan al resto de NDA.
    const QUESTIONS = [
        { q: 'Durante un sismo fuerte dentro de un edificio, lo más seguro es:',
          o: ['Correr a la salida de inmediato', 'Agacharte, cubrirte y agarrarte', 'Pararte bajo el marco de una puerta', 'Usar el ascensor'], a:1,
          explain: 'Agáchate, cúbrete bajo un mueble resistente y agárrate hasta que termine el movimiento. No corras ni uses el ascensor.',
          url: 'quehacer', urlLabel: '¿Qué hacer AHORA?' },
        { q: '¿Cuántos litros de agua por persona, por día, debe llevar tu mochila de emergencia?',
          o: ['Medio litro', '1 litro', '3 litros', 'No hace falta guardar agua'], a:2,
          explain: 'Se recomiendan 3 litros de agua por persona por día, para al menos 3 días.',
          url: 'resources', urlLabel: 'Guías y Recursos' },
        { q: 'Tu mochila de emergencia debe alcanzarte para sobrevivir al menos:',
          o: ['2 horas', '12 horas', '72 horas', 'Una semana exacta'], a:2,
          explain: 'La mochila de emergencia se arma para cubrir un mínimo de 72 horas (3 días) de autosuficiencia.',
          url: 'resources', urlLabel: 'Guías y Recursos' },
        { q: 'Ante lluvias intensas, NUNCA debes:',
          o: ['Cruzar quebradas o calles inundadas', 'Tener una radio a pilas', 'Conocer tu ruta de evacuación', 'Cargar tu celular'], a:0,
          explain: 'Con apenas 15 cm de corriente ya puedes perder el equilibrio, y una crecida puede subir en segundos.',
          url: 'inundaciones', urlLabel: 'Inundaciones' },
        { q: 'El punto de reunión familiar sirve para:',
          o: ['Decorar el plan', 'Reencontrarse si se separan en la emergencia', 'Guardar la mochila', 'Llamar a los bomberos'], a:1,
          explain: 'Acuerda con tu familia un punto de reunión cercano y otro más lejano por si el primero no es seguro.',
          url: 'quehacer', urlLabel: '¿Qué hacer AHORA?' },
        { q: '¿Cuántos volcanes hay en El Salvador?',
          o: ['8', '12', '26', '40'], a:2,
          explain: 'El Salvador tiene 26 volcanes a lo largo de su cordillera; el Izalco y el San Miguel (Chaparrastique) son de los más activos.',
          url: 'volcanes', urlLabel: 'Volcanes' },
        { q: 'Si sientes un sismo fuerte estando en la costa, ¿qué debes hacer?',
          o: ['Esperar la alerta oficial', 'Subir a tierra alta de inmediato', 'Meterte al mar a revisar', 'Llamar primero a la familia'], a:1,
          explain: 'El sismo ES la alerta: sube a terreno alto (mínimo 30 metros sobre el nivel del mar) sin esperar aviso oficial.',
          url: 'tsunamis', urlLabel: 'Tsunamis' },
        { q: '¿Cuál de estas es una señal de alerta de un deslizamiento?',
          o: ['Grietas nuevas en el suelo o paredes', 'Que llueva un poco', 'Que haga calor', 'Ver pasar un carro'], a:0,
          explain: 'Grietas nuevas, árboles o postes inclinados y sonidos de tronido en una ladera son señales de que puede ocurrir un deslizamiento.',
          url: 'deslizamientos', urlLabel: 'Deslizamientos' },
        { q: '¿Cuándo ocurrió el terremoto más devastador reciente de El Salvador?',
          o: ['13 de enero de 2001', '10 de octubre de 1986', '1917', '1854'], a:0,
          explain: 'El terremoto del 13 de enero de 2001 (M7.7) fue el más devastador del siglo, e incluyó el deslizamiento de Las Colinas.',
          url: 'sismos', urlLabel: 'Monitor Sísmico' },
        { q: '¿Cuál es el número de Bomberos en El Salvador?',
          o: ['911', '913', '2222-5155', '2231-4000'], a:1,
          explain: '911 es la PNC (Emergencias), 913 Bomberos, 2222-5155 Cruz Roja y 2231-4000 el COEN (Operaciones).',
          url: 'quehacer', urlLabel: '¿Qué hacer AHORA?' },
    ];
    document.getElementById('quizTotalQ').textContent = QUESTIONS.length;
    let qi = 0, qscore = 0;
    const elStart = document.getElementById('quizStart'), elPlay = document.getElementById('quizPlay'), elEnd = document.getElementById('quizEnd');
    const elExplain = document.getElementById('quizExplain'), elNext = document.getElementById('quizNext');

    function showQuestion() {
        const cur = QUESTIONS[qi];
        document.getElementById('quizProgress').textContent = `Pregunta ${qi+1} de ${QUESTIONS.length}`;
        document.getElementById('quizScore').innerHTML = `<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><polygon points="12,2 15,9 22,9.5 16.5,14 18,21 12,17.5 6,21 7.5,14 2,9.5 9,9"/></svg> ${qscore}`;
        document.getElementById('quizBar').style.width = `${(qi/QUESTIONS.length)*100}%`;
        document.getElementById('quizQuestion').textContent = cur.q;
        elExplain.style.display = 'none'; elExplain.innerHTML = '';
        elNext.style.display = 'none';
        const box = document.getElementById('quizOptions'); box.innerHTML = '';
        cur.o.forEach((opt, i) => {
            const b = document.createElement('button');
            b.className = 'quiz-opt'; b.textContent = opt;
            b.onclick = () => answer(i, b);
            box.appendChild(b);
        });
    }
    function answer(i, btn) {
        const cur = QUESTIONS[qi];
        document.querySelectorAll('.quiz-opt').forEach((b, idx) => {
            b.disabled = true;
            if (idx === cur.a) b.classList.add('correct');
            else if (idx === i) b.classList.add('wrong');
        });
        const isCorrect = i === cur.a;
        if (isCorrect) qscore++;
        document.getElementById('quizScore').innerHTML = `<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><polygon points="12,2 15,9 22,9.5 16.5,14 18,21 12,17.5 6,21 7.5,14 2,9.5 9,9"/></svg> ${qscore}`;

        let html = '';
        if (isCorrect) {
            html += `<p class="quiz-explain-verdict correct"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="8 12 11 15 16 9"/></svg> ¡Correcto!</p>`;
        } else {
            html += `<p class="quiz-explain-verdict wrong"><svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg> La respuesta correcta era: "${cur.o[cur.a]}"</p>`;
        }
        html += `<p class="quiz-explain-text">${cur.explain}</p>`;
        if (cur.url) {
            html += `<a class="quiz-explain-link" href="?url=${cur.url}" target="_blank" rel="noopener">Aprende más en ${cur.urlLabel} <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>`;
        }
        elExplain.innerHTML = html;
        elExplain.style.display = 'block';
        elNext.textContent = (qi + 1 < QUESTIONS.length) ? 'Siguiente pregunta →' : 'Ver resultado →';
        elNext.style.display = 'inline-block';
    }
    elNext.onclick = () => { qi++; (qi < QUESTIONS.length) ? showQuestion() : endQuiz(); };
    function endQuiz() {
        elPlay.style.display = 'none'; elEnd.style.display = 'block';
        document.getElementById('quizBar').style.width = '100%';
        document.getElementById('quizFinalScore').textContent = `${qscore} / ${QUESTIONS.length}`;
        let emo, title, text;
        if (qscore <= Math.ceil(QUESTIONS.length * 0.4)) { emo='<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M12 14l9-5-9-5-9 5 9 5z"/><path d="M3 9v6c0 1.5 4 3 9 3s9-1.5 9-3V9"/></svg>'; title='Vas comenzando'; text='Repasa nuestras guías y vuelve a intentarlo. ¡Cada dato cuenta!'; }
        else if (qscore <= Math.ceil(QUESTIONS.length * 0.8)) { emo='<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M6 4v6a3 3 0 0 0 3 3h1v7h6v-9l3-3V4h-4l-3 3-3-3z"/></svg>'; title='¡Bien preparado!'; text='Sabes lo importante. Afina los últimos detalles y serás un experto.'; }
        else { emo='<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M8 21h8M12 17v4M7 4h10v5a5 5 0 0 1-10 0V4z"/><path d="M17 5h3a2 2 0 0 1-2 4M7 5H4a2 2 0 0 0 2 4"/></svg>'; title='¡Experto en emergencias!'; text='Impecable. Comparte lo que sabes con tu familia y comunidad.'; }
        document.getElementById('quizResultEmoji').innerHTML = emo;
        document.getElementById('quizResultTitle').textContent = title;
        document.getElementById('quizResultText').textContent = text;
    }
    document.getElementById('quizStartBtn').onclick = () => { qi=0; qscore=0; elStart.style.display='none'; elPlay.style.display='block'; showQuestion(); };
    document.getElementById('quizRetry').onclick = () => { qi=0; qscore=0; elEnd.style.display='none'; elPlay.style.display='block'; showQuestion(); };

    const MEM_ICONS = ['<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M12 2s6 7 6 12a6 6 0 0 1-12 0c0-5 6-12 6-12z"/></svg>','<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M9 2h6l1 4-2 2v12a2 2 0 0 1-2 2h-0a2 2 0 0 1-2-2V8L8 6l1-4z"/></svg>','<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><rect x="4" y="9" width="16" height="6" rx="2" transform="rotate(-15 12 12)"/><line x1="10" y1="9" x2="10" y2="15"/><line x1="14" y1="9" x2="14" y2="15"/></svg>','<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><rect x="3" y="9" width="18" height="12" rx="2"/><circle cx="8" cy="15" r="2"/><path d="M13 13h5M13 17h3"/><path d="M7 9l3-5h6l2 5"/></svg>','<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><rect x="2" y="7" width="18" height="10" rx="2"/><line x1="22" y1="11" x2="22" y2="13"/></svg>','<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><rect x="8" y="7" width="8" height="14" rx="2"/><path d="M10 7V4h4v3M12 2v2"/></svg>','<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><rect x="5" y="6" width="14" height="14" rx="1"/><line x1="5" y1="10" x2="19" y2="10"/></svg>','<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><rect x="6" y="2" width="12" height="20" rx="2"/><line x1="11" y1="18" x2="13" y2="18"/></svg>'];
    let memDeck = [], memFlipped = [], memTries = 0, memPairs = 0, memLock = false;
    function buildMemory() {
        memDeck = [...MEM_ICONS, ...MEM_ICONS].sort(() => Math.random()-0.5);
        memTries = 0; memPairs = 0; memFlipped = []; memLock = false;
        document.getElementById('memTries').textContent = 0;
        document.getElementById('memPairs').textContent = 0;
        document.getElementById('memWin').style.display = 'none';
        const board = document.getElementById('memBoard'); board.innerHTML = '';
        memDeck.forEach((icon, idx) => {
            const cell = document.createElement('div'); cell.className = 'mem-cell'; cell.dataset.icon = icon; cell.dataset.idx = idx;
            cell.innerHTML = `<div class="mem-inner"><div class="mem-face mem-front">?</div><div class="mem-face mem-back">${icon}</div></div>`;
            cell.onclick = () => flipMem(cell);
            board.appendChild(cell);
        });
    }
    function flipMem(cell) {
        if (memLock || cell.classList.contains('flipped') || cell.classList.contains('matched')) return;
        cell.classList.add('flipped'); memFlipped.push(cell);
        if (memFlipped.length === 2) {
            memLock = true; memTries++;
            document.getElementById('memTries').textContent = memTries;
            const [a,b] = memFlipped;
            if (a.dataset.icon === b.dataset.icon) {
                setTimeout(() => { a.classList.add('matched'); b.classList.add('matched'); memFlipped=[]; memLock=false;
                    memPairs++; document.getElementById('memPairs').textContent = memPairs;
                    if (memPairs === MEM_ICONS.length) { document.getElementById('memWinTries').textContent = memTries; document.getElementById('memWin').style.display='block'; }
                }, 450);
            } else {
                setTimeout(() => { a.classList.remove('flipped'); b.classList.remove('flipped'); memFlipped=[]; memLock=false; }, 800);
            }
        }
    }
    document.getElementById('memReset').onclick = buildMemory;
    buildMemory();

    const BP_ITEMS = [
        {e:'<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M12 2s6 7 6 12a6 6 0 0 1-12 0c0-5 6-12 6-12z"/></svg>', l:'Agua', good:true}, {e:'<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M9 2h6l1 4-2 2v12a2 2 0 0 1-2 2h-0a2 2 0 0 1-2-2V8L8 6l1-4z"/></svg>', l:'Linterna', good:true},
        {e:'<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><rect x="4" y="9" width="16" height="6" rx="2" transform="rotate(-15 12 12)"/><line x1="10" y1="9" x2="10" y2="15"/><line x1="14" y1="9" x2="14" y2="15"/></svg>', l:'Botiquín', good:true}, {e:'<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><rect x="3" y="9" width="18" height="12" rx="2"/><circle cx="8" cy="15" r="2"/><path d="M13 13h5M13 17h3"/><path d="M7 9l3-5h6l2 5"/></svg>', l:'Radio', good:true},
        {e:'<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><rect x="5" y="6" width="14" height="14" rx="1"/><line x1="5" y1="10" x2="19" y2="10"/></svg>', l:'Comida enlatada', good:true}, {e:'<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><rect x="2" y="7" width="18" height="10" rx="2"/><line x1="22" y1="11" x2="22" y2="13"/></svg>', l:'Pilas', good:true},
        {e:'<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>', l:'Documentos', good:true}, {e:'<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M8 2l4 3 4-3 4 4-3 3v13H7V9L4 6z"/></svg>', l:'Abrigo', good:true},
        {e:'<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><rect x="2" y="7" width="20" height="10" rx="4"/><line x1="7" y1="10" x2="7" y2="14"/><line x1="5" y1="12" x2="9" y2="12"/><circle cx="16" cy="10.5" r="1"/><circle cx="18.5" cy="13" r="1"/></svg>', l:'Consola', good:false}, {e:'<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em"><path d="M8 10h8l-4 11z"/><path d="M6 10a6 6 0 0 1 12 0z"/></svg>', l:'Helado', good:false},
        {e:'<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em"><rect x="9" y="2" width="6" height="8" rx="2"/><path d="M10 10l1 12h2l1-12z"/></svg>', l:'Maquillaje', good:false}, {e:'<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M5 3v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3M6 15v6M18 15v6"/></svg>', l:'Silla', good:false},
    ];
    let bpSelected = new Set();
    function buildBackpack() {
        const grid = document.getElementById('bpGrid'); grid.innerHTML = '';
        BP_ITEMS.map((it,i)=>({it,i})).sort(()=>Math.random()-0.5).forEach(({it,i}) => {
            const d = document.createElement('div'); d.className='bp-item'; d.dataset.i = i;
            d.innerHTML = `<span class="bp-emoji">${it.e}</span><span class="bp-label">${it.l}</span>`;
            d.onclick = () => {
                if (d.classList.contains('reveal-good')||d.classList.contains('reveal-bad')) return;
                d.classList.toggle('selected');
                bpSelected.has(i) ? bpSelected.delete(i) : bpSelected.add(i);
                document.getElementById('bpCount').textContent = [...bpSelected].filter(x=>BP_ITEMS[x].good).length;
            };
            grid.appendChild(d);
        });
    }
    document.getElementById('bpCheck').onclick = () => {
        let correct=0, mistakes=0;
        document.querySelectorAll('.bp-item').forEach(d => {
            const it = BP_ITEMS[d.dataset.i]; const sel = d.classList.contains('selected');
            if (it.good && sel) { d.classList.add('reveal-good'); correct++; }
            else if (!it.good && sel) { d.classList.add('reveal-bad'); mistakes++; }
            else if (it.good && !sel) { d.classList.add('reveal-bad'); }
        });
        const res = document.getElementById('bpResult');
        if (correct===8 && mistakes===0){ res.style.color='#2e8b7f'; res.innerHTML='<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M8 21h8M12 17v4M7 4h10v5a5 5 0 0 1-10 0V4z"/><path d="M17 5h3a2 2 0 0 1-2 4M7 5H4a2 2 0 0 0 2 4"/></svg> ¡Mochila perfecta! Llevas todo lo esencial.'; }
        else { res.style.color='#f29f05'; res.textContent=`Acertaste ${correct}/8 esenciales. ${mistakes? 'Quita lo que no sirve (en rojo).':'¡Casi! Te faltan algunos en rojo.'}`; }
    };
    buildBackpack();

    const ACTS = [
        {k:'agachate', label:'¡AGÁCHATE!', img:'assets/media/img/agachate.png'},
        {k:'cubrete', label:'¡CÚBRETE!', img:'assets/media/img/cubrete.png'},
        {k:'agarrate', label:'¡AGÁRRATE!', img:'assets/media/img/agarrate.png'}
    ];
    let drillTarget=null, drillStart=0, drillBest=null, drillTimeout=null;
    const stage = document.getElementById('drillStage'), dmsg = document.getElementById('drillMsg');
    function startDrill() {
        clearTimeout(drillTimeout); drillTarget=null;
        stage.className='drill-stage wait'; dmsg.innerHTML='Prepárate… <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><circle cx="8" cy="12" r="3"/><circle cx="16" cy="12" r="3"/></svg>';
        const wait = 900 + Math.random()*2200;
        drillTimeout = setTimeout(() => {
            drillTarget = ACTS[Math.floor(Math.random()*ACTS.length)];
            stage.className='drill-stage go';
            dmsg.innerHTML = `<img class="drill-act-img" src="${drillTarget.img}" alt="${drillTarget.label}"><span>${drillTarget.label}</span>`;
            drillStart = performance.now();
        }, wait);
    }
    document.querySelectorAll('.drill-act').forEach(btn => {
        btn.addEventListener('click', () => {
            if (!drillTarget) { stage.className='drill-stage'; dmsg.textContent='Aún no. ¡Espera la señal y vuelve a empezar!'; clearTimeout(drillTimeout); drillTarget=null; return; }
            const ms = Math.round(performance.now() - drillStart);
            const secs = (ms/1000).toFixed(2);
            if (btn.dataset.act === drillTarget.k) {
                if (drillBest===null || ms<drillBest){ drillBest=ms; document.getElementById('drillBest').textContent = (drillBest/1000).toFixed(2)+' s'; }
                stage.className='drill-stage'; dmsg.innerHTML=`<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><circle cx="12" cy="12" r="10"/><polyline points="8 12 11 15 16 9"/></svg> ¡Correcto en ${secs} s! Toca "Empezar" otra vez.`;
            } else {
                stage.className='drill-stage'; dmsg.innerHTML='<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg> Acción equivocada. La señal pedía otra cosa.';
            }
            drillTarget=null;
        });
    });
    document.getElementById('drillStart').onclick = startDrill;
});
</script>

<?php
$content = ob_get_clean();
require_once 'layout.php';
?>
