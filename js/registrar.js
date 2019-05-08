function validareg()
 {	
	var cvalido=/[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;  // para validar si es un correo electronico
   var nvalido=/\d/; // para validar que el primer caracter ingresado es una letra
   //variable numeros,
   var patron=/^\d{9}$/;
   var patron2=/^\d{8}$/;
   var p1=document.formulario.password1.value;
   var p2=document.formulario.password2.value;
   var espacios=false;
   var cont=0;

	if ((document.formulario.nombre.value.length == 0)) 
		{
			alert("INGRESE UN NOMBRE");
			document.formulario.nombre.focus();
			// sino se cumple la condicion
			return false;
		}
	else{
		  if ((document.formulario.apellido.value.length == 0) || ( nvalido.test(document.formulario.apellido.value)))
		  	{
					alert("APELLIDO erroneo!, Asegurese de no ingresar espacios en blanco");
					document.formulario.apellido.focus();
					//sino se cumple la condicion
					return false;
		 	 }
		  else{
		  		 if (document.formulario.telefono.value.length == 0)
		  			{
				       	alert("INGRESE UN TELEFONO VALIDO");
				    	document.formulario.telefono.focus();
				       	//sino se cumple la condicion
				      	return false;
		 			 }
		 		 else{
		 		 		
		 		 				if ((document.formulario.dni.value.length == 0 ) || (!patron2.test(document.formulario.dni.value)))
		 		 				{
		 		 					alert("INGRESE UN DNI VALIDO ¡EXACTAMENTE 8 DIGITOS!");
		 		 					document.formulario.dni.focus();
		 		 					//sino cumple condicion
		 		 					return false;
		 		 				}	 
						  		else{
				             			if ((document.formulario.email.value.length == 0) || (! cvalido.test(document.formulario.email.value))) 
						     			{
						     				alert(" E-mail NO VALIDO, INTENTE NUEVAMENTE!!");
							    			document.formulario.email.focus();
							    			// sino se cumple la condicion
							    			return false;
							  			}
						  				else{

						        			if (document.formulario.password1.value.length == 0 || document.formulario.password2.value.length == 0)
						        			{
						        				alert("LOS CAMPOS DE CONTRASEÑA NO PUEDEN ESTAR VACIOS");
						        				return false;
						       				}

						  					 else{
						   	     					if(document.formulario.password1.value != document.formulario.password2.value)
						   	     					{
						   	     						alert("LAS CONTRASENAS DEBEN COINCIDIR");
						   	     						return false;
						   	     					}  

						   							 else{
						    								 while(!espacios && (cont < p1.length))
						    								 {
						    	 								if(p1.charAt(cont)==" ")
						    	 									espacios=true;
						    	 									cont++;
						    	 							}
						    								 if(espacios)
						    								 {
						    	 								 alert("LA CONTRASEÑA NO PUEDE CONTENER ESPACIOS EN BLANCO");
						    	 								 return false;
						    	 	
						    							     }
															else{
																	 alert("FORMULARIO COMPLETO");
								   									 return true;
																}
															}
									
										}
							}
								}
						}

		    	 }

        	 }
     }
    
 }
function validarusu()
{
   var nvalido=/^\d+$/; // para validar que el primer caracter ingresado es una letra
			if ((document.formulario2.usuario.value.length == 0) || ( nvalido.test(document.formulario2.usuario.value)))
			{
				alert(" USUARIO INVALIDO, INTENTE NUEVAMENTE ");
				document.formulario2.usuario.focus();
				//sino se cumple la condicion
				return false;
			}
			else
			{
				if (document.formulario2.clave.value.length == 0)
				 {
					alert("CONTRASEÑA INCORRECTA");
					document.formulario2.clave.focus();
					// sino se cumple la condicion
					return false;
				 }
				else
				{
					//alert("DATOS CORRECTOS");
				    return true;
		        }
      	   }
}