<?php defined('SYSPATH') or die('No direct script access.');

class View_Page_Projects_List extends Abstract_View_Page {

	protected $_cached = array(
		'projects' => NULL,
	);

	public function projects()
	{
		if ($this->_cached['projects'] !== NULL)
			return $this->_cached['projects'];

		$config = Kohana::config('couchdb');
		return Couch_Model::factory('project', new Sag($config->host, $config->port))
			->find_all(TRUE);
	}

	public function has_projects()
	{
		return (bool) count($this->projects());
	}
}