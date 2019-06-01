<?php
// se recibe el valor que identifica la imagen en la tabla

function mensajeActiva($idS){
	$link=conectar();

//le envio mensaje a los inscriptos de que se abrio la subasta
$query = "SELECT idPersona FROM inscripto WHERE idSubasta='$idS' ";
            $result = mysqli_query($link, $query);
            $num=mysqli_num_rows($result); 


   $contenido="La subasta se ha activado";
   $fecha=date('Y-m-j-H:i');
	while($row = mysqli_fetch_array($result)){
         $var_consulta="INSERT INTO mensaje (idPersona,idSubasta,contenido,fecha)
                     values('$row[0]','$idS','$contenido','$fecha')";
            	
          $var_resultado = $link->query($var_consulta);


	}





}

function mensajeTermino($idS){
	$link=conectar();

//le envio mensaje a los inscriptos de que se abrio la subasta
$query = "SELECT idPersona FROM inscripto WHERE idSubasta='$idS' ";
            $result = mysqli_query($link, $query);
            $num=mysqli_num_rows($result); 


   $contenido="La subasta ha terminado";
   $fecha=date('Y-m-j-H:i');
	while($row = mysqli_fetch_array($result)){
         $var_consulta="INSERT INTO mensaje (idPersona,idSubasta,contenido,fecha)
                     values('$row[0]','$idS','$contenido','$fecha')";
            	
          $var_resultado = $link->query($var_consulta);


	}





}










?>