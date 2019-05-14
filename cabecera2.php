<!DOCTYPE html>
<?php
  session_start();
?>
<html lang="en">
<head>
  <title>Home Switch Home</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  
  

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href=""><img id="logoinicio" src="imgs/HSH-Complete.svg" class="img-thumbnail"></a> 
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="index.php">Home</a></li>
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Page 1 <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="#">Page 1-1</a></li>
          <li><a href="#">Page 1-2</a></li>
          <li><a href="#">Page 1-3</a></li>
        </ul>
      </li>
      <li><a href="#">Page 2</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <?php
      if(isset($_SESSION['estado'])){
               if($_SESSION['estado']=="logeado"){

                        if($_SESSION['rol']=="1"){

                           echo" <li>HOLA ADMINISTRADOR ".$_SESSION['nombre']." ! </li>
                                 <li><a href=salir.php><span class='glyphicon glyphicon-log-out'></span>CERRAR SESIÓN</a></li>";}
                        else {
                          echo"  <li>HOLA".$_SESSION['nombre']."! </li>
                                 <li><a href=salir.php><span class='glyphicon glyphicon-log-out'></span>CERRAR SESIÓN</>"; 
                                 }
                }
                }                 
                else{
                          echo"
                                <li><a href=registrar.php><span class='glyphicon glyphicon-user'></span>Registrarse</a></li>
                                <li><a href=ingresar.php><span class='glyphicon glyphicon-log-in'></span>Iniciar sesion</a></li>";    


                } 
                                         
       ?>

    </ul>
  </div>
</nav>

<script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrapValidator.min.js"></script>
</body>
</hml>