<span class="fs-1">Algunos de nuestros productos</span>

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