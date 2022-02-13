<?php

class Producto{
	/********  ATRIBUTOS  ********/
	private $id;
	private $categoria_id;
	private $nombre;
	private $descripcion;
	private $precio;
	private $stock;
	private $oferta;
	private $fecha;
	private $imagen;

	private $db;
	



	/********  FUNCIONES  ********/
	public function __construct() {
		$this->db = Database::connect();
	}
	



	
	function getId() {
		return $this->id;
	}

	function getCategoria_id() {
		return $this->categoria_id;
	}

	function getNombre() {
		return $this->nombre;
	}

	function getDescripcion() {
		return $this->descripcion;
	}

	function getPrecio() {
		return $this->precio;
	}

	function getStock() {
		return $this->stock;
	}

	function getOferta() {
		return $this->oferta;
	}

	function getFecha() {
		return $this->fecha;
	}

	function getImagen() {
		return $this->imagen;
	}

	function setId($id) {
		$this->id = $id;
	}

	function setCategoria_id($categoria_id) {
		$this->categoria_id = $categoria_id;
	}

	function setNombre($nombre) {
		$this->nombre = $this->db->real_escape_string($nombre);
	}

	function setDescripcion($descripcion) {
		$this->descripcion = $this->db->real_escape_string($descripcion);
	}

	function setPrecio($precio) {
		$this->precio = $this->db->real_escape_string($precio);
	}

	function setStock($stock) {
		$this->stock = $this->db->real_escape_string($stock);
	}

	function setOferta($oferta) {
		$this->oferta = $this->db->real_escape_string($oferta);
	}

	function setFecha($fecha) {
		$this->fecha = $fecha;
	}

	function setImagen($imagen) {
		$this->imagen = $imagen;
	}


	//Obtener UN Productos:
	public function getOne(){
		$producto = $this->db->query("SELECT * FROM productos WHERE id = '{$this->getId()}'");

		return $producto->fetch_object();
	}


	//Obtener TODOS los Productos:
	public function getAll(){
		$productos = $this->db->query("SELECT * FROM productos ORDER BY id DESC");

		return $productos;
	}


	//Obtener todos los productos con paginacion
	public function getAllPaginado($pagina, $cantidadMostrar){
		$sql = 	"SELECT * FROM productos ORDER BY id DESC ".
				" LIMIT " . (($pagina-1)*$cantidadMostrar) . " , " . $cantidadMostrar;
		$productos = $this->db->query($sql);

		return $productos;
	}


	//Obtener productos con Oferta con paginacion
	public function getOfertasPaginado($pagina, $cantidadMostrar){
		$sql = 	"SELECT * FROM productos WHERE oferta='si' ORDER BY id DESC ".
				" LIMIT " . (($pagina-1)*$cantidadMostrar) . " , " . $cantidadMostrar;
		$productos = $this->db->query($sql);

		return $productos;
	}


	//Obtener Productos randoms:
	public function getRandom($limit){
		$productos = $this->db->query("SELECT * FROM productos ORDER BY RAND() LIMIT $limit");

		return $productos;
	}
	
	
	//Obtener todos los productos por las categorias
	public function getAllCategory(){
		$sql = "SELECT p.*, c.nombre AS 'catnombre' FROM productos p "
				. "INNER JOIN categorias c ON c.id = p.categoria_id "
				. "WHERE p.categoria_id = '{$this->getCategoria_id()}' "
				. "ORDER BY id DESC ";
		$productos = $this->db->query($sql);

		return $productos;
	}

	//Obtener todos los productos por las categorias con paginacion
	public function getAllCategoryPaginado($pagina, $cantidadMostrar){
		$sql = "SELECT p.*, c.nombre AS 'catnombre' FROM productos p "
				. "INNER JOIN categorias c ON c.id = p.categoria_id "
				. "WHERE p.categoria_id = '{$this->getCategoria_id()}' "
				. "ORDER BY id DESC "
				." LIMIT " . (($pagina-1)*$cantidadMostrar) . " , " . $cantidadMostrar;
		$productos = $this->db->query($sql);

		return $productos;
	}
	
	public function getCountProductosByCategory(){
		$sql = "SELECT COUNT(*) AS 'numProductosPorCat' FROM productos p "
				. "WHERE p.categoria_id = '{$this->getCategoria_id()}' "
				. "ORDER BY id DESC GROUP BY p.categoria_id";
		$productos = $this->db->query($sql);

		return $productos;
	}


	//Obtener el stock disponible en una categoria
	public function getSumStockDisponibleByCategory(){
		$sql = 	"SELECT SUM(p.stock) AS stockDisponible FROM productos p "
				. "WHERE p.categoria_id = '{$this->getCategoria_id()}';";
				//GROUP BY p.categoria_id
		
		$productos = $this->db->query($sql);

		return $productos;
	}


	//Obtener la recaudacion total de una categoria
	public function getRecaudacionTotalByCategory(){
		$sql = 	"SELECT SUM(lp.unidades * p.precio) AS recaudacionTotal FROM lineas_pedidos lp "
				. "JOIN productos p ON p.id = lp.producto_id "
				. "WHERE p.categoria_id = '{$this->getCategoria_id()}';";
		$productos = $this->db->query($sql);

		return $productos;
	}


	//Obtener todo el stock vendido de una categoria
	public function getSumStockByCategory(){
		$sql = 	"SELECT SUM(lp.unidades) AS 'stockVendido' FROM lineas_pedidos lp "
				. "WHERE lp.producto_id = '{$this->getId()}' GROUP BY lp.producto_id;";
				
		$productos = $this->db->query($sql);

		return $productos;
	}


	//Obtener Producto mas vendido(TOP VENTAS):
	public function getTop(){
		$sql = 	"SELECT SUM(lp.unidades) as uni, p.* FROM lineas_pedidos lp"
				. " JOIN productos p ON p.id = lp.producto_id"
				. " GROUP BY lp.producto_id ORDER BY uni desc limit 1;";
		$productos = $this->db->query($sql);

		return $productos;
	}


	//Obtener Productos sin ventas:
	public function getSinVentas(){
		$sql = 	"SELECT p.* FROM productos p"
				. " WHERE NOT EXISTS(SELECT * FROM lineas_pedidos lp WHERE lp.producto_id=p.id); ";
		$productos = $this->db->query($sql);

		return $productos;
	}


	//Obtener Productos sin Stock:
	public function getSinStock(){
		$sql = 	"SELECT p.* FROM productos p"
				. " WHERE p.stock IS NULL OR p.stock=0; ";
		$productos = $this->db->query($sql);

		return $productos;
	}


	//Obtener Productos con ofertas:
	public function getOfertas(){
		$sql = 	"SELECT p.* FROM productos p"
				. " WHERE p.oferta like 'si' ORDER BY p.id desc;";
		$productos = $this->db->query($sql);

		return $productos;
	}


	//Guardar Producto:
	public function save(){
		$sql = "INSERT INTO productos VALUES(NULL, {$this->getCategoria_id()}, '{$this->getNombre()}', '{$this->getDescripcion()}', {$this->getPrecio()}, {$this->getStock()}, '{$this->getOferta()}', CURDATE(), '{$this->getImagen()}');";
		echo($sql);
		$save = $this->db->query($sql);
		
		$result = false;
		if($save){
			$result = true;
		}

		return $result;
	}
	

	//Modificar Producto:
	public function edit(){
		$sql = "UPDATE productos SET nombre='{$this->getNombre()}', descripcion='{$this->getDescripcion()}', precio={$this->getPrecio()}, oferta='{$this->getOferta()}', stock={$this->getStock()}, categoria_id={$this->getCategoria_id()}  ";
		//echo($sql);
		if($this->getImagen() != null){
			$sql .= ", imagen='{$this->getImagen()}'";
		}
		
		$sql .= " WHERE id='{$this->id}';";
		
		
		$save = $this->db->query($sql);
		
		$result = false;
		if($save){
			$result = true;
		}

		return $result;
	}
	

	//Borrar Producto:
	public function delete(){
		$sql = "DELETE FROM productos WHERE id='{$this->id}'";
		$delete = $this->db->query($sql);
		
		$result = false;
		if($delete){
			$result = true;
		}

		return $result;
	}
	public function esValido(){
		$sql = 	"SELECT COUNT(*) num FROM productos p WHERE p.stock>='{$this->stock}' AND p.id='{$this->id}'";
		$productos = $this->db->query($sql);
		if($productos->fetch_object()->num==0){
			return false;
		}
		return true;
	}
}