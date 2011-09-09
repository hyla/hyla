<?php defined('SYSPATH') or die('No direct script access.');

abstract class Abstract_Controller_Hyla_Base extends Controller {

	/**
	 * @var object the content View object
	 */
	public $view;

	/**
	 * @var object the event dispatcher for this request
	 */
	public $dispatcher;

	/**
	 * @var object the Sag object for this request
	 */
	public $couchdb;

	/**
	 * @var object the authenticated user model
	 */
	public $auth;

	/**
	 * @var object the OAuth Consumer object
	 */
	public $oauth_client;

	public function before()
	{
		// All Hyla actions have access to markdown
		require_once Kohana::find_file('vendor/markdown', 'markdown');

		$this->view = $this->_request_view();
		$this->dispatcher = Event_Dispatcher::factory()
			->load_subscribers();

		$config = Kohana::$config->load('couchdb');
		$this->couchdb = new Sag($config->host, $config->port);

		// Try to log the user in
		$this->auth = Couch_Model::factory('user', $this->couchdb)
			->find(Cookie::get('auth'));

		if ($this->auth->loaded())
		{
			// Create a consumer
			$this->oauth_client = OAuth2_Consumer::factory('web', $this->auth->get('_id'));
		}
	}

	/**
	 * Assigns the title to the template.
	 *
	 * @param   string   request method
	 * @return  void
	 */
	public function after()
	{
		// If content is NULL, then there is no View to render
		if ($this->view === NULL)
		{
			if ( ! Valid::not_empty($this->response->body()))
				throw new Kohana_View_Exception('There was no View created for this request.');

			// Response was handled manually
			return;
		}

		$this->view
			->set('request', $this->request)
			->set('dispatcher', $this->dispatcher)
			->set('couchdb', $this->couchdb)
			->set('auth', $this->auth)
			->set('oauth_client', $this->oauth_client);

		$this->response->body($this->view);
	}

	/**
	 * Returns true if the post has a valid CSRF
	 *
	 * @return  bool
	 */
	public function valid_post()
	{
		if (Request::post_max_size_exceeded())
		{
			return FALSE;
		}

		// @TODO: add CSRF checks
		return (bool) $_POST;
	}

	protected function _request_view()
	{
		// Set default title and content views (path only)
		$directory = $this->request->directory();
		$controller = $this->request->controller();
		$action = $this->request->action();

		// Removes leading slash if this is not a subdirectory controller
		$controller_path = trim($directory.'/'.$controller.'/'.$action, '/');

		try
		{
			$view = Kostache::factory($controller_path)
				->assets(new Assets);
		}
		catch (Kohana_View_Exception $x)
		{
			/*
			 * The View class could not be found, so the controller action is
			 * repsonsible for making sure this is resolved.
			 */
			$view = NULL;
		}

		return $view;
	}
}