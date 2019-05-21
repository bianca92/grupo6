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

$query = "SELECT s.numero, p.idPropiedad, p.titulo,p.ciudad ,su.precioMinimo, su.fechaInicioSubasta, su.fechaInicioInscripcion, su.activa, su.idSubasta, su.cerrada
          FROM propiedad p INNER JOIN subasta su ON p.idPropiedad=su.idPropiedad INNER JOIN semana s ON s.idSemana=su.idSemana";
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
        <th>puja actual</th>
      </tr>
    </thead>
    <tbody>
  

    <?php while ($row = mysqli_fetch_array($result))  { 
    //<img src=mostrarImagen.php?idPropiedad=".$row['idPropiedad']." style=width:60%"
    if(($row['activa']==1)&&($row['cerrada']!=1)){

      //OBTENGO PUJA GANADORA DEL MOMENTO
       $pujaMaxima= $row['precioMinimo'];
       $pujaMaximaPuja="";
           $var_consulta4= "SELECT cantidad, idPuja FROM puja WHERE idSubasta=$row[idSubasta]";
            $result4 = mysqli_query($con, $var_consulta4);

              //ACTUALIZO EL MINIMO SI YA HAY OFERTAS ANTERIORES
              while ($row4 = mysqli_fetch_array($result4)){
                  if ($row4['cantidad']>=$pujaMaxima){
                        $pujaMaxima=$row4['cantidad'];
                        $pujaMaximaPuja=$row4['idPuja'];  
                          }
                }
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
            <td><h4><?php echo "$pujaMaxima" ?></h4></td>
            <td><?php echo "<a href='cerrar_subastaActiva.php?pugano=".$pujaMaximaPuja."&sub=".$row['idSubasta']."'> <button type='button' class='btn btn-succes'>CERRAR SUBASTA</button> </a>" ;?></td>
         </tr>  
         <?php } } ?>      
      
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