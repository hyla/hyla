<?php defined('SYSPATH') or die('No direct script access.');

class View_Page_Installer_Home extends Abstract_View_Page {

	protected $_layout = 'layout/installer';

	protected function _form_defaults()
	{
		return array(
			'base_url'     => str_replace('installer.php', '', $_SERVER['SCRIPT_URI']),
			'index_file'   => 'index.php',
			'charset'      => 'UTF-8',
			'cache_dir'    => APPPATH.'cache',
			'couchdb'      => array(
				'host'     => 'localhost',
				'port'     => '5984',
				'db'       => 'hyla',
				'username' => '',
				'password' => '',
			),
			'smtp'         => array(
				'host'     => 'localhost',
				'port'     => '25',
				'username' => '',
				'password' => '',
			),
			'rabbitmq'     => array(
				'host'     => 'localhost',
				'port'     => '5672',
				'vhost'    => 'hyla',
				'login'    => 'guest',
				'password' => 'guest',
			),
		);
	}

	public function form()
	{
		$yform = YForm::factory()
			->add_values($this->_form_defaults());

		return array(
			'open'              => $yform->open($_SERVER['SCRIPT_URI']),

			'base_url'          => $yform->text('base_url'),
			'index_file'        => $yform->text('index_file'),
			'charset'           => $yform->text('charset'),
			'cache_dir'         => $yform->text('cache_dir'),

			'couchdb-host'      => $yform->text('couchdb[host]'),
			'couchdb-port'      => $yform->text('couchdb[port]'),
			'couchdb-db'        => $yform->text('couchdb[db]'),
			'couchdb-username'  => $yform->text('couchdb[username]'),
			'couchdb-password'  => $yform->text('couchdb[password]'),

			'smtp-host'         => $yform->text('smtp[host]'),
			'smtp-port'         => $yform->text('smtp[port]'),
			'smtp-username'     => $yform->text('smtp[username]'),
			'smtp-password'     => $yform->text('smtp[password]'),

			'rabbitmq-host'     => $yform->text('rabbitmq[host]'),
			'rabbitmq-port'     => $yform->text('rabbitmq[port]'),
			'rabbitmq-vhost'    => $yform->text('rabbitmq[vhost]'),
			'rabbitmq-login'    => $yform->text('rabbitmq[login]'),
			'rabbitmq-password' => $yform->text('rabbitmq[password]'),

			'save'              => $yform->submit('save'),

			'close'             => $yform->close(),
		);
	}
}
