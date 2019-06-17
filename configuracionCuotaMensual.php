<html>
   <head>
   
<?php
		
		include("clases.php");  
    include("cabecera.php");
include("conexion.php");



//$link = mysqli_connect('localhost','root','','grupo6');
$link=conectar();




$var_consulta= "SELECT * FROM config_cuota WHERE idTipoUsuario='1' ";
$var_resultado = $link->query($var_consulta);
$row = mysqli_fetch_array($var_resultado);
 $var_consulta= "SELECT * FROM config_cuota WHERE idTipoUsuario='2' ";
$var_resultado = $link->query($var_consulta);
$row2 = mysqli_fetch_array($var_resultado);
?>




	<title>Configuracion cuotas</title>
	
	</head>

	<body>
		
		
		<div id="wrapper">


			<form name="formulario" action="configuracionCuotaMensual_2.php" method="POST" class="login-form" enctype="multipart/form-data" onsubmit="return validareg();">
				
				<div class="header">
					<h1>CONFIGURACIÓN CUOTAS</h1>
				</div>
			 
				
				<div class="content">


                    <div>
                    <input   type="number" name="basicoActual" class="hidden" value='<?php echo "$row[monto]" ?>'autocomplete="off">
					
				   <label for="date">Monto cuota usuario clasico: </br></label>
					<input id="cuotaC"   type="number" name="basico" class="input username" value='<?php echo "$row[monto]" ?>'autocomplete="off">

                   <label for="date">Monto cuota usuario premium: </br></label>
					<input id="cuotaP"   type="number" name="premium" class="input username" value='<?php echo "$row2[monto]" ?>'autocomplete="off">
					<input   type="number" name="premiumActual" class="hidden" value='<?php echo "$row2[monto]" ?>'autocomplete="off">
                
                    </select>
                    </div></br>


				<div class="footer">
					<input type="submit" name="login" value="GUARDAR" class="button" />
				</div>

			</form>
			
		</div>

	</body>
	</html>