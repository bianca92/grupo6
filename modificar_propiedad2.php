
		
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

if (($_FILES['imagen2']['size'])== ""){

	$var_consulta= "UPDATE propiedad SET idPropiedad='$Propiedad', titulo='$titulo',ciudad='$idUbicacion', descripcion='$descripcion' WHERE idPropiedad='$Propiedad' ";
  $var_resultado = $link->query($var_consulta);
}
else {
	
	$image = addslashes(file_get_contents($_FILES['imagen2']['tmp_name']));
  $var_consulta= "UPDATE propiedad SET idPropiedad='$Propiedad', titulo='$titulo',ciudad='$idUbicacion', descripcion='$descripcion',  imagen='$image' WHERE idPropiedad='$Propiedad' ";
$var_resultado = $link->query($var_consulta);

}




header("Location:index.php");

 
?>
	