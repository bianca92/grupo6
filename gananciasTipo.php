
<html>
	<head>
        <?php
include("clases.php");  
include("cabecera.php");
?>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="js/code/highcharts.js"></script>
        <script src="js/code/modules/exporting.js"></script>
          <script src="js/code/modules/export-data.js"></script>
		<title>ESTADISTICAS</title>

		<style type="text/css">

body {
    background: #f2f2f2;
    color: #111;
    font-family: sans-serif;
    font-size: 14px;
}
 
.contenedor {
    width: 980px;
    margin: 0 auto;    
    padding: 2em;    
}
 
#consulta, #grafica {
    padding: 18px 20px;    
    text-align:center;
}
 
</style>

	</head>
	<body>


<?php //<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div> ?>
<div class="container-fluid">
    <div class="row">
    <?php include('menuEstadistica.php');?>
    <div class="col-md-9" style="aling:right">
    <div id="consulta"> <div id="grafica">
<?php
include("conexion.php");  $con=conectar();
                                        
$queryPremium='SELECT month(fecha) as mes, count(month(fecha)) as total, SUM(monto) as ventas FROM comprap p NATURAL JOIN subasta s  GROUP by month(fecha)';
$resultPremium = mysqli_query($con, $queryPremium);

$querySubasta='SELECT month(fecha) as mes, count(month(fecha)) as total, SUM(monto) as ventas FROM comprasu u NATURAL JOIN  subasta s  GROUP by month(fecha)';
$resultSubasta = mysqli_query($con, $querySubasta);

$queryHotsale='SELECT month(fecha) as mes, count(month(fecha)) as total,SUM(monto) as ventas FROM comprah NATURAL JOIN hotsale h NATURAL JOIN subasta s GROUP by month(fecha)';
$resultHotsale = mysqli_query($con, $queryHotsale);

$arrayp = array(); $arrayh = array(); $arrays = array(); 

 for ($i=1; $i <=12 ; $i++) { 
     $arrayp[$i]= 0;
     $arrayh[$i]= 0;
     $arrays[$i]= 0;}
     
 
      //PREMIUM
        
            while($rowp = mysqli_fetch_array($resultPremium, MYSQLI_ASSOC)){
               $arrayp[$rowp['mes']]= (int)$rowp["ventas"]; 
              }
      //SUBASTA        
            while($rowS = mysqli_fetch_array($resultSubasta, MYSQLI_ASSOC)){
               
              $arrays[$rowS['mes']]=(int)$rowS['ventas'] ; 
             } 
    //HOTSALE
          while($rowH = mysqli_fetch_array($resultHotsale, MYSQLI_ASSOC)){
              
             $arrayh[$rowH['mes']]= (int)$rowH["ventas"];
            
         }
?> </div>
		<script type="text/javascript">
Highcharts.chart('grafica', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Ganancias Mensuales Por Ventas'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        categories: [ 'Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre' 
        
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Total ($)'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [{
        name: 'Hotsale',
        data: [<?php for($i=1;$i<=12;$i++){ echo $arrayh[$i].",";}?>]

    }, {
        name: 'Compras Premium',
        data: [<?php for($a=1;$a<=12;$a++){ echo $arrayp[$a].",";}?>]

    }, {
        name: 'Subastas',
        data: [<?php for($x=1;$x<=12;$x++){ echo $arrays[$x].",";}?>]

    }]
});
		</script>
    </div>
</div></div></div>
	</body>
</html>