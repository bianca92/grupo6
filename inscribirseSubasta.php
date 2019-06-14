<?php
include("clases.php");  
include("conexion.php");
$link=conectar();
$Subasta=$_GET['idS'];

$Persona=$_GET['idU'];

$fechaActual = date('Y-m-d-H:i');

$var_consulta= "INSERT INTO inscripto (idPersona,idSubasta,fecha)values('$Persona','$Subasta','$fechaActual')";
   $result = mysqli_query($link, $var_consulta) ;



header("Location:subastasUsuario.php");


?>