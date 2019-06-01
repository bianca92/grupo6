<?php

 include("conexion.php");

$subasta = $_GET['sub'];

$link=conectar();
$fecha_actual = date('Y-m-j');


$consulta="UPDATE subasta SET fechaFinInscripcion='$fecha_actual' WHERE idSubasta='$subasta' ";

$resu = $link->query($consulta); 


echo '<script> alert("SE HA CERRADO LA INSCRIPCION");</script>';
echo "<script> window.location ='subastasAdmin.php' ;</script>";


mysqli_close($link);
?>