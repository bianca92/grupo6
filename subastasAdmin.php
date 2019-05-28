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


$query = "SELECT s.numero, p.idPropiedad, p.titulo,p.ciudad ,su.precioMinimo, su.fechaInicioSubasta, su.fechaInicioInscripcion, 
                 su.idSubasta,su.activa,su.fechaFinInscripcion, su.year
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
      </tr>
    </thead>
    <tbody>
  

    <?php 
 $auxiliar=true;

    while ($row = mysqli_fetch_array($result))  { 
      $actualizar=actualizar($row['idSubasta']);
       $row['activa']=$actualizar[0];
      $row['cerrada']=$actualizar[1];

           if($row['activa']!=1){

             $auxiliar=false;
    $imgs=ObtenerImgs($row['idPropiedad']);
    

      // PASADA LA FECHA DE FIN inscripcion EL BOTON CERRAR DEBE DESHABILITARSE
       $configuracion="active"; $accion='';
       if ($row['fechaFinInscripcion']<=date("Y-m-d") ){
          $configuracion="disabled"; $accion="#";
      }
      else{$accion="cerrar_subasta.php?no=".$row['idSubasta']."";}
      //activas segun la fecha y que no se haya presionado el boton cerrar

   
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
            <td><?php echo "<a href=$accion> <button type='button' class='btn btn-succes ".$configuracion."'>CERRAR INSCRIPCION</button></a></td>"  
            ?>
             <td><?php echo "<a href='inscriptos.php?sub=".$row['idSubasta']."'> <button type='button' class='btn btn-succes'>INSCRIPTOS</button> </a></br>" ;?>  
         </tr>  
         <?php } }?>      
      
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