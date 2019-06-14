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
   
	$todo= "actividadUsuario.php";
	$inscripciones= "actividadInscripciones.php";
	$pujas="actividadPujas.php";
	$compras="actividadCompras.php";
	$subastas="actividadSubastas.php";
	$subastasGanadas="actividadSubastasGanadas.php";
	$subastasPerdidas="actividadSubastasPerdidas.php";	
	$compraPremium="actividadCompraPremium.php";
	$hotSale="actividadHotSale.php";
	$comentarios="actividadComentarios.php";

	?>
  
<div id="header" style="margin-top: -20px; background-color: #50C0F2">

     <div class="container-fluid">
  	


   	<ul class="menu" style="float:left;">
        <li><a style="color: #000" href=#></i>MI ACTIVIDAD:</a></li>
      <li><a href=<?php echo $todo; ?>></i>TODO</a></li>
      <li><a href=<?php echo $inscripciones; ?>></i>INSCRIPCIONES</a></li>
      <li><a href=<?php echo $pujas; ?>></i>PUJAS</a></li>
      <li><a href=<?php echo $compras; ?>></i>COMPRAS</a>
        <ul class="submenu" style="background-color: #50C0F2">            
           <li><a href=<?php echo $subastas; ?>></i>SUBASTAS</a>
              <ul class="submenu2">
                 <li><a href=<?php echo $subastasGanadas; ?>>SUBASTAS GANADAS</a></li>
                 <li><a href=<?php echo $subastasPerdidas; ?>>SUBASTAS PERDIDAS</a></li>
              </ul>
           </li>
           <li><a href=<?php echo $compraPremium; ?>></i>COMPRAS PREMIUM</a></li>
           <li><a href=<?php echo $hotSale; ?>></i>COMPRAS HOT SALE</a></li>
        </ul>
      </li>
      <li><a href=<?php echo $comentarios; ?>></i>COMENTARIOS Y PUNTUACIONES</a></li>

    </ul>
   </div>
   </div>

</div>

	
</body>

</html>


