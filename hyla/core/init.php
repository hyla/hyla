<?php defined('SYSPATH') or die('No direct script access.');

Route::set('installer', 'installer(/<action>)')
	->defaults(array(
		'directory'  => 'page',
		'controller' => 'installer',
		'action'     => 'home',
	));

Route::set('hyla/home', '')
	->defaults(array(
		'directory'  => 'page',
		'controller' => 'main',
		'action'     => 'home',
	));

Route::set('hyla/log_in', 'log_in/<action>', array('action' => 'github|hyla'))
	->defaults(array(
		'directory'  => 'page',
		'controller' => 'authentication',
		'action'     => 'github',
	));

Route::set('hyla/log_out', 'log_out')
	->defaults(array(
		'directory'  => 'page',
		'controller' => 'authentication',
		'action'     => 'log_out',
	));

Route::set('hyla/account-settings', 'account/settings(/<action>)')
	->defaults(array(
		'directory'  => 'page/account',
		'controller' => 'settings',
		'action'     => 'home',
	));

Route::set('hyla/projects', 'projects(/<action>)', array('action' => 'create'))
	->defaults(array(
		'directory'  => 'page',
		'controller' => 'projects',
		'action'     => 'list',
	));

Route::set('hyla/single-project', 'projects/<slug>/<action>')
	->defaults(array(
		'directory'  => 'page',
		'controller' => 'projects',
	));

Route::set('hyla/oauth-endpoints', 'oauth2/endpoints/<action>')
	->defaults(array(
		'directory'  => 'page/oauth2',
		'controller' => 'endpoints',
	));

Route::set('hyla/api', 'api')
	->callback('API_Router::prefix_request_method')
	->defaults(array(
		'directory'  => 'api',
		'controller' => 'main',
	));

Route::set('hyla/api/projects', 'api/projects(/<id>)')
	->callback(function($route, $uri, $params, $request) {
		$params['action'] = Valid::not_empty($params['id'])
			? 'project'
			: 'collection';

		return $params;
	})
	->callback('API_Router::prefix_request_method')
	->defaults(array(
		'directory'  => 'api',
		'controller' => 'projects',
		'action'     => 'projects',
		'id'         => NULL,
	));

Route::set('hyla/api/accounts/notification-settings', 'api/accounts/<id>/notification-settings')
	->callback('API_Router::prefix_request_method')
	->defaults(array(
		'directory'  => 'api/accounts/settings',
		'controller' => 'notifications',
		'action'     => 'notifications',
	));