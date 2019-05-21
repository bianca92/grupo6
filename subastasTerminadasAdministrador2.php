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
        <th>precio venta</th>
        <th>ganador</th>
      </tr>
    </thead>
    <tbody>
  

    <?php while ($row = mysqli_fetch_array($result))  { 
    //<img src=mostrarImagen.php?idPropiedad=".$row['idPropiedad']." style=width:60%"
    if(($row['activa']==1)&&($row['cerrada']==1)){

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
            <td><h4><?php echo "$row[numero]" ;?></h4></td>
            <td><h4><?php echo "$"."$row[precioMinimo]" ?></h4></td>
            <td><h4><?php echo "$row[fechaInicioSubasta]" ?></h4></td>
            <td><h4><?php echo "$row[fechaInicioInscripcion]" ?></h4></td>
            <td><h4><?php echo "$pujaMaxima" ?></h4></td>
            <td><h4><?php echo "$mailPer" ?></h4></td>
           
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