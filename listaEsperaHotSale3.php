<?php
include("clases.php");  
include("cabecera.php");
include("conexion.php");

$link=conectar();

$paraHotSale = $_POST['subastaHotSale'];
$cant= count($paraHotSale);
$precios = $_POST['precioHotSale'];
$fechaActual = date('Y-m-j');

for($n=0; $n<$cant;$n++)  { 

	$var_consulta="INSERT INTO hotsale (idSubasta, precio, fechaagregada) values('$paraHotSale[$n]', '$precios[$n]', '$fechaActual')";
    $var_resultado = $link->query($var_consulta);

    $var_consulta= "UPDATE subasta SET enhotsale='1' WHERE idSubasta='$paraHotSale[$n]' ";
    $var_resultado = $link->query($var_consulta);

}
 mysqli_close($link);
 echo "<script> window.location ='listaHotSale.php' ;</script>";


?>