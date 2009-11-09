<div class="project list">
	<p><?php echo HTML::anchor(Route::get('project/crud')->uri(array('action' => 'create')), 'New Project') ?></p>

	<dl>
	<?php foreach ($projects as $project): ?>
		<dt><?php echo HTML::anchor(Route::get('project')->uri(array('name' => $project->name)), $project->name) ?></dt>
		<dd><?php echo Text::auto_p(Text::auto_link($project->description)) ?></dd>

	<?php endforeach ?>
	</dl>
</div>
