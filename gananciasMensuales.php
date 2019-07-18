
<html >
<head>
    <?php
    include("cabecera.php");
 $mostrar = "";

  if (isset($_GET['ver'])){

    $tipo = $_GET['ver'];
    $mostrar= "where p.tipoU = $tipo";
 } 
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script src="jsjquery.min.js"></script>
<script src="js/code/highcharts.js"></script>
<script src="js/code/themes/grid.js"></script>
<script src="js/code/modules/exporting.js"></script>
<script src = "https://code.highcharts.com/highcharts.src.js" > </script>
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Estadísticas</title>

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
 
#grafica, #consulta {
    padding: 18px 20px;    
    text-align:center;
}
 
.form {
    text-align: center;
    margin: 0 auto;    
    max-width: 320px;
}
 
table {
    cursor: pointer;
    padding:8px;
    width: 100%;
}
 
th { text-align:center ;
    background: rgb(66, 159, 202);  
    border-color: rgb(66, 159, 202);
}
 
tr, td{ text-align:center ;
    border: 1px solid rgb(66, 159, 202); 
    border-radius: 5px;
}
</style>
</head>
<body>
<div class="container-fluid">
    

    <div class="row">
    <?php include('menuEstadistica.php');?>
    <div class="col-md-9" style="aling:right">
    <div id="consulta"><h1>Total de ganancias mensuales</h1><hr>

          <?php
            include("conexion.php");  $con=conectar();
            
            $query =  "SELECT month(fecha) as mes,COUNT(month(fecha)) as total, SUM(monto) as ventas , p.tipoU

                       FROM(SELECT c.monto, c.fecha, c.idPersona FROM comprap as c NATURAL JOIN subasta as s 
                             UNION ALL
                            SELECT c.monto, c.fecha, c.idPersona FROM comprasu as c NATURAL JOIN subasta as s
                              UNION ALL
                            SELECT c.monto, c.fecha, c.idPersona FROM comprah as c NATURAL JOIN hotsale as h NATURAL JOIN subasta as s
                         ) c NATURAL JOIN persona p ".$mostrar." GROUP by month(fecha)" ;       

            $result = mysqli_query($con, $query);
            $num=mysqli_num_rows($result); 
           if ($num==0) {
             echo"<h4>NO SE HAN ENCONTRADO RESULTADOS</h4>";
            }
            else{   ?>  
            
             <table>
            <thead>
                <tr>
                    <th>MES</th>
                    <th>CANTIDAD</th>
                    <th>VENTAS</th>
                    <th>Total de ventas</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $c=0;
            $a=0;
            $total=0;
            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
              setlocale(LC_TIME, 'fr_FR.UTF-8');
                $fecha = DateTime::createFromFormat('!m', "0".$row["mes"]);
                $mes = ucfirst(strftime("%B", $fecha->getTimestamp()));
                $meses[$c] = $mes;
                $ventas[$c] = $row["ventas"];
                $cantidad[$c] = $row["total"];   
                $total = $total + $row["total"];
                $c++;
            }
            for ($j=0;$j<=$c-1;$j++)
            {
                $a++;
                echo "<tr><td>".$meses[$j];
                echo "</td><td>".$cantidad[$j]; 
                echo "</td><td>".'$'.$ventas[$j]; 

                //echo "</td><td>".$total;
               
                if ($j==0)  
                {
                echo "</td><td rowspan=".$c.">".$total."</td></tr>";
                }
            }
            mysqli_close($con);       
            ?>
            </tbody>
            </table>
        </div>
       
        <script type="text/javascript">
        $(function () {
            var colors = Highcharts.getOptions().colors,
            categories = [<?php for($y=0; $y<=$c-1; $y++){ echo "'".$meses[$y]."',";}?>    ],
            name = 'ventas por ',
            data = [
            <?php for($x=0;$x<=$c-1;$x++){ ?>    
            {
                y: <?php echo $ventas[$x]; ?>,
                color: colors[<?php echo $x; ?>],                    
            },  
            <?php } ?>        
            ];
            function setChart(name, categories, data, color) {
                chart.xAxis[0].setCategories(categories, false);
                chart.series[0].remove(false);
                chart.addSeries({
                    name: name,
                    data: data,
                    color: color || 'white'
                }, false);
                chart.redraw();
            }
            var chart = $('#grafica').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Ganancias mensuales'
                },
                xAxis: {
                    categories: categories
                },
                credits: {
                    enabled: false
                },
                plotOptions: {
                    column: {
                        cursor: 'pointer',
                        point: {
                            events: {
                                click: function() {
                                    var drilldown = this.drilldown;
                                    if (drilldown) {  
                                        setChart(drilldown.name, drilldown.categories, drilldown.data, drilldown.color);
                                    } else {  
                                        setChart(name, categories, data);
                                    }
                                }
                            }
                        },
                        dataLabels: {
                            enabled: true,
                            color: colors[0],
                            style: {
                                fontWeight: 'bold'
                            },
                            formatter: function() {
                                return this.y +' $';
                            },
                        }
                    }
                },
                series: [{
                    name: name,
                    data: data,
                    color: 'white'
                }],
                exporting: {
                    enabled: true
                }
            })
            .highcharts();  
        });
        </script>
        <div id="grafica"></div> <?php } ?> </div></div>
    </div>
</body>
</html>