<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Model to handle oauth2 access tokens
 *
 * @package    OAuth2
 * @category   Model
 */
class Model_OAuth2_User_Token extends Model_OAuth2 implements Interface_Model_OAuth2_User_Token {

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
	public static function find_token($provider, $user_id = NULL)
	{

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
}