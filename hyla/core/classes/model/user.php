<?php defined('SYSPATH') or die('No direct script access.');

class Model_User extends Couch_Model {

	protected $_document = array(
		'model'       => 'user',
	);

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