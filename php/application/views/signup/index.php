

<div class="register-box">
	<div class="register-logo">
		<a href="#"><b><?php echo lang('app_title'); ?></b></a>
	</div>
	<div class="register-box-body">
		<p class="register-box-msg"><?php echo lang('signup_title'); ?></p>

		<form action="<?php echo base_url('signup'); ?>" method="post">
			<div class="form-group has-feedback<?php if(isset($errors['nickname'])): ?> has-error<?php endif; ?>">
				<input type="text" class="form-control" placeholder="<?php echo lang('users_nickname'); ?>" name="nickname" value="<?php if(isset($data['nickname'])): echo html_escape($data['nickname']); endif; ?>">
				<span class="glyphicon glyphicon-user form-control-feedback"></span>
				<span class="help-block"><?php if(isset($errors['nickname'])): echo $errors['nickname']; endif; ?></span>
			</div>

			<div class="form-group has-feedback<?php if(isset($errors['email'])): ?> has-error<?php endif; ?>">
				<input type="text" class="form-control" placeholder="<?php echo lang('users_email'); ?>" name="email" value="<?php if(isset($data['email'])): echo html_escape($data['email']); endif; ?>">
				<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
				<span class="help-block"><?php if(isset($errors['email'])): echo $errors['email']; endif; ?></span>
			</div>

			<div class="form-group has-feedback<?php if(isset($errors['password'])): ?> has-error<?php endif; ?>">
				<input type="password" class="form-control" placeholder="<?php echo lang('users_password'); ?>" name="password">
				<span class="glyphicon glyphicon-lock form-control-feedback"></span>
				<span class="help-block"><?php if(isset($errors['password'])): echo $errors['password']; endif; ?></span>
			</div>

			<div class="row">
				<div class="col-sm-8">
					<div class="form-group checkbox icheck<?php if(isset($errors['terms'])): ?> has-error<?php endif; ?>">
						<label>
							<input type="checkbox" class="signup-terms" name="terms" value="terms"<?php if(isset($data['terms'])): ?> checked="checked"<?php endif; ?>> <?php echo lang('signup_terms'); ?>
						</label>
						<span class="help-block"><?php if(isset($errors['terms'])): echo $errors['terms']; endif; ?></span>
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
