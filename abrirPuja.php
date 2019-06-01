<?php

 include("conexion.php");
 include("contenidoMensaje.php");

$subasta = $_GET['sub'];

$link=conectar();
$fecha_actual = date('Y-m-j');
$fecha_fin=strtotime ( '+7 day' , strtotime ( $fecha_actual ) ) ;
$fecha_fin = date ( 'Y-m-j' , $fecha_fin);

$consulta="UPDATE subasta SET activa=1, fechaInicioSubasta='$fecha_actual', fechaFinSubasta='$fecha_fin' WHERE idSubasta='$subasta' ";

$resu = $link->query($consulta); 

//le envio mensaje a los inscriptos de que se abrio la subasta
$envio=mensajeActiva($subasta);


echo '<script> alert("LA SUBASTA SE HA ACTIVADO");</script>';
echo "<script> window.location ='subastasAdmin.php' ;</script>";


mysqli_close($link);
?>