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

$query = "SELECT p.idPropiedad, p.titulo,p.localidad ,su.precioMinimo, su.fechaInicioSubasta, su.fechaInicioInscripcion, 
                 su.idSubasta,su.activa,su.fechaFinInscripcion, su.year, su.idSemana, su.cerrada, su.cancelada, su.preciopremium
          FROM propiedad p INNER JOIN subasta su ON p.idPropiedad=su.idPropiedad WHERE su.cancelada != 1";
$result = mysqli_query($con, $query);
$num=mysqli_num_rows($result); 
if ($num==0) {
  echo"<h4>NO SE HAN ENCONTRADO RESULTADOS</h4>";
}
else{     ?>

  <div class="container">
    <?php
    //----------PRIMERA PARTE DE LA BUSQUEDA-------------------------------------------------------
$pagina="subastasAdmin";
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
    <div>
      <h4>SUBASTAS NO COMENZADAS:</h4>
      <table class="table table-hover">
         <thead>
            <tr>
            <th>Subastas</th>
            <th>Titulo</th>
            <th>Localidad</th>
            <th>Semana</th>
            <th>Año</th>    
            <th>Precio Inicial</th>
            <th>Precio Premium</th>
            <th>Inicio Inscripcion</th>
            <th>Inicio Subasta</th>
            </tr>
         </thead>
        <tbody>
  
        <?php 
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

             if($row['activa']!=1 && $muestra==true){

                 $auxiliar=false;
                 $imgs=ObtenerImgs($row['idPropiedad']);
      ?>
                 <tr>
                  <td> <?php echo '<img src="data:image/jpeg;base64,'.base64_encode($imgs[0]).'" style=width:30% />';?></td>
                  <td><h4><?php echo "$row[titulo]" ?></h4> </td>
                  <td><h4><?php echo" $row[localidad] ";?></h4></td>
                  <td><h4><?php $week_start = new DateTime(); $week_start->setISODate((int)$row['year'],(int)$row['idSemana']); $fi= $week_start->format('d/m');echo "$fi" ;?></h4></td>
                  <td><h4><?php  $fi= $week_start->format('Y');echo "$fi" ;?></h4></td>
                  <td><h4><?php echo "$"."$row[precioMinimo]" ?></h4></td>
                  <td><h4><?php echo "$"."$row[preciopremium]" ?></h4></td>
                  <td><h4><?php $fi=date('d/m/Y', strtotime($row['fechaInicioInscripcion'])); echo"$fi" ?></h4></td>
                  <td><h4><?php $fs=date('d/m/Y', strtotime($row['fechaInicioSubasta'])); echo "$fs"; ?></h4></td>  
                  <td><?php echo "<a href='inscriptos.php?sub=".$row['idSubasta']."'> <button type='button' class='btn btn-succes'>INSCRIPTOS</button> </a></br>" ;?>  
                  <td> <?php 
                     $fecha_actual = date('Y-m-d-H:i');
                     //SI TODAVIA NO LLEGO LA FECHA DE INSCRIPCION QUE PUEDA ABRIR LA INSCRIPCION AHORA
                     if($fecha_actual<$row['fechaInicioInscripcion']){
                         echo "<a href='abrirInscripcion.php?sub=".$row['idSubasta']."'> <button type='button' class='btn btn-succes'>Abrir inscripcion</button> </a></br>" ;
                     }
                     else{
                         //SI LA INSCRIPCION YA INICIO PUEDE CERRARLA ANTES DE LA FECHA DE CIERRE.
                         if($fecha_actual>=$row['fechaInicioInscripcion']&&$fecha_actual<$row['fechaFinInscripcion']){
                             echo "<a href='cerrarInscripcion.php?sub=".$row['idSubasta']."'> <button type='button' class='btn btn-succes'>Cerrar inscripcion</button> </a></br>" ;
                         }
                         else {
                             //SI LA INSCRIPCION YA CERRO QUE PUEDA ABRIR LA SUBASTA ANTES DE LA FECHA
                             if($fecha_actual>=$row['fechaFinInscripcion']&&$fecha_actual<$row['fechaInicioSubasta']){

                                  echo "<a href='abrirPuja.php?sub=".$row['idSubasta']."'> <button type='button' class='btn btn-succes'>Habilitar pujas</button> </a></br>" ;
                             }
                         }
                    }
             
                 ?>  

                   <td><?php echo "<a href='eliminar_subasta.php?sub=".$row['idSubasta']."'> <button type='button' class='btn btn-succes'>Eliminar subasta</button> </a></br>" ;?>
                 </tr>  
      <?php }
         }?>      
      
        </tbody>
      </table>
      <?php
 
      if ($auxiliar==true){
          echo"<tr><td><h4>NO SE HAN ENCONTRADO RESULTADOS</h4></td></tr>";
       } 
}  

mysqli_free_result($result);
mysqli_close($con);

?> 
  
</div>
     

 </div>

 
   
   </html>