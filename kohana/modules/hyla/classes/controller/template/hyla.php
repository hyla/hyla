<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Template_Hyla extends Controller_Template {

	public $template = 'templates/default';
	// Controls access for the whole controller, if not set to FALSE we will only allow user roles specified
	// Can be set to a string or an array, for example array('login', 'admin') or 'login'
	public $auth_required = FALSE;
	// Controls access for separate actions
	// 'adminpanel' => 'admin' will only allow users with the role admin to access action_adminpanel
	// 'moderatorpanel' => array('login', 'moderator') will only allow users with the roles login and moderator to access action_moderatorpanel
	public $secure_actions = FALSE;

	public function before()
	{
		parent::before();

		#Open session
		$this->session= Session::instance();

		#Check user auth and role
		$action_name = Request::instance()->action;
		if (($this->auth_required !== FALSE && Auth::instance()->logged_in($this->auth_required) === FALSE) 
		|| (is_array($this->secure_actions) && array_key_exists($action_name, $this->secure_actions) && 
		Auth::instance()->logged_in($this->secure_actions[$action_name]) === FALSE))
		{
			if (Auth::instance()->logged_in()){
				Request::instance()->redirect('account/noaccess');
			}else{
				Request::instance()->redirect('account/signin');
			}
		}
	}   
} // End Template_Hyla
