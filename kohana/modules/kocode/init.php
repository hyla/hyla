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

Route::set('kocode-admin', 'admin(/<controller>(/<action>(/<id>)))')
	->defaults(array(
		'controller'	=> 'main',
		'directory'		=> 'admin',
	));

Route::set('kocode-main', '(<controller>(/<action>(/<id>)))')
	->defaults(array(
		'controller' => 'main',
	));
