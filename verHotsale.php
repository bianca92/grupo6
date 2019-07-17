</html>
<head>
  <?php





  if(isset($_GET['msj'])){
       $mensaje= $_GET['msj'];
//

    if($mensaje="2")
       echo"<script> alert ('DEBE ESTAR REGISTRADO PARA ACCEDER')</script>"; 
    }
?>
</head> 
<body> 

   
 <?php
        
$queryhotsale = "SELECT  hs.idHotsale, hs.precio, hs.fechaagregada, su.idSubasta, su.idSemana, su.year, p.titulo, p.localidad, su.cancelada, p.idPropiedad
          FROM hotsale hs INNER JOIN subasta su ON hs.idSubasta = su.idSubasta INNER JOIN propiedad p ON su.idPropiedad = p.idPropiedad 
          WHERE su.enhotsale = '1' AND su.cancelada = '0' LIMIT 2";
          $resulthotsale = mysqli_query($con, $queryhotsale);
          $numH=mysqli_num_rows($resulthotsale); 
  ?>                 
  <div class="row"  >
    <div class="col-lg-4">

      <div class="panel-group" style="background-color: #EAB15A">
    <div class="panel panel-default" style="background-color: #EAB15A">
      <div class="panel-heading" style="background-color: #FF7516"><h4>HOT SALE hasta <?php echo$nuevafecha;?></h4></div>
      <div class="panel-body">
     
      <?php 
    while ($rowH = mysqli_fetch_array($resulthotsale)) {
   
  
     ?>
      <div class="row">
          <div class="thumbnail" style="background-color: #EAB15A" >
        
           <?php $imgs=ObtenerImgs($rowH['idPropiedad']);
            
            echo '<img src="data:image/jpeg;base64,'.base64_encode($imgs[0]).'" style="width:822px;height:300px;" />';
           
           ?>
         

          <div class="caption">
            <h4><?php echo "$rowH[titulo] en la localidad de: $rowH[localidad] ";?></h4>

           <?php if((isset($_SESSION['estado']))&&($_SESSION['rol']=="0")){
             $week_start = new DateTime(); $week_start->setISODate((int)$rowH['year'],(int)$rowH['idSemana']);
                                           $fi= $week_start->format('d/m'); ?>
                 
            <h3><?php echo "OFERTA <kbd>$ $rowH[precio]</kbd>";?></h3>
            <h4><?php echo "para la semana de: $fi del año ";
            $fi= $week_start->format('Y'); echo "$fi " ; ?>
             </h4> <?php } ?>
          </div>
       </div>
</div>
<?php }

  if(isset($_SESSION['estado'])){
     if($_SESSION['rol']=="0"){ ?>
       <a href="listarHotsaleUsuario.php" class="btn btn-success" float="left">VER MÁS</a>
<?php
    
  }}
  else{ ?>
       <a href="ingresar.php" class="btn btn-success" float="left">VER MÁS</a>
<?php } ?>
  </div> </div> </div> </div> 


</body>
</html> 