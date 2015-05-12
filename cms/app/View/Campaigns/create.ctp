<?php $this->Html->addCrumb('Campañas', array('controller' => 'campaigns', 'action' => 'index')) ?>
<?php $this->Html->addCrumb('Agregar', array('controller' => 'campaigns', 'action' => 'create')) ?>
<div class="box">
	<div class="box-title">
		<h3>
			<i class="fa fa-calendar"></i>
			Campaña
		</h3>
	</div>
	<div class="box-content">
		<?php echo $this->Form->create('Campaign', array('class' => 'form-horizontal form-validate')) ?>
			<?php echo $this->Form->input('Campaign.id', array('type' => 'hidden')) ?>
			<div class="form-group">
				<label for="CampaignName" class="control-label col-sm-2">Nombre</label>
				<div class="col-sm-10">
					<?php echo $this->Form->input('Campaign.name', array('div' => false, 'label' => false, 'class' => 'form-control', 'data-rule-required' => true)) ?>
				</div>
			</div>
			<div class="form-group">
				<label for="CampaignDescription" class="control-label col-sm-2">Descripción</label>
				<div class="col-sm-10">
					<?php echo $this->Form->input('Campaign.description', array('div' => false, 'label' => false, 'class' => 'form-control', 'data-rule-required' => true)) ?>
				</div>
			</div>
			<div class="input-daterange">
				<div class="form-group">
					<label for="CampaignStartDate" class="control-label col-sm-2">Fechas Lanzamiento</label>
					<div class="col-sm-10">
						<?php echo $this->Form->input('Campaign.start_date', array('type' => 'text', 'div' => false, 'label' => false, 'class' => 'form-control', 'data-rule-required' => true)) ?>
					</div>
				</div>
				<div class="form-group">
					<label for="CampaignEndDate" class="control-label col-sm-2">Fechas Expiración</label>
					<div class="col-sm-10">
						<?php echo $this->Form->input('Campaign.end_date', array('type' => 'text', 'div' => false, 'label' => false, 'class' => 'form-control', 'data-rule-required' => true)) ?>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="CampaignShopBrochureId" class="control-label col-sm-2">Catalogos</label>
				<div class="col-sm-10">
					<select data-rule-required="true" multiple="multiple" id="CampaignShopBrochureId" name="data[CampaignShopBrochure][shop_brochure_id][]">
					</select>
				</div>
			</div>
			<div class="form-actions">
				<?php echo $this->Form->submit('Guardar', array('div' => false, 'class' => 'btn btn-primary')) ?>
				<a href="<?php echo $this->request->referer() ?>" class="btn">Cancelar</a>
			</div>
		<?php echo $this->Form->end() ?>
	</div>
</div>