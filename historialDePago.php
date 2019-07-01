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
$rol=($_SESSION['rol']);

?>
<body>

	<form name="formulario" class="login-form" style="width:900px; background-color:#fff;">
<table>
<?PHP


try{

	if($rol=="1"){//---ES EL ADMINISTRADOR
		$id=$_GET['idU'];  

		//recupero datos del usuario
		$consul= "SELECT * FROM persona WHERE IdPersona='$id' ";
		$resul=mysqli_query($con, $consul);
		$datosU = mysqli_fetch_array($resul);


		 ?>


		<form name="formulario" class="login-form" style="width:900px;background-color:#28a3db;">
				<div class="header"style="background-color:#28a3db;color: #000000">
					<h1> Historial de pagos de:   <?php echo "  $datosU[nombre] $datosU[apellido]"?></h1>
				</div>
		
<?php
	}
	else{
		$id=($_SESSION['id']);

		?>
		<form style="background-color: #28a3db"><div style="background-color:#28a3db "><h1> Historial de pagos</h1></div></form><br/>
		<?php
	}
	$arreglo=actividadPagosUsuario($id);
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
</form>
</body>
</html>