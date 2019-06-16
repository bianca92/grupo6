<?php
include("conexion.php");

 $link=conectar();
 $idP="28";
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
  $i=$i + 1;}

  echo '<img src="data:image/jpeg;base64,'.base64_encode($value[0]).'" style="width:300px;height:300px;" />';
echo '<img src="data:image/jpeg;base64,'.base64_encode($value[1]).'" style="width:300px;height:300px;" />';
 echo '<img src="data:image/jpeg;base64,'.base64_encode($value[0]).'" style="width:300px;height:300px;" />';
echo '<img src="data:image/jpeg;base64,'.base64_encode($value[1]).'" style="width:300px;height:300px;" />';
 echo '<img src="data:image/jpeg;base64,'.base64_encode($value[0]).'" style="width:300px;height:300px;" />';
echo '<img src="data:image/jpeg;base64,'.base64_encode($value[1]).'" style="width:300px;height:300px;" />';



?>