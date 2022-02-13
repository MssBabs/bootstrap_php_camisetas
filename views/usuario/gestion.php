<h1>Gestión de Usuarios</h1>


<?php if(isset($_SESSION['delete']) && $_SESSION['delete'] == 'complete'): ?>
	<strong class="alert_green">El usuario se ha borrado correctamente</strong><br/>
<?php elseif(isset($_SESSION['delete']) && $_SESSION['delete'] != 'complete'): ?>	
	<strong class="alert_red">El usuario NO se ha borrado correctamente</strong><br/>
<?php endif; ?>
<?php Utils::deleteSession('delete'); ?>


<table>
	<tr>
		<th>ID</th>
		<th>EMAIL</th>
		<th>IMPORTE TOTAL</th>
		<th>PEDIDOS PENDIENTES</th>
		<th>ACCIONES</th>
	</tr>
	<?php while($usu = $usuarios->fetch_object()): ?>
		<tr>
			<td><?=$usu->id;?></td>
			<td><?=$usu->email;?></td>
			<td>
                <?php
                    $pedido = new Pedido();
                    $pedido->setUsuario_id($usu->id);

                    $importeTotal = $pedido->getImporteTotalPedidosByUsuario();

                    /*La consulta en bruto pasa a ser un objeto de php:
                        1º $importeTotal->fetch_object()                    -> Transformamos consulta a objeto
                        2º fetch_object()->coste // $importeTotal->coste    -> Accedemos al atributo declarado en la sentencia
                    */ 
                    $importeTotal=$importeTotal->fetch_object();
                    if($importeTotal !=null){
                        echo $importeTotal->coste;
                    }
                ?>
            </td>
			<td>
                <?php
                    $pedidosPendientes = $pedido->getPedidosPendientesByUsuario();
                    
                    $pedidosPendientes=$pedidosPendientes->fetch_object();
                    if($pedidosPendientes !=null){
                        echo $pedidosPendientes->pedidosPendientes;
                    }
                ?>
            </td>
			<td>
				<a href="<?=base_url?>usuario/editar&id=<?=$usu->id?>" class="button button-gestion">Editar</a>
				<a href="<?=base_url?>usuario/eliminar&id=<?=$usu->id?>" class="button button-gestion button-red">Eliminar</a>
			</td>
		</tr>
	<?php endwhile; ?>
</table>