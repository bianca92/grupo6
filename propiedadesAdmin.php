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


$query = "SELECT * FROM propiedad ORDER BY titulo";
            $result = mysqli_query($con, $query);
            $num=mysqli_num_rows($result); 


$fecha_actual = date('Y-m-d');


 
?>          



  <div class="container">

    <a href="propiedades.php" class="btn btn-warning" float="left">NUEVO</a>


    <!-- EL FORM DE LA BUSQUEDA -->
    <form method="GET" action="propiedadesAdmin.php" >
 <p></i><input type="text" name="lugar" required="required" placeholder="Ingrese titulo o lugar" />
 <input type="submit" value="Buscar"/> 
</form>

<?php


if (!empty($_GET)){
$filtro=$_GET['lugar'];


}
         
     ?>
   
 <?php
   

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
                  echo"<h4>NO SE HAN ENCONTRADO RESULTADOS</h4>"; } ?>
 
    <?php 
   $auxiliar=false;

    while ($row = mysqli_fetch_array($result))  { 

       if (!empty($_GET)){
            
           //si se recibio GET pero no hay propiedad
            $muestra=false;
          
        
    
           // busco si el lugar o titulo ingresado se encuentra entre la info de la propiedad  
            $ubicacion1 = stripos($row['pais'], $filtro);
             $ubicacion2 = stripos($row['provincia'], $filtro);
              $ubicacion3 = stripos($row['localidad'], $filtro);
             $titulo = stripos($row['titulo'], $filtro);
          
                
          
         if($ubicacion1!==false or $ubicacion2!==false or $ubicacion3!==false or $titulo!==false){
          
          $muestra=true;
         
                    }
       
      
      }

     else {//si no se recibio nada por GET que me muestre todo
 
             $muestra=true;
      }

      if($muestra==true){
     $auxiliar=true;

      $imgs=ObtenerImgs($row['idPropiedad']); ?>
      <tr>
            <td><?php echo '<img src="data:image/jpeg;base64,'.base64_encode($imgs[0]).'" style=width:20% />';?></td>
            <td><h4><?php echo "$row[titulo]" ?></h4> </td>
             <td><h4><?php echo" $row[pais] ";?></h4></td>
              <td><h4><?php echo" $row[provincia] ";?></h4></td>
            <td><h4><?php echo" $row[localidad] ";?></h4></td>
            <td><?php echo "<a href='modificar_propiedad.php?no=".$row[0]."'> <button type='button' class='btn btn-succes'>MODIFICAR</button> </a>" ;?></td>
            <td><?php echo "<a href='alta_subasta.php?no=".$row[0]."'> <button type='button' class='btn btn-succes'>SUBASTAR</button> </a>" ;?></td>
         </tr>  
         <?php } 

       } if($auxiliar==false){echo"<h4>NO SE HAN ENCONTRADO RESULTADOS</h4>"; 
}?>  
           
      
      </tbody>
  </table>
</div>
     

 </div>

 <?php
 
            mysqli_free_result($result);
            mysqli_close($con);

?> 
   
   </html>