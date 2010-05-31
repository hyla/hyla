<?php if ($errors): ?>
<div class="error">
		<p class="message">Registration Failed</p>
		<ul class="errors">
		<?php foreach ($errors as $message): ?>
	    <li><?php echo $message ?></li>
		<?php endforeach ?>
</div>
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
<button type="submit" value="submit"><?php echo __('Register'); ?></button>
<?php echo Form::close(); ?>