<?php
include("clases.php");
include("cabecera.php");
 include("conexion.php");
 include("contenidoMensaje.php");?>

<?php //$link=conectar();
 
// $id=($_SESSION['id']);


//$var_consulta="INSERT INTO enesperapremium (idPersona)
             //        values('$id')";
            	
//$var_resultado = $link->query($var_consulta);
//$envio=mensajeSolicitarPremium($id);


echo '<script> alert("Para efectuar la solicitud debe llamar al 0800-333-555 o dirigirse nuestras oficinas.");</script>';

echo "<script> window.history.back();</script>";


?>

<?php
//mysqli_close($link);
?>