<html>
	<head>
		
<?php
		include("cabecera.php");
		include("clases.php");
		include("conexion.php");
		
?>
	<title>Propiedades</title>
	
	</head>
	<body>
		
		<div id="wrapper">

			<form name="formulario" action="altapropiedad.php" method="POST" class="login-form" enctype="multipart/form-data" onsubmit="return validareg();">
				
				<div class="header">
					<h1>  Propiedades</h1>
				</div>
			 
				
				<div class="content">
					<label for="titulo">Titulo: </br></label>
					<input type="text" name="titulo" class="input username" size="25"  pattern="{2,20}">

					<label for="ubicacion">Ciudad: </br></label>
					<input type="text" name="ubicacion" class="input username" required="required">
					
					<label for="descripcion">Descripcion: </br></label>
					 <textarea name="descripcion" rows="4" cols="50"></textarea></br></br>
					
					
					<label for="imagen">Imagen: </br></label>
					<input type="file" class="form-control" id="imagen[]" name="imagen[]" multiple="" accept="image/*" required="required" >
					
					
					
				</div>
				<div class="footer">
					<input type="submit" name="login" value="Dar de alta propiedad" class="button" />
				</div>
			</form>
			
		</div>
	</body>
</html>