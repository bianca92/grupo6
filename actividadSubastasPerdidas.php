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

include("cabeceraActividad.php");
?>
<body>
	<form name="formulario" class="login-form" style="width:900px; background-color:#fff;">
<table>
<?PHP


try{
	$arreglo=actividadSubastasPerdidasUsuario($id);
	foreach($arreglo as $dato) {?>
		
   <tr> 
   	<td><br><?php echo "$dato[1]<br/>"; ?> </td>
                                
    </tr>

		


<?php
	}
		

}
catch(Exception $e){
	echo $e->getMessage();
}
?>
</table>
</form>
</body>
</html>