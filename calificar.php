<html>
<head>
<?php

		include("cabecera.php");
		include("clases.php");
		include("conexion.php");
		
$propiedad=$_GET['prop'];
$subasta=$_GET['sub'];

?>
<title>SUBASTA</title>
	
</head>
<body>
		
<div id="wrapper">


<form name="formulario" action="calificar2.php" method="POST" class="login-form" enctype="multipart/form-data" onsubmit="return validareg();">
				
<div class="header">
	<h3>CONTANOS TU EXPERIENCIA</h3>
</div>
			 
				
<div class="content">

<input type="hidden" name="propiedad" value='<?php echo "$propiedad" ?>' size="25">	
<input type="hidden" name="subasta" value='<?php echo "$subasta" ?>' size="25">

<div class="valoracion">
  <input id="radio1" type="radio" name="estrellas" value="5" required="required">
  <label for="radio1">★</label>
  <input id="radio2" type="radio" name="estrellas" value="4" required="required">
  <label for="radio2">★</label>
  <input id="radio3" type="radio" name="estrellas" value="3" required="required">
  <label for="radio3">★</label>
  <input id="radio4" type="radio" name="estrellas" value="2" required="required">
  <label for="radio4">★</label>
  <input id="radio5" type="radio" name="estrellas" value="1" required="required">
  <label for="radio5">★</label>
</div>

        <label for="opinion">Deja tu opinión: </br></label>
        <textarea rows='4' cols='56' id='opinion' name='opinion' class="input username" required="required"></textarea><br/>
     
</div>

<div class="footer">
	<input type="submit" name="login" value="GUARDAR" class="button" />
</div>
    </form>



<?php

/*
for ($i=1; $i <=5; $i++) { ?>
	<a href="valoracion.php?estrella=$i" ><span class="glyphicon glyphicon-star-empty"></span></a>
}

*/
?>
</body>
</html>