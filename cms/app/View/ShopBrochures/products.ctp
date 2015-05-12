<div class="box">
	<div class="box-content">
		<?php echo $this->Form->create('ShopBrochureProduct', array('class' => 'form-horizontal form-validate')) ?>
			<div class="form-group">
				<label for="ShopBrochureProductProductId" class="control-label col-sm-2">Prdoducto</label>
				<div class="col-sm-10">
					<?php echo $this->Form->input('ShopBrochureProduct.product_id', array('options' => $products, 'div' => false, 'label' => false, 'class' => '', 'data-rule-required' => true)) ?>
				</div>
			</div>
			<div class="form-group">
				<label for="ShopBrochureProductPrice" class="control-label col-sm-2">Precio</label>
				<div class="col-sm-10">
					<?php echo $this->Form->input('ShopBrochureProduct.price', array('div' => false, 'label' => false, 'class' => 'form-control', 'data-rule-required' => true)) ?>
				</div>
			</div>
			<div class="form-group">
				<label for="ShopBrochureProductCode" class="control-label col-sm-2">Código</label>
				<div class="col-sm-10">
					<?php echo $this->Form->input('ShopBrochureProduct.code', array('div' => false, 'label' => false, 'class' => 'form-control', 'data-rule-required' => true)) ?>
				</div>
			</div>
		<?php echo $this->Form->end() ?>
	</div>
</div>