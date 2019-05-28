<html>
	<head>
		
<?php
		include("cabecera.php");
		include("clases.php");
		include("conexion.php");
		
?>

<?php 
$con=conectar();
$subasta=$_GET['sub'];



//HAGO LA CONSULTA PARA SABER LOS ID DE LOS INSCRIPTOS A ESTA SUBASTA
$var_consulta= "SELECT idPersona FROM inscripto WHERE idSubasta=$subasta";
   $result = mysqli_query($con, $var_consulta);
   $num=mysqli_num_rows($result); 
if ($num==0) {
  echo"<h4>NO HAY INSCRIPTOS</h4>";
 }
else{







?>
	<title>Propiedades</title>
	
	</head>
	<body>
		
		<div id="wrapper" style="margin: 0 auto;" >

			<form name="formulario" class="login-form" style="width:500px;" >
				
				<div class="header">
					<h1>  Inscriptos</h1>
				</div>
			 
			 <table  style="width:500px;">
				<?php $primero = "Nombre y apellido";
                              $segundo="E-mail";
                             
                               $color = "#2E86C1"; 
  ?>
 <tr>
  <td><?php echo "<p><font color='".$color."'>".$primero."</font></p>";  ?> </td> 
  <td ><?php echo "<p><font color='".$color."'>".$segundo."</font></p>";  ?></td> 
 </tr>
			
                  
                    <?php
                     //BUSCO LOS DATOS DE TODOS LOS INSCRIPTOS
                    $i=1;
                    while ($row = mysqli_fetch_array($result)){
      
                      $var_consulta2= "SELECT apellido, nombre, email FROM persona WHERE idPersona=$row[0]";
                         $result2 = mysqli_query($con, $var_consulta2);
                         $row2 = mysqli_fetch_array($result2); ?>
                         
                       
                      <tr>
                             <td> <br><?php echo "$i - $row2[1] $row2[0]." ; ?> </td>
                              <td> <br><?php echo "$row2[2]"; ?> </td>
                               
                          </tr>
           

                     <?php $i=$i + 1;  }

                    ?>
                       
                   
					</table> 
					
					
		
				
			</form>
			<?php } ?>
		</div>
	</body>
</html>