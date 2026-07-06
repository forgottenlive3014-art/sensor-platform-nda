/* ================================================================
   NDA — Puente Processing (Arduino Serial -> HTTP -> PHP)
   ------------------------------------------------------------
   Lee las lineas "DATA,gx,gy,gz,intensidad" que envia el Arduino
   por Serial y las reenvia como POST JSON al endpoint PHP de NDA
   (?url=sensor/ingest). Tambien muestra una ventana con la señal
   en vivo, util como "segunda pantalla" de la maqueta.

   CONFIGURA ESTAS 3 LINEAS ANTES DE EJECUTAR:
     1) NOMBRE_PUERTO  -> el puerto serial donde esta el Arduino
     2) API_URL        -> la URL de tu instalacion de NDA
     3) TOKEN           -> debe ser IGUAL al SENSOR_INGEST_TOKEN
                            que pusiste en el archivo .env del proyecto

   Este sketch no necesita librerias externas de Processing: usa
   processing.serial.* (incluida) y java.net.HttpURLConnection
   (incluida en el Java del propio Processing).
   ================================================================ */

import processing.serial.*;
import java.net.HttpURLConnection;
import java.net.URL;
import java.io.OutputStream;

// ---------------------- CONFIGURACION ----------------------
String NOMBRE_PUERTO = "COM3";                 // Windows: "COM3", "COM4"...  |  Mac/Linux: "/dev/ttyUSB0", "/dev/cu.usbmodem*"
String API_URL       = "http://localhost/NDA/index.php?url=sensor/ingest";
String TOKEN         = "CAMBIA_ESTE_TOKEN";     // igual al SENSOR_INGEST_TOKEN del .env
int    BAUD_RATE     = 9600;
// -------------------------------------------------------------

Serial puerto;
String bufferLinea = "";

// Historial para el osciloscopio en pantalla
int HIST_LEN = 200;
float[] historial = new float[HIST_LEN];

float ultimaIntensidad = 0;
String ultimoEstado = "Esperando datos del Arduino...";
ArrayList<String> logConsola = new ArrayList<String>();
boolean arduinoConectado = false;
int ultimaLecturaMillis = 0;

void setup() {
  size(760, 420);
  surface.setTitle("NDA — Puente Sensor de Vibracion");
  frameRate(30);

  try {
    puerto = new Serial(this, NOMBRE_PUERTO, BAUD_RATE);
    puerto.bufferUntil('\n');
    agregarLog("Puerto serial " + NOMBRE_PUERTO + " abierto.");
  } catch (Exception e) {
    agregarLog("ERROR: no se pudo abrir el puerto " + NOMBRE_PUERTO + ". Revisa el nombre del puerto.");
  }

  for (int i = 0; i < HIST_LEN; i++) historial[i] = 0;
}

void draw() {
  background(2, 21, 38); // mismo azul oscuro de la plataforma

  arduinoConectado = (millis() - ultimaLecturaMillis) < 2000;

  dibujarEncabezado();
  dibujarOsciloscopio();
  dibujarConsola();
}

void dibujarEncabezado() {
  fill(255);
  textSize(18);
  text("NDA — Puente Arduino / Processing", 20, 32);

  fill(arduinoConectado ? color(107, 161, 90) : color(255, 59, 63));
  ellipse(24, 55, 10, 10);
  fill(255);
  textSize(12);
  text(arduinoConectado ? "Arduino conectado" : "Sin señal del Arduino", 38, 59);

  textSize(28);
  fill(ultimaIntensidad >= 0.8 ? color(255, 59, 63) : ultimaIntensidad >= 0.3 ? color(242, 159, 5) : color(107, 161, 90));
  text(nf(ultimaIntensidad, 1, 2) + " G", 600, 45);
}

void dibujarOsciloscopio() {
  noFill();
  stroke(60, 90, 110);
  rect(20, 80, 720, 160);

  stroke(107, 161, 90);
  strokeWeight(2);
  beginShape();
  for (int i = 0; i < HIST_LEN; i++) {
    float x = map(i, 0, HIST_LEN - 1, 20, 740);
    float y = 160 - historial[i] * 90;
    vertex(x, y);
  }
  endShape();
  strokeWeight(1);
}

void dibujarConsola() {
  fill(255);
  textSize(12);
  text("Registro:", 20, 265);

  fill(15, 20, 32);
  rect(20, 272, 720, 130);

  fill(200);
  textSize(11);
  int y = 288;
  int start = max(0, logConsola.size() - 9);
  for (int i = start; i < logConsola.size(); i++) {
    text(logConsola.get(i), 28, y);
    y += 14;
  }
}

void agregarLog(String msg) {
  String hora = nf(hour(), 2) + ":" + nf(minute(), 2) + ":" + nf(second(), 2);
  logConsola.add("[" + hora + "] " + msg);
  if (logConsola.size() > 200) logConsola.remove(0);
  println(msg);
}

// Se ejecuta automaticamente cada vez que llega una linea completa del Arduino
void serialEvent(Serial p) {
  String linea = p.readStringUntil('\n');
  if (linea == null) return;
  linea = trim(linea);
  if (linea.length() == 0) return;

  if (linea.startsWith("READY")) {
    agregarLog("Arduino listo: " + linea);
    return;
  }

  if (linea.startsWith("DATA,")) {
    String[] partes = split(linea, ',');
    if (partes.length < 5) return;

    float gx = float(partes[1]);
    float gy = float(partes[2]);
    float gz = float(partes[3]);
    float intensidad = float(partes[4]);

    ultimaIntensidad = intensidad;
    ultimaLecturaMillis = millis();

    // Desplaza el historial del osciloscopio
    for (int i = 0; i < HIST_LEN - 1; i++) historial[i] = historial[i + 1];
    historial[HIST_LEN - 1] = intensidad;

    enviarAPlataforma(gx, gy, gz, intensidad);
  }
}

// Envia la lectura al backend PHP de NDA como POST JSON
void enviarAPlataforma(float gx, float gy, float gz, float intensidad) {
  thread("postAsync"); // evita bloquear la interfaz mientras se hace la peticion HTTP
}

// NOTA: por simplicidad este metodo re-lee las variables globales mas
// recientes; en un uso mas avanzado podrias encolar cada lectura.
void postAsync() {
  try {
    String json = "{"
      + "\"token\":\"" + TOKEN + "\","
      + "\"intensidad\":" + ultimaIntensidad + ","
      + "\"eje_x\":" + historial[HIST_LEN - 1] + ","
      + "\"eje_y\":0,"
      + "\"eje_z\":0,"
      + "\"fuente\":\"arduino-processing\""
      + "}";

    URL url = new URL(API_URL);
    HttpURLConnection con = (HttpURLConnection) url.openConnection();
    con.setRequestMethod("POST");
    con.setRequestProperty("Content-Type", "application/json");
    con.setDoOutput(true);
    con.setConnectTimeout(3000);

    OutputStream os = con.getOutputStream();
    os.write(json.getBytes("UTF-8"));
    os.flush();
    os.close();

    int status = con.getResponseCode();
    if (status != 200) {
      agregarLog("Aviso: el servidor respondio codigo " + status + " (revisa el TOKEN en .env)");
    }
    con.disconnect();
  } catch (Exception e) {
    agregarLog("ERROR al enviar a la plataforma: " + e.getMessage());
  }
}
