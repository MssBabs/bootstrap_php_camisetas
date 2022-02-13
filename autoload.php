<?php
	/*controllers_autoload(): 
		registra automaticamente los controladores,
		evitando tener que resgistrarlos uno a uno a mano.
	*/
	function controllers_autoload($classname){
		$classname =  ucwords($classname);	// CAMBIADO POR Alberto para GNU/Linux 
		include 'controllers/' . $classname . '.php';
	}

	spl_autoload_register('controllers_autoload');