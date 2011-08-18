<?php defined('SYSPATH') or die('No direct script access.');

abstract class Abstract_View_Model implements Interface_Model {

	public static function factory(Interface_Model $model)
	{
		// Get the associated View_ name (ex: View_Model_User)
		$class = 'View_'.get_class($model);

		if (class_exists($class))
		{
			$reflection = new ReflectionClass($class);
			$instance = $reflection->newInstance($model);
		}
		else
		{
			$instance = new View_Model($model);
		}

		return $instance;
	}

	protected $_model;

	public function __construct(Interface_Model $model)
	{
		$this->_model = $model;
	}

	public function get($key, $default = NULL)
	{
		return $this->_model->get($key, $default);
	}

	public function set($key, $value)
	{
		throw new Kohana_Exception('Cannot set values in View Models');
	}
}