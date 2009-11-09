<?php

$route = Route::get('project');

?>
<div class="project list">
	<dl>
	<?php foreach ($projects as $project): ?>
		<dt><?php echo HTML::anchor($route->uri(array('name' => $project->name)), $project->name) ?></dt>
		<dd><?php echo Text::auto_p(Text::auto_link($project->description)) ?></dd>

	<?php endforeach ?>
	</dl>
</div>
