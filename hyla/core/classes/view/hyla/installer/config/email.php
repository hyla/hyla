<?php defined('SYSPATH') or die('No direct script access.');

class View_Hyla_Installer_Config_Email extends Kostache {

	public $host;
	public $port;
	public $username;
	public $password;

	public function required_input()
	{
		return array(
			'host'   => array(
				'line'    => 'SMTP Host [localhost]',
				'default' => 'localhost',
			),
			'port' => array(
				'line'    => 'SMTP Port [25]',
				'default' => '25',
			),
			'username' => array(
				'line'    => 'SMTP Username []',
				'default' => '',
			),
			'password'  => array(
				'line'    => 'SMTP Password []',
				'default' => '',
			),
		);
	}

	public function save_path()
	{
		return APPPATH.'config/email.php';
	}
}