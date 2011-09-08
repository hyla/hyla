<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @package    OAuth2
 * @category   Model
 */
class Model_OAuth2_Auth_Code extends Model_OAuth2 implements Interface_Model_OAuth2_Auth_Code {

	protected $_document = array(
		'model'        => 'oauth2_auth_code',
		'code'         => NULL,
		'client_id'    => NULL,
		'user_id'      => NULL,
		'redirect_uri' => NULL,
		'expires'      => NULL,
		'scope'        => NULL,
	);

	/**
	 * @var  integer  Lifetime
	 */
	public static $lifetime = 30;

	/**
	 * Find a auth code
	 *
	 * @param string $code      code to find
	 * @param int    $client_id client id to pair with
	 *
	 * @return Model_OAuth2_Auth_Code
	 */
	public static function find_code($code, $client_id = NULL)
	{
		$config = Kohana::$config->load('couchdb');
		$sag = new Sag($config->host, $config->port);

		return Couch_Model::factory('oauth2_auth_code', $sag)
			->_find($code, $client_id);
	}

	/**
	 * Create a auth code
	 *
	 * @param int    $client_id    client id to create with
	 * @param string $redirect_uri redirect uri to create with
	 * @param int    $user_id      the user id to create with
	 * @param string $scope        scope to create with
	 *
	 * @return Model_OAuth2_Auth_Code
	 */
	public static function create_code($client_id, $redirect_uri, $user_id = NULL, $scope = NULL)
	{
		$config = Kohana::$config->load('couchdb');
		$sag = new Sag($config->host, $config->port);

		$code = Couch_Model::factory('oauth2_Auth_Code', $sag)
			->set('client_id', $client_id)
			->set('redirect_uri', $redirect_uri)
			->set('user_id', $user_id)
			->set('scope', serialize($scope))
			->set('expires', time() + Model_OAuth2_Auth_Code::$lifetime)
			->set('code', UUID::v4())
			->create();

		return $code;
	}

	/**
	 * Deletes a auth code
	 *
	 * @param string $code the code to delete
	 */
	public static function delete_code($code)
	{
		return Model_OAuth2_Auth_Code::find_code($code)->delete();
	}

	/**
	 * Deletes expired codes
	 *
	 * @return  integer  Number of codes deleted
	 */
	public static function deleted_expired_codes()
	{
		echo Debug::vars('Model_OAuth2_Auth_Code::deleted_expired_codes');die;
	}

	public function _find($code, $client_id = NULL)
	{
		$key = json_encode(array($code, $client_id));

		$uri = '/_design/couchapp/_view/find_oauth2_auth_code?key='.$key;
		$response = $this->_sag->get($uri);

		if (count($response->body['rows']) > 0)
		{
			return $this->find($response->body['rows'][0]['id']);
		}
		else
		{
			return new Model_OAuth2_Auth_Code($this->_sag);
		}
	}
}
