<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Page_Admin_Plugins extends Controller_Hyla_Page
{
	public function action_index()
	{
		$this->view
			->bind('plugins', $plugins);
	}
}
