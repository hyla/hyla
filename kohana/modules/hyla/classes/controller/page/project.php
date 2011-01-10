<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Page_Project extends Controller_Hyla_Page
{
	public function action_list()
	{
		$this->view
			->bind('projects', $projects);

		$projects = array();
	}

	public function action_details()
	{
		$this->view
			->bind('project', $project);

		$name = $this->request->param('name');
		$project = ORM::factory('project')
			->where('name', '=', $name)
			->find();

		if ( ! $project->loaded())
		{
			$this->request->redirect(Route::get('hyla-main')->uri(array
				(
					'controller' => 'project',
				)));
		}
	}

	public function action_create()
	{
		$this->view
			->bind('project', $project)
			->bind('errors', $errors);

		$project = ORM::factory('project');

		if ($_POST)
		{
			try
			{
				$project->values($_POST, array('name', 'title', 'description'));
				$project->create();

				$this->request->redirect(Route::get('hyla-main')
					->uri(array
					(
						'controller' => 'project',
						'action'     => 'details',
						'id'         => $project->name
					)));
			}
			catch (ORM_Validation_Exception $e)
			{
				$errors = $e->object->errors('project/edit');
			}
		}
	}

	public function action_update()
	{
		$this->view
			->bind('project', $project)
			->bind('errors', $errors);

#		$project = Sprig::factory('project', array('name' => $this->request->param('name')))
#			->load();

		if ( ! $project->loaded())
		{
			$this->request->redirect($this->request->uri(array('action' => 'create')));
		}

		if ($_POST)
		{
			try
			{
				$project->values($_POST)->update();

				$this->request->redirect(Route::get('project')->uri(array('name' => $project->name)));
			}
			catch (Validate_Exception $e)
			{
				$errors = $e->array->errors('project/edit');
			}
		}
	}
}
