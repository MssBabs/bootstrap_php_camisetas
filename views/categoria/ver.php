<?php if (isset($categoria)): ?>
	<h1><?= $categoria->nombre ?></h1>

	<?php if ($productos->num_rows == 0): ?>
		<p>No hay productos para mostrar</p>
	<?php else: ?>
		<div class="row">
		<?php while ($product = $productos->fetch_object()) : ?>

			<div class="product card justify-content-center col-3 m-4" >
				<a class="h-75" href="<?= base_url ?>producto/ver&id=<?= $product->id ?>">
					<?php if ($product->imagen != null) : ?>
						<img class="card-img-top h-75" src="<?= base_url ?>uploads/images/<?= $product->imagen ?>" />
					<?php else : ?>
						<img class="card-img-top h-75" src="<?= base_url ?>assets/img/camiseta.png" />
					<?php endif; ?>
					<div class="card-body">
						<h5 class="card-title"><?= $product->nombre ?></h5>
				</a>

				<p><?= $product->precio ?></p>

				<?php if ($product->stock > 0) : ?>
					<a href="<?= base_url ?>carrito/add&id=<?= $product->id ?>" class="btn btn-primary">Comprar</a>
				<?php else : ?>
					<!-- href="#" == Dirección no existente -->
					<a href="#" class="btn btn-warning">No disponible</a>
				<?php endif; ?>

				<?php if($product->oferta == 'si'): ?>
					<input type="button" class="btn btn-info" value="EN OFERTA!!">
				<?php endif; ?>
			</div>
			</div>
		<?php endwhile; ?>
</div>
	<?php endif; ?>
	
	<!--Paginacion-->
	<div id="navegador" class="m-3" >
		<nav>
		<ul class="pagination">
			<?php for($i =1 ; $i<=$numeroDePaginas ; $i++): ?>
				
					<?php if(isset($id)): ?>
						<?php if ($i!= $pagina):?>
							<li class="page-item">
							<a class="page-link"  href="<?=base_url?>categoria/ver&id=<?= $id ?>&pagina=<?= $i ?>">
								<?= $i ?>
							</a>
						<?php else:?>
							<li class="page-item active">
							<a class="page-link "><?=$i?></a>
						<?php endif; ?>
					<?php else: ?>
						<?php if ($i!= $pagina):?>
							<li class="page-item">
							<a class="page-link" href="<?=base_url?>categoria/verTodos&pagina=<?= $i ?>">
								<?= $i ?></button>
							</a>
						<?php else:?>
							<li class="page-item active">
							<a class="page-link"><?=$i?></a>
							
						<?php endif; ?>
					<?php endif; ?>
				</li>
			<?php endfor;?>
		</ul>
		</nav>
	</div>
<?php else: ?>
	<h1>La categoría no existe</h1>
<?php endif; ?>