<?php $this->Html->addCrumb('Campañas', array('controller' => 'campaigns', 'action' => 'index')) ?>
<br>
<br>
<div class="box box-color box-bordered">
	<div class="box-title">
		<h3>
			<i class="fa fa-calendar"></i>
			Campañas
		</h3>
	</div>
	<div class="box-content nopadding">
		<table class="table table-hover table-nomargin">
			<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('id', 'ID') ?></th>
					<th><?php echo $this->Paginator->sort('start_date', 'Fechas Lanzamiento') ?></th>
					<th><?php echo $this->Paginator->sort('end_date', 'Fechas Expiración') ?></th>
					<th><?php echo $this->Paginator->sort('name', 'Nombre') ?></th>
					<th><?php echo $this->Paginator->sort('description', 'Descripción') ?></th>
					<th>Acciónes</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($rows as $k => $v) { ?>
					<tr>
						<td><?php echo $v['Campaign']['id'] ?></td>
						<td><?php echo $v['Campaign']['start_date'] ?></td>
						<td><?php echo $v['Campaign']['end_date'] ?></td>
						<td><?php echo $v['Campaign']['name'] ?></td>
						<td><?php echo $v['Campaign']['description'] ?></td>
						<td>
							<a href="<?php echo h(Router::url('/campaigns/update/'.$v['Campaign']['id'], true)) ?>" class="btn" rel="tooltip" title="" data-original-title="Editar"><i class="fa fa-edit"></i></a>
							<a href="<?php echo h(Router::url('/campaigns/delete/'.$v['Campaign']['id'], true)) ?>" class="btn delete" rel="tooltip" title="" data-original-title="Eliminar"><i class="fa fa-times"></i></a>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<div class="paginator-counter pull-left">
			<?php echo $this->Paginator->counter('Página {:page} de {:pages}, mostrando {:current} registros de {:count} total, comienza en registro {:start}, finaliza en {:end}') ?>
		</div>
		<div class="table-pagination">
			<?php echo $this->Paginator->first('Primera', array('tag' => false)) ?>
			<?php echo $this->Paginator->prev('Anterior', array('tag' => false), null, array('tag' => 'a', 'class' => 'disabled')) ?> 
			<?php echo $this->Paginator->numbers(array('before' => '<span>', 'after' => '</span>', 'tag' => 'a', 'currentClass' => 'active', 'separator' => false)) ?>
			<?php echo $this->Paginator->next('Siguiente', array('tag' => false), null, array('tag' => 'a', 'class' => 'disabled')) ?>
			<?php echo $this->Paginator->last('Ultima', array('tag' => false)) ?>
		</div>
	</div>
</div>