<?php

 include("conexion.php");
 include("contenidoMensaje.php");

$puja = $_GET['pugano'];
$subasta = $_GET['sub'];

$link=conectar();
$fecha_actual = date('Y-m-j');

$consulta="UPDATE subasta SET cerrada=1, fechaFinSubasta='$fecha_actual' WHERE idSubasta='$subasta' ";
$resu = $link->query($consulta); 
$envio=mensajeTermino($subasta);


echo '<script> alert("LA SUBASTA SE HA CERRADO");</script>';
echo "<script> window.location ='subastasActivasAdministrador2.php' ;</script>";


mysqli_close($link);
?>