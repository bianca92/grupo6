<html>

<?php

include("clases.php");  
include("cabecera.php");
include("conexion.php");
include("actividadFunciones.php");


$con=conectar();

//para que no se pueda acceder a esta pagina si no esta logeado
try{
$login= new Login();
$login->autorizar();
}
catch(Exception $e){
   echo $e->getMessage();
   header("Location:index.php");
}

$id=($_SESSION['id']);


?>


<?PHP
include("cabeceraActividad.php");
try{
	$arreglo=actividadSubastasTodasUsuario($id);
	foreach($arreglo as $dato) ?>
		<ul style="list-style-type:disc;">
			<li><?php echo "$dato[1]<br/>";?></li>
		</ul>
	<?php
}
catch(Exception $e){
	echo $e->getMessage();
}
?>

</html>