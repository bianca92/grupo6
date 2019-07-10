<html>
   <head>
   
<?php
		
		include("clases.php");  
    include("cabecera.php");
include("conexion.php");



//$link = mysqli_connect('localhost','root','','grupo6');
$link=conectar();

$ganador = $_GET['ganador'];
$subasta = $_GET['sub'];
$monto = $_GET['monto'];
$tipo = $_GET['tipo'];


$var_consulta= "SELECT * FROM tarjeta WHERE idPersona='$ganador' ";
$var_resultado = $link->query($var_consulta);
$row = mysqli_fetch_array($var_resultado);
 $var_consulta= "SELECT * FROM subasta INNER JOIN propiedad on subasta.idPropiedad=propiedad.idPropiedad WHERE idSubasta='$subasta' ";
$var_resultado = $link->query($var_consulta);
$row2 = mysqli_fetch_array($var_resultado);
?>




	<title>Pagar</title>
	
	</head>

	<body>
		
		
		<div id="wrapper">


			<form name="formulario" action="pagarSemana_2.php" method="POST" class="login-form" enctype="multipart/form-data" onsubmit="return validareg();">
				
				<div class="header">
					<h1>PAGAR SEMANA</h1>
				</div>
			 
				
				<div class="content">


                    <div>
                    <input   type="text" name="ganador" class="hidden" value='<?php echo "$ganador" ?>'autocomplete="off">
					<input   type="text" name="subasta" class="hidden" value='<?php echo "$subasta" ?>'autocomplete="off">
					<input   type="text" name="monto" class="hidden" value='<?php echo "$monto" ?>'autocomplete="off">
					<input   type="text" name="tarjeta" class="hidden" value='<?php echo "$row[idTarjeta]" ?>'autocomplete="off">
					<input   type="text" name="tipo" class="hidden" value='<?php echo "$tipo" ?>'autocomplete="off">
					
				  <?php
				  $week_start = new DateTime(); $week_start->setISODate((int)$row2['year'],(int)$row2['idSemana']);
                                           $fi= $week_start->format('d/m/Y');
                  echo "Propiedad: $row2[titulo]. Semana: $fi.";
                  echo "</p>";
                  echo "DATOS DE LA TARJETA:";
                  echo "</p>";
                  echo "    Marca: $row[marca]";
                  echo "</p>";
                  $ult4 = substr($row['numero'],12);
                  
                  echo "    Numero: **** **** **** $ult4";
                  echo "</p>";
                  echo "    Titular: $row[titular]";
                  echo "</p>";

                  echo "    Vencimiento: $row[vencimiento]";
                ?>
                  <h3>Monto:<?php echo "$$monto";?></h3>
                    </select>
                    </div></br>


				<div class="footer">
					<input type="submit" name="login" value="PAGAR" class="button" />
				</div>

			</form>
			
		</div>

	</body>
	</html>