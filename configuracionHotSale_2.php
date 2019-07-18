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
  $fechaFin=strtotime ( '+'.$duracion.' day' , strtotime ( $fechaInicio )) ; 
  $fechaFin=date('Y-m-d', $fechaFin);

 if($fecha_actual>$fechaInicio && $fecha_actual>=$fechaFin){
      $fechaInicio = strtotime ( '+1 year' , strtotime ( $fechaInicio )) ; 
      $fechaInicio = date ( 'Y-m-d' , $fechaInicio ); 
      $fechaFin=strtotime ( '+'.$duracion.' day' , strtotime ( $fechaInicio )) ; 
      $fechaFin=date('Y-m-d', $fechaFin);

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
              
$var_resultado = $link->query($var_consulta);

}

//restauro los descartados para el hot salae
$consul="SELECT * FROM subasta WHERE cancelada = '1' AND enhotsale='1'";
$resul= mysqli_query($link, $consul);
$cant = mysqli_num_rows($resul);
if($cant!=0){
  while($row=mysqli_fetch_array($resul)){

    //busco que no se haya publicado
    $consul2="SELECT * FROM hotsale WHERE idSubasta = '$row[idSubasta]' ";
    $resul2= $link->query($consul2);
    $cantHS = mysqli_num_rows($resul2);
  
    if($cantHS==0 ){
      $var_consultaA="UPDATE subasta SET cancelada='0' , enhotsale='0'WHERE idSubasta='$row[idSubasta]' ";
      $var_resultadoA = $link->query($var_consultaA);
    }
    else{
      //calculo la semana subastada
      $week_start = new DateTime();
      $week_start->setISODate((int)$row['year'],(int)$row['idSemana']);
      $fechaSubasta= $week_start->format('Y-m-d');
      //le resto las semanas
      $fechaAntes=date('Y-m-d',strtotime($fechaSubasta."- 2 week"));

      if($fechaFin<=$fechaAntes){ //sipuede entrar en la proxima subasta que la saque de cancelada
        $var_consulta="UPDATE subasta SET cancelada='0' WHERE idSubasta='$row[idSubasta]' ";
         $var_resultado = $link->query($var_consulta);
      }

    }
  }
}

//restauro los que entraron al hotsale cuando se iban a poder mostrar y ahora no
$consul3="SELECT * FROM hotsale hs INNER JOIN subasta su ON hs.idSubasta=su.idSubasta WHERE su.cancelada = '0' AND su.enhotsale='1'  ";
$resul3= $link->query($consul3);
$cantHS3 = mysqli_num_rows($resul3);
if($cantHS3!=0){
  while($row=mysqli_fetch_array($resul3)){
     //busco que no se haya vendido
     $consul="SELECT * FROM comprah WHERE idHotsale = '$row[idHotsale]' ";
     $resul= $link->query($consul);
     $cantCHS = mysqli_num_rows($resul);

     if($cantCHS==0 ){
      //calculo si entra en el nevo hot sale

      //calculo la semaa subastada
      $week_start = new DateTime();
      $week_start->setISODate((int)$row['year'],(int)$row['idSemana']);
      $fechaSubasta= $week_start->format('Y-m-d');
      //le resto las semanas
      $fechaAntes=date('Y-m-d',strtotime($fechaSubasta."- 2 week"));

      if($fechaFin>$fechaAntes){
         $var_consulta="UPDATE subasta SET enhotsale='0' WHERE idSubasta='$row[idSubasta]' ";
         $var_resultado = $link->query($var_consulta);
         $var_consulta="DELETE FROM hotsale WHERE idHotsale='$row[idHotsale]' ";
         $var_resultado = $link->query($var_consulta);

      }
    }
  }
}


echo '<script> alert("MODIFICACION EXITOSA");</script>';

echo "<script> window.history.go(-1);</script>";

?>

<?php
mysqli_close($link);
?>