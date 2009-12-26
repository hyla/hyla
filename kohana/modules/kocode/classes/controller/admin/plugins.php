<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Plugins extends Controller_Template_Kocode_Admin {

	public function action_index()
	{
		$this->template->content = View::factory('admin/plugins/list')
			->bind('plugins', $plugins);

		$plugins = Sprig::factory('plugin')->load(NULL, FALSE);
	}

} // End Admin Plugins
