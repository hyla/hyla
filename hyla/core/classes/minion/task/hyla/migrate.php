<?php defined('SYSPATH') or die('No direct script access.');

class Minion_Task_Hyla_Migrate extends Minion_Task {

	public function execute( array $config)
	{
		$client_id = UUID::v4();
		$client_secret = UUID::v4();
		// Just create the web oauth consumer in the config
		$config = Kohana::$config->load('oauth2');
		$config->set('consumer', array(
			'web' => array(
				'redirect_uri'  => 'http://dev.vm/hyla/inbound',
				'grant_type'    => OAuth2::GRANT_TYPE_CLIENT_CREDENTIALS,
				'client_id'     => $client_id,
				'client_secret' => $client_secret,
				'authorize_uri' => Route::get('hyla/oauth-endpoints')
					->uri(array('action' => 'authorize')),
				'token_uri'     => Route::get('hyla/oauth-endpoints')
					->uri(array('action' => 'token')),
			),
		));

		// Save this information for the provider as well
		$couch_config = Kohana::$config->load('couchdb');
		$sag = new Sag($couch_config->host, $couch_config->port);
		$model = Couch_Model::factory('oauth2_client', $sag)
			->set('client_id', $client_id)
			->set('client_secret', $client_secret)
			->create();
	}
}