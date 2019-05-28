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
$var_consulta= "SELECT idPersona, cantidad FROM puja WHERE idSubasta=$subasta";
   $result = mysqli_query($con, $var_consulta);
   $num=mysqli_num_rows($result); 
if ($num==0) {
  echo"<h4>NO HAY PUJAS</h4>";
 }
else{







?>
	<title>Pujas</title>
	
	</head>
	<body>
		
		<div id="wrapper" style="margin-left: 400px;margin-top: 0px;">

			
			<form name="formulario" class="login-form" style="width:600px;">
				<div class="header">
					<h1>  PUJAS</h1>
				</div>
			 
				
				
					 <table  style="width:600px;">
					 	<?php $primero = "Nombre y apellido";
                              $segundo="E-mail";
                              $tercero="Monto";
                               $color = "#2E86C1"; 
  ?>
 <tr>
  <td><?php echo "<p><font color='".$color."'>".$primero."</font></p>";  ?> </td> 
  <td ><?php echo "<p><font color='".$color."'>".$segundo."</font></p>";  ?></td> 
  <td ><?php echo "<p><font color='".$color."'>".$tercero."</font></p>";  ?> </td>
 </tr>
                  
                    <?php
                     //BUSCO LOS DATOS DE TODOS LOS INSCRIPTOS
                    $i=1;
                    while ($row = mysqli_fetch_array($result)){
      
                      $var_consulta2= "SELECT apellido, nombre, email FROM persona WHERE idPersona=$row[0]";
                         $result2 = mysqli_query($con, $var_consulta2);
                         $row2 = mysqli_fetch_array($result2); ?>
                        
                         <tr>
                             <td> <br><?php echo "$i - $row2[1] $row2[0]" ; ?> </td>
                              <td> <br><?php echo "$row2[2]"; ?> </td>
                                <td><br><?php echo "$$row[1]"; ?> </td>
                          </tr>
                         
  
                      
           

                     <?php 
                      

                     $i=$i + 1;  }

                    ?>
                   
 
 
</table> 
                       
                   
					
					
			
			</form>	
		
			<?php } ?>
			
		</div>
	</body>
</html>