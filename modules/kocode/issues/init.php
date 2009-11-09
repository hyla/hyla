<?php defined('SYSPATH') or die('No direct script access.');

Route::set('issue', 'issues(/<id>)')
	->defaults(array(
		'controller' => 'issues',
		'action'     => 'detail',
	));

Route::set('project/issues', 'projects/<name>/issues')
	->defaults(array(
		'controller' => 'issues',
	));

