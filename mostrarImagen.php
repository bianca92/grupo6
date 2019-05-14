<?php
// se recibe el valor que identifica la imagen en la tabla

function obtenerImgs($idP){
	$link=conectar();
// se recupera la información de la imagen
$sql = "SELECT contenidoImagen
        FROM imagen
        WHERE idPropiedad=$idP";
$result = mysqli_query($link, $sql);
//$row = mysqli_fetch_array($result);

$i=0;
while($row=mysqli_fetch_array($result)){
  // header("Content-type: image/".$row["tipoImagen"]);  
  $value[$i]= $row[0];
  $i=$i + 1;

}
return $value;
}









/*$id = $_GET['idPropiedad'];

Include("conexion.php");
$link=conectar();
// se recupera la información de la imagen
$sql = "SELECT contenidoImagen , tipoImagen
        FROM imagen
        WHERE idPropiedad=$id";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result);
mysqli_close($link);





// se imprime la imagen y se le avisa al navegador que lo que se está
// enviando no es texto, sino que es una imagen un tipo en particular
header("Content-type: image/".$row["tipoImagen"]);  
echo $row['contenidoImagen'];*/

?>