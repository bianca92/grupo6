<?php

 include("conexion.php");
 include("contenidoMensaje.php");

$persona = $_GET['idU'];

$link=conectar();

//----ELIMINAR DE LISTAS DE ESPERA---------------------

$consulta="DELETE FROM esperaclasico WHERE idPersona='$persona' ";

$resu = $link->query($consulta); 

$consulta="DELETE FROM enesperapremium WHERE idPersona='$persona' ";

$resu = $link->query($consulta); 

//----PASAR A PREMIUM----------------------------

$consulta="UPDATE persona SET tipoU='clasico' WHERE idPersona='$persona' ";

$resu = $link->query($consulta); 

//le envio mensaje que fue rehazado como premium
$envio=mensajeEliminoPremium($persona);


echo '<script> alert("SE HA CAMBIADO A USUARIO CLASICO");</script>';

echo "<script> window.history.back();</script>";


mysqli_close($link);
?>