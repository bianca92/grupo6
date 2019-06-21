


<?php	
	include("clases.php");  
    include("cabecera.php");
    include("conexion.php");


$link=conectar();

$propiedad=$_POST['propiedad'];

$semana=$_POST['datepicker'];
$precioInicial=$_POST['precioInicial'];

#W (mayúscula) te devuelve el número de semana
#w (minúscula) te devuelve el número de día dentro de la semana (0=domingo, #6=sabado)

//OBTENGO EL NUMERO DE LA SEMANA QUE EL ADMIN INGRESO
$numero=date('W', strtotime($semana));
//OBTENGO EL MES
$mes=date('m', strtotime($semana));
//OBTENGO EL AÑO
$year=date('Y', strtotime($semana));
if($mes=="12" && $numero=="1"){
	$year=$year+1;
}
if($mes=="01" && $numero=="53"){
	$year=$year-1;
}
if($mes=="01" && $numero=="52"){
	$year=$year-1;
}

//OBTENGO EL INICIO DE LA SEMANA QUE EL ADMIN INGRESO
$week_start = new DateTime();
	//le paso como parametros el año, la semana
$week_start->setISODate($year,$numero);
     //CREO LA NUEVA FECHA, QUE ES EL INICIO DE LA SEMANA
$fi= $week_start->format('Y-m-j');

        

$insDesde=strtotime ( '-6 month' , strtotime ( $fi ) ) ;
$insDesde = date ( 'Y-m-j' , $insDesde);

$insHasta=strtotime ( '+7 day' , strtotime ( $insDesde ) ) ;
$insHasta = date ( 'Y-m-j' , $insHasta);

$ofDesde=strtotime ( '-5 month' , strtotime ( $fi) ) ;
$ofDesde = date ( 'Y-m-j' , $ofDesde);

$ofHasta=strtotime ( '+7 day' , strtotime ( $ofDesde ) ) ;
$ofHasta = date ( 'Y-m-j' , $ofHasta);

$var_consulta="INSERT INTO subasta (idPropiedad,precioMinimo, idSemana, fechaInicioInscripcion, fechaFinInscripcion,fechaInicioSubasta, fechaFinSubasta,activa,cerrada,year,cancelada)
                     values('$propiedad','$precioInicial','$numero','$insDesde','$insHasta','$ofDesde','$ofHasta',0,0, '$year',0)";
            	
$var_resultado = $link->query($var_consulta);

$var_consulta="INSERT INTO semanatienepropiedad (idSemana,idPropiedad,year)
                     values('$numero', '$propiedad','$year')";
            	
$var_resultado = $link->query($var_consulta);




            mysqli_close($link);




echo "<script> window.history.go(-2);</script>";

 

?>