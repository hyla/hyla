<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Account extends Controller_Template_Hyla {
	
	function action_register()
		{	
			#If user already signed-in
			if(Auth::instance()->logged_in()!= 0){
				#redirect to the user account
				Request::instance()->redirect('account/profile');
			}
 
		#Load the view
		$content = $this->template->content = View::factory('account/register');		
		$content->errors = NULL;
		#If there is a post and $_POST is not empty
		if ($_POST)
		{
			#Instantiate a new user
			$user = ORM::factory('user');	
 
			#Load the validation rules, filters etc...
			$post = Validate::factory($_POST)
				->rule('password', 'not_empty')
				->rule('password', 'min_length', array('6'))
				->rule('password_confirm',  'matches', array('password'));
	
 
			#If the post data validates using the rules setup in the user model
			if ($post->check())
			{
				#Affects the sanitized vars to the user object
				$user->values($_POST);
				
				#create the account
				$user->save();
 
				#Add the login role to the user
				$login_role = new Model_Role(array('name' =>'login'));
				$user->add('roles',$login_role);
 
				#sign the user in
				$content = Kohana::debug(Auth::instance()->login($_POST['username'], $_POST['password']));
 
				#redirect to the user account
				#Request::instance()->redirect('account/profile');
			}
			else
			{
				#Get errors for display in view
				$content->errors = $post->errors('register');
			}			
		}		
	}
 
 
 
 
	public function action_login()
	{
		#If user already signed-in
		if(Auth::instance()->logged_in() != 0){
			#redirect to the user account
			Request::instance()->redirect('account/profile');		
		}
 
		$content = $this->template->content = View::factory('account/login');	
		$content->errors = NULL;
		#If there is a post and $_POST is not empty
		if ($_POST)
		{
			#Instantiate a new user
			$user = ORM::factory('user');
 
			#Check Auth
			$status = $user->login($_POST);
 
			#If the post data validates using the rules setup in the user model
			if ($status)
			{		
				#redirect to the user account
				Request::instance()->redirect('account/profile');
			}else
			{
                                #Get errors for display in view
				$content->errors = $_POST->errors('signin');
			}
 
		}
	}
 
 
	public function action_profile()
	{
		
	}
 
	public function action_logout()
	{
		#Sign out the user
		Auth::instance()->logout();
 
		#redirect to the user account and then the signin page if logout worked as expected
		Request::instance()->redirect('account/profile');		
	}
	
}