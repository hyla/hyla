<?php defined('SYSPATH') or die('No direct script access.');

class Model_Comment extends ORM
{
	protected $_belongs_to = array('ticket' => array(), 'user' => array());
	
	public function rules()
	{
		$rules = array
		(
			'ticket_id' => array('not_empty' => array()),
			'user_id' => array('not_empty' => array()),
		);
		return $rules;
	}
} 