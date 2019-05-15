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


$query = "SELECT s.precioMinimo, s.fechaInicioSubasta, s.fechaInicioInscripcion,se.numero,p.idPropiedad, p.titulo,p.ciudad FROM subasta s 
INNER JOIN semana se ON s.idSemana= se.idSemana
INNER JOIN semanatienepropiedad sp ON s.idSemana=sp.idSemana
INNER JOIN propiedad p ON sp.idPropiedad=p.idPropiedad";
            $result = mysqli_query($con, $query);
            $num=mysqli_num_rows($result); 
  if ($num==0) {
  echo"<h4>NO SE ENCONTRARON RESULTADO</h4>";
 }
else{
     ?>

  <div class="container">
<?php
?>
  <div>
    <table class="table table-hover">
    <thead>
      <tr>
        <th>Subastas</th>
        <th></th>
        <th>ciudad</th>
        <th>semana</th>
        <th>precio inicial</th>
        <th>subasta</th>
        <th>inscripcion</th>
      </tr>
    </thead>
    <tbody>
  

    <?php while ($row = mysqli_fetch_array($result))  { 
    //<img src=mostrarImagen.php?idPropiedad=".$row['idPropiedad']." style=width:60%"
    $imgs=ObtenerImgs($row['idPropiedad']);
    ?>
        <tr>
          <td> <?php echo '<img src="data:image/jpeg;base64,'.base64_encode($imgs[0]).'" style=width:30% />';?></td>
           <td><h4><?php echo "$row[titulo]" ?></h4> </td>
            <td><h4><?php echo" $row[ciudad] ";?></h4></td>
            <td><h4><?php echo "$row[numero]" ;?></h4></td>
            <td><h4><?php echo "$"."$row[precioMinimo]" ?></h4></td>
            <td><h4><?php echo "$row[fechaInicioSubasta]" ?></h4></td>
            <td><h4><?php echo "$row[fechaInicioInscripcion]" ?></h4></td>
            <td><?php echo "<a href='cerrar_subasta.php?no=".$row[0]."'> <button type='button' class='btn btn-succes'>CERRAR</button> </a>" ;?></td>
         </tr>  
         <?php } ?>      
      
      </tbody>
  </table>
</div>
     

 </div>

 <?php
 }
            mysqli_free_result($result);
            mysqli_close($con);

?> 
   
   </html>