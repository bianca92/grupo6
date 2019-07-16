<?php
include("clases.php");
include("cabecera.php");
 include("conexion.php");
 include("contenidoMensaje.php");?>

<?php $link=conectar();

 $subasta=$_POST['subasta'];
 $ganador=$_POST['ganador'];
 $tarjeta=$_POST['tarjeta'];
 $monto=$_POST['monto'];
 $tipo=$_POST['tipo'];

 $fecha=date('Y-m-j-H:i');

if ($tipo=='subasta'){
$consulta= "SELECT * FROM persona WHERE IdPersona='$ganador'";
$var_resultado = $link->query($consulta);
$row = mysqli_fetch_array($var_resultado);
$creditos= $row['credito'] -1;
$var_consulta="UPDATE persona SET credito='$creditos' WHERE IdPersona='$ganador' ";           	
$var_resultado = $link->query($var_consulta);
 $var_consulta="INSERT INTO comprasu (idSubasta,idPersona,idTarjeta,monto,fecha)
                     values('$subasta', '$ganador','$tarjeta','$monto', '$fecha')";
            	
$var_resultado = $link->query($var_consulta);

 }
 if ($tipo=='premium'){
$consulta= "SELECT * FROM persona WHERE IdPersona='$ganador'";
$var_resultado = $link->query($consulta);
$row = mysqli_fetch_array($var_resultado);
$creditos= $row['credito'] -1;
$var_consulta="UPDATE persona SET credito='$creditos' WHERE IdPersona='$ganador' ";           	
$var_resultado = $link->query($var_consulta);
 $var_consulta="INSERT INTO comprap (idSubasta,idPersona,idTarjeta,monto,fecha)
                     values('$subasta', '$ganador','$tarjeta','$monto', '$fecha')";           	
$var_resultado = $link->query($var_consulta);

$var_consulta="UPDATE subasta SET activa=1, cerrada=1, fechaFinSubasta='$fecha' WHERE idSubasta='$subasta' ";           	
$var_resultado = $link->query($var_consulta);

$mensaje=compradaPorPremium($subasta,$ganador);

 }





echo '<script> alert("PAGO EFECTUADO");</script>';

echo "<script> window.history.go(-2);</script>";

?>

<?php
mysqli_close($link);
?>