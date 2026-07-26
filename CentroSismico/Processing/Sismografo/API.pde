


import java.net.HttpURLConnection;
import java.net.URL;
import java.io.OutputStream;
import java.io.BufferedReader;
import java.io.InputStreamReader;

String servidor = "http://localhost/ProyectoSismico/API/guardar_sismo.php";

// Envía un evento al servidor
void enviarEventoServidor() {

  try {

    URL url = new URL(servidor);

    HttpURLConnection conexion = (HttpURLConnection) url.openConnection();

    conexion.setRequestMethod("POST");
    conexion.setDoOutput(true);

    String datos =
      "ax=" + ax +
      "&ay=" + ay +
      "&az=" + az +
      "&gx=" + gx +
      "&gy=" + gy +
      "&gz=" + gz +
      "&magnitud=" + magnitud +
      "&nivel=" + nivel +
      "&hora=" + ultimaHora;

    OutputStream os = conexion.getOutputStream();
    os.write(datos.getBytes());
    os.flush();
    os.close();

    int respuesta = conexion.getResponseCode();

    println("Servidor respondió: " + respuesta);

    BufferedReader br = new BufferedReader(
      new InputStreamReader(conexion.getInputStream())
    );

    String linea;

    while ((linea = br.readLine()) != null) {

      println(linea);

    }

    br.close();

  }

  catch(Exception e){

    println("Error enviando datos:");

    println(e.getMessage());

  }

}
