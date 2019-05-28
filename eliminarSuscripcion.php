<?php
// se recibe el valor que identifica la imagen en la tabla
include("conexion.php");
$persona=$_GET['idU'];
$subasta=$_GET['idS'];
	$link=conectar();
// se recupera la información de la imagen
$sql = "DELETE FROM inscripto
        WHERE idPersona=$persona and idSubasta=$subasta";
$result = mysqli_query($link, $sql);
//$row = mysqli_fetch_array($result);
if (mysqli_affected_rows($link) > 0) { 
echo '<script> alert("SE HA ELIMINADO LA SUSCRIPCION");</script>';
echo "<script> window.location ='subastasUsuario.php' ;</script>";



} 
mysqli_close($link);
//header("Location:subastasUsuario.php");
?>