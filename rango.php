<html>
   <head>
   


  <title>SUBASTA</title>
  
  </head>

  <body>
    
    
    <div id="wrapper">


      <form name="formulario" action="alta_subast.php" method="POST" class="login-form" enctype="multipart/form-data" onsubmit="return validareg();">
        
        <div class="header">
          <h1>SUBASTA</h1>
        </div>
       
        
        <div class="content">

          
                    <div>

          
           <label for="date">SEMANA: </br></label>
          <input id="datepicker"   type="text" name="datepicker" class="input username" size="8" autocomplete="off">
         <input id="datepicker1"   type="text" name="datepicker1" class="input username" size="8" autocomplete="off">

                
                    </select>
                    </div></br>

                

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
    
 
    <script type="text/javascript">

//VARIABLE DE LAS FECHAS DESHABILITADAS (la inicio con una fecha cualquiera porque si nunca entra al while la varible queda vacia y el calendario no anda)

var disableddates=['10-12-2018'];


    
   </script>



   <script type="text/javascript">
        

        

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
                
               


            });
        });


 $( function calendario () {
          //variable para poner una fecha minima
          var e = new Date(Date.now())
             e.setMonth(e.getMonth() + 6)
             e.setDate(e.getDate() + 6)

            $.datepicker.setDefaults($.datepicker.regional["es"]);
            $( "#datepicker1" ).datepicker({
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
                
               


            });
        });



    </script>
    <!------------------------------------------------------------------------------------------------------------>
</html>
