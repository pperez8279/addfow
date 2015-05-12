<?php $this->Html->addCrumb('Usuarios', array('controller' => 'users', 'action' => 'index')) ?>
<?php $this->Html->addCrumb('Agregar', array('controller' => 'users', 'action' => 'create')) ?>
<div class="box">
	<div class="box-title">
		<h3>
			<i class="fa fa-user"></i>
			Agregar Usuario
		</h3>
	</div>
	<div class="box-content">
		<?php echo $this->Form->create('User', array('class' => 'form-horizontal form-validate')) ?>
			<div class="form-group">
				<label for="UserFirstName" class="control-label col-sm-2">Nombre</label>
				<div class="col-sm-10">
					<?php echo $this->Form->input('User.first_name', array('div' => false, 'label' => false, 'class' => 'form-control', 'data-rule-required' => true)) ?>
				</div>
			</div>
			<div class="form-group">
				<label for="UserLastName" class="control-label col-sm-2">Apellido</label>
				<div class="col-sm-10">
					<?php echo $this->Form->input('User.last_name', array('div' => false, 'label' => false, 'class' => 'form-control', 'data-rule-required' => true)) ?>
				</div>
			</div>
			<div class="form-group">
				<label for="UserEmail" class="control-label col-sm-2">Email</label>
				<div class="col-sm-10">
					<?php echo $this->Form->input('User.email', array('div' => false, 'label' => false, 'class' => 'form-control', 'data-rule-required' => true,'data-rule-email' => true)) ?>
				</div>
			</div>
			<div class="form-group">
				<label for="UserUserType" class="control-label col-sm-2">Tipo</label>
				<div class="col-sm-10">
					<?php echo $this->Form->input('User.user_type_id', array('div' => false, 'label' => false, 'class' => 'form-control', 'data-rule-required' => true, 'options' => $UserTypes)) ?>
				</div>
			</div>
			<div class="form-actions">
				<?php echo $this->Form->submit('Guardar', array('div' => false, 'class' => 'btn btn-primary')) ?>
				<a href="<?php echo $this->request->referer() ?>" class="btn">Cancelar</a>
			</div>
		<?php echo $this->Form->end() ?>
	</div>
</div>