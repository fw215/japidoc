

<div class="login-box">
	<div class="login-logo">
		<a href="#"><b><?php echo lang('app_title'); ?></b></a>
	</div>
	<div class="login-box-body">
		<p class="login-box-msg"><?php echo lang('login_title'); ?></p>

		<form action="<?php echo base_url('login'); ?>" method="post">
			<div class="form-group has-feedback">
				<input type="email" class="form-control" placeholder="Email">
				<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
			</div>
			<div class="form-group has-feedback">
				<input type="password" class="form-control" placeholder="Password">
				<span class="glyphicon glyphicon-lock form-control-feedback"></span>
			</div>
			<div class="row">
				<div class="col-sm-8">
					<div class="checkbox icheck">
						<label>
							<input type="checkbox" class="remember-me"> <?php echo lang('login_remember_me'); ?>
						</label>
					</div>
				</div>
				<div class="col-sm-4">
					<button type="submit" class="btn btn-primary btn-block btn-flat"><?php echo lang('login_signin'); ?></button>
				</div>
			</div>
		</form>

		<div class="social-auth-links text-center">
			<p>- OR -</p>
		</div>

		<a href="<?php echo base_url('signup'); ?>" class="text-center"><?php echo lang('login_signup'); ?></a>

	</div>
</div>
