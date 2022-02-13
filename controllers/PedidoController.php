<?php
	require_once 'models/Pedido.php';
	require_once 'models/Usuario.php';

	
	class pedidoController{
		
		//Crear Pedido:
		public function hacer(){
			require_once 'views/pedido/hacer.php';
		}
		

		//Añadir Pedido:
		public function add(){
			if(isset($_SESSION['identity'])){
				$usuario_id = $_SESSION['identity']->id;
				$provincia = isset($_POST['provincia']) ? $_POST['provincia'] : false;
				$localidad = isset($_POST['localidad']) ? $_POST['localidad'] : false;
				$direccion = isset($_POST['direccion']) ? $_POST['direccion'] : false;
				
				$stats = Utils::statsCarrito();
				$coste = $stats['total'];
					
				if($provincia && $localidad && $direccion){
					//Guardar datos en bd:
					$pedido = new Pedido();
					$pedido->setUsuario_id($usuario_id);
					$pedido->setProvincia($provincia);
					$pedido->setLocalidad($localidad);
					$pedido->setDireccion($direccion);
					$pedido->setCoste($coste);
					
					$save = $pedido->save();
					
					//Guardar linea pedido:
					$save_linea = $pedido->save_linea();
					
					if($save && $save_linea){
						$_SESSION['pedido'] = "complete";
					}else{
						$_SESSION['pedido'] = "failed";
					}
					
				}else{
					$_SESSION['pedido'] = "failed";
				}
				
				header("Location:".base_url.'pedido/confirmado');			
			}else{
				//Redigir al index:
				header("Location:".base_url);
			}
		}
		

		//Confirmar Pedido:
		public function confirmado(){
			if(isset($_SESSION['identity'])){
				$identity = $_SESSION['identity'];
				$pedido = new Pedido();
				$pedido->setUsuario_id($identity->id);
				
				$pedido = $pedido->getOneByUser();
				
				$pedido_productos = new Pedido();
				$productos = $pedido_productos->getProductosByPedido($pedido->id);
				//Vaciar Carrito:
				unset($_SESSION['carrito']);
			}
			require_once 'views/pedido/confirmado.php';
		}
		

		//Mostrar Pedidos:
		public function mis_pedidos(){
			Utils::isIdentity();
			$usuario_id = $_SESSION['identity']->id;
			$pedido = new Pedido();
			
			//Sacar los pedidos del usuario:
			$pedido->setUsuario_id($usuario_id);
			$pedidos = $pedido->getAllByUser();
			
			require_once 'views/pedido/mis_pedidos.php';
		}
		

		//Mostrar Info Pedido:
		public function detalle(){
			Utils::isIdentity();
			if(isset($_GET['id'])){
				$id = $_GET['id'];
				
				//Sacar pedido:
				$pedido = new Pedido();
				$pedido->setId($id);
				$pedido = $pedido->getOne();

				//Sacar info del usuario:
				$usuario = new Usuario();
				$usuario->setId($pedido->usuario_id);
				$usuario = $usuario->getOne();
				
				//Sacar poductos:
				$pedido_productos = new Pedido();
				$productos = $pedido_productos->getProductosByPedido($id);
				
				//Si no es el admnin-> usuario solo puede ver sus propios pedidos:
				if(!isset($_SESSION['admin'])){
					if($_SESSION["identity"]->id == $usuario->id){
						require_once 'views/pedido/detalle.php';
					}else{
						header('Location:'.base_url.'pedido/mis_pedidos');
					}
				}else{
					require_once 'views/pedido/detalle.php';
				}
			}else{
				header('Location:'.base_url.'pedido/mis_pedidos');
			}
		}
		
		
		public function gestion(){
			Utils::isAdmin();
			$gestion = true;
			
			$pedido = new Pedido();
			$pedidos = $pedido->getAll();
			
			require_once 'views/pedido/mis_pedidos.php';
		}
		

		//Cambiar Estado Pedido:
		public function estado(){
			Utils::isAdmin();
			if(isset($_POST['pedido_id']) && isset($_POST['estado'])){
				//Recoger datos form:
				$id            = $_POST['pedido_id'];
				$estado        = $_POST['estado'];
				$fecha_entrega = $_POST['fecha_entrega'];
				
				//Upadate del pedido:
				$pedido = new Pedido();
				$pedido->setId($id);
				$pedido->setEstado($estado);
				if($estado == "sended"){
					$pedido->setFecha_entrega($fecha_entrega);
				}

				$pedido->edit();
				
				header("Location:".base_url.'pedido/detalle&id='.$id);
			}else{
				header("Location:".base_url);
			}
		}
		
		
		//Eliminar pedido:
		public function eliminar(){
			if(isset($_GET['id'])){
				$id = $_GET['id'];
				echo($id."<br>");
				
				$pedido = new Pedido();
				$pedido->setId($id);

				//1º eliminar linea_pedido
				$delete01 = $pedido->delete_linea();
				//2º eliminar pedido
				$delete02 = $pedido->delete();
				
				if($delete01 && $delete02){
					$_SESSION['delete'] = 'complete';
				}else{
					$_SESSION['delete'] = 'failed';
				}
			}else{
				$_SESSION['delete'] = 'failed';
			}

			header('Location:'.base_url.'pedido/mis_pedidos');
		}

		
		//Generar Pdf:
		public function generarPDF(){
			Utils::isAdmin();


			$id = $_POST['pedido_id'];
	
			//Sacar pedido:
			$pedido = new Pedido();
			$pedido->setId($id);
			$pedido = $pedido->getOne();

			//Sacar info del usuario:
			$usuario = new Usuario();
			$usuario->setId($pedido->usuario_id);
			$usuario = $usuario->getOne();
			
			//Sacar poductos:
			$pedido_productos = new Pedido();
			$productos = $pedido_productos->getProductosByPedido($id);


			$textoPedido =	"<h1>Pedido número: $pedido->id </h1>
							<h3>Dirección del Cliente:</h3>
							Nombre: $usuario->nombre  $usuario->apellidos <br/>
							Email:  $usuario->email 					  <br/><br/>

							<h3>Dirección de envio:</h3>
							Provincia: $pedido->provincia <br/>
							Cuidad:    $pedido->localidad <br/>
							Direccion: $pedido->direccion <br/><br/>

							<h3>Datos del pedido:</h3>
							Estado: 		  $pedido->fecha         <br/>
							Estado: 		  $pedido->estado 		 <br/>
							Número de pedido: $pedido->id     		 <br/>
							Total a pagar:    $pedido->coste  		 <br/><br/>
							
							<h3>Productos:</h3>
							<table style='border:1px solid black;'>
								<tr>
									<th><b>Nombre:   </b></th>
									<th><b>Precio:	 </b></th>
									<th><b>Unidades: </b></th>
								</tr>";
								
								while ($producto = $productos->fetch_object()){
									$filaPedido = 	"<tr>";
										$filaPedido = $filaPedido. "<td> $producto->nombre </td>";
										$filaPedido = $filaPedido. "<td> $producto->precio </td>";
										$filaPedido = $filaPedido. "<td> $producto->unidades </td>";
									$filaPedido = $filaPedido. "</tr>";
									
									$textoPedido .= $filaPedido;
								}
							$textoPedido .= "</table>";


			//echo $textoPedido;


			//Generar PDF con libreria TCPDF:
			require_once('./vendor/tecnickcom/tcpdf/tcpdf.php');
			ob_clean();
			ob_start();
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf->AddPage();
			$pdf->writeHTMLCell(0, 0, '', '', $textoPedido, 0, 1, 0, true, '', true);
			$pdf->Output('order.pdf', 'I');
			ob_end_flush();
		}
	}
?>