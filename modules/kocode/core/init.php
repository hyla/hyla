<?php defined('SYSPATH') or die('No direct script access.');

$enabled = Sprig::factory('module', array('enabled' => 1))
	->load(NULL, FALSE);

$modules = Kohana::modules();
foreach ($enabled as $mod)
{
	$modules[$mod->name] = MODPATH.'kocode/'.$mod->name;
}
Kohana::modules($modules);

// Clean up
unset($modules, $enabled);

Route::set('project/crud', 'projects(/<name>)/<action>', array('action' => '(?:create|update|delete)'))
	->defaults(array(
		'controller' => 'projects',
	));

Route::set('project', 'projects(/<name>)')
	->defaults(array(
		'controller' => 'projects',
	));
