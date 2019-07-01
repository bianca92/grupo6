<?php

 include("conexion.php");
 include("contenidoMensaje.php");

$persona = $_GET['idU'];

$link=conectar();


$fechaActual = date('Y-m-d-H:i');


$consulta="UPDATE persona SET tipoU='clasico' WHERE idPersona='$persona' ";

$resu = $link->query($consulta); 


$consulta="DELETE FROM esperaclasico WHERE idPersona='$persona' ";

$resu = $link->query($consulta); 

//le envio mensaje que fue aceptado como premium
$envio=mensajeSeAceptoClasico($persona);


echo '<script> alert("SE HA ACEPTADO LA SOLICITUD");</script>';

echo "<script> window.history.back();</script>";


mysqli_close($link);
?>