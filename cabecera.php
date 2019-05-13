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

	<?php   $archivop=""; $archivosu="";
             if(isset($_SESSION['estado'])){
      	  		 if($_SESSION['estado']=="logeado"){

                        if($_SESSION['rol']=="1"){
                        	//echo"<h3><a href=index.php><span class= 'glyphicon glyphicon-home'</span></a> | 
      	           	         //    HOLA ADMINISTRADOR ".$_SESSION['nombre']." ! | <a href=salir.php><span class='glyphicon glyphicon-log-out'></span>CERRAR SESIÓN</a></h3>";
      	           	              $opcion1="Hola Administrador! " ; $opcion2="<a href=salir.php><span class='glyphicon glyphicon-log-out'></span>Salir</a>";  
                                  $archivop="propiedadesAdmin.php"; $archivosu="subastasAdmin.php";
        
                        }
                        else{

						
				      //echo" <h3><a href=index.php><span class= 'glyphicon glyphicon-home'</span></a> | 
	      	           	   //  HOLA ".$_SESSION['nombre']." ! | <a href=salir.php><span class='glyphicon glyphicon-log-out'></span>CERRAR SESIÓN</a></h3>";
	                             $opcion1="  Hola ".$_SESSION['nombre']." !  ";  $opcion2="<a href=salir.php><span class='glyphicon glyphicon-log-out'></span>Salir</a>";
	                             $archivop="listarPropiedades.php"; $archivosu="subastasUsuario.php";
			                }
		            }
	            }
			    else{ 
			    	//echo"<h3><a href=index.php><span class= 'glyphicon glyphicon-home'</span></a> | <a href=ingresar.php><span class='glyphicon glyphicon-log-in'></span> INGRESAR</a> |<a href=registrar.php><span class='glyphicon glyphicon-user'></span> REGISTRARSE</a></h3>";}
                        $opcion1="<a href=ingresar.php><span class='glyphicon glyphicon-log-in'></span> INGRESAR</a>"; 
                        $opcion2="<a href=registrar.php><span class='glyphicon glyphicon-user'></span> REGISTRARSE</a>"; 
                    }
            ?>		



<nav class="navbar navbar">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#"><img src="imgs/HSH-Complete.svg" class="img-thumbnail" width="110" height="100" margin-bottom: -60px></a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="index.php"><span class= 'glyphicon glyphicon-home'</span></a></li>
      <li><a href=<?php echo $archivop; ?>>PROPIEDADES</a></li>
      <li><a href=<?php echo "$archivosu"; ?>>SUBASTAS</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><?php echo"$opcion1"; ?></li>
      <li><?php echo"$opcion2";?></li>
    </ul>
  </div>
</nav>





</div>
      <script src="js/jquery.js"></script>
	  <script src="js/bootstrap.min.js"></script>
	  <script src="js/bootstrapValidator.min.js"></script>



</body>


</html>
