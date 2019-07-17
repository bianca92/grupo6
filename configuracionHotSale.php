<html>
   <head>
   
<?php
		
		include("clases.php");  
    include("cabecera.php");
    include("conexion.php");



//$link = mysqli_connect('localhost','root','','grupo6');
$link=conectar();


$var_consulta= "SELECT * FROM config_hotsale";
$var_resultado = $link->query($var_consulta);
 $num=mysqli_num_rows($var_resultado); 

?>



	<title>Configuracion hotsale</title>
	
	</head>

	<body>

    <?php
    //datos hot sale
    $consulta="SELECT * FROM config_hotsale";
    $resu2 = $link->query($consulta); 
    $row2=mysqli_fetch_array($resu2);



    $fechaHotsale="$row2[dia]/$row2[mes]/$row2[year]";

    ?>
		
		
		<div id="wrapper">
      <h4 style='color:#FF7516'>El proximo Hot Sale sera el <?php echo"$fechaHotsale";?> </h4>


			<form name="formulario" action="configuracionHotSale_2.php" method="POST" class="login-form" enctype="multipart/form-data" onsubmit="return validareg();">
				
				<div class="header">
					<h1>CONFIGURACIÓN HOTSALE</h1><br/>
          <br/>

				</div>
			 
				
				<div class="content">
               <?php if($num==0){
                  $primeraVez=1;
                  $duracion="";
                  $fecha="";
                  
                   }
               else {
               $primeraVez=0;   
               $row = mysqli_fetch_array($var_resultado);
               $duracion="$row[duracion]";
             
             

              ?>
        <input type="text" name="idConfigHotsale" class="hidden" value='<?php echo "$row[idConfigHotsale]" ?>'>
				  

               <?php
               }

               ?>
                    <div>
                    <input type="text" name="primera" class="hidden" value='<?php echo "$primeraVez" ?>'>
				
					<label for="date">Inicio: </br></label>
					<input id="datepicker"   type="text" name="datepicker" class="input username" value='<?php echo "$row[fecha]" ?>' size="8" autocomplete="off" required="required">


                   <label for="duracion">Dias de duracion: </br></label>
					<input id="duracion"   type="number" name="duracion" class="input username" min=1 value='<?php echo "$duracion" ?>' autocomplete="off" >
					
                

                    

                    </select>
                    </div></br>


				<div class="footer">
					<input type="submit" name="login" value="GUARDAR" class="button" />
				</div>

			</form>
			
		</div>

	</body>

	<link href="css/jquery-ui.css" rel="stylesheet"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>
    <script type="text/javascript">
        

        $( function calendario () {
        	//variable para poner una fecha minima
        	

            $.datepicker.setDefaults($.datepicker.regional["es"]);
            $( "#datepicker" ).datepicker({
            	defaultDate: '2020-01-01',
                dateFormat: 'yy-mm-dd',
                changeMonth:true,
                changeYear:true,
                yearRange: "2019:2021", 
                firstDay: 1,
                minDate: new Date('2019-01-01'), /** AAAA,MM,DD Fecha inicio */
                maxDate: new Date('2021-01-01'), /** AAAA,MM,DD Fecha Fin */

                monthNames: ['Enero', 'Febrero', 'Marzo',
                'Abril', 'Mayo', 'Junio',
                'Julio', 'Agosto', 'Septiembre',
                'Octubre', 'Noviembre', 'Diciembre'],
                monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
                'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                dayNamesMin: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
                
              
                


            });
        });


    </script>

	</html>