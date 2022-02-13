<?php
	class Pedido{
		/********  ATRIBUTOS  ********/
		private $id;
		private $usuario_id;
		private $provincia;
		private $localidad;
		private $direccion;
		private $coste;
		private $estado;
		private $fecha;
		private $fecha_entrega;
		private $hora;

		private $db;
		


		
		/********  FUNCIONES  ********/
		public function __construct() {
			$this->db = Database::connect();
		}
		



		function getId() {
			return $this->id;
		}

		function getUsuario_id() {
			return $this->usuario_id;
		}

		function getProvincia() {
			return $this->provincia;
		}

		function getLocalidad() {
			return $this->localidad;
		}

		function getDireccion() {
			return $this->direccion;
		}

		function getCoste() {
			return $this->coste;
		}

		function getEstado() {
			return $this->estado;
		}

		function getFecha() {
			return $this->fecha;
		}

		function getFecha_entrega() {
			return $this->fecha_entrega;
		}

		function getHora() {
			return $this->hora;
		}

		function setId($id) {
			$this->id = $id;
		}

		function setUsuario_id($usuario_id) {
			$this->usuario_id = $usuario_id;
		}

		function setProvincia($provincia) {
			$this->provincia = $this->db->real_escape_string($provincia);
		}

		function setLocalidad($localidad) {
			$this->localidad = $this->db->real_escape_string($localidad);
		}

		function setDireccion($direccion) {
			$this->direccion = $this->db->real_escape_string($direccion);
		}

		function setCoste($coste) {
			$this->coste = $coste;
		}

		function setEstado($estado) {
			$this->estado = $estado;
		}

		function setFecha($fecha) {
			$this->fecha = $fecha;
		}

		function setFecha_entrega($fecha_entrega) {
			$this->fecha_entrega = $fecha_entrega;
		}

		function setHora($hora) {
			$this->hora = $hora;
		}


		//Obtener TODOS Los Productos:
		public function getAll(){
			$productos = $this->db->query("SELECT * FROM pedidos ORDER BY id DESC");

			return $productos;
		}
		

		//Obtener UN Producto:
		public function getOne(){
			$producto = $this->db->query("SELECT * FROM pedidos WHERE id = {$this->getId()}");

			return $producto->fetch_object();
		}
		

		//Obtener Un Pedido de un Usuario:
		public function getOneByUser(){
			$sql = "SELECT p.id, p.coste FROM pedidos p "
					//. "INNER JOIN lineas_pedidos lp ON lp.pedido_id = p.id "
					. "WHERE p.usuario_id = {$this->getUsuario_id()} ORDER BY id DESC LIMIT 1";
				
			$pedido = $this->db->query($sql);
				
			return $pedido->fetch_object();
		}
		

		//Obtener TODOS Los Pedidos de un Usuario:
		public function getAllByUser(){
			$sql = "SELECT p.* FROM pedidos p "
					. "WHERE p.usuario_id = {$this->getUsuario_id()} ORDER BY id DESC";
				
			$pedido = $this->db->query($sql);
				
			return $pedido;
		}
		
		
		//Obtener todos los productos de un Pedido:
		public function getProductosByPedido($id){
			/*$sql = "SELECT * FROM productos WHERE id IN "
			 		 . "(SELECT producto_id FROM lineas_pedidos WHERE pedido_id={$id})";
			*/
		
			$sql = "SELECT pr.*, lp.unidades FROM productos pr "
					. "INNER JOIN lineas_pedidos lp ON pr.id = lp.producto_id "
					. "WHERE lp.pedido_id={$id}";
					
			$productos = $this->db->query($sql);
				
			return $productos;
		}
		

		//Guardar pedido:
		public function save(){
			$sql = "INSERT INTO pedidos VALUES(NULL, {$this->getUsuario_id()}, '{$this->getProvincia()}', '{$this->getLocalidad()}', '{$this->getDireccion()}', {$this->getCoste()}, 'confirm', CURDATE(), CURTIME());";
			$save = $this->db->query($sql);
			
			$result = false;
			if($save){
				$result = true;
			}
			
			return $result;
		}
		

		//Guardar linea_peidos
		public function save_linea(){
			$sql = "SELECT LAST_INSERT_ID() as 'pedido';";
			$query = $this->db->query($sql);
			$pedido_id = $query->fetch_object()->pedido;
			
			foreach($_SESSION['carrito'] as $elemento){
				$producto = $elemento['producto'];
				
				$insert = "INSERT INTO lineas_pedidos VALUES(NULL, {$pedido_id}, {$producto->id}, {$elemento['unidades']})";
				$save = $this->db->query($insert);
				
				$insert = "UPDATE productos SET stock=stock-{$elemento['unidades']} WHERE  id={$producto->id}";
				$save = $this->db->query($insert);
				
			}
			
			$result = false;
			if($save){
				$result = true;
			}

			return $result;
		}
		

		//Editar estado pedido:
		public function edit(){
			if($this->getEstado() == "sended"){
				$sql = "UPDATE pedidos SET estado='{$this->getEstado()}', fecha_entrega='{$this->getFecha_entrega()}' ";
				$sql .= " WHERE id={$this->getId()};";
			}else{
				$sql = "UPDATE pedidos SET estado='{$this->getEstado()}' ";
				$sql .= " WHERE id={$this->getId()};";
			}
			
		
			$save = $this->db->query($sql);
			
			$result = false;
			if($save){
				$result = true;
			}

			return $result;
		}

		
		//Obtener importe total de los pedidos de un Usuario:
		public function getImporteTotalPedidosByUsuario(){
			$sql =  "SELECT SUM(p.coste) AS coste FROM pedidos p ". 
					"WHERE p.usuario_id = '{$this->getUsuario_id()}' GROUP BY p.usuario_id";
				
			$importeTotal = $this->db->query($sql);
			
			return $importeTotal;
		}
		

		//Obtener pedidos pendientes de un Usuario:
		public function getPedidosPendientesByUsuario(){
			//Utils.php		->if($status == 'confirm'){$value = 'Pendiente';}
			$sql =  "SELECT COUNT(*) AS pedidosPendientes FROM pedidos p ". 
					"WHERE p.usuario_id = '{$this->getUsuario_id()}' AND p.estado like 'confirm' GROUP BY p.usuario_id";
				
			$pedidosPendientes = $this->db->query($sql);
			
			return $pedidosPendientes;
		}


		//Borrar pedido:
		public function delete(){
			$sql = "DELETE FROM pedidos WHERE id={$this->id}";
			$delete = $this->db->query($sql);
			
			$result = false;
			if($delete){
				$result = true;
			}

			return $result;
		}


		//Borrar linea_peidos
		public function delete_linea(){
			$sql = "DELETE FROM lineas_pedidos WHERE pedido_id={$this->id}";
			$delete = $this->db->query($sql);
			
			$result = false;
			if($delete){
				$result = true;
			}

			return $result;
		}
	}
?>