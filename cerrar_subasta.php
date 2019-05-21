<?php

 include("conexion.php");

$subasta = $_GET['no'];

$link=conectar();

$consulta="UPDATE subasta SET activa=1 WHERE idSubasta='$subasta' ";

$resu = $link->query($consulta); 


echo '<script> alert("LA SUBASTA SE HA ACTIVADO");</script>';
echo "<script> window.location ='subastasAdmin.php' ;</script>";


mysqli_close($link);
?>