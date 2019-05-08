<html>
	<head>
		<script type="text/javascript" src="js/registrar.js"></script>
<?php
		include("cabecera.php");
		include("clases.php");
		try{
			$login = new Login;
			$OK=$login->autorizar();
			header("Location:index.php");
		}
		catch( Exception $e){
			$mensaje= $e->getMessage();
		}
?>
	<title>Registrarme</title>
	
	</head>
	<body>
		
		<div id="wrapper">

			<form name="formulario" action="registrarusuario.php" method="POST" class="login-form" enctype="multipart/form-data" onsubmit="return validareg();">
				
				<div class="header">
					<h1>  Registrarse</h1>
				</div>
			 
				
				<div class="content">
					<label for="nombre">Nombre: </br></label>
					<input type="text" name="nombre" class="input username" size="25"  pattern="[a-zA-Z]{2,20}" title="Ingrese sólo letras, al menos dos." id="valNom">
					
					<label for="apellido">Apellido: </br></label>
					<input type="text" name="apellido" class="input username" size="25" required="required" pattern="[a-zA-Z]{2,20}" title="Ingrese sólo letras, al menos dos." id="valNom">
					
					<label for="telefono">Telefono: </br></label>
					<input type="tel"  name="telefono" class="input" required="required" pattern="[0-9*/+() -]{6,50}" title="Ingrese al menos 6 dígitos. Puede usar '/' o '-' o espacio para separarlos. Puede usar '( )' para el código de área" placeholder="Ej: (0221) 4789-1256 / (011) 4567 5234" id="valTel">
					
					
					<label for="dni">DNI: </br></label>
					<input type="text" name="dni" class="input username" maxlength="8" required="required">
					
					<label for="ciudad">Ciudad: </br></label>
					<input type="text" name="ciudad" class="input username" required="required">
					
					<label for="email">Email: </br></label>
					<input type="email" name="email" class="input username" size=30 required="required">
					
					<label for="password">Contraseña: </br></label>
					<input type="password" name="password1" size=20 minlength="6" maxlength="20" class="input password" required="required">
					
					<label for="password" >Confirme contraseña: </br></label>
					<input type="password" name="password2" minlength="6" size="20" maxlength="20" class="input password" required="required">	
					
					
				</div>
				<div class="footer">
					<input type="submit" name="login" value="Registrarme" class="button" />
				</div>
			</form>
			
		</div>
	</body>
</html>