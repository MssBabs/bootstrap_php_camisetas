<?php if(isset($edit) && isset($usu) && is_object($usu)): ?>
	<h1>Editar Usuario <?=$usu->nombre?></h1>
	<?php $url_action = base_url."usuario/save&id=".$usu->id; ?>	
<?php else: ?>
	<h1>Registrarse</h1>
	<?php $url_action = base_url."usuario/save"; ?>
<?php endif; ?>


<?php if(isset($_SESSION['register']) && $_SESSION['register'] == 'complete'): ?>
	<strong class="alert_green"><?php if(isset($edit)){echo "Actualizacion"; }else {echo "Registro";} ?> completado correctamente</strong><br><br>
<?php elseif(isset($_SESSION['register']) && $_SESSION['register'] == 'failed'): ?>
	<strong class="alert_red"><?php if(isset($edit)){echo "Actualizacion"; }else {echo "Registro";} ?> fallido, introduce bien los datos</strong><br><br>
<?php endif; ?>

<?php Utils::deleteSession('register'); ?>


<form action="<?=$url_action?>" method="POST">
	<label for="nombre">Nombre</label>
	<input type="text" name="nombre" value="<?=isset($usu) && is_object($usu) ? $usu->nombre : ''; ?>" required/>
	
	<label for="apellidos">Apellidos</label>
	<input type="text" name="apellidos" value="<?=isset($usu) && is_object($usu) ? $usu->apellidos : ''; ?>" required/>
	
	<label for="email">Email</label>
	<input type="email" name="email" value="<?=isset($usu) && is_object($usu) ? $usu->email : ''; ?>" required/>
	
	<label for="password">Contraseña</label>
	<input type="password" name="password" value="<?=isset($usu) && is_object($usu) ? $usu->password : ''; ?>" required/>
	
	<?php if(isset($edit)): ?>
		<input type="submit" name="operacion" value="Guardar" />	
	<?php else: ?>
		<input type="submit" name="operacion" value="Registrarse" />
	<?php endif; ?>
</form>