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


$query = "SELECT * FROM propiedad";
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
        <th>Titulo</th>
        <th>Pais</th>
        <th>Provincia</th>
        <th>Localidad</th>
      </tr>
    </thead>
    <tbody>
      <?php  if ($num==0) {
                  echo"<h4>NO SE HAN ENCONTRADO RESULTADOS</h4>"; } ?>
 
    <?php while ($row = mysqli_fetch_array($result))  { 
      $imgs=ObtenerImgs($row['idPropiedad']); ?>
      <tr>
            <td><?php echo '<img src="data:image/jpeg;base64,'.base64_encode($imgs[0]).'" style=width:20% />';?></td>
            <td><h4><?php echo "$row[titulo]" ?></h4> </td>
             <td><h4><?php echo" $row[pais] ";?></h4></td>
              <td><h4><?php echo" $row[provincia] ";?></h4></td>
            <td><h4><?php echo" $row[localidad] ";?></h4></td>
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