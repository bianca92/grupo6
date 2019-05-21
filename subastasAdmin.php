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

$query = "SELECT s.numero, p.idPropiedad, p.titulo,p.ciudad ,su.precioMinimo, su.fechaInicioSubasta, su.fechaInicioInscripcion, su.idSubasta,su.activa
          FROM propiedad p INNER JOIN subasta su ON p.idPropiedad=su.idPropiedad INNER JOIN semana s ON s.idSemana=su.idSemana";
            $result = mysqli_query($con, $query);
            $num=mysqli_num_rows($result); 
  if ($num==0) {
  echo"<h4>NO SE HAN ENCONTRADO RESULTADOS</h4>";
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
           if($row['activa']!=1){
    $imgs=ObtenerImgs($row['idPropiedad']);
    ?>
        <tr>
          <td> <?php echo '<img src="data:image/jpeg;base64,'.base64_encode($imgs[0]).'" style=width:30% />';?></td>
           <td><h4><?php echo "$row[titulo]" ?></h4> </td>
            <td><h4><?php echo" $row[ciudad] ";?></h4></td>
            <td><h4><?php echo "$row[numero]" ;?></h4></td>
            <td><h4><?php echo "$"."$row[precioMinimo]" ?></h4></td>
            <td><h4><?php $fs=date('d/m/Y', strtotime($row['fechaInicioSubasta'])); echo "$fs"; ?></h4></td>  
            <td><h4><?php $fi=date('d/m/Y', strtotime($row['fechaInicioInscripcion'])); echo"$fi" ?></h4></td>
            <td><?php echo "<a href='cerrar_subasta.php?no=".$row['idSubasta']."'> <button type='button' class='btn btn-succes'>CERRAR</button> </a></td>"  ?>
         </tr>  
         <?php } }?>      
      
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