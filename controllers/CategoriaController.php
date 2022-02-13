<?php
	require_once 'models/Categoria.php';
	require_once 'models/Producto.php';


	class categoriaController{
		
		public function index(){
			Utils::isAdmin();
			$categoria = new Categoria();
			$categorias = $categoria->getAll();
			
			require_once 'views/categoria/index.php';
		}
		

		public function ver(){
			if(isset($_GET['id'])){
				$id = $_GET['id'];

				//1ºVars Paginación:
				$pagina=1;
				if(isset($_GET['pagina'])){
					$pagina = $_GET['pagina'];
				}
				$cantidadMostrar=6;
				
				//Conseguir categoria:
				$categoria = new Categoria();
				$categoria->setId($id);
				$categoria = $categoria->getOne();
				
				//Conseguir productos:
				$producto = new Producto();
				$producto->setCategoria_id($id);
				//2ºnumero de paginas-> como num_rows/$cantidadMostrar
				$numeroDePaginas = ceil($producto->getAllCategory()->num_rows/$cantidadMostrar);
				//3ºle mando la pagina en la que estamos y la cantidad a productos que mostrar
				$productos = $producto->getAllCategoryPaginado($pagina, $cantidadMostrar);
			}
			
			require_once 'views/categoria/ver.php';
		}
		

		public function verTodos(){
			//1ºVars Paginación:
			$pagina=1;
			if(isset($_GET['pagina'])){
				$pagina = $_GET['pagina'];
			}
			$cantidadMostrar=6;
		
			//Conseguir categoria:
			$categoria = new stdClass();//create a new
			$categoria->nombre = "Todos los productos";

			//Conseguir productos:
			$producto = new Producto();
			

			//2ºnumero de paginas-> como num_rows/$cantidadMostrar
			$numeroDePaginas=ceil($producto->getAll()->num_rows/$cantidadMostrar);
			//3ºle mando la pagina en la que estamos y la cantidad a productos que mostrar
			$productos = $producto->getAllPaginado($pagina, $cantidadMostrar);
			

			require_once 'views/categoria/ver.php';
		}


		public function verOfertas(){
			//1ºVars Paginación:
			$pagina=1;
			if(isset($_GET['pagina'])){
				$pagina = $_GET['pagina'];
			}
			$cantidadMostrar=6;
		
			//Conseguir categoria:
			$categoria = new stdClass();//create a new
			$categoria->nombre = "Ofertas";

			//Conseguir productos:
			$producto = new Producto();
			

			//2ºnumero de paginas-> como num_rows/$cantidadMostrar
			$numeroDePaginas=ceil($producto->getOfertas()->num_rows/$cantidadMostrar);
			//3ºle mando la pagina en la que estamos y la cantidad a productos que mostrar
			$productos = $producto->getOfertasPaginado($pagina, $cantidadMostrar);
			

			require_once 'views/categoria/ver.php';
		}


		public function crear(){
			Utils::isAdmin();
			
			require_once 'views/categoria/crear.php';
		}
		
		
		public function save(){
			Utils::isAdmin();

			if(isset($_POST) && isset($_POST['nombre'])){
				//Guardar la categoria en bd:
				$categoria = new Categoria();
				$categoria->setNombre($_POST['nombre']);
				
				if($_POST['operacion'] == 'Crear'){
					$save = $categoria->save();

					if($save){
						$_SESSION['register'] = "complete";
						
						header("Location:".base_url.'categoria/index');
					}else{
						$_SESSION['register'] = "failed";
					}
				}else{
					$categoria->setId($_GET['id']);
					$edit = true;
					$editado = $categoria->edit();

					if($editado){
						$_SESSION['register'] = "complete";

						header("Location:".base_url.'categoria/index');
					}else{
						$_SESSION['register'] = "failed";
					}
				}
			}else{
				$_SESSION['register'] = "failed";
			}
		}


		public function editar(){
			Utils::isAdmin();

			if(isset($_GET['id'])){
				$id = $_GET['id'];
				$edit = true;
				
				$categoria = new Categoria();
				$categoria->setId($id);
				
				$cat = $categoria->getOne();
				
				require_once 'views/categoria/crear.php';
				
			}else{
				header('Location:'.base_url.'Categoria/index');
			}
		}


		public function eliminar(){
			Utils::isAdmin();
			
			if(isset($_GET['id'])){
				$id = $_GET['id'];
				$categoria = new Categoria();
				$categoria->setId($id);
				
				//Solo se puede eliminar una categoria si no tiene productos
				$producto = new Producto();
				$producto->setCategoria_id($categoria->getId());
				$numProductosPorCat = $producto->getCountProductosByCategory();
				$resultado = $numProductosPorCat->fetch_object();

				if(($resultado == null) || ($resultado->numProductosPorCat == 0)){
					$delete = $categoria->delete();

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
			
			header('Location:'.base_url.'Categoria/index');
		}
	}
?>