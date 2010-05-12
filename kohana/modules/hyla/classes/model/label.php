<?php defined('SYSPATH') or die('No direct script access.');
class Model_Label extends ORM
{
	protected $_has_many = array('tickets' => array('through' => 'ticket_labels'));

	public function rules()
	{
		$rules = array
		(
			'name' => array('not_empty' => array()),
		);
		return $rules;
	}
}