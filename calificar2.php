<?php	
	include("clases.php");  
    include("cabecera.php");
    include("conexion.php");


$link=conectar();
 $id=($_SESSION['id']);
 $fecha=date('Y-m-j-H:i');

$propiedad=$_POST['propiedad'];

$subasta=$_POST['subasta'];
$estrellas=$_POST['estrellas'];

$opinion=$_POST['opinion'];


$var_consulta="INSERT INTO valoracion (comentario,puntuacion, idPropiedad,idPersona,fecha, idSubasta)
                     values('$opinion','$estrellas','$propiedad','$id','$fecha','$subasta')";
            	
$var_resultado = $link->query($var_consulta);






 mysqli_close($link);




echo "<script> window.history.go(-2);</script>";

 

?>