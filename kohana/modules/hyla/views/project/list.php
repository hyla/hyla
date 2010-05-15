
<div class="box">
<?php if( ! count($projects)): ?>

	<p>You have no projects</p>

<?php else: ?>
	<?php foreach($projects as $project): ?>

	<ul id="project_list">
		<li>
			<h3><?php echo HTML::anchor(Route::get('project/crud')
							->uri(array('name' => $project->name, 'action' => 'details')), $project->name) ?></h3>
			<div class="project_description">
				<?php echo Text::auto_p(Text::auto_link($project->description)) ?>
			<div>
		</li>
	</ul>

	<?php endforeach; ?>
<?php endif; ?>

</div>

