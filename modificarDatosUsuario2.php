<?php
		
include("clases.php");  
include("cabecera.php");
include("conexion.php");



//$link = mysqli_connect('localhost','root','','grupo6');
$link=conectar();
if(!$link)
{
    echo "<h3>No se ha podido conectar PHP - MySQL, verifique sus datos.</h3><hr><br>";
}
else
{
   // echo "<h3>Conexion Exitosa PHP - MySQL</h3><hr><br>";
}
$id=$_POST['usuario'];
$tarjeta=$_POST['tarjeta'];

$nombre=$_POST['nombre'];
$apellido=$_POST['apellido'];
$dni=$_POST['dni'];
$telefono=$_POST['telefono'];
$ciudad=$_POST['ciudad'];
$email=$_POST['email'];
$nacimiento_actual=$_POST['nacimientoActual'];
$nacimiento=$_POST['nacimiento'];
$marca=$_POST['marca'];
$numero=$_POST['numero'];
$codigo=$_POST['codigo'];
$vencimiento=$_POST['vencimiento']; 
//claves
$claveActual=$_POST['claveAhora'];
$claveActualIngresada=$_POST['clave0']; 
$claveNueva=$_POST['clave'];
$repetirClaveNueva=$_POST['clave2'];

$fecha=date('Y-m-j-H:i');

if($claveActual==$claveActualIngresada){
	$clave=$claveActual;
     if($nacimiento==null){
      
        $nacimiento=date('Y-m-j', strtotime( $nacimiento_actual)) ;
       
     }


	 if($claveNueva!=null){ 
	 	if($claveNueva==$repetirClaveNueva){
         $clave=$claveNueva;
         echo '<script> alert("SE HA MODIFICADO LA CONTRASEÑA");</script>';
        }
        else { echo '<script> alert("LAS CONTRASEÑAS NUEVAS NO COINCIDEN");</script>';
        echo "<script> window.location.href='misDatos.php';</script>";
                 }
	 }
//ACTUALIZAR DATOS USUARIO----------(agregar la fecha de nac)
$var_consulta= "UPDATE persona SET IdPersona='$id', nombre='$nombre', apellido='$apellido', dni='$dni', telefono='$telefono', ciudad='$ciudad', email='$email', clave='$clave', fechaNacimiento='$nacimiento', fechaModificacion='$fecha'  WHERE IdPersona='$id' ";
$var_resultado = $link->query($var_consulta);

//ACTUALIZAR DATOS TARJETA
             $var_consulta= "UPDATE tarjeta SET marca='$marca', numero='$numero', codigo='$codigo', vencimiento='$vencimiento'  WHERE idTarjeta='$tarjeta' ";
               $var_resultado = $link->query($var_consulta);
//Aca termina actualizar tarjeta--------------------------------------------------------

 echo "<script> window.location.href='misDatos.php';</script>";
}


else{ echo '<script> alert("CONTRASEÑA INCORRECTA, NO SE HAN GUARDADO LOS CAMBIOS");</script>';
echo "<script> window.history.back();</script>";
}




 
?>
	