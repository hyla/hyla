 <?php defined('SYSPATH') or die('No direct script access.');

class Model_User extends ORM
{
	protected $_has_many = array('projects' => array(), 'tickets' => array(), 'comments' => array());
	
	public function rules()
	{
		$rules = array
		(
			'username' => array('not_empty' => array()),
			'email' => array('not_empty' => array(), 'email' => array()),
			'password_confirm' => array('matches' => array('password')),
			'password' => array('not_empty' => array())

		);
		return $rules;
	}	
}
