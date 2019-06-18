<?php

include("conexion.php");
include("contenidoMensaje.php");

$link=conectar();
$propiedad=$_GET['no'];

$consulta="UPDATE propiedad SET eliminada=1 WHERE idPropiedad='$propiedad' ";
$resu = $link->query($consulta);

$consulta1="SELECT * FROM subasta WHERE idPropiedad='$propiedad' ";
$resulSubasta = $link->query($consulta1);
while ($row = mysqli_fetch_array($resulSubasta)) {

$fecha_actual = date('Y-m-j-H:i');

$query = "SELECT * FROM inscripto WHERE idSubasta='$row[idSubasta]' ";
$resultI = mysqli_query($link, $query);
$num=mysqli_num_rows($resultI);

if($num > 0){  		// HAY INSCRIPTOS PARA ESA SUBASTA

// avisarle a los inscriptos
$envio=mensajeEliminarSubasta($row['idSubasta']);

}
// marcar como cancelada ---> cancelada = 1
$consulta2="UPDATE subasta SET cancelada=1, fechaFinSubasta='$fecha_actual' WHERE idSubasta='$row[idSubasta]' ";
$resul2 = $link->query($consulta2); 
 } 

echo '<script> alert("SE HA ELIMINADO LA PROPIEDAD");</script>';

echo "<script> window.history.back();</script>";


?>