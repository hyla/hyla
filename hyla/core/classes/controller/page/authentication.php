<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Page_Authentication extends Abstract_Controller_Hyla_Page {

	public function action_github()
	{
		$config = Kohana::$config->load('oauth')->github;

		if ($this->request->query('code'))
		{
			// User sent back with a code
			$url = $config['oauth_token'];
			$query = array(
				'client_id'     => $config['client_id'],
				'client_secret' => $config['secret'],
				'redirect_uri'  => URL::site($this->request->uri()),
				'code'          => $this->request->query('code'),
			);

			$request = Request::factory($url)
				->query($query);

			$response = $request->execute();

			$user = Couch_Model::factory('user', $this->couchdb);
			$user->github_auth($response->body());

			// Log the user in
			Cookie::set('auth', $user->get('_id'));
			// Log the user into the API (I guess)
			$this->request->redirect(Route::url('hyla/log_in', array('action' => 'hyla')));
		}
		else
		{
			$url = $config['oauth_dialog'];
			$query = array(
				'client_id' => $config['client_id'],
				'redirect_uri' => URL::site($this->request->uri()),
			);

			$this->request->redirect($url.'?'.http_build_query($query));
		}
	}

	public function action_hyla()
	{
		$config = Kohana::$config->load('oauth2')->consumer['hyla-auth'];

		if ($this->request->query('code'))
		{
			// User sent back with a code
			$url = $config['token_uri'];
			$query = array(
				'client_id'     => $config['client_id'],
				'client_secret' => $config['client_secret'],

				'code'          => $this->request->query('code'),
			);

			$request = Request::factory($url)
				->method(Request::POST)
				->post(array(
					'grant_type'    => 'authorization_code',
					'client_id'     => $config['client_id'],
					'client_secret' => $config['client_secret'],
					'code'          => $this->request->query('code'),
					'redirect_uri'  => URL::site($this->request->uri()),
				));

			$response = $request->execute();

			$info = json_decode($response->body(), TRUE);

			$token_type = $info['token_type'];
			$access_token = $info['access_token'];
			$refresh_token = $info['refresh_token'];

			$token = Model_OAuth2_User_Token::create_token('hyla-auth', $token_type, $access_token, $this->auth->get('_id'), $refresh_token);

			$this->request->redirect(Route::url('hyla/home'));
		}
		else
		{
			$url = $config['authorize_uri'];
			$query = array(
				'client_id' => $config['client_id'],
				'redirect_uri' => URL::site($this->request->uri()),
				'response_type' => 'code',
			);

			$this->request->redirect($url.'?'.http_build_query($query));
		}
	}

	public function action_log_out()
	{
		Cookie::delete('auth');
		$this->request->redirect(Route::url('hyla/home'));
	}
}