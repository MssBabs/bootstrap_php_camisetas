<!-- BARRA LATERAL -->
<div class="col-2">
<aside id="lateral" >

		<div id="carrito" class="block_aside">
			<span class="fs-4">Mi carrito</span>
			<ul class="nav nav-pills flex-column mb-auto">
				<?php $stats = Utils::statsCarrito(); ?>
				<li><a class="nav-link" href="<?=base_url?>carrito/index">Productos (<?=$stats['count']?>)</a></li>
				<li><a class="nav-link" href="<?=base_url?>carrito/index">Total: <?=$stats['total']?> $</a></li>
				<li><a class="nav-link" href="<?=base_url?>carrito/index">Ver el carrito</a></li>
			</ul>
		</div>
		
		<div id="login" class="block_aside">
		<ul class="nav nav-pills flex-column mb-auto">
			<?php if(!isset($_SESSION['identity'])): ?>
				<li>
					<span class="fs-4">Entrar a la web</span>
					
					<form action="<?=base_url?>usuario/login" method="post">
						<div class="mb-3">
							<label for="email"  class="form-label">Email</label>
							<input type="email" class="form-control" name="email" />
						
						
							<label for="password" class="form-label">Contraseña</label>
							<input type="password" class="form-control" name="password" />
						</div>
						<div class="mb-3">
							<input type="submit" value="Enviar" />
						</div>
					</form>
				</li>
			<?php else: ?>
				<h3><?=$_SESSION['identity']->nombre?> <?=$_SESSION['identity']->apellidos?></h3>
			<?php endif; ?>

			
				<?php if(isset($_SESSION['admin'])): ?>
					<li><a class="nav-link" href="<?=base_url?>categoria/index">Gestionar categorias</a></li>
					<li><a class="nav-link" href="<?=base_url?>producto/gestion">Gestionar productos</a></li>
					<li><a class="nav-link" href="<?=base_url?>pedido/gestion">Gestionar pedidos</a></li>
					<li><a class="nav-link" href="<?=base_url?>usuario/gestion">Gestionar usuarios</a></li>
				<?php endif; ?>
				
				<?php if(isset($_SESSION['identity'])): ?>
					<li><a class="nav-link" href="<?=base_url?>pedido/mis_pedidos">Mis pedidos</a></li>
					<li><a class="nav-link" href="<?=base_url?>usuario/editar?id=<?= $_SESSION['identity']->id ?>">Configuración</a></li>
					<li><a class="nav-link" href="<?=base_url?>usuario/logout">Cerrar sesión</a></li>
				<?php else: ?> 
					<li><a class="nav-link" href="<?=base_url?>usuario/registro">Registrate aqui</a></li>
				<?php endif; ?> 
			</ul>
		</div>
	
</aside>
</div>
<!-- CONTENIDO CENTRAL -->
<div id="central" class="col-10">
	<div class="row  justify-content-center">