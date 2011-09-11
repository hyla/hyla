<?php defined('SYSPATH') or die('No direct script access.');

class View_Page_Projects_Tracker_View extends Abstract_View_Page_Project {

	public function update_url()
	{
		if ( ! $this->auth->can('updateTicket'))
			return NULL;

		return $this->ticket['update_url'];
	}
}