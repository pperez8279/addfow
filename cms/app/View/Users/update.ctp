<?php $this->Html->addCrumb('Usuarios', array('controller' => 'users', 'action' => 'index')) ?>
<?php $this->Html->addCrumb('Editar', array('controller' => 'users', 'action' => 'update')) ?>
<div class="box">
	<div class="box-title">
		<h3>
			<i class="fa fa-user"></i>
			Editar Usuario
		</h3>
	</div>
	<div class="box-content">
		<?php echo $this->Form->create('User', array('class' => 'form-horizontal form-validate')) ?>
			<div class="col-sm-10">
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
				<div class="form-group">
					<label for="UserFacebookUserId" class="control-label col-sm-2">Facebook ID</label>
					<div class="col-sm-10">
						<?php echo $this->Form->input('User.facebook_user_id', array('type' => 'text', 'div' => false, 'label' => false, 'class' => 'form-control', 'readonly')) ?>
					</div>
				</div>
			</div>
			<div class="col-sm-2">
				<a href="javascript:;" class="thumbnail">
					<img class="img-responsive" src="http://oficina.vnstudios.com/dingdong/site/images/users/<?php echo $this->request->data['User']['picture'] ?>">
				</a>
			</div>
			<div class="clearfix"></div>
			<?php if ($rows) { ?>
			<div class="box box-color box-bordered">
				<div class="box-title">
					<h3>
						<i class="fa fa-user"></i>
						Clientes
					</h3>
				</div>
				<div class="box-content nopadding">
					<table class="table table-hover table-nomargin">
						<thead>
							<tr>
								<th><?php echo $this->Paginator->sort('User.id', 'ID') ?></th>
								<th><?php echo $this->Paginator->sort('User.first_name', 'Nombre') ?></th>
								<th><?php echo $this->Paginator->sort('User.last_name', 'Apellido') ?></th>
								<th><?php echo $this->Paginator->sort('User.email', 'Email') ?></th>
								<th class="text-center">Acciónes</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($rows as $k => $v) { ?>
								<tr>
									<td><?php echo $v['User']['id'] ?></td>
									<td><?php echo $v['User']['first_name'] ?></td>
									<td><?php echo $v['User']['last_name'] ?></td>
									<td><?php echo $v['User']['email'] ?></td>
									<td class="text-center">
										<a href="<?php echo h(Router::url('/users/update/'.$v['User']['id'], true)) ?>" class="btn" rel="tooltip" data-original-title="Ver"><i class="fa fa-eye"></i></a>
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
			<?php } ?>
			<div class="form-actions">
				<?php echo $this->Form->submit('Guardar', array('div' => false, 'class' => 'btn btn-primary')) ?>
				<a href="<?php echo $this->request->referer() ?>" class="btn">Cancelar</a>
			</div>
		<?php echo $this->Form->end() ?>
	</div>
</div>