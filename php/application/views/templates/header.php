<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?= lang('app_title'); ?></title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link href="<?= base_url('/'); ?>favicon.ico" type="image/x-icon" rel="icon"/>
	<link href="<?= base_url('/'); ?>favicon.ico" type="image/x-icon" rel="shortcut icon"/>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css?v=3.3.7"/>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css?v=4.7.0"/>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.2/css/AdminLTE.min.css?v=2.4.2"/>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.2/css/skins/skin-purple.min.css?v=2.4.2"/>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/all.css?v=1.0.2"/>
	<link rel="stylesheet" type="text/css" href="<?= base_url('/'); ?>css/my-style.css?v=<?= get_file_info(FCPATH.'css'.DS.'my-style.css')['date']; ?>"/>

	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<?php if($class == 'login' || $class == 'signup'): ?>
<body class="hold-transition login-page">
<?php else: ?>
<body class="hold-transition skin-purple sidebar-mini">
	<div class="wrapper" id="main-container">
		<header class="main-header">
			<a href="<?= base_url('/'); ?>" class="logo">
				<span class="logo-mini"><b><?= lang('app_title_mini'); ?></b></span>
				<span class="logo-lg"><b><?= lang('app_title'); ?></b></span>
			</a>
			<nav class="navbar navbar-static-top" role="navigation">
				<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
					<span class="sr-only">Toggle navigation</span>
				</a>
				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<li class="dropdown user user-menu">
							<a href="<?= base_url('/login/logout'); ?>" class="dropdown-toggle">
								<span class=""><?= lang('logout_title'); ?></span>
							</a>
						</li>
					</ul>
				</div>
			</nav>
		</header>

		<aside class="main-sidebar">
			<section class="sidebar">
				<ul class="sidebar-menu" data-widget="tree">
					<li class="header"><?= lang('app_aside_header'); ?></li>
<?php foreach($aside as $side): ?>
<?php if($side['children']): ?>
					<li class="treeview <?php if($class == $side['class']): ?>active<?php endif; ?>">
						<a href="#"><?= $side['icon']; ?> <span><?= $side['name']; ?></span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
<?php foreach($side['children'] as $child): ?>
							<li class="<?php if($class == $side['class'] && $method == $child['method']): ?>active<?php endif; ?>">
								<a href="<?= base_url('/').$child['link']; ?>">
									<?= $child['name']; ?>
								</a>
							</li>
<?php endforeach; ?>
						</ul>
					</li>
<?php else: ?>
					<li class="<?php if($class == $side['class']): ?>active<?php endif; ?>">
						<a href="<?= base_url('/').$side['link']; ?>">
							<?= $side['icon']; ?> <span><?= $side['name']; ?></span>
						</a>
					</li>
<?php endif; ?>
<?php endforeach; ?>
				</ul>
			</section>
		</aside>

		<div class="content-wrapper">

<?php endif; ?>