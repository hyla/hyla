<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ticket extends Couch_Model {

	protected $_document = array(
		'model'       => 'ticket',
		'project'     => NULL,
		'created_by'  => NULL,
		'created_on'  => NULL,
		'updated_on'  => NULL,
		'title'       => NULL,
		'description' => NULL,
		'status'      => 'open',
		'history'     => array(),
	);

	protected function _setup_validation(Validation $validation)
	{
		return parent::_setup_validation($validation)
			->rule('created_by', 'not_empty')
			->rule('title', 'not_empty')
			->rule('description', 'not_empty');
	}

	public function create()
	{
		if ( ! $this->get('created_on'))
		{
			$this->set('created_on', time());
		}

		return parent::create();
	}

	public function update()
	{
		if ( ! $this->get('updated_on'))
		{
			$this->set('updated_on', time());
		}

		return parent::create();
	}

	public function get_author($id = NULL)
	{
		if ($id === NULL)
		{
			$id = $this->get('created_by');
		}

		return Couch_Model::factory('user', $this->_sag)
			->find($id);
	}

	public function get_project()
	{
		return Couch_Model::factory('project', $this->_sag)
			->find($this->get('project_id'));
	}

	public function add_comment($author_id, $comment)
	{
		$this->append('history', array(
			'action'     => 'comment',
			'time'       => time(),
			'created_by' => $author_id,
			'comment'    => $comment,
		));

		return $this;
	}
}