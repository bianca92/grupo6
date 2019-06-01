<html>


<?php

include("clases.php");  
include("cabecera.php");
include("conexion.php");
include("mostrarImagen.php");
include("actualizarSegunFecha.php");
$con=conectar();

  if(isset($_GET['msj'])){
       $mensaje= $_GET['msj'];
//

    if($mensaje="2")
       echo"<script> alert ('DEBE ESTAR REGISTRADO PARA ACCEDER')</script>"; 
    }

$query = "SELECT  p.idPropiedad, p.titulo,p.ciudad ,su.precioMinimo, su.fechaInicioSubasta, su.fechaFinSubasta, su.activa, su.idSubasta, su.cerrada, su.year, su.idSemana
          FROM propiedad p INNER JOIN subasta su ON p.idPropiedad=su.idPropiedad";
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
        <th>Inicio Subasta</th>
        <th>Fin Subasta</th>
        <th>Precio Venta</th>
        <th>Ganador</th>
      </tr>
    </thead>
    <tbody>
  

    <?php 
 $auxiliar=true;
    while ($row = mysqli_fetch_array($result))  { 
      $actualizar=actualizar($row['idSubasta']);
      $row['activa']=$actualizar[0];
      $row['cerrada']=$actualizar[1];
    //<img src=mostrarImagen.php?idPropiedad=".$row['idPropiedad']." style=width:60%"
    if(($row['activa']==1)&&($row['cerrada']==1)){
       $auxiliar=false;
      //OBTENGO PUJA GANADORA 

       $pujaMaxima= $row['precioMinimo'];
       $pujaMaximaPersona="";
       $mailPer="NO HUBO GANADOR";

           $var_consulta4= "SELECT cantidad, idPersona FROM puja WHERE idSubasta=$row[idSubasta]";
            $result4 = mysqli_query($con, $var_consulta4);
            $numPuja = mysqli_num_rows($result4);
            //CHEQUEA SI HUBO PUJAS PARA ESA PROPIEDAD
            if($numPuja!=0){

              //OBTENGO EL MONTO MAXIMO DE PUJA Y QUIEN LO HIZO (GANADOR)
              while ($row4 = mysqli_fetch_array($result4)){
                  if ($row4['cantidad']>=$pujaMaxima){
                        $pujaMaxima=$row4['cantidad'];
                        $pujaMaximaPersona= $row4['idPersona'];  
                          }
                }
                //BUSCA LOS DATOS DEL GANADOR
                
                $consuPers="SELECT email FROM persona WHERE idPersona=$pujaMaximaPersona";
                $resuPer = mysqli_query($con,$consuPers);
                $numPer=mysqli_num_rows($resuPer);
                $rowPer = mysqli_fetch_array($resuPer);
                $mailPer = $rowPer['email'];
              }

    $imgs=ObtenerImgs($row['idPropiedad']);
    ?>
        <tr>
          <td> <?php echo '<img src="data:image/jpeg;base64,'.base64_encode($imgs[0]).'" style=width:30% />';?></td>
           <td><h4><?php echo "$row[titulo]" ?></h4> </td>
            <td><h4><?php echo" $row[ciudad] ";?></h4></td>
            <td><h4><?php $week_start = new DateTime(); $week_start->setISODate((int)$row['year'],(int)$row['idSemana']);
                                           $fi= $week_start->format('d/m');echo "$fi" ;?></h4></td>
             <td><h4><?php  $fi= $week_start->format('Y');echo "$fi" ;?></h4></td>
            <td><h4><?php echo "$"."$row[precioMinimo]" ?></h4></td>
            <td><h4><?php $fi=date('d/m/Y', strtotime($row['fechaInicioSubasta'])); echo"$fi" ?></h4></td>
            <td><h4><?php $fs=date('d/m/Y', strtotime($row['fechaFinSubasta'])); echo "$fs"; ?></h4></td>  
            <td><h4><?php echo "$"."$pujaMaxima" ?></h4></td>
            <td><h4><?php echo "$mailPer" ?></h4></td>
            <td><?php echo "<a href='listaPujas.php?sub=".$row['idSubasta']."'> <button type='button' class='btn btn-succes'>PUJAS</button> </a></br>" ;?> 
            <td><?php echo "<a href='inscriptos.php?sub=".$row['idSubasta']."'> <button type='button' class='btn btn-succes'>INSCRIPTOS</button> </a></br>" ;?>  
           
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