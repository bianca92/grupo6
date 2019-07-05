<?php

 include("conexion.php");

$subasta = $_GET['sub'];

$link=conectar();

$consulta="UPDATE subasta SET enhotsale='0' WHERE idSubasta='$subasta' ";

$resu = $link->query($consulta); 

$consulta="DELETE FROM hotsale WHERE idSubasta='$subasta' ";

$resu = $link->query($consulta); 


echo '<script> alert("SE HA QUITADO LA SEMANA DEL HOT SALE");</script>';
echo "<script> window.history.go(-1);</script>";


mysqli_close($link);
?>