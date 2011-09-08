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

	/**
	 *
	 * @return array
	 */
	public function validate_authorize_params()
	{
		$request_params = Arr::extract($this->_request->query(), array(
			'client_id',
			'response_type',
			'redirect_uri',
			'state',
			'scope',
		));

		$validation = Validation::factory($request_params)
			->rule('client_id',     'not_empty')
			->rule('client_id',     'uuid::valid')
			->rule('response_type', 'not_empty')
			->rule('response_type', 'in_array',  array(':value', $this->_config['supported_response_types']))
			->rule('scope',         'in_array',  array(':value', $this->_config['scopes']))
			->rule('redirect_uri',  'url');

		if ( ! $validation->check())
			throw new OAuth2_Exception_InvalidRequest("Invalid Request: ".Debug::vars($validation->errors()));

		// Check we have a valid client
		$client = Model_OAuth2_Client::find_client($request_params['client_id']);

		if ( ! $client->loaded())
			throw new OAuth2_Exception_InvalidClient('Invalid client');

		// Lookup the redirect_uri if none was supplied in the URL
		if ( ! Valid::url($request_params['redirect_uri']))
		{
			$request_params['redirect_uri'] = $client->get('redirect_uri');

			// Is the redirect_uri still empty? Error if so..
			if ( ! Valid::url($request_params['redirect_uri']))
				throw new OAuth2_Exception_InvalidRequest('\'redirect_uri\' is required');
		}
		else if ($client->get('redirect_uri') != $request_params['redirect_uri'])
		{
			throw new OAuth2_Exception_InvalidGrant('redirect_uri mismatch');
		}

		// Check if this client is allowed use this response_type
		if ( ! in_array($request_params['response_type'], $client->allowed_response_types()))
			throw new OAuth2_Exception_UnauthorizedClient('You are not allowed use the \':response_type\' response_type', array(
				':response_type' => $request_params['response_type']
			));

		return $request_params;
	}

	/**
	 * @return string Redirect URL
	 */
	public function authorize($accepted, $user_id = NULL)
	{
		// Validate the request
		$request_params = $this->validate_authorize_params();


		// Find the client
		$client = Model_OAuth2_Client::find_client($request_params['client_id']);

		$url = $request_params['redirect_uri'];

		if ( ! $accepted)
		{
			$url .= 'error='.OAuth2::ERROR_ACCESS_DENIED;

			if (Valid::not_empty($request_params['state']))
			{
				$url .= '&state='.urlencode($request_params['state']);
			}
		}
		else
		{
			// Generate a code...
			$auth_code = Model_OAuth2_Auth_Code::create_code($request_params['client_id'], $request_params['redirect_uri'], $user_id, $request_params['scope']);

			if ($request_params['response_type'] == OAuth2::RESPONSE_TYPE_CODE)
			{
				$url .= '?code='.urlencode($auth_code->get('code'));

				if (Valid::not_empty($request_params['state']))
				{
					$url .= '&state='.urlencode($request_params['state']);
				}

				if (Valid::not_empty($request_params['scope']))
				{
					$url .= '&scope='.urlencode($request_params['scope']);
				}
			}
			else if ($request_params['response_type'] == OAuth2::RESPONSE_TYPE_TOKEN)
			{
				// Generate an access token
				$access_token = Model_OAuth2_Access_Token::create_token($request_params['client_id'], $user_id, $request_params['scope']);

				$url .= '#access_token='.$access_token->get('access_token').'&token_type='.OAuth2::TOKEN_TYPE_BEARER;

				if (Valid::not_empty($request_params['state']))
				{
					$url .= '&state='.urlencode($request_params['state']);
				}

				if (Valid::not_empty($request_params['scope']))
				{
					$url .= '&scope='.urlencode($request_params['scope']);
				}
			}
			else
			{
				throw new OAuth2_Exception_InvalidRequest('Unsupported response_type');
			}

		}

		// Return the redirect URL
		return $url;
	}
}