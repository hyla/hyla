<?php
/**
 * Admin Template
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>KoCode - Admin Panel</title>
</head>

<body>
    <?php echo $content; ?>

	<div id="kohana-profiler">
	<?php echo View::factory('profiler/stats') ?>
	</div>
</body>
</html>