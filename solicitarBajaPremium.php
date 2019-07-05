<?php
include("clases.php");
include("cabecera.php");
 include("conexion.php");
 include("contenidoMensaje.php");?>

<?php $link=conectar();
 
 $id=($_SESSION['id']);

$consulta="UPDATE persona SET tipoU='clasico' WHERE idPersona='$id' ";

$resu = $link->query($consulta); 

//le envio mensaje que se paso a clasico
$envio=mensajeBajaPremium($id);


echo '<script> alert("BAJA AL SERVICIO PREMIUM EXITOSA");</script>';

echo "<script> window.history.back();</script>";


?>

<?php
mysqli_close($link);
?>