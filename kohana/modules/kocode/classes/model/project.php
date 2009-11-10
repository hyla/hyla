<?php defined('SYSPATH') or die('No direct script access.');

class Model_Project extends Sprig {

	protected function _init()
	{
		$this->_fields += array(
			'id' => new Sprig_Field_Auto,
			'name' => new Sprig_Field_Char(array(
				'max_length' => '32',
				'unique' => TRUE,
			)),
			'description' => new Sprig_Field_Text,
		);
	}

} // End Project
