<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<title></title>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />

	<?php echo Assets::instance()->render(); ?>
</head>
<body>
	<div class="clearfix" id="header-container">
		<div id="header" class="container_12">
			<div class="grid_8">
				<h1>Site title here</h1>
			<?php if(isset($active_project)): ?>
				<span class="divider">/</span>
				<h1><?php echo $active_project->name; ?></h1>
			<?php endif; ?>
			</div>
			<div id="user-box" class="grid_4">
				Hello Guest
			</div>
		</div>
	</div>
	<div id="menu-container" class="clearfix">
		<div id="menu" class="clearfix container_12">
			<ul class="grid_12 horizontal-menu">
				<li><a class="active" href="#">Dashboard</a></li>
				<li><a href="#">Projects</a></li>
				<li><a href="#">Users</a></li>
			</ul>
		</div>
	</div>
	<div class="clearfix" id="info-container">
		<div id="info" class="clearfix container_12">
			<h2 id="page-title" class="grid_7"><?php echo isset($page_title) ? $page_title : 'Page title not set...'; ?></h2>
			<div class="grid_5 clearfix">
				<ul class="horizontal-menu clearfix">
					<li><a class="active" href="#">Overview</a></li>
					<li><a href="#">Activity</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="clearfix" id="main-container">
		<div class="container_12 clearfix" id="main">
