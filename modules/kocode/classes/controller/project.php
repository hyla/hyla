<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Project extends Controller_Website {

	public function action_list()
	{
		$this->template->content = View::factory('project/list');
	}
}