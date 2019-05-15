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


$query = "SELECT s.idSubasta, p.idPropiedad, p.titulo,p.ciudad FROM subasta s 
INNER JOIN semana se ON s.idSemana= se.idSemana
INNER JOIN semanatienepropiedad sp ON s.idSemana=sp.idSemana
INNER JOIN propiedad p ON sp.idPropiedad=p.idPropiedad";
            $result = mysqli_query($con, $query);
            $num=mysqli_num_rows($result); 


     ?>
     <link  href="css/bootstrap1.min.css">
<div class="container">
   
 
 <?php
   
  for($x = 1; $x <=($num/3) ; $x++){
        

  ?>
  <div class="row">

    <?php 
    $nombre=1;
    while ($row = mysqli_fetch_array($result))  { 

      
  ?>

        <?php
    




       
           
      $consulta3 = "SELECT *
        FROM propiedad
        WHERE idPropiedad= $row[idPropiedad]";
           $result3 = mysqli_query($con, $consulta3);
           $row3 = mysqli_fetch_array($result3);
           

 
       
           ?>  
      <div class="col-sm-4">
     
        <div class="thumbnail">

          <!-- Galeria Carrusel -->
             <div id="<?php echo $nombre; ?>" class="carousel slide" data-ride="carousel">
        
        <!-- contenedor de los slide -->
        
        <div class="carousel-inner" role="listbox">
          
          <?php  $imgs=ObtenerImgs($row3['idPropiedad']);?>
          <!-- Indicadores -->
          <ol class="carousel-indicators">
            <!-- crear primer indicador -->
          <li data-target="#<?php echo $nombre; ?>" data-slide-to="0" class="active" ></li>
           <?php   
            //crear los indicadores para las imagenes
             for($i=1; $i < count($imgs); $i++){ 
              ?>          
                    <li data-target="#<?php echo $nombre; ?>" data-slide-to="<?php echo $i; ?>" ></li>
              
               <?php } ?>      
        </ol>

          <!-- La primera Imagen -->
          <div class="item  active">
            <?php echo '<img src="data:image/jpeg;base64,'.base64_encode($imgs[0]).'" style="width:822px;height:300px;"> '?> 
            <!-- style="width:822px;height:322px;" --> <!-- YA ME QUEDO CLARO POR QUE TODAS LAS IMAGENES MISMO TAMAÑO -->
            <div class="carousel-caption">
              
            </div>
          </div>
          <!-- Las demas imagenes -->
<?php
            for($i = 1; $i < count($imgs); $i++){ ?>
          <div class="item ">
            <?php echo '<img src="data:image/jpeg;base64,'.base64_encode($imgs[$i]).'" style="width:822px;height:300px;">'?>
            <div class="carousel-caption">
             
            </div>
          </div>
        <?php }
          ?>      
        </div>
        <!-- Controles -->
         <div class="caption">
        <a href="#<?php echo $nombre; ?>" class="left carousel-control" role="button" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
          <span class="sr-only">Anterior</span>
        </a>
        <a href="#<?php echo $nombre; ?>" class="right carousel-control" role="button" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
          <span class="sr-only">Siguiente</span>
        </a>
        </div>
      </div>
      <!-- Aca Termina Galeria Carrusel -->
            <h4><?php echo "$row3[titulo] en la ciudad de $row3[ciudad] ";?></h4>
            <h4><?php echo "$row3[descripcion]";?></h4>
            <?php 
                 
                
                  echo "<a href='inscribirseSubasta.php?idS=".$row[0]."'> <button type='button' class='btn btn-succes'>Inscribirse</button> </a>" ;
               

            ?>



          
       </div>
      </div>
     <?php 
$nombre= $nombre + 1;

   } ?>
    
    </div>

<?php } ?>
 </div>


  <script src="jquery-3.2.1.min.js"></script>
  <script src="js/bootstrap1.min.js"></script>
   
   </body>
   </html>