<?php defined('SYSPATH') or die('No direct script access.');

class View_Page_Tracker_Tickets_View extends Abstract_View_Page_Project {

	public function update_url()
	{
		if ( ! $this->auth->can('updateTicket'))
			return NULL;

		return $this->ticket['update_url'];
	}

	public function delete_form()
	{
		if ( ! $this->auth->can('deleteTicket'))
			return NULL;

		$yform = YForm::factory();

		return array(
			'open'        => $yform->open($this->ticket['delete_url']),
			'submit'      => $yform->submit('delete'),
			'close'       => $yform->close(),
		);
	}
}