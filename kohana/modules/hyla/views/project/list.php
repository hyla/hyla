
<div class="box">
<?php if( ! count($projects)): ?>

	<p>You have no projects</p>
	<?php
$source = '$foo = 45;
	for ( $i = 1; $i < $foo; $i++ ){
		echo "$foo\n";  --$foo;
	}';
	$language = 'php';

	$geshi = new GeSHi($source, $language);
	$geshi->enable_line_numbers(GESHI_FANCY_LINE_NUMBERS, 2);
	$geshi->set_line_style('background: #fcfcfc;', 'background: #f0f0f0;');
	
	echo $geshi->parse_code();

	       ?>

<?php else: ?>
	<?php foreach($projects as $project): ?>

	<ul id="project_list">
		<li>
			<h3><?php echo HTML::anchor(Route::get('project/crud')
							->uri(array('name' => $project->name)), $project->name) ?></h3>
			<p class="project_description">
				<?php echo Text::auto_p(Text::auto_link($project->description)) ?>
			<p>
		</li>
	</ul>

	<?php endforeach; ?>
<?php endif; ?>

</div>

