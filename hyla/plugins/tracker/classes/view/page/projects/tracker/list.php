<?php defined('SYSPATH') or die('No direct script access.');

class View_Page_Projects_Tracker_List extends Abstract_View_Page_Project {

	protected $_cached = array(
		'tickets' => NULL,
	);

	public function tickets()
	{
		if ($this->_cached['tickets'] !== NULL)
			return $this->_cached['tickets'];

		$tickets = Couch_Model::factory('ticket', $this->couchdb)
			->find_all(TRUE);

		$data = array();
		foreach ($tickets as $ticket)
		{
			$item = (array) $ticket;
			$item['url'] = Route::url('hyla-tracker', array(
				'slug'   => $this->project->get('slug'),
				'action' => 'view',
				'ticket' => $item['_id'],
			));

			$data[] = $item;
		}

		return $this->_cached['tickets'] = $data;
	}

	public function urls()
	{
		return array(
			'new-ticket' => Route::url('hyla-tracker', array(
				'slug'   => $this->project->get('slug'),
				'action' => 'new',
			)),
		);
	}
}