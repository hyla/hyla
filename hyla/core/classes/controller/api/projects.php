<?php defined('SYSPATH') or die('No direct script access.');

class Controller_API_Projects extends Abstract_Controller_Hyla_API {

	public function action_get_collection() {}
	public function action_get_project() {}
	public function action_put_project()
	{
		$this->view
			->bind('project', $project);

		$project = $this->di_container->get('couch_model.project')
			->find($this->request->param('id'));

		$values = json_decode($this->request->body(), TRUE);

		$project->values($values, array('name', 'slug', 'description'));
		$project->update();
	}
	public function action_delete_project()
	{
		$project = $this->di_container->get('couch_model.project')
			->find($this->request->param('id'))
			->delete();
	}
}