<html>
<head>

<?php

include("clases.php");  
include("cabecera.php");
include("conexion.php");
include("mostrarImagen.php");
include("actualizarSegunFecha.php");
include("funciones.php");

$rechazoautomatico=rechazoAutomatico();

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
//

    if($mensaje="2")
       echo"<script> alert ('DEBE ESTAR REGISTRADO PARA ACCEDER')</script>"; 
    }

?>

          
  <?php   

?>
</head>
<body>

<div class="container"> 
<?php
//----------PRIMERA PARTE DE LA BUSQUEDA-------------------------------------------------------
$pagina="subastasTerminadasUsuario";
$fecha_actual = date('Y-m-d');
$nuevafechaB = "1990-01-01";
include("busqueda.php");
   //BUSQUEDA
if (!empty($_GET)){
$inicio=$_GET['inicio'];
$fin=$_GET['fin'];
$lugar=$_GET['lugar'];

$nuevafecha = strtotime ( '+2 month' , strtotime ( $inicio ) ) ;
$nuevafecha = date ( 'Y-m-d' , $nuevafecha );

if ($inicio!=0 && $fin!=0 && $fin>$nuevafecha){
  echo '<script> alert("El rango debe ser inferior a 2 meses");</script>';
  echo "<script> window.history.go(-1);</script>";
}
 if($inicio==0){$inicio="1990-01-01";

}
if($fin==0){$fin="2050-01-01";}




}
//-------------------------------------------------------------------------------------------


$query = "SELECT su.idSubasta, p.idPropiedad, p.titulo,p.localidad ,su.precioMinimo, su.fechaInicioSubasta, su.fechaFinSubasta,
su.fechaInicioInscripcion, su.fechaFinInscripcion, su.activa, su.cerrada, su.year,su.idSemana, su.cancelada, p.eliminada, su.enhotsale
          FROM propiedad p INNER JOIN subasta su ON p.idPropiedad=su.idPropiedad";
            $result = mysqli_query($con, $query);
            $num=mysqli_num_rows($result); 
      

if ($num==0) {
  echo"<h4>NO SE HAN ENCONTRADO RESULTADOS</h4>";
 }
 else{
     ?>
     <link  href="css/bootstrap1.min.css">

   
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
     //----------------------------------SEGUNDA PARTE DE LA BUSQUEDA--------------------------
       if (!empty($_GET)){
           //si se recibio GET pero esta no es la subasta que no la muestre
           $muestra=false;
           $query2 = "SELECT * FROM propiedad WHERE idPropiedad=$row[idPropiedad]";
            $result2 = mysqli_query($con, $query2);
            $row2 = mysqli_fetch_array($result2);
             $week_start = new DateTime(); $week_start->setISODate((int)$row['year'],(int)$row['idSemana']);
          $week_start= $week_start->format('Y-m-d');
           $week_end = strtotime ( '+6 day' , strtotime ( $week_start ) ) ;
           $week_end = date ( 'Y-m-d' , $week_end); 
           // busco si el lugar ingresado se encuentra entre la info de ubicacion e la propiead  
            $ubicacion1 = stripos($row2['pais'], $lugar);
             $ubicacion2 = stripos($row2['provincia'], $lugar);
              $ubicacion3 = stripos($row2['localidad'], $lugar);
          
                
          //COMPRUEBA SI LA MUESTRA
         if(($week_start>=$inicio && $week_end<=$fin)&&($ubicacion1!==false or $ubicacion2!==false or $ubicacion3!==false )){
                 
          $muestra=true;
         
          }
      

       }


       else {//si no se recibio nada por GET que me muestre todo
        $muestra=true;}
//-------------------------------------------------------------------------------------------------------------------------------------
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
                     //consulto si alguien la compro
                     $consulP= "SELECT * FROM comprap WHERE idSubasta=$row[idSubasta]";
                    $resultP = mysqli_query($con, $consulP);
                    $numP = mysqli_num_rows($resultP);
                    //si alguien la compro premium
                    if($numP>0){
                      $rowP= mysqli_fetch_array($resultP);
                      if($id==$rowP['idPersona']){
                        $inscripto=true;
                      }

                    }
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
 $ganador=0;
$val="";
$consulWinner= "SELECT * FROM ganador WHERE idSubasta=$row[idSubasta]";
            $resultWinner = mysqli_query($con, $consulWinner);
            $num = mysqli_num_rows($resultWinner);

             // PROPIEDAD ELIMINADA
          if(($row['cancelada']==1 or $row['eliminada']==1) && $num==0 && $row['enhotsale']!=1){
            echo"LA SUBASTA SE HA CANCELADO - LA PROPIEDAD YA NO ESTA DISPONIBLE";
          }
          else{ // TODOS LOS DEMAS PROPIEDADES
           //si nadie la gano y nadie la compro como premium
 
           if ($num==0 && $numP==0){
            $winnerMsj="NADIE HA GANADO";
            $pujaMaxima="--";
          }
           else {
            //si hay un ganador
            if($num>0){
            $rowWinner = mysqli_fetch_array($resultWinner);
            $consulPuja= "SELECT cantidad FROM puja WHERE idPuja=$rowWinner[idPuja]";
            $resultPuja = mysqli_query($con, $consulPuja);
            $rowPuja = mysqli_fetch_array($resultPuja);
            $pujaMaxima= "$rowPuja[cantidad]";
            $winnerPersona=$rowWinner['idPersona'];
            $winnerAccion=0;
                 if($winnerPersona==$id){ 
                     $rechazoautomaticoDias=rechazoAutomaticoDias($row['idSubasta']);
                     
                   $winnerMsj="¡¡GANASTE LA SUBASTA!!"; 
                   $ganador=1;
   $val=$rowWinner['idSubasta'];
                 }
                else{
                  $winnerMsj="Perdiste la subasta";} 
            }
            if ($numP>0 && $rowP['idPersona']==$id){
              $winnerMsj="Has comprado esta semana como premium.";
              $pujaMaxima= "$rowP[monto]";
              $winnerPersona='';
              $ganador=1;
              $val=$row['idSubasta'];          
                  }

         if ($numP>0 && $rowP['idPersona']!=$id){$winnerMsj="Un usuario premium ha comprado esta semana.";}

            } ?>


             <h4><p class= 'text-danger'><?php echo $winnerMsj ?></p><h4> 
             <h4><?php echo "Precio de venta: $pujaMaxima.";?></h4>
             
             <h6><?php echo "<p class=bg-primary >La subasta cerró el ".date('d/m/Y', strtotime($row['fechaFinSubasta']))."<p>";?></h6>
         <?php  
       }
echo "<a href='detalle.php?prop=$row[idPropiedad]&busqueda=0&semanas=".serialize(0)."'> <button type='button' class='btn btn-succes'>Detalle de propiedad</button> </a>";
 $valoracionC = "SELECT * FROM valoracion WHERE idSubasta=$val";
                    $resultV = mysqli_query($con, $valoracionC);
                    
$consulPagado= "SELECT * FROM comprasu WHERE idSubasta='$row[idSubasta]'";
            $resultPagado = mysqli_query($con, $consulPagado);
            $numPagado = mysqli_num_rows($resultPagado);
            //que solo le deje calificar si ya pago
  if($ganador==1 && mysqli_num_rows($resultV)==0 && ($numPagado==1 or $numP==1)){
echo "<a href='calificar.php?sub=".$row['idSubasta']."&prop=".$row['idPropiedad']."'> <button type='button' class='btn btn-succes'>CALIFICAR</button> </a></br></td>" ;}

$consultaC= "SELECT * FROM persona WHERE IdPersona='$id'";
$var_resultadoC = $con->query($consultaC);
$rowC = mysqli_fetch_array($var_resultadoC);
//si es el ganador que le permita pagar(si tiene los creditos)
if($ganador==1 && ($numPagado==0 && $numP==0) &&$rowC['credito']>0){
echo "<a href='pagarSemana.php?sub=".$row['idSubasta']."&monto=".$pujaMaxima."&ganador=".$winnerPersona."&tipo=subasta'> <button type='button' class='btn btn-succes'>PAGAR</button> </a></td>" ;
echo "<a href='rechazarSemana.php?sub=".$row['idSubasta']."&monto=".$pujaMaxima."&ganador=".$id."'> <button type='button' class='btn btn-succes'><h5 class=text-danger >RECHAZAR</h5></button> </a></br></td>" ;}
// SI GANÓ PERO NO TIENE MAS CREDITOS.
if($ganador==1 && $numPagado==0 && $numP==0 && $rowC['credito']<=0){echo "<h4 class=text-danger >NO TIENES MAS CREDITOS</h4>";}

//si ya pagó que le diga pagada
if($ganador==1 && $numPagado==1){
  echo "<h4 class=text-danger >PAGADA</h4>";
}
       ?>
         </div> 
      </div> <?php   
      }// fin div col4


$nombre= $nombre + 1;
 
   
 } ?>
    

 
  <script src="jquery-3.2.1.min.js"></script>
  <script src="js/bootstrap1.min.js"></script>
   <?php if ($auxiliar==true){
    echo"<h4>NO SE HAN ENCONTRADO RESULTADOS</h4>";
   } ?>

</div><?php // fin de row ?>
<?php  }  //fin del else 
 ?> 
</div>   
   </body>
   </html>