<html>
<head>

<?php

include("clases.php");  
include("cabecera.php");
include("conexion.php");
include("mostrarImagen.php");



$propiedad=$_GET['prop'];
$semanas=unserialize($_GET['semanas']);
$busqueda=$_GET['busqueda'];

$con=conectar();
include("funciones.php");
//para que no se pueda acceder a esta pagina si no esta logeado
try{
$login= new Login();
$login->autorizar();
}
catch(Exception $e){
   echo $e->getMessage();
   header("Location:index.php");

}
?>
<link  href="css/bootstrap1.min.css">
<?php//nombre de los botones de la galeria
    $nombre=1; ?>
</head>
<body>
  <div class="container">
<?php

//TrAER PROPIEDAD
$query = "SELECT * FROM propiedad WHERE idPropiedad=$propiedad";
            $result = mysqli_query($con, $query);
            $num=mysqli_num_rows($result);
            $row = mysqli_fetch_array($result);


//MOSTRAR DATOS

//MOSTRAR IMAGENES
//------------------------------------------------------------------------------------------
?>
<div class="row">
<?php//nombre de los botones de la galeria
    //$nombre=1; ?>
<div class="col-sm-6">

        <div class="thumbnail" >
 <!-- Galeria Carrusel -->
 
             <div id="<?php echo $nombre; ?>" class="carousel slide" data-ride="carousel">
        
        <!-- contenedor de los slide -->
        
        <div class="carousel-inner" role="listbox">
          
          <?php  $imgs=ObtenerImgs($row['idPropiedad']);?>
          <!-- Indicadores -->
          <ol class="carousel-indicators">
            <!-- crear primer indicador -->
          <li data-target="#<?php echo $nombre; ?>" data-slide-to="0" class="active" ></li>
           <?php   
            //crear los indicadores para las imagenes
             for($i=1; $i < count($imgs); $i++){ 
              ?>          
                    <li data-target="#<?php echo $nombre; ?>" data-slide-to="<?php echo $i; ?>" ></li>
                  <?php    
                } ?>      
        </ol>

          <!-- La primera Imagen -->
          <div class="item  active">
            <?php echo '<img src="data:image/jpeg;base64,'.base64_encode($imgs[0]).'" style="width:550px;height:400px;"> '?> 
            <!-- style="width:822px;height:322px;" --> <!-- YA ME QUEDO CLARO POR QUE TODAS LAS IMAGENES MISMO TAMAÑO -->
            <div class="carousel-caption">
              
            </div>
          </div>
          <!-- Las demas imagenes -->
<?php       
            for($i = 1; $i < count($imgs); $i++){ ?>
          <div class="item ">
            <?php echo '<img src="data:image/jpeg;base64,'.base64_encode($imgs[$i]).'" style="width:550px;height:400px;">'?>
            <div class="carousel-caption">
             
            </div>
          </div>
        <?php }
          ?>      
        </div>
        <!-- Controles -->
         <div class="caption">
        <a href="#<?php echo $nombre; ?>" class="left carousel-control" role="button" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
          <span class="sr-only">Anterior</span>
        </a>
        <a href="#<?php echo $nombre; ?>" class="right carousel-control" role="button" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
          <span class="sr-only">Siguiente</span>
        </a>
        </div>
 
      </div>
      <!-- Aca Termina Galeria Carrusel -->

  </div>
  <?php // $nombre= $nombre + 1; ?>
</div>
<div class="col-sm-6">

<h1><?php echo" $row[titulo]"; ?>

<?php for ($i=1; $i <=puntuacion($propiedad) ; $i++) { 
  echo"<span class='glyphicon glyphicon-star'></span>";
}?>
</h1>
<table class="table">
  <thead>
      <tr>
        <?php
            $queryPer = "SELECT * FROM persona WHERE idPersona=($_SESSION[id])";
            $resulPer = mysqli_query($con, $queryPer);
            $rowPer = mysqli_fetch_array($resulPer);
            
         if($rowPer['tipoU']=='premium') { ?>
        <button class="btn btn-info " ><a href="comprarPremium.php">COMPRAR</a></button>
     <?php }
      ?></tr>
  </thead>
  <tbody>
<tr> 

</tr>    
<tr>
  <th><h5>UBICACION</h5></th>
  <td><h5>DIRECCION: <?php echo "$row[direccion]"; ?></br>
          LOCALIDAD: <?php echo "$row[localidad]"; ?> </br> 
          PROVINCIA: <?php echo "$row[provincia]"; ?> </br>
          PAIS: <?php echo "$row[pais]"; ?> </br></h5></td>
</tr>
<tr>
 <th><h5>DESCRIPCION:</br> </h5> </th> 
 <td><h5><?php echo "$row[descripcion]"; ?> </h5></td>
</tr>
</tbody>
</table>
  </div>
<?php //SEMANAS PARA UNA PROPIEDAD 
 

?>
<div class="col-sm-12">
	<div class="panel panel-info">
      <div class="panel-heading">SEMANAS DISPONIBLES</div>
      <div class="panel-body">
      <?php
      if($busqueda==1){
            foreach ($semanas as &$fecha) {
               if($fecha!=""){
                  //tengo el idsemana de la fecha disponible para recuperar datos de subasta
                  $fecha2 = new DateTime($fecha);
                  $semana = $fecha2->format('W');
                    $query3 = "SELECT * FROM subasta WHERE idPropiedad=$propiedad and idSemana=$semana";
                    $result3 = mysqli_query($con, $query3);
                    $row3 = mysqli_fetch_array($result3);
                    echo "<a href='verSemana.php?sub=$row3[idSubasta]'>FECHA: $fecha </a>". estadoDeSubasta($fecha,$propiedad)."</br>";
                           }  } }
      if ($busqueda==0) {
            $query2 = "SELECT * FROM subasta WHERE idPropiedad=$propiedad";
            $result2 = mysqli_query($con, $query2);
            if (mysqli_num_rows($result2)==0) {
              echo "NO HAY RESULTADOS";

            }
            else{
            while($row2 = mysqli_fetch_array($result2)){


          
           $week_start = new DateTime(); $week_start->setISODate((int)$row2['year'],(int)$row2['idSemana']);
           $week_start= $week_start->format('Y-m-d');
           $week_start= date('d-m-Y', strtotime($week_start));
           if($row2['cerrada']==0){
            //echo "<a href='verSemana.php?fecha=$week_start&prop=$propiedad'>FECHA: $week_start </a>".estadoDeSubasta($week_start,$propiedad)."</br>"; 
           echo "<a href='verSemana.php?sub=$row2[idSubasta]'>FECHA: $week_start </a>".estadoDeSubasta($week_start,$propiedad)."</br>";} 
           }}
      
      }
?> 
    </div>
    </div>
 <?php // comentarios de la publicacion 
 ?>
 <h3>COMENTARIOS</h3>
  <div class="panel panel-default">
    <div class="panel-body">
 <?php
 $var_consulta3= "SELECT * FROM valoracion WHERE idPropiedad='$propiedad'";
 $var_resultado3 = mysqli_query($con, $var_consulta3); 
 if (mysqli_num_rows($var_resultado3)==0) {
              echo "NO HAY RESULTADOS";
}
else{
 while ($row3=  mysqli_fetch_array($var_resultado3)) {
  echo"<h5>'$row3[comentario]'</h5></br>";
  //guardar nombre de usuario opcional
}}
 ?>  
 </div>
  </div> 
</div>  
 
<script src="jquery-3.2.1.min.js"></script>
<script src="jquery-3.2.1.min.js"></script>
<script src="js/bootstrap1.min.js"></script><script src="js/bootstrap1.min.js"></script>               
</div>
</body>

</html>