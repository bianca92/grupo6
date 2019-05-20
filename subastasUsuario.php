<html>
<?php

include("clases.php");  
include("cabecera.php");
include("conexion.php");
include("mostrarImagen.php");
 
 //para que no se pueda acceder a esta pagina si no esta logeado
try{
$login= new Login();
$login->autorizar();
}
catch(Exception $e){
   echo $e->getMessage();
   header("Location:index.php");
}
$con=conectar();


$query = "SELECT su.idSubasta, s.numero, p.idPropiedad, p.titulo,p.ciudad ,su.precioMinimo, su.fechaInicioSubasta, 
su.fechaInicioInscripcion, su.fechaFinInscripcion
          FROM propiedad p INNER JOIN subasta su ON p.idPropiedad=su.idPropiedad INNER JOIN semana s ON s.idSemana=su.idSemana";
            $result = mysqli_query($con, $query);
            $num=mysqli_num_rows($result); 
            

    if ($num==0) {
  echo"<h4>NO SE ENCONTRARON RESULTADO</h4>";
 }
else{
     ?>
     <link  href="css/bootstrap1.min.css">
<div class="container">
   
<?php 
  //for($x = 1; $x <=($num/3) ; $x++){
?>
  <div class="row">

    <?php 
    //nombre de los botones de la galeria
    $nombre=1;
    while ($row = mysqli_fetch_array($result))  { 
       //selecciona para luego revisar que el usuario no este inscripto en la subasta
        $id=($_SESSION['id']);
       $Inscripto = "SELECT *
        FROM inscripto
        WHERE idPersona= $id";
           $resuInscripto = mysqli_query($con, $Inscripto);
      
  ?>

        
      <div class="col-sm-4">
     
        <div class="thumbnail" >

          <!-- Galeria Carrusel -->
             <div id="<?php echo $nombre; ?>" class="carousel slide" data-ride="carousel">
        
        <!-- contenedor de los slide -->
        
        <div class="carousel-inner" role="listbox">
          
          <?php  $imgs=ObtenerImgs($row['idPropiedad']);?>
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
            <h4><?php echo "$row[titulo] en la ciudad de $row[ciudad] ";?></h4>
           
             <h4><?php echo "Precio Minimo: $ $row[precioMinimo].";?></h4>
            <?php 
                 
                 $fecha_actual = date('Y-m-d');
                 if ($fecha_actual>=$row['fechaInicioInscripcion'] && $fecha_actual<=$row['fechaFinInscripcion'] ){
                 
                        //revisa que el usuario no este iscripto en la subasta
                      $inscripto=false;
                     while ($row2 = mysqli_fetch_array($resuInscripto)){
                              if ($row2['idSubasta']==$row['idSubasta']){
                                 $inscripto= true;  

                              }

                             // echo "$row2[idSubasta] y $row[idSubasta]";
                     }
                
                if ($inscripto==true){
                   // echo "<p </p>";
                            // funcion date() par cambiar el formato a dia/mes/año
                            echo "<p class=bg-info>Ya estas inscripto a esta subasta</p>";
                            echo "<p </p>";
                            echo "<p class= text-danger>La subasta abrira el dia ".date('d/m/Y', strtotime($row['fechaInicioSubasta']))."</p>";
                             }
                       else { 
                        echo "<p class=bg-primary >Tienes tiempo de inscribirte hasta el ".date('d/m/Y', strtotime($row['fechaFinInscripcion']))."<p>";
                        echo "<a href='inscribirseSubasta.php?idS=".$row[0]."&idU=".$id."'> <button  type='button' class='btn btn-success'>Inscribirse</button> </a>" ; }
                        }
                else{
                  
                  echo "<p class= bg-danger>La inscripcion comienza el ".date('d/m/Y', strtotime($row['fechaInicioInscripcion']))."</p>"; 
                    
                }
               
                ?><button class="btn btn-info " onclick="myFunction()" >Comprar</button>

<script>
function myFunction() {
  alert("DEBE SER USUARIO PREMIUM!");
}
</script>
            

         </div>
      </div>
     <?php 
$nombre= $nombre + 1;

   } ?>
    
    </div>

<?php // } ?>
 </div>


  <script src="jquery-3.2.1.min.js"></script>
  <script src="js/bootstrap1.min.js"></script>
   <?php } ?>
   </body>
   </html>