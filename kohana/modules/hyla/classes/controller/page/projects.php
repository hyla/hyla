<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Page_Projects extends Abstract_Controller_Hyla_Page {

	public function action_list()
	{
		$this->view
			->bind('projects', $projects);

		$projects = array();
	}
}