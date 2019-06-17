<html>


<?php

include("clases.php");  
include("cabecera.php");
include("conexion.php");
include("mostrarImagen.php");
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


$query = "SELECT * FROM propiedad";
            $result = mysqli_query($con, $query);
            $num=mysqli_num_rows($result); 

         
     ?>

<div class="container">
<div class="col-sm-4" > 
<a href="propiedades.php" class="btn btn-warning" float="left">NUEVO</a></br>
</div>

<div class="col-sm-8" >
<?php $pagina="propiedadesAdmin";   
include("busqueda.php"); ?>
</div>

<?php
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
  echo "<script> window.location ='propiedadesAdmin.php' ;</script>";}

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
          
                
          //GUARDA EN UN ARREGLO LAS SMANAS DISPONIBLES DE LA PROPIEDAD BUSqUEDA
         if($week_start>=$inicio && $week_end<=$fin && $fecha_actual<$row2['fechaFinInscripcion']&&($ubicacion1!==false or $ubicacion2!==false or $ubicacion3!==false )){
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


  <div>

    <table class="table table-hover">
    <thead>
      <tr>
        <th>Propiedad</th>
        <th>Titulo</th>
        <th>Pais</th>
        <th>Provincia</th>
        <th>Localidad</th>
      </tr>
    </thead>
    <tbody>
      <?php  if ($num==0) {
                  echo"<h4>NO SE HAN ENCONTRADO RESULTADOS</h4>"; } 
 
    while ($row = mysqli_fetch_array($result))  { 
      $imgs=ObtenerImgs($row['idPropiedad']); ?>
      <tr>

            
             <td><?php if (!empty($_GET)){ 
              echo "<a href='detalleAdmin.php?prop=$row[idPropiedad]&busqueda=$busqueda&semanas=".serialize($semanasDisponibles)."'>".
                    '<img src="data:image/jpeg;base64,'.base64_encode($imgs[0]).'" style=width:20% />'."</a></br>  ";
              echo "Semanas disponibles: ";
              foreach ($semanasDisponibles as &$valor) {
                      echo "$valor.  ";
                               }}
            else{
              echo "<a href='detalleAdmin.php?prop=$row[idPropiedad]&busqueda=$busqueda&semanas=".serialize($semanasD)."'>".
                     '<img src="data:image/jpeg;base64,'.base64_encode($imgs[0]).'" style=width:20% />'."</a>  ";}  
                 ?></td>
            
            <td><h4><?php echo "$row[titulo]" ;?></h4> </td>
             <td><h4><?php echo" $row[pais] ";?></h4></td>
              <td><h4><?php echo" $row[provincia] ";?></h4></td>
            <td><h4><?php echo" $row[localidad] ";?></h4></td>
            <td><?php echo "<a href='modificar_propiedad.php?no=".$row[0]."'> <button type='button' class='btn btn-succes'>MODIFICAR</button> </a>" ;?></td>
            <td><?php echo "<a href='alta_subasta.php?no=".$row[0]."'> <button type='button' class='btn btn-succes'>SUBASTAR</button> </a>" ;?></td>
         </tr>  
         <?php } ?>  
           
      
      </tbody>
  </table>
</div>
     

 
<?php } } 

if($auxiliar==false){echo"<h4>NO SE HAN ENCONTRADO RESULTADOS</h4>"; 
}
 
            mysqli_free_result($result);
            mysqli_close($con);

?> 
   </div>
   </html>