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
  if($row2['activa']==1){
  $estado="<p class= bg-danger>EN SUBASTA</p>";
}  
else{
  
   $estado="<p class= bg-info>EN INSCRIPCION</p>";
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

?>