<h1>Gestionar categorias</h1>


<a href="<?=base_url?>categoria/crear" class="button button-small">
	Crear categoria
</a>


<table>
	<tr>
		<th>ID</th>
		<th>NOMBRE</th>
		<th>RECAUDACION TOTAL</th>
		<th>STOCK DISPONIBLE</th>
	</tr>
	<?php while($cat = $categorias->fetch_object()): ?>
		<tr>
			<td><?=$cat->id;?></td>
			<td><?=$cat->nombre;?></td>
			<td>
				<?php
					$producto = new Producto();
                    $producto->setCategoria_id($cat->id);

					$recaudacionTotal = $producto->getRecaudacionTotalByCategory();

                    $recaudacionTotal=$recaudacionTotal->fetch_object();
                    if($recaudacionTotal !=null){
                        echo $recaudacionTotal->recaudacionTotal;
                    }
				?>
			</td>
			<td>
                <?php
					/*$stock = $producto->getSumStockByCategory();
					$stock = $stock->fetch_object();
                    if($stock != null){
                        echo $stock->numProductosPorCat;
                    }*/

					$stockDisponible = $producto->getSumStockDisponibleByCategory();

                    $stockDisponible = $stockDisponible->fetch_object();
                    if($stockDisponible != null){
						
                        echo $stockDisponible->stockDisponible;
                    }else{
						echo "0";
					}
					
                ?>
            </td>


			<td>
				<a href="<?=base_url?>categoria/editar&id=<?=$cat->id?>" class="button button-gestion">Editar</a>
				<a href="<?=base_url?>categoria/eliminar&id=<?=$cat->id?>" class="button button-gestion button-red">Eliminar</a>
			</td>
		</tr>
	<?php endwhile; ?>
</table>
