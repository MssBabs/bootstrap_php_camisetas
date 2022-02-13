<?php if(isset($edit) && isset($cat) && is_object($cat)): ?>
	<h1>Editar categoria <?=$cat->nombre?></h1>
	<?php $url_action = base_url."categoria/save&id=".$cat->id; ?>
<?php else: ?>
	<h1>Crear nueva categoria</h1>
	<?php $url_action = base_url."categoria/save"; ?>
<?php endif; ?>

<form action="<?=$url_action?>" method="POST">
	<label for="nombre">Nombre</label>
	<input type="text" name="nombre" value="<?=isset($cat) && is_object($cat) ? $cat->nombre : ''; ?>" required/>
	
	<?php if(isset($edit)): ?>
		<input type="submit" name="operacion" value="Guardar" />	
	<?php else: ?>
		<input type="submit" name="operacion" value="Crear" />
	<?php endif; ?>
</form>