<!---<form action="formulario.php" method="post">
 <p>Su nombre: <input type="text" name="nombre" /></p>
 <p>Su edad: <input type="text" name="edad" /></p>
 <p><input type="submit" /></p>
</form>
--->
<form method="GET" action="subastasTerminadasUsuario.php" >
 <p><i class="fas fa-search"></i><input type="date" name="inicio" />
 	<input type="date" name="fin" />
 <input type="submit" value="Buscar"/> 
</form>
<?php
//if (!empty($_POST)){
//$nombre=$_POST['nombre'];
//$edad=$_POST['edad'];echo "$nombre - $edad";}
//else {echo "hola";}



          
 
?>