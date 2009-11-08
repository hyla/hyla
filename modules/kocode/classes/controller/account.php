<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Account extends Controller_Website {

	/**
	 * Saves changes to the user account profile
	 */
	public function action_profile()
	{
		$this->template->content = View::factory('account/profile');
	}

	/**
	 * Basic registration form
	 */
	public function action_register()
	{
		$this->template->content = View::factory('account/register');
	}

	/**
	 * Basic login form
	 */
	public function action_login()
	{
		$errors = FALSE;
		if ($_POST)
		{
			$username = arr::get($_POST, 'username');
			$password = arr::get($_POST, 'password');
			$remember = arr::get($_POST, 'remember_me', FALSE);

			if (Auth::instance()->login($username, $password, $remember))
			{
				// successfully logged in, redirect somewhere
				Request::instance()->redirect('account/profile');
			}
			else
			{
				// set errors and show form again
				$errors = TRUE;
			}
		}
		$this->template->content = View::factory('account/login')
			->set('errors', $errors);
	}

	/**
	 * Logs a user out and redirects where?
	 */
	public function action_logout()
	{
		Auth::instance()->logout();
		Request::instance()->redirect('account/login');
	}

	/**
	 * Activates the account from the emailed token
	 */
	public function action_activate($token = NULL)
	{

	}
	
	/**
	 * Sends an email to reset the password
	 */
	public function action_forgot_password()
	{
		$this->template->content = View::factory('account/forgot_password');
	}
}