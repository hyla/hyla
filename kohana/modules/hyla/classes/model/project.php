<?php defined('SYSPATH') or die('No direct script access.');

class Model_Project extends Couch_Model {

	protected $_document = array(
		'model'       => 'project',
		'name'        => NULL,
		'description' => NULL,
	);

	protected function _setup_validation(Validation $validation)
	{
		return parent::_setup_validation($validation)
			->rule('name', array($this, 'unique_name'));
	}

	public function unique_name($value)
	{
		$uri = '/_design/couchapp/_view/find_project_by_name?key="'.$value.'"';
		$response = $this->_sag->get($uri);

		if ($response->body['total_rows'] > 0)
		{
			if ($this->loaded())
			{
				return $this->get('_id') === $response->body['rows'][0]['id'];
			}

			return FALSE;
		}

		return TRUE;
	}

	public function find_by_name($name)
	{
		$uri = '/_design/couchapp/_view/find_project_by_name?key="'.$name.'"';
		$response = $this->_sag->get($uri);

		if ($response->body['total_rows'] > 0)
		{
			$this->find($response->body['rows'][0]['id']);
		}

		return $this;
	}
}