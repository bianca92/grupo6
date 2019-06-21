<html>
<?php

include("clases.php");  
include("cabecera.php");
include("conexion.php");
include("mostrarImagen.php");
include("actualizarSegunFecha.php");


 
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


$query = "SELECT su.idSubasta, p.idPropiedad, p.titulo,p.localidad ,su.precioMinimo, su.fechaInicioSubasta, 
su.fechaInicioInscripcion, su.fechaFinInscripcion, su.activa, su.cerrada, su.idSemana, su.year, su.cancelada
          FROM propiedad p INNER JOIN subasta su ON p.idPropiedad=su.idPropiedad WHERE su.cancelada!=1";
            $result = mysqli_query($con, $query);
            $num=mysqli_num_rows($result); 
            
$fecha_actual = date('Y-m-d');
$nuevafecha = strtotime ( '+6 month' , strtotime ( $fecha_actual ) ) ;
$nuevafecha = date ( 'Y-m-d' , $nuevafecha );

    if ($num==0) {
  echo"<h4>NO SE HAN ENCONTRADO RESULTADOS</h4>";
 }
else{
     ?>
     <link  href="css/bootstrap1.min.css">
<div class="container">
<!---
  DESPUES LO ARREGLO:
<form method="GET" action="subastasUsuario.php" >
 <p></i><input type="date" name="inicio" min='<?php echo $nuevafecha; ?>' required="required" />
 </i><input type="date" name="fin" min='<?php echo $nuevafecha; ?>' required="required"/>
 <input type="submit" value="Buscar"/> 
</form> --->
   
<?php 
 //BUSQUEDA
if (!empty($_GET)){
$inicio=$_GET['inicio'];
$fin=$_GET['fin'];


$nuevafecha = strtotime ( '+2 month' , strtotime ( $inicio ) ) ;
$nuevafecha = date ( 'Y-m-d' , $nuevafecha );

if ($fin>$nuevafecha){
  echo '<script> alert("El rango debe ser inferior a 2 meses");</script>';
  echo "<script> window.location ='subastasUsuario.php' ;</script>";}



}
  //for($x = 1; $x <=($num/3) ; $x++){
?>
  <div class="row">

    <?php 
    //nombre de los botones de la galeria
    $nombre=1;
    //significa que hubo subastas disponibles pero o ya estan activas o ya terminaron y por eso no las muestra en esta subasta
    $auxiliar=true;
    while ($row = mysqli_fetch_array($result))  { 
        if (!empty($_GET)){
           //si se recibio GET pero esta no es la subasta que no la muestre
          $muestra=false;
           $week_start = new DateTime(); $week_start->setISODate((int)$row['year'],(int)$row['idSemana']);
          $week_start= $week_start->format('Y-m-j');
           $week_end = strtotime ( '+6 day' , strtotime ( $week_start ) ) ;
           $week_end = date ( 'Y-m-j' , $week_end);
            

         if($week_start>=$inicio && $week_end<=$fin){
            //si esta es la subasta que la muestre

          $muestra=true;
         }
      }
       else {//si no se recibio nada por GET que me muestre todo
        $muestra=true;
        }


      $actualizar=actualizar($row['idSubasta']);
      $row['activa']=$actualizar[0];
      $row['cerrada']=$actualizar[1];
       //selecciona para luego revisar que el usuario no este inscripto en la subasta
        $id=($_SESSION['id']);
       $Inscripto = "SELECT *
        FROM inscripto
        WHERE idPersona= $id";
           $resuInscripto = mysqli_query($con, $Inscripto);

            $fecha_actual = date('Y-m-d');
            $inscripto=false;
                 if ($fecha_actual>=$row['fechaInicioInscripcion'] ){
                 
                        //revisa que el usuario no este iscripto en la subasta
                      
                     while ($row2 = mysqli_fetch_array($resuInscripto)){
                              if ($row2['idSubasta']==$row['idSubasta']){
                                 $inscripto= true;  

                              }

                             // echo "$row2[idSubasta] y $row[idSubasta]";
                     }}
      
      if(($row['activa']!=1)&&($row['cerrada']!=1)&&($muestra==true)){
        
        //si entra aca quiere decir que va a visualizar al menos 1 resultado.
       if($inscripto==false && $fecha_actual>=$row['fechaFinInscripcion'] ){}

       else { $auxiliar=false;

        
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
           
             <h4><?php echo "Precio Minimo: $ $row[precioMinimo].";?></h4>
            <?php 
                 
                
                
                       if ($inscripto==true){
                   // echo "<p </p>";
                            // funcion date() par cambiar el formato a dia/mes/año
                            echo "<p class=bg-info>Ya estas inscripto a esta subasta</p>";
                            echo "<p </p>";
                            echo "<p class= text-danger>La subasta abrira el dia ".date('d/m/Y', strtotime($row['fechaInicioSubasta']))."</p>";
                             echo "<a href='eliminarSuscripcion.php?idS=".$row[0]."&idU=".$id."'> <button  type='button' class='btn btn-success'>Eliminar Suscripcion</button> </a>" ;
                             }

                       else { 

                         if ($fecha_actual<$row['fechaInicioInscripcion']){

                         echo "<p class= bg-danger>La inscripcion comienza el ".date('d/m/Y', strtotime($row['fechaInicioInscripcion']))."</p>"; 
                          }
                          else{
                        echo "<p class=bg-primary >La inscripcion cierra el ".date('d/m/Y', strtotime($row['fechaFinInscripcion']))."<p>";
                        echo "<a href='inscribirseSubasta.php?idS=".$row[0]."&idU=".$id."'> <button  type='button' class='btn btn-success'>Inscribirse</button> </a>" ; }


                      }
                        
             $consultaPremium= "SELECT * FROM persona WHERE idPersona='$id'";
             $resuPremium = mysqli_query($con,  $consultaPremium);
             $rowPre= mysqli_fetch_array($resuPremium);
             if ($rowPre['tipoU']=="premium"&& $rowPre['credito']>0 ){
                  echo "<a  href=#> <button type='button' class='btn btn-succes'>COMPRAR</button> </a>";}
                 
                    echo "<a  href='detalle.php?prop=$row[idPropiedad]&busqueda=0&semanas=".serialize(0)."'> <button type='button' class='btn btn-succes'>Detalle propiedad</button> </a>";
                 
               
                ?>


            

         </div>
      </div>
     <?php 
$nombre= $nombre + 1;

   }

 } }?>
    
    </div>

<?php // } ?>
 </div>


  <script src="jquery-3.2.1.min.js"></script>
  <script src="js/bootstrap1.min.js"></script>
   <?php if ($auxiliar==true){
    echo"<h4>NO SE HAN ENCONTRADO RESULTADOS</h4>";
   }} 
 


   ?>
   </body>
   </html>