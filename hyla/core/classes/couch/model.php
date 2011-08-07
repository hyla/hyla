<?php defined('SYSPATH') or die('No direct script access.');

abstract class Couch_Model {

	public static function factory($model, Sag $sag)
	{
		$class = 'Model_'.$model;
		return new $class($sag);
	}

	protected $_sag;
	protected $_db = 'hyla';
	protected $_document = array();

	public function __construct(Sag $sag)
	{
		$this->_sag = $sag->setDatabase($this->_db, TRUE);

		if ( ! isset($this->_document))
			throw new Kohana_Exception('Must define $_document[\'model\']');
	}

	public function get($key, $default = NULL)
	{
		return array_key_exists($key, $this->_document)
			? $this->_document[$key]
			: $default;
	}

	public function set($key, $value = NULL)
	{
		if (is_array($key))
		{
			foreach ($key as $k => $v)
			{
				$this->set($k, $v);
			}
		}
		else
		{
			$this->_document[$key] = $value;
		}

		return $this;
	}

	public function values( Array $values, Array $fields = NULL)
	{
		if ($fields === NULL)
		{
			$keys = array_keys($this->_document);
			// We don't want to ever set _id
			$fields = array_diff($keys, array('_id'));
		}

		foreach ($fields as $field)
		{
			$this->set($field, Arr::get($values, $field));
		}

		return $this;
	}

	public function document()
	{
		return $this->_document;
	}

	public function find($id)
	{
		$response = $this->_sag->get($id);

		return $this->set($response->body);
	}

	public function find_all($as_array = FALSE)
	{
		$uri = '/_design/couchapp/_view/find_all_models?key="'.$this->get('model').'";include_docs=true';
		$response = $this->_sag->get($uri);

		$models = array();
		foreach ($response->body['rows'] as $row)
		{
			$model = Couch_Model::factory($this->get('model'), $this->_sag)
				->find($row['id']);

			$models[] = $as_array ? $model->document() : $model;
		}

		return $models;
	}

	public function create()
	{
		$this->_validate();

		$response = $this->_sag->post($this->_document);

		// Merge the meta data from couch
		$this->set(array(
			'_id'  => $response->body['id'],
			'_rev' => $response->body['rev'],
		));

		return $this;
	}

	public function update()
	{
		if ( ! $this->loaded())
			throw new Kohana_Exception('update() called on new document');

		$this->_validate();

		$response = $this->_sag->put($this->get('_id'), $this->_document);

		// Merge the meta data from couch
		$this->set(array(
			'_id'  => $response->body['id'],
			'_rev' => $response->body['rev'],
		));

		return $this;
	}

	protected function _setup_validation(Validation $validation)
	{
		return $validation;
	}

	protected function _validate()
	{
		$validation = Validation::factory($this->_document);
		$validation = $this->_setup_validation($validation);

		if ($validation->check())
			return TRUE;

		throw new Validation_Exception($validation);
	}

	public function loaded()
	{
		return isset($this->_document['_id']);
	}
}