<?php defined('SYSPATH') or die('No direct script access.');

class View_Page_Tracker_Tickets_List extends Abstract_View_Page_Project {

	protected $_cached = array(
		'tickets' => NULL,
	);

	public function tickets()
	{
		if ($this->_cached['tickets'] !== NULL)
			return $this->_cached['tickets'];

		$request = Request::factory(Route::get('hyla/api/tickets')->uri())
			->query(array(
				'project' => $this->project->get('_id'),
			));
		$response = $this->oauth_client->execute($request);
		$body = json_decode($response->body(), TRUE);
		$tickets = $body['collection'];

		return $this->_cached['tickets'] = $tickets;
	}

	public function can_create_ticket()
	{
		return $this->auth->can('createTicket');
	}

	public function urls()
	{
		return array(
			'new-ticket' => Route::url('hyla/tickets', array(
				'slug'   => $this->project->get('slug'),
				'action' => 'new',
			)),
		);
	}
}