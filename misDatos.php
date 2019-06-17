<html>

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

 
 <form name="formulario" class="login-form" style="width:600px; background-color:#fff;float:left;margin-left: 30px;"><h2 align="center">  MIS DATOS</h2> <h4 align="center">
 	<?php
          //SI NO ES PREMIUM QUE LE MUESTRE EL BOTON PARA HACERSE
      if($datosUsuario['tipoU']!="premium"){ 
         $pp="solicitarPremium.php";   ?>
       <a class="elBoton" href=<?php echo "  ".$pp; ?>>¡QUIERO SER PREMIUM!</a><br/>
        <?php

      } 
      else{ echo "YA SOS PREMIUM !!";}
      
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



 
 

       
  <form name="formulario" class="login-form" style="width:600px; background-color:#fff;float:right;margin-right: 25px;"> <h2 align="center">  FORMA DE PAGO</h2>
    
    <ul style="list-style-type:none;font-size:20px">
      <b><li>  Tarjeta:</b></br>
     
         <?php echo "    Marca: $datosTarjeta[marca]";?> </li>

        <?php  $ult4 = substr($datosTarjeta['numero'],12); ?>
        <li> <?php echo "    Numero: **** **** **** $ult4";?> </li>
        <li> <?php echo "    Titular: $datosTarjeta[titular]";?> </li>
      
         <li><?php echo "    Vencimiento: $datosTarjeta[vencimiento]";?> </li>
                    

 
  </ul>
  
  <h3 align="center" style="font-size: 15px; color: #2AA6CF"><?php echo "<a style='color: #2AA6CF'  href='modificarFormaDePago.php?idT=".$datosUsuario['idTarjeta']."'>Editar </a>";?></h3>
  
 
  </form>


 <?php
 
            mysqli_free_result($result);
            mysqli_close($con);

?> 
   </body>
   </html>