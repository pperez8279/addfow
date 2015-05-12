<?php $this->Html->addCrumb('Usuarios CMS', array('controller' => 'backend_users', 'action' => 'index')) ?>
<?php $this->Html->addCrumb('Editar', array('controller' => 'backend_users', 'action' => 'update')) ?>
<div class="box">
	<div class="box-title">
		<h3>
			<i class="fa fa-user"></i>
			Editar Usuario
		</h3>
	</div>
	<div class="box-content">
		<?php echo $this->Form->create('BackendUser', array('class' => 'form-horizontal form-validate')) ?>
			<div class="form-group">
				<label for="BackendUserFirstName" class="control-label col-sm-2">Nombre</label>
				<div class="col-sm-10">
					<?php echo $this->Form->input('BackendUser.first_name', array('div' => false, 'label' => false, 'class' => 'form-control', 'data-rule-required' => true)) ?>
				</div>
			</div>
			<div class="form-group">
				<label for="BackendUserLastName" class="control-label col-sm-2">Apellido</label>
				<div class="col-sm-10">
					<?php echo $this->Form->input('BackendUser.last_name', array('div' => false, 'label' => false, 'class' => 'form-control', 'data-rule-required' => true)) ?>
				</div>
			</div>
			<div class="form-group">
				<label for="emailfield" class="control-label col-sm-2">Email</label>
				<div class="col-sm-10">
					<?php echo $this->Form->input('BackendUser.email', array('div' => false, 'label' => false, 'class' => 'form-control', 'data-rule-required' => true,'data-rule-email' => true)) ?>
				</div>
			</div>
			<div class="form-actions">
				<?php echo $this->Form->submit('Guardar', array('div' => false, 'class' => 'btn btn-primary')) ?>
				<a href="<?php echo h(Router::url('/backend_users/password/'.$this->request->data['BackendUser']['id'], true)) ?>" class="btn">Cambiar Contraseña</a>
				<a href="<?php echo $this->request->referer() ?>" class="btn">Cancelar</a>
			</div>
		<?php echo $this->Form->end() ?>
	</div>
</div>