<?php

include("conexion.php");

$sql = "SELECT ax,ay,az,gx,gy,gz,ts FROM lecturas ORDER BY id DESC LIMIT 100";

$resultado = $conn->query($sql);

$datos = array();

while($fila = $resultado->fetch_assoc()){
    $datos[] = $fila;
}

$datos = array_reverse($datos);

header('Content-Type: application/json');

echo json_encode($datos);

$conn->close();

?>
