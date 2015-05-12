<?php $this->Html->addCrumb('Ofertas', array('controller' => 'offers', 'action' => 'index')) ?>
<?php $this->Html->addCrumb('Agregar', array('controller' => 'offers', 'action' => 'create')) ?>
<div class="box">
	<div class="box-title">
		<h3>
			<i class="fa fa-tags"></i>
			Oferta
		</h3>
	</div>
	<div class="box-content">
		<?php echo $this->Form->create('Offer', array('class' => 'form-horizontal form-validate')) ?>
			<?php echo $this->Form->input('Offer.id', array('type' => 'hidden')) ?>
			<div class="form-group">
				<label for="OfferName" class="control-label col-sm-2">Nombre</label>
				<div class="col-sm-10">
					<?php echo $this->Form->input('Offer.name', array('div' => false, 'label' => false, 'class' => 'form-control', 'data-rule-required' => true)) ?>
				</div>
			</div>
			<div class="form-group">
				<label for="OfferDescription" class="control-label col-sm-2">Descripción</label>
				<div class="col-sm-10">
					<?php echo $this->Form->input('Offer.description', array('div' => false, 'label' => false, 'class' => 'form-control', 'data-rule-required' => true)) ?>
				</div>
			</div>
			<div class="form-group">
				<label for="OfferOfferTypeId" class="control-label col-sm-2">Oferta</label>
				<div class="col-sm-10">
					<?php echo $this->Form->input('Offer.offer_type_id', array('title' =>'Este campo es obligatorio.', 'div' => false, 'label' => false, 'data-rule-required' => true, 'options' => $OffersTypes, 'empty' => 'Seleccione...')) ?>
				</div>
			</div>
			<div class="form-group">
				<label for="OfferProductGroupShopBrochureId" class="control-label col-sm-2">Catalogo</label>
				<div class="col-sm-10">
					<?php echo $this->Form->input('OfferProductGroup.0.shop_brochure_id', array('title' =>'Este campo es obligatorio.', 'div' => false, 'label' => false, 'data-rule-required' => true, 'options' => $ShopBrochures, 'empty' => 'Seleccione...')) ?>
				</div>
			</div>
			<div class="form-group" id="offer-price">
				<label for="OfferProductGroupPrice" class="control-label col-sm-2">Precio</label>
				<div class="col-sm-2">
					<?php echo $this->Form->input('OfferProductGroup.0.price', array('type' => 'text', 'div' => false, 'label' => false, 'class' => 'form-control price', 'data-rule-required' => true)) ?>
				</div>
			</div>
			<div class="form-group">
				<label for="OfferProductGroupProductId" class="control-label col-sm-2">Productos</label>
				<div class="col-sm-10">
					<select data-rule-required="true" multiple="multiple" id="OfferProductGroupShopBrochureProductId" name="data[OfferProductGroup][shop_brochure_product_id][]">
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="OfferProductGroupCode" class="control-label col-sm-2">Código</label>
				<div class="col-sm-2">
					<?php echo $this->Form->input('OfferProductGroup.0.code', array('div' => false, 'label' => false, 'class' => 'form-control', 'data-rule-required' => true)) ?>
				</div>
			</div>
			<div class="form-actions">
				<?php echo $this->Form->submit('Guardar', array('div' => false, 'class' => 'btn btn-primary')) ?>
				<a href="<?php echo $this->request->referer() ?>" class="btn">Cancelar</a>
			</div>
		<?php echo $this->Form->end() ?>
	</div>
</div>