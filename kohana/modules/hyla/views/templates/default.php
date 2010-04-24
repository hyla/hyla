<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>Hyla - The Froggy Project Manager</title>

		<?php echo Assets::instance()->render(); ?>

	</head>
	<body>
	<div class="container_12 ui-corner-bottom">
			<div class="grid_12">
				<div class="grid_4 " style="float:right;" id="account_links">
					<ul class="nav ui-corner-bl">
						<li><a href="#">Home</a></li>
						<li><a href="#">Account Settings</a></li>
						<li><a href="#">Logout</a></li>
					</ul>
				</div>
				<h1 id="branding">
					<?php echo HTML::image('hyla/themes/default/media/images/hyla.png', array('alt' => 'Hyla Project Manager')); ?>
				</h1>
			</div>

			<div class="clear"></div>
			<div class="grid_12 ui-tabs ui-widget ui-widget-content ui-corner-all"  id="tabs">
				<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
					<li class="ui-state-default ui-corner-top">
						<a href="#tabs-1">Latest News</a>
					</li>
					<li class="ui-state-default ui-corner-top ui-tabs-selected ui-state-active">
						<a href="#tabs-2">Projects</a>
					</li>
				</ul>
				<div class="grid_12 ui-tabs-panel ui-widget-content ui-corner-bottom" id="tabs-1">

				<?php echo $content; ?>

				</div>
			</div>

			<div class="clear"></div>

			<div class="grid_12 ui-corner-bottom" id="site_info">
				<div class="box">
					<p>Should something go down here...?</p>
				</div>
			</div>
			<div class="clear"></div>
		</div>

	</body>
</html>
