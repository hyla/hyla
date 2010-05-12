<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ticket extends ORM
{
	protected $_belongs_to = array('user' => array(), 'status' => array(), 'project' => array());
	protected $_has_many = array('labels' => array('through' => 'ticket_labels'));

	protected $_created_column = array('created_on' => TRUE);
	protected $_updated_column = array('last_update' => TRUE);

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
