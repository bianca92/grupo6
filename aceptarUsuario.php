<?php

 include("conexion.php");
 include("contenidoMensaje.php");

$persona = $_GET['idU'];

$link=conectar();


$consulta="UPDATE persona SET tipoU='premium' WHERE idPersona='$persona' ";

$resu = $link->query($consulta); 

$consulta="DELETE FROM enesperapremium WHERE idPersona='$persona' ";

$resu = $link->query($consulta); 

//le envio mensaje que fue aceptado como premium
$envio=mensajeSeAceptoPremium($persona);


echo '<script> alert("SE HA ACEPTADO LA SOLICITUD");</script>';

echo "<script> window.history.back();</script>";


mysqli_close($link);
?>