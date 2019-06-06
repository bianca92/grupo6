
		
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

//RECUPERO LOS VALORES DE PUJAR.PHP
$monto=$_POST['monto'];
$subasta=$_POST['subasta'];
$usuario=$_POST['usuario'];
$ganador=$_POST['ganador'];
$fecha=$_POST['fecha'];



	$var_consulta= "INSERT INTO puja (idPersona,idSubasta,cantidad,fecha)values('$usuario','$subasta','$monto','$fecha') ";
  $var_resultado = $link->query($var_consulta);
  $ultimo_id=mysqli_insert_id($link);

if($ganador=="1"){
	$var_consulta= "INSERT INTO ganador (idPersona,idSubasta,idPuja)values('$usuario','$subasta','$ultimo_id') ";
  $var_resultado = $link->query($var_consulta);
}
else{

	$consulta="UPDATE ganador SET idPersona='$usuario', idPuja='$ultimo_id' WHERE idSubasta='$subasta' ";

$resu = $link->query($consulta); 
}

 






header("Location:subastasActivasUsuario4.php");

 
?>
	