
//  ALERTA SISMO FUERTE — global, se carga en TODAS las paginas del sitio
//  (a diferencia de centrosismico.js, que solo corre en la pagina del
//  sismografo). Consulta CentroSismico/API/obtener_sismo.php en segundo
//  plano y, si el ultimo evento llega a magnitud moderada (2.5) o mas
//  (MODERADO, FUERTE, TERREMOTO), tapa la pagina con la alerta sin importar
//  en que apartado este el usuario.

(function () {
    const overlay = document.getElementById('csiAlertOverlay');
    if (!overlay) return;

    const API_URL = 'CentroSismico/API/obtener_sismo.php';
    const MAGNITUD_ALERTA = 2.5; // moderado y para arriba (incluye FUERTE/TERREMOTO)
    const STORAGE_KEY = 'nda-csi-ultima-alerta-id';

    function setText(id, val) {
        const el = document.getElementById(id);
        if (el) el.textContent = val;
    }

    // Misma clasificacion texto -> clase de color que usa centrosismico.js
    // (leyenda .ml/.mm/.mh/.mx): asi la alerta de pantalla completa se ve
    // verde en LEVE, naranja en MODERADO, roja en FUERTE y morada en TERREMOTO.
    function nivelClass(nivel) {
        switch ((nivel || '').toUpperCase()) {
            case 'MODERADO': return 'mm';
            case 'FUERTE': return 'mh';
            case 'TERREMOTO': return 'mx';
            default: return 'ml'; // LEVE / MICRO SISMO / desconocido
        }
    }

    function getUltimaAlertaId() {
        try { return localStorage.getItem(STORAGE_KEY); } catch (e) { return null; }
    }
    function setUltimaAlertaId(id) {
        try { localStorage.setItem(STORAGE_KEY, id); } catch (e) { /* modo privado, etc. */ }
    }

    let alertaTimeout = null;

    function mostrarAlerta(sismo) {
        setText('csiAlertMag', (parseFloat(sismo.magnitud) || 0).toFixed(2));
        setText('csiAlertNivel', sismo.nivel || '');
        overlay.classList.remove('ml', 'mm', 'mh', 'mx');
        overlay.classList.add(nivelClass(sismo.nivel));
        overlay.classList.add('show');
        overlay.setAttribute('aria-hidden', 'false');
        clearTimeout(alertaTimeout);
        alertaTimeout = setTimeout(ocultarAlerta, 15000);
    }

    function ocultarAlerta() {
        clearTimeout(alertaTimeout);
        overlay.classList.remove('show');
        overlay.setAttribute('aria-hidden', 'true');
    }

    const closeBtn = document.getElementById('csiAlertClose');
    if (closeBtn) closeBtn.onclick = ocultarAlerta;

    // Persistido en localStorage: si el usuario navega a otra pagina no se
    // le vuelve a mostrar la misma alerta que ya vio.
    let ultimaAlertaId = getUltimaAlertaId();

    async function revisarSismos() {
        try {
            const r = await fetch(API_URL, { cache: 'no-store' });
            if (!r.ok) return;
            const datos = await r.json();
            if (!Array.isArray(datos) || !datos.length) return;

            const ultimo = datos[0];
            const magnitud = parseFloat(ultimo.magnitud) || 0;
            const idActual = ultimo.id != null ? String(ultimo.id) : null;

            if (magnitud >= MAGNITUD_ALERTA && idActual && idActual !== ultimaAlertaId) {
                ultimaAlertaId = idActual;
                setUltimaAlertaId(idActual);
                mostrarAlerta(ultimo);
            }
        } catch (e) {
            // Estacion sin conexion: no hay nada que alertar, se reintenta en el siguiente ciclo
        }
    }

    revisarSismos();
    setInterval(revisarSismos, 5000);
})();
