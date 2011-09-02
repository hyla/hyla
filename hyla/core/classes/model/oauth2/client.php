<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Models an oauth client to insert, read and delete data
 *
 * @package   OAuth2
 * @category  Model
 */
class Model_OAuth2_Client extends Model_OAuth2 implements Interface_Model_OAuth2_Client {

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
}
