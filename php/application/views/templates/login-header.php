<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $this->lang->line('my_application_name'); ?></title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link href="<?php echo base_url('/'); ?>favicon.ico" type="image/x-icon" rel="icon"/>
	<link href="<?php echo base_url('/'); ?>favicon.ico" type="image/x-icon" rel="shortcut icon"/>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css?v=3.3.7"/>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css?v=4.7.0"/>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.2/css/AdminLTE.min.css?v=2.4.2"/>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.2/css/skins/skin-green.min.css?v=2.4.2"/>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/all.css?v=1.0.2"/>
	<link rel="stylesheet" type="text/css" href="<?php base_url('/'); ?>css/my-style.css?v=<?php echo get_file_info(FCPATH.'css'.DS.'my-style.css')['date']; ?>"/>

	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body class="hold-transition login-page">
