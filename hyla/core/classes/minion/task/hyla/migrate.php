<?php defined('SYSPATH') or die('No direct script access.');

class Minion_Task_Hyla_Migrate extends Minion_Task {

	public function execute( array $config)
	{
		$client_id = UUID::v4();
		$client_secret = UUID::v4();
		// Just create the web oauth consumer in the config
		$config = Kohana::$config->load('oauth2');
		$config->set('consumer', array(
			'hyla-auth' => array(
				'redirect_uri'  => 'http://dev.vm/hyla/inbound',
				'grant_type'    => OAuth2::GRANT_TYPE_AUTH_CODE,
				'client_id'     => $client_id,
				'client_secret' => $client_secret,
				'authorize_uri' => Route::get('hyla/oauth-endpoints')
					->uri(array('action' => 'authorize')),
				'token_uri'     => Route::get('hyla/oauth-endpoints')
					->uri(array('action' => 'token')),
			),
			'hyla-web' => array(
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
			->set('redirect_uri', Route::url('hyla/log_in', array('action' => 'hyla')))
			->create();

		// Create the configs needed for the KRabbit class
		$config = Kohana::$config->load('rabbitmq');
		$config->set('exchanges', array(
			'events' => array(
				'connection' => 'hyla',
				'name'       => 'events',
				'type'       => AMQP_EX_TYPE_TOPIC,
				'flags'      => AMQP_DURABLE,
			),
		));
		$config->set('queues', array(
			'notifications' => array(
				'connection' => 'hyla',
				'name'       => 'notifications',
				'flags'      => AMQP_DURABLE,
				'bindings'   => array(
					'events' => 'model.#',
				),
			),
		));
	}
}