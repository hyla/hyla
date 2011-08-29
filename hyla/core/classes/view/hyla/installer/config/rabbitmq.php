<?php defined('SYSPATH') or die('No direct script access.');

class View_Hyla_Installer_Config_RabbitMQ extends Kostache {

	public $host;
	public $port;
	public $vhost;
	public $login;
	public $password;

	public function required_input()
	{
		return array(
			'host'   => array(
				'line'    => 'Host [localhost]',
				'default' => 'localhost',
			),
			'port' => array(
				'line'    => 'Port [5672]',
				'default' => '5672',
			),
			'vhost' => array(
				'line'    => 'Virtual Host [hyla]',
				'default' => 'hyla',
			),
			'login'  => array(
				'line'    => 'Username [guest]',
				'default' => 'guest',
			),
			'password' => array(
				'line'    => 'Password [guest]',
				'default' => 'guest',
			),
		);
	}

	public function save_path()
	{
		return APPPATH.'config/rabbitmq.php';
	}
}