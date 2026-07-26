<?php

include("conexion.php");

$ax = $_POST["ax"];
$ay = $_POST["ay"];
$az = $_POST["az"];

$gx = $_POST["gx"];
$gy = $_POST["gy"];
$gz = $_POST["gz"];

$sql = "INSERT INTO lecturas
(ax,ay,az,gx,gy,gz)
VALUES
('$ax','$ay','$az','$gx','$gy','$gz')";

if($conn->query($sql)){
    // Buffer corto: solo interesa la señal reciente para la gráfica en vivo.
    // La limpieza no corre en cada insert (sería caro a 10/seg), solo de vez en cuando.
    if(mt_rand(1,20) == 1){
        $conn->query("DELETE FROM lecturas WHERE ts < NOW() - INTERVAL 2 MINUTE");
    }
    echo "OK";
}else{
    echo "ERROR";
}

$conn->close();

?>
