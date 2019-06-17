<?php
include("clases.php");
include("cabecera.php");
 include("conexion.php");
 include("contenidoMensaje.php");?>

<?php $link=conectar();
 $montoBasicoActual=$_POST['basicoActual'];
 $montoPremiumActual=$_POST['premiumActual'];
$montoBasico=$_POST['basico'];
$montoPremium=$_POST['premium'];
if ($montoBasicoActual!=$montoBasico){$envio=mensajeCambioDeCuota(1,$montoBasico);}
if ($montoPremiumActual!=$montoPremium){$envio=mensajeCambioDeCuota(2,$montoPremium);}
$var_consulta="UPDATE config_cuota SET monto='$montoBasico' WHERE idTipoUsuario='1' ";
            	
$var_resultado = $link->query($var_consulta);

$var_consulta="UPDATE config_cuota SET monto='$montoPremium' WHERE idTipoUsuario='2' ";
            	
$var_resultado = $link->query($var_consulta);



echo '<script> alert("MODIFICACION EXITOSA");</script>';

echo "<script> window.location.href='index.php';</script>";

?>

<?php
mysqli_close($link);
?>