<?php defined('SYSPATH') or die('No direct script access.');

class OAuth2_Provider_TokenType_Bearer extends Kohana_OAuth2_Provider_TokenType_Bearer {

	protected function validate()
	{
		$access_token = Model_OAuth2_Access_Token::find_token($this->_find_token_string());

		if ( ! $access_token->loaded())
			throw new OAuth2_Exception_InvalidToken('The access token provided is expired, revoked, malformed, or invalid for other reasons.');

		$client = Model_OAuth2_Client::find_client($access_token->get('client_id'));

		if ( ! $client->loaded())
			throw new OAuth2_Exception_InvalidToken('The access token provided is expired, revoked, malformed, or invalid for other reasons.');

		$this->_client = $client;
	}

	/**
	 * Gets the request user_id
	 *
	 * @return string
	 */
	public function get_user_id()
	{
		$access_token = Model_OAuth2_Access_Token::find_token($this->_find_token_string());

		if ( ! $access_token->loaded())
			throw new OAuth2_Exception_InvalidClient('Client authentication failed');

		return $access_token->get('user_id');
	}
}