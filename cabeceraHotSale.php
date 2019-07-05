
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
   </div>
   </div>

</div>

	
</body>

</html>