<?php defined('SYSPATH') or die('No direct script access.');

class API_Router {

	public static function route_method(Route $route, $uri, $params, Request $request)
	{
		return array(
			'action' => strtolower($request->method().'_'.$params['action'])
		) + $params;
	}
}