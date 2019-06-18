<?php

 include("conexion.php");

$subasta = $_GET['sub'];

$link=conectar();
$fecha_actual = date('Y-m-j');
$fecha_fin=strtotime ( '+7 day' , strtotime ( $fecha_actual ) ) ;
$fecha_fin = date ( 'Y-m-j' , $fecha_fin);

$consulta="UPDATE subasta SET fechaInicioInscripcion='$fecha_actual', fechaFinInscripcion='$fecha_fin' WHERE idSubasta='$subasta' ";

$resu = $link->query($consulta); 


//echo '<script> alert("SE HA ABIERTO LA INSCRIPCION");</script>';
//echo "<script> window.location ='subastasAdmin.php' ;</script>";


mysqli_close($link);
?>