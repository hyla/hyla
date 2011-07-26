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

	public function before()
	{
		$this->view = $this->_request_view();
		$this->dispatcher = Event_Dispatcher::factory()
			->load_subscribers();

		$config = Kohana::config('couchdb');
		$this->couchdb = new Sag($config->host, $config->port);
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
			throw new Kohana_View_Exception('There was no View created for this request.');

		$this->view
			->set('request', $this->request)
			->set('dispatcher', $this->dispatcher)
			->set('couchdb', $this->couchdb);

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

	abstract protected function _request_view();
}