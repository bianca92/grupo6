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

$query = "SELECT s.numero, p.idPropiedad, p.titulo,p.ciudad ,su.precioMinimo, su.fechaInicioSubasta, su.fechaInicioInscripcion, su.activa, su.idSubasta, su.cerrada, su.year
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
        <th>Titulo</th>
        <th>Ciudad</th>
        <th>Semana</th>
        <th>Año</th>
        <th>Precio Inicial</th>
        <th>Inicio Inscripcion</th>
        <th>Inicio Subasta</th>
        <th>Puja Actual</th>
      </tr>
    </thead>
    <tbody>
  

    <?php 
 $auxiliar=true;

    while ($row = mysqli_fetch_array($result))  { 
    //<img src=mostrarImagen.php?idPropiedad=".$row['idPropiedad']." style=width:60%"
    if(($row['activa']==1)&&($row['cerrada']!=1)){
       $auxiliar=false;
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
            <td><h4><?php echo "$row[year]" ;?></h4></td>
            <td><h4><?php echo "$"."$row[precioMinimo]" ?></h4></td>
            <td><h4><?php $fi=date('d/m/Y', strtotime($row['fechaInicioInscripcion'])); echo"$fi" ?></h4></td>
            <td><h4><?php $fs=date('d/m/Y', strtotime($row['fechaInicioSubasta'])); echo "$fs"; ?></h4></td>  
            <td><h4><?php echo "$"."$pujaMaxima" ?></h4></td>
            <td><?php echo "<a href='cerrar_subastaActiva.php?pugano=".$pujaMaximaPuja."&sub=".$row['idSubasta']."'> <button type='button' class='btn btn-succes'>CERRAR SUBASTA</button> </a></br>" ;?>
                 </br><a href="#"><button type='button' class='btn btn-succes'>INSCRIPTOS</button></a></td>
         </tr>  
         <?php } } ?>      
      
      </tbody>
  </table>
  <?php
 if ($auxiliar==true){
    echo"<tr><td><h4>NO SE HAN ENCONTRADO RESULTADOS</h4></td></tr>";
   } }  

            mysqli_free_result($result);
            mysqli_close($con);

?> 
</div>
     

 </div>


   
   </html>