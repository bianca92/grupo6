<?php
	
	include("clases.php");  
    include("cabecera.php");
    include("conexion.php");




$link=conectar();

$propiedad=$_POST['propiedad'];

$year=$_POST['year'];
$numSemana=$_POST['semana'];
$precioInicial=$_POST['precioInicial'];
$insDesde=$_POST['insDesde'];
$insHasta=$_POST['insHasta'];
$ofDesde=$_POST['ofDesde'];
$ofHasta=$_POST['ofHasta'];

// busco el id de semana en la tabla semana para insertar en la nueba tabla
$consulta= "SELECT idSemana FROM semana WHERE numero='$numSemana' ";
$resultado = $link->query($consulta);
$row = mysqli_fetch_array($resultado);
$idSemana=$row['idSemana'];
mysqli_free_result($resultado);

// cargo la tabla semana tiene propiedad
$consulta2="INSERT INTO semanatienepropiedad (idSemana, idPropiedad, year)values('$idSemana','$propiedad','$year')";
            $resu = $link->query($consulta2); 
mysqli_free_result($resu);

	
$var_consulta="INSERT INTO subasta (precioMinimo, idSemana, fechaInicioSubasta, fechaFinSubasta, fechaInicioInscripcion, fechaFinInscripcion)
                     values('$precioInicial','$idSemana','$ofDesde','$ofHasta','$insDesde','$insHasta')";
            	
$var_resultado = $link->query($var_consulta);



mysqli_free_result($var_resultado);
            mysqli_close($con);



header("Location:index.php");

 
?>