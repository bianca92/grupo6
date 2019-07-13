<html>


<?php

include("clases.php");  
include("cabecera.php");
include("conexion.php");
include("mostrarImagen.php");
include("actualizarSegunFecha.php");
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

    //datos hot sale
    $consulta="SELECT * FROM config_hotsale";
    $resu2 = $con->query($consulta); 
    $row2=mysqli_fetch_array($resu2);

    //CREO LA FECHA DEL HOTSALE DE ESTE AÑO
    $añoH=date("Y");
    $fecha="$row2[dia]-$row2[mes]-$row2[year]";
    $fechaHotsale= strtotime ( 'd-m-Y' , strtotime ( $fecha ) ) ;
    $fechaH=strtotime($fechaHotsale);

    //me fijo que el hotsale de este año no haya pasado
    $fecha_actual=date('d-m-Y');

    if ($fecha_actual > $fechaHotsale){
       $añoH=$añoH + 1;
       $fecha="$row2[dia]-$row2[mes]-$row2[year]";
       //creo la fecha definitiva del hotsale
       $fechaHotsale= date ( 'd-m-Y' , strtotime ( $fecha ) ) ;
       //la paso a un formato comparable
       $fechaH=strtotime($fechaHotsale);

    }
    $fechaH=date('d/m/Y', $fechaH);

$query = "SELECT p.idPropiedad, p.titulo,p.localidad ,su.precioMinimo, su.fechaInicioSubasta, su.fechaInicioInscripcion, 
                 su.idSubasta,su.activa,su.fechaFinInscripcion, su.year, su.idSemana, su.cerrada, su.cancelada, su.enhotsale
          FROM subasta su INNER JOIN propiedad p ON su.idPropiedad=p.idPropiedad WHERE su.cancelada != 1 AND su.enhotsale = 0";
$result = mysqli_query($con, $query);
$num=mysqli_num_rows($result); 
if ($num==0) {
  echo"<h4 style='color:#FF7516'>El proximo Hot Sale sera el $fechaH </h4>";
  echo"<h4>NO SE HAN ENCONTRADO SEMANAS EN ESPERA</h4>";
}
else{     ?>

  <div class="container">

    <div>
      <?php echo"<h4 style='color:#FF7516'>El proximo Hot Sale sera el $fechaH </h4>"; ?>
      <h3>LISTA DE ESPERA PARA HOT SALE:</h3>
      <h5>Seleccione las subastas que desee que esten en oferta en epoca de Hot Sale</h5>
      <form method="POST" action="listaEsperaHotSale2.php">
      <table class="table table-hover">
         <thead>
            <tr>
            <th>Seleccion</th>
            <th>Subastas</th>
            <th>Titulo</th>
            <th>Localidad</th>
            <th>Semana</th>
            <th>Año</th>    
            <th>Precio Inicial</th>
            <th>Inscriptos</th>
            </tr>
         </thead>
        <tbody>
  
        <?php 
         $auxiliar=true;
         

         while ($row = mysqli_fetch_array($result))  { 


             $actualizar=actualizar($row['idSubasta']);
             $row['activa']=$actualizar[0];
             $row['cerrada']=$actualizar[1];
             
             
             
             
             $queryG = "SELECT * FROM ganador WHERE idSubasta = '$row[idSubasta]'";
             $resultG = mysqli_query($con, $queryG);
             $numG=mysqli_num_rows($resultG); 


             if(($row['activa']==1)&&($row['cerrada']==1)&&($numG==0)){  // terminada sin ganador

              $valor=actualizarHotSale($row['idSubasta']);
              $row['cancelada']=$valor;

              if($row['cancelada']!=1 ){


                 $auxiliar=false;
                 $imgs=ObtenerImgs($row['idPropiedad']);
      ?>
                 <tr>
                  <td><input type="checkbox" name="check[]" value='<?php echo "$row[idSubasta]"?>'></td>
                  <td> <?php echo '<img src="data:image/jpeg;base64,'.base64_encode($imgs[0]).'" style=width:30% />';?></td>
                  <td><h4><?php echo "$row[titulo]" ?></h4> </td>
                  <td><h4><?php echo" $row[localidad] ";?></h4></td>
                  <td><h4><?php $week_start = new DateTime(); $week_start->setISODate((int)$row['year'],(int)$row['idSemana']); $fi= $week_start->format('d/m');echo "$fi" ;?></h4></td>
                  <td><h4><?php  $fi= $week_start->format('Y');echo "$fi" ;?></h4></td>
                  <td><h4><?php echo "$"."$row[precioMinimo]" ?></h4></td>        <?php


                  $queryI = "SELECT * FROM inscripto WHERE idSubasta = '$row[idSubasta]'";
                  $resultI = mysqli_query($con, $queryI);
                  $numI=mysqli_num_rows($resultI); 
                  if ($numI==0) {  // no hubo inscriptos  
                    ?>
                    <td><h4><?php echo "NO"?></h4></td>
                    <?php
                  }
                  else{  ?>
                    <td><h4><?php echo "SI"?></h4></td>
                    <?php

                  }
                  ?>
                  <td><?php echo "<a href='eliminar_subasta.php?sub=".$row['idSubasta']."'> <button type='button' class='btn btn-succes'>Eliminar semana</button> </a></br>" ;?>
                  
                 </tr>  
      <?php }
            else{
            //ACTUALIZO EL ENHOTSALE=1 PARA QEU SE SEPA QUE SE DESCARTO ACA.
             $cActualizar= "UPDATE subasta SET enhotsale='1' WHERE idSubasta='$row[idSubasta]' ";
             $rActualizar = $con->query($cActualizar); 
            }


             }
         }?>      
      
        </tbody>
      </table>

      
      <?php
 
      if ($auxiliar==true){
          echo"<tr><td><h4>NO SE HAN ENCONTRADO SEMANAS EN ESPERA</h4></td></tr>";
       } 
       else{  ?>
        <input type="submit" value="Aceptar">
      </form>   <?php
       }
}  

mysqli_free_result($result);
mysqli_close($con);

?> 
  
</div>
     

 </div>

 
   
   </html>