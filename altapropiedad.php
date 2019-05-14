<?php
include("clases.php");  
    
include("conexion.php");
session_start();

    $t=$_POST['titulo'];
    $des=$_POST['descripcion'];
    $c=$_POST['ubicacion'];
    
        $con=conectar();

        
    //Insertar informacion de texto  
  $query="INSERT INTO propiedad (titulo,descripcion,ciudad)values('$t','$des','$c')";
  $resu=mysqli_query($con,$query);

 $ultimo_id=mysqli_insert_id($con);

//Insertar Imagenes
for($i = 0; $i < count($_FILES['imagen']['name']); $i++){

    $imagen= $_FILES['imagen']['tmp_name'][$i]; //archivo temporal
    $imagen2= file_get_contents("$imagen");//leer el contenido de un archivo en una cadena.
     $imagen2=addslashes($imagen2); // agrega barra invertidas /

     $extension = $_FILES['imagen']['type'][$i];
      $extension=str_replace("image/", "", $extension); //remplaza en la cadena "image/" por ""

       $query="INSERT INTO imagen (contenidoImagen,tipoImagen,idPropiedad)values('$imagen2','$extension','$ultimo_id')";
             $resu=mysqli_query($con,$query);
}


            
            header("Location:index.php");
    
           // $query2="INSERT INTO credito (monto,idUsuario)values('1','$id')";
           // $resul2=mysqli_query($con,$query2);
            

        


?>