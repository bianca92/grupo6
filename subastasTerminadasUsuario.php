<html>


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



$query = "SELECT su.idSubasta, p.idPropiedad, p.titulo,p.localidad ,su.precioMinimo, su.fechaInicioSubasta, su.fechaFinSubasta,
su.fechaInicioInscripcion, su.fechaFinInscripcion, su.activa, su.cerrada, su.year,su.idSemana, su.cancelada
          FROM propiedad p INNER JOIN subasta su ON p.idPropiedad=su.idPropiedad WHERE su.cancelada!=1";
            $result = mysqli_query($con, $query);
            $num=mysqli_num_rows($result); 
      

    if ($num==0) {
  echo"<h4>NO SE HAN ENCONTRADO RESULTADOS</h4>";
 }
else{
     ?>
     <link  href="css/bootstrap1.min.css">
<div class="container">
   
   <a href='subastasGanadasUsuario.php' class='btn btn-warning' float='right'>FUI GANADOR</a> </br></br>
 
 <?php
   
  //for($x = 1; $x <=($num/3) ; $x++){
        

  ?>
  <div class="row">

    <?php 
    //nombre de los botones de la galeria
    $nombre=1;
//OBTIENE EL ID DEL USUARIO ACTUAL
    $id=($_SESSION['id']);
  $auxiliar=true;
    while ($row = mysqli_fetch_array($result))  { 
  
       if (!empty($_GET)){
           //si se recibio GET pero esta no es la subasta que no la muestre
           $muestra=false;
           if($row['idSemana']==$numeroS && $row['year']==$year){
            //si esta es la subasta que la muestre
            $muestra=true;
           }
       }
       else {//si no se recibio nada por GET que me muestre todo
        $muestra=true;}

      $actualizar=actualizar($row['idSubasta']);
      $row['activa']=$actualizar[0];
      $row['cerrada']=$actualizar[1];
       //selecciona para luego revisar que el usuario no este inscripto en la subasta    
       $Inscripto = "SELECT *
        FROM inscripto
        WHERE idPersona= $id";
           $resuInscripto = mysqli_query($con, $Inscripto);  
           
                  //VERIFICAR QUE EL USUSARIO ESTE O NO INSCRIPTO EN LA SUBASTA
                      $inscripto=false;
                      
                     while ($row2 = mysqli_fetch_array($resuInscripto)){
                              if ($row2['idSubasta']==$row['idSubasta']){
                                 $inscripto= true;  
                              }
                     }
                  //--------------------------------------------------------------------
                  //SI ESTA ACTIVA QUE LA MUESTRE
     if(($inscripto==true)&&($row['activa']==1)&&($row['cerrada']==1)&&$muestra==true){
      $auxiliar=false;
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
           
            
            <?php 
          
        

 
           $consulWinner= "SELECT * FROM ganador WHERE idSubasta=$row[idSubasta]";
            $resultWinner = mysqli_query($con, $consulWinner);
            $num = mysqli_num_rows($resultWinner);
           
           if ($num==0){
            $winnerMsj="NADIE HA GANADO";
            $pujaMaxima="No hubo pujas";
          }
           else {
            $rowWinner = mysqli_fetch_array($resultWinner);
            $consulPuja= "SELECT cantidad FROM puja WHERE idPuja=$rowWinner[idPuja]";
            $resultPuja = mysqli_query($con, $consulPuja);
            $rowPuja = mysqli_fetch_array($resultPuja);
            $pujaMaxima= $rowPuja['cantidad'];
            $winnerPersona=$rowWinner['idPersona'];
            $winnerAccion=0;
                 if($winnerPersona==$id){ 

                   $winnerMsj="¡¡GANASTE LA SUBASTA!!"; }
                else{
                  $winnerMsj="Perdiste la subasta";} 
           } ?>


             <h4><p class= 'text-danger'><?php echo $winnerMsj ?></p><h4> 
             <h4><?php echo "Puja ganadora: $ $pujaMaxima.";?></h4>
             <h6><?php
              echo "<p class=bg-primary >La subasta cerró el ".date('d/m/Y', strtotime($row['fechaFinSubasta']))."<p>";
             ?></h6>
         
         </div>
      </div> <?php // fin div thumbnail
$nombre= $nombre + 1;

   }
 }?>
    
    </div>

<?php //} }?>
 </div>
 
  <script src="jquery-3.2.1.min.js"></script>
  <script src="js/bootstrap1.min.js"></script>
   <?php if ($auxiliar==true){
    echo"<h4>NO SE HAN ENCONTRADO RESULTADOS</h4>";
   } 
 } //fin del else 
 ?>
</div>
   
   </body>
   </html>