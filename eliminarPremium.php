<?php

 include("conexion.php");
 include("contenidoMensaje.php");

$persona = $_GET['idU'];

$link=conectar();


$consulta="UPDATE persona SET tipoU='clasico' WHERE idPersona='$persona' ";

$resu = $link->query($consulta); 

//le envio mensaje que fue rehazado como premium
$envio=mensajeEliminoPremium($persona);


echo '<script> alert("SE HA CAMBIADO A USUARIO BASICO");</script>';

echo "<script> window.history.back();</script>";


mysqli_close($link);
?>