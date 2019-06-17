<?php
// mensaje de que se activo la subasta. NUMERO 1
function mensajeActiva($idS){
	$link=conectar();

//selecciono el id de los inscriptos
$query = "SELECT idPersona FROM inscripto WHERE idSubasta='$idS' ";
            $resultI = mysqli_query($link, $query);
            $num=mysqli_num_rows($resultI); 

if($num==0){//si no hay inscriptos
           }
else {
  //selecciono el id del admin.

$query = "SELECT idPersona FROM persona WHERE tipoU='administra' ";
            $result = mysqli_query($link, $query);
          $idA = mysqli_fetch_array($result);




   $contenido="La subasta se ha activado";
   $fecha=date('Y-m-j-H:i');
	while($row = mysqli_fetch_array($resultI)){
         $var_consulta="INSERT INTO mensaje (idSubasta,contenido,fecha,idDe,idPara,numero)
                                    values('$idS','$contenido','$fecha','$idA[0]','$row[0]','1')";
            	
          $var_resultado = $link->query($var_consulta);
  }
}
}


//mensaje de que termino la subasta NUMERO 2
function mensajeTermino($idS){
	$link=conectar();
  //selecciono el id de los inscriptos
$query = "SELECT idPersona FROM inscripto WHERE idSubasta='$idS' ";
            $resultI = mysqli_query($link, $query);
            $num=mysqli_num_rows($resultI); 

 if($num==0) {}          
//selecciono el id del admin.
else {
  $query = "SELECT idPersona FROM persona WHERE tipoU='administra' ";
            $result = mysqli_query($link, $query);
          $idA = mysqli_fetch_array($result);


//selecciono el id del ganador
     $query = "SELECT idPersona FROM ganador WHERE idSubasta='$idS' ";
     $result = mysqli_query($link, $query);
     $num2 = mysqli_num_rows($result); 
     if($num2==0)  { $idG[0]="";}
     else{
      $idG = mysqli_fetch_array($result);
     }

   $fecha=date('Y-m-j-H:i');
   //mando los mensajes
	  while($row = mysqli_fetch_array($resultI)){
      $contenido="Has perdido la subasta";
      if($idG[0]==$row[0]){
        $contenido="Felicidades has ganado la subasta";
      }

         $var_consulta="INSERT INTO mensaje (idSubasta,contenido,fecha,idDe,idPara,numero)
                                    values('$idS','$contenido','$fecha','$idA[0]','$row[0]','2')";
            	
          $var_resultado = $link->query($var_consulta);
	

    }
}

}
//mensaje del usuario al adminitrador de que quiere ser premium NUMERO 3
function mensajeSolicitarPremium($idP){
  $link=conectar();

//selecciono el id del admin.
$query = "SELECT idPersona FROM persona WHERE tipoU='administra' ";
            $result = mysqli_query($link, $query);
          $idA = mysqli_fetch_array($result);


//le envio mensaje a los inscriptos de que se abrio la subasta
$query = "SELECT * FROM persona WHERE idPersona='$idP' ";
            $result = mysqli_query($link, $query);
            $row = mysqli_fetch_array($result);


   $contenido="$row[nombre] $row[apellido]: Quiero ser premium." ;
   $fecha=date('Y-m-j-H:i');
  $var_consulta="INSERT INTO mensaje (contenido,fecha,idDe,idPara,numero)
                                    values('$contenido','$fecha','$row[0]','$idA[0]','3')";
              
   $var_resultado = $link->query($var_consulta);
  
}
//mensaje que se acepto el usuario   NUMERO 4
function mensajeSeAceptoPremium($idP){
  $link=conectar();

//selecciono el id del admin.
$query = "SELECT idPersona FROM persona WHERE tipoU='administra' ";
            $result = mysqli_query($link, $query);
          $idA = mysqli_fetch_array($result);


//le envio mensaje que fue aceptado como premium



   $contenido="¡FELICITACIONES!Ahora eres usuario PREMIUM." ;
   $fecha=date('Y-m-j-H:i');
  $var_consulta="INSERT INTO mensaje (contenido,fecha,idDe,idPara,numero)
                                    values('$contenido','$fecha','$idA[0]','$idP','4')";
              
   $var_resultado = $link->query($var_consulta);
  
}

//mensaje que se rechazo el usuario   NUMERO 5
function mensajeSeRechazoPremium($idP){
  $link=conectar();

//selecciono el id del admin.
$query = "SELECT idPersona FROM persona WHERE tipoU='administra' ";
            $result = mysqli_query($link, $query);
          $idA = mysqli_fetch_array($result);


//le envio mensaje que fue rechazado como premium



   $contenido="Lamentamos informarle que ha sido rechazado para ser PREMIUM." ;
   $fecha=date('Y-m-j-H:i');
  $var_consulta="INSERT INTO mensaje (contenido,fecha,idDe,idPara,numero)
                                    values('$contenido','$fecha','$idA[0]','$idP','5')";
              
   $var_resultado = $link->query($var_consulta);
  
}


//mensaje que se ya no es mas premium   NUMERO 6
function mensajeEliminoPremium($idP){
  $link=conectar();

//selecciono el id del admin.
$query = "SELECT idPersona FROM persona WHERE tipoU='administra' ";
            $result = mysqli_query($link, $query);
          $idA = mysqli_fetch_array($result);


//le envio mensaje que fue rechazado como premium



   $contenido="Lamentamos informarle que ya no eres usuario PREMIUM." ;
   $fecha=date('Y-m-j-H:i');
  $var_consulta="INSERT INTO mensaje (contenido,fecha,idDe,idPara,numero)
                                    values('$contenido','$fecha','$idA[0]','$idP','6')";
              
   $var_resultado = $link->query($var_consulta);
  
}

//mensaje que cambio el monto de la cuota NUMERO 7
function mensajeCambioDeCuota($idTipoUsuario,$monto){
  $link=conectar();
  if ($idTipoUsuario==1){$tipo="clasico";}
  else{$tipo="premium";}
  //selecciono el id de los inscriptos

$query = "SELECT idPersona FROM persona WHERE tipoU='$tipo' ";
            $resultI = mysqli_query($link, $query);
            $num=mysqli_num_rows($resultI); 

 if($num==0) {}          
//selecciono el id del admin.
else {
  $query = "SELECT idPersona FROM persona WHERE tipoU='administra' ";
            $result = mysqli_query($link, $query);
          $idA = mysqli_fetch_array($result);



     
 $contenido="El monto de la cuota mensual ha sido modificada, el nuevo monto es $ $monto.";
   $fecha=date('Y-m-j-H:i');
   //mando los mensajes
    while($row = mysqli_fetch_array($resultI)){
     
         $var_consulta="INSERT INTO mensaje (contenido,fecha,idDe,idPara,numero)
                                    values('$contenido','$fecha','$idA[0]','$row[0]','7')";
              
          $var_resultado = $link->query($var_consulta);
  

    }
}

}




?>