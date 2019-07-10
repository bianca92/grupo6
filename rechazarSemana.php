<?php
include("clases.php");
include("cabecera.php");
 include("conexion.php");
 include("contenidoMensaje.php");?>

<?php $link=conectar();

 $subasta=$_GET['sub'];
 $ganador=$_GET['ganador'];
 $monto=$_GET['monto'];
 

 $fecha=date('Y-m-j-H:i');


$consulta= "SELECT * FROM puja WHERE idSubasta='$subasta' ORDER BY cantidad DESC";
$var_resultado = $link->query($consulta);
$idPuja=0;
$idPersona=0;
while ($row = mysqli_fetch_array($var_resultado)){
 if($row['cantidad']<$monto && $row['idPersona']!=$ganador){
     $idPersona=$row['idPersona'];
     $idPuja=$row['idPuja'];
     break;
 }

}
//si no hay otro ganador, que borre
if($idPuja==0 && $idPersona==0){
	$sql = "DELETE FROM ganador
        WHERE idSubasta=$subasta";
$result = mysqli_query($link, $sql);
}
else {

$var_consulta="UPDATE ganador SET idPersona='$idPersona', idPuja='$idPuja' WHERE idSubasta='$subasta' ";           	
$var_resultado = $link->query($var_consulta);
}



echo '<script> alert("SUBASTA RECHAZADA");</script>';

echo "<script> window.history.go(-1);</script>";

?>

<?php
mysqli_close($link);
?>