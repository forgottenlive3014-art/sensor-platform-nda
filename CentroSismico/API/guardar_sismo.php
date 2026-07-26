<?php

include("conexion.php");

$ax = $_POST["ax"];
$ay = $_POST["ay"];
$az = $_POST["az"];

$gx = $_POST["gx"];
$gy = $_POST["gy"];
$gz = $_POST["gz"];

$magnitud = $_POST["magnitud"];
$nivel = $_POST["nivel"];

$fecha = date("Y-m-d");
$hora = date("H:i:s");

$sql = "INSERT INTO sismos
(fecha,hora,ax,ay,az,gx,gy,gz,magnitud,nivel)
VALUES
('$fecha','$hora','$ax','$ay','$az','$gx','$gy','$gz','$magnitud','$nivel')";

if($conn->query($sql)){
    echo "OK";
}else{
    echo "ERROR";
}

$conn->close();

?>