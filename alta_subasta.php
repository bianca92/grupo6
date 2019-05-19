<html>
   <head>		
<?php
		
		include("clases.php");  
    include("cabecera.php");
include("conexion.php");


//$link = mysqli_connect('localhost','root','','grupo6');
$link=conectar();

$Propiedad=$_GET['no'];


$var_consulta= "SELECT * FROM propiedad WHERE idPropiedad='$Propiedad' ";
$var_resultado = $link->query($var_consulta);
$row = mysqli_fetch_array($var_resultado);
 
?>
	<title>SUBASTA</title>
	
	</head>
	<body>
		
		<div id="wrapper">

			<form name="formulario" action="alta_subasta2.php" method="POST" class="login-form" enctype="multipart/form-data" onsubmit="return validareg();">
				
				<div class="header">
					<h1>SUBASTA</h1>
				</div>
			 
				
				<div class="content">

					<input type="hidden" name="propiedad" value='<?php echo "$row[0]" ?>' size="25">

                    <div>
					<label for="año">AÑO: </br></label>
					<input id="fecha"   type="text" name="year" class="input username" size="8" min="2019" >
					
					<label for="semana">SEMANA:</label>
                    <select id="semana"  name="semana">
                               
                    <?PHP              
                      for ($i=1; $i < 54; $i++) { 
            	
                              echo" <option value= $i selected>$i</option>";
                    }
                    ?>
                    </select>
                    </div></br>
                
                    <div>
					<label for="precioInicial">Precio Inicial: </br></label>
					<input id="precio" type="number" name="precioInicial"  ></div></br>
					<div>
					<label for="insDesde">Inscripcion desde : </label>
					<input id="fecha" type="date" name="insDesde">
					
					<label for="insHasta">hasta : </label>
					<input id="fecha" type="date" name="insHasta" >
					</div></br>
					<div>
                    <label for="ofDesde">Ofertar desde : </br></label>
					<input id="fecha" type="date" name="ofDesde" >
					</div>
					<div>
                    <label for="ofHasta">hasta : </label>
					<input id="fecha" type="date" name="ofHasta" >
					</div>
                    
					
					
			</div>
				<div class="footer">
					<input type="submit" name="login" value="GUARDAR" class="button" />
				</div>

			</form>
			
		</div>
	</body>
</html>