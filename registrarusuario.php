<?php
include("clases.php");  
    
include("conexion.php");
session_start();

    $n=$_POST['nombre'];
    $a=$_POST['apellido'];
    
    $dni=$_POST['dni'];
    $e=$_POST['email'];
    $t=$_POST['telefono'];
    $p=$_POST['password1'];
    $c=$_POST['ciudad'];

        $con=conectar();

        
        $resul=mysqli_query($con,"SELECT email FROM persona  WHERE email='$e' ");//verificamos si hay un mail igual

        if(mysqli_num_rows($resul)==1){//si existe un usuario con el mismo mail
            echo '<script> alert("INGRESE OTRO MAIL");</script>';
            echo '<script> window.location ="registrar.php";</script>';

            //echo" existe usuario con el mismo mail ";
        }
        else{//si el usuario no existe se da de alta en la base de  datos;
          
            $query="INSERT INTO persona (dni,nombre,apellido,telefono,email,clave,tipoU,rol,credito,ciudad)values('$dni','$n','$a','$t','$e','$p','clasico','0','2','$c')";
            $resul5=mysqli_query($con,$query);

            $id=mysqli_insert_id($con);
    
           // $query2="INSERT INTO credito (monto,idUsuario)values('1','$id')";
           // $resul2=mysqli_query($con,$query2);
            

        }

if($resul5){  //SE INGRESO CORRECTAMENTE
     try{
     $login = new Login();
    $fila=$login->autentificar($con,$p,$e);
    
    header("Location:index.php");
      }
    catch(Exception $e){
    echo $e->getMessage();}


}
else{
          echo '<script> alert("NO SE PUDO CREAR SU CUENTA!! INTENTE NUEVAMENTE");</script>';
          echo '<script> window.location ="registrar.php";</script>';
        }   
?>