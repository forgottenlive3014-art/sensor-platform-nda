# NDA — Integración de Hardware (Sensor de Vibración)

Esta carpeta contiene la maqueta demostrativa descrita en el anteproyecto:
un sensor de vibración conectado a un microcontrolador que envía datos a
la plataforma NDA para mostrar una **alerta sísmica simulada** (hora +
intensidad aproximada). **No es un sistema oficial de alerta temprana.**

Flujo de datos:

```
MPU-6050  --I2C-->  Arduino/ESP32  --Serial USB-->  Processing  --HTTP POST-->  PHP (NDA)  --> Frontend (sección "Sensor Arduino")
```

---

## 1. Materiales

- Arduino UNO/NANO (5V) o ESP32 (3.3V) — cualquiera sirve, el sketch usa I2C estándar.
- Módulo acelerómetro **MPU-6050**.
- Cable USB para programar y para mantener conectado el puente serial.
- (Opcional) LED + resistencia de 220-330Ω para indicador físico de alerta.
- (Opcional) Buzzer piezoeléctrico para alerta sonora.

## 2. Cableado

| MPU-6050 | Arduino UNO/NANO | ESP32 |
|---|---|---|
| VCC | 5V | 3.3V |
| GND | GND | GND |
| SCL | A5 | GPIO22 |
| SDA | A4 | GPIO21 |

LED de alerta (opcional): ánodo → pin 8 (con resistencia), cátodo → GND.

## 3. Arduino IDE

1. Abre `arduino/nda_sensor_vibracion/nda_sensor_vibracion.ino` en el Arduino IDE.
2. Selecciona tu placa y puerto en **Herramientas**.
3. Sube el sketch (no requiere librerías adicionales, solo `Wire.h` que ya viene incluida).
4. Abre el **Monitor Serial** a 9600 baudios y confirma que ves líneas como:
   ```
   READY,NDA Sensor de Vibracion iniciado
   DATA,0.012,-0.004,0.998,0.015
   ```
   Si mueves o golpeas suavemente el sensor, el último número (intensidad) debe subir.
5. **Cierra el Monitor Serial** antes de abrir Processing — solo un programa puede usar el puerto a la vez.

## 4. Processing

1. Instala [Processing](https://processing.org/download) (modo Java, el que trae por defecto).
2. Abre `processing/nda_bridge/nda_bridge.pde`.
3. Edita las 3 líneas de configuración al inicio del archivo:
   ```java
   String NOMBRE_PUERTO = "COM3";   // ve la lista de puertos abajo
   String API_URL       = "http://localhost/NDA/index.php?url=sensor/ingest";
   String TOKEN         = "CAMBIA_ESTE_TOKEN";
   ```
   Para ver los puertos disponibles, puedes correr temporalmente este código en Processing:
   ```java
   import processing.serial.*;
   void setup() { println(Serial.list()); }
   ```
4. El `TOKEN` debe ser **idéntico** al valor de `SENSOR_INGEST_TOKEN` que pongas en el
   archivo `.env` del proyecto PHP (ver siguiente paso). Es la forma en que el backend
   verifica que la lectura viene de tu maqueta y no de cualquiera en internet.
5. Dale **Run** (▶) en Processing. Se abrirá una ventana con el osciloscopio en vivo,
   el estado de conexión y un registro de eventos.

## 5. Backend PHP

1. En la raíz del proyecto, copia `.env.example` como `.env` (si no lo has hecho ya).
2. Define un token cualquiera (letras/números, sin espacios):
   ```
   SENSOR_INGEST_TOKEN=un-token-largo-y-dificil-de-adivinar
   ```
3. Usa ese mismo valor en `TOKEN` dentro de `nda_bridge.pde` (paso anterior).
4. Corre `sql/migration_sensor.sql` en tu base de datos (o reimporta `nda_project.sql`
   completo si es una instalación nueva) para crear la tabla `lecturas_sensor`.

## 6. Verifica en el sitio

Abre la plataforma NDA en el navegador → sección **"Sensor Arduino"** en la página de
inicio (ancla `#arduino`). Si todo está conectado:

- El indicador junto al título del sismógrafo cambia a **"Arduino conectado"** (punto verde).
- Al mover el sensor, el panel muestra la intensidad real y agrega líneas al registro
  marcadas como *"— sensor real"*.
- Si la intensidad supera el umbral de alerta (0.8G), se activa la misma interfaz de
  alerta que usa el botón "Simular Alerta", pero disparada por hardware real.

El sitio consulta `?url=sensor/latest` cada pocos segundos; no necesitas recargar la página.

## 7. Notas y solución de problemas

- **"el servidor respondio codigo 401"** → el `TOKEN` de Processing no coincide con
  `SENSOR_INGEST_TOKEN` del `.env`, o el `.env` no existe.
- **La ventana de Processing no logra abrir el puerto** → revisa que el Monitor Serial
  del Arduino IDE esté cerrado, y que `NOMBRE_PUERTO` sea exactamente el que aparece
  en `Serial.list()`.
- **`API_URL` con XAMPP/Laragon**: normalmente es algo como
  `http://localhost/sensor-platform-nda/index.php?url=sensor/ingest` — ajusta el nombre
  de carpeta según donde copiaste el proyecto.
- Este demostrador usa **ESP32 solo por WiFi opcional en el futuro**; tal como está
  configurado hoy, tanto el Arduino UNO como el ESP32 se comunican por **cable USB
  (Serial)**, no por red — así el circuito de la maqueta es igual de sencillo con
  cualquiera de las dos placas.
