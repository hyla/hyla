<?php
/**
 * Admin Template
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>KoCode - Admin Panel</title>

<?php echo Assets::instance()->render(); ?>

</head>

<body>
    <div class="container_16" id="main_frame">
		<div class="grid_16 section header">
			<h1>KoCode</h1>
		</div>
		<div class="grid_16">
			<?php echo $content; ?>
		</div>
		
		<div class="clear"></div>
    </div>

	<div id="kohana-profiler">
	<?php echo View::factory('profiler/stats') ?>
	</div>
</body>
</html>