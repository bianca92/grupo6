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



$var_consulta= "SELECT * FROM mensaje WHERE idPara=$id ORDER BY fecha DESC";
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
		
		<div id="wrapper" style="margin-left: 350px;margin-top: 0px;">

			
			<form name="formulario" class="login-form" style="width:700px;height:60px; background-color:#28a3db;">
				<div class="header" style="padding: 0px;">
					<h1> MENSAJES</h1>
				</div>
			 
				
				
					 <table  style="width:700px;background-color:#fff;">
					 	<?php $primero = "Contenido de mensaje";
                              $segundo="Fecha";
                               $tercero="Hora";

                               $color = "#fff"; 
  ?>
 <tr style="background-color:#000;">
  <td><?php echo "<p><font color='".$color."'>".$primero."</font></p>";  ?> </td> 
  <td ><?php echo "<p><font color='".$color."'>".$segundo."</font></p>";  ?></td> 
  <td ><?php echo "<p><font color='".$color."'>".$tercero."</font></p>";  ?></td> 
 </tr>
                  
                    <?php
                     //BUSCO LOS DATOS DE TODOS LOS INSCRIPTOS
                   
                    while ($row = mysqli_fetch_array($result)){
                    	$i="<i class='fas fa-envelope-open-text'></i>";

                           if (is_null($row['leido'])){
                           $consulta="UPDATE mensaje SET leido=1 WHERE idPara='$id' ";
                               $resu = $con->query($consulta); 
                               $i="<p class= text-danger><i class='fas fa-envelope'></i>";

                           }
                       ?>
                        
                         <tr>
                             <td> <br><?php echo "$i $row[contenido]" ; 
                             

                             switch ($row['numero']) {
                                  case 1:
                                           echo "<a href='verSemana.php?sub=".$row['idSubasta']."'> <button type='button' class='btn btn-succes'>Ver subasta</button> </a></br>";
                                            break;
                                  case 2:
                                            echo "<a href='verSemana.php?sub=".$row['idSubasta']."'> <button type='button' class='btn btn-succes'>Ver subasta</button> </a></br>";
                                           break;
                                 case 3:
                                             echo "<a href='verListaEspera.php'> <button type='button' class='btn btn-succes'>Ver listado para PREMIUM</button> </a></br>";
                                            break;
                                 case 8:
                                             echo "<a href='verSemana.php?sub=".$row['idSubasta']."'> <button type='button' class='btn btn-succes'>Ver subasta</button> </a></br>";
                                            break;
                                 case 9:
                                              echo "<a href='verListaEsperaClasico.php'> <button type='button' class='btn btn-succes'>Ver listado para CLASICO</button> </a></br>";
                                            break;
                                 
}

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