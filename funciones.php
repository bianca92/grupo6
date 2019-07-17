 <?php
 function estadoDeSubasta($fecha,$propiedad){
  include_once("conexion.php");
$link = conectar();
 
  //fecha actual
$fecha_actual = date('Y-m-d');
//$fecha_actual2 = new DateTime($fecha_actual);
//$semana = $fecha_actual2->format('W');
//tengo el idsemana de la fecha disponible para recuperar datos de subasta
$fecha2 = new DateTime($fecha);
$semana = $fecha2->format('W');

//me traigo la informacion de la subasta para esa semana
$var_consulta2= "SELECT * FROM subasta WHERE idPropiedad='$propiedad' and idSemana='$semana' ";
$var_resultado2 = mysqli_query($link, $var_consulta2); 
$row2=  mysqli_fetch_array($var_resultado2);

 if ($fecha_actual<$row2['fechaInicioInscripcion']) {
   $estado="<p class= bg-success>LA INSCRIPCION COMIENZA ".date('d/m/Y', strtotime($row2['fechaInicioInscripcion']))."</p>"; 
 }
 else{
       if(($row2['activa']==1)&&($row2['cerrada']!=1)){
            $estado="<p class= bg-danger>EN SUBASTA</p>";
            }
       else{     
        $estado="<p class= bg-success>LA SUBASTA COMIENZA ".date('d/m/Y', strtotime($row2['fechaInicioSubasta']))."</p>"; 
           if(($fecha_actual>=$row2['fechaInicioInscripcion'])&&($fecha_actual<$row2['fechaFinInscripcion'])){
             $estado="<p class= bg-info>EN INSCRIPCION</p>";
           }
       
      
      }
}


//---------
//$estado="<p class= bg-success>LA INSCRIPCION COMIENZA ".date('d/m/Y', strtotime($row2['fechaInicioInscripcion']))."</p>"; 
 /*  if (($fecha_actual>=$row2['fechaInicioInscripcion'])and($fecha_actual<=$row2['fechaFinInscripcion'])and($row['activa']==1)) {
  $estado= "<p class= bg-info>ABIERTA LA INSCRIPCION"."</p>";
}
else{
	if (($fecha_actual>$row2['fechaFinInscripcion'])and($fecha_actual<$row2['fechaInicioSubasta'])){
		echo"<p class= bg-danger>INSCRIPCION CERRADA - La subasta comienza ".date('d/m/Y', strtotime($row2['fechaInicioSubasta']))."</p>";
	}
    if (($fecha_actual>=$row2['fechaInicioSubasta'])and($fecha_actual<=$row2['fechaFinSubasta'])) {
    $estado="<p class= bg-info>EN SUBASTA</p>";  
    }}
if(($row2['cerrada']==1)and($row2['activa']==1)||($fecha=="")){
  $estado="<p class= bg-danger>TERMINADA</p>";
}  
*/
return $estado;
}
function puntuacion($propiedad){ //promedio de puntos de una propiedad
	 include_once("conexion.php");
   include_once("contenidoMensaje.php");
$link = conectar();
$var_consulta3= "SELECT * FROM valoracion WHERE idPropiedad='$propiedad'";
$var_resultado3 = mysqli_query($link, $var_consulta3); 
$count=mysqli_num_rows($var_resultado3);

if($count==0){
	$media=0;
}
else{
$sum=0;
while ($row3=  mysqli_fetch_array($var_resultado3)) {
  $sum=$sum + $row3['puntuacion'];
}
$media= $sum/ $count;
}

return $media;
}



function rechazoAutomatico(){
 
 include_once("conexion.php");
  $link=conectar();
$ganador=($_SESSION['id']);
  $var_consulta="SELECT * FROM persona WHERE idPersona=$ganador";             
$var_resultado = $link->query($var_consulta);
 $row = mysqli_fetch_array($var_resultado);
 if ($row['credito']==0){
     
//saco las subastas que no estan pagadas
$var_consulta2="SELECT g.idPersona, g.idSubasta, g.idPuja
  FROM ganador g
 WHERE NOT EXISTS (SELECT g.idSubasta FROM comprasu cs WHERE g.idPersona=cs.idPersona and g.idSubasta=cs.idSubasta)";             
$var_resultado2 = $link->query($var_consulta2);
$num=mysqli_num_rows($var_resultado2); 

 if($num!=0){
  //recorro las subastas impagas
      while ($row2 = mysqli_fetch_array($var_resultado2)){
   //si la subasta le pertenece a este usuario, tengo que hacer el rechazo
        if($row2['idPersona']==$ganador){
                  $var_consultaP="SELECT * FROM puja WHERE idPuja=$row2[idPuja]";             
                   $var_resultadoP = $link->query($var_consultaP);
                   $rowP = mysqli_fetch_array($var_resultadoP);
               $monto=$rowP['cantidad'];
               $subasta=$row2['idSubasta'];

               $consulta1= "SELECT * FROM puja WHERE idSubasta='$subasta' ORDER BY cantidad DESC";
                   $var_resultado1 = $link->query($consulta1);
                   $idPuja=0;
                   $idPersona=0;
                   while ($row = mysqli_fetch_array($var_resultado1)){
                         if($row['cantidad']<$monto && $row['idPersona']!=$ganador){
                               $idPersona=$row['idPersona'];
                               $idPuja=$row['idPuja'];
                               break;
                          }

                    }
                   //si no hay otro ganador, que borre
                   if($idPuja==0 && $idPersona==0){
                        $sql = "DELETE FROM ganador WHERE idSubasta=$subasta";
                          $result = mysqli_query($link, $sql);
                          $mensaje= rechazoAutCreditos($subasta,$ganador);
                    }
                   else {

                         $sql="UPDATE ganador SET idPersona='$idPersona', idPuja='$idPuja' WHERE idSubasta='$subasta' ";            
                           $result = $link->query($sql);
                           $mensaje= mensajeNuevoGanador($subasta);
                           $mensaje= rechazoAutCreditos($subasta,$ganador);
                          }
          

         }
   
       }
 }

 

}


}

function rechazoAutomaticoDias($subasta){
 
 include_once("conexion.php");
  $link=conectar();
  $ganador=($_SESSION['id']);

  $consultaAux= "SELECT * FROM mensaje WHERE (idPara=$ganador AND idSubasta=$subasta) AND numero='10'"; 
  $var_resultadoAux= $link->query($consultaAux);
  $rowAux = mysqli_fetch_array($var_resultadoAux);
 $fecha_actual=strtotime(date('Y-m-j-H:i'));
  $fechaSubasta=strtotime ( '+7 day' , strtotime ( $rowAux['fecha'] ) ) ;

 if($fecha_actual>=$fechaSubasta){


//saco los datos de la tabla ganador
$var_consulta2="SELECT * FROM ganador WHERE idPersona=$ganador AND idSubasta=$subasta";             
$var_resultado2 = $link->query($var_consulta2);
$row2 = mysqli_fetch_array($var_resultado2);

 
        //obtengo el monto de la puja
                  $var_consultaP="SELECT * FROM puja WHERE idPuja=$row2[idPuja]";             
                   $var_resultadoP = $link->query($var_consultaP);
                   $rowP = mysqli_fetch_array($var_resultadoP);
               $monto=$rowP['cantidad'];
              

               $consulta1= "SELECT * FROM puja WHERE idSubasta='$subasta' ORDER BY cantidad DESC";
                   $var_resultado1 = $link->query($consulta1);
                   $idPuja=0;
                   $idPersona=0;
                   while ($row = mysqli_fetch_array($var_resultado1)){
                         if($row['cantidad']<$monto && $row['idPersona']!=$ganador){
                               $idPersona=$row['idPersona'];
                               $idPuja=$row['idPuja'];
                               break;
                          }

                    }
                   //si no hay otro ganador, que borre
                   if($idPuja==0 && $idPersona==0){
                        $sql = "DELETE FROM ganador WHERE idSubasta=$subasta";
                          $result = mysqli_query($link, $sql);
                           $mensaje= rechazoAutDias($subasta,$ganador);
                    }
                   else {

                         $sql="UPDATE ganador SET idPersona='$idPersona', idPuja='$idPuja' WHERE idSubasta='$subasta' ";            
                           $result = $link->query($sql);
                           $mensaje= mensajeNuevoGanador($subasta);
                            $mensaje= rechazoAutDias($subasta,$ganador);
                          }
          

     return 1;    
   }
      
return 0;


}



?>