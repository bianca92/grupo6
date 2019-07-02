<?php
include("clases.php");
include("cabecera.php");
 include("conexion.php");
 include("contenidoMensaje.php");?>

<?php $link=conectar();

 $primeraVez=$_POST['primera'];

 
 $fechaInicio=$_POST['datepicker'];
 $duracion=$_POST['duracion'];
 
//sustraigo el dia y el mes
$dia=substr("$fechaInicio",0, 2);
$mes=substr("$fechaInicio",3, 2);
// de esta manera se crea la fecha, lo dejo aca para no olvidarme como se hace
$año=date("Y");
$fecha="$dia-$mes-$año";
$fechaInicio= date ( 'd-m-Y' , strtotime ( $fecha ) ) ;

//---------------------------------------------------------------------

//si es la primera vez que se configura creo la tabla
if ($primeraVez==1){

$var_consulta="INSERT INTO config_hotsale (dia,mes,duracion)
                     values('$dia', '$mes','$duracion')";
            	
$var_resultado = $link->query($var_consulta);



 }
else{
$idC=$_POST['idConfigHotsale'];
$var_consulta="UPDATE config_hotsale SET dia='$dia', mes='$mes', duracion='$duracion' WHERE idConfigHotsale='$idC' ";
            	
$var_resultado = $link->query($var_consulta);}



echo '<script> alert("MODIFICACION EXITOSA");</script>';

echo "<script> window.history.go(-2);</script>";

?>

<?php
mysqli_close($link);
?>