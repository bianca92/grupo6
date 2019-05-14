
		
<?php
		
		include("clases.php");  
    include("cabecera.php");
include("conexion.php");



//$link = mysqli_connect('localhost','root','','grupo6');
$link=conectar();
if(!$link)
{
    echo "<h3>No se ha podido conectar PHP - MySQL, verifique sus datos.</h3><hr><br>";
}
else
{
    //echo "<h3>Conexion Exitosa PHP - MySQL</h3><hr><br>";
}
$Propiedad=$_GET['no'];



$var_consulta= "SELECT * FROM propiedad WHERE idPropiedad='$Propiedad' ";
$var_resultado = $link->query($var_consulta);
$row = mysqli_fetch_array($var_resultado);



 
?>
	<title>Propiedades</title>
	
	</head>
	<body>
		
		<div id="wrapper">

			<form name="formulario" action="modificar_propiedad2.php" method="POST" class="login-form" enctype="multipart/form-data" onsubmit="return validareg();">
				
				<div class="header">
					<h1>  Modificar</h1>
				</div>
			 
				
				<div class="content">

					
					<input type="hidden" name="propiedad" value='<?php echo "$row[0]" ?>' size="25">

					<label for="titulo">Titulo: </br></label>
					<input type="text" name="titulo" value='<?php echo "$row[1]" ?>' size="25">

					
					<label for="descripcion">Descripcion: </br></label>
					<input type="text" name="descripcion" value='<?php echo "$row[2]" ?>' size="25" pattern="{2,20}">
					
					<label for="ubicacion">Ciudad: </br></label>
					<input type="text" name="ubicacion" value='<?php echo "$row[3]" ?>' size="25">
					

					

					<label for="imagen">Imagen: </br></label>
					
					<input type="file" class="form-control" id="imagen[]" name="imagen[]" multiple="" accept="image/*" upload_max_filesize = 1M >
                    
					
					
					
				</div>
				<div class="footer">
					<input type="submit" name="login" value="GUARDAR" class="button" />
				</div>

			</form>
			
		</div>
	</body>
</html>