<html>
	<head>
		
<?php
		include("cabecera.php");
		include("clases.php");
		include("conexion.php");
		
?>

<?php 
$con=conectar();





$var_consulta= "SELECT * FROM persona WHERE rol=0 ORDER BY fechaRegistro DESC";
   $result = mysqli_query($con, $var_consulta);
   $num=mysqli_num_rows($result); 
if ($num==0) {
  echo"<h4>NO HAY USUARIOS TODAVIA</h4>";
 }
else{







?>
	<title>Usuarios</title>
	
	</head>
	<body>
		
		<div id="wrapper" style="margin-left: 220px;margin-top: 0px;"  >

			
			<form name="formulario" class="login-form" style="width:900px;background-color:#28a3db;">
				<div class="header">
					<h1> Todos los Usuarios</h1>
				</div>
			 
				
				
					 <table  style="width:900px; background-color:#fff; ">
					 	<?php $primero = "Nombre y apellido";
                              $segundo="E-mail";
                              $tercero="Tipo de Usuario";
                              $cuarto="Fecha de registro";

                               $color = "#fff"; 
  ?>
 <tr style="background-color:#000000;">
  <td ><?php echo "<p><font color='".$color."'>".$primero."</font></p>";  ?> </td> 
  <td ><?php echo "<p><font color='".$color."'>".$segundo."</font></p>";  ?></td>
  <td ><?php echo "<p><font color='".$color."'>".$tercero."</font></p>";  ?></td>
   <td ><?php echo "<p><font color='".$color."'>".$cuarto."</font></p>";  ?></td>
   <td >  </td>  
   <td >  </td>
   
 </tr>
                  
                    <?php
                     //BUSCO LOS DATOS DE TODOS LOS INSCRIPTOS
                    $i=1;
                    while ($row = mysqli_fetch_array($result)){
      
                      ?>
                        
                         <tr>
                             <td> <br><?php echo "$i - $row[nombre] $row[apellido]" ; ?> </td>
                              <td> <br><?php echo "$row[email]"; ?> </td>
                                <td> <br><?php echo "$row[tipoU]"; ?> </td>
                                 <td> <br><?php echo "$row[fechaRegistro]"; ?> </td>
                       
                    <?php   if($row['tipoU']=="premium"){ //--------------------------------------------------ES PREMIUM -------?>

                              <td><br><?php echo "<a href='eliminarPremium.php?idU=".$row['IdPersona']."'> <button type='button' class='btn btn-succes'>Pasar a CLASICO</button> </a></br>" ;?>  
                              
                       <?php   } 
                        else{//-------------------------------------------------------------------------------ES CLASICO--------
                        	
                           // $var_consulta1= "SELECT idPersona FROM enesperapremium WHERE idPersona='$row[IdPersona]'";
                           // $result1 = mysqli_query($con, $var_consulta1);
                           // $num=mysqli_num_rows($result1); 
                           // if ($num!=0) {
                            


                       ?>
                           <td><br><?php echo "<a href='eliminarClasico.php?idU=".$row['IdPersona']."'> <button type='button' class='btn btn-succes'>Pasar a PREMIUM</button> </a></br>" ;?>       
                          
                         
                          <?php // }
                            }  ?>
                      <td><br><?php echo "<a href='historialDePago.php?idU=".$row['IdPersona']."'> <button type='button' class='btn btn-succes'>Pagos</button> </a></br>" ;?>       
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