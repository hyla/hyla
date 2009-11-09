<div class="project edit">

	<h1><?php echo $project->loaded() ? 'Update' : 'Create' ?> Project</h1>
	<?php echo Form::open() ?>

	<?php include Kohana::find_file('views', 'errors') ?>

	<dl>
	<?php foreach ($project->inputs() as $label => $input): ?>
		<dt><?php echo $label ?></dt>
		<dd><?php echo $input ?></dd>

	<?php endforeach ?>
	</dl>
	<p class="submit"><?php echo Form::button(NULL, 'Save', array('type' => 'submit')) ?></p>
	<?php echo Form::close() ?>

</div>