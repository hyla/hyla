<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Projects extends Controller_Template_Kocode {

	public function before()
	{
		if ($this->request->param('name'))
		{
			$this->request->action = 'detail';
		}

		parent::before();
	}

	public function action_index()
	{
		$this->template->content = View::factory('projects/list')
			->bind('projects', $projects);

		$projects = Sprig::factory('project', array('public' => TRUE))
			->load(NULL, FALSE);
	}

	public function action_detail()
	{
		$this->template->content = View::factory('projects/detail')
			->bind('project', $project);

		$project = Sprig::factory('project', array('name' => $this->request->param('name')))
			->load();
	}

} // End Projects
