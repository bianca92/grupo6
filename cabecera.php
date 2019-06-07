<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 5 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<?php  


	session_start();


?>

<html lang="es">
<head>
       <title> Home switch Home </title> 

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://kit.fontawesome.com/fbb224999c.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>


    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8"/>
	<style type="text/css"></style>
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
 


</head>	

<body>
	<div id="header">

	<?php   $archivop=""; $archivosu=""; $archivoActUsu=""; $archivoTerminadas=""; $premium="";$mensajes=""; $verOpcionesLogeado=false; 
             if(isset($_SESSION['estado'])){
      	  		 if($_SESSION['estado']=="logeado"){
                        
                        //ADMINISTRADOR
                        if($_SESSION['rol']=="1"){
                        	//echo"<h3><a href=index.php><span class= 'glyphicon glyphicon-home'</span></a> | 
      	           	         //    HOLA ADMINISTRADOR ".$_SESSION['nombre']." ! | <a href=salir.php><span class='glyphicon glyphicon-log-out'></span>CERRAR SESIÓN</a></h3>";
      	           	             $opcion1="<a href'#'><span class'glyphicon-user'></span>Hola Administrador!</a>";
                                  $opcion2="<a href=salir.php><span class='glyphicon glyphicon-log-out'></span>SALIR</a>";  
                                  $archivop="propiedadesAdmin.php"; $archivosu="subastasAdmin.php"; $archivoActUsu="subastasActivasAdministrador2.php"; $archivoTerminadas="subastasTerminadasAdministrador2.php";
                                  $verOpcionesLogeado=true;
                                  $mensajes="mensajes.php";
                        }
                      else {
                      // USUARIO REGISTRADO
						
				                  //echo" <h3><a href=index.php><span class= 'glyphicon glyphicon-home'</span></a> | 
	      	           	   //  HOLA ".$_SESSION['nombre']." ! | <a href=salir.php><span class='glyphicon glyphicon-log-out'></span>CERRAR SESIÓN</a></h3>";
	                             $opcion1="<a href'#'><span class'glyphicon-user'></span>Hola $_SESSION[nombre] !</a>" ;  
                               $opcion2="<a href=salir.php><span class='glyphicon glyphicon-log-out'></span>SALIR</a>";
	                             $archivop="listarPropiedades.php"; $archivosu="subastasUsuario.php"; $archivoActUsu="subastasActivasUsuario4.php"; $archivoTerminadas="subastasTerminadasUsuario.php"; 
                               $premium="solicitarPremium.php";
                               $mensajes="mensajes.php";
			                         $verOpcionesLogeado=true;
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
      <a class="navbar-brand" href="index.php"><img src="imgs/HSH-Complete.svg" class="img-thumbnail" width="110" height="100" margin-bottom: -60px></a>
    </div>

    <?php // Mostra solo si esta logueado PROPIEDADES Y SUBASTAS
    if($verOpcionesLogeado==true){   ?>

    <ul class="menu" style="float:left">
      
      <li><a href=<?php echo $archivop; ?>></i>PROPIEDADES</a></li>
      <li><a href=<?php echo "$archivosu"; ?>><i class="fas fa-gavel"></i>SUBASTAS</a>
       <ul class="submenu">
            
             <li><a href=<?php echo $archivoActUsu; ?>>SUBASTAS ACTIVAS</a></li>
      <li><a href=<?php echo $archivoTerminadas; ?>>SUBASTAS TERMINADAS</a></li>
          </ul>
      </li>
     
     </ul>

  
   <?php  }
    
     ?>
     <ul class="menu" style="float:right">
      <?php // Mostra solo si es usurio clasico
    if($verOpcionesLogeado==true and $_SESSION['tipoU']=="clasico"){                                   ?>
       
       <?php  //me fijo si el usuario no tiene una solicitud pendiente
           $var_consulta="SELECT idPersona FROM enesperapremium
                     WHERE idPersona='".$_SESSION['id']."'";
           $var_resultado = mysqli_query(mysqli_connect('localhost','root','','grupo6'),$var_consulta);
           $num=mysqli_num_rows($var_resultado);  
           if ($num==0){?>
                 <li><a href=<?php echo $premium; ?>>¡QUIERO SER PREMIUM!</a></li>
           <?php } 
           else{ ?>
                <li><a href=#>SOLICITUD ENVIADA</a></li>
      <?php  }
    }

     ?>
     <?php // Mostra solo si esta logueado la casilla de mensajes
    if($verOpcionesLogeado==true){ 
      
      $sql = "SELECT * FROM mensaje WHERE idPara='".$_SESSION['id']."' and leido IS NULL";
      $res = mysqli_query(mysqli_connect('localhost','root','','grupo6'),$sql);
      $tot = mysqli_num_rows($res);
                                      ?>
       <li><a href=<?php echo $mensajes; ?>><i class="fas fa-envelope"></i><?php 

       $numero="($tot)";
       $color = "*FF0000";
      // echo "Mensajes"; 
      echo "<font color='".$color."'>".$numero."</font>";

       ?></a></li>
     
      <?php  }
      if($verOpcionesLogeado==true){
        if ($_SESSION['rol']!="1"){//config del usuario?>     
            <li><a href=# ><i class="fas fa-cogs"></i>AJUSTES</a>
                <ul class="submenu"> 
                     <li><a href=misDatos.php><i class="fas fa-user-alt"></i>-MIS DATOS</a></li>
                     <li><a href=<?php ?>><i class="far fa-credit-card"></i>-CONFIG. DE PAGO</a></li>
               </ul>
            </li>
        <?php
        }  else{ //menu del administrador?>        
                    <li><a href=# > <i class="fas fa-bars"></i>     <i class="fas fa-bars"></i></a>
                <ul class="submenu"> 
                     <li><a href=verListaEspera.php><i class="fas fa-ellipsis-v"></i>-VER LISTA EN ESPERA</a></li>
                    
               </ul>
            </li>
            <?php
             }  
        ?>

       <li><?php echo"$opcion1"; ?>   
         <ul class="submenu">
             <li><?php echo"$opcion2";?></li>
         </ul>

       </li>

<?php
      }
        
if($verOpcionesLogeado!=true){
     ?>
  
      <li><?php echo"$opcion1"; ?></li>
      <li><?php echo"$opcion2";?></li>
    </ul>
    <?php
      }
  
    
     ?>
  </div>
</nav>

</div>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrapValidator.min.js"></script>


</body>
</html>
