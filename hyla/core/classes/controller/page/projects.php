<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Page_Projects extends Abstract_Controller_Hyla_Page {

	public function action_list() {}

	public function action_home()
	{
		$this->view
			->bind('project', $project);

		$project = $this->di_container->get('couch_model.project')
			->find_by_slug($this->request->param('slug'));

		if ( ! $project->loaded())
			throw new HTTP_Exception_404;
	}

	public function action_create()
	{
		$this->view
			->bind('values', $values)
			->bind('errors', $errors);

		if ($this->request->post())
		{
			$values = $this->request->post();

			try
			{
				$project = $this->di_container->get('couch_model.project');
				$project->values($values, array('name', 'slug', 'description'));
				$project->create();

				$this->request->redirect(Route::url('hyla/projects'));
			}
			catch (Validation_Exception $e)
			{
				$errors = $e->array->errors('validation');
			}
		}
	}
}