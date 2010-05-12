<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ticket extends ORM
{
	protected $_belongs_to = array('user' => array(), 'status' => array(), 'project' => array());
	protected $_has_many = array('labels' => array('through' => 'ticket_labels'));
	
	public function rules()
	{
		$rules = array
		(
			'project_id' => array('not_empty' => array()),
			'user_id' => array('not_empty' => array()),
			'status_id' => array('not_empty' => array()),
		);
		return $rules;
	}
}