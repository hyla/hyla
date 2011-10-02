<?php defined('SYSPATH') or die('No direct script access.');

class View_Model_Ticket extends View_Model {

	protected $_as_array_methods = array(
		'author', 'history',
		'url', 'update_url', 'delete_url',
		'created_on_date_time', 'created_on_date_time',
	);

	public function author()
	{
		return View_Model::factory($this->_model->get_author())
			->as_array();
	}

	public function history()
	{
		$data = array();

		foreach ($this->_model->get('history') as $item)
		{
			$item['date_time'] = date('m/d/Y h:i a', $item['time']);
			$item['author'] = View_Model::factory($this->_model->get_author($item['created_by']));
			$data[] = $item;
		}

		return $data;
	}

	public function created_on_date_time()
	{
		if ( ! $this->_model->get('created_on'))
			return NULL;

		return date('m/d/Y h:i a', $this->_model->get('created_on'));
	}

	public function updated_on_date_time()
	{
		if ( ! $this->_model->get('updated_on'))
			return NULL;

		return date('m/d/Y h:i a', $this->_model->get('updated_on'));
	}

	public function url()
	{
		return Route::url('hyla/tickets', array(
				'slug'   => $this->_model->get_project()->get('slug'),
				'action' => 'view',
				'ticket' => $this->_model->get('_id'),
			));
	}

	public function update_url()
	{
		return Route::url('hyla/tickets', array(
			'action' => 'update',
			'slug'   => $this->_model->get_project()->get('slug'),
			'ticket' => $this->_model->get('_id'),
		));
	}

	public function delete_url()
	{
			return Route::url('hyla/tickets', array(
				'action' => 'delete',
				'slug'   => $this->_model->get_project()->get('slug'),
				'ticket' => $this->_model->get('_id'),
			));
	}
}