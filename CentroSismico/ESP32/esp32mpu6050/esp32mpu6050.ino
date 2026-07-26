#include <Wire.h>
#include <MPU6050.h>

MPU6050 mpu;

// Offsets
long axOffset = 0, ayOffset = 0, azOffset = 0;
long gxOffset = 0, gyOffset = 0, gzOffset = 0;

// Filtro
float axF = 0, ayF = 0, azF = 0;
float gxF = 0, gyF = 0, gzF = 0;

const float alpha = 0.20;

void calibrarSensor() {

  Serial.println("Calibrando... No muevas el sensor.");

  long ax = 0, ay = 0, az = 0;
  long gx = 0, gy = 0, gz = 0;

  for (int i = 0; i < 500; i++) {

    int16_t x, y, z;
    int16_t rx, ry, rz;

    mpu.getAcceleration(&x, &y, &z);
    mpu.getRotation(&rx, &ry, &rz);

    ax += x;
    ay += y;
    az += z - 16384;

    gx += rx;
    gy += ry;
    gz += rz;

    delay(5);
  }

  axOffset = ax / 500;
  ayOffset = ay / 500;
  azOffset = az / 500;

  gxOffset = gx / 500;
  gyOffset = gy / 500;
  gzOffset = gz / 500;

  Serial.println("Calibración terminada.");
}

void setup() {

  Serial.begin(115200);

  Wire.begin(21,22);

  mpu.initialize();

  if(!mpu.testConnection()){

    Serial.println("Error MPU6050");

    while(true);

  }

  calibrarSensor();

}

void loop() {

  int16_t ax, ay, az;
  int16_t gx, gy, gz;

  mpu.getAcceleration(&ax,&ay,&az);
  mpu.getRotation(&gx,&gy,&gz);

  float axReal = (ax - axOffset) / 16384.0;
  float ayReal = (ay - ayOffset) / 16384.0;
  float azReal = (az - azOffset) / 16384.0;

  float gxReal = (gx - gxOffset) / 131.0;
  float gyReal = (gy - gyOffset) / 131.0;
  float gzReal = (gz - gzOffset) / 131.0;

  axF = alpha * axReal + (1 - alpha) * axF;
  ayF = alpha * ayReal + (1 - alpha) * ayF;
  azF = alpha * azReal + (1 - alpha) * azF;

  gxF = alpha * gxReal + (1 - alpha) * gxF;
  gyF = alpha * gyReal + (1 - alpha) * gyF;
  gzF = alpha * gzReal + (1 - alpha) * gzF;

  Serial.print(axF,3);
  Serial.print(",");

  Serial.print(ayF,3);
  Serial.print(",");

  Serial.print(azF,3);
  Serial.print(",");

  Serial.print(gxF,3);
  Serial.print(",");

  Serial.print(gyF,3);
  Serial.print(",");

  Serial.println(gzF,3);

  delay(20);
}
