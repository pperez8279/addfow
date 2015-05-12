<?php $this->Html->addCrumb('Usuarios', array('controller' => 'users', 'action' => 'index')) ?>
<br>
<br>
<div class="box-content">
	<?php echo $this->Form->create('User', array('class' => 'form-horizontal form-validate', 'action'=>'index', 'novalidate' => true)) ?>
	<div class="form-group">
		<label for="UserFirstName" class="control-label col-sm-2">Nombre</label>
		<div class="col-sm-10">
			<?php echo $this->Form->input('Search.User.first_name', array('div' => false, 'label' => false, 'class' => 'form-control', 'data-rule-required' => true)) ?>
		</div>
	</div>
	<div class="form-group">
		<label for="UserUserType" class="control-label col-sm-2">Tipo</label>
		<div class="col-sm-10">
			<?php echo $this->Form->input('Search.User.user_type_id', array('div' => false, 'label' => false, 'class' => 'form-control', 'data-rule-required' => false, 'options' => $UserTypes)) ?>
		</div>
	</div>
	<div class="form-actions">
		<?php echo $this->Form->submit('Buscar', array('div' => false, 'class' => 'btn btn-primary')) ?>
		<a href="<?php echo h(Router::url('/users/create', true)) ?>" data-original-title="Nueva Usuario" class="btn btn-primary pull-right">Nueva Usuario</a>
	</div>
	<?php echo $this->Form->end() ?>
</div>
<div class="box box-color box-bordered">
	<div class="box-title">
		<h3>
			<i class="fa fa-user"></i>
			Usuarios
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
					<th><?php echo $this->Paginator->sort('UserType.name', 'Tipo') ?></th>
					<th>Acciónes</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($rows as $k => $v) { ?>
					<tr>
						<td><?php echo $v['User']['id'] ?></td>
						<td><?php echo $v['User']['first_name'] ?></td>
						<td><?php echo $v['User']['last_name'] ?></td>
						<td><?php echo $v['User']['email'] ?></td>
						<td><?php echo $v['UserType']['name'] ?></td>
						<td>
							<a href="<?php echo h(Router::url('/users/update/'.$v['User']['id'], true)) ?>" class="btn" rel="tooltip" title="" data-original-title="Editar"><i class="fa fa-edit"></i></a>
							<a href="<?php echo h(Router::url('/users/delete/'.$v['User']['id'], true)) ?>" class="btn delete" rel="tooltip" title="" data-original-title="Eliminar"><i class="fa fa-times"></i></a>
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