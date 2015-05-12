<?php $this->Html->addCrumb('Usuarios CMS', array('controller' => 'backend_users', 'action' => 'index')) ?>
<div class="box box-color box-bordered">
	<div class="box-title">
		<h3>
			<i class="fa fa-user"></i>
			Usuarios CMS
		</h3>
	</div>
	<div class="box-content nopadding">
		<table class="table table-hover table-nomargin">
			<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('id', 'ID') ?></th>
					<th><?php echo $this->Paginator->sort('first_name', 'Nombre') ?></th>
					<th><?php echo $this->Paginator->sort('last_name', 'Apellido') ?></th>
					<th><?php echo $this->Paginator->sort('email', 'Email') ?></th>
					<th><?php echo $this->Paginator->sort('profile', 'Perfil') ?></th>
					<th>Acciónes</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($rows as $k => $v) { ?>
					<tr>
						<td><?php echo $v['BackendUser']['id'] ?></td>
						<td><?php echo $v['BackendUser']['first_name'] ?></td>
						<td><?php echo $v['BackendUser']['last_name'] ?></td>
						<td><?php echo $v['BackendUser']['email'] ?></td>
						<td><?php echo $v['BackendUser']['email'] ?></td>
						<td>
							<a href="<?php echo h(Router::url('/backend_users/update/'.$v['BackendUser']['id'], true)) ?>" class="btn" rel="tooltip" title="" data-original-title="Editar"><i class="fa fa-edit"></i></a>
							<a href="<?php echo h(Router::url('/backend_users/delete/'.$v['BackendUser']['id'], true)) ?>" class="btn delete" rel="tooltip" title="" data-original-title="Eliminar"><i class="fa fa-times"></i></a>
							<a href="<?php echo h(Router::url('/backend_users/password/'.$v['BackendUser']['id'], true)) ?>" class="btn" rel="tooltip" title="" data-original-title="Cambiar Contraseña"><i class="fa fa-key"></i></a>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<div class="paginator-counter pull-left">
			<?php echo $this->Paginator->counter('Página {:page} de {:pages}, mostrando {:current} registros de {:count} total, comienza en registro {:start}, finaliza en {:end}') ?>
		</div>
		<div class="table-pagination">
			<?php echo $this->Paginator->first('Primera', array('tag' => false)) ?>
			<?php echo $this->Paginator->prev('Anterior', array('tag' => false), null, array('tag' => 'a', 'class' => 'disabled')) ?> 
			<?php echo $this->Paginator->numbers(array('before' => '<span>', 'after' => '</span>', 'tag' => 'a', 'currentClass' => 'active', 'separator' => false)) ?>
			<?php echo $this->Paginator->next('Siguiente', array('tag' => false), null, array('tag' => 'a', 'class' => 'disabled')) ?>
			<?php echo $this->Paginator->last('Ultima', array('tag' => false)) ?>
		</div>
	</div>
</div>