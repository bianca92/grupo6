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

//$fecha=$_GET['fecha'];
//$propiedad=$_GET['prop'];	
$subasta=$_GET['sub'];
?>
</head>
<body>

<?php
$fecha_actual = date('Y-m-d');   $id=($_SESSION['id']);
/*tengo el idsemana de la fecha disponible para recuperar datos de subasta
$fecha2 = new DateTime($fecha);
$semana = $fecha2->format('W'); */

$query = "SELECT su.idSubasta, p.idPropiedad, p.titulo,p.localidad ,su.precioMinimo,su.preciopremium, su.fechaInicioSubasta, su.fechaFinSubasta,
          su.fechaInicioInscripcion, su.fechaFinInscripcion, su.activa, su.cerrada,su.cancelada, su.year, su.idSemana,p.eliminada
          FROM propiedad p INNER JOIN subasta su ON p.idPropiedad=su.idPropiedad and su.idSubasta=$subasta";
            $result = mysqli_query($con, $query);
            $num=mysqli_num_rows($result); 
            $row=mysqli_fetch_array($result);
           
?>
<link  href="css/bootstrap1.min.css">
<div class="container">
    
           <?php //IMAGENES
           $imgs=ObtenerImgs($row['idPropiedad']);
            $i=0; 
           // while($i < count($imgs)) { ?>
             
        <div class="col-sm-4">
        <div class="thumbnail" >
              <?php echo '<img src="data:image/jpeg;base64,'.base64_encode($imgs[$i]).'" style="width:822px;height:300px;" />'; $i=$i+1;?>
          </div></div>
              
        <?php  // }

           ?>
<div class="col-sm-8">
<table class="table">  

  <tr>
     <?php
        //SI GANO O SE ELIMINO LA SUBASTA ----------------------------------------------
          
      if(($row['activa']==1)&&($row['cerrada']==1)){
            // PROPIEDAD ELIMINADA
         $week_start = new DateTime(); $week_start->setISODate((int)$row['year'],(int)$row['idSemana']);
      $fi= $week_start->format('d/m/Y'); ?>
      <h4><?php echo "Para la semana del $fi.";?></h4>
      <h4><?php echo "$row[titulo] en la localidad de $row[localidad] ";?></h4>


<?php
          if($row['eliminada']==1 or $row['cancelada']==1){
            
            




            echo"LA SUBASTA SE HA CANCELADO - LA PROPIEDAD YA NO ESTA DISPONIBLE";

           




          }
          else{ // TODOS LOS DEMAS PROPIEDADES
           $ganador="";
           $consulWinner= "SELECT * FROM ganador WHERE idSubasta='$row[idSubasta]'";
            $resultWinner = mysqli_query($con, $consulWinner);
            $num = mysqli_num_rows($resultWinner);
           
           if ($num==0){
            $winnerMsj="NADIE HA GANADO";
            $pujaMaxima="--";
           
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
                    $ganador=1;  
                    $winnerMsj="¡¡GANASTE LA SUBASTA!!";
                     $rechazoautomaticoDias=rechazoAutomaticoDias($row['idSubasta']);
                      if($rechazoautomaticoDias==1){
                        $ganador=0;
                        $winnerMsj="Han pasado 7 dias ya no puedes adjudicarte la semana.";
                      }
                  }
                else{
                  $winnerMsj="Perdiste la subasta";} 


            }


//------------------PREMIUM----------------------------------------------------------------------------------------------
              //consulto si alguien la compro como premium
                     $consulP= "SELECT * FROM comprap WHERE idSubasta=$row[idSubasta]";
                    $resultP = mysqli_query($con, $consulP);
                    $numP = mysqli_num_rows($resultP);
                    //si alguien la compro premium
                    if($numP>0){
                      $rowP= mysqli_fetch_array($resultP);
                     $winnerMsj="Un usuario premium ha comprado esta semana.";
                      if($id==$rowP['idPersona']){
                        $ganador=1;
                        $winnerMsj="Has comprado esta semana como usuario premium.";
                        $pujaMaxima=$rowP['monto'];
                      }}




//-----------------------------------------------------------------------------------------------------

             ?>


             <h4><p class= 'text-danger'><?php echo $winnerMsj ?></p><h4> 
             <h4><?php echo "Precio de venta: $ $pujaMaxima.";?></h4>
            <?php } ?>
             <h6><?php echo "<p class=bg-primary >La subasta cerró el ".date('d/m/Y', strtotime($row['fechaFinSubasta']))."</p>";?></h6>
         <?php 
//-----------------------------PAGAR-----------------------------------------------------------------------------------
            $consulPagado= "SELECT * FROM comprasu WHERE idSubasta=$row[idSubasta]";
            $resultPagado = mysqli_query($con, $consulPagado);
            $numPagado = mysqli_num_rows($resultPagado);

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

//-------------------VALORACION---------------------------------------------------------------------------------------------------

$valoracionC = "SELECT * FROM valoracion WHERE idSubasta=$row[idSubasta]";
                    $resultV = mysqli_query($con, $valoracionC);

if($ganador==1 && mysqli_num_rows($resultV)==0 && ($numPagado==1 or $numP==1)){
echo "<a href='calificar.php?sub=".$row['idSubasta']."&prop=".$row['idPropiedad']."'> <button type='button' class='btn btn-succes'>CALIFICAR</button> </a></br></td>" ;}
//--------------------------------------------------------------------------------------------------------------------------

          }
     else{ 
     
       //TRAIGO DATOS DE LA PERSONA
       $queryPer = "SELECT * FROM persona WHERE idPersona=$id";
       $resulPer = mysqli_query($con, $queryPer);
       $rowPer = mysqli_fetch_array($resulPer);
            //BUSCO LA PUJA MAXIMO
       $pujaMaxima= $row['precioMinimo'];
       $var_consulta4= "SELECT cantidad FROM puja WHERE idSubasta=$row[idSubasta]";
       $result4 = mysqli_query($con, $var_consulta4);

            //ACTUALIZO EL MINIMO SI YA HAY OFERTAS ANTERIORES
        while ($row4 = mysqli_fetch_array($result4)){
            if ($row4['cantidad']>=$pujaMaxima){
                $pujaMaxima=$row4['cantidad'];    }
                }    

//selecciona para luego revisar que el usuario no este inscripto en la subasta    
       $Inscripto = "SELECT * FROM inscripto WHERE idPersona= $id";
       $resuInscripto = mysqli_query($con, $Inscripto);  
           
    //VERIFICAR QUE EL USUSARIO ESTE O NO INSCRIPTO EN LA SUBASTA
        $inscripto=false;
                      
        while ($row2 = mysqli_fetch_array($resuInscripto)){
             if ($row2['idSubasta']==$row['idSubasta']){
                      $inscripto= true;  
                    }
              }
      $week_start = new DateTime(); $week_start->setISODate((int)$row['year'],(int)$row['idSemana']);
      $fi= $week_start->format('d/m/Y'); ?>
      <h4><?php echo "Para la semana del $fi.";?></h4>
      <h4><?php echo "$row[titulo] en la localidad de $row[localidad] ";?></h4>
      <h4><?php echo "Precio Minimo: $ $row[precioMinimo].";?></h4>
    </tr>
    <tr>   
 <?php     if ($inscripto==true){ //1
                 	//SUBASTA ACTIVA
           if(($inscripto==true)&&($row['activa']==1)&&($row['cerrada']!=1)){ //2
            //INFORMO SOBRE LAS PUJAS MAXIMAS
                 //OBTENGO CUAL ES EL ULTIMO MONTO DE ESTE USUARIO
            $var_consulta5= "SELECT MAX(cantidad) AS maximo FROM puja WHERE idSubasta=$row[idSubasta] and idPersona=$id";
            $result5 = mysqli_query($con, $var_consulta5);
            $row5= mysqli_fetch_array($result5);

               //SI ESTE USUARIO NO HA HECHO NINGUNA OFERTA ANTERIOR O SEA NO HAY REGISTRO EN LA TABLA
                   
                     if($row5[0]==false){
                      echo "Aun no has echo ninguna oferta";}
                    //SI HAY UNA OFERTA ANTERIOR DE ESTE USUARIO QUE SE LA DIGA
                     else{
                                 if($pujaMaxima==$row5[0]){
                                  echo "<p class=bg-info> Vas ganando la puja </p>";
                                 }
                                 else {  echo "Tu oferta anterior fue de $ $row5[0] ."; }
                     } ?>
        <h4><?php echo "Puja Actual: $ $pujaMaxima.";?></h4>
      <?php
               echo "<p class=bg-primary >La subasta cierra el ".date('d/m/Y', strtotime($row['fechaFinSubasta']))."<p>";
              
               if($rowPer['credito']==0){
                  echo "<a href=# <button type='button'  disabled class='btn btn-succes'>Pujar</button> </a>" ; echo "No puedes realizar una puja.No tienes mas creditos.";

               }
                 else {

                   echo "<a href='Pujar.php?idS=".$row[0]."&idU=".$id."&min=".$row['precioMinimo']."'> <button type='button' class='btn btn-succes'>Pujar</button> </a>" ;
                 }      




                       } //2

                       
                       else{ //SUBASTA EN Inscripcion 
                           // funcion date() par cambiar el formato a dia/mes/año
                            echo "<p class=bg-info>Ya estas inscripto a esta subasta</p>";
                            echo "<p </p>";
                            echo "<p class= text-danger>La subasta abrira el dia ".date('d/m/Y', strtotime($row['fechaInicioSubasta']))."</p>";
                             echo "<a href='eliminarSuscripcion.php?idS=".$row[0]."&idU=".$id."'> <button  type='button' class='btn btn-success'>Eliminar Suscripcion</button> </a>" ;
                        }    
                       

                       } //1
                       else{ //sino estoy inscripto
                       	 // SI SOY PREMIUM ME INSCRIBO EN CUALQUIER MOMENTO 
                       	if (($rowPer['tipoU']=='premium')&&($inscripto==false)&&($fecha_actual>=$row['fechaInicioInscripcion'])) {
                       	     if($fecha_actual<$row['fechaInicioSubasta']){
                             echo "<p class=bg-primary >La subasta comienza el ".date('d/m/Y', strtotime($row['fechaInicioSubasta']))."<p>";
                             }
                              if($fecha_actual>=$row['fechaInicioSubasta'] && $fecha_actual<$row['fechaFinSubasta']){
                             echo "<p class=bg-primary >La subasta cierra el ".date('d/m/Y', strtotime($row['fechaFinSubasta']))."<p>";
                               echo "<p class= bg-danger> Puja Actual: $ $pujaMaxima.<p>";
                             }

                          echo "<a href='inscribirseSubasta.php?idS=".$row[0]."&idU=".$id."'> <button  type='button' class='btn btn-success'>Inscribirse</button> </a>" ;
                       	 


                       	}
                         else{
                         if ($fecha_actual<$row['fechaInicioInscripcion']){

                         echo "<p class= bg-danger>La inscripcion comienza el ".date('d/m/Y', strtotime($row['fechaInicioInscripcion']))."</p>"; 
                          }
                          else{
                            if($fecha_actual<$row['fechaFinInscripcion']){                       
                        echo "<p class=bg-primary >La inscripcion cierral el ".date('d/m/Y', strtotime($row['fechaFinInscripcion']))."<p>";
                        echo "<a href='inscribirseSubasta.php?idS=".$row[0]."&idU=".$id."'> <button  type='button' class='btn btn-success'>Inscribirse</button> </a>" ;} 
                       if ($fecha_actual>=$row['fechaInicioSubasta'] && $fecha_actual<$row['fechaFinSubasta']) {echo "<p class=bg-danger >En subasta.<p>";}
                       if ($fecha_actual>=$row['fechaFinInscripcion'] && $fecha_actual<$row['fechaInicioSubasta']){echo "<p class=bg-danger >Ya cerró la inscripción.<p>";}

                      }
                        }

                      }

  
  ?>              
                        
</tr>
<tr>
<script>
</script>
<?php
function comprobar($fechaSubasta,$credito,&$ok){
$fecha_actual = date('Y-m-d'); $accion="";
if(($credito==0)||($fecha_actual>=$fechaSubasta)){
 $accion="disabled"; 
  if($credito==0){$ok="No tenes creditos disponibles";}
  else{ if ($fecha_actual>=$fechaSubasta) {
  	$ok="No podés adjudicarte la residencia porque está en subasta";
  }}
} return $accion; }

$ok="";

          $consulPagado= "SELECT * FROM comprap WHERE idSubasta='$row[idSubasta]'";
            $resultPagado = mysqli_query($con, $consulPagado);
            $numPagado = mysqli_num_rows($resultPagado);
            $rowPagado=mysqli_fetch_array($resultPagado);
            //solo puede comprar si nadie mas la ha comprado
    if($rowPer['tipoU']=='premium' && $numPagado==0) { 
      //------------------------------------------------------------------------------------------- BOTON COMPRA PREMIUM -----------------?>

        <a href='pagarSemana.php?sub=<?php echo $row["idSubasta"]?>&monto=<?php echo $row["preciopremium"]?>&ganador=<?php echo $rowPer["IdPersona"]?>&tipo=premium'><button class='btn btn-success' type="button" <?php echo comprobar($row['fechaInicioSubasta'],$rowPer['credito'],$ok)?> >COMPRAR</button></a>
     <?php echo $ok; }

     if($numPagado==1 && $rowPagado['idPersona']==$rowPer["IdPersona"]) {
      echo "<h4 class=text-danger >Ya compraste esta propiedad</h4>";
     }
    }?>
          </tr>  
         </table>
         </div>
      </div>

<script src="jquery-3.2.1.min.js"></script>
<script src="js/bootstrap1.min.js"></script>
  
 


  

</body>
</html>


