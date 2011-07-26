<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ticket extends Couch_Model {

	protected $_document = array(
		'model'       => 'ticket',
		'title'       => NULL,
		'description' => NULL,
	);

	protected function _setup_validation(Validation $validation)
	{
		return parent::_setup_validation($validation)
			->rule('title', 'not_empty')
			->rule('description', 'not_empty');
	}
}