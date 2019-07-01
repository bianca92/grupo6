<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
<style>
/* Popup container - can be anything you want */
.popup2 {
  position: relative;
  display: inline-block;
  cursor: pointer;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* The actual popup */
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

/* Popup arrow */
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

/* Toggle this class - hide and show the popup */
.popup2 .show2 {
  visibility: visible;
  -webkit-animation: fadeIn 1s;
  animation: fadeIn 1s;
}

/* Add animation (fade in the popup) */
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

<?php

include("clases.php");  
include("cabecera.php");
include("conexion.php");

$con=conectar();

//para que no se pueda acceder a esta pagina si no esta logeado
try{
$login= new Login();
$login->autorizar();
}
catch(Exception $e){
   echo $e->getMessage();
   header("Location:index.php");
}

$id=($_SESSION['id']);

//OBTENGO LOS DATOS DEL USUARIO ACTUAL
$query = "SELECT * FROM persona WHERE IdPersona = '$id' ";
            $result = mysqli_query($con, $query);
            $num=mysqli_num_rows($result); 
            $datosUsuario = mysqli_fetch_array($result);

//OBTENGO LOS DATOS DE LA TARJETA DEL USUARIO ACTUAL
$query = "SELECT * FROM tarjeta  WHERE idTarjeta ='$datosUsuario[idTarjeta]' ";
            $result = mysqli_query($con, $query);
            $num=mysqli_num_rows($result); 
            $datosTarjeta = mysqli_fetch_array($result);





         
     ?>

  
  

 

<br/>

<?php //------------------------------------------- FORMULARIO MIS DATOS -------------------------------------------------------------------?>


 
 <form name="formulario" class="login-form" style="width:600px; background-color:#fff;float:left;margin-left: 30px;"><h2 align="center">  MIS DATOS</h2> <h4 align="center">
 	<?php
          
      if($datosUsuario['tipoU']!="premium"){ //-------------------------------------------------------- ES CLASICO--------------

        //BUSCA SI MANDO SOLICITUD PARA SR PREMIUM

        $queryInscripto = "SELECT * FROM enesperapremium  WHERE idPersona ='$id' ";
        $resultInscripto = mysqli_query($con, $queryInscripto);
        $numInscripto=mysqli_num_rows($resultInscripto); 

        if($numInscripto!=1){ //------------------------------------------------------------------ NO MANDO SOLICITUD PARA PREMIUM ------
        ?>
          <div class="popup2" onclick="myFunction2()" onmouseover="this.style.cssText='color:#0A88C0'" onmouseout="this.style.cssText='color:#000000'"> ¡QUIERO SER PREMIUM!
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
              <?php echo"<a href=solicitarPremium.php > ¡SER PREMIUM!</a>";?>

                </h6>  
              </ul></span>
          </div>   <?php     
        }
        else{echo "SOLICITUD ALTA PREMIUM ENVIADA";} //------------------------------------------------------- MANDO SOLICITUD PARA PREMIUM ------
        
      } 
      else{ //-------------------------------------------------------------------------------------- ES PREMIUM ---------------

        //BUSCA SI´PIDIO SER CLASICO
        $queryInscripto = "SELECT * FROM esperaclasico WHERE idPersona ='$id' ";
        $resultInscripto = mysqli_query($con, $queryInscripto);
        $numInscripto=mysqli_num_rows($resultInscripto); 

        if($numInscripto!=1){//----------------------------------------------------------------- NO MANDO SOLICITUD PARA CLASICO --- ?>
              <ul class="menu" >
            <li><a href=# onmouseover="this.style.cssText='color:#0A88C0'" onmouseout="this.style.cssText='color:#000000'" > YA SOS PREMIUM !! </a>
             <ul class="submenu"style="background-color: #FFFFFF"onmouseover="this.style.cssText='color:#0A88C0';this.style.background-color='color:#FFFFFF'" onmouseout="this.style.cssText='color:#000000'; this.style.background-color='color:#FFFFFF'"> 
                <li><a href=solicitarBajaPremium.php style="background-color: #FFFFFF"onmouseover="this.style.cssText='color:#0A88C0'" onmouseout="this.style.cssText='color:#000000'">Dejar de ser PREMIUM</a></li>
             </ul>
             </li> </ul><?php
        }
        else{echo "SOLICITUD BAJA PREMIUM ENVIADA";}//----------------------------------------------------- MANDO SOLICITUD PARA CLASICO----
      }
      
       ?> </h4>
 	




 <ul style="list-style-type:none;font-size:20px;">



      <b><li>  Nombre:</b>
      
         <?php echo "    $datosUsuario[nombre]";?> </li>

        <br/>
      <b><li>  Apellido:</b>
      
         <?php echo "    $datosUsuario[apellido]";?> </li>
     
        <br/>
      <b><li>  DNI:</b>
      
         <?php echo "    $datosUsuario[dni]";?> </li>
   
        <br/>
      <b><li>  Fecha de Nacimiento:</b>
     
         <?php echo "".date('d/m/Y', strtotime($datosUsuario['fechaNacimiento']))."";?> </li>
   
        <br/>
      <b><li>  Email:</b>
      
         <?php echo "    $datosUsuario[email]";?> </li>
      
        <br/>
      <b><li>  Clave:</b>
     
         <?php echo "    *********";?> </li>
      
        <br/>
      <b><li>  Telefono:</b>
     
         <?php echo "    $datosUsuario[telefono]";?> </li>
      
        <br/>
      <b><li>  Ciudad:</b>
      
         <?php echo "    $datosUsuario[ciudad]";?> </li>
      
        <br/>
      <b><li>  Creditos</b>
     
         <?php echo "  : $datosUsuario[credito]" ?>
              <?php

              // SI TIENE CREDITOS QUE MUESTRE CUANDO SE VENCEN (FORMATO MES/ANIO) 
                    if ($datosUsuario['credito']!=0){
                      ?>
                      <?php 
                      $nueva= date('Y');
                       $nueva= $nueva+1;
                     echo "- Vencimiento: 1/$nueva"; ?> </li>
                     <?php 
                    } ?>
                
                    <br/>
</ul>
<li style="text-align: center; font-size: 10px"> <?php echo "  Ultima modificacion de datos: ".date('d/m/Y-H:i', strtotime($datosUsuario['fechaModificacion']))."";?>
   <a style="font-size:15px; color: #2AA6CF " href="modificarDatosUsuario.php">Editar</a></li>
 </form>



 

<?php // -----------------------------------------------   FORMULARIO FORMA DE PAGO  --------------------------------------------------------- ?>


 

       
  <form name="formulario" class="login-form" style="width:600px; background-color:#fff;float:right;margin-right: 25px;"> <h2 align="center">  FORMA DE PAGO</h2>
    
    <ul style="list-style-type:none;font-size:20px">
      <b><li>  Tarjeta:</b></br>
     
         <?php echo "    Marca: $datosTarjeta[marca]";?> </li>

        <?php  $ult4 = substr($datosTarjeta['numero'],12); ?>
        <li> <?php echo "    Numero: **** **** **** $ult4";?> </li>
        <li> <?php echo "    Titular: $datosTarjeta[titular]";?> </li>
      
         <li><?php echo "    Vencimiento: $datosTarjeta[vencimiento]";?> </li>
         <br/>
         <li style="color: #2AA6CF"><?php echo "<a style='color: #2AA6CF'  href='historialDePago.php?id=".$id."'>Ver historial de pago </a>";?></li>  

 
  </ul>

  
  <h3 align="center" style="font-size: 15px; color: #2AA6CF"><?php echo "<a style='color: #2AA6CF'  href='modificarFormaDePago.php?idT=".$datosUsuario['idTarjeta']."'>Editar </a>";?></h3>
  
 
  </form>


 <?php
 
            mysqli_free_result($result);
            mysqli_close($con);

?> 
 <script>
      // When the user clicks on div, open the popup
      function myFunction2() {
          var popup2 = document.getElementById("myPopup2");
          popup2.classList.toggle("show2");
      }
    </script>
   </body>
   </html>