<?php

 include("conexion.php");
 include("contenidoMensaje.php");


$hayGanador=$_GET['g'];
$subasta = $_GET['sub'];

$link=conectar();

$fecha_actual = date('Y-m-j-H:i');

$consulta="UPDATE subasta SET cerrada=1, fechaFinSubasta='$fecha_actual' WHERE idSubasta='$subasta' ";
$resu = $link->query($consulta); 


if($hayGanador>0){
	$puja = $_GET['pugano'];

	//establece el ganador
	$consultaGanador= "SELECT * FROM puja WHERE idPuja=$puja";
	$resu2 = $link->query($consultaGanador); 
	$num=mysqli_num_rows($resu2); 
	if ($num!=0) {
		$row = mysqli_fetch_array($resu2);
		$var_consulta= "INSERT INTO ganador (idPersona,idSubasta,idPuja)values('$row[idPersona]','$row[idSubasta]','$row[idPuja]') ";
	 	$var_resultado = $link->query($var_consulta);
	}
}

$envio=mensajeTermino($subasta);

echo '<script> alert("LA SUBASTA SE HA CERRADO");</script>';
echo "<script> window.location ='subastasActivasAdministrador2.php' ;</script>";

mysqli_close($link);
?>