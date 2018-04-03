

<div class="register-box">
	<div class="register-logo">
		<a href="#"><b>Admin</b>LTE</a>
	</div>
	<div class="register-box-body">
		<p class="register-box-msg"><?php echo lang('signup_title'); ?></p>

		<form action="../../index2.html" method="post">
			<div class="form-group has-feedback">
				<input type="text" class="form-control" placeholder="Nickname">
				<span class="glyphicon glyphicon-user form-control-feedback"></span>
			</div>
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
							<input type="checkbox" class="signup-terms"> <?php echo lang('signup_terms'); ?>
						</label>
					</div>
				</div>
				<div class="col-sm-4">
					<button type="submit" class="btn btn-primary btn-block btn-flat"><?php echo lang('signup_register'); ?></button>
				</div>
			</div>
		</form>

		<div class="social-auth-links text-center">
			<p>- OR -</p>
		</div>

		<a href="<?php echo base_url('login'); ?>" class="text-center"><?php echo lang('signup_login'); ?></a>

	</div>
</div>
