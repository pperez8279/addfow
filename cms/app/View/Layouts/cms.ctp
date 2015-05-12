<?php echo $this->element('header') ?>
<body>
	<div id="navigation">
		<div class="container-fluid">
			<a href="#" id="brand">DINGDONG</a>
			<a href="#" class="toggle-nav" rel="tooltip" data-placement="bottom" title="" data-original-title="Toggle navigation">
				<i class="fa fa-bars"></i>
			</a>
			<ul class='main-nav'>
			</ul>
			<div class="user">
				<ul class="icon-nav">
					<li class="dropdown sett">
						<a href="#" class='dropdown-toggle' data-toggle="dropdown">
							<i class="fa fa-cog"></i>
						</a>
						<ul class="dropdown-menu pull-right theme-settings">
							<li>
								<span>Layout-width</span>
								<div class="version-toggle">
									<a href="#" class='set-fixed'>Fixed</a>
									<a href="#" class="active set-fluid">Fluid</a>
								</div>
							</li>
							<li>
								<span>Topbar</span>
								<div class="topbar-toggle">
									<a href="#" class='set-topbar-fixed'>Fixed</a>
									<a href="#" class="active set-topbar-default">Default</a>
								</div>
							</li>
							<li>
								<span>Sidebar</span>
								<div class="sidebar-toggle">
									<a href="#" class='set-sidebar-fixed'>Fixed</a>
									<a href="#" class="active set-sidebar-default">Default</a>
								</div>
							</li>
						</ul>
					</li>
					<li class='dropdown colo'>
						<a href="#" class='dropdown-toggle' data-toggle="dropdown">
							<i class="fa fa-tint"></i>
						</a>
						<ul class="dropdown-menu pull-right theme-colors">
							<li class="subtitle">
								Predefined colors
							</li>
							<li>
								<span class='red'></span>
								<span class='orange'></span>
								<span class='green'></span>
								<span class="brown"></span>
								<span class="blue"></span>
								<span class='lime'></span>
								<span class="teal"></span>
								<span class="purple"></span>
								<span class="pink"></span>
								<span class="magenta"></span>
								<span class="grey"></span>
								<span class="darkblue"></span>
								<span class="lightred"></span>
								<span class="lightgrey"></span>
								<span class="satblue"></span>
								<span class="satgreen"></span>
							</li>
						</ul>
					</li>
				</ul>
				<div class="dropdown">
					<a href="#" class='dropdown-toggle' data-toggle="dropdown">
						<i class="fa fa-user"></i>
						<?php echo AuthComponent::user('first_name').' '.AuthComponent::user('last_name') ?>
					</a>
					<ul class="dropdown-menu pull-right">
						<li>
							<a href="<?php echo h(Router::url('/backend_users/update/'.AuthComponent::user('id'), true)) ?>">Editar Perfil</a>
						</li>
						<li>
							<a href="<?php echo h(Router::url('/backend_users/password/'.AuthComponent::user('id'), true)) ?>">Cambiar Contraseña</a>
						</li>
						<li>
							<a href="<?php echo Router::url('/backend_users/logout') ?>">Cerrar sesión</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid" id="content">
		<div id="left">
			<form action="search-results.html" method="GET" class='search-form'>
				<div class="search-pane">
					<input type="text" name="search" placeholder="Search here...">
					<button type="submit">
						<i class="fa fa-search"></i>
					</button>
				</div>
			</form>
			<div class="subnav subnav-hidden" data-module="backend_users">
				<div class="subnav-title">
					<a href="#" class='toggle-subnav'>
						<i class="fa fa-angle-down"></i>
						<span>Usuarios CMS</span>
					</a>
				</div>
				<ul class="subnav-menu">
					<li>
						<a href="<?php echo h(Router::url('/backend_users', true)) ?>">Listar / Editar</a>
					</li>
					<li>
						<a href="<?php echo h(Router::url('/backend_users/create', true)) ?>">Agregar</a>
					</li>
				</ul>
			</div>
			<div class="subnav subnav-hidden" data-module="users">
				<div class="subnav-title">
					<a href="#" class='toggle-subnav'>
						<i class="fa fa-angle-down"></i>
						<span>Usuarios</span>
					</a>
				</div>
				<ul class="subnav-menu">
					<li>
						<a href="<?php echo h(Router::url('/users', true)) ?>">Listar / Editar</a>
					</li>
					<li>
						<a href="<?php echo h(Router::url('/users/create', true)) ?>">Agregar</a>
					</li>
				</ul>
			</div>
			<div class="subnav">
				<div class="subnav-title">
					<ul class="subnav-menu">
						<li>
							<a href="<?php echo h(Router::url('/categories', true)) ?>">
								<span class="single">Categorías</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="subnav subnav-hidden" data-module="campaigns">
				<div class="subnav-title">
					<a href="#" class='toggle-subnav'>
						<i class="fa fa-angle-down"></i>
						<span>Campañas</span>
					</a>
				</div>
				<ul class="subnav-menu">
					<li>
						<a href="<?php echo h(Router::url('/campaigns', true)) ?>">Listar / Editar</a>
					</li>
					<li>
						<a href="<?php echo h(Router::url('/campaigns/create', true)) ?>">Agregar</a>
					</li>
				</ul>
			</div>
			<div class="subnav subnav-hidden" data-module="shop_brochures">
				<div class="subnav-title">
					<a href="#" class='toggle-subnav'>
						<i class="fa fa-angle-down"></i>
						<span>Catálogos</span>
					</a>
				</div>
				<ul class="subnav-menu">
					<li>
						<a href="<?php echo h(Router::url('/shop_brochures', true)) ?>">Listar / Editar</a>
					</li>
					<li>
						<a href="<?php echo h(Router::url('/shop_brochures/create', true)) ?>">Agregar</a>
					</li>
				</ul>
			</div>
			<div class="subnav subnav-hidden" data-module="products">
				<div class="subnav-title">
					<a href="#" class='toggle-subnav'>
						<i class="fa fa-angle-down"></i>
						<span>Productos</span>
					</a>
				</div>
				<ul class="subnav-menu">
					<li>
						<a href="<?php echo h(Router::url('/products', true)) ?>">Listar / Editar</a>
					</li>
					<li>
						<a href="<?php echo h(Router::url('/products/create', true)) ?>">Agregar</a>
					</li>
					<li>
						<a href="<?php echo h(Router::url('/products/download_template', true)) ?>">Descargar Plantilla</a>
					</li>
					<li>
						<a href="<?php echo h(Router::url('/products/import', true)) ?>">Importar</a>
					</li>
				</ul>
			</div>
			<div class="subnav subnav-hidden" data-module="offers">
				<div class="subnav-title">
					<a href="#" class='toggle-subnav'>
						<i class="fa fa-angle-down"></i>
						<span>Ofertas</span>
					</a>
				</div>
				<ul class="subnav-menu">
					<li>
						<a href="<?php echo h(Router::url('/offers', true)) ?>">Listar / Editar</a>
					</li>
					<li>
						<a href="<?php echo h(Router::url('/offers/create', true)) ?>">Agregar</a>
					</li>
				</ul>
			</div>
			<div class="subnav">
				<div class="subnav-title">
					<ul class="subnav-menu">
						<li>
							<a href="<?php echo h(Router::url('/user_tracking_actions', true)) ?>">
								<span class="single">Reportes</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div id="main">
			<div class="container-fluid">
				<div class="page-header">
					<div class="pull-left">
						<h1><?php echo $Module ?></h1>
					</div>
				</div>
				<div class="breadcrumbs">
						<?php echo $this->Html->getCrumbList(array('separator' => '<i class="fa fa-angle-right"></i>'), 'Home') ?>
					<div class="close-bread">
						<a href="#">
							<i class="fa fa-times"></i>
						</a>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<?php echo $this->Session->flash() ?>
						<?php echo $this->fetch('content') ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php echo $this->element('footer') ?>