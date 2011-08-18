<?php defined('SYSPATH') or die('No direct script access.');

class View_Model_Ticket extends View_Model {

	public function title()
	{
		return $this->_model->get('title');
	}

	public function description()
	{
		return $this->_model->get('description');
	}

	public function author()
	{
		return View_Model::factory($this->_model->get_author());
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
}