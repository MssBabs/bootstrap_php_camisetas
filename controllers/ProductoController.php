<?php
	require_once 'models/Producto.php';


	class productoController{
		
		public function index(){
			$producto = new Producto();
			$productos = $producto->getRandom(6);
		
			//Renderizar vista:
			require_once 'views/producto/destacados.php';
		}
		

		//Mostrar Producto:
		public function ver(){
			if(isset($_GET['id'])){
				$id = $_GET['id'];
			
				$producto = new Producto();
				$producto->setId($id);
				
				$product = $producto->getOne();
				
			}
			require_once 'views/producto/ver.php';
		}
		

		public function gestion(){
			Utils::isAdmin();
			
			$producto = new Producto();
			$productos = $producto->getAll();
			
			require_once 'views/producto/gestion.php';
		}


		//Obtener Producto Mas Vendido (TOP VENTAS):
		public function top(){
			Utils::isAdmin();
			
			$producto = new Producto();
			$productos = $producto->getTop();
			
			require_once 'views/producto/gestion.php';
		}


		//Obtener Productos Sin Ventas:
		public function sinVentas(){
			Utils::isAdmin();
			
			$producto = new Producto();
			$productos = $producto->getSinVentas();
			
			require_once 'views/producto/gestion.php';
		}


		//Obtener Productos Sin Stock:
		public function sinStock(){
			Utils::isAdmin();
			
			$producto = new Producto();
			$productos = $producto->getSinStock();
			
			require_once 'views/producto/gestion.php';
		}
		

		//Obtener Productos Con Ofertas:
		public function conOferta(){
			Utils::isAdmin();
				
			$producto = new Producto();
			$productos = $producto->getOfertas();
				
			require_once 'views/producto/gestion.php';
		}	


		//Crear Producto:
		public function crear(){
			Utils::isAdmin();

			require_once 'views/producto/crear.php';
		}
		

		//Guardar Producto:
		public function save(){
			Utils::isAdmin();

			if(isset($_POST)){
				$nombre      = isset($_POST['nombre']) ? $_POST['nombre'] : false;
				$descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : false;
				$precio      = isset($_POST['precio']) ? $_POST['precio'] : false;
				$oferta      = isset($_POST['oferta']) ? $_POST['oferta'] : false;
				$stock       = isset($_POST['stock']) ? $_POST['stock'] : false;
				$categoria   = isset($_POST['categoria']) ? $_POST['categoria'] : false;
				//$imagen = isset($_POST['imagen']) ? $_POST['imagen'] : false;
				
				if($nombre && $descripcion && $precio && $oferta && $stock && $categoria){
					$producto = new Producto();
					$producto->setNombre($nombre);
					$producto->setDescripcion($descripcion);
					$producto->setPrecio($precio);
					$producto->setOferta($oferta);
					$producto->setStock($stock);
					$producto->setCategoria_id($categoria);
					
					//Guardar la imagen:
					if(isset($_FILES['imagen'])){
						$file = $_FILES['imagen'];
						$filename = $file['name'];
						$mimetype = $file['type'];

						if($mimetype == "image/jpg" || $mimetype == 'image/jpeg' || $mimetype == 'image/png' || $mimetype == 'image/gif'){

							if(!is_dir('uploads/images')){
								mkdir('uploads/images', 0777, true);
							}

							$producto->setImagen($filename);
							move_uploaded_file($file['tmp_name'], 'uploads/images/'.$filename);
						}
					}
					
					if(isset($_GET['id'])){
						$id = $_GET['id'];
						$producto->setId($id);
						
						$save = $producto->edit();
					}else{
						$save = $producto->save();
					}
					
					if($save){
						$_SESSION['producto'] = "complete";
					}else{
						$_SESSION['producto'] = "failed";
					}
				}else{
					$_SESSION['producto'] = "failed";
				}
			}else{
				$_SESSION['producto'] = "failed";
			}

			header('Location:'.base_url.'Producto/gestion');
		}
		
		
		//Editar Producto:
		public function editar(){
			Utils::isAdmin();

			if(isset($_GET['id'])){
				$id = $_GET['id'];
				$edit = true;
				
				$producto = new Producto();
				$producto->setId($id);
				
				$pro = $producto->getOne();
				
				require_once 'views/producto/crear.php';
				
			}else{
				header('Location:'.base_url.'Producto/gestion');
			}
		}
		

		//Eliminar Producto:
		public function eliminar(){
			Utils::isAdmin();
			
			if(isset($_GET['id'])){
				$id = $_GET['id'];
				$producto = new Producto();
				$producto->setId($id);
				
				$delete = $producto->delete();
				if($delete){
					$_SESSION['delete'] = 'complete';
				}else{
					$_SESSION['delete'] = 'failed';
				}
			}else{
				$_SESSION['delete'] = 'failed';
			}
			
			header('Location:'.base_url.'Producto/gestion');
		}
	}
?>