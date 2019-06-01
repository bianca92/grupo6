<html>
   <head>
   
<?php
		
		include("clases.php");  
    include("cabecera.php");
include("conexion.php");



//$link = mysqli_connect('localhost','root','','grupo6');
$link=conectar();

$Propiedad=$_GET['no'];


$var_consulta= "SELECT * FROM propiedad WHERE idPropiedad='$Propiedad' ";
$var_resultado = $link->query($var_consulta);
$row = mysqli_fetch_array($var_resultado);
 
?>




	<title>SUBASTA</title>
	
	</head>

	<body>
		
		
		<div id="wrapper">


			<form name="formulario" action="alta_subasta2.php" method="POST" class="login-form" enctype="multipart/form-data" onsubmit="return validareg();">
				
				<div class="header">
					<h1>SUBASTA</h1>
				</div>
			 
				
				<div class="content">

					<input type="hidden" name="propiedad" value='<?php echo "$row[0]" ?>' size="25">

                    <div>

					
				   <label for="date">SEMANA: </br></label>
					<input id="datepicker"   type="text" name="datepicker" class="input username" size="8" autocomplete="off">


                
                    </select>
                    </div></br>

                
                    <div>
					<label for="precioInicial">Precio Inicial: </br></label>
					<input id="precio" type="number" name="precioInicial"  required="required"></div></br>
                   <table  style="width:300px;"> <?php  ?>
                  <?php  ?> 
                     <tr>
                             <td> <br><?php echo "?)La inscripcion comenzará 6 meses antes, con duracion de 7 dias." ;
                                            echo "<p>?)La puja comenzará 5 meses antes, con duracion de 7 dias." ?> </td>
                              
                               
                          </tr>

              </table> 
					<!--

<div>
					<label for="insDesde">Inscripcion desde : </label>
					<input id="fecha" type="date" name="insDesde" required="required">
					
					<label for="insHasta">hasta : </label>
					<input id="fecha" type="date" name="insHasta" required="required">
					</div></br>
					<div>
                    <label for="ofDesde">Ofertar desde : </br></label>
					<input id="fecha" type="date" name="ofDesde" required="required">
					</div>
					<div>
                    <label for="ofHasta">hasta : </label>
					<input id="fecha" type="date" name="ofHasta" required="required">
					</div>
                    
					-->
					
			</div>

				<div class="footer">
					<input type="submit" name="login" value="GUARDAR" class="button" />
				</div>

			</form>
			
		</div>

	</body>
	<!------CODIGO CORRESPONDIENTE AL CALENDARIO------------------------------------------------->





<!------FORMATO DEL CALENDARIO------------------------------------------------->
  <link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>
    
 <?php 
//CONSIGO LA FECHA DE LA SEMANA A SUBASTAR

  $var_consulta2= "SELECT idSemana, year FROM subasta WHERE idPropiedad='$Propiedad' ";
            $var_resultado2 = $link->query($var_consulta2);
            
 
     ?>
    <script type="text/javascript">

//VARIABLE DE LAS FECHAS DESHABILITADAS (la inicio con una fecha cualquiera porque si nunca entra al while la varible queda vacia y el calendario no anda)

var disableddates=['10-12-2018'];


    
   </script>

<?php
//RECORRO LAS FECHAS DE LA SEMANAS PARA ESTA PROPIEDAD
while ($row2 = mysqli_fetch_array($var_resultado2))
{ 
   //OBTENGO A QUE SEMANA DEL AÑO PERTENECE
	//$fi=date('W', strtotime($row2[0]));
	
	//OBTENGO EL AÑO AL QUE PERTENECE
   //$year=date('Y', strtotime($row2[0]));

   //OBTENGO CUAL ES EL PRIMER DIA DE ESA SEMANA
	
	$week_start = new DateTime();
	//le paso como parametros el año, la semana
     $week_start->setISODate((int)$row2[1],(int)$row2[0]);
     //CREO LA NUEVA FECHA, QUE ES EL INICIO DE LA SEMANA
     $fi= $week_start->format('j-n-Y');
    
  
//DESHABILITO TODA LA SEMANA
      for ($i=0; $i<7; $i++){
	?>
	<script>
	disableddates.push('<?php $fie=date(strtotime($fi."+ $i days")); 
		                      $fie=date ( 'n-j-Y' , $fie ); echo"$fie" 
		                      ?>');
	</script>
	
	<?php

	echo "<p> </p>";
}}
?>


   <script type="text/javascript">
        

        function DisableSpecificDates(date) {

            var m = date.getMonth();
            var d = date.getDate();
            var y = date.getFullYear();
            var currentdate = (m + 1) + '-' + d + '-' + y ;

            for (var i = 0; i < disableddates.length; i++) {
                if ($.inArray(currentdate, disableddates) != -1 ) {
                    return [false];
                } 
            }

            return disableddates;
        }

        $( function calendario () {
        	//variable para poner una fecha minima
        	var e = new Date(Date.now())
             e.setMonth(e.getMonth() + 6)
             e.setDate(e.getDate() + 6)

            $.datepicker.setDefaults($.datepicker.regional["es"]);
            $( "#datepicker" ).datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth:true,
                changeYear:true,
                yearRange: "2019:2030", 
                firstDay: 1,
                minDate: new Date(e), /** AAAA,MM,DD Fecha inicio */
                maxDate: new Date(2040, 11, 25), /** AAAA,MM,DD Fecha Fin */

                monthNames: ['Enero', 'Febrero', 'Marzo',
                'Abril', 'Mayo', 'Junio',
                'Julio', 'Agosto', 'Septiembre',
                'Octubre', 'Noviembre', 'Diciembre'],
                monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
                'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                dayNamesMin: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
                
                beforeShowDay: DisableSpecificDates
                


            });
        });


    </script>
    <!------------------------------------------------------------------------------------------------------------>
</html>
