<?php defined('SYSPATH') or die('No direct script access.');

class View_Page_Projects_Tracker_View extends Abstract_View_Page_Project {

	public function ticket()
	{
		return View_Model::factory($this->ticket);
	}
}