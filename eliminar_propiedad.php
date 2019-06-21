<?php

include("conexion.php");
include("contenidoMensaje.php");

$link=conectar();
$propiedad=$_GET['no'];

$consulta="UPDATE propiedad SET eliminada=1 WHERE idPropiedad='$propiedad' ";
$resu = $link->query($consulta);



$consulta1="SELECT * FROM subasta WHERE idPropiedad='$propiedad' ";
$resulSubasta = $link->query($consulta1);
while ($row = mysqli_fetch_array($resulSubasta)) { // x cada subastad de la propiedad

$fecha_actual = date('Y-m-j-H:i');

$query = "SELECT * FROM inscripto WHERE idSubasta='$row[idSubasta]' ";
$resultI = mysqli_query($link, $query);
$num=mysqli_num_rows($resultI);

if($num > 0){  		// HAY INSCRIPTOS PARA ESA SUBASTA

// avisarle a los inscriptos
$envio=mensajeEliminarSubasta($row['idSubasta']);

}
// marcar como cancelada ---> cancelada = 1
//$consulta2="UPDATE subasta SET cancelada=1, fechaFinSubasta='$fecha_actual' WHERE idSubasta='$row[idSubasta]' ";
//$resul2 = $link->query($consulta2); 
// si es distinta de cerrada de 1, pongo en uno
if($row['cerrada']==0){
    if ($row['activa']==0) {
      $consulta3="UPDATE subasta SET activa=1,fechaInicioInscripcion='$fecha_actual', fechaFinInscripcion='$fecha_actual',fechaInicioSubasta='$fecha_actual', fechaFinSubasta='$fecha_actual' WHERE idSubasta='$row[idSubasta]' ";
      $resul3 = $link->query($consulta3); 
	}
   $consulta2="UPDATE subasta SET cerrada=1,fechaInicioInscripcion='$fecha_actual', fechaFinInscripcion='$fecha_actual',fechaInicioSubasta='$fecha_actual', fechaFinSubasta='$fecha_actual' WHERE idSubasta='$row[idSubasta]' ";
   $resul2 = $link->query($consulta2); 
}
 } 

echo '<script> alert("SE HA ELIMINADO LA PROPIEDAD");</script>';

echo "<script> window.history.back();</script>";
 mysqli_free_result($result);
            mysqli_close($con);

?>