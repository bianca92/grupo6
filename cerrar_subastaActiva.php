<?php

 include("conexion.php");

$puja = $_GET['pugano'];
$subasta = $_GET['sub'];

$link=conectar();

$consulta="UPDATE subasta SET cerrada=1 WHERE idSubasta='$subasta' ";
$resu = $link->query($consulta); 


$consulta3="INSERT INTO ganador (idPuja) VALUES ('$puja')";
$result3 = mysqli_query($link, $consulta3) ;


echo '<script> alert("LA SUBASTA SE HA CERRADO");</script>';
echo "<script> window.location ='subastasActivasAdministrador2.php' ;</script>";


mysqli_close($link);
?>