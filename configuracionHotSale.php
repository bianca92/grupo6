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




	<title>Configuracion cuotas</title>
	
	</head>

	<body>
		
		
		<div id="wrapper">


			<form name="formulario" action="configuracionHotSale_2.php" method="POST" class="login-form" enctype="multipart/form-data" onsubmit="return validareg();">
				
				<div class="header">
					<h1>CONFIGURACIÓN HOTSALE</h1>
				</div>
			 
				
				<div class="content">
               <?php if($num==0){
                  $primeraVez=1;
                  $duracion="";
                  $fecha="";
                  ?>

                <?php
                   }
               else {
               $primeraVez=0;
               $row = mysqli_fetch_array($var_resultado);
               $fecha="$row[dia] - $row[mes]";
               $duracion=$row['duracion'];
              ?>
 
                     
                     <input type="text" name="idConfigHotsale" class="hidden" value='<?php echo "$row[idConfigHotsale]" ?>'>
				  

               <?php
               }

               ?>
                    <div>
                    <input type="text" name="primera" class="hidden" value='<?php echo "$primeraVez" ?>'>
				
					<label for="date">Inicio: </br></label>
					<input id="datepicker"   type="text" name="datepicker" class="input username" placeholder='<?php echo "$fecha" ?>' size="8" autocomplete="off" required="required">


                   <label for="duracion">Dias de duracion: </br></label>
					<input id="duracion"   type="number" name="duracion" class="input username" min=1 placeholder='<?php echo "$duracion" ?>' autocomplete="off" required="required">
					
                

                    

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
            	defaultDate: '01-01',
                dateFormat: 'dd-mm',
                changeMonth:true,
                changeYear:true,
                yearRange: "2019:2019", 
                firstDay: 1,
                minDate: new Date('2019-01-01'), /** AAAA,MM,DD Fecha inicio */
                maxDate: new Date('2020-01-01'), /** AAAA,MM,DD Fecha Fin */

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