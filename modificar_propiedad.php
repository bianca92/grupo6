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
$Propiedad=$_GET['no'];


$var_consulta= "SELECT * FROM propiedad WHERE idPropiedad='$Propiedad' ";
$var_resultado = $link->query($var_consulta);
$row = mysqli_fetch_array($var_resultado);


?>
	<title>Propiedades</title>
	
	</head>
	<body>
		
		<div id="wrapper" style="margin-top: 0px">

			<form name="formulario" action="modificar_propiedad2.php" method="POST" class="login-form" enctype="multipart/form-data" onsubmit="return validareg();">
				
				<div class="header">
					<h1>  Modificar</h1>
				</div>
			 
				
				<div class="content">

					
					<input type="hidden" name="propiedad" value='<?php echo "$row[idPropiedad]" ?>' size="25">

					<label for="titulo">Titulo: </br></label>
					<input type="text" name="titulo" class="input username" value='<?php echo "$row[titulo]" ?>' size="25">

					
                    <label for="ubicacion">Pais: </br></label>
					<input type="text" name="pais" class="input username" value='<?php echo "$row[pais]" ?>'>
					<label for="ubicacion">Provincia: </br></label>
					<input type="text" name="provincia" class="input username" value='<?php echo "$row[provincia]" ?>'>
					<label for="ubicacion">Localidad: </br></label>
					<input type="text" name="localidad" class="input username" value='<?php echo "$row[localidad]" ?>'>
					<label for="ubicacion">Direccion: </br></label>
					<input type="text" name="direccion" class="input username" value='<?php echo "$row[direccion]" ?>'>

					
					<label for="descripcion">Descripcion: </br></la'<?php echo "$row[descripcion]" ?>'bel></br>
					<textarea id="area" name="descripcion"  rows="4" cols="25"><?php echo "$row[descripcion]" ?></textarea></br>
					
					
					<label for="imagen">Imagen: </br></label>
					<input type="file" class="form-control" id="imagen[]" name="imagen[]" multiple="" accept="image/*" upload_max_filesize = 2M post_max_size =2M >
                    
					
					
			</div>
				<div class="footer">
					<input type="submit" name="login" value="GUARDAR" class="button" />
				</div>

			</form>
			
		</div>
	</body>
</html>