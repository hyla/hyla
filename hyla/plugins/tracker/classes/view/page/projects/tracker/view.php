<?php defined('SYSPATH') or die('No direct script access.');

class View_Page_Projects_Tracker_View extends Abstract_View_Page_Project {

	public function ticket()
	{
		return View_Model::factory($this->ticket);
	}

	public function update_url()
	{
		if ( ! $this->auth->can('updateTicket'))
			return NULL;

		return Route::url('hyla-tracker', array(
			'action' => 'update',
			'slug'   => $this->project->get('slug'),
			'ticket' => $this->ticket->get('_id'),
		));
	}
}