<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
		<title>Administrador Sistema Manejador de Eventos UPTM</title>
	
		<!-- Core CSS - Include with every page -->
		<link href="<?=base_url('backend/css/bootstrap.min.css')?>" rel="stylesheet">
		<link href="<?=base_url('backend/font-awesome/css/font-awesome.css')?>" rel="stylesheet">
		
		<!-- SB Admin CSS - Include with every page -->
		<link href="<?=base_url('backend/css/sb-admin.css')?>" rel="stylesheet">
	
		<?php if($controller == 'Home'): ?>
			<!-- Page-Level Plugin CSS - Dashboard -->
			<link href="<?=base_url('backend/css/plugins/morris/morris-0.4.3.min.css')?>" rel="stylesheet">
			<link href="<?=base_url('backend/css/plugins/timeline/timeline.css')?>" rel="stylesheet">
		<?php elseif ($controller == 'List'): ?>
			<link href="<?=base_url('backend/css/plugins/dataTables/dataTables.bootstrap.css')?>" rel="stylesheet">
		<?php elseif ($controller == 'New_Job' or $controller == 'New_Entry'): ?>
			<link href="<?=base_url('backend/css/plugins/summernote/summernote.css')?>" rel="stylesheet">
			<link href="<?=base_url('backend/css/plugins/summernote/summernote-bs3.css')?>" rel="stylesheet">
		<?php endif; ?>

	</head>
	<body>
		<div id="wrapper">
			<nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="<?=site_url('backend/index')?>"><span class="hidden-xs">Sistema Manejador de Eventos de la Universidad Politécnica Territorial de Mérida "Kléber Ramírez"</span> <span class="visible-xs">EMS UPTM</span></a>
				</div>
				<!-- /.navbar-header -->
	
				<ul class="nav navbar-top-links navbar-right pull-right">
					<!-- /.dropdown -->
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
						</a>
						<ul class="dropdown-menu dropdown-user">
							<li><a href="<?=site_url('user/view/'.$this->session->userdata('manager_ems_uptm')['Participant_Id'])?>"><i class="fa fa-user fa-fw"></i> Perfil de Usuario</a>
							</li>
							<li class="divider"></li>
							<li><a href="<?=site_url('backend/logout')?>"><i class="fa fa-sign-out fa-fw"></i> Cerrar Sesión</a>
							</li>
						</ul>
						<!-- /.dropdown-user -->
					</li>
					<!-- /.dropdown -->
				</ul>
				<!-- /.navbar-top-links -->
	
				<div class="navbar-default navbar-static-side" role="navigation">
					<div class="sidebar-collapse">
						<ul class="nav" id="side-menu">
							<li>
								<a href="<?=site_url('backend/index')?>"><i class="fa fa-home fa-fw"></i> Inicio</a>
							</li>
							<li>
								<a href="<?=site_url('admin/accounts_index')?>"><i class="fa fa-th fa-fw"></i> Administración<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level">
									<li>
										<a href="<?=site_url('admin/accounts_index')?>"><i class="fa fa-building-o fa-fw"></i> Cuentas</a>
									</li>
									<li>
										<a href="<?=site_url('admin/backup')?>"><i class="fa fa-download fa-fw"></i> Respaldo</a>
									</li>
								</ul>
								<!-- /.nav-second-level -->
							</li>
							<li>
								<a href="<?=site_url('events/index')?>"><i class="fa fa-calendar fa-fw"></i> Eventos<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level">
									<li>
										<a href="<?=site_url('events/index')?>"><i class="fa fa-thumb-tack fa-fw"></i> Eventos</a>
									</li>
									<li>
										<a href="<?=site_url('sale/index')?>"><i class="fa fa-clock-o fa-fw"></i> Preventas</a>
									</li>
									<li>
										<a href="<?=site_url('events/applications')?>"><i class="fa fa-rocket fa-fw"></i> Ponentes</a>
									</li>
								</ul>
								<!-- /.nav-second-level -->
							</li>
							<li>
								<a href="#"><i class="fa fa-users fa-fw"></i> Participantes<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level">
									<li>
										<a href="<?=site_url('participant/index')?>"><i class="fa fa-th-list fa-fw"></i>Lista</a>
									</li>
									<li>
										<a href="<?=site_url('registration/index')?>"><i class="fa fa-ticket fa-fw"></i>Inscripción</a>
									</li>
									<li>
										<a href="<?=site_url('payment/index')?>"><i class="fa fa-money fa-fw"></i>Pagos</a>
									</li>
								</ul>
								<!-- /.nav-second-level -->
							</li>
							<li>
								<a href="#"><i class="fa fa-picture-o fa-fw"></i> Certificados<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level">
									<li>
										<a href="<?=site_url('certified/design')?>"><i class="fa fa-picture-o fa-fw"></i> Diseño</a>
									</li>
									<li>
										<a href="<?=site_url('certified/prints')?>"><i class="fa fa-print fa-fw"></i> Impresión</a>
									</li>
								</ul>
								<!-- /.nav-second-level -->
							</li>							
							<!--<li>
								<a href="<?=site_url('reports')?>"><i class="fa fa-bar-chart-o fa-fw"></i> Reportes</span></a>
							</li>-->
							<li>
								<a href="#"><i class="fa fa-user fa-fw"></i> Acceso<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level">
									<li>
										<a href="<?=site_url('user/index')?>"><i class="fa fa-user fa-fw"></i> Usuarios</a>
									</li>
									<li>
										<a href="<?=site_url('user/search_participant')?>"><i class="fa fa-plus fa-fw"></i> Añadir Usuario</a>
									</li>
								</ul>
							</li>
						</ul>
						<!-- /#side-menu -->
					</div>
					<!-- /.sidebar-collapse -->
				</div>
				<!-- /.navbar-static-side -->
			</nav>

