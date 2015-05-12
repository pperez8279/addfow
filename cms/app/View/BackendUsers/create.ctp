<?php $this->Html->addCrumb('Usuarios CMS', array('controller' => 'backend_users', 'action' => 'index')) ?>
<?php $this->Html->addCrumb('Agregar', array('controller' => 'backend_users', 'action' => 'create')) ?>
<div class="box">
	<div class="box-title">
		<h3>
			<i class="fa fa-user"></i>
			Agregar Usuario
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
			<div class="form-group">
				<label for="BackendUserPassword" class="control-label col-sm-2">Contraseña</label>
				<div class="col-sm-10">
					<?php echo $this->Form->input('BackendUser.password', array('div' => false, 'label' => false, 'class' => 'form-control', 'data-rule-required' => true)) ?>
				</div>
			</div>
			<div class="form-group">
				<label for="confirmfield" class="control-label col-sm-2">Confirmar Contraseña</label>
				<div class="col-sm-10">
					<?php echo $this->Form->input('BackendUser.confirm_password', array('type' => 'password', 'div' => false, 'label' => false, 'class' => 'form-control', 'data-rule-required' => true, 'data-rule-equalTo' => '#BackendUserPassword')) ?>
				</div>
			</div>
			<div class="form-actions">
				<?php echo $this->Form->submit('Guardar', array('div' => false, 'class' => 'btn btn-primary')) ?>
				<button type="button" class="btn">Cancel</button>
			</div>
		<?php echo $this->Form->end() ?>
	</div>
</div>