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
$id=$_POST['usuario'];
$tarjeta=$_POST['tarjeta'];

$nombre=$_POST['nombre'];
$apellido=$_POST['apellido'];
$dni=$_POST['dni'];
$telefono=$_POST['telefono'];
$ciudad=$_POST['ciudad'];
$email=$_POST['email'];
$clave=$_POST['clave'];
// $nacimiento=$_POST['nacimiento'];
$marca=$_POST['marca'];
$numero=$_POST['numero'];
$codigo=$_POST['codigo'];
$vencimiento=$_POST['vencimiento'];  


//ACTUALIZAR DATOS USUARIO----------(agregar la fecha de nac)
$var_consulta= "UPDATE persona SET IdPersona='$id', nombre='$nombre', apellido='$apellido', dni='$dni', telefono='$telefono', ciudad='$ciudad', email='$email', clave='$clave'  WHERE IdPersona='$id' ";
$var_resultado = $link->query($var_consulta);

//ACTUALIZAR DATOS TARJETA
$var_consulta= "UPDATE tarjeta SET idTarjeta='$tarjeta', marca='$marca', numero='$numero', codigo='$codigo', vencimiento='$vencimiento'  WHERE idTarjeta='$tarjeta' ";
$var_resultado = $link->query($var_consulta);

header("Location:misDatos.php");

 
?>
	