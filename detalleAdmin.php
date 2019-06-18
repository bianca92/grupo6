<html>
<head>

<?php
include("clases.php");  
include("cabecera.php");
include("conexion.php");
include("mostrarImagen.php");

$propiedad=$_GET['prop'];


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

}?>
<link  href="css/bootstrap1.min.css">
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
//------------------------------------------------------------------------------------------  ?>
 
<div class="panel panel-info">
      <div class="panel-heading">IMAGENES</div>
      <div class="panel-body">
      <?php  $imgs=ObtenerImgs($row['idPropiedad']);
      $i=0; 
      while($i < count($imgs)) { ?>
             
        <div class="col-sm-4">
        <div class="thumbnail" >
              <?php echo '<img src="data:image/jpeg;base64,'.base64_encode($imgs[$i]).'" style="width:822px;height:300px;" />'; $i=$i+1;?>
        </div></div>
    <?php   }
           ?>
</div></div>
<div class="panel panel-info">
      <div class="panel-heading">TITULO</div>
      <div class="panel-body"> 
<h3><?php echo" $row[titulo]"; ?></h3>
</div></div>
<div class="panel panel-info">
      <div class="panel-heading">PUNTUACION</div>
      <div class="panel-body">

<h1><?php for ($i=1; $i <=puntuacion($propiedad) ; $i++) { 
  echo"<span class='glyphicon glyphicon-star'></span>";
}?></h1>
</div></div>
<div class="panel panel-info">
      <div class="panel-heading">UBICACION</div>
      <div class="panel-body">
        <h5>DIRECCION: <?php echo "  $row[direccion]"; ?></br>
          LOCALIDAD: <?php echo "  $row[localidad]"; ?> </br> 
          PROVINCIA: <?php echo "  ".$row['provincia']; ?> </br>
          PAIS: <?php echo "$row[pais]"; ?> </br></h5>
</div></div>
<div class="panel panel-info">
      <div class="panel-heading">DESCRIPCION</div>
      <div class="panel-body">
<h5><?php echo "$row[descripcion]"; ?> </h5>
</div></div>


<?php //SEMANAS PARA UNA PROPIEDAD 
 ?>
	<div class="panel panel-info">
      <div class="panel-heading">SEMANAS DISPONIBLES</div>
      <div class="panel-body">
      <?php
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
           echo "FECHA: $week_start </a>".estadoDeSubasta($week_start,$propiedad)."</br>";} 
           }}      
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