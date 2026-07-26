void dibujarPanel() {

  int x = width - 300;

  // Fondo del panel
  fill(30);
  stroke(70);
  rect(x, 0, 300, height);

  fill(255);
  textSize(24);
  text("ESTACIÓN", x + 70, 40);

  // Estado
  textSize(18);
  text("Estado", x + 20, 90);

  color estadoColor = color(0,255,0);

  if(nivel.equals("LEVE"))
    estadoColor=color(255,255,0);

  else if(nivel.equals("MODERADO"))
    estadoColor=color(255,150,0);

  else if(nivel.equals("FUERTE"))
    estadoColor=color(255,0,0);

  else if(nivel.equals("TERREMOTO"))
    estadoColor=color(180,0,255);

  fill(estadoColor);
  ellipse(x+40,125,18,18);

  fill(255);
  text(nivel,x+60,132);

  // Magnitud
  textSize(18);
  text("Magnitud estimada",x+20,180);

  textSize(30);
  text(nf(magnitud,1,2),x+20,220);

  textSize(18);
  text("Mw*",x+140,220);

  // Datos
  textSize(16);

  text("AX: "+nf(ax,1,3),x+20,280);
  text("AY: "+nf(ay,1,3),x+20,310);
  text("AZ: "+nf(az,1,3),x+20,340);

  text("GX: "+nf(gx,1,3),x+20,390);
  text("GY: "+nf(gy,1,3),x+20,420);
  text("GZ: "+nf(gz,1,3),x+20,450);

  // Barra de intensidad

  textSize(18);

  text("Intensidad",x+20,520);

  noFill();
  stroke(180);

  rect(x+40,540,30,180);

  float h=map(constrain(magnitud,0,8),0,8,0,180);

  noStroke();

  fill(estadoColor);

  rect(x+40,720-h,30,h);

  fill(255);

  text("0",x+80,720);
  text("8",x+80,550);

}
