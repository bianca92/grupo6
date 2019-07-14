<?php
include("clases.php");
include("cabecera.php");
 include("conexion.php");
 include("contenidoMensaje.php");?>

<?php $link=conectar();

 $hotsale=$_POST['hotsale'];
 $persona=$_POST['persona'];
 $tarjeta=$_POST['tarjeta'];
 $monto=$_POST['monto'];
 //$tipo=$_POST['tipo'];

 $fecha=date('Y-m-j-H:i');


//$consulta= "SELECT * FROM persona WHERE idPersona='$persona'";
//$var_resultado = $link->query($consulta);
//$row = mysqli_fetch_array($var_resultado);
//$creditos= $row['credito'] -1;
//$var_consulta="UPDATE persona SET credito='$creditos' WHERE IdPersona='$ganador' ";           	
//$var_resultado = $link->query($var_consulta);
 $var_consulta="INSERT INTO compraH (idPersona,idHotsale,idTarjeta,monto,fecha)
                     values('$persona','$hotsale','$tarjeta','$monto', '$fecha')";
            	
$var_resultado = $link->query($var_consulta);

 

echo '<script> alert("ADQUIRISTE LA SEMANA");</script>';

echo "<script> window.history.go(-2);</script>";

?>

<?php
mysqli_close($link);
?>