
<html>

<head>
       
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <meta http-equiv="Content-Type" content="text/html" charset="UTF-8"/>
  <style type="text/css"></style>
 <link rel="stylesheet" type="text/css" href="css/estilos.css">


</head>
<body>
	<div>
    <?php
   	$todas= "listaHotSale.php";
	$enHotSale= "listaActualHotSale.php";
	$vendidasHS="listaHotSaleVendidas.php";
	$sinVenderHS="listaHotSaleSinVender.php";
 
  //datos hot sale
    $consultaHotSale="SELECT * FROM config_hotsale";
    $resu2 =  mysqli_query(mysqli_connect('localhost','root','','grupo6'),$consultaHotSale); 
    $row2=mysqli_fetch_array($resu2);

    //CREO LA FECHA DEL HOTSALE DE ESTE AÑO
    $añoH=date("Y");
    $fecha="$row2[dia]-$row2[mes]-$row2[year]";
    $fechaHotsale= strtotime ( 'd-m-Y' , strtotime ( $fecha ) ) ;
    $fechaH=strtotime($fechaHotsale);

    //me fijo que el hotsale de este año no haya pasado
    $fecha_actual=date('d-m-Y');

    if ($fecha_actual > $fechaHotsale){
       $añoH=$añoH + 1;
       $fecha="$row2[dia]-$row2[mes]-$row2[year]";
       //creo la fecha definitiva del hotsale
       $fechaHotsale= date ( 'd-m-Y' , strtotime ( $fecha ) ) ;
       //la paso a un formato comparable
       $fechaH=strtotime($fechaHotsale);

    }
    $fechaH=date('d/m/Y', $fechaH);

	

	?>
  
<div id="header" style="margin-top: -20px; background-color: #FF7516">

     <div class="container-fluid">
  	


   	<ul class="menu" style="float:left;">
        <li><h4>SEMANAS EN HOT SALE:</h4></li>
      <li><a href=<?php echo $todas; ?>></i>TODAS</a></li>
      <li><a href=<?php echo $enHotSale; ?>></i>ACTUALMENTE PUBLICADAS</a></li>
      <li><a href=<?php echo $vendidasHS; ?>></i>VENDIDAS</a></li>
      <li><a href=<?php echo $sinVenderHS; ?>></i>SIN VENDER</a></li>

    </ul>
    <ul class="menu" style="float: right;">
      <li><h4 style='color:#FFFFFF'>El proximo Hot Sale sera el <?php echo"$fechaH";?> </h4></li>
      
    </ul>
   </div>
   </div>

</div>

	
</body>

</html>