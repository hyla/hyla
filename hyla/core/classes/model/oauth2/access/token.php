<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Model to handle oauth2 access tokens
 *
 * @package    OAuth2
 * @category   Model
 * @author     Managed I.T.
 * @copyright  (c) 2011 Managed I.T.
 * @license    https://github.com/managedit/kohana-oauth2/blob/master/LICENSE.md
 */
class Model_OAuth2_Access_Token extends Model_OAuth2 implements Interface_Model_OAuth2_Access_Token {

	protected $_document = array(
		'model'        => 'oauth2_access_token',
		'access_token' => NULL,
		'expires'      => NULL,
		'client_id'    => NULL,
		'user_id'      => NULL,
		'scope'        => NULL,
	);

	/**
	 * @var  integer  Token Lifetime in seconds
	 */
	public static $lifetime = 900; // 5 Minutes

	/**
	 * Find an access token
	 *
	 * @param string $access_token token to find
	 * @param int    $client_id    client to match with
	 *
	 * @return stdClass
	 */
	public static function find_token($access_token, $client_id = NULL)
	{
		$config = Kohana::$config->load('couchdb');
		$sag = new Sag($config->host, $config->port);

		return Couch_Model::factory('oauth2_access_token', $sag)
			->_find($access_token, $client_id);
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
	public static function create_token($client_id, $user_id = NULL, $scope = NULL)
	{
		$config = Kohana::$config->load('couchdb');
		$sag = new Sag($config->host, $config->port);

		$token = Couch_Model::factory('oauth2_access_token', $sag)
			->set('access_token', UUID::v4())
			->set('expires', time() + Model_OAuth2_Access_Token::$lifetime)
			->set('client_id', $client_id)
			->set('user_id', $user_id)
			->set('scope', serialize($scope))
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
	public static function delete_token($access_token)
	{
		return Model_OAuth2_Access_Token::find_token($access_token)->delete();
	}

	/**
	 * Deletes expired tokens
	 *
	 * @return integer Number of tokens deleted
	 */
	public static function deleted_expired_tokens()
	{
		echo Debug::vars('Model_OAuth2_Access_Token::deleted_expired_tokens');die;
		//die('Model_OAuth2_Access_Token::deleted_expired_tokens');
	}

	public function _find($access_token, $client_id = NULL)
	{
		$key = json_encode(array($access_token, $client_id));

		$uri = '/_design/couchapp/_view/find_oauth2_access_token?key='.$key;
		$response = $this->_sag->get($uri);

		if (count($response->body['rows']) > 0)
		{
			return $this->find($response->body['rows'][0]['id']);
		}
		else
		{
			return new Model_OAuth2_Access_Token($this->_sag);
		}
	}
}