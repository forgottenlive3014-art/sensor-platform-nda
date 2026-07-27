<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Centro Sísmico de El Salvador</title>

<link rel="stylesheet" href="../../assets/css/centrosismico-web.css">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>

<header>

<h1>🌎 Centro Sísmico de El Salvador</h1>

<div class="estado">

<h2>Magnitud Actual</h2>

<div id="magnitud">0.0</div>

<p id="nivel">Sin actividad</p>

</div>

</header>

<section class="panel">

<div class="grafica">

<h2>Señal en vivo (Aceleración X/Y/Z)</h2>

<canvas id="graficaViva"></canvas>

<h2>Magnitud de eventos</h2>

<canvas id="graficaSismos"></canvas>

</div>

<div class="historial">

<h2>Últimos eventos</h2>

<table>

<thead>

<tr>

<th>Fecha</th>
<th>Hora</th>
<th>Magnitud</th>
<th>Nivel</th>

</tr>

</thead>

<tbody id="tabla">

</tbody>

</table>

</div>

</section>

<script src="../../assets/js/centrosismico-web.js"></script>

</body>

</html>