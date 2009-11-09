<?php if ( ! empty($errors)): ?>
<ul class="errors">
<?php foreach ($errors as $message): ?>
	<li><?php echo $message ?></li>
<?php endforeach ?>
</ul>
<?php endif ?>
