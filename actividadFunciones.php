<?php



//PUJAS-----------------------------------------------------------------------------------------------------------------------

function actividadPujasUsuario($idS){
$con=conectar();
	$p=0;
	$arregloP= array();

	$query = "SELECT * FROM puja pu INNER JOIN subasta su ON pu.idSubasta = su.idSubasta INNER JOIN propiedad p ON su.idPropiedad = p.idPropiedad WHERE pu.idPersona = '$idS' ";
	$result = mysqli_query($con, $query);
    $num=mysqli_num_rows($result); 
    
	if($num == 0){ 

		throw new Exception("Aun no haz realizado ninguna puja");
	}
	else{

		while ($row=mysqli_fetch_array($result)){

			$arregloP [$p][0]= $row['fecha'];
			$str= "".date('d/m/Y-H:i', strtotime($row['fecha']))." - Realizaste una puja de $ $row[cantidad] por la propiedad \"$row[titulo]\".";
			$arregloP [$p][1]= $str;
			$p= $p+1;
		}
		return ordenar($arregloP);
	}

}

//INSCRIPCIONES-------------------------------------------------------------------------------------------------------------
function actividadInscripcionesUsuario($idS){
$con=conectar();
	$i=0;
	$arregloI= array();

	$query = "SELECT * FROM inscripto ins INNER JOIN subasta su ON ins.idSubasta = su.idSubasta INNER JOIN propiedad p ON su.idPropiedad = p.idPropiedad WHERE ins.idPersona = '$idS' ";
	$result = mysqli_query($con, $query);
    $num=mysqli_num_rows($result); 
    
	if($num == 0){ 

		throw new Exception("Aun no te haz inscripto en ninguna subasta");
	}
	else{

		while ($row=mysqli_fetch_array($result)){
			
			$arregloI [$i][0]= $row['fecha'];
			$arregloI [$i][1]= "".date('d/m/Y-H:i', strtotime($row['fecha']))." - Te inscribiste a una subasta por una semana en la propiedad \"$row[titulo]\".";
			$i= $i+1;
		}
		return ordenar($arregloI);
	}

}

//HOT SALE----------------------------------------------------------------------------------------------------------------------
function actividadHotSaleUsuario($idS){
$con=conectar();
	$p=0;
	$arregloP= array();

	$query = "SELECT * FROM comprah c INNER JOIN hotsale h ON c.idHotsale = h.idHotsale INNER JOIN subasta su ON h.idSubasta = su.idSubasta INNER JOIN propiedad p ON su.idPropiedad = p.idPropiedad WHERE c.idPersona = '$idS' ";
	$result = mysqli_query($con, $query);
    $num=mysqli_num_rows($result); 
    

	if($num == 0){ 

		throw new Exception("Aun no haz realizado ninguna compra en Hot Sale");
	}
	else{

		while ($row=mysqli_fetch_array($result)){
			
			$arregloP [$p][0]= $row[fecha];
			$arregloP [$p][1]= "".date('d/m/Y-H:i', strtotime($row['fecha']))." - Compraste en Hot Sale a $ $row[precio] una semana en la propiedad \"$row[titulo]\".";
			$p= $p+1;
		}
		return ordenar($arregloP);
	}

}

//PREMIUM------------------------------------------------------------------------------------------------------------------------
function actividadPremiumUsuario($idS){
$con=conectar();
	$i=0;
	$arregloP= array();

	$query = "SELECT * FROM comprap c INNER JOIN subasta su ON c.idSubasta = su.idSubasta INNER JOIN propiedad p ON su.idPropiedad = p.idPropiedad WHERE c.idPersona = '$idS' ";
	$result = mysqli_query($con, $query);
    $num=mysqli_num_rows($result);     

	if($num == 0){ 

		throw new Exception("Aun no haz realizado ninguna compra con el beneficio premium");
	}
	else{

		while ($row=mysqli_fetch_array($result)){
			
			$arregloP [$i][0]= $row[fecha];
			$arregloP [$i][1]= "".date('d/m/Y-H:i', strtotime($row['fecha']))." - Compraste una semana con tu beneficio premium a $ $row[precioMinimo] en la propiedad \"$row[titulo]\".";
			$i= $i+1;
		}
		return ordenar($arregloP);
	}

}

//SUBASTAS GANADAS--------------------------------------------------------------------------------------------------------------
function actividadSubastasGanadasUsuario($idS){
$con=conectar();
	$i=0;
	$arregloP= array();

	$query = "SELECT * FROM ganador g INNER JOIN subasta su ON g.idSubasta = su.idSubasta INNER JOIN propiedad p ON su.idPropiedad = p.idPropiedad INNER JOIN puja pu ON pu.idPuja = g.idPuja WHERE g.idPersona = '$idS' ";
	$result = mysqli_query($con, $query);
    $num=mysqli_num_rows($result); 
    
	if($num == 0){ 

		throw new Exception("Aun no haz ganado ninguna subasta");
	}
	else{

		while ($row=mysqli_fetch_array($result)){
			
			$arregloP [$i][0]= $row['fechaFinSubasta'];
			$arregloP [$i][1]= "".date('d/m/Y-H:i', strtotime($row['fechaFinSubasta']))." - Ganaste la subasta por una semana en la propiedad \"$row[titulo]\" con una puja de $ $row[cantidad].";
			$i= $i+1;
		}
		return ordenar($arregloP);
	}

}

//SUBASTAS PERDIDAS--------------------------------------------------------------------------------------------------------------
function actividadSubastasPerdidasUsuario($idS){
$con=conectar();
	$i=0;
	$arregloP= array();

	$query = "SELECT * FROM ganador g INNER JOIN subasta su ON g.idSubasta = su.idSubasta INNER JOIN propiedad p ON su.idPropiedad = p.idPropiedad INNER JOIN inscripto i ON i.idSubasta = su.idSubasta WHERE g.idPersona != '$idS' AND i.idPersona= '$idS'";
	$result = mysqli_query($con, $query);
    $num=mysqli_num_rows($result);     

	if($num == 0){

		throw new Exception("Aun no haz perdido ninguna subasta");
	}
	else{

		while ($row=mysqli_fetch_array($result)){
			
			$arregloP [$i][0]= $row[fechaFinSubasta];
			$arregloP [$i][1]= "".date('d/m/Y-H:i', strtotime($row['fechaFinSubasta']))." - Perdiste la subasta por una semana en la propiedad \"$row[titulo]\".";
			$i= $i+1;
		}
		return ordenar($arregloP);
	}

}

//TODO SUBASTAS-----------------------------------------------------------------------------------------------------------------
function actividadSubastasTodasUsuario($idS){
	$con=conectar();
	$hayG=true;
	$hayP=true;

	//CHEQUEO SI HAY GANADAS
	try{
		$arregloG= actividadSubastasGanadasUsuario($idS);
	}
	catch(Exception $e){
		$hayG=false;
	}
	
	//CHEQUEO SI HAY PERDIDAS
	try{
		$arregloP= actividadSubastasPerdidasUsuario($idS);
	}
	catch(Exception $e){
		$hayP=false;
	}

	//DEVUELVO LO CORRESPONDIENTE
	if($hayP==true){
		if($hayG==true){  // hay perdidad - hay ganadas

			$arregloM= array_merge($arregloG,$arregloP);	
			return ordenar($arregloM);	
		}
		else{ // hay perdidas - no hay ganadas

			return $arregloP;
		}		
	}
	else{
		if($hayG==true){  // no hay perdidad - hay ganadas

			return $arregloG;	
		}
		else{ // no hay perdidas - no hay ganadas

			throw new Exception("Aun no hay subastas para mostrar.");
			
		}		
	}
}

//TODO COMPRAS------------------------------------------------------------------------------------------------------------------
function actividadComprasTodasUsuario($idS){
$con=conectar();
	$g=true;
	$h=true;
	$p=true;

	//CHEQUEO SI HAY GANADAS
	try{
		$arregloG= actividadSubastasGanadasUsuario($idS);
	}
	catch(Exception $e){
		$g=false;
	}

	//CHEQUEO SI HAY HOT SALE
	try{
		$arregloH= actividadHotSaleUsuario($idS);
	}
	catch(Exception $e){
		$h=false;
	}

	//CHEQUEO SI HAY COMPRAS PREMIUM
	try{
		$arregloP= actividadPremiumUsuario($idS);
	}
	catch(Exception $e){
		$p=false;
	}


	//DEVUELVO LO CORRESPONDIENTE
	if($g==true){
		if($h==true){
			if($p==true){  //  hay g - hay h - hay p

				$arregloM= array_merge($arregloG,$arregloH,$arregloP);
				return ordenar($arregloM);
			}
			else{  // hay g - hay h - no p

				$arregloM= array_merge($arregloG,$arregloH);
				return ordenar($arregloM);
			}
		}
		else{
			if($p==true){  //  hay g - no h - hay p

				$arregloM= array_merge($arregloG,$arregloP);
				return ordenar($arregloM);
			}
			else{  // hay g - no h - no p

				return $arregloG;
			}
		}
	}
	else{
		if($h==true){
			if($p==true){  //  no g - hay h - hay p

				$arregloM= array_merge($arregloH,$arregloP);
				return ordenar($arregloM);
			}
			else{  // no g - hay h - no p

				return $arregloH;
			}
		}
		else{
			if($p==true){  //  no g - no h - hay p

				return $arregloP;
			}
			else{  // no g - no h - no p

				throw new Exception("Aun no haz realizado ninguna compra.");
			}
		}
	}

	

}

//COMENTARIOS Y PUNTUACIONES-----------------------------------------------------------------------------------------------------
function actividadComentariosYPuntuacionesUsuario($idS){
$con=conectar();
	$i=0;
	$arregloP= array();

	$query = "SELECT * FROM valoracion v INNER JOIN propiedad p ON v.idPropiedad = p.idPropiedad WHERE v.idPersona = '$idS' ";
	$result = mysqli_query($con, $query);
    $num=mysqli_num_rows($result); 
    
	if($num == 0){ 

		throw new Exception("Aun no haz realizado ningun comentario ni puntuacion");
	}
	else{

		while ($row=mysqli_fetch_array($result)){
		
			$arregloP [$i][0]= $row[fecha];
			$arregloP [$i][1]= "".date('d/m/Y-H:i', strtotime($row['fecha']))."- Realizaste una valoracion para la propiedad \"$row[titulo]\".";
			$i= $i+1;
		}
		return ordenar($arregloP);
	}

}

//TODO---------------------------------------------------------------------------------------------------------------------------
function actividadTodoUsuario($idS){
$con=conectar();
	$c=true;
	$v=true;
	$p=true;
	$i=true;

	//CHEQUEO SI HAY COMPRAS
	try{
		$arregloC= actividadComprasTodasUsuario($idS);
	}
	catch(Exception $e){
		$c=false;
	}

	//CHEQUEO SI HAY VALORACIONES
	try{
		$arregloV= actividadComentariosYPuntuacionesUsuario($idS);
	}
	catch(Exception $e){
		$v=false;
	}

	//CHEQUEO SI HAY PUJAS
	try{
		$arregloP= actividadPujasUsuario($idS);
	}
	catch(Exception $e){
		$p=false;
	}

	//CHEQUO SI HAY INSCRIPCIONES
	try{
		$arregloI= actividadInscripcionesUsuario($idS);
	}
	catch(Exception $e){
		$i=false;
	}


	//DEVUELVO LO CORRESPONDIENTE
	if($c==true){
		if($v==true){
			if($p==true){
				if($i==true){  //   hay c - hay v - hay p - hay i

					$arregloM= array_merge($arregloC,$arregloV,$arregloP,$arregloI);
					return ordenar($arregloM);
				}
				else{  //   hay c - hay v - hay p - no i

					$arregloM= array_merge($arregloC,$arregloV,$arregloP);
					return ordenar($arregloM);
				}
			}
			else{  // p=false

				if($i==true){  //   hay c - hay v - no p - hay i

					$arregloM= array_merge($arregloC,$arregloV,$arregloI);
					return ordenar($arregloM);
				}
				else{  //   hay c - hay v - no p - no i

					$arregloM= array_merge($arregloC,$arregloV);
					return ordenar($arregloM);
				}
			}
		}
		else{  // v=false

			if($p==true){
				if($i==true){  //   hay c - no v - hay p - hay i

					$arregloM= array_merge($arregloC,$arregloP,$arregloI);
					return ordenar($arregloM);
				}
				else{  //   hay c - no v - hay p - no i

					$arregloM= array_merge($arregloC,$arregloP);
					return ordenar($arregloM);
				}
			}
			else{  // p=false

				if($i==true){  //   hay c - no v - no p - hay i

					$arregloM= array_merge($arregloC,$arregloI);
					return ordenar($arregloM);
				}
				else{  //   hay c - no v - no p - no i

					return $arregloC;
				}
			}
		}
	}
	else{  // c=false

		if($v==true){
			if($p==true){
				if($i==true){  //   no c - hay v - hay p - hay i

					$arregloM= array_merge($arregloV,$arregloP,$arregloI);
					return ordenar($arregloM);
				}
				else{  //   no c - hay v - hay p - no i

					$arregloM= array_merge($arregloV,$arregloP);
					return ordenar($arregloM);
				}
			}
			else{  // p=false

				if($i==true){  //   no c - hay v - no p - hay i

					$arregloM= array_merge($arregloV,$arregloI);
					return ordenar($arregloM);
				}
				else{  //   no c - hay v - no p - no i

					return $arregloV;
				}
			}
		}
		else{  // v=false

			if($p==true){
				if($i==true){  //   no c - no v - hay p - hay i

					$arregloM= array_merge($arregloP,$arregloI);
					return ordenar($arregloM);
				}
				else{  //   no c - no v - hay p - no i

					return $arregloP;
				}
			}
			else{  // p=false

				if($i==true){  //   no c - no v - no p - hay i

					return $arregloI;
				}
				else{  //   no c - no v - no p - no i

					throw new Exception("Aun no hay actividad para mostrar");
				}
			}
		}
		
	}

}

//ORDENAR-----------------------------------------------------------------------------------------------------------------------
function compararFechas ( $a, $b ) {

    return strtotime($b[0]) - strtotime($a[0]);
}
 
function ordenar ($arreglo){

	$arreglo1=$arreglo;
	usort($arreglo1, 'compararFechas');
	return $arreglo1;
}

?>