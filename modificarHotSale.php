<html>
<head>
		
<?php
		
include("clases.php");  
include("cabecera.php");
include("conexion.php");
include("cabeceraHotSale.php");



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
$ofertaHS=$_GET['hs'];


$var_consulta= "SELECT * FROM hotsale WHERE idHotsale='$ofertaHS' ";
$var_resultado = $link->query($var_consulta);
$row = mysqli_fetch_array($var_resultado);


?>
	<title>MODIFICAR SEMANA EN HOT SALE</title>
	
	</head>
	<body>
		
		<div id="wrapper" style="margin-top: 0px">

			<form name="formulario" action="modificarHotSale2.php" method="POST" class="login-form" enctype="multipart/form-data" onsubmit="return validareg();">
				
				<div class="header">
					<h1>  Modificar Oferta</h1>
				</div>
			 
				
				<div class="content">

					
					<input type="hidden" name="hs" value='<?php echo "$row[idHotsale]" ?>' size="25">

					
					<label for="ubicacion">Precio: </br></label>
					<input type="text" name="nuevoPrecio" class="input username" value='<?php echo "$row[precio]" ?>'>
					
                    
					
					
			</div>
				<div class="footer">
					<input type="submit" name="login" value="GUARDAR" class="button" />
				</div>

			</form>
			
		</div>
	</body>
</html>