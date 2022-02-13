<!DOCTYPE HTML>
<html lang="es">
	<head>
		<meta charset="utf-8" />
		<title>Tienda de Camisetas</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	</head>
	<body>
		<div id="container" class="container-fluid">
			<!-- CABECERA -->
			<header id="header" class="mt-2" >

			<a href="<?=base_url?>" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
				<img class="bi me-4  col-1" src="<?=base_url?>assets/img/camiseta.png" alt="Camiseta Logo" />
				<span class="fs-4">Tienda de camisetas</span>
			</a>
		
			</header>

			<!-- MENU -->
			<?php $categorias = Utils::showCategorias(); ?>

			<nav id="menu" class="navbar navbar-expand-lg navbar-light bg-light">
				<div class="container-fluid">
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav me-auto mb-2 mb-lg-0">
						<!--Inicio-->
						<li class="nav-item">
							<a class="nav-link" href="<?=base_url?>">Inicio</a>
						</li>

						<!--Categorias-->
						<?php while($cat = $categorias->fetch_object()): ?>
							<li class="nav-item">
								<a class="nav-link" href="<?=base_url?>categoria/ver&id=<?=$cat->id?>"><?=$cat->nombre?></a>
							</li>
						<?php endwhile; ?>
						
						<!--Todos los productos-->
						<li class="nav-item">
							<a class="nav-link" href="<?=base_url?>categoria/verTodos">Todos los Productos</a>
						</li>

						<!--Productos con descuento-->
						<li class="nav-item">
							<a class="nav-link" href="<?=base_url?>categoria/verOfertas">Ofertas</a>
						</li>
					</ul>
				</div>
				</div>
			</nav>

			<div id="content" class="container-fluid row">