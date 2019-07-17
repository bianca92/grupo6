<html>


<?php

include("clases.php");  
include("cabecera.php");
include("conexion.php");
include("mostrarImagen.php");
include("actualizarSegunFecha.php");
$con=conectar();

  if(isset($_GET['msj'])){
       $mensaje= $_GET['msj'];
//

    if($mensaje="2")
       echo"<script> alert ('DEBE ESTAR REGISTRADO PARA ACCEDER')</script>"; 
    }

$query = "SELECT  p.idPropiedad, p.titulo,p.localidad ,su.precioMinimo, su.fechaInicioSubasta, su.fechaFinSubasta, su.activa,
                  su.idSubasta, su.cerrada, su.year, su.idSemana, su.cancelada,p.eliminada, su.preciopremium, su.enhotsale
          FROM propiedad p INNER JOIN subasta su ON p.idPropiedad=su.idPropiedad";
            $result = mysqli_query($con, $query);
            $num=mysqli_num_rows($result); 

  if ($num==0) {
  echo"<h4>NO SE HAN ENCONTRADO RESULTADOS</h4>";
 }
else{
     
     ?>

  <div class="container">
<?php
?>
  <div>
    <table class="table table-hover"><h4>SUBASTAS TERMINADAS:</h4>
    <thead>
      <tr>
        <th>Subastas</th>
        <th>Titulo</th>
        <th>Localidad</th>
        <th>Semana</th>
        <th>Año</th>
        <th>Precio Inicial</th>
        <th>Precio Premium</th>
        <th>Inicio Subasta</th>
        <th>Fin Subasta</th>
        <th>Precio Venta</th>
        <th>Ganador</th>
      </tr>
    </thead>
    <tbody>
  

    <?php 
 $auxiliar=true;
    while ($row = mysqli_fetch_array($result))  { 
      $actualizar=actualizar($row['idSubasta']);
      $row['activa']=$actualizar[0];
      $row['cerrada']=$actualizar[1];
       //<img src=mostrarImagen.php?idPropiedad=".$row['idPropiedad']." style=width:60%"
       if(($row['activa']==1)&&($row['cerrada']==1)){
          $auxiliar=false; 
       //-------------------------------------------------------------------------------------------
         //OBTENGO PUJA GANADORA 
       $pujaMaxima= "-";
       $pujaMaximaPersona="";
       $mailPer="NO HUBO GANADOR";
        
           $var_consulta4= "SELECT * FROM ganador inner join puja on ganador.idPuja=puja.idPuja WHERE ganador.idSubasta=$row[idSubasta]";
            $result4 = mysqli_query($con, $var_consulta4);
            $numG = mysqli_num_rows($result4);
            $col=0;
            if($numG!=0){

              $col=1;

              //OBTENGO EL MONTO MAXIMO DE PUJA Y QUIEN LO HIZO (GANADOR)
              $row4 = mysqli_fetch_array($result4);
                        $pujaMaxima=$row4['cantidad'];
                        $pujaMaximaPersona= $row4['idPersona'];  
                          
                
                //BUSCA LOS DATOS DEL GANADOR
                
                $consuPers="SELECT email FROM persona WHERE idPersona=$pujaMaximaPersona";
                $resuPer = mysqli_query($con,$consuPers);
                $numPer=mysqli_num_rows($resuPer);
                $rowPer = mysqli_fetch_array($resuPer);
                $mailPer = $rowPer['email'];
                
              }
              else {
                $consulPremium= "SELECT * FROM comprap WHERE idSubasta=$row[idSubasta]";
                $resultPremium = mysqli_query($con, $consulPremium);
                 $numPremium = mysqli_num_rows($resultPremium);
                 if ($numPremium!=0){
                  $col=2;
                  $rowPremium = mysqli_fetch_array($resultPremium);

                $consuPers="SELECT email FROM persona WHERE idPersona=$rowPremium[idPersona]";
                $resuPer = mysqli_query($con,$consuPers);
                $numPer=mysqli_num_rows($resuPer);
                $rowPer = mysqli_fetch_array($resuPer);
                $mailPer = "$rowPer[email](compra premium)";
                $pujaMaxima=$rowPremium['monto'];
                 
                 }

              }
//-----------------------------------------------------------------------------------------------------------------
      $imgs=ObtenerImgs($row['idPropiedad']);
          ?>
        <tr>
          <td> <?php echo '<img src="data:image/jpeg;base64,'.base64_encode($imgs[0]).'" style=width:30% />';?></td>
           <td><h4><?php echo "$row[titulo]" ?></h4> </td>
            <td><h4><?php echo" $row[localidad] ";?></h4></td>
            <td><h4><?php $week_start = new DateTime(); $week_start->setISODate((int)$row['year'],(int)$row['idSemana']);
                                           $fi= $week_start->format('d/m');echo "$fi" ;?></h4></td>
             <td><h4><?php  $fi= $week_start->format('Y');echo "$fi" ;?></h4></td>
            <td><h4><?php echo "$"."$row[precioMinimo]" ?></h4></td>
            <td><h4><?php echo "$"."$row[preciopremium]" ?></h4></td>
            <td><h4><?php $fi=date('d/m/Y', strtotime($row['fechaInicioSubasta'])); echo"$fi" ?></h4></td>
            <td><h4><?php $fs=date('d/m/Y', strtotime($row['fechaFinSubasta'])); echo "$fs"; ?></h4></td>  
            
           

       <?php     //SI LA PROPIEDAD DE LA SEMANA ESTA ELIMINADA
       if (($row['cancelada']==1 or $row['eliminada']==1) && $mailPer=="NO HUBO GANADOR" && $row['enhotsale']!=1) {
         echo"<td></td><td style='color:#FE0813'>ELIMINADA</td><td></td>";
       }
       else{
          if($row['cancelada']==1 && $row['enhotsale']==1){  

            //busco si estuvo en hot sale
             $cHS= "SELECT * FROM hotsale WHERE idSubasta=$row[idSubasta]";
             $rHS = mysqli_query($con, $cHS);
             $nHS = mysqli_num_rows($rHS);

             if($nHS==0){   //no entro al hot sale      
              ?>
                <td><h4><?php echo "$"."$pujaMaxima" ?></h4></td>
               <td><h4><?php echo "$mailPer" ?></h4></td>
               <td><?php echo "<a href='listaPujas.php?sub=".$row['idSubasta']."'> <button type='button' class='btn btn-succes'>PUJAS</button> </a></br>" ;?> 
               <td><?php echo "<a href='inscriptos.php?sub=".$row['idSubasta']."'> <button type='button' class='btn btn-succes'>INSCRIPTOS</button> </a></br>" ; 

             }
             else{  //entro al hot sale y no se vendio
              //busco si se vendio en el hot sale pasado
              $cCHS= "SELECT * FROM comprah c INNER JOIN hotsale h ON c.idHotsale=h.idHotsale INNER JOIN persona p ON c.idPersona=p.IdPersona WHERE h.idSubasta=$row[idSubasta]";
             $rCHS = mysqli_query($con, $cCHS);
             $nCHS = mysqli_num_rows($rCHS);

             if($nCHS==0){
                 ?>
              <td><h4><?php echo "$"."$pujaMaxima" ?></h4></td>
               <td><h4><?php echo "NO SE VENDIO EN EL HOT SALE" ?></h4></td>
            <td><?php echo "<a href='listaPujas.php?sub=".$row['idSubasta']."'> <button type='button' class='btn btn-succes'>PUJAS</button> </a></br>" ;?> 
            <td><?php echo "<a href='inscriptos.php?sub=".$row['idSubasta']."'> <button type='button' class='btn btn-succes'>INSCRIPTOS</button> </a></br>" ;   
              }
              else{
              $rowCHS= mysqli_fetch_array($rCHS);    ?>
                <td><h4><?php echo "$"."$rowCHS[monto]" ?></h4></td>
               <td><h4 style='color:#FF7516'><?php echo "$rowCHS[email]" ?></h4></td>
            <td><?php echo "<a href='listaPujas.php?sub=".$row['idSubasta']."'> <button type='button' class='btn btn-succes'>PUJAS</button> </a></br>" ;?> 
            <td><?php echo "<a href='inscriptos.php?sub=".$row['idSubasta']."'> <button type='button' class='btn btn-succes'>INSCRIPTOS</button> </a></br>" ;
              }

             }

          }
          else{
            if($row['enhotsale']==1 && $row['cancelada']!=1){ // esta en hot sale

              //busco si se vendi en hot sale
             $cCHS= "SELECT * FROM comprah c INNER JOIN hotsale h ON c.idHotsale=h.idHotsale INNER JOIN persona p ON c.idPersona=p.IdPersona WHERE h.idSubasta=$row[idSubasta]";
             $rCHS = mysqli_query($con, $cCHS);
             $nCHS = mysqli_num_rows($rCHS);


             if($nCHS==1){  //se vendio en hot sale    
             $rowCHS= mysqli_fetch_array($rCHS);   ?>
              <td><h4><?php echo "$ $rowCHS[precio]" ?></h4></td>
               <td><h4 style='color:#FF7516'><?php echo "$rowCHS[email]" ?></h4></td>
               <td><?php echo "<a href='listaPujas.php?sub=".$row['idSubasta']."'> <button type='button' class='btn btn-succes'>PUJAS</button> </a></br>" ;?> 
               <td><?php echo "<a href='inscriptos.php?sub=".$row['idSubasta']."'> <button type='button' class='btn btn-succes'>INSCRIPTOS</button> </a></br>" ;
             }
             else{ //aun no se vendio       ?>
              <td></td>
               <td><h4 style='color:#FF7516'><?php echo "PUBLICADA EN HOT SALE" ?></h4></td>
               <td><?php echo "<a href='listaPujas.php?sub=".$row['idSubasta']."'> <button type='button' class='btn btn-succes'>PUJAS</button> </a></br>" ;?> 
               <td><?php echo "<a href='inscriptos.php?sub=".$row['idSubasta']."'> <button type='button' class='btn btn-succes'>INSCRIPTOS</button> </a></br>" ;
             }

            }
            else{ 
              if($mailPer=="NO HUBO GANADOR"){    ?>
              <td><h4><?php echo "$"."$pujaMaxima" ?></h4></td>
               <td><h4><?php echo "$mailPer" ?></h4></td>
              <td><?php echo "<a href='listaPujas.php?sub=".$row['idSubasta']."'> <button type='button' class='btn btn-succes'>PUJAS</button> </a></br>" ;?> 
             <td><?php echo "<a href='inscriptos.php?sub=".$row['idSubasta']."'> <button type='button' class='btn btn-succes'>INSCRIPTOS</button> </a></br>" ;
            }
            else{     ?>
              <td><h4><?php echo "$"."$pujaMaxima" ?></h4></td>
                <?php if($col == 1){    ?>
               <td><h4 style='color:#1BAB01'><?php echo "$mailPer" ?></h4></td>  <?php
             } 
             if($col==2){ ?>
               <td><h4 style='color:#0223AF'><?php echo "$mailPer" ?></h4></td>  <?php

             } ?>
              <td><?php echo "<a href='listaPujas.php?sub=".$row['idSubasta']."'> <button type='button' class='btn btn-succes'>PUJAS</button> </a></br>" ;?> 
             <td><?php echo "<a href='inscriptos.php?sub=".$row['idSubasta']."'> <button type='button' class='btn btn-succes'>INSCRIPTOS</button> </a></br>" ;
            }}
          }?>
            
            <td><?php //echo "<a href='eliminar_subasta.php?sub=".$row['idSubasta']."'> <button type='button' class='btn btn-succes'>Eliminar subasta</button> </a></br>" ;
       }?>
           
         </tr>  
         <?php } } ?>      
      
      </tbody>
  </table>
   <?php
  if ($auxiliar==true){
    echo"<tr><td><h4>NO SE HAN ENCONTRADO RESULTADOS</h4></td></tr>";
   } } 

            mysqli_free_result($result);
            mysqli_close($con);

?> 
</div>
     

 </div>

 
   
   </html>