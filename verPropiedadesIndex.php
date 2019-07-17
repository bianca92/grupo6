
<html>


<?php

include("clases.php");  
  include("mostrarImagen.php");
include("conexion.php");
include("actualizarHotSale.php");
$con=conectar();

  if(isset($_GET['msj'])){
       $mensaje= $_GET['msj'];
//

    if($mensaje="2")
       echo"<script> alert ('DEBE ESTAR REGISTRADO PARA ACCEDER')</script>"; 
    }


$query = "SELECT idPropiedad,titulo,localidad, eliminada FROM propiedad WHERE eliminada != 1";
            $result = mysqli_query($con, $query);
                   $num=mysqli_num_rows($result); 
     ?>

  <div class="container-fluid" style="margin:10px; padding-right:10px" >
   <?php // MOSTRAR HOTSALE SI ES LA TEMPORADA
   $fecha_actual=date('Y-m-d');
        //fecha de hotsale
         $consultaHotSale="SELECT * FROM config_hotsale";
         $resHotsale =  mysqli_query(mysqli_connect('localhost','root','','grupo6'),$consultaHotSale); 
         $rowH=mysqli_fetch_array($resHotsale);

          $dias=$rowH['duracion'];
          $fechaHotsale=$rowH['fecha'];
          //$fechaHotsale= strtotime ( 'd-m-Y' , strtotime ( $rowH['fechah'] ) ) ;
           
         
           
          $nuevafecha = strtotime ( '+'.$dias.'day' , strtotime ( $rowH['fecha'] )) ; 
          $nuevafecha = date ( 'd/m/Y' , $nuevafecha ); 
          //$finHotsale = date ( 'Y-m-d' , $nuevafecha ); 

           if (($fecha_actual>=$fechaHotsale)&&($fecha_actual<=$nuevafecha)) { 
             
             include('verHotsale.php');
           }

     
    while ($row = mysqli_fetch_array($result)) {
   
     //for($i= 1; $i<= 3; $i++){
             //$row = mysqli_fetch_array($result);
     ?>
 
      <div class="col-lg-4" style=" padding-right:5px" >
           
        <div class="thumbnail">
        
           <?php $imgs=ObtenerImgs($row['idPropiedad']);
            
            echo '<img src="data:image/jpeg;base64,'.base64_encode($imgs[0]).'" style="width:822px;height:300px;" />';
           
           ?>
         

          <div class="caption">
            <h4><?php echo "$row[titulo] en la localidad de: $row[localidad] ";?></h4>
           
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