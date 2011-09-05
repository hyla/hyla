<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Page_OAuth2_Endpoints extends Abstract_Controller_Hyla_Page {

	/**
	 * @var OAuth2_Provider
	 */
	protected $_oauth;

	public function before()
	{
		parent::before();

		$this->_oauth = OAuth2_Provider::factory($this->request);
	}

	/**
	 * This action issues access and refresh tokens and is called only
	 * by the 3rd party. All output should be JSON.
	 *
	 * You DO NOT need to extend/replace this action.
	 */
	public function action_token()
	{
		$this->response->headers('Content-Type', File::mime_by_ext('json'));

		try
		{
			// Attempt to issue a token
			$this->response->body($this->_oauth->token());
		}
		catch (OAuth2_Exception $e)
		{
			// Something went wrong, lets give a formatted error
			$this->response->status(400);
			$this->response->headers('WWW-Authenticate', 'Bearer');
			$this->response->body($e->getJsonError());
		}
	}

	public function action_authorize()
	{
		try
		{
			// Check if the user is logged in
			if ($this->auth->loaded())
			{
				// Find the current user
				$user = $this->auth;

				/**
				 * Gather and validate the parameters from the query string
				 * so they can be included in the POST with the
				 * authorization results
				 */
				$auth_params = $this->_oauth->validate_authorize_params();

				/**
				 * If you want to show the name of the client requesting access,
				 * you can use this to look it up ..
				 */
				$client = Model_OAuth2_Client::find_client($auth_params['client_id']);

				/**
				 * Authorization results have been submitted. Check if
				 * the resource owner agreed, and pass this + the user's
				 * primary key into the OAuth2_Provider::authorize() method.
				 */
				if ($this->request->method() == Request::POST)
				{
					$agreed = ($this->request->post('accepted') == 'Yes');

					$redirect_url = $this->_oauth->authorize($accepted, $user->pk());

					/**
					 * Finally, Redirect the resource owner back to the
					 * client. This should be done regardless of if they
					 * granted permission or not.
					 */
					$this->request->redirect($redirect_url);
				}

				/**
				 * Show the authorization form. Ensure all the $auth_params
				 * are included as hidden fields.
				 */
				$this->view->set(array(
					'auth_params' => $auth_params,
					'client'      => $client,
					'user'        => $user,
				)));
			}
			else
			{
				/**
				 * Redirect the user to the login page.
				 *
				 * You should ensure that once the user has successfully
				 * logged in, redirect back to this URL ensuring ALL query
				 * string parameters are included!
				 */
				$this->request->redirect(Route::url('login'));
			}
		}
		catch (OAuth2_Exception $e)
		{
			/**
			 * Something went wrong!
			 *
			 * You should probably show a nice error page :)
			 *
			 * Do NOT redirect the user back to the client.
			 */
			throw new HTTP_Exception_400($e->getMessage());
		}
	}
}