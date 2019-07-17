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



          
          

$query = "SELECT su.idSubasta, p.idPropiedad, p.titulo,p.localidad ,su.precioMinimo, su.fechaInicioSubasta, su.fechaFinSubasta,
su.fechaInicioInscripcion, su.fechaFinInscripcion, su.activa, su.cerrada, su.year, su.idSemana, su.cancelada
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
    
<?php  
 
  //----------PRIMERA PARTE DE LA BUSQUEDA-------------------------------------------------------
$pagina="subastasActivasUsuario";
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

if ($inicio!=0 && $fin!=0 && ($fin>$nuevafecha or $inicio>$fin) ){
  echo '<script> alert("El rango debe ser inferior a 2 meses");</script>';
  echo "<script> window.history.go(-1);</script>";
}
 if($inicio==0){$inicio="1990-01-01";

}
if($fin==0){$fin="2050-01-01";}




}
//-------------------------------------------------------------------------------------------     
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
              $titulo = stripos($row2['titulo'], $lugar);
               if(empty($lugar)){          
             $ubicacion1=true;
              }
                
          //COMPRUEBA SI LA MUESTRA
         if(($week_start>=$inicio && $week_end<=$fin)&&($ubicacion1!==false or $ubicacion2!==false or $ubicacion3!==false or $titulo!==false )){
                 
          $muestra=true;
         
          }
      

       }


       else {//si no se recibio nada por GET que me muestre todo
        $muestra=true;}
//--------------------------------------------------------------------------------------------------------------------------------




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
     if(($inscripto==true)&&($row['activa']==1)&&($row['cerrada']!=1)&&($muestra==true)){
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
           $pujaMaxima= $row['precioMinimo'];
           $var_consulta4= "SELECT cantidad FROM puja WHERE idSubasta=$row[idSubasta]";
            $result4 = mysqli_query($con, $var_consulta4);

              //ACTUALIZO EL MINIMO SI YA HAY OFERTAS ANTERIORES
              while ($row4 = mysqli_fetch_array($result4)){
                  if ($row4['cantidad']>=$pujaMaxima){
                        $pujaMaxima=$row4['cantidad'];    }
                }
                 //OBTENGO CUAL ES EL ULTIMO MONTO DE ESTE USUARIO
            $var_consulta5= "SELECT MAX(cantidad) AS maximo FROM puja WHERE idSubasta=$row[idSubasta] and idPersona=$id";
             $result5 = mysqli_query($con, $var_consulta5);
              $row5= mysqli_fetch_array($result5);

               //SI ESTE USUARIO NO HA HECHO NINGUNA OFERTA ANTERIOR O SEA NO HAY REGISTRO EN LA TABLA
                   
                     if($row5[0]==false){
                      echo "Aun no has echo ninguna oferta";
                    
                             }
                    //SI HAY UNA OFERTA ANTERIOR DE ESTE USUARIO QUE SE LA DIGA
                             else{
                                 if($pujaMaxima==$row5[0]){
                                  echo "<p class=bg-info> Vas ganando la puja </p>";
                                 }
                                 else {  echo "Tu oferta anterior fue de $ $row5[0] ."; }

                     
                    }


    
              ?>

             <h4><?php echo "Puja Actual: $ $pujaMaxima.";?></h4>
             <?php
             echo "<p class=bg-primary >La subasta cierra el ".date('d/m/Y', strtotime($row['fechaFinSubasta']))."<p>";
              
             
               $queryPer = "SELECT * FROM persona WHERE idPersona=$id";
       $resulPer = mysqli_query($con, $queryPer);
       $rowPer = mysqli_fetch_array($resulPer);

              if($rowPer['credito']==0){
               
                echo "<a href=# <button type='button'  disabled class='btn btn-succes'>Pujar</button> </a>" ; echo "No puedes realizar una puja.No tienes mas creditos.";}

               else {
                    echo "<a href='Pujar.php?idS=".$row[0]."&idU=".$id."&min=".$row['precioMinimo']."'> <button type='button' class='btn btn-succes'>Pujar</button> </a>" ;

               }

              

              

               echo "<a style='float:right;'  href='detalle.php?prop=$row[idPropiedad]&busqueda=0&semanas=".serialize(0)."'> <button type='button' class='btn btn-succes'>Detalles de propiedad</button> </a></br>";
               ?>



          
       </div>
      </div>
     <?php 
$nombre= $nombre + 1;

   } 
   }?>
    
    </div>

<?php //} ?>
 </div>


  <script src="jquery-3.2.1.min.js"></script>
  <script src="js/bootstrap1.min.js"></script>
   <?php if ($auxiliar==true){
    echo"<h4>NO SE HAN ENCONTRADO RESULTADOS</h4>";
   }}  ?>
   </body>
   </html>