<?php defined('SYSPATH') or die('No direct script access.');

Route::set('hyla-tracker', 'projects/<slug>/tracker(/<action>(/<ticket>))')
	->defaults(array(
		'directory'  => 'page/projects',
		'controller' => 'tracker',
		'action'     => 'list',
	));