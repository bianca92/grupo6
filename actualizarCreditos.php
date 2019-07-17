<?php

$fecha_actual=date('Y');

 $consulta= "SELECT * FROM persona WHERE IdPersona=$_SESSION[id] ";
 $resultado =  mysqli_query(mysqli_connect('localhost','root','','grupo6'),$consulta);
 $row = mysqli_fetch_array($resultado);

if($fecha_actual>$row['acreditado']){

      $actualizarCreditos= "UPDATE persona SET  credito=2, acreditado=$fecha_actual   WHERE IdPersona=$row[IdPersona] ";
      $resCreditos =  mysqli_query(mysqli_connect('localhost','root','','grupo6'),$actualizarCreditos);


 } ?>