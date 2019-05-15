		
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
					<input type="text" name="year" size="8" min="2019" >
					
					  SEMANA:
                               <select name="semana">
                               
            <?PHP              
                      for ($i=1; $i < 54; $i++) { 
            	
                              echo" <option value= $i selected>$i</option>";
             }
            ?>
                               </select></br>
                    </div></br>          

					<div>
					<label for="precioInicial">Precio Inicial: </br></label>
					<input type="number" name="precioInicial"  ></div></br>
					<div>
					<label for="insDesde">Inscripcion
					 desde : </br></label>
					<input type="date" name="insDesde" >
					</div></br>
					<div>
                    <label for="insHasta">hasta : </br></label>
					<input type="date" name="insHasta" >
					</div></br>
					<div>
                    <label for="ofDesde">Ofertar
                     desde : </br></label>
					<input type="date" name="ofDesde" >
					</div></br>
					<div>
                    <label for="ofHasta">hasta : </br></label>
					<input type="date" name="ofHasta" >
					</div>
                    
					
					
			</div>
				<div class="footer">
					<input type="submit" name="login" value="GUARDAR" class="button" />
				</div>

			</form>
			
		</div>
	</body>
</html>