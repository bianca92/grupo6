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
    text-align:center;}
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


<?php //<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div> ?>
<div class="container-fluid">
    <div class="row">
    <?php include('menuEstadistica.php');?>
    <div class="col-md-9" style="aling:right">
    <div id="consulta"> <div id="grafica">
<?php
include("conexion.php");  $con=conectar();
                                        
$queryp = 'SELECT COUNT(idPuja) as pujas, idPropiedad, p.titulo, p.localidad, max(pu.cantidad) as total 

             FROM puja as pu NATURAL JOIN subasta as s NATURAL JOIN propiedad as p

             where idSubasta in(SELECT idSubasta from comprasu) 

             GROUP BY p.idPropiedad ORDER BY `pujas` DESC';
 $resultp = mysqli_query($con, $queryp);
   
?>

     <table>
            <thead>
                <tr>
                  <h4 style="font-family: sans-serif;">CANTIDAD DE PUJAS POR PROPIEDAD</h4>
                    <th>RESIDENCIA</th>
                    <th>CANTIDAD</th>
                    <th>VENTAS</th>
                    
                </tr>
            </thead>
            <tbody>
              <?php while ($rowP = mysqli_fetch_array($resultp, MYSQLI_ASSOC)) { ?>
                 </tr><td><?php echo $rowP['titulo']." ".$rowP['localidad']; ?></td>
              <td><?php echo $rowP['pujas']; ?></td>
              <td><?php echo "$ ".$rowP['total'];?></td></tr>
             <?php } ?>
             
             </tbody>
            </table> 
 </div>
	
    </div>
</div></div></div>
	</body>
</html>