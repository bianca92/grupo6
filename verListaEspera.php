<html>
	<head>
		
<?php
		include("cabecera.php");
		include("clases.php");
		include("conexion.php");
		
?>

<?php 
$con=conectar();





$var_consulta= "SELECT idPersona FROM enesperapremium ORDER BY idEspera DESC";
   $result = mysqli_query($con, $var_consulta);
   $num=mysqli_num_rows($result); 
if ($num==0) {
  echo"<h4>NO HAY SOLICITUDES</h4>";
 }
else{







?>
	<title>LISTA DE ESPERA PARA PREMIUM</title>
	
	</head>
	<body>
		
		<div id="wrapper" style="margin-left: 350px;margin-top: 0px;">

			
			<form name="formulario" class="login-form" style="width:700px;background-color:#28a3db;">
				<div class="header">
					<h1> LISTA DE ESPERA PARA PREMIUM</h1>
				</div>
			 
				
				
					 <table  style="width:700px; background-color:#fff; ">
					 	<?php $primero = "Nombre y apellido";
                              $segundo="E-mail";
                              
                               $color = "#fff"; 
  ?>
 <tr style="background-color:#000000;">
  <td ><?php echo "<p><font color='".$color."'>".$primero."</font></p>";  ?> </td> 
  <td ><?php echo "<p><font color='".$color."'>".$segundo."</font></p>";  ?></td>
   <td ></td>  
   <td ></td>
    <td ></td>
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
                             
                           <td><br><?php echo "<a href='aceptarUsuario.php?idU=".$row['idPersona']."'> <button type='button' class='btn btn-succes'>ACEPTAR</button> </a></br>" ;?>  
                          <td><br><?php echo "<a href='rechazarUsuario.php?idU=".$row['idPersona']."'> <button type='button' class='btn btn-succes'>RECHAZAR</button> </a></br>" ;?>  
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