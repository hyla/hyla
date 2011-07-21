<?php defined('SYSPATH') or die('No direct script access.');

Route::set('tracker/home', 'projects/<slug>/tracker')
	->defaults(array(
		'directory'  => 'page/projects',
		'controller' => 'tracker',
		'action'     => 'home',
	));