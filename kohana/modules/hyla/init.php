<?php defined('SYSPATH') or die('No direct script access.');

//$enabled = Sprig::factory('plugin', array('enabled' => 1))
//	->load(NULL, FALSE);

$modules = Kohana::modules();
//foreach ($enabled as $plugin)
//{
//	$modules[$plugin->name] = DOCROOT.'hyla/plugins/'.$plugin->name;
//}
Kohana::modules($modules);

// Clean up
unset($modules, $enabled);

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

Route::set('project/crud', 'project/<name>(/<action>)', array('action' => '(?:home|delete|archive)'))
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

Route::set('account', 'account(/<action>)', array('action' => '(?:login|register)'))
	->defaults(array(
		'controller' => 'account',
		'action'     => 'login',
	));

Route::set('hyla-main', '(<controller>(/<action>(/<id>)))')
	->defaults(array(
		'controller' => 'main',
	));
