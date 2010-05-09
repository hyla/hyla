<?php if ($errors): ?>
<div class="error"><?php echo __('Registration Failed'); ?></div>
<?php endif; ?>
<?php echo Form::open(); ?>
<fieldset>
	<legend><?php echo __('Registration'); ?></legend>
	<ul>
	<li><label for="username"><?php echo __('Username'); ?></label>
	<input type="text" name="username" id="username" /></li>
	<li><label for="email"><?php echo __('Email'); ?></label>
	<input type="text" name="email" id="email" /></li>
	<li><label for="password"><?php echo __('Password'); ?></label>
	<input type="text" name="password" id="password" /></li>
	<li><label for="password_confirm"><?php echo __('Confirm Password'); ?></label>
	<input type="text" name="password_confirm" id="password_confirm" /></li>
	</ul>
</fieldset>
<button type="submit" value="submit"><?php echo __('Login'); ?></button>
<?php echo Form::close(); ?>