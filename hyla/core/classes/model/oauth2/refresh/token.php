<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @package    OAuth2
 * @category   Model
 */
class Model_OAuth2_Refresh_Token extends Model_OAuth2 implements Interface_Model_OAuth2_Refresh_Token {

	/**
	 * @var  integer  Token Lifetime in seconds
	 */
	public static $lifetime = 15552000; // 6 Months

	/**
	 * Find a token
	 *
	 * @param string $refresh_token the token to find
	 * @param int    $client_id     the optional client id to find with
	 *
	 * @return stdClass | null
	 */
	public static function find_token($refresh_token, $client_id = NULL)
	{

	}

	/**
	 * Create a token
	 *
	 * @param int    $client_id the client id to create with
	 * @param int    $user_id   the user id to create with
	 * @param string $scope     the scope to create with
	 *
	 * @return stdClass
	 */
	public static function create_token($client_id, $user_id = NULL, $scope = NULL)
	{

	}

	/**
	 * Deletes a token
	 *
	 * @param string $refresh_token the token to delete
	 *
	 * @return null
	 */
	public static function delete_token($refresh_token)
	{
		Model_OAuth2_Refresh_Token::find_token($refresh_token)->delete();
	}

	/**
	 * Deletes expired tokens
	 *
	 * @return integer Number of tokens deleted
	 */
	public static function deleted_expired_tokens()
	{

	}
}