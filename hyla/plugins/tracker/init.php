<?php defined('SYSPATH') or die('No direct script access.');

Route::set('hyla-tracker', 'projects/<slug>/tracker(/<action>(/<ticket>))')
	->defaults(array(
		'directory'  => 'page/projects',
		'controller' => 'tracker',
		'action'     => 'list',
	));

Route::set('hyla/api/tickets', 'api/tickets(/<id>)', array('id' => '\d'))
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
		'action'     => NULL,
		'id'         => NULL,
	));