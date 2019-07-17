<html>


<?php

include("clases.php");  
include("cabecera.php");
include("conexion.php");
include("mostrarImagen.php");
include("actualizarSegunFecha.php");
$con=conectar();


$sql2 = "SELECT * FROM subasta";
      $res2 = mysqli_query($con,$sql2);
      $tot2 = mysqli_num_rows($res2);
      if ($tot2==0){}
      else{
        while ($row2 = mysqli_fetch_array($res2)){
          $actualizar=actualizar($row2['idSubasta']);
      $row2['activa']=$actualizar[0];
      $row2['cerrada']=$actualizar[1];
        }

      }

//para que no se pueda acceder a esta pagina si no esta logeado
try{
$login= new Login();
$login->autorizar();
}
catch(Exception $e){
   echo $e->getMessage();
   header("Location:index.php");
}
$tipo= $_SESSION['tipoU'];

$query = "SELECT * FROM propiedad WHERE eliminada != 1";
            $result = mysqli_query($con, $query);
            $num=mysqli_num_rows($result); 
            
     ?>
<?php  if ($num==0) {
                  echo"<h4>NO SE HAN ENCONTRADO RESULTADOS</h4>"; 
                } ?>
  <div class="container">
   
 

  <div class="row">
    

    <?php 
$pagina="listarPropiedades";
$fecha_actual = date('Y-m-d');
$nuevafechaB = strtotime ( '+6 month' , strtotime ( $fecha_actual ) ) ;
$nuevafechaB = date ( 'Y-m-d' , $nuevafechaB );
include("busqueda.php");
$fecha_actual = date('Y-m-d');
$busqueda=0; $x=0;
$semanasD[$x]="";
 //BUSQUEDA
if (!empty($_GET)){
$inicio=$_GET['inicio'];
$fin=$_GET['fin'];
$lugar=$_GET['lugar'];

$busqueda=1;
$nuevafecha = strtotime ( '+2 month' , strtotime ( $inicio ) ) ;
$nuevafecha = date ( 'Y-m-d' , $nuevafecha );

if ($fin>$nuevafecha){
  echo '<script> alert("El rango debe ser inferior a 2 meses");</script>';
  echo "<script> window.location ='subastasUsuario.php' ;</script>";}



}
        









    $auxiliar=false;
    while ($row = mysqli_fetch_array($result))  { 
      
      $query2 = "SELECT * FROM subasta WHERE idPropiedad=$row[idPropiedad]";
            $result2 = mysqli_query($con, $query2);
            $num2=mysqli_num_rows($result2); 

            
          if (!empty($_GET)){
            
           //si se recibio GET pero no hay subasta
            $muestra=false;
            $i=0;
            $semanasDisponibles[$i]="";
            while($row2 = mysqli_fetch_array($result2))
           {
            
           $week_start = new DateTime(); $week_start->setISODate((int)$row2['year'],(int)$row2['idSemana']);
          $week_start= $week_start->format('Y-m-d');
           $week_end = strtotime ( '+6 day' , strtotime ( $week_start ) ) ;
           $week_end = date ( 'Y-m-d' , $week_end); 
           // busco si el lugar ingresado se encuentra entre la info de ubicacion e la propiead  
            $ubicacion1 = stripos($row['pais'], $lugar);
             $ubicacion2 = stripos($row['provincia'], $lugar);
              $ubicacion3 = stripos($row['localidad'], $lugar);
          
                
          //GUARDA EN UN ARREGLO LAS SEMANAS DISPONIBLES DE LA PROPIEDAD BUSqUEDA
if(($week_start>=$inicio && $week_end<=$fin && (($fecha_actual<$row2['fechaFinInscripcion']&& $tipo=="clasico")or($fecha_actual<$row2['fechaFinSubasta']&& $tipo=="premium")))&&($ubicacion1!==false or $ubicacion2!==false or $ubicacion3!==false )){
           $week_start= date('d-m-Y', strtotime($week_start));
          $semanasDisponibles[$i]=$week_start;
          $muestra=true;
         
                    }
          $i=$i + 1;
      }
      

      }

 else {//si no se recibio nada por GET que me muestre todo
 
 $muestra=true;
   }


//echo "<p> es verdadero o false: $muestra";
 if($muestra==true){
     $auxiliar=true;
      ?>
      <div class="col-sm-4">
     
        <div class="thumbnail">
        
           <?php $imgs=ObtenerImgs($row['idPropiedad']);
            
            echo '<img src="data:image/jpeg;base64,'.base64_encode($imgs[0]).'" style="width:822px;height:300px;" />';
           
           ?>
          <div class="caption">
           
            <h4><?php // si se realizo una busqueda accedo al detalle con las fechas
            
            if (!empty($_GET)){ 
              echo "<a href='detalle.php?prop=$row[idPropiedad]&busqueda=$busqueda&semanas=".serialize($semanasDisponibles)."'><h4>$row[titulo] en la ciudad de: $row[localidad]</h4></a>  ";
              echo "Semanas disponibles: ";
              foreach ($semanasDisponibles as &$valor) {
                      echo "$valor.  ";
                               }}
            else{
              echo "<a href='detalle.php?prop=$row[idPropiedad]&busqueda=$busqueda&semanas=".serialize($semanasD)."'><h4>$row[titulo] en la ciudad de: $row[localidad]</h4></a>  ";}        
                             


            ?></h4>     

          </div>

       </div>
      </div>
     <?php } ?>
    


<?php } 

if($auxiliar==false){echo"<h4>NO SE HAN ENCONTRADO RESULTADOS</h4>"; 
}?>
 </div>

 <?php
 
            mysqli_free_result($result);
            mysqli_close($con);

?> 
   
   </html>