<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 5 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<?php
	session_start();
?>

<html lang="es">
<head>
       <title> Home switch Home </title> 

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>


    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8"/>
	<style type="text/css"></style>
	<link rel="stylesheet" type="text/css" href="css/estilos.css">

</head>	


<body>
	<div id="header">
        
		<?php
			if(isset($_SESSION['estado'])){
      	  		 if($_SESSION['estado']=="logeado"){

                        if($_SESSION['rol']=="1"){
                        	echo"<h3><a href=index.php><span class= 'glyphicon glyphicon-home'</span></a> | 
      	           	             HOLA ADMINISTRADOR ".$_SESSION['nombre']." ! | <a href=salir.php><span class='glyphicon glyphicon-log-out'></span>CERRAR SESIÓN</a></h3>";

        
                        }
                        else{

						
				      echo"
							<h3><a href=index.php><span class= 'glyphicon glyphicon-home'</span></a> | 
	      	           	     HOLA ".$_SESSION['nombre']." ! | <a href=salir.php><span class='glyphicon glyphicon-log-out'></span>CERRAR SESIÓN</a></h3>";
	    
			                }
		            }
	            }
			    else{ 
			    	echo"<h3><a href=index.php><span class= 'glyphicon glyphicon-home'</span></a> | <a href=ingresar.php><span class='glyphicon glyphicon-log-in'></span> INGRESAR</a> |<a href=registrar.php><span class='glyphicon glyphicon-user'></span> REGISTRARSE</a></h3>";}

            ?>
       
         <img id="logoinicio" src="imgs/HSH-Complete.svg">
  
	</div>
	<?php Include("menu.php"); ?>
<script src="js/jquery.js"></script>
	  <script src="js/bootstrap.min.js"></script>
	  <script src="js/bootstrapValidator.min.js"></script>



</body>

</html>
