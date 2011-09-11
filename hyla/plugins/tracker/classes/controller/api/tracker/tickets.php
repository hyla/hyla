<?php defined('SYSPATH') or die('No direct script access.');

class Controller_API_Tracker_Tickets extends Abstract_Controller_Hyla_API {

	public function action_get_collection() {}
	public function action_get_ticket()
	{
		$this->view
			->bind('ticket', $ticket);

		$ticket = Couch_Model::factory('ticket', $this->couchdb)
			->find($this->request->param('id'));

		if ( ! $ticket->loaded())
			throw new HTTP_Exception_404;
	}
	public function action_put_ticket() {}
	public function action_delete_ticket()
	{
		$ticket = Couch_Model::factory('ticket', $this->couchdb)
			->find($this->request->param('id'));
		if ( ! $ticket->loaded())
			throw new HTTP_Exception_404;

		if ( ! $this->auth->can('deleteTicket', array('ticket' => $ticket)))
			throw new HTTP_Exception_404;

		$ticket->delete();
	}
}