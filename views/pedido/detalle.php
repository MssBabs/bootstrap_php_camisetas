<h1>Detalle del pedido</h1>

<?php if (isset($pedido)): ?>
	<?php if(isset($_SESSION['admin'])): ?>
		<h3>Cambiar estado del pedido</h3>

		<form action="<?=base_url?>pedido/estado" method="POST">

			<input type="hidden" value="<?=$pedido->id?>" name="pedido_id"/>

			<select name="estado" onchange="definirFechaEntrega()">
				<option value="confirm"     <?=$pedido->estado == "confirm" ? 'selected' : '';?>     >Pendiente             </option>
				<option value="preparation" <?=$pedido->estado == "preparation" ? 'selected' : '';?> >En preparación        </option>
				<option value="ready"       <?=$pedido->estado == "ready" ? 'selected' : '';?>       >Preparado para enviar </option>
				<option value="sended"      <?=$pedido->estado == "sended" ? 'selected' : '';?>      >Enviado               </option>
			</select>

			<!-- FECHA ENTREGA: -->
			<input type="date" name="fecha_entrega" style="display:none"/>
			<script>
				function definirFechaEntrega(){
					var estado = document.getElementsByName("estado")[0].value;

					if (estado == "sended"){
						document.getElementsByName("fecha_entrega")[0].style="display:block";
					}else{
						document.getElementsByName("fecha_entrega")[0].style="display:none";
					}
				}
			</script>


			<input type="submit" value="Cambiar estado"/>
		</form>
		<br/>
	<?php endif; ?>

	<h3>Dirección del Cliente:</h3>
	Nombre: <?= $usuario->nombre. " ". $usuario->apellidos ?> <br/>
	Email:  <?= $usuario->email ?> 							  <br/><br/>

	<h3>Dirección de envio:</h3>
	Provincia: <?= $pedido->provincia ?> <br/>
	Cuidad:    <?= $pedido->localidad ?> <br/>
	Direccion: <?= $pedido->direccion ?> <br/><br/>

	<h3>Datos del pedido:</h3>
	Fecha del pedido: <?= $pedido->fecha ?>   				  <br/>
	Estado: 		  <?=Utils::showStatus($pedido->estado)?> <br/>
	Número de pedido: <?= $pedido->id ?>   					  <br/>
	<?php if($pedido->estado == 'sended'): ?>
	Fecha de entrega: <?= $pedido->fecha_entrega ?> 		  <br/>
	<?php endif; ?>
	Total a pagar:    <?= $pedido->coste ?> $ 				  <br/><br/><br/>
	
	<h3>Productos:</h3><br/>
	<table>
		<tr>
			<th>Imagen</th>
			<th>Nombre</th>
			<th>Precio</th>
			<th>Unidades</th>
		</tr>
		
		<?php while ($producto = $productos->fetch_object()): ?>
			<tr>
				<td>
					<?php if ($producto->imagen != null): ?>
						<img src="<?= base_url ?>uploads/images/<?= $producto->imagen ?>" class="img_carrito" />
					<?php else: ?>
						<img src="<?= base_url ?>assets/img/camiseta.png" class="img_carrito" />
					<?php endif; ?>
				</td>
				
				<td>
					<a href="<?= base_url ?>producto/ver&id=<?= $producto->id ?>"><?= $producto->nombre ?></a>
				</td>
				
				<td>
					<?= $producto->precio ?>
				</td>
				
				<td>
					<?= $producto->unidades ?>
				</td>
			</tr>
		<?php endwhile; ?>
	</table>


	<?php if($pedido->estado != 'sended'): ?>
		<a href="<?=base_url?>pedido/eliminar&id=<?=$pedido->id?>" class="button button-gestion button-red">Eliminar pedido</a>
	<?php endif; ?>




	<?php if(isset($_SESSION['admin'])): ?>
		<form action="<?=base_url?>pedido/generarPDF" method="POST">
			<input type="hidden" value="<?=$pedido->id?>" name="pedido_id"/>
			<input type="submit" value="Imprimir en PDF" />
		</form>
	<?php endif; ?>
<?php endif; ?>