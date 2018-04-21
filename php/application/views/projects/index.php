


			<section class="content-header">
				<h1><?php echo lang('projects_title'); ?></h1>
				<ol class="breadcrumb">
					<li>
						<a href="<?php echo base_url('/projects'); ?>">
							<i class="fa fa-paw" aria-hidden="true"></i> <?php echo lang('projects_title'); ?>
						</a>
					</li>
				</ol>
			</section>

			<section class="content container-fluid">
				<div class="box">
					<div class="box-header with-border">
						<div class="row">
							<div class="col-xs-12">
								<h1>Welcome to CodeIgniter!</h1>
							</div>
						</div>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-xs-12">
								<div class="box-body" v-cloak>
									<p>The page you are looking at is being generated dynamically by CodeIgniter.</p>

									<p>If you would like to edit this page you'll find it located at:</p>
									<code>application/views/welcome_message.php</code>

									<p>The corresponding controller for this page is found at:</p>
									<code>application/controllers/Welcome.php</code>

									<p>If you are exploring CodeIgniter for the very first time, you should start by reading the <a href="user_guide/">User Guide</a>.</p>
									<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
