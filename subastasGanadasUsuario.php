<html>
<head>

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
    } ?>
</head>
<body>

<?php
$query = "SELECT  p.idPropiedad, p.titulo,p.localidad ,su.precioMinimo, su.fechaInicioSubasta, su.fechaFinSubasta, su.activa, su.idSubasta,
                  su.cerrada, su.year, su.idSemana
          FROM propiedad p INNER JOIN subasta su ON p.idPropiedad=su.idPropiedad";
            $result = mysqli_query($con, $query);
            $num=mysqli_num_rows($result); 

if ($num==0) {
  echo"<h4>NO SE HAN ENCONTRADO RESULTADOS</h4>";
 }
else{  ?>

<div class="container">

  <table class="table table-hover">
    <thead>
      <tr>
        <th>Subastas</th>
        <th>Titulo</th>
        <th>Localidad</th>
        <th>Semana</th>
        <th>Año</th>
        <th>Precio Inicial</th>
        <th>Precio Venta</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
<?php

//OBTIENE EL ID DEL USUARIO ACTUAL
  $id=($_SESSION['id']);
 
  while ($row = mysqli_fetch_array($result)){ 

      $actualizar=actualizar($row['idSubasta']);
      $row['activa']=$actualizar[0];
      $row['cerrada']=$actualizar[1];
       //selecciona para luego revisar que el usuario no este inscripto en la subasta    
       $Inscripto = "SELECT * FROM inscripto WHERE idPersona= $id";
       $resuInscripto = mysqli_query($con, $Inscripto);  
           
                  //VERIFICAR QUE EL USUSARIO ESTE O NO INSCRIPTO EN LA SUBASTA
                    $inscripto=false;
                      
                     while ($row2 = mysqli_fetch_array($resuInscripto)){
                              if ($row2['idSubasta']==$row['idSubasta']){
                                 $inscripto= true;  
                              }
                     }
                  //--------------------------------------------------------------------
                  //SI ESTA ACTIVA QUE LA MUESTRE
    if(($inscripto==true)&&($row['activa']==1)&&($row['cerrada']==1)){
      $consulWinner= "SELECT * FROM ganador WHERE idSubasta=$row[idSubasta]";
      $resultWinner = mysqli_query($con, $consulWinner);
      $num = mysqli_num_rows($resultWinner);
           
      if ($num==1){ //si hay un ganador de la subasta
          
        $rowWinner = mysqli_fetch_array($resultWinner);
        $consulPuja= "SELECT cantidad FROM puja WHERE idPuja=$rowWinner[idPuja]";
        $resultPuja = mysqli_query($con, $consulPuja);
        $rowPuja = mysqli_fetch_array($resultPuja);
        $pujaMaxima= $rowPuja['cantidad'];
        $winnerPersona=$rowWinner['idPersona'];
           
        if($winnerPersona==$id){ 

        //GANASTE LA SUBASTA!!
           

       // IMAGENES - COMIENZA LA PROYECCION           
      $imgs=ObtenerImgs($row['idPropiedad']);
    ?>
        <tr>
          <td> <?php echo '<img src="data:image/jpeg;base64,'.base64_encode($imgs[0]).'" style=width:30% />';?></td>
          <td><h4><?php echo "$row[titulo]" ?></h4> </td>
          <td><h4><?php echo" $row[localidad] ";?></h4></td>
          <td><h4><?php $week_start = new DateTime(); $week_start->setISODate((int)$row['year'],(int)$row['idSemana']);
                                           $fi= $week_start->format('d/m');echo "$fi" ;?></h4></td>
          <td><h4><?php  $fi= $week_start->format('Y');echo "$fi" ;?></h4></td>
          <td><h4><?php echo "$"."$row[precioMinimo]" ?></h4></td>
            
          <td><h4><?php echo "$"."$pujaMaxima" ?></h4></td>
            <?php
            //CALIFICAR SI AUN NO HA CALIFICADO
              $query2 = "SELECT * FROM valoracion WHERE idSubasta=$rowWinner[idSubasta]";
                    $result2 = mysqli_query($con, $query2);
                    if(mysqli_num_rows($result2)==0){ ?> 
                 
          <td><?php echo "<a href='calificar.php?sub=".$row['idSubasta']."&prop=".$row['idPropiedad']."'> <button type='button' class='btn btn-succes'>CALIFICAR</button> </a></br></td>" ;}?> 
        </tr>  
         <?php } } }
       } //fin del while de la filas de subastas
?>      
      </tbody>
  </table>
 </div> 
   <?php


   } //else de tabla con resultados

            mysqli_free_result($result);
            mysqli_close($con);

?>
</body>
</html>