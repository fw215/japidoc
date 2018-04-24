

<div class="login-box">
	<div class="login-logo">
		<a href="#"><b><?= lang('app_title'); ?></b></a>
	</div>
	<div class="login-box-body">
		<p class="login-box-msg"><?= lang('login_title'); ?></p>

		<form action="<?= base_url('login'); ?>" method="post">
			<input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash(); ?>" />
			<div class="form-group has-feedback<?php if(isset($errors['email'])): ?> has-error<?php endif; ?>">
				<input type="text" class="form-control" name="email" placeholder="<?= lang('users_email'); ?>" value="<?php if(isset($data['email'])): echo html_escape($data['email']); endif; ?>">
				<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
				<span class="help-block"><?php if(isset($errors['email'])): echo $errors['email']; endif; ?></span>
			</div>
			<div class="form-group has-feedback<?php if(isset($errors['password'])): ?> has-error<?php endif; ?>">
				<input type="password" class="form-control" name="password" placeholder="<?= lang('users_password'); ?>">
				<span class="glyphicon glyphicon-lock form-control-feedback"></span>
				<span class="help-block"><?php if(isset($errors['password'])): echo $errors['password']; endif; ?></span>
			</div>
			<div class="row">
				<div class="col-sm-8">
					<div class="checkbox icheck">
						<label>
							<input type="checkbox" class="remember-me" name="remember_me"> <?= lang('login_remember_me'); ?>
						</label>
					</div>
				</div>
				<div class="col-sm-4">
					<button type="submit" class="btn btn-primary btn-block btn-flat"><?= lang('login_signin'); ?></button>
				</div>
			</div>
		</form>

		<div class="social-auth-links text-center">
			<p>- OR -</p>
		</div>

		<a href="<?= base_url('signup'); ?>" class="text-center"><?= lang('login_signup'); ?></a>

	</div>
</div>
