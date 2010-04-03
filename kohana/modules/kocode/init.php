<?php defined('SYSPATH') or die('No direct script access.');

//$enabled = Sprig::factory('plugin', array('enabled' => 1))
//	->load(NULL, FALSE);

$modules = Kohana::modules();
//foreach ($enabled as $plugin)
//{
//	$modules[$plugin->name] = DOCROOT.'kocode/plugins/'.$plugin->name;
//}
Kohana::modules($modules);

// Clean up
unset($modules, $enabled);

Route::set('admin', 'admin(/<controller>(/<action>(/<id>)))')
	->defaults(array(
		'controller'	=> 'main',
		'action'		=> 'index',
		'directory'		=> 'admin',
	));

	
Route::set('project/crud', 'projects(/<name>)/<action>', array('action' => '(?:delete)'))
	->defaults(array(
		'controller' => 'projects',
	));

Route::set('project/general', 'projects/<name>(/<controller>(/<action>))')
	->defaults(array(
		'directory'		=> 'projects',
		'controller' 	=> 'main',
	));
