<?php defined('SYSPATH') or die('No direct script access.');

class View_Model_User extends View_Model {

	protected $_as_array_methods = array('display_name');

	public function display_name()
	{
		if (($name = $this->_model->path('github.name')) !== NULL)
		{
			return $name;
		}
		elseif (($login = $this->_model->path('github.login')) !== NULL)
		{
			return $login;
		}
		elseif (($email = $this->_model->path('github.email')) !== NULL)
		{
			return $email;
		}
		else
		{
			return NULL;
		}
	}
}