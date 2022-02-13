<?php
	session_start();

	require_once 'autoload.php';
	require_once 'config/db.php';
	require_once 'config/parameters.php';
	require_once 'helpers/Utils.php';

	
	require_once 'views/layout/header.php';
	require_once 'views/layout/sidebar.php';


	function show_error(){
		$error = new errorController();
		$error->index();
	}


	//Obtener la clase del controlador:
	if(isset($_GET['controller'])){
		$nombre_controlador = $_GET['controller'].'Controller';
	}elseif(!isset($_GET['controller']) && !isset($_GET['action'])){
		//controller_default definido en config/parameters.php -> productoController
		$nombre_controlador = controller_default;
	}else{
		show_error();
		exit();
	}


	//Ejecuta acción definida en el controlador:
	if(class_exists($nombre_controlador)){	
		$controlador = new $nombre_controlador();
		
		if(isset($_GET['action']) && method_exists($controlador, $_GET['action'])){
			$action = $_GET['action'];
			$controlador->$action();
		}elseif(!isset($_GET['controller']) && !isset($_GET['action'])){
			//action_default definido en config/parameters.php -> index
			$action_default = action_default;
			$controlador->$action_default();
		}else{
			show_error();
		}
	}else{
		show_error();
	}


	require_once 'views/layout/footer.php';
?>