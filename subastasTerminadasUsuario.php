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



          
          

$query = "SELECT su.idSubasta, s.numero, p.idPropiedad, p.titulo,p.ciudad ,su.precioMinimo, su.fechaInicioSubasta, su.fechaFinSubasta,
su.fechaInicioInscripcion, su.fechaFinInscripcion, su.activa, su.cerrada, s.fecha, su.year
          FROM propiedad p INNER JOIN subasta su ON p.idPropiedad=su.idPropiedad INNER JOIN semana s ON s.idSemana=su.idSemana";
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
     if(($inscripto==true)&&($row['activa']==1)&&($row['cerrada']==1)){
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
      <h4><?php echo "Para la semana del $row[fecha] del $row[year].";?></h4>
            <h4><?php echo "$row[titulo] en la ciudad de $row[ciudad] ";?></h4>
           
            
            <?php 
          // $pujaMaxima= $row['precioMinimo'];
          /// $var_consulta4= "SELECT cantidad FROM puja WHERE idSubasta=$row[idSubasta]";
           // $result4 = mysqli_query($con, $var_consulta4);

              //ACTUALIZO EL MINIMO SI YA HAY OFERTAS ANTERIORES
             // while ($row4 = mysqli_fetch_array($result4)){
              //    if ($row4['cantidad']>=$pujaMaxima){
               //         $pujaMaxima=$row4['cantidad'];    }
               // }


            //OBTENER DATOS DEL GANADOR
           // $winnerPersona="NADIE HA GANADO";
            //$winnerCantidad=$row['precioMinimo'];

          //  $winnerConsul= "SELECT cantidad FROM puja WHERE idSubasta=$row[idSubasta]";
   //         $winnerResult = mysqli_query($con, $winnerConsul);
     //       $winnerNumPuja = mysqli_num_rows($winnerResult);
            //CHEQUEA SI HUBO PUJAS PARA ESA PROPIEDAD
       //     if($winnerNumPuja!=0){
              //RECUPERO LOS DATOS DE LA PUJA GANADORA
      //        $winnerConsul2= "SELECT idPersona, cantidad
       //                         FROM puja
        //                        WHERE idSubasta= $row[idSubasta] and idPuja IN (SELECT idPuja FROM ganador)";
         //     $winnerResult2=mysqli_query($con,$winnerConsul2);
          //    $row7=mysql_fetch_array($winnerResult2);
              //ACTUALIZO EL MONTO GANADOR
          //    $winnerCantidad=$row7['cantidad'];
              //CHEQUEO SI EL QUE GANO FUE EL USUARIO ACTUAL
          //    if($row7['idPersona']==$id){
           //     $winnerPersona="GANASTE LA SUBASTA !!";
          //    }
           //   else{$winnerPersona="Perdiste la subasta";}
         //   }


          //OBTENGO PUJA GANADORA 

           $pujaMaxima= $row['precioMinimo'];
           $winnerPersona="";
           $winnerMsj="NADIE HA GANADO";
           

           $consulWinner= "SELECT cantidad, idPersona FROM puja WHERE idSubasta=$row[idSubasta]";
            $resultWinner = mysqli_query($con, $consulWinner);
            $numPujasWinner = mysqli_num_rows($resultWinner);
            //CHEQUEA SI HUBO PUJAS PARA ESA PROPIEDAD
            if($numPujasWinner!=0){

              //OBTENGO EL MONTO MAXIMO DE PUJA Y QUIEN LO HIZO (GANADOR)
              while ($rowWinner = mysqli_fetch_array($resultWinner)){
                  if ($rowWinner['cantidad']>=$pujaMaxima){
                        $pujaMaxima=$rowWinner['cantidad'];
                        $winnerPersona= $rowWinner['idPersona'];  
                          }
                }
               
                if($winnerPersona==$id){
                    $winnerMsj="¡¡GANASTE LA SUBASTA!!";
                }
                else{$winnerMsj="Perdiste la subasta";} }
      













                 //OBTENGO CUAL ES EL ULTIMO MONTO DE ESTE USUARIO
          //  $var_consulta5= "SELECT cantidad FROM puja WHERE idSubasta=$row['idSubasta'] and idPersona=$id";
            // $result5 = mysqli_query($con, $var_consulta5);
             // $row5= mysqli_fetch_array($result5);

               //SI ESTE USUARIO NO HA HECHO NINGUNA OFERTA ANTERIOR O SEA NO HAY REGISTRO EN LA TABLA
                   // $primeraOferta=0;
                    // if($row5==false){
                     // echo "Aun no has echo ninguna oferta";
                      // $primeraOferta=1;
                           //  }
                    //SI HAY UNA OFERTA ANTERIOR DE ESTE USUARIO QUE SE LA DIGA
                           //  else{
                             //    if($pujaMaxima==$row5[0]){
                               //   echo "Vas ganando la puja";
                                // }
                                // else {  echo "Tu oferta anterior fue de $ $row5[0] ."; }

                     
                   // }


    
              ?>

             <h4><?php echo "Puja ganadora: $ $pujaMaxima.";?></h4>
             <h6><?php
             echo "La subasta cerro el dia $row[fechaFinSubasta]";
             ?></h6>

             <h6><?php
             echo "<h4><p class= text-danger> $winnerMsj </p></h4";
              // echo "<a href='Pujar.php?idS=".$row[0]."&idU=".$id."&min=".$row['precioMinimo']."'> <button type='button' class='btn btn-succes'>Pujar</button> </a>" ;
               ?></h6>



          
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
   } } 


   ?>
   </body>
   </html>