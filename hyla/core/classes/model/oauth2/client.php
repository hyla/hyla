<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Models an oauth client to insert, read and delete data
 *
 * @package   OAuth2
 * @category  Model
 */
class Model_OAuth2_Client extends Model_OAuth2 implements Interface_Model_OAuth2_Client {

	protected $_document = array(
		'model'         => 'oauth2_client',
		'user_id'       => NULL,
		'client_id'     => NULL,
		'client_secret' => NULL,
		'redirect_uri'  => '',
	);

	/**
	 * Find a client
	 *
	 * @param int    $client_id     the client to find
	 * @param string $client_secret the secret to find with
	 *
	 * @return stdClass | null
	 */
	public static function find_client($client_id, $client_secret = NULL)
	{
		$config = Kohana::$config->load('couchdb');
		$sag = new Sag($config->host, $config->port);

		return Couch_Model::factory('oauth2_client', $sag)
			->_find($client_id, $client_secret);
	}

	/**
	 * Create a client
	 *
	 * @param string $redirect_uri sets the redirect uri
	 * @param string $user_id      sets the user id
	 *
	 * @return stdObject
	 */
	public static function create_client($redirect_uri = NULL, $user_id = NULL)
	{
		echo Debug::vars('Model_OAuth2_Client::create_client');die;
		//die('Model_OAuth2_Client::create_client');
	}

	/**
	 * Deletes a token
	 *
	 * @param int $client_id client to delete
	 *
	 * @return null
	 */
	public static function delete_client($client_id)
	{
		Model_OAuth2_Client::find_client($client_id)->delete();
	}

	/**
	 * Allows us to restrict which clients can use specific
	 * response types.
	 *
	 * @return array
	 */
	public function allowed_response_types()
	{
		return $this->_config->provider['supported_response_types'];
	}

	public function _find($client_id, $client_secret = NULL)
	{
		$key = json_encode(array($client_id, $client_secret));

		$uri = '/_design/couchapp/_view/find_oauth2_client?key='.$key;
		$response = $this->_sag->get($uri);

		if (count($response->body['rows']) > 0)
		{
			return $this->find($response->body['rows'][0]['id']);
		}
		else
		{
			return new Model_OAuth2_Client($this->_sag);
		}
	}
}
