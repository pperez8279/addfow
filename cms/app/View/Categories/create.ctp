<div class="box">
	<div class="box-content">
		<?php echo $this->Form->create('Category', array('class' => 'form-horizontal form-validate')) ?>
			<div class="form-group">
				<label for="CategoryName" class="control-label col-sm-2">Nombre</label>
				<div class="col-sm-10">
					<?php echo $this->Form->input('Category.name', array('div' => false, 'label' => false, 'class' => 'form-control', 'data-rule-required' => true)) ?>
				</div>
			</div>
			<div class="form-group">
				<label for="CategoryDescription" class="control-label col-sm-2">Descripción</label>
				<div class="col-sm-10">
					<?php echo $this->Form->input('Category.description', array('div' => false, 'label' => false, 'class' => 'form-control')) ?>
				</div>
			</div>
		<?php echo $this->Form->end() ?>
	</div>
</div>