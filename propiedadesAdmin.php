<html>


<?php

include("clases.php");  
include("cabecera.php");
include("conexion.php");
include("mostrarImagen.php");
$con=conectar();

	if(isset($_GET['msj'])){
  		 $mensaje= $_GET['msj'];
//

   	if($mensaje="2")
  		 echo"<script> alert ('DEBE ESTAR REGISTRADO PARA ACCEDER')</script>"; 
  	}


$query = "SELECT idPropiedad,titulo,ciudad FROM propiedad";
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
  

    <?php while ($row = mysqli_fetch_array($result))  { ?>
  
      <tr>
          <td> <?php $imgs=ObtenerImgs($row['idPropiedad']);
            for($i = 0; $i < count($imgs); $i++){
            echo '<img src="data:image/jpeg;base64,'.base64_encode($imgs[$i]).'" width=50 height=50 />';
           }
          ?>

          </td>
          
           <td><h4><?php echo "$row[titulo]" ?></h4> </td>
            <td><h4><?php echo" $row[ciudad] ";?></h4></td>
            <td><?php echo "<a href='modificar_propiedad.php?no=".$row[0]."'> <button type='button' class='btn btn-succes'>Modificar</button> </a>" ;?></td>
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