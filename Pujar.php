<html>
	<head>
		
<?php
		include("cabecera.php");
		include("clases.php");
		include("conexion.php");
		
?>

<?php 
$con=conectar();
$subasta=$_GET['idS'];
$usuario=$_GET['idU'];
$minimo=$_GET['min'];
$minaux=$_GET['min'];;
$alguienOfertoMinimo=false;
//HAGO LA CONSULTA PARA SABER LOS MONTOS OFERTADOS PARA ESTA SUBASTA
$var_consulta= "SELECT cantidad FROM puja WHERE idSubasta=$subasta";
   $result = mysqli_query($con, $var_consulta);

//ACTUALIZO EL MINIMO SI YA HAY OFERTAS ANTERIORES
while ($row = mysqli_fetch_array($result)){
      

        if ($row['cantidad']>$minimo){
               
               $minimo=$row['cantidad'];               
                              }
          if ($row['cantidad']==$minimo) {
          	$alguienOfertoMinimo=true;
          }                 
 }



 //OBTENGO CUAL ES EL ULTIMO MONTO DE ESTE USUARIO
 $var_consulta= "SELECT cantidad FROM puja WHERE idSubasta=$subasta and idPersona=$usuario";
   $result2 = mysqli_query($con, $var_consulta);
   $row2= mysqli_fetch_array($result2);


?>
	<title>Propiedades</title>
	
	</head>
	<body>
		
		<div id="wrapper">

			<form name="formulario" action="Pujar2.php"  method="POST" class="login-form" enctype="multipart/form-data" onsubmit="return validareg();">
				
				<div class="header">
					<h1>  Pujar</h1>
				</div>
			 
				
				<div class="content">
                  
                    <?php
                     //LE DIGO AL USUARIO CUAL ES LA PUJA MAYOR HASTA EL MOMENTO
                     if ($minimo==$minaux && $alguienOfertoMinimo==false){
                   echo "El precio minimo es $ $minimo.";
                     }
                      else {
                        echo "La puja mayor actual es $ $minimo.";
                      	$minimo=$minimo +1;}
                     
                    echo " <p> </p>";
                    //SI ESTE USUARIO NO HA HECHO NINGUNA OFERTA ANTERIOR O SEA NO HAY REGISTRO EN LA TABLA
                    $primeraOferta=0;
                     if($row2==false){
   	                  echo "Aun no has echo ninguna oferta";
                       $primeraOferta=1;
                             }
                    //SI HAY UNA OFERTA ANTERIOR DE ESTE USUARIO QUE SE LA DIGA
                             else{
                     echo "Tu oferta anterior es $ $row2[0] ";
                    }

                    ?>
                       </br>
					<label for="Tu oferta">Tu nueva oferta: </br></label>
                    
                    <?php //ACA ENTRA LA NUEVA OFERTA Y ESTABLECI QUE EL MONTO MINIMO SEA LA OFERTA MAYOR, OBVIAMENTE PARA QUE NO PUEDA OFERTAR UN MONTO MENOR AL ACTUAL 
                     ?>
					<input type="number" name="monto" class="input username" min='<?php echo "$minimo" ?>' required="required">
                    <?php //ESTOS DATOS LOS NECESITO PARA EL INSERT DE ESTA MANERA LOS PASO AL PUJAR2.PHP ?>
					<input type="hidden" name="usuario" value='<?php echo "$usuario" ?>' />
					<input type="hidden" name="subasta" value='<?php echo "$subasta" ?>' />
					<input type="hidden" name="primeraOferta" value='<?php echo "$primeraOferta" ?>' />

					
                     
					
			
					
					
				
					
					
					
				</div>
				<div class="footer">
					<input type="submit" name="login" value="Ofertar" class="button" />
				</div>
			</form>
			
		</div>
	</body>
</html>