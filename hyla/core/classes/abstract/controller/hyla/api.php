<?php defined('SYSPATH') or die('No direct script access.');

abstract class Abstract_Controller_Hyla_API extends Abstract_Controller_Hyla_Base {

	/**
	 * @var Object Request Payload
	 */
	protected $_request_payload = NULL;

	/**
	 * @var Object Response Payload
	 */
	protected $_response_payload = NULL;

	/**
	 * @var array Response Metadata
	 */
	protected $_response_metadata = array('error' => FALSE);

	/**
	 * @var array Response Links
	 */
	protected $_response_links = array();

	/**
	 * @var array Map of HTTP methods -> actions
	 */
	protected $_action_map = array(
		Http_Request::POST   => 'post',   // Typically Create..
		Http_Request::GET    => 'get',
		Http_Request::PUT    => 'put',    // Typically Update..
		Http_Request::DELETE => 'delete',
	);

	/**
	 * @var array List of HTTP methods which support body content
	 */
	protected $_methods_with_body_content = array(
		Http_Request::POST,
		Http_Request::PUT,
	);

	/**
	 * @var array List of HTTP methods which may be cached
	 */
	protected $_cacheable_methods = array(
		Http_Request::GET,
	);

	/**
	 * @var array Map of json errors to their string values
	 */
	protected $_json_error_map = array(
		JSON_ERROR_NONE           => 'No error has occurred',
		JSON_ERROR_DEPTH          => 'The maximum stack depth has been exceeded',
		JSON_ERROR_STATE_MISMATCH => 'Invalid or malformed JSON',
		JSON_ERROR_CTRL_CHAR      => 'Control character error, possibly incorrectly encoded',
		JSON_ERROR_SYNTAX         => 'Syntax error',
		JSON_ERROR_UTF8           => 'Malformed UTF-8 characters, possibly incorrectly encoded',
	);

	public function before()
	{
		parent::before();

		$this->_parse_request();
	}

	public function after()
	{
		$this->_prepare_response();

		parent::after();
	}

	/**
	 * Parse the request...
	 */
	protected function _parse_request()
	{
		// Is that a valid method?
		if ( ! isset($this->_action_map[$this->request->method()]))
		{
			// TODO .. add to the if (maybe??) .. method_exists($this, 'action_'.$this->request->method())
			throw new Http_Exception_405('The :method method is not supported. Supported methods are :allowed_methods', array(
				':method'          => $method,
				':allowed_methods' => implode(', ', array_keys($this->_action_map)),
			));
		}

		// Are we be expecting body content as part of the request?
		if (in_array($this->request->method(), $this->_methods_with_body_content))
		{
			$this->_parse_request_body();
		}
	}

	protected function _parse_request_body()
	{
		if ($this->request->body() == '')
			return;

		$this->_request_payload = json_decode($this->request->body(), TRUE);

		if ( ! is_array($this->_request_payload) AND ! is_object($this->_request_payload))
			throw new Http_Exception_400('Invalid json supplied ":error". \':json\'', array(
				':error' => Arr::get($this->_json_error_map, json_last_error()),
				':json'  => $this->request->body(),
			));
	}

	protected function _prepare_response()
	{
		// Should we prevent this request from being cached?
		if ( ! in_array($this->request->method(), $this->_cacheable_methods))
		{
			$this->response->headers('cache-control', 'no-cache, no-store, max-age=0, must-revalidate');
		}

		// Set the correct content-type header
		$this->response->headers('Content-Type', 'application/json');
	}
}