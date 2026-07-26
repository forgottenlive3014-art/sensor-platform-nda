CREATE DATABASE IF NOT EXISTS proyectosismico;
USE proyectosismico;

CREATE TABLE sismos (
id INT AUTO_INCREMENT PRIMARY KEY,
fecha DATE NOT NULL,
hora TIME NOT NULL,

ax FLOAT,
ay FLOAT,
az FLOAT,

gx FLOAT,
gy FLOAT,
gz FLOAT,

magnitud FLOAT,
nivel VARCHAR(30),
creado TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Señal cruda en vivo (buffer corto, se auto-limpia en guardar_lectura.php)
CREATE TABLE IF NOT EXISTS lecturas (
id INT AUTO_INCREMENT PRIMARY KEY,
ts TIMESTAMP(3) DEFAULT CURRENT_TIMESTAMP(3),
ax FLOAT, ay FLOAT, az FLOAT,
gx FLOAT, gy FLOAT, gz FLOAT
);