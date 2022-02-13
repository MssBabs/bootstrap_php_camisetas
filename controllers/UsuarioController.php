<?php
	require_once 'models/Usuario.php';
	require_once 'models/Pedido.php';


	class usuarioController{
		
		public function index(){
			echo "Controlador Usuarios, Acción index";
		}
		

		public function registro(){
			require_once 'views/usuario/registro.php';
		}
		

		//Guardar Usuario
		public function save(){
			if(isset($_POST)){
				
				$nombre    = isset($_POST['nombre']) ? $_POST['nombre'] : false;
				$apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : false;
				$email     = isset($_POST['email']) ? $_POST['email'] : false;
				$password  = isset($_POST['password']) ? $_POST['password'] : false;
				
				if($nombre && $apellidos && $email && $password){
					$usuario = new Usuario();
					$usuario->setNombre($nombre);
					$usuario->setApellidos($apellidos);
					$usuario->setEmail($email);
					$usuario->setPassword($password);

					if($_POST['operacion'] == 'Registrarse'){
						$save = $usuario->save();

						if($save){
							$_SESSION['register'] = "complete";

							header("Location:".base_url.'usuario/registro');
						}else{
							$_SESSION['register'] = "failed";
						}
					}else{
						$usuario->setId($_GET['id']);
						$edit = true;
						$editado = $usuario->edit();

						if($editado){
							$_SESSION['register'] = "complete";

							header("Location:".base_url.'usuario/editar&id='.$usuario->getId());
						}else{
							$_SESSION['register'] = "failed";
						}
					}
				}else{
					$_SESSION['register'] = "failed";
				}
			}else{
				$_SESSION['register'] = "failed";
			}
		}
		

		//Identificar Usuario:
		public function login(){
			if(isset($_POST)){
				
				$usuario = new Usuario();
				$usuario->setEmail($_POST['email']);
				$usuario->setPassword($_POST['password']);
				
				$identity = $usuario->login();
				
				//Consulta a la base de datos
				if($identity && is_object($identity)){
					$_SESSION['identity'] = $identity;
					
					if($identity->rol == 'admin'){
						$_SESSION['admin'] = true;
					}
					
				}else{
					$_SESSION['error_login'] = 'Identificación fallida !!';
				}
			}

			header("Location:".base_url);
		}
		

		public function logout(){
			if(isset($_SESSION['identity'])){
				unset($_SESSION['identity']);
			}
			
			if(isset($_SESSION['admin'])){
				unset($_SESSION['admin']);
			}
			
			header("Location:".base_url);
		}
		

		public function gestion(){
			Utils::isAdmin();
			
			$usuario = new Usuario();
			$usuarios = $usuario->getAll();
			
			require_once 'views/usuario/gestion.php';
		}


		//Editar Usuario:
		public function editar(){
			//Utils::isAdmin();
			
			if(isset($_GET['id'])){
				$id = $_GET['id'];
				$edit = true;
				
				$usuario = new Usuario();
				$usuario->setId($id);
				
				$usu = $usuario->getOne();
				
				require_once 'views/usuario/registro.php';
				
			}else{
				header('Location:'.base_url.'usuario/gestion');
			}
		}


		//Eliminar Usuario:
		public function eliminar(){
			Utils::isAdmin();
			
			if(isset($_GET['id'])){
				$id = $_GET['id'];

				$usuario = new Usuario();
				$usuario->setId($id);
				//var_dump($usuario);

				//Solo se puede eliminar si no tiene pedidos pendientes
				$pedido = new Pedido();
                $pedido->setUsuario_id($usuario->getId());
				$pedidosPendientes = $pedido->getPedidosPendientesByUsuario();
                $resultado = $pedidosPendientes->fetch_object();

				if(($resultado == null) || ($resultado->pedidosPendientes == 0)){
					$delete = $usuario->delete();

					if($delete){
						$_SESSION['delete'] = 'complete';
					}else{
						$_SESSION['delete'] = 'failed';
					}
				}else{
					$_SESSION['delete'] = 'failed';
				}
			}else{
				$_SESSION['delete'] = 'failed';
			}
			
			header('Location:'.base_url.'Usuario/gestion');
		}
	} // fin clase
?>