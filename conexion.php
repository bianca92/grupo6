<?php
//archivo conexion.php
function conectar(){
	$link=mysqli_connect('localhost','root','','grupo6')
	or die("Error". mysql_error($link));
	return $link;
}
?>