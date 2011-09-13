<?php defined('SYSPATH') or die('No direct script access.');

class Controller_API_Accounts_Settings_Notifications extends Abstract_Controller_Hyla_API {

	public function action_get_collection() {}
	public function action_get_notifications() {}
	public function action_put_notifications()
	{
		$this->view
			->bind('user', $user);

		$user = Couch_Model::factory('user', $this->couchdb)
			->find($this->request->param('id'));

		$notification_settings = array();

		foreach ($this->_request_payload as $notification => $notifiers)
		{
			$notifiers = array_keys($notifiers);
			$notification_settings[$notification] = $notifiers;
		}

		$user->set('notification-settings', $notification_settings);
		$user->update();
	}
}