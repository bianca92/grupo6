<?php

$fecha_actual=date('Y-m-d');

 $consulta= "SELECT * FROM config_Hotsale";
 $resultado =  mysqli_query(mysqli_connect('localhost','root','','grupo6'),$consulta);
 $row = mysqli_fetch_array($resultado);

 $fechaFin=strtotime ( '+'.$row['duracion'].' day' , strtotime ( $row['fecha'] )) ; 
      $fechaFin=date('Y-m-d', $fechaFin);

 $fechaSiguiente=strtotime ( '+ 1 year' , strtotime ( $row['fecha'] )) ; 
      $fechaSiguiente=date('Y-m-d', $fechaSiguiente);

$año=date("Y", strtotime($fechaSiguiente));
if($fecha_actual> $fechaFin){
     $actualizarHotsale= "UPDATE config_Hotsale SET  fecha='$fechaSiguiente', year='$año'  WHERE idConfigHotsale=$row[idConfigHotsale] ";
      $resHotsale =  mysqli_query(mysqli_connect('localhost','root','','grupo6'),$actualizarHotsale);


 } 

 	?>