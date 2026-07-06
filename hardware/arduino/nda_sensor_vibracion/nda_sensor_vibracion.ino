/* ================================================================
   NDA — Sensor de Vibración (MPU-6050)
   ------------------------------------------------------------
   Lee el acelerómetro MPU-6050 por I2C (sin librerías externas,
   solo Wire.h que ya viene con el Arduino IDE) y envía por Serial
   una linea de datos varias veces por segundo:

       DATA,<gx>,<gy>,<gz>,<intensidad>

   El puente de Processing (carpeta ../processing/nda_bridge) lee
   estas lineas y las reenvia a la plataforma NDA via HTTP.

   Placa recomendada: Arduino UNO / NANO (5V) o ESP32 (3.3V, ajustar
   el cableado de VCC del sensor a 3.3V en ese caso).

   Conexión MPU-6050:
     VCC -> 5V  (o 3.3V en ESP32)
     GND -> GND
     SCL -> A5  (Uno/Nano)   |  GPIO22 (ESP32)
     SDA -> A4  (Uno/Nano)   |  GPIO21 (ESP32)

   LED de alerta (opcional):
     Ánodo -> pin 8 (con resistencia de 220-330 ohm)
     Cátodo -> GND
   ================================================================ */

#include <Wire.h>

const int MPU_ADDR = 0x68;      // Direccion I2C por defecto del MPU-6050
const int LED_ALERTA_PIN = 8;   // LED opcional que se enciende en umbral de alerta

// Umbrales de intensidad (mismos valores que usa la plataforma web)
const float UMBRAL_PRECAUCION = 0.30;
const float UMBRAL_ALERTA     = 0.80;

// Suavizado de la señal: promedio movil simple para reducir ruido
const int VENTANA_SUAVIZADO = 5;
float historialIntensidad[VENTANA_SUAVIZADO];
int indiceHistorial = 0;

unsigned long ultimoEnvio = 0;
const unsigned long INTERVALO_ENVIO_MS = 200; // 5 lecturas por segundo

void setup() {
  Serial.begin(9600);
  Wire.begin();

  // Despertar el MPU-6050 (por defecto arranca en modo "sleep")
  Wire.beginTransmission(MPU_ADDR);
  Wire.write(0x6B); // registro PWR_MGMT_1
  Wire.write(0);    // 0 = despertar el sensor
  Wire.endTransmission(true);

  pinMode(LED_ALERTA_PIN, OUTPUT);
  digitalWrite(LED_ALERTA_PIN, LOW);

  for (int i = 0; i < VENTANA_SUAVIZADO; i++) historialIntensidad[i] = 0;

  Serial.println("READY,NDA Sensor de Vibracion iniciado");
}

void loop() {
  float gx, gy, gz;
  leerAcelerometro(gx, gy, gz);

  // Magnitud del vector de aceleracion menos la gravedad en reposo (~1G)
  float magnitud = sqrt(gx * gx + gy * gy + gz * gz);
  float intensidadCruda = fabs(magnitud - 1.0);

  // Promedio movil para suavizar el ruido del sensor
  historialIntensidad[indiceHistorial] = intensidadCruda;
  indiceHistorial = (indiceHistorial + 1) % VENTANA_SUAVIZADO;
  float intensidad = 0;
  for (int i = 0; i < VENTANA_SUAVIZADO; i++) intensidad += historialIntensidad[i];
  intensidad /= VENTANA_SUAVIZADO;

  digitalWrite(LED_ALERTA_PIN, intensidad >= UMBRAL_ALERTA ? HIGH : LOW);

  unsigned long ahora = millis();
  if (ahora - ultimoEnvio >= INTERVALO_ENVIO_MS) {
    ultimoEnvio = ahora;
    Serial.print("DATA,");
    Serial.print(gx, 3); Serial.print(",");
    Serial.print(gy, 3); Serial.print(",");
    Serial.print(gz, 3); Serial.print(",");
    Serial.println(intensidad, 3);
  }

  delay(20);
}

// Lee los 3 ejes del acelerometro y los convierte a unidades de "G"
void leerAcelerometro(float &gx, float &gy, float &gz) {
  Wire.beginTransmission(MPU_ADDR);
  Wire.write(0x3B); // registro de inicio: ACCEL_XOUT_H
  Wire.endTransmission(false);
  Wire.requestFrom(MPU_ADDR, 6, true);

  int16_t rawX = (Wire.read() << 8) | Wire.read();
  int16_t rawY = (Wire.read() << 8) | Wire.read();
  int16_t rawZ = (Wire.read() << 8) | Wire.read();

  // Sensibilidad por defecto del MPU-6050 en +/-2g: 16384 LSB por G
  gx = rawX / 16384.0;
  gy = rawY / 16384.0;
  gz = rawZ / 16384.0;
}
