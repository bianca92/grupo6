<html>
<?php
if(isset($_GET['msj'])){
   $mensaje= $_GET['msj'];
//
   if($mensaje="1")
   echo"<script> alert ('USUARIO O CONTRASEÑA INVALIDA')</script>"; 
}?>
<head>
<?PHP
include("clases.php");
 include("cabecera.php"); 
try{
$login = new Login;
$OK=$login->autorizar();
header("Location:index.php");
}
catch( Exception $e){
   $mensaje= $e->getMessage();

}?>  
<script type="text/javascript" src="js/registrar.js"></script>

	<title> Ingresar a mi cuenta </title>
</head>
<body id="ingresar">
<div class="wrapper">
      
      
      <div id="wrapper">
         
      	<form name="formulario2" action="validarlogin.php" class="login-form" method="post" onsubmit="return validarusu();" >
         
			<div class="header">
               <h1>Ingresar a Mi cuenta</h1>
            </div>
		 
		 <div class="content">
      		<label for="usuario">Usuario:</label>
      		<input type="email" name="usuario" class="input username"  required="required" size=25></br></br>
      		<label for="clave">Contraseña:</label>
      		<input type="password" class="input password" name="clave" minlength="6" maxlength="20" required="required" size=20></br>
		       <p><a href="recuperarClave.php">Olvidé mi clave</a></p>
            
            </div>
            <div class="footer">
               <input type="submit" name="Ingresar" value="Ingresar" class="button" />
               
            </div>
            
         </form>
          <p>¿Todavía no tenés cuenta? <a href="registrar.php">¡Registrarme!</a></p>
      </div>      

</body>
</html>