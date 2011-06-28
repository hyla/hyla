<?php defined('SYSPATH') or die('No direct script access.');

class View_Page_Main_Home extends Abstract_View_Page {

	public function projects()
	{
		return Couch_Model::factory('project', new Sag)
			->find_all(TRUE);
	}
}