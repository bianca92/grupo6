<?php


include("clases.php");  
include("cabecera.php");
include("conexion.php");

$link=conectar();
if(!$link)
{
    echo "<h3>No se ha podido conectar PHP - MySQL, verifique sus datos.</h3><hr><br>";
}
$usuario=$_POST['usuario'];

$marca=$_POST['marca'];
$numero=$_POST['numero'];
$codigo=$_POST['codigo'];
$vencimiento=$_POST['vencimiento']; 


            
//CREA UNA NUEVA TARJETA

     $query="INSERT INTO tarjeta (idPersona, numero, marca, vencimiento, codigo)values('$usuario','$numero','$marca','$vencimiento','$codigo')";
     $resul5=mysqli_query($link,$query);
     $tarjeta=mysqli_insert_id($link);

//ACTUALIZA LA TARJETA DEL USUARIO

 $var_consulta= "UPDATE persona SET idTarjeta='$tarjeta'  WHERE IdPersona='$usuario' ";
 $var_resultado = $link->query($var_consulta);


echo "<script> window.location.href='misDatos.php';</script>";

?>