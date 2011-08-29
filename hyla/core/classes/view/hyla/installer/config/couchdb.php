<?php defined('SYSPATH') or die('No direct script access.');

class View_Hyla_Installer_Config_CouchDB extends Kostache {

	public $host;
	public $port;
	public $db;

	public function required_input()
	{
		return array(
			'host'   => array(
				'line'    => 'Host [dev.vm]',
				'default' => 'dev.vm',
			),
			'port' => array(
				'line'    => 'Port [5984]',
				'default' => '5984',
			),
			'db'  => array(
				'line'    => 'Database [hyla]',
				'default' => 'hyla',
			),
		);
	}

	public function save_path()
	{
		return APPPATH.'config/couchdb.php';
	}
}