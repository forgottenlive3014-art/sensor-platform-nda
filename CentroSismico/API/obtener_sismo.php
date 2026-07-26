<?php

include("conexion.php");

$sql = "SELECT * FROM sismos ORDER BY id DESC";

$resultado = $conn->query($sql);

$datos = array();

while($fila = $resultado->fetch_assoc()){
    $datos[] = $fila;
}

header('Content-Type: application/json');

echo json_encode($datos, JSON_PRETTY_PRINT);

$conn->close();

?>