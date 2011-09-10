<?php defined('SYSPATH') or die('No direct script access.');

class View_API_Tracker_Tickets_Get_Collection extends Abstract_View_API {

	public function collection()
	{
		$tickets = Couch_Model::factory('ticket', $this->couchdb)
			->find_all();

		$data = array();
		foreach ($tickets as $ticket)
		{
			$ticket = View_Model::factory($ticket);
			$item = $ticket->document();
			$item['url'] = $ticket->url();
			$item['created_on_date_time'] = $ticket->created_on_date_time();
			$item['updated_on_date_time'] = $ticket->updated_on_date_time();

			$data[] = $item;
		}

		return $data;
	}
}