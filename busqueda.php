<?php


$fecha_actual = date('Y-m-d');
$nuevafecha = strtotime ( '+6 month' , strtotime ( $fecha_actual ) ) ;
$nuevafecha = date ( 'Y-m-d' , $nuevafecha );

          
 
?>
<form class="form-inline" method="GET" action= <?php $pagina.".php" ?>>
 <p></i><input type="text" class="form-control" name="lugar" required="required" placeholder="Ingrese lugar" />
 </i><input type="date" class="form-control" name="inicio" min='<?php echo $nuevafecha; ?>' required="required" />
 </i><input type="date" class="form-control" name="fin" min='<?php echo $nuevafecha; ?>'  required="required"/>
 <input type="submit" class="btn btn-default" value="Buscar"/> 
</form>
