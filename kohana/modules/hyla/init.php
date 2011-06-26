<?php defined('SYSPATH') or die('No direct script access.');

Route::set('hyla/home', '')
	->defaults(array(
		'directory'  => 'hyla',
		'controller' => 'main',
		'action'     => 'home',
	));

Route::set('hyla/project', 'project(/<action>)', array('action' => '(?:list|create)'))
	->defaults(array(
		'directory'  => 'page',
		'controller' => 'project',
		'action'     => 'list',
	));

Route::set('hyla/project/crud', 'project/<name>(/<action>)', array('action' => '(?:details|home|delete|archive)'))
	->defaults(array(
		'directory'  => 'page',
		'controller' => 'project',
		'action'     => 'home',
	));
