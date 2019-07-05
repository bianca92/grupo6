
		
<?php
		
include("clases.php");  
include("cabecera.php");
include("conexion.php");
include("cabeceraHotSale.php");


$link=conectar();
if(!$link)
{
    echo "<h3>No se ha podido conectar PHP - MySQL, verifique sus datos.</h3><hr><br>";
}

$oferta=$_POST['hs'];
$precio=$_POST['nuevoPrecio'];

	
$var_consulta= "UPDATE hotsale SET precio='$precio' WHERE idHotsale='$oferta' ";

$resu=mysqli_query($link,$var_consulta);

echo "<script> window.history.go(-2);</script>";

 
?>
	