<div class="wrapper">
	<h1>
		<a href="">
			<img src="<?php echo h(Router::url('/img/logo-big.png', true)) ?>" alt="" class='retina-ready' width="59" height="49">
			DINGDONG
		</a>
	</h1>
	<div class="login-body">
		<h2>SIGN IN</h2>
		<?php echo $this->Form->create('BackendUser', array('class' => 'form-validate', 'id' => 'test', 'novalidate')) ?>
			<div class="form-group">
				<div class="email controls">
					<?php echo $this->Form->input('BackendUser.email', array('div' => false, 'label' => false, 'placeholder' => 'Email address', 'class' => 'form-control', 'data-rule-required' => true,'data-rule-email' => true)) ?>
				</div>
			</div>
			<div class="form-group">
				<div class="pw controls">
					<?php echo $this->Form->input('BackendUser.password', array('div' => false, 'label' => false, 'placeholder' => 'Password', 'class' => 'form-control', 'data-rule-required' => true)) ?>
				</div>
			</div>
			<div class="submit">
				<div class="remember">
					<?php echo $this->Form->checkbox('BackendUser.remember', array('div' => false, 'label' => false, 'class' => 'icheck-me', 'data-skin' => 'square', 'data-color' => 'blue', 'id' => 'remember', 'value' => 1)) ?>
					<label for="remember">Remember me</label>
				</div>
				<?php echo $this->Form->submit('Sign me in', array('div' => false, 'class' => 'btn btn-primary')) ?>
			</div>
		<?php echo $this->Form->end() ?>
		<div class="forget">
			<a href="javascript:;">
				<span>Forgot password?</span>
			</a>
		</div>
	</div>
</div>