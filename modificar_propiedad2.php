
		
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
 $pais=$_POST['pais'];
     $provincia=$_POST['provincia'];
      $localidad=$_POST['localidad'];
       $direccion=$_POST['direccion'];

//if (($_FILES['imagen']['error'])> 0)
if (count(array_filter($_FILES['imagen']['name']))==0)
{

	$var_consulta= "UPDATE propiedad SET idPropiedad='$Propiedad', titulo='$titulo', descripcion='$descripcion', pais='$pais', provincia='$provincia',localidad='$localidad', direccion='$direccion' WHERE idPropiedad='$Propiedad' ";
  $var_resultado = $link->query($var_consulta);
}
else {
	
  $var_consulta= "UPDATE propiedad SET idPropiedad='$Propiedad', titulo='$titulo', descripcion='$descripcion', pais='$pais', provincia='$provincia',localidad='$localidad', direccion='$direccion' WHERE idPropiedad='$Propiedad' ";

$resu=mysqli_query($link,$var_consulta);
$query="DELETE FROM imagen WHERE idpropiedad='$Propiedad'";
      $resu=mysqli_query($link,$query);

 //insertar nuevas imagenes
for($i = 0; $i < count($_FILES['imagen']['name']); $i++){

    $imagen= $_FILES['imagen']['tmp_name'][$i]; //archivo temporal
    $imagen2= file_get_contents("$imagen");//leer el contenido de un archivo en una cadena.
     $imagen2=addslashes($imagen2); // agrega barra invertidas /

     $extension = $_FILES['imagen']['type'][$i];
      $extension=str_replace("image/", "", $extension); //remplaza en la cadena "image/" por ""

       $query="INSERT INTO imagen (contenidoImagen,tipoImagen,idPropiedad)values('$imagen2','$extension','$Propiedad')";
             $resu=mysqli_query($link,$query);
}
}




echo "<script> window.history.go(-2);</script>";

 
?>
	