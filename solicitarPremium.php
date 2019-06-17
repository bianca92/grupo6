<?php
include("clases.php");
include("cabecera.php");
 include("conexion.php");
 include("contenidoMensaje.php");?>

<?php $link=conectar();
 
 $id=($_SESSION['id']);


$var_consulta="INSERT INTO enesperapremium (idPersona)
                  values('$id')";
            	
$var_resultado = $link->query($var_consulta);
$envio=mensajeSolicitarPremium($id);


echo '<script> alert("SOLICITUD ENVIADA");</script>';

echo "<script> window.history.back();</script>";


?>

<?php
mysqli_close($link);
?>