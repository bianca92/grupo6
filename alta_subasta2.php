


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


//VER SI EXISTE UNA SUBASTA PARA ESA SEMANA Y PROPIEDAD
$consulta1="SELECT idSemana, idPropiedad FROM subasta WHERE idPropiedad=$propiedad AND idSemana=$idSemana AND year=$year";
$resul1 =$link->query($consulta1);
$num=mysqli_num_rows($resul1); 

if($num==1) { 
    
    echo '<script> alert("YA EXISTE UNA SUBASTA EN ESA SEMANA");</script>';
    echo "<script> window.location ='alta_subasta.php?no=".$propiedad."' ;</script>";

}

else{

// cargo la tabla semana tiene propiedad
$consulta2="INSERT INTO semanatienepropiedad (idSemana, idPropiedad, year)values('$idSemana','$propiedad','$year')";
            $resu = $link->query($consulta2); 
mysqli_free_result($resu);

	
$var_consulta="INSERT INTO subasta (idPropiedad,precioMinimo, idSemana, fechaInicioSubasta, fechaFinSubasta, fechaInicioInscripcion, fechaFinInscripcion,year)
                     values('$propiedad','$precioInicial','$idSemana','$ofDesde','$ofHasta','$insDesde','$insHasta', '$year')";
            	
$var_resultado = $link->query($var_consulta);



mysqli_free_result($var_resultado);
            mysqli_close($con);




header("Location:subastasAdmin.php");
}
 

?>