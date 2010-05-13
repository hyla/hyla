<?php if ($errors): ?>
<div class="error"><?php echo __('Login Failed'); ?></div>
<?php endif; ?>
<?php echo Form::open(); ?>
<fieldset>
	<legend><?php echo __('Registration'); ?></legend>
	<label for="username"><?php echo __('Username'); ?></label>
	<input type="text" name="username" id="username" />
	<label for="email"><?php echo __('Email'); ?></label>
	<input type="text" name="email" id="email" />
	<label for="password"><?php echo __('Password'); ?></label>
	<input type="password" name="password" id="password" />
	<label for="password_confirm"><?php echo __('Re-Type Password'); ?></label>
	<input type="password" name="password_confirm" id="password_confirm" />
</fieldset>
<button type="submit" value="submit"><?php echo __('Login'); ?></button>
<?php echo Form::close(); ?>