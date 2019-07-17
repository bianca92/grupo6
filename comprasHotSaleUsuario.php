<html>
<head>

<?php

include("clases.php");  
include("cabecera.php");
include("conexion.php");
include("mostrarImagen.php");
include("actualizarSegunFecha.php");
include("funciones.php");

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


if(isset($_GET['msj'])){
    $mensaje= $_GET['msj'];

    if($mensaje="2")
       echo"<script> alert ('DEBE ESTAR REGISTRADO PARA ACCEDER')</script>"; 
}

?>

          
  <?php   
   //BUSQUEDA
if (!empty($_GET)){
  $fechaIngresada=$_GET['week'];

  //OBTENGO EL NUMERO DE LA SEMANA DE LA FECHA
  $numeroS=date('W', strtotime($fechaIngresada));
  //OBTENGO EL MES
  $mes=date('m', strtotime($fechaIngresada));
  //OBTENGO EL AÑO
  $year=date('Y', strtotime($fechaIngresada));
  
  if($mes=="12" && $numeroS=="1"){
    $year=$year+1;
  }
  if($mes=="01" && $numeroS=="53"){
   $year=$year-1;
  }
  if($mes=="01" && $numeroS=="52"){
    $year=$year-1;
  }
}
?>
</head>
<body>

<div class="container"> 
  <h2 style="color: #FF7516">COMPRAS HOT SALE</h2></br>
<?php
$id=($_SESSION['id']);

$query = "SELECT * FROM comprah ch INNER JOIN hotsale hs ON ch.idHotsale=hs.idHotsale INNER JOIN subasta su ON hs.idSubasta=su.idSubasta INNER JOIN propiedad p ON su.idPropiedad=p.idPropiedad WHERE ch.idPersona=$id ";
$result = mysqli_query($con, $query);
$num=mysqli_num_rows($result); 
      

if ($num==0) {
  echo"<h4>NO SE HAN ENCONTRADO RESULTADOS</h4>";
}
else{

     ?>
     <link  href="css/bootstrap1.min.css">
 
 <?php
   
  //for($x = 1; $x <=($num/3) ; $x++){
        

  ?>
  <div class="row">

    <?php 
    //nombre de los botones de la galeria
  $nombre=1;
  //OBTIENE EL ID DEL USUARIO ACTUAL
    
  $auxiliar=true;
  while ($row = mysqli_fetch_array($result))  { 
  
     $muestra=true;
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
      <h4><?php $week_start = new DateTime(); $week_start->setISODate((int)$row['year'],(int)$row['idSemana']);
                                           $fi= $week_start->format('d/m/Y');
                echo "Para la semana del $fi.";?></h4>
      <h4><?php echo "$row[titulo] en la localidad de $row[localidad] ";?></h4>

       
      <h4><?php echo "Precio de venta: $row[monto].";?></h4>
             
      <h6><?php echo "Fecha de compra: ".date('d/m/Y', strtotime($row['fecha'])).".";?></h6>
         <?php  
       
      echo "<a href='detalle.php?prop=$row[idPropiedad]&busqueda=0&semanas=".serialize(0)."'> <button type='button' class='btn btn-succes'>Detalle de propiedad</button> </a>";
      $valoracionC = "SELECT * FROM valoracion WHERE idSubasta=$row[idSubasta]";
      $resultV = mysqli_query($con, $valoracionC);
                    
      if( mysqli_num_rows($resultV)==0 ){
        echo "<a href='calificar.php?sub=".$row['idSubasta']."&prop=".$row['idPropiedad']."'> <button type='button' class='btn btn-succes'>CALIFICAR</button> </a></br></td>" ;}


       ?>
         </div> 
      </div> <?php   
      }// fin div col4


$nombre= $nombre + 1;
 
   
  ?>
    

 
  <script src="jquery-3.2.1.min.js"></script>
  <script src="js/bootstrap1.min.js"></script>
   

</div><?php // fin de row ?>
<?php  }  //fin del else 
 ?> 
</div>   
   </body>
   </html>