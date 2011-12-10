<?php defined('SYSPATH') or die('No direct script access.');

class View_API_Projects_Get_Project extends Abstract_View_API {

	public function ok()
	{
		return TRUE;
	}

	public function project()
	{
		return Couch_Model::factory('project', $this->couchdb)
			->find($this->params['id'])
			->document();
	}
}