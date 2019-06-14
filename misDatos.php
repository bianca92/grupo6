<html>
 <head>
   <style type="text/css">
    .botoncito{
      
      padding: 6px;
      font-weight: 350;
      font-size: 12px;
      color: #ffffff;
      background-color: #1883ba;
      border-radius: 6px;
      
  }
  .botoncito:hover{
    color: #1883ba;
    background-color: #ffffff;
  }
</style>
<style type="text/css">
    .elBoton{
      
      padding: 6px;
      font-weight: 350;
      font-size: 12px;
      color: #ffffff;
      background-color: #F0AD4E;
      border-radius: 6px;
      
  }
  .elBoton:hover{
    color: #F79D1D;
    background-color: #CBE9F8;
  }
</style>
</style>
<style type="text/css">
    .texto{
      
      padding: 20px;
      font-weight: 350;
      font-size: 14px;
      color: #000000;
      background-color: #CBE9F8;
      
      
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
$query = "SELECT * FROM persona p INNER JOIN  tarjeta t ON p.IdPersona = t.idPersona WHERE p.IdPersona = '$id' ";
            $result = mysqli_query($con, $query);
            $num=mysqli_num_rows($result); 
            $datosUsuario = mysqli_fetch_array($result);

         
     ?>

  
  

 <h2 align="center">  MIS DATOS</h2>
<br/>
 
 <div class="texto">
 <ul style="list-style-type:none;">
      <b><li>  Nombre:</li></b>
      <ul style="list-style-type:none;">
        <li> <?php echo "    $datosUsuario[nombre]";?> </li>
      </ul>
        <br/>
      <b><li>  Apellido:</li></b>
      <ul style="list-style-type:none;">
        <li> <?php echo "    $datosUsuario[apellido]";?> </li>
      </ul>
        <br/>
      <b><li>  DNI:</li></b>
      <ul style="list-style-type:none;">
        <li> <?php echo "    $datosUsuario[dni]";?> </li>
      </ul>
        <br/>
      <b><li>  Fecha de Nacimiento:</li></b>
      <ul style="list-style-type:none;">
        <li> <?php echo "".date('d/m/Y', strtotime($datosUsuario['fechaNacimiento']))."";?> </li>
      </ul>
        <br/>
      <b><li>  Email:</li></b>
      <ul style="list-style-type:none;">
        <li> <?php echo "    $datosUsuario[email]";?> </li>
      </ul>
        <br/>
      <b><li>  Clave:</li></b>
      <ul style="list-style-type:none;">
        <li> <?php echo "    *********";?> </li>
      </ul>
        <br/>
      <b><li>  Telefono:</li></b>
      <ul style="list-style-type:none;">
        <li> <?php echo "    $datosUsuario[telefono]";?> </li>
      </ul>
        <br/>
      <b><li>  Ciudad:</li></b>
      <ul style="list-style-type:none;">
        <li> <?php echo "    $datosUsuario[ciudad]";?> </li>
      </ul>
        <br/>
      <b><li>  Tarjeta:</li></b>
      <ul style="list-style-type:none;">
        <li> <?php echo "    Marca: $datosUsuario[marca]";?> </li>

        <?php  $ult4 = substr($datosUsuario['numero'],12); ?>
        <li> <?php echo "    Numero: **** **** **** $ult4";?> </li>
      </ul>
        <br/>
      <b><li>  Creditos:</li></b>
      <ul style="list-style-type:none;">
        <li> <?php echo "    Disponibles: $datosUsuario[credito]" ?> </li>
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
                  </ul>
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
   </div>
   <?php echo "  Ultima modificacion de datos: ".date('d/m/Y', strtotime($datosUsuario['fechaModificacion']))."";?><br/>
   <a href="modificarDatosUsuario.php">Editar</a>
 
 

 <?php
 
            mysqli_free_result($result);
            mysqli_close($con);

?> 
   </body>
   </html>