<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ticket extends Couch_Model {

	protected $_document = array(
		'model'       => 'ticket',
		'created_by'  => NULL,
		'title'       => NULL,
		'description' => NULL,
	);

	protected function _setup_validation(Validation $validation)
	{
		return parent::_setup_validation($validation)
			->rule('created_by', 'not_empty')
			->rule('title', 'not_empty')
			->rule('description', 'not_empty');
	}

	public function get_author()
	{
		return Couch_Model::factory('user', $this->_sag)
			->find($this->get('created_by'));
	}
}