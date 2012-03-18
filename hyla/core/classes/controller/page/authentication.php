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

			$user = $this->di_container->get('couch_model.user');
			$user->github_auth($response->body());

			// Log the user in
			Cookie::set('auth', $user->get('_id'));
			// Send the user back home
			$this->request->redirect(Route::url('hyla/home'));
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

	public function action_log_out()
	{
		Cookie::delete('auth');
		$this->request->redirect(Route::url('hyla/home'));
	}
}