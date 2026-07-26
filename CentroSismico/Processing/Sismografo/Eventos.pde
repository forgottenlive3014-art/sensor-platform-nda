import java.text.SimpleDateFormat;
import java.util.Date;

ArrayList<String> historial = new ArrayList<String>();

boolean alertaActiva = false;
int tiempoAlerta = 0;

float ultimaMagnitud = 0;
String ultimoNivel = "";
String ultimaHora = "";

boolean eventoRegistrado = false;

int ultimoEnvio = -100000;
final int COOLDOWN_MS = 1500; // tiempo mínimo entre guardados al servidor

void verificarEvento() {

  // Solo registrar cuando la magnitud sea >= 2.0 y ya haya pasado el cooldown
  if (magnitud >= 2.0 && !eventoRegistrado
      && millis() - ultimoEnvio >= COOLDOWN_MS) {

    eventoRegistrado=true;
    ultimoEnvio = millis();

    ultimaMagnitud = magnitud;
    ultimoNivel = nivel;

    SimpleDateFormat sdf = new SimpleDateFormat("HH:mm:ss");
    ultimaHora = sdf.format(new Date());

    guardarEnServidor();

    historial.add(0,
      ultimaHora + "   " +
      nf(ultimaMagnitud,1,2) +
      " Mw   " +
      ultimoNivel);

    // Mantener máximo 15 eventos
    if(historial.size()>15){
      historial.remove(historial.size()-1);
    }

    alertaActiva = true;
    tiempoAlerta = millis();

  }

  // Cuando baja la vibración puede volver a registrar
  if(magnitud < 1.8){

    eventoRegistrado = false;

  }

}

void dibujarEventos(){

  // Franja libre debajo de las 3 gráficas de aceleración
  int x = 20;
  int y0 = 720;
  int w = width - 360;
  int h = height - y0 - 20;

  fill(35);
  stroke(70);

  rect(x, y0, w, h);

  fill(255);

  textSize(18);

  text("Historial", x+15, y0+25);

  textSize(12);

  int lineaAlto = 18;
  int filasDisponibles = (h - 45) / lineaAlto;

  int y = y0 + 50;

  for (int i = 0; i < min(historial.size(), filasDisponibles); i++) {

    text(historial.get(i), x+15, y);

    y += lineaAlto;

  }

}

void dibujarAlerta(){

  if(!alertaActiva)
    return;

  if(millis()-tiempoAlerta>3000){

    alertaActiva=false;

    return;

  }

  fill(200,0,0,220);

  rect(width/2-220,40,440,90,15);

  fill(255);

  textAlign(CENTER);

  textSize(28);

  text("⚠️ EVENTO SÍSMICO",width/2,75);

  textSize(18);

  text("Magnitud: "+nf(ultimaMagnitud,1,2)+" Mw",
       width/2,105);

  textAlign(LEFT);

}
