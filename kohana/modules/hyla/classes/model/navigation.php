<?php defined('SYSPATH') or die('No direct script access.');

class Model_Navigation {

	/**
	 * Array of navigation items
	 */
	protected $_items = array();

	public function add(Array $navigation_item)
	{
		$this->_items[] = $navigation_item;
	}

	public function as_array()
	{
		return $this->_items;
	}
}