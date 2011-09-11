<?php defined('SYSPATH') or die('No direct script access.');

class View_API_Tracker_Tickets_Get_Ticket extends Abstract_View_API {

	public function ticket()
	{
		return View_Model::factory($this->ticket)->as_array();
	}
}