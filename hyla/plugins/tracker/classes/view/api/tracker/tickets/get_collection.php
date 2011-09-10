<?php defined('SYSPATH') or die('No direct script access.');

class View_API_Tracker_Tickets_Get_Collection extends Abstract_View_API {

	public function collection()
	{
		return Couch_Model::factory('ticket', $this->couchdb)
			->find_all(TRUE);
	}
}