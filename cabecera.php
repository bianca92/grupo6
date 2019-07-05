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

<meta name="viewport" content="width=device-width, initial-scale=1">
<style>

.popup {
  position: relative;
  display: inline-block;
  cursor: pointer;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}


.popup .popuptext {
  visibility: hidden;
  width: 1000px;
  height: 170px;
  background-color: #A8E0FE;
  color: #000000;
  text-align: justify;
  border-radius: 6px;
  padding: 8px 0;
  position: absolute;
  z-index: 1;
  top: 50px;
  bottom: 125%;
  left: 100%;
  margin-left: -1100px;
}


.popup .popuptext::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: #555 transparent transparent transparent;
}


.popup .show {
  visibility: visible;
  -webkit-animation: fadeIn 1s;
  animation: fadeIn 1s;
}


@-webkit-keyframes fadeIn {
  from {opacity: 0;} 
  to {opacity: 1;}
}

@keyframes fadeIn {
  from {opacity: 0;}
  to {opacity:1 ;}
}

.popup:hover {
  color: #FFFFFF;
}


</style>

<meta name="viewport" content="width=device-width, initial-scale=1">
<style>

.popup2 {
  position: relative;
  display: inline-block;
  cursor: pointer;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

.popup2 .popuptext2 {
  visibility: hidden;
  width: 1000px;
  height: 170px;
  background-color: #A8E0FE;
  color: #000000;
  text-align: justify;
  border-radius: 6px;
  padding: 8px 0;
  position: absolute;
  z-index: 1;
  top: 50px;
  bottom: 125%;
  left: 100%;
  margin-left: -800px;
}


.popup2 .popuptext2::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: #555 transparent transparent transparent;
}


.popup2 .show2 {
  visibility: visible;
  -webkit-animation: fadeIn 1s;
  animation: fadeIn 1s;
}


@-webkit-keyframes fadeIn {
  from {opacity: 0;} 
  to {opacity: 1;}
}

@keyframes fadeIn {
  from {opacity: 0;}
  to {opacity:1 ;}
}

.popup2:hover {
  color: #FFFFFF;
}


</style>

 


</head>	

<body>
	<div id="header">

	<?php   $archivop=""; $archivosu=""; $archivoActUsu=""; $archivoTerminadas=""; $premium="";$mensajes=""; $verOpcionesLogeado=false; 
             if(isset($_SESSION['estado'])){
      	  		 if($_SESSION['estado']=="logeado"){
                        
                        //ADMINISTRADOR
                        if($_SESSION['rol']=="1"){
                        	
      	           	             $opcion1="<a href'#'><span class'glyphicon-user'></span>Hola Administrador!</a>";
                                  $opcion2="<a href=salir.php><span class='glyphicon glyphicon-log-out'></span>SALIR</a>";  
                                  $archivop="propiedadesAdmin.php"; $archivosu="subastasAdmin.php"; $archivoActUsu="subastasActivasAdministrador2.php"; $archivoTerminadas="subastasTerminadasAdministrador2.php";
                                  $verOpcionesLogeado=true;
                                  $mensajes="mensajes.php";
                        }
                      else {
                      // USUARIO REGISTRADO
						
	                             $opcion1="<a href'#'><span class'glyphicon-user'></span>Hola $_SESSION[nombre] !</a>" ;  
                               $opcion2="<a href=salir.php><span class='glyphicon glyphicon-log-out'></span>SALIR</a>";
	                             $archivop="listarPropiedades.php"; $archivosu="subastasUsuario.php"; $archivoActUsu="subastasActivasUsuario4.php"; $archivoTerminadas="subastasTerminadasUsuario.php"; 
                               $premium="solicitarPremium.php";
                               $mensajes="mensajes.php";
			                         $verOpcionesLogeado=true;
                      }
		            }
	            }
			    else{ // NO LOGUEADO

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
      <li><a href=#><i class="fas fa-gavel"></i>SUBASTAS</a>
       <ul class="submenu">
             <li><a href=<?php echo "$archivosu"; ?>>SUBASTAS NO COMENZADAS</a></li>
             <li><a href=<?php echo $archivoActUsu; ?>>SUBASTAS ACTIVAS</a></li>
              <li><a href=<?php echo $archivoTerminadas; ?>>SUBASTAS TERMINADAS</a></li>
          </ul>
      </li>
      <?php
      if($_SESSION['rol']=="1"){  // SI ES ADMINISTRADOR QUE MUESTRE SIEMPRE EL HOT SALE ?>

          <li><a href=# style="background-color: #FF7516">HOT SALE</a>
           <ul class="submenu" style="background-color: #FF7516">
             <li><a href="configuracionHotSale.php">CONFIGURAR FECHA DEL HOT SALE</a></li>
             <li><a href="listaEsperaHotSale.php">LISTA DE ESPERA PARA HOT SALE</a></li>
             <li><a href="listaHotSale.php">SUBASTAS EN HOT SALE</a></li>
          </ul>
         </li>    <?php
      }
      else{ // ES USUARIO, que le muestre si esta en fecha EL HOT SALE  --------------------------------------------------------------------


      }
      ?>
     
     </ul>

  
   <?php  }
    
     ?>
     <ul class="menu" style="float:right">
      <?php // Mostra solo si es usurio clasico

// ES CLASICO  
    if($verOpcionesLogeado==true and $_SESSION['tipoU']=="clasico"){                                   ?>
       
       <?php  //me fijo si el usuario no tiene una solicitud pendiente
           $var_consulta="SELECT idPersona FROM enesperapremium
                     WHERE idPersona='".$_SESSION['id']."'";
           $var_resultado = mysqli_query(mysqli_connect('localhost','root','','grupo6'),$var_consulta);
           $num=mysqli_num_rows($var_resultado);  
           if ($num==0){  //NO MANDO SOLICITUD PARA PREMIUM 

           		 $sql = "SELECT * FROM config_cuota WHERE idTipoUsuario='2'";
 				 $res = mysqli_query(mysqli_connect('localhost','root','','grupo6'),$sql);
 				 $montoPremium = mysqli_fetch_array($res);

				 // BOTON QUIERO SER PREMIUM CON POPUP        ?>
              	<div class="popup2" onclick="myFunction2()"> ¡QUIERO SER PREMIUM!
              	<span class="popuptext2" id="myPopup2"><ul  style="list-style-type:disc;" >
      			<h6><li>Como usuario premium podra comprar de forma directa semanas que se vayan a subastar sin la necesidad de pujar.</li>
        		<li>Los usuarios premium cuentan con dos creditos anuales, como el usuario clasico. Estos creditos representan una semana al año cada uno, por lo que se descontara un credito</li> al ganar una subasta y un credito al realizar una compra directa.<br/>
        		<li>Como usuario premium los creditos se pueden usar de cualquiera de las siguientes combinaciones:</li>
          		<ul style="list-style-type: disc;">
            		<li>Los dos en dos subastas.</li>
            		<li>Los dos en compras directas.</li>
            		<li>Uno en compra directa y otro en subasta.</li>
          		</ul>
        		<li>Los usuarios premium podran dar de baja este beneficio y volver a ser usuarios clasicos en cualquier momento.</li>
        		<li>El costo de ser usuario premium es de $ <?php echo "$montoPremium[monto]" ?> por mes.</li>
      			</br>
     			 <?php echo"<a href=solicitarPremium.php> ¡SER PREMIUM!</a>";?>
      			</h6>  
      			</ul></span>
				</div>                
           <?php } 
           else{ // MANDO SOLICITUD PARA PREMIUM    ?>
                <li><a href=#>SOLICITUD ENVIADA</a></li>
     		<?php  }
    }
    if($verOpcionesLogeado==true and $_SESSION['tipoU']=="premium"){ // USUARIO PREMIUM       ?>
          
          	 <li><a href=# > </i>ERES PREMIUM </a>
             <ul class="submenu"> 
                <li><a href=solicitarBajaPremium.php>Dejar de ser PREMIUM</a></li>
             </ul>
             </li> <?php
           
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
                     <li><a href=misDatos.php><i class="fas fa-user-alt"></i>  MIS DATOS</a></li>
                     <li><a href=actividadUsuario.php><i class="fas fa-mouse-pointer"></i>  MI ACTIVIDAD</a></li>
               </ul>
            </li>

        <?php
        }  else{ //menu del administrador?>     
                 
               <li><a href=# > <i class="fas fa-cogs"></i>     <i class="fas fa-bars"></i></a>
                <ul class="submenu"> 
                    <li><a href=configuracionCuotaMensual.php>CONFIG.CUOTA MENSUAL</a></li>
                     <li><a href=ListarTodosLosUsuarios.php>LISTA DE USUARIOS</a></li>
                     <li><a href="verListaEspera.php">LISTA DE ESPERA PARA PREMIUM</a></li>
                     
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

  $sql = "SELECT * FROM config_cuota WHERE idTipoUsuario='1'";
  $res = mysqli_query(mysqli_connect('localhost','root','','grupo6'),$sql);
  $montoClasico = mysqli_fetch_array($res);


  

     ?>
  
      <li><?php echo"$opcion1"; ?></li> 
<div class="popup" onclick="myFunction()"><p class='glyphicon glyphicon-user'> </p> REGISTRARSE
  <span class="popuptext" id="myPopup"><ul  style="list-style-type:disc;" >
      <h6><li>Como usuario registrado poseera dos creditos anuales, los cuales representan una semana al año cada uno.</li>
        <li>Podra comprar semanas en cualquiera de las distintas propiedades que se encuentran disponibles en el sitio.</li>
        <li>La venta de semanas es mediante subastas, en las cuales debera inscribirse para poder pujar y si realiza la puja mas alta al cierre de la misma se le otorgara la semana subastada.</li>
        <li>La semana ganada se podra abonar con la tarjeta registrada o con cualquier otra tarjeta. El valor de la misma es el ultimo monto pujado.</li>
        <li>Cada semana ganada mediante subasta equivale a un credito, por lo que podra comprar mediante subasta solo dos semanas al año.</li>
        <li>Como usuario registrado podra acceder al servicio premium, el cual le dara el beneficio de comprar semanas que se vayan a subastar de forma directa sin la necesidad de pujar. </li>
        <li>Este sitio esta adherido al Hot Sale, por lo que habran semanas en distintas propiedades disponibles para ser adquiridas mediante compra directa en momento de Hot Sale.</li>
        <li>Las compras en Hot Sale no descuentan creditos.</li>
        <li>El costo de ser usuario clasico es de $ <?php echo "$montoClasico[monto]" ?> por mes.</li>
      </br>
      <?php echo"$opcion2";?>

      </h6>  
      </ul></span>
</div>
       
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
    <script>
      // When the user clicks on div, open the popup
      function myFunction() {
          var popup = document.getElementById("myPopup");
          popup.classList.toggle("show");
      }
    </script>
        <script>
      // When the user clicks on div, open the popup
      function myFunction2() {
          var popup2 = document.getElementById("myPopup2");
          popup2.classList.toggle("show2");
      }
    </script>



</body>
</html>
