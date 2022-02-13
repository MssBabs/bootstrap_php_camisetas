<h1>Gestión de productos</h1>


<P style="display:flex">
	<a href="<?=base_url?>producto/crear" class="button button-small">
		Crear producto
	</a>
	<a href="<?=base_url?>producto/top" class="button button-small">
		Producto más vendido
	</a>
	<a href="<?=base_url?>producto/sinVentas" class="button button-small">
		Productos sin ventas
	</a>
	<a href="<?=base_url?>producto/sinStock" class="button button-small">
		Productos sin stock
	</a>
	<a href="<?=base_url?>producto/conOferta" class="button button-small">
		Productos con Ofertas
	</a>
</P>


<!-- mns -->
<?php if(isset($_SESSION['producto']) && $_SESSION['producto'] == 'complete'): ?>
	<strong class="alert_green">El producto se ha guardado correctamente</strong><br><br>
<?php elseif(isset($_SESSION['producto']) && $_SESSION['producto'] != 'complete'): ?>	
	<strong class="alert_red">El producto NO se ha guardado correctamente</strong><br><br>
<?php endif; ?>
<?php Utils::deleteSession('producto'); ?>
	
<?php if(isset($_SESSION['delete']) && $_SESSION['delete'] == 'complete'): ?>
	<strong class="alert_green">El producto se ha borrado correctamente</strong><br><br>
<?php elseif(isset($_SESSION['delete']) && $_SESSION['delete'] != 'complete'): ?>	
	<strong class="alert_red">El producto NO se ha borrado correctamente</strong><br><br>
<?php endif; ?>
<?php Utils::deleteSession('delete'); ?>

<!--el total de ventas realizadas, producto más vendido, productos sin ventas, productos sin existencias.-->
<table>
	<tr>
		<th>ID</th>
		<th>NOMBRE</th>
		<th>PRECIO</th>
		<th>STOCK DISPONIBLE</th>
		<th>TOTAL DE STOCK VENDIDO</th>
		<th>ACCIONES</th>
	</tr>
	<?php while($pro = $productos->fetch_object()): ?>
		<tr>
			<td><?=$pro->id;?></td>
			<td><?=$pro->nombre;?></td>
			<td><?=$pro->precio;?></td>
			<td><?=$pro->stock;?></td>
			<td>
				<?php 
					$producto = new Producto();
                    $producto->setId($pro->id);

					$stockVendido = $producto->getSumStockByCategory();

                    $stockVendido = $stockVendido->fetch_object();
                    if($stockVendido !=null){
                        echo $stockVendido->stockVendido;
                    }
				?>
			</td>
			<td>
				<a href="<?=base_url?>producto/editar&id=<?=$pro->id?>" class="button button-gestion">Editar</a>
				<a href="<?=base_url?>producto/eliminar&id=<?=$pro->id?>" class="button button-gestion button-red">Eliminar</a>
			</td>
		</tr>
	<?php endwhile; ?>
</table>
