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
    $nac=$_POST['nacimiento'];
    $num=$_POST['numero'];
    $marca=$_POST['marca'];
    $venc=$_POST['vencimiento'];
    $cod=$_POST['codigo'];

        $con=conectar();

        
        $resul=mysqli_query($con,"SELECT email FROM persona  WHERE email='$e' ");//verificamos si hay un mail igual

        if(mysqli_num_rows($resul)==1){//si existe un usuario con el mismo mail
            echo '<script> alert("INGRESE OTRO MAIL");</script>';
            echo '<script> window.location ="registrar.php";</script>';

            //echo" existe usuario con el mismo mail ";
        }
        else{//si el usuario no existe se da de alta en la base de  datos;

            $fechaActual = date('Y-m-d-H:i');         
            $nuevaFecha = "01/".$venc;
            $nueva= date('Y-m-d',strtotime($nuevaFecha));
               
          //CARGAR DATOS DEL USUARIO
            $query="INSERT INTO persona (dni,nombre,apellido,telefono,email,clave,tipoU,rol,credito,ciudad,fechaRegistro,fechaNacimiento, fechaModificacion)values('$dni','$n','$a','$t','$e','$p','clasico','0','2','$c','$fechaActual', '$nac', '$fechaActual')";
            $resul5=mysqli_query($con,$query);

            $id=mysqli_insert_id($con);

            //CARGAR DATOS DE LA TARJETA
            $queryT="INSERT INTO tarjeta (idPersona, numero, marca, vencimiento, codigo)values('$id','$num','$marca','$nueva','$cod')";
            $resulT=mysqli_query($con,$queryT);

            $idT=mysqli_insert_id($con);

            //ENLAZAR TARJETA CON USUARIO
            $queryTP="UPDATE persona SET idTarjeta='$idT'  WHERE idPersona='$id'";
            $resulTP=mysqli_query($con,$queryTP);


        

            
    
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