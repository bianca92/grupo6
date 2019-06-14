<html>
<head>
		
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
    //echo "<h3>Conexion Exitosa PHP - MySQL</h3><hr><br>";
}

$id=($_SESSION['id']);


//OBTENGO LOS DATOS DEL USUARIO ACTUAL
$var_consulta = "SELECT * FROM persona p INNER JOIN  tarjeta t ON p.IdPersona = t.idPersona WHERE p.IdPersona = '$id' ";
$var_resultado = mysqli_query($link, $var_consulta);
$row = mysqli_fetch_array($var_resultado);




?>
	<title>Datos</title>
	
	</head>
	<body>
		
		<div id="wrapper" style="margin-top: 0px">

			<form name="formulario" action="modificarDatosUsuario2.php" method="POST" class="login-form" enctype="multipart/form-data" onsubmit="return validareg();">
				
				<div class="header">
					<h1> Modificar Mis Datos</h1>
				</div>
			 
				
				<div class="content">

					
					<input type="hidden" name="usuario" value='<?php echo "$row[IdPersona]" ?>' size="25">
					<input type="hidden" name="tarjeta" value='<?php echo "$row[idTarjeta]" ?>' size="25">

					<label for="nombre">Nombre: </br></label>
					<input type="text" name="nombre" class="input username" value='<?php echo "$row[nombre]" ?>' size="25">

                    <label for="apellido">Apellido: </br></label>
					<input type="text" name="apellido" class="input username" value='<?php echo "$row[apellido]" ?>'>

					<label for="dni">DNI: </br></label>
					<input type="text" name="dni" class="input username" value='<?php echo "$row[dni]" ?>'>

					<label for="telefono">Telefono: </br></label>
					<input type="text" name="telefono" class="input username" value='<?php echo "$row[telefono]" ?>'>

					<label for="ciudad">Ciudad: </br></label>
					<input type="text" name="ciudad" class="input username" value='<?php echo "$row[ciudad]" ?>'>

					<label for="email">Email: </br></label>
					<input type="text" name="email" class="input username" value='<?php echo "$row[email]" ?>'>

<?php   //  HACER VERIFICAR SI LA CLAVE ANTERIOR ES LA CORRECTA Y SI LA NUEVA Y LA CONFIRMACION COINCIDEN ?>

					<label for="clave0">Contraseña Anterior: </br></label>
					<input type="password" name="clave0" size=20 minlength="6" maxlength="20" class="input password" value='<?php echo "*******"?>' >

					<label for="clave">Contraseña Nueva: </br></label>
					<input type="password" name="clave" size=20 minlength="6" maxlength="20" class="input password" >
					
					<label for="clave2" >Confirme Contraseña Nueva: </br></label>
					<input type="password" name="clave2" minlength="6" size="20" maxlength="20" class="input password" >	

					<label for="fechaNacimiento">Fecha de Nacimiento: </br></label>
					<input id="datepicker" type="date" name="nacimiento" class="input username" size="8" autocomplete="off" max='<?php echo $fechaMayorEdad; ?>'  title="Debes ser mayor de edad para poder registrarte" id="valNacimiento" required="required">

					<label for="ubicacion">Datos de la Tarjeta: </br></label>

					<label for="marca">Marca: </br></label>
					<input type="text" name="marca" class="input username" value='<?php echo "$row[marca]" ?>'>

					<label for="numero">Numero: </br></label>
					<?php  $ult4 = substr($row['numero'],12); ?>
					<input type="text" name="numero" class="input username" value='<?php echo "**** **** **** $ult4" ?>'>

					<label for="codigo">Codigo de Seguridad: </br></label>
					<input type="text" name="codigo" class="input username" value='<?php echo "***" ?>'>

					<label for="vencimiento">Fecha de Vencimiento: </br></label>
					<input type="text" name="vencimiento" class="input username" value='<?php echo "$row[vencimiento]" ?>'>           
					
					
			</div>
				<div class="footer">
					<input type="submit" name="login" value="GUARDAR" class="button" />
				</div>

			</form>
			
		</div>
	</body>
</html>