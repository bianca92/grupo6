
<html>


<?php

include("clases.php");  
  
include("conexion.php");
$con=conectar();

  if(isset($_GET['msj'])){
       $mensaje= $_GET['msj'];
//

    if($mensaje="2")
       echo"<script> alert ('DEBE ESTAR REGISTRADO PARA ACCEDER')</script>"; 
    }


$query = "SELECT idPropiedad,titulo,ciudad,imagen,tipoimagen FROM propiedad";
            $result = mysqli_query($con, $query);
                   $num=mysqli_num_rows($result); 
     ?>

  <div class="container">
   
 
 <?php
   
  for($x = 1; $x <=($num/3) ; $x++){
        

  ?>
  <div class="row">

    <?php for($i= 1; $i<= 3; $i++){
             $row = mysqli_fetch_array($result); ?>
      <div class="col-sm-4">
     
        <div class="thumbnail">
        
           <?php echo "<img src=mostrarImagen.php?idPropiedad=".$row['idPropiedad']  ;?> alt=propiedad style=width:100%; >
          <div class="caption">
            <h4><?php echo "$row[titulo] en la ciudad de: $row[ciudad] ";?></h4>
            <p><a href='modificar_propiedad.php?no=".$row[0]."'> <button type='button' class='btn btn-succes'>Modificar</button> </a></p>
          </div>
       </div>
      </div>
     <?php } ?>
    
    </div>

<?php } ?>
 </div>

 <?php
 
            mysqli_free_result($result);
            mysqli_close($con);

?> 
   
   </html>