<?php $this->Html->addCrumb('Usuarios CMS', array('controller' => 'backend_users', 'action' => 'index')) ?>
<?php $this->Html->addCrumb('Cambiar Contraseña', array('controller' => 'backend_users', 'action' => 'password')) ?>
<div class="box">
	<div class="box-title">
		<h3>
			<i class="fa fa-user"></i>
			Cambiar Contraseña
		</h3>
	</div>
	<div class="box-content">
		<?php echo $this->Form->create('BackendUser', array('class' => 'form-horizontal form-validate')) ?>
			<div class="form-group">
				<label for="BackendUserPassword" class="control-label col-sm-2">Contraseña Actual</label>
				<div class="col-sm-10">
					<?php echo $this->Form->input('BackendUser.old_password', array('type' => 'password', 'div' => false, 'label' => false, 'class' => 'form-control', 'data-rule-required' => true)) ?>
				</div>
			</div>
			<div class="form-group">
				<label for="BackendUserPassword" class="control-label col-sm-2">Contraseña Nueva</label>
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
				<a href="<?php echo $this->request->referer() ?>" class="btn">Cancelar</a>
			</div>
		<?php echo $this->Form->end() ?>
	</div>
</div>