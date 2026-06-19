<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHATBOT</title>
</head>
<style>

#chatButton {
    position: fixed;
    bottom: 30px;
    right: 30px;
    z-index: 9999;
    cursor: pointer;
}

.chat-bubble {
    background: linear-gradient(135deg, #f97316, #ea580c);
    border-radius: 50%;
    width: 64px;
    height: 64px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    transition: all 0.3s ease;
    overflow: hidden;
    border: 2px solid #f97316;
}

.chat-bubble:hover {
    transform: scale(1.1);
    box-shadow: 0 0 30px rgba(249, 115, 22, 0.4);
}

.chat-bubble img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.chat-badge {
    position: absolute;
    top: -4px;
    right: -4px;
    width: 14px;
    height: 14px;
    background: #22c55e;
    border-radius: 50%;
    border: 2px solid #0f172a;
    animation: pulse 1.5s infinite;
}

/* Modal */
.chat-modal-custom {
    position: fixed;
    bottom: 100px;
    right: 30px;
    width: 420px;
    height: 580px;
    background: #0f172a;
    border-radius: 28px;
    box-shadow: 0 25px 60px rgba(0,0,0,0.6);
    z-index: 9998;
    border: 1px solid rgba(249, 115, 22, 0.15);
    display: none;
    flex-direction: column;
    overflow: hidden;
}

.chat-modal-custom.open {
    display: flex;
}

/* Header */
.chat-header-custom {
    background: linear-gradient(135deg, #ea580c, #f97316);
    padding: 14px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-shrink: 0;
}

.chat-header-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    overflow: hidden;
    border: 2px solid rgba(255,255,255,0.3);
    flex-shrink: 0;
}

.chat-header-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Mensajes */
.chat-messages-custom {
    flex: 1;
    overflow-y: auto;
    padding: 16px 18px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    background: #0f172a;
}

.chat-messages-custom::-webkit-scrollbar {
    width: 4px;
}
.chat-messages-custom::-webkit-scrollbar-track {
    background: #1e293b;
}
.chat-messages-custom::-webkit-scrollbar-thumb {
    background: #f97316;
    border-radius: 10px;
}

/* Mensaje individual */
.msg-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    overflow: hidden;
    flex-shrink: 0;
}

.msg-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.msg-bubble-bot {
    background: rgba(30, 41, 59, 0.8);
    border-radius: 12px 12px 12px 4px;
    padding: 10px 16px;
    color: #e2e8f0;
    font-size: 14px;
    max-width: 85%;
    line-height: 1.6;
}

.msg-bubble-user {
    background: #f97316;
    border-radius: 12px 12px 4px 12px;
    padding: 10px 16px;
    color: white;
    font-size: 14px;
    max-width: 85%;
    line-height: 1.6;
}

/* Input */
.chat-input-custom {
    border-top: 1px solid rgba(51, 65, 85, 0.5);
    padding: 12px 16px 14px;
    background: #1a2332;
    flex-shrink: 0;
}

.chat-input-custom input {
    flex: 1;
    background: #334155;
    border: 1px solid #475569;
    border-radius: 12px;
    padding: 10px 14px;
    color: #f1f5f9;
    font-size: 14px;
    outline: none;
    transition: border-color 0.3s;
}

.chat-input-custom input:focus {
    border-color: #f97316;
}

.chat-input-custom input::placeholder {
    color: #94a3b8;
}

.btn-send {
    background: linear-gradient(135deg, #f97316, #ea580c);
    color: white;
    border: none;
    border-radius: 12px;
    padding: 10px 18px;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 15px rgba(249, 115, 22, 0.3);
}

.btn-send:hover {
    transform: scale(1.05);
}

/* Typing */
.typing-indicator {
    display: none;
    padding: 4px 18px 8px;
}

.typing-dots {
    display: flex;
    gap: 4px;
    padding: 8px 12px;
    background: rgba(30, 41, 59, 0.8);
    border-radius: 12px;
}

.typing-dot {
    width: 8px;
    height: 8px;
    background: #fb923c;
    border-radius: 50%;
    display: inline-block;
    animation: dotPulse 1.4s infinite;
}

.typing-dot:nth-child(2) { animation-delay: 0.2s; }
.typing-dot:nth-child(3) { animation-delay: 0.4s; }

/* Animaciones */
@keyframes pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(1.2); }
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(12px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes dotPulse {
    0%, 60%, 100% { transform: translateY(0); opacity: 0.4; }
    30% { transform: translateY(-6px); opacity: 1; }
}

.fade-in {
    animation: fadeIn 0.35s ease;
}

/* Responsive */
@media (max-width: 640px) {
    .chat-modal-custom {
        width: calc(100% - 32px);
        right: 16px;
        left: 16px;
        bottom: 90px;
        height: 65vh;
        border-radius: 20px;
    }
    #chatButton {
        bottom: 20px;
        right: 20px;
    }
    .chat-bubble {
        width: 56px;
        height: 56px;
    }
}
</style>
<body>
<div id="chatButton">
    <div class="chat-bubble">
        <img src="assets/media/img/chatbot.png" alt="Chatbot NDA">
    </div>
    <div class="chat-badge"></div>
</div>

<div id="chatModal" class="chat-modal-custom">

    <!-- HEADER CON IMAGEN -->
    <div class="chat-header-custom">
        <div style="display:flex; align-items:center; gap:12px;">
            <div class="chat-header-avatar">
                <img src="assets/media/img/chatbot.png" alt="NDA">
            </div>
            <div>
                <h3 style="color:white; font-weight:bold; font-size:14px; margin:0;">Asistente NDA</h3>
                <div style="display:flex; align-items:center; gap:6px;">
                    <span style="width:8px; height:8px; background:#22c55e; border-radius:50%; display:inline-block; animation:pulse 1.5s infinite;"></span>
                    <span style="color:rgba(255,255,255,0.8); font-size:10px;">En línea · IA</span>
                </div>
            </div>
        </div>
        <button onclick="cerrarChat()" style="width:32px; height:32px; background:rgba(255,255,255,0.1); border:none; border-radius:8px; color:white; cursor:pointer; font-size:18px; display:flex; align-items:center; justify-content:center; transition:background 0.3s;">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <!-- MENSAJES CON AVATAR -->
    <div id="chatMessages" class="chat-messages-custom">
        <div class="fade-in" style="display:flex; gap:10px;">
            <div class="msg-avatar">
                <img src="assets/media/img/chatbot.png" alt="NDA">
            </div>
            <div class="msg-bubble-bot">
                <strong>🌙 ¡Hola!</strong> Soy el asistente de <strong>NDA</strong>.<br>
                📌 <strong>Especialista en sismos de El Salvador.</strong><br>
                ¿En qué te ayudo hoy?
            </div>
        </div>
    </div>

    <!-- INDICADOR DE ESCRITURA CON AVATAR -->
    <div id="typingIndicator" class="typing-indicator">
        <div style="display:flex; gap:10px; align-items:center;">
            <div class="msg-avatar">
                <img src="assets/media/img/chatbot.png" alt="NDA">
            </div>
            <div class="typing-dots">
                <span class="typing-dot"></span>
                <span class="typing-dot"></span>
                <span class="typing-dot"></span>
            </div>
        </div>
    </div>

    <!-- INPUT -->
    <div class="chat-input-custom">
        <div style="display:flex; gap:10px;">
            <input id="chatInput" type="text" placeholder="Escribe tu pregunta..." 
                   onfocus="this.style.borderColor='#f97316'"
                   onblur="this.style.borderColor='#475569'">
            <button onclick="enviarMensaje()" class="btn-send">
                <i class="fa-regular fa-paper-plane"></i>
            </button>
        </div>
        <div style="display:flex; justify-content:space-between; font-size:10px; color:#64748b; margin-top:8px; padding:0 4px;">
            <span>Enter para enviar</span>
            <span> IA · Groq</span>
        </div>
    </div>
</div>

<!-- JAVASCRIPT DEL CHATBOT                      -->
<script>
// Variables
var chatAbierto = false;
var esperando = false;

// Abrir/cerrar chat
function toggleChat() {
    var modal = document.getElementById('chatModal');
    if (!modal) return;
    
    if (chatAbierto) {
        modal.classList.remove('open');
        chatAbierto = false;
    } else {
        modal.classList.add('open');
        chatAbierto = true;
        setTimeout(function() {
            var input = document.getElementById('chatInput');
            if (input) input.focus();
        }, 300);
    }
}

// Cerrar chat
function cerrarChat() {
    var modal = document.getElementById('chatModal');
    if (modal) {
        modal.classList.remove('open');
        chatAbierto = false;
    }
}

// Enviar mensaje
function enviarMensaje() {
    if (esperando) return;
    
    var input = document.getElementById('chatInput');
    if (!input) return;
    
    var texto = input.value.trim();
    if (!texto) return;
    
    agregarMensaje('user', texto);
    input.value = '';
    esperando = true;
    input.disabled = true;
    
    var typing = document.getElementById('typingIndicator');
    if (typing) typing.style.display = 'block';
    
    fetch('?url=chat-api', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ message: texto })
    })
    .then(function(response) { return response.json(); })
    .then(function(data) {
        if (typing) typing.style.display = 'none';
        agregarMensaje('bot', data.reply || 'Lo siento, no pude procesar tu pregunta.');
    })
    .catch(function(error) {
        if (typing) typing.style.display = 'none';
        agregarMensaje('bot', ' Error de conexión. Asegúrate de que el servidor esté corriendo.');
        console.error('Error:', error);
    })
    .finally(function() {
        esperando = false;
        input.disabled = false;
        input.focus();
    });
}

// Agregar mensaje al chat
function agregarMensaje(rol, texto) {
    var container = document.getElementById('chatMessages');
    if (!container) return;
    
    var esBot = rol === 'bot';
    var div = document.createElement('div');
    div.className = 'fade-in';
    div.style.display = 'flex';
    div.style.gap = '10px';
    if (!esBot) div.style.flexDirection = 'row-reverse';
    
    var avatar = esBot ? 'assets/media/img/chatbot.png' : 'assets/media/img/user-avatar.png';
    var bubbleClass = esBot ? 'msg-bubble-bot' : 'msg-bubble-user';
    
    div.innerHTML = 
        '<div class="msg-avatar">' +
            '<img src="' + avatar + '" alt="avatar">' +
        '</div>' +
        '<div class="' + bubbleClass + '">' +
            texto.replace(/\n/g, '<br>').replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>') +
        '</div>';
    
    container.appendChild(div);
    container.scrollTop = container.scrollHeight;
}

// Eventos
document.addEventListener('DOMContentLoaded', function() {
    var btn = document.getElementById('chatButton');
    if (btn) {
        btn.onclick = toggleChat;
    }
    
    var input = document.getElementById('chatInput');
    if (input) {
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                enviarMensaje();
            }
        });
    }
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            cerrarChat();
        }
    });
    
    console.log(' Chatbot NDA listo');
});
</script>
</body>
</html>