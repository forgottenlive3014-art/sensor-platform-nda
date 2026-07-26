int ultimaLecturaEnviada = -100000;
final int INTERVALO_LECTURA_MS = 100; // 10 lecturas por segundo
boolean enviandoLectura = false;

// Se llama cada frame desde draw(); solo dispara un envío cada INTERVALO_LECTURA_MS
void enviarLecturaEnVivo() {

  if (millis() - ultimaLecturaEnviada < INTERVALO_LECTURA_MS) return;
  if (enviandoLectura) return;

  ultimaLecturaEnviada = millis();

  thread("_enviarLecturaEnVivo");

}

// Corre en un hilo aparte para no trabar el dibujo con la llamada HTTP
void _enviarLecturaEnVivo() {

  enviandoLectura = true;

  try {

    URL url = new URL("http://localhost/CentroSismico/API/guardar_lectura.php");

    HttpURLConnection con = (HttpURLConnection) url.openConnection();

    con.setRequestMethod("POST");
    con.setDoOutput(true);
    con.setConnectTimeout(800);
    con.setReadTimeout(800);

    String datos =
      "ax=" + ax +
      "&ay=" + ay +
      "&az=" + az +
      "&gx=" + gx +
      "&gy=" + gy +
      "&gz=" + gz;

    OutputStream os = con.getOutputStream();
    os.write(datos.getBytes("UTF-8"));
    os.flush();
    os.close();

    con.getResponseCode();
    con.disconnect();

  }
  catch(Exception e) {

    println("Error lectura en vivo:");
    println(e);

  }

  enviandoLectura = false;

}

void guardarEnServidor() {

  try {

    URL url = new URL("http://localhost/CentroSismico/API/guardar_sismo.php");

    HttpURLConnection con = (HttpURLConnection) url.openConnection();

    con.setRequestMethod("POST");
    con.setDoOutput(true);
    con.setConnectTimeout(800);
    con.setReadTimeout(800);

    String datos =
      "ax=" + ax +
      "&ay=" + ay +
      "&az=" + az +
      "&gx=" + gx +
      "&gy=" + gy +
      "&gz=" + gz +
      "&magnitud=" + magnitud +
      "&nivel=" + nivel;

    OutputStream os = con.getOutputStream();
    os.write(datos.getBytes("UTF-8"));
    os.flush();
    os.close();

    int codigo = con.getResponseCode();

    println("Servidor: " + codigo);

    con.disconnect();

  }
  catch(Exception e) {

    println("Error:");
    println(e);

  }

}
