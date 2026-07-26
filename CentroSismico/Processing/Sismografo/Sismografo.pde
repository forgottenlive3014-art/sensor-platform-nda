import java.net.*;
import processing.serial.*;

Serial puerto;

// Datos del sensor
float ax = 0, ay = 0, az = 0;
float gx = 0, gy = 0, gz = 0;

// Historial de datos
final int MAX = 300;
float[] histAX = new float[MAX];
float[] histAY = new float[MAX];
float[] histAZ = new float[MAX];

float magnitud = 0;
String nivel = "NORMAL";

void setup() {

  size(1400, 900);

  println("Puertos disponibles:");
  println(Serial.list());

  // Cambia el índice si es necesario
  puerto = new Serial(this, Serial.list()[0], 115200);
  puerto.bufferUntil('\n');

  textFont(createFont("Arial",16));
}

int ultimoDiagnostico = 0;

void diagnostico(){

  if(millis() - ultimoDiagnostico < 1000) return;

  ultimoDiagnostico = millis();

  println("ax="+nf(ax,1,3)+" ay="+nf(ay,1,3)+" az="+nf(az,1,3)
    +" | baseAX="+nf(baseAX,1,3)+" baseAY="+nf(baseAY,1,3)+" baseAZ="+nf(baseAZ,1,3)
    +" | magnitud="+magnitud+" nivel="+nivel
    +" | baseInicializada="+baseInicializada+" eventoRegistrado="+eventoRegistrado);

}

void draw() {

  background(20);

  calcularMagnitud();

  diagnostico();

  verificarEvento();

  enviarLecturaEnVivo();

  dibujarEncabezado();

  dibujarGraficas();

  dibujarPanel();
  
  dibujarEventos();
  
  dibujarAlerta();

}

void serialEvent(Serial p){

  String linea = trim(p.readStringUntil('\n'));

  if(linea==null) return;

  String datos[] = split(linea, ',');

  if(datos.length==6){

    float nax=float(datos[0]);
    float nay=float(datos[1]);
    float naz=float(datos[2]);

    float ngx=float(datos[3]);
    float ngy=float(datos[4]);
    float ngz=float(datos[5]);

    // Línea corrupta del serial (típico justo al conectar): se descarta entera
    // para no contaminar el estado con NaN, que ya no se puede corregir después
    if(Float.isNaN(nax) || Float.isNaN(nay) || Float.isNaN(naz) ||
       Float.isNaN(ngx) || Float.isNaN(ngy) || Float.isNaN(ngz)){
      return;
    }

    ax=nax; ay=nay; az=naz;
    gx=ngx; gy=ngy; gz=ngz;

    // Arranca la línea base en la primera lectura real, para no
    // interpretar el ajuste inicial (0 -> valor real) como una sacudida
    if(!baseInicializada){
      baseAX = ax;
      baseAY = ay;
      baseAZ = az;
      baseInicializada = true;
    }

    actualizar(histAX,ax);
    actualizar(histAY,ay);
    actualizar(histAZ,az);

  }

}

void actualizar(float[] arreglo,float valor){

  for(int i=0;i<MAX-1;i++){

    arreglo[i]=arreglo[i+1];

  }

  arreglo[MAX-1]=valor;

}

// Sigue muy lento la orientación/gravedad actual, para poder restarla
float baseAX = 0, baseAY = 0, baseAZ = 0;
boolean baseInicializada = false;
final float BASE_ALPHA = 0.01;

void calcularMagnitud(){

  if(!baseInicializada) return; // aún no llega la primera lectura del sensor

  baseAX = BASE_ALPHA*ax + (1-BASE_ALPHA)*baseAX;
  baseAY = BASE_ALPHA*ay + (1-BASE_ALPHA)*baseAY;
  baseAZ = BASE_ALPHA*az + (1-BASE_ALPHA)*baseAZ;

  // Solo cuenta el movimiento respecto a esa orientación "de reposo",
  // así girar/levantar el sensor despacio no se confunde con vibración real
  float dx = ax - baseAX;
  float dy = ay - baseAY;
  float dz = az - baseAZ;

  float energia = sqrt(dx*dx + dy*dy + dz*dz);

  magnitud = energia * 2.4;

  if(magnitud<2){

    nivel="NORMAL";

  }else if(magnitud<3){

    nivel="MICRO SISMO";

  }else if(magnitud<4){

    nivel="LEVE";

  }else if(magnitud<5){

    nivel="MODERADO";

  }else if(magnitud<6){

    nivel="FUERTE";

  }else{

    nivel="TERREMOTO";

  }

}

void dibujarEncabezado(){

  fill(35);
  noStroke();
  rect(0,0,width,90);

  fill(255);
  textSize(28);
  text("CENTRO DE MONITOREO SÍSMICO",20,40);

  textSize(18);
  text("Magnitud estimada: "+nf(magnitud,1,2),25,70);
  text("Estado: "+nivel,380,70);

}

void dibujarGrafica(float[] datos,color c,int y,String titulo){

  fill(35);
  rect(20,y,width-320,160);

  fill(255);
  textSize(16);
  text(titulo,30,y+20);

  stroke(c);
  strokeWeight(2);
  noFill();

  beginShape();

  for(int i=0;i<MAX;i++){

    float x=map(i,0,MAX-1,30,width-340);
    float yy=map(datos[i],-2,2,y+140,y+30);

    vertex(x,yy);

  }

  endShape();

}

void dibujarPanelSimple(){

  fill(35);
  rect(width-280,90,280,height-90);

  fill(255);

  textSize(22);
  text("DATOS",width-250,130);

  textSize(16);

  text("AX: "+nf(ax,1,3),width-250,180);
  text("AY: "+nf(ay,1,3),width-250,210);
  text("AZ: "+nf(az,1,3),width-250,240);

  text("GX: "+nf(gx,1,3),width-250,290);
  text("GY: "+nf(gy,1,3),width-250,320);
  text("GZ: "+nf(gz,1,3),width-250,350);

  textSize(20);

  text("Nivel",width-250,430);

  text(nivel,width-250,470);

  textSize(18);

  text("Magnitud",width-250,540);

  text(nf(magnitud,1,2),width-250,575);

}
