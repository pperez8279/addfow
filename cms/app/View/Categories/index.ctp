<?php $this->Html->addCrumb('Categorías', array('controller' => 'categories', 'action' => 'index')) ?>
<br>
<div class="pull-right">
	<a href="javascript:;" data-url="categories/create" data-id="0" data-original-title="Nueva Categoría Padre" class="btn btn-primary dialog">Nueva Categoría Padre</a>
</div>
<br>
<br>
<div id="sortable">
	<?php echo $rows ?>
</div>