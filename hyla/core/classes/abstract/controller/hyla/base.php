<?php defined('SYSPATH') or die('No direct script access.');

abstract class Abstract_Controller_Hyla_Base extends Controller {

	/**
	 * @var object the content View object
	 */
	public $view;

	protected $_filters = array();
	protected $_values = array();
	protected $_params = array();

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

	/**
	 * @var object the Dependency Container object
	 */
	public $di_container;

	public function before()
	{
		// All Hyla actions have access to markdown
		require_once Kohana::find_file('vendor/markdown', 'markdown');

		$definitions = Dependency_Definition_List::factory()
			->from_array(Kohana::$config->load('dependencies')->as_array());
		$this->di_container = new Dependency_Container($definitions);

		$this->view = $this->_request_view();
		$this->dispatcher = Event_Dispatcher::factory()
			->load_subscribers();

		$this->couchdb = $this->di_container->get('couchdb');

		// Try to log the user in
		$this->auth = $this->di_container->get('couch_model.user')
			->find(Cookie::get('auth'));

		// Create a consumer
		$this->oauth_client = ($this->auth->loaded())
			// Use auth_code
			? OAuth2_Consumer::factory('hyla-auth', $this->auth->get('_id'))
			// Use client_credentials
			: OAuth2_Consumer::factory('hyla-web');

		// Default filters/values/params
		$this->_filters = $this->request->query();
		$this->_values = $this->request->post();
		$this->_params = $this->request->param();
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
			->set('oauth_client', $this->oauth_client)
			->set('di_container', $this->di_container)
			->set('filters', $this->_filters)
			->set('values', $this->_values)
			->set('params', $this->_params);

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