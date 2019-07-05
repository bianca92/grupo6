<?php
// se recibe el valor que identifica la imagen en la tabla

include("contenidoMensaje.php");

function actualizar($idS){

    $link=conectar();

    // se recupera la información de la subasta
    $sql = "SELECT *
            FROM subasta
            WHERE idSubasta=$idS";
    $result = mysqli_query($link, $sql);
    $row=mysqli_fetch_array($result);

    $fecha_actual = date('Y-m-d');


    if ($row['activa']!=1 && $fecha_actual>=$row['fechaInicioSubasta'] ){

        $consulta="UPDATE subasta SET activa=1 WHERE idSubasta=$idS ";
        $resu = mysqli_query($link,$consulta); 

        //envio mensaje a los suscriptos de que se activo la subasta
        $envio=mensajeActiva($idS);

    }
    
    if ($row['cerrada']!=1 && $fecha_actual>=$row['fechaFinSubasta'] ){

        $consulta="UPDATE subasta SET cerrada=1 WHERE idSubasta=$idS ";
        $resu = mysqli_query($link,$consulta); 

        //establece el ganador
        $consultaGanador= "SELECT * FROM puja WHERE idSubasta=$idS ORDER BY cantidad DESC";
        $resu2 = $link->query($consultaGanador); 
        $num=mysqli_num_rows($resu2); 
        if ($num!=0) {
            $row = mysqli_fetch_array($resu2);
            $var_consulta= "INSERT INTO ganador (idPersona,idSubasta,idPuja)values('$row[idPersona]','$row[idSubasta]','$row[idPuja]') ";
            $var_resultado = $link->query($var_consulta);
        }

        //envio mensaje a los suscriptos de que se termino la subasta
        $envio=mensajetermino($idS);

    }

    $sql = "SELECT *
            FROM subasta
            WHERE idSubasta=$idS";
    $result = mysqli_query($link, $sql);
    $row=mysqli_fetch_array($result);

    $value[0]=$row['activa'];
    $value[1]=$row['cerrada'];
    return $value;

}

//ACTUALIZACION DE CANCELADA PARA LAS DE HOT SALE ------------------------------------------------------------------------
function actualizarHotSale($idS){

    $con=conectar();

    //datos subasta
    $consulta="SELECT * FROM subasta WHERE idSubasta='$idS'";
    $resu = $con->query($consulta); 
    $row=mysqli_fetch_array($resu);

    //datos hot sale
    $consulta="SELECT * FROM config_hotsale";
    $resu2 = $con->query($consulta); 
    $row2=mysqli_fetch_array($resu2);

    //------------------------------------------------------------------------------------
    //CREO LA FECHA DEL HOTSALE DE ESTE AÑO
    $añoH=date("Y");
    $fecha="$row2[dia]-$row2[mes]-$añoH";
    $fechaHotsale= strtotime ( 'd-m-Y' , strtotime ( $fecha ) ) ;
    $fechaH=strtotime($fechaHotsale);

    //me fijo que el hotsale de este año no haya pasado
    $fecha_actual=date('d-m-Y');

    if ($fecha_actual > $fechaHotsale){
       $añoH=$añoH + 1;
       $fecha="$row2[dia]-$row2[mes]-$añoH";
       //creo la fecha definitiva del hotsale
       $fechaHotsale= date ( 'd-m-Y' , strtotime ( $fecha ) ) ;
       //la paso a un formato comparable
       $fechaH=strtotime($fechaHotsale);

    }
    
    //---------------------------------------------------------------------------------------

    //CREO LA FECHA DE LA SUBASTA
    $week_start = new DateTime();
    $week_start->setISODate((int)$row['year'],(int)$row['idSemana']);
    $fechaSubasta= $week_start->format('d-m-Y');
    //le resto las semanas
    $fechaAntes=date('d-m-Y',strtotime($fechaSubasta."- 2 week"));
    //la paso a un formato comparable
    $fechaA=strtotime($fechaAntes);
    //--------------------------------------------------------------------------------------

    //AHORA SI COMPARO LAS FECHAS PARA LA LISTA.

    if ($fechaH<$fechaA){
        //la fecha del proximo hotsale $fechaHotsale es MENOR a la fecha 2 semanas antes de la subasta $fechaAntes
        //pensar en los cumpleaños, la fecha posterior es mas chica que la anterior
         $consulta="UPDATE subasta SET cancelada=1 WHERE idSubasta=$idS ";
        $resu = mysqli_query($con,$consulta); 
        
        return '1'; //se cancela
       
    }
    else {
        //la fecha del proximo hotsale $fechaHotsale es MAYOR a la fecha 2 semanas antes de la subasta $fechaAntes
         return '0';
    }
}

?>