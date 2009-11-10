<?php defined('SYSPATH') or die('No direct script access.');

Route::set('project/browser', 'projects/<name>/browser')
	->defaults(array(
		'controller' => 'browser',
	));

