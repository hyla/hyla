<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Page_Projects_Tracker extends Abstract_Controller_Hyla_Page {

	public function action_home()
	{
		$this->view
			->bind('project', $project);

		$config = Kohana::config('couchdb');
		$project = Couch_Model::factory('project', new Sag($config->host, $config->port))
			->find_by_slug($this->request->param('slug'));

		if ( ! $project->loaded())
			throw new HTTP_Exception_404;
	}
}