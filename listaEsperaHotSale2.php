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







 
if (false) { //--------------------------------------------------------------------------  MODIFICAR ---------------------
  echo "NO HA SELECCIONADO NINGUNA SUBASTA PARA PONER EN HOT SALE";
}
else{    
//obtengo el arreglo con los id de las subastas seleccionadas para hotsale

$paraHotSale = $_POST['check'];
$cantHotSale = count($paraHotSale); ?>

  <div class="container">

    <div>
      <h4>INDIQUE EL PRECIO DE VENTA EN HOT SALE:</h4>
      <form name="formulario" action="listaEsperaHotSale3.php" method="POST" >
      <table class="table table-hover">
         <thead>
            <tr>
            
            <th>Subastas</th>
            <th>Titulo</th>
            <th>Localidad</th>
            <th>Semana</th>
            <th>Año</th>    
            <th>Precio Inicial</th>
            <th>Inscriptos</th>
            <th>Precio Hot Sale</th>
            </tr>
         </thead>
        <tbody>
  
        <?php 
         
         

         for($n=0; $n<$cantHotSale;$n++)  { 

         	

             //datos subasta y propiedad
             $query = "SELECT p.idPropiedad, p.titulo,p.localidad ,su.precioMinimo, su.idSubasta, su.year, su.idSemana
             		FROM propiedad p INNER JOIN subasta su ON p.idPropiedad=su.idPropiedad
             		WHERE su.idSubasta = '$paraHotSale[$n]' ";
			 $result = mysqli_query($con, $query);
			 $row = mysqli_fetch_array($result);

                             
                 $imgs=ObtenerImgs($row['idPropiedad']);
      ?>
                 <tr>
                  
                  <td> <?php echo '<img src="data:image/jpeg;base64,'.base64_encode($imgs[0]).'" style=width:30% />';?></td>
                  <td><h4><?php echo "$row[titulo]" ?></h4> </td>
                  <td><h4><?php echo" $row[localidad] ";?></h4></td>
                  <td><h4><?php $week_start = new DateTime(); $week_start->setISODate((int)$row['year'],(int)$row['idSemana']); $fi= $week_start->format('d/m');echo "$fi" ;?></h4></td>
                  <td><h4><?php  $fi= $week_start->format('Y');echo "$fi" ;?></h4></td>
                  <td><h4><?php echo "$"."$row[precioMinimo]" ?></h4></td>        <?php


                  $queryI = "SELECT * FROM inscripto WHERE idSubasta = '$row[idSubasta]'";
                  $resultI = mysqli_query($con, $queryI);
                  $numI=mysqli_num_rows($resultI); 
                  if ($numI==0) {  // no hubo inscriptos  
                    ?>
                    <td><h4><?php echo "NO"?></h4></td>
                    <?php
                  }
                  else{  ?>
                    <td><h4><?php echo "SI"?></h4></td>
                    <?php

                  }

                  ?>
                  <input type="hidden" name="subastaHotSale[]" value='<?php echo "$row[idSubasta]"?>'>
                  <td><input  type="number" name="precioHotSale[]"  required="required"></td>
                  
                 </tr>  
      <?php } 
         ?>      
      
        </tbody>
      </table>

      <input type="submit" name="login" value="Guardar" class="button" />
      </form>
      <?php
}  

mysqli_free_result($result);
mysqli_close($con);

?> 
  
</div>
     

 </div>

 
   
   </html>