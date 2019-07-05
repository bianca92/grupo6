<html>


<?php

include("clases.php");  
include("cabecera.php");
include("conexion.php");
include("mostrarImagen.php");
include("actualizarSegunFecha.php");
include("cabeceraHotSale.php");
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


// RECUPERO TODAS LAS SUBASTAS CON "ENHOTSALE = 1"
$query = "SELECT  hs.idHotsale, hs.precio, hs.fechaagregada, su.idSubasta, su.idSemana, su.year, p.titulo, p.localidad,  p.idPropiedad, su.cancelada
          FROM hotsale hs INNER JOIN subasta su ON hs.idSubasta = su.idSubasta INNER JOIN propiedad p ON su.idPropiedad = p.idPropiedad 
          WHERE su.enhotsale = '1' AND su.cancelada!='1' ";
$result = mysqli_query($con, $query);
$num=mysqli_num_rows($result); 

if ($num==0) {
    echo"<h4>NO SE HAN ENCONTRADO RESULTADOS</h4>";
}
else{     ?>

  <div class="container">
    <div>
      <table class="table table-hover">
        <h4>SEMANAS PUBLICADAS PARA EL PROXIMO HOT SALE:</h4>
        <thead>
          <tr>
            <th>Añadida</th>
            <th>Foto</th>
            <th>Titulo</th>
            <th>Localidad</th>
            <th>Semana</th>
            <th>Año</th>
            <th>Precio Hot Sale</th>
            
          </tr>
        </thead>
        <tbody>       <?php 
         
          $auxiliar=true;

         while ($row = mysqli_fetch_array($result))  { 

          
          $row['cancelada']=actualizarHotSale($row['idSubasta']);
                  
          if($row['cancelada']!=1){
                      
              $auxiliar=false;
             
              $imgs=ObtenerImgs($row['idPropiedad']);       ?>
              <tr>
                 <td><h4><?php $f=date('d/m/Y',strtotime($row['fechaagregada'])); echo "$f"?></h4></td>
                 <td> <?php echo '<img src="data:image/jpeg;base64,'.base64_encode($imgs[0]).'" style=width:30% />';?></td>
                 <td><h4><?php echo "$row[titulo]" ?></h4> </td>
                 <td><h4><?php echo" $row[localidad] ";?></h4></td>
                 <td><h4><?php $week_start = new DateTime(); $week_start->setISODate((int)$row['year'],(int)$row['idSemana']);
                                           $fi= $week_start->format('d/m');echo "$fi" ;?></h4></td>
                 <td><h4><?php  $fi= $week_start->format('Y');echo "$fi" ;?></h4></td>
                 <td><h4><?php echo "$"."$row[precio]" ?></h4></td>                       
                 <td><?php echo "<a href='modificarHotSale.php?hs=".$row['idHotsale']."'> <button type='button' class='btn btn-succes'>Modificar</button> </a></br>" ;?>  
                 <td><?php echo "<a href='eliminarHotSale.php?sub=".$row['idSubasta']."'> <button type='button' class='btn btn-succes'>Quitar de hot sale</button> </a></br>" ;?>       
                                  
                 
              </tr>   <?php
             
         }}      ?>      
      
        </tbody>
      </table>         <?php
      
      if ($auxiliar==true){
          echo"<tr><td><h4>NO SE HAN ENCONTRADO RESULTADOS</h4></td></tr>";
      }
}  
mysqli_free_result($result);
mysqli_close($con);       ?> 

    </div>
 </div>
</html>