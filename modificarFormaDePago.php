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


//OBTENGO el ID de la tarjeta del usuario actual
$var_consulta = "SELECT idTarjeta FROM persona WHERE IdPersona = '$id' ";
$var_resultado = mysqli_query($link, $var_consulta);
$row = mysqli_fetch_array($var_resultado);

$idT = $row['idTarjeta'];

//OBTENGO LOS DATOS DE LA TARJETA ACTUAL
//OBTENGO LOS DATOS DEL USUARIO ACTUAL
$var_consulta = "SELECT * FROM tarjeta WHERE idTarjeta = '$idT' ";
$var_resultado = mysqli_query($link, $var_consulta);
$row = mysqli_fetch_array($var_resultado);



?>
	<title>Datos</title>
	
	</head>
	<body>
		
		<div id="wrapper" style="margin-top: 0px">

			<form name="formulario" action="modificarFormaDePago2.php" method="POST" class="login-form" enctype="multipart/form-data" onsubmit="return validareg();">
				
				<div class="header">
					<h1> Modificar Forma de Pago</h1>
				</div>
			 
				
				<div class="content">

					
					<input type="hidden" name="usuario" value='<?php echo "$id" ?>' size="25">
					

					<label for="ubicacion">Datos de la Tarjeta: </label><br/>


					<label for="marca">Marca: </br></label>
					<input type="text" name="marca" class="input username" value='<?php echo "$row[marca]" ?>' required="required">

					<label for="numero">Numero: </br></label>
					<?php  $ult4 = substr($row['numero'],12); ?>
					<input type="text" name="numero" class="input username" pattern="[0-9]{16}" title="Ingrese los 16 digitos de su tarjeta de credito" id="valNumero" placeholder='<?php echo "**** **** **** $ult4" ?>'required="required">				

					<label for="codigo">Codigo de Seguridad: </br></label>
					<input type="text" name="codigo" class="input username" pattern="[0-9]{3}" title="Ingrese los 3 digitos del dorso de su tarjeta de credito" id="valCodigo" placeholder='<?php echo "***" ?>'required="required">

					<label for="vencimiento">Fecha de Vencimiento: </br></label>
					<input type="text" name="vencimiento" class="input username" pattern="[0-9*/]{7}" title="Ingrese la fecha de vencimiento con el formato mm/aaaa" id="valVencimiento" value='<?php echo "$row[vencimiento]" ?>'required="required">           
					
					
			</div>
				<div class="footer">
					<input type="submit" name="login" value="GUARDAR" class="button" />
				</div>

			</form>
			
		</div>
	</body>
</html>