<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Page_Main extends Abstract_Controller_Hyla_Page {

	public function action_home() {
		$oauth_client = OAuth2_Consumer::factory('web', OAuth2::GRANT_TYPE_CLIENT_CREDENTIALS);

		$request = Request::factory('api/test');

		// Execute the request, via the client.
		$response = json_decode($oauth_client->execute($request));
		echo Debug::vars($response);
	}
}