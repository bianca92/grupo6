<?php
// se recibe el valor que identifica la imagen en la tabla

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

}
if ($row['cerrada']!=1 && $fecha_actual>=$row['fechaFinSubasta'] ){

 $consulta="UPDATE subasta SET cerrada=1 WHERE idSubasta=$idS ";
        $resu = mysqli_query($link,$consulta); 

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