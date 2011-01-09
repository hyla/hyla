<?php defined('SYSPATH') or die('No direct script access.');

Route::set('hyla-admin', 'admin(/<controller>(/<action>(/<id>)))')
	->defaults(array(
		'controller' => 'main',
		'directory'  => 'admin',
	));

Route::set('project/general', 'project(/<action>)', array('action' => '(?:list|create)'))
	->defaults(array(
		'controller' => 'project',
		'action'     => 'list',
	));

Route::set('project/crud', 'project/<name>(/<action>)', array('action' => '(?:details|home|delete|archive)'))
	->defaults(array(
		'controller' => 'project',
		'action'     => 'home',
	));

Route::set('project/settings', 'project/<name>/settings(/<action>)', array('action' => '(?:main|members)'))
	->defaults(array(
		'directory'  => 'project',
		'controller' => 'settings',
		'action'     => 'main',
	));

Route::set('hyla-main', '(<controller>(/<action>(/<id>)))')
	->defaults(array(
		'controller' => 'main',
	));
