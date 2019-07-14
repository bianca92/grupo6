<html>
   <head>
   
<?php
		
include("clases.php");  
include("cabecera.php");
include("conexion.php");




$link=conectar();

$idHotsale = $_GET['hotsale'];
$monto = $_GET['monto'];



$var_consulta= "SELECT * FROM tarjeta WHERE idPersona='$_SESSION[id]' ";
$var_resultado = $link->query($var_consulta);
$row = mysqli_fetch_array($var_resultado);
$var_consulta= "SELECT * FROM hotsale h NATURAL JOIN subasta s NATURAL JOIN propiedad 
                WHERE h.idSubasta = s.idSubasta";
$var_resultado = $link->query($var_consulta);
$row2 = mysqli_fetch_array($var_resultado);
?>




	<title>Pagar</title>
	
	</head>

	<body>
		  <div class="well well-sm" style="background-color: #FF7516">
         <?php  $consultaHotSale="SELECT * FROM config_hotsale";
         $resHotsale =  mysqli_query(mysqli_connect('localhost','root','','grupo6'),$consultaHotSale); 
         $rowH=mysqli_fetch_array($resHotsale);

          $dias=$rowH['duracion'];
          $fechaHotsale=$rowH['fecha'];
          
          $nuevafecha = strtotime ( '+'.$dias.'day' , strtotime ( $rowH['fecha'] )) ; 
          $nuevafecha = date ( 'd/m/Y' , $nuevafecha );
          echo"<h4> HOT SALE hasta ".$nuevafecha."</h4>";
        ?>
  </div> 
		
		<div id="wrapper" style="background-color: #EAB15A">


			<form name="formulario" action="compraHotsale_2.php" method="POST" class="login-form" enctype="multipart/form-data" onsubmit="return validareg();">
				
				<div class="header">
					<h1>PAGAR PROPIEDAD EN OFERTA</h1>
				</div>
			 
				
				<div class="content">


                    <div>
                    <input   type="text" name="persona" class="hidden" value='<?php echo "$_SESSION[id]" ?>'autocomplete="off">
					<input   type="text" name="hotsale" class="hidden" value='<?php echo "$idHotsale" ?>'autocomplete="off">
					<input   type="text" name="monto" class="hidden" value='<?php echo "$monto" ?>'autocomplete="off">
					<input   type="text" name="tarjeta" class="hidden" value='<?php echo "$row[idTarjeta]" ?>'autocomplete="off">
					
					
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