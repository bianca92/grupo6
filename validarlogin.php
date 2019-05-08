<?php

include("clases.php");
include("conexion.php");
$con=conectar();


$u=$_POST['usuario'];// usuario=email
$c=$_POST['clave'];
session_start();
try{
$login = new Login();
$login->autentificar($con,$c,$u);
header("Location:index.php");
}
catch(Exception $e){
	$MENSAJE= $e->getMessage();
	 header("Location:ingresar.php?msj='$MENSAJE' ");
}

?>