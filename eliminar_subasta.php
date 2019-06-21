<html>
<?php
include("conexion.php");
include("contenidoMensaje.php");

$link=conectar();
$fecha_actual = date('Y-m-j-H:i');

$idS=$_GET['sub'];


$query = "SELECT * FROM inscripto WHERE idSubasta='$idS' ";
$resultI = mysqli_query($link, $query);
$num=mysqli_num_rows($resultI);

if($num > 0){  		// HAY INSCRIPTOS PARA ESA SUBASTA

// avisarle a los inscriptos
$envio=mensajeEliminarSubasta($idS);

}
// marcar como cancelada ---> cancelada = 1
$consulta="UPDATE subasta SET cancelada=1,cerrada=1,activa=1,fechaInicioInscripcion='$fecha_actual', fechaFinInscripcion='$fecha_actual',fechaInicioSubasta='$fecha_actual',fechaFinSubasta='$fecha_actual' WHERE idSubasta='$idS' ";
$resu = $link->query($consulta); 

echo '<script> alert("SE HA ELIMINADO LA SUBASTA");</script>';

echo "<script> window.history.back();</script>";
?>
</html>