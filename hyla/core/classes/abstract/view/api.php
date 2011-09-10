<?php defined('SYSPATH') or die('No direct script access.');

abstract class Abstract_View_API {

	/**
	 * Assets object to add css/js groups to
	 */
	protected $_assets;

	/**
	 * Sets the Assets object in the view
	 * Extend this method in Views to add Asset groups.
	 *
	 *     public function assets($assets)
	 *     {
	 *         $assets->group('default-template');
	 *         return parent::assets($assets);
	 *     }
	 *
	 * @param  Object the Assets object
	 * @return this
	 */
	public function assets($assets)
	{
		$this->_assets = $assets;

		return $this;
	}

	/**
	 * Assigns a variable by name.
	 *
	 *     // This value can be accessed as {{foo}} within the template
	 *     $view->set('foo', 'my value');
	 *
	 * You can also use an array to set several values at once:
	 *
	 *     // Create the values {{food}} and {{beverage}} in the template
	 *     $view->set(array('food' => 'bread', 'beverage' => 'water'));
	 *
	 * @param   string   variable name or an array of variables
	 * @param   mixed    value
	 * @return  $this
	 */
	public function set($key, $value = NULL)
	{
		if (is_array($key))
		{
			foreach ($key as $name => $value)
			{
				$this->{$name} = $value;
			}
		}
		else
		{
			$this->{$key} = $value;
		}

		return $this;
	}

	/**
	 * Assigns a value by reference. The benefit of binding is that values can
	 * be altered without re-setting them. It is also possible to bind variables
	 * before they have values. Assigned values will be available as a
	 * variable within the template file:
	 *
	 *     // This reference can be accessed as {{ref}} within the template
	 *     $view->bind('ref', $bar);
	 *
	 * @param   string   variable name
	 * @param   mixed    referenced variable
	 * @return  $this
	 */
	public function bind($key, & $value)
	{
		$this->{$key} =& $value;

		return $this;
	}

	public function __toString()
	{
		try
		{
			return $this->render();
		}
		catch (Exception $e)
		{
			// Display the exception message
			Kohana_Exception::handler($e);

			return '';
		}
	}

	public function _data()
	{
		$data = array();
		$reflection = new ReflectionClass($this);

		$properties = $reflection->getProperties(ReflectionProperty::IS_PUBLIC);
		$methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);
		$skip_methods = array('factory', 'set', 'bind', 'render', 'assets');

		foreach ($properties as $property)
		{
			if ($property->name[0] === '_')
				continue;

			$data[$property->name] = $property->getValue($this);
		}

		foreach ($methods as $method)
		{
			if ($method->name[0] === '_' OR in_array($method->name, $skip_methods))
				continue;

			$data[$method->name] = $method->invoke($this);
		}

		return $data;
	}

	public function render()
	{
		return json_encode($this->_data());
	}
}