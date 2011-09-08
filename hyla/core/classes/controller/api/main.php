<?php defined('SYSPATH') or die('No direct script access.');

class Controller_API_Main extends Controller_API {

	public function action_test()
	{
		$this->_response_payload = array(
			'foo' => 'Hello',
			'bar' => 'World',
		);
	}
}