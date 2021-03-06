<?php defined('SYSPATH') or die('No direct script access.');

class View_Page_Projects_List extends Abstract_View_Page {

	protected $_cached = array(
		'projects' => NULL,
	);

	public function can_create_project()
	{
		return $this->auth->can('createProject');
	}

	public function create_url()
	{
		return Route::url('hyla/projects', array('action' => 'create'));
	}

	public function projects()
	{
		if ($this->_cached['projects'] !== NULL)
			return $this->_cached['projects'];

		$projects = $this->di_container->get('couch_model.project')
			->find_all(TRUE);

		$data = array();
		foreach ($projects as $project)
		{
			$item = (array) $project;
			$item['url'] = Route::url('hyla/single-project', array(
				'slug'   => $item['slug'],
				'action' => 'home',
			));

			$data[] = $item;
		}

		return $this->_cached['projects'] = $data;
	}

	public function has_projects()
	{
		return (bool) count($this->projects());
	}
}