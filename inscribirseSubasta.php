<?php
include("clases.php");  
include("conexion.php");
$link=conectar();
$Subasta=$_GET['idS'];

$Persona=$_GET['idU'];

$var_consulta= "INSERT INTO inscripto (idPersona,idSubasta)values('$Persona','$Subasta')";
   $result = mysqli_query($link, $var_consulta) ;



header("Location:subastasUsuario.php");


?>