<html>
<?php
	if(isset($_GET['msj'])){
  		 $mensaje= $_GET['msj'];
//

   	if($mensaje="2")
  		 echo"<script> alert ('DEBE ESTAR REGISTRADO PARA ACCEDER')</script>"; 
}?>

<head>
	<title> Home switch Home </title>
	<link rel=stylesheet href="css/estilos.css" type="text/css" media=screen>
</head>
	
<body>
	
	<?php
		Include ("cabecera.php");
		Include("verPropiedadesIndex.php");
		
	?>

</div>

</body>	
</html>