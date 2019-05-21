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


$query = "SELECT idPropiedad,titulo,ciudad FROM propiedad";
            $result = mysqli_query($con, $query);
            $num=mysqli_num_rows($result); 
            
     ?>
<?php  if ($num==0) {
                  echo"<h4>NO SE HAN ENCONTRADO RESULTADOS</h4>"; } ?>
  <div class="container">
   
 
 <?php
   
  for($x = 1; $x <=($num/3) ; $x++){
        

  ?>
  <div class="row">

    <?php while ($row = mysqli_fetch_array($result))  { ?>
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

<?php } ?>
 </div>

 <?php
 
            mysqli_free_result($result);
            mysqli_close($con);

?> 
   
   </html>