<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Project extends Controller_Template_Hyla {

	public function action_list()
	{
		$this->template->content = View::factory('project/list')
			->bind('projects', $projects);

		$projects = ORM::factory('project')->find_all();
	}

	public function action_details()
	{
		$this->template->content = View::factory('project/details')
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
		$this->template->content = View::factory('project/create')
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
		$this->template->content = View::factory('projects/edit')
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

} // End Projects
