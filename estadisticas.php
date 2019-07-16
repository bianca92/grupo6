

<html >
<head>
    <?php
    include("cabecera.php");
    include("conexion.php");  $con=conectar();

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
 
th { text-align:center ; font-family: sans-serif;
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

<?php
$query= 'SELECT c.idPropiedad,COUNT(month(fecha)) as cantidad, SUM(monto) as total, c.titulo, c.localidad  

FROM(SELECT s.idPropiedad,c.monto, c.fecha, p.titulo, p.localidad FROM comprap as c NATURAL JOIN subasta as s NATURAL JOIN propiedad as p
     UNION ALL 
     SELECT s.idPropiedad,c.monto, c.fecha, p.titulo, p.localidad FROM comprasu as c NATURAL JOIN subasta as s NATURAL JOIN propiedad as p
     UNION ALL 
     SELECT s.idPropiedad,c.monto, c.fecha, p.titulo, p.localidad FROM comprah as c NATURAL JOIN hotsale as h NATURAL JOIN subasta as s NATURAL JOIN propiedad as p ) 
   c GROUP by idPropiedad order by total desc ';
   $result = mysqli_query($con, $query);
   
?>

<div class="container-fluid">
    <div class="row">
    <?php include('menuEstadistica.php');?>
    <div class="col-md-9" style="aling:right">
    <div id="consulta"><h2>INFORMACION</h2><hr>

       <table>
            <thead>
                <tr>
                  <h4 style="font-family: sans-serif;">CANTIDAD DE VENTAS POR PROPIEDAD</h4>
                    <th>RESIDENCIA</th>
                    <th>CANTIDAD</th>
                    <th>VENTAS</th>
                    
                </tr>
            </thead>
            <tbody>
              <?php while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) { ?>
                 </tr><td><?php echo $row['titulo']." ".$row['localidad']; ?></td>
              <td><?php echo $row['cantidad']; ?></td>
              <td><?php echo "$ ".$row['total'];?></td></tr>
             <?php } ?>
             
             </tbody>
            </table> 

    </div>  
  </div> 
  </div> 
</div> 
</body> 
        
