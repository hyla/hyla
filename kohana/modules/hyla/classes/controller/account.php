<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Account extends Controller_Template_Hyla {
	
	function action_register()
		{	
			//If user already signed-in
			if(Auth::instance()->logged_in()!= 0){
				//Redirect to the user account
				Request::instance()->redirect('account/profile');
			}
 
			//Load the view
			$this->template->content = View::factory('account/register')
				->bind('errors', $errors);	

			//If there is a post and $_POST is not empty
			if ($_POST)
			{
				//Instantiate a new user
				$user = ORM::factory('user');	
 
				//Load the validation rules, filters etc...
				$validate_pw_confirm = Validate::factory($_POST)
					->rule('password_confirm',  'matches', array('password'));
			
				try
				{
					//Affects the sanitized vars to the user object
					$user->values($_POST);
				
					//create the account
					$user->create($validate_pw_confirm );
 
					//Add the login role to the user
					$user->activate();

					//Sign the user in
					Auth::instance()->login($_POST['username'], $_POST['password']);
				}
				catch(ORM_Validation_Exception $e)
				{
					//Get errors for display in view
					$errors = $validate_pw_confirm->errors('user');
				}			
			}		
		}
 
 
 
 
	public function action_login()
	{
		//If user already signed-in
		if(Auth::instance()->logged_in() != 0){
			//Redirect to the user account
			Request::instance()->redirect('project/list');		
		}
 
		$content = $this->template->content = View::factory('account/login');	
		$content->errors = NULL;
		$content->userdata = NULL;
		//If there is a post and $_POST is not empty
		if ($_POST)
		{
			//Instantiate a new user
			$user = $content->userdata = ORM::factory('user');
 
			//Check Auth
			$status = $user->login($_POST);
 
			//If the post data validates using the rules setup in the user model
			if ($status)
			{		
				//redirect to the user account
				Request::instance()->redirect('project/list');
				
			}
			else
			{
        //Get errors for display in view
				$content->errors = $_POST->errors('signin');
			}
		}
	}
 
 
	public function action_profile()
	{
		$content = $this->template->content = View::factory('account/profile');
		$content->user = Kohana::debug(Auth::instance()->get_user());
	}
 
	public function action_logout()
	{
		//Sign out the user
		Auth::instance()->logout();
 
		//Redirect to the user account and then the signin page if logout worked as expected
		Request::instance()->redirect('account/profile');		
	}
	
}