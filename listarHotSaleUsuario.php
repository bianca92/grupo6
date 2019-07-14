</html>
<head>
<?php


include("clases.php");  
include("cabecera.php");
include("conexion.php");
include("mostrarImagen.php");
include("actualizarSegunFecha.php");

$con=conectar();

  if(isset($_GET['msj'])){
       $mensaje= $_GET['msj'];
//

    if($mensaje="2")
       echo"<script> alert ('DEBE ESTAR REGISTRADO PARA ACCEDER')</script>"; 
    }
?>
</head> 
<body> 

  <div class="container-fluid" style="margin:10px; padding-right:10px" > 

  <div class="well well-sm" style="background-color: #FF7516">
  <?php  $consultaHotSale="SELECT * FROM config_hotsale";
         $resHotsale =  mysqli_query(mysqli_connect('localhost','root','','grupo6'),$consultaHotSale); 
         $rowH=mysqli_fetch_array($resHotsale);

          $dias=$rowH['duracion'];
          $fechaHotsale=$rowH['fecha'];
          
          $nuevafecha = strtotime ( '+'.$dias.'day' , strtotime ( $rowH['fecha'] )) ; 
          $nuevafecha = date ( 'd/m/Y' , $nuevafecha );
          echo"<h4> HOT SALE hasta ".$nuevafecha."</h4>";
?>
  </div> 

    <div class="row">
 <?php
        
$queryhotsale = "SELECT  hs.idHotsale, hs.precio, hs.fechaagregada, su.idSubasta, su.idSemana, su.year, p.titulo, p.localidad, su.cancelada, p.idPropiedad
          FROM hotsale hs INNER JOIN subasta su ON hs.idSubasta = su.idSubasta INNER JOIN propiedad p ON su.idPropiedad = p.idPropiedad 
          WHERE su.enhotsale = '1' AND su.cancelada = '0' AND idHotsale NOT IN (SELECT idHotsale FROM comprah )";
          $resulthotsale = mysqli_query($con, $queryhotsale);
          $numH=mysqli_num_rows($resulthotsale); 
  ?>                 
  

   
     
      <?php 
    while ($rowH = mysqli_fetch_array($resulthotsale)) {?>
   
    <div class="col-lg-4">
  
     
      
          <div class="thumbnail" style="background-color: #EAB15A" >
        
           <?php $imgs=ObtenerImgs($rowH['idPropiedad']);
            
            echo '<img src="data:image/jpeg;base64,'.base64_encode($imgs[0]).'" style="width:822px;height:300px;" />';
           
           ?>
         

          <div class="caption">
            <h4><?php echo "$rowH[titulo] en la localidad de: $rowH[localidad] ";?></h4>

           <?php if((isset($_SESSION['estado']))&&($_SESSION['rol']=="0")){
             $week_start = new DateTime(); $week_start->setISODate((int)$rowH['year'],(int)$rowH['idSemana']);
                                           $fi= $week_start->format('d/m'); ?>
                 
            <h3><?php echo "OFERTA $ $rowH[precio]"." ";?><a href="compraHotsale.php?hotsale=<?php echo $rowH['idHotsale']?>&monto=<?php echo $rowH['precio']?>" class="btn btn-danger" float="right">COMPRAR</a></h3>
            <h4><?php echo "para la semana de: $fi del año ";
            $fi= $week_start->format('Y'); echo "$fi " ; ?></h4> <?php } ?>
          </div>
       </div>
</div> 
<?php } ?>

  </div> 

</div>
</body>
</html>  