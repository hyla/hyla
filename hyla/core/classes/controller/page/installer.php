<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Page_Installer extends Abstract_Controller_Hyla_Page {

	public function before()
	{
		$this->view = $this->_request_view();
	}

	public function action_home()
	{
		if ($this->valid_post())
		{
			$init = Kostache::factory('file/config/init')
				->set('values', $this->request->post());

			file_put_contents($init->filepath(), $init->render());

			$couchdb = Kostache::factory('file/config/couchdb')
				->set('values', $this->request->post('couchdb'));

			file_put_contents($couchdb->filepath(), $couchdb->render());

			$couchapprc = Kostache::factory('file/couchapp/couchapprc')
				->set('values', $this->request->post('couchdb'));

			file_put_contents($couchapprc->filepath(), $couchapprc->render());

			$this->request->redirect(Route::url('installer', array('action' => 'database')));
		}
	}

	public function action_database()
	{
		exec('cd '.escapeshellarg(DOCROOT).' && ./minion media:compile --pattern=media/couchapp/monkeys');

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