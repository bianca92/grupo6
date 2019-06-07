<?php


$fecha_actual = date('Y-m-d');
$nuevafecha = strtotime ( '+6 month' , strtotime ( $fecha_actual ) ) ;
$nuevafecha = date ( 'Y-m-d' , $nuevafecha );

          
 
?>
<form method="GET" action="listarPropiedades.php" >
 <p></i><input type="text" name="lugar" required="required" placeholder="Ingrese lugar" />
 </i><input type="date" name="inicio" min='<?php echo $nuevafecha; ?>' required="required" />
 </i><input type="date" name="fin" min='<?php echo $nuevafecha; ?>' required="required"/>
 <input type="submit" value="Buscar"/> 
</form>
