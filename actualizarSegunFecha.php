<?php
// se recibe el valor que identifica la imagen en la tabla

include("contenidoMensaje.php");
function actualizar($idS){
	$link=conectar();
// se recupera la información de la imagen
$sql = "SELECT *
        FROM subasta
        WHERE idSubasta=$idS";
$result = mysqli_query($link, $sql);
$fecha_actual = date('Y-m-d');

$row=mysqli_fetch_array($result);
if ($row['activa']!=1 && $fecha_actual>=$row['fechaInicioSubasta'] ){

 $consulta="UPDATE subasta SET activa=1 WHERE idSubasta=$idS ";
        $resu = mysqli_query($link,$consulta); 

//envio mensaje a los suscriptos de que se activo la subasta
        $envio=mensajeActiva($idS);

}
if ($row['cerrada']!=1 && $fecha_actual>=$row['fechaFinSubasta'] ){

 $consulta="UPDATE subasta SET cerrada=1 WHERE idSubasta=$idS ";
        $resu = mysqli_query($link,$consulta); 


//establece el ganador
$consultaGanador= "SELECT * FROM puja WHERE idSubasta=$idS ORDER BY cantidad DESC";
$resu2 = $link->query($consultaGanador); 
 $num=mysqli_num_rows($resu2); 
if ($num!=0) {
$row = mysqli_fetch_array($resu2);
$var_consulta= "INSERT INTO ganador (idPersona,idSubasta,idPuja)values('$row[idPersona]','$row[idSubasta]','$row[idPuja]') ";
 $var_resultado = $link->query($var_consulta);
}

  //envio mensaje a los suscriptos de que se termino la subasta
        $envio=mensajetermino($idS);

}
$sql = "SELECT *
        FROM subasta
        WHERE idSubasta=$idS";
$result = mysqli_query($link, $sql);
$row=mysqli_fetch_array($result);
$value[0]=$row['activa'];
$value[1]=$row['cerrada'];
return $value;

}







?>