<?php

 include("conexion.php");
 include("contenidoMensaje.php");

$persona = $_GET['idU'];

$link=conectar();


$consulta="DELETE FROM esperaclasico WHERE idPersona='$persona' ";

$resu = $link->query($consulta); 

//le envio mensaje que fue rehazado como premium
$envio=mensajeSeRechazoClasico($persona);


echo '<script> alert("SE HA RECHAZADO LA SOLICITUD");</script>';

echo "<script> window.history.back();</script>";


mysqli_close($link);
?>