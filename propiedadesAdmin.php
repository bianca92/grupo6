<html>


<?php

include("clases.php");  
include("cabecera.php");
include("conexion.php");
include("mostrarImagen.php");
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


$query = "SELECT idPropiedad,titulo,ciudad,imagen,tipoimagen FROM propiedad";
            $result = mysqli_query($con, $query);
            $num=mysqli_num_rows($result); 
     ?>

  <div class="container">

    <a href="propiedades.php" class="btn btn-warning" float="left">NUEVO</a>
   
 <?php
   

?>
  <div>
    <table class="table table-hover">
    <thead>
      <tr>
        <th>Propiedad</th>
        <th></th>
        <th>ciudad</th>
      </tr>
    </thead>
    <tbody>
  

    <?php while ($row = mysqli_fetch_array($result))  { 
      $imgs=ObtenerImgs($row['idPropiedad']); ?>
      <tr>
            <td><?php echo '<img src="data:image/jpeg;base64,'.base64_encode($imgs[0]).'" style=width:20% />';?></td>
            <td><h4><?php echo "$row[titulo]" ?></h4> </td>
            <td><h4><?php echo" $row[ciudad] ";?></h4></td>
            <td><?php echo "<a href='modificar_propiedad.php?no=".$row[0]."'> <button type='button' class='btn btn-succes'>MODIFICAR</button> </a>" ;?></td>
            <td><?php echo "<a href='alta_subasta.php?no=".$row[0]."'> <button type='button' class='btn btn-succes'>SUBASTAR</button> </a>" ;?></td>
         </tr>  
         <?php } ?>      
      
      </tbody>
  </table>
</div>
     

 </div>

 <?php
 
            mysqli_free_result($result);
            mysqli_close($con);

?> 
   
   </html>