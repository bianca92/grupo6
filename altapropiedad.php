<?php
include("clases.php");  
    
include("conexion.php");
session_start();

    $t=$_POST['titulo'];
    $des=$_POST['descripcion'];
    $c=$_POST['ubicacion'];
    
     //$foto=$_FILES['imagen']['name'];
   //$ruta=$_FILES['imagen']['tmp_name'];
    //$destino="imgs/".$foto;
    //copy($ruta,$destino);

    
$imagen= $_FILES['imagen']['tmp_name']; //archivo temporal
$imagen2= file_get_contents("$imagen");//leer el contenido de un archivo en una cadena.
$imagen2=addslashes($imagen2); // agrega barra invertidas /

$extension = $_FILES['imagen']['type'];
$extension=str_replace("image/", "", $extension); //remplaza en la cadena "image/" por ""
    
    


    

        $con=conectar();

        
      
            $query="INSERT INTO propiedad (titulo,descripcion,ciudad,imagen,tipoimagen)values('$t','$des','$c','$imagen2','$extension')";
            $resu=mysqli_query($con,$query);

            $id=mysqli_insert_id($con);
            header("Location:index.php");
    
           // $query2="INSERT INTO credito (monto,idUsuario)values('1','$id')";
           // $resul2=mysqli_query($con,$query2);
            

        


?>