
<html>


<?php

include("clases.php");  
  include("mostrarImagen.php");
include("conexion.php");
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
   
 
 <?php
 //comtempla la cantidad de propiedades , xq 4, 5 o7 propiedades no se listaban

 //$resto= $num%3; $filas=$num/3;
 //if(($resto)!=0){
   //$filas=$filas+1;}
 
   
  //for($x = 1; $x <= $filas ; $x++){
        

  ?>
  <div class="row">

    <?php 
    while ($row = mysqli_fetch_array($result)) {
   
     //for($i= 1; $i<= 3; $i++){
             //$row = mysqli_fetch_array($result);
     ?>
      <div class="col-sm-4">
           
        <div class="thumbnail">
        
           <?php $imgs=ObtenerImgs($row['idPropiedad']);
            
            echo '<img src="data:image/jpeg;base64,'.base64_encode($imgs[0]).'" style="width:822px;height:300px;" />';
           
           ?>
         

          <div class="caption">
            <h4><?php echo "$row[titulo] en la ciudad de: $row[ciudad] ";?></h4>
           
          </div>
       </div>
      </div>
     <?php } ?>
    
    </div>

<?php// } ?>
 </div>

 <?php
 
            mysqli_free_result($result);
            mysqli_close($con);

?> 
   
   </html>