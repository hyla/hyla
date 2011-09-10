<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Model to handle oauth2 access tokens
 *
 * @package    OAuth2
 * @category   Model
 */
class Model_OAuth2_User_Token extends Model_OAuth2 implements Interface_Model_OAuth2_User_Token {

	protected $_document = array(
		'model'         => 'oauth2_user_token',
		'provider'      => NULL,
		'token_type'    => NULL,
		'access_token'  => NULL,
		'refresh_token' => NULL,
		'user_id'       => NULL,
	);

	/**
	 * @var  integer  Token Lifetime in seconds
	 */
	public static $lifetime = 3600; // 1 hour

	/**
	 * Find an access token
	 *
	 * @param string $access_token token to find
	 * @param int    $client_id    client to match with
	 *
	 * @return stdClass
	 */
	public static function find_token($provider, $user_id = NULL)
	{
		$config = Kohana::$config->load('couchdb');
		$sag = new Sag($config->host, $config->port);

		return Couch_Model::factory('oauth2_user_token', $sag)
			->_find($provider, $user_id);
	}

	/**
	 * Create an access token
	 *
	 * @param int $client_id client id to create with
	 * @param int $user_id   user id to create with
	 * @param int $scope     scope to create with
	 *
	 * @return stdClass
	 */
	public static function create_token($provider, $token_type, $access_token, $user_id = NULL, $refresh_token = NULL)
	{
		$config = Kohana::$config->load('couchdb');
		$sag = new Sag($config->host, $config->port);

		$token = Couch_Model::factory('oauth2_user_token', $sag)
			->set('provider', $provider)
			->set('token_type', $token_type)
			->set('access_token', $access_token)
			->set('refresh_token', $refresh_token)
			->set('user_id', $user_id)
			->create();

		return $token;
	}

	/**
	 * Deletes an access token
	 *
	 * @param string $access_token the token to delete
	 *
	 * @return null
	 */
	public static function delete_token($provider, $user_id = NULL)
	{
		return Model_OAuth2_User_Token::find_token($provider, $user_id)->delete();
	}

	public function _find($provider, $user_id = NULL)
	{
		$key = json_encode(array(urlencode($provider), urlencode($user_id)));

		$uri = '/_design/couchapp/_view/find_oauth2_user_token?key='.$key;
		$response = $this->_sag->get($uri);

		if (count($response->body['rows']) > 0)
		{
			return $this->find($response->body['rows'][0]['id']);
		}
		else
		{
			return new Model_OAuth2_User_Token($this->_sag);
		}
	}
}