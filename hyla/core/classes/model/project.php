<?php defined('SYSPATH') or die('No direct script access.');

class Model_Project extends Couch_Model {

	protected $_document = array(
		'model'       => 'project',
		'name'        => NULL,
		'slug'        => NULL,
		'description' => NULL,
	);

	protected function _setup_validation(Validation $validation)
	{
		return parent::_setup_validation($validation)
			->rule('name', 'not_empty')
			->rule('slug', 'not_empty')
			->rule('slug', array($this, 'unique_slug'));
	}

	public function unique_slug($value)
	{
		$uri = '/_design/couchapp/_view/find_project_by_slug?key="'.$value.'"';
		$response = $this->_sag->get($uri);

		if (count($response->body['rows']) > 0)
		{
			if ($this->loaded())
			{
				return $this->get('_id') === $response->body['rows'][0]['id'];
			}

			return FALSE;
		}

		return TRUE;
	}

	public function find_by_slug($name)
	{
		$uri = '/_design/couchapp/_view/find_project_by_slug?key="'.$name.'"';
		$response = $this->_sag->get($uri);

		if (count($response->body['rows']) > 0)
		{
			$this->find($response->body['rows'][0]['id']);
		}

		return $this;
	}

	public function create()
	{
		parent::create();

		// Trigger a RabbitMQ event for model.project.create
		$exchange = KRabbit::factory()->exchange('events');
		$exchange->publish($this->get('_id'), 'model.project.create', 0, array('delivery_mode' => 2));
	}
}