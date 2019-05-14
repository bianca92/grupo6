
<html>

	<div id="menu">
             
                 <ul class="nav nav-pills">
                  <li><a href="listarPropiedades">PROPIEDADES</a></li>
             	         
    <?php
			if(isset($_SESSION['estado'])){
      	  		 if($_SESSION['estado']=="logeado"){

                        if($_SESSION['rol']=="1"){
                       ?>	
                        	
                          <li class="active"><a href="propiedades.php">Agregar</a></li>
                          <li><a href="listarSubastas.php">SUBASTAS</a></li>
						              <li class="active"><a href="altaSubasta.php">Agregar</a></li>
                                            
                             
		 <?php
                        }


                       else{
           ?>
						
				               
                       <li><a href="listarSubastas.php">SUBASTAS</a></li>
						           <li><a href="misSubasta.php">MIS SUBASTAS</a></li>
                                            
    <?php						  		
			                }
		            } 
                 

	     
           }
			    ?>
              </ul>
           </div>
         <div class="clearfix visible-lg"></div>       
	
      <script src="js/jquery.js"></script>
	  <script src="js/bootstrap.min.js"></script>
	  <script src="js/bootstrapValidator.min.js"></script>





</html>