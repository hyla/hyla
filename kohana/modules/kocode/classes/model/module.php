<?php defined('SYSPATH') or die('No direct script access.');

class Model_Module extends Sprig {

	protected function _init()
	{
		$this->_fields += array(
			'name' => new Sprig_Field_Char(array(
				'primary' => TRUE,
				'unique' => TRUE,
				'max_length' => 32,
			)),
			'title' => new Sprig_Field_Char(array(
				'max_length' => 64,
			)),
			'enabled' => new Sprig_Field_Boolean(array(
				'default' => FALSE,
			)),
		);
	}

} // End Module