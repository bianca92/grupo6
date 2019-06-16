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
$query = "SELECT * FROM persona p INNER JOIN  tarjeta t ON p.IdPersona = t.idPersona WHERE p.IdPersona = '$id' ";
            $result = mysqli_query($con, $query);
            $num=mysqli_num_rows($result); 
            $datosUsuario = mysqli_fetch_array($result);

         
     ?>

  
  

 <h2 align="center">  MIS DATOS</h2>

<br/>
 
 <form name="formulario" class="login-form" style="width:600px; background-color:#fff;">
 	
 	<li style="text-align: center"> <?php echo "  Ultima modificacion de datos: ".date('d/m/Y-H:i', strtotime($datosUsuario['fechaModificacion']))."";?>
   <a style="font-size:25px; " href="modificarDatosUsuario.php">Editar</a></li>




 <ul style="list-style-type:none;font-size:20px">



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
      <b><li>  Tarjeta:</b>
     
         <?php echo "    Marca: $datosUsuario[marca]";?> </li>

        <?php  $ult4 = substr($datosUsuario['numero'],12); ?>
        <li> <?php echo "    Numero: **** **** **** $ult4";?> </li>
      
        <br/>
      <b><li>  Creditos:</b>
     
         <?php echo "    Disponibles: $datosUsuario[credito]" ?> </li>
              <?php

              // SI TIENE CREDITOS QUE MUESTRE CUANDO SE VENCEN (FORMATO MES/ANIO) 
                    if ($datosUsuario['credito']!=0){
                      ?>
                     <li> <?php 
                      $nueva= date('Y');
                       $nueva= $nueva+1;
                     echo "Vencimiento: 1/$nueva"; ?> </li>
                     <?php 
                    } ?>
                
                    <br/>
                    <?php
          //SI NO ES PREMIUM QUE LE MUESTRE EL BOTON PARA HACERSE
      if($datosUsuario['tipoU']!="premium"){ 
         $pp="solicitarPremium.php";   ?>
       <a class="elBoton" href=<?php echo "  ".$pp; ?>>¡QUIERO SER PREMIUM!</a><br/>
        <?php

      } 
      else{ echo "YA SOS PREMIUM !!";}
      
       ?> 

 </ul>
  
  
 
  </form>

 <?php
 
            mysqli_free_result($result);
            mysqli_close($con);

?> 
   </body>
   </html>