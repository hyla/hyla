<?php defined('SYSPATH') or die('No direct script access.');

class View_API_Accounts_Settings_Notifications_Put_Notifications extends Abstract_View_API {

	public function ok()
	{
		return TRUE;
	}

	public function notification_settings()
	{
		return $this->user->get('notification-settings');
	}
}