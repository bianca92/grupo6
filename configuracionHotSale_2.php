<?php
include("clases.php");
include("cabecera.php");
 include("conexion.php");
 include("contenidoMensaje.php");?>

<?php $link=conectar();

 $primeraVez=$_POST['primera'];

 
 $fechaInicio=$_POST['datepicker'];
 $duracion=$_POST['duracion'];

  //OBTENGO EL NUMERO DE LA SEMANA QUE EL ADMIN INGRESO
$dia=date('d', strtotime($fechaInicio));
//OBTENGO EL MES
$mes=date('m', strtotime($fechaInicio));
$year=date('Y', strtotime($fechaInicio));

  $fecha_actual=date('Y-m-d');

 if($fecha_actual>$fechaInicio){
      $fechaInicio = strtotime ( '+1 year' , strtotime ( $fechaInicio )) ; 
      $fechaInicio = date ( 'Y-m-d' , $fechaInicio ); 
      $year= $year + 1;
 }
 

// de esta manera se crea la fecha, lo dejo aca para no olvidarme como se hace
//$año=date("Y");
//$fecha="$dia-$mes-$year";
//$fechaInicio= date ( 'd-m-Y' , strtotime ( $fecha ) ) ;

//---------------------------------------------------------------------

//si es la primera vez que se configura creo la tabla
if ($primeraVez==1){

$var_consulta="INSERT INTO config_hotsale (dia,mes,year,fecha,duracion)
                     values('$dia', '$mes','$year','$fechaInicio','$duracion')";
            	
$var_resultado = $link->query($var_consulta);

}
else{
$idC=$_POST['idConfigHotsale'];
$var_consulta="UPDATE config_hotsale SET dia='$dia', mes='$mes', year='$year', fecha='$fechaInicio' ,duracion='$duracion' WHERE idConfigHotsale='$idC' ";
            	
$var_resultado = $link->query($var_consulta);}



echo '<script> alert("MODIFICACION EXITOSA");</script>';

echo "<script> window.history.go(-2);</script>";

?>

<?php
mysqli_close($link);
?>