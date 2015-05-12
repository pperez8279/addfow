<?php $this->Html->addCrumb('Productos', array('controller' => 'products', 'action' => 'index')) ?>
<?php $this->Html->addCrumb('Agregar', array('controller' => 'products', 'action' => 'create')) ?>
<div class="box">
	<div class="box-title">
		<h3>
			<i class="fa fa-shopping-cart"></i>
			Producto
		</h3>
	</div>
	<div class="box-content">
		<?php echo $this->Form->create('Product', array('class' => 'form-horizontal form-validate')) ?>
			<div class="form-group">
				<label for="ProductName" class="control-label col-sm-2">Nombre</label>
				<div class="col-sm-10">
					<?php echo $this->Form->input('Product.name', array('div' => false, 'label' => false, 'class' => 'form-control', 'data-rule-required' => true)) ?>
				</div>
			</div>
			<div class="form-group">
				<label for="ProductCode" class="control-label col-sm-2">Código</label>
				<div class="col-sm-10">
					<?php echo $this->Form->input('Product.code', array('div' => false, 'label' => false, 'class' => 'form-control', 'data-rule-required' => true)) ?>
				</div>
			</div>
			<div class="form-group">
				<label for="ProductPrice" class="control-label col-sm-2">Precio</label>
				<div class="col-sm-10">
					<?php echo $this->Form->input('Product.price', array('div' => false, 'label' => false, 'class' => 'form-control', 'data-rule-required' => true)) ?>
				</div>
			</div>
			<div class="form-group">
				<label for="ProductDescription" class="control-label col-sm-2">Descripción</label>
				<div class="col-sm-10">
					<?php echo $this->Form->input('Product.description', array('div' => false, 'label' => false, 'class' => 'form-control', 'data-rule-required' => true)) ?>
				</div>
			</div>
			<div class="form-group">
				<label for="ProductCategoryId" class="control-label col-sm-1">Categoría</label>
				<a href="javascript:;" class="btn btn-primary col-sm-1 assign-category">Asignar Categoría</a>
				<div class="col-sm-10">
					<input id="ProductCategoryName" <?php if ($ProductCategoryName) echo 'value="'.$ProductCategoryName.'"'?>type="text" class="form-control" data-rule-required="true" disabled>
					<?php echo $this->Form->input('Product.category_id', array('type' => 'hidden', 'div' => false, 'label' => false, 'class' => 'form-control', 'data-rule-required' => true)) ?>
				</div>
			</div>
			<div class="form-actions">
				<?php echo $this->Form->submit('Guardar', array('div' => false, 'class' => 'btn btn-primary')) ?>
				<a href="<?php echo $this->request->referer() ?>" class="btn">Cancelar</a>
			</div>
		<?php echo $this->Form->end() ?>
	</div>
</div>