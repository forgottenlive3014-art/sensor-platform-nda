void dibujarGraficas() {

  dibujarGraficaIndividual(histAX, color(255, 60, 60), 120, "Aceleración X (g)");
  dibujarGraficaIndividual(histAY, color(60, 255, 60), 330, "Aceleración Y (g)");
  dibujarGraficaIndividual(histAZ, color(60, 170, 255), 540, "Aceleración Z (g)");

}

void dibujarGraficaIndividual(float datos[], int c, int y, String titulo) {

  int x = 30;
  int ancho = width - 360;
  int alto = 170;

  // Fondo
  fill(28);
  stroke(80);
  rect(x, y, ancho, alto);

  // Cuadrícula horizontal
  stroke(55);

  for (int i = 0; i <= 8; i++) {

    float yy = map(i, 0, 8, y + 20, y + alto - 20);
    line(x, yy, x + ancho, yy);

  }

  // Cuadrícula vertical
  for (int i = 0; i <= 10; i++) {

    float xx = map(i, 0, 10, x, x + ancho);
    line(xx, y, xx, y + alto);

  }

  // Título
  fill(255);
  textSize(16);
  text(titulo, x + 10, y + 18);

  // Línea central (0 g)
  stroke(140);
  line(x, y + alto / 2, x + ancho, y + alto / 2);

  // Señal
  stroke(c);
  strokeWeight(2);
  noFill();

  beginShape();

  for (int i = 0; i < datos.length; i++) {

    float xx = map(i, 0, datos.length - 1, x, x + ancho);

    float yy = map(datos[i], -2.0, 2.0, y + alto - 20, y + 20);

    vertex(xx, yy);

  }

  endShape();

  strokeWeight(1);

}
