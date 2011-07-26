<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Page_Projects_Tracker extends Abstract_Controller_Hyla_Page {

	public function action_list()
	{
		$this->view
			->bind('project', $project);

		$project = Couch_Model::factory('project', $this->couchdb)
			->find_by_slug($this->request->param('slug'));

		if ( ! $project->loaded())
			throw new HTTP_Exception_404;
	}

	public function action_new()
	{
		$this->view
			->bind('project', $project)
			->bind('ticket', $ticket)
			->bind('values', $values)
			->bind('errors', $errors);

		$project = Couch_Model::factory('project', $this->couchdb)
			->find_by_slug($this->request->param('slug'));

		if ( ! $project->loaded())
			throw new HTTP_Exception_404;

		if ($this->request->post())
		{
			$values = $this->request->post();

			try
			{
				$ticket = Couch_Model::factory('ticket', $this->couchdb);
				$ticket->values($values, array('title', 'description'));
				$ticket->create();

				$this->request->redirect(Route::url('hyla-tracker', array(
					'slug' => $project->get('slug'),
				)));
			}
			catch (Validation_Exception $e)
			{
				$errors = $e->array->errors('validation');
			}
		}
	}
}