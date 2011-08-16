<?php defined('SYSPATH') or die('No direct script access.');

class Model_User extends Couch_Model implements Model_ACL_User {

	protected $_document = array(
		'model'       => 'user',
	);

	/**
	 * Wrapper method to execute ACL policies. Only returns a boolean, if you
	 * need a specific error code, look at Policy::$last_code
	 *
	 * @param string $policy_name the policy to run
	 * @param array  $args        arguments to pass to the rule
	 *
	 * @return boolean
	 */
	public function can($policy_name, $args = array())
	{
		$status = FALSE;

		$refl = new ReflectionClass('Policy_' . $policy_name);
		$class = $refl->newInstanceArgs();
		$status = $class->execute($this, $args);

		if ($status === TRUE)
		{
			return TRUE;
		}
		elseif ($status === FALSE)
		{
			// We don't know what kind of specific error this was
			$status = Policy::GENERAL_FAILURE;
		}

		Policy::$last_code = $status;

		return FALSE;
	}

	/**
	 * Wrapper method for self::can() but throws an exception instead of bool
	 *
	 * @param string $policy_name the policy to run
	 * @param array  $args        arguments to pass to the rule
	 *
	 * @throws Policy_Exception
	 *
	 * @return null
	 */
	public function assert($policy_name, $args = array())
	{
		$status = $this->can($policy_name, $args);

		if ($status !== TRUE)
		{
			throw new Policy_Exception('Could not authorize policy :policy', array(
					':policy' => $policy_name
				), Policy::$last_code);
		}
	}

	public function github_auth($token)
	{
		$config = Kohana::$config->load('oauth')->github;

		$http = new HTTPRequest($config['api_url'].'user/show?'.$token, HTTPRequest::METH_GET);
		$response = $http->send();

		$user = Arr::get(json_decode($response->body, TRUE), 'user');

		$search = $this->find_by_github_id(Arr::get($user, 'id'));

		// Try finding this user before creating a document for him
		if ( ! $search->loaded() AND ($email = Arr::get($user, 'email')) !== NULL)
		{
			$search = $this->find_by_email(Arr::get($user, 'email'));
		}

		// If the user exists and has the github info, just return it
		if ($search->loaded() AND $this->get('github') !== NULL)
			return $search;

		// Save the new github info
		$search->set('github', $user);

		if ($search->loaded())
		{
			$search->update();
		}
		else
		{
			$search->create();
		}

		return $search;
	}

	public function find_by_email($email)
	{
		$uri = '/_design/couchapp/_view/find_user_by_email?key="'.$email.'"';
		$response = $this->_sag->get($uri);

		if (count($response->body['rows']) > 0)
		{
			$this->find($response->body['rows'][0]['id']);
		}

		return $this;
	}

	public function find_by_github_id($id)
	{
		$uri = '/_design/couchapp/_view/find_user_by_github_id?key="'.$id.'"';
		$response = $this->_sag->get($uri);

		if (count($response->body['rows']) > 0)
		{
			$this->find($response->body['rows'][0]['id']);
		}

		return $this;
	}
}