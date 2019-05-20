
		
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
$primeraOferta=$_POST['primeraOferta'];
//SI ESLA PRIMERA OFERTA QUE CREE LA TABLA

if($primeraOferta==1){
	$var_consulta= "INSERT INTO puja (idPersona,idSubasta,cantidad)values('$usuario','$subasta','$monto') ";
  $var_resultado = $link->query($var_consulta);
}
 else {
//SI NO ES LA PRIMERA OFERTA QUE ACTUALICE LA TABLA
$var_consulta= "UPDATE puja SET cantidad='$monto' WHERE idPersona='$usuario' AND idSubasta=$subasta ";
  $var_resultado = $link->query($var_consulta);

 }






header("Location:subastasActivasUsuario4.php");

 
?>
	