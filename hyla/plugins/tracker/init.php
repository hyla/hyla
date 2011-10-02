<?php defined('SYSPATH') or die('No direct script access.');

Route::set('hyla/tickets', 'projects/<slug>/tickets(/<action>(/<ticket>))')
	->defaults(array(
		'directory'  => 'page/tracker',
		'controller' => 'tickets',
		'action'     => 'list',
	));

Route::set('hyla/api/tickets', 'api/tickets(/<id>)')
	->callback(function($route, $uri, $params, $request) {
		$params['action'] = Valid::not_empty($params['id'])
			? 'ticket'
			: 'collection';

		return $params;
	})
	->callback('API_Router::prefix_request_method')
	->defaults(array(
		'directory'  => 'api/tracker',
		'controller' => 'tickets',
		// Just here so I can be sure they are set in the callbacks
		'action'     => NULL,
		'id'         => NULL,
	));