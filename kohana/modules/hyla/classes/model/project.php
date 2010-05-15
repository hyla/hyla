<?php defined('SYSPATH') or die('No direct script access.');

class Model_Project extends ORM {
	
	protected $_belongs_to = array('user' => array());
	
	public function rules()
	{
		$rules = array
		(
			'name' => array('not_empty' => array()),
			'title' => array('not_empty' => array()),
		);
		return $rules;
	}
} // End Project




