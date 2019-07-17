<?php




          
 
?>
<form class="form-inline" method="GET" action= <?php $pagina.".php" ?>>
 <p></i><input type="text" class="form-control" name="lugar" placeholder="Ingrese nombre o lugar" />
 </i><input type="date" class="form-control" name="inicio" min='<?php echo $nuevafechaB; ?>'  />
 </i><input type="date" class="form-control" name="fin" min='<?php echo $nuevafechaB; ?>'  />
 <input type="submit" class="btn btn-default" value="Buscar"/> 
</form>
