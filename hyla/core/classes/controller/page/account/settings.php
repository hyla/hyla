<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Page_Account_Settings extends Abstract_Controller_Hyla_Page {

	public function action_home() {}
	public function action_notifications()
	{
		$this->view
			->bind('errors', $errors)
			->bind('values', $values);

		if ($values = $this->request->post())
		{
			// Update the user notifications settings using the API
			$request = Request::factory(Route::get('hyla/api/accounts/notification-settings')
				->uri(array('id' => $this->auth->get('_id'))))
				->method(Request::PUT)
				->body(json_encode(Arr::get($values, 'notification-settings', array())));

			$response = $this->oauth_client->execute($request);

			$this->request->redirect($this->request->uri());
		}
	}
}