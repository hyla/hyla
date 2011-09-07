<?php defined('SYSPATH') or die('No direct script access.');

class OAuth2_Provider extends Kohana_OAuth2_Provider {

	/**
	 * Handle a token request.
	 *
	 * @return string Response Body
	 */
	public function token()
	{
		// Some defaults..
		$user_id       = NULL;
		$scopes        = NULL;

		// Get an client authorization handler
		$authorization = OAuth2_Provider_Authorization::factory($this->_request);

		// Get the client issueing this request
		$client = $authorization->get_client();

		// Invalid client? Blow up.
		if ( ! $client->loaded())
			throw new OAuth2_Exception_InvalidClient('Unknown or invalid client');

		// Get a grant type handler
		$grant = OAuth2_Provider_GrantType::factory($this->_request, $client);

		// Validate the request against the rules for this grant type
		$grant->validate_request();

		// Find the user_id for this request
		$user_id = $grant->get_user_id();

		// Find the scope for this request
		$scopes = $grant->get_scopes();

		// Prepare the response
		$response = array(
			'token_type'    => OAuth2::TOKEN_TYPE_BEARER, // TODO: Support other token types here..
			'expires_in'    => Model_OAuth2_Access_Token::$lifetime,
		);

		// Generate an access token
		$access_token = Model_OAuth2_Access_Token::create_token($client->get('client_id'), $user_id, $scopes);

		$response['access_token'] = $access_token->get('access_token');

		// If refreh tokens are supported, add one.
		if (in_array(OAuth2::GRANT_TYPE_REFRESH_TOKEN, $this->_config['supported_grant_types']))
		{
			// Generate a refresh token
			$refresh_token = Model_OAuth2_Refresh_Token::create_token($client->get('client_id'), $user_id, $scopes);

			$response['refresh_token'] = $refresh_token->get('refresh_token');
		}

		// Cleanup anything that needs expiring!
		$grant->cleanup();

		return json_encode($response);
	}
}