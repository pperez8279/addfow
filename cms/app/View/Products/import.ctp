<?php $this->Html->addCrumb('Productos', array('controller' => 'products', 'action' => 'index')) ?>
<?php $this->Html->addCrumb('Importar', array('controller' => 'products', 'action' => 'import')) ?>
<div class="box">
	<div class="box-title">
		<h3>
			<i class="fa fa-shopping-cart"></i>
			Importar Productos
		</h3>
	</div>
	<div class="box-content">
		<?php echo $this->Form->create('Product', array('class' => 'form-horizontal form-validate', 'type' => 'file')) ?>
			<div class="form-group">
				<label for="ProductName" class="control-label col-sm-2">Seleccionar y Subir Plantilla</label>
				<div class="col-sm-10">
					<?php echo $this->Form->input('Product.file', array('type' => 'file', 'div' => false, 'label' => false, 'class' => 'form-control', 'data-rule-required' => true)) ?>
				</div>
			</div>
			<div class="form-actions">
				<?php echo $this->Form->submit('Importar', array('div' => false, 'class' => 'btn btn-primary')) ?>
				<a href="<?php echo $this->request->referer() ?>" class="btn">Cancelar</a>
			</div>
		<?php echo $this->Form->end() ?>
	</div>
</div>