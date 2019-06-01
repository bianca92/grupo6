<html>
	<head>
		
<?php
		include("cabecera.php");
		include("clases.php");
		include("conexion.php");
		
?>

<?php 
$con=conectar();
 $id=($_SESSION['id']);



$var_consulta= "SELECT * FROM mensaje WHERE idPersona=$id ORDER BY fecha DESC";
   $result = mysqli_query($con, $var_consulta);
   $num=mysqli_num_rows($result); 
if ($num==0) {
  echo"<h4>NO HAY MENSAJES</h4>";
 }
else{







?>
	<title>Mensajes</title>
	
	</head>
	<body>
		
		<div id="wrapper" style="margin-left: 400px;margin-top: 0px;">

			
			<form name="formulario" class="login-form" style="width:600px;">
				<div class="header">
					<h1>  PUJAS</h1>
				</div>
			 
				
				
					 <table  style="width:600px;">
					 	<?php $primero = "Contenido mensaje";
                              $segundo="Fecha";
                               $tercero="Hora";

                               $color = "#2E86C1"; 
  ?>
 <tr>
  <td><?php echo "<p><font color='".$color."'>".$primero."</font></p>";  ?> </td> 
  <td ><?php echo "<p><font color='".$color."'>".$segundo."</font></p>";  ?></td> 
  <td ><?php echo "<p><font color='".$color."'>".$tercero."</font></p>";  ?></td> 
 </tr>
                  
                    <?php
                     //BUSCO LOS DATOS DE TODOS LOS INSCRIPTOS
                   
                    while ($row = mysqli_fetch_array($result)){
                    	$i="";

                           if (is_null($row['leido'])){
                           $consulta="UPDATE mensaje SET leido=1 WHERE idPersona='$id' ";
                               $resu = $con->query($consulta); 
                               $i="<p class= text-danger>No leido:";

                           }
                       ?>
                        
                         <tr>
                             <td> <br><?php echo "$i $row[contenido]" ; 
                             if(is_null($row['idSubasta'])){}
                             else {echo "<a href='verSubasta.php?sub=".$row['idSubasta']."'> <button type='button' class='btn btn-succes'>Ver subasta</button> </a></br>";}

                             	?> 


                         </td>
                              <td> <br><?php echo "".date('d/m/Y', strtotime($row['fecha'])).""; ?> </td>
                                <td> <br><?php echo "".date('H:i', strtotime($row['fecha'])).""; ?> </td>
                                
                          </tr>
                         
  
                      
           

                     <?php 
                      

                       }

                    ?>
                   
 
 
</table> 
                       
                   
					
					
			
			</form>	
		
			<?php } ?>
			
		</div>
	</body>
</html>