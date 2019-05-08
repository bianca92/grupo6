
		
<?php
		
		include("clases.php");  
    include("cabecera.php");
include("conexion.php");



//$link = mysqli_connect('localhost','root','','grupo6');
$link=conectar();
if(!$link)
{
    echo "<h3>No se ha podido conectar PHP - MySQL, verifique sus datos.</h3><hr><br>";
}
else
{
   // echo "<h3>Conexion Exitosa PHP - MySQL</h3><hr><br>";
}
$Propiedad=$_POST['propiedad'];

$titulo=$_POST['titulo'];
$descripcion=$_POST['descripcion'];
$idUbicacion=$_POST['ubicacion'];

if ($_FILES['imagen2']['error']>0){
	$destino=$_POST['imagen1'];
}
else {
	$foto=$_FILES['imagen2']['name'];
  $ruta=$_FILES['imagen2']['tmp_name'];
    $destino="imgs/".$foto;
    copy($ruta,$destino);
}




$var_consulta= "UPDATE propiedad SET idPropiedad='$Propiedad', titulo='$titulo',ciudad='$idUbicacion', descripcion='$descripcion',  imagen='$destino' WHERE idPropiedad='$Propiedad' ";
$var_resultado = $link->query($var_consulta);

header("Location:listarPropiedades.php");

 
?>
	